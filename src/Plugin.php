<?php

namespace Nacosvel\Composer;

use Composer\Composer;
use Composer\EventDispatcher\EventSubscriberInterface;
use Composer\IO\IOInterface;
use Composer\Plugin\PluginInterface;
use Composer\Script\Event;
use Composer\Script\ScriptEvents;
use Nacosvel\Composer\Events\PostInstallEvent;
use Nacosvel\Composer\Events\PostUpdateEvent;

class Plugin implements PluginInterface, EventSubscriberInterface
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

    public static function getSubscribedEvents(): array
    {
        return [
            'post-autoload-dump' => [
                ['onNacosvelCommands'],
                ['onNacosvelConsoles'],
            ],
        ];
    }

    public static function onNacosvelCommands(Event $event)
    {
        return (new PostUpdateEvent($event->getComposer(), $event->getIO()))->handle($event->getComposer()->getPackage());
    }

    public static function onNacosvelConsoles(Event $event)
    {
        return (new PostInstallEvent($event->getComposer(), $event->getIO()))->handle($event->getComposer()->getPackage());
    }

}
