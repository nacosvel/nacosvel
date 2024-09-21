<?php

namespace Nacosvel\Feign\Contracts;

use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;
use Throwable;

interface FallbackInterface
{
    /**
     * @throws Throwable
     */
    public function __invoke(
        RequestInterface  $request,
        ResponseInterface $response,
        array             $options = [],
        Throwable         $previous = null
    ): ResponseInterface;

}
