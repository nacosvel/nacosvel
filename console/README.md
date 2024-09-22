# Nacosvel Console

[![GitHub Tag](https://img.shields.io/github/v/tag/nacosvel/console)](https://github.com/nacosvel/console/tags)
[![Total Downloads](https://img.shields.io/packagist/dt/nacosvel/console?style=flat-square)](https://packagist.org/packages/nacosvel/console)
[![Packagist Version](https://img.shields.io/packagist/v/nacosvel/console)](https://packagist.org/packages/nacosvel/console)
[![Packagist PHP Version Support](https://img.shields.io/packagist/php-v/nacosvel/console)](https://github.com/nacosvel/console)
[![Packagist License](https://img.shields.io/github/license/nacosvel/console)](https://github.com/nacosvel/console)

## Requirements

- PHP >= 8.0
- [Symfony Console](https://github.com/symfony/console) ^6.0

## Installation

You can install the package via [Composer](https://getcomposer.org/):

```bash
composer require nacosvel/console
```

## Getting Started

```shell
php ns
```

```bash
Nacosvel Console 1.0.0

Usage:
  command [options] [arguments]

Options:
  -h, --help            Display help for the given command. When no command is given display help for the list command
  -q, --quiet           Do not output any message
  -V, --version         Display this application version
      --ansi|--no-ansi  Force (or disable --no-ansi) ANSI output
  -n, --no-interaction  Do not ask any interactive question
  -v|vv|vvv, --verbose  Increase the verbosity of messages: 1 for normal output, 2 for more verbose output and 3 for debug

Available commands:
  completion  Dump the shell completion script
  help        Display help for a command
  list        List commands
```

## Quick Examples

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

use Nacosvel\Console;

$console = new Console\Kernel();
$console->add(new Console\Command\DemoCommand());
$console->run();
```

### 配置命令自动注册

```json5
{
    // ...
    "extra": {
        "nacosvel": {
            "commands": [
                // "Nacosvel\\Console\\Command\\DemoCommand"
                // Add your custom Command
            ]
        }
    }
}
```

### 执行命令

```shell
php ns demo nacosvel -o console
```

## License

Nacosvel Console is made available under the MIT License (MIT). Please see [License File](LICENSE) for more information.
