<?php

namespace Nacosvel\Helper;

if (!function_exists('Nacosvel\Helper\http_parse_query')) {
    /**
     * Parse the URL-encoded query string into an associative array.
     *
     * @description the `http_build_query()` reverse conversion function
     *
     * @param string $string
     *
     * @return array
     */
    function http_parse_query(string $string = ''): array
    {
        $response = json_decode($string, true);
        if (json_last_error() != JSON_ERROR_NONE) {
            $response = (function ($string) {
                parse_str($string, $response);
                return $response;
            })($string);
        }
        return $response ?: [];
    }
}

if (!function_exists('Nacosvel\Helper\array_some')) {
    /**
     * The tests whether at least one element in the array passes the test implemented by the provided function.
     *
     * @param array    $array
     * @param callable $callback
     *
     * @return bool
     */
    function array_some(array $array, callable $callback): bool
    {
        foreach ($array as $key => $value) {
            if ($callback($value, $key)) {
                return true;
            }
        }
        return false;
    }
}

if (!function_exists('Nacosvel\Helper\array_every')) {
    /**
     * The method tests whether all elements in the array pass the test implemented by the provided function.
     *
     * @param array    $array
     * @param callable $callback
     *
     * @return bool
     */
    function array_every(array $array, callable $callback): bool
    {
        foreach ($array as $key => $value) {
            if (!$callback($value, $key)) {
                return false;
            }
        }
        return true;
    }
}

if (!function_exists('Nacosvel\Helper\array_replicate')) {
    /**
     * @template ReturnValue
     * @param mixed                         $data
     * @param (callable():ReturnValue)|null $target
     *
     * @return ReturnValue|mixed
     */
    function array_replicate(mixed $data, callable $target = null): mixed
    {
        if (!is_array($data)) {
            return $data;
        }
        $result = is_callable($target) ? call_user_func($target) : [];
        foreach ($data as $k => $v) {
            $result[$k] = is_array($data) ? array_replicate($v, $target) : $v;
        }
        return $result;
    }
}
