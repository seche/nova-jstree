[![MIT License](https://img.shields.io/apm/l/atomic-design-ui.svg?)](https://github.com/seche/nova-laravel-world/LICENSE)
[![PR's Welcome](https://img.shields.io/badge/PRs-welcome-brightgreen.svg?style=flat)](https://github.com/seche/nova-laravel-world/compare)

# **Nova-Jstree**
Nova Field for the [JsTree](https://www.jstree.com/) library. This allows you to utilize JsTree in a model. 

## Table of Contents
1. [Prerequisites](#Prerequisites)
2. [Installation](#Installation)
3. [Usage](#Usage)
   1. [data()](#data())
   2. [theme()](#theme())
   3. [types()](#types())
   4. [checkbox()](#checkbox())
   5. [search()](#search())
4. [Localization](#Localization)
5. [Bugs/Issues](#Bugs/Issues)
6. [License](#License)

## Prerequisites 

This package utilizes the following NPM packages:
- [@fortawesome/fontawesome-free](https://www.npmjs.com/package/@fortawesome/fontawesome-free)
- [jquery](https://www.npmjs.com/package/jquery)
- [jstree](https://www.npmjs.com/package/jstree)

## Installation

1. The package can be installed through Composer.
   
   ```composer require seche/nova-jstree```
   

2. Use the field.
   ```
   use Seche\NovaJstree\Jstree;
   ```
3. Publish Assets. 
   ```
   php artisan vendor:publish --tag=jstree-images
   php artisan vendor:publish --tag=jstree-fonts
   ```

## Usage
   ```
public function fields(Request $request)
{
    return [
        Jstree::make(__('Name'), 'name')
                ->theme(['dots' => true, 'stripes' => false, 'icons' => false])
                ->checkbox()
                ->search()
                ->data(['1', '2', '3']),
        ];
    }
   ```
**Note: See JsTree Documentation for full details on each options available.**

### data()
Takes an array and converts it to a usable JSON object by JsTree. 

You can use the `->toArray()` helper method on a Collection when passing it in data().

### theme()
Default: 
   ```
[
    'dots' => true,
    'icons' => true,
    'stripes' => true,
    'name' => 'default', // default-dark
    'variant' => 'small' // small, large, null
]
   ```

### types()
Default:
   ```
[
    '#' => ['max_children' => 1,
            'max_depth' => 4,
            'valid_children'=> ['root']
    ],
    'root' => [
        'icon' => 'fa fa-hdd text-yellow',
        'valid_children' => ['default', 'file']
    ],
    'default' => [
        'icon' => 'fa fa-folder text-yellow',
        'valid_children' => ['default','file']
    ],
    'file' => [
        'icon' => 'fa fa-file',
        'valid_children' => []
    ],
    'text' =>[
        'icon' => 'far fa-file-alt',
        'valid_children' => []
    ],
    'word' => [
        'icon' => 'far fa-file-word',
        'valid_children' => []
    ],
    'excel' => [
        'icon' => 'far fa-file-excel',
        'valid_children' => []
    ],
    'ppt' => [
        'icon' => 'far fa-file-powerpoint',
        'valid_children' => []
    ],
    'pdf' => [
        'icon' => 'far fa-file-pdf',
        'valid_children' => []
    ],
    'archive' => [
        'icon' => 'far fa-file-archive',
        'valid_children' => []
    ],
    'image' => [
        'icon' => 'far fa-file-image',
        'valid_children' => []
    ],
    'audio' => [
        'icon' => 'far fa-file-audio',
        'valid_children' => []
    ],
    'video' => [
        'icon' => 'far fa-file-video',
        'valid_children' => []
    ]
]
   ```

### checkbox()
Default:
   ```
[
    'visible' => false,
    'three_state' => true,
    'keep_selected_style' => true,
    'whole_node' => true
]
   ```

### search()
Default:
   ```
[
    'visible' => false,
    'show_only_matches' => true,
    'case_sensitive' => false,
    'fuzzy' => false,
    'show_only_matches_children' => false
]
   ```

## Localization

English and French are supported and located in the `resources/lang/` folder and will support any other languages added. 

## Bugs/Issues

Have a bug or an issue with this package? Open a [new issue here](https://github.com/seche/nova-laravel-world/issues/new/choose) on GitHub.

## License
The MIT License (MIT). Please see [License File](LICENSE) for more information.
