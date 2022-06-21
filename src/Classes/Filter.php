<?php

namespace Morningtrain\WP\Hooks\Classes;

class Filter extends \Morningtrain\WP\Hooks\Abstracts\AbstractHook
{

    protected function add()
    {
        $this->numArgs = $this->findNumArgs($this->callback);
        foreach ((array) $this->hook as $hook) {
            \add_filter($hook, $this->callback, $this->priority, $this->numArgs);
        }
    }
}
