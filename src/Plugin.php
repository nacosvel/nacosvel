<?php

namespace Nacosvel\Composer;

use Composer\Composer;
use Composer\EventDispatcher\EventSubscriberInterface;
use Composer\InstalledVersions;
use Composer\IO\IOInterface;
use Composer\Plugin\PluginInterface;
use Composer\Script\Event;

class Plugin implements PluginInterface, EventSubscriberInterface
{
    private Composer    $composer;
    private IOInterface $io;

    public function activate(Composer $composer, IOInterface $io): void
    {
        $this->composer = $composer;
        $this->io       = $io;
        $io->write("<question>Nacosvel\Composer has been activate</question>");
    }

    public function deactivate(Composer $composer, IOInterface $io): void
    {
        $io->write("<question>Nacosvel\Composer has been deactivate</question>");
    }

    public function uninstall(Composer $composer, IOInterface $io): void
    {
        $io->write("<warning>Nacosvel\Composer has been uninstalled</warning>");
    }

    public static function getSubscribedEvents(): array
    {
        return [
            'post-install-cmd' => 'onPostInstallCmd',
            'post-update-cmd'  => 'onPostUpdateCmd',
        ];
    }

    public function onPostInstallCmd(Event $event): void
    {
        $this->commands($event);
        $this->consoles($event);
    }

    public function onPostUpdateCmd(Event $event): void
    {
        $this->commands($event);
        $this->consoles($event);
    }

    protected function commands(Event $event): void
    {
        $rootPath      = $event->getComposer()->getConfig()->get('vendor-dir') . '/composer';
        $installedRepo = $event->getComposer()->getRepositoryManager()->getLocalRepository();
        foreach ($installedRepo->getPackages() as $package) {
            $extra = $package->getExtra();

            if (array_key_exists('nacosvel', $extra)) {
                $extra = $extra['nacosvel'];
            } else {
                continue;
            }

            $commandFile = 'nacosvel/command.json';
            if (array_key_exists('command-file', $extra)) {
                $commandFile = $extra['command-file'];
            }

            if (array_key_exists('commands', $extra)) {
                $commands = $extra['commands'];
            } else {
                continue;
            }

            $packageName = $package->getName();
            $cacheFile   = $rootPath . '/' . $commandFile;
            $cache       = $this->getCache($cacheFile);

            if (false === array_key_exists($packageName, $cache)) {
                $cache[$packageName] = [];
            }

            foreach ($commands as $command) {
                $cache[$packageName][] = $command;
            }

            $this->cache($cacheFile, $cache);

            $this->io->write("<comment>{$packageName} Commands cached successfully.</comment>");
        }
    }

    protected function consoles(Event $event): void
    {
        $rootPath      = $event->getComposer()->getConfig()->get('vendor-dir') . '/../';
        $rootPath      = realpath($rootPath);
        $installedRepo = $event->getComposer()->getRepositoryManager()->getLocalRepository();
        foreach ($installedRepo->getPackages() as $package) {
            $extra = $package->getExtra();


            if (array_key_exists('nacosvel', $extra)) {
                $extra = $extra['nacosvel'];
            } else {
                continue;
            }

            if (array_key_exists('consoles', $extra)) {
                $consoles = $extra['consoles'];
            } else {
                continue;
            }

            $packageInstallPath = realpath(InstalledVersions::getInstallPath($package->getName()));

            if (!is_dir($packageInstallPath)) {
                continue;
            }

            foreach ($consoles as $originalCommand => $console) {
                $this->copy($packageInstallPath . '/' . $originalCommand, $rootPath . '/' . $console);
            }
        }
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

    protected function copy(string $sourceFile, string $destFile): bool
    {
        if (file_exists($destFile)) {
            $this->io->write("<info>{$sourceFile} already exists.</info>");
            return false;
        }

        $destPath = dirname($destFile);

        if (!is_dir($destPath)) {
            mkdir($destPath, 0777, true);
        }

        if (copy($sourceFile, $destFile)) {
            $this->io->write("<comment>{$sourceFile} copied successfully.</comment>");
            return true;
        }

        $this->io->write("<error>{$sourceFile} copied failed.</error>");

        return false;
    }
}
