<?php
if (!defined('ABSPATH')) {
    exit;
}

function gg_remove_wp_version() {
    return '';
}
add_filter('the_generator', 'gg_remove_wp_version');

function gg_login_errors_override() {
    return __('Credenciales incorrectas. Por favor intenta de nuevo.', 'ganagana');
}
add_filter('login_errors', 'gg_login_errors_override');

if (!defined('DISALLOW_FILE_EDIT')) {
    define('DISALLOW_FILE_EDIT', true);
}
