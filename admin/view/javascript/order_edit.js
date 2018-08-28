(function($) {
    "use strict";

    var $window         = $(window);
    var $document       = $(document);
    var initCreateOrder = function() {
    	
  		/****************************************************
         * Call init() function on Orders
         * @event : load
         ****************************************************/

    	$document.ready(function() {
            Orders.init(function() {
                // get products
                Orders.setProducts(function() {
                    var token           = $('#content').attr('data-api-token');
                    var paymentPostData = $('#tab-payment input[type="text"], #tab-payment input[type="hidden"], #tab-payment input[type="radio"]:checked, #tab-payment input[type="checkbox"]:checked, #tab-payment select, #tab-payment textarea');
                    
                    // payment address | payment method
	    			Orders.setPaymentAddress(paymentPostData, token,
                    function(json) {
                        // get payment methods
                        Orders.getPaymentMethod(token);
                    });

                    // shipping address | shipping method
                    Orders.setShippingAddress(token,
                    function(json) {
                        Orders.getShippingMethod(token);
                    });
                });
            });
    	});
        
        
        /****************************************************
         * Confirm/Save Order Button
         * @event : click
         ****************************************************/

    	$document.on('click', '#button-confirm', function(e) {
    		var that = $(this);
            swal({
                title: "Confirm Order!",
                text: "Are you sure you want to save this order?",
                type: "warning",
                showCancelButton: true,
                confirmButtonClass: "btn-primary",
                confirmButtonText: "Save",
                closeOnConfirm: false,
                showLoaderOnConfirm: true
            },
            function(isConfirm){
                if (isConfirm) {
                	var token = $('#content').attr('data-api-token');
                    Orders.save(token,
                	function(json) {
                		swal({
						  	title: "Order Confirmed!",
						  	text: "Order has been successfully confirmed. Now you'll be redirected to the orders list.",
						  	type: "success"
						},
						function() {
                            var utoken = $('#content').data('token');
                            var url    = `index.php?route=sale/order&token=${utoken}`;
						    window.location.href = url;
						});
                	});
                }
            });
    	});
        
        
        /****************************************************
         * Cancel Order Button
         * @event : click
         ****************************************************/

        $document.on('click', '#button-cancel', function(e) {
            e.preventDefault();
            var that = $(this);
            swal({
                title: "You are about to cancel order!",
                text: "Are you sure you want to cancel this order?",
                type: "error",
                showCancelButton: true,
                confirmButtonClass: "btn-warning",
                confirmButtonText: "Continue",
                closeOnConfirm: false,
                showLoaderOnConfirm: true
            },
            function(isConfirm){
                if (isConfirm) {
	                var token = $('#content').data('token');
                    Orders.cancel(token);
                }
            });
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
    				url: 'index.php?route=localisation/zone/get_zones_by_country_id&token'+token,
    				type: 'GET',
    				dataType: 'default: Intelligent Guess (Other values: xml, json, script, or html)',
    				data: {param1: 'value1'},
    			})
    			.done(function() {
    				console.log("success");
    			})
    			.fail(function() {
    				console.log("error");
    			})
    			.always(function() {
    				console.log("complete");
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
    		$('#button-confirm').attr('disabled', true);
    		if (that.val().length && that.val() != '') {
    			var token = $('#content').attr('data-api-token');
    			Orders.setShippingMethod(that.val(), token, 
    			function(json) {
    				that.closest('.form-group').addClass('has-success');
    				if ($('select#input-payment_method').val() != '') {
    					$('#button-confirm').attr('disabled', false);
    				}
    				Orders.getProducts(token);
    			});
    		}
    	});
        
        
        /****************************************************
         * On Payment Method selection change
         * @event : change
         ****************************************************/

    	$document.on('change', 'select#input-payment_method', function() {
    		var that = $(this);
    		$('#button-confirm').attr('disabled', true);
    		if (that.val().length && that.val() != '') {
    			var token = $('#content').attr('data-api-token');
    			Orders.setPaymentMethod(that.val(), token, 
    			function(json) {
    				that.closest('.form-group').addClass('has-success');
    				if ($('select#input-shipping_method').val() != '') {
						$('#button-confirm').attr('disabled', false);
					}
    				Orders.getProducts(token);
    			});
    		}
    	});
        
        
        /****************************************************
         * On Invoice to Shipping Check
         * @event : click
         ****************************************************/

    	$document.on('click', 'input#invoice_to_shipping', function() {
    		var that = $(this);
    		$('#button-confirm').attr('disabled', true);
    		if (that.is(':checked')) {
    			var token           = $('#content').attr('data-api-token');
    			var paymentPostData = $('#tab-shipping input[type="text"], #tab-shipping input[type="hidden"], #tab-shipping input[type="radio"]:checked, #tab-shipping input[type="checkbox"]:checked, #tab-shipping select, #tab-shipping textarea');

    			Orders.setPaymentAddress(paymentPostData, token,
				function(json) {
					if ($('select#input-shipping_method').val() != '' && $('select#input-shipping_method').val() != '') {
						$('#button-confirm').attr('disabled', false);
					}
					Orders.getPaymentMethod(token);
				});
    		}
    	});
        
        
        /****************************************************
         * Product/Cart Line Item Quantity Change
         * @event : keyup or change
         ****************************************************/

        $(document).on('keydown', 'td.prd-quantity>input, td.quantity>input', function(e) {
            var keyCode = (e.keyCode ? e.keyCode : e.which);
            if (keyCode == 13) {
                var trow = $(this).closest('tr');
                var qty  = parseInt($(this).val());
                if (typeof qty === "number" && qty > 0) {
                    Orders.updateProduct(trow.attr('data-cart-id'), trow.attr('data-cart-id'), $(this).val());
                } else {
                    swal("Error!", "Invalid item quantity. Quantity value must be greater than or equal to 1.", "error");
                    $(this).val($(this).attr('data-qty')).focus();
                }
            }
        });
        
        
        /****************************************************
         * Remove Product/cart line item
         * @event : click
         ****************************************************/

    	$document.on('click', '.remove-product', function(e) {
    		e.preventDefault();
            Orders.removeProduct($(this).attr('data-cart-id'), $(this).attr('data-product-id'));
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
    };

    initCreateOrder();

}(jQuery));