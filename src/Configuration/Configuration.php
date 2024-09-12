<?php

namespace Nacosvel\Feign\Configuration;

use Nacosvel\Feign\Contracts\ConfigurationInterface;
use Nacosvel\Feign\Support\RequestMethod;
use Nacosvel\Interop\Container\Contracts\NacosvelInterface;

abstract class Configuration implements ConfigurationInterface
{
    protected string $defaultMethod = RequestMethod::POST;

    protected array $consumerMap = [
        RequestMethod::GET     => 'query',
        RequestMethod::POST    => 'form_params',// multipart, json, form_params
        RequestMethod::PUT     => 'form_params',// json, body, form_params
        RequestMethod::DELETE  => 'query',// json, body, query
        RequestMethod::PATCH   => 'form_params',// json, body, form_params
        RequestMethod::OPTIONS => 'query',
        RequestMethod::HEAD    => 'query',
    ];

    protected array $producerMap = [
        'data',
        // 'list',// data.list
    ];

    /**
     * Attempt to convert $key to $value based on return type
     *
     * @template T of object
     * @template S of T
     *
     * @return array<class-string<T>, S>
     */
    public function converters(): array
    {
        return [
            // Model::class      => new Post(),
            // Collection::class => new Collection(),
            // '*'               => new Transformation(),
        ];
    }

    final public function register(NacosvelInterface $factory): void
    {
        $factory->bind(ConfigurationInterface::class, function () {
            return $this;
        });

        call_user_func([$this, 'boot'], $factory);
    }

    abstract public function boot(NacosvelInterface $factory): void;

    /**
     * @return string
     */
    public function getDefaultMethod(): string
    {
        return $this->defaultMethod;
    }

    /**
     * @param string $method
     *
     * @return string
     */
    public function getConsumerMap(string $method): string
    {
        return array_key_exists($method, $this->consumerMap) ? $this->consumerMap[$method] : $this->defaultMethod;
    }

    /**
     * @return array
     */
    public function getProducerMap(): array
    {
        return $this->producerMap;
    }

}
