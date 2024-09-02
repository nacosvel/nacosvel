<?php

namespace Nacosvel\NacosClient\Contracts\Naming;

use Nacosvel\NacosClient\Contracts\V1\VersionInterface;

interface OperatorServersInterface extends VersionInterface
{
    /**
     * @return bool
     */
    public function getHealthy(): bool;

    /**
     * @param bool $healthy
     *
     * @return static
     */
    public function setHealthy(bool $healthy): static;

}
