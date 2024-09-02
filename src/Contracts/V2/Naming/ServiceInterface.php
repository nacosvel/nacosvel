<?php

namespace Nacosvel\NacosClient\Contracts\V2\Naming;

use Nacosvel\NacosClient\Contracts\V2\VersionInterface;

interface ServiceInterface extends VersionInterface
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


    /**
     * @return string
     */
    public function getGroupName(): string;


    /**
     * @param string $groupName
     *
     * @return static
     */
    public function setGroupName(string $groupName): static;


    /**
     * @return string
     */
    public function getServiceName(): string;


    /**
     * @param string $serviceName
     *
     * @return static
     */
    public function setServiceName(string $serviceName): static;
}
