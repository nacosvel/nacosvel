<?php

namespace Nacosvel\Feign\Middleware;

use Exception;
use GuzzleHttp\Exception\RequestException;
use Nacosvel\Feign\Contracts\FallbackInterface;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;

class FallbackMiddleware extends ResponseMiddleware
{
    public function __construct(protected FallbackInterface $fallback)
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
        } catch (Exception $exception) {
            $fallbackResponse = call_user_func($this->fallback, $request, $response, $options, $exception);
            if ($fallbackResponse instanceof ResponseInterface) {
                return $fallbackResponse;
            }
            throw RequestException::create($request, $response);
        }
    }

}
