<?php

namespace Nacosvel\Feign;

use Exception;
use GuzzleHttp\ClientInterface;
use GuzzleHttp\Exception\BadResponseException;
use Nacosvel\Feign\Annotation\Contracts\FeignClientInterface;
use Nacosvel\Feign\Annotation\Contracts\RequestMappingInterface;
use Nacosvel\Feign\Annotation\FeignClient;
use Nacosvel\Feign\Annotation\RequestMapping;
use Nacosvel\Feign\Contracts\ConfigurationInterface;
use Nacosvel\Feign\Contracts\FeignRequestInterface;
use Nacosvel\Feign\Contracts\RequestTemplateInterface;
use Nacosvel\Feign\Exception\FeignException;
use Nacosvel\Feign\Middleware\FallbackMiddleware;
use Nacosvel\Feign\Middleware\RequestMiddleware;
use Nacosvel\Feign\Middleware\ResponseMiddleware;
use Nacosvel\Feign\Middleware\UserAgentMiddleware;
use Nacosvel\Helper\Utils;
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
        $this->client = Builder::factory();
    }

    /**
     * @throws FeignException
     */
    public function __invoke(): ResponseInterface
    {
        try {
            return $this->getClient()
                ->chain($this->getPath())
                ->request($this->getMethod(), $this->toArray());
        } catch (BadResponseException $exception) {
            return $exception->getResponse();
        } catch (Exception $exception) {
            throw new FeignException($exception->getMessage(), $exception->getCode(), $exception);
        }
    }

    /**
     * @return ChainableInterface
     */
    public function getClient(): ChainableInterface
    {
        if (
            class_exists($clientClass = $this->getFeignClient()->getClient()) &&
            is_subclass_of($clientClass, ClientInterface::class)
        ) {
            $this->client->getClient()->setRequestClient(application($clientClass));
        }
        $handler = $this->client->getClient()->getConfig('handler');
        $handler->push(new RequestMiddleware(), 'RequestMiddleware');
        $handler->push(new UserAgentMiddleware(), 'UserAgentMiddleware');
        $handler->push(new ResponseMiddleware(), 'ResponseMiddleware');
        $handler->push(new FallbackMiddleware($this->getFeignClient()->getFallback()), 'FallbackMiddleware');
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
        $method        = $configuration->consumer($this->getMethod());
        $parameters    = array_merge($this->requestTemplate->getRequestMapping()->getParams(), $this->requestTemplate->getBody());
        return Utils::tap($parameters, function ($parameters) use ($method) {
            $parameters[$method] = $parameters;
        });
    }

}
