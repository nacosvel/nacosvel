<?php

namespace Nacosvel\Composer\Contracts;

use Composer\Script\Event;

interface EventInterface
{
    public function __invoke(Event $event): void;

}
