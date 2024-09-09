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
     * @return string
     */
    public function getParams(): string;

    /**
     * @return string
     */
    public function getHeaders(): string;

    /**
     * @return string
     */
    public function getConsumes(): string;

    /**
     * @return string
     */
    public function getProduces(): string;

}
