/**
 * Tema GanaGana Custom — Admin Page Header Preview & Toggle
 * Controla la visibilidad de campos y el Live Preview en el editor de páginas.
 */
(function ($) {
    'use strict';

    $(document).ready(function () {
        var $metaBox = $('#gg_page_header_meta');
        if (!$metaBox.length) return;

        var $modeSelect     = $('#page_header_mode');
        var $imageField     = $('#page_header_image');
        var $heightSelect    = $('#page_header_height');
        var $posSelect       = $('#page_header_position');
        var $showTitleCheck  = $('#page_header_show_title');
        var $colorInput      = $('#page_header_title_color');
        var $overlayCheck    = $('#page_header_overlay');
        var $previewWrap     = $('#gg-ph-preview-wrap');

        // Filas de los campos hero en CMB2
        function getHeroRows() {
            return $metaBox.find('.cmb-row').filter(function () {
                var $row = $(this);
                return !$row.find('#page_header_mode').length &&
                       !$row.find('#gg-ph-preview-wrap').length;
            });
        }

        function renderPreview() {
            var mode = $modeSelect.val();

            if (mode === 'hidden') {
                $previewWrap.html(
                    '<div style="background:#F7FAFC;border:2px dashed #CBD5E0;border-radius:8px;padding:16px;text-align:center;color:#718096;font-size:0.75rem;font-weight:600;text-transform:uppercase;">' +
                    '🚫 La página no tendrá cabecera (inicia directo con el contenido)' +
                    '</div>'
                );
                return;
            }

            if (mode === 'default') {
                var titleText = getPageTitle();
                $previewWrap.html(
                    '<div style="margin-top:10px;">' +
                    '  <div style="font-size:0.7rem;font-weight:700;color:#2A5747;text-transform:uppercase;margin-bottom:6px;">Vista Previa (Predeterminado):</div>' +
                    '  <div style="background:#2A5747;border-radius:6px;padding:14px 10px;text-align:center;box-shadow:0 2px 8px rgba(0,0,0,0.15);">' +
                    '    <span style="color:#ffffff;font-weight:800;font-size:0.85rem;text-transform:uppercase;letter-spacing:0.04em;">' + escapeHtml(titleText) + '</span>' +
                    '  </div>' +
                    '</div>'
                );
                return;
            }

            // Modo HERO
            var imgUrl       = $imageField.val() || '';
            var heightVal    = $heightSelect.val() || '400';
            var positionVal  = $posSelect.val() || 'center center';
            var showTitle    = $showTitleCheck.is(':checked');
            var titleColor   = $colorInput.val() || '#FFFFFF';
            var hasOverlay   = $overlayCheck.is(':checked');
            var titleText    = getPageTitle();

            // Altura proporcional para la miniatura
            var miniHeight = 90;
            if (heightVal === '200') miniHeight = 60;
            if (heightVal === '500' || heightVal === '650') miniHeight = 120;
            if (heightVal === '100vh') miniHeight = 150;

            var bgStyle = imgUrl
                ? 'background-image:url(' + imgUrl + ');background-size:cover;background-position:' + positionVal + ';'
                : 'background:linear-gradient(135deg, #1A382D 0%, #3A7A5E 100%);';

            var overlayHtml = hasOverlay
                ? '<div style="position:absolute;top:0;left:0;width:100%;height:100%;background:rgba(0,0,0,0.45);z-index:1;"></div>'
                : '';

            var titleHtml = showTitle
                ? '<div style="position:relative;z-index:2;color:' + titleColor + ';font-weight:800;font-size:0.8rem;text-transform:uppercase;text-shadow:0 1px 4px rgba(0,0,0,0.7);padding:0 8px;line-height:1.2;">' + escapeHtml(titleText) + '</div>'
                : '';

            $previewWrap.html(
                '<div style="margin-top:10px;">' +
                '  <div style="font-size:0.7rem;font-weight:700;color:#2A5747;text-transform:uppercase;margin-bottom:6px;">Vista Previa (Hero Ancho Completo):</div>' +
                '  <div style="position:relative;height:' + miniHeight + 'px;' + bgStyle + 'border-radius:6px;display:flex;align-items:center;justify-content:center;overflow:hidden;box-shadow:0 3px 10px rgba(0,0,0,0.2);">' +
                     overlayHtml +
                     titleHtml +
                '  </div>' +
                (!imgUrl ? '<div style="font-size:0.68rem;color:#E53E3E;margin-top:4px;font-style:italic;">⚠️ Sin imagen seleccionada (mostrando fondo verde de prueba)</div>' : '') +
                '</div>'
            );
        }

        // Obtener título de la página desde Gutenberg o el editor clásico
        function getPageTitle() {
            var gtenbergTitle = $('.editor-post-title__input, .components-text-control__input').val();
            if (gtenbergTitle) return gtenbergTitle;

            var classicTitle = $('#title').val();
            if (classicTitle) return classicTitle;

            return window.ggPageHeader ? window.ggPageHeader.siteTitle : 'TÍTULO DE PÁGINA';
        }

        function escapeHtml(text) {
            return $('<div>').text(text).html();
        }

        function toggleFields() {
            var mode = $modeSelect.val();
            var $heroRows = getHeroRows();

            if (mode === 'hero') {
                $heroRows.show(150);
            } else {
                $heroRows.hide(150);
            }
            renderPreview();
        }

        $modeSelect.on('change', toggleFields);
        $imageField.on('change input', renderPreview);
        $heightSelect.on('change', renderPreview);
        $posSelect.on('change', renderPreview);
        $showTitleCheck.on('change', renderPreview);
        $colorInput.on('change input', renderPreview);
        $overlayCheck.on('change', renderPreview);

        $(document).on('input keyup change', '.editor-post-title__input, #title', renderPreview);

        // Observar cuando WP Media Modal actualiza el valor del campo file
        var observer = new MutationObserver(function() {
            renderPreview();
        });
        if ($imageField.length) {
            observer.observe($imageField[0], { attributes: true, attributeFilter: ['value'] });
        }

        toggleFields();
    });

})(jQuery);
