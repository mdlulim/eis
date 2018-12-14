(function ($) {
    "use strict";
    
    var $document = $(document);
    var pageId;

    $document.ready(function() {
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
    });

    $document.on('change', '#input__appointment_type', function () {
        var optVal           = $("#input__appointment_type option:selected").val();
        var newBusiness      = $(".newbusiness");
        var existingBusiness = $(".custmr_id");

        if(optVal == 'New Business') {
            newBusiness.show();
            existingBusiness.hide();
        } else if(optVal == 'Existing Business') {
            newBusiness.hide();
            existingBusiness.show();
        } else {
            newBusiness.hide();
            existingBusiness.hide();
        }
    });

    $document.on('change','select[name="salesrep_id"]', function() {
        var token       = $('#content').data('token');
        var salesrep_id = $('select[name="salesrep_id"] option:selected').val();
        $('select[name="salesrep_id"]').html();
        $('#div__available-times').hide();
        if ($(this).val().length > 0) {
            $.ajax({
                url: `index.php?route=replogic/schedule_management/getCustomer&token=${token}`,
                type: 'post',
                data: `salesrep_id=${salesrep_id}`,
                dataType: 'json',
                crossDomain: true,
                success: function(json) {
                    var html = `<option value="">Select Customer</option>`;
                    if (json && json != '') {
                        for (var i = 0; i < json.length; i++) {
                            html += `<option value="${json[i]['customer_id']}">${json[i]['firstname']}</option>`;
                        }
                    } else {
                        html += `<option value="">No Found Customer</option>`;
                    }
                    $('select[name="customer_id"]').html(html);
                    $('#div__available-times').show();
                },
                error: function(xhr, ajaxOptions, thrownError) {
                    alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
                }
            });
        }
	});

	$document.on('change', 'select[name="customer_id"]', function() {
        var token       = $('#content').data('token');
        var customer_id = $('select[name="customer_id"] option:selected').val();
		$.ajax({
            url: `index.php?route=replogic/schedule_management/getaddress&token=${token}`,
            type: 'post',
            data: `customer_id=${customer_id}`,
            dataType: 'json',
            crossDomain: true,
            success: function(json) {
                $('#input-appointment_address').val(json);
            },
            error: function(xhr, ajaxOptions, thrownError) {
                alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
            }
        });
	
    });
    
    $document.on('click', 'button[type="submit"][form="form__schedule-appointment"]', function(e) {
        e.preventDefault();
        $('#form__schedule-appointment').submit();
    });

    $document.on("submit", '#form__schedule-appointment', function(e) {
        e.preventDefault();
        var $form = $(this);
        var $data = $form.serialize();
        
        // validate form 
        if (validateAppointmentForm()) {
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
                    var url   = `index.php?route=replogic/schedule_management/scheduleAppointment&token=${token}`;
                    $.ajax({
                        url      : url,
                        type     : 'POST',
                        data     : $data,
                        dataType : 'json',
                        success  :  function(json) {
                            if (json['success']) {
                                $form[0].reset();
                                swal({
                                    title: "Appointment Created!", 
                                    text: json['message'], 
                                    type: "success"
                                }, function() {
                                    // redirect
                                    window.location.href = $('#content').attr('data-redirect-url');
                                });
                            } else {
                                swal("Error!", json['error'], "error");
                            }
                        }
                    });
                }
            });
        }
    });

    $document.on("click", '#input__all_day_check', function() {
        var durationInput    = $('#input__appointment_duration');
        var appointmentTimes = $('.row__available-times>div');
        var appointmentTime  = $('#input__appointment_time');

        appointmentTimes.removeClass('selected');
        appointmentTime.val('');
        $('#input__appointment_duration option:selected').removeAttr('selected');

        if ($(this).is(":checked")) {
            $('#input__appointment_duration option[value="1 Day"]').prop('selected', true);
            durationInput.val('1 Day');
            appointmentTimes.each(function(k,v) {
                if (!$(this).hasClass('disabled')) {
                    $(this).addClass('selected');
                    appointmentTime.val($(this).text());
                    return false;
                }
            });
        } else {
            durationInput.val('30 minutes');
            $('#input__appointment_duration option[value="0:30"]').prop('selected', true);
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

    $document.on("click", '.row__available-times>div', function() {
        if (!$(this).hasClass('disabled')) {
            $('.row__available-times>div').removeClass('selected');
            $('#input__appointment_time').val($(this).text());
            $(this).addClass('selected');
        }
    });

    $document.on("change", '#input__appointment_date', function() {
        var token      = $('#content').data('token');
        var date       = $(this).val();
        var salesrepId = $('#input__salesrep_id').val();
        if (salesrepId.length > 0) {
            getBookingTimes(date, salesrepId, token);
        } else {
            $('#input__salesrep_id').closest('.form-group').removeClass('has-error').find('small.text-danger').remove(); // clear previous error messages (if any)
            $('#input__salesrep_id').after('<small class="text-danger bold">Select Sales Rep<small>').closest('.form-group').addClass('has-error');
            $('#input__appointment_date').val($('#input__appointment_date').data('today'));
            return false;
        }
    });

    $document.on('change', '#input__salesrep_id', function() {
        if ($(this).val().length > 0) {
            $(this).closest('.form-group').removeClass('has-error');

            // get booking times for the selected sales rep
            var token      = $('#content').data('token');
            var date       = $('#input__appointment_date').val();
            var salesrepId = $(this).val();
            getBookingTimes(date, salesrepId, token);
        }
    });

    $document.on("change", '#input__appointment_duration', function() {
        var allDayCheck = $('#input__all_day_check');
        if ($(this).val() === "1 Day") {
            allDayCheck.prop('checked', true);
        } else {
            allDayCheck.prop('checked', false);
        }
    });

}(jQuery));


/********************************************* 
 * Validate Appointment Form
 *********************************************/

function validateAppointmentForm() {
    var type     = $('#input__appointment_type');
    var title    = $('#input__appointment_title');
    var customer = $('#input__customer_id');
    var salesrep = $('#input__salesrep_id');
    var time     = $('#input__appointment_time');
    var valid    = true;

    // validate appointment type
    type.closest('.form-group').removeClass('has-error').find('small.text-danger').remove(); // clear previous error messages (if any)
    if (type.val().length === 0) {
        type.after('<small class="text-danger bold">Select business type<small>').closest('.form-group').addClass('has-error');
        valid = false;
    }

    // validate appointment title
    title.closest('.form-group').removeClass('has-error').find('small.text-danger').remove(); // clear previous error messages (if any)
    if (title.val().length === 0) {
        title.after('<small class="text-danger bold">Enter appointment title<small>').closest('.form-group').addClass('has-error');
        valid = false;
    }

    // validate appointment time
    if (time.val().length === 0 && valid) {
        swal("Error!", "Please select time of the appointment", "error");
        valid = false;
    }

    return valid;
}

// reset appointment form
function resetAppointmentForm() {
    var form  = $('#form__schedule-appointment');
    form.find('.form-group').removeClass('has-error').find('small.text-danger').remove();
    form[0].reset();
}

function getBookingTimes(appointment_date, salesrep_id, token) {
    var url = `index.php?route=replogic/schedule_management/getSalesRepAppointmentTimesByDate&token=${token}`;
    $.ajax({
        url       : url,
        type      : 'GET',
        data      : { salesrep_id:salesrep_id, date:appointment_date },
        dataType  : 'json',
        beforeSend: function() {
            // loader here...
        },
        success: function(json) {
            if (json['booked_times']) {
                var times = json['booked_times'];
                $('.row__available-times>div')
                .removeClass('disabled selected')
                .each(function(k,v) {
                    if (times.indexOf($(this).text()) >= 0) {
                        $(this).addClass('disabled');
                    }
                });
            }
        }
    });
}