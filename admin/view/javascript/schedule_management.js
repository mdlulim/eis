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

}(jQuery));