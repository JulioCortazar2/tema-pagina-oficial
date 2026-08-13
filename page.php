<?php
get_header();
?>

<?php while (have_posts()) : the_post(); ?>

    <?php
    $header_mode    = get_post_meta(get_the_ID(), 'page_header_mode', true);
    $header_mode    = !empty($header_mode) ? $header_mode : 'default';

    $hero_image_id  = get_post_meta(get_the_ID(), 'page_header_image_id', true);
    $hero_image_url = $hero_image_id ? wp_get_attachment_image_url($hero_image_id, 'full') : '';
    if (!$hero_image_url) {
        $hero_image_url = get_post_meta(get_the_ID(), 'page_header_image', true);
    }

    $hero_height    = get_post_meta(get_the_ID(), 'page_header_height', true);
    $hero_height    = !empty($hero_height) ? $hero_height : '400';
    $hero_position  = get_post_meta(get_the_ID(), 'page_header_position', true);
    $hero_position  = !empty($hero_position) ? $hero_position : 'center center';

    // Manejo de checkboxes: si la meta no existe aún o es 'on', por defecto se activa
    $show_title_meta = get_post_meta(get_the_ID(), 'page_header_show_title', true);
    $show_title      = ($show_title_meta === 'off') ? false : true;

    $title_color     = get_post_meta(get_the_ID(), 'page_header_title_color', true);
    $title_color     = !empty($title_color) ? $title_color : '#FFFFFF';

    $overlay_meta    = get_post_meta(get_the_ID(), 'page_header_overlay', true);
    $has_overlay     = ($overlay_meta === 'off') ? false : true;

    $hero_height_css = ($hero_height === '100vh') ? '100vh' : $hero_height . 'px';
    ?>

    <?php if ($header_mode === 'default') : ?>
        <div class="gg-container">
            <div class="gg-page-header">
                <h1 class="gg-page-title"><?php the_title(); ?></h1>
            </div>
        </div>

    <?php elseif ($header_mode === 'hero') : ?>
        <div class="gg-page-hero"
             style="
                 position: relative;
                 width: 100%;
                 height: <?php echo esc_attr($hero_height_css); ?>;
                 background-image: url('<?php echo esc_url($hero_image_url); ?>');
                 background-position: <?php echo esc_attr($hero_position); ?>;
                 background-size: cover;
                 background-repeat: no-repeat;
                 display: flex;
                 align-items: center;
                 justify-content: center;
                 text-align: center;
                 overflow: hidden;
                 margin-bottom: 35px;
             ">
            <?php if ($has_overlay) : ?>
                <div class="gg-page-hero-overlay"
                     style="
                         position: absolute;
                         top: 0;
                         left: 0;
                         width: 100%;
                         height: 100%;
                         background: linear-gradient(180deg, rgba(0, 0, 0, 0.50) 0%, rgba(0, 0, 0, 0.70) 100%);
                         z-index: 1;
                         pointer-events: none;
                     "></div>
            <?php endif; ?>

            <?php if ($show_title) : ?>
                <div class="gg-page-hero-content"
                     style="
                         position: relative;
                         z-index: 2;
                         width: 100%;
                         max-width: 900px;
                         margin: 0 auto;
                         padding: 20px;
                         text-align: center;
                         display: flex;
                         flex-direction: column;
                         align-items: center;
                         justify-content: center;
                     ">
                    <h1 class="gg-page-hero-title"
                        style="
                            color: <?php echo esc_attr($title_color); ?>;
                            text-align: center;
                            margin: 0 auto;
                            width: 100%;
                            display: block;
                            font-weight: 800;
                            text-transform: uppercase;
                            text-shadow: 0 2px 12px rgba(0, 0, 0, 0.85);
                        ">
                        <?php the_title(); ?>
                    </h1>
                </div>
            <?php endif; ?>
        </div>

    <?php endif; ?>

    <div class="gg-container">
        <div class="gg-layout-full">
            <article id="post-<?php the_ID(); ?>" <?php post_class('gg-article'); ?>>

                <?php if (has_post_thumbnail()) : ?>
                    <div class="gg-single-thumb">
                        <?php the_post_thumbnail('full'); ?>
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

                <?php
                if (comments_open() || get_comments_number()) :
                    comments_template();
                endif;
                ?>

            </article>
        </div>
    </div>

<?php endwhile; ?>

<?php
get_footer();
