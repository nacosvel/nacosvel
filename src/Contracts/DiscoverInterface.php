<?php

namespace Nacosvel\Container\Interop\Contracts;

use Psr\Container\ContainerInterface;

interface DiscoverInterface
{
    public static function container(
        ?ContainerInterface $container = null,
        callable|string     $bind = 'bind',
        callable|string     $make = 'make',
        callable|string     $resolving = 'resolving'
    ): ApplicationInterface;

}
