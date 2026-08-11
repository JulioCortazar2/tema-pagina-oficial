# Documentación del Directorio Modular `/inc/`

Este directorio contiene los módulos PHP que componen la funcionalidad del tema **GanaGana Custom** (`ganagana-custom`). Cada archivo está enfocado en una responsabilidad única para mantener el código organizado, mantenible y escalable.

---

## 📁 Archivos Módulos y Responsabilidades

### 1. `enqueue-scripts.php`
- **Descripción:** Controla la carga de archivos de estilos (CSS) y scripts (JavaScript) en el frontend y en el panel de administración (`wp-admin`).
- **Funciones:**
  - `ganagana_enqueue_assets()`: Carga `main.css`, `main.js` y Google Fonts Montserrat en el sitio web con cache-busting dinámico (`filemtime`).
  - `gg_enqueue_admin_styles()`: Carga `admin-options.css`, `admin-page-header.js` y `wp_enqueue_media()` en las pantallas de opciones y edición de páginas.

### 2. `hooks.php`
- **Descripción:** Registra las características nativas del tema, menús de navegación y zonas de widgets (sidebars).
- **Funciones:**
  - `ganagana_theme_support()`: Activa `title-tag`, `post-thumbnails`, `custom-logo`, y `html5`.
  - `ganagana_register_menus()`: Registra la ubicación del `primary-menu` (Menú Principal Header).
  - `ganagana_widgets_init()`: Registra la zona de widgets `sidebar-1` (Barra Lateral Principal).

### 3. `utilities.php`
- **Descripción:** Proporciona funciones de utilidad y helpers reutilizables en todo el tema.
- **Funciones:**
  - `gg_get_option($field_id)`: Recupera valores de opciones guardadas en CMB2 mappeando IDs con su clave de opción única (`option_key`).
  - `gg_parse_enlaces_raw($raw_text)`: Convierte cadenas multilínea con formato `Texto|URL` ingresadas en textareas a arreglos estructurados.

### 4. `cmb2-options.php`
- **Descripción:** Gestiona la creación de pantallas de configuración y meta campos mediante el framework CMB2.
- **Funciones:**
  - `gg_register_theme_options()`: Registra el panel "Topbar" y sus subpáginas (Topbar, Header, Pre-footer, Footer, Copyright).
  - `gg_register_page_header_meta()`: Registra el meta box lateral en el editor de páginas para configurar la cabecera individual (Default, Hero 100% ancho, Sin cabecera).

### 5. `walkers.php`
- **Descripción:** Contiene las clases Walker personalizadas para maquetado de menús complejos.
- **Clases:**
  - `GG_Mega_Menu_Walker`: Hereda de `Walker_Nav_Menu` para generar la estructura HTML de 3 niveles del Mega Menú corporativo (Categorías, Secciones y Badges).

### 6. `custom-post-types.php`
- **Descripción:** Plantilla modular para registrar Tipos de Contenido Personalizados (Custom Post Types) futuros (ej. Juegos, Puntos de Venta, Promociones).

### 7. `custom-taxonomies.php`
- **Descripción:** Plantilla modular para registrar Taxonomías Personalizadas futuras (ej. Categorías de Juego, Tipos de Servicio).

### 8. `security.php`
- **Descripción:** Reglas de endurecimiento y seguridad para el tema.
- **Funciones:**
  - Oculta la versión de WordPress en las cabeceras HTML.
  - Sanitiza mensajes de error de inicio de sesión.
  - Deshabilita la edición de archivos desde el panel administrativo.

### 9. `elementor-support.php`
- **Descripción:** Integra ganchos y filtros de compatibilidad específicos con el maquetador visual Elementor.

---

## 🛠️ Guía para Agregar Nuevas Funciones

1. **Determina la categoría:** Identifica a cuál de los archivos anteriores corresponde la nueva función.
2. **Usa siempre la constante de acceso seguro:** Cada archivo debe comenzar con:
   ```php
   if (!defined('ABSPATH')) {
       exit;
   }
   ```
3. **No incluyas código directamente en `functions.php`:** Agrega la lógica dentro del módulo correspondiente en `/inc/`. `functions.php` solo se utiliza para importar estos archivos mediante `require_once`.
