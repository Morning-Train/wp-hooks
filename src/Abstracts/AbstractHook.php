<?php

namespace Morningtrain\WP\Hooks\Abstracts;

use Morningtrain\WP\Hooks\Classes\CallbackManager;
use PHPUnit\TextUI\ReflectionException;

/**
 *
 */
abstract class AbstractHook
{

    protected int $priority = 10;
    protected ?int $numArgs = null;
    protected $callback = null;
    const DEFAULT_NUM_ARGS = 1;

    /**
     * @param  string|array  $hook  or hooks to apply to
     *
     * @param $callback
     */
    public function __construct(protected string|array $hook)
    {
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
    protected function findNumArgs(string|callable $callable): int
    {
        // For figuring [SomeClass::class,'someMethod] type callbacks
        if (is_array($callable)) {
            try {
                return (new \ReflectionMethod($callable[0], $callable[1]))->getNumberOfParameters();
            } catch (\ReflectionException $e) {
                return static::DEFAULT_NUM_ARGS;
            }
        }
        // If the value is a string and a class matching this string exists then attempt to invoke this class
        if (is_string($callable) && class_exists($callable)) {
            $reflectionClass = new \ReflectionClass($callable);
            if ($reflectionClass->hasMethod('__invoke')) {
                return $reflectionClass->getMethod('__invoke')->getNumberOfParameters();
            }

            return static::DEFAULT_NUM_ARGS;
        }
        // If the callback is a string and a function matches then call it
        if (is_string($callable) && function_exists($callable)) {
            return (new \ReflectionFunction($callable))->getNumberOfParameters();
        }
        // If the callback is still here then it must be a closure or something.. so call it!
        if (is_callable($callable)) {
            return (new \ReflectionFunction($callable))->getNumberOfParameters();
        }

        return static::DEFAULT_NUM_ARGS;
    }

    /**
     * Add/register the hook into WordPress
     *
     * @return mixed
     */
    abstract protected function add();

    /**
     * The callbackmanager is used with more complecated callbacks.
     *
     * If you have a callback that requires more information than the hook provides then you can use this.
     *
     * See View or Invoke for some references
     *
     * @param  string  $method
     * @param  null  $args
     */
    protected function useCallbackManager(string $method, $args = null)
    {
        // Get a token as ID from the CallbackManager
        $token = CallbackManager::getToken();
        // Set the ViewRenderer as callback manager with the token as method for identification
        $this->callback = [
            CallbackManager::class,
            $token,
        ];

        // Add this action as method with args to the CallbackManager so that it can recognize this action later
        CallbackManager::addAction($token, $method, $args);
    }
}
