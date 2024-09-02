<?php

namespace Nacosvel\Composer;

use Composer\Composer;
use Composer\IO\IOInterface;
use Composer\Plugin\PluginInterface;
use Composer\Script\ScriptEvents;
use Nacosvel\Composer\Events\PostInstallEvent;
use Nacosvel\Composer\Events\PostUpdateEvent;

class Plugin implements PluginInterface
{
    public function activate(Composer $composer, IOInterface $io): void
    {
        $eventDispatcher = $composer->getEventDispatcher();

        $eventDispatcher->addListener(ScriptEvents::POST_AUTOLOAD_DUMP, new PostInstallEvent($composer, $io));
        $eventDispatcher->addListener(ScriptEvents::POST_AUTOLOAD_DUMP, new PostUpdateEvent($composer, $io));

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

}
