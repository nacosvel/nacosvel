<?php

namespace Nacosvel\Composer\Events;

use Composer\Composer;
use Composer\IO\IOInterface;
use Composer\Package\PackageInterface;

class PostInstallEvent extends PackageEvent
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

        if (array_key_exists('consoles', $extra)) {
            $consoles = $extra['consoles'];
        } else {
            return;
        }

        $packageInstallPath = $this->packageManifest->getInstallPath($package->getName());

        if (!is_dir($packageInstallPath)) {
            return;
        }

        foreach ($consoles as $originalCommand => $console) {
            $this->copy(
                $this->packageManifest->combinePaths($packageInstallPath, $originalCommand),
                $this->packageManifest->getRootPath($console)
            );
        }
    }

    protected function copy(string $sourceFile, string $destFile): bool
    {
        if (file_exists($destFile)) {
            $this->io->write("<info>{$destFile} already exists.</info>");
            return false;
        }

        $destPath = dirname($destFile);

        if (!is_dir($destPath)) {
            mkdir($destPath, 0777, true);
        }

        if (copy($sourceFile, $destFile)) {
            $this->io->write("<comment>{$destFile} copied successfully.</comment>");
            return true;
        }

        $this->io->write("<error>{$destFile} copied failed.</error>");

        return false;
    }

}
