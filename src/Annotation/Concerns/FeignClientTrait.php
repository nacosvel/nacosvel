<?php

namespace Nacosvel\Feign\Annotation\Concerns;

use Nacosvel\Feign\Contracts\ClientInterface;
use Nacosvel\Feign\Contracts\ConfigurationInterface;
use Nacosvel\Feign\Contracts\FallbackInterface;
use function Nacosvel\Container\Interop\application;

trait FeignClientTrait
{
    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @param string $name
     *
     * @return static
     */
    public function setName(string $name): static
    {
        $this->name = $name;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getUrl(): string|null
    {
        return $this->url;
    }

    /**
     * @param string|null $url
     *
     * @return static
     */
    public function setUrl(string|null $url): static
    {
        $this->url = $url;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getPath(): string|null
    {
        return $this->path;
    }

    /**
     * @param string|null $path
     *
     * @return static
     */
    public function setPath(string|null $path): static
    {
        $this->path = $path;
        return $this;
    }

    /**
     * @return ConfigurationInterface
     */
    public function getConfiguration(): ConfigurationInterface
    {
        return application($this->configuration);
    }

    /**
     * @param string $configuration
     *
     * @return static
     */
    public function setConfiguration(string $configuration): static
    {
        if (!class_exists($configuration) || !is_subclass_of($configuration, ConfigurationInterface::class)) {
            $configuration = ConfigurationInterface::class;
        }
        $this->configuration = $configuration;
        return $this;
    }

    /**
     * @return FallbackInterface
     */
    public function getFallback(): FallbackInterface
    {
        return application($this->fallback);
    }

    /**
     * @param string $fallback
     *
     * @return static
     */
    public function setFallback(string $fallback): static
    {
        if (!class_exists($fallback) || !is_subclass_of($fallback, FallbackInterface::class)) {
            $fallback = FallbackInterface::class;
        }
        $this->fallback = $fallback;
        return $this;
    }

    /**
     * @return ClientInterface
     */
    public function getClient(): ClientInterface
    {
        return application($this->client);
    }

    /**
     * @param string $client
     *
     * @return static
     */
    public function setClient(string $client): static
    {
        if (!class_exists($client) || !is_subclass_of($client, ClientInterface::class)) {
            $client = ClientInterface::class;
        }
        $this->client = $client;
        return $this;
    }

}
