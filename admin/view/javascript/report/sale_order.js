(function($) {

    'use strict';

    var initDataTables = function () {
        $(document).ready(function() {
            if ($('#salesReportDataTable').length > 0) {
                var aOptions = {
                    "sDom"           : "<t><'row'<'col-md-12'i p>>",
                    "oLanguage"      : {"sLengthMenu":"_MENU_ ","sInfo":"Showing _START_ to _END_ of _TOTAL_"},
                    "iDisplayLength" : 10
                };
                var oTable        = $('#salesReportDataTable').DataTable(aOptions);

                var buttonCommon = {
                    exportOptions: {
                        columns: ':visible'
                    }
                };
                var exportButtons = new $.fn.dataTable.Buttons(oTable, {
                    buttons: [,
                        'colvis',
                        $.extend(true, {}, buttonCommon, {
                            extend: 'copyHtml5'
                        }),
                        $.extend(true, {}, buttonCommon, {
                            extend: 'csvHtml5'
                        }),
                        $.extend(true, {}, buttonCommon, {
                            extend: 'excelHtml5'
                        }),
                        $.extend(true, {}, buttonCommon, {
                            extend: 'pdfHtml5'
                        }),
                        $.extend(true, {}, buttonCommon, {
                            extend: 'print'
                        })
                    ]
                }).container().appendTo('#export-buttons');
            }
        });
    };

    var initOnStateChange = function() {
        $(document).on('change', '#filter_time_frame', function() {
            if ($(this).val() === "custom") {
                $('.tf-no-range').hide();
                $('.tf-range').show();
            } else {
                $('.tf-no-range').show();
                $('.tf-range').hide();
            }
        });
    };

    var initReport = function() {
        $(document).ready(function() {
            
            /*******************************************
             * Initialize date range picker
             *******************************************/
            
            var start = moment().subtract(29, 'days');
            var end   = moment();

             // check if there's previously selection
             if (location.search.indexOf('filter_date_start') !== -1) {
                var urlParams = getAllUrlParams();
                start         = moment(urlParams.filter_date_start.replace(new RegExp('%20', 'g'), ' '));
                end           = moment(urlParams.filter_date_end.replace(new RegExp('%20', 'g'), ' '));
            }

            function cb(start, end) {
                $('#reportrange span').html(start.format('DD MMMM YYYY') + ' - ' + end.format('DD MMMM YYYY'));
            }

            $('#reportrange').daterangepicker({
                startDate : start,
                endDate   : end,
                ranges    : {
                    'Today'       : [moment(), moment()],
                    'Yesterday'   : [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
                    'Last 7 Days' : [moment().subtract(6, 'days'), moment()],
                    'Last 30 Days': [moment().subtract(29, 'days'), moment()],
                    'This Month'  : [moment().startOf('month'), moment().endOf('month')],
                    'Last Month'  : [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
                }
            }, cb);

            cb(start, end);
        });
        $(document).on('click', '#button-filter-reset', function() {
            var token = $('#content').data('token');
            var url   = `index.php?route=report/sale_order&token=${token}`;
            location  = url;
        });
        $(document).on('click', '#button-filter', function() {
            var token = $('#content').data('token');
            var url   = `index.php?route=report/sale_order&token=${token}`;

            // show page loader
            $('.loader-wrapper').show();
            
            /*******************************************
             * Filter date range
             *******************************************/
        
            var reportrange       = $('#reportrange span').html().split(' - ');
            var filter_date_start = reportrange[0];
            var filter_date_end   = reportrange[1];

            if (filter_date_start) {
                url += `&filter_date_start=${encodeURIComponent(filter_date_start)}`;
            }
            
            if (filter_date_end) {
                url += `&filter_date_end=${encodeURIComponent(filter_date_end)}`;
            }
            
            /*******************************************
             * Filter order status
             *******************************************/

            var filter_order_status = $('select[name="filter_order_status_id"]').val();
            if (filter_order_status) {
                url += `&filter_order_status=${encodeURIComponent(filter_order_status)}`;
            }
            
            /*******************************************
             * Filter sales rep
             *******************************************/

            var filter_salesrep = $('select[name="filter_salesrep"]').val();
            if (filter_salesrep) {
                url += `&filter_salesrep=${encodeURIComponent(filter_salesrep)}`;
            }
            
            /*******************************************
             * Filter sales manager
             *******************************************/

            var filter_sales_manager = $('select[name="filter_sales_manager"]').val();
            if (filter_sales_manager) {
                url += `&filter_sales_manager=${encodeURIComponent(filter_sales_manager)}`;
            }
                
            /*******************************************
             * Filter payment method
             *******************************************/

            var filter_payment_method = $('select[name="filter_payment_method"]').val();
            if (filter_payment_method) {
                url += `&filter_payment_method=${encodeURIComponent(filter_payment_method)}`;
            }
            
            /*******************************************
             * Filter shipping method
             *******************************************/

            var filter_shipping_method = $('select[name="filter_shipping_method"]').val();
            if (filter_shipping_method) {
                url += `&filter_shipping_method=${encodeURIComponent(filter_shipping_method)}`;
            }
        
            location = url;
        });
    };

    initDataTables();
    initOnStateChange();
    initReport();

})(window.jQuery);