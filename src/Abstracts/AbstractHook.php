<?php

namespace Morningtrain\WP\Hooks\Abstracts;

/**
 *
 */
abstract class AbstractHook
{

    protected int $priority = 10;
    protected int $numArgs = 1;
    protected $callback;

    /**
     * @param  string|array  $hook  or hooks to apply to
     *
     * @param $callback
     */
    public function __construct(protected string|array $hook, $callback)
    {
        $this->callback = $callback;
    }

    /**
     * Add the filter og action on destruct
     */
    public function __destruct()
    {
        $this->add();
    }

    /**
     * Set the hook priority
     * The higher the number the later the execution
     *
     * @param  int  $priority  Default is 10
     *
     * @return $this
     */
    public function priority(int $priority): static
    {
        $this->priority = $priority;

        return $this;
    }

    /**
     * The number of args supplied for the callback is determined by the callback itself.
     *
     * @throws \ReflectionException
     */
    protected function findNumArgs(callable $callable): int
    {
        $CReflection = is_array($callable) ?
            new \ReflectionMethod($callable[0], $callable[1]) :
            new \ReflectionFunction($callable);

        return $CReflection->getNumberOfParameters();
    }

    /**
     * Add/register the hook into WordPress
     *
     * @return mixed
     */
    abstract protected function add();

}
