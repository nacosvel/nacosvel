# Nacosvel Package

A small utility library for handling metadata parsing and expansion.

[![GitHub Tag](https://img.shields.io/github/v/tag/nacosvel/package)](https://github.com/nacosvel/package/tags)
[![Total Downloads](https://img.shields.io/packagist/dt/nacosvel/package?style=flat-square)](https://packagist.org/packages/nacosvel/package)
[![Packagist Version](https://img.shields.io/packagist/v/nacosvel/package)](https://packagist.org/packages/nacosvel/package)
[![Packagist PHP Version Support](https://img.shields.io/packagist/php-v/nacosvel/package)](https://github.com/nacosvel/package)
[![Packagist License](https://img.shields.io/github/license/nacosvel/package)](https://github.com/nacosvel/package)

## 安装

推荐使用 PHP 包管理工具 [Composer](https://getcomposer.org/) 安装 SDK：

```bash
composer require nacosvel/package
```

## Interface Reference

Nacosvel\Package\Contracts\PackageInterface

- getRootPath(string $path = null): string;
- setRootPath(string $rootPath): static;
- getVendorPath(string $path = null): string;
- setVendorPath(string $vendorPath): static;
- combinePaths(string $basePath, string $relativePath): string;

Nacosvel\Package\Contracts\PackageManifestInterface

- getManifest(string $namespace = null, string ...$args): mixed;
- getPackageManifest(string ...$args): mixed;
- getInstallPath(string $packageName): ?string;
- getInstalledPackages(): array;

## Quick Examples

```php
$package = new \Nacosvel\Package\PackageManifest();

$package->getRootPath();
$package->getRootPath('composer.json');
$package->getVendorPath();
$package->getVendorPath('composer/installed.json');

$package->getManifest('psr/log', 'extra', 'branch-alias', 'dev-master');
$package->getPackageManifest('name');

$package->getInstalledPackages();
$package->getInstallPath('psr/log');
```

## License

Guzzle is made available under the MIT License (MIT). Please see [License File](LICENSE) for more information.
