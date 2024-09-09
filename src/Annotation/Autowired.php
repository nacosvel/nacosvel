<?php

namespace Nacosvel\Feign\Annotation;

use Attribute;
use Nacosvel\Feign\Contracts\ServiceInterface;
use Nacosvel\Feign\FeignReflective;
use ReflectionClass;

#[Attribute(Attribute::TARGET_PROPERTY)]
class Autowired
{
    public function __construct(protected string $reflectiveClass = FeignReflective::class)
    {
        if (false === class_exists($this->reflectiveClass) ||
            false === is_subclass_of($reflectiveClass, ServiceInterface::class)) {
            $this->reflectiveClass = FeignReflective::class;
        }
    }

    /**
     * @param string            $propertyName
     * @param ReflectionClass[] $reflectionClasses
     *
     * @return ServiceInterface
     */
    public function getInstance(string $propertyName = '', array $reflectionClasses = []): ServiceInterface
    {
        return new $this->reflectiveClass($propertyName, $reflectionClasses);
    }

}
