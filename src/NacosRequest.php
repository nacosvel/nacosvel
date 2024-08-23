<?php

namespace Nacosvel\Nacos;

use Nacosvel\Nacos\Concerns\NacosRequestTrait;
use Nacosvel\Nacos\Contracts\NacosAuthInterface;
use Nacosvel\Nacos\Contracts\NacosRequestInterface;
use Nacosvel\Nacos\Contracts\NacosConfigInterface;
use Psr\Cache\CacheItemPoolInterface;

class NacosRequest implements NacosRequestInterface
{
    use NacosRequestTrait;

    public function __construct(
        protected NacosConfigInterface|array  $config,
        protected NacosAuthInterface|null     $auth = null,
        protected CacheItemPoolInterface|null $cache = null,
    )
    {
        $this->setConfig($config);
        $this->setAuth($auth);
        $this->setCache($cache);
    }

}
