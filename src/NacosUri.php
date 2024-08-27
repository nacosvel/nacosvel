<?php

namespace Nacosvel\Nacos;

use ArrayIterator;
use GuzzleHttp\Psr7\Uri;
use Nacosvel\Nacos\Concerns\NacosUriTrait;
use Nacosvel\Nacos\Contracts\Arrayable;
use Nacosvel\Nacos\Contracts\NacosUriInterface;
use Psr\Http\Message\UriInterface;
use Stringable;

class NacosUri extends ArrayIterator implements NacosUriInterface, Arrayable, Stringable
{
    use NacosUriTrait;

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
     * @inheritDoc
     *
     * @return UriInterface
     */
    #[\Override]
    public function offsetGet(mixed $key): UriInterface
    {
        return parent::offsetGet($key);
    }

    /**
     * @inheritDoc
     *
     * @return void
     */
    #[\Override]
    public function offsetSet(mixed $key, mixed $value): void
    {
        assert($value instanceof UriInterface);
        parent::offsetSet($key, $value);
    }

    /**
     * @inheritDoc
     *
     * @return void
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
     * @return array
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
     *
     * @return UriInterface
     */
    #[\Override]
    public function current(): UriInterface
    {
        return parent::current();
    }

    public function getUri(bool $withUser = true): UriInterface
    {
        $uri = $this->current();

        if ($withUser === false) {
            $uri = $uri->withUserInfo('');
        }

        return $uri->withFragment('');
    }

    /**
     * @inheritDoc
     *
     * @return array
     */
    public function toArray(): array
    {
        return $this->getArrayCopy();
    }

    /**
     * @inheritDoc
     *
     * @return string
     */
    public function __toString(): string
    {
        return (string)$this->current();
    }
}
