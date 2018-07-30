(function ($) {
    "use strict";

    var $window   = $(window);
    var $document = $(document);
    var token;
    var loader;
    var appointmentModal;

    $document.ready(function() {
        var pageFooter      = $('footer#footer');
        var lmWrapper       = $('.lm-wrapper');
        var lmContainer     = $('.lm-map-container');
        var lmWrapperOffset = lmWrapper.offset().top;
        var lmWrapperHeight = $window.height() - lmWrapperOffset - $window.scrollTop();

        // set content height base on viewport
        lmWrapper.css({"height": lmWrapperHeight + "px"});
        lmContainer.css({"height": lmWrapperHeight + "px"});

        // remove pageFooter html
        pageFooter.remove();

        token            = $('#content').data('token');
        loader           = $('.loader-wrapper');
        appointmentModal = $('#modalScheduleAppointment');

        // hide loader
        loader.hide();

        // initialise date picker for appointment_date
        var date  = new Date();
        var today = new Date(date.getFullYear(), date.getMonth(), date.getDate());
        $('#input__appointment_date').datetimepicker({
            minDate: today,
            showTodayButton: true,
            pickTime: false,
            daysOfWeekDisabled: [0, 6],
            format: 'dddd, DD MMMM YYYY'
        });
        $('#input__appointment_time').datetimepicker({
            minDate: new Date(),
            pickDate: false,
            format: 'h:mm A'
        });
    });

    $document.on("click", ".lm-leftnav-toggle", function() {
        $(this).parent().find('.lm-leftnav').toggleClass('open');
    });

    $document.on("click", '.lm-leftnav-list-item > section', function() {
        $(this).parent().toggleClass('show-footer');
    });

    $document.on("change", '#lmf-team', function() {
        var obj = ($(this).val().length) ? { team: $(this).val() } : { team: 0 };
        var url = filterStateChange(obj, token);
        loader.show();
        window.location.href = url;
    });

    $document.on("change", '#lmf-salesrep', function() {
        var obj = ($(this).val().length) ? { salesrep: $(this).val() } : { salesrep: 0 };
        var url = filterStateChange(obj, token);
        loader.show();
        window.location.href = url;
    });

    $document.on("change", '#lmf-customer', function() {
        var obj = ($(this).val().length) ? { customer: $(this).val() } : { customer: 0 };
        var url = filterStateChange(obj, token);
        loader.show();
        window.location.href = url;
    });

    $document.on("click", 'input.lmf-type', function() {
        var obj = { type: $(this).val() };
        var url = filterStateChange(obj, token);
        loader.show();
        window.location.href = url;
    });

    $document.on("click", 'a[data-toggle="appointment-modal"]', function(e) {
        e.preventDefault();
        var appointmentModal = $('#modalScheduleAppointment');
        var customerId       = $(this).data('cid');
        var customerName     = $(this).data('cname');
        var salesrepId       = $(this).data('srid');
        var salesrepName     = $(this).data('srname');
        var appntmntAddress  = $(this).data('addr');

        appointmentModal.find('input[name="customer_id"]').val(customerId);
        appointmentModal.find('span#customer_name').html(customerName);
        appointmentModal.find('input[name="salesrep_id"]').val(salesrepId);
        appointmentModal.find('span#salesrep_name').html(salesrepName);
        appointmentModal.find('#input__salesrep_name').val(salesrepName);
        appointmentModal.find('#input__appointment_address').val(appntmntAddress);
        appointmentModal.modal('show');
    });

    $document.on("click", 'button[data-dismiss="modal"]', function() {
        resetAppointmentForm();
    });

    $document.on("click", '#button-reload', function() {
        loader.show();
    });

    $document.on("click", '#input__all_day_check', function() {
        var durationInput = $('#input__appointment_duration');
        $('#input__appointment_duration option:selected').removeAttr('selected');
        if ($(this).is(":checked")) {
            $('#input__appointment_duration option[value="1 Day"]').attr('selected', true);
            durationInput.val('1 Day').attr('disabled', true);
        } else {
            $('#input__appointment_duration option[value="30 Minutes"]').attr('selected', true);
            durationInput.val('30 Minutes').attr('disabled', false);
        }
    });

    $document.on("submit", '#form__schedule-appointment', function(e) {
        e.preventDefault();
        var $form = $(this);
        // validate form 
        if (validateAppointmentForm()) {
            appointmentModal.modal('hide');
            swal({
                title: "Create Appointment!",
                text: "Are you sure you want to schedule appointment for '"+$('#input__salesrep_name').val()+"'?",
                type: "warning",
                showCancelButton: true,
                confirmButtonClass: "btn-primary",
                confirmButtonText: "Yes, Schedule",
                closeOnConfirm: false,
                showLoaderOnConfirm: true
            },
            function(isConfirm){
                if (isConfirm) {
                    var token = $('#content').data('token');
                    var url   = `index.php?route=replogic/location_management/scheduleAppointment&token=${token}`;
                    var data  = $form.serialize();
                    $.ajax({
                        url      : url,
                        type     : 'POST',
                        data     : data,
                        dataType : 'json',
                        success  :  function(json) {
                            if (json['success']) {
                                $form[0].reset();
                                swal({
                                    title: "Appointment Created!", 
                                    text: json['message'], 
                                    type: "success"
                                }, function() {
                                    // reload page
                                    window.location.href = $('a#button-reload').attr('href');
                                });
                            } else {
                                swal({
                                    title: "Error!", 
                                    text: json['error'], 
                                    type: "error"
                                }, function() {
                                    // show modal
                                    appointmentModal.modal('show');
                                });
                            }
                        }
                    });
                }
            });
        }
    });

    $document.on("keyup", '#input__appointment_title', function() {
        $(this).closest('.form-group').removeClass('has-error').find('small.text-danger').remove();
        $(this).closest('form').find('button[type="submit"]').attr('disabled', false);
        if ($(this).val().length === 0) {
            $(this).after('<small class="text-danger bold">Enter appointment title<small>').closest('.form-group').addClass('has-error');
            $(this).closest('form').find('button[type="submit"]').attr('disabled', true);
        }
    });

}(jQuery));

/********************************************* 
 * Filters [dropdowns]
 *********************************************/

function filterStateChange(obj, token) {

    var url = `index.php?route=replogic/location_management&token=${token}`;

    // team
    if (obj['team'] !== undefined) {
        url += (obj['team'] > 0) ? `&filter_team_id=${obj['team']}` : ``;
    } else if (getURLVar('filter_team_id').length) {
        url += `&filter_team_id=${getURLVar('filter_team_id')}`;
    }

    // sales rep
    if (obj['salesrep'] !== undefined) {
        url += (obj['salesrep'] > 0) ? `&filter_salesrep_id=${obj['salesrep']}` : ``;
    } else if (getURLVar('filter_salesrep_id').length) {
        url += `&filter_salesrep_id=${getURLVar('filter_salesrep_id')}`;
    }

    // customer/business type
    if (obj['type'] !== undefined) {
        url += (obj['type'].length > 0) ? `&filter_type=${obj['type']}` : ``;
    } else if (getURLVar('filter_type').length) {
        url += `&filter_type=${getURLVar('filter_type')}`;
    }

    // customer
    if (obj['customer'] !== undefined) {
        url += (obj['customer'] > 0) ? `&filter_customer_id=${obj['customer']}` : ``;
    } else if (getURLVar('filter_customer_id').length) {
        url += `&filter_customer_id=${getURLVar('filter_customer_id')}`;
    }

    return url;
}

/********************************************* 
 * Google Map Marker/Pin
 *********************************************/

function createMarker(latlng, html) {
    var marker = new google.maps.Marker({
        position: latlng,
        map: map
    });

    google.maps.event.addListener(marker, 'click', function() {
        infowindow.setContent(html);
        infowindow.open(map, marker);
    });
    return marker;
}


/********************************************* 
 * Validate Appointment Form
 *********************************************/

function validateAppointmentForm() {
    var title    = $('#input__appointment_title');
    var customer = $('#input__customer_id');
    var salesrep = $('#input__salesrep_id');
    var valid    = true;

    // validate appointment title
    title.closest('.form-group').removeClass('has-error').find('small.text-danger').remove(); // clear previous error messages (if any)
    if (title.val().length === 0) {
        title.after('<small class="text-danger bold">Enter appointment title<small>').closest('.form-group').addClass('has-error');
        valid = false;
    }

    return valid;
}

function resetAppointmentForm() {
    var form = $('#form__schedule-appointment');
    form.find('.form-group').removeClass('has-error').find('small.text-danger').remove();
    form[0].reset();
}