<?php

namespace Nacosvel\Feign\Contracts;

use Nacosvel\Feign\Annotation\Contracts\FeignClientInterface;
use Nacosvel\Feign\Annotation\Contracts\RequestMappingInterface;
use Nacosvel\OpenHttp\Contracts\ChainableInterface;
use Psr\Http\Message\ResponseInterface;

interface FeignRequestInterface
{
    public function __invoke(): ResponseInterface;

    /**
     * @return ChainableInterface
     */
    public function getClient(): ChainableInterface;

    public function getFeignClient(): FeignClientInterface;

    public function getRequestMapping(): RequestMappingInterface;

    public function getPath(): string;

    public function getMethod(): string;

    public function toArray(): array;

}
