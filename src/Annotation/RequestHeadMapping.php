<?php

namespace Nacosvel\Feign\Annotation;

use Attribute;
use Nacosvel\Feign\Support\RequestMethod;

#[Attribute(Attribute::TARGET_METHOD)]
class RequestHeadMapping extends RequestMapping
{
    public function __construct(
        protected string $path,
        protected string $params = '',
        protected string $headers = '',
        protected string $consumes = '',
        protected string $produces = ''
    )
    {
        parent::__construct(path: $path, method: RequestMethod::HEAD, params: $params, headers: $headers, consumes: $consumes, produces: $produces);
    }

}
