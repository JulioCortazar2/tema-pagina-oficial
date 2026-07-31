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

<header class="gg-site-header">
    <!-- =============================================
         BARRA SUPERIOR (VERDE OSCURO #2A5747)
         ============================================= -->
    <div class="gg-topbar">
        <div class="gg-container gg-topbar-inner">
            <div class="gg-topbar-right">
                <?php 
                $topbar_links = gg_get_option('topbar_links');
                
                if (!empty($topbar_links) && is_array($topbar_links)) : 
                    foreach ($topbar_links as $item) :
                        $texto  = !empty($item['texto']) ? esc_html($item['texto']) : '';
                        $url    = !empty($item['url']) ? esc_url($item['url']) : '#';
                        $target = !empty($item['target_blank']) ? '_blank' : '_self';
                        if ($texto) :
                        ?>
                            <a href="<?php echo $url; ?>" target="<?php echo $target; ?>" class="gg-topbar-link">
                                <?php echo $texto; ?>
                            </a>
                        <?php 
                        endif;
                    endforeach;
                else : 
                    // Links de prueba/fallback predeterminados
                ?>
                    <a href="<?php echo esc_url(home_url('/gg-puntos')); ?>" class="gg-topbar-link">GG PUNTOS</a>
                    <a href="<?php echo esc_url(home_url('/red-transaccional')); ?>" class="gg-topbar-link">RED TRANSACCIONAL</a>
                    <a href="<?php echo esc_url(home_url('/noticias')); ?>" class="gg-topbar-link">NOTICIAS</a>
                    <a href="<?php echo esc_url(home_url('/contacto')); ?>" class="gg-topbar-link">CONTACTO</a>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <!-- =============================================
         BARRA DE NAVEGACIÓN (AMARILLA #ffe82c)
         ============================================= -->
    <div class="gg-navbar">
        <div class="gg-container gg-navbar-inner">

            <!-- LOGO (Izquierda) -->
            <?php
            // Lee la URL configurada en Ajustes GanaGana > Header
            // Si está vacía, usa el inicio del sitio como fallback
            $logo_url = gg_get_option('logo_url');
            $logo_href = !empty($logo_url) ? esc_url($logo_url) : esc_url(home_url('/'));
            ?>
            <div class="gg-logo">
                <?php if (has_custom_logo()) : ?>
                    <?php
                    // the_custom_logo() genera su propio <a href="home_url()"> que no se puede
                    // cambiar directamente, así que envolvemos el output con nuestro enlace.
                    $custom_logo_img = get_custom_logo(); // Obtiene el HTML del logo
                    // Reemplaza el href del enlace generado por WordPress con la URL configurada
                    $custom_logo_img = preg_replace(
                        '/href=["\']([^"\']*)["\']/',
                        'href="' . $logo_href . '"',
                        $custom_logo_img,
                        1 // Solo reemplaza el primer <a>
                    );
                    echo $custom_logo_img;
                    ?>
                <?php else : ?>
                    <a href="<?php echo $logo_href; ?>" rel="home">
                        <img src="<?php echo get_template_directory_uri(); ?>/assets/images/logo.png" alt="<?php bloginfo('name'); ?>">
                    </a>
                <?php endif; ?>
            </div>

            <!-- MENÚ PRINCIPAL (Centro) - Usa Walker Mega Menu -->
            <nav class="gg-nav-container" id="gg-site-navigation" aria-label="Menú Principal">
                <?php
                if (has_nav_menu('primary-menu')) {
                    wp_nav_menu(array(
                        'theme_location' => 'primary-menu',
                        'container'      => false,
                        'menu_class'     => 'nav-menu',
                        'depth'          => 3,
                        'walker'         => new GG_Mega_Menu_Walker(),
                    ));
                } else {
                    // Fallback visual con estructura megamenu
                ?>
                    <ul class="nav-menu">
                        <li class="nav-item menu-item-has-children">
                            <a href="#" class="nav-link">JUEGOS <span class="dropdown-arrow">▾</span></a>
                            <div class="megamenu-dropdown">
                                <ul class="megamenu-sections">
                                    <li class="megamenu-section">
                                        <span class="section-title">CHANCES</span>
                                        <ul class="megamenu-links">
                                            <li class="megamenu-link-item"><a href="#">Chance</a></li>
                                            <li class="megamenu-link-item"><a href="#">Chance Mas</a></li>
                                            <li class="megamenu-link-item"><a href="#">Billonario</a></li>
                                            <li class="megamenu-link-item"><a href="#">Triplata</a></li>
                                            <li class="megamenu-link-item"><a href="#">Billetón</a></li>
                                        </ul>
                                    </li>
                                    <li class="megamenu-section">
                                        <span class="section-title">BALOTOS</span>
                                        <ul class="megamenu-links">
                                            <li class="megamenu-link-item"><a href="#">Balotos</a></li>
                                            <li class="megamenu-link-item"><a href="#">Baloto Revancha</a></li>
                                            <li class="megamenu-link-item"><a href="#">MiLoto</a></li>
                                            <li class="megamenu-link-item"><a href="#">Color Loto</a></li>
                                        </ul>
                                    </li>
                                    <li class="megamenu-section">
                                        <span class="section-title">OTROS</span>
                                        <ul class="megamenu-links">
                                            <li class="megamenu-link-item"><a href="#">Raspa &amp; Listo <span class="menu-badge badge-new">NUEVO</span></a></li>
                                            <li class="megamenu-link-item"><a href="#">BetPlay <span class="menu-badge badge-recarga">RECARGA</span></a></li>
                                            <li class="megamenu-link-item"><a href="#">Smanario</a></li>
                                            <li class="megamenu-link-item"><a href="#">KENO <span class="menu-badge badge-new">NUEVO</span></a></li>
                                            <li class="megamenu-link-item"><a href="#">Gordito GanaGana</a></li>
                                        </ul>
                                    </li>
                                </ul>
                            </div>
                        </li>
                        <li class="nav-item"><a href="#" class="nav-link">SERVICIOS <span class="dropdown-arrow">▾</span></a></li>
                        <li class="nav-item"><a href="#" class="nav-link">PROMOCIONES <span class="dropdown-arrow">▾</span></a></li>
                        <li class="nav-item"><a href="#" class="nav-link">RESULTADOS <span class="dropdown-arrow">▾</span></a></li>
                    </ul>
                <?php
                }
                ?>
            </nav>

            <!-- ACCIONES HEADER (Buscador + Botón Promociones - Derecha) -->
            <div class="gg-navbar-actions">

                <!-- Buscador -->
                <div class="gg-search-wrapper">
                    <form role="search" method="get" class="gg-search-form" action="<?php echo esc_url(home_url('/')); ?>">
                        <input type="search" class="gg-search-input" placeholder="Buscar..." value="<?php echo get_search_query(); ?>" name="s" title="Buscar" />
                        <button type="submit" class="gg-search-submit" aria-label="Buscar">
                            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><circle cx="11" cy="11" r="8"></circle><line x1="21" y1="21" x2="16.65" y2="16.65"></line></svg>
                        </button>
                    </form>
                </div>

                <!-- Botón Destacado PROMOCIONES -->
                <?php 
                $btn_promo_texto = gg_get_option('btn_promociones_texto');
                $btn_promo_url   = gg_get_option('btn_promociones_url');
                
                $texto_promo = !empty($btn_promo_texto) ? esc_html($btn_promo_texto) : 'PROMOCIONES';
                $url_promo   = !empty($btn_promo_url) ? esc_url($btn_promo_url) : esc_url(home_url('/promociones'));
                ?>
                <a href="<?php echo $url_promo; ?>" class="gg-btn-promociones">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M20.59 13.41l-7.17 7.17a2 2 0 0 1-2.83 0L2 12V2h10l8.59 8.59a2 2 0 0 1 0 2.82z"></path><line x1="7" y1="7" x2="7.01" y2="7"></line></svg>
                    <span><?php echo $texto_promo; ?></span>
                </a>

                <!-- Botón Hamburguesa Móvil -->
                <button class="gg-mobile-toggle" id="gg-mobile-toggle" aria-label="Abrir menú de navegación">
                    <span class="gg-hamburger-bar"></span>
                    <span class="gg-hamburger-bar"></span>
                    <span class="gg-hamburger-bar"></span>
                </button>

            </div>

        </div>
    </div>
</header>

<main id="gg-main-content" class="gg-main-content">