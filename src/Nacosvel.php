<?php

namespace Nacosvel\Interop\Container;

use Closure;
use Nacosvel\Interop\Container\Contracts\NacosvelInterface;
use Psr\Container\ContainerInterface;

/**
 * @template T of ContainerInterface
 */
class Nacosvel implements NacosvelInterface
{
    private static ?self $instance = null;

    /**
     * @return self
     */
    public static function getInstance(): self
    {
        if (self::$instance === null) {
            self::$instance = new self();
        }

        return self::$instance;
    }

    /**
     * @var ContainerInterface<T>
     */
    protected ContainerInterface $container;
    protected Closure            $bind;
    protected Closure            $make;
    protected Closure            $resolving;

    /**
     * @return ContainerInterface<T>
     */
    public function getContainer(): ContainerInterface
    {
        return $this->container;
    }

    /**
     * @param ContainerInterface<T> $container
     *
     * @return static
     */
    public function setContainer(ContainerInterface $container): static
    {
        $this->container = $container;
        return $this;
    }

    /**
     * @param mixed $abstract
     * @param null  $concrete
     *
     * @return static
     */
    public function bind(mixed $abstract, $concrete = null): static
    {
        return (function ($abstract, $concrete) {
            call_user_func($this->bind, $abstract, $concrete);
            return $this;
        })($abstract, $concrete);
    }

    /**
     * @param Closure $bind
     *
     * @return static
     */
    public function setBind(Closure $bind): static
    {
        $this->bind = $bind;
        return $this;
    }

    /**
     * @param mixed $abstract
     * @param null  $concrete
     *
     * @return static
     */
    public function make(mixed $abstract, $concrete = null): static
    {
        return (function ($abstract, $concrete) {
            call_user_func($this->make, $abstract, $concrete);
            return $this;
        })($abstract, $concrete);
    }

    /**
     * @param Closure $make
     *
     * @return static
     */
    public function setMake(Closure $make): static
    {
        $this->make = $make;
        return $this;
    }

    /**
     * @param mixed $abstract
     * @param null  $concrete
     *
     * @return static
     */
    public function resolving(mixed $abstract, $concrete = null): static
    {
        return (function ($abstract, $concrete) {
            call_user_func($this->resolving, $abstract, $concrete);
            return $this;
        })($abstract, $concrete);
    }

    /**
     * @param Closure $resolving
     *
     * @return static
     */
    public function setResolving(Closure $resolving): static
    {
        $this->resolving = $resolving;
        return $this;
    }

    private function __construct()
    {
        //
    }

    private function __clone()
    {
        //
    }

}
