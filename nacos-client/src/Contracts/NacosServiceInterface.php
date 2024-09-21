<?php

namespace Nacosvel\NacosClient\Contracts;

use GuzzleHttp\ClientInterface;
use Nacosvel\Nacos\Contracts\NacosResponseInterface;
use Psr\Cache\CacheItemPoolInterface;
use Psr\Log\LoggerInterface;

interface NacosServiceInterface
{
    /**
     * @return string
     */
    public function getNamespace(): string;

    /**
     * @param string $namespace
     *
     * @return static
     */
    public function setNamespace(string $namespace): static;

    /**
     * @return string
     */
    public function getNamespaceId(): string;

    /**
     * @param string $namespaceId
     *
     * @return static
     */
    public function setNamespaceId(string $namespaceId): static;

    /**
     * @param CacheItemPoolInterface $cache
     *
     * @return static
     */
    public function withCache(CacheItemPoolInterface $cache): static;

    /**
     * @param ClientInterface $client
     *
     * @return static
     */
    public function withClient(ClientInterface $client): static;

    /**
     * @param LoggerInterface $logger
     *
     * @return static
     */
    public function withLogger(LoggerInterface $logger): static;

    /**
     * 命名空间 注入，发送请求后统一响应
     *
     * @param NacosRequestResponseInterface $request
     *
     * @return NacosResponseInterface
     */
    public function execute(NacosRequestResponseInterface $request): NacosResponseInterface;

}
