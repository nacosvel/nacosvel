<?php

namespace Nacosvel\Nacos\Contracts;

use Iterator;
use Psr\Http\Message\UriInterface;

interface NacosConfigInterface extends Iterator
{
    public function toArray(): array;

    public function getUri(bool $withUser = true): UriInterface;

}
