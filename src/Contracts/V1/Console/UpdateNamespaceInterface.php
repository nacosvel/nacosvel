<?php

namespace Nacosvel\NacosClient\Contracts\V1\Console;

use Nacosvel\NacosClient\Contracts\V1\VersionInterface;

interface UpdateNamespaceInterface extends VersionInterface
{
    /**
     * @return string
     */
    public function getNamespaceDesc(): string;


    /**
     * @param string $namespaceDesc
     *
     * @return static
     */
    public function setNamespaceDesc(string $namespaceDesc): static;


    /**
     * @return string
     */
    public function getNamespace(): string;


    /**
     * @param string $namespace
     *
     * @return static
     */
    public function setNamespace(string $namespace): static;


    /**
     * @return string
     */
    public function getNamespaceShowName(): string;


    /**
     * @param string $namespaceShowName
     *
     * @return static
     */
    public function setNamespaceShowName(string $namespaceShowName): static;

}
