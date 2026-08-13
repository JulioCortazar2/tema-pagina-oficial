<?php
if (!defined('ABSPATH')) {
    exit;
}

$gg_logos = gg_get_option('logos_institucionales');

if (empty($gg_logos) || !is_array($gg_logos)) {
    return;
}

$gg_logos_bg     = gg_get_option('logos_bg_color');
$gg_logos_bg     = !empty($gg_logos_bg) ? $gg_logos_bg : '#ffffff';
$gg_logos_altura = absint(gg_get_option('logos_altura_max'));
$gg_logos_altura = $gg_logos_altura > 0 ? $gg_logos_altura : 70;

$gg_logos_items = array();
foreach ($gg_logos as $gg_logo) {
    $gg_img_id = !empty($gg_logo['imagen_id']) ? absint($gg_logo['imagen_id']) : 0;
    if ($gg_img_id > 0 && wp_attachment_is_image($gg_img_id)) {
        $gg_logos_items[] = $gg_logo;
    }
}

if (empty($gg_logos_items)) {
    return;
}
?>
<div class="gg-footer-logos" style="--gg-logos-bg: <?php echo esc_attr($gg_logos_bg); ?>; --gg-logos-altura: <?php echo esc_attr($gg_logos_altura); ?>px;">
    <ul class="gg-footer-logos__list">
        <?php foreach ($gg_logos_items as $gg_logo) :
            $gg_img_id  = absint($gg_logo['imagen_id']);
            $gg_alt     = !empty($gg_logo['alt']) ? trim($gg_logo['alt']) : '';
            $gg_url     = !empty($gg_logo['url']) ? $gg_logo['url'] : '';
            $gg_blank   = !empty($gg_logo['target_blank']);

            $gg_escala_raw = isset($gg_logo['escala']) ? (float) $gg_logo['escala'] : 100;
            if ($gg_escala_raw < 50 || $gg_escala_raw > 150) {
                $gg_escala_raw = 100;
            }
            $gg_escala = $gg_escala_raw / 100;

            $gg_img_attr = array(
                'loading'  => 'lazy',
                'decoding' => 'async',
                'class'    => 'gg-footer-logos__img',
            );
            if ($gg_alt !== '') {
                $gg_img_attr['alt'] = $gg_alt;
            }

            $gg_img_html = wp_get_attachment_image($gg_img_id, 'full', false, $gg_img_attr);
            if (empty($gg_img_html)) {
                continue;
            }
        ?>
            <li class="gg-footer-logos__item" style="--gg-logo-escala: <?php echo esc_attr($gg_escala); ?>;">
                <?php if (!empty($gg_url)) : ?>
                    <a class="gg-footer-logos__link" href="<?php echo esc_url($gg_url); ?>"<?php echo $gg_blank ? ' target="_blank" rel="noopener noreferrer"' : ''; ?>>
                        <?php echo $gg_img_html; ?>
                    </a>
                <?php else : ?>
                    <?php echo $gg_img_html; ?>
                <?php endif; ?>
            </li>
        <?php endforeach; ?>
    </ul>
</div>
