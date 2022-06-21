<?php

namespace Morningtrain\WP\Hooks\Classes;

class View extends \Morningtrain\WP\Hooks\Abstracts\AbstractHook
{
    protected string $view;
    protected int $numArgs = 1;

    public function __construct(array|string $hook, $view)
    {
        $this->hook = $hook;
        $this->view = $view;
    }

    public function numArgs(int $numArgs): static
    {
        $this->numArgs = $numArgs;

        return $this;
    }

    protected function add()
    {
        foreach ((array) $this->hook as $hook) {
            $token = ViewRenderer::getToken();
            $this->callback = [ViewRenderer::class, $token];
            ViewRenderer::addAction($token, $this->view);
            \add_action($hook, $this->callback, $this->priority, $this->numArgs);
        }
    }
}
