<?php
namespace Morningtrain\WP\Hooks\Classes;

class Action extends \Morningtrain\WP\Hooks\Abstracts\AbstractHook
{

    protected function add()
    {
        $this->numArgs = $this->findNumArgs($this->callback);
        foreach ((array) $this->hook as $hook) {
            \add_action($hook, $this->callback, $this->priority, $this->numArgs);
        }
    }
}
