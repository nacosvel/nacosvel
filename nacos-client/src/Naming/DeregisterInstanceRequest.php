<?php

namespace Nacosvel\NacosClient\Naming;

use Nacosvel\NacosClient\Contracts\V1\Naming\DeregisterInstanceInterface as V1;
use Nacosvel\NacosClient\Contracts\V2\Naming\DeregisterInstanceInterface as V2;
use Nacosvel\NacosClient\NacosRequestResponse;

class DeregisterInstanceRequest extends NacosRequestResponse implements V1, V2
{
    protected string $method = self::DELETE;

    /**
     * Request Uri
     *
     * @var array|string
     */
    protected array|string $uri = [
        'v1' => '/nacos/v1/ns/instance',
        'v2' => '/nacos/v2/ns/instance',
    ];

    public function v1(string $serviceName, string $ip, int $port): V1
    {
        return new class($serviceName, $ip, $port, 'v1') extends DeregisterInstanceRequest implements V1, V2 {
            public function __construct(string $serviceName, string $ip, int $port, string $version = null)
            {
                parent::__construct($version);
                $this->setServiceName($serviceName)->setIp($ip)->setPort($port);
            }

            protected function responseValid(int $code, string $content, array $decode = []): bool
            {
                return $code == 200 && $content === 'ok';
            }

            protected function responseSuccessHandler(int $code, string $content, array $decode = []): string
            {
                return parent::responseSuccessHandler($code, json_encode([
                    'code'    => 0,
                    'message' => 'success',
                    'data'    => $content,
                ]));
            }

            protected function responseFailureHandler(int $code, string $content, array $decode = []): string
            {
                return parent::responseFailureHandler($code, json_encode(count($decode) ? $decode : [
                    'code'    => $code,
                    'message' => 'Internal Server Error',
                    'data'    => $content,
                ]));
            }
        };
    }

    public function v2(string $serviceName, string $ip, int $port): V2
    {
        return new class($serviceName, $ip, $port, 'v2') extends DeregisterInstanceRequest implements V1, V2 {
            public function __construct(string $serviceName, string $ip, int $port, string $version = null)
            {
                parent::__construct($version);
                $this->setServiceName($serviceName)->setIp($ip)->setPort($port);
            }
        };
    }


    protected string $namespaceId;
    protected string $groupName;
    protected string $serviceName;
    protected string $ip;
    protected int    $port;
    protected string $clusterName;
    protected bool   $healthy;
    protected float  $weight;
    protected bool   $enabled;
    protected string $metadata;
    protected bool   $ephemeral;

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
    public function setNamespaceId(string $namespaceId): static
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
    public function setGroupName(string $groupName): static
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
    public function setClusterName(string $clusterName): static
    {
        return $this->parameter('clusterName', $this->clusterName = $clusterName);
    }

    /**
     * @return bool
     */
    public function getHealthy(): bool
    {
        return $this->healthy;
    }

    /**
     * @param bool $healthy
     *
     * @return static
     */
    public function setHealthy(bool $healthy): static
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
    public function setWeight(float $weight): static
    {
        return $this->parameter('weight', $this->weight = $weight);
    }

    /**
     * @return bool
     */
    public function getEnabled(): bool
    {
        return $this->enabled;
    }

    /**
     * @param bool $enabled
     *
     * @return static
     */
    public function setEnabled(bool $enabled): static
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
    public function getEphemeral(): bool
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
