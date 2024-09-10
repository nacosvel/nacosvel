<?php

namespace Nacosvel\Feign;

use Nacosvel\Feign\Configuration\Configuration;
use Nacosvel\Feign\Contracts\ConfigurationInterface;
use Nacosvel\Feign\Support\RequestMethod;
use Nacosvel\Interop\Container\Contracts\NacosvelInterface;

class FeignClientsConfiguration extends Configuration implements ConfigurationInterface
{
    protected string $defaultMethod = RequestMethod::POST;

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

    public function boot(NacosvelInterface $factory): void
    {
        //
    }

}
