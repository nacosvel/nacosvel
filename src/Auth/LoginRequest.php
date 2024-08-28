<?php

namespace Nacosvel\NacosClient\Auth;

use Nacosvel\Nacos\NacosRequest;
use Nacosvel\NacosClient\Contracts\Auth\LoginInterface;

class LoginRequest extends NacosRequest implements LoginInterface
{
    /**
     * Default Version
     *
     * @var string
     */
    protected string $version = 'v1';

    /**
     * Request Uri
     *
     * @var array|string
     */
    protected array|string $uri = '/nacos/v1/auth/login';

    public function v1(string $username, string $password): LoginInterface
    {
        return $this->setUsername($username)->setPassword($password);
    }

    protected string $username;
    protected string $password;

    /**
     * @return string
     */
    public function getUsername(): string
    {
        return $this->username;
    }

    /**
     * @param string $username
     *
     * @return static
     */
    public function setUsername(string $username): static
    {
        $this->username = $username;
        return $this;
    }

    /**
     * @return string
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    /**
     * @param string $password
     *
     * @return static
     */
    public function setPassword(string $password): static
    {
        $this->password = $password;
        return $this;
    }

}
