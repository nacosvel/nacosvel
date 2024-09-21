<?php

namespace Nacosvel\NacosClient\Naming;

use Nacosvel\NacosClient\Contracts\Naming\InstanceBeatInterface;
use Nacosvel\NacosClient\NacosRequestResponse;

class InstanceBeatRequest extends NacosRequestResponse implements InstanceBeatInterface
{
    /**
     * Default Version
     *
     * @var string
     */
    protected string $version = 'v1';

    /**
     * Request Method
     *
     * @var string
     */
    protected string $method = self::PUT;

    /**
     * Request Uri
     *
     * @var array|string
     */
    protected array|string $uri = '/nacos/v1/ns/instance/beat';

    public function v1(string $serviceName, string $ip, int $port, string $beat): InstanceBeatInterface
    {
        return new class($serviceName, $ip, $port, $beat, 'v1') extends InstanceBeatRequest implements InstanceBeatInterface {
            public function __construct(string $serviceName, string $ip, int $port, string $beat, string $version = null)
            {
                parent::__construct($version);
                $this->setServiceName($serviceName)->setIp($ip)->setPort($port)->setBeat($beat);
            }

            protected function responseValid(int $code, string $content, array $decode = []): bool
            {
                return $code == 200 && $content === 'ok';
            }

            protected function responseSuccessHandler(int $code, string $content, array $decode = []): string
            {
                return parent::responseSuccessHandler($code, json_encode([
                    'code'    => 0,
                    'message' => 'success',
                    'data'    => $content,
                ]));
            }

            protected function responseFailureHandler(int $code, string $content, array $decode = []): string
            {
                return parent::responseFailureHandler($code, json_encode(count($decode) ? $decode : [
                    'code'    => $code,
                    'message' => 'lightBeatEnabled',
                    'data'    => $content,
                ]));
            }
        };
    }


    protected string $serviceName;
    protected string $ip;
    protected int    $port;
    protected string $namespaceId;
    protected string $groupName;
    protected bool   $ephemeral;
    protected string $beat;

    /**
     * @return string
     */
    public function getServiceName(): string
    {
        return $this->serviceName;
    }

    /**
     * @param string $serviceName
     *
     * @return static
     */
    public function setServiceName(string $serviceName): static
    {
        return $this->parameter('serviceName', $this->serviceName = $serviceName);
    }

    /**
     * @return string
     */
    public function getIp(): string
    {
        return $this->ip;
    }

    /**
     * @param string $ip
     *
     * @return static
     */
    public function setIp(string $ip): static
    {
        return $this->parameter('ip', $this->ip = $ip);
    }

    /**
     * @return int
     */
    public function getPort(): int
    {
        return $this->port;
    }

    /**
     * @param int $port
     *
     * @return static
     */
    public function setPort(int $port): static
    {
        return $this->parameter('port', $this->port = $port);
    }

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
    public function getGroupName(): string
    {
        return $this->groupName;
    }

    /**
     * @param string $groupName
     *
     * @return static
     */
    public function setGroupName(string $groupName): static
    {
        return $this->parameter('groupName', $this->groupName = $groupName);
    }

    /**
     * @return bool
     */
    public function isEphemeral(): bool
    {
        return $this->ephemeral;
    }

    /**
     * @param bool $ephemeral
     *
     * @return static
     */
    public function setEphemeral(bool $ephemeral): static
    {
        return $this->parameter('ephemeral', $this->ephemeral = $ephemeral);
    }

    /**
     * @return string
     */
    public function getBeat(): string
    {
        return $this->beat;
    }

    /**
     * @param string $beat
     *
     * @return static
     */
    public function setBeat(string $beat): static
    {
        return $this->parameter('beat', $this->beat = $beat);
    }
}
