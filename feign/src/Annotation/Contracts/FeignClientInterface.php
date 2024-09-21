<?php

namespace Nacosvel\Feign\Annotation\Contracts;

use Nacosvel\Feign\Contracts\ClientInterface;
use Nacosvel\Feign\Contracts\ConfigurationInterface;
use Nacosvel\Feign\Contracts\FallbackInterface;

interface FeignClientInterface
{
    /**
     * @return string
     */
    public function getName(): string;

    /**
     * @param string $name
     *
     * @return static
     */
    public function setName(string $name): static;

    /**
     * @return string|null
     */
    public function getUrl(): string|null;

    /**
     * @param string|null $url
     *
     * @return static
     */
    public function setUrl(string|null $url): static;

    /**
     * @return string|null
     */
    public function getPath(): string|null;

    /**
     * @param string|null $path
     *
     * @return static
     */
    public function setPath(string|null $path): static;

    /**
     * @return ConfigurationInterface
     */
    public function getConfiguration(): ConfigurationInterface;

    /**
     * @param string $configuration
     *
     * @return static
     */
    public function setConfiguration(string $configuration): static;

    /**
     * @return FallbackInterface
     */
    public function getFallback(): FallbackInterface;

    /**
     * @param string $fallback
     *
     * @return static
     */
    public function setFallback(string $fallback): static;

    /**
     * @return ClientInterface
     */
    public function getClient(): ClientInterface;

    /**
     * @param string $client
     *
     * @return static
     */
    public function setClient(string $client): static;

}
