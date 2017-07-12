<?php

namespace Tonik\CLI\Renaming;

class Placeholders
{
    /**
     * List of placeholders.
     *
     * @var array
     */
    const REPLACEMENTS = [
        '{{ theme.name }}' => [
            'value' => 'Tonik Starter Theme',
            'message' => '<comment>Theme Name</comment> [Tonik Starter Theme]',
        ],

        '{{ theme.url }}' => [
            'value' => '//labs.tonik.pl/theme/',
            'message' => '<comment>Theme URI</comment> [//labs.tonik.pl/theme/]',
        ],

        '{{ theme.description }}' => [
            'value' => 'Enhance your WordPress theme development workflow',
            'message' => '<comment>Theme Description</comment> [Enhance your WordPress theme development workflow]',
        ],

        '{{ theme.version }}' => [
            'value' => '2.0.0',
            'message' => '<comment>Theme Version</comment> [2.0.0]',
        ],

        '{{ theme.author }}' => [
            'value' => 'Tonik',
            'message' => '<comment>Author</comment> [Tonik]',
        ],

        '{{ theme.author.url }}' => [
            'value' => '//tonik.pl/',
            'message' => '<comment>Author URI</comment> [//tonik.pl/]',
        ],

        '{{ theme.textdomain }}' => [
            'value' => 'tonik',
            'message' => '<comment>Theme Textdomain</comment> [tonik]',
        ],

        'App\Theme' => [
            'value' => 'App\Theme',
            'message' => '<comment>Theme Namespace</comment> [App\Theme]',
        ]
    ];
}