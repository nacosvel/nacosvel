<?php

namespace Nacosvel\Nacos;

use Nacosvel\Nacos\Concerns\NacosRequestTrait;
use Nacosvel\Nacos\Contracts\NacosRequestInterface;

abstract class NacosRequest implements NacosRequestInterface
{
    use NacosRequestTrait;

    /**
     * Default Version
     *
     * @var string
     */
    protected string $version = 'v2';

    /**
     * Request Method
     *
     * @var string
     */
    protected string $method = self::POST;

    /**
     * Request Uri
     *
     * @example
     * ```
     *  protected array|string $uri = '/nacos/{Version}/ns/instance';
     *  protected array|string $uri = [
     *    'v1' => '/nacos/v1/ns/instance',
     *    'v2' => '/nacos/v2/ns/instance',
     *  ];
     *  ```
     *
     * @var array|string
     */
    protected array|string $uri = [];
}
