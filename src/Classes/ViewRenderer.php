<?php

namespace Morningtrain\WP\Hooks\Classes;

/**
 * Class for rendering views on actions
 */
class ViewRenderer
{
    // The actions known. As token => view
    protected static array $actions = [];

    /**
     * Called as an action callback
     *
     * @param  string  $name  The action token
     * @param  array  $arguments  The action arguments
     *
     * @throws \Morningtrain\WP\View\Exceptions\MissingPackageException
     * @throws \ReflectionException
     */
    public static function __callStatic(string $name, array $arguments)
    {
        if (key_exists($name, static::$actions)) {
            // If this token is recognized then render its view
            echo \Morningtrain\WP\View\View::render(static::$actions[$name], $arguments);
        }
    }

    /**
     * Add an action to the renderer
     *
     * @param  string  $token  The token identifier
     * @param  string  $view  The view to render when called
     */
    public static function addAction(string $token, string $view)
    {
        static::$actions[$token] = $view;
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
