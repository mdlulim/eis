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
                            extend: 'copy'
                        }),
                        $.extend(true, {}, buttonCommon, {
                            extend: 'csv'
                        }),
                        // $.extend(true, {}, buttonCommon, {
                        //     extend: 'excel'
                        // }),
                        $.extend(true, {}, buttonCommon, {
                            extend: 'pdf'
                        })
                    ]
                }).container().appendTo('#export-buttons');
                createFilter(oTable, oFilterColumns);
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

        $(document).on('click', '#import-cart', function(e) {
            e.preventDefault();
            var fileInput = $(this).parent().find('input');
            fileInput.trigger('click');
        });

        $(document).on('change', 'form#form-cart-importer>input[type="file"]', function() {
            var file = $(this)[0].files[0];
            if (file) {
                var error;
                var maxSize  = 5000; // 5000 KB => 5MB (Max)
                var fileSize = parseInt(file.size / 1024); // convert to KB
                var formats  = [
                    'text/csv',
                    'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet'
                ];
                if (formats.indexOf(file.type) !== -1) {
                    if (fileSize <= maxSize) {
                        swal({
                            title: "Are you sure?",
                            text: `You are about to import "${file.name}" to your shopping cart.`,
                            type: "warning",
                            showCancelButton: true,
                            confirmButtonClass: "btn-info",
                            confirmButtonText: "Yes, import it!",
                            closeOnConfirm: false,
                            showLoaderOnConfirm: true
                        },
                        function(isConfirm) {
                            if (isConfirm) {
                                var formData = new FormData(document.getElementById("form-cart-importer"));
                                $.ajax({
                                    url: 'index.php?route=checkout/cart/import',
                                    type: 'post',
                                    dataType: 'json',
                                    data: formData,
                                    processData: false,
                                    contentType: false,
                                    success: function(json) {
                                        if (json['success']) {
                                            swal({
                                                title: "Success",
                                                text: json['success'],
                                                type: "success"
                                            },
                                            function() {
                                                window.location.href = 'index.php?route=checkout/cart';
                                            });
                                        } else {
                                            swal("Error!", json['error'], "error");
                                        }
                                    }
                                });
                            }
                        });
                    } else {
                        error = `The selected file "${file.name} [${file.size/1024} KB]" exceeds the maximum upload size of 5000KB.`;
                        swal("Invalid File Size!", error, "error");
                    }
                } else {
                    error = `Invalid file format chosen. Only CSV files are allowed.`;
                    swal("Invalid File Type!", error, "error");
                }
            }
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