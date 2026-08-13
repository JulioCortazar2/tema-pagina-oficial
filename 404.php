<?php
get_header();
?>

<div class="gg-container">

    <div class="gg-404-container">
        
        <div class="gg-404-code">404</div>

        <h1 class="gg-404-title">¡Ups! Página no encontrada</h1>

        <p class="gg-404-desc">
            La página que estás buscando no existe, ha sido movida o la dirección ingresada no es correcta.
            Prueba realizando una búsqueda a continuación o regresa a la página de inicio.
        </p>

        <div class="gg-404-search">
            <form role="search" method="get" class="gg-search-form" action="<?php echo esc_url(home_url('/')); ?>">
                <input type="search" class="gg-search-input" style="width: 100%;" placeholder="¿Qué estás buscando?" value="<?php echo get_search_query(); ?>" name="s" />
                <button type="submit" class="gg-search-submit" aria-label="Buscar">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><circle cx="11" cy="11" r="8"></circle><line x1="21" y1="21" x2="16.65" y2="16.65"></line></svg>
                </button>
            </form>
        </div>

        <a href="<?php echo esc_url(home_url('/')); ?>" class="gg-btn-promociones" style="display: inline-flex;">
            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"></path><polyline points="9 22 9 12 15 12 15 22"></polyline></svg>
            <span>Volver a la Página Principal</span>
        </a>

    </div>

</div>

<?php
get_footer();
