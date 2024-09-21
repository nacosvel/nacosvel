<?php

namespace Nacosvel\Feign;

use ArrayAccess;
use Nacosvel\Feign\Contracts\ConfigurationInterface;
use Nacosvel\Feign\Contracts\FeignResponseInterface;
use Nacosvel\Feign\Contracts\RequestTemplateInterface;
use Nacosvel\Feign\Support\Transformation;
use Nacosvel\Helper\Utils;
use Psr\Http\Message\ResponseInterface;
use function Nacosvel\Container\Interop\application;

class FeignResponse implements FeignResponseInterface
{
    protected array                     $data            = [];
    protected array                     $maps            = [];
    protected string                    $raw             = '';
    protected ?RequestTemplateInterface $requestTemplate = null;

    public function __construct(
        protected ResponseInterface $response
    )
    {
        try {
            $this->raw = $contents = $response->getBody()->getContents();
            $data      = json_decode($contents, true);
            if (json_last_error() === JSON_ERROR_NONE) {
                $this->data = is_array($data) ? $data : [];
            }
        } catch (\Exception $exception) {
            //
        } finally {
            $response->getBody()->rewind();
        }
    }

    public function __invoke(RequestTemplateInterface $requestTemplate): void
    {
        foreach (($this->requestTemplate = $requestTemplate)->getReturnTypes() as $type => $reflectionNamedType) {
            foreach (application(ConfigurationInterface::class)->converters() ?? [] as $abstract => $concrete) {
                if (
                    is_subclass_of($concrete, ArrayAccess::class) && is_object($concrete) &&
                    ($abstract === '*' || is_subclass_of($type, $abstract) || $type === $abstract) &&
                    ($abstract === '*' || is_subclass_of($concrete, $abstract) || get_class($concrete) === $abstract)
                ) {
                    $this->maps[get_class($concrete)] = Utils::array_replicate($this->data, function () use ($concrete) {
                        return clone $concrete;
                    });
                }
            }
        }
        $this->maps[Transformation::class] = Utils::array_replicate($this->data, function () {
            return new Transformation();
        });
    }

    public function __call(string $name, array $arguments)
    {
        foreach ($this->maps as $map) {
            if (method_exists($map, $name)) {
                return call_user_func_array([$map, $name], $arguments);
            }
        }

        if (method_exists($this, $name)) {
            return call_user_func_array([$this, $name], $arguments);
        }

        foreach ($this->maps as $map) {
            if (method_exists($map, '__call')) {
                return call_user_func_array([$map, '__call'], $arguments);
            }
        }

        return null;
    }

    /**
     * @return string
     */
    protected function getRawContents(): string
    {
        return $this->raw;
    }

    /**
     * @return ResponseInterface
     */
    protected function getOriginalResponse(): ResponseInterface
    {
        return $this->response;
    }

    /**
     * @return array
     */
    protected function toArray(): array
    {
        return $this->data;
    }

}
