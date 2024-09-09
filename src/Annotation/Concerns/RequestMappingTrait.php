<?php

namespace Nacosvel\Feign\Annotation\Concerns;

use Nacosvel\Feign\Concerns\StrToArrayTrait;

trait RequestMappingTrait
{
    use StrToArrayTrait;

    /**
     * @return string
     */
    public function getPath(): string
    {
        return $this->path;
    }

    /**
     * @param string $path
     *
     * @return static
     */
    public function setPath(string $path): static
    {
        $this->path = $path;
        return $this;
    }

    /**
     * @return string
     */
    public function getMethod(): string
    {
        return $this->method;
    }

    /**
     * @param string $method
     *
     * @return static
     */
    public function setMethod(string $method): static
    {
        $this->method = $method;
        return $this;
    }

    /**
     * @return array
     */
    public function getParams(): array
    {
        return $this->parseStrToArray($this->params);
    }

    /**
     * @param string $params
     *
     * @return static
     */
    public function setParams(string $params): static
    {
        $this->params = $params;
        return $this;
    }

    /**
     * @return array
     */
    public function getHeaders(): array
    {
        return $this->parseStrToArray($this->headers);
    }

    /**
     * @param string $headers
     *
     * @return static
     */
    public function setHeaders(string $headers): static
    {
        $this->headers = $headers;
        return $this;
    }

    /**
     * @return string
     */
    public function getConsumes(): string
    {
        return $this->consumes;
    }

    /**
     * @param string $consumes
     *
     * @return static
     */
    public function setConsumes(string $consumes): static
    {
        $this->consumes = $consumes;
        return $this;
    }

    /**
     * @return string
     */
    public function getProduces(): string
    {
        return $this->produces;
    }

    /**
     * @param string $produces
     *
     * @return static
     */
    public function setProduces(string $produces): static
    {
        $this->produces = $produces;
        return $this;
    }

}
