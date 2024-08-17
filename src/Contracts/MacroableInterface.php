<?php

namespace Nacosvel\Utils\Contracts;

interface MacroableInterface
{
    public static function macro(string $name, callable|object $macro): void;

    public static function mixin(object $mixin, bool $replace = true): void;

    public static function hasMacro(string $name): bool;

    public static function flushMacros(): void;

    public static function __callStatic(string $method, array $parameters);

    public function __call(string $method, array $parameters);

}
