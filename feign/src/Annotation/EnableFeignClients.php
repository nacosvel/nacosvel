<?php

namespace Nacosvel\Feign\Annotation;

use Attribute;
use Nacosvel\Feign\Contracts\ConfigurationInterface;
use Nacosvel\Feign\FeignConfiguration;

#[Attribute(Attribute::TARGET_CLASS)]
class EnableFeignClients
{
    public function __construct(
        protected string $value = FeignConfiguration::class,
    )
    {
        if (false === class_exists($value) ||
            false === is_subclass_of($value, ConfigurationInterface::class)) {
            $this->value = FeignConfiguration::class;
        }
    }

    public function __invoke(): ConfigurationInterface
    {
        return new $this->value();
    }

}
