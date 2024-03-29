<?php

namespace Morningtrain\WP\Hooks;

use Morningtrain\PHPLoader\Loader;
use Morningtrain\WP\Hooks\Abstracts\AbstractHook;
use Morningtrain\WP\Hooks\Classes\Action;
use Morningtrain\WP\Hooks\Classes\Filter;
use Morningtrain\WP\Hooks\Classes\View;

/**
 * For registering action and filters
 * ... and views!
 */
class Hook
{
    /**
     * Load all .php files in directory / directories
     * @param  string|array  $path
     */
    public static function loadDir(string|array $path)
    {
        Loader::create($path);
    }

    /**
     * Register an action with a callback!
     * You should refer to some other managing class in your callback
     *
     * @param  string|array  $hook
     * @param  ?callable  $callback
     *
     * @return Action
     * @see https://developer.wordpress.org/reference/functions/add_action/
     */
    public static function action(string|array $hook, callable|string|null $callback = null): Action
    {
        $action = new Action($hook);
        if ($callback !== null) {
            $action->handle($callback);
        }

        return $action;
    }

    /**
     * Register a filter with a callback!
     * You should refer to some other managing class in your callback
     *
     * Remember that filters must return a new or modified version of its first param
     *
     * @param  string|array  $hook
     * @param  ?callable  $callback
     *
     * @return Filter
     * @see https://developer.wordpress.org/reference/functions/add_filter/
     */
    public static function filter(string|array $hook, callable|string|null $callback = null): Filter
    {
        $filter = new Filter($hook);
        if ($callback !== null) {
            $filter->return($callback);
        }

        return $filter;
    }

    /**
     * Register a rendering of a view on an action
     *
     * @param  string|array  $hook
     * @param  string  $view
     *
     * @return View
     */
    public static function view(string|array $hook, string $view): View
    {
        return new View($hook, $view);
    }
}
