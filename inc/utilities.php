<?php
/**
 * Tema GanaGana Custom — Funciones de Utilidad y Helpers
 *
 * Proporciona funciones auxiliares para mapeo de opciones CMB2,
 * parseo de enlaces estructurados v2, slugs y generación de URLs dinámicas.
 *
 * @package GanaGanaCustom
 */

if (!defined('ABSPATH')) {
    exit; // Evita el acceso directo
}

/**
 * Helper para obtener opciones guardadas en CMB2 Options Page.
 * Mapea cada ID de campo con la clave de opción (option_key) correspondiente.
 *
 * @param string $field_id El identificador único del campo.
 * @return mixed Valor del campo o null si CMB2 no está disponible.
 */
function gg_get_option($field_id) {
    if (!function_exists('cmb2_get_option')) {
        return null;
    }

    // Mapa de campo => option_key de su sección
    $map = array(
        'topbar_links'             => 'gg_topbar',
        'logo_url'                 => 'gg_header_promo',
        'btn_promociones_texto'    => 'gg_header_promo',
        'btn_promociones_url'      => 'gg_header_promo',
        'prefooter_texto'          => 'gg_prefooter',
        'prefooter_botones'        => 'gg_prefooter',
        'footer_empresa_nombre'    => 'gg_footer',
        'footer_empresa_desc'      => 'gg_footer',
        'footer_empresa_email'     => 'gg_footer',
        'footer_empresa_telefono'  => 'gg_footer',
        'footer_empresa_ubicacion' => 'gg_footer',
        'footer_redes_sociales'    => 'gg_footer',
        'footer_columnas'          => 'gg_footer',
        'copyright_texto'          => 'gg_copyright',
        'copyright_links'          => 'gg_copyright',
    );

    $option_key = isset($map[$field_id]) ? $map[$field_id] : 'gg_topbar';
    return cmb2_get_option($option_key, $field_id);
}

/**
 * Convierte el título de una columna del footer a un slug limpio.
 * Ej: "Quiénes Somos" -> "quienes-somos"
 *
 * @param string $titulo Título de la columna.
 * @return string Slug sanitizado.
 */
function gg_get_columna_slug($titulo) {
    if (empty($titulo)) {
        return 'informacion';
    }
    return sanitize_title($titulo);
}

/**
 * Construye la URL limpia directa para la página: /pagina-slug/ o el permalink nativo de WP.
 * Se elimina el prefijo del slug de la columna.
 *
 * @param string $columna_slug Slug de la columna contenedora (conservado por compatibilidad).
 * @param string $pagina_slug  Slug de la página.
 * @param int    $page_id      ID de la página en WordPress.
 * @return string URL amigable resultante.
 */
function gg_build_footer_link_url($columna_slug, $pagina_slug, $page_id = 0) {
    $pagina_slug = sanitize_title($pagina_slug);
    $page_id     = absint($page_id);

    // 1. Si tenemos el ID de la página, obtener su permalink nativo de WordPress
    if ($page_id > 0) {
        $permalink = get_permalink($page_id);
        if ($permalink && !is_wp_error($permalink)) {
            return $permalink;
        }
    }

    // 2. Si tenemos el slug de la página, construir la URL directa: /pagina-slug/
    if (!empty($pagina_slug)) {
        return home_url('/' . $pagina_slug . '/');
    }

    // 3. Fallback si hay ID pero no se pudo obtener permalink nativo
    if ($page_id > 0) {
        return home_url('/?page_id=' . $page_id);
    }

    // 4. Fallback general
    return home_url('/');
}

/**
 * Helper v2 para parsear enlaces del footer.
 * Soporta nuevo formato: "Texto | pagina-slug | page_id"
 * Con retrocompatibilidad para formato antiguo: "Texto | https://url..."
 *
 * @param string $raw_text     Cadena multilínea ingresada en el textarea.
 * @param string $columna_slug Slug de la columna contenedora.
 * @return array Lista de enlaces parseados y sanitizados.
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

        // Formato Nuevo: Texto | pagina-slug | page_id
        if (!empty($p3) && is_numeric($p3)) {
            $pagina_slug = sanitize_title($p2);
            $page_id     = absint($p3);
            $url         = gg_build_footer_link_url($columna_slug, $pagina_slug, $page_id);
        }
        // Formato Antiguo o URL Directa: Texto | https://...
        elseif (!empty($p2) && (strpos($p2, 'http://') === 0 || strpos($p2, 'https://') === 0 || strpos($p2, '/') === 0 || strpos($p2, '?') === 0)) {
            // Intentar extraer page_id de URLs antiguas tipo ?page_id=123
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
        }
        // Formato Simplificado: Texto | page_id o Texto | pagina-slug
        elseif (!empty($p2)) {
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

/**
 * Mantiene compatibilidad con v1.
 */
function gg_parse_enlaces_raw($raw_text) {
    return gg_parse_enlaces_raw_v2($raw_text, '');
}

/**
 * Obtiene el inventario de todas las páginas publicadas en WordPress
 * formateadas como: "Título | slug | ID" para copiar/pegar fácilmente.
 *
 * @return array Array de strings formateadas por página.
 */
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
 * Función utilitaria para migrar automáticamente los datos antiguos guardados
 * en la base de datos (convertir URLs tipo ?page_id=X al nuevo formato).
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

            // Si es formato antiguo con URL
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
