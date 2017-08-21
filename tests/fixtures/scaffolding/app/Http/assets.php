<?php

wp_enqueue_style('vendor', asset_path('css/vendor.css'));
wp_enqueue_style('app', asset_path('css/app.css'));

wp_enqueue_script('vendor', asset_path('js/vendor.js'), ['jquery'], null, true);
wp_enqueue_script('app', asset_path('js/app.js'), ['vendor'], null, true);

add_editor_style(asset_path('css/vendor.css'));
add_editor_style(asset_path('css/app.css'));
