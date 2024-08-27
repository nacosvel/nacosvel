<?php

namespace Nacosvel\Nacos\Contracts;

use Psr\Cache\CacheItemPoolInterface;

interface NacosRequestInterface
{
    public function getNacosUri(): NacosUriInterface;

    public function setNacosUri(string|array|NacosUriInterface $uri): static;

    public function getNacosAuth(): NacosAuthInterface;

    public function setNacosAuth(NacosAuthInterface|null $auth): static;

    public function getCache(): CacheItemPoolInterface;

    public function setCache(CacheItemPoolInterface|null $cache): static;

}
