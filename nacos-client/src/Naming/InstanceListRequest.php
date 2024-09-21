<?php

namespace Nacosvel\NacosClient\Naming;

use Nacosvel\NacosClient\Contracts\V1\Naming\InstanceListInterface as V1;
use Nacosvel\NacosClient\Contracts\V2\Naming\InstanceListInterface as V2;
use Nacosvel\NacosClient\NacosRequestResponse;

class InstanceListRequest extends NacosRequestResponse implements V1, V2
{
    protected string $method = self::GET;

    /**
     * Request Uri
     *
     * @var array|string
     */
    protected array|string $uri = [
        'v1' => '/nacos/v1/ns/instance/list',
        'v2' => '/nacos/v2/ns/instance/list',
    ];

    public function v1(string $serviceName): V1
    {
        return new class($serviceName, 'v1') extends InstanceListRequest implements V1, V2 {
            public function __construct(string $serviceName, string $version = null)
            {
                parent::__construct($version);
                $this->setServiceName($serviceName);
            }

            protected function responseSuccessHandler(int $code, string $content, array $decode = []): string
            {
                return parent::responseSuccessHandler($code, json_encode([
                    'code'    => 0,
                    'message' => 'success',
                    'data'    => json_decode($content,true),
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

    public function v2(string $serviceName): V2
    {
        return new class($serviceName, 'v2') extends InstanceListRequest implements V1, V2 {
            public function __construct(string $serviceName, string $version = null)
            {
                parent::__construct($version);
                $this->setServiceName($serviceName);
            }
        };
    }


    protected string $userAgent;
    protected string $clientVersion;
    protected string $namespaceId;
    protected string $groupName;
    protected string $serviceName;
    protected string $clusterName;
    protected string $ip;
    protected int    $port;
    protected bool   $healthyOnly;
    protected string $app;

    /**
     * @version v1
     */
    protected string $clusters;

    /**
     * @return string
     */
    public function getUserAgent(): string
    {
        return $this->userAgent;
    }

    /**
     * @param string $userAgent
     *
     * @return static
     */
    public function setUserAgent(string $userAgent): static
    {
        return $this->setOption('headers', [
            'User-Agent' => $this->userAgent = $userAgent,
        ]);
    }

    /**
     * @return string
     */
    public function getClientVersion(): string
    {
        return $this->clientVersion;
    }

    /**
     * @param string $clientVersion
     *
     * @return static
     */
    public function setClientVersion(string $clientVersion): static
    {
        return $this->setOption('headers', [
            'Client-Version' => $this->clientVersion = $clientVersion,
        ]);
    }

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
     * @return bool
     */
    public function getHealthyOnly(): bool
    {
        return $this->healthyOnly;
    }

    /**
     * @param bool $healthyOnly
     *
     * @return static
     */
    public function setHealthyOnly(bool $healthyOnly): static
    {
        return $this->parameter('healthyOnly', $this->healthyOnly = $healthyOnly);
    }

    /**
     * @return string
     */
    public function getApp(): string
    {
        return $this->app;
    }

    /**
     * @param string $app
     *
     * @return static
     */
    public function setApp(string $app): static
    {
        return $this->parameter('app', $this->app = $app);
    }

    /**
     * @return string
     */
    public function getClusters(): string
    {
        return $this->clusters;
    }

    /**
     * @param string $clusters
     *
     * @return static
     */
    public function setClusters(string $clusters): static
    {
        return $this->parameter('clusters', $this->clusters = $clusters);
    }
}
