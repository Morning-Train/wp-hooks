<?php

namespace Morningtrain\WP\Hooks;

use Morningtrain\PHPLoader\Loader;
use Morningtrain\WP\Hooks\Abstracts\AbstractHook;
use Morningtrain\WP\Hooks\Classes\Action;
use Morningtrain\WP\Hooks\Classes\Filter;
use Morningtrain\WP\Hooks\Classes\View;

class Hooks
{
    /**
     * Load all .php files in directory / directories
     * Invoke all found Hook classes
     * @param  string|array  $path
     */
    public static function loadDir(string|array $path)
    {
        Loader::create($path);
    }

    public static function action(string|array $hook, callable $callback): Action
    {
        return new Action($hook, $callback);
    }

    public static function filter(string|array $hook, callable $callback): Filter
    {
        return new Filter($hook, $callback);
    }

    public static function view(string|array $hook, string $view): View
    {
        return new View($hook, $view);
    }
}
