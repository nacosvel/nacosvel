<?php

namespace Nacosvel\Feign;

use Nacosvel\Feign\Annotation\Autowired;
use Nacosvel\Feign\Annotation\EnableFeignClients;
use Nacosvel\Feign\Contracts\AutowiredInterface;
use Nacosvel\Feign\Contracts\ReflectiveInterface;
use Nacosvel\Helper;
use Nacosvel\Container\Interop\Contracts\ApplicationInterface;
use Nacosvel\Container\Interop\Discover;
use Psr\Container\ContainerInterface;
use ReflectionClass;
use ReflectionException;
use ReflectionNamedType;
use ReflectionUnionType;

class FeignRegistrar
{
    public static function builder(
        ContainerInterface $container,
        callable|string    $bind = 'bind',
        callable|string    $make = 'make',
        callable|string    $resolving = 'resolving'
    ): void
    {
        $instance = Discover::container($container, $bind, $make, $resolving);
        static::registerDefaultConfiguration($instance);
        static::registerDefaultAnnotation($instance);
    }

    /**
     * Register the default configuration class.
     *
     * @param ApplicationInterface $instance
     *
     * @return ApplicationInterface
     */
    protected static function registerDefaultConfiguration(ApplicationInterface $instance): ApplicationInterface
    {
        try {
            // class-string<T> of ContainerInterface::class
            $reflectionClass = new ReflectionClass(self::getLoaderClassName(3));
        } catch (ReflectionException $e) {
            return self::makeDefaultConfiguration($instance);
        }
        // EnableFeignClients::class Annotation Class
        if (count($attributes = $reflectionClass->getAttributes(EnableFeignClients::class)) === 0) {
            return self::makeDefaultConfiguration($instance);
        }
        // T of ConfigurationInterface<EnableFeignClients>
        foreach ($attributes as $attribute) {
            $enableFeignClients = $attribute->newInstance()->getInstance();
            $enableFeignClients->register($instance);
        }
        return $instance;
    }

    /**
     * Get the default configuration class.
     *
     * @param ApplicationInterface $instance
     *
     * @return ApplicationInterface
     */
    protected static function makeDefaultConfiguration(ApplicationInterface $instance): ApplicationInterface
    {
        $reflectionClass = new ReflectionClass(EnableFeignClients::class);
        try {
            $reflectionClass->newInstance()->getInstance()->register($instance);
        } catch (ReflectionException $e) {
            // Internal implementation code can definitely be instantiated.
        }
        return $instance;
    }

    /**
     * Get the string-class Name of the caller by the $target.
     *
     * @param int $target
     *
     * @return string
     */
    private static function getLoaderClassName(int $target = 0): string
    {
        $loadClass = '';
        foreach (debug_backtrace() as $key => $backtrace) {
            if ($key === $target) {
                $loadClass = $backtrace['class'] ?? '';
                break;
            }
        }
        return $loadClass;
    }

    /**
     * When the dependencies of an object are automatically injected,
     * register annotations into the container,
     * complete the request based on the interface,
     * and inject the data into properties.
     *
     * @param ApplicationInterface $instance
     *
     * @return ApplicationInterface
     */
    public static function registerDefaultAnnotation(ApplicationInterface $instance): ApplicationInterface
    {
        return $instance->resolving(AutowiredInterface::class, function ($resolving) {
            call_user_func([static::class, 'resolvingAutowiredInterface'], $resolving);
        });
    }

    /**
     * When a class implements the AutowiredInterface,
     * it injects data into properties that are annotated with the Autowired annotation.
     *
     * @param $resolving
     *
     * @return void
     */
    protected static function resolvingAutowiredInterface($resolving): void
    {
        try {
            $reflectionClass = new ReflectionClass($resolving);
        } catch (ReflectionException $e) {
            return;
        }
        // Controller|Repositories|Services|Models Class
        foreach ($reflectionClass->getProperties() as $property) {
            // Type constraints for each property
            $reflectionClasses = array_map(function ($propertyType) {
                if (!($propertyType instanceof ReflectionNamedType) || $propertyType->isBuiltin()) {
                    return false;
                }
                // Exclude invalid class or interface types
                $propertyTypeName = $propertyType->getName();
                if (!class_exists($propertyTypeName) && !interface_exists($propertyTypeName)) {
                    return false;
                }
                // Exclude ReflectiveInterface::class type from the property type constraints.
                $reflectionClass = new ReflectionClass($propertyTypeName);
                if ($reflectionClass->implementsInterface(ReflectiveInterface::class)) {
                    return false;
                }
                return $reflectionClass;
            }, Helper\with($property->getType(), function ($type) {
                return $type instanceof ReflectionUnionType ? $type->getTypes() : ($type ? [$type] : []);
            }));
            // Autowired::class Annotation Class
            foreach ($property->getAttributes(Autowired::class) as $attribute) {
                $property->setAccessible(true);
                /**
                 * @var Autowired                            $autowiredAnnotation
                 * @var ReflectiveInterface<FeignReflective> $reflective
                 */
                $autowiredAnnotation = $attribute->newInstance();
                $reflective          = $autowiredAnnotation->getInstance($property->getName(), array_filter($reflectionClasses));
                // T of ReflectiveInterface<FeignReflective>
                $property->setValue($resolving, $reflective);
            }
        }
    }

}
