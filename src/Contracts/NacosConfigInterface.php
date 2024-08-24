<?php

namespace Nacosvel\Nacos\Contracts;

use Iterator;

interface NacosConfigInterface extends Iterator
{
    public function toArray(): array;

    public function getUri(): string;

}
