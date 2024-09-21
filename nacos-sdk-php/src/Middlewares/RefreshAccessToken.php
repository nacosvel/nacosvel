<?php

namespace Nacosvel\Nacos\Middlewares;

use GuzzleHttp\Exception\ConnectException;
use GuzzleHttp\Promise\Create;
use GuzzleHttp\Promise\PromiseInterface;
use GuzzleHttp\Psr7\Uri;
use Nacosvel\Nacos\Contracts\NacosAuthInterface;
use Nacosvel\Nacos\Contracts\NacosClientInterface;
use Nacosvel\Nacos\Contracts\NacosUriInterface;
use Psr\Cache\CacheItemPoolInterface;
use Psr\Cache\InvalidArgumentException;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;

class RefreshAccessToken
{
    protected NacosUriInterface      $uri;
    protected NacosAuthInterface     $auth;
    protected CacheItemPoolInterface $cache;
    /**
     * @var callable(RequestInterface, array): PromiseInterface $nextHandler
     */
    private $nextHandler;

    /**
     * @param NacosClientInterface                                $nacosClient
     * @param callable(RequestInterface, array): PromiseInterface $nextHandler
     */
    public function __construct(protected NacosClientInterface $nacosClient, callable $nextHandler)
    {
        $this->uri         = $this->nacosClient->getConfig()->getNacosUri();
        $this->auth        = $this->nacosClient->getConfig()->getNacosAuth();
        $this->cache       = $this->nacosClient->getConfig()->getCache();
        $this->nextHandler = $nextHandler;
    }

    public function __invoke(RequestInterface $request, array $options): PromiseInterface
    {
        $handler = $this->nextHandler;
        $uri     = $this->uri->getUri(false);
        $uri     = $request->getUri()
            ->withScheme($uri->getScheme())
            ->withHost($uri->getHost())
            ->withUserInfo($uri->getUserInfo())
            ->withPort($uri->getPort())
            ->withPath($request->getUri()->getPath())
            ->withQuery($request->getUri()->getQuery());

        try {
            $item = $this->cache->getItem(md5($this->uri->getUri()));
            if ($item->isHit()) {
                $uri = Uri::withQueryValue($uri, 'accessToken', $item->get());
            }
        } catch (\Exception|InvalidArgumentException $exception) {
            // ignore access token
        }

        $request = $request->withUri($uri);

        return $handler($request, $options)->then(
            $this->onFulfilled($request, $options),
            $this->onRejected($request, $options)
        );
    }

    public function onFulfilled(RequestInterface $request, array $options): callable
    {
        return function (ResponseInterface $response) use ($request, $options): PromiseInterface|ResponseInterface {
            if ($response->getStatusCode() === 200) {
                return $response;
            }
            if ($this->decider($request, $options, $response) === false) {
                return $response;
            }
            return $this->doRetry($request, $options);
        };
    }

    public function onRejected(RequestInterface $request, array $options): callable
    {
        return function (mixed $reason) use ($request, $options): PromiseInterface {
            if ($this->decider($request, $options, null, $reason) === false) {
                return Create::rejectionFor($reason);
            }
            return $this->doRetry($request, $options);
        };
    }

    private function doRetry(RequestInterface $request, array $options): PromiseInterface
    {
        $request = $request->withHeader('RefreshAccessToken', 'RefreshAccessToken');

        return $this($request, $options);
    }

    public function decider(RequestInterface $request, array $options, ?ResponseInterface $response = null, mixed $reason = null): bool
    {
        if ($request->hasHeader('RefreshAccessToken')) {
            return false;
        }

        if ($response?->getStatusCode() === 403) {
            return $this->auth->getAccessToken($this->nacosClient);
        }

        if ($reason instanceof ConnectException) {
            return true;
        }

        return false;
    }

}
