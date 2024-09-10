<?php

namespace Nacosvel\Feign;

use Nacosvel\Feign\Annotation\Autowired;
use Nacosvel\Feign\Annotation\EnableFeignClients;
use Nacosvel\Feign\Contracts\AutowiredInterface;
use Nacosvel\Feign\Contracts\FeignInterface;
use Nacosvel\Feign\Contracts\ServiceInterface;
use Psr\Container\ContainerInterface;
use ReflectionClass;
use ReflectionException;
use ReflectionNamedType;
use ReflectionUnionType;

class FeignClientsRegistrar extends FeignFactory
{
    public static function builder(
        ContainerInterface $container,
        callable|string    $bind = 'bind',
        callable|string    $with = 'with',
        callable|string    $resolving = 'resolving'
    ): void
    {
        $callable = function ($callable) use ($container) {
            return is_string($callable) ? function ($abstract, $concrete) use ($container, $callable) {
                return call_user_func([$container, $callable], $abstract, $concrete);
            } : $callable;
        };
        $instance = self::getInstance()
            ->setContainer($container)
            ->setBind($callable($bind))
            ->setWith($callable($with))
            ->setResolving($callable($resolving));
        static::registerDefaultConfiguration($instance);
        static::registerDefaultAnnotation($instance);
    }

    /**
     * Register the default configuration class.
     *
     * @param FeignInterface $instance
     *
     * @return FeignInterface
     */
    protected static function registerDefaultConfiguration(FeignInterface $instance): FeignInterface
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
     * @param FeignInterface $instance
     *
     * @return FeignInterface
     */
    protected static function makeDefaultConfiguration(FeignInterface $instance): FeignInterface
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
     * @param FeignInterface $instance
     *
     * @return FeignInterface
     */
    public static function registerDefaultAnnotation(FeignInterface $instance): FeignInterface
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
        // Controller|Repositories|Services|Models Class
        foreach ((new ReflectionClass($resolving))->getProperties() as $property) {
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
                // Exclude ServiceInterface::class type from the property type constraints.
                $reflectionClass = new ReflectionClass($propertyTypeName);
                if ($reflectionClass->implementsInterface(ServiceInterface::class)) {
                    return false;
                }
                return $reflectionClass;
            }, ($type = $property->getType()) ? ($type instanceof ReflectionUnionType ? $type->getTypes() : [$type]) : []);
            // Autowired::class Annotation Class
            foreach ($property->getAttributes(Autowired::class) as $attribute) {
                $property->setAccessible(true);
                /**
                 * @var Autowired                         $autowiredAnnotation
                 * @var ServiceInterface<FeignReflective> $serviceInterface
                 */
                $autowiredAnnotation = $attribute->newInstance();
                $serviceInterface    = $autowiredAnnotation->getInstance($property->getName(), array_filter($reflectionClasses));
                // T of ServiceInterface<FeignReflective>
                $property->setValue($resolving, $serviceInterface);
            }
        }
    }

}
