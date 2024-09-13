<?php

namespace Nacosvel\Helper;

use Nacosvel\Helper\Concerns\ArrayTrait;
use Nacosvel\Helper\Concerns\IlluminateTrait;
use Nacosvel\Helper\Concerns\URLTrait;

final class Utils
{
    use ArrayTrait, IlluminateTrait, URLTrait;

    /**
     * Get hashCode for give string
     *
     * @param string $data
     *
     * @return int
     */
    public static function hashCode(string $data): int
    {
        return hexdec(hash('crc32', $data));
    }

}
