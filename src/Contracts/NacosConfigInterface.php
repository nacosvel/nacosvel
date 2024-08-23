<?php

namespace Nacosvel\Nacos\Contracts;

interface NacosConfigInterface
{
    public function toArray(): array;

    public function getUri(): string;

}
