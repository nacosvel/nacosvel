<?php

namespace Nacosvel\Feign;

use Nacosvel\Feign\Annotation\Contracts\FeignClientInterface;
use Nacosvel\Feign\Annotation\Contracts\RequestAttributeInterface;
use Nacosvel\Feign\Annotation\Contracts\RequestMappingInterface;
use Nacosvel\Feign\Contracts\MiddlewareInterface;
use Nacosvel\Feign\Contracts\RequestMiddlewareInterface;
use Nacosvel\Feign\Contracts\RequestTemplateInterface;
use Nacosvel\Feign\Contracts\ResponseMiddlewareInterface;

class RequestTemplate implements RequestTemplateInterface
{
    protected string                     $propertyName        = '';
    protected string                     $methodName          = '';
    protected ?FeignClientInterface      $feignClient         = null;
    protected ?RequestMappingInterface   $requestMapping      = null;
    protected ?RequestAttributeInterface $requestAttribute    = null;
    protected array                      $middlewares         = [];
    protected array                      $requestMiddlewares  = [];
    protected array                      $responseMiddlewares = [];
    protected array                      $parameters          = [];
    protected array                      $body                = [];
    protected array                      $returnTypes         = [];

    /**
     * @return string
     */
    public function getPropertyName(): string
    {
        return $this->propertyName;
    }

    /**
     * @param string $propertyName
     *
     * @return static
     */
    public function setPropertyName(string $propertyName): static
    {
        $this->propertyName = $propertyName;
        return $this;
    }

    /**
     * @return string
     */
    public function getMethodName(): string
    {
        return $this->methodName;
    }

    /**
     * @param string $methodName
     *
     * @return static
     */
    public function setMethodName(string $methodName): static
    {
        $this->methodName = $methodName;
        return $this;
    }

    /**
     * @return FeignClientInterface|null
     */
    public function getFeignClient(): FeignClientInterface|null
    {
        return $this->feignClient;
    }

    /**
     * @param FeignClientInterface $feignClient
     *
     * @return static
     */
    public function setFeignClient(FeignClientInterface $feignClient): static
    {
        $this->feignClient = $feignClient;
        return $this;
    }

    /**
     * @return RequestMappingInterface|null
     */
    public function getRequestMapping(): RequestMappingInterface|null
    {
        return $this->requestMapping;
    }

    /**
     * @param RequestMappingInterface $requestMapping
     *
     * @return static
     */
    public function setRequestMapping(RequestMappingInterface $requestMapping): static
    {
        $this->requestMapping = $requestMapping;
        return $this;
    }

    /**
     * @return RequestAttributeInterface|null
     */
    public function getRequestAttribute(): RequestAttributeInterface|null
    {
        return $this->requestAttribute;
    }

    /**
     * @param RequestAttributeInterface $requestAttribute
     *
     * @return static
     */
    public function setRequestAttribute(RequestAttributeInterface $requestAttribute): static
    {
        $this->requestAttribute = $requestAttribute;
        return $this;
    }

    /**
     * @return array
     */
    public function getMiddlewares(): array
    {
        return $this->middlewares;
    }

    /**
     * @param MiddlewareInterface $middleware
     *
     * @return static
     */
    public function addMiddleware(MiddlewareInterface $middleware): static
    {
        $this->middlewares[] = $middleware;
        return $this;
    }

    /**
     * @return array
     */
    public function getRequestMiddlewares(): array
    {
        return $this->requestMiddlewares;
    }

    /**
     * @param RequestMiddlewareInterface $requestMiddleware
     *
     * @return static
     */
    public function addRequestMiddleware(RequestMiddlewareInterface $requestMiddleware): static
    {
        $this->requestMiddlewares[] = $requestMiddleware;
        return $this;
    }

    /**
     * @return array
     */
    public function getResponseMiddlewares(): array
    {
        return $this->responseMiddlewares;
    }

    /**
     * @param ResponseMiddlewareInterface $responseMiddleware
     *
     * @return static
     */
    public function addResponseMiddleware(ResponseMiddlewareInterface $responseMiddleware): static
    {
        $this->responseMiddlewares[] = $responseMiddleware;
        return $this;
    }

    /**
     * @return array
     */
    public function getParameters(): array
    {
        return $this->parameters;
    }

    /**
     * @param array $parameters
     *
     * @return static
     */
    public function setParameters(array $parameters): static
    {
        $this->parameters = $parameters;
        return $this;
    }

    /**
     * @return array
     */
    public function getBody(): array
    {
        return $this->body;
    }

    /**
     * @param array $body
     *
     * @return static
     */
    public function setBody(array $body): static
    {
        $this->body = array_merge($this->getBody(), $body);
        return $this;
    }

    /**
     * @return array
     */
    public function getReturnTypes(): array
    {
        return $this->returnTypes;
    }

    /**
     * @param array $returnTypes
     *
     * @return static
     */
    public function setReturnTypes(array $returnTypes): static
    {
        $this->returnTypes = $returnTypes;
        return $this;
    }

}
