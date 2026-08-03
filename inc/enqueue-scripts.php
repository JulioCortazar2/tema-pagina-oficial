<?php
/**
 * Tema GanaGana Custom — Carga de Scripts y Estilos (Enqueue)
 *
 * Administra la inclusión de hojas de estilo (CSS) y archivos JavaScript
 * tanto en el frontend como en la interfaz de administración (wp-admin).
 *
 * @package GanaGanaCustom
 */

if (!defined('ABSPATH')) {
    exit; // Evita el acceso directo
}

/**
 * 1. Encola los estilos y scripts del frontend.
 */
function ganagana_enqueue_assets() {
    // Google Font: Montserrat
    wp_enqueue_style(
        'google-font-montserrat',
        'https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,300;0,400;0,500;0,600;0,700;0,800;1,400;1,600&display=swap',
        array(),
        null
    );

    // CSS Principal con cache-busting automático vía filemtime
    $css_path = GANAGANA_DIR . '/assets/css/main.css';
    $css_ver  = file_exists($css_path) ? filemtime($css_path) : '1.0.0';
    wp_enqueue_style(
        'ganagana-main',
        GANAGANA_URI . '/assets/css/main.css',
        array('google-font-montserrat'),
        $css_ver
    );

    // JS Principal con cache-busting automático
    $js_path = GANAGANA_DIR . '/assets/js/main.js';
    $js_ver  = file_exists($js_path) ? filemtime($js_path) : '1.0.0';
    wp_enqueue_script(
        'ganagana-main',
        GANAGANA_URI . '/assets/js/main.js',
        array(),
        $js_ver,
        true
    );
}
add_action('wp_enqueue_scripts', 'ganagana_enqueue_assets');

/**
 * 2. Encola los estilos y scripts del panel de administración (wp-admin).
 *
 * @param string $hook Identificador de la pantalla actual en wp-admin.
 */
function gg_enqueue_admin_styles($hook) {
    // CSS para páginas de opciones del tema en Ajustes GanaGana
    $gg_pages = array(
        'toplevel_page_gg_topbar',
        'ajustes-ganagana_page_gg_header_promo',
        'ajustes-ganagana_page_gg_prefooter',
        'ajustes-ganagana_page_gg_footer',
        'ajustes-ganagana_page_gg_copyright',
        'ajustes-ganagana_page_gg_redes_flotantes',
    );

    if (in_array($hook, $gg_pages, true)) {
        wp_enqueue_style(
            'gg-admin-options',
            GANAGANA_URI . '/assets/css/admin-options.css',
            array(),
            filemtime(GANAGANA_DIR . '/assets/css/admin-options.css')
        );
    }

    // JS + CSS para la vista previa de cabecera en el editor de páginas
    if (in_array($hook, array('post.php', 'post-new.php'), true)) {
        $screen = get_current_screen();
        if ($screen && $screen->post_type === 'page') {
            // Carga la librería nativa de medios de WordPress
            wp_enqueue_media();

            wp_enqueue_script(
                'gg-admin-page-header',
                GANAGANA_URI . '/assets/js/admin-page-header.js',
                array('jquery'),
                '1.0.0',
                true
            );

            // Pasa variables de soporte al JS
            wp_localize_script('gg-admin-page-header', 'ggPageHeader', array(
                'placeholderUrl' => GANAGANA_URI . '/assets/images/logo.png',
                'siteTitle'      => get_bloginfo('name'),
            ));
        }
    }
}
add_action('admin_enqueue_scripts', 'gg_enqueue_admin_styles');
