# WP Hooks

[![Latest Release](https://backuptrain.dk/internal-projects/wp/wp-hooks/-/badges/release.svg)](https://backuptrain.dk/internal-projects/wp/wp-hooks/-/releases)
[![pipeline status](https://backuptrain.dk/internal-projects/wp/wp-hooks/badges/master/pipeline.svg)](https://backuptrain.dk/internal-projects/wp/wp-hooks/-/pipelines)
[![coverage status](https://backuptrain.dk/internal-projects/wp/wp-hooks/badges/master/coverage.svg)](https://backuptrain.dk/internal-projects/wp/wp-hooks/-/graphs/master/charts)

To let you organize all your WordPress actions and filters.

## Table of Contents

- [Introduction](#introduction)
- [Getting Started](#getting-started)
    - [Installation](#installation)
- [Dependencies](#dependencies)
    - [morningtrain/php-loader](#morningtrainphp-loader)
- [Usage](#usage)

## Introduction

This tool is made for organizing WordPress hooks.

Instead of calling `add_action` and `add_filter` everywhere in your codebase you can create a directory for ALL your
project hooks!

In here you create a class for every hook you wish to add. Either action or filter.

A Hook is composed of a hook, such as `init`, a priority and a callback named `handle()`

## Getting Started

To get started install the package as described below in [Installation](#installation).

To use the tool have a look at [Usage](#usage)

### Installation

## Dependencies

### morningtrain/php-loader

[PHP Loader](https://grandcentral.backuptrain.dk/internal-projects/php-loader) is used to load and initialize all Hooks

## Usage

To load all Hooks of a given directory

```php
// Load all .php files in ./Hooks and add all found Hooks
\Morningtrain\WP\Hooks\Hooks::loadDir(__DIR__ . "/Hooks");
```

### Multiple Directories

Since this tool uses PHP Loader, you may use multiple directories.

```php
// Load all .php files in ./Hooks and add all found Hooks
\Morningtrain\WP\Hooks\Hooks::loadDir([__DIR__ . "/Hooks",__DIR__ . "/EvenMoreHooks"]);
```

## Creating a Hook

### Creating an action

```php
namespace MyApp\Hooks;

class RemoveCommentsMenuItem extends \Morningtrain\WP\Hooks\Abstracts\AbstractActionHook
{
    protected string|array $hook = 'admin_menu';

    public function handle()
    {
        global $wp_admin_bar;
        $wp_admin_bar->remove_menu('comments');
    }

}
```

### Creating a filter

```php
namespace MyApp\Hooks;

class AllowVideoAndSvgUpload extends \Morningtrain\WP\Hooks\Abstracts\AbstractFilterHook
{
    protected string|array $hook = 'mime_types';

    public function handle($wp_get_mime_types)
    {
        $wp_get_mime_types['webp'] = 'image/webp';
        $wp_get_mime_types['svg'] = 'image/svg+xml';
        
        return $wp_get_mime_types;
    }

}
```

## Setting priority

To set the priority simply add its prop. Default is, as always, 10.

```php
namespace MyApp\Hooks;

class MadeByTagline extends \Morningtrain\WP\Hooks\Abstracts\AbstractActionHook
{
    protected string|array $hook = 'footer';
    protected int $priority = 999;

    public function handle()
    {
        echo "Made by someguy@morningtrain.dk";
    }

}
```

## NumArgs

There is no need to set the number of expected args for the callback method.

`AbstractHook` looks at the declaration of handle and counts the number af args it has. So, in short, numArgs will
always be the same as your `handle` reguires!
