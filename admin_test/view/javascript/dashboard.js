(function($) {

    'use strict';

    var initLoader = function () {
        $(document).ready(function() {
            if ($('.loader-wrapper').length > 0) {
                $('.loader-wrapper').hide();
            }
        });
    };

    var initPrompChangePassword = function () {
        $(document).ready(function() {
            if (location.search.indexOf('prompt_change_password=1') !== -1) {
                swal({
                    title: "Choose Your Password",
                    text: "You logged in with a system generated password. You will now be asked to choose your own password.",
                    type: "info",
                    showCancelButton: false,
                    confirmButtonClass: "btn btn-info",
                    confirmButtonText: "Ok, proceed",
                    closeOnConfirm: false
                },
                function() {
                    var token = getURLVar('token');
                    var redirect = "index.php?route=common/choose_password&token="+token;
                    location.href = redirect;
                });
            }
        });
    };

    var initMenuEvents = function () {
        $(document).on("click", '#Dashboard li a', function () {
            if ($('.loader-wrapper').length > 0) {
                $('.loader-wrapper').show();
            }
        });
    };

    var initDataTables = function () {
        $(document).ready(function() {
            // latest appointment data table
            if ($('#latestAppointmentsTbl').length > 0) {
                var aOptions = {
                    "sDom"           : "<t><'row'<'col-md-12'i p>>",
                    "oLanguage"      : {"sLengthMenu":"_MENU_ ","sInfo":"Showing _START_ to _END_ of _TOTAL_"},
                    "iDisplayLength" : 10
                };
                $('#latestAppointmentsTbl').DataTable(aOptions);
            }

            // customers by orders data table
            if ($('#customersByOrdersTbl').length > 0) {
                var cOptions = {
                    "sDom"           : "<t><'row'<'col-md-12'i p>>",
                    "oLanguage"      : {"sLengthMenu":"_MENU_ ","sInfo":"Showing _START_ to _END_ of _TOTAL_"},
                    "iDisplayLength" : 10
                };
                $('#customersByOrdersTbl').DataTable(cOptions);
            }
        });
    };

    var initDateFilter = function () {
        $(document).ready(function() {
            if (location.search.indexOf("filter_time_frame=custom") !== -1) {
                $('.date-picker').datetimepicker({
                    pickTime: false,
                    format: 'DD MMMM YYYY'
                });
            }
        });
    	$(document).on("change", '#filter_time_frame', function() {
            switch ($(this).val()) {
                case "custom":
                    $('.tf-range').show();
                    $('.tf-no-range').hide();
                    $('.date-picker').datetimepicker({
                        pickTime: false,
                        format: 'DD MMMM YYYY'
                    });
                    break;

                default:
                    $('.loader-wrapper').show();
                    var url = $(this).closest("form").attr("action");
                    window.location.href = url + "&filter_time_frame=" + $(this).val();
                    break;
            }
    	});
        $(document).on("click", '#btn-custom-filter', function(e) {
            e.preventDefault();
            var dateFrom = $('#filter-range-from').val();
            var dateTo = $('#filter-range-to').val();
            var url = $(this).closest("form").attr("action");
            $('.loader-wrapper').show();
            window.location.href = url + "&filter_time_frame=custom&filter_date_from="+dateFrom+"&filter_date_to="+dateTo;
        });
        $(document).on("click", 'a.disabled', function(e) {
            e.preventDefault();
            return false;
        });
        $(document).on("click", '.tf-no-range > a', function(e) {
            console.log("click");
            $('.loader-wrapper').show();
        });
    };
    initLoader();
    initPrompChangePassword();
    initMenuEvents();
    initDateFilter();
    initDataTables();

})(window.jQuery);