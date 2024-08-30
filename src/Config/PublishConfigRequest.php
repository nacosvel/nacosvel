<?php

namespace Nacosvel\NacosClient\Config;

use Nacosvel\NacosClient\Contracts\V1\Config\PublishConfigInterface as V1;
use Nacosvel\NacosClient\Contracts\V2\Config\PublishConfigInterface as V2;
use Nacosvel\NacosClient\NacosRequestResponse;

class PublishConfigRequest extends NacosRequestResponse implements V1, V2
{
    /**
     * Request Uri
     *
     * @var array|string
     */
    protected array|string $uri = [
        'v1' => '/nacos/v1/cs/configs',
        'v2' => '/nacos/v2/cs/config',
    ];

    public function v1(string $dataId, string $group, string $content): V1
    {
        return new class($dataId, $group, $content, 'v1') extends PublishConfigRequest implements V1, V2 {
            public function __construct(string $dataId, string $group, string $content, string $version = null)
            {
                parent::__construct($version);
                $this->setDataId($dataId)->setGroup($group)->setContent($content);
            }

            #[\Override]
            public function responseSuccessHandler(int $code, string $content = '', array $decode = []): string
            {
                return parent::responseSuccessHandler($code, json_encode([
                    'code'    => 0,
                    'message' => 'success',
                    'data'    => str_replace(PHP_EOL, "\r\n", $content),
                ]));
            }

            #[\Override]
            public function responseFailureHandler(int $code, string $content = '', array $decode = []): string
            {
                return parent::responseFailureHandler($code, json_encode(count($decode) ? $decode : [
                    'code'    => $code,
                    'message' => $content,
                    'data'    => '',
                ]));
            }

        };
    }

    public function v2(string $dataId, string $group, string $content): V2
    {
        return new class($dataId, $group, $content, 'v2') extends PublishConfigRequest implements V1, V2 {
            public function __construct(string $dataId, string $group, string $content, string $version = null)
            {
                parent::__construct($version);
                $this->setDataId($dataId)->setGroup($group)->setContent($content);
            }
        };
    }

    protected string $namespaceId;
    protected string $group;
    protected string $dataId;
    protected string $content;
    protected string $tag;
    protected string $appName;
    protected string $srcUser;
    protected string $configTags;
    protected string $desc;
    protected string $use;
    protected string $effect;
    protected string $type;
    protected string $schema;

    /**
     * @version v1
     */
    protected string $tenant;

    /**
     * @return string
     */
    public function getNamespaceId(): string
    {
        return $this->namespaceId;
    }

    /**
     * @param string $namespaceId
     *
     * @return static
     */
    public function setNamespaceId(string $namespaceId): static
    {
        return $this->parameter('namespaceId', $this->namespaceId = $namespaceId);
    }

    /**
     * @return string
     */
    public function getGroup(): string
    {
        return $this->group;
    }

    /**
     * @param string $group
     *
     * @return static
     */
    public function setGroup(string $group): static
    {
        return $this->parameter('group', $this->group = $group);
    }

    /**
     * @return string
     */
    public function getDataId(): string
    {
        return $this->dataId;
    }

    /**
     * @param string $dataId
     *
     * @return static
     */
    public function setDataId(string $dataId): static
    {
        return $this->parameter('dataId', $this->dataId = $dataId);
    }

    /**
     * @return string
     */
    public function getContent(): string
    {
        return $this->content;
    }

    /**
     * @param string $content
     *
     * @return static
     */
    public function setContent(string $content): static
    {
        return $this->parameter('content', $this->content = $content);
    }

    /**
     * @return string
     */
    public function getTag(): string
    {
        return $this->tag;
    }

    /**
     * @param string $tag
     *
     * @return static
     */
    public function setTag(string $tag): static
    {
        return $this->parameter('tag', $this->tag = $tag);
    }

    /**
     * @return string
     */
    public function getAppName(): string
    {
        return $this->appName;
    }

    /**
     * @param string $appName
     *
     * @return static
     */
    public function setAppName(string $appName): static
    {
        return $this->parameter('appName', $this->appName = $appName);
    }

    /**
     * @return string
     */
    public function getSrcUser(): string
    {
        return $this->srcUser;
    }

    /**
     * @param string $srcUser
     *
     * @return static
     */
    public function setSrcUser(string $srcUser): static
    {
        return $this->parameter('srcUser', $this->srcUser = $srcUser);
    }

    /**
     * @return string
     */
    public function getConfigTags(): string
    {
        return $this->configTags;
    }

    /**
     * @param string $configTags
     *
     * @return static
     */
    public function setConfigTags(string $configTags): static
    {
        return $this->parameter('configTags', $this->configTags = $configTags);
    }

    /**
     * @return string
     */
    public function getDesc(): string
    {
        return $this->desc;
    }

    /**
     * @param string $desc
     *
     * @return static
     */
    public function setDesc(string $desc): static
    {
        return $this->parameter('desc', $this->desc = $desc);
    }

    /**
     * @return string
     */
    public function getUse(): string
    {
        return $this->use;
    }

    /**
     * @param string $use
     *
     * @return static
     */
    public function setUse(string $use): static
    {
        return $this->parameter('use', $this->use = $use);
    }

    /**
     * @return string
     */
    public function getEffect(): string
    {
        return $this->effect;
    }

    /**
     * @param string $effect
     *
     * @return static
     */
    public function setEffect(string $effect): static
    {
        return $this->parameter('effect', $this->effect = $effect);
    }

    /**
     * @return string
     */
    public function getType(): string
    {
        return $this->type;
    }

    /**
     * @param string $type
     *
     * @return static
     */
    public function setType(string $type): static
    {
        return $this->parameter('type', $this->type = $type);
    }

    /**
     * @return string
     */
    public function getSchema(): string
    {
        return $this->schema;
    }

    /**
     * @param string $schema
     *
     * @return static
     */
    public function setSchema(string $schema): static
    {
        return $this->parameter('schema', $this->schema = $schema);
    }

    /**
     * @return string
     */
    public function getTenant(): string
    {
        return $this->tenant;
    }

    /**
     * @param string $tenant
     *
     * @return static
     */
    public function setTenant(string $tenant): static
    {
        return $this->parameter('tenant', $this->tenant = $tenant);
    }
}
