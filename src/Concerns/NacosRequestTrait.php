<?php

namespace Nacosvel\Nacos\Concerns;

use GuzzleHttp\UriTemplate\UriTemplate;

trait NacosRequestTrait
{
    /**
     * Request Options
     *
     * @var array
     */
    protected array $options = [];

    protected array $fields = [
        self::POST   => 'form_params',
        self::PUT    => 'form_params',
        self::GET    => 'query',
        self::DELETE => 'query',
    ];

    public function __construct(string $version = null)
    {
        $this->setVersion($version ?? $this->getVersion());
    }

    /**
     * @inheritDoc
     *
     * @return string
     */
    public function getVersion(): string
    {
        return $this->version;
    }

    /**
     * @inheritDoc
     *
     * @return static
     */
    public function setVersion(string $version): static
    {
        $this->version = $version;

        return $this->setOption('Version', $this->getVersion());
    }

    /**
     * @inheritDoc
     *
     * @return string
     */
    public function getMethod(): string
    {
        return $this->method;
    }

    /**
     * @inheritDoc
     *
     * @return string
     */
    public function getUri(): string
    {
        $uri = $this->uri;

        if (is_string($this->uri)) {
            $uri = explode(',', $this->uri);
        }

        if (array_key_exists($lowerVersion = strtolower($this->getVersion()), $lowerKeysUri = array_change_key_case($uri, CASE_LOWER))) {
            return $lowerKeysUri[$lowerVersion];
        }

        $versionNumber = intval(strrev($this->getVersion())) - 1;

        if (array_key_exists($versionNumber, $uri)) {
            $uri = $uri[$versionNumber];
        } else {
            $uri = current($uri);
        }

        return UriTemplate::expand($uri, $this->toArray());
    }

    /**
     * @inheritDoc
     *
     * @return static
     *
     * @example
     *  ```
     *  $this->setOption('headers', ['Content-Type' => 'application/json']);
     *  $this->setOption('timeout', 10);
     *  ```
     */
    public function setOption(string $field, mixed $options): static
    {
        if (false === array_key_exists($field, $this->options)) {
            $this->options[$field] = [];
        }

        if (false === is_array($options)) {
            $this->options[$field] = $options;
        } else {
            $this->options[$field] = array_merge($this->options[$field], $options);
        }

        return $this;
    }

    /**
     * @inheritDoc
     *
     * @return static
     *
     * @example
     *  ```
     *  $this->parameters([
     *     'namespaceId' => 'public',
     *     'groupName'  => 'DEFAULT_GROUP',
     *  ]);
     *  ```
     */
    public function parameters(array $parameters): static
    {
        if (false === array_key_exists($this->method, $this->fields)) {
            return $this;
        }

        $optionKey = $this->fields[$this->method];

        if (false === array_key_exists($optionKey, $this->options)) {
            $this->options[$optionKey] = [];
        }

        $this->options[$optionKey] = array_merge($this->options[$optionKey], $parameters);

        return $this;
    }

    /**
     * @inheritDoc
     *
     * @return static
     *
     * @example
     *  ```
     *  $this->parameter('namespaceId', 'public');
     *  ```
     */
    public function parameter(string $key, string $value = null): static
    {
        return $this->parameters([$key => $value]);
    }

    /**
     * @inheritDoc
     *
     * @return array
     */
    public function toArray(): array
    {
        return $this->options;
    }

}
