<?php
if (!defined('ABSPATH')) {
    exit;
}

add_action('cmb2_admin_init', 'gg_register_theme_options');
function gg_register_theme_options() {
    if (!function_exists('new_cmb2_box')) {
        return;
    }

    $topbar = new_cmb2_box(array(
        'id'           => 'gg_topbar_options',
        'title'        => 'Barra Superior (Topbar Verde)',
        'object_types' => array('options-page'),
        'option_key'   => 'gg_topbar',
        'menu_title'   => 'Ajustes GanaGana',
        'page_title'   => 'Ajustes del Tema GanaGana',
        'icon_url'     => 'dashicons-admin-generic',
        'position'     => 60,
        'capability'   => 'gg_manage_theme_options',
    ));

    $topbar_group = $topbar->add_field(array(
        'id'          => 'topbar_links',
        'type'        => 'group',
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
        'name'       => 'Página Interna (Opcional)',
        'id'         => 'pagina_id',
        'type'       => 'select',
        'options_cb' => 'gg_footer_opciones_paginas',
    ));
    $topbar->add_group_field($topbar_group, array(
        'name' => 'URL Externa (Opcional)',
        'desc' => 'Ej: https://www.ejemplo.com (Si colocas una URL aquí, se usará en lugar de la página de destino)',
        'id'   => 'url',
        'type' => 'text_url',
    ));
    $topbar->add_group_field($topbar_group, array(
        'name' => 'Abrir en nueva pestaña',
        'id'   => 'target_blank',
        'type' => 'checkbox',
    ));

    $header_promo = new_cmb2_box(array(
        'id'           => 'gg_header_promo_options',
        'title'        => 'Opciones Menu Principal',
        'object_types' => array('options-page'),
        'option_key'   => 'gg_header_promo',
        'parent_slug'  => 'gg_topbar',
        'tab_title'    => 'Opciones Menu Principal',
        'capability'   => 'gg_manage_theme_options',
    ));
    $header_promo->add_field(array(
        'name'        => 'URL del Logo (al hacer clic)',
        'description' => 'Tiene prioridad sobre la página seleccionada abajo. Si se deja vacío, se usa esa página o (si tampoco hay) el inicio del sitio.',
        'id'          => 'logo_url',
        'type'        => 'text_url',
    ));
    $header_promo->add_field(array(
        'name'       => 'Página Interna del Logo (Opcional)',
        'description'=> 'Alternativa a la URL de arriba. Se usa solo si la URL del Logo está vacía.',
        'id'         => 'logo_pagina_id',
        'type'       => 'select',
        'options_cb' => 'gg_footer_opciones_paginas',
    ));
    $header_promo->add_field(array(
        'name'    => 'Texto del Botón del Menú',
        'id'      => 'btn_promociones_texto',
        'type'    => 'text',
        'default' => 'PROMOCIONES',
    ));
    $header_promo->add_field(array(
        'name'        => 'URL del Botón del Menú',
        'description' => 'Tiene prioridad sobre la página seleccionada abajo.',
        'id'          => 'btn_promociones_url',
        'type'        => 'text_url',
    ));
    $header_promo->add_field(array(
        'name'       => 'Página Interna del Botón del Menú (Opcional)',
        'description'=> 'Alternativa a la URL de arriba. Se usa solo si la URL del Botón está vacía.',
        'id'         => 'btn_promociones_pagina_id',
        'type'       => 'select',
        'options_cb' => 'gg_footer_opciones_paginas',
    ));
    $header_promo->add_field(array(
        'name'    => 'Mostrar Botón del Menú',
        'desc'    => 'Activa/desactiva la visibilidad del botón que aparece al lado de la barra de búsqueda.',
        'id'      => 'mostrar_btn_menu',
        'type'    => 'checkbox',
        'default' => 'on',
    ));

    $img_final = new_cmb2_box(array(
        'id'           => 'gg_img_final_pagina_options',
        'title'        => 'Imagenes Relacionadas',
        'object_types' => array('options-page'),
        'option_key'   => 'gg_img_final_pagina',
        'parent_slug'  => 'gg_topbar',
        'menu_title'   => 'Imagenes Relacionadas',
        'tab_title'    => 'Imagenes Relacionadas',
        'capability'   => 'gg_manage_theme_options',
    ));
    $img_final->add_field(array(
        'name'       => esc_html__('Altura Máxima de Logos (px)', 'ganagana'),
        'desc'       => esc_html__('Se reduce automáticamente en móvil.', 'ganagana'),
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
        'options'     => array(
            'group_title'   => esc_html__('Logo #{#}', 'ganagana'),
            'add_button'    => esc_html__('+ Agregar Logo', 'ganagana'),
            'remove_button' => esc_html__('Eliminar Logo', 'ganagana'),
            'sortable'      => true,
        ),
    ));
    $img_final->add_group_field($logos_group, array(
        'name'       => esc_html__('Imagen del Logo', 'ganagana'),
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
        'id'   => 'alt',
        'type' => 'text',
    ));
    $img_final->add_group_field($logos_group, array(
        'name' => esc_html__('URL de Destino (Opcional)', 'ganagana'),
        'id'   => 'url',
        'type' => 'text_url',
    ));
    $img_final->add_group_field($logos_group, array(
        'name' => esc_html__('Abrir en nueva pestaña', 'ganagana'),
        'id'   => 'target_blank',
        'type' => 'checkbox',
    ));

    $prefooter = new_cmb2_box(array(
        'id'           => 'gg_prefooter_options',
        'title'        => 'Barra Pre-Footer',
        'object_types' => array('options-page'),
        'option_key'   => 'gg_prefooter',
        'parent_slug'  => 'gg_topbar',
        'tab_title'    => 'Pre-Footer',
        'capability'   => 'gg_manage_theme_options',
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
        'name'       => 'Página Interna (Opcional)',
        'id'         => 'pagina_id',
        'type'       => 'select',
        'options_cb' => 'gg_footer_opciones_paginas',
    ));
    $prefooter->add_group_field($prefooter_btns, array(
        'name' => 'URL Externa (Opcional)',
        'desc' => 'Ej: https://www.ejemplo.com (Si colocas una URL aquí, se usará en lugar de la página de destino)',
        'id'   => 'url_boton',
        'type' => 'text_url',
    ));
    $prefooter->add_group_field($prefooter_btns, array(
        'name' => 'Abrir en nueva pestaña',
        'id'   => 'target_blank',
        'type' => 'checkbox',
    ));

    $footer = new_cmb2_box(array(
        'id'           => 'gg_footer_options',
        'title'        => 'Footer Principal',
        'object_types' => array('options-page'),
        'option_key'   => 'gg_footer',
        'parent_slug'  => 'gg_topbar',
        'tab_title'    => 'Footer',
        'capability'   => 'gg_manage_theme_options',
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

    $enlaces_group = $footer->add_field(array(
        'id'          => 'footer_enlaces',
        'type'        => 'group',
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

    $copyright = new_cmb2_box(array(
        'id'           => 'gg_copyright_options',
        'title'        => 'Barra Copyright',
        'object_types' => array('options-page'),
        'option_key'   => 'gg_copyright',
        'parent_slug'  => 'gg_topbar',
        'tab_title'    => 'Copyright',
        'capability'   => 'gg_manage_theme_options',
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

    $redes_flotantes = new_cmb2_box(array(
        'id'           => 'gg_redes_flotantes_options',
        'title'        => 'Redes Sociales',
        'object_types' => array('options-page'),
        'option_key'   => 'gg_redes_flotantes',
        'parent_slug'  => 'gg_topbar',
        'tab_title'    => 'Redes Sociales',
        'capability'   => 'gg_manage_theme_options',
    ));

    $flotantes_group = $redes_flotantes->add_field(array(
        'id'          => 'redes_flotantes_items',
        'type'        => 'group',
        'options'     => array(
            'group_title'   => 'Red Social #{#}',
            'add_button'    => '+ Agregar Red Social',
            'remove_button' => 'Eliminar',
            'sortable'      => true,
        ),
    ));
    $redes_flotantes->add_group_field($flotantes_group, array(
        'name' => 'Nombre de la red social',
        'id'   => 'nombre_red',
        'type' => 'text',
    ));
    $redes_flotantes->add_group_field($flotantes_group, array(
        'name' => 'Link a la red social',
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

    $botones_derechos = new_cmb2_box(array(
        'id'           => 'gg_botones_derechos_options',
        'title'        => 'Botones Flotantes Derechos',
        'object_types' => array('options-page'),
        'option_key'   => 'gg_botones_derechos',
        'parent_slug'  => 'gg_topbar',
        'tab_title'    => 'Botones Derechos',
        'capability'   => 'gg_manage_theme_options',
    ));

    $right_group = $botones_derechos->add_field(array(
        'id'          => 'botones_derechos_items',
        'type'        => 'group',
        'options'     => array(
            'group_title'   => 'Botón Derecho #{#}',
            'add_button'    => '+ Agregar Botón Derecho',
            'remove_button' => 'Eliminar',
            'sortable'      => true,
        ),
    ));
    $botones_derechos->add_group_field($right_group, array(
        'name' => 'Texto del Botón (Visible al Expandir)',
        'id'   => 'texto',
        'type' => 'text',
    ));
    $botones_derechos->add_group_field($right_group, array(
        'name' => 'URL de Destino',
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
        'id'   => 'imagen_icono',
        'type' => 'file',
        'options' => array(
            'url' => false,
        ),
    ));
    $botones_derechos->add_group_field($right_group, array(
        'name'    => 'Color del Círculo (Esfera)',
        'id'      => 'color_circulo',
        'type'    => 'colorpicker',
        'default' => '#1A382D',
    ));
    $botones_derechos->add_group_field($right_group, array(
        'name'    => 'Color de Fondo al Expandirse',
        'id'      => 'color_bg_expandido',
        'type'    => 'colorpicker',
        'default' => '#ffe82c',
    ));
    $botones_derechos->add_group_field($right_group, array(
        'name'    => 'Color del Texto al Expandirse',
        'id'      => 'color_texto_expandido',
        'type'    => 'colorpicker',
        'default' => '#1A382D',
    ));

    $servicios = new_cmb2_box(array(
        'id'           => 'gg_servicios_options',
        'title'        => 'Servicios (Carrusel de Iconos)',
        'object_types' => array('options-page'),
        'option_key'   => 'gg_servicios',
        'parent_slug'  => 'gg_topbar',
        'tab_title'    => 'Servicios',
        'capability'   => 'gg_manage_theme_options',
    ));

    $servicios_group = $servicios->add_field(array(
        'id'          => 'servicios_items',
        'type'        => 'group',
        'options'     => array(
            'group_title'   => 'Servicio #{#}',
            'add_button'    => '+ Agregar Servicio',
            'remove_button' => 'Eliminar Servicio',
            'sortable'      => true,
        ),
    ));
    $servicios->add_group_field($servicios_group, array(
        'name'       => 'Imagen',
        'desc'       => 'Usa imágenes con fondo transparente: se muestran tal cual, sin recorte.',
        'id'         => 'imagen',
        'type'       => 'file',
        'options'    => array(
            'url' => false,
        ),
        'query_args' => array(
            'type' => 'image',
        ),
    ));
    $servicios->add_group_field($servicios_group, array(
        'name' => 'Texto Alternativo (Alt)',
        'id'   => 'alt',
        'type' => 'text',
    ));
    $servicios->add_group_field($servicios_group, array(
        'name'       => 'Página de Destino',
        'id'         => 'pagina_id',
        'type'       => 'select',
        'options_cb' => 'gg_footer_opciones_paginas',
    ));
    $servicios->add_group_field($servicios_group, array(
        'name' => 'URL Externa (Opcional)',
        'desc' => 'Ej: https://www.ejemplo.com (Si colocas una URL aquí, se usará en lugar de la página de destino)',
        'id'   => 'url_externa',
        'type' => 'text_url',
    ));
    $servicios->add_group_field($servicios_group, array(
        'name'    => 'Abrir en nueva pestaña',
        'id'      => 'target_blank',
        'type'    => 'checkbox',
        'default' => 'on',
    ));
}

/**
 * WordPress duplica el título del menú padre como título del primer submenú
 * (add_menu_page reutiliza el mismo $menu_title para ambos); esto restaura
 * "Topbar" en esa pestaña.
 */
add_action('admin_menu', 'gg_fix_topbar_submenu_label', 999);
function gg_fix_topbar_submenu_label() {
    global $submenu;
    if (isset($submenu['gg_topbar'][0][0])) {
        $submenu['gg_topbar'][0][0] = 'Topbar';
    }
}

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
        'name'            => 'Mostrar título',
        'id'              => 'page_header_show_title',
        'type'            => 'checkbox',
        'default'         => 'on',
        // CMB2 borra el meta al desmarcar un checkbox en vez de guardar 'off',
        // lo que impedía distinguir "desmarcado" de "nunca guardado" (ambos
        // devolvían '' en get_post_meta y siempre se mostraba el título).
        'sanitization_cb' => function ($value) {
            return $value === 'on' ? 'on' : 'off';
        },
    ));

    $cmb->add_field(array(
        'name'    => 'Color del título',
        'id'      => 'page_header_title_color',
        'type'    => 'colorpicker',
        'default' => '#FFFFFF',
    ));

    $cmb->add_field(array(
        'name'            => 'Capa oscura (overlay)',
        'id'              => 'page_header_overlay',
        'type'            => 'checkbox',
        'default'         => 'on',
        'sanitization_cb' => function ($value) {
            return $value === 'on' ? 'on' : 'off';
        },
    ));

    $cmb->add_field(array(
        'id'   => 'page_header_preview_notice',
        'type' => 'title',
        'name' => '<div id="gg-ph-preview-wrap"></div>',
    ));
}
