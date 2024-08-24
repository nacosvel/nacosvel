<?php

namespace Nacosvel\Nacos\Contracts;

use GuzzleHttp\ClientInterface;

interface NacosClientInterface
{
    public function getRequest(): NacosRequestInterface;

    public function setRequest(NacosRequestInterface $request): static;

    public function getResponse(): NacosResponseInterface;

    public function setResponse(NacosResponseInterface $response): static;

    public function getClient(): ClientInterface;

    public function setClient(ClientInterface $client): static;

}
