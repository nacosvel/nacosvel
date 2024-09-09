<?php

namespace Nacosvel\Feign\Concerns;

use Nacosvel\Feign\Annotation\Contracts\FeignClientInterface;
use Nacosvel\Feign\Annotation\Contracts\RequestMappingInterface;

trait RequestTemplateTrait
{
    protected ?FeignClientInterface    $feignClient    = null;
    protected ?RequestMappingInterface $requestMapping = null;

    protected string $action;
    protected array  $body;

    /**
     * @return FeignClientInterface|null
     */
    public function getFeignClient(): ?FeignClientInterface
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
    public function getRequestMapping(): ?RequestMappingInterface
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
     * @return string
     */
    public function getAction(): string
    {
        return $this->action;
    }

    /**
     * @param string $action
     *
     * @return static
     */
    public function setAction(string $action): static
    {
        $this->action = $action;
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
        $this->body = $body;
        return $this;
    }

    /**
     * @return string
     */
    abstract public function getAlias(): string;

    /**
     * @param string $alias
     *
     * @return static
     */
    abstract public function setAlias(string $alias): static;

}
