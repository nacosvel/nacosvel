<?php

namespace Nacosvel\Nacos\Contracts;

interface NacosRequestInterface extends Arrayable
{
    public const GET    = 'GET';
    public const POST   = 'POST';
    public const PUT    = 'PUT';
    public const DELETE = 'DELETE';

    /**
     * Get Version
     *
     * @return string
     */
    public function getVersion(): string;

    /**
     * Set Version
     *
     * @param string $version
     *
     * @return static
     */
    public function setVersion(string $version): static;

    /**
     * Get Method
     *
     * @return string
     */
    public function getMethod(): string;

    /**
     * Get Uri
     *
     * @return string
     */
    public function getUri(): string;

    /**
     * Set Option
     *
     * @param string $field
     * @param array  $options
     *
     * @return static
     */
    public function setOption(string $field, mixed $options): static;

    /**
     * Set Parameters in Bulk
     *
     * @param array $parameters
     *
     * @return static
     */
    public function parameters(array $parameters): static;

    /**
     * Set Parameter
     *
     * @param string      $key
     * @param string|null $value
     *
     * @return static
     */
    public function parameter(string $key, string $value = null): static;

}
