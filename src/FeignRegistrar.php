<?php

namespace Nacosvel\Feign;

use Nacosvel\Feign\Annotation\Contracts\FeignClientInterface;
use Nacosvel\Feign\Annotation\Contracts\RequestAttributeInterface;
use Nacosvel\Feign\Annotation\EnableFeignClients;
use Nacosvel\Feign\Configuration\Client;
use Nacosvel\Feign\Configuration\Fallback;
use Nacosvel\Feign\Contracts\AutowiredInterface;
use Nacosvel\Feign\Contracts\ClientInterface;
use Nacosvel\Feign\Contracts\ConfigurationInterface;
use Nacosvel\Feign\Contracts\FallbackInterface;
use Nacosvel\Feign\Contracts\MiddlewareInterface;
use Nacosvel\Feign\Contracts\ReflectiveInterface;
use Nacosvel\Feign\Exception\FeignRuntimeException;
use Nacosvel\Helper\Utils;
use Nacosvel\Container\Interop\Contracts\ApplicationInterface;
use Nacosvel\Container\Interop\Discover;
use Psr\Container\ContainerInterface;
use ReflectionAttribute;
use ReflectionClass;
use ReflectionException;
use ReflectionNamedType;
use ReflectionProperty;
use ReflectionUnionType;

class FeignRegistrar
{
    public static function builder(
        ContainerInterface $container = null,
        callable|string    $bind = 'bind',
        callable|string    $make = 'make',
        callable|string    $resolving = 'resolving'
    ): ApplicationInterface
    {
        $configuration = static::registerDefaultConfiguration(self::getLoaderClassName(2));
        return Utils::tap(Discover::container($container, $bind, $make, $resolving), function (ApplicationInterface $container) use ($configuration) {
            $container->bind(ConfigurationInterface::class, function () use ($container, $configuration) {
                return $configuration;
            });
            $container->bind(FallbackInterface::class, function () use ($container, $configuration) {
                return new Fallback();
            });
            $container->bind(ClientInterface::class, function () use ($container, $configuration) {
                return new Client();
            });
            $configuration->boot($container);
            /**
             * When a class implements the AutowiredInterface,
             * it injects data into properties that are annotated with the Autowired annotation.
             */
            $container->resolving(function ($resolving) {
                is_subclass_of($resolving, AutowiredInterface::class) && static::registerDefaultAnnotation($resolving);
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
            return call_user_func($attribute->newInstance());
        }
        return null;
    }

    /**
     * Get the default configuration class.
     *
     * @return ConfigurationInterface|null
     */
    private static function makeDefaultConfiguration(): ?ConfigurationInterface
    {
        $reflectionClass = new ReflectionClass(EnableFeignClients::class);
        try {
            return call_user_func($reflectionClass->newInstance());
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
     * When the dependencies of an object are automatically injected,
     * register annotations into the container,
     * complete the request based on the interface,
     * and inject the data into properties.
     *
     * @param $resolving
     *
     * @return void
     */
    protected static function registerDefaultAnnotation($resolving): void
    {
        try {
            $reflectionClass = new ReflectionClass($resolving);
        } catch (ReflectionException $e) {
            return;
        }
        foreach ($reflectionClass->getProperties() as $property) {
            if ($property->isStatic() || (PHP_VERSION_ID >= 80100 && $property->isReadOnly())) {
                continue;
            }
            // Annotations containing properties that implement the AutowiredInterface interface will be automatically injected.
            $reflective      = null;
            $validAnnotation = Utils::array_some($attributes = self::makePropertyAttributes($property), function ($type) use (&$reflective) {
                $hasAutowiredInterface = $type instanceof AutowiredInterface;
                if (false === $hasAutowiredInterface) {
                    return false;
                }
                $reflective = call_user_func($type);
                return $reflective instanceof AutowiredInterface && $reflective instanceof ReflectiveInterface;
            });
            if (false === $validAnnotation) {
                continue;
            }
            // Type constraints expected by the property
            $types = array_filter($propertyTypes = self::makePropertyTypes($property), function (ReflectionNamedType $type) {
                $propertyTypes = [
                    AutowiredInterface::class,
                    ReflectiveInterface::class,
                ];
                return false === Utils::array_some($propertyTypes, function ($propertyType) use ($type) {
                        return is_subclass_of($type->getName(), $propertyType) || ($type->getName() === $propertyType);
                    });
            });
            if (count($propertyTypes) === count($types)) {
                throw new FeignRuntimeException("Annotation implementing AutowiredInterface::class, expecting a return type of either AutowiredInterface::class or ReflectiveInterface::class.");
            }
            // Set property accessibility
            if (!$property->isPublic()) {
                $property->setAccessible(true);
            }
            // Set property value
            $property->setValue($resolving, call_user_func(
                $reflective,
                propertyName: $property->getName(),
                propertyTypes: $types,
                propertyAttributes: $attributes
            ));
        }
    }

    /**
     * Retrieve the collection of reflection objects for the expected return types of a specified class property.
     *
     * @param ReflectionProperty $property
     *
     * @return array
     */
    private static function makePropertyTypes(ReflectionProperty $property): array
    {
        return array_filter(Utils::with($property->getType(), function ($type) {
            return $type instanceof ReflectionUnionType ? $type->getTypes() : ($type ? [$type] : []);
        }), function (ReflectionNamedType $type) {
            return false === $type->isBuiltin();
        });
    }

    /**
     * Retrieve the collection of reflection objects for the expected annotation instances of a specified class property.
     *
     * @param ReflectionProperty $property
     *
     * @return array
     */
    private static function makePropertyAttributes(ReflectionProperty $property): array
    {
        return Utils::mapWithKeys(function (ReflectionAttribute $attribute, int $key) {
            $propertyAttributes   = [
                AutowiredInterface::class,
                FeignClientInterface::class,
                MiddlewareInterface::class,
                RequestAttributeInterface::class,
            ];
            $hasPropertyAttribute = Utils::array_some($propertyAttributes, function ($propertyAttribute) use ($attribute) {
                return is_subclass_of($attribute->getName(), $propertyAttribute);
            });
            return $hasPropertyAttribute ? [$key => $attribute->newInstance()] : false;
        }, $property->getAttributes());
    }

}
