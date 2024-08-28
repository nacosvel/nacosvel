<?php

namespace Nacosvel\NacosClient\Config;

use Nacosvel\Nacos\NacosRequest;
use Nacosvel\NacosClient\Contracts\V1\Config\RequestConfigInterface as V1;
use Nacosvel\NacosClient\Contracts\V2\Config\RequestConfigInterface as V2;

class RequestConfigRequest extends NacosRequest implements V1, V2
{
    /**
     * Request Method
     *
     * @var string
     */
    protected string $method = self::GET;
    /**
     * Request Uri
     *
     * @var array|string
     */
    protected array|string $uri = '/nacos/{Version}/cs/config';

    public function v1(string $group, string $dataId): V1
    {
        return new class($group, $dataId, 'v1') extends RequestConfigRequest implements V1, V2 {
            public function __construct(string $group, string $dataId, string $version = null)
            {
                parent::__construct($version);
                $this->setGroup($group)->setDataId($dataId);
            }
        };
    }

    public function v2(string $group, string $dataId): V2
    {
        return new class($group, $dataId, 'v2') extends RequestConfigRequest implements V1, V2 {
            public function __construct(string $group, string $dataId, string $version = null)
            {
                parent::__construct($version);
                $this->setGroup($group)->setDataId($dataId);
            }
        };
    }

    protected string $namespaceId;
    protected string $group;
    protected string $dataId;
    protected string $tag;
    /**
     * @version v1
     */
    protected string $tenant;

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
    public function getGroup(): string
    {
        return $this->group;
    }

    /**
     * @param string $group
     *
     * @return static
     */
    public function setGroup(string $group): static
    {
        return $this->parameter('group', $this->group = $group);
    }

    /**
     * @return string
     */
    public function getDataId(): string
    {
        return $this->dataId;
    }

    /**
     * @param string $dataId
     *
     * @return static
     */
    public function setDataId(string $dataId): static
    {
        return $this->parameter('dataId', $this->dataId = $dataId);
    }

    /**
     * @return string
     */
    public function getTag(): string
    {
        return $this->tag;
    }

    /**
     * @param string $tag
     *
     * @return static
     */
    public function setTag(string $tag): static
    {
        return $this->parameter('tag', $this->tag = $tag);
    }

    /**
     * @return string
     */
    public function getTenant(): string
    {
        return $this->tenant;
    }

    /**
     * @param string $tenant
     *
     * @return static
     */
    public function setTenant(string $tenant): static
    {
        return $this->parameter('tenant', $this->tenant = $tenant);
    }

}
