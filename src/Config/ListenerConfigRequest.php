<?php

namespace Nacosvel\NacosClient\Config;

use Nacosvel\NacosClient\Contracts\Config\ListenerConfigInterface;
use Nacosvel\NacosClient\NacosRequestResponse;

class ListenerConfigRequest extends NacosRequestResponse implements ListenerConfigInterface
{
    /**
     * Default Version
     *
     * @var string
     */
    protected string $version = 'v1';

    /**
     * Request Uri
     *
     * @var array|string
     */
    protected array|string $uri = '/nacos/v1/cs/configs/listener';


    public function v1(string $dataId, string $group, string $contentFileName, string $tenant = '')
    {
        return new class($dataId, $group, $contentFileName, $tenant, 'v1') extends ListenerConfigRequest implements ListenerConfigInterface {
            public function __construct(string $dataId, string $group, string $contentFileName, string $tenant = '', string $version = null)
            {
                parent::__construct($version);
                $contentMD5 = md5('');
                if (is_file($contentFileName)) {
                    $contentMD5 = md5(file_get_contents($contentFileName));
                }
                $this->setListeningConfigs($dataId, $group, $contentMD5, $tenant)->setLongPullingTimeout($this->getLongPullingTimeout());
            }

            protected function responseValid(int $code, string $content, array $decode = []): bool
            {
                return $code == 200 && $content === '';
            }

            public function responseSuccessHandler(int $code, string $content = '', array $decode = []): string
            {
                return parent::responseSuccessHandler($code, json_encode([
                    'code'    => 0,
                    'message' => 'success',
                    'data'    => $content,
                ]));
            }

            public function responseFailureHandler(int $code, string $content = '', array $decode = []): string
            {
                return parent::responseFailureHandler($code, json_encode(count($decode) ? $decode : [
                    'code'    => $code,
                    'message' => 'Inconsistent data',
                    'data'    => $content,
                ]));
            }

        };
    }

    protected string $listeningConfigs;
    protected int    $longPullingTimeout = 30 * 1000;

    /**
     * @return string
     */
    public function getListeningConfigs(): string
    {
        return $this->listeningConfigs;
    }

    /**
     * @param string $dataId
     * @param string $group
     * @param string $contentMD5
     * @param string $tenant
     *
     * @return static
     */
    public function setListeningConfigs(string $dataId, string $group, string $contentMD5, string $tenant = ''): static
    {
        return $this->parameter('Listening-Configs', $this->listeningConfigs = (function ($dataId, $group, $contentMD5, $tenant) {
            if ($tenant) {
                return "{$dataId}%02{$group}%02{$contentMD5}%02{$tenant}%01";
            }
            return "{$dataId}%02{$group}%02{$contentMD5}%01";
        })($dataId, $group, $contentMD5, $tenant));
    }

    /**
     * @return int
     */
    public function getLongPullingTimeout(): int
    {
        return $this->longPullingTimeout;
    }

    /**
     * @param int $longPullingTimeout
     *
     * @return static
     */
    public function setLongPullingTimeout(int $longPullingTimeout): static
    {
        return $this->setOption('headers', [
            'Long-Pulling-Timeout' => $this->longPullingTimeout = $longPullingTimeout,
        ]);
    }

}
