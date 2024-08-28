<?php

namespace Nacosvel\NacosClient\Contracts\Auth;

use Nacosvel\NacosClient\Contracts\VersionInterface;

interface LoginInterface extends VersionInterface
{
    /**
     * @return string
     */
    public function getUsername(): string;

    /**
     * @param string $username
     *
     * @return static
     */
    public function setUsername(string $username): static;

    /**
     * @return string
     */
    public function getPassword(): string;

    /**
     * @param string $password
     *
     * @return static
     */
    public function setPassword(string $password): static;

}
