<?php

namespace Nacosvel\Feign\Contracts;

use Nacosvel\Feign\Annotation\Contracts\FeignClientInterface;
use Nacosvel\Feign\Annotation\Contracts\RequestMappingInterface;

interface RequestTemplateInterface
{
    /**
     * @return FeignClientInterface|null
     */
    public function getFeignClient(): ?FeignClientInterface;

    /**
     * @param FeignClientInterface $feignClient
     *
     * @return static
     */
    public function setFeignClient(FeignClientInterface $feignClient): static;

    /**
     * @return RequestMappingInterface|null
     */
    public function getRequestMapping(): ?RequestMappingInterface;

    /**
     * @param RequestMappingInterface $requestMapping
     *
     * @return static
     */
    public function setRequestMapping(RequestMappingInterface $requestMapping): static;

    /**
     * @return string
     */
    public function getAction(): string;

    /**
     * @param string $action
     *
     * @return static
     */
    public function setAction(string $action): static;

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
     * @return string
     */
    public function getAlias(): string;

    /**
     * @param string $alias
     *
     * @return static
     */
    public function setAlias(string $alias): static;

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
     * @param string $parameter
     *
     * @return $this
     */
    public function pushParameter(string $parameter): static;

}
