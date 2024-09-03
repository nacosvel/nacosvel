<?php

namespace Nacosvel\NacosClient\Naming;

use Nacosvel\NacosClient\Contracts\V1\Naming\CreateServiceInterface as V1;
use Nacosvel\NacosClient\Contracts\V2\Naming\CreateServiceInterface as V2;
use Nacosvel\NacosClient\NacosRequestResponse;

class CreateServiceRequest extends NacosRequestResponse implements V1, V2
{
    /**
     * Request Method
     *
     * @var string
     */
    protected string $method = self::POST;

    /**
     * Request Uri
     *
     * @var array|string
     */
    protected array|string $uri = [
        'v1' => '/nacos/v1/ns/service',
        'v2' => '/nacos/v2/ns/service',
    ];

    public function v1(string $serviceName): V1
    {
        return new class($serviceName, 'v1') extends CreateServiceRequest implements V1, V2 {
            public function __construct(string $serviceName, string $version = null)
            {
                parent::__construct($version);
                $this->setServiceName($serviceName);
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

    public function v2(string $serviceName): V2
    {
        return new class($serviceName, 'v2') extends CreateServiceRequest implements V1, V2 {
            public function __construct(string $serviceName, string $version = null)
            {
                parent::__construct($version);
                $this->setServiceName($serviceName);
            }
        };
    }

    protected string $namespaceId;
    protected string $groupName;
    protected string $serviceName;
    protected string $metadata;
    protected bool   $ephemeral;
    protected float  $protectThreshold;
    protected string $selector;

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

    /**
     * @return float
     */
    public function getProtectThreshold(): float
    {
        return $this->protectThreshold;
    }

    /**
     * @param float $protectThreshold
     *
     * @return static
     */
    public function setProtectThreshold(float $protectThreshold): static
    {
        return $this->parameter('protectThreshold', $this->protectThreshold = $protectThreshold);
    }

    /**
     * @return string
     */
    public function getSelector(): string
    {
        return $this->selector;
    }

    /**
     * @param string $selector
     *
     * @return static
     */
    public function setSelector(string $selector): static
    {
        return $this->parameter('selector', $this->selector = $selector);
    }
}
