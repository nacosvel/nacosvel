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
     * @return string|null
     */
    public function getConfiguration(): ?string
    {
        return $this->configuration;
    }

    /**
     * @param string|null $configuration
     *
     * @return static
     */
    public function setConfiguration(?string $configuration): static
    {
        $this->configuration = $configuration;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getFallback(): ?string
    {
        return $this->fallback;
    }

    /**
     * @param string|null $fallback
     *
     * @return static
     */
    public function setFallback(?string $fallback): static
    {
        $this->fallback = $fallback;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getClient(): ?string
    {
        return $this->client;
    }

    /**
     * @param string|null $client
     *
     * @return static
     */
    public function setClient(?string $client): static
    {
        $this->client = $client;
        return $this;
    }

}
