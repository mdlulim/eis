(function ($) {
    "use strict";

    $(document).ready(function() {
        if ($('select[name="category"]').val().length) {
            $('select[name="category"]').trigger('change');
        }
    });

    $(document).on('change', 'select[name="category"]', function() {
        var category = $(this).val();
        var token    = $('#content').data('token');
        var route    = 'setting/configuration/get';
        $.ajax({
            url      : `index.php?route=${route}`,
            type     : 'GET',
            dataType : 'json',
            data     : { token: token, category: category },
            success  : function(json) {
                $('#config').html('');
                $('#config').html(getTemplate(json, category));
            }
        });
    });

    // hide or show fields based on selection
    $(document).on('change', '#newSettingModal select[name="type"]', function() {
        var $this = $(this);
        var modal = $('#newSettingModal');
        var type  = $this.val();
        switch (type) {
            case 'checkbox':
            case 'link':
            case 'radio':
            case 'select':
                // hide 'length'
                modal.find('input[name="length"]').closest('.form-group').hide();

                // link does not need 'values'
                if (type === "link") {
                    modal.find('input[name="values"]').closest('.form-group').hide();
                } else {
                    modal.find('input[name="values"]').closest('.form-group').show();
                }
                break;

            case 'text':
                modal.find('input[name="length"]').closest('.form-group').show();
                modal.find('input[name="values"]').closest('.form-group').hide();
                break;
        }
    });

    $(document).on('click', '.btn-add', function(e) {
        e.preventDefault();
        var modal    = $('#newSettingModal');
        var category = $(this).data('category');
        var section  = $(this).data('section');
        modal.find('.modal-title').html(`Add ${category[0].toUpperCase()}${category.substr(1)} Config Setting`);
        modal.find('input[name="category"]').val(category);
        modal.find('input[name="section"]').val(section.toLowerCase());
        modal.modal('show');
    });

    $(document).on('click', '.btn-save', function() {
        var modal = $('#newSettingModal');
        var form  = modal.find('form');
        var token = $('#content').data('token');
        var route = 'setting/configuration/add';

        // validate user input
        if (!newSettingValid()) {
            swal("Validation Error!", "Please complete all fields marked as required (*).", "error");
            return false;
        }

        $.ajax({
            url      : `index.php?route=${route}&token=${token}`,
            type     : 'POST',
            dataType : 'json',
            data     : form.serialize(),
            success  : function(json) {
                if (json.success) {
                    var data = json.data;
                    var html = getConfigTypeHtml(data);
                    if ($('fieldset[data-category="' + data.category + '"][data-section="' + data.section + '"]').find('.btn-submit-container').length) {
                        $('fieldset[data-category="' + data.category + '"][data-section="' + data.section + '"]').find('.btn-submit-container').before(html);
                    } else {
                        $('fieldset[data-category="' + data.category + '"][data-section="' + data.section + '"]').append(html);
                    }
                    
                }
                modal.modal('hide');
            }
        });
    });

    // reset form on modal close
    $(document).on('hidden.bs.modal', '#newSettingModal', function (e) {
        $(this).find('.form-group').removeClass('has-error has-success');
        $(this).find('form')[0].reset();
    });

    // prompt user to 'save changes' made on [ text, radio, checkbox ] input fields
    $(document).on('keyup change', 'form input', function() {
        var btnHtml   = getSaveButtonHtml();
        var container = $(this).closest('fieldset').find('.btn-submit-container');
        if (!container.length) {
            $(this).closest('fieldset').append(btnHtml);
        }
    });

    // prompt user to 'save changes' made on select change event
    $(document).on('change', 'form select', function() {
        var btnHtml   = getSaveButtonHtml();
        var container = $(this).closest('fieldset').find('.btn-submit-container');
        if (!container.length) {
            $(this).closest('fieldset').append(btnHtml);
        }
    });

    // discard changes of the active config settings section
    $(document).on('click', '.btn-submit-container .btn-cancel', function() {
        swal({
            title: "Discard changes?",
            text: "This action will refresh your page.",
            type: "warning",
            showCancelButton: true,
            confirmButtonClass: "btn-info",
            confirmButtonText: "Yes, cancel!",
            closeOnConfirm: false,
            showLoaderOnConfirm: true
        },
        function(isConfirm){
            if (isConfirm) {
                var token = $('#content').data('token');
                location.href = `index.php?route=setting/configuration&token=${token}`;
            }
        });
    });

    // save changes of the active config settings section
    $(document).on('click', '.btn-submit-container .btn-submit-changes', function() {
        var $this   = $(this);
        var section = $this.closest('.btn-submit-container').data('section');
        var text    = `You are about to save changes for ${section}.`;
        swal({
            title: "Save changes?",
            text: text,
            type: "warning",
            showCancelButton: true,
            confirmButtonClass: "btn-info",
            confirmButtonText: "Yes, proceed!",
            closeOnConfirm: false,
            showLoaderOnConfirm: true
        },
        function(isConfirm){
            if (isConfirm) {
                // save changes using ajax
                var data  = $this.closest('form').serialize();
                var token = $('#content').data('token');
                var route = 'setting/configuration/set';
                $.ajax({
                    url      : `index.php?route=${route}&token=${token}`,
                    type     : 'POST',
                    dataType : 'json',
                    data     : data,
                    success  : function(json) {
                        if (json.success) {
                            $this.closest('.btn-submit-container').remove();
                            swal("Success!", "Saved changes!.", "success");
                        } else {
                            swal("Error!", "An unexpected error has occured!.", "error");
                        }
                    }
                });
            }
        });
    });

}(jQuery));

function getTemplate(data, category) {
    var html = ``;
    if (typeof data === "object") {
        for (var key in data) {
            var fields = ``;
            html += `<fieldset data-category="${category}" data-section="${key}"><legend>${key}</legend>`;
            html += `<div class="row"><div class="col-md-12"><a href="#" class="btn btn-sm btn-primary btn-add pull-right" data-category="${category}" data-section="${key}"><i class="fa fa-plus"></i> Add Setting</a></div></div>`;
            for (var i=0; i<data[key].length; i++) {
                fields += getConfigTypeHtml(data[key][i]);
            }
            html += fields;
            html += `</fieldset>`;
        }
    } else {
        html = `<fieldset><legend>${category}</legend><div style="text-align:center; padding-bottom:15px;"><em>No configuration settings available for ${title}.</em></div></fieldset>`;
    }
    return `<form class="form-horizontal">${html}</form>`;
}

function getConfigTypeHtml(data) {
    
    switch (data.type) {

        /************************************************
         * radio input
         ************************************************/

        case 'radio':
            var values = data.values.split(',');
            return `<div class="form-group">
                <label class="col-sm-2 control-label text-right">${data.name}</label>
                <div class="col-sm-10">
                    <label class="radio-inline">
                        <input type="radio" name="config_field_id[${data.config_field_id}]" value="${values[0]}" ${(values[0]===data.value) ? 'checked': ''}>&nbsp;
                        ${values[0]}
                    </label>&nbsp;&nbsp;
                    <label class="radio-inline">
                        <input type="radio" name="config_field_id[${data.config_field_id}]" value="${values[1]}" ${(values[1]===data.value) ? 'checked': ''}>&nbsp;
                        ${values[1]}
                    </label>
                </div>
            </div>`;

        /************************************************
         * text input
         ************************************************/

        case 'text':
            return `<div class="form-group">
                <label class="col-sm-2 control-label text-right">${data.name}</label>
                <div class="col-sm-10">
                    <input type="text" class="form-control" name="config_field_id[${data.config_field_id}]" value="${data.value}" maxlen="${data.length}" />
                </div>
            </div>`;

        /************************************************
         * select
        ************************************************/

        case 'select':
            var values = data.values.split(',');
            var html   = `<div class="form-group">
                <label class="col-sm-2 control-label text-right">${data.name}</label>
                <div class="col-sm-10">
                    <select class="form-control" name="config_field_id[${data.config_field_id}]">`;
            for (var i=0; i<values.length; i++) {
                html += `<option value="${values[i].toLowerCase()}" ${(values[i]==data.value) ? 'selected': ''}>${values[i]}</option>`;
            }
            html += `</select></div></div>`;
            return html;

        /************************************************
         * link
         ************************************************/

        case 'link':
            return `<div class="form-group">
                <label class="col-sm-2 control-label text-right">${data.name}</label>
                <div class="col-sm-10">
                    <a href="${data.value}" target="_blank" class="btn btn-primary"><i class="fa fa-link"></i> View Details</a>
                </div>
            </div>`;
    }
}

function getSaveButtonHtml() {
    return `<div class="form-group btn-submit-container">
        <div class="col-sm-10 col-sm-push-2">
            <button type="button" class="btn btn-default btn-cancel">Cancel</button>&nbsp;
            <button type="button" class="btn btn-primary btn-submit-changes">Save Changes</button>
        </div>
    </div>`;
}

function newSettingValid() {
    var valid = true;
    var modal = $('#newSettingModal');
    modal.find('input,select').each(function(k,v) {
        var el = $(this);
        el.closest('.form-group').removeClass('has-error has-success');
        if (el.closest('.form-group').hasClass('required') && !el.closest('.form-group').is(':hidden')) {
            if (!el.val().length) {
                el.closest('.form-group').addClass('has-error');
                valid = false;
            } else {
                el.closest('.form-group').addClass('has-success');
            }
        }
    });
    return valid;
}