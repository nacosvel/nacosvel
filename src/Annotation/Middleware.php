<?php

namespace Nacosvel\Feign\Annotation;

use Attribute;
use Nacosvel\Feign\Contracts\MiddlewareInterface;
use Nacosvel\Feign\Contracts\RequestMiddlewareInterface;
use Nacosvel\Feign\Contracts\ResponseMiddlewareInterface;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;

#[Attribute(Attribute::TARGET_CLASS | Attribute::TARGET_PROPERTY | Attribute::TARGET_METHOD | Attribute::IS_REPEATABLE)]
class Middleware implements MiddlewareInterface
{
    private string $request  = '';
    private string $response = '';

    public function __construct(
        string $request,
        string $response,
    )
    {
        $this->setRequest($request)->setResponse($response);
    }

    /**
     * @return string
     */
    public function getRequest(): string
    {
        return $this->request;
    }

    /**
     * @param string $request
     *
     * @return static
     */
    public function setRequest(string $request): static
    {
        $this->request = $request;
        return $this;
    }

    /**
     * @return string
     */
    public function getResponse(): string
    {
        return $this->response;
    }

    /**
     * @param string $response
     *
     * @return static
     */
    public function setResponse(string $response): static
    {
        $this->response = $response;
        return $this;
    }

    public function __invoke(callable $handler): callable
    {
        return function (RequestInterface $request, array $options) use ($handler) {
            $requestHandler = is_subclass_of($this->getRequest(), RequestMiddlewareInterface::class) ?
                new ($this->getRequest())() :
                $this;
            return $handler(call_user_func([$requestHandler, 'request'], $request, $options), $options)->then(
                function (ResponseInterface $response) use ($request, $options) {
                    $responseHandler = is_subclass_of($this->getResponse(), ResponseMiddlewareInterface::class) ?
                        new ($this->getResponse())() :
                        $this;
                    return call_user_func([$responseHandler, 'response'], $request, $response, $options);
                }
            );
        };
    }

    public function request(RequestInterface $request, array $options): RequestInterface
    {
        return $request;
    }

    public function response(RequestInterface $request, ResponseInterface $response, array $options): ResponseInterface
    {
        return $response;
    }

}
