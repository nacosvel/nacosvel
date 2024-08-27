<?php

namespace Nacosvel\Nacos;

use DateTime;
use GuzzleHttp\ClientInterface;
use GuzzleHttp\Exception\BadResponseException;
use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Psr7\Response;
use GuzzleHttp\Psr7\Utils;
use Nacosvel\Nacos\Concerns\NacosClientTrait;
use Nacosvel\Nacos\Contracts\NacosClientInterface;
use Nacosvel\Nacos\Contracts\NacosConfigInterface;
use Nacosvel\Nacos\Contracts\NacosRequestInterface;
use Nacosvel\Nacos\Contracts\NacosResponseInterface;
use Nacosvel\OpenHttp\Contracts\ChainableInterface;
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

    protected ChainableInterface $client;

    public function __construct(
        protected NacosConfigInterface    $config,
        protected ?NacosResponseInterface $response = null,
        ?ClientInterface                  $client = null,
        ?LoggerInterface                  $logger = null
    )
    {
        $this->setConfig($config);
        $this->setResponse($response ?? new NacosResponse());
        $this->setClient($client);
        $this->setLogger($logger ?? new NullLogger());
    }

    public function request(NacosRequestInterface|string $method, string $uri = '', array $options = []): NacosResponseInterface
    {
        if ($method instanceof NacosRequestInterface) {
            return $this->request($method->getMethod(), $method->getUri(), $method->toArray());
        }

        $this->logger->debug(sprintf("Nacos Request [%s] %s", strtoupper($method), $uri));

        try {
            $response = $this->getClient()->chain($uri)->request($method, $options);
        } catch (ClientException $exception) {
            $this->logger->error(sprintf("Nacos ClientException [%s] %s", $exception->getResponse()->getStatusCode(), $exception->getResponse()->getReasonPhrase()));
            $response = new Response(
                status: $exception->getCode() < 100 ? 400 : $exception->getCode(),
                headers: ['Content-Type' => 'application/json'],
                body: Utils::streamFor($exception->getResponse()?->getBody()?->getContents())
            );
        } catch (BadResponseException $exception) {
            $this->logger->error(sprintf("Nacos ClientException [%s] %s", $exception->getResponse()->getStatusCode(), $exception->getResponse()->getReasonPhrase()));
            $response = new Response(
                status: $exception->getCode() < 100 ? 500 : $exception->getCode(),
                headers: ['Content-Type' => 'application/json'],
                body: Utils::streamFor(json_encode([
                    'timestamp' => (new DateTime('now'))->format('Y-m-d\TH:i:s.vP'),
                    'status'    => $exception->getResponse()->getStatusCode() ?: 500,
                    'error'     => $exception->getResponse()->getReasonPhrase() ?: 'Bad Request',
                    'message'   => $exception->getResponse()?->getBody()?->getContents(),
                ]))
            );
        } catch (ClientExceptionInterface|Throwable $exception) {
            $this->logger->error(sprintf("Nacos Exception [%s] %s", get_class($exception), $exception->getMessage()));
            $response = new Response(
                status: $exception->getCode() < 100 ? 500 : $exception->getCode(),
                headers: ['Content-Type' => 'application/json'],
                body: Utils::streamFor(json_encode([
                    'timestamp' => (new DateTime('now'))->format('Y-m-d\TH:i:s.vP'),
                    'status'    => $exception->getCode() ?: 500,
                    'error'     => get_class($exception),
                    'message'   => $exception->getMessage(),
                ]))
            );
        }

        return $this->response->setResponse($response);
    }

}
