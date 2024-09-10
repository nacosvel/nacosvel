<?php

namespace Nacosvel\Feign\Middleware;

use Nacosvel\Feign\Contracts\MiddlewareInterface;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;

abstract class AbstractMiddleware implements MiddlewareInterface
{
    public function __invoke(callable $handler): callable
    {
        return function (RequestInterface $request, array $options) use ($handler) {
            return $handler(call_user_func([$this, 'request'], $request, $options), $options)->then(
                function (ResponseInterface $response) use ($request, $options) {
                    return call_user_func([$this, 'response'], $request, $response, $options);
                }
            );
        };
    }

    public function request(RequestInterface $request, array $options): RequestInterface
    {
        return $request;
    }

    public function response(RequestInterface $request, ResponseInterface $response, array $options): ResponseInterface
    {
        return $response;
    }

}
