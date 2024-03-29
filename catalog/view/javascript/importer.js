var Importer = {};

Importer.fileMaxSize = 5000;
Importer.fileFormats = [
    'text/csv', 
    'text/x-csv',
    'application/vnd.ms-excel', 
    'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
    'application/csv',
    'application/x-csv',
    'text/comma-separated-values',
    'text/x-comma-separated-values'
];

Importer.init = function() {
    
};

Importer.triggerFileUpload = function (element) {
    var fileInput = $(element).parent().find('input');
    fileInput.trigger('click');
};

Importer.uploadFile = function(input) {
    var file = $(input)[0].files[0];
    if (file) {
        var error;
        var fileSize = parseInt(file.size / 1024); // convert to KB
        if (Importer.fileFormats.indexOf(file.type) !== -1) {
            if (fileSize <= Importer.fileMaxSize) {
                var text = '';
                if ($("#form-cart-importer").length) {
                    text = `You are about to import   "${file.name}"  to your shopping cart.`;
                } else if ($("#form-stocksheet-importer").length) {
                    text = `You are about to import   "${file.name}"  to your stock sheet.`;
                }
                swal({
                    title: "Are you sure?",
                    text: text,
                    type: "warning",
                    showCancelButton: true,
                    confirmButtonClass: "btn-info",
                    confirmButtonText: "Yes, import it!",
                    closeOnConfirm: false,
                    showLoaderOnConfirm: true
                },
                function(isConfirm) {
                    if (isConfirm) {
                        if ($("#form-cart-importer").length) {
                            var formData      = new FormData(document.getElementById("form-cart-importer"));
                            var postUrl       = 'index.php?route=checkout/cart/import';
                            var importModal   = $('#modalImportCart');
                            var actionButton  = 'button[data-action="add_to_cart"]';
                            var localstoreVar = 'cart_products';
                        } else if ($("#form-stocksheet-importer").length) {
                            var formData      = new FormData(document.getElementById("form-stocksheet-importer"));
                            var postUrl       = 'index.php?route=account/stocksheet/import';
                            var importModal   = $('#modalImportStocksheet');
                            var actionButton  = 'button[data-action="add_to_stocksheet"]';
                            var localstoreVar = 'stocksheet_products';
                        }
                        
                        
                        var ajaxLoader  = importModal.find('.ajax__loader');
                        $.ajax({
                            url: `${postUrl}&action=upload`,
                            type: 'post',
                            dataType: 'json',
                            data: formData,
                            processData: false,
                            contentType: false,
                            success: function(json) {
                                if (json['success']) {
                                    var products = json['found'];
                                    swal({
                                        title: "Continue?",
                                        text: json['success'],
                                        type: "success",
                                        showCancelButton: true,
                                        confirmButtonClass: "btn-info",
                                        confirmButtonText: "Yes, continue!",
                                        closeOnConfirm: true,
                                        showLoaderOnConfirm: true
                                    },
                                    function (isConfirm) {
                                        if (isConfirm) {
                                            var postData      = {};
                                            postData.products = products;
                                            $.ajax({
                                                url: `${postUrl}&action=validate`,
                                                type: 'post',
                                                dataType: 'json',
                                                data: postData,
                                                beforeSend: function() {
                                                    ajaxLoader.addClass('load');
                                                    importModal.modal('show');
                                                    importModal.find('button').attr('disabled', true);
                                                    importModal.find(actionButton).prop('disabled', true).html('Processing...');
                                                },
                                                success: function(json) {
                                                    importModal.find('button').attr('disabled', false);
                                                    importModal.find(actionButton).attr('disabled', false).html('Continue');
                                                    if (json['success']) {
                                                        ajaxLoader.removeClass('load');
                                                        importModal.find('.text-area').append(`<div class="alert alert-success">${json['success']}</div>`);
                                                        $('#steps-uid-0-t-1').find('.current-info').remove();
                                                        $('#steps-uid-0-t-1').parent().removeClass('current').addClass('done');
                                                        $('#steps-uid-0-t-2').parent().addClass('current');
                                                        localStorage.setItem(localstoreVar, json['products']);
                                                    } else {
                                                        ajaxLoader.removeClass('load');
                                                        importModal.modal('hide');
                                                        swal("Error!", json['error'], "error");
                                                    }
                                                }
                                            });
                                        } else {
                                            var hiddenForm = $('#form__import-items-not-found');
                                            hiddenForm.find('input[name="items"]').val(JSON.stringify(json['not_found']));
                                            hiddenForm.submit();
                                        }
                                    });
                                } else {
                                    if (json['warning']) {
                                        var products = json['found'];
                                        swal({
                                            title: "Continue with errors?",
                                            text: json['warning'],
                                            type: "warning",
                                            showCancelButton: true,
                                            confirmButtonClass: "btn-warning",
                                            confirmButtonText: "Yes, continue!",
                                            closeOnConfirm: true,
                                            showLoaderOnConfirm: true
                                        },
                                        function (isConfirm) {
                                            if (isConfirm) {
                                                var postData      = {};
                                                postData.products = products;
                                                $.ajax({
                                                    url: `${postUrl}&action=validate`,
                                                    type: 'post',
                                                    dataType: 'json',
                                                    data: postData,
                                                    beforeSend: function() {
                                                        ajaxLoader.addClass('load');
                                                        importModal.modal('show');
                                                        importModal.find('button').attr('disabled', true);
                                                        importModal.find(actionButton).prop('disabled', true).html('Processing...');
                                                    },
                                                    success: function(json) {
                                                        importModal.find('button').attr('disabled', false);
                                                        importModal.find(actionButton).attr('disabled', false).html('Continue');
                                                        if (json['success']) {
                                                            ajaxLoader.removeClass('load');
                                                            importModal.find('.text-area').append(`<div class="alert alert-success">${json['success']}</div>`);
                                                            $('#steps-uid-0-t-1').find('.current-info').remove();
                                                            $('#steps-uid-0-t-1').parent().removeClass('current').addClass('done');
                                                            $('#steps-uid-0-t-2').parent().addClass('current');
                                                            localStorage.setItem(localstoreVar, json['products']);
                                                        } else {
                                                            ajaxLoader.removeClass('load');
                                                            importModal.modal('hide');
                                                            swal("Error!", json['error'], "error");
                                                        }
                                                    }
                                                });
                                            } else {
                                                var hiddenForm = $('#form__import-items-not-found');
                                                hiddenForm.find('input[name="items"]').val(JSON.stringify(json['not_found']));
                                                hiddenForm.submit();
                                            }
                                        });
                                    } else {
                                        swal("Error!", json['error'], "error");
                                    }
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
};

Importer.addItemsToCart = function(element) {
    var postUrl     = 'index.php?route=checkout/cart/import&action=' + $(element).attr('data-action');
    var finish      = ($(element).attr('data-action') === "finish");
    var postData    = { products: localStorage.getItem('cart_products') };
    var importModal = $('#modalImportCart');
    var ajaxLoader  = importModal.find('.ajax__loader');
    if (!finish) {
        $.ajax({
            url: postUrl,
            type: 'post',
            dataType: 'json',
            data: postData,
            beforeSend: function() {
                importModal.find('button').attr('disabled', true);
                ajaxLoader.addClass('load');
                importModal.find('.alert').remove();
                $(element).prop('disabled', true).html('Processing...');
            },
            success: function(json) {
                importModal.find('button').attr('disabled', false);
                ajaxLoader.removeClass('load');
                if (json['success']) {
                    importModal.find('.text-area').append(`<div class="alert alert-success">${json['success']}</div>`);
                    $('#steps-uid-0-t-2').find('.current-info').remove();
                    $('#steps-uid-0-t-2').parent().removeClass('current').addClass('done');
                    $('#steps-uid-0-t-3').parent().addClass('current');
                    $(element).attr('data-action', 'finish').attr('disabled', false).html('Finish');
                } else {
                    $(element).attr('disabled', false).html('Continue');
                    importModal.modal('hide');
                    swal("Error!", json['error'], "error");
                }
            },
            error: function(xhr,status,error) {
                if (status.indexOf("error") !== -1) {
                    importModal.find('button').attr('disabled', false);
                    ajaxLoader.removeClass('load');
                    importModal.modal('hide');
                    $(element).html('Continue');
                    swal("Error!", 'An unexpected error has occured. Please try again', "error");
                }
            }
        });
    } else {
        importModal.find('button').attr('disabled', true);
        importModal.find('.alert').remove();
        ajaxLoader.addClass('load');
        $(element).html('Refreshing...');
        location.href = 'index.php?route=checkout/cart';
    }
};

Importer.addItemsToStocksheet = function(element) {
    var postUrl     = 'index.php?route=account/stocksheet/import&action=' + $(element).attr('data-action');
    var finish      = ($(element).attr('data-action') === "finish");
    var postData    = { products: localStorage.getItem('stocksheet_products') };
    var importModal = $('#modalImportStocksheet');
    var ajaxLoader  = importModal.find('.ajax__loader');
    if (!finish) {
        $.ajax({
            url: postUrl,
            type: 'post',
            dataType: 'json',
            data: postData,
            beforeSend: function() {
                importModal.find('button').attr('disabled', true);
                ajaxLoader.addClass('load');
                importModal.find('.alert').remove();
                $(element).prop('disabled', true).html('Processing...');
            },
            success: function(json) {
                importModal.find('button').attr('disabled', false);
                ajaxLoader.removeClass('load');
                if (json['success']) {
                    importModal.find('.text-area').append(`<div class="alert alert-success">${json['success']}</div>`);
                    $('#steps-uid-0-t-2').find('.current-info').remove();
                    $('#steps-uid-0-t-2').parent().removeClass('current').addClass('done');
                    $('#steps-uid-0-t-3').parent().addClass('current');
                    $(element).attr('data-action', 'finish').attr('disabled', false).html('Finish');
                } else {
                    $(element).attr('disabled', false).html('Continue');
                    importModal.modal('hide');
                    swal("Error!", json['error'], "error");
                }
            },
            error: function(xhr,status,error) {
                if (status.indexOf("error") !== -1) {
                    importModal.find('button').attr('disabled', false);
                    ajaxLoader.removeClass('load');
                    importModal.modal('hide');
                    $(element).html('Continue');
                    swal("Error!", 'An unexpected error has occured. Please try again', "error");
                }
            }
        });
    } else {
        importModal.find('button').attr('disabled', true);
        importModal.find('.alert').remove();
        ajaxLoader.addClass('load');
        $(element).html('Refreshing...');
        location.href = 'index.php?route=account/stocksheet';
    }
};

