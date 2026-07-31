<?php
/**
 * Tema GanaGana Custom — Soporte del Tema, Menús, Widgets y Rewrite Rules (Hooks)
 *
 * Registra las características nativas del tema, menús de navegación,
 * zonas de widgets (sidebars) y reglas de reescritura de URL amigables.
 *
 * @package GanaGanaCustom
 */

if (!defined('ABSPATH')) {
    exit; // Evita el acceso directo
}

/**
 * 1. Registra el soporte nativo del tema.
 */
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

/**
 * 2. Registra las ubicaciones de menús de navegación.
 */
function ganagana_register_menus() {
    register_nav_menus(array(
        'primary-menu' => __('Menú Principal Header', 'ganagana'),
    ));
}
add_action('init', 'ganagana_register_menus');

/**
 * 3. Registra las áreas de widgets (sidebar).
 */
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

/**
 * 4. Registrar Rewrite Rules para URLs amigables del Footer: /columna-slug/pagina-slug/
 */
function gg_register_footer_rewrite_rules() {
    add_rewrite_rule(
        '^([^/]+)/([^/]+)/?$',
        'index.php?pagename=$matches[2]',
        'top'
    );
}
add_action('init', 'gg_register_footer_rewrite_rules');

/**
 * 5. Evita que WordPress aplique redirección 301 canónica en las URLs estructuradas del footer.
 *
 * @param string $redirect_url  URL de destino canónica.
 * @param string $requested_url URL solicitada originalmente por el usuario.
 * @return string|false URL de redirección o false para desactivar.
 */
function gg_disable_canonical_redirect_for_footer($redirect_url, $requested_url) {
    if ($redirect_url && preg_match('#/[^/]+/[^/]+/#', $requested_url)) {
        return false;
    }
    return $redirect_url;
}
add_filter('redirect_canonical', 'gg_disable_canonical_redirect_for_footer', 10, 2);

/**
 * 6. Refresca reglas de reescritura en la activación del tema.
 */
function gg_flush_rewrite_rules_on_activation() {
    gg_register_footer_rewrite_rules();
    flush_rewrite_rules();
}
add_action('after_switch_theme', 'gg_flush_rewrite_rules_on_activation');
