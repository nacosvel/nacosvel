<?php

namespace Nacosvel\Feign\Contracts;

use Nacosvel\Interop\Container\Contracts\NacosvelInterface;

interface ConfigurationInterface
{
    public function register(NacosvelInterface $factory): void;

    public function boot(NacosvelInterface $factory): void;

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

    /**
     * @return array
     */
    public function getTransformationMap(): array;

}
