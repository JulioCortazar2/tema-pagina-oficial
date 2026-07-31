<?php
/**
 * Tema GanaGana Custom — Registro de Opciones y Meta Boxes (CMB2)
 *
 * Registra el panel de administración "Ajustes GanaGana" con sus pestañas
 * (Topbar, Header, Pre-footer, Footer, Copyright) y el meta box de cabecera por página.
 *
 * @package GanaGanaCustom
 */

if (!defined('ABSPATH')) {
    exit; // Evita el acceso directo
}

/**
 * 1. Registrar Páginas de Opciones y Campos del Tema en CMB2.
 */
add_action('cmb2_admin_init', 'gg_register_theme_options');
function gg_register_theme_options() {
    if (!function_exists('new_cmb2_box')) {
        return;
    }

    // =========================================================
    // SECCIÓN 1: TOPBAR (Barra Superior Verde)
    // =========================================================
    $topbar = new_cmb2_box(array(
        'id'           => 'gg_topbar_options',
        'title'        => 'Barra Superior (Topbar Verde)',
        'object_types' => array('options-page'),
        'option_key'   => 'gg_topbar',
        'menu_title'   => 'Ajustes GanaGana',
        'page_title'   => 'Ajustes del Tema GanaGana',
        'icon_url'     => 'dashicons-admin-generic',
        'position'     => 60,
    ));

    // Links del Topbar (Repeater)
    $topbar_group = $topbar->add_field(array(
        'id'          => 'topbar_links',
        'type'        => 'group',
        'description' => 'Agrega, quita o reordena los links de la barra superior verde.',
        'options'     => array(
            'group_title'   => 'Link #{#}',
            'add_button'    => '+ Agregar Link',
            'remove_button' => 'Eliminar Link',
            'sortable'      => true,
        ),
    ));
    $topbar->add_group_field($topbar_group, array(
        'name' => 'Texto',
        'id'   => 'texto',
        'type' => 'text',
    ));
    $topbar->add_group_field($topbar_group, array(
        'name' => 'URL',
        'id'   => 'url',
        'type' => 'text_url',
    ));
    $topbar->add_group_field($topbar_group, array(
        'name' => 'Abrir en nueva pestaña',
        'id'   => 'target_blank',
        'type' => 'checkbox',
    ));

    // =========================================================
    // SECCIÓN 2: HEADER — Logo URL + Botón Promociones
    // =========================================================
    $header_promo = new_cmb2_box(array(
        'id'           => 'gg_header_promo_options',
        'title'        => 'Header — Logo y Botón Promociones',
        'object_types' => array('options-page'),
        'option_key'   => 'gg_header_promo',
        'parent_slug'  => 'gg_topbar',
        'tab_title'    => 'Header',
    ));
    $header_promo->add_field(array(
        'name'        => 'URL del Logo (al hacer clic)',
        'description' => 'URL a la que redirige el logo al hacer clic. Si se deja vacío, redirige al inicio del sitio.',
        'id'          => 'logo_url',
        'type'        => 'text_url',
    ));
    $header_promo->add_field(array(
        'name'    => 'Texto del Botón Promociones',
        'id'      => 'btn_promociones_texto',
        'type'    => 'text',
        'default' => 'PROMOCIONES',
    ));
    $header_promo->add_field(array(
        'name' => 'URL del Botón Promociones',
        'id'   => 'btn_promociones_url',
        'type' => 'text_url',
    ));

    // =========================================================
    // SECCIÓN 3: PRE-FOOTER
    // =========================================================
    $prefooter = new_cmb2_box(array(
        'id'           => 'gg_prefooter_options',
        'title'        => 'Barra Pre-Footer',
        'object_types' => array('options-page'),
        'option_key'   => 'gg_prefooter',
        'parent_slug'  => 'gg_topbar',
        'tab_title'    => 'Pre-Footer',
    ));
    $prefooter->add_field(array(
        'name'    => 'Texto Central',
        'id'      => 'prefooter_texto',
        'type'    => 'text',
        'default' => 'PAGO DE PREMIOS Y SERVICIOS TRADICIONALES',
    ));

    $prefooter_btns = $prefooter->add_field(array(
        'id'          => 'prefooter_botones',
        'type'        => 'group',
        'description' => 'Botones amarillos que aparecen en la barra pre-footer.',
        'options'     => array(
            'group_title'   => 'Botón #{#}',
            'add_button'    => '+ Agregar Botón',
            'remove_button' => 'Eliminar Botón',
            'sortable'      => true,
        ),
    ));
    $prefooter->add_group_field($prefooter_btns, array(
        'name' => 'Texto del Botón',
        'id'   => 'texto_boton',
        'type' => 'text',
    ));
    $prefooter->add_group_field($prefooter_btns, array(
        'name' => 'URL del Botón',
        'id'   => 'url_boton',
        'type' => 'text_url',
    ));
    $prefooter->add_group_field($prefooter_btns, array(
        'name' => 'Abrir en nueva pestaña',
        'id'   => 'target_blank',
        'type' => 'checkbox',
    ));

    // =========================================================
    // SECCIÓN 4: FOOTER PRINCIPAL
    // =========================================================
    $footer = new_cmb2_box(array(
        'id'           => 'gg_footer_options',
        'title'        => 'Footer Principal',
        'object_types' => array('options-page'),
        'option_key'   => 'gg_footer',
        'parent_slug'  => 'gg_topbar',
        'tab_title'    => 'Footer',
    ));
    $footer->add_field(array(
        'name'    => 'Nombre de la Empresa',
        'id'      => 'footer_empresa_nombre',
        'type'    => 'text',
        'default' => 'GanaGana',
    ));
    $footer->add_field(array(
        'name' => 'Descripción de la Empresa',
        'id'   => 'footer_empresa_desc',
        'type' => 'textarea_small',
    ));
    $footer->add_field(array(
        'name' => 'Email de Contacto',
        'id'   => 'footer_empresa_email',
        'type' => 'text_email',
    ));
    $footer->add_field(array(
        'name' => 'Teléfono',
        'id'   => 'footer_empresa_telefono',
        'type' => 'text',
    ));
    $footer->add_field(array(
        'name' => 'Ubicación',
        'id'   => 'footer_empresa_ubicacion',
        'type' => 'text',
    ));

    $redes_group = $footer->add_field(array(
        'id'          => 'footer_redes_sociales',
        'type'        => 'group',
        'description' => 'Agrega las redes sociales de la empresa.',
        'options'     => array(
            'group_title'   => 'Red Social #{#}',
            'add_button'    => '+ Agregar Red Social',
            'remove_button' => 'Eliminar',
            'sortable'      => true,
        ),
    ));
    $footer->add_group_field($redes_group, array(
        'name'        => 'Red Social',
        'description' => 'Ej: facebook, instagram, youtube, twitter, threads, tiktok',
        'id'          => 'red_social',
        'type'        => 'text',
    ));
    $footer->add_group_field($redes_group, array(
        'name' => 'URL del Perfil',
        'id'   => 'url_red',
        'type' => 'text_url',
    ));

    $cols_group = $footer->add_field(array(
        'id'          => 'footer_columnas',
        'type'        => 'group',
        'description' => 'Columnas de enlaces del footer (2 a 4 columnas). Cada columna tiene un título y una lista de enlaces.',
        'options'     => array(
            'group_title'   => 'Columna #{#}',
            'add_button'    => '+ Agregar Columna',
            'remove_button' => 'Eliminar Columna',
            'sortable'      => true,
        ),
    ));
    $footer->add_group_field($cols_group, array(
        'name' => 'Título de la Columna',
        'id'   => 'titulo_columna',
        'type' => 'text',
    ));
    $footer->add_group_field($cols_group, array(
        'name'        => 'Enlaces (uno por línea)',
        'description' => 'Formato preferido para SEO y migraciones:<br><code>Texto del enlace | slug-pagina | id-pagina</code><br>Ejemplo:<br><code>Historia Empresarial | historia-empresarial | 284</code><br><br><i>(Nota: También soporta el formato antiguo <code>Texto|https://url-destino.com</code>)</i>',
        'id'          => 'enlaces_raw',
        'type'        => 'textarea',
    ));

    // --- Panel de Inventario de Páginas (Ayuda para copiar/pegar) ---
    $inventory_items = function_exists('gg_get_pages_inventory') ? gg_get_pages_inventory() : array();
    $inventory_html = '<div style="background:#F7FAFC;border:1px solid #E2E8F0;border-radius:8px;padding:15px;margin-top:15px;">';
    $inventory_html .= '<h4 style="margin:0 0 10px 0;color:#2A5747;font-size:0.9rem;text-transform:uppercase;">📋 Inventario de Páginas Creadas en WordPress</h4>';
    $inventory_html .= '<p style="font-size:0.8rem;color:#4A5568;margin-bottom:10px;">Copia y pega la línea de la página que desees en la caja de enlaces de la columna correspondiente:</p>';

    if (!empty($inventory_items)) {
        $inventory_html .= '<textarea readonly style="width:100%;height:140px;font-family:monospace;font-size:0.78rem;background:#ffffff;border:1px solid #CBD5E0;border-radius:4px;padding:8px;color:#2D3748;" onclick="this.select();">';
        foreach ($inventory_items as $item) {
            $inventory_html .= esc_html($item['formatted']) . "\n";
        }
        $inventory_html .= '</textarea>';
        $inventory_html .= '<span style="font-size:0.72rem;color:#718096;display:block;margin-top:4px;">💡 Haz clic dentro de la caja de arriba para seleccionar todo el texto.</span>';
    } else {
        $inventory_html .= '<p style="font-size:0.8rem;color:#718096;">No hay páginas publicadas creadas en este sitio aún.</p>';
    }
    $inventory_html .= '</div>';

    $footer->add_field(array(
        'id'   => 'footer_pages_inventory_notice',
        'type' => 'title',
        'name' => $inventory_html,
    ));

    // =========================================================
    // SECCIÓN 5: COPYRIGHT
    // =========================================================
    $copyright = new_cmb2_box(array(
        'id'           => 'gg_copyright_options',
        'title'        => 'Barra Copyright',
        'object_types' => array('options-page'),
        'option_key'   => 'gg_copyright',
        'parent_slug'  => 'gg_topbar',
        'tab_title'    => 'Copyright',
    ));
    $copyright->add_field(array(
        'name'        => 'Texto de Copyright',
        'description' => 'Ej: © 2026 GanaGana - Todos los derechos reservados.',
        'id'          => 'copyright_texto',
        'type'        => 'text',
    ));

    $legal_group = $copyright->add_field(array(
        'id'          => 'copyright_links',
        'type'        => 'group',
        'description' => 'Enlaces legales que aparecen a la derecha del copyright.',
        'options'     => array(
            'group_title'   => 'Enlace #{#}',
            'add_button'    => '+ Agregar Enlace Legal',
            'remove_button' => 'Eliminar',
            'sortable'      => true,
        ),
    ));
    $copyright->add_group_field($legal_group, array(
        'name' => 'Texto',
        'id'   => 'texto',
        'type' => 'text',
    ));
    $copyright->add_group_field($legal_group, array(
        'name' => 'URL',
        'id'   => 'url',
        'type' => 'text_url',
    ));
}

/**
 * 2. CMB2 Meta Box: Configuración de Cabecera por Página.
 * Aparece en el panel lateral del editor de páginas.
 */
add_action('cmb2_admin_init', 'gg_register_page_header_meta');
function gg_register_page_header_meta() {
    if (!function_exists('new_cmb2_box')) {
        return;
    }

    $cmb = new_cmb2_box(array(
        'id'           => 'gg_page_header_meta',
        'title'        => 'Cabecera de Página',
        'object_types' => array('page'),
        'context'      => 'side',
        'priority'     => 'high',
        'show_names'   => true,
    ));

    $cmb->add_field(array(
        'name'    => 'Tipo de cabecera',
        'id'      => 'page_header_mode',
        'type'    => 'select',
        'default' => 'default',
        'options' => array(
            'default' => 'Barra verde con título (predeterminado)',
            'hero'    => 'Imagen de ancho completo con título',
            'hidden'  => 'Sin cabecera (solo contenido)',
        ),
    ));

    $cmb->add_field(array(
        'name'       => 'Imagen de fondo',
        'desc'       => 'Sube o selecciona la imagen que cubre el ancho completo.',
        'id'         => 'page_header_image',
        'type'       => 'file',
        'options'    => array('url' => false),
        'query_args' => array('type' => 'image'),
    ));

    $cmb->add_field(array(
        'name'    => 'Altura de la imagen',
        'id'      => 'page_header_height',
        'type'    => 'select',
        'default' => '400',
        'options' => array(
            '200'   => 'Pequeña — 200px',
            '350'   => 'Media — 350px',
            '500'   => 'Grande — 500px',
            '650'   => 'Extra Grande — 650px',
            '100vh' => 'Pantalla completa',
        ),
    ));

    $cmb->add_field(array(
        'name'    => 'Posición de imagen',
        'desc'    => 'Controla qué parte de la imagen se ve cuando se recorta.',
        'id'      => 'page_header_position',
        'type'    => 'select',
        'default' => 'center center',
        'options' => array(
            'center center' => 'Centro (predeterminado)',
            'center top'    => 'Arriba',
            'center bottom' => 'Abajo',
            'left center'   => 'Izquierda',
            'right center'  => 'Derecha',
        ),
    ));

    $cmb->add_field(array(
        'name'    => 'Mostrar título',
        'desc'    => 'Muestra el nombre de la página sobre la imagen.',
        'id'      => 'page_header_show_title',
        'type'    => 'checkbox',
        'default' => 'on',
    ));

    $cmb->add_field(array(
        'name'    => 'Color del título',
        'id'      => 'page_header_title_color',
        'type'    => 'colorpicker',
        'default' => '#FFFFFF',
    ));

    $cmb->add_field(array(
        'name'    => 'Capa oscura (overlay)',
        'desc'    => 'Oscurece la imagen para que el título sea más legible.',
        'id'      => 'page_header_overlay',
        'type'    => 'checkbox',
        'default' => 'on',
    ));

    $cmb->add_field(array(
        'id'   => 'page_header_preview_notice',
        'type' => 'title',
        'name' => '<div id="gg-ph-preview-wrap"></div>',
    ));
}
