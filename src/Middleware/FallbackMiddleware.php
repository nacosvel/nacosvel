<?php

namespace Nacosvel\Feign\Middleware;

use GuzzleHttp\Exception\RequestException;
use Nacosvel\Feign\Contracts\FallbackInterface;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;
use function Nacosvel\Container\Interop\application;

class FallbackMiddleware extends ResponseMiddleware
{
    public function __construct(protected string $fallbackClass)
    {
        //
    }

    public function response(RequestInterface $request, ResponseInterface $response, array $options): ResponseInterface
    {
        try {
            if ($response->getStatusCode() < 400) {
                return $response;
            }
            throw RequestException::create($request, $response);
        } catch (\Exception $exception) {
            if (
                class_exists($this->fallbackClass) &&
                is_subclass_of($this->fallbackClass, FallbackInterface::class) &&
                call_user_func(application($this->fallbackClass), $request, $response, $options, $exception) instanceof ResponseInterface) {
                return $response;
            }
            throw RequestException::create($request, $response);
        }
    }

}
