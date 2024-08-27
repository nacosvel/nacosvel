<?php

namespace Nacosvel\Nacos;

use Nacosvel\Nacos\Concerns\NacosRequestTrait;
use Nacosvel\Nacos\Contracts\NacosAuthInterface;
use Nacosvel\Nacos\Contracts\NacosRequestInterface;
use Nacosvel\Nacos\Contracts\NacosUriInterface;
use Psr\Cache\CacheItemPoolInterface;

class NacosRequest implements NacosRequestInterface
{
    use NacosRequestTrait;

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
