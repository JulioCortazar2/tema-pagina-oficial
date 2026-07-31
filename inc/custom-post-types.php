<?php
/**
 * Tema GanaGana Custom — Custom Post Types (CPT)
 *
 * Módulo para registrar tipos de contenido personalizados futuros
 * (ejemplo: Juegos, Puntos de Venta, Promociones, Ganadores).
 *
 * @package GanaGanaCustom
 */

if (!defined('ABSPATH')) {
    exit; // Evita el acceso directo
}

/*
 * Ejemplo de estructura para registrar un CPT futuro:
 *
 * function gg_register_juegos_cpt() {
 *     $labels = array(
 *         'name'               => _x('Juegos', 'Post Type General Name', 'ganagana'),
 *         'singular_name'      => _x('Juego', 'Post Type Singular Name', 'ganagana'),
 *         'menu_name'          => __('Juegos', 'ganagana'),
 *     );
 *     $args = array(
 *         'label'               => __('Juego', 'ganagana'),
 *         'supports'            => array('title', 'editor', 'thumbnail', 'excerpt'),
 *         'public'              => true,
 *         'show_in_rest'        => true,
 *         'has_archive'         => true,
 *         'menu_icon'           => 'dashicons-tickets-alt',
 *     );
 *     register_post_type('gg_juego', $args);
 * }
 * add_action('init', 'gg_register_juegos_cpt');
 */
