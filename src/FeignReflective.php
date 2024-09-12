<?php

namespace Nacosvel\Feign;

use ArrayAccess;
use Nacosvel\Feign\Annotation\Contracts\FeignClientInterface;
use Nacosvel\Feign\Annotation\Contracts\RequestMappingInterface;
use Nacosvel\Feign\Contracts\FeignRequestInterface;
use Nacosvel\Feign\Contracts\FeignResponseInterface;
use Nacosvel\Feign\Contracts\RequestTemplateInterface;
use Nacosvel\Feign\Contracts\ReflectiveInterface;
use Nacosvel\Helper;
use Psr\Http\Message\ResponseInterface;
use ReflectionClass;
use ReflectionNamedType;
use ReflectionUnionType;

class FeignReflective implements ReflectiveInterface
{
    protected RequestTemplateInterface $requestTemplate;

    /**
     * @param string            $propertyName
     * @param ReflectionClass[] $reflectionClasses
     */
    public function __construct(
        protected string $propertyName = '',
        protected array  $reflectionClasses = [],
    )
    {
        $this->requestTemplate = new RequestTemplate();
        $this->requestTemplate->setAlias($this->propertyName);
    }

    /**
     * @param string $name
     * @param array  $arguments
     *
     * @return FeignResponseInterface
     */
    public function __call(string $name, array $arguments): FeignResponseInterface
    {
        $requestTemplate = $this->parseAnnotations($name)->buildArguments($arguments)->getRequestTemplate();

        $feignRequest = $this->getFeignRequest($requestTemplate);

        return Helper\tap($this->getFeignResponse(call_user_func($feignRequest)), function ($feignResponse) use ($requestTemplate) {
            call_user_func($feignResponse, $requestTemplate->getReturnTypes());
        });
    }

    /**
     * Parse annotations.
     *
     * @param string $name
     *
     * @return $this
     */
    protected function parseAnnotations(string $name): static
    {
        foreach ($this->reflectionClasses as $reflectionClass) {
            // check if method exists
            if (false === $reflectionClass->hasMethod($name)) {
                continue;
            }
            // get an instance of the annotations for the interface
            foreach ($reflectionClass->getAttributes() as $attribute) {
                if (is_subclass_of($attribute->getName(), FeignClientInterface::class)) {
                    $this->requestTemplate->setFeignClient($attribute->newInstance());
                }
            }
            // get the reflection object of the $name method
            try {
                $reflectionMethod = $reflectionClass->getMethod($name);
            } catch (\ReflectionException $e) {
                continue;
            }
            // get the return types of the $name method
            $returnTypes = array_map(function (?ReflectionNamedType $type) {
                if (is_null($type) || $type->allowsNull() || $type->isBuiltin()) {
                    return false;
                }
                if (is_subclass_of($type->getName(), ArrayAccess::class) || $type->getName() === ArrayAccess::class) {
                    return $type->getName();
                }
                return false;
            }, Helper\with($reflectionMethod->getReturnType(), function ($type) {
                return $type instanceof ReflectionUnionType ? $type->getTypes() : ($type ? [$type] : []);
            }));
            $this->requestTemplate->setReturnTypes(array_filter($returnTypes));
            // get the parameters of the $name method
            foreach ($reflectionMethod->getParameters() as $parameter) {
                $this->requestTemplate->pushParameter($parameter->getName());
            }
            // get an instance of the annotations for the $name method
            foreach ($reflectionMethod->getAttributes() as $attribute) {
                if (is_subclass_of($attribute->getName(), RequestMappingInterface::class)) {
                    $this->requestTemplate->setRequestMapping($attribute->newInstance());
                }
            }
        }
        $this->requestTemplate->setAction($name);
        return $this;
    }

    /**
     * Build Request Body
     *
     * @param array $arguments
     *
     * @return $this
     */
    protected function buildArguments(array $arguments): static
    {
        $parameters = $this->requestTemplate->getParameters();
        $arguments  = count($parameters) === count($arguments) ? array_combine($parameters, $arguments) : array_merge(...$arguments);
        $this->requestTemplate->setBody($arguments);
        return $this;
    }

    protected function getRequestTemplate(): RequestTemplateInterface
    {
        return $this->requestTemplate;
    }

    protected function getFeignRequest(RequestTemplateInterface $requestTemplate): FeignRequestInterface
    {
        return new FeignRequest($requestTemplate);
    }

    protected function getFeignResponse(ResponseInterface $response): FeignResponseInterface
    {
        return new FeignResponse($response);
    }

}
