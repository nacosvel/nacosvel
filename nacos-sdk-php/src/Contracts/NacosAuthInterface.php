<?php

namespace Nacosvel\Nacos\Contracts;

interface NacosAuthInterface
{
    public function getUsername(): ?string;

    public function setUsername(?string $username): static;

    public function getPassword(): ?string;

    public function setPassword(?string $password): static;

    public function getAccessToken(NacosClientInterface $client): bool;

}
