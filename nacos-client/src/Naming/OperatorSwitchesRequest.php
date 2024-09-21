<?php

namespace Nacosvel\NacosClient\Naming;

use Nacosvel\NacosClient\Contracts\Naming\OperatorSwitchesInterface;
use Nacosvel\NacosClient\NacosRequestResponse;

class OperatorSwitchesRequest extends NacosRequestResponse implements OperatorSwitchesInterface
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
    protected array|string $uri = '/nacos/v1/ns/operator/switches';

    public function v1(): OperatorSwitchesInterface
    {
        return new class('v1') extends OperatorSwitchesRequest implements OperatorSwitchesInterface {
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
