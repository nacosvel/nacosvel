<?php

namespace Nacosvel\NacosClient\Console;

use Nacosvel\NacosClient\Contracts\Console\NamespaceInterface;
use Nacosvel\NacosClient\NacosRequestResponse;

class NamespaceRequest extends NacosRequestResponse implements NamespaceInterface
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
    protected array|string $uri = '/nacos/v2/console/namespace';

    public function v2(string $namespaceId): NamespaceInterface
    {
        return $this->setNamespaceId($namespaceId);
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
