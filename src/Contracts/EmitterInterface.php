<?php

namespace Nacosvel\Utils\Contracts;

interface EmitterInterface
{
    /**
     * 根据指定模式获取指定事件键名集合
     *
     * @param string|null $eventKey 指定键名
     * @param bool        $wildcard 模式匹配
     *
     * @return array
     */
    public function getEventsKeys(string $eventKey = null, bool $wildcard = false): array;

    /**
     * 根据指定模式判断是否存在指定键名
     *
     * @param string|null $eventKey 指定键名
     * @param bool        $wildcard 模式匹配
     *
     * @return bool
     */
    public function hasEventsKeys(string $eventKey = null, bool $wildcard = false): bool;

    /**
     * 根据指定模式获取指定事件集合
     *
     * @param string|null $eventKey 指定键名
     * @param bool        $wildcard 模式匹配
     *
     * @return array
     */
    public function getEvents(string $eventKey = null, bool $wildcard = false): array;

    /**
     * 清空所有实例事件集合
     *
     * @return static
     */
    public function clear(): static;

    /**
     * 重置当前实例事件集合
     *
     * @return static
     */
    public function reset(): static;

    public function getHash(): string;

    public function setHash(string $hash): static;

    /**
     * 获取事件键名
     *
     * @param string $key
     *
     * @return string
     */
    public function getEventKey(string $key): string;

    /**
     * Register an event handler for the given event.
     *
     * @param string|array $keys    Type of event to listen for, or '*' for all events
     * @param callable     $handler Function to call in response to given event
     *
     * @return void
     */
    public function on(string|array $keys, callable $handler): void;

    /**
     * Register a one-time event handler for a given event.
     *
     * @param string|array $keys    Type of event to listen for, or '*' for all events
     * @param callable     $handler Function to call in response to given event
     *
     * @return void
     */
    public function once(string|array $keys, callable $handler): void;

    /**
     * Remove an event handler for the given event. If handler is omitted, all handlers of the given event are removed.
     *
     * @param string|array  $keys    Type of event to unregister handler from, or '*'
     * @param callable|null $handler Handler function to remove
     *
     * @return void
     */
    public function off(string|array $keys, ?callable $handler = null): void;

    /**
     * Invoke all handlers for the given event. If present, '*' handlers are invoked after event-matched handlers.
     *
     * @param string|array $keys    The event type to invoke
     * @param mixed        ...$args Any value, passed to each handler
     *
     * @return array
     */
    public function emit(string|array $keys, mixed ...$args): array;
}
