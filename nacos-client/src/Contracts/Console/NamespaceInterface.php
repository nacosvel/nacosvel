<?php

namespace Nacosvel\NacosClient\Contracts\Console;

use Nacosvel\NacosClient\Contracts\V2\VersionInterface;

interface NamespaceInterface extends VersionInterface
{
    /**
     * @return string
     */
    public function getNamespaceId(): string;

    /**
     * @param string $namespaceId
     *
     * @return static
     */
    public function setNamespaceId(string $namespaceId): static;

}
