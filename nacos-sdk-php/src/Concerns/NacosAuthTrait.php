<?php

namespace Nacosvel\Nacos\Concerns;

use Nacosvel\Nacos\Contracts\NacosClientInterface;

trait NacosAuthTrait
{
    public function getUsername(): ?string
    {
        return $this->username;
    }

    public function setUsername(?string $username): static
    {
        $this->username = $username;
        return $this;
    }

    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function setPassword(?string $password): static
    {
        $this->password = $password;
        return $this;
    }

    abstract public function getAccessToken(NacosClientInterface $client): bool;

}
