(function($) {
    "use strict";

    var oTable;

    var initCheckoutCart = function() {
        $(document).ready(function($) {
            /* datatable for cart [checkout] */
            if ($('.cart-info>table.table').length) {
                var aOptions = {
                    "sDom"           : "<t><'row'<'col-md-12'i p>>",
                    "oLanguage"      : {"sLengthMenu":"_MENU_ ","sInfo":"Showing _START_ to _END_ of _TOTAL_"},
                    "iDisplayLength" : 50,
                    "bSort"          : false
                };
                oTable = $('.cart-info>table.table').DataTable(aOptions);
                var oFilterColumns = [];
                $('.datatable-custom-filters ul.dropdown-menu input[type="checkbox"]:checked').each(function(i,v) {
                    oFilterColumns.push(parseInt(this.value));
                });
                var buttonCommon = {
                    exportOptions: {
                        columns: [1,2,3,4,5,6],
                        format: {
                            body: function(data, row, column, node) {
                                switch (column) {
                                    case 0:
                                        return $(data).html();

                                    case 3:
                                        return $(data).find('input').val();

                                    case 4:
                                    case 5:
                                        return data.replace( /[R,]/g, '' );

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
                        }),
                        // $.extend(true, {}, buttonCommon, {

       //     extend: 'excelHtml5'
                        // }),
                        $.extend(true, {}, buttonCommon, {
                            extend: 'pdfHtml5'

                        })
                    ]
                }).container().appendTo('#export-buttons');
                createFilter(oTable, oFilterColumns);

                
            }
            if ($('.cart__items-not-found table.table').length) {
                var vOptions = {
                    "sDom"           : "<t><'row'<'col-md-12'i p>>",
                    "oLanguage"      : {"sLengthMenu":"_MENU_ ","sInfo":"Showing _START_ to _END_ of _TOTAL_"},
                    "iDisplayLength" : 50,
                    "bSort"          : false
                };
                $('.cart__items-not-found table.table').DataTable(vOptions);
            }
            if ($('.datatable-custom-filters form').length) {
                $('.datatable-custom-filters form').on('submit', function(form) {
                    form.preventDefault();
                    return false;
                });
            }
        });

        $(document).on('click', '.datatable-custom-filters ul.dropdown-menu input[type="checkbox"]', function() {
            oTable.search('').draw();
            // clear search input
            $('.datatable-custom-filters input.input-filter').val('');
            // .searchable class toggler
            var th_class = $(this).data('toogle-class');
            $('.cart-info table>tbody>td.' + th_class).toggleClass('searchable');
            var oFilterColumns = [];
            $('.datatable-custom-filters ul.dropdown-menu input[type="checkbox"]:checked').each(function(i,v) {
                oFilterColumns.push(parseInt(this.value));
            });
            // recreate custom datatable filter
            createFilter(oTable, oFilterColumns);
        });

        $(document).on('click', '.dropdown-toggle', function(e) {
            e.preventDefault();
            $(this).parent().toggleClass('open');
        });

        $(document).on('focus', '.datatable-custom-filters input.input-filter', function() {
            $(this).parent().find('.input-group-btn').removeClass('open');
        });

        $(document).on('change', 'form#form-cart-importer>input[type="file"]', function() {
            Importer.uploadFile(this);
        });

        $(document).on('click', 'button#button-continue', function() {
            Importer.addItemsToCart(this);
        });
    };

    initCheckoutCart();

}(jQuery));

function createFilter(table, columns) {
    var input = $('.datatable-custom-filters input.input-filter').on("keyup", function() {
        if (this.value.trim() != '') {
            table.draw();
        }
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
