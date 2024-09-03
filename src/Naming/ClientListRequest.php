<?php

namespace Nacosvel\NacosClient\Naming;

use Nacosvel\NacosClient\Contracts\V2\Naming\ClientListInterface;
use Nacosvel\NacosClient\NacosRequestResponse;

class ClientListRequest extends NacosRequestResponse implements ClientListInterface
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
    protected array|string $uri = '/nacos/v2/ns/client/list';

    public function v2(): ClientListInterface
    {
        return $this;
    }

}
