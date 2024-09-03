<?php

namespace Nacosvel\NacosClient\Config;

use Nacosvel\NacosClient\Contracts\V1\Config\HistoryConfigInterface as V1;
use Nacosvel\NacosClient\Contracts\V2\Config\HistoryConfigInterface as V2;
use Nacosvel\NacosClient\NacosRequestResponse;

class HistoryConfigRequest extends NacosRequestResponse implements V1, V2
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
    protected array|string $uri = [
        'v1' => '/nacos/v1/cs/history',
        'v2' => '/nacos/v2/cs/history',
    ];

    public function v1(string $dataId, string $group, int|string $nid): V1
    {
        return new class($dataId, $group, $nid, 'v1') extends HistoryConfigRequest implements V1, V2 {
            public function __construct(string $dataId, string $group, int|string $nid, string $version = null)
            {
                parent::__construct($version);
                $this->setDataId($dataId)->setGroup($group)->setNid($nid);
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

    public function v2(string $dataId, string $group, int|string $nid): V2
    {
        return new class($dataId, $group, $nid, 'v2') extends HistoryConfigRequest implements V1, V2 {
            public function __construct(string $dataId, string $group, int|string $nid, string $version = null)
            {
                parent::__construct($version);
                $this->setDataId($dataId)->setGroup($group)->setNid($nid);
            }
        };
    }

    protected string     $namespaceId;
    protected string     $group;
    protected string     $dataId;
    protected int|string $nid;

    /**
     * @version  v1
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
     * @return int|string
     */
    public function getNid(): int|string
    {
        return $this->nid;
    }

    /**
     * @param int|string $nid
     *
     * @return static
     */
    public function setNid(int|string $nid): static
    {
        return $this->parameter('nid', $this->nid = $nid);
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
