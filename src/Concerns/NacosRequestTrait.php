<?php

namespace Nacosvel\Nacos\Concerns;

use GuzzleHttp\ClientInterface;
use Nacosvel\Nacos\Contracts\NacosAuthInterface;
use Nacosvel\Nacos\Contracts\NacosConfigInterface;
use Nacosvel\Nacos\NacosAuth;
use Nacosvel\Nacos\NacosConfig;
use Nacosvel\OpenHttp\Builder;
use Nacosvel\OpenHttp\Contracts\ChainableInterface;
use Psr\Cache\CacheItemPoolInterface;
use Symfony\Component\Cache\Adapter\FilesystemAdapter;

trait NacosRequestTrait
{
    public function getClient(): ChainableInterface
    {
        return $this->client;
    }

    public function setClient(ChainableInterface|ClientInterface|null $client): static
    {
        if ($client instanceof ClientInterface) {
            $client = call_user_func(function (ChainableInterface $factory, ClientInterface $client) {
                $factory->getClient()->setRequestClient($client);
                return $factory;
            }, Builder::factory(), $client);
        }

        if (is_null($client)) {
            $client = Builder::factory();
        }

        $this->client = $client;

        return $this;
    }

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
