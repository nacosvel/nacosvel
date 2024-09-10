<?php

namespace Nacosvel\Feign\Middleware;

use GuzzleHttp\Exception\RequestException;
use Nacosvel\Feign\Contracts\FallbackInterface;
use Nacosvel\Interop\Container\Nacosvel;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;

class FallbackMiddleware extends ResponseMiddleware
{
    public function response(RequestInterface $request, ResponseInterface $response, array $options): ResponseInterface
    {
        if ($response->getStatusCode() < 400) {
            return $response;
        }
        $container = Nacosvel::getInstance()->getContainer();
        if ($container->has(FallbackInterface::class)) {
            return call_user_func($container->make(FallbackInterface::class), $request, $response, $options);
        }
        throw RequestException::create($request, $response);
    }

}
