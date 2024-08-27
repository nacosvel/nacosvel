<?php

namespace Nacosvel\Nacos\Concerns;

use GuzzleHttp\ClientInterface;
use Nacosvel\Nacos\Contracts\NacosConfigInterface;
use Nacosvel\Nacos\Contracts\NacosResponseInterface;
use Nacosvel\Nacos\Middlewares\RefreshAccessToken;
use Nacosvel\OpenHttp\Builder;
use Nacosvel\OpenHttp\Contracts\ChainableInterface;

trait NacosClientTrait
{
    /**
     * @return NacosConfigInterface
     */
    public function getConfig(): NacosConfigInterface
    {
        return $this->config;
    }

    /**
     * @param NacosConfigInterface $config
     *
     * @return static
     */
    public function setConfig(NacosConfigInterface $config): static
    {
        $this->config = $config;
        return $this;
    }

    /**
     * @return NacosResponseInterface
     */
    public function getResponse(): NacosResponseInterface
    {
        return $this->response;
    }

    /**
     * @param NacosResponseInterface $response
     *
     * @return static
     */
    public function setResponse(NacosResponseInterface $response): static
    {
        $this->response = $response;

        return $this;
    }

    /**
     * @return ChainableInterface
     */
    public function getClient(): ChainableInterface
    {
        return $this->client;
    }

    /**
     * @param ClientInterface|null $client
     *
     * @return static
     */
    public function setClient(?ClientInterface $client = null): static
    {
        $factory         = Builder::factory();
        $clientDecorator = $factory->getClient();

        if (is_null($client)) {
            $client = $clientDecorator->getRequestClient();
        } else {
            $client = $clientDecorator->setRequestClient($client)->getRequestClient();
        }

        $handler = $clientDecorator->getConfig('handler');
        $handler->remove('nacosvel.nacos_sdk_php.nacos_auth_middleware');
        $handler->push(function (callable $handler) {
            return new RefreshAccessToken($this, $handler);
        }, 'nacosvel.nacos_sdk_php.nacos_auth_middleware');

        $this->client = $factory;

        return $this;
    }

}
