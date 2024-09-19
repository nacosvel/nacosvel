<?php

namespace Nacosvel\Container\Interop\Contracts;

use Closure;
use Psr\Container\ContainerInterface;

/**
 * @template T of ContainerInterface
 */
interface ApplicationInterface
{
    public static function getInstance(): self;

    /**
     * @return ContainerInterface<T>
     */
    public function getContainer(): ContainerInterface;

    /**
     * @param ContainerInterface<T> $container
     *
     * @return static
     */
    public function setContainer(ContainerInterface $container): static;

    /**
     * @param string              $abstract
     * @param Closure|string|null $concrete
     *
     * @return static
     */
    public function bind(string $abstract, Closure|string|null $concrete = null): static;

    /**
     * @param Closure $bind
     *
     * @return static
     */
    public function setBind(Closure $bind): static;

    /**
     * @template S of object
     * @param string|class-string<S>|mixed $abstract
     * @param array                        $parameters
     *
     * @return S|mixed
     */
    public function make(mixed $abstract, array $parameters = []): mixed;

    /**
     * @param Closure $make
     *
     * @return static
     */
    public function setMake(Closure $make): static;

    /**
     * @param Closure|string $abstract
     * @param Closure|null   $callback
     *
     * @return static
     */
    public function resolving(Closure|string $abstract, Closure $callback = null): static;

    /**
     * @param Closure $resolving
     *
     * @return static
     */
    public function setResolving(Closure $resolving): static;

}
