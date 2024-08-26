<?php

namespace Nacosvel\Nacos;

use Exception;
use Nacosvel\Nacos\Concerns\NacosAuthTrait;
use Nacosvel\Nacos\Contracts\NacosAuthInterface;
use Nacosvel\Nacos\Contracts\NacosClientInterface;
use Psr\Cache\InvalidArgumentException;

class NacosAuth implements NacosAuthInterface
{
    use NacosAuthTrait;

    public function __construct(protected ?string $username = null, protected ?string $password = null)
    {
        //
    }

    public function getAccessToken(NacosClientInterface $client): bool
    {
        $cache    = $client->getRequest()->getCache();
        $config   = $client->getRequest()->getConfig();
        $response = $client->execute('POST', '/nacos/v1/auth/login', [
            'form_params' => [
                'username' => $this->getUsername(),
                'password' => $this->getPassword(),
            ],
        ])->response();

        if (false === array_key_exists('accessToken', $response)) {
            return false;
        }

        if (false === array_key_exists('tokenTtl', $response)) {
            return false;
        }

        try {
            $item = $cache->getItem(md5($config->getUri()));
            $cache->save($item->set($response['accessToken'])->expiresAfter($response['tokenTtl']));
        } catch (Exception|InvalidArgumentException $exception) {
            return false;
        }

        return true;
    }

}
