<?php

namespace Nacosvel\Helper\Concerns;

trait ArrayTrait
{
    /**
     * The tests whether at least one element in the array passes the test implemented by the provided function.
     *
     * @param array    $array
     * @param callable $callback
     *
     * @return bool
     */
    public static function array_some(array $array, callable $callback): bool
    {
        foreach ($array as $key => $value) {
            if ($callback($value, $key)) {
                return true;
            }
        }
        return false;
    }

    /**
     * The method tests whether all elements in the array pass the test implemented by the provided function.
     *
     * @param array    $array
     * @param callable $callback
     *
     * @return bool
     */
    public static function array_every(array $array, callable $callback): bool
    {
        foreach ($array as $key => $value) {
            if (!$callback($value, $key)) {
                return false;
            }
        }
        return true;
    }

    /**
     * @template ReturnValue
     * @param mixed                         $data
     * @param (callable():ReturnValue)|null $target
     *
     * @return ReturnValue|mixed
     */
    public static function array_replicate(mixed $data, callable $target = null): mixed
    {
        if (!is_array($data)) {
            return $data;
        }
        $result = is_callable($target) ? call_user_func($target) : [];
        foreach ($data as $k => $v) {
            $result[$k] = is_array($data) ? self::array_replicate($v, $target) : $v;
        }
        return $result;
    }

    /**
     * Run an associative map over each of the items.
     * The callback should return an associative array with a single key/value pair.
     *
     * @param callable $callback
     * @param array    $iterables
     *
     * @return array
     */
    public static function mapWithKeys(callable $callback, array $iterables): array
    {
        $result = [];
        foreach ($iterables as $key => $value) {
            if (!is_array($assoc = $callback($value, $key))) {
                continue;
            }
            foreach ($assoc as $mapKey => $mapValue) {
                $result[$mapKey] = $mapValue;
            }
        }
        return $result;
    }

    /**
     * Flatten a multi-dimensional array into a single level.
     *
     * @param array $iterables
     * @param float $depth
     *
     * @return array
     */
    public static function array_flatten(array $iterables = [], float $depth = PHP_INT_MAX): array
    {
        $result = [];
        foreach ($iterables as $iterable) {
            if (!is_array($iterable)) {
                $result[] = $iterable;
            } else {
                $values = $depth === 1 ? array_values($iterable) : static::array_flatten($iterable, $depth - 1);
                foreach ($values as $value) {
                    $result[] = $value;
                }
            }
        }
        return $result;
    }

}
