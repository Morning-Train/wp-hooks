<?php

namespace Morningtrain\WP\Hooks;

class Hooks
{
    public static bool $foo = false;

    public static function foo()
    {
        static::$foo = true;
    }

    public static function bar() : string
    {
        return "bar";
    }
}
