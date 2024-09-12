<?php

namespace Nacosvel\Feign\Middleware;

use GuzzleHttp\Exception\RequestException;
use Nacosvel\Feign\Contracts\FallbackInterface;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;
use function Nacosvel\Container\Interop\application;

class FallbackMiddleware extends ResponseMiddleware
{
    public function response(RequestInterface $request, ResponseInterface $response, array $options): ResponseInterface
    {
        if ($response->getStatusCode() < 400) {
            return $response;
        }
        if (application()->getContainer()->has(FallbackInterface::class)) {
            return call_user_func(application(FallbackInterface::class), $request, $response, $options);
        }
        throw RequestException::create($request, $response);
    }

}
