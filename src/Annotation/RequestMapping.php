<?php

namespace Nacosvel\Feign\Annotation;

use Attribute;
use Nacosvel\Feign\Annotation\Concerns\RequestMappingTrait;
use Nacosvel\Feign\Annotation\Contracts\RequestMappingInterface;

#[Attribute(Attribute::TARGET_METHOD)]
class RequestMapping implements RequestMappingInterface
{
    use RequestMappingTrait;

    public function __construct(
        protected ?string $path = null,
        protected string  $method = '',
        protected string  $params = '',
        protected string  $headers = '',
    )
    {
        $this->setPath($path)
            ->setMethod($method)
            ->setParams($params)
            ->setHeaders($headers);
    }

}
