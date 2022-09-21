<?php

namespace Morningtrain\WP\Hooks\Classes;

/**
 * Class for rendering views on actions
 */
class CallbackManager
{
    // The actions known. As token => [method,args]
    protected static array $actions = [];

    /**
     * Called as an action callback
     *
     * @param  string  $name  The action token
     * @param  array  $arguments  The action arguments
     *
     */
    public static function __callStatic(string $name, array $arguments)
    {
        if (key_exists($name, static::$actions)) {
            $action = static::$actions[$name];

            return static::{$action['method']}($action['args'], $arguments);
        }
    }

    /**
     * Add an action to the renderer
     *
     * @param  string  $token  The token identifier
     * @param  string  $method  Method on CallbackManager to call
     * @param  mixed  $args  Args for method
     */
    public static function addAction(string $token, string $method, $args = null)
    {
        static::$actions[$token] = [
            'method' => $method,
            'args' => $args,
        ];
    }

    public static function returnTrue(): bool
    {
        return true;
    }

    public static function returnFalse(): bool
    {
        return false;
    }

    public static function view($view, $arguments)
    {
        echo \Morningtrain\WP\View\View::render($view, $arguments);
    }

    public static function invoke($class, $arguments)
    {
        return (new $class)(...$arguments);
    }

    /**
     * Get a new unique token
     *
     * @return string
     */
    public static function getToken(): string
    {
        $token = static::generateToken();
        while (key_exists($token, static::$actions)) {
            $token = static::generateToken();
        }

        return $token;
    }

    /**
     * Generate some token
     * Note that no uppercase characters are used since casing in method names are ignored.
     *
     * @return string
     */
    protected static function generateToken(): string
    {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyz';
        $token = 'V_'; // methods can't start with numbers

        for ($i = 0; $i < 12; $i++) {
            $index = rand(0, strlen($characters) - 1);
            $token .= $characters[$index];
        }

        return $token;
    }
}
