<?php

namespace Nacosvel\NacosClient\Contracts\V2\Config;

use Nacosvel\NacosClient\Contracts\V2\VersionInterface;

interface HistoryConfigInterface extends VersionInterface
{
    /**
     * @return string
     */
    public function getNamespaceId(): string;


    /**
     * @param string $namespaceId
     *
     * @return static
     */
    public function setNamespaceId(string $namespaceId): static;


    /**
     * @return string
     */
    public function getGroup(): string;


    /**
     * @param string $group
     *
     * @return static
     */
    public function setGroup(string $group): static;


    /**
     * @return string
     */
    public function getDataId(): string;


    /**
     * @param string $dataId
     *
     * @return static
     */
    public function setDataId(string $dataId): static;


    /**
     * @return int|string
     */
    public function getNid(): int|string;


    /**
     * @param int|string $nid
     *
     * @return static
     */
    public function setNid(int|string $nid): static;
}
