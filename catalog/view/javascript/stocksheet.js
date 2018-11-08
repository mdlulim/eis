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

    $(document).on('click', '.btn-remove', function(e) {
        if (!confirm('Are you sure you want to remove the selected item?')) {
            e.preventDefault();
        }
    });

    $(document).on('click', '.btn-add-sheet-to-cart', function(e) {
        e.preventDefault();
        var text = 'Please note that all current cart items will be replaced with contents from this order, should line Items have no stock or are disabled it will not be added to your cart.';
        swal({
            title: "Continue?",
            text: text,
            type: "warning",
            showCancelButton: true,
            confirmButtonClass: "btn-warning",
            confirmButtonText: "Yes, continue!",
            closeOnConfirm: true,
            showLoaderOnConfirm: true
        },
        function (isConfirm) {
            if (isConfirm) {
                var postData = [];
                var data     = oTable.rows().data();
                data.each(function (value, index) {
                    var input    = oTable.cell(index, 3).nodes().to$().find('input');
                    var quantity = parseInt(input.val());
                    if (quantity > 0) {
                        postData.push({
                            product_id           : parseInt(input.attr('data-product-id')),
                            cart_import_quantity : quantity
                        });
                    }
                });
                $.ajax({
                    url     : 'index.php?route=checkout/cart/addmultiple',
                    type    : 'POST',
                    data    : { products: postData },
                    dataType: 'json',
                    success : function(json) {
                        if (json['success']) {
                            location.href = 'index.php?route=checkout/cart'
                        } else {
                            swal('Error!', json['error'], 'error');
                        }
                    }
                });
            }
        });
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