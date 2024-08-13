<?php

namespace Nacosvel\Utils;

final class Utils
{
    /**
     * Get hashCode for string $data
     *
     * @param string $data
     *
     * @return int
     */
    public static function hashCode(string $data): int
    {
        return hexdec(hash('crc32', $data));
    }

    /**
     * Build components based on parsed URLs
     *
     * @param array     $components    ["scheme" => "string", "host" => "string", "port" => "int", "user" => "string", "pass" => "string", "query" => "string", "path" => "string", "fragment" => "string"]
     * @param string    $defaultScheme http
     * @param false|int $defaultPort   false
     *
     * @return string The URL by combining the components.
     */
    public static function build_url(array $components = [], string $defaultScheme = 'http', false|int $defaultPort = false): string
    {
        $scheme   = array_key_exists('scheme', $components) ? $components['scheme'] : $defaultScheme;
        $user     = array_key_exists('user', $components) ? $components['user'] : '';
        $pass     = array_key_exists('pass', $components) ? $components['pass'] : '';
        $host     = array_key_exists('host', $components) ? $components['host'] : '';
        $port     = array_key_exists('port', $components) ? $components['port'] : $defaultPort;
        $path     = array_key_exists('path', $components) ? $components['path'] : '/';
        $query    = array_key_exists('query', $components) ? $components['query'] : '';
        $fragment = array_key_exists('fragment', $components) ? $components['fragment'] : '';

        $protocol = '://';

        if ($user || $pass) {
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

}
