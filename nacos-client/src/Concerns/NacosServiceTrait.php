<?php

namespace Nacosvel\NacosClient\Concerns;

use GuzzleHttp\ClientInterface;
use Nacosvel\Nacos\Contracts\NacosResponseInterface;
use Nacosvel\NacosClient\Console\NamespaceListRequest;
use Nacosvel\NacosClient\Contracts\NacosRequestResponseInterface;
use Psr\Cache\CacheItemPoolInterface;
use Psr\Log\LoggerInterface;

trait NacosServiceTrait
{
    protected string $namespaceId = '';

    /**
     * @return string
     */
    public function getNamespace(): string
    {
        return $this->namespace;
    }

    /**
     * @param string $namespace
     *
     * @return static
     */
    public function setNamespace(string $namespace): static
    {
        $this->namespace = $namespace ?: 'public';
        return $this->setNamespaceId($this->getNamespaceIdByNamespace($this->namespace));
    }

    protected function getNamespaceIdByNamespace(string $namespace): string
    {
        if ($namespace === 'public') {
            return '';
        }

        try {
            $response = $this->nacosClient->request(new NamespaceListRequest());
            if ($response->getResponse()->getStatusCode() != 200) {
                return $namespace;
            }
            $contents = $response->response();
            foreach ($contents['data'] ?? [] as $item) {
                if ($item['namespaceShowName'] == $namespace) {
                    $namespace = $item['namespace'];
                    break;
                }
            }
        } catch (\Throwable $e) {
            // I tried my best. When the program throws an error 🤪
        }

        return $namespace;
    }

    /**
     * @return string
     */
    public function getNamespaceId(): string
    {
        return $this->namespaceId;
    }

    /**
     * @param string $namespaceId
     *
     * @return static
     */
    public function setNamespaceId(string $namespaceId): static
    {
        $this->namespaceId = $namespaceId;
        return $this;
    }

    /**
     * @param CacheItemPoolInterface $cache
     *
     * @return static
     */
    public function withCache(CacheItemPoolInterface $cache): static
    {
        $this->nacosConfig->setCache($this->cache = $cache);
        return $this;
    }

    /**
     * @param ClientInterface $client
     *
     * @return static
     */
    public function withClient(ClientInterface $client): static
    {
        $this->nacosClient->setClient($this->client = $client);
        return $this;
    }

    /**
     * @param LoggerInterface $logger
     *
     * @return static
     */
    public function withLogger(LoggerInterface $logger): static
    {
        $this->nacosClient->setLogger($this->logger = $logger);
        return $this;
    }

    /**
     * 命名空间 注入，发送请求后统一响应
     *
     * @param NacosRequestResponseInterface $request
     *
     * @return NacosResponseInterface
     */
    abstract public function execute(NacosRequestResponseInterface $request): NacosResponseInterface;

}
