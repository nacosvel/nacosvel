<?php

namespace Nacosvel\Feign\Contracts;

interface FeignResponseInterface
{
    public function __invoke(RequestTemplateInterface $requestTemplate): void;

    public function __call(string $name, array $arguments);

}
