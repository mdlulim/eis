var Importer = {};

Importer.fileMaxSize = 5000;
Importer.fileFormats = ['text/csv', 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet'];

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
                swal({
                    title: "Are you sure?",
                    text: `You are about to import   "${file.name}"  to your shopping cart.`,
                    type: "warning",
                    showCancelButton: true,
                    confirmButtonClass: "btn-info",
                    confirmButtonText: "Yes, import it!",
                    closeOnConfirm: false,
                    showLoaderOnConfirm: true
                },
                function(isConfirm) {
                    if (isConfirm) {
                        var formData    = new FormData(document.getElementById("form-cart-importer"));
                        var postUrl     = 'index.php?route=checkout/cart/import';
                        var importModal = $('#modalImportCart');
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
                                    $('#modalImportCart').modal('show');
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
                                                var postData   = {};
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
                                                        importModal.find('button[data-action="add_to_cart"]').prop('disabled', true).html('Processing...');
                                                    },
                                                    success: function(json) {
                                                        importModal.find('button').attr('disabled', false);
                                                        importModal.find('button[data-action="add_to_cart"]').attr('disabled', false).html('Continue');
                                                        if (json['success']) {
                                                            ajaxLoader.removeClass('load');
                                                            importModal.find('.text-area').append(`<div class="alert alert-success">${json['success']}</div>`);
                                                            $('#steps-uid-0-t-1').find('.current-info').remove();
                                                            $('#steps-uid-0-t-1').parent().removeClass('current').addClass('done');
                                                            $('#steps-uid-0-t-2').parent().addClass('current');
                                                            localStorage.setItem('cart_products', json['products']);
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