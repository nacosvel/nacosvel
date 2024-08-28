<?php

namespace Nacosvel\NacosClient\Contracts\Naming;

use Nacosvel\NacosClient\Contracts\VersionInterface;

interface RegisterInstanceInterface extends VersionInterface
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
    public function setNamespaceId(string $namespaceId = 'public'): static;

    /**
     * @return string
     */
    public function getGroupName(): string;

    /**
     * @param string $groupName
     *
     * @return static
     */
    public function setGroupName(string $groupName = 'DEFAULT_GROUP'): static;

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
    public function setClusterName(string $clusterName = 'DEFAULT'): static;

    /**
     * @return bool
     */
    public function isHealthy(): bool;

    /**
     * @param bool $healthy
     *
     * @return static
     */
    public function setHealthy(bool $healthy = true): static;

    /**
     * @return float
     */
    public function getWeight(): float;

    /**
     * @param float $weight
     *
     * @return static
     */
    public function setWeight(float $weight = 1.0): static;

    /**
     * @return bool
     */
    public function isEnabled(): bool;

    /**
     * @param bool $enabled
     *
     * @return static
     */
    public function setEnabled(bool $enabled = true): static;

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
    public function isEphemeral(): bool;

    /**
     * @param bool $ephemeral
     *
     * @return static
     */
    public function setEphemeral(bool $ephemeral): static;

}
