/**
 * Tema GanaGana Custom — Títulos dinámicos en grupos repetibles de CMB2.
 * Añade el valor del campo más representativo de cada fila (ej: "facebook",
 * "Visión, Misión y valores") al título del recuadro colapsable, para poder
 * identificar el contenido sin tener que expandirlo.
 */
(function ($) {
    'use strict';

    // Mapa: id del grupo repetible -> id del campo cuyo valor se muestra en el título.
    var GG_GROUP_TITLE_FIELDS = {
        'topbar_links':           'texto',
        'logos_institucionales':  'alt',
        'prefooter_botones':      'texto_boton',
        'footer_redes_sociales':  'red_social',
        'footer_columnas':        'titulo_columna',
        'footer_enlaces':         'texto_enlace',
        'copyright_links':        'texto',
        'redes_flotantes_items':  'nombre_red',
        'botones_derechos_items': 'texto',
        'servicios_items':        'alt'
    };

    function ggGetGroupInfo($row) {
        var id = $row.attr('id') || '';
        var match = id.match(/^cmb-group-(.+)-(\d+)$/);
        if (!match) {
            return null;
        }
        return { groupId: match[1], index: match[2] };
    }

    function ggUpdateRowTitle($row) {
        var info = ggGetGroupInfo($row);
        if (!info || !GG_GROUP_TITLE_FIELDS.hasOwnProperty(info.groupId)) {
            return;
        }

        var fieldSuffix = GG_GROUP_TITLE_FIELDS[info.groupId];
        var fieldId = info.groupId + '_' + info.index + '_' + fieldSuffix;
        var $field = $row.find('#' + fieldId);
        var $span = $row.find('.cmb-group-title span').first();

        if (!$field.length || !$span.length) {
            return;
        }

        var $table = $row.closest('.cmb-repeatable-group');
        var template = $table.find('.cmb-add-group-row').data('grouptitle');
        var rowNumber = parseInt($row.data('iterator'), 10) + 1;
        var base = template ? String(template).replace('{#}', rowNumber) : $span.text();

        var value = $.trim($field.val() || '');
        $span.text(value ? base + ' ' + value : base);
    }

    function ggUpdateAllRowsIn($context) {
        $context.find('.cmb-repeatable-grouping').each(function () {
            ggUpdateRowTitle($(this));
        });
    }

    $(function () {
        ggUpdateAllRowsIn($('body'));
    });

    $(document).on('input change', '.cmb-repeatable-grouping input, .cmb-repeatable-grouping select', function () {
        ggUpdateRowTitle($(this).closest('.cmb-repeatable-grouping'));
    });

    $(document).on('cmb2_add_row cmb2_remove_row', function (evt) {
        ggUpdateAllRowsIn($(evt.target));
    });

})(jQuery);
