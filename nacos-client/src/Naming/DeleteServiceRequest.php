<?php

namespace Nacosvel\NacosClient\Naming;

use Nacosvel\NacosClient\Contracts\V1\Naming\DeleteServiceInterface as V1;
use Nacosvel\NacosClient\Contracts\V2\Naming\DeleteServiceInterface as V2;
use Nacosvel\NacosClient\NacosRequestResponse;

class DeleteServiceRequest extends NacosRequestResponse implements V1, V2
{
    protected string $method = self::DELETE;

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
        return new class($serviceName, 'v1') extends DeleteServiceRequest implements V1, V2 {
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
        return new class($serviceName, 'v2') extends DeleteServiceRequest implements V1, V2 {
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
}
