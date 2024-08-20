<?php

namespace Nacosvel\Utils;

use Nacosvel\Utils\Contracts\EmitterInterface;

class Emitter implements EmitterInterface
{
    protected static array $events = [];

    protected ?string $hash = null;

    public function __construct(string $hash = null)
    {
        $this->hash = $hash ?: spl_object_hash($this);
    }

    /**
     * 根据指定模式获取指定事件键名集合
     *
     * @param string|null $eventKey 指定键名
     * @param bool        $wildcard 模式匹配
     *
     * @return array
     */
    public function getEventsKeys(string $eventKey = null, bool $wildcard = false): array
    {
        return array_keys($this->getEvents($eventKey, $wildcard));
    }

    /**
     * 根据指定模式判断是否存在指定键名
     *
     * @param string|null $eventKey 指定键名
     * @param bool        $wildcard 模式匹配
     *
     * @return bool
     */
    public function hasEventsKeys(string $eventKey = null, bool $wildcard = false): bool
    {
        return count($this->getEvents($eventKey, $wildcard)) > 0;
    }

    /**
     * 根据指定模式获取指定事件集合
     *
     * @param string|null $eventKey 指定键名
     * @param bool        $wildcard 模式匹配
     *
     * @return array
     */
    public function getEvents(string $eventKey = null, bool $wildcard = false): array
    {
        if (is_null($eventKey)) {
            return array_filter(self::$events, function ($eventName) {
                return $this->matches($this->getEventKey('*'), $eventName);
            }, ARRAY_FILTER_USE_KEY);
        }
        return array_filter($this->getEvents(), function ($eventName) use ($eventKey, $wildcard) {
            return $wildcard ? $this->matches($eventKey, $eventName) : $eventKey == $eventName;
        }, ARRAY_FILTER_USE_KEY);
    }

    /**
     * 设置事件
     *
     * @param array $events
     *
     * @return static
     */
    protected function setEvents(array $events): static
    {
        self::$events = $events;

        return $this;
    }

    /**
     * 清空所有实例事件集合
     *
     * @return static
     */
    public function clear(): static
    {
        self::$events = [];

        return $this;
    }

    /**
     * 重置当前实例事件集合
     *
     * @return static
     */
    public function reset(): static
    {
        foreach ($this->getEventsKeys() as $eventKey) {
            unset(self::$events[$eventKey]);
        }

        return $this;
    }

    public function getHash(): string
    {
        return $this->hash;
    }

    public function setHash(string $hash): static
    {
        $this->hash = $hash;

        return $this;
    }

    /**
     * 获取事件键名
     *
     * @param string $key
     *
     * @return string
     */
    public function getEventKey(string $key): string
    {
        return "{$this->getHash()}:{$key}";
    }

    /**
     * Register an event handler for the given event.
     *
     * @param string|array $keys    Type of event to listen for, or '*' for all events
     * @param callable     $handler Function to call in response to given event
     *
     * @return void
     */
    public function on(string|array $keys, callable $handler): void
    {
        if (is_string($keys)) {
            $keys = explode(',', $keys);
        }

        if (false === is_array($keys)) {
            return;
        }

        foreach (array_filter($keys) as $key) {
            $eventKey = $this->getEventKey($key);
            if (false === $this->hasEventsKeys($eventKey)) {
                self::$events[$eventKey] = [];
            }
            self::$events[$eventKey][] = $handler;
        }
    }

    /**
     * Register a one-time event handler for a given event.
     *
     * @param string|array $keys    Type of event to listen for, or '*' for all events
     * @param callable     $handler Function to call in response to given event
     *
     * @return void
     */
    public function once(string|array $keys, callable $handler): void
    {
        if (is_string($keys)) {
            $keys = explode(',', $keys);
        }

        if (false === is_array($keys)) {
            return;
        }

        foreach (array_filter($keys) as $key) {
            $this->on($key, $wrapper = function () use ($key, $handler, &$wrapper) {
                $this->off($key, $wrapper);
                return call_user_func_array($handler, func_get_args());
            });
        }
    }

    /**
     * Remove an event handler for the given event. If handler is omitted, all handlers of the given event are removed.
     *
     * @param string|array  $keys    Type of event to unregister handler from, or '*'
     * @param callable|null $handler Handler function to remove
     *
     * @return void
     */
    public function off(string|array $keys, ?callable $handler = null): void
    {
        if (is_string($keys)) {
            $keys = explode(',', $keys);
        }

        if (false === is_array($keys)) {
            return;
        }

        foreach (array_filter($keys) as $key) {
            $eventKey = $this->getEventKey($key);
            foreach ($this->getEvents($eventKey, true) as $eventName => $eventHandlers) {
                foreach ($eventHandlers as $index => $eventHandler) {
                    if (is_null($handler) || ($eventHandler == $handler)) {
                        unset(self::$events[$eventName][$index]);
                    }
                }
                if ($this->hasEventsKeys($eventName)) {
                    unset(self::$events[$eventName]);
                }
            }
        }
    }

    /**
     * Invoke all handlers for the given event. If present, '*' handlers are invoked after event-matched handlers.
     *
     * @param string|array $keys    The event type to invoke
     * @param mixed        ...$args Any value, passed to each handler
     *
     * @return array
     */
    public function emit(string|array $keys, mixed ...$args): array
    {
        if (is_string($keys)) {
            $keys = explode(',', $keys);
        }

        if (false === is_array($keys)) {
            return [];
        }

        $events = [];

        foreach (array_filter($keys) as $key) {
            $eventKey = $this->getEventKey($key);
            foreach ($this->getEvents($eventKey) as $eventHandlers) {
                foreach ($eventHandlers as $eventHandler) {
                    $events[] = call_user_func_array($eventHandler, $args);
                }
            }
            // If present, '*' handlers are invoked after event-matched handlers.
            foreach ($this->getEvents($eventKey, true) as $eventName => $eventHandlers) {
                if ($eventKey == $eventName) {
                    continue;
                }
                foreach ($eventHandlers as $eventHandler) {
                    $events[] = call_user_func_array($eventHandler, $args);
                }
            }
        }

        return $events;
    }

    /**
     * 模式匹配
     *
     * @param string $pattern
     * @param string $subject
     *
     * @return bool
     */
    protected function matches(string $pattern, string $subject): bool
    {
        $pattern = str_replace('\*', '.*', preg_quote($pattern, '/'));

        return preg_match("/^{$pattern}$/", $subject) === 1;
    }

}
