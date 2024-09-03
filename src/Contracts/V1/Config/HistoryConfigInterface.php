<?php

namespace Nacosvel\NacosClient\Contracts\V1\Config;

use Nacosvel\NacosClient\Contracts\V1\VersionInterface;

interface HistoryConfigInterface extends VersionInterface
{
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
    

    /**
     * @return string
     */
    public function getTenant(): string;


    /**
     * @param string $tenant
     *
     * @return static
     */
    public function setTenant(string $tenant): static;

}
