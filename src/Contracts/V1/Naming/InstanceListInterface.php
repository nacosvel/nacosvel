<?php

namespace Nacosvel\NacosClient\Contracts\V1\Naming;

use Nacosvel\NacosClient\Contracts\V1\VersionInterface;

interface InstanceListInterface extends VersionInterface
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
     * @return bool
     */
    public function getHealthyOnly(): bool;


    /**
     * @param bool $healthyOnly
     *
     * @return static
     */
    public function setHealthyOnly(bool $healthyOnly): static;

    /**
     * @return string
     */
    public function getClusters(): string;


    /**
     * @param string $clusters
     *
     * @return static
     */
    public function setClusters(string $clusters): static;

}
