<?php

namespace Nacosvel\Nacos\Concerns;

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
     * @param ResponseInterface $response
     *
     * @return static
     */
    public function setResponse(ResponseInterface $response): static
    {
        $this->response = $response;
        return $this;
    }

    /**
     * @param (callable(ResponseInterface): mixed)|null $callback
     *
     * @return mixed
     */
    abstract public function response(callable $callback = null): mixed;

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

}
