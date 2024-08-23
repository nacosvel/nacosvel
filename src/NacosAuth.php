<?php

namespace Nacosvel\Nacos;

use Nacosvel\Nacos\Concerns\NacosAuthTrait;
use Nacosvel\Nacos\Contracts\NacosAuthInterface;

class NacosAuth implements NacosAuthInterface
{
    use NacosAuthTrait;

    public function __construct(protected ?string $username = null, protected ?string $password = null)
    {
        //
    }

    public function __invoke(callable $handler): callable
    {
        return $handler;
    }

}
