<?php
/**
 * Tema GanaGana Custom — Taxonomías Personalizadas
 *
 * Módulo para registrar taxonomías personalizadas futuras
 * (ejemplo: Categorías de Juegos, Zonas Transaccionales, Tipos de Promoción).
 *
 * @package GanaGanaCustom
 */

if (!defined('ABSPATH')) {
    exit; // Evita el acceso directo
}

/*
 * Ejemplo de estructura para registrar una Taxonomía futura:
 *
 * function gg_register_juegos_taxonomy() {
 *     $labels = array(
 *         'name'              => _x('Categorías de Juego', 'taxonomy general name', 'ganagana'),
 *         'singular_name'     => _x('Categoría de Juego', 'taxonomy singular name', 'ganagana'),
 *     );
 *     $args = array(
 *         'hierarchical'      => true,
 *         'labels'            => $labels,
 *         'show_ui'           => true,
 *         'show_admin_column' => true,
 *         'show_in_rest'      => true,
 *     );
 *     register_taxonomy('categoria_juego', array('gg_juego'), $args);
 * }
 * add_action('init', 'gg_register_juegos_taxonomy');
 */
