<?php

use Brain\Monkey;

beforeAll(function () {
    Monkey\setUp();
});

afterAll(function () {
    Monkey\tearDown();
});

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

it('registers custom actions', function () {
    expect(did_action('myAction'))->toEqual(0);
    do_action('myAction');
    expect(did_action('myAction'))->toEqual(1);
});

it('loads, adds actions', function () {
    \Morningtrain\WP\Hooks\Hooks::loadDir(dirname(__DIR__) . "/TestApp/Hooks");
    expect(has_action('foo', '\TestApp\Hooks\FooAction->handle()'))->toBeTrue();
});


