<?php

namespace Nacosvel\NacosClient\Contracts\V2\Config;

use Nacosvel\NacosClient\Contracts\V2\VersionInterface;

interface DeleteConfigInterface extends VersionInterface
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
     * @return string
     */
    public function getTag(): string;


    /**
     * @param string $tag
     *
     * @return static
     */
    public function setTag(string $tag): static;


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
