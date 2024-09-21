<?php

namespace Nacosvel\Feign\Configuration;

use GuzzleHttp\Exception\BadResponseException;
use GuzzleHttp\Exception\RequestException;
use GuzzleHttp\Psr7\Response;
use Nacosvel\Feign\Contracts\FallbackInterface;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;
use Throwable;

class Fallback implements FallbackInterface
{
    /**
     * @throws Throwable
     */
    public function __invoke(
        RequestInterface  $request,
        ResponseInterface $response,
        array             $options = [],
        Throwable         $previous = null
    ): ResponseInterface
    {
        if ($previous instanceof BadResponseException) {
            return $response;
        }
        if ($previous instanceof RequestException) {
            return new Response($response->getStatusCode(), [], json_encode([
                'code'    => $response->getStatusCode(),
                'status'  => false,
                'message' => $response->getReasonPhrase(),
            ]));
        }
        throw $previous;
    }

}
