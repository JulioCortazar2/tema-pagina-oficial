<?php
if (!defined('ABSPATH')) {
    exit;
}

// --- 1. Frontend Enqueue ---
function ganagana_enqueue_assets() {
    wp_enqueue_style(
        'google-font-montserrat',
        'https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,300;0,400;0,500;0,600;0,700;0,800;1,400;1,600&display=swap',
        array(),
        null
    );

    $css_path = GANAGANA_DIR . '/assets/css/main.css';
    $css_ver  = file_exists($css_path) ? filemtime($css_path) : '1.0.0';
    wp_enqueue_style(
        'ganagana-main',
        GANAGANA_URI . '/assets/css/main.css',
        array('google-font-montserrat'),
        $css_ver
    );

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

// --- 2. Admin Enqueue ---
function gg_enqueue_admin_styles($hook) {
    $gg_pages = array(
        'toplevel_page_gg_topbar',
        'ajustes-ganagana_page_gg_header_promo',
        'ajustes-ganagana_page_gg_prefooter',
        'ajustes-ganagana_page_gg_footer',
        'ajustes-ganagana_page_gg_copyright',
        'ajustes-ganagana_page_gg_redes_flotantes',
        'ajustes-ganagana_page_gg_botones_derechos',
    );

    if (in_array($hook, $gg_pages, true)) {
        wp_enqueue_style(
            'gg-admin-options',
            GANAGANA_URI . '/assets/css/admin-options.css',
            array(),
            filemtime(GANAGANA_DIR . '/assets/css/admin-options.css')
        );
    }

    if (in_array($hook, array('post.php', 'post-new.php'), true)) {
        $screen = get_current_screen();
        if ($screen && $screen->post_type === 'page') {
            wp_enqueue_media();

            wp_enqueue_script(
                'gg-admin-page-header',
                GANAGANA_URI . '/assets/js/admin-page-header.js',
                array('jquery'),
                '1.0.0',
                true
            );

            wp_localize_script('gg-admin-page-header', 'ggPageHeader', array(
                'placeholderUrl' => GANAGANA_URI . '/assets/images/logo.png',
                'siteTitle'      => get_bloginfo('name'),
            ));
        }
    }
}
add_action('admin_enqueue_scripts', 'gg_enqueue_admin_styles');
