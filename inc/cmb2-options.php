<?php
/**
 * Tema GanaGana Custom — Registro de Opciones y Meta Boxes (CMB2)
 *
 * Registra el panel de administración "Topbar" con sus pestañas
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
    // SECCIÓN 2.5: IMÁGENES FINAL DE PÁGINA (Franja de logos institucionales)
    // =========================================================
    $img_final = new_cmb2_box(array(
        'id'           => 'gg_img_final_pagina_options',
        'title'        => 'Imágenes Final de Página',
        'object_types' => array('options-page'),
        'option_key'   => 'gg_img_final_pagina',
        'parent_slug'  => 'gg_topbar',
        'menu_title'   => 'img_FinalPagina',
        'tab_title'    => 'img_FinalPagina',
    ));
    $img_final->add_field(array(
        'name'    => esc_html__('Color de Fondo — Franja de Logos', 'ganagana'),
        'desc'    => esc_html__('Color de fondo de la franja de logos institucionales.', 'ganagana'),
        'id'      => 'logos_bg_color',
        'type'    => 'colorpicker',
        'default' => '#ffffff',
    ));
    $img_final->add_field(array(
        'name'       => esc_html__('Altura Máxima de Logos (px)', 'ganagana'),
        'desc'       => esc_html__('Altura base de los logos en escritorio, en píxeles. Se reduce automáticamente en móvil.', 'ganagana'),
        'id'         => 'logos_altura_max',
        'type'       => 'text_small',
        'default'    => '70',
        'attributes' => array(
            'type' => 'number',
            'min'  => '20',
        ),
    ));

    $logos_group = $img_final->add_field(array(
        'id'          => 'logos_institucionales',
        'type'        => 'group',
        'desc'        => esc_html__('Logos institucionales que se muestran en una franja al final de la página (ej: Vigilado Supersalud, Aliado de Su Red). Cantidad ilimitada, arrastra para reordenar.', 'ganagana'),
        'options'     => array(
            'group_title'   => esc_html__('Logo #{#}', 'ganagana'),
            'add_button'    => esc_html__('+ Agregar Logo', 'ganagana'),
            'remove_button' => esc_html__('Eliminar Logo', 'ganagana'),
            'sortable'      => true,
        ),
    ));
    $img_final->add_group_field($logos_group, array(
        'name'       => esc_html__('Imagen del Logo', 'ganagana'),
        'desc'       => esc_html__('Obligatorio para que el logo se muestre en el frontend. Sube o selecciona una imagen de la Biblioteca de Medios.', 'ganagana'),
        'id'         => 'imagen',
        'type'       => 'file',
        'options'    => array(
            'url' => false,
        ),
        'query_args' => array(
            'type' => 'image',
        ),
    ));
    $img_final->add_group_field($logos_group, array(
        'name' => esc_html__('Texto Alternativo (Alt)', 'ganagana'),
        'desc' => esc_html__('Descripción para accesibilidad y SEO. Si se deja vacío, se usa el texto alternativo definido en la Biblioteca de Medios.', 'ganagana'),
        'id'   => 'alt',
        'type' => 'text',
    ));
    $img_final->add_group_field($logos_group, array(
        'name' => esc_html__('URL de Destino (Opcional)', 'ganagana'),
        'desc' => esc_html__('Si se define, el logo será clicable y enlazará a esta dirección.', 'ganagana'),
        'id'   => 'url',
        'type' => 'text_url',
    ));
    $img_final->add_group_field($logos_group, array(
        'name' => esc_html__('Abrir en nueva pestaña', 'ganagana'),
        'id'   => 'target_blank',
        'type' => 'checkbox',
    ));
    $img_final->add_group_field($logos_group, array(
        'name'       => esc_html__('Escala Visual (%)', 'ganagana'),
        'desc'       => esc_html__('Ajusta el tamaño relativo del logo entre 50% y 150% para compensar proporciones muy distintas entre logos. Valor por defecto: 100.', 'ganagana'),
        'id'         => 'escala',
        'type'       => 'text_small',
        'default'    => '100',
        'attributes' => array(
            'type' => 'number',
            'min'  => '50',
            'max'  => '150',
        ),
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

    // ---------------------------------------------------------
    // GRUPO A: COLUMNAS DEL FOOTER
    // ---------------------------------------------------------
    $cols_group = $footer->add_field(array(
        'id'          => 'footer_columnas',
        'type'        => 'group',
        'description' => 'Define las columnas principales del footer (ej: Nuestros Productos, Atención al Cliente).',
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

    // ---------------------------------------------------------
    // PANEL INFORMATIVO / REFERENCIA VISUAL DE COLUMNAS
    // ---------------------------------------------------------
    $columnas_existentes = gg_get_option('footer_columnas');
    $nombres_cols = array();
    if (!empty($columnas_existentes) && is_array($columnas_existentes)) {
        foreach ($columnas_existentes as $c) {
            if (!empty($c['titulo_columna'])) {
                $nombres_cols[] = '<strong>' . esc_html($c['titulo_columna']) . '</strong>';
            }
        }
    }
    $notice_text = !empty($nombres_cols) ? implode(' · ', $nombres_cols) : '<i>(No hay columnas creadas arriba aún. Crea primero las columnas y guarda los cambios).</i>';

    $footer->add_field(array(
        'id'   => 'footer_columnas_referencia_notice',
        'type' => 'title',
        'name' => '<div style="background:#eff6ff;border-left:4px solid #3b82f6;padding:12px 16px;margin:20px 0 10px 0;border-radius:4px;color:#1e3a8a;font-size:0.9rem;">' .
                  '📋 <strong>Columnas disponibles actualmente:</strong> ' . $notice_text .
                  '</div>',
    ));

    // ---------------------------------------------------------
    // GRUPO B: ENLACES DEL FOOTER (Lista plana)
    // ---------------------------------------------------------
    $enlaces_group = $footer->add_field(array(
        'id'          => 'footer_enlaces',
        'type'        => 'group',
        'description' => 'Agrega cada enlace individual, selecciona su página de destino y asignalo a la columna correspondiente.',
        'options'     => array(
            'group_title'   => 'Enlace #{#}',
            'add_button'    => '+ Agregar Enlace',
            'remove_button' => 'Eliminar Enlace',
            'sortable'      => true,
        ),
    ));
    $footer->add_group_field($enlaces_group, array(
        'name' => 'Texto del Enlace (Nombre Visible)',
        'id'   => 'texto_enlace',
        'type' => 'text',
    ));
    $footer->add_group_field($enlaces_group, array(
        'name'       => 'Página de Destino',
        'id'         => 'pagina_id',
        'type'       => 'select',
        'options_cb' => 'gg_footer_opciones_paginas',
    ));
    $footer->add_group_field($enlaces_group, array(
        'name' => 'URL Externa (Opcional)',
        'desc' => 'Ej: https://www.ejemplo.com (Si colocas una URL aquí, se usará en lugar de la página de destino)',
        'id'   => 'url_externa',
        'type' => 'text_url',
    ));
    $footer->add_group_field($enlaces_group, array(
        'name' => 'Abrir en nueva pestaña',
        'id'   => 'target_blank',
        'type' => 'checkbox',
    ));
    $footer->add_group_field($enlaces_group, array(
        'name'       => 'Columna a la que pertenece',
        'id'         => 'columna',
        'type'       => 'select',
        'options_cb' => 'gg_footer_opciones_columnas',
    ));
    $footer->add_group_field($enlaces_group, array(
        'name'       => 'Orden de aparición',
        'desc'       => 'Posición dentro de su columna (0 = primero, 1 = segundo, etc.)',
        'id'         => 'orden',
        'type'       => 'text',
        'default'    => '0',
        'attributes' => array(
            'type' => 'number',
            'min'  => '0',
        ),
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
        'name'       => 'Página de Destino',
        'id'         => 'pagina_id',
        'type'       => 'select',
        'options_cb' => 'gg_footer_opciones_paginas',
    ));
    $copyright->add_group_field($legal_group, array(
        'name' => 'URL',
        'desc' => 'Ej: https://www.ejemplo.com (Si colocas una URL aquí, se usará en lugar de la página de destino)',
        'id'   => 'url',
        'type' => 'text_url',
    ));

    // =========================================================
    // SECCIÓN 6: REDES SOCIALES FLOTANTES (Widget lateral)
    // =========================================================
    $redes_flotantes = new_cmb2_box(array(
        'id'           => 'gg_redes_flotantes_options',
        'title'        => 'Redes Sociales Flotantes',
        'object_types' => array('options-page'),
        'option_key'   => 'gg_redes_flotantes',
        'parent_slug'  => 'gg_topbar',
        'tab_title'    => 'Redes Flotantes',
    ));

    $flotantes_group = $redes_flotantes->add_field(array(
        'id'          => 'redes_flotantes_items',
        'type'        => 'group',
        'description' => 'Configura las redes sociales que aparecerán en el botón flotante del sitio.',
        'options'     => array(
            'group_title'   => 'Red Social #{#}',
            'add_button'    => '+ Agregar Red Social',
            'remove_button' => 'Eliminar',
            'sortable'      => true,
        ),
    ));
    $redes_flotantes->add_group_field($flotantes_group, array(
        'name' => 'Nombre de la red social',
        'desc' => 'Ej: Instagram, Facebook, Telegram',
        'id'   => 'nombre_red',
        'type' => 'text',
    ));
    $redes_flotantes->add_group_field($flotantes_group, array(
        'name' => 'Link a la red social',
        'desc' => 'Ej: https://www.instagram.com/tu-usuario',
        'id'   => 'url_red',
        'type' => 'text_url',
    ));
    $redes_flotantes->add_group_field($flotantes_group, array(
        'name'    => 'Abrir en nueva pestaña',
        'id'      => 'target_blank',
        'type'    => 'checkbox',
        'default' => 'on',
    ));
    $redes_flotantes->add_group_field($flotantes_group, array(
        'name'    => 'Ícono de la red social',
        'id'      => 'icono_red',
        'type'    => 'select',
        'options' => array(
            'facebook'  => 'Facebook',
            'instagram' => 'Instagram',
            'youtube'   => 'YouTube',
            'twitter'   => 'Twitter / X',
            'x'         => 'X (Twitter)',
            'threads'   => 'Threads',
            'tiktok'    => 'TikTok',
            'linkedin'  => 'LinkedIn',
            'whatsapp'  => 'WhatsApp',
            'otro'      => 'No está la red social',
        ),
        'default' => 'facebook',
    ));

    // =========================================================
    // SECCIÓN 7: BOTONES FLOTANTES DERECHOS (Acciones Rápidas)
    // =========================================================
    $botones_derechos = new_cmb2_box(array(
        'id'           => 'gg_botones_derechos_options',
        'title'        => 'Botones Flotantes Derechos',
        'object_types' => array('options-page'),
        'option_key'   => 'gg_botones_derechos',
        'parent_slug'  => 'gg_topbar',
        'tab_title'    => 'Botones Derechos',
    ));

    $right_group = $botones_derechos->add_field(array(
        'id'          => 'botones_derechos_items',
        'type'        => 'group',
        'description' => 'Configura las esferas del lado derecho que se expanden hacia la izquierda al pasar el cursor.',
        'options'     => array(
            'group_title'   => 'Botón Derecho #{#}',
            'add_button'    => '+ Agregar Botón Derecho',
            'remove_button' => 'Eliminar',
            'sortable'      => true,
        ),
    ));
    $botones_derechos->add_group_field($right_group, array(
        'name' => 'Texto del Botón (Visible al Expandir)',
        'desc' => 'Ej: GG PUNTOS, RECARGAS, CONTACTO',
        'id'   => 'texto',
        'type' => 'text',
    ));
    $botones_derechos->add_group_field($right_group, array(
        'name' => 'URL de Destino',
        'desc' => 'Ej: https://webganagana.com.co/puntos',
        'id'   => 'url',
        'type' => 'text_url',
    ));
    $botones_derechos->add_group_field($right_group, array(
        'name' => 'Abrir en nueva pestaña',
        'id'   => 'target_blank',
        'type' => 'checkbox',
    ));
    $botones_derechos->add_group_field($right_group, array(
        'name' => 'Imagen del Ícono (Esfera)',
        'desc' => 'Sube una imagen o ícono personalizado en formato PNG, SVG o JPG.',
        'id'   => 'imagen_icono',
        'type' => 'file',
        'options' => array(
            'url' => false,
        ),
    ));
    $botones_derechos->add_group_field($right_group, array(
        'name'    => 'Color del Círculo (Esfera)',
        'desc'    => 'Color de fondo del botón esférico por defecto',
        'id'      => 'color_circulo',
        'type'    => 'colorpicker',
        'default' => '#1A382D',
    ));
    $botones_derechos->add_group_field($right_group, array(
        'name'    => 'Color de Fondo al Expandirse',
        'desc'    => 'Color del fondo de la etiqueta de texto al abrirse',
        'id'      => 'color_bg_expandido',
        'type'    => 'colorpicker',
        'default' => '#ffe82c',
    ));
    $botones_derechos->add_group_field($right_group, array(
        'name'    => 'Color del Texto al Expandirse',
        'desc'    => 'Color del texto al abrirse',
        'id'      => 'color_texto_expandido',
        'type'    => 'colorpicker',
        'default' => '#1A382D',
    ));
}

/**
 * WordPress duplica automáticamente el título del menú padre como título del
 * primer submenú (add_menu_page usa el mismo $menu_title para ambos). Esta
 * corrección restaura "Topbar" como nombre de esa primera pestaña, ahora que
 * el título del menú padre es "Ajustes GanaGana".
 */
add_action('admin_menu', 'gg_fix_topbar_submenu_label', 999);
function gg_fix_topbar_submenu_label() {
    global $submenu;
    if (isset($submenu['gg_topbar'][0][0])) {
        $submenu['gg_topbar'][0][0] = 'Topbar';
    }
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
