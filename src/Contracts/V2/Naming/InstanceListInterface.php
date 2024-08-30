<?php

namespace Nacosvel\NacosClient\Contracts\V2\Naming;

use Nacosvel\NacosClient\Contracts\V2\VersionInterface;

interface InstanceListInterface extends VersionInterface
{
    /**
     * @return string
     */
    public function getUserAgent(): string;


    /**
     * @param string $userAgent
     *
     * @return static
     */
    public function setUserAgent(string $userAgent): static;


    /**
     * @return string
     */
    public function getClientVersion(): string;


    /**
     * @param string $clientVersion
     *
     * @return static
     */
    public function setClientVersion(string $clientVersion): static;


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
    public function getClusterName(): string;


    /**
     * @param string $clusterName
     *
     * @return static
     */
    public function setClusterName(string $clusterName): static;


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
    public function getApp(): string;

    /**
     * @param string $app
     *
     * @return static
     */
    public function setApp(string $app): static;
}
