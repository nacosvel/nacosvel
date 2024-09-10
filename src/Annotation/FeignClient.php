<?php

namespace Nacosvel\Feign\Annotation;

use Attribute;
use GuzzleHttp\Client;
use Nacosvel\Feign\Annotation\Concerns\FeignClientTrait;
use Nacosvel\Feign\Annotation\Contracts\FeignClientInterface;
use Nacosvel\Feign\Configuration\Fallback;
use Nacosvel\Feign\FeignConfiguration;

#[Attribute(Attribute::TARGET_CLASS)]
class FeignClient implements FeignClientInterface
{
    use FeignClientTrait;

    public function __construct(
        protected string $name,
        protected string $url = '',
        protected string $path = '/',
        protected string $configuration = FeignConfiguration::class,
        protected string $fallback = Fallback::class,
        protected string $client = Client::class,
    )
    {
        $this->setName($name)
            ->setUrl($url)
            ->setPath($path ?: '/')
            ->setConfiguration($configuration)
            ->setFallback($fallback)
            ->setClient($client);
    }

}
