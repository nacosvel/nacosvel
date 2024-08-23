<?php

namespace Nacosvel\Nacos\Contracts;

use Psr\Cache\CacheItemPoolInterface;

interface NacosRequestInterface
{
    public function getConfig(): NacosConfigInterface;

    public function setConfig(array|NacosConfigInterface $config): static;

    public function getAuth(): NacosAuthInterface;

    public function setAuth(NacosAuthInterface|null $auth): static;

    public function getCache(): CacheItemPoolInterface;

    public function setCache(CacheItemPoolInterface|null $cache): static;

}
