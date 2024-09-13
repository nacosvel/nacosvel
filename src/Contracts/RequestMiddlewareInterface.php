<?php

namespace Nacosvel\Feign\Contracts;

use Psr\Http\Message\RequestInterface;

interface RequestMiddlewareInterface
{
    public function request(RequestInterface $request, array $options): RequestInterface;

}
