<?php

namespace Nacosvel\Nacos\Contracts;

use Iterator;
use Psr\Http\Message\UriInterface;

interface NacosUriInterface extends Iterator
{
    public function getUri(bool $withUser = true): UriInterface;

}
