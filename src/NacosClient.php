<?php

namespace Nacosvel\Nacos;

use Exception;
use GuzzleHttp\Exception\TransferException;
use Nacosvel\Nacos\Contracts\NacosRequestInterface;
use Nacosvel\Nacos\Contracts\NacosResponseInterface;
use Psr\Log\LoggerAwareInterface;
use Psr\Log\LoggerAwareTrait;
use Psr\Log\LoggerInterface;
use Psr\Log\NullLogger;
use RuntimeException;

class NacosClient implements LoggerAwareInterface
{
    use LoggerAwareTrait;

    public function __construct(
        protected NacosRequestInterface   $client,
        protected ?NacosResponseInterface $response = null,
        ?LoggerInterface                  $logger = null
    )
    {
        if (is_null($response)) {
            $this->response = new NacosResponse();
        }
        if (is_null($logger)) {
            $logger = new NullLogger();
        }
        $this->setLogger($logger);
    }

    public function execute(string $method, string $uri = '', array $options = []): mixed
    {
        $this->logger->debug(sprintf("Nacos Request [%s] %s", strtoupper($method), $uri));

        try {
            $response = $this->client->getClient()->getClient()->request($method, $uri, $options);
            if ($response->getStatusCode() >= 400) {
                $this->logger->error($message = sprintf("Nacos Response [%s] %s", $response->getStatusCode(), $response->getReasonPhrase()));
                throw new RuntimeException($message, -1);
            }
        } catch (TransferException|Exception $exception) {
            $this->logger->error(sprintf("Nacos Exception [%s]", $exception->getMessage()));
            throw new RuntimeException($exception->getMessage(), $exception->getCode(), $exception);
        }

        return call_user_func($this->response, $response);
    }
}
