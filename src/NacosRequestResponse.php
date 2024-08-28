<?php

namespace Nacosvel\NacosClient;

use Nacosvel\Nacos\NacosRequest;
use Nacosvel\NacosClient\Concerns\NacosResponseTrait;
use Nacosvel\NacosClient\Contracts\NacosResponseInterface;
use Psr\Http\Message\ResponseInterface;

class NacosRequestResponse extends NacosRequest implements NacosResponseInterface
{
    use NacosResponseTrait;

    public function responseValid(ResponseInterface $response, string $content, array $decode = []): bool
    {
        return $response->getStatusCode() == 200;
    }

    public function responseSuccessCallback(ResponseInterface $response, string $content, array $decode = []): string
    {
        return $content;
    }

    public function responseFailureCallback(ResponseInterface $response, string $content, array $decode = []): string
    {
        return $content;
    }

    public function standardizing(ResponseInterface $response): string
    {
        $content = $response->getBody()->getContents();
        $decode  = json_decode($content, true);

        if (json_last_error() != JSON_ERROR_NONE) {
            $decode = [];
        }

        $successCallback = $this->responseSuccessCallback($response, $content, $decode);
        $failureCallback = $this->responseFailureCallback($response, $content, $decode);

        return $this->responseValid($response, $content, $decode) ? $successCallback : $failureCallback;
    }

}
