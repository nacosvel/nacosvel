<?php

namespace Nacosvel\Feign\Contracts;

use Nacosvel\Container\Interop\Contracts\ApplicationInterface;

interface ConfigurationInterface
{
    public function register(ApplicationInterface $factory): void;

    public function boot(ApplicationInterface $factory): void;

    /**
     * @return string
     */
    public function getDefaultMethod(): string;

    /**
     * @param string $method
     *
     * @return string
     */
    public function getConsumerMap(string $method): string;

    /**
     * @return array
     */
    public function getProducerMap(): array;

}
