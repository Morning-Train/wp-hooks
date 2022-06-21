<?php

namespace Morningtrain\WP\Hooks\Classes;

class ViewRenderer
{
    protected static array $actions = [];

    public static function __callStatic(string $name, array $arguments)
    {
        if (key_exists($name, static::$actions)) {
            echo \Morningtrain\WP\View\View::render(static::$actions[$name], $arguments);
        }
    }

    public static function addAction(string $token, string $view)
    {
        static::$actions[$token] = $view;
    }

    public static function getToken(): string
    {
        $token = static::generateToken();
        while (key_exists($token, static::$actions)) {
            $token = static::generateToken();
        }

        return $token;
    }

    protected static function generateToken(): string
    {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyz';
        $token = '';

        for ($i = 0; $i < 12; $i++) {
            $index = rand(0, strlen($characters) - 1);
            $token .= $characters[$index];
        }

        return $token;
    }
}
