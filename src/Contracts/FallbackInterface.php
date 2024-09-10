<?php

namespace Nacosvel\Feign\Contracts;

use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;

interface FallbackInterface
{
    public function __invoke(
        RequestInterface  $request,
        ResponseInterface $response,
        array             $options = []
    ): ResponseInterface;

}
