<?php

namespace Nacosvel\Helper;

if (!function_exists('Nacosvel\Helper\build_url')) {
    /**
     * Build a URL from its parsed components, with optional filters to remove certain parts.
     *
     * This function takes a parsed URL as an associative array (with keys like 'scheme', 'host', 'path', etc.),
     * and builds a complete URL string based on these components. Optionally, you can pass filters (as integers)
     * to remove specific parts of the URL, where each filter corresponds to a URL component (scheme, host, etc.).
     *
     * @meta the `parsed_url()` reverse conversion function
     *
     * @param array $parsed_url An associative array representing the parsed URL components:
     *                          <ul>
     *                          <li>'scheme' (string)  : The protocol to use (e.g., "http", "https").</li>
     *                          <li>'host'   (string)  : The domain or host (e.g., "example.com").</li>
     *                          <li>'port'   (string)  : The port number (optional).</li>
     *                          <li>'user'   (string)  : The username for authentication (optional).</li>
     *                          <li>'pass'   (string)  : The password for authentication (optional).</li>
     *                          <li>'path'   (string)  : The path on the server (e.g., "/some/path").</li>
     *                          <li>'query'  (string)  : The query string (e.g., "param=value").</li>
     *                          <li>'fragment' (string): The fragment identifier (e.g., "section1").</li>
     *                          </ul>
     *                          The array can be partial, and defaults will be used for missing components.
     *
     * @param int   ...$filters Optional list of integers representing components to filter out. Each filter corresponds to:
     *                          <ul>
     *                          <li>PHP_URL_SCHEME</li>
     *                          <li>PHP_URL_HOST</li>
     *                          <li>PHP_URL_PORT</li>
     *                          <li>PHP_URL_USER</li>
     *                          <li>PHP_URL_PASS</li>
     *                          <li>PHP_URL_PATH</li>
     *                          <li>PHP_URL_QUERY</li>
     *                          <li>PHP_URL_FRAGMENT</li>
     *                          </ul>
     *
     * @return string A complete URL string, constructed from the given parsed components, with the optional filters applied.
     *
     * @example
     * ```
     * $url = build_url(['host' => 'example.com', 'path' => '/some/path', 'fragment' => 'section1'], PHP_URL_PATH, PHP_URL_QUERY, PHP_URL_FRAGMENT);
     * // This will build a URL without the path, query and fragment, resulting in "http://example.com"
     * ```
     */
    function build_url(array $parsed_url, int ...$filters): string
    {
        extract(array_merge([
            'scheme' => 'http', 'host' => '', 'port' => '',
            'user'   => '', 'pass' => '', 'path' => '/',
            'query'  => '', 'fragment' => '',
        ], $parsed_url));
        $scheme     = strtolower($scheme);
        $user       = ($user = urlencode($user)) ? "{$user}:" : '';
        $pass       = ($pass = urlencode($pass)) ? "{$pass}@" : '';
        $host       = strtolower($host);
        $port       = ($port && !(($scheme == "http" && $port == 80) || ($scheme == "https" && $port == 443))) ? ":{$port}" : '';
        $path       = trim($path, '/') ? "/{$path}" : '/';
        $query      = $query ? "?{$query}" : $query;
        $fragment   = $fragment ? "#{$fragment}" : $fragment;
        $scheme     = "{$scheme}://";
        $components = 0;
        foreach ($filters as $filter) {
            $components |= (2 ** $filter);
        }
        foreach (['scheme', 'host', 'port', 'user', 'pass', 'path', 'query', 'fragment'] as $key => $part) {
            if (($components & (2 ** $key)) == (2 ** $key)) {
                $$part = '';
            }
        }
        return implode('', compact(
            'scheme', 'user', 'pass',
            'host', 'port', 'path',
            'query', 'fragment'
        ));
    }
}

if (!function_exists('Nacosvel\Helper\camelToKebab')) {
    /**
     * 将 小驼峰命名法（camelCase）或大驼峰命名（PascalCase）的字符串转换为 kebab-case。
     * (?<!^): 这个负向前瞻断言确保匹配的字母不是字符串的第一个字符。
     * [A-Z](?=[a-z]): 这是一个断言，它只会匹配后面跟随小写字母的大写字母，防止处理像 HTTPResponse 这样连续大写字母的情况。
     * (?<=[a-z])[A-Z]: 断言前面是小写字母的大写字母，适用于处理正常的 camelCase。
     *
     * @param string        $input
     * @param callable|null $callback
     *
     * @return string
     */
    function camelToKebab(string $input = '', callable $callback = null): string
    {
        if (empty($input)) {
            return $input;
        }

        if (is_callable($callback)) {
            $input = call_user_func($callback, $input);
        }

        // Convert camelCase or PascalCase to kebab-case, handling consecutive uppercase letters
        $output = preg_replace('/(?<!^)([A-Z](?=[a-z])|(?<=[a-z])[A-Z])/', '-$1', $input);

        // Convert to lowercase and return
        return strtolower($output);
    }
}

if (!function_exists('Nacosvel\Helper\kebabToCamel')) {
    /**
     * 将 kebab-case 的字符串转换为小驼峰命名法（camelCase）。
     * 该函数需要识别连字符 - 并将它后面的字母转换为大写。
     *
     * @param string        $input
     * @param callable|null $callback
     *
     * @return string
     */
    function kebabToCamel(string $input = '', callable $callback = null): string
    {
        if (empty($input)) {
            return $input;
        }

        // Use preg_replace_callback to find '-' followed by a lowercase letter
        $output = preg_replace_callback('/-(\w)/', function ($matches) {
            return strtoupper($matches[1]); // Convert the letter after '-' to uppercase
        }, strtolower($input));

        // Return the camelCase version
        return is_callable($callback) ? call_user_func($callback, lcfirst($output)) : lcfirst($output); // Ensure the first character is lowercase
    }
}

if (!function_exists('Nacosvel\Helper\kebabToPascal')) {
    /**
     * 将 kebab-case 的字符串转换为大驼峰命名法（PascalCase）。
     *
     * @param string        $input
     * @param callable|null $callback
     *
     * @return string
     */
    function kebabToPascal(string $input = '', callable $callback = null): string
    {
        if (empty($input)) {
            return $input;
        }

        // Use preg_replace_callback to find '-' followed by a lowercase letter
        $output = preg_replace_callback('/-(\w)/', function ($matches) {
            return strtoupper($matches[1]); // Convert the letter after '-' to uppercase
        }, strtolower($input));

        // Capitalize the first character to match PascalCase
        return is_callable($callback) ? call_user_func($callback, ucfirst($output)) : ucfirst($output); // Ensure the first character is uppercase
    }
}
