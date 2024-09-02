<?php

namespace Nacosvel\NacosClient\Contracts\V1\Naming;

use Nacosvel\NacosClient\Contracts\V1\VersionInterface;

interface ServiceListInterface extends VersionInterface
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
    public function getGroupName(): string;


    /**
     * @param string $groupName
     *
     * @return static
     */
    public function setGroupName(string $groupName): static;


    /**
     * @return int
     */
    public function getPageNo(): int;


    /**
     * @param int $pageNo
     *
     * @return static
     */
    public function setPageNo(int $pageNo): static;


    /**
     * @return int
     */
    public function getPageSize(): int;


    /**
     * @param int $pageSize
     *
     * @return static
     */
    public function setPageSize(int $pageSize): static;
}
