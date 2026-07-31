<?php
/**
 * Tema GanaGana Custom — functions.php
 *
 * Archivo principal del tema. Define las constantes del sistema y carga
 * de manera limpia y modular todos los componentes desde /inc/.
 *
 * @package GanaGanaCustom
 */

if (!defined('ABSPATH')) {
    exit; // Evita el acceso directo
}

// ─── 1. CONSTANTES GLOBALES DEL TEMA ─────────────────────────────────
define('GANAGANA_VERSION', '1.0.0');
define('GANAGANA_DIR', get_template_directory());
define('GANAGANA_URI', get_template_directory_uri());

// ─── 2. IMPORTACIÓN DE MÓDULOS (/inc/) ──────────────────────────────

// Utilidades y Helpers (se carga primero para disponibilidad global)
require_once GANAGANA_DIR . '/inc/utilities.php';

// Carga de Scripts y Estilos (Frontend y Admin)
require_once GANAGANA_DIR . '/inc/enqueue-scripts.php';

// Soporte del Tema, Menús y Widgets
require_once GANAGANA_DIR . '/inc/hooks.php';

// Opciones del Tema y Meta Boxes con CMB2
require_once GANAGANA_DIR . '/inc/cmb2-options.php';

// Walkers Personalizados (Mega Menú)
require_once GANAGANA_DIR . '/inc/walkers.php';

// Custom Post Types y Taxonomías
require_once GANAGANA_DIR . '/inc/custom-post-types.php';
require_once GANAGANA_DIR . '/inc/custom-taxonomies.php';

// Seguridad y Sanitización
require_once GANAGANA_DIR . '/inc/security.php';

// Integración y Soporte para Elementor
require_once GANAGANA_DIR . '/inc/elementor-support.php';