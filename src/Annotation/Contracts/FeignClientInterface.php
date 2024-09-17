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
     * @return string
     */
    public function getConfiguration(): string;

    /**
     * @param string $configuration
     *
     * @return static
     */
    public function setConfiguration(string $configuration): static;

    /**
     * @return string
     */
    public function getFallback(): string;

    /**
     * @param string $fallback
     *
     * @return static
     */
    public function setFallback(string $fallback): static;

    /**
     * @return string
     */
    public function getClient(): string;

    /**
     * @param string $client
     *
     * @return static
     */
    public function setClient(string $client): static;

}
