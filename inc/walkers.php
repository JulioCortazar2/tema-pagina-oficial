<?php
/**
 * Tema GanaGana Custom — Walkers de Navegación Personalizados
 *
 * Contiene la implementación del Walker para maquetar la estructura de
 * tres niveles del Mega Menú corporativo en el header.
 *
 * @package GanaGanaCustom
 */

if (!defined('ABSPATH')) {
    exit; // Evita el acceso directo
}

/**
 * Walker Personalizado para Mega Menú.
 *
 * Nivel 0: Items principales de la barra navegación amarilla (JUEGOS, SERVICIOS, PROMOCIONES...)
 * Nivel 1: Títulos de sección dentro del mega dropdown (CHANCES, BALOTOS, OTROS...)
 * Nivel 2: Enlaces finales de cada producto (Chance, Baloto Revancha, MiLoto, BetPlay...)
 */
class GG_Mega_Menu_Walker extends Walker_Nav_Menu {

    function start_lvl(&$output, $depth = 0, $args = null) {
        if ($depth === 0) {
            // Primer nivel de dropdown: contenedor megamenu
            $output .= '<div class="megamenu-dropdown"><ul class="megamenu-sections">';
        } elseif ($depth === 1) {
            // Segundo nivel: lista dentro de sección
            $output .= '<ul class="megamenu-links">';
        }
    }

    function end_lvl(&$output, $depth = 0, $args = null) {
        if ($depth === 0) {
            $output .= '</ul></div>';
        } elseif ($depth === 1) {
            $output .= '</ul>';
        }
    }

    function start_el(&$output, $item, $depth = 0, $args = null, $id = 0) {
        if ($depth === 0) {
            // Item principal del menú (barra amarilla)
            $classes = implode(' ', $item->classes);
            $has_children = in_array('menu-item-has-children', $item->classes, true);

            $output .= '<li class="nav-item ' . esc_attr($classes) . '">';
            $output .= '<a href="' . esc_url($item->url) . '" class="nav-link">';
            $output .= esc_html($item->title);
            if ($has_children) {
                $output .= ' <span class="dropdown-arrow">▾</span>';
            }
            $output .= '</a>';

        } elseif ($depth === 1) {
            // Título de sección (CHANCES, BALOTOS, OTROS, ACUMULADOS)
            $output .= '<li class="megamenu-section">';
            $output .= '<span class="section-title">';
            $output .= esc_html($item->title);
            $output .= '</span>';

        } elseif ($depth === 2) {
            // Link final
            $output .= '<li class="megamenu-link-item">';
            $output .= '<a href="' . esc_url($item->url) . '">';
            $output .= esc_html($item->title);

            // Si tiene descripción en WP Menu, mostrar badge automáticamente
            if (!empty($item->description)) {
                $badge_class = 'badge-new'; // por defecto rojo
                $desc_lower  = strtolower($item->description);
                if (strpos($desc_lower, 'recarga') !== false) {
                    $badge_class = 'badge-recarga';
                } elseif (strpos($desc_lower, 'promo') !== false) {
                    $badge_class = 'badge-promo';
                }
                $output .= ' <span class="menu-badge ' . esc_attr($badge_class) . '">';
                $output .= esc_html($item->description);
                $output .= '</span>';
            }

            $output .= '</a>';
        }
    }

    function end_el(&$output, $item, $depth = 0, $args = null) {
        $output .= '</li>';
    }
}
