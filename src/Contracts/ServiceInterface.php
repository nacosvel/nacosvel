<?php

namespace Nacosvel\Feign\Contracts;

use Psr\Http\Message;

interface ServiceInterface
{
    public function getRawContents(): string;

    public function getOriginalResponse(): Message\ResponseInterface;

    public function toArray(): array;

}
