<?php

namespace Nacosvel\Feign\Contracts;

use Nacosvel\Container\Interop\Contracts\ApplicationInterface;

interface ConfigurationInterface
{
    public function boot(ApplicationInterface $factory): void;

    /**
     * Attempt to convert $key to $value based on return type
     *
     * @template T of object
     * @template S of T
     *
     * @return array<class-string<T>, S>
     */
    public function converters(): array;

    /**
     * @return string
     */
    public function getDefaultMethod(): string;

    /**
     * @param string $method
     *
     * @return string
     */
    public function consumer(string $method): string;

    /**
     * @param string|null $name
     *
     * @return string|array|null
     */
    public function getService(?string $name = null): string|array|null;

    /**
     * @param string|array $name
     * @param array        $services
     *
     * @return static
     */
    public function setServices(string|array $name = [], array $services = []): static;

}
