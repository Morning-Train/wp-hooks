<?php

it('has Hook main class', function () {
    expect(\Morningtrain\WP\Hooks\Hooks::class)->toBeString();
});

it('can bar', function(){
    expect(\Morningtrain\WP\Hooks\Hooks::bar())->toBeString();
});

it('can foo', function(){
    expect(\Morningtrain\WP\Hooks\Hooks::$foo)->toBeFalse();
    \Morningtrain\WP\Hooks\Hooks::foo();
    expect(\Morningtrain\WP\Hooks\Hooks::$foo)->toBeTrue();
});
