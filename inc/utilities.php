<?php
if (!defined('ABSPATH')) {
    exit;
}

function gg_get_option($field_id) {
    if (!function_exists('cmb2_get_option')) {
        return null;
    }

    $map = array(
        'topbar_links'             => 'gg_topbar',
        'logo_url'                 => 'gg_header_promo',
        'logo_pagina_id'           => 'gg_header_promo',
        'btn_promociones_texto'    => 'gg_header_promo',
        'btn_promociones_url'      => 'gg_header_promo',
        'btn_promociones_pagina_id' => 'gg_header_promo',
        'prefooter_texto'          => 'gg_prefooter',
        'prefooter_botones'        => 'gg_prefooter',
        'footer_empresa_nombre'    => 'gg_footer',
        'footer_empresa_desc'      => 'gg_footer',
        'footer_empresa_email'     => 'gg_footer',
        'footer_empresa_telefono'  => 'gg_footer',
        'footer_empresa_ubicacion' => 'gg_footer',
        'footer_redes_sociales'    => 'gg_footer',
        'footer_columnas'          => 'gg_footer',
        'footer_enlaces'           => 'gg_footer',
        'logos_bg_color'           => 'gg_img_final_pagina',
        'logos_altura_max'         => 'gg_img_final_pagina',
        'logos_institucionales'    => 'gg_img_final_pagina',
        'copyright_texto'          => 'gg_copyright',
        'copyright_links'          => 'gg_copyright',
        'redes_flotantes_items'    => 'gg_redes_flotantes',
        'botones_derechos_items'   => 'gg_botones_derechos',
        'servicios_items'          => 'gg_servicios',
    );

    $option_key = isset($map[$field_id]) ? $map[$field_id] : 'gg_topbar';
    return cmb2_get_option($option_key, $field_id);
}

function gg_get_columna_slug($titulo) {
    if (empty($titulo)) {
        return 'informacion';
    }
    return sanitize_title($titulo);
}

function gg_build_footer_link_url($columna_slug, $pagina_slug, $page_id = 0) {
    $pagina_slug = sanitize_title($pagina_slug);
    $page_id     = absint($page_id);

    if ($page_id > 0) {
        $permalink = get_permalink($page_id);
        if ($permalink && !is_wp_error($permalink)) {
            return $permalink;
        }
    }

    if (!empty($pagina_slug)) {
        return home_url('/' . $pagina_slug . '/');
    }

    if ($page_id > 0) {
        return home_url('/?page_id=' . $page_id);
    }

    return home_url('/');
}

/**
 * Soporta el formato nuevo "Texto | pagina-slug | page_id" y, por
 * retrocompatibilidad, el formato antiguo "Texto | https://url...".
 */
function gg_parse_enlaces_raw_v2($raw_text, $columna_slug = '') {
    $enlaces = array();
    if (empty($raw_text)) {
        return $enlaces;
    }

    $lines = explode("\n", trim($raw_text));
    foreach ($lines as $line) {
        $line = trim($line);
        if (empty($line)) {
            continue;
        }

        $parts = array_map('trim', explode('|', $line));

        $texto = isset($parts[0]) ? esc_html($parts[0]) : '';
        if (empty($texto)) {
            continue;
        }

        $p2 = isset($parts[1]) ? $parts[1] : '';
        $p3 = isset($parts[2]) ? $parts[2] : '';

        if (!empty($p3) && is_numeric($p3)) {
            $pagina_slug = sanitize_title($p2);
            $page_id     = absint($p3);
            $url         = gg_build_footer_link_url($columna_slug, $pagina_slug, $page_id);
        } elseif (!empty($p2) && (strpos($p2, 'http://') === 0 || strpos($p2, 'https://') === 0 || strpos($p2, '/') === 0 || strpos($p2, '?') === 0)) {
            if (preg_match('/page_id=(\d+)/', $p2, $matches)) {
                $page_id = absint($matches[1]);
                $post = get_post($page_id);
                $pagina_slug = $post ? $post->post_name : '';
                $url = gg_build_footer_link_url($columna_slug, $pagina_slug, $page_id);
            } else {
                $url = esc_url($p2);
                $page_id = 0;
                $pagina_slug = '';
            }
        } elseif (!empty($p2)) {
            if (is_numeric($p2)) {
                $page_id = absint($p2);
                $post = get_post($page_id);
                $pagina_slug = $post ? $post->post_name : '';
            } else {
                $pagina_slug = sanitize_title($p2);
                $page_id = 0;
            }
            $url = gg_build_footer_link_url($columna_slug, $pagina_slug, $page_id);
        } else {
            $url = '#';
            $page_id = 0;
            $pagina_slug = '';
        }

        $enlaces[] = array(
            'texto' => $texto,
            'slug'  => $pagina_slug,
            'id'    => $page_id,
            'url'   => $url,
        );
    }

    return $enlaces;
}

function gg_parse_enlaces_raw($raw_text) {
    return gg_parse_enlaces_raw_v2($raw_text, '');
}

function gg_get_pages_inventory() {
    $pages = get_pages(array(
        'post_type'   => 'page',
        'post_status' => 'publish',
        'sort_column' => 'post_title',
        'sort_order'  => 'ASC',
    ));

    $inventory = array();
    if (!empty($pages)) {
        foreach ($pages as $p) {
            $inventory[] = array(
                'id'        => $p->ID,
                'title'     => $p->post_title,
                'slug'      => $p->post_name,
                'formatted' => $p->post_title . ' | ' . $p->post_name . ' | ' . $p->ID,
            );
        }
    }
    return $inventory;
}

/**
 * Migra los enlaces guardados en formato antiguo (?page_id=X) al formato
 * nuevo "Texto | slug | ID" — se ejecuta sobre datos ya guardados en la DB.
 */
function gg_migrate_footer_links_format() {
    $columnas = gg_get_option('footer_columnas');
    if (empty($columnas) || !is_array($columnas)) {
        return;
    }

    $modificado = false;
    foreach ($columnas as $i => $col) {
        if (empty($col['enlaces_raw'])) continue;

        $lines = explode("\n", trim($col['enlaces_raw']));
        $nuevas_lineas = array();

        foreach ($lines as $line) {
            $line = trim($line);
            if (empty($line)) continue;

            $parts = array_map('trim', explode('|', $line));
            $texto = $parts[0];
            $url   = isset($parts[1]) ? $parts[1] : '';

            if (strpos($url, 'page_id=') !== false) {
                preg_match('/page_id=(\d+)/', $url, $m);
                if (!empty($m[1])) {
                    $pid  = absint($m[1]);
                    $post = get_post($pid);
                    if ($post) {
                        $nuevas_lineas[] = $texto . ' | ' . $post->post_name . ' | ' . $pid;
                        $modificado = true;
                        continue;
                    }
                }
            }
            $nuevas_lineas[] = $line;
        }

        if (!empty($nuevas_lineas)) {
            $columnas[$i]['enlaces_raw'] = implode("\n", $nuevas_lineas);
        }
    }

    if ($modificado) {
        $option = get_option('gg_footer');
        if (is_array($option)) {
            $option['footer_columnas'] = $columnas;
            update_option('gg_footer', $option);
        }
    }
}

function gg_footer_opciones_paginas() {
    $pages = get_pages(array(
        'post_type'   => 'page',
        'post_status' => 'publish',
        'sort_column' => 'post_title',
        'sort_order'  => 'ASC',
        'number'      => 0,
    ));

    $options = array(
        '' => '— Selecciona una página —',
    );

    if (!empty($pages)) {
        foreach ($pages as $p) {
            $options[$p->ID] = $p->post_title . ' (ID: ' . $p->ID . ')';
        }
    }

    return $options;
}

function gg_footer_opciones_columnas() {
    $columnas = gg_get_option('footer_columnas');

    $options = array(
        '' => '— Selecciona una columna —',
    );

    if (!empty($columnas) && is_array($columnas)) {
        foreach ($columnas as $col) {
            $titulo = !empty($col['titulo_columna']) ? trim($col['titulo_columna']) : '';
            if ($titulo) {
                $options[$titulo] = $titulo;
            }
        }
    }

    return $options;
}
