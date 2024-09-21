<?php

namespace Nacosvel\Feign\Annotation;

use Attribute;
use Nacosvel\Feign\Annotation\Concerns\FeignClientTrait;
use Nacosvel\Feign\Annotation\Contracts\FeignClientInterface;
use Nacosvel\Feign\Contracts\ClientInterface;
use Nacosvel\Feign\Contracts\ConfigurationInterface;
use Nacosvel\Feign\Contracts\FallbackInterface;

#[Attribute(Attribute::TARGET_CLASS | Attribute::TARGET_PROPERTY)]
class FeignClient implements FeignClientInterface
{
    use FeignClientTrait;

    public function __construct(
        protected string  $name,
        protected ?string $url = null,
        protected ?string $path = null,
        protected string  $configuration = ConfigurationInterface::class,
        protected string  $fallback = FallbackInterface::class,
        protected string  $client = ClientInterface::class,
    )
    {
        $this->setName($name)
            ->setUrl($url)
            ->setPath($path)
            ->setConfiguration($configuration)
            ->setFallback($fallback)
            ->setClient($client);
    }

}
