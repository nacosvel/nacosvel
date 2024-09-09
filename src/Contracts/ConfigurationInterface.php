<?php

namespace Nacosvel\Feign\Contracts;

interface ConfigurationInterface
{
    public function register(FeignInterface $factory): void;

    public function boot(FeignInterface $factory): void;

}
