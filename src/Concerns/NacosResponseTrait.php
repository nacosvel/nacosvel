<?php

namespace Nacosvel\NacosClient\Concerns;

use GuzzleHttp\Psr7\Response;
use GuzzleHttp\Psr7\Utils;
use Psr\Http\Message\ResponseInterface;

trait NacosResponseTrait
{
    protected ResponseInterface $response;

    /**
     * @return ResponseInterface
     */
    public function getResponse(): ResponseInterface
    {
        $this->response->getBody()->rewind();

        return $this->response;
    }

    /**
     * @param (callable(ResponseInterface): mixed)|null $callback
     *
     * @return mixed
     */
    public function response(callable $callback = null): mixed
    {
        $response = $this->getResponse();

        $response = new Response(
            status: $response->getStatusCode(),
            headers: $response->getHeaders(),
            body: Utils::streamFor($this->standardizing($response)),
            version: $response->getProtocolVersion(),
            reason: $response->getReasonPhrase()
        );

        $callback = $callback ?? function (ResponseInterface $response) {
            $content = json_decode($response->getBody()->getContents(), true);

            if (json_last_error() == JSON_ERROR_NONE) {
                return $content;
            }

            return [];
        };

        return $callback($response);
    }

    /**
     * @param (callable(ResponseInterface): mixed)|null $callback
     *
     * @return mixed
     */
    public function raw(callable $callback = null): mixed
    {
        $response = $this->getResponse();

        $callback = $callback ?? function (ResponseInterface $response) {
            return $response->getBody()->getContents();
        };

        return $callback($response);
    }

    /**
     * @inheritDoc
     *
     * @return static
     */
    public function setResponse(ResponseInterface $response): static
    {
        $this->response = $response;

        return $this;
    }

}
