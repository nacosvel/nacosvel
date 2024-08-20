<?php

namespace Nacosvel\Utils\Facades;

use Nacosvel\Utils\Support\Facade;
use RuntimeException;

/**
 * @method static array getEventsKeys(string $eventKey = null, bool $wildcard = false);
 * @method static bool hasEventsKeys(string $eventKey = null, bool $wildcard = false);
 * @method static array getEvents(string $eventKey = null, bool $wildcard = false);
 * @method static \Nacosvel\Utils\Emitter clear();
 * @method static \Nacosvel\Utils\Emitter reset();
 * @method static string getHash();
 * @method static \Nacosvel\Utils\Emitter setHash(string $hash);
 * @method static string getEventKey(string $key);
 * @method static void on(string|array $keys, callable $handler);
 * @method static void once(string|array $keys, callable $handler);
 * @method static void off(string|array $keys, ?callable $handler = null);
 * @method static array emit(string|array $keys, mixed ...$args);
 *
 * @see \Nacosvel\Utils\Emitter
 * @see \Nacosvel\Utils\Contracts\EmitterInterface
 */
class Emitter extends Facade
{

    /**
     * Get the registered name of the component.
     *
     * @return string
     *
     * @throws RuntimeException
     */
    protected static function getFacadeAccessor(): string
    {
        return \Nacosvel\Utils\Emitter::class;
    }

    /**
     * Get a resolved facade instance.
     *
     * @return \Nacosvel\Utils\Emitter
     */
    protected static function getFacadeInstance(): \Nacosvel\Utils\Emitter
    {
        return new \Nacosvel\Utils\Emitter();
    }
}
