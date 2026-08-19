<?php
if (!defined('ABSPATH')) {
    exit;
}

/**
 * Roles adicionales que un usuario con promote_users puede asignar/quitar
 * desde el perfil de usuario, sin depender de plugins de terceros.
 *
 * Whitelist deliberadamente estática: nunca generar este listado desde
 * wp_roles() ni desde $_POST, para que sea imposible asignar 'administrator'
 * u otro rol no previsto vía manipulación del formulario.
 */
const GG_EXTRA_ROLES = array(
    'editor_carrusel'         => 'Puede administrar Carruseles',
    'editor_ajustes_ganagana' => 'Puede administrar Ajustes del Tema',
);

function gg_extra_roles_render_fields($user) {
    if (!current_user_can('promote_users')) {
        return;
    }
    ?>
    <h2><?php esc_html_e('Roles adicionales (GanaGana)', 'ganagana'); ?></h2>
    <table class="form-table" role="presentation">
        <?php foreach (GG_EXTRA_ROLES as $slug => $label) : ?>
            <?php
            if (!get_role($slug)) {
                continue;
            }
            $checked = in_array($slug, (array) $user->roles, true);
            ?>
            <tr>
                <th>
                    <label for="gg_extra_role__<?php echo esc_attr($slug); ?>"><?php echo esc_html($label); ?></label>
                </th>
                <td>
                    <input type="checkbox"
                           name="gg_extra_role__<?php echo esc_attr($slug); ?>"
                           id="gg_extra_role__<?php echo esc_attr($slug); ?>"
                           value="1"
                           <?php checked($checked); ?> />
                </td>
            </tr>
        <?php endforeach; ?>
    </table>
    <?php
    wp_nonce_field('gg_extra_roles_nonce_action', 'gg_extra_roles_nonce');
}
add_action('show_user_profile', 'gg_extra_roles_render_fields');
add_action('edit_user_profile', 'gg_extra_roles_render_fields');

function gg_extra_roles_save_fields($user_id) {
    if (!isset($_POST['gg_extra_roles_nonce'])) {
        return;
    }
    if (!wp_verify_nonce(sanitize_text_field(wp_unslash($_POST['gg_extra_roles_nonce'])), 'gg_extra_roles_nonce_action')) {
        return;
    }
    if (!current_user_can('promote_users')) {
        return;
    }

    $user_data = get_userdata($user_id);
    if (!$user_data) {
        return;
    }
    $user = new WP_User($user_id);

    foreach (GG_EXTRA_ROLES as $slug => $label) {
        if (!get_role($slug)) {
            continue;
        }
        $checkbox_field = 'gg_extra_role__' . $slug;
        $wants_role     = !empty($_POST[$checkbox_field]);
        $has_role       = in_array($slug, (array) $user->roles, true);

        if ($wants_role && !$has_role) {
            $user->add_role($slug);
        } elseif (!$wants_role && $has_role) {
            $user->remove_role($slug);
        }
    }
}
/**
 * Se usa 'profile_update' (no 'personal_options_update' / 'edit_user_profile_update')
 * porque esos hooks corren ANTES de que WordPress procese el dropdown "Rol" del
 * perfil. Ese proceso termina en WP_User::set_role(), que borra todos los roles
 * del usuario y deja solo el       rol principal — lo que revertía cualquier add_role()
 * hecho aquí antes. 'profile_update' se dispara después de que set_role() ya
 * terminó, así que los cambios de esta whitelist quedan persistidos.
 */
add_action('profile_update', 'gg_extra_roles_save_fields');

function gg_ocultar_categorias_etiquetas_para_editor() {
    $user = wp_get_current_user();

    if ( in_array( 'editor', (array) $user->roles ) ) {
        remove_submenu_page( 'edit.php', 'edit-tags.php?taxonomy=category' );
        remove_submenu_page( 'edit.php', 'edit-tags.php?taxonomy=post_tag' );
        remove_menu_page( 'tools.php' );
        remove_menu_page( 'edit-comments.php' );
    }
}
add_action( 'admin_menu', 'gg_ocultar_categorias_etiquetas_para_editor', 999 );

function gg_ocultar_apariencia_para_editor() {
    $user = wp_get_current_user();

    if ( ! in_array( 'editor', (array) $user->roles, true ) ) {
        return;
    }

    global $submenu;

    if ( empty( $submenu['themes.php'] ) ) {
        return;
    }

    // Deja visible únicamente "Menús" dentro de Apariencia; oculta Temas,
    // Patrones, Personalizar, Widgets y Fuentes. Se filtra por slug en vez
    // de usar remove_submenu_page() porque el slug de "Personalizar" incluye
    // un query string dinámico (customize.php?return=...) que cambia en
    // cada carga y no se puede comparar de forma exacta.
    foreach ( $submenu['themes.php'] as $key => $item ) {
        if ( 0 !== strpos( $item[2], 'nav-menus.php' ) ) {
            unset( $submenu['themes.php'][ $key ] );
        }
    }
}
add_action( 'admin_menu', 'gg_ocultar_apariencia_para_editor', 999 );
