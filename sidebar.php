<?php
/**
 * Tema GanaGana Custom - sidebar.php
 * Área de Widgets Lateral
 */
?>

<div class="gg-sidebar">

    <?php if (is_active_sidebar('sidebar-1')) : ?>

        <?php dynamic_sidebar('sidebar-1'); ?>

    <?php else : ?>

        <!-- Fallback de Widgets predeterminados si la barra lateral está vacía -->
        <div class="widget widget_search">
            <h3 class="widget-title">Buscar</h3>
            <form role="search" method="get" class="gg-search-form" action="<?php echo esc_url(home_url('/')); ?>">
                <input type="search" class="gg-search-input" style="width: 100%;" placeholder="Buscar..." value="<?php echo get_search_query(); ?>" name="s" />
                <button type="submit" class="gg-search-submit" aria-label="Buscar">
                    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><circle cx="11" cy="11" r="8"></circle><line x1="21" y1="21" x2="16.65" y2="16.65"></line></svg>
                </button>
            </form>
        </div>

        <div class="widget widget_recent_entries">
            <h3 class="widget-title">Noticias Recientes</h3>
            <ul>
                <?php
                $recent_posts = wp_get_recent_posts(array(
                    'numberposts' => 5,
                    'post_status' => 'publish'
                ));
                foreach ($recent_posts as $post_item) :
                ?>
                    <li>
                        <a href="<?php echo get_permalink($post_item['ID']); ?>">
                            <?php echo esc_html($post_item['post_title']); ?>
                        </a>
                    </li>
                <?php endforeach; wp_reset_query(); ?>
            </ul>
        </div>

        <div class="widget widget_categories">
            <h3 class="widget-title">Categorías</h3>
            <ul>
                <?php wp_list_categories(array('title_li' => '')); ?>
            </ul>
        </div>

    <?php endif; ?>

</div>
