<?php

namespace Morningtrain\WP\Hooks\Abstracts;

abstract class AbstractFilterHook extends AbstractHook
{
    protected string $hookFunction = 'add_filter';
}

