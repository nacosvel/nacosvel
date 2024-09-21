<?php

namespace Nacosvel\Feign\Support;

use Nacosvel\Feign\Contracts\ServiceInterface;
use Nacosvel\Feign\Contracts\TransformationInterface;
use Psr\Http\Message\ResponseInterface;

abstract class Service implements ServiceInterface, TransformationInterface
{
    abstract public function getRawContents(): string;

    abstract public function getOriginalResponse(): ResponseInterface;

    abstract public function toArray(): array;

    abstract public function get(int|string $key = null, $default = null);

    abstract public function convertToArray(): array;

}
