<?php

namespace Nacosvel\Nacos;

use GuzzleHttp\ClientInterface;
use GuzzleHttp\Exception\BadResponseException;
use GuzzleHttp\Psr7\Response;
use GuzzleHttp\Psr7\Utils;
use Nacosvel\Nacos\Concerns\NacosClientTrait;
use Nacosvel\Nacos\Contracts\NacosClientInterface;
use Nacosvel\Nacos\Contracts\NacosRequestInterface;
use Nacosvel\Nacos\Contracts\NacosResponseInterface;
use Psr\Http\Client\ClientExceptionInterface;
use Psr\Log\LoggerAwareInterface;
use Psr\Log\LoggerAwareTrait;
use Psr\Log\LoggerInterface;
use Psr\Log\NullLogger;
use Throwable;

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
        $this->setClient();
    }

    public function execute(string $method, string $uri = '', array $options = []): NacosResponseInterface
    {
        $this->logger->debug(sprintf("Nacos Request [%s] %s", strtoupper($method), $uri));

        try {
            $response = $this->getClient()->request($method, $uri, $options);
        } catch (BadResponseException $exception) {
            $this->logger->error(sprintf("Nacos ClientException [%s] %s", $exception->getResponse()->getStatusCode(), $exception->getResponse()->getReasonPhrase()));
            $response = new Response(
                status: $exception->getCode(),
                headers: ['Content-Type' => 'application/json'],
                body: Utils::streamFor(json_encode([
                    'code'    => $exception->getResponse()->getStatusCode(),
                    'error'   => $exception->getResponse()->getReasonPhrase(),
                    'message' => $exception->getMessage(),
                ]))
            );
        } catch (ClientExceptionInterface|Throwable $exception) {
            $this->logger->error(sprintf("Nacos Exception [%s] %s", get_class($exception), $exception->getMessage()));
            $response = new Response(
                status: $exception->getCode(),
                headers: ['Content-Type' => 'application/json'],
                body: Utils::streamFor(json_encode([
                    'code'    => $exception->getCode(),
                    'error'   => get_class($exception),
                    'message' => $exception->getMessage(),
                ]))
            );
        }

        return $this->response->setResponse($response);
    }
}
