<?php

namespace TestApp\Managers;

class FooManager
{
    public static bool $foo = false;

    public static function handle()
    {
        static::$foo = true;
    }
}
