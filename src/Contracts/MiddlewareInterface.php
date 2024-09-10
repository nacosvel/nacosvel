<?php

namespace Nacosvel\Feign\Contracts;

use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;

interface MiddlewareInterface
{
    public function request(RequestInterface $request, array $options): RequestInterface;

    public function response(RequestInterface $request, ResponseInterface $response, array $options): ResponseInterface;

}
