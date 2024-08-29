<?php

namespace Nacosvel\NacosClient\Contracts\V1\Console;


use Nacosvel\NacosClient\Contracts\V1\VersionInterface;

interface CreateNamespaceInterface extends VersionInterface
{
    /**
     * @return string
     */
    public function getNamespaceName(): string;


    /**
     * @param string $namespaceName
     *
     * @return static
     */
    public function setNamespaceName(string $namespaceName): static;


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
    public function getCustomNamespaceId(): string;


    /**
     * @param string $customNamespaceId
     *
     * @return static
     */
    public function setCustomNamespaceId(string $customNamespaceId): static;

}
