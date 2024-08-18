<?php

namespace Nacosvel\Utils\Support;

use RuntimeException;

abstract class Facade
{
    /**
     * The resolved object instances.
     *
     * @var array
     */
    protected static array $resolvedInstance = [];

    /**
     * Indicates if the resolved instance should be cached.
     *
     * @var bool
     */
    protected static bool $cached = true;

    protected function __construct()
    {
        //
    }

    /**
     * Get the root object behind the facade.
     *
     * @return mixed
     */
    public static function getFacadeRoot(): mixed
    {
        return static::resolveFacadeInstance(static::getFacadeAccessor());
    }

    /**
     * Get the registered name of the component.
     *
     * @return string
     *
     * @throws RuntimeException
     */
    abstract protected static function getFacadeAccessor(): string;

    /**
     * Resolve the facade root instance from the container.
     *
     * @param string $name
     *
     * @return mixed
     */
    protected static function resolveFacadeInstance(string $name): mixed
    {
        if (isset(static::$resolvedInstance[$name])) {
            return static::$resolvedInstance[$name];
        }

        if (static::$cached) {
            return static::$resolvedInstance[$name] = static::getFacadeInstance();
        }

        return static::$resolvedInstance[$name];
    }

    /**
     * Get or create the facade instance.
     *
     * @return mixed
     */
    abstract protected static function getFacadeInstance(): mixed;

    /**
     * Clear a resolved facade instance.
     *
     * @param string $name
     *
     * @return void
     */
    public static function clearResolvedInstance(string $name): void
    {
        unset(static::$resolvedInstance[$name]);
    }

    /**
     * Clear all resolved instances.
     *
     * @return void
     */
    public static function clearResolvedInstances(): void
    {
        static::$resolvedInstance = [];
    }

    /**
     * Handle dynamic, static calls to the object.
     *
     * @param string $method
     * @param array  $arguments
     *
     * @return mixed
     */
    public static function __callStatic(mixed $method, array $arguments)
    {
        $instance = static::getFacadeRoot();

        if (!$instance) {
            throw new RuntimeException('A facade root has not been set.');
        }

        return $instance->$method(...$arguments);
    }

}
