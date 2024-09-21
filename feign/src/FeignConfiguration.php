<?php

namespace Nacosvel\Feign;

use Nacosvel\Feign\Configuration\Client;
use Nacosvel\Feign\Configuration\Configuration;
use Nacosvel\Feign\Configuration\Fallback;
use Nacosvel\Feign\Contracts\ClientInterface;
use Nacosvel\Feign\Contracts\ConfigurationInterface;
use Nacosvel\Feign\Contracts\FallbackInterface;
use Nacosvel\Feign\Support\RequestMethod;
use Nacosvel\Container\Interop\Contracts\ApplicationInterface;

class FeignConfiguration extends Configuration
{
    protected string $defaultMethod = RequestMethod::POST;

    public function boot(ApplicationInterface $factory): void
    {
        // $factory->bind(ConfigurationInterface::class, function () {
        //     return new self();
        // });
        // $factory->bind(FallbackInterface::class, function () {
        //     return new Fallback();
        // });
        // $factory->bind(ClientInterface::class, function () {
        //     return new Client();
        // });
    }

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

}
