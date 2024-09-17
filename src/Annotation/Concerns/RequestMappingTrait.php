<?php

namespace Nacosvel\Feign\Annotation\Concerns;

use Nacosvel\Helper\Utils;

trait RequestMappingTrait
{
    /**
     * @return string|null
     */
    public function getPath(): string|null
    {
        return $this->path;
    }

    /**
     * @param string|null $path
     *
     * @return static
     */
    public function setPath(string|null $path): static
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
        return Utils::http_parse_query($this->params);
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
        return Utils::http_parse_query($this->headers);
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

}
