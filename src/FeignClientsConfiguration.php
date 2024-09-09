<?php

namespace Nacosvel\Feign;

use Nacosvel\Feign\Configuration\Configuration;
use Nacosvel\Feign\Contracts\ConfigurationInterface;
use Nacosvel\Feign\Contracts\FeignInterface;

class FeignClientsConfiguration extends Configuration implements ConfigurationInterface
{
    public function boot(FeignInterface $factory): void
    {
        //
    }

}
