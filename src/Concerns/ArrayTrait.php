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

}
