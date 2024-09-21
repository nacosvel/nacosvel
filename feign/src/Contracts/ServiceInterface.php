<?php

namespace Nacosvel\Feign\Contracts;

use Psr\Http\Message\ResponseInterface;

interface ServiceInterface
{
    public function getRawContents(): string;

    public function getOriginalResponse(): ResponseInterface;

    public function toArray(): array;

}
