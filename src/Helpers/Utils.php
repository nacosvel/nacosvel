<?php

namespace Nacosvel\Helpers\Utils;

/**
 * Parse the URL-encoded query string into an associative array.
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
