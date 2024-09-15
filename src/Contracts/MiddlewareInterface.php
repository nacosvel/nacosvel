<?php

namespace Nacosvel\Feign\Contracts;

interface MiddlewareInterface
{
    public function __invoke(callable $handler): callable;

}
