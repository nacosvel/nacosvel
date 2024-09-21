<?php

namespace Nacosvel\NacosClient\Contracts\V1\Naming;

use Nacosvel\NacosClient\Contracts\V1\VersionInterface;

interface UpdateInstanceInterface extends VersionInterface
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
    public function getIp(): string;


    /**
     * @param string $ip
     *
     * @return static
     */
    public function setIp(string $ip): static;


    /**
     * @return int
     */
    public function getPort(): int;


    /**
     * @param int $port
     *
     * @return static
     */
    public function setPort(int $port): static;


    /**
     * @return string
     */
    public function getClusterName(): string;


    /**
     * @param string $clusterName
     *
     * @return static
     */
    public function setClusterName(string $clusterName): static;


    /**
     * @return bool
     */
    public function getHealthy(): bool;


    /**
     * @param bool $healthy
     *
     * @return static
     */
    public function setHealthy(bool $healthy): static;


    /**
     * @return float
     */
    public function getWeight(): float;


    /**
     * @param float $weight
     *
     * @return static
     */
    public function setWeight(float $weight): static;


    /**
     * @return bool
     */
    public function getEnabled(): bool;


    /**
     * @param bool $enabled
     *
     * @return static
     */
    public function setEnabled(bool $enabled): static;


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
}
