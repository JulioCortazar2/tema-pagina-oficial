<?php
/**
 * Tema GanaGana Custom — Seguridad y Sanitización
 *
 * Módulo para añadir reglas de endurecimiento (hardening), sanitización
 * de datos y eliminación de metadatos innecesarios en las cabeceras HTML.
 *
 * @package GanaGanaCustom
 */

if (!defined('ABSPATH')) {
    exit; // Evita el acceso directo
}

/**
 * 1. Elimina la versión de WordPress de las cabeceras HTML y feeds RSS.
 */
function gg_remove_wp_version() {
    return '';
}
add_filter('the_generator', 'gg_remove_wp_version');

/**
 * 2. Oculta errores de inicio de sesión detallados por seguridad.
 */
function gg_login_errors_override() {
    return __('Credenciales incorrectas. Por favor intenta de nuevo.', 'ganagana');
}
add_filter('login_errors', 'gg_login_errors_override');

/**
 * 3. Deshabilita la edición de archivos PHP desde el panel admin si no está definida.
 */
if (!defined('DISALLOW_FILE_EDIT')) {
    define('DISALLOW_FILE_EDIT', true);
}
