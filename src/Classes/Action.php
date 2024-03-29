<?php

namespace Morningtrain\WP\Hooks\Classes;

/**
 * A WordPress action
 *
 * @see https://developer.wordpress.org/reference/functions/add_action/
 */
class Action extends \Morningtrain\WP\Hooks\Abstracts\AbstractHook
{

    protected bool $proactive = false;

    /**
     * Set the method for handling the action call
     *
     * This is the same as the callback that you may supply as a second param in the constructor
     *
     * @param  string|callable  $callback
     * @return $this
     */
    public function handle(string|callable $callback): static
    {
        $this->callback = $callback;

        return $this;
    }

    /**
     * Render a view as the action callback
     *
     * @param  string  $view
     * @return $this
     */
    public function view(string $view): static
    {
        $this->useCallbackManager('view', $view);
        $this->numArgs = 1;

        return $this;
    }

    /**
     * Makes the action proactive
     *
     * This calls the callback immediately if the action has already been called.
     *
     * NOTE: Since the callback will be called directly, no args will be supplied.
     * This method is mainly useful for initializing parts of the codebase after a given action has been triggered.
     *
     * @return $this
     */
    public function proactive(): static
    {
        $this->proactive = true;

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
        if(is_string($this->callback) && class_exists($this->callback)){
            $this->useCallbackManager('invoke', $this->callback);
        }
        foreach ((array) $this->hook as $hook) {
            if ($this->proactive && \did_action($hook)) {
                ($this->callback)();
                continue;
            }
            \add_action($hook, $this->callback, $this->priority, $this->numArgs);
        }
    }
}
