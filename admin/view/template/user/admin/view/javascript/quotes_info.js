(function($) {
	"use strict";

	var $document     = $(document);
	var initQuoteInfo = function() {
    	
  		/****************************************************
         * Call init() function on Quotes
         * @event : [page] load
         ****************************************************/

		$document.ready(function($) {
			Quotes.init();
		});
        
        
        /****************************************************
         * Add IP Address for API Access
         * @event : click
         ****************************************************/
        
        $(document).on('click', '#button-ip-add', function() {
            var token  = $('#content').data('token');
            var api_ip = $('#content').data('api-ip');
            Functions.addApiIpAddress(api_ip, token);
        });  
        
        
        /****************************************************
         * Open New Address Modal [link]
         * @event : click
         ****************************************************/
    	
    	$document.on('click', '#addNewAddress', function(e) {
    		e.preventDefault();
    		$('#newAddressModal').modal('show');
    	});
        
        
        /****************************************************
         * Add New Shipping Address from Modal
         * @event : click
         ****************************************************/

    	$document.on('click', 'button#submitAddressForm', function() {
		    var newaddressline1 = $('#newaddressline1').val();
		    var city            = $('#city').val();
		    var country         = $('#country-select').val();
			var zone            = $('#input-payment-zone').val();
		    if (newaddressline1.trim() == '' ) {
		        alert('Please Enter Address Line 1.');
		        $('#newaddressline1').focus();
		        return false;
			} else if (city.trim() == '' ){
		        alert('Please Enter City.');
		        $('#city').focus();
		        return false;
			} else if (country.trim() == '' ){
		        alert('Please Select Country.');
		        $('#country-select').focus();
		        return false;
			} else if (zone.trim() == '' ){
		        alert('Please Select Region / State.');
		        $('#input-payment-zone').focus();
		        return false;
		    } else {
		        $.ajax({
		            type: 'POST',
					url: 'index.php?route=customer/customer/addaddress&token=' + $('#content').data('token'),
		            data: $('#newAddressModal input[type="text"], #newAddressModal input[type="hidden"], #newAddressModal select'),
		            dataType: 'json',
		            beforeSend: function() {
		                $('.submitBtn').attr("disabled", true);
		                $('.modal-body').css('opacity', '.5');
		            },
		            success: function(json) {
		                $('#newAddressModal').modal('hide');
						
						var lastid = json['address_id'];
						var html   = '<option value="">Select Shipping Address</option>';

						if (json['addresses']) {
							for (var i in json['addresses']) {
								if (json['addresses'][i]['address_id'] == lastid) {
									html += '<option value="' + json['addresses'][i]['address_id'] + '" selected="selected">' + json['addresses'][i]['address_1'] + ' ' + json['addresses'][i]['address_2'] + ',' + json['addresses'][i]['city'] + ',' + json['addresses'][i]['zone'] + ',' + json['addresses'][i]['country'] + '</option>';
								} else {
									html += '<option value="' + json['addresses'][i]['address_id'] + '">' + json['addresses'][i]['address_1'] + ' ' + json['addresses'][i]['address_2'] + ',' + json['addresses'][i]['city'] + ',' + json['addresses'][i]['zone'] + ',' + json['addresses'][i]['country'] + '</option>';
								}
							}
						}
						$('select#input-shipping-address').html(html);
						$('select#input-shipping-address').trigger('change');
		            }
		        });
		    }
		});
        
        
        /****************************************************
         * On Country selection change
         * @event : change
         ****************************************************/

    	$document.on('change', 'select#country-select', function() {
    		var token = $('#content').data('token');

    		// if country is selected
    		if ($(this).val().length > 0) {
    			$.ajax({
    				url     : 'index.php?route=localisation/zone/get_zones_by_country_id&token'+token,
    				type    : 'get',
    				dataType: 'json',
    				data    : {country_id : $(this).val()},
    				success : function(json) {

    				}
    			});
    		}
    	});
        
        
        /****************************************************
         * On Shipping Address selection change
         * @event : change
         ****************************************************/

    	$document.on('change', 'select#input-shipping-address', function() {
    		if ($(this).val().length && $(this).val() != '') {
	    		// get shipping address from user's selection
	    		Orders.getShippingAddress($(this).val(),
	    		function(json) {
	    			// set shipping address
	    			Orders.setShippingAddress(token,
	    			function(json) {
	    				// get shipping method
	    				Orders.getShippingMethod(token);
	    			});
	    		});
    		}
    	});
        
        
        /****************************************************
         * On Shipping Method selection change
         * @event : change
         ****************************************************/

    	$document.on('change', 'select#input-shipping_method', function() {
    		var that = $(this);
    		$('#button-save').attr('disabled', true);
    		if (that.val().length && that.val() != '') {
    			var token = $('#content').attr('data-api-token');
    			Orders.setShippingMethod(that.val(), token, 
    			function(json) {
    				that.closest('.form-group').addClass('has-success');
    				if ($('select#input-payment_method').val() != '') {
    					$('#button-save').attr('disabled', false);
    				}
    				Quotes.getProducts(token);
    			});
    		}
    	});
        
        
        /****************************************************
         * On Payment Method selection change
         * @event : change
         ****************************************************/

    	$document.on('change', 'select#input-payment_method', function() {
    		var that = $(this);
    		$('#button-save').attr('disabled', true);
    		if (that.val().length && that.val() != '') {
    			var token = $('#content').attr('data-api-token');
    			Orders.setPaymentMethod(that.val(), token, 
    			function(json) {
    				that.closest('.form-group').addClass('has-success');
    				if ($('select#input-shipping_method').val() != '') {
						$('#button-save').attr('disabled', false);
					}
    				Quotes.getProducts(token);
    			});
    		}
    	});
        
        
        /****************************************************
         * On Invoice to Shipping Check
         * @event : click
         ****************************************************/

    	$document.on('click', 'input#invoice_to_shipping', function() {
    		var that = $(this);
    		$('#button-save').attr('disabled', true);
    		if (that.is(':checked')) {
    			var token           = $('#content').attr('data-api-token');
    			var paymentPostData = $('#tab-shipping input[type="text"], #tab-shipping input[type="hidden"], #tab-shipping input[type="radio"]:checked, #tab-shipping input[type="checkbox"]:checked, #tab-shipping select, #tab-shipping textarea');

    			Orders.setPaymentAddress(paymentPostData, token,
				function(json) {
					if ($('select#input-shipping_method').val() != '' && $('select#input-shipping_method').val() != '') {
						$('#button-save').attr('disabled', false);
					}
					Orders.getPaymentMethod(token);
				});
    		}
    	});
        
        
        /****************************************************
         * Convert Quote to Order Button
         * @event : click
         ****************************************************/

    	$document.on('click', '#button-save', function(e) {
    		var that = $(this);
            swal({
                title: "Convert to Order!",
                text: "Are you sure you want to convert this quote to order?",
                type: "warning",
                showCancelButton: true,
                confirmButtonClass: "btn-primary",
                confirmButtonText: "Convert",
                closeOnConfirm: false,
                showLoaderOnConfirm: true
            },
            function(isConfirm){
                if (isConfirm) {
                	var token = $('#content').attr('data-api-token');
                    Quotes.convert(token,
                	function(json) {
                		// success code here...
                		swal({
						  	title: "Quote Converted!",
						  	text: "Quote successfully converted to order. Now you'll be redirected to the quote list.",
						  	type: "success"
						},
						function() {
							window.location.href = $('#button-cancel').attr('href');
						});
                	});
                }
            });
    	});
        
        
        /****************************************************
         * Deny a Quote Button
         * @event : click
         ****************************************************/

    	$document.on('click', '#button-deny', function(e) {
    		e.preventDefault();
    		var that = $(this);
            swal({
                title: "Deny Quote!",
                text: "Please provide reason for denying this quote.",
                type: "input",
                showCancelButton: true,
                confirmButtonClass: "btn-primary",
                confirmButtonText: "Deny",
                closeOnConfirm: false,
                inputPlaceholder: "Write a reason...",
                showLoaderOnConfirm: true
            },
            function(inputValue) {
            	if (inputValue === false) return false;
			  	if (inputValue === "") {
				    swal.showInputError("You need to write something!");
				    return false;
			  	}

			  	var quoteId = $('#content').data('quote-id');
			  	var reason  = inputValue;
                Quotes.deny(quoteId, reason);
            });
    	});
	};

	initQuoteInfo();

}(jQuery));