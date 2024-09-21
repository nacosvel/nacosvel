<?php

namespace Nacosvel\NacosClient\Naming;

use Nacosvel\NacosClient\Contracts\Naming\UpdateOperatorSwitchesInterface;
use Nacosvel\NacosClient\NacosRequestResponse;

class UpdateOperatorSwitchesRequest extends NacosRequestResponse implements UpdateOperatorSwitchesInterface
{
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
    protected array|string $uri = '/nacos/v1/ns/operator/switches';

    public function v1(string $entry, string $value): UpdateOperatorSwitchesInterface
    {
        return new class($entry, $value, 'v1') extends UpdateOperatorSwitchesRequest implements UpdateOperatorSwitchesInterface {
            public function __construct(string $entry, string $value, string $version = null)
            {
                parent::__construct($version);
                $this->setEntry($entry)->setValue($value);
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
                    'message' => 'Internal Server Error',
                    'data'    => $content,
                ]));
            }
        };
    }

    protected string $entry;
    protected string $value;
    protected bool   $debug;

    /**
     * @return string
     */
    public function getEntry(): string
    {
        return $this->entry;
    }

    /**
     * @param string $entry
     *
     * @return static
     */
    public function setEntry(string $entry): static
    {
        return $this->parameter('entry', $this->entry = $entry);
    }

    /**
     * @return string
     */
    public function getValue(): string
    {
        return $this->value;
    }

    /**
     * @param string $value
     *
     * @return static
     */
    public function setValue(string $value): static
    {
        return $this->parameter('value', $this->value = $value);
    }

    /**
     * @return bool
     */
    public function getDebug(): bool
    {
        return $this->debug;
    }

    /**
     * @param bool $debug
     *
     * @return static
     */
    public function setDebug(bool $debug): static
    {
        return $this->parameter('debug', $this->debug = $debug);
    }
}
