<?php
/**
 * Tema GanaGana Custom - footer.php
 */
?>
    </main><!-- #gg-main-content -->

    <footer class="gg-site-footer">

        <!-- =============================================
             SECCIÓN 1: BARRA PRE-FOOTER (Verde con Botones Amarillos)
             ============================================= -->
        <div class="gg-prefooter">
            <div class="gg-container gg-prefooter-inner">

                <!-- Ícono Compartir / Atención Izquierda -->
                <div class="gg-prefooter-icon">
                    <svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <circle cx="18" cy="5" r="3"></circle>
                        <circle cx="6" cy="12" r="3"></circle>
                        <circle cx="18" cy="19" r="3"></circle>
                        <line x1="8.59" y1="13.51" x2="15.42" y2="17.49"></line>
                        <line x1="15.41" y1="6.51" x2="8.59" y2="10.49"></line>
                    </svg>
                </div>

                <!-- Texto Central -->
                <div class="gg-prefooter-text">
                    <?php 
                    $prefooter_texto = gg_get_option('prefooter_texto');
                    echo !empty($prefooter_texto) ? esc_html($prefooter_texto) : 'PAGO DE PREMIOS Y SERVICIOS TRADICIONALES';
                    ?>
                </div>

                <!-- Botones Amarillos -->
                <div class="gg-prefooter-buttons">
                    <?php 
                    $prefooter_botones = gg_get_option('prefooter_botones');
                    if (!empty($prefooter_botones) && is_array($prefooter_botones)) :
                        foreach ($prefooter_botones as $btn) :
                            $texto  = !empty($btn['texto_boton']) ? esc_html($btn['texto_boton']) : '';
                            $url    = !empty($btn['url_boton']) ? esc_url($btn['url_boton']) : '#';
                            $target = !empty($btn['target_blank']) ? '_blank' : '_self';
                            if ($texto) :
                            ?>
                                <a href="<?php echo $url; ?>" target="<?php echo $target; ?>" class="gg-btn-yellow">
                                    <?php echo $texto; ?>
                                </a>
                            <?php 
                            endif;
                        endforeach;
                    else : 
                        // Fallback predeterminado
                    ?>
                        <a href="<?php echo esc_url(home_url('/puntos-de-venta')); ?>" class="gg-btn-yellow">PUNTOS DE VENTA</a>
                        <a href="<?php echo esc_url(home_url('/consultar-ganadores')); ?>" class="gg-btn-yellow">CONSULTAR GANADORES</a>
                    <?php endif; ?>
                </div>

            </div>
        </div>

        <!-- =============================================
             SECCIÓN 2: FOOTER PRINCIPAL (Verde Oscuro #1A382D, 4 Columnas)
             ============================================= -->
        <div class="gg-footer-main">
            <div class="gg-container gg-footer-grid">

                <!-- Columna 1: Info Empresa y Redes Sociales -->
                <div class="gg-footer-col gg-footer-col-company">
                    <?php 
                    $empresa_nombre    = gg_get_option('footer_empresa_nombre');
                    $empresa_desc      = gg_get_option('footer_empresa_desc');
                    $empresa_email     = gg_get_option('footer_empresa_email');
                    $empresa_telefono  = gg_get_option('footer_empresa_telefono');
                    $empresa_ubicacion = gg_get_option('footer_empresa_ubicacion');
                    ?>
                    
                    <h3 class="gg-footer-title">
                        <?php echo !empty($empresa_nombre) ? esc_html($empresa_nombre) : 'GanaGana'; ?>
                    </h3>
                    <p class="gg-footer-desc">
                        <?php echo !empty($empresa_desc) ? esc_html($empresa_desc) : 'La red multiservicios de los tolimenses. Conectando a nuestra región con servicios de calidad y confianza.'; ?>
                    </p>

                    <ul class="gg-footer-contact-list">
                        <li>
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07A19.5 19.5 0 0 1 4.69 12 19.79 19.79 0 0 1 1.61 3.4 2 2 0 0 1 3.6 1.22h3a2 2 0 0 1 2 1.72c.127.96.361 1.903.7 2.81a2 2 0 0 1-.45 2.11L7.91 8.78a16 16 0 0 0 6.29 6.29l.98-.98a2 2 0 0 1 2.11-.45c.907.339 1.85.573 2.81.7A2 2 0 0 1 22 16.92z"/></svg>
                            <a href="tel:<?php echo esc_attr(!empty($empresa_telefono) ? $empresa_telefono : '+5782610014'); ?>">
                                <?php echo !empty($empresa_telefono) ? esc_html($empresa_telefono) : '+57 (8) 261 0014'; ?>
                            </a>
                        </li>
                        <li>
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"/><polyline points="22,6 12,13 2,6"/></svg>
                            <a href="mailto:<?php echo esc_attr(!empty($empresa_email) ? $empresa_email : 'servicio.alcliente@ganagana.com.co'); ?>">
                                <?php echo !empty($empresa_email) ? esc_html($empresa_email) : 'servicio.alcliente@ganagana.com.co'; ?>
                            </a>
                        </li>
                        <li>
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"/><circle cx="12" cy="10" r="3"/></svg>
                            <span><?php echo !empty($empresa_ubicacion) ? esc_html($empresa_ubicacion) : 'Ibagué, Tolima - Colombia'; ?></span>
                        </li>
                    </ul>

                    <!-- Redes Sociales — SVG Inline Map -->
                    <?php
                    /**
                     * Mapa de íconos SVG por red social.
                     * Clave: nombre en minúsculas que escribe el admin en el formulario.
                     * Valor: SVG inline listo para usar.
                     * Para agregar una red nueva: añade su clave y SVG aquí.
                     */
                    function gg_get_social_svg($nombre) {
                        $iconos = array(

                            'facebook' => '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" width="20" height="20"><path d="M22 12c0-5.523-4.477-10-10-10S2 6.477 2 12c0 4.991 3.657 9.128 8.438 9.878v-6.987H7.898V12h2.54V9.797c0-2.506 1.492-3.89 3.777-3.89 1.094 0 2.238.195 2.238.195v2.46h-1.26c-1.243 0-1.63.771-1.63 1.562V12h2.773l-.443 2.89h-2.33v6.988C18.343 21.128 22 16.991 22 12z"/></svg>',

                            'instagram' => '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" width="20" height="20"><path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zM12 0C8.741 0 8.333.014 7.053.072 2.695.272.273 2.69.073 7.052.014 8.333 0 8.741 0 12c0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98C8.333 23.986 8.741 24 12 24c3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98C15.668.014 15.259 0 12 0zm0 5.838a6.162 6.162 0 100 12.324 6.162 6.162 0 000-12.324zM12 16a4 4 0 110-8 4 4 0 010 8zm6.406-11.845a1.44 1.44 0 100 2.881 1.44 1.44 0 000-2.881z"/></svg>',

                            'youtube' => '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" width="20" height="20"><path d="M23.498 6.186a3.016 3.016 0 00-2.122-2.136C19.505 3.545 12 3.545 12 3.545s-7.505 0-9.377.505A3.017 3.017 0 00.502 6.186C0 8.07 0 12 0 12s0 3.93.502 5.814a3.016 3.016 0 002.122 2.136c1.871.505 9.376.505 9.376.505s7.505 0 9.377-.505a3.015 3.015 0 002.122-2.136C24 15.93 24 12 24 12s0-3.93-.502-5.814zM9.545 15.568V8.432L15.818 12l-6.273 3.568z"/></svg>',

                            'twitter' => '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" width="20" height="20"><path d="M18.244 2.25h3.308l-7.227 8.26 8.502 11.24H16.17l-5.214-6.817L4.99 21.75H1.68l7.73-8.835L1.254 2.25H8.08l4.713 6.231zm-1.161 17.52h1.833L7.084 4.126H5.117z"/></svg>',

                            'x' => '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" width="20" height="20"><path d="M18.244 2.25h3.308l-7.227 8.26 8.502 11.24H16.17l-5.214-6.817L4.99 21.75H1.68l7.73-8.835L1.254 2.25H8.08l4.713 6.231zm-1.161 17.52h1.833L7.084 4.126H5.117z"/></svg>',

                            'threads' => '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 192 192" fill="currentColor" width="20" height="20"><path d="M141.537 88.988a66.667 66.667 0 00-2.518-1.143c-1.482-27.307-16.403-42.94-41.457-43.1h-.34c-14.986 0-27.449 6.396-35.12 18.036l13.779 9.452c5.73-8.695 14.724-10.548 21.348-10.548h.23c8.248.054 14.474 2.452 18.502 7.13 2.932 3.405 4.893 8.11 5.864 14.05-7.314-1.244-15.224-1.626-23.68-1.14-23.82 1.371-39.134 15.264-38.105 34.568.522 9.792 5.4 18.216 13.735 23.719 7.047 4.652 16.124 6.927 25.557 6.412 12.458-.683 22.231-5.436 29.049-14.127 5.178-6.6 8.453-15.153 9.899-25.93 5.937 3.583 10.337 8.298 12.767 13.966 4.132 9.635 4.373 25.468-8.546 38.376-11.319 11.308-24.925 16.2-45.488 16.351-22.809-.169-40.06-7.484-51.275-21.742C35.236 139.966 29.808 120.682 29.605 96c.203-24.682 5.63-43.966 16.133-57.317C57.053 24.425 74.303 17.11 97.112 16.94c22.975.17 40.526 7.52 52.171 21.847 5.71 7.026 10.015 15.86 12.853 26.162l16.147-4.308c-3.44-12.68-8.853-23.606-16.219-32.668C147.036 9.607 125.202.195 97.27 0h-.406C69.019.195 47.355 9.65 32.endXml 27.989 18.31 44.974 10.994 68.853 10.752 96.002c.243 27.15 7.558 51.027 21.235 69.003 14.601 19.103 36.265 28.56 64.416 28.76h.407c24.567-.18 41.854-6.609 56.077-20.826 19.163-19.141 18.568-42.94 12.268-57.602-4.484-10.454-13.033-18.945-24.866-24.349zM96.35 151.095c-9.196.5-18.775-1.58-25.488-5.658-5.072-3.148-7.764-7.542-8.011-12.964-.418-9.862 7.164-19.668 29.081-20.948 2.546-.147 5.035-.218 7.47-.218 5.693 0 11.045.502 15.938 1.485-1.814 22.542-10.021 37.744-19.99 38.303z"/></svg>',

                            'tiktok' => '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" width="20" height="20"><path d="M19.59 6.69a4.83 4.83 0 01-3.77-4.25V2h-3.45v13.67a2.89 2.89 0 01-2.88 2.5 2.89 2.89 0 01-2.89-2.89 2.89 2.89 0 012.89-2.89c.28 0 .54.04.79.1V9.01a6.33 6.33 0 00-.79-.05 6.34 6.34 0 00-6.34 6.34 6.34 6.34 0 006.34 6.34 6.34 6.34 0 006.33-6.34V8.69a8.18 8.18 0 004.78 1.52V6.75a4.85 4.85 0 01-1.01-.06z"/></svg>',

                            'linkedin' => '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" width="20" height="20"><path d="M20.447 20.452h-3.554v-5.569c0-1.328-.027-3.037-1.852-3.037-1.853 0-2.136 1.445-2.136 2.939v5.667H9.351V9h3.414v1.561h.046c.477-.9 1.637-1.85 3.37-1.85 3.601 0 4.267 2.37 4.267 5.455v6.286zM5.337 7.433a2.062 2.062 0 01-2.063-2.065 2.064 2.064 0 112.063 2.065zm1.782 13.019H3.555V9h3.564v11.452zM22.225 0H1.771C.792 0 0 .774 0 1.729v20.542C0 23.227.792 24 1.771 24h20.451C23.2 24 24 23.227 24 22.271V1.729C24 .774 23.2 0 22.222 0h.003z"/></svg>',

                            'whatsapp' => '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" width="20" height="20"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/></svg>',
                        );

                        // Si el nombre existe en el mapa, devuelve el SVG
                        if (isset($iconos[$nombre])) {
                            return $iconos[$nombre];
                        }

                        // Fallback: muestra las 2 primeras letras en mayúsculas
                        return '<span style="font-size:0.7rem;font-weight:800;line-height:1;">' . esc_html(strtoupper(substr($nombre, 0, 2))) . '</span>';
                    }
                    ?>

                    <!-- Redes Sociales -->
                    <div class="gg-footer-socials">
                        <?php 
                        $redes_sociales = gg_get_option('footer_redes_sociales');
                        if (!empty($redes_sociales) && is_array($redes_sociales)) :
                            foreach ($redes_sociales as $social) :
                                $nombre = !empty($social['red_social']) ? strtolower(trim($social['red_social'])) : '';
                                $url    = !empty($social['url_red']) ? esc_url($social['url_red']) : '#';
                                if (!$nombre) continue;
                                ?>
                                <a href="<?php echo $url; ?>" target="_blank" rel="noopener noreferrer"
                                   aria-label="<?php echo esc_attr(ucfirst($nombre)); ?>"
                                   class="gg-social-icon gg-social-<?php echo esc_attr($nombre); ?>">
                                    <?php echo gg_get_social_svg($nombre); ?>
                                </a>
                                <?php
                            endforeach;
                        else :
                            // Fallback hardcodeado
                        ?>
                            <a href="https://www.facebook.com/ganaganaoficial/" target="_blank" rel="noopener noreferrer" aria-label="Facebook" class="gg-social-icon gg-social-facebook"><?php echo gg_get_social_svg('facebook'); ?></a>
                            <a href="https://twitter.com/ganaganaoficial/" target="_blank" rel="noopener noreferrer" aria-label="Twitter" class="gg-social-icon gg-social-twitter"><?php echo gg_get_social_svg('twitter'); ?></a>
                            <a href="https://www.instagram.com/ganaganaoficial/" target="_blank" rel="noopener noreferrer" aria-label="Instagram" class="gg-social-icon gg-social-instagram"><?php echo gg_get_social_svg('instagram'); ?></a>
                            <a href="https://www.youtube.com/channel/UCGPe6UsUNlFxMSb6GSKTx4g" target="_blank" rel="noopener noreferrer" aria-label="YouTube" class="gg-social-icon gg-social-youtube"><?php echo gg_get_social_svg('youtube'); ?></a>
                        <?php endif; ?>
                    </div>
                </div>

                <!-- Columnas Dinámicas del Footer (CMB2 Repeater v2) -->
                <?php 
                $footer_columnas = gg_get_option('footer_columnas');
                
                if (!empty($footer_columnas) && is_array($footer_columnas)) :
                    foreach ($footer_columnas as $col) :
                        $col_titulo  = !empty($col['titulo_columna']) ? esc_html($col['titulo_columna']) : 'Sección';
                        $col_slug    = gg_get_columna_slug($col_titulo);
                        // CMB2: parser v2 soporta "Texto | slug | id" y fallback "Texto | URL"
                        $col_enlaces = !empty($col['enlaces_raw']) ? gg_parse_enlaces_raw_v2($col['enlaces_raw'], $col_slug) : array();
                        ?>
                        <div class="gg-footer-col">
                            <h4 class="gg-footer-title"><?php echo $col_titulo; ?></h4>
                            <ul class="gg-footer-links">
                                <?php foreach ($col_enlaces as $link) : 
                                    $link_texto = !empty($link['texto']) ? esc_html($link['texto']) : '';
                                    $link_url   = !empty($link['url']) ? esc_url($link['url']) : '#';
                                    if ($link_texto) :
                                ?>
                                    <li><a href="<?php echo $link_url; ?>"><?php echo $link_texto; ?></a></li>
                                <?php 
                                    endif;
                                endforeach; ?>
                            </ul>
                        </div>
                        <?php
                    endforeach;
                else : 
                    // Fallback predeterminado de 3 columnas
                ?>
                    <div class="gg-footer-col">
                        <h4 class="gg-footer-title">NUESTROS PRODUCTOS</h4>
                        <ul class="gg-footer-links">
                            <li><a href="#">Chance Tradicional</a></li>
                            <li><a href="#">Super Chance</a></li>
                            <li><a href="#">Baloto & Revancha</a></li>
                            <li><a href="#">Loterías de Colombia</a></li>
                            <li><a href="#">Giros Nacionales</a></li>
                        </ul>
                    </div>

                    <div class="gg-footer-col">
                        <h4 class="gg-footer-title">ATENCIÓN AL CLIENTE</h4>
                        <ul class="gg-footer-links">
                            <li><a href="#">Preguntas Frecuentes</a></li>
                            <li><a href="#">Puntos de Venta Cercanos</a></li>
                            <li><a href="#">Pago de Premios</a></li>
                            <li><a href="#">Formulario de Contacto</a></li>
                            <li><a href="#">PQRS</a></li>
                        </ul>
                    </div>

                    <div class="gg-footer-col">
                        <h4 class="gg-footer-title">LA EMPRESA</h4>
                        <ul class="gg-footer-links">
                            <li><a href="#">Quiénes Somos</a></li>
                            <li><a href="#">Trabaje con Nosotros</a></li>
                            <li><a href="#">Responsabilidad Social</a></li>
                            <li><a href="#">Noticias & Comunicados</a></li>
                            <li><a href="#">Transparencia</a></li>
                        </ul>
                    </div>
                <?php endif; ?>

            </div>
        </div>

        <!-- =============================================
             SECCIÓN 3: BARRA COPYRIGHT (Verde, Línea Divisoria)
             ============================================= -->
        <div class="gg-copyright-bar">
            <div class="gg-container gg-copyright-inner">

                <!-- Texto Copyright -->
                <div class="gg-copyright-text">
                    <?php 
                    $copyright_texto = gg_get_option('copyright_texto');
                    if (!empty($copyright_texto)) :
                        echo esc_html($copyright_texto);
                    else :
                    ?>
                        &copy; <?php echo date('Y'); ?> <strong>GanaGana</strong> - La red multiservicios de los tolimenses. Todos los derechos reservados.
                    <?php endif; ?>
                </div>

                <!-- Enlaces Legales a la Derecha -->
                <div class="gg-copyright-links">
                    <?php 
                    $copyright_links = gg_get_option('copyright_links');
                    if (!empty($copyright_links) && is_array($copyright_links)) :
                        foreach ($copyright_links as $leg) :
                            $leg_texto = !empty($leg['texto']) ? esc_html($leg['texto']) : '';
                            $leg_url   = !empty($leg['url']) ? esc_url($leg['url']) : '#';
                            if ($leg_texto) :
                            ?>
                                <a href="<?php echo $leg_url; ?>"><?php echo $leg_texto; ?></a>
                            <?php 
                            endif;
                        endforeach;
                    else : 
                        // Fallback enlaces legales
                    ?>
                        <a href="#">Términos y Condiciones</a>
                        <a href="#">Política de Privacidad</a>
                        <a href="#">Habeas Data</a>
                    <?php endif; ?>
                </div>

            </div>
        </div>

    </footer>

    <?php wp_footer(); ?>
</body>
</html>