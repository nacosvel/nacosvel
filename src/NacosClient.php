<?php

namespace Nacosvel\Nacos;

use Exception;
use GuzzleHttp\Client;
use GuzzleHttp\ClientInterface;
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\Exception\TransferException;
use Nacosvel\Nacos\Concerns\NacosClientTrait;
use Nacosvel\Nacos\Contracts\NacosClientInterface;
use Nacosvel\Nacos\Contracts\NacosRequestInterface;
use Nacosvel\Nacos\Contracts\NacosResponseInterface;
use Nacosvel\OpenHttp\Builder;
use Psr\Log\LoggerAwareInterface;
use Psr\Log\LoggerAwareTrait;
use Psr\Log\LoggerInterface;
use Psr\Log\NullLogger;
use RuntimeException;

class NacosClient implements NacosClientInterface, LoggerAwareInterface
{
    use LoggerAwareTrait;
    use NacosClientTrait;

    protected ClientInterface $client;

    public function __construct(
        protected NacosRequestInterface   $request,
        protected ?NacosResponseInterface $response = null,
        ?LoggerInterface                  $logger = null
    )
    {
        $this->setRequest($request);
        $this->setResponse($response ?? new NacosResponse());
        $this->setLogger($logger ?? new NullLogger());
        $this->setClient(new Client());
    }

    public function execute(string $method, string $uri = '', array $options = []): mixed
    {
        $this->logger->debug(sprintf("Nacos Request [%s] %s", strtoupper($method), $uri));

        try {
            $response = $this->getClient()->request($method, $uri, $options);
            if ($response->getStatusCode() >= 400) {
                $this->logger->error($message = sprintf("Nacos Response Status Code [%s] %s", $response->getStatusCode(), $response->getReasonPhrase()));
                throw new RuntimeException($message, -1);
            }
        } catch (GuzzleException|Exception $exception) {
            $this->logger->error(sprintf("Nacos Exception [%s] %s", get_class($exception), $exception->getMessage()));
            throw new RuntimeException($exception->getMessage(), $exception->getCode(), $exception);
        }

        return call_user_func($this->response, $response);
    }
}
