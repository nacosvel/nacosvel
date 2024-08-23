<?php

namespace Nacosvel\Nacos\Concerns;

use Nacosvel\Nacos\Contracts\NacosAuthInterface;
use Nacosvel\Nacos\Contracts\NacosConfigInterface;
use Nacosvel\Nacos\NacosAuth;
use Nacosvel\Nacos\NacosConfig;
use Psr\Cache\CacheItemPoolInterface;
use Symfony\Component\Cache\Adapter\FilesystemAdapter;

trait NacosRequestTrait
{
    public function getConfig(): NacosConfigInterface
    {
        return $this->config;
    }

    public function setConfig(array|NacosConfigInterface $config): static
    {
        if (is_array($config)) {
            $config = new NacosConfig($config);
        }

        $this->config = $config;

        return $this;
    }

    public function getAuth(): NacosAuthInterface
    {
        return $this->auth;
    }

    public function setAuth(NacosAuthInterface|null $auth): static
    {
        if (is_null($auth)) {
            $auth = new NacosAuth();
        }

        $this->auth = $auth;

        return $this;
    }

    public function getCache(): CacheItemPoolInterface
    {
        return $this->cache;
    }

    public function setCache(CacheItemPoolInterface|null $cache): static
    {
        if (is_null($cache)) {
            $cache = new FilesystemAdapter('nacosvel.nacos');
        }

        $this->cache = $cache;

        return $this;
    }

}
