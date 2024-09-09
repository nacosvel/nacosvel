<?php

namespace Nacosvel\Feign\Annotation\Contracts;

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
     * @return string
     */
    public function getUrl(): string;

    /**
     * @param string $url
     *
     * @return static
     */
    public function setUrl(string $url): static;

    /**
     * @return string
     */
    public function getPath(): string;

    /**
     * @param string $path
     *
     * @return static
     */
    public function setPath(string $path): static;

    /**
     * @return string|null
     */
    public function getConfiguration(): ?string;

    /**
     * @param string|null $configuration
     *
     * @return static
     */
    public function setConfiguration(?string $configuration): static;

    /**
     * @return string|null
     */
    public function getFallback(): ?string;

    /**
     * @param string|null $fallback
     *
     * @return static
     */
    public function setFallback(?string $fallback): static;

    /**
     * @return string|null
     */
    public function getClient(): ?string;

    /**
     * @param string|null $client
     *
     * @return static
     */
    public function setClient(?string $client): static;

}
