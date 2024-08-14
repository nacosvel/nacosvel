<?php

use Nacosvel\Utils\Concerns\HigherOrderTapProxy;

if (!function_exists('tap')) {
    /**
     * Call the given Closure with the given value then return the value.
     *
     * @template TValue
     *
     * @param TValue                          $value
     * @param (callable(TValue): TValue)|null $callback
     *
     * @return TValue
     */
    function tap($value, callable $callback = null)
    {
        if (is_null($callback)) {
            return new HigherOrderTapProxy($value);
        }

        $callback($value);

        return $value;
    }
}

if (!function_exists('with')) {
    /**
     * Return the given value, optionally passed through the given callback.
     *
     * @template TValue
     *
     * @param TValue                          $value
     * @param (callable(TValue): TValue)|null $callback
     *
     * @return TValue
     */
    function with($value, callable $callback = null)
    {
        return is_null($callback) ? $value : $callback($value);
    }
}
