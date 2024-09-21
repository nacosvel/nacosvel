# Nacosvel Composer

A Composer Plugin for Publishing Console Tools and Caching Commands.

[![GitHub Tag](https://img.shields.io/github/v/tag/nacosvel/composer)](https://github.com/nacosvel/composer/tags)
[![Total Downloads](https://img.shields.io/packagist/dt/nacosvel/composer?style=flat-square)](https://packagist.org/packages/nacosvel/composer)
[![Packagist Version](https://img.shields.io/packagist/v/nacosvel/composer)](https://packagist.org/packages/nacosvel/composer)
[![Packagist PHP Version Support](https://img.shields.io/packagist/php-v/nacosvel/composer)](https://github.com/nacosvel/composer)
[![Packagist License](https://img.shields.io/github/license/nacosvel/composer)](https://github.com/nacosvel/composer)

## 安装

推荐使用 PHP 包管理工具 [Composer](https://getcomposer.org/) 安装 SDK：

```bash
composer require nacosvel/composer
```

```json5
{
    // ...
    "extra": {
        "nacosvel": {
            "commands": []
        }
    }
    // ...
}
```

```json5
{
    // ...
    "extra": {
        "nacosvel": {
            "consoles": {}
        }
    }
    // ...
}
```

## License

Guzzle is made available under the MIT License (MIT). Please see [License File](LICENSE) for more information.
