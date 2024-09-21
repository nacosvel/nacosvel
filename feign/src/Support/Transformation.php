<?php

namespace Nacosvel\Feign\Support;

use ArrayIterator;
use Nacosvel\Feign\Contracts\TransformationInterface;

class Transformation extends ArrayIterator implements TransformationInterface
{
    public function __construct(array $array = [])
    {
        parent::__construct($array);
    }

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
    public function get(string|int $key = null, $default = null)
    {
        if (is_null($key)) {
            return $this->getArrayCopy();
        }
        return array_reduce(explode('.', $key), function ($carry, $key) {
            if (is_null($carry) || !$carry->offsetExists($key)) {
                return null;
            }
            return $carry->offsetGet($key);
        }, $this) ?? $default;
    }

    /**
     * Get array copy
     * This function is an alias of:getArrayCopy
     *
     * @return array
     */
    public function convertToArray(): array
    {
        return $this->getArrayCopy();
    }

}
