<?php

namespace Nacosvel\Nacos\Concerns;

use Nacosvel\Nacos\Contracts\NacosAuthInterface;
use Nacosvel\Nacos\Contracts\NacosUriInterface;
use Nacosvel\Nacos\NacosAuth;
use Nacosvel\Nacos\NacosUri;
use Psr\Cache\CacheItemPoolInterface;
use Symfony\Component\Cache\Adapter\FilesystemAdapter;

trait NacosConfigTrait
{
    public function getNacosUri(): NacosUriInterface
    {
        return $this->uri;
    }

    public function setNacosUri(string|array|NacosUriInterface $uri): static
    {
        if (is_string($uri)) {
            $uri = explode(',', $uri);
        }

        if (is_array($uri)) {
            $uri = new NacosUri($uri);
        }

        $this->uri = $uri;

        return $this;
    }

    public function getNacosAuth(): NacosAuthInterface
    {
        return $this->auth;
    }

    public function setNacosAuth(NacosAuthInterface|null $auth): static
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
