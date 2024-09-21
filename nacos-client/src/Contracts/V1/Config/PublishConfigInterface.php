<?php

namespace Nacosvel\NacosClient\Contracts\V1\Config;

use Nacosvel\NacosClient\Contracts\V1\VersionInterface;

interface PublishConfigInterface extends VersionInterface
{
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
    public function getContent(): string;


    /**
     * @param string $content
     *
     * @return static
     */
    public function setContent(string $content): static;

    /**
     * @return string
     */
    public function getType(): string;

    /**
     * @param string $type
     *
     * @return static
     */
    public function setType(string $type): static;
}
