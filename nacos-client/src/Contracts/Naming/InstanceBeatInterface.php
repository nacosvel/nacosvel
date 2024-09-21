<?php

namespace Nacosvel\NacosClient\Contracts\Naming;

use Nacosvel\NacosClient\Contracts\V1\VersionInterface;

interface InstanceBeatInterface extends VersionInterface
{
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
     * @return bool
     */
    public function isEphemeral(): bool;


    /**
     * @param bool $ephemeral
     *
     * @return static
     */
    public function setEphemeral(bool $ephemeral): static;


    /**
     * @return string
     */
    public function getBeat(): string;


    /**
     * @param string $beat
     *
     * @return static
     */
    public function setBeat(string $beat): static;

}
