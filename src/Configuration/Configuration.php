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
     * @var array<mixed, mixed|(callable(mixed,int): mixed)>
     */
    protected array $transformationMap = [
        // User::class => Model::class,
        // Collection::class => Collection::class,
        // ArrayObject::class => function ($value, $key) {},
    ];

    final public function register(NacosvelInterface $factory): void
    {
        $factory->bind(ConfigurationInterface::class, function () {
            return $this;
        });

        if (method_exists(static::class, 'boot')) {
            $this->boot($factory);
        }
    }

    abstract public function boot(NacosvelInterface $factory): void;

}
