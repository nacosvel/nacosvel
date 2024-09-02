<?php

namespace Nacosvel\Composer\Events;

use Composer\Script\Event;
use Nacosvel\Composer\Contracts\EventInterface;

class NacosvelEvent implements EventInterface
{
    public function __invoke(Event $event): void
    {
        $dispatcher = $event->getComposer()->getEventDispatcher();
        $nacosvel   = new Event('nacosvel', $event->getComposer(), $event->getIO());
        $dispatcher->dispatch($nacosvel->getName(), $nacosvel);
    }

}
