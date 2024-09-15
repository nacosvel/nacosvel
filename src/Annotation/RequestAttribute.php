<?php

namespace Nacosvel\Feign\Annotation;

use Attribute;
use Nacosvel\Feign\Annotation\Contracts\RequestAttributeInterface;

#[Attribute(Attribute::TARGET_CLASS | Attribute::TARGET_PROPERTY | Attribute::TARGET_METHOD)]
class RequestAttribute implements RequestAttributeInterface
{
    public const QUERY       = 'query';
    public const FORM_PARAMS = 'form_params';
    public const BODY        = 'body';
    public const JSON        = 'json';
    public const MULTIPART   = 'multipart';

    public function __construct(protected string $value)
    {
        $this->setValue($this->value);
    }

    /**
     * @return string
     */
    public function getValue(): string
    {
        return $this->value;
    }

    /**
     * @param string $value
     *
     * @return static
     */
    public function setValue(string $value): static
    {
        $this->value = $value;
        return $this;
    }

}
