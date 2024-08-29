<?php

namespace Nacosvel\NacosClient\Auth;

use Nacosvel\NacosClient\Contracts\Auth\LoginInterface;
use Nacosvel\NacosClient\NacosRequestResponse;

class LoginRequest extends NacosRequestResponse implements LoginInterface
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
        return $this->parameter('username', $this->username = $username);
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
        return $this->parameter('password', $this->password = $password);
    }

}
