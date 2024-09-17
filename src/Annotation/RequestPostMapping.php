<?php

namespace Nacosvel\Feign\Annotation;

use Attribute;
use Nacosvel\Feign\Support\RequestMethod;

#[Attribute(Attribute::TARGET_METHOD)]
class RequestPostMapping extends RequestMapping
{
    public function __construct(
        protected ?string $path = null,
        protected string  $params = '',
        protected string  $headers = '',
    )
    {
        parent::__construct(
            path: $path,
            method: RequestMethod::POST,
            params: $params,
            headers: $headers
        );
    }

}
