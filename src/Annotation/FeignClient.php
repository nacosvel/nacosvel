<?php

namespace Nacosvel\Feign\Annotation;

use Attribute;
use Nacosvel\Feign\Annotation\Concerns\FeignClientTrait;
use Nacosvel\Feign\Annotation\Contracts\FeignClientInterface;

#[Attribute(Attribute::TARGET_CLASS)]
class FeignClient implements FeignClientInterface
{
    use FeignClientTrait;

    public function __construct(
        protected string  $name,
        protected string  $url = '',
        protected string  $path = '',
        protected ?string $configuration = null,
        protected ?string $fallback = null,
        protected ?string $client = null,
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
