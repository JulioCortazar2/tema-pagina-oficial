<?php
if (!defined('ABSPATH')) {
    exit;
}

function ganagana_theme_support() {
    add_theme_support('title-tag');
    add_theme_support('post-thumbnails');
    add_theme_support('custom-logo', array(
        'height'      => 60,
        'width'       => 200,
        'flex-height' => true,
        'flex-width'  => true,
    ));
    add_theme_support('html5', array(
        'search-form',
        'comment-form',
        'comment-list',
        'gallery',
        'caption',
        'style',
        'script',
    ));
}
add_action('after_setup_theme', 'ganagana_theme_support');

function ganagana_register_menus() {
    register_nav_menus(array(
        'primary-menu' => __('MenÃº Principal Header', 'ganagana'),
    ));
}
add_action('init', 'ganagana_register_menus');

function ganagana_widgets_init() {
    register_sidebar(array(
        'name'          => __('Barra Lateral Principal', 'ganagana'),
        'id'            => 'sidebar-1',
        'description'   => __('Agrega widgets aquÃ­ para mostrar en el sidebar de blogs y pÃ¡ginas.', 'ganagana'),
        'before_widget' => '<div id="%1$s" class="widget %2$s">',
        'after_widget'  => '</div>',
        'before_title'  => '<h3 class="widget-title">',
        'after_title'   => '</h3>',
    ));
}
add_action('widgets_init', 'ganagana_widgets_init');

function gg_flush_rewrite_rules_on_activation() {
    flush_rewrite_rules();
}
add_action('after_switch_theme', 'gg_flush_rewrite_rules_on_activation');

function gg_asegurar_rol_ajustes_theme() {
    if (!get_role('editor_ajustes_ganagana')) {
        add_role('editor_ajustes_ganagana', 'Editor Ajustes GanaGana', array('read' => true));
    }
    $rol = get_role('editor_ajustes_ganagana');
    if ($rol) {
        $rol->add_cap('gg_manage_theme_options');
        $rol->add_cap('edit_theme_options'); // Apariencia > MenÃºs (estructura del mega menÃº).
    }

    $admin = get_role('administrator');
    if ($admin) {
        $admin->add_cap('gg_manage_theme_options');
    }
}
add_action('after_switch_theme', 'gg_asegurar_rol_ajustes_theme');
add_action('admin_init', 'gg_asegurar_rol_ajustes_theme');
