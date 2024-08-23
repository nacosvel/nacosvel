<?php

namespace Nacosvel\Nacos;

use GuzzleHttp\ClientInterface;
use Nacosvel\Nacos\Concerns\NacosRequestTrait;
use Nacosvel\Nacos\Contracts\NacosAuthInterface;
use Nacosvel\Nacos\Contracts\NacosRequestInterface;
use Nacosvel\Nacos\Contracts\NacosConfigInterface;
use Nacosvel\OpenHttp\Contracts\ChainableInterface;
use Psr\Cache\CacheItemPoolInterface;

class NacosRequest implements NacosRequestInterface
{
    use NacosRequestTrait;

    public function __construct(
        protected ChainableInterface|ClientInterface|null $client = null,
        protected NacosConfigInterface|array              $config = [],
        protected ?NacosAuthInterface                     $auth = null,
        protected CacheItemPoolInterface|null             $cache = null
    )
    {
        $this->setClient($client);
        $this->setConfig($config);
        $this->setAuth($auth);
        $this->setCache($cache);
    }


}
