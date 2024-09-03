<?php

namespace Nacosvel\NacosClient\Naming;

use Nacosvel\NacosClient\Contracts\Naming\ClientSubscribeListInterface;
use Nacosvel\NacosClient\NacosRequestResponse;

class ClientSubscribeListRequest extends NacosRequestResponse implements ClientSubscribeListInterface
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
    protected array|string $uri = '/nacos/v2/ns/client/subscribe/list';

    public function v2(string $clientId): ClientSubscribeListInterface
    {
        return $this->setClientId($clientId);
    }

    protected string $clientId;

    /**
     * @return string
     */
    public function getClientId(): string
    {
        return $this->clientId;
    }


    /**
     * @param string $clientId
     *
     * @return static
     */
    public function setClientId(string $clientId): static
    {
        return $this->parameter('clientId', $this->clientId = $clientId);
    }
}
