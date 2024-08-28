<?php

namespace Nacosvel\Nacos\Concerns;

use Psr\Http\Message\ResponseInterface;

trait NacosResponseTrait
{
    public function __construct(protected ?ResponseInterface $response = null)
    {
        //
    }

    /**
     * @return ResponseInterface
     */
    public function getResponse(): ResponseInterface
    {
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

}
