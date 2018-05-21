(function ($) {
    "use strict";

    var initStateChange = function () {
    	$(document).on('change', 'select[name="customer_group_id"]', function() {
			if($(this).val() == '3') {
				$("#wholesal").show();
			} else {
				$("#wholesal").hide();
			}
		});
		$(document).on('change', '#send_invitation', function () {
			if ($(this).is(':checked')) {
				$(this).val('yes');
			} else {
				$(this).val('no');
			}
		});
		$(document).on('click', 'button[type="submit"]', function(e) {
			$('.loader-wrapper').show();
		});
    };

    var initSendInvitation = function () {
    	$(document).on('click', '#resend-invitation', function(e) {
    		e.preventDefault();
    		var customerName = $(this).data('customername');
    		var token = $(this).data('token');
    		var customerId = $(this).data('customerid');
    		var postData = { ajax: 1, action: 'send_invitation', customer_id: customerId };
    		swal({
				title: "Are you sure?",
				text: "You are about to (re)send invitation to "+customerName+".",
				type: "warning",
				showCancelButton: true,
				confirmButtonClass: "btn-info",
				confirmButtonText: "Yes, send it!",
				closeOnConfirm: false
			},
			function(isConfirm){
				if (isConfirm) {
					$.ajax({
		    			url: "index.php?route=customer/customer_info&token="+token,
		    			type: 'POST',
		    			data: postData,
		    			beforeSend: function() {
		    				$('.loader-wrapper').show();
		    			},
		    			success: function(xhr) {
		    				var res = $.parseJSON(xhr);
		    				$('.loader-wrapper').hide();
		    				if (res.success)
		    					swal("Sent!", "Email invitation has been sent to "+customerName+".", "success");
		    				else
		    					swal("Error!", "An unexpected error has occurred.", "error");
		    			}
		    		});
				}
			});
    	});
    };

    var initBulkSendInvitation = function () {
    	$(document).on('click', '#button-invitation', function() {
    		var form = $('#form-customer');
    		var customers = form.find('input[name^="selected"]');
    		var postUrl = form.attr('action').replace('customer/customer/delete', 'customer/customer/invitation');
    		var postData = {};
    		postData.ajax = 1;
    		postData.send_bulk_invitation = 1;
    		postData.customers = [];

    		if (customers.length > 0) {
    			for (var i = 0; i < customers.length; i++) {
    				if ($(customers[i]).is(':checked')) {
    					var customer = {
    						id: customers[i].value
    					};
    					postData.customers.push(customer);
    				}
    			}
    		} else {
    			swal("Error!", "Please select customer(s) to send invitation to.", "error");
    			return false;
    		}

    		swal({
				title: "Are you sure?",
				text: "You are about to send invitation to "+postData.customers.length+" selected customer(s).",
				type: "warning",
				showCancelButton: true,
				confirmButtonClass: "btn-info",
				confirmButtonText: "Yes, send!",
				closeOnConfirm: false
			},
			function(isConfirm){
				if (isConfirm) {
					$.ajax({
		    			url: postUrl,
		    			type: 'POST',
		    			data: postData,
		    			beforeSend: function() {
		    				$('.loader-wrapper').show();
		    			},
		    			success: function(xhr) {
		    				var res = $.parseJSON(xhr);
		    				$('.loader-wrapper').hide();
		    				if (res.success) {
		    					$('input[type="checkbox"]').prop('checked', false);
			    				$('#button-delete').prop('disabled', true);
	    						$('#button-invitation').prop('disabled', true);
		    					swal("Sent!", "Email invitation has been sent to "+postData.customers.length+" customer(s).", "success");
		    				} else {
		    					swal("Error!", "An unexpected error has occurred.", "error");
		    				}
		    			}
		    		});
				}
			});
    	});
    };

    var initCustomerContact = function () {
    	
    };

    initStateChange();
    initSendInvitation();
    initBulkSendInvitation();
    initCustomerContact();

}(jQuery));