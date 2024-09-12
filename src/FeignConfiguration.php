<?php

namespace Nacosvel\Feign;

use Nacosvel\Feign\Configuration\Configuration;
use Nacosvel\Feign\Contracts\ConfigurationInterface;
use Nacosvel\Feign\Support\RequestMethod;
use Nacosvel\Interop\Container\Contracts\NacosvelInterface;

class FeignConfiguration extends Configuration implements ConfigurationInterface
{
    protected string $defaultMethod = RequestMethod::POST;

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

    public function boot(NacosvelInterface $factory): void
    {
        //
    }

}
