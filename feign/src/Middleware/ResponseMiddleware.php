<?php

namespace Nacosvel\Feign\Middleware;

use Nacosvel\Feign\Contracts\ResponseMiddlewareInterface;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;

class ResponseMiddleware extends AbstractMiddleware implements ResponseMiddlewareInterface
{
    public function response(RequestInterface $request, ResponseInterface $response, array $options): ResponseInterface
    {
        return $response;
    }

}
