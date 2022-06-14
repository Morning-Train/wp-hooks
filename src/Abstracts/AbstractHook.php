<?php

namespace Morningtrain\WP\Hooks\Abstracts;

/**
 * @method handle
 */
abstract class AbstractHook
{
    protected string|array $hook;
    protected int $priority = 10;
    protected int $numArgs = 1;

    protected string $hookFunction;

    public function __invoke()
    {
        if ($numArgs = $this->getHandleParametersCount()) {
            $this->numArgs = $numArgs;
        }

        $this->add();
    }

    protected function getReflectionClass()
    {
        return new \ReflectionClass(get_called_class());
    }

    protected function getReflectionHandleMethod()
    {
        $rc = $this->getReflectionClass();
        if (empty($rc)) {
            return false;
        }

        return $rc->getMethod('handle');
    }

    protected function getHandleParametersCount()
    {
        $rm = $this->getReflectionHandleMethod();
        if (! $rm) {
            return 1;
        }

        return $rm->getNumberOfParameters();
    }

    protected function add()
    {
        $function = $this->hookFunction;

        if (! function_exists($function)) {
            return;
        }

        foreach ((array) $this->hook as $hook) {
            $function($hook, [$this, 'handle'], $this->priority, $this->numArgs);
        }
    }

    // Extended class must implement handle()
}
