<?php

namespace Nacosvel\Feign\Contracts;

use Nacosvel\Feign\Annotation\Contracts\FeignClientInterface;
use Nacosvel\Feign\Annotation\Contracts\RequestAttributeInterface;
use Nacosvel\Feign\Annotation\Contracts\RequestMappingInterface;

interface RequestTemplateInterface
{
    /**
     * @return string
     */
    public function getPropertyName(): string;

    /**
     * @param string $propertyName
     *
     * @return static
     */
    public function setPropertyName(string $propertyName): static;

    /**
     * @return string
     */
    public function getMethodName(): string;

    /**
     * @param string $methodName
     *
     * @return static
     */
    public function setMethodName(string $methodName): static;

    /**
     * @return FeignClientInterface|null
     */
    public function getFeignClient(): FeignClientInterface|null;

    /**
     * @param FeignClientInterface $feignClient
     *
     * @return static
     */
    public function setFeignClient(FeignClientInterface $feignClient): static;

    /**
     * @return RequestMappingInterface|null
     */
    public function getRequestMapping(): RequestMappingInterface|null;

    /**
     * @param RequestMappingInterface $requestMapping
     *
     * @return static
     */
    public function setRequestMapping(RequestMappingInterface $requestMapping): static;

    /**
     * @return RequestAttributeInterface|null
     */
    public function getRequestAttribute(): RequestAttributeInterface|null;

    /**
     * @param RequestAttributeInterface $requestAttribute
     *
     * @return static
     */
    public function setRequestAttribute(RequestAttributeInterface $requestAttribute): static;

    /**
     * @return array
     */
    public function getMiddlewares(): array;

    /**
     * @param MiddlewareInterface $middleware
     *
     * @return static
     */
    public function addMiddleware(MiddlewareInterface $middleware): static;

    /**
     * @return array
     */
    public function getRequestMiddlewares(): array;

    /**
     * @param RequestMiddlewareInterface $requestMiddleware
     *
     * @return static
     */
    public function addRequestMiddleware(RequestMiddlewareInterface $requestMiddleware): static;

    /**
     * @return array
     */
    public function getResponseMiddlewares(): array;

    /**
     * @param ResponseMiddlewareInterface $responseMiddleware
     *
     * @return static
     */
    public function addResponseMiddleware(ResponseMiddlewareInterface $responseMiddleware): static;

    /**
     * @return array
     */
    public function getParameters(): array;

    /**
     * @param array $parameters
     *
     * @return static
     */
    public function setParameters(array $parameters): static;

    /**
     * @return array
     */
    public function getBody(): array;

    /**
     * @param array $body
     *
     * @return static
     */
    public function setBody(array $body): static;

    /**
     * @return array
     */
    public function getReturnTypes(): array;

    /**
     * @param array $returnTypes
     *
     * @return static
     */
    public function setReturnTypes(array $returnTypes): static;

}
