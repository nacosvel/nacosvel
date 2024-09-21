<?php

namespace Nacosvel\NacosClient\Contracts\V2\Naming;

use Nacosvel\NacosClient\Contracts\V2\VersionInterface;

interface ClientInterface extends VersionInterface
{
    /**
     * @return string
     */
    public function getClientId(): string;


    /**
     * @param string $clientId
     *
     * @return static
     */
    public function setClientId(string $clientId): static;

}
