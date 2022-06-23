<?php

namespace Morningtrain\WP\Hooks\Classes;

/**
 * A WordPress action
 *
 * @see https://developer.wordpress.org/reference/functions/add_action/
 */
class Action extends \Morningtrain\WP\Hooks\Abstracts\AbstractHook
{

    public function handle(callable $callback): static
    {
        $this->callback = $callback;

        return $this;
    }

    public function view(string $view): static
    {
        $this->useCallbackManager('view', $view);
        $this->numArgs = 1;

        return $this;
    }

    /**
     * Add the action for each hook
     * This is done on __destruct automatically
     *
     * @return mixed|void
     *
     * @throws \ReflectionException
     */
    protected function add()
    {
        if ($this->numArgs === null) {
            $this->numArgs = $this->findNumArgs($this->callback);
        }
        foreach ((array) $this->hook as $hook) {
            \add_action($hook, $this->callback, $this->priority, $this->numArgs);
        }
    }
}
