<?php

namespace Tonik\Theme\App\Http;

/*
|-----------------------------------------------------------------
| Theme Assets
|-----------------------------------------------------------------
|
| This file is for registering your theme stylesheets and scripts.
| In here you should also deregister all unwanted assets which
| can be shiped with various third-parity plugins.
|
*/

use function Tonik\Theme\App\asset_path;

/**
 * Registers theme stylesheet files.
 *
 * @return void
 */
function register_stylesheets() {
    wp_enqueue_style('app', asset_path('css/app.css'));
}
add_action('wp_enqueue_scripts', 'Tonik\Theme\App\Http\register_stylesheets');

/**
 * Registers theme script files.
 *
 * @return void
 */
function register_scripts() {
    wp_enqueue_script('app', asset_path('js/app.js'), [], null, true);
}
add_action('wp_enqueue_scripts', 'Tonik\Theme\App\Http\register_scripts');

/**
 * Registers editor stylesheets.
 *
 * @return void
 */
function register_editor_stylesheets() {
    add_editor_style(asset_path('css/app.css'));
}
add_action('admin_init', 'Tonik\Theme\App\Http\register_editor_stylesheets');
