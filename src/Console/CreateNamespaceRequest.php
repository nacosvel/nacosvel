<?php

namespace Nacosvel\NacosClient\Console;

use Nacosvel\NacosClient\Contracts\V1\Console\CreateNamespaceInterface as V1;
use Nacosvel\NacosClient\Contracts\V2\Console\CreateNamespaceInterface as V2;
use Nacosvel\NacosClient\NacosRequestResponse;

class CreateNamespaceRequest extends NacosRequestResponse implements V1, V2
{
    /**
     * Request Uri
     *
     * @var array|string
     */
    protected array|string $uri = [
        'v1' => '/nacos/v1/console/namespaces',
        'v2' => '/nacos/v2/console/namespace',
    ];

    public function v1(string $customNamespaceId, string $namespaceName): V1
    {
        return new class($customNamespaceId, $namespaceName, 'v1') extends CreateNamespaceRequest implements V1, V2 {
            public function __construct(string $customNamespaceId, string $namespaceName, string $version = null)
            {
                parent::__construct($version);
                $this->setCustomNamespaceId($customNamespaceId)->setNamespaceName($namespaceName);
            }

            protected function responseValid(int $code, string $content, array $decode = []): bool
            {
                return $code == 200 && $content === 'true';
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
                    'code'    => 22000,
                    'message' => 'illegal namespace',
                    'data'    => $content,
                ]));
            }
        };
    }

    public function v2(string $namespaceId, string $namespaceName): V2
    {
        return new class($namespaceId, $namespaceName, 'v2') extends CreateNamespaceRequest implements V1, V2 {
            public function __construct(string $namespaceId, string $namespaceName, string $version = null)
            {
                parent::__construct($version);
                $this->setNamespaceId($namespaceId)->setNamespaceName($namespaceName);
            }
        };
    }


    protected string $namespaceId;
    protected string $namespaceName;
    protected string $namespaceDesc;

    /**
     * @version v1
     */
    protected string $customNamespaceId;

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
    public function getNamespaceName(): string
    {
        return $this->namespaceName;
    }

    /**
     * @param string $namespaceName
     *
     * @return static
     */
    public function setNamespaceName(string $namespaceName): static
    {
        return $this->parameter('namespaceName', $this->namespaceName = $namespaceName);
    }

    /**
     * @return string
     */
    public function getNamespaceDesc(): string
    {
        return $this->namespaceDesc;
    }

    /**
     * @param string $namespaceDesc
     *
     * @return static
     */
    public function setNamespaceDesc(string $namespaceDesc): static
    {
        return $this->parameter('namespaceDesc', $this->namespaceDesc = $namespaceDesc);
    }

    /**
     * @return string
     */
    public function getCustomNamespaceId(): string
    {
        return $this->customNamespaceId;
    }

    /**
     * @param string $customNamespaceId
     *
     * @return static
     */
    public function setCustomNamespaceId(string $customNamespaceId): static
    {
        return $this->parameter('customNamespaceId', $this->customNamespaceId = $customNamespaceId);
    }
}
