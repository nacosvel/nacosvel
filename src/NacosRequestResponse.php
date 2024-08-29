<?php

namespace Nacosvel\NacosClient;

use GuzzleHttp\Psr7\Response;
use GuzzleHttp\Psr7\Utils;
use Nacosvel\Nacos\Concerns\NacosResponseTrait;
use Nacosvel\Nacos\NacosRequest;
use Nacosvel\NacosClient\Contracts\NacosRequestResponseInterface;
use Psr\Http\Message\ResponseInterface;

abstract class NacosRequestResponse extends NacosRequest implements NacosRequestResponseInterface
{
    use NacosResponseTrait;

    protected function responseValid(int $code, string $content, array $decode = []): bool
    {
        return $code == 200;
    }

    protected function responseSuccessHandler(int $code, string $content, array $decode = []): string
    {
        return $content;
    }

    protected function responseFailureHandler(int $code, string $content, array $decode = []): string
    {
        return $content;
    }

    /**
     * @inheritDoc
     *
     * @return mixed
     */
    public function response(callable $callback = null): mixed
    {
        $response = $this->getResponse();
        $content  = $response->getBody()->getContents();

        $response = new Response(
            status: $code = $response->getStatusCode(),
            headers: $response->getHeaders(),
            body: Utils::streamFor((function (int $code, string $content) {
                $decode = json_decode($content, true);

                if (json_last_error() != JSON_ERROR_NONE) {
                    $decode = [];
                }

                $successCallback = $this->responseSuccessHandler($code, $content, $decode);
                $failureCallback = $this->responseFailureHandler($code, $content, $decode);

                return $this->responseValid($code, $content, $decode) ? $successCallback : $failureCallback;
            })($code, $content)),
            version: $response->getProtocolVersion(),
            reason: $response->getReasonPhrase()
        );
        $response->getBody()->rewind();

        $callback = $callback ?? function (ResponseInterface $response): array {
            $content = $response->getBody()->getContents();
            $content = json_decode($content, true);

            if (json_last_error() == JSON_ERROR_NONE) {
                return $content;
            }

            return [];
        };

        return $callback($response);
    }

}
