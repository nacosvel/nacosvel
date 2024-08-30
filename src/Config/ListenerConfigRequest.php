<?php

namespace Nacosvel\NacosClient\Config;

use Nacosvel\NacosClient\Contracts\Config\ListenerConfigInterface;
use Nacosvel\NacosClient\NacosRequestResponse;

class ListenerConfigRequest extends NacosRequestResponse implements ListenerConfigInterface
{
    /**
     * Default Version
     *
     * @var string
     */
    protected string $version = 'v1';

    /**
     * Request Uri
     *
     * @var array|string
     */
    protected array|string $uri = '/nacos/v1/cs/configs/listener';
}
