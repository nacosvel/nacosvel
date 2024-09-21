<?php

namespace Nacosvel\NacosClient\Config;

use Nacosvel\NacosClient\Contracts\V1\Config\HistoryListConfigInterface as V1;
use Nacosvel\NacosClient\Contracts\V2\Config\HistoryListConfigInterface as V2;
use Nacosvel\NacosClient\NacosRequestResponse;

class HistoryListConfigRequest extends NacosRequestResponse implements V1, V2
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
        'v1' => '/nacos/v1/cs/history?search=accurate',
        'v2' => '/nacos/v2/cs/history/list',
    ];

    public function v1(string $dataId, string $group): V1
    {
        return new class($dataId, $group, 'v1') extends HistoryListConfigRequest implements V1, V2 {
            public function __construct(string $dataId, string $group, string $version = null)
            {
                parent::__construct($version);
                $this->setDataId($dataId)->setGroup($group);
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

    public function v2(string $dataId, string $group): V2
    {
        return new class($dataId, $group, 'v2') extends HistoryListConfigRequest implements V1, V2 {
            public function __construct(string $dataId, string $group, string $version = null)
            {
                parent::__construct($version);
                $this->setDataId($dataId)->setGroup($group);
            }
        };
    }

    protected string $namespaceId;
    protected string $group;
    protected string $dataId;
    protected int    $pageNo;
    protected int    $pageSize;

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
     * @return int
     */
    public function getPageNo(): int
    {
        return $this->pageNo;
    }

    /**
     * @param int $pageNo
     *
     * @return static
     */
    public function setPageNo(int $pageNo): static
    {
        return $this->parameter('pageNo', $this->pageNo = $pageNo);
    }

    /**
     * @return int
     */
    public function getPageSize(): int
    {
        return $this->pageSize;
    }

    /**
     * @param int $pageSize
     *
     * @return static
     */
    public function setPageSize(int $pageSize): static
    {
        return $this->parameter('pageSize', $this->pageSize = $pageSize);
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
