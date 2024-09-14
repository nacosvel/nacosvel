<?php

namespace Nacosvel\Feign;

use Nacosvel\Feign\Annotation\Autowired;
use Nacosvel\Feign\Annotation\EnableFeignClients;
use Nacosvel\Feign\Contracts\AutowiredInterface;
use Nacosvel\Feign\Contracts\ConfigurationInterface;
use Nacosvel\Feign\Contracts\ReflectiveInterface;
use Nacosvel\Helper\Utils;
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
    ): ApplicationInterface
    {
        $configuration = static::registerDefaultConfiguration(self::getLoaderClassName(2));
        return Utils::tap(Discover::container($container, $bind, $make, $resolving), function (ApplicationInterface $container) use ($configuration) {
            $container->bind(ConfigurationInterface::class, function () use ($container, $configuration) {
                return Utils::tap($configuration, function (ConfigurationInterface $configuration) use ($container) {
                    $configuration->boot($container);
                });
            });
            /**
             * When the dependencies of an object are automatically injected,
             * register annotations into the container,
             * complete the request based on the interface,
             * and inject the data into properties.
             */
            $container->resolving(AutowiredInterface::class, function ($resolving) {
                static::resolvingAutowiredInterface($resolving);
            });
        });
    }

    /**
     * Register the default configuration class.
     *
     * @param string $loaderClass
     *
     * @return ConfigurationInterface|null
     */
    protected static function registerDefaultConfiguration(string $loaderClass): ?ConfigurationInterface
    {
        try {
            // class-string<T> of ContainerInterface::class
            $reflectionClass = new ReflectionClass($loaderClass);
        } catch (ReflectionException $e) {
            return self::makeDefaultConfiguration();
        }
        // EnableFeignClients::class Annotation Class
        if (count($attributes = $reflectionClass->getAttributes(EnableFeignClients::class)) === 0) {
            return self::makeDefaultConfiguration();
        }
        // T of ConfigurationInterface<EnableFeignClients>
        foreach ($attributes as $attribute) {
            return $attribute->newInstance()->getInstance();
        }
        return null;
    }

    /**
     * Get the default configuration class.
     *
     * @return ConfigurationInterface|null
     */
    protected static function makeDefaultConfiguration(): ?ConfigurationInterface
    {
        $reflectionClass = new ReflectionClass(EnableFeignClients::class);
        try {
            return $reflectionClass->newInstance()->getInstance();
        } catch (ReflectionException $e) {
            // Internal implementation code can definitely be instantiated.
        }
        return null;
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
            $reflectionClasses = array_reduce(Utils::with($property->getType(), function ($type) {
                return $type instanceof ReflectionUnionType ? $type->getTypes() : ($type ? [$type] : []);
            }), function ($carry, $propertyType) {
                if (!($propertyType instanceof ReflectionNamedType) || $propertyType->isBuiltin()) {
                    return $carry;
                }
                // Exclude invalid class or interface types
                $propertyTypeName = $propertyType->getName();
                if (!class_exists($propertyTypeName) && !interface_exists($propertyTypeName)) {
                    return $carry;
                }
                // Exclude ReflectiveInterface::class type from the property type constraints.
                $reflectionClass = new ReflectionClass($propertyTypeName);
                if ($reflectionClass->implementsInterface(ReflectiveInterface::class)) {
                    return $carry;
                }
                return Utils::tap($carry, function (&$carry) use ($propertyTypeName, $reflectionClass) {
                    $carry[$propertyTypeName] = $reflectionClass;
                });
            }, []);
            // Autowired::class Annotation Class
            foreach ($property->getAttributes(Autowired::class) as $attribute) {
                $property->setAccessible(true);
                /**
                 * @var Autowired                            $autowiredAnnotation
                 * @var ReflectiveInterface<FeignReflective> $reflective
                 */
                $autowiredAnnotation = $attribute->newInstance();
                $reflective          = $autowiredAnnotation->getInstance($property->getName(), $reflectionClasses);
                // T of ReflectiveInterface<FeignReflective>
                $property->setValue($resolving, $reflective);
            }
        }
    }

}
