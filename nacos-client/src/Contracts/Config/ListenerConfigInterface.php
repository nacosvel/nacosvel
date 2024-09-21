<?php

namespace Nacosvel\NacosClient\Contracts\Config;

use Nacosvel\NacosClient\Contracts\V1\VersionInterface;

interface ListenerConfigInterface extends VersionInterface
{
    /**
     * @return string
     */
    public function getListeningConfigs(): string;


    /**
     * @param string $dataId
     * @param string $group
     * @param string $contentMD5
     * @param string $tenant
     *
     * @return static
     */
    public function setListeningConfigs(string $dataId, string $group, string $contentMD5, string $tenant = ''): static;


    /**
     * @return int
     */
    public function getLongPullingTimeout(): int;


    /**
     * @param int $longPullingTimeout
     *
     * @return static
     */
    public function setLongPullingTimeout(int $longPullingTimeout): static;


}
