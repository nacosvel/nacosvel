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
     * @param mixed $abstract
     * @param null  $concrete
     *
     * @return static
     */
    public function bind(mixed $abstract, $concrete = null): static;

    /**
     * @param Closure $bind
     *
     * @return static
     */
    public function setBind(Closure $bind): static;

    /**
     * @param mixed $abstract
     * @param null  $concrete
     *
     * @return mixed
     */
    public function make(mixed $abstract, $concrete = null): mixed;

    /**
     * @param Closure $make
     *
     * @return static
     */
    public function setMake(Closure $make): static;

    /**
     * @param mixed $abstract
     * @param null  $concrete
     *
     * @return static
     */
    public function resolving(mixed $abstract, $concrete = null): static;

    /**
     * @param Closure $resolving
     *
     * @return static
     */
    public function setResolving(Closure $resolving): static;

}
