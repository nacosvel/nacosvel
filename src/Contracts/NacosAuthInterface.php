<?php

namespace Nacosvel\Nacos\Contracts;

interface NacosAuthInterface
{
    public function __invoke(callable $handler): callable;

    public function getUsername(): ?string;

    public function setUsername(?string $username): static;

    public function getPassword(): ?string;

    public function setPassword(?string $password): static;

}
