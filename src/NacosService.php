<?php

namespace Nacosvel\NacosClient;

use GuzzleHttp\ClientInterface;
use Nacosvel\Nacos\Contracts\NacosAuthInterface;
use Nacosvel\Nacos\Contracts\NacosClientInterface;
use Nacosvel\Nacos\Contracts\NacosConfigInterface;
use Nacosvel\Nacos\Contracts\NacosResponseInterface;
use Nacosvel\Nacos\NacosAuth;
use Nacosvel\Nacos\NacosClient;
use Nacosvel\Nacos\NacosConfig;
use Nacosvel\NacosClient\Contracts\NacosRequestResponseInterface;
use Nacosvel\NacosClient\Contracts\NacosServiceInterface;
use Psr\Cache\CacheItemPoolInterface;
use Psr\Log\LoggerInterface;

class NacosService implements NacosServiceInterface
{
    protected string $namespaceId = '';

    protected ?NacosAuthInterface     $nacosAuth = null;
    protected ?CacheItemPoolInterface $cache     = null;
    protected NacosConfigInterface    $nacosConfig;
    protected ?ClientInterface        $client    = null;
    protected ?LoggerInterface        $logger    = null;
    protected NacosClientInterface    $nacosClient;

    public function __construct(
        protected array|string $serverAddr = '',
        protected string       $namespace = 'public',
        protected ?string      $username = null,
        protected ?string      $password = null,
    )
    {
        if (!$serverAddr) {
            throw new \InvalidArgumentException('$serverAddr is required for NacosService');
        }
        if (is_string($serverAddr)) {
            $this->serverAddr = explode(',', $serverAddr);
        }
        if (!$namespace) {
            $namespace = 'public';
        }
        $this->namespace = $namespace;

        if ($this->username || $this->password) {
            $this->nacosAuth = new NacosAuth($this->username, $this->password);
        }

        $this->nacosConfig = new NacosConfig($this->serverAddr, $this->nacosAuth, $this->cache);
        $this->nacosClient = new NacosClient($this->nacosConfig, null, $this->client, $this->logger);
    }

    /**
     * @param CacheItemPoolInterface $cache
     *
     * @return static
     */
    public function withCache(CacheItemPoolInterface $cache): static
    {
        $this->nacosConfig->setCache($this->cache = $cache);
        return $this;
    }

    /**
     * @param ClientInterface $client
     *
     * @return static
     */
    public function withClient(ClientInterface $client): static
    {
        $this->nacosClient->setClient($this->client = $client);
        return $this;
    }

    /**
     * @param LoggerInterface $logger
     *
     * @return static
     */
    public function withLogger(LoggerInterface $logger): static
    {
        $this->nacosClient->setLogger($this->logger = $logger);
        return $this;
    }

    /**
     * @param NacosRequestResponseInterface $request
     *
     * @return NacosResponseInterface
     */
    public function execute(NacosRequestResponseInterface $request): NacosResponseInterface
    {
        $response = $this->nacosClient->request($request);

        return $request->setResponse($response->getResponse());
    }

}
