<?php

namespace Nacosvel\Utils;

final class Utils
{
    /**
     * Build components based on parsed URLs
     *
     * @param array       $components            ["scheme" => "string", "host" => "string", "port" => "int", "user" => "string", "pass" => "string", "query" => "string", "path" => "string", "fragment" => "string"]
     * @param true|string $defaultHttpScheme     default Http Scheme: true
     * @param bool        $isBasicAuthentication Basic Authentication: false
     * @param false|int   $defaultPort           default Port: false
     *
     * @return string The URL by combining the components.
     * @example
     * ```
     * // $components = parse_url('://example.com:80/path?query#fragment');
     * // $components = parse_url('http://user:pass@example.com:80/path?query#fragment');
     * $components = [
     *       "scheme"   => "",
     *       "host"     => "example",
     *       "port"     => "",
     *       "user"     => "user",
     *       "pass"     => "pass",
     *       "query"    => "query",
     *       "path"     => "path",
     *       "fragment" => "fragment",
     *  ];
     * build_url($components, true, false, false);
     * // 'http://example.com/path?query#fragment'
     * build_url($components, false, false, false);
     * // '://example.com/path?query#fragment'
     * build_url($components, true, false, false);
     * // 'http://example.com/path?query#fragment'
     * build_url($components, true, true, false);
     * // 'http://user:pass@example.com/path?query#fragment'
     * build_url($components, true, true, 80);
     * // 'http://user:pass@example.com:80/path?query#fragment'
     *```
     */
    public static function build_url(array $components = [], true|string $defaultHttpScheme = true, bool $isBasicAuthentication = false, false|int $defaultPort = false): string
    {
        $scheme   = array_key_exists('scheme', $components) ? $components['scheme'] : ($defaultHttpScheme === true ? 'http' : $defaultHttpScheme);
        $user     = array_key_exists('user', $components) ? $components['user'] : '';
        $pass     = array_key_exists('pass', $components) ? $components['pass'] : '';
        $host     = array_key_exists('host', $components) ? $components['host'] : '';
        $port     = array_key_exists('port', $components) ? $components['port'] : $defaultPort;
        $path     = array_key_exists('path', $components) ? $components['path'] : '/';
        $query    = array_key_exists('query', $components) ? $components['query'] : '';
        $fragment = array_key_exists('fragment', $components) ? $components['fragment'] : '';

        $protocol = '://';

        if (($user || $pass) && $isBasicAuthentication) {
            $protocol = "://{$user}:{$pass}@";
        }

        if ($port) {
            $port = ":{$port}";
        }

        if ($query) {
            $query = "?{$query}";
        }

        if ($fragment) {
            $fragment = "#{$fragment}";
        }

        return implode('', compact('scheme', 'protocol', 'host', 'port', 'path', 'query', 'fragment'));
    }

    /**
     * Get hashCode for give string
     *
     * @param string $data
     *
     * @return int
     */
    public static function hashCode(string $data): int
    {
        return hexdec(hash('crc32', $data));
    }

}
