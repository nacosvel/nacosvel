<?php

namespace Nacosvel\Feign\Contracts;

interface ReflectiveInterface
{
    public function __call(string $name, array $arguments): FeignResponseInterface;

}
