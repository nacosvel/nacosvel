<?php

namespace Nacosvel\Feign\Annotation;

use Attribute;
use Nacosvel\Feign\Annotation\Concerns\RequestMappingTrait;
use Nacosvel\Feign\Annotation\Contracts\RequestMappingInterface;
use Nacosvel\Feign\Support\RequestMethod;

#[Attribute(Attribute::TARGET_METHOD)]
class RequestMapping implements RequestMappingInterface
{
    use RequestMappingTrait;

    public function __construct(
        protected string $path,
        protected string $method = RequestMethod::GET,
        protected string $params = '',
        protected string $headers = '',
        protected string $consumes = '',
        protected string $produces = ''
    )
    {
        $this->setPath($path)
            ->setMethod($method)
            ->setParams($params)
            ->setHeaders($headers)
            ->setConsumes($consumes)
            ->setProduces($produces);
    }

}
