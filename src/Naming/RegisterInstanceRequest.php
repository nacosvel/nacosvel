<?php

namespace Nacosvel\NacosClient\Naming;

use Nacosvel\Nacos\NacosRequest;
use Nacosvel\NacosClient\Contracts\Naming\RegisterInstanceInterface;

class RegisterInstanceRequest extends NacosRequest implements RegisterInstanceInterface
{
    /**
     * Request Uri
     *
     * @var array|string
     */
    protected array|string $uri = '/nacos/{Version}/ns/instance';

    public function v1(string $serviceName, string $ip, int $port): RegisterInstanceInterface
    {
        return new class($serviceName, $ip, $port, 'v1') extends RegisterInstanceRequest implements RegisterInstanceInterface {
            public function __construct(string $serviceName, string $ip, int $port, string $version = null)
            {
                parent::__construct($version);
                $this->setServiceName($serviceName)->setIp($ip)->setPort($port);
            }
        };
    }

    public function v2(string $serviceName, string $ip, int $port): RegisterInstanceInterface
    {
        return new class($serviceName, $ip, $port, 'v2') extends RegisterInstanceRequest implements RegisterInstanceInterface {
            public function __construct(string $serviceName, string $ip, int $port, string $version = null)
            {
                parent::__construct($version);
                $this->setServiceName($serviceName)->setIp($ip)->setPort($port);
            }
        };
    }

    public string $namespaceId = 'public';
    public string $groupName   = 'DEFAULT_GROUP';
    public string $serviceName;
    public string $ip;
    public int    $port;
    public string $clusterName = 'DEFAULT';
    public bool   $healthy     = true;
    public float  $weight      = 1.0;
    public bool   $enabled     = true;
    public string $metadata;
    public bool   $ephemeral;

    /**
     * @return string
     */
    public function getNamespaceId(): string
    {
        return $this->namespaceId;
    }

    /**
     * @param string $namespaceId
     *
     * @return static
     */
    public function setNamespaceId(string $namespaceId = 'public'): static
    {
        return $this->parameter('namespaceId', $this->namespaceId = $namespaceId);
    }

    /**
     * @return string
     */
    public function getGroupName(): string
    {
        return $this->groupName;
    }

    /**
     * @param string $groupName
     *
     * @return static
     */
    public function setGroupName(string $groupName = 'DEFAULT_GROUP'): static
    {
        return $this->parameter('groupName', $this->groupName = $groupName);
    }

    /**
     * @return string
     */
    public function getServiceName(): string
    {
        return $this->serviceName;
    }

    /**
     * @param string $serviceName
     *
     * @return static
     */
    public function setServiceName(string $serviceName): static
    {
        return $this->parameter('serviceName', $this->serviceName = $serviceName);
    }

    /**
     * @return string
     */
    public function getIp(): string
    {
        return $this->ip;
    }

    /**
     * @param string $ip
     *
     * @return static
     */
    public function setIp(string $ip): static
    {
        return $this->parameter('ip', $this->ip = $ip);
    }

    /**
     * @return int
     */
    public function getPort(): int
    {
        return $this->port;
    }

    /**
     * @param int $port
     *
     * @return static
     */
    public function setPort(int $port): static
    {
        return $this->parameter('port', $this->port = $port);
    }

    /**
     * @return string
     */
    public function getClusterName(): string
    {
        return $this->clusterName;
    }

    /**
     * @param string $clusterName
     *
     * @return static
     */
    public function setClusterName(string $clusterName = 'DEFAULT'): static
    {
        return $this->parameter('clusterName', $this->clusterName = $clusterName);
    }

    /**
     * @return bool
     */
    public function isHealthy(): bool
    {
        return $this->healthy;
    }

    /**
     * @param bool $healthy
     *
     * @return static
     */
    public function setHealthy(bool $healthy = true): static
    {
        return $this->parameter('healthy', $this->healthy = $healthy);
    }

    /**
     * @return float
     */
    public function getWeight(): float
    {
        return $this->weight;
    }

    /**
     * @param float $weight
     *
     * @return static
     */
    public function setWeight(float $weight = 1.0): static
    {
        return $this->parameter('weight', $this->weight = $weight);
    }

    /**
     * @return bool
     */
    public function isEnabled(): bool
    {
        return $this->enabled;
    }

    /**
     * @param bool $enabled
     *
     * @return static
     */
    public function setEnabled(bool $enabled = true): static
    {
        return $this->parameter('enabled', $this->enabled = $enabled);
    }

    /**
     * @return string
     */
    public function getMetadata(): string
    {
        return $this->metadata;
    }

    /**
     * @param string $metadata
     *
     * @return static
     */
    public function setMetadata(string $metadata): static
    {
        return $this->parameter('metadata', $this->metadata = $metadata);
    }

    /**
     * @return bool
     */
    public function isEphemeral(): bool
    {
        return $this->ephemeral;
    }

    /**
     * @param bool $ephemeral
     *
     * @return static
     */
    public function setEphemeral(bool $ephemeral): static
    {
        return $this->parameter('ephemeral', $this->ephemeral = $ephemeral);
    }

}
