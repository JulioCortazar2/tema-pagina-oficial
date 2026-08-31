<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<?php wp_body_open(); ?>

<a class="skip-link" href="#gg-main-content">Saltar al contenido</a>

<header class="gg-site-header">
    <div class="gg-topbar">
        <div class="gg-container gg-topbar-inner">
            <div class="gg-topbar-right">
                <?php 
                $topbar_links = gg_get_option('topbar_links');
                
                if (!empty($topbar_links) && is_array($topbar_links)) :
                    foreach ($topbar_links as $item) :
                        $texto     = !empty($item['texto']) ? esc_html($item['texto']) : '';
                        $url_raw   = !empty($item['url']) ? trim($item['url']) : '';
                        $pagina_id = !empty($item['pagina_id']) ? absint($item['pagina_id']) : 0;

                        $url = '';
                        if (!empty($url_raw)) {
                            $url = esc_url($url_raw);
                        } elseif ($pagina_id > 0) {
                            $permalink = get_permalink($pagina_id);
                            if ($permalink && !is_wp_error($permalink)) {
                                $url = esc_url($permalink);
                            }
                        }

                        $target = !empty($item['target_blank']) ? '_blank' : '_self';
                        if ($texto && $url) :
                        ?>
                            <a href="<?php echo $url; ?>" target="<?php echo $target; ?>" class="gg-topbar-link">
                                <?php echo $texto; ?>
                            </a>
                        <?php
                        endif;
                    endforeach;
                endif;
                ?>
            </div>
        </div>
    </div>

    <div class="gg-navbar">
        <div class="gg-container gg-navbar-inner">

            <?php
            $logo_url       = gg_get_option('logo_url');
            $logo_pagina_id = absint(gg_get_option('logo_pagina_id'));

            $logo_href = '';
            if (!empty($logo_url)) {
                $logo_href = esc_url($logo_url);
            } elseif ($logo_pagina_id > 0) {
                $logo_permalink = get_permalink($logo_pagina_id);
                if ($logo_permalink && !is_wp_error($logo_permalink)) {
                    $logo_href = esc_url($logo_permalink);
                }
            }
            if (empty($logo_href)) {
                $logo_href = esc_url(home_url('/'));
            }
            ?>
            <div class="gg-logo">
                <?php if (has_custom_logo()) : ?>
                    <?php
                    $custom_logo_img = get_custom_logo();
                    $custom_logo_img = preg_replace(
                        '/href=["\']([^"\']*)["\']/',
                        'href="' . $logo_href . '"',
                        $custom_logo_img,
                        1
                    );
                    echo $custom_logo_img;
                    ?>
                <?php else : ?>
                    <a href="<?php echo $logo_href; ?>" rel="home">
                        <img src="<?php echo get_template_directory_uri(); ?>/assets/images/logo.png" alt="<?php bloginfo('name'); ?>">
                    </a>
                <?php endif; ?>
            </div>

            <nav class="gg-nav-container" id="gg-site-navigation" aria-label="MenÃº Principal">
                <?php
                if (has_nav_menu('primary-menu')) {
                    wp_nav_menu(array(
                        'theme_location' => 'primary-menu',
                        'container'      => false,
                        'menu_class'     => 'nav-menu',
                        'depth'          => 3,
                        'walker'         => new GG_Mega_Menu_Walker(),
                    ));
                }
                ?>
            </nav>

            <div class="gg-navbar-actions">
                <div class="gg-search-wrapper">
                    <form role="search" method="get" class="gg-search-form" action="<?php echo esc_url(home_url('/')); ?>">
                        <input type="search" class="gg-search-input" placeholder="Buscar..." value="<?php echo get_search_query(); ?>" name="s" title="Buscar" />
                        <button type="submit" class="gg-search-submit" aria-label="Buscar">
                            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><circle cx="11" cy="11" r="8"></circle><line x1="21" y1="21" x2="16.65" y2="16.65"></line></svg>
                        </button>
                    </form>
                </div>

                <?php
                $mostrar_btn_menu = gg_get_option('mostrar_btn_menu');
                if ($mostrar_btn_menu === 'on') {
                    $btn_promo_texto     = gg_get_option('btn_promociones_texto');
                    $btn_promo_url       = gg_get_option('btn_promociones_url');
                    $btn_promo_pagina_id = absint(gg_get_option('btn_promociones_pagina_id'));

                    $texto_promo = !empty($btn_promo_texto) ? esc_html($btn_promo_texto) : 'PROMOCIONES';

                    $url_promo = '';
                    if (!empty($btn_promo_url)) {
                        $url_promo = esc_url($btn_promo_url);
                    } elseif ($btn_promo_pagina_id > 0) {
                        $promo_permalink = get_permalink($btn_promo_pagina_id);
                        if ($promo_permalink && !is_wp_error($promo_permalink)) {
                            $url_promo = esc_url($promo_permalink);
                        }
                    }
                    if (empty($url_promo)) {
                        $url_promo = esc_url(home_url('/promociones'));
                    }
                    ?>
                    <a href="<?php echo $url_promo; ?>" class="gg-btn-promociones">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M20.59 13.41l-7.17 7.17a2 2 0 0 1-2.83 0L2 12V2h10l8.59 8.59a2 2 0 0 1 0 2.82z"></path><line x1="7" y1="7" x2="7.01" y2="7"></line></svg>
                        <span><?php echo $texto_promo; ?></span>
                    </a>
                    <?php
                }
                ?>

                <button class="gg-mobile-toggle" id="gg-mobile-toggle" aria-label="Abrir menÃº de navegaciÃ³n">
                    <span class="gg-hamburger-bar"></span>
                    <span class="gg-hamburger-bar"></span>
                    <span class="gg-hamburger-bar"></span>
                </button>
            </div>

        </div>
    </div>
</header>

<?php do_action( 'gg_antes_del_contenido_principal' ); ?>

<main id="gg-main-content" class="gg-main-content">
