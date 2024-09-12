<?php

namespace Nacosvel\Container\Interop;

use Nacosvel\Container\Interop\Contracts\ApplicationInterface;

if (!function_exists('Nacosvel\Container\Interop\application')) {
    /**
     * Get the available container instance.
     *
     * @template T of object
     *
     * @param class-string<T>|mixed $abstract
     * @param array                 $parameters
     *
     * @return ($abstract is null ? ApplicationInterface : ($abstract is class-string<T> ? T : mixed))
     */
    function application(mixed $abstract = null, array $parameters = []): mixed
    {
        if (is_null($abstract)) {
            return Application::getInstance();
        }

        return Application::getInstance()->make($abstract, $parameters);
    }
}
