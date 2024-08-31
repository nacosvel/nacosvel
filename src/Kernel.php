<?php

namespace Nacosvel\Console;

use Exception;
use Nacosvel\Console\Exception\NacosvelConsoleException;
use Override;
use Symfony\Component\Console\Application;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class Kernel extends Application
{
    protected static array $bootstraps = [];

    public function __construct(string $name = 'Nacosvel Console', string $version = '1.0.0')
    {
        parent::__construct($name, $version);
    }

    public function getBootstraps(): array
    {
        if (count(self::$bootstraps) == 0) {
            self::$bootstraps = [];
        }

        return self::$bootstraps;
    }

    /**
     * @throws NacosvelConsoleException
     */
    #[Override]
    public function run(InputInterface $input = null, OutputInterface $output = null): int
    {
        $this->addCommands($this->getBootstraps());

        try {
            return parent::run($input, $output);
        } catch (Exception $e) {
            throw new NacosvelConsoleException($e->getMessage(), $e->getCode(), $e);
        }
    }

}
