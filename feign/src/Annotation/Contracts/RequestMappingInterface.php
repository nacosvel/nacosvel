<?php

namespace Nacosvel\Feign\Annotation\Contracts;

interface RequestMappingInterface
{
    /**
     * @return string|null
     */
    public function getPath(): string|null;

    /**
     * @param string|null $path
     *
     * @return static
     */
    public function setPath(string|null $path): static;

    /**
     * @return string|null
     */
    public function getMethod(): string|null;

    /**
     * @param string|null $method
     *
     * @return static
     */
    public function setMethod(string|null $method): static;

    /**
     * @return array
     */
    public function getParams(): array;

    /**
     * @param string $params
     *
     * @return static
     */
    public function setParams(string $params): static;

    /**
     * @return array
     */
    public function getHeaders(): array;

    /**
     * @param string $headers
     *
     * @return static
     */
    public function setHeaders(string $headers): static;

}
