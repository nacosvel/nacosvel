<?php

namespace Nacosvel\Feign\Concerns;

use ArrayAccess;
use ArrayIterator;
use Nacosvel\Feign\Annotation\Contracts\FeignClientInterface;
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
    protected string $propertyName       = '';
    protected array  $propertyTypes      = [];
    protected array  $propertyAttributes = [];
    protected string $methodName         = '';
    protected array  $methods            = [];
    protected array  $methodsAttributes  = [];
    protected array  $methodsParameters  = [];
    protected array  $methodsReturnTypes = [];
    protected array  $attributes         = [];

    /**
     * @param string $propertyName
     * @param array  $propertyTypes
     * @param array  $propertyAttributes
     *
     * @return static
     */
    public function __invoke(
        string $propertyName = '',
        array  $propertyTypes = [],
        array  $propertyAttributes = []
    ): static
    {
        return $this->setPropertyName($propertyName)
            ->setPropertyTypes($propertyTypes)
            ->setPropertyAttributes($propertyAttributes)
            ->resolvingMethods()
            ->resolvingMethodsAttributes()
            ->resolvingMethodsParameters()
            ->resolvingMethodsReturnTypes()
            ->resolvingAttributes();
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
            $methods = Utils::mapWithKeys(function (ReflectionMethod $reflectionMethod) {
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
            return count($methods) ? [$propertyTypeName => $methods] : false;
        }, $this->getMethods());
        return $this->setMethodsAttributes($methodsAttributes);
    }

    protected function resolvingMethodsParameters(): static
    {
        $methodsParameters = Utils::mapWithKeys(function (array $methods, string $propertyTypeName) {
            $methods = Utils::mapWithKeys(function (ReflectionMethod $reflectionMethod, string $propertyTypeName) {
                $parameters = Utils::mapWithKeys(function (ReflectionParameter $parameter) {
                    return [$parameter->getPosition() => $parameter->getName()];
                }, $reflectionMethod->getParameters());
                return count($parameters) ? [$propertyTypeName => $parameters] : false;
            }, $methods);
            return count($methods) ? [$propertyTypeName => $methods] : false;
        }, $this->getMethods());
        return $this->setMethodsParameters($methodsParameters);
    }

    protected function resolvingMethodsReturnTypes(): static
    {
        $methodsReturnTypes = Utils::mapWithKeys(function (array $methods, string $propertyTypeName) {
            $methods = Utils::mapWithKeys(function (ReflectionMethod $reflectionMethod, string $propertyTypeName) {
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
            return count($methods) ? [$propertyTypeName => $methods] : false;
        }, $this->getMethods());
        return $this->setMethodsReturnTypes($methodsReturnTypes);
    }

    protected function resolvingAttributes(): static
    {
        $typesAttributes = Utils::mapWithKeys(function (ReflectionNamedType $type) {
            $typeName = $type->getName();
            if (!interface_exists($typeName)) {
                return false;
            }
            $reflectionClass = new ReflectionClass($typeName);
            if (count($attributes = $reflectionClass->getAttributes()) === 0) {
                return false;
            }
            $attributes = Utils::mapWithKeys(function (ReflectionAttribute $attribute, int $key) {
                $propertyTypesAttributes  = [
                    FeignClientInterface::class,
                    MiddlewareInterface::class,
                    RequestAttributeInterface::class,
                ];
                $hasPropertyTypeAttribute = Utils::array_some($propertyTypesAttributes, function ($propertyTypeAttribute) use ($attribute) {
                    return is_subclass_of($attribute->getName(), $propertyTypeAttribute);
                });
                return $hasPropertyTypeAttribute ? [$key => $attribute->newInstance()] : false;
            }, $attributes);
            if (count($attributes) === 0) {
                return false;
            }
            return [$typeName => $attributes];
        }, $this->getPropertyTypes());
        return $this->setAttributes($typesAttributes);
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
     * @param string|null $method
     *
     * @return array|ArrayIterator
     */
    protected function getMethods(string $method = null): array|ArrayIterator
    {
        if (is_null($method)) {
            return $this->methods;
        }
        return new ArrayIterator(Utils::mapWithKeys(function (array $methods, $classStub) use ($method) {
            return array_key_exists($method, $methods) ? [$classStub => $methods] : false;
        }, $this->getMethods()));
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
     * @param string|null $classString
     * @param string|null $method
     *
     * @return array|ArrayIterator
     */
    protected function getMethodsAttributes(string $classString = null, string $method = null): array|ArrayIterator
    {
        if (is_null($classString)) {
            return $this->methodsAttributes;
        }
        if (is_null($method)) {
            return new ArrayIterator(Utils::mapWithKeys(function (array $methodsAttributes, $classStub) use ($classString) {
                return $classStub === $classString ? [$classStub => $methodsAttributes] : false;
            }, $this->getMethodsAttributes()));
        }
        return new ArrayIterator(Utils::mapWithKeys(function (array $methodsAttributes, $classStub) use ($method) {
            return array_key_exists($method, $methodsAttributes) ? [$classStub => $methodsAttributes[$method]] : false;
        }, $this->getMethodsAttributes($classString)->getArrayCopy()));
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
     * @param string|null $classString
     * @param string|null $method
     *
     * @return array|ArrayIterator
     */
    protected function getMethodsParameters(string $classString = null, string $method = null): array|ArrayIterator
    {
        if (is_null($classString)) {
            return $this->methodsParameters;
        }
        if (is_null($method)) {
            return new ArrayIterator(Utils::mapWithKeys(function (array $methodsParameters, $classStub) use ($classString) {
                return $classStub === $classString ? [$classStub => $methodsParameters] : false;
            }, $this->getMethodsParameters()));
        }
        return new ArrayIterator(Utils::mapWithKeys(function (array $methodsParameters, $classStub) use ($method) {
            return array_key_exists($method, $methodsParameters) ? [$classStub => $methodsParameters[$method]] : false;
        }, $this->getMethodsParameters($classString)->getArrayCopy()));
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
     * @param string|null $classString
     * @param string|null $method
     *
     * @return array|ArrayIterator
     */
    protected function getMethodsReturnTypes(string $classString = null, string $method = null): array|ArrayIterator
    {
        if (is_null($classString)) {
            return $this->methodsReturnTypes;
        }
        if (is_null($method)) {
            return new ArrayIterator(Utils::mapWithKeys(function (array $methodsReturnTypes, $classStub) use ($classString) {
                return $classStub === $classString ? [$classStub => $methodsReturnTypes] : false;
            }, $this->getMethodsReturnTypes()));
        }
        return new ArrayIterator(Utils::mapWithKeys(function (array $methodsReturnTypes, $classStub) use ($method) {
            return array_key_exists($method, $methodsReturnTypes) ? [$classStub => $methodsReturnTypes[$method]] : false;
        }, $this->getMethodsReturnTypes($classString)->getArrayCopy()));
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

    /**
     * @param string|null $classString
     *
     * @return array|ArrayIterator
     */
    protected function getAttributes(string $classString = null): array|ArrayIterator
    {
        if (is_null($classString)) {
            return $this->attributes;
        }
        return new ArrayIterator(Utils::mapWithKeys(function (array $attributes, $classStub) use ($classString) {
            return $classStub === $classString ? [$classStub => $attributes] : false;
        }, $this->getAttributes()));
    }

    /**
     * @param array $attributes
     *
     * @return static
     */
    protected function setAttributes(array $attributes): static
    {
        $this->attributes = $attributes;
        return $this;
    }

}
