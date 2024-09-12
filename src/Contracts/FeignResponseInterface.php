<?php

namespace Nacosvel\Feign\Contracts;

interface FeignResponseInterface
{
    public function __invoke(array $returnTypes): void;

    public function __call(string $name, array $arguments);

    // public function getRawContents(): string;
    //
    // public function getOriginalResponse(): ResponseInterface;
    //
    // public function toArray(): array;

}
