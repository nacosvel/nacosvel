<?php

namespace Nacosvel\Nacos;

use Nacosvel\Nacos\Concerns\NacosConfigTrait;
use Nacosvel\Nacos\Contracts\NacosAuthInterface;
use Nacosvel\Nacos\Contracts\NacosConfigInterface;
use Nacosvel\Nacos\Contracts\NacosUriInterface;
use Psr\Cache\CacheItemPoolInterface;

class NacosConfig implements NacosConfigInterface
{
    use NacosConfigTrait;

    public function __construct(
        protected NacosUriInterface|array|string $uri,
        protected NacosAuthInterface|null        $auth = null,
        protected CacheItemPoolInterface|null    $cache = null,
    )
    {
        $this->setNacosUri($uri);
        $this->setNacosAuth($auth);
        $this->setCache($cache);
    }

}
