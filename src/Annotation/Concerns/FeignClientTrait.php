<?php

namespace Nacosvel\Feign\Annotation\Concerns;

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
     * @return string
     */
    public function getConfiguration(): string
    {
        return $this->configuration;
    }

    /**
     * @param string $configuration
     *
     * @return static
     */
    public function setConfiguration(string $configuration): static
    {
        $this->configuration = $configuration;
        return $this;
    }

    /**
     * @return string
     */
    public function getFallback(): string
    {
        return $this->fallback;
    }

    /**
     * @param string $fallback
     *
     * @return static
     */
    public function setFallback(string $fallback): static
    {
        $this->fallback = $fallback;
        return $this;
    }

    /**
     * @return string
     */
    public function getClient(): string
    {
        return $this->client;
    }

    /**
     * @param string $client
     *
     * @return static
     */
    public function setClient(string $client): static
    {
        $this->client = $client;
        return $this;
    }

}
