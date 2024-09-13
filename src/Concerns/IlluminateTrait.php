<?php

namespace Nacosvel\Helper\Concerns;

trait IlluminateTrait
{
    /**
     * Call the given Closure with the given value then return the value.
     *
     * @template TValue
     *
     * @param TValue                         $value
     * @param (callable(TValue): mixed)|null $callback
     *
     * @return TValue
     */
    public static function tap($value, callable $callback = null)
    {
        if (is_null($callback)) {
            return new HigherOrderTapProxy($value);
        }

        $callback($value);

        return $value;
    }

    /**
     * Return the given value, optionally passed through the given callback.
     *
     * @template TValue
     * @template TReturn
     *
     * @param TValue                             $value
     * @param (callable(TValue): (TReturn))|null $callback
     *
     * @return ($callback is null ? TValue : TReturn)
     */
    public static function with($value, callable $callback = null)
    {
        return is_null($callback) ? $value : $callback($value);
    }

}
