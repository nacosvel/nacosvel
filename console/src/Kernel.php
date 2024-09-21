<?php

namespace Nacosvel\Console;

use Exception;
use Nacosvel\Console\Command\Command;
use Nacosvel\Console\Exception\NacosvelConsoleException;
use Nacosvel\Package\Contracts\PackageManifestInterface;
use Nacosvel\Package\PackageManifest;
use Override;
use Symfony\Component\Console\Application;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class Kernel extends Application
{
    protected static array             $bootstraps = [];
    protected PackageManifestInterface $packageManifest;

    public function __construct(protected string $cacheCommandFile = 'nacosvel/command.json')
    {
        parent::__construct('Nacosvel Console', '1.0.0');
        $this->packageManifest = new PackageManifest();
        $this->setCacheCommandFile($this->cacheCommandFile);
    }

    /**
     * @return string
     */
    public function getCacheCommandFile(): string
    {
        return $this->cacheCommandFile;
    }

    /**
     * @param string $cacheCommandFile
     *
     * @return Kernel
     */
    public function setCacheCommandFile(string $cacheCommandFile): Kernel
    {
        $path                   = $this->packageManifest->getVendorPath('composer');
        $this->cacheCommandFile = $this->packageManifest->combinePaths($path, $cacheCommandFile);
        return $this;
    }

    protected function getCacheCommands(): array
    {
        if (!is_file($this->getCacheCommandFile())) {
            return [];
        }

        $cache = json_decode(file_get_contents($this->getCacheCommandFile()), true) ?? [];

        return array_unique(array_merge(...array_values($cache)));
    }

    protected function getBootstraps(): array
    {
        if (self::$bootstraps) {
            return self::$bootstraps;
        }

        foreach ($this->getCacheCommands() as $command) {
            if (class_exists($command) && is_subclass_of($command, Command::class)) {
                self::$bootstraps[] = new $command();
            }
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
