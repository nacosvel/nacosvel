<?php

namespace Nacosvel\Feign\Configuration;

use Nacosvel\Feign\Contracts\ConfigurationInterface;
use Nacosvel\Feign\Contracts\FeignInterface;
use Nacosvel\Feign\Support\RequestMethod;

abstract class Configuration implements ConfigurationInterface
{
    protected string $defaultMethod = RequestMethod::POST;

    final public function register(FeignInterface $factory): void
    {
        $factory->bind(ConfigurationInterface::class, function () {
            return $this;
        });

        if (method_exists(static::class, 'boot')) {
            $this->boot($factory);
        }
    }

    abstract public function boot(FeignInterface $factory): void;

}
