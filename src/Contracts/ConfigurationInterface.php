<?php

namespace Nacosvel\Feign\Contracts;

use Nacosvel\Interop\Container\Contracts\NacosvelInterface;

interface ConfigurationInterface
{
    public function register(NacosvelInterface $factory): void;

    public function boot(NacosvelInterface $factory): void;

}
