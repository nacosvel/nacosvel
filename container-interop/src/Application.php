<?php

namespace Nacosvel\Container\Interop;

use Closure;
use Nacosvel\Container\Interop\Contracts\ApplicationInterface;
use Psr\Container\ContainerInterface;

/**
 * @template T of ContainerInterface
 */
class Application implements ApplicationInterface
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
     * @param string              $abstract
     * @param Closure|string|null $concrete
     *
     * @return static
     */
    public function bind(string $abstract, Closure|string|null $concrete = null): static
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
     * @template S of object
     * @param string|class-string<S>|mixed $abstract
     * @param array                        $parameters
     *
     * @return S|mixed
     */
    public function make(mixed $abstract, array $parameters = []): mixed
    {
        return call_user_func($this->make, $abstract, $parameters);
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
     * @param Closure|string $abstract
     * @param Closure|null   $callback
     *
     * @return static
     */
    public function resolving(Closure|string $abstract, Closure $callback = null): static
    {
        return (function ($abstract, $callback) {
            call_user_func($this->resolving, $abstract, $callback);
            return $this;
        })($abstract, $callback);
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
