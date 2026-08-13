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
        'primary-menu' => __('Menú Principal Header', 'ganagana'),
    ));
}
add_action('init', 'ganagana_register_menus');

function ganagana_widgets_init() {
    register_sidebar(array(
        'name'          => __('Barra Lateral Principal', 'ganagana'),
        'id'            => 'sidebar-1',
        'description'   => __('Agrega widgets aquí para mostrar en el sidebar de blogs y páginas.', 'ganagana'),
        'before_widget' => '<div id="%1$s" class="widget %2$s">',
        'after_widget'  => '</div>',
        'before_title'  => '<h3 class="widget-title">',
        'after_title'   => '</h3>',
    ));
}
add_action('widgets_init', 'ganagana_widgets_init');

function gg_register_footer_rewrite_rules() {
    add_rewrite_rule(
        '^([^/]+)/([^/]+)/?$',
        'index.php?pagename=$matches[2]',
        'top'
    );
}
add_action('init', 'gg_register_footer_rewrite_rules');

/**
 * Sin esto, WP redirige 301 las URLs de dos segmentos del footer
 * (/columna-slug/pagina-slug/) hacia su permalink canónico real.
 */
function gg_disable_canonical_redirect_for_footer($redirect_url, $requested_url) {
    if ($redirect_url && preg_match('#/[^/]+/[^/]+/#', $requested_url)) {
        return false;
    }
    return $redirect_url;
}
add_filter('redirect_canonical', 'gg_disable_canonical_redirect_for_footer', 10, 2);

function gg_flush_rewrite_rules_on_activation() {
    gg_register_footer_rewrite_rules();
    flush_rewrite_rules();
}
add_action('after_switch_theme', 'gg_flush_rewrite_rules_on_activation');
