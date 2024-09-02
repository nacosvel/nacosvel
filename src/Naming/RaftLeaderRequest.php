<?php

namespace Nacosvel\NacosClient\Naming;

use Nacosvel\NacosClient\Contracts\Naming\RaftLeaderInterface;
use Nacosvel\NacosClient\NacosRequestResponse;

class RaftLeaderRequest extends NacosRequestResponse implements RaftLeaderInterface
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
    protected array|string $uri = '/nacos/v1/ns/raft/leader';

    public function v1(): RaftLeaderInterface
    {
        return new class('v1') extends RaftLeaderRequest implements RaftLeaderInterface {
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
        };
    }
}
