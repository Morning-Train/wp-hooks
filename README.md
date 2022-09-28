# WP Hooks

To let you organize all your WordPress actions and filters.

## Table of Contents

- [Introduction](#introduction)
- [Getting Started](#getting-started)
    - [Installation](#installation)
- [Dependencies](#dependencies)
    - [morningtrain/php-loader](#morningtrainphp-loader)
- [Usage](#usage)
  - [Creating a hook](#creating-a-hook)
      - [Adding an action](#adding-an-action)
      - [Adding a filter](#adding-a-filter)
      - [Adding a view on an action](#adding-a-view-on-an-action)
- [Credits](#credits)
- [Testing](#testing)
- [License](#license)


## Introduction

This tool is made for organizing WordPress hooks.

This tool lets you:

- Load all .php files recursively in a directory
- Add filters and action using a fluid api
- Render Blade views directly on an action (if morningtrain/wp-view is installed)

## Getting Started

To get started install the package as described below in [Installation](#installation).

To use the tool have a look at [Usage](#usage)

### Installation

Install with composer

```bash
composer require morningtrain/wp-hooks
```

## Dependencies

### morningtrain/php-loader

[PHP Loader](https://github.com/Morning-Train/php-loader) is used to load and initialize all Hooks

### morningtrain/wp-view (optional)

[WP View](https://github.com/Morning-Train/wp-view) is used to load and initialize all Hooks

## Usage

To load all Hooks of a given directory

```php
// Load all .php files in ./Hooks and add all found Hooks
\Morningtrain\WP\Hooks\Hook::loadDir(__DIR__ . "/App/Hooks");
```

### Multiple Directories

Since this tool uses PHP Loader, you may use multiple directories.

```php
// Load all .php files in ./Hooks and add all found Hooks
\Morningtrain\WP\Hooks\Hook::loadDir([__DIR__ . "/App/Hooks",__DIR__ . "/EvenMoreHooks"]);
```

## Creating a Hook

To create a hook first call `Hook::action`, `Hook::filter` or `Hook::view`. Then start a chain to add additional
parameters.

### Adding an action

To add an action call `Hook::action`. You may either add the callback as the second parameter or by using `handle()`

```php
\Morningtrain\WP\Hooks\Hook::action('init',[Some::class, 'someMethod']);
// is the same as
\Morningtrain\WP\Hooks\Hook::action('init')
    ->handle([Some::class, 'someMethod']);

// With a priority
\Morningtrain\WP\Hooks\Hook::action('init')
    ->priority(20)
    ->handle([Some::class, 'someMethod']);

// Rendering a view
\Morningtrain\WP\Hooks\Hook::action('init')
    ->view('some_view');
```

**Note** that it is not necessary to define the number of args for the callback. The action (or filter) will look at the
callback's definition to know how many arguments it takes.

### Adding a filter

Adding filters is just like adding action. Call `Hook::filter`. You may either add the callback as the second parameter
or by using `filter()`

```php
\Morningtrain\WP\Hooks\Hook::filter('mime_types',[Some::class, 'addSvgMimeType']);
// is the same as
\Morningtrain\WP\Hooks\Hook::filter('mime_types')
    ->filter([Some::class, 'addSvgMimeType']);

// With a priority
\Morningtrain\WP\Hooks\Hook::filter('mime_types')
    ->priority(20)
    ->filter([Some::class, 'addSvgMimeType']);


// For simple filters that return true or false
\Morningtrain\WP\Hooks\Hook::filter('use_some_feature')
    ->returnTrue();
\Morningtrain\WP\Hooks\Hook::filter('use_some_feature')
    ->returnFalse();

```

**Note** that it is not necessary to define the number of args for the callback. The action (or filter) will look at the
callback's definition to know how many arguments it takes.

### Adding a view on an action

You may, if the `morningtrain/wp-view` package is installed, render a blade view directly from an action.

```php
    // This will render the footer/copyright view in the footer
    \Morningtrain\WP\Hooks\Hook::view('footer','footer/copyright');
```

**Note** that you MUST define the number of args used in the hook since the hook has no callback method to analyze.

If you need to use the action params in your view you may render your view from another method or
use [view composing](https://laravel.com/docs/9.x/views#view-composers).

```php
// An action that looks something like this: do_action('some_post_action',$postId);
\Morningtrain\WP\Hooks\Hook::view('some_post_action','someView');
\Morningtrain\WP\View\View::composer('some_post_action',function($view){
    [$postId] = $view;
    $view->with('postId',$postId);
});
```

### Using single use handlers (invokable)

You can use a single use class like so:
```php
class FilterMimeTypes{
 public function __invoke(array $mimeTypes)
        {
            $mimeTypes['webp'] = 'image/webp';
            return $mimeTypes;
        }
}

\Morningtrain\WP\Hooks\Hook::filter('mime_types',FilterMimeTypes::class);
```

## Credits

- [Mathias Munk](https://github.com/mrmoeg)
- [All Contributors](../../contributors)

## Testing

```bash
composer test
```

## License

The MIT License (MIT). Please see [License File](LICENSE) for more information.
