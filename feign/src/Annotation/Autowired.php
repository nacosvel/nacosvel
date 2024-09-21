<?php

namespace Nacosvel\Feign\Annotation;

use Attribute;
use Nacosvel\Feign\Contracts\AutowiredInterface;
use Nacosvel\Feign\Contracts\ReflectiveInterface;
use Nacosvel\Feign\FeignReflective;

#[Attribute(Attribute::TARGET_PROPERTY)]
class Autowired implements AutowiredInterface
{
    public function __construct(protected string $value = FeignReflective::class)
    {
        if (false === class_exists($value) ||
            false === (is_subclass_of($value, AutowiredInterface::class) && is_subclass_of($value, ReflectiveInterface::class))) {
            $this->value = FeignReflective::class;
        }
    }

    /**
     * Invoke the Autowired method.
     *
     * @return AutowiredInterface|ReflectiveInterface
     */
    public function __invoke(): AutowiredInterface|ReflectiveInterface
    {
        return new $this->value();
    }

}
