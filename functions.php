<?php
if (!defined('ABSPATH')) {
    exit;
}

define('GANAGANA_VERSION', '1.0.0');
define('GANAGANA_DIR', get_template_directory());
define('GANAGANA_URI', get_template_directory_uri());

require_once GANAGANA_DIR . '/inc/utilities.php';
require_once GANAGANA_DIR . '/inc/enqueue-scripts.php';
require_once GANAGANA_DIR . '/inc/hooks.php';
require_once GANAGANA_DIR . '/inc/cmb2-options.php';
require_once GANAGANA_DIR . '/inc/walkers.php';
require_once GANAGANA_DIR . '/inc/custom-post-types.php';
require_once GANAGANA_DIR . '/inc/custom-taxonomies.php';
require_once GANAGANA_DIR . '/inc/security.php';
require_once GANAGANA_DIR . '/inc/elementor-support.php';