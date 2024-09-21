<?php

namespace Nacosvel\Feign\Contracts;

use ArrayAccess;

interface TransformationInterface extends ArrayAccess
{
    /**
     * Get value for an offset
     * This function is an alias of:offsetGet
     *
     * @template T of static
     *
     * @param string|int|null $key
     * @param null            $default
     *
     * @return T
     */
    public function get(string|int $key = null, $default = null);

    /**
     * Get array copy
     * This function is an alias of:getArrayCopy
     *
     * @return array
     */
    public function convertToArray(): array;

}
