<?php

namespace Nacosvel\Feign\Concerns;

trait StrToArrayTrait
{
    protected function parseStrToArray(string $string = ''): array
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
