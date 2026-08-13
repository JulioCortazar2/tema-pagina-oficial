<?php
get_header();
?>

<div class="gg-container">

    <?php while (have_posts()) : the_post(); ?>

        <div class="gg-layout-grid">

            <div class="gg-layout-main">
                <article id="post-<?php the_ID(); ?>" <?php post_class('gg-article'); ?>>

                    <h1 class="gg-page-title" style="color: var(--gg-green-darker); margin-bottom: 15px; font-size: 2rem;">
                        <?php the_title(); ?>
                    </h1>

                    <div class="gg-single-meta">
                        <span>Publicado el: <strong><?php echo get_the_date(); ?></strong></span>
                        <span>Por: <strong><?php the_author(); ?></strong></span>
                        <?php if (has_category()) : ?>
                            <span>Categoría: <strong><?php the_category(', '); ?></strong></span>
                        <?php endif; ?>
                    </div>

                    <?php if (has_post_thumbnail()) : ?>
                        <div class="gg-single-thumb">
                            <?php the_post_thumbnail('large'); ?>
                        </div>
                    <?php endif; ?>

                    <div class="gg-entry-content">
                        <?php 
                        the_content(); 

                        wp_link_pages(array(
                            'before' => '<div class="page-links">' . __('Páginas:', 'ganagana'),
                            'after'  => '</div>',
                        ));
                        ?>
                    </div>

                    <?php if (has_tag()) : ?>
                        <div class="gg-post-tags" style="margin-top: 30px; padding-top: 15px; border-top: 1px solid var(--gg-border-color);">
                            <strong>Etiquetas: </strong> <?php the_tags('', ', ', ''); ?>
                        </div>
                    <?php endif; ?>

                    <div class="gg-post-navigation" style="display: flex; justify-content: space-between; margin-top: 40px; padding-top: 20px; border-top: 2px solid var(--gg-border-color);">
                        <div class="nav-previous"><?php previous_post_link('%link', '← %title'); ?></div>
                        <div class="nav-next"><?php next_post_link('%link', '%title →'); ?></div>
                    </div>

                </article>
            </div>

            <aside class="gg-layout-sidebar">
                <?php get_sidebar(); ?>
            </aside>

        </div>

    <?php endwhile; ?>

</div>

<?php
get_footer();
