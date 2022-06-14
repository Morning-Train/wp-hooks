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

    /**
     * Construct and add the hook
     */
    public function __invoke(): void
    {
        if ($numArgs = $this->getHandleParametersCount()) {
            $this->numArgs = $numArgs;
        }

        $this->add();
    }

    /**
     * Get the hook class' reflection class instance
     * @return \ReflectionClass
     * @throws \ReflectionException
     */
    protected function getReflectionClass(): \ReflectionClass
    {
        return new \ReflectionClass(get_called_class());
    }

    /**
     * Get the Reflections Handle method
     *
     * @return \ReflectionMethod|bool
     * @throws \ReflectionException
     */
    protected function getReflectionHandleMethod(): ?\ReflectionMethod
    {
        $rc = $this->getReflectionClass();
        if (empty($rc)) {
            return null;
        }

        return $rc->getMethod('handle');
    }

    /**
     * Get the Reflections Handle methods argument count
     *
     * @return int
     * @throws \ReflectionException
     */
    protected function getHandleParametersCount(): int
    {
        $rm = $this->getReflectionHandleMethod();
        if (! $rm) {
            return 1;
        }

        return $rm->getNumberOfParameters();
    }

    /**
     * Add the filter or action
     */
    protected function add(): void
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
