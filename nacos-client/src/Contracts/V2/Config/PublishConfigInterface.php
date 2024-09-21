<?php

namespace Nacosvel\NacosClient\Contracts\V2\Config;

use Nacosvel\NacosClient\Contracts\V2\VersionInterface;

interface PublishConfigInterface extends VersionInterface
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
    public function getAppName(): string;


    /**
     * @param string $appName
     *
     * @return static
     */
    public function setAppName(string $appName): static;


    /**
     * @return string
     */
    public function getSrcUser(): string;


    /**
     * @param string $srcUser
     *
     * @return static
     */
    public function setSrcUser(string $srcUser): static;


    /**
     * @return string
     */
    public function getConfigTags(): string;


    /**
     * @param string $configTags
     *
     * @return static
     */
    public function setConfigTags(string $configTags): static;


    /**
     * @return string
     */
    public function getDesc(): string;


    /**
     * @param string $desc
     *
     * @return static
     */
    public function setDesc(string $desc): static;


    /**
     * @return string
     */
    public function getUse(): string;


    /**
     * @param string $use
     *
     * @return static
     */
    public function setUse(string $use): static;


    /**
     * @return string
     */
    public function getEffect(): string;


    /**
     * @param string $effect
     *
     * @return static
     */
    public function setEffect(string $effect): static;


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


    /**
     * @return string
     */
    public function getSchema(): string;


    /**
     * @param string $schema
     *
     * @return static
     */
    public function setSchema(string $schema): static;

}
