<?php

namespace Nacosvel\Feign\Annotation;

use Attribute;
use Nacosvel\Feign\Contracts\ResponseMiddlewareInterface;

#[Attribute(Attribute::TARGET_CLASS | Attribute::TARGET_PROPERTY | Attribute::TARGET_METHOD | Attribute::IS_REPEATABLE)]
class ResponseMiddleware extends Middleware implements ResponseMiddlewareInterface
{
    public function __construct(
        string $value,
    )
    {
        $this->setResponse($value);
    }

}
