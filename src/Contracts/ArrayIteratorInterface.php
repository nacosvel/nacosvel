<?php

namespace Nacosvel\LoadBalancer\Contracts;

use SeekableIterator;

/**
 * @deprecated Iterator
 */
interface ArrayIteratorInterface extends SeekableIterator
{
    public function offsetExists(mixed $key): bool;

    public function offsetGet(mixed $key): ServerInstanceInterface;

    public function offsetSet(int $key, mixed $value): void;

    // public function offsetUnset(mixed $offset): void;

    public function append(string $value): void;

    // public function getArrayCopy(): array;

    // public function count(): int;

    // public function unserialize(string $data): void;

    // public function serialize(): string;

    public function current(): ServerInstanceInterface;

}
