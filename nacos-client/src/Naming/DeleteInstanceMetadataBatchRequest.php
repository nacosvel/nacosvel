<?php

namespace Nacosvel\NacosClient\Naming;

use Nacosvel\NacosClient\Contracts\V1\Naming\DeleteInstanceMetadataBatchInterface as V1;
use Nacosvel\NacosClient\Contracts\V2\Naming\DeleteInstanceMetadataBatchInterface as V2;
use Nacosvel\NacosClient\NacosRequestResponse;

class DeleteInstanceMetadataBatchRequest extends NacosRequestResponse implements V1, V2
{
    /**
     * Request Method
     *
     * @var string
     */
    protected string $method = self::DELETE;

    /**
     * Request Uri
     *
     * @var array|string
     */
    protected array|string $uri = [
        'v1' => '/nacos/v1/ns/instance/metadata/batch',
        'v2' => '/nacos/v2/ns/instance/metadata/batch',
    ];

    public function v1(string $namespaceId, string $serviceName, string $metadata): V1
    {
        return new class($namespaceId, $serviceName, $metadata, 'v1') extends DeleteInstanceMetadataBatchRequest implements V1, V2 {
            public function __construct(string $namespaceId, string $serviceName, string $metadata, string $version = null)
            {
                parent::__construct($version);
                $this->setNamespaceId($namespaceId)->setServiceName($serviceName)->setMetadata($metadata);
            }

            protected function responseSuccessHandler(int $code, string $content, array $decode = []): string
            {
                return parent::responseSuccessHandler($code, json_encode([
                    'code'    => 0,
                    'message' => 'success',
                    'data'    => json_decode($content, true),
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

    public function v2(string $serviceName, string $metadata): V2
    {
        return new class($serviceName, $metadata, 'v2') extends DeleteInstanceMetadataBatchRequest implements V1, V2 {
            public function __construct(string $serviceName, string $metadata, string $version = null)
            {
                parent::__construct($version);
                $this->setServiceName($serviceName)->setMetadata($metadata);
            }
        };
    }

    protected string $namespaceId;
    protected string $groupName;
    protected string $serviceName;
    protected string $consistencyType;
    protected string $instances;
    protected string $metadata;

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
    public function getConsistencyType(): string
    {
        return $this->consistencyType;
    }

    /**
     * @param string $consistencyType
     *
     * @return static
     */
    public function setConsistencyType(string $consistencyType): static
    {
        return $this->parameter('consistencyType', $this->consistencyType = $consistencyType);
    }

    /**
     * @return string
     */
    public function getInstances(): string
    {
        return $this->instances;
    }

    /**
     * @param string $instances
     *
     * @return static
     */
    public function setInstances(string $instances): static
    {
        return $this->parameter('instances', $this->instances = $instances);
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
}
