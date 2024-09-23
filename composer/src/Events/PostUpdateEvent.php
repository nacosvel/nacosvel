<?php

namespace Nacosvel\Composer\Events;

use Composer\Composer;
use Composer\IO\IOInterface;
use Composer\Package\PackageInterface;

class PostUpdateEvent extends PackageEvent
{
    public function __construct(Composer $composer, IOInterface $io)
    {
        parent::__construct($composer, $io);
    }

    public function handle(PackageInterface $package): void
    {
        $extra = $package->getExtra();

        if (array_key_exists('nacosvel', $extra)) {
            $extra = $extra['nacosvel'];
        } else {
            return;
        }

        $commandFile = 'nacosvel/command.json';
        if (array_key_exists('command-file', $extra)) {
            $commandFile = $extra['command-file'];
        }

        if (array_key_exists('commands', $extra)) {
            $commands = $extra['commands'];
        } else {
            return;
        }

        $packageName  = $package->getName();
        $composerPath = $this->packageManifest->getVendorPath('composer');
        $cacheFile    = $this->packageManifest->combinePaths($composerPath, $commandFile);
        $cache        = $this->getCache($cacheFile);

        if (false === array_key_exists($packageName, $cache)) {
            $cache[$packageName] = [];
        }

        foreach ($commands as $command) {
            $cache[$packageName][] = $command;
        }

        $this->cache($cacheFile, array_map(function ($cache) {
            return array_unique($cache);
        }, $cache));

        $this->io->write("<comment>{$packageName} Commands cached successfully.</comment>");
    }

    protected function getCache(string $filePath): array
    {
        if (!file_exists($filePath)) {
            return [];
        }

        $cache = json_decode(file_get_contents($filePath), true);

        if (json_last_error() == JSON_ERROR_NONE) {
            return is_array($cache) ? $cache : [];
        }

        return [];
    }

    protected function cache(string $filePath, array $commands): void
    {
        $dir = dirname($filePath);

        if (!is_dir($dir)) {
            mkdir($dir, 0777, true);

            if (!is_dir($dir)) {
                $this->io->write("<error>Failed [{$dir}] to create directories</error>");
            }
        }

        if (!file_put_contents($filePath, json_encode($commands, JSON_PRETTY_PRINT))) {
            $this->io->write("<error>Failed to save cached file [{$filePath}]</error>");
        }
    }

}
