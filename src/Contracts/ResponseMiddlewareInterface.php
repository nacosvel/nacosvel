<?php

namespace Nacosvel\Feign\Contracts;

use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;

interface ResponseMiddlewareInterface
{
    public function response(RequestInterface $request, ResponseInterface $response, array $options): ResponseInterface;

}
