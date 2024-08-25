<?php

namespace Nacosvel\Nacos;

use ArrayIterator;
use GuzzleHttp\Psr7\Uri;
use Nacosvel\Nacos\Concerns\NacosConfigTrait;
use Nacosvel\Nacos\Contracts\NacosConfigInterface;
use Psr\Http\Message\UriInterface;
use Stringable;

class NacosConfig extends ArrayIterator implements NacosConfigInterface, Stringable
{
    use NacosConfigTrait;

    public function __construct(array|string $uri = [])
    {
        if (is_string($uri)) {
            $uri = explode(',', $uri);
        }
        $isListArray = $uri == array_values($uri);
        parent::__construct(array_reduce(array_keys($uri), function ($initial, $key) use ($uri, $isListArray) {
            $url       = new Uri($isListArray ? $uri[$key] : $key);
            $url       = $url->withFragment($isListArray ? '1' : strval($uri[$key]));
            $url       = $url->getPath() == '' ? $url->withPath('/') : $url;
            $initial[] = $url;
            return $initial;
        }, []));
    }

    /**
     * Get array copy
     */
    #[\Override]
    public function offsetGet(mixed $key): UriInterface
    {
        return parent::offsetGet($key);
    }

    /**
     * Get array copy
     */
    #[\Override]
    public function offsetSet(mixed $key, mixed $value): void
    {
        assert($value instanceof UriInterface);
        parent::offsetSet($key, $value);
    }

    /**
     * Get array copy
     */
    #[\Override]
    public function append(mixed $value): void
    {
        assert($value instanceof UriInterface);
        parent::append($value);
    }

    /**
     * @inheritDoc
     *
     * @return string[]
     */
    #[\Override]
    public function getArrayCopy(): array
    {
        return array_reduce(parent::getArrayCopy(), function ($uri, UriInterface $item) {
            $uri[(string)$item] = $item->getFragment();
            return $uri;
        }, []);
    }

    /**
     * @inheritDoc
     */
    public function toArray(): array
    {
        return $this->getArrayCopy();
    }

    /**
     * @inheritDoc
     */
    public function count(): int
    {
        return parent::count();
    }

    /**
     * @inheritDoc
     */
    #[\Override]
    public function current(): UriInterface
    {
        return parent::current();
    }

    /**
     * @inheritDoc
     */
    public function __toString(): string
    {
        return (string)$this->current();
    }
}
