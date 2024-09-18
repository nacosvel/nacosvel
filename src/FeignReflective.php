<?php

namespace Nacosvel\Feign;

use LogicException;
use Nacosvel\Feign\Annotation\Contracts\FeignClientInterface;
use Nacosvel\Feign\Annotation\Contracts\RequestAttributeInterface;
use Nacosvel\Feign\Annotation\Contracts\RequestMappingInterface;
use Nacosvel\Feign\Concerns\ReflectiveTrait;
use Nacosvel\Feign\Contracts\AutowiredInterface;
use Nacosvel\Feign\Contracts\FeignRequestInterface;
use Nacosvel\Feign\Contracts\FeignResponseInterface;
use Nacosvel\Feign\Contracts\MiddlewareInterface;
use Nacosvel\Feign\Contracts\RequestMiddlewareInterface;
use Nacosvel\Feign\Contracts\RequestTemplateInterface;
use Nacosvel\Feign\Contracts\ReflectiveInterface;
use Nacosvel\Feign\Contracts\ResponseMiddlewareInterface;
use Nacosvel\Helper\Utils;
use Psr\Http\Message\ResponseInterface;

class FeignReflective implements AutowiredInterface, ReflectiveInterface
{
    use ReflectiveTrait;

    protected RequestTemplateInterface $requestTemplate;

    public function __construct()
    {
        $this->requestTemplate = new RequestTemplate();
    }

    /**
     * @param string $name
     * @param array  $arguments
     *
     * @return FeignResponseInterface
     */
    public function __call(string $name, array $arguments): FeignResponseInterface
    {
        $requestTemplate = $this->setMethodName($name)->parseAnnotations($name)->buildArguments($arguments)->getRequestTemplate();

        $feignRequest = $this->getFeignRequest($requestTemplate);

        return Utils::tap($this->getFeignResponse(call_user_func($feignRequest)), function ($feignResponse) use ($requestTemplate) {
            call_user_func($feignResponse, $requestTemplate->getReturnTypes());
        });
    }

    private function buildAttributes(array $attributes = []): static
    {
        foreach ($attributes as $attribute) {
            match (true) {
                $attribute instanceof FeignClientInterface => $this->requestTemplate->setFeignClient($attribute),
                $attribute instanceof RequestMappingInterface => $this->requestTemplate->setRequestMapping($attribute),
                $attribute instanceof RequestAttributeInterface => $this->requestTemplate->setRequestAttribute($attribute),
                $attribute instanceof RequestMiddlewareInterface => $this->requestTemplate->addRequestMiddleware($attribute),
                $attribute instanceof ResponseMiddlewareInterface => $this->requestTemplate->addResponseMiddleware($attribute),
                $attribute instanceof MiddlewareInterface => $this->requestTemplate->addMiddleware($attribute),
                default => null,
            };
        }
        return $this;
    }

    private function buildParameters(array $parameters = []): static
    {
        $this->requestTemplate->setParameters($parameters);
        return $this;
    }

    private function buildReturnTypes(array $returnTypes = []): static
    {
        $this->requestTemplate->setReturnTypes($returnTypes);
        return $this;
    }

    private function buildPropertyName(string $propertyName): static
    {
        $this->requestTemplate->setPropertyName($propertyName);
        return $this;
    }

    private function buildMethodName(string $methodName): static
    {
        $this->requestTemplate->setMethodName($methodName);
        return $this;
    }

    /**
     * Parse annotations.
     *
     * @param string $name
     *
     * @return static
     */
    protected function parseAnnotations(string $name): static
    {
        $method = $this->getMethods($name);

        if ($method->count() > 1) {
            throw new LogicException("Multiple definitions exist for method '{$name}'");
        }

        return $this->buildPropertyName($this->getPropertyName())
            ->buildMethodName($this->getMethodName())
            ->buildAttributes($this->getPropertyAttributes())
            ->buildAttributes($this->getAttributes($method->key() ?? '')->current() ?? [])
            ->buildAttributes($this->getMethodsAttributes($method->key() ?? '', $name)->current() ?? [])
            ->buildParameters($this->getMethodsParameters($method->key() ?? '', $name)->current() ?? [])
            ->buildReturnTypes($this->getMethodsReturnTypes($method->key() ?? '', $name)->current() ?? []);
    }

    /**
     * Build Request Body
     *
     * @param array $arguments
     *
     * @return static
     */
    protected function buildArguments(array $arguments): static
    {
        $parameters = $this->requestTemplate->getParameters();
        $arguments  = count($parameters) === count($arguments) ?
            array_combine($parameters, $arguments) :
            (count($arguments) === 1 && is_array($arguments[0]) ? $arguments[0] : $arguments);
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
