<?php

namespace Nacosvel\NacosClient\Naming;

use Nacosvel\NacosClient\Contracts\V1\Naming\ServiceListInterface as V1;
use Nacosvel\NacosClient\Contracts\V2\Naming\ServiceListInterface as V2;
use Nacosvel\NacosClient\NacosRequestResponse;

class ServiceListRequest extends NacosRequestResponse implements V1, V2
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
        'v1' => '/nacos/v1/ns/service/list',
        'v2' => '/nacos/v2/ns/service/list',
    ];

    public function v1(int $pageNo = 1, int $pageSize = 20): V1
    {
        return new class($pageNo, $pageSize, 'v1') extends ServiceListRequest implements V1, V2 {
            public function __construct(int $pageNo = 1, int $pageSize = 20, string $version = null)
            {
                parent::__construct($version);
                $this->setPageNo($pageNo)->setPageSize($pageSize);
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

    public function v2(string $selector): V2
    {
        return new class($selector, 'v2') extends ServiceListRequest implements V1, V2 {
            public function __construct(string $selector, string $version = null)
            {
                parent::__construct($version);
                $this->setSelector($selector);
            }
        };
    }

    protected string $namespaceId;
    protected string $groupName;
    protected string $selector;
    protected int    $pageNo;
    protected int    $pageSize;

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
}
