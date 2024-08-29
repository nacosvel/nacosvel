<?php

namespace Nacosvel\Nacos\Contracts;

use Psr\Http\Message\ResponseInterface;

interface NacosResponseInterface
{
    /**
     * @return ResponseInterface
     */
    public function getResponse(): ResponseInterface;

    /**
     * @param ResponseInterface $response
     *
     * @return static
     */
    public function setResponse(ResponseInterface $response): static;

    /**
     * @param (callable(ResponseInterface): mixed)|null $callback
     *
     * @return mixed
     */
    public function response(callable $callback = null): mixed;

    /**
     * @param (callable(ResponseInterface): mixed)|null $callback
     *
     * @return mixed
     */
    public function raw(callable $callback = null): mixed;

}
