<?php

namespace Nacosvel\NacosClient\Config;

use Nacosvel\NacosClient\Contracts\V1\Config\DeleteConfigInterface as V1;
use Nacosvel\NacosClient\Contracts\V2\Config\DeleteConfigInterface as V2;
use Nacosvel\NacosClient\NacosRequestResponse;

class DeleteConfigRequest extends NacosRequestResponse implements V1, V2
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
        'v1' => '/nacos/v1/cs/configs',
        'v2' => '/nacos/v2/cs/config',
    ];

    public function v1(string $dataId, string $group): V1
    {
        return new class($dataId, $group, 'v1') extends DeleteConfigRequest implements V1, V2 {
            public function __construct(string $dataId, string $group, string $version = null)
            {
                parent::__construct($version);
                $this->setDataId($dataId)->setGroup($group);
            }

            protected function responseValid(int $code, string $content, array $decode = []): bool
            {
                return $code == 200 && $content === 'true';
            }

            public function responseSuccessHandler(int $code, string $content = '', array $decode = []): string
            {
                return parent::responseSuccessHandler($code, json_encode([
                    'code'    => 0,
                    'message' => 'success',
                    'data'    => $content,
                ]));
            }

            public function responseFailureHandler(int $code, string $content = '', array $decode = []): string
            {
                return parent::responseFailureHandler($code, json_encode(count($decode) ? $decode : [
                    'code'    => $code,
                    'message' => 'server error',
                    'data'    => $content,
                ]));
            }

        };
    }

    public function v2(string $dataId, string $group): V2
    {
        return new class($dataId, $group, 'v2') extends DeleteConfigRequest implements V1, V2 {
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
