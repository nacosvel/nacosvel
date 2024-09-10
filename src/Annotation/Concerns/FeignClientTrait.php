<?php

namespace Nacosvel\Feign\Annotation\Concerns;

use GuzzleHttp\Client;
use GuzzleHttp\ClientInterface;
use Nacosvel\Feign\Configuration\Fallback;
use Nacosvel\Feign\Contracts\ConfigurationInterface;
use Nacosvel\Feign\Contracts\FallbackInterface;
use Nacosvel\Feign\FeignConfiguration;

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
     * @return string
     */
    public function getUrl(): string
    {
        return $this->url;
    }

    /**
     * @param string $url
     *
     * @return static
     */
    public function setUrl(string $url): static
    {
        $this->url = $url;
        return $this;
    }

    /**
     * @return string
     */
    public function getPath(): string
    {
        return $this->path;
    }

    /**
     * @param string $path
     *
     * @return static
     */
    public function setPath(string $path): static
    {
        $this->path = $path;
        return $this;
    }

    /**
     * @return ConfigurationInterface
     */
    public function getConfiguration(): ConfigurationInterface
    {
        return new $this->configuration();
    }

    /**
     * @param string $configuration
     *
     * @return static
     */
    public function setConfiguration(string $configuration): static
    {
        if (!class_exists($configuration) || !is_subclass_of($configuration, ConfigurationInterface::class)) {
            $configuration = FeignConfiguration::class;
        }
        $this->configuration = $configuration;
        return $this;
    }

    /**
     * @return FallbackInterface
     */
    public function getFallback(): FallbackInterface
    {
        return new $this->fallback();
    }

    /**
     * @param string $fallback
     *
     * @return static
     */
    public function setFallback(string $fallback): static
    {
        if (!class_exists($fallback) || !is_subclass_of($fallback, FallbackInterface::class)) {
            $fallback = Fallback::class;
        }
        $this->fallback = $fallback;
        return $this;
    }

    /**
     * @return ClientInterface
     */
    public function getClient(): ClientInterface
    {
        return new $this->client();
    }

    /**
     * @param string $client
     *
     * @return static
     */
    public function setClient(string $client): static
    {
        if (!class_exists($client) || !is_subclass_of($client, ClientInterface::class)) {
            $client = Client::class;
        }
        $this->client = $client;
        return $this;
    }

}
