<?php

namespace Nacosvel\Feign\Middleware;

use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;

class ResponseMiddleware extends AbstractMiddleware
{
    public function response(RequestInterface $request, ResponseInterface $response, array $options): ResponseInterface
    {
        return $response;
    }

}
