<?php

namespace App\Theme\Http;

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

use function App\Theme\asset_path;

/**
 * Registers theme stylesheet files.
 *
 * @return void
 */
function register_stylesheets() {
    wp_enqueue_style('bulma', asset_path('css/bulma.css'));
    wp_enqueue_style('app', asset_path('css/app.css'));
}
add_action('wp_enqueue_scripts', 'App\Theme\Http\register_stylesheets');

/**
 * Registers theme script files.
 *
 * @return void
 */
function register_scripts() {
    wp_enqueue_script('app', asset_path('js/app.js'), [], null, true);
}
add_action('wp_enqueue_scripts', 'App\Theme\Http\register_scripts');

/**
 * Registers editor stylesheets.
 *
 * @return void
 */
function register_editor_stylesheets() {
    add_editor_style(asset_path('css/bulma.css'));
    add_editor_style(asset_path('css/app.css'));
}
add_action('admin_init', 'App\Theme\Http\register_editor_stylesheets');
