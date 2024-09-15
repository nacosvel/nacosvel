<?php

namespace Nacosvel\Feign\Annotation\Contracts;

interface RequestAttributeInterface
{
    /**
     * @return string
     */
    public function getValue(): string;

    /**
     * @param string $value
     *
     * @return static
     */
    public function setValue(string $value): static;

}
