<?php

namespace Nacosvel\Feign\Annotation;

use Attribute;
use Nacosvel\Feign\Contracts\ConfigurationInterface;
use Nacosvel\Feign\FeignClientsConfiguration;

#[Attribute(Attribute::TARGET_CLASS)]
class EnableFeignClients
{
    public function __construct(
        protected string $configurationCLass = FeignClientsConfiguration::class,
    )
    {
        if (false === class_exists($this->configurationCLass) ||
            false === is_subclass_of($this->configurationCLass, ConfigurationInterface::class)) {
            $this->configurationCLass = FeignClientsConfiguration::class;
        }
    }

    public function getInstance(): ConfigurationInterface
    {
        return new $this->configurationCLass();
    }

}
