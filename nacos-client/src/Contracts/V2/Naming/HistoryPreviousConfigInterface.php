<?php

namespace Nacosvel\NacosClient\Contracts\V2\Naming;

use Nacosvel\NacosClient\Contracts\V2\VersionInterface;

interface HistoryPreviousConfigInterface extends VersionInterface
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
    public function getId(): int|string;


    /**
     * @param int|string $id
     *
     * @return static
     */
    public function setId(int|string $id): static;
}
