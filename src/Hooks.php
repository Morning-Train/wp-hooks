<?php

namespace Morningtrain\WP\Hooks;

use Morningtrain\PHPLoader\Loader;
use Morningtrain\WP\Hooks\Abstracts\AbstractHook;

class Hooks
{
    /**
     * Load all .php files in directory / directories
     * Invoke all found Hook classes
     * @param  string|array  $path
     */
    public static function loadDir(string|array $path)
    {
        Loader::create($path)
            ->isA(AbstractHook::class)
            ->invoke();
    }
}
