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
use Nacosvel\NacosClient\Concerns\NacosServiceTrait;
use Nacosvel\NacosClient\Contracts\NacosRequestResponseInterface;
use Nacosvel\NacosClient\Contracts\NacosServiceInterface;
use Psr\Cache\CacheItemPoolInterface;
use Psr\Log\LoggerInterface;

class NacosService implements NacosServiceInterface
{
    use NacosServiceTrait;

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

        if ($this->username || $this->password) {
            $this->nacosAuth = new NacosAuth($this->username, $this->password);
        }

        $this->nacosConfig = new NacosConfig($this->serverAddr, $this->nacosAuth, $this->cache);
        $this->nacosClient = new NacosClient($this->nacosConfig, null, $this->client, $this->logger);

        $this->setNamespace($this->namespace);
    }

    protected function setPropertyValueNamespaceId(NacosRequestResponseInterface $request): NacosRequestResponseInterface
    {

        if ($request instanceof Contracts\V1\VersionInterface) {
            $request = $this->setPropertyValue($request, ['tenant', 'namespaceId']);
        }

        if ($request instanceof Contracts\V2\VersionInterface) {
            $request = $this->setPropertyValue($request, 'namespaceId');
        }

        return $request;
    }

    protected function setPropertyValue(NacosRequestResponseInterface $request, array|string $properties = [])
    {
        if (is_array($properties)) {
            foreach ($properties as $property) {
                $request = $this->setPropertyValue($request, $property);
            }
            return $request;
        }

        try {
            $reflection = new \ReflectionClass($request);

            if ($reflection->hasProperty($properties) === false) {
                return $request;
            }

            $property = $reflection->getProperty($properties);

            if ($property->isInitialized($request) && $property->getValue($request)) {
                return $request;
            }

            $property->setValue($request, $this->getNamespaceId());

            $request->parameter($properties, $this->getNamespaceId());
        } catch (\Throwable $e) {
            // I tried my best. When the program throws an error 🤪
        }

        return $request;
    }

    /**
     * @param NacosRequestResponseInterface $request
     *
     * @return NacosResponseInterface
     */
    public function execute(NacosRequestResponseInterface $request): NacosResponseInterface
    {
        if ($this->getNamespaceId()) {
            $request = $this->setPropertyValueNamespaceId($request);
        }

        var_dump($request->toArray());

        $response = $this->nacosClient->request($request);

        return $request->setResponse($response->getResponse());
    }

}
