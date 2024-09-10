<?php

namespace Nacosvel\Feign\Configuration;

use GuzzleHttp\Psr7\Response;
use Nacosvel\Feign\Contracts\FallbackInterface;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;

class Fallback implements FallbackInterface
{
    public function __invoke(
        RequestInterface  $request,
        ResponseInterface $response,
        array             $options = []
    ): ResponseInterface
    {
        return new Response($response->getStatusCode(), [], json_encode([
            'code'    => $response->getStatusCode(),
            'status'  => false,
            'message' => $response->getReasonPhrase(),
        ]));
    }

}
