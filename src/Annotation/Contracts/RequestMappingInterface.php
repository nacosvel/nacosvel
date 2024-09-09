<?php

namespace Nacosvel\Feign\Annotation\Contracts;

interface RequestMappingInterface
{
    /**
     * @return string
     */
    public function getPath(): string;

    /**
     * @return string
     */
    public function getMethod(): string;

    /**
     * @return array
     */
    public function getParams(): array;

    /**
     * @return array
     */
    public function getHeaders(): array;

    /**
     * @return string
     */
    public function getConsumes(): string;

    /**
     * @return string
     */
    public function getProduces(): string;

}
