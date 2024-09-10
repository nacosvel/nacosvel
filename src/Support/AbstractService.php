<?php

namespace Nacosvel\Feign\Support;

use Nacosvel\Feign\Annotation\Contracts\FeignClientInterface;
use Nacosvel\Feign\Annotation\Contracts\RequestMappingInterface;
use Nacosvel\Feign\Contracts\FeignResponseInterface;
use Nacosvel\Feign\Contracts\RequestTemplateInterface;
use Nacosvel\Feign\Contracts\ServiceInterface;
use Nacosvel\Feign\FeignBuilder;
use Nacosvel\Feign\FeignRequest;
use Nacosvel\Feign\RequestTemplate;
use ReflectionClass;

abstract class AbstractService implements ServiceInterface
{
    protected RequestTemplateInterface $requestTemplate;

    /**
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
        $parameters = [];
        foreach ($this->reflectionClasses as $reflectionClass) {
            if (false === $reflectionClass->hasMethod($name)) {
                continue;
            }
            foreach ($reflectionClass->getAttributes() as $attribute) {
                if (is_subclass_of($attribute->getName(), FeignClientInterface::class)) {
                    $this->requestTemplate->setFeignClient($attribute->newInstance());
                }
            }
            try {
                $reflectionMethod = $reflectionClass->getMethod($name);
            } catch (\ReflectionException $e) {
                continue;
            }
            foreach ($reflectionMethod->getParameters() as $parameter) {
                $parameters[] = $parameter->getName();
            }
            foreach ($reflectionMethod->getAttributes() as $attribute) {
                if (is_subclass_of($attribute->getName(), RequestMappingInterface::class)) {
                    $this->requestTemplate->setRequestMapping($attribute->newInstance());
                }
            }
        }

        if (count($parameters) === count($arguments)) {
            $this->requestTemplate->setParameters($arguments = array_combine($parameters, $arguments));
        }

        return (new FeignBuilder(new FeignRequest($this->requestTemplate->setAction($name)->setBody($arguments))))->build();
    }

}
