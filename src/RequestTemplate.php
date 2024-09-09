<?php

namespace Nacosvel\Feign;

use Nacosvel\Feign\Concerns\RequestTemplateTrait;
use Nacosvel\Feign\Contracts\RequestTemplateInterface;

class RequestTemplate implements RequestTemplateInterface
{
    use RequestTemplateTrait;

    protected string $alias = '';

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

}
