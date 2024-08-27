<?php

namespace Nacosvel\Nacos\Contracts;

use GuzzleHttp\ClientInterface;

interface NacosClientInterface
{
    public function getConfig(): NacosConfigInterface;

    public function setConfig(NacosConfigInterface $config): static;

    public function getResponse(): NacosResponseInterface;

    public function setResponse(NacosResponseInterface $response): static;

    public function getClient(): ClientInterface;

    public function setClient(?ClientInterface $client = null): static;

    public function request(NacosRequestInterface|string $method, string $uri = '', array $options = []): NacosResponseInterface;

}
