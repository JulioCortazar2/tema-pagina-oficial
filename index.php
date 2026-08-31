<?php
get_header();
?>

<div class="gg-container">

    <div class="gg-page-header">
        <h1 class="gg-page-title">Noticias y Novedades</h1>
        <p class="gg-page-subtitle">EntÃ©rate de las Ãºltimas promociones, ganadores y comunicados de GanaGana</p>
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
                                    <span><?php echo get_the_date('d M, Y'); ?></span>
                                </div>

                                <h2 class="gg-post-card-title">
                                    <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                                </h2>

                                <div class="gg-post-card-excerpt">
                                    <?php the_excerpt(); ?>
                                </div>

                                <a href="<?php the_permalink(); ?>" class="gg-post-card-btn">
                                    Leer artÃ­culo
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><line x1="5" y1="12" x2="19" y2="12"></line><polyline points="12 5 19 12 12 19"></polyline></svg>
                                </a>
                            </div>

                        </article>
                    <?php endwhile; ?>
                </div>

                <div class="gg-pagination">
                    <?php
                    the_posts_pagination(array(
                        'mid_size'  => 2,
                        'prev_text' => 'â€¹ Anterior',
                        'next_text' => 'Siguiente â€º',
                    ));
                    ?>
                </div>

            <?php else : ?>

                <div class="gg-article">
                    <h2>No se encontraron publicaciones</h2>
                    <p>Lo sentimos, actualmente no hay artÃ­culos disponibles para mostrar.</p>
                </div>

            <?php endif; ?>
        </div>

        <aside class="gg-layout-sidebar">
            <?php get_sidebar(); ?>
        </aside>

    </div>

</div>

<?php
get_footer();
