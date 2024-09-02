<?php

namespace Nacosvel\NacosClient\Contracts\Naming;

use Nacosvel\NacosClient\Contracts\V1\VersionInterface;

interface UpdateOperatorSwitchesInterface extends VersionInterface
{
    /**
     * @return string
     */
    public function getEntry(): string;


    /**
     * @param string $entry
     *
     * @return static
     */
    public function setEntry(string $entry): static;


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


    /**
     * @return bool
     */
    public function getDebug(): bool;


    /**
     * @param bool $debug
     *
     * @return static
     */
    public function setDebug(bool $debug): static;
}
