<?php

namespace Nacosvel\Feign;

use Nacosvel\Feign\Concerns\RequestTemplateTrait;
use Nacosvel\Feign\Contracts\RequestTemplateInterface;

class RequestTemplate implements RequestTemplateInterface
{
    use RequestTemplateTrait;

    protected string $alias      = '';
    protected array  $parameters = [];

    /**
     * @return string
     */
    public function getAlias(): string
    {
        return $this->alias;
    }

    /**
     * @param string $alias
     *
     * @return RequestTemplate
     */
    public function setAlias(string $alias): static
    {
        $this->alias = $alias;
        return $this;
    }

    /**
     * @return array
     */
    public function getParameters(): array
    {
        return $this->parameters;
    }

    /**
     * @param array $parameters
     *
     * @return static
     */
    public function setParameters(array $parameters): static
    {
        $this->parameters = $parameters;
        return $this;
    }

}
