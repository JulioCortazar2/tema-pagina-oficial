<?php
/**
 * Tema GanaGana Custom - search.php
 * Plantilla para Resultados de Búsqueda
 */

get_header();
?>

<div class="gg-container">

    <!-- Header de Búsqueda -->
    <div class="gg-page-header">
        <div class="gg-container">
            <h1 class="gg-page-title">
                Resultados para: "<?php echo get_search_query(); ?>"
            </h1>
            <p class="gg-page-subtitle">
                <?php 
                global $wp_query;
                echo sprintf(_n('Se encontró %d resultado', 'Se encontraron %d resultados', $wp_query->found_posts, 'ganagana'), $wp_query->found_posts);
                ?>
            </p>
        </div>
    </div>

    <div class="gg-layout-grid">

        <div class="gg-layout-main">
            <?php if (have_posts()) : ?>

                <div class="gg-posts-grid">
                    <?php while (have_posts()) : the_post(); ?>
                        <article id="post-<?php the_ID(); ?>" <?php post_class('gg-post-card'); ?>>
                            
                            <div class="gg-post-card-thumb">
                                <a href="<?php the_permalink(); ?>">
                                    <?php if (has_post_thumbnail()) : ?>
                                        <?php the_post_thumbnail('medium_large'); ?>
                                    <?php else : ?>
                                        <img src="<?php echo get_template_directory_uri(); ?>/assets/images/logo.png" alt="<?php the_title_attribute(); ?>" style="object-fit: contain; padding: 30px; background: #fff;" />
                                    <?php endif; ?>
                                </a>
                            </div>

                            <div class="gg-post-card-body">
                                <div class="gg-post-meta">
                                    <span><?php echo get_post_type() === 'page' ? 'Página' : get_the_date('d M, Y'); ?></span>
                                </div>

                                <h2 class="gg-post-card-title">
                                    <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                                </h2>

                                <div class="gg-post-card-excerpt">
                                    <?php the_excerpt(); ?>
                                </div>

                                <a href="<?php the_permalink(); ?>" class="gg-post-card-btn">
                                    Ver contenido
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><line x1="5" y1="12" x2="19" y2="12"></line><polyline points="12 5 19 12 12 19"></polyline></svg>
                                </a>
                            </div>

                        </article>
                    <?php endwhile; ?>
                </div>

                <!-- Paginación -->
                <div class="gg-pagination">
                    <?php
                    the_posts_pagination(array(
                        'mid_size'  => 2,
                        'prev_text' => '‹ Anterior',
                        'next_text' => 'Siguiente ›',
                    ));
                    ?>
                </div>

            <?php else : ?>

                <div class="gg-article" style="text-align: center;">
                    <h2>No se encontraron resultados</h2>
                    <p>No pudimos encontrar ningún contenido que coincida con "<strong><?php echo get_search_query(); ?></strong>". Por favor intenta con otros términos de búsqueda.</p>
                    
                    <div style="max-width: 400px; margin: 25px auto 0;">
                        <form role="search" method="get" class="gg-search-form" action="<?php echo esc_url(home_url('/')); ?>">
                            <input type="search" class="gg-search-input" style="width: 100%;" placeholder="Intentar otra búsqueda..." value="" name="s" />
                            <button type="submit" class="gg-search-submit" aria-label="Buscar">
                                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><circle cx="11" cy="11" r="8"></circle><line x1="21" y1="21" x2="16.65" y2="16.65"></line></svg>
                            </button>
                        </form>
                    </div>
                </div>

            <?php endif; ?>
        </div>

        <!-- Sidebar -->
        <aside class="gg-layout-sidebar">
            <?php get_sidebar(); ?>
        </aside>

    </div>

</div>

<?php
get_footer();
