<?php

namespace Nacosvel\Nacos\Concerns;

use GuzzleHttp\Psr7\Uri;
use Psr\Http\Message\UriInterface;

trait NacosConfigTrait
{
    public function getUri(bool $withUser = true): string
    {
        $uri = $this->current();
        if ($withUser === false) {
            $uri = $uri->withUserInfo('');
        }
        return (string)$uri->withFragment('');
    }

    public function getScheme(): string
    {
        return $this->current()->getScheme();
    }

    public function getAuthority(): string
    {
        return $this->current()->getAuthority();
    }

    public function getUserInfo(): string
    {
        return $this->current()->getUserInfo();
    }

    public function getHost(): string
    {
        return $this->current()->getHost();
    }

    public function getPort(): string
    {
        return $this->current()->getPort();
    }

    public function getPath(): string
    {
        return $this->current()->getPath();
    }

    public function getQuery(): string
    {
        return $this->current()->getQuery();
    }

    public function getFragment(): string
    {
        return $this->current()->getFragment();
    }

    public function withScheme(string $scheme): UriInterface
    {
        return $this->current()->withScheme($scheme);
    }

    public function withUserInfo(string $user, string $password = null): UriInterface
    {
        return $this->current()->withUserInfo($user, $password);
    }

    public function withHost(string $host): UriInterface
    {
        return $this->current()->withScheme($host);
    }

    public function withPort(string $port): UriInterface
    {
        return $this->current()->withPort($port);
    }

    public function withPath(string $path): UriInterface
    {
        return $this->current()->withPath($path);
    }

    public function withQuery(string $query): UriInterface
    {
        return $this->current()->withQuery($query);
    }

    public function withFragment(string $fragment): UriInterface
    {
        return $this->current()->withFragment($fragment);
    }

    public function composeComponents(?string $scheme, ?string $authority, string $path, ?string $query, ?string $fragment): string
    {
        return Uri::composeComponents($scheme, $authority, $path, $query, $fragment);
    }

    public function isDefaultPort(): bool
    {
        return Uri::isDefaultPort($this->current());
    }

    public function isAbsolute(): bool
    {
        return Uri::isAbsolute($this->current());
    }

    public function isNetworkPathReference(): bool
    {
        return Uri::isNetworkPathReference($this->current());
    }

    public function isAbsolutePathReference(): bool
    {
        return Uri::isAbsolutePathReference($this->current());
    }

    public function isRelativePathReference(): bool
    {
        return Uri::isRelativePathReference($this->current());
    }

    public function isSameDocumentReference(?UriInterface $base = null): bool
    {
        return Uri::isSameDocumentReference($this->current(), $base);
    }

    public function withoutQueryValue(string $key): UriInterface
    {
        return Uri::withoutQueryValue($this->current(), $key);
    }

    public function withQueryValue(string $key, ?string $value): UriInterface
    {
        return Uri::withQueryValue($this->current(), $key, $value);
    }

    public function withQueryValues(array $keyValueArray): UriInterface
    {
        return Uri::withQueryValues($this->current(), $keyValueArray);
    }

    public function fromParts(array $parts): UriInterface
    {
        return Uri::fromParts($parts);
    }

}
