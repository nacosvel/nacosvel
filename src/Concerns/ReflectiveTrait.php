<?php

namespace Nacosvel\Feign\Concerns;

use ArrayAccess;
use Nacosvel\Feign\Annotation\Contracts\RequestAttributeInterface;
use Nacosvel\Feign\Annotation\Contracts\RequestMappingInterface;
use Nacosvel\Feign\Contracts\MiddlewareInterface;
use Nacosvel\Helper\Utils;
use ReflectionAttribute;
use ReflectionClass;
use ReflectionMethod;
use ReflectionNamedType;
use ReflectionParameter;
use ReflectionUnionType;

trait ReflectiveTrait
{
    protected string $propertyName            = '';
    protected array  $propertyTypes           = [];
    protected array  $propertyTypesAttributes = [];
    protected array  $propertyAttributes      = [];
    protected string $methodName              = '';
    protected array  $methods                 = [];
    protected array  $methodsAttributes       = [];
    protected array  $methodsParameters       = [];
    protected array  $methodsReturnTypes      = [];

    /**
     * @param string $propertyName
     * @param array  $propertyTypes
     * @param array  $propertyTypesAttributes
     * @param array  $propertyAttributes
     *
     * @return static
     */
    public function __invoke(
        string $propertyName = '',
        array  $propertyTypes = [],
        array  $propertyTypesAttributes = [],
        array  $propertyAttributes = []
    ): static
    {
        return $this->setPropertyName($propertyName)
            ->setPropertyTypes($propertyTypes)
            ->setPropertyTypesAttributes($propertyTypesAttributes)
            ->setPropertyAttributes($propertyAttributes)
            ->resolvingMethods()
            ->resolvingMethodsAttributes()
            ->resolvingMethodsParameters()
            ->resolvingMethodsReturnTypes();
    }

    protected function resolvingMethods(): static
    {
        $methods = Utils::mapWithKeys(function (ReflectionNamedType $propertyType) {
            $propertyTypeName = $propertyType->getName();
            if (!class_exists($propertyTypeName) && !interface_exists($propertyTypeName)) {
                return false;
            }
            $reflectionClass = new ReflectionClass($propertyTypeName);
            $methods         = Utils::mapWithKeys(function (ReflectionMethod $method) {
                return [$method->getName() => $method];
            }, $reflectionClass->getMethods());
            return count($methods) ? [$propertyTypeName => $methods] : false;
        }, $this->propertyTypes);
        return $this->setMethods($methods);
    }

    protected function resolvingMethodsAttributes(): static
    {
        $methodsAttributes = Utils::mapWithKeys(function (array $methods, string $propertyTypeName) {
            $attributes = Utils::mapWithKeys(function (ReflectionMethod $reflectionMethod) {
                $attributes = Utils::mapWithKeys(function (ReflectionAttribute $attribute, int $key) {
                    $propertyMethodAttributes = [
                        RequestMappingInterface::class,
                        RequestAttributeInterface::class,
                        MiddlewareInterface::class,
                    ];
                    $hasPropertyAttribute     = Utils::array_some($propertyMethodAttributes, function ($propertyAttribute) use ($attribute) {
                        return is_subclass_of($attribute->getName(), $propertyAttribute);
                    });
                    return $hasPropertyAttribute ? [$key => $attribute->newInstance()] : false;
                }, $reflectionMethod->getAttributes());
                return count($attributes) ? [$reflectionMethod->getName() => $attributes] : false;
            }, $methods);
            return count($attributes) ? [$propertyTypeName => $attributes] : false;
        }, $this->getMethods());
        return $this->setMethodsAttributes($methodsAttributes);
    }

    protected function resolvingMethodsParameters(): static
    {
        $methodsParameters = Utils::mapWithKeys(function (array $methods, string $propertyTypeName) {
            $parameters = Utils::mapWithKeys(function (ReflectionMethod $reflectionMethod, string $propertyTypeName) {
                $parameters = Utils::mapWithKeys(function (ReflectionParameter $parameter) {
                    return [$parameter->getPosition() => $parameter->getName()];
                }, $reflectionMethod->getParameters());
                return count($parameters) ? [$propertyTypeName => $parameters] : false;
            }, $methods);
            return count($parameters) ? [$propertyTypeName => $parameters] : false;
        }, $this->getMethods());
        return $this->setMethodsParameters($methodsParameters);
    }

    protected function resolvingMethodsReturnTypes(): static
    {
        $methodsReturnTypes = Utils::mapWithKeys(function (array $methods, string $propertyTypeName) {
            $returnTypes = Utils::mapWithKeys(function (ReflectionMethod $reflectionMethod, string $propertyTypeName) {
                $types = Utils::mapWithKeys(function (ReflectionNamedType $type) {
                    if ($type->allowsNull() || $type->isBuiltin()) {
                        return false;
                    }
                    if (is_subclass_of($type->getName(), ArrayAccess::class) || $type->getName() === ArrayAccess::class) {
                        return [$type->getName() => $type];
                    }
                    return false;
                }, Utils::with($reflectionMethod->getReturnType(), function ($type) {
                    return $type instanceof ReflectionUnionType ? $type->getTypes() : ($type ? [$type] : []);
                }));
                return count($types) ? [$propertyTypeName => $types] : false;
            }, $methods);
            return count($returnTypes) ? [$propertyTypeName => $returnTypes] : false;
        }, $this->getMethods());
        return $this->setMethodsReturnTypes($methodsReturnTypes);
    }

    /**
     * @return string
     */
    protected function getPropertyName(): string
    {
        return $this->propertyName;
    }

    /**
     * @param string $propertyName
     *
     * @return static
     */
    protected function setPropertyName(string $propertyName): static
    {
        $this->propertyName = $propertyName;
        return $this;
    }

    /**
     * @return array
     */
    protected function getPropertyTypes(): array
    {
        return $this->propertyTypes;
    }

    /**
     * @param array $propertyTypes
     *
     * @return static
     */
    protected function setPropertyTypes(array $propertyTypes): static
    {
        $this->propertyTypes = $propertyTypes;
        return $this;
    }

    /**
     * @return array
     */
    protected function getPropertyAttributes(): array
    {
        return $this->propertyAttributes;
    }

    /**
     * @param array $propertyAttributes
     *
     * @return static
     */
    protected function setPropertyAttributes(array $propertyAttributes): static
    {
        $this->propertyAttributes = $propertyAttributes;
        return $this;
    }

    /**
     * @return array
     */
    protected function getPropertyTypesAttributes(): array
    {
        return $this->propertyTypesAttributes;
    }

    /**
     * @param array $propertyTypesAttributes
     *
     * @return static
     */
    protected function setPropertyTypesAttributes(array $propertyTypesAttributes): static
    {
        $this->propertyTypesAttributes = $propertyTypesAttributes;
        return $this;
    }

    /**
     * @return string
     */
    protected function getMethodName(): string
    {
        return $this->methodName;
    }

    /**
     * @param string $methodName
     *
     * @return static
     */
    protected function setMethodName(string $methodName): static
    {
        $this->methodName = $methodName;
        return $this;
    }

    /**
     * @return array
     */
    protected function getMethods(): array
    {
        return $this->methods;
    }

    /**
     * @param array $methods
     *
     * @return static
     */
    protected function setMethods(array $methods): static
    {
        $this->methods = $methods;
        return $this;
    }

    /**
     * @return array
     */
    protected function getMethodsAttributes(): array
    {
        return $this->methodsAttributes;
    }

    /**
     * @param array $methodsAttributes
     *
     * @return static
     */
    protected function setMethodsAttributes(array $methodsAttributes): static
    {
        $this->methodsAttributes = $methodsAttributes;
        return $this;
    }

    /**
     * @return array
     */
    protected function getMethodsParameters(): array
    {
        return $this->methodsParameters;
    }

    /**
     * @param array $methodsParameters
     *
     * @return static
     */
    protected function setMethodsParameters(array $methodsParameters): static
    {
        $this->methodsParameters = $methodsParameters;
        return $this;
    }

    /**
     * @return array
     */
    protected function getMethodsReturnTypes(): array
    {
        return $this->methodsReturnTypes;
    }

    /**
     * @param array $methodsReturnTypes
     *
     * @return static
     */
    protected function setMethodsReturnTypes(array $methodsReturnTypes): static
    {
        $this->methodsReturnTypes = $methodsReturnTypes;
        return $this;
    }

}
