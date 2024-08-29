<?php

namespace Nacosvel\NacosClient\Contracts;

use GuzzleHttp\ClientInterface;
use Psr\Cache\CacheItemPoolInterface;
use Psr\Log\LoggerInterface;

interface NacosServiceInterface
{
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

}
