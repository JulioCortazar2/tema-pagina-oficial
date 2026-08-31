<?php
if (!defined('ABSPATH')) {
    exit;
}

function gg_check_elementor_support() {
    if (did_action('elementor/loaded')) {
        add_theme_support('elementor-select-2');
    }
}
add_action('after_setup_theme', 'gg_check_elementor_support');

function gg_elementor_page_layout_support() {
    if (did_action('elementor/loaded')) {
        add_filter('body_class', function ($classes) {
            $classes[] = 'gg-elementor-active';
            return $classes;
        });
    }
}
add_action('wp', 'gg_elementor_page_layout_support');

function gg_ocultar_elementor_para_editor() {
    $user = wp_get_current_user();

    if ( in_array( 'editor', (array) $user->roles ) ) {
        remove_menu_page( 'elementor' );
        remove_menu_page( 'elementor-home' );
    }
}
add_action( 'admin_menu', 'gg_ocultar_elementor_para_editor', 999 );
