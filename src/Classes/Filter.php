<?php

namespace Morningtrain\WP\Hooks\Classes;

/**
 * Register the filter(s)
 *
 * @see https://developer.wordpress.org/reference/functions/add_filter/
 */
class Filter extends \Morningtrain\WP\Hooks\Abstracts\AbstractHook
{

    public function return(string|callable $callback): static
    {
        $this->callback = $callback;

        return $this;
    }

    public function returnTrue(): static
    {
        $this->callback = [CallbackManager::class, __FUNCTION__];

        return $this;
    }

    public function returnFalse(): static
    {
        $this->callback = [CallbackManager::class, __FUNCTION__];

        return $this;
    }

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
        if (is_string($this->callback) && class_exists($this->callback)) {
            $this->useCallbackManager('invoke', $this->callback);
        }
        foreach ((array) $this->hook as $hook) {
            \add_filter($hook, $this->callback, $this->priority, $this->numArgs);
        }
    }
}
