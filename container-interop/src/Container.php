<?php

namespace Nacosvel\Container\Interop;

use Nacosvel\Container\Interop\Contracts\ApplicationInterface;

if (!function_exists('Nacosvel\Container\Interop\application')) {
    /**
     * Get the available container instance.
     *
     * @template T of object
     *
     * @param string|class-string<T>|mixed $abstract The interface or class name.
     * @param array                        $parameters
     *
     * @return ApplicationInterface|T An instance implementing the given interface or container instance.
     */
    function application(mixed $abstract = null, array $parameters = []): mixed
    {
        if (is_null($abstract)) {
            return Application::getInstance();
        }

        return Application::getInstance()->make($abstract, $parameters);
    }
}
