<?php

namespace Nacosvel\Container\Interop;

use InvalidArgumentException;
use Nacosvel\Container\Interop\Contracts\DiscoverInterface;
use Nacosvel\Container\Interop\Contracts\ApplicationInterface;
use Psr\Container\ContainerInterface;
use Psr\Container\NotFoundExceptionInterface;

class Discover extends Application implements DiscoverInterface
{
    public static function container(
        ?ContainerInterface $container = null,
        callable|string     $bind = 'bind',
        callable|string     $make = 'make',
        callable|string     $resolving = 'resolving'
    ): ApplicationInterface
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
