<?php

namespace Nacosvel\NacosClient\Contracts\V2\Naming;

use Nacosvel\NacosClient\Contracts\V2\VersionInterface;

interface CreateServiceInterface extends VersionInterface
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
    public function getMetadata(): string;


    /**
     * @param string $metadata
     *
     * @return static
     */
    public function setMetadata(string $metadata): static;


    /**
     * @return bool
     */
    public function getEphemeral(): bool;


    /**
     * @param bool $ephemeral
     *
     * @return static
     */
    public function setEphemeral(bool $ephemeral): static;


    /**
     * @return float
     */
    public function getProtectThreshold(): float;


    /**
     * @param float $protectThreshold
     *
     * @return static
     */
    public function setProtectThreshold(float $protectThreshold): static;


    /**
     * @return string
     */
    public function getSelector(): string;


    /**
     * @param string $selector
     *
     * @return static
     */
    public function setSelector(string $selector): static;

}
