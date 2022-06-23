<?php

namespace Morningtrain\WP\Hooks\Classes;

/**
 * Add the view for each action
 * This is done on __destruct automatically
 *
 * @return mixed|void
 *
 * @throws \ReflectionException
 */
class View extends \Morningtrain\WP\Hooks\Abstracts\AbstractHook
{
    protected string $view;
    protected int $numArgs = 1;

    /**
     * Register an action that renders a view
     *
     * @param  array|string  $hook
     * @param  string  $view  Name of the view to render
     */
    public function __construct(array|string $hook, $view)
    {
        $this->hook = $hook;
        $this->view = $view;
    }

    /**
     * Set the number of args for the view as supplied by the action
     * Since view has no idea of what callback will be used there is no way for us to know the number of arguments needed.
     * So if it is more than one, set it with this method
     *
     * @param  int  $numArgs
     *
     * @return $this
     */
    public function numArgs(int $numArgs): static
    {
        $this->numArgs = $numArgs;

        return $this;
    }

    /**
     * Add the view to action(s)
     *
     * @return mixed|void
     */
    protected function add()
    {
        foreach ((array) $this->hook as $hook) {
            $token = CallbackManager::getToken(); // Get a token as ID from the ViewRenderer helper class
            $this->callback = [
                CallbackManager::class,
                $token,
            ]; // Set the ViewRenderer as callback manager with the token as method for identification
            CallbackManager::addAction($token,
                $this->view); // Add this action as token and view to the ViewRenderer so that it can recognize this action later
            \add_action($hook, $this->callback, $this->priority, $this->numArgs);
        }
    }
}
