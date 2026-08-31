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
            'closed'        => true,
        ),
    ));
    $topbar->add_group_field($topbar_group, array(
        'name' => 'Texto',
        'id'   => 'texto',
        'type' => 'text',
    ));
    $topbar->add_group_field($topbar_group, array(
        'name'       => 'PÃ¡gina Interna (Opcional)',
        'id'         => 'pagina_id',
        'type'       => 'select',
        'options_cb' => 'gg_footer_opciones_paginas',
    ));
    $topbar->add_group_field($topbar_group, array(
        'name' => 'URL Externa (Opcional)',
        'desc' => 'Ej: https://www.ejemplo.com (Si colocas una URL aquÃ­, se usarÃ¡ en lugar de la pÃ¡gina de destino)',
        'id'   => 'url',
        'type' => 'text_url',
    ));
    $topbar->add_group_field($topbar_group, array(
        'name' => 'Abrir en nueva pestaÃ±a',
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
        'description' => 'Tiene prioridad sobre la pÃ¡gina seleccionada abajo. Si se deja vacÃ­o, se usa esa pÃ¡gina o (si tampoco hay) el inicio del sitio.',
        'id'          => 'logo_url',
        'type'        => 'text_url',
    ));
    $header_promo->add_field(array(
        'name'       => 'PÃ¡gina Interna del Logo (Opcional)',
        'description'=> 'Alternativa a la URL de arriba. Se usa solo si la URL del Logo estÃ¡ vacÃ­a.',
        'id'         => 'logo_pagina_id',
        'type'       => 'select',
        'options_cb' => 'gg_footer_opciones_paginas',
    ));
    $header_promo->add_field(array(
        'name'    => 'Texto del BotÃ³n del MenÃº',
        'id'      => 'btn_promociones_texto',
        'type'    => 'text',
        'default' => 'PROMOCIONES',
    ));
    $header_promo->add_field(array(
        'name'        => 'URL del BotÃ³n del MenÃº',
        'description' => 'Tiene prioridad sobre la pÃ¡gina seleccionada abajo.',
        'id'          => 'btn_promociones_url',
        'type'        => 'text_url',
    ));
    $header_promo->add_field(array(
        'name'       => 'PÃ¡gina Interna del BotÃ³n del MenÃº (Opcional)',
        'description'=> 'Alternativa a la URL de arriba. Se usa solo si la URL del BotÃ³n estÃ¡ vacÃ­a.',
        'id'         => 'btn_promociones_pagina_id',
        'type'       => 'select',
        'options_cb' => 'gg_footer_opciones_paginas',
    ));
    $header_promo->add_field(array(
        'name'    => 'Mostrar BotÃ³n del MenÃº',
        'desc'    => 'Activa/desactiva la visibilidad del botÃ³n que aparece al lado de la barra de bÃºsqueda.',
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
        'name'       => esc_html__('Altura MÃ¡xima de Logos (px)', 'ganagana'),
        'desc'       => esc_html__('Se reduce automÃ¡ticamente en mÃ³vil.', 'ganagana'),
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
            'closed'        => true,
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
        'name' => esc_html__('Abrir en nueva pestaÃ±a', 'ganagana'),
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
            'group_title'   => 'BotÃ³n #{#}',
            'add_button'    => '+ Agregar BotÃ³n',
            'remove_button' => 'Eliminar BotÃ³n',
            'sortable'      => true,
            'closed'        => true,
        ),
    ));
    $prefooter->add_group_field($prefooter_btns, array(
        'name' => 'Texto del BotÃ³n',
        'id'   => 'texto_boton',
        'type' => 'text',
    ));
    $prefooter->add_group_field($prefooter_btns, array(
        'name'       => 'PÃ¡gina Interna (Opcional)',
        'id'         => 'pagina_id',
        'type'       => 'select',
        'options_cb' => 'gg_footer_opciones_paginas',
    ));
    $prefooter->add_group_field($prefooter_btns, array(
        'name' => 'URL Externa (Opcional)',
        'desc' => 'Ej: https://www.ejemplo.com (Si colocas una URL aquÃ­, se usarÃ¡ en lugar de la pÃ¡gina de destino)',
        'id'   => 'url_boton',
        'type' => 'text_url',
    ));
    $prefooter->add_group_field($prefooter_btns, array(
        'name' => 'Abrir en nueva pestaÃ±a',
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
        'id'   => 'info_principal_heading',
        'type' => 'title',
        'name' => '<div style="background-color: #1A382D; color: #FFFFFF; padding: 12px 15px; margin: 20px 0 15px 0; border-left: 4px solid #FFE82C; font-size: 14px; font-weight: 600;">InformaciÃ³n Principal</div>',
    ));

    $footer->add_field(array(
        'name'    => 'Nombre de la Empresa',
        'id'      => 'footer_empresa_nombre',
        'type'    => 'text',
        'default' => 'GanaGana',
    ));
    $footer->add_field(array(
        'name' => 'DescripciÃ³n de la Empresa',
        'id'   => 'footer_empresa_desc',
        'type' => 'textarea_small',
    ));
    $footer->add_field(array(
        'name' => 'Email de Contacto',
        'id'   => 'footer_empresa_email',
        'type' => 'text_email',
    ));
    $footer->add_field(array(
        'name' => 'TelÃ©fono',
        'id'   => 'footer_empresa_telefono',
        'type' => 'text',
    ));
    $footer->add_field(array(
        'name' => 'UbicaciÃ³n',
        'id'   => 'footer_empresa_ubicacion',
        'type' => 'text',
    ));

    $footer->add_field(array(
        'id'   => 'redes_heading',
        'type' => 'title',
        'name' => '<div style="background-color: #1A382D; color: #FFFFFF; padding: 12px 15px; margin: 20px 0 15px 0; border-left: 4px solid #FFE82C; font-size: 14px; font-weight: 600;">Redes Sociales</div>',
    ));

    $redes_group = $footer->add_field(array(
        'id'          => 'footer_redes_sociales',
        'type'        => 'group',
        'options'     => array(
            'group_title'   => 'Red Social #{#}',
            'add_button'    => '+ Agregar Red Social',
            'remove_button' => 'Eliminar',
            'sortable'      => true,
            'closed'        => true,
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

    $footer->add_field(array(
        'id'   => 'columnas_heading',
        'type' => 'title',
        'name' => '<div style="background-color: #1A382D; color: #FFFFFF; padding: 12px 15px; margin: 20px 0 15px 0; border-left: 4px solid #FFE82C; font-size: 14px; font-weight: 600;">Columnas del Footer</div>',
    ));

    $cols_group = $footer->add_field(array(
        'id'          => 'footer_columnas',
        'type'        => 'group',
        'options'     => array(
            'group_title'   => 'Columna #{#}',
            'add_button'    => '+ Agregar Columna',
            'remove_button' => 'Eliminar Columna',
            'sortable'      => true,
            'closed'        => true,
        ),
    ));
    $footer->add_group_field($cols_group, array(
        'name' => 'TÃ­tulo de la Columna',
        'id'   => 'titulo_columna',
        'type' => 'text',
    ));

    $footer->add_field(array(
        'id'   => 'enlaces_heading',
        'type' => 'title',
        'name' => '<div style="background-color: #1A382D; color: #FFFFFF; padding: 12px 15px; margin: 20px 0 15px 0; border-left: 4px solid #FFE82C; font-size: 14px; font-weight: 600;">VinculaciÃ³n de Enlaces</div>',
    ));

    $enlaces_group = $footer->add_field(array(
        'id'          => 'footer_enlaces',
        'type'        => 'group',
        'options'     => array(
            'group_title'   => 'Enlace #{#}',
            'add_button'    => '+ Agregar Enlace',
            'remove_button' => 'Eliminar Enlace',
            'sortable'      => true,
            'closed'        => true,
        ),
    ));
    $footer->add_group_field($enlaces_group, array(
        'name' => 'Texto del Enlace (Nombre Visible)',
        'id'   => 'texto_enlace',
        'type' => 'text',
    ));
    $footer->add_group_field($enlaces_group, array(
        'name'       => 'PÃ¡gina de Destino',
        'id'         => 'pagina_id',
        'type'       => 'select',
        'options_cb' => 'gg_footer_opciones_paginas',
    ));
    $footer->add_group_field($enlaces_group, array(
        'name' => 'URL Externa (Opcional)',
        'desc' => 'Ej: https://www.ejemplo.com (Si colocas una URL aquÃ­, se usarÃ¡ en lugar de la pÃ¡gina de destino)',
        'id'   => 'url_externa',
        'type' => 'text_url',
    ));
    $footer->add_group_field($enlaces_group, array(
        'name' => 'Abrir en nueva pestaÃ±a',
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
        'name'       => 'Orden de apariciÃ³n',
        'desc'       => 'PosiciÃ³n dentro de su columna (0 = primero, 1 = segundo, etc.)',
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
        'description' => 'Ej: Â© 2026 GanaGana - Todos los derechos reservados.',
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
            'closed'        => true,
        ),
    ));
    $copyright->add_group_field($legal_group, array(
        'name' => 'Texto',
        'id'   => 'texto',
        'type' => 'text',
    ));
    $copyright->add_group_field($legal_group, array(
        'name'       => 'PÃ¡gina de Destino',
        'id'         => 'pagina_id',
        'type'       => 'select',
        'options_cb' => 'gg_footer_opciones_paginas',
    ));
    $copyright->add_group_field($legal_group, array(
        'name' => 'URL',
        'desc' => 'Ej: https://www.ejemplo.com (Si colocas una URL aquÃ­, se usarÃ¡ en lugar de la pÃ¡gina de destino)',
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
            'closed'        => true,
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
        'name'    => 'Abrir en nueva pestaÃ±a',
        'id'      => 'target_blank',
        'type'    => 'checkbox',
        'default' => 'on',
    ));
    $redes_flotantes->add_group_field($flotantes_group, array(
        'name'    => 'Ãcono de la red social',
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
            'otro'      => 'No estÃ¡ la red social',
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
            'group_title'   => 'BotÃ³n Derecho #{#}',
            'add_button'    => '+ Agregar BotÃ³n Derecho',
            'remove_button' => 'Eliminar',
            'sortable'      => true,
            'closed'        => true,
        ),
    ));
    $botones_derechos->add_group_field($right_group, array(
        'name' => 'Texto del BotÃ³n (Visible al Expandir)',
        'id'   => 'texto',
        'type' => 'text',
    ));
    $botones_derechos->add_group_field($right_group, array(
        'name' => 'URL de Destino',
        'id'   => 'url',
        'type' => 'text_url',
    ));
    $botones_derechos->add_group_field($right_group, array(
        'name' => 'Abrir en nueva pestaÃ±a',
        'id'   => 'target_blank',
        'type' => 'checkbox',
    ));
    $botones_derechos->add_group_field($right_group, array(
        'name' => 'Imagen del Ãcono (Esfera)',
        'id'   => 'imagen_icono',
        'type' => 'file',
        'options' => array(
            'url' => false,
        ),
    ));
    $botones_derechos->add_group_field($right_group, array(
        'name'    => 'Color del CÃ­rculo (Esfera)',
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
            'closed'        => true,
        ),
    ));
    $servicios->add_group_field($servicios_group, array(
        'name'       => 'Imagen',
        'desc'       => 'Usa imÃ¡genes con fondo transparente: se muestran tal cual, sin recorte.',
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
        'name'       => 'PÃ¡gina de Destino',
        'id'         => 'pagina_id',
        'type'       => 'select',
        'options_cb' => 'gg_footer_opciones_paginas',
    ));
    $servicios->add_group_field($servicios_group, array(
        'name' => 'URL Externa (Opcional)',
        'desc' => 'Ej: https://www.ejemplo.com (Si colocas una URL aquÃ­, se usarÃ¡ en lugar de la pÃ¡gina de destino)',
        'id'   => 'url_externa',
        'type' => 'text_url',
    ));
    $servicios->add_group_field($servicios_group, array(
        'name'    => 'Abrir en nueva pestaÃ±a',
        'id'      => 'target_blank',
        'type'    => 'checkbox',
        'default' => 'on',
    ));
}

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
        'title'        => 'Cabecera de PÃ¡gina',
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
            'default' => 'Barra verde con tÃ­tulo (predeterminado)',
            'hero'    => 'Imagen de ancho completo con tÃ­tulo',
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
            '200'   => 'PequeÃ±a â€” 200px',
            '350'   => 'Media â€” 350px',
            '500'   => 'Grande â€” 500px',
            '650'   => 'Extra Grande â€” 650px',
            '100vh' => 'Pantalla completa',
        ),
    ));

    $cmb->add_field(array(
        'name'    => 'PosiciÃ³n de imagen',
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
        'name'            => 'Mostrar tÃ­tulo',
        'id'              => 'page_header_show_title',
        'type'            => 'checkbox',
        'default'         => 'on',
        'sanitization_cb' => function ($value) {
            return $value === 'on' ? 'on' : 'off';
        },
    ));

    $cmb->add_field(array(
        'name'    => 'Color del tÃ­tulo',
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
