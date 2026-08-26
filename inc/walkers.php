<?php
if (!defined('ABSPATH')) {
    exit;
}

class GG_Mega_Menu_Walker extends Walker_Nav_Menu {

    function start_lvl(&$output, $depth = 0, $args = null) {
        if ($depth === 0) {
            $output .= '<div class="megamenu-dropdown"><ul class="megamenu-sections">';
        } elseif ($depth === 1) {
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
            $classes = implode(' ', $item->classes);
            $has_children = in_array('menu-item-has-children', $item->classes, true);

            // Ítem sin destino real (Custom Link dejado como "#" o vacío en
            // el admin, típicamente el disparador de un dropdown): se
            // renderiza como <span>, no como <a>, para no exponer un enlace
            // roto a buscadores ni lectores de pantalla.
            $es_placeholder = empty($item->url) || '#' === $item->url;
            $tag = $es_placeholder ? 'span' : 'a';

            $output .= '<li class="nav-item ' . esc_attr($classes) . '">';
            $output .= '<' . $tag . ($es_placeholder ? '' : ' href="' . esc_url($item->url) . '"') . ' class="nav-link">';
            $output .= esc_html($item->title);
            if ($has_children) {
                $output .= ' <span class="dropdown-arrow">▾</span>';
            }
            $output .= '</' . $tag . '>';

        } elseif ($depth === 1) {
            $output .= '<li class="megamenu-section">';
            $output .= '<span class="section-title">';
            $output .= esc_html($item->title);
            $output .= '</span>';

        } elseif ($depth === 2) {
            $output .= '<li class="megamenu-link-item">';
            $output .= '<a href="' . esc_url($item->url) . '">';
            $output .= esc_html($item->title);

            if (!empty($item->description)) {
                $badge_class = 'badge-new';
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
