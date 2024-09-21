<?php

namespace Nacosvel\Feign\Annotation;

use Attribute;
use Nacosvel\Feign\Contracts\RequestMiddlewareInterface;

#[Attribute(Attribute::TARGET_CLASS | Attribute::TARGET_PROPERTY | Attribute::TARGET_METHOD | Attribute::IS_REPEATABLE)]
class RequestMiddleware extends Middleware implements RequestMiddlewareInterface
{
    public function __construct(
        string $value,
    )
    {
        $this->setRequest($value);
    }

}
