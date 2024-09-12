<?php

namespace Nacosvel\Feign;

use Exception;
use GuzzleHttp\Exception\BadResponseException;
use GuzzleHttp\Exception\ConnectException;
use Nacosvel\Feign\Annotation\Contracts\FeignClientInterface;
use Nacosvel\Feign\Annotation\Contracts\RequestMappingInterface;
use Nacosvel\Feign\Annotation\FeignClient;
use Nacosvel\Feign\Annotation\RequestMapping;
use Nacosvel\Feign\Contracts\ConfigurationInterface;
use Nacosvel\Feign\Contracts\FallbackInterface;
use Nacosvel\Feign\Contracts\FeignRequestInterface;
use Nacosvel\Feign\Contracts\RequestTemplateInterface;
use Nacosvel\Feign\Middleware\FallbackMiddleware;
use Nacosvel\Feign\Middleware\RequestMiddleware;
use Nacosvel\Feign\Middleware\ResponseMiddleware;
use Nacosvel\Feign\Middleware\UserAgentMiddleware;
use Nacosvel\OpenHttp\Builder;
use Nacosvel\OpenHttp\Contracts\ChainableInterface;
use Psr\Http\Message\ResponseInterface;
use function Nacosvel\Container\Interop\application;

class FeignRequest implements FeignRequestInterface
{
    protected ChainableInterface $client;

    public function __construct(
        protected RequestTemplateInterface $requestTemplate
    )
    {
        $this->client  = Builder::factory();
    }

    public function __invoke(): ResponseInterface
    {
        try {
            return $this->setClientFallback()
                ->getClient()
                ->chain($this->getPath())
                ->request($this->getMethod(), $this->toArray());
        } catch (BadResponseException $exception) {
            return $exception->getResponse();
        } catch (ConnectException|Exception $exception) {
            throw new $exception;
        }
    }

    protected function setClientFallback(): static
    {
        if ($fallback = $this->getFeignClient()->getFallback()) {
            application()->bind(FallbackInterface::class, function () use ($fallback) {
                return $fallback;
            });
        }
        return $this;
    }

    /**
     * @return ChainableInterface
     */
    public function getClient(): ChainableInterface
    {
        $client  = $this->getFeignClient()->getClient();
        $handler = $this->client->getClient()->setRequestClient($client)->getConfig('handler');
        $handler->push(new UserAgentMiddleware());
        $handler->push(new RequestMiddleware());
        $handler->push(new ResponseMiddleware());
        $handler->push(new FallbackMiddleware());
        return $this->client;
    }

    public function getFeignClient(): FeignClientInterface
    {
        if ($feignClient = $this->requestTemplate->getFeignClient()) {
            return $feignClient;
        }

        return new FeignClient('order');
    }

    public function getRequestMapping(): RequestMappingInterface
    {
        if ($requestMapping = $this->requestTemplate->getRequestMapping()) {
            return $requestMapping;
        }

        return new RequestMapping($this->requestTemplate->getAlias());
    }

    public function getPath(): string
    {
        return join('/', array_filter([
            rtrim($this->getFeignClient()->getUrl(), '/'),
            trim($this->getFeignClient()->getPath(), '/'),
            trim($this->getRequestMapping()->getPath(), '/'),
        ]));
    }

    public function getMethod(): string
    {
        return $this->getRequestMapping()->getMethod();
    }

    public function toArray(): array
    {
        /** @var ConfigurationInterface $configuration */
        $configuration = application(ConfigurationInterface::class);
        $method        = $configuration->getConsumerMap($this->getMethod());
        $parameters    = array_merge($this->requestTemplate->getRequestMapping()->getParams(), $this->requestTemplate->getBody());
        return tap($parameters, function ($parameters) use ($method) {
            $parameters[$method] = $parameters;
        });
    }

}
