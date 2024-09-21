<?php

namespace Nacosvel\NacosClient\Console;

use Nacosvel\NacosClient\Contracts\V1\Console\DeleteNamespaceInterface as V1;
use Nacosvel\NacosClient\Contracts\V2\Console\DeleteNamespaceInterface as V2;
use Nacosvel\NacosClient\NacosRequestResponse;

class DeleteNamespaceRequest extends NacosRequestResponse implements V1, V2
{
    protected string $method = self::DELETE;

    /**
     * Request Uri
     *
     * @var array|string
     */
    protected array|string $uri = [
        'v1' => '/nacos/v1/console/namespaces',
        'v2' => '/nacos/v2/console/namespace',
    ];

    public function v1(string $namespaceId): V1
    {
        return new class($namespaceId, 'v1') extends DeleteNamespaceRequest implements V1, V2 {
            public function __construct(string $namespaceId, string $version = null)
            {
                parent::__construct($version);
                $this->setNamespaceId($namespaceId);
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

    public function v2(string $namespaceId): V2
    {
        return new class($namespaceId, 'v2') extends DeleteNamespaceRequest implements V1, V2 {
            public function __construct(string $namespaceId, string $version = null)
            {
                parent::__construct($version);
                $this->setNamespaceId($namespaceId);
            }
        };
    }


    protected string $namespaceId;

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

}
