<?php

namespace Nacosvel\NacosClient\Naming;

use Nacosvel\NacosClient\Contracts\Naming\OperatorServersInterface;
use Nacosvel\NacosClient\NacosRequestResponse;

class OperatorServersRequest extends NacosRequestResponse implements OperatorServersInterface
{
    protected string $version = 'v1';

    /**
     * Request Method
     *
     * @var string
     */
    protected string $method = self::GET;

    /**
     * Request Uri
     *
     * @var array|string
     */
    protected array|string $uri = '/nacos/v1/ns/operator/servers';

    public function v1(): OperatorServersInterface
    {
        return new class('v1') extends OperatorServersRequest implements OperatorServersInterface {
            public function __construct(string $version = null)
            {
                parent::__construct($version);
            }

            protected function responseSuccessHandler(int $code, string $content, array $decode = []): string
            {
                return parent::responseSuccessHandler($code, json_encode([
                    'code'    => 0,
                    'message' => 'success',
                    'data'    => json_decode($content, true),
                ]));
            }

            protected function responseFailureHandler(int $code, string $content, array $decode = []): string
            {
                return parent::responseFailureHandler($code, json_encode(count($decode) ? $decode : [
                    'code'    => $code,
                    'message' => 'Internal Server Error',
                    'data'    => $content,
                ]));
            }
        };
    }

    protected bool $healthy;

    /**
     * @return bool
     */
    public function getHealthy(): bool
    {
        return $this->healthy;
    }

    /**
     * @param bool $healthy
     *
     * @return static
     */
    public function setHealthy(bool $healthy): static
    {
        return $this->parameter('healthy', $this->healthy = $healthy);
    }
}
