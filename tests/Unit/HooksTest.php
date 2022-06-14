<?php

it('has Hook main class', function () {
    expect(\Morningtrain\WP\Hooks\Hooks::class)->toBeString();
});

it('has AbstractHook main class', function () {
    expect(\Morningtrain\WP\Hooks\Abstracts\AbstractHook::class)->toBeString();
});

it('has Abstract Action main class', function () {
    expect(\Morningtrain\WP\Hooks\Abstracts\AbstractActionHook::class)->toBeString();
});

it('has Abstract Filter main class', function () {
    expect(\Morningtrain\WP\Hooks\Abstracts\AbstractFilterHook::class)->toBeString();
});


