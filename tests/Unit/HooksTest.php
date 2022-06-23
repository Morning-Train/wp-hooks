<?php

use Brain\Monkey;

beforeAll(function () {
    Monkey\setUp();
});

afterAll(function () {
    Monkey\tearDown();
});

it('has Hook main class', function () {
    expect(\Morningtrain\WP\Hooks\Hook::class)->toBeString();
});

it('registers custom actions', function () {
    expect(did_action('myAction'))->toEqual(0);
    do_action('myAction');
    expect(did_action('myAction'))->toEqual(1);
});

it('loads, adds actions', function () {
    \Morningtrain\WP\Hooks\Hook::loadDir(dirname(__DIR__) . "/TestApp/hooks");
    expect(has_action('foo', '\TestApp\Managers\FooManager::handle()'))->toBeTrue();
});
