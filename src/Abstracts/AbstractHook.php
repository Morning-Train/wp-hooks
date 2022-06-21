<?php

namespace Morningtrain\WP\Hooks\Abstracts;

/**
 * @method handle
 */
abstract class AbstractHook
{

    protected int $priority = 10;
    protected int $numArgs = 1;
    protected $callback;

    public function __construct(protected string|array $hook, $callback)
    {
        $this->callback = $callback;
    }

    public function __destruct()
    {
        $this->add();
    }

    public function priority(int $priority): static
    {
        $this->priority = $priority;

        return $this;
    }

    /**
     * @throws \ReflectionException
     */
    protected function findNumArgs(callable $callable): int
    {
        $CReflection = is_array($callable) ?
            new \ReflectionMethod($callable[0], $callable[1]) :
            new \ReflectionFunction($callable);

        return $CReflection->getNumberOfParameters();
    }

    abstract protected function add();

}
