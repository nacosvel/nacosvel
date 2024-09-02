<?php

namespace Nacosvel\Composer\Events;

use Composer\Composer;
use Composer\IO\IOInterface;
use Composer\Package\PackageInterface;
use Composer\Script\Event;
use Nacosvel\Composer\Contracts\EventInterface;
use Nacosvel\Package\Contracts\PackageManifestInterface;
use Nacosvel\Package\PackageManifest;

abstract class PackageEvent implements EventInterface
{
    protected PackageManifestInterface $packageManifest;

    public function __construct(protected Composer $composer, protected IOInterface $io)
    {
        $this->packageManifest = new PackageManifest();
    }

    public function __invoke(Event $event): void
    {
        foreach ($event->getComposer()->getRepositoryManager()->getLocalRepository()->getPackages() as $package) {
            if (array_key_exists('nacosvel', $package->getExtra())) {
                $this->handle($package);
            }
        }
    }

    abstract public function handle(PackageInterface $package): void;

}
