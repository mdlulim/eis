(function ($) {
    "use strict";

    var $window   = $(window);
    var $document = $(document);
    var token;
    var loader;
    var pageId;
    var appointmentModal;
    var modalLoader;

    $document.ready(function() {
        var pageFooter      = $('footer#footer');
        var lmWrapper       = $('.lm-wrapper');
        var lmContainer     = $('.lm-map-container');

        if (lmContainer.length && lmWrapper.length) {
            var lmWrapperOffset = lmWrapper.offset().top;
            var lmWrapperHeight = $window.height() - lmWrapperOffset - $window.scrollTop();

            // set content height base on viewport
            lmWrapper.css({"height": lmWrapperHeight + "px"});
            lmContainer.css({"height": lmWrapperHeight + "px"});

            // remove pageFooter html
            pageFooter.remove();

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
        }

        token            = $('#content').data('token');
        loader           = $('.loader-wrapper');
        appointmentModal = $('#modalScheduleAppointment');
        modalLoader      = $('.modal__loader-overlay');
        pageId           = $('#content').data('page-id');

        // hide loader
        loader.hide();
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
        appointmentModal.find('#input__customer_name').val(customerName);

        // if location_management page check available times before show
        if (pageId === "location_management") {
            var date       = new Date().toDateString();
            var url        = `index.php?route=replogic/schedule_management/getSalesRepAppointmentTimesByDate&token=${token}`;
            $.ajax({
                url       : url,
                type      : 'GET',
                data      : { salesrep_id: salesrepId, date: date },
                dataType  : 'json',
                beforeSend: function() {
                    modalLoader.show();
                },
                success: function(json) {
                    modalLoader.hide();
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
                    appointmentModal.modal('show');
                }
            });
        } else {
            appointmentModal.modal('show');
        }
    });

    $document.on("hidden.bs.modal", '#modalScheduleAppointment', function() {
        resetAppointmentForm();
    });

    $document.on("click", '#button-reload', function() {
        loader.show();
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
                    var url   = `index.php?route=replogic/schedule_management/scheduleAppointment&token=${token}`;
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

    $document.on("click", '.row__available-times>div', function() {
        if (!$(this).hasClass('disabled')) {
            $('.row__available-times>div').removeClass('selected');
            $('#input__appointment_time').val($(this).text());
            $(this).addClass('selected');
        }
    });

    $document.on("change", '#input__appointment_date', function() {
        var date       = $(this).val();
        var salesrepId = $('#input__salesrep_id').val();
        var url        = `index.php?route=replogic/schedule_management/getSalesRepAppointmentTimesByDate&token=${token}`;
        $.ajax({
            url       : url,
            type      : 'GET',
            data      : { salesrep_id: salesrepId, date: date },
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
    var time     = $('#input__appointment_time');
    var valid    = true;

    // validate appointment title
    title.closest('.form-group').removeClass('has-error').find('small.text-danger').remove(); // clear previous error messages (if any)
    if (title.val().length === 0) {
        title.after('<small class="text-danger bold">Enter appointment title<small>').closest('.form-group').addClass('has-error');
        valid = false;
    }

    // validate appointment time
    if (time.val().length === 0) {
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


/********************************************* 
 * Create Map Marker/Pin [Google Map]
 *********************************************/

function createMarker(data, type) {

    // geocoder
    geocoder.geocode({'address': data.address}, function(results, status) {
        if (status === "OK") {
            if (results.length) {
                var coordinates = results[0].geometry.location;
                var html   = getInfoWindowContent(data, type);
                var marker = new google.maps.Marker({
                    position: coordinates,
                    name: data.id,
                    map: map,
                    icon: data.icon
                });
                google.maps.event.addListener(marker, 'click', function() {
                    infoWindow.setContent(html);
                    infoWindow.open(map, marker);
                });
                markers.push(marker);
            }
        } else {
            /////// an error has occured: write relevant code underneath ///////
        }
    });
}


/********************************************* 
 * Google Map Marker/Pin Info Window Content
 *********************************************/

function getInfoWindowContent(data, type) {
    var html = ``;
    switch(type) {

        // Customer
        case 'customer':
            html += `<div class="gmap__infowindow ${type}">`;
            html += `<div class="row">`;
            html += `<div class="col__icon"><i class='material-icons'>&#xe0af</i></div>`;
            html += `<div class="col__content"><b>${data.name}</b><br/>${data.address}</div>`;
            html += `</div>`;
            html += `<div class="row"><hr/></div>`;
            html += `<div class="row">`;
            html += `<div class="col__icon">&nbsp;</div>`;
            html += `<div class="col__content"><b>Last visited:</b> ${data.last_visit}<br/>`;
            html += `<a href="#" data-toggle="appointment-modal" data-cname="${data.name}" data-cid="${data.id}" data-srname="${data.sr_name}" data-srid="${data.sr_id}" data-addr="${data.address}">Schedule Appointment...</a></div>`;
            html += `</div>`;
            html += `</div>`;
            break;
        
        // Sales Rep Checked-In Location
        case 'checkin':
            html += `<div class="gmap__infowindow ${type}">`;
            html += `<div class="row">`;
            html += `<div class="col__icon"><i class='material-icons'>event</i></div>`;
            html += `<div class="col__content">${data.visit_time} &nbsp;&nbsp; ${data.visit_date}</div>`;
            html += `</div>`;
            html += `<div class="row"><hr/></div>`;
            html += `<div class="row">`;
            html += `<div class="col__icon"><i class='material-icons'>&#xe0af</i></div>`;
            html += `<div class="col__content"><b>Customer Name:</b><br/>`;
            html += `${data.customer}<br/>`;
            html += `${data.customer_address}<br/>`;
            html += `<span class="loc__last-checkin" style="margin-top:5px">`;
            html += `<i class="material-icons">beenhere</i>`;
            html += `<span>${data.last_seen} </span>`;
            html += `</span></div>`;
            html += `</div>`;
            html += `<div class="row"><hr/></div>`;
            html += `<div class="row">`;
            html += `<div class="col__icon"><i class='material-icons text-danger'>&#xe55f</i></div>`;
            html += `<div class="col__content"><b>GPS Address</b><br/>${data.gps_address}</div>`;
            html += `</div>`;
            html += `<div class="row" style="margin-top:13px">`;
            html += `<div class="col__icon"><i class='material-icons' style="color:#32DB64">beenhere</i></div>`;
            html += `<div class="col__content"><b>Rep Reported Address</b><br/>${data.address}</div>`;
            html += `</div>`;
            html += `</div>`;
            break;
        
        // Sales Rep GPS Location
        case 'salesrep':
            html += `<div class="gmap__infowindow ${type}">`;
            html += `<div class="row">`;
            html += `<div class="col__icon"><i class='material-icons'>&#xe7fd</i></div>`;
            html += `<div class="col__content">Sales Rep: <b>${data.name}</b></div>`;
            html += `</div>`;
            html += `<div class="row" style="margin-top:13px">`;
            html += `<div class="col__icon"><i class='material-icons text-danger'>&#xe55f</i></div>`;
            html += `<div class="col__content"><b>GPS Address</b><br/>${data.address}</div>`;
            html += `</div>`;
            html += `</div>`;
            break;
    }
    return html;
}