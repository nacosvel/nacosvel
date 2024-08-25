<?php

namespace Nacosvel\Nacos\Concerns;

use GuzzleHttp\ClientInterface;
use Nacosvel\Nacos\Contracts\NacosRequestInterface;
use Nacosvel\Nacos\Contracts\NacosResponseInterface;
use Nacosvel\Nacos\Middlewares\RefreshAccessToken;
use Nacosvel\OpenHttp\Builder;

trait NacosClientTrait
{
    /**
     * @return NacosRequestInterface
     */
    public function getRequest(): NacosRequestInterface
    {
        return $this->request;
    }

    /**
     * @param NacosRequestInterface $request
     *
     * @return static
     */
    public function setRequest(NacosRequestInterface $request): static
    {
        $this->request = $request;
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
     * @return ClientInterface
     */
    public function getClient(): ClientInterface
    {
        return $this->client;
    }

    /**
     * @param ClientInterface $client
     *
     * @return static
     */
    public function setClient(ClientInterface $client): static
    {
        $clientDecorator = Builder::factory()->getClient()->setRequestClient($client);
        $client          = $clientDecorator->getRequestClient();
        $handler         = $clientDecorator->getConfig('handler');
        $handler->remove('nacosvel.nacos_sdk_php.nacos_auth_middleware');
        $handler->push(function (callable $handler) {
            return new RefreshAccessToken($this, $handler);
        }, 'nacosvel.nacos_sdk_php.nacos_auth_middleware');
        $this->client = $client;
        return $this;
    }

}
