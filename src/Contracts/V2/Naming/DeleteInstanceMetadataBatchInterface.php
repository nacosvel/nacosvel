<?php

namespace Nacosvel\NacosClient\Contracts\V2\Naming;

use Nacosvel\NacosClient\Contracts\V2\VersionInterface;

interface DeleteInstanceMetadataBatchInterface extends VersionInterface
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


    /**
     * @return string
     */
    public function getConsistencyType(): string;


    /**
     * @param string $consistencyType
     *
     * @return static
     */
    public function setConsistencyType(string $consistencyType): static;


    /**
     * @return string
     */
    public function getInstances(): string;


    /**
     * @param string $instances
     *
     * @return static
     */
    public function setInstances(string $instances): static;


    /**
     * @return string
     */
    public function getMetadata(): string;


    /**
     * @param string $metadata
     *
     * @return static
     */
    public function setMetadata(string $metadata): static;
}
