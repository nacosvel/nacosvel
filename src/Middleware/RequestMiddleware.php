<?php

namespace Nacosvel\Feign\Middleware;

use Psr\Http\Message\RequestInterface;

class RequestMiddleware extends AbstractMiddleware
{
    public function request(RequestInterface $request, array $options): RequestInterface
    {
        return $request;
    }

}
