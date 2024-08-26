# Nacos Client SDK for PHP

[![GitHub Tag](https://img.shields.io/github/v/tag/nacosvel/nacos-sdk-php)](https://github.com/nacosvel/nacos-sdk-php/tags)
[![Total Downloads](https://img.shields.io/packagist/dt/nacosvel/nacos-sdk-php?style=flat-square)](https://packagist.org/packages/nacosvel/nacos-sdk-php)
[![Packagist Version](https://img.shields.io/packagist/v/nacosvel/nacos-sdk-php)](https://packagist.org/packages/nacosvel/nacos-sdk-php)
[![Packagist PHP Version Support](https://img.shields.io/packagist/php-v/nacosvel/nacos-sdk-php)](https://github.com/nacosvel/nacos-sdk-php)
[![Packagist License](https://img.shields.io/github/license/nacosvel/nacos-sdk-php)](https://github.com/nacosvel/nacos-sdk-php)

## 安装

推荐使用 PHP 包管理工具 [Composer](https://getcomposer.org/) 安装 SDK：

```bash
composer require nacosvel/nacos-sdk-php
```

## 文档

### Open-API 开启鉴权之前

```php
<?php

use Nacosvel\Nacos\NacosClient;
use Nacosvel\Nacos\NacosRequest;

$request  = new NacosRequest('http://127.0.0.1:8848');
//$request  = new NacosRequest('http://127.0.0.1:8848,http://127.0.0.2:8848');
//$request  = new NacosRequest([
//    'http://127.0.0.1:8848' => 5,
//    'http://127.0.0.2:8848' => 10,
//]);
$client   = new NacosClient($request);
$response = $client->execute('GET', 'nacos/v2/ns/instance/list', [
    'query' => [
        'serviceName' => 'nacosvel/nacos-sdk-php',
    ],
])->response();
var_dump($response);
```

### Open-API 开启鉴权之后

```php
<?php

use Nacosvel\Nacos\NacosAuth;
use Nacosvel\Nacos\NacosClient;
use Nacosvel\Nacos\NacosRequest;
use Symfony\Component\Cache\Adapter\FilesystemAdapter;

$request  = new NacosRequest('http://127.0.0.1:8848', new NacosAuth('nacos', 'nacos'), new FilesystemAdapter('cache.namespace'));
$client   = new NacosClient($request);
$response = $client->execute('GET', 'nacos/v2/ns/instance/list', [
    'query' => [
        'serviceName' => 'nacosvel/nacos-sdk-php',
    ],
])->response();
var_dump($response);
```

### `NacosResponseInterface` 自定义响应接口

```php
<?php

use Nacosvel\Nacos\NacosAuth;
use Nacosvel\Nacos\NacosClient;
use Nacosvel\Nacos\NacosRequest;
use Nacosvel\Nacos\NacosResponse;
use Psr\Log\NullLogger;
use Symfony\Component\Cache\Adapter\FilesystemAdapter;

$request  = new NacosRequest('http://127.0.0.1:8848', new NacosAuth('nacos', 'nacos'), new FilesystemAdapter('cache.namespace'));
$client   = new NacosClient($request, new NacosResponse(), new NullLogger());
$response = $client->execute('GET', 'nacos/v2/ns/instance/list', [
    'query' => [
        'serviceName' => 'nacosvel/nacos-sdk-php',
    ],
])->response();
var_dump($response);
```

### `response(ResponseInterface $response)` 自定义响应方法

```php
<?php

use Nacosvel\Nacos\NacosAuth;
use Nacosvel\Nacos\NacosClient;
use Nacosvel\Nacos\NacosRequest;
use Nacosvel\Nacos\NacosResponse;
use Psr\Log\NullLogger;
use Symfony\Component\Cache\Adapter\FilesystemAdapter;

$request  = new NacosRequest('http://127.0.0.1:8848', new NacosAuth('nacos', 'nacos'), new FilesystemAdapter('cache.namespace'));
$client   = new NacosClient($request, new NacosResponse(), new NullLogger());
$response = $client->execute('GET', 'nacos/v2/ns/instance/list', [
    'query' => [
        'serviceName' => 'nacosvel/nacos-sdk-php',
    ],
])->response(function (\Psr\Http\Message\ResponseInterface $response) {
    return $response->getBody()->getContents();
});
var_dump($response);
```

### `$client->setClient(new Client());` 自定义 `HTTP requests Client`

```php
<?php

use GuzzleHttp\Client;
use Nacosvel\Nacos\NacosAuth;
use Nacosvel\Nacos\NacosClient;
use Nacosvel\Nacos\NacosRequest;
use Nacosvel\Nacos\NacosResponse;
use Psr\Log\NullLogger;
use Symfony\Component\Cache\Adapter\FilesystemAdapter;

$request = new NacosRequest('http://127.0.0.1:8848', new NacosAuth('nacos', 'nacos'), new FilesystemAdapter('cache.namespace'));
$client  = new NacosClient($request, new NacosResponse(), new NullLogger());
$client->setClient(new Client());
$response = $client->execute('GET', 'nacos/v2/ns/instance/list', [
    'query' => [
        'serviceName' => 'nacosvel/nacos-sdk-php',
    ],
])->response();
var_dump($response);
```

### 完整示例

```php
<?php

use GuzzleHttp\Client;
use Nacosvel\Nacos\NacosAuth;
use Nacosvel\Nacos\NacosClient;
use Nacosvel\Nacos\NacosConfig;
use Nacosvel\Nacos\NacosRequest;
use Nacosvel\Nacos\NacosResponse;
use Psr\Log\NullLogger;
use Symfony\Component\Cache\Adapter\FilesystemAdapter;

$config  = new NacosConfig('http://127.0.0.1:8848');
$auth    = new NacosAuth('nacos', 'nacos');
$cache   = new FilesystemAdapter('cache.namespace');
$request = new NacosRequest($config, $auth, $cache);
$client  = new NacosClient($request, new NacosResponse(), new NullLogger());
$client->setClient(new Client());
$response = $client->execute('GET', 'nacos/v2/ns/instance/list', [
    'query' => [
        'serviceName' => 'nacosvel/nacos-sdk-php',
    ],
])->response();
var_dump($response);
```

## License

Guzzle is made available under the MIT License (MIT). Please see [License File](LICENSE) for more information.
