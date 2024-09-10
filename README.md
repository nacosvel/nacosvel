# Nacosvel Container Interop

## Achieve compatibility and interoperability among different container objects.

The library discovers available PSR-11 container implementations by searching for a list of known classes that implement
the relevant interfaces, and returns an instance of the first one found. It supports binding, instantiation, and allows
executing specific callbacks or logic when a class or dependency is resolving (i.e., instantiated or injected).

[![GitHub Tag](https://img.shields.io/github/v/tag/nacosvel/container-interop)](https://github.com/nacosvel/container-interop/tags)
[![Total Downloads](https://img.shields.io/packagist/dt/nacosvel/container-interop?style=flat-square)](https://packagist.org/packages/nacosvel/container-interop)
[![Packagist Version](https://img.shields.io/packagist/v/nacosvel/container-interop)](https://packagist.org/packages/nacosvel/container-interop)
[![Packagist PHP Version Support](https://img.shields.io/packagist/php-v/nacosvel/container-interop)](https://github.com/nacosvel/container-interop)
[![Packagist License](https://img.shields.io/github/license/nacosvel/container-interop)](https://github.com/nacosvel/container-interop)

## 安装

推荐使用 PHP 包管理工具 [Composer](https://getcomposer.org/) 安装 SDK：

```bash
composer require nacosvel/container-interop
```

## Usage

### Default Method Names

If your container uses the standard method names (bind, make, resolving), you can simply call:

```php
use Nacosvel\Interop\Container\Discover;

Discover::container();
```

discovers available PSR-11 container implementations by searching for a list of known classes that implement the
relevant interfaces

### Custom Method Names

If your container uses different method names, specify them as follows:

```php
use Nacosvel\Interop\Container\Discover;

Discover::container(
    container: $container,
    bind: 'customBindMethod',
    make: 'customMakeMethod',
    resolving: 'customResolvingMethod'
);
```

or

```php
use Nacosvel\Interop\Container\Discover;

Discover::container(
    container: $container,
    bind: function ($abstract, $concrete) use ($container) {
        return call_user_func([$container, 'your bind method name'], $abstract, $concrete);
    },
    make: function ($abstract, array $parameters = []) use ($container) {
        return call_user_func([$container, 'your make method name'], $abstract, $parameters);
    },
    resolving: function ($abstract, Closure $callback = null) use ($container) {
        return call_user_func([$container, 'your resolving method name'], $abstract, $callback);
    }
);
```

- `container`: The container instance you want to work with.
- `bind`: The name of the method used for binding dependencies.
- `make`: The name of the method used for creating instances.
- `resolving`: The name of the method used for resolving dependencies.

### Accessing the Container

Once configured, third-party packages can access the container using:

```php
use Nacosvel\Interop\Container\Nacosvel;

$container = Nacosvel::getInstance()->getContainer();
```

This method ensures compatibility with various container implementations without worrying about their specific methods.

## License

Guzzle is made available under the MIT License (MIT). Please see [License File](LICENSE) for more information.
