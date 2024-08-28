# The PHP Nacos client for request and response data is strongly typed and IDE-friendly.

[![GitHub Tag](https://img.shields.io/github/v/tag/nacosvel/nacos-client)](https://github.com/nacosvel/nacos-client/tags)
[![Total Downloads](https://img.shields.io/packagist/dt/nacosvel/nacos-client?style=flat-square)](https://packagist.org/packages/nacosvel/nacos-client)
[![Packagist Version](https://img.shields.io/packagist/v/nacosvel/nacos-client)](https://packagist.org/packages/nacosvel/nacos-client)
[![Packagist PHP Version Support](https://img.shields.io/packagist/php-v/nacosvel/nacos-client)](https://github.com/nacosvel/nacos-client)
[![Packagist License](https://img.shields.io/github/license/nacosvel/nacos-client)](https://github.com/nacosvel/nacos-client)

## 安装

推荐使用 PHP 包管理工具 [Composer](https://getcomposer.org/) 安装 SDK：

```bash
composer require nacosvel/nacos-client
```

## 开发计划

- [ ] 配置管理
- [ ] 服务发现
- [ ] 命名空间
- [x] Open-API鉴权
- [ ] 运维API

## 接口列表

- ✅ Done
- ⬜ To Do
- 🔄 In Progress
- ❌ Unsupported

### 配置管理

| interface                                                      | implements                                                 | v1                                         | v2                                         |
|----------------------------------------------------------------|------------------------------------------------------------|--------------------------------------------|--------------------------------------------|
| [2.1. 获取配置](src/Config/RequestConfigRequest.php)               | `Nacosvel\NacosClient\Config\RequestConfigRequest`         | [✅](#/nacos/v1/cs/configs)                 | [✅](#/nacos/v2/cs/config)                  |
| [监听配置](src/Config/ListenerConfigRequest.php)                   | `Nacosvel\NacosClient\Config\ListenerConfigRequest`        | [⬜](#/nacos/v1/cs/configs/listener)        | ❌                                          |
| [2.2. 发布配置](src/Config/PublishConfigRequest.php)               | `Nacosvel\NacosClient\Config\PublishConfigRequest`         | [⬜](#/nacos/v1/cs/configs)                 | [⬜](#/nacos/v2/cs/config)                  |
| [2.3. 删除配置](src/Config/DeleteConfigRequest.php)                | `Nacosvel\NacosClient\Config\DeleteConfigRequest`          | [⬜](#/nacos/v1/cs/configs)                 | [⬜](#/nacos/v2/cs/config)                  |
| [2.3. 查询配置历史列表](src/Config/HistoryListConfigRequest.php)       | `Nacosvel\NacosClient\Config\HistoryListConfigRequest`     | [⬜](#/nacos/v1/cs/history?search=accurate) | [⬜](#/nacos/v2/cs/history/list)            |
| [2.3. 查询具体版本的历史配置](src/Config/HistoryConfigRequest.php)        | `Nacosvel\NacosClient\Config\HistoryConfigRequest`         | [⬜](#/nacos/{Version}/cs/history)          | [⬜](#/nacos/{Version}/cs/history)          |
| [2.6. 查询配置上一版本信息](src/Config/HistoryPreviousConfigRequest.php) | `Nacosvel\NacosClient\Config\HistoryPreviousConfigRequest` | [⬜](#/nacos/{Version}/cs/history/previous) | [⬜](#/nacos/{Version}/cs/history/previous) |

### 服务发现

| interface                                                                   | implements                                                       | v1                                                | v2                                                | 
|-----------------------------------------------------------------------------|------------------------------------------------------------------|---------------------------------------------------|---------------------------------------------------|
| [3.1. 注册实例](src/Naming/RegisterInstanceRequest.php)                         | `Nacosvel\NacosClient\Naming\RegisterInstanceRequest`            | [⬜](#/nacos/{Version}/ns/instance)                | [⬜](#/nacos/{Version}/ns/instance)                |
| [3.2. 注销实例](src/Naming/DeregisterInstanceRequest.php)                       | `Nacosvel\NacosClient\Naming\DeregisterInstanceRequest`          | [⬜](#/nacos/{Version}/ns/instance)                | [⬜](#/nacos/{Version}/ns/instance)                |
| [3.3. 更新实例](src/Naming/UpdateInstanceRequest.php)                           | `Nacosvel\NacosClient\Naming\UpdateInstanceRequest`              | [⬜](#/nacos/{Version}/ns/instance)                | [⬜](#/nacos/{Version}/ns/instance)                |
| [3.4. 查询实例详情](src/Naming/InstanceRequest.php)                               | `Nacosvel\NacosClient\Naming\InstanceRequest`                    | [⬜](#/nacos/{Version}/ns/instance)                | [⬜](#/nacos/{Version}/ns/instance)                |
| [3.5. 查询指定服务的实例列表](src/Naming/InstanceListRequest.php)                      | `Nacosvel\NacosClient\Naming\InstanceListRequest`                | [⬜](#/nacos/{Version}/ns/instance/list)           | [⬜](#/nacos/{Version}/ns/instance/list)           |
| [发送实例心跳](src/Naming/InstanceBeatRequest.php)                                | `Nacosvel\NacosClient\Naming\InstanceBeatRequest`                | [⬜](#/nacos/v1/ns/instance/beat)                  | ❌                                                 |
| [3.6. 批量更新实例元数据](src/Naming/UpdateInstanceMetadataBatchRequest.php)         | `Nacosvel\NacosClient\Naming\UpdateInstanceMetadataBatchRequest` | [⬜](#/nacos/{Version}/ns/instance/metadata/batch) | [⬜](#/nacos/{Version}/ns/instance/metadata/batch) |
| [3.7. 批量删除实例元数据](src/Naming/DeleteInstanceMetadataBatchRequest.php)         | `Nacosvel\NacosClient\Naming\DeleteInstanceMetadataBatchRequest` | [⬜](#/nacos/{Version}/ns/instance/metadata/batch) | [⬜](#/nacos/{Version}/ns/instance/metadata/batch) |
| [3.8. 创建服务](src/Naming/CreateServiceRequest.php)                            | `Nacosvel\NacosClient\Naming\CreateServiceRequest`               | [⬜](#/nacos/{Version}/ns/service)                 | [⬜](#/nacos/{Version}/ns/service)                 |
| [3.9. 删除服务](src/Naming/DeleteServiceRequest.php)                            | `Nacosvel\NacosClient\Naming\DeleteServiceRequest`               | [⬜](#/nacos/{Version}/ns/service)                 | [⬜](#/nacos/{Version}/ns/service)                 |
| [3.10. 修改服务](src/Naming/UpdateServiceRequest.php)                           | `Nacosvel\NacosClient\Naming\UpdateServiceRequest`               | [⬜](#/nacos/{Version}/ns/service)                 | [⬜](#/nacos/{Version}/ns/service)                 |
| [3.11. 查询服务详情](src/Naming/ServiceRequest.php)                               | `Nacosvel\NacosClient\Naming\ServiceRequest`                     | [⬜](#/nacos/{Version}/ns/service)                 | [⬜](#/nacos/{Version}/ns/service)                 |
| [3.12. 查询服务列表](src/Naming/ServiceListRequest.php)                           | `Nacosvel\NacosClient\Naming\ServiceListRequest`                 | [⬜](#/nacos/{Version}/ns/service/list)            | [⬜](#/nacos/{Version}/ns/service/list)            |
| [3.13. 更新实例健康状态](src/Naming/UpdateHealthInstanceRequest.php)                | `Nacosvel\NacosClient\Naming\UpdateHealthInstanceRequest`        | [⬜](#/nacos/{Version}/ns/health/instance)         | [⬜](#/nacos/{Version}/ns/health/instance)         |
| [查询系统开关](src/Naming/OperatorSwitchesRequest.php)                            | `Nacosvel\NacosClient\Naming\OperatorSwitchesRequest`            | [⬜](#/nacos/v1/ns/operator/switches)              | ❌                                                 |
| [修改系统开关](src/Naming/UpdateOperatorSwitchesRequest.php)                      | `Nacosvel\NacosClient\Naming\UpdateOperatorSwitchesRequest`      | [⬜](#/nacos/v1/ns/operator/switches)              | ❌                                                 |
| [查看系统当前数据指标](src/Naming/OperatorMetricsRequest.php)                         | `Nacosvel\NacosClient\Naming\OperatorMetricsRequest`             | [⬜](#/nacos/v1/ns/operator/metrics)               | ❌                                                 |
| [查看当前集群Server列表](src/Naming/OperatorServersRequest.php)                     | `Nacosvel\NacosClient\Naming\OperatorServersRequest`             | [⬜](#/nacos/v1/ns/operator/servers)               | ❌                                                 |
| [查看当前集群leader](src/Naming/RaftLeaderRequest.php)                            | `Nacosvel\NacosClient\Naming\RaftLeaderRequest`                  | [⬜](#/nacos/v1/ns/raft/leader)                    | ❌                                                 |
| [3.14. 查询客户端列表（新）](src/Naming/ClientListRequest.php)                        | `Nacosvel\NacosClient\Naming\ClientListRequest`                  | ❌                                                 | [⬜](#/nacos/v2/ns/client/list)                    |
| [3.15. 查询客户端信息（新）](src/Naming/ClientRequest.php)                            | `Nacosvel\NacosClient\Naming\ClientRequest`                      | ❌                                                 | [⬜](#/nacos/v2/ns/client)                         |
| [3.16. 查询客户端的注册信息（新）](src/Naming/ClientPublishListRequest.php)              | `Nacosvel\NacosClient\Naming\ClientPublishListRequest`           | ❌                                                 | [⬜](#/nacos/v2/ns/client/publish/list)            |
| [3.17. 查询客户端的订阅信息（新）](src/Naming/ClientSubscribeListRequest.php)            | `Nacosvel\NacosClient\Naming\ClientSubscribeListRequest`         | ❌                                                 | [⬜](#/nacos/v2/ns/client/subscribe/list)          |
| [3.18. 查询注册指定服务的客户端信息（新）](src/Naming/ClientServersPublishListRequest.php)   | `Nacosvel\NacosClient\Naming\ClientServersPublishListRequest`    | ❌                                                 | [⬜](#/nacos/v2/ns/client/service/publisher/list)  |
| [3.19. 查询订阅指定服务的客户端信息（新）](src/Naming/ClientServersSubscribeListRequest.php) | `Nacosvel\NacosClient\Naming\ClientServersSubscribeListRequest`  | ❌                                                 | [⬜](#/nacos/v2/ns/client/service/subscriber/list) |

### 命名空间

| interface                                             | implements                                            | v1                                       | v2                                       |
|-------------------------------------------------------|-------------------------------------------------------|------------------------------------------|------------------------------------------|
| [4.1. 查询命名空间列表](src/Console/NamespaceListRequest.php) | `Nacosvel\NacosClient\Console\NamespaceListRequest`   | ❌                                        | [⬜](#/nacos/v2/console/namespace/list)   | 
| [4.2. 查询具体命名空间](src/Console/NamespaceRequest.php)     | `Nacosvel\NacosClient\Console\NamespaceRequest`       | [⬜](#/nacos/{Version}/console/namespace) | [⬜](#/nacos/{Version}/console/namespace) |
| [4.3. 创建命名空间](src/Console/CreateNamespaceRequest.php) | `Nacosvel\NacosClient\Console\CreateNamespaceRequest` | [⬜](#/nacos/{Version}/console/namespace) | [⬜](#/nacos/{Version}/console/namespace) |
| [4.4. 编辑命名空间](src/Console/UpdateNamespaceRequest.php) | `Nacosvel\NacosClient\Console\UpdateNamespaceRequest` | [⬜](#/nacos/{Version}/console/namespace) | [⬜](#/nacos/{Version}/console/namespace) |
| [4.5. 删除命名空间](src/Console/DeleteNamespaceRequest.php) | `Nacosvel\NacosClient\Console\DeleteNamespaceRequest` | [⬜](#/nacos/{Version}/console/namespace) | [⬜](#/nacos/{Version}/console/namespace) |

### Open-API鉴权

| interface                               | implements                               | v1                         | v2 |
|-----------------------------------------|------------------------------------------|----------------------------|----|
| [Open-API鉴权](src/Auth/LoginRequest.php) | `Nacosvel\NacosClient\Auth\LoginRequest` | [✅](#/nacos/v1/auth/login) | ❌  |

## License

Guzzle is made available under the MIT License (MIT). Please see [License File](LICENSE) for more information.
