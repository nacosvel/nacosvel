<?php

namespace Nacosvel\Feign\Contracts;

use Nacosvel\OpenHttp\Contracts\ChainableInterface;
use Psr\Http\Message\ResponseInterface;

interface FeignRequestInterface
{
    public function __invoke(): ResponseInterface;

    public function getClient(): ChainableInterface;

    public function buildURI(): string;

    public function buildPath(): string;

    public function buildMethod(): string;

    public function buildOptions(): array;

}
