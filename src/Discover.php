<?php

namespace Nacosvel\Interop\Container;

use InvalidArgumentException;
use Nacosvel\Interop\Container\Contracts\DiscoverInterface;
use Nacosvel\Interop\Container\Contracts\NacosvelInterface;
use Psr\Container\ContainerInterface;
use Psr\Container\NotFoundExceptionInterface;

class Discover extends Nacosvel implements DiscoverInterface
{
    public static function container(
        ?ContainerInterface $container = null,
        callable|string     $bind = 'bind',
        callable|string     $make = 'make',
        callable|string     $resolving = 'resolving'
    ): NacosvelInterface
    {
        $container = is_null($container) ? self::builder() : $container;

        $callable = function ($callable) use ($container) {
            return is_string($callable) ? function ($abstract, $concrete) use ($container, $callable) {
                return call_user_func([$container, $callable], $abstract, $concrete);
            } : $callable;
        };

        return self::getInstance()
            ->setContainer($container)
            ->setBind($callable($bind))
            ->setMake($callable($make))
            ->setResolving($callable($resolving));
    }

    protected static function builder(): ContainerInterface
    {
        foreach (debug_backtrace() as $backtrace) {
            if (class_exists($class = $backtrace['class'] ?? '') && is_subclass_of($class, ContainerInterface::class)) {
                return $backtrace['object'];
            }
        }

        throw new class('No container instance implementing the Psr\Container\ContainerInterface interface was found.') extends InvalidArgumentException implements NotFoundExceptionInterface {
        };
    }

}
