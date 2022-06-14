<?php

namespace Morningtrain\WP\Hooks\Abstracts;

abstract class AbstractActionHook extends AbstractHook
{
    protected string $hookFunction = 'add_action';
}

