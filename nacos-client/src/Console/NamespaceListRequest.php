<?php

namespace Nacosvel\NacosClient\Console;

use Nacosvel\NacosClient\Contracts\Console\NamespaceListInterface;
use Nacosvel\NacosClient\NacosRequestResponse;

class NamespaceListRequest extends NacosRequestResponse implements NamespaceListInterface
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
        'v1' => '/nacos/{Version}/console/namespaces',
        'v2' => '/nacos/{Version}/console/namespace/list',
    ];

    public function v1(): NamespaceListInterface
    {
        return $this->setVersion('v1');
    }

    public function v2(): NamespaceListInterface
    {
        return $this->setVersion('v2');
    }

}
