<?php

namespace Nacosvel\Nacos;

use ArrayIterator;
use GuzzleHttp\Psr7\Uri;
use Nacosvel\Nacos\Concerns\NacosConfigTrait;
use Nacosvel\Nacos\Contracts\NacosConfigInterface;
use Psr\Http\Message\UriInterface;

class NacosConfig extends ArrayIterator implements NacosConfigInterface
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
            $initial[] = $url->withFragment($isListArray ? '1' : strval($uri[$key]));
            return $initial;
        }, []));
    }

    #[\Override]
    public function offsetGet(mixed $key): UriInterface
    {
        return parent::offsetGet($key);
    }

    #[\Override]
    public function offsetSet(mixed $key, mixed $value): void
    {
        assert($value instanceof UriInterface);
        parent::offsetSet($key, $value);
    }

    #[\Override]
    public function append(mixed $value): void
    {
        assert($value instanceof UriInterface);
        parent::append($value);
    }

    /**
     * Get array copy
     *
     * @return string[]
     */
    #[\Override]
    public function getArrayCopy(): array
    {
        return array_reduce(parent::getArrayCopy(), function ($uri, UriInterface $item) {
            $uri[$item->withFragment('')->__toString()] = $item->getFragment();
            return $uri;
        }, []);
    }

    public function toArray(): array
    {
        return $this->getArrayCopy();
    }

    public function count(): int
    {
        return parent::count();
    }

    #[\Override]
    public function current(): UriInterface
    {
        return parent::current();
    }

}
