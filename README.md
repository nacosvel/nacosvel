# Nacosvel Console

[![GitHub Tag](https://img.shields.io/github/v/tag/nacosvel/console)](https://github.com/nacosvel/console/tags)
[![Total Downloads](https://img.shields.io/packagist/dt/nacosvel/console?style=flat-square)](https://packagist.org/packages/nacosvel/console)
[![Packagist Version](https://img.shields.io/packagist/v/nacosvel/console)](https://packagist.org/packages/nacosvel/console)
[![Packagist PHP Version Support](https://img.shields.io/packagist/php-v/nacosvel/console)](https://github.com/nacosvel/console)
[![Packagist License](https://img.shields.io/github/license/nacosvel/console)](https://github.com/nacosvel/console)

## 环境和依赖

- PHP >= 8.0
- [Symfony Console](https://github.com/symfony/console) ^6.0

## 安装

推荐使用 PHP 包管理工具 [Composer](https://getcomposer.org/) 安装 SDK：

```bash
composer require nacosvel/console
```

## 开始使用

### 创建命令类

```php
<?php

namespace Nacosvel\Console\Command;

use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputOption;

class DemoCommand extends Command
{
    /**
     * @var string|null The default command name
     */
    protected static $defaultName = 'demo';

    /**
     * @var string|null The default command description
     */
    protected static $defaultDescription = 'demo description';

    protected function handle(): int
    {
        $this->line($this->argument('name'));
        $this->line($this->option('option'));

        $this->line('line');
        $this->newLine();
        $this->info('info');
        $this->warn('warn');
        $this->error('error');
        $this->question('question');
        $this->comment('comment');

        return self::SUCCESS;
    }

    /**
     * Get the console command arguments.
     *
     * @return array
     */
    protected function getArguments(): array
    {
        return [
            ['name', InputArgument::OPTIONAL, 'The name of the class', 'demo'],
        ];
    }

    /**
     * Get the console command options.
     *
     * @return array
     */
    protected function getOptions(): array
    {
        return [
            ['option', 'o', InputOption::VALUE_OPTIONAL, 'description', 'default'],
        ];
    }

}
```

### 注册命令

```php
<?php

use Nacosvel\Console\Command\DemoCommand;
use Nacosvel\Console\Kernel;

$kernel = new Kernel();
$kernel->add(new DemoCommand());
$kernel->run();
```

### 执行命令

```shell
php nacosvel demo nacosvel -o console
```

## License

Guzzle is made available under the MIT License (MIT). Please see [License File](LICENSE) for more information.
