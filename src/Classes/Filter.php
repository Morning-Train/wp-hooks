<?php

namespace Morningtrain\WP\Hooks\Classes;

/**
 * Register the filter(s)
 *
 * @see https://developer.wordpress.org/reference/functions/add_filter/
 */
class Filter extends \Morningtrain\WP\Hooks\Abstracts\AbstractHook
{
    /**
     * Add the filter for each hook
     * This is done on __destruct automatically
     *
     * @return mixed|void
     *
     * @throws \ReflectionException
     */
    protected function add()
    {
        $this->numArgs = $this->findNumArgs($this->callback);
        foreach ((array) $this->hook as $hook) {
            \add_filter($hook, $this->callback, $this->priority, $this->numArgs);
        }
    }
}
