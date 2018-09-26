(function($) {
    "use strict";

    var oTable;

    $(document).ready(function() {
        if ($('.wishlist-info table.table').length) {
            var aOptions = {
                "sDom"           : "<t><'row'<'col-md-12'i p>>",
                "oLanguage"      : {"sLengthMenu":"_MENU_ ","sInfo":"Showing _START_ to _END_ of _TOTAL_"},
                "iDisplayLength" : 50,
                "bSort"          : true,
                "aaSorting"      : [[1, 'asc']]
            };
            oTable = $('.wishlist-info table.table').DataTable(aOptions);
            var oFilterColumns = [];
            $('.datatable-custom-filters ul.dropdown-menu input[type="checkbox"]:checked').each(function(i,v) {
                oFilterColumns.push(parseInt(this.value));
            });
            var buttonCommon = {
                exportOptions: {
                    columns: [1,2,3,4],
                    format: {
                        body: function(data, row, column, node) {
                            switch (column) {
                                case 0:
                                    return $(data).html();

                                case 2:
                                    return $(data).val();

                                case 3:
                                    return $(data).html().trim().replace( /[R,]/g, '' ).replace(' ','');

                                default:
                                    return data;
                            }
                        }
                    }
                }
            };
            var exportButtons = new $.fn.dataTable.Buttons(oTable, {
                buttons: [
                    $.extend(true, {}, buttonCommon, {
                        extend: 'copyHtml5'
                    }),
                    $.extend(true, {}, buttonCommon, {
                        extend: 'csvHtml5'
                    })
                ]
            }).container().appendTo('#export-buttons');
            createFilter(oTable, oFilterColumns);
        }
    });

    $(document).on('change', 'form#form-stocksheet-importer>input[type="file"]', function() {
        Importer.uploadFile(this);
    });

    $(document).on('change', 'form#form-stocksheet-importer>input[type="file"]', function() {
        Importer.uploadFile(this);
    });

    $(document).on('click', 'button#button-continue', function() {
        Importer.addItemsToStocksheet(this);
    });

    $(document).on('click', '.dropdown-toggle', function(e) {
        e.preventDefault();
        $(this).parent().toggleClass('open');
    });

    $(document).on('focus', '.datatable-custom-filters input.input-filter', function() {
        $(this).parent().find('.input-group-btn').removeClass('open');
    });

}(jQuery));

function createFilter(table, columns) {
    var input = $('.datatable-custom-filters input.input-filter').on("keyup", function() {
        // if (this.value.trim() != '') {
            table.draw();
        // }
    });
    $.fn.dataTable.ext.search.push(function(settings, searchData, index, rowData, counter) {
        var val = input.val().toLowerCase();
        for (var i = 0, ien = columns.length; i < ien; i++) {
            if (searchData[columns[i]].toLowerCase().indexOf(val) !== -1) {
                return true;
            }
        }
        return false;
    });
    return input;
}