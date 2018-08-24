(function ($) {
    "use strict";
    
    var $document  = $(document);
    var salesrepId;
    var token;
    var loader;

    $document.ready(function() {

        var lmContainer     = $('.lm-map-container');
        var visitList       = $('.lm-wrapper .lm-leftnav-vlist');
        var visitListHeight = lmContainer.height() - 216;
        var bookedTimes     = $.parseJSON(localStorage.getItem('booked_times'));

        // determine height of the list items container
        visitList.css({"height": visitListHeight + "px"});

        salesrepId = $('#content').data('salesrep-id');
        token      = $('#content').data('token');
        loader     = $('.loader-wrapper');

        // initialise date picker for filter_date
        $('#input__filter_date').datetimepicker({
            showTodayButton: true,
            pickTime: false,
            daysOfWeekDisabled: [0, 6],
            format: 'dddd, DD MMMM YYYY'
        });
    });

    $document.on("change", '#srv__lmf-customer', function() {
        var obj = ($(this).val().length) ? { customer: $(this).val(), salesrep_id: salesrepId } : { customer: 0, salesrep_id: salesrepId };
        var url = salesrepFilterStateChange(obj, token);
        loader.show();
        window.location.href = url;
    });

    $document.on("change", '#input__filter_date', function() {
        var date  = formatDate($(this).val());
        var obj = ($(this).val().length) ? { date: date, salesrep_id: salesrepId } : { date: date, salesrep_id: salesrepId };
        var url = salesrepFilterStateChange(obj, token);
        loader.show();
        window.location.href = url;
    });

    $document.on("change", '#srv__lmf-type', function() {
        var obj = ($(this).val().length) ? { type: $(this).val(), salesrep_id: salesrepId } : { type: '', salesrep_id: salesrepId };
        var url = salesrepFilterStateChange(obj, token);
        loader.show();
        window.location.href = url;
    });

}(jQuery));

/********************************************* 
 * Filters [dropdowns]
 *********************************************/

function salesrepFilterStateChange(obj, token) {

    var url = `index.php?route=replogic/salesrep_info&type=visits&salesrep_id=${obj['salesrep_id']}&token=${token}`;

    // customer/business type
    if (obj['type'] !== undefined) {
        url += (obj['type'].length > 0) ? `&filter_type=${obj['type']}` : ``;
    } else if (getURLVar('filter_type').length) {
        url += `&filter_type=${getURLVar('filter_type')}`;
    }

    // customer
    if (obj['type'] === undefined) {
        if (obj['customer'] !== undefined) {
            url += (obj['customer'] > 0) ? `&filter_customer_id=${obj['customer']}` : ``;
        } else if (getURLVar('filter_customer_id').length) {
            url += `&filter_customer_id=${getURLVar('filter_customer_id')}`;
        }
    }

    // date
    if (obj['date'] !== undefined) {
        url += (obj['date'].length > 0) ? `&filter_date=${obj['date']}` : ``;
    } else if (getURLVar('filter_date').length) {
        url += `&filter_date=${getURLVar('filter_date')}`;
    }

    return url;
}

/********************************************* 
 * Format date
 *********************************************/

function formatDate(date) {
    var d = new Date(date),
        month = '' + (d.getMonth() + 1),
        day = '' + d.getDate(),
        year = d.getFullYear();

    if (month.length < 2) month = '0' + month;
    if (day.length < 2) day = '0' + day;

    return [year, month, day].join('-');
}