<?php
/**
 * Tema GanaGana Custom — Integración y Soporte para Elementor
 *
 * Módulo para gestionar la compatibilidad, ubicaciones de maquetado
 * y soporte específico para el constructor Elementor.
 *
 * @package GanaGanaCustom
 */

if (!defined('ABSPATH')) {
    exit; // Evita el acceso directo
}

/**
 * 1. Verifica si Elementor está activo y declara soporte de ubicaciones si es necesario.
 */
function gg_check_elementor_support() {
    if (did_action('elementor/loaded')) {
        // Soporte para ubicaciones nativas de Elementor Pro Header / Footer si se utilizan
        add_theme_support('elementor-select-2');
    }
}
add_action('after_setup_theme', 'gg_check_elementor_support');

/**
 * 2. Asegura que los contenedores de Elementor usen el 100% del ancho del viewport en layouts full-width.
 */
function gg_elementor_page_layout_support() {
    if (did_action('elementor/loaded')) {
        add_filter('body_class', function ($classes) {
            $classes[] = 'gg-elementor-active';
            return $classes;
        });
    }
}
add_action('wp', 'gg_elementor_page_layout_support');
