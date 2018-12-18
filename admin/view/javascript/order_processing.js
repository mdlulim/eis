(function($) {
    "use strict";

    var $window          = $(window);
    var $document        = $(document);
    var $loader          = $('.loader-wrapper');
    var initProcessOrder = function() {
    	
  		/****************************************************
         * Call init() function on Orders
         * @event : load
         ****************************************************/

    	$document.ready(function() {

    		if ($('#content').data('catalog') !== undefined) {

				var catalog = $('#content').data('catalog');
                var api     = JSON.parse(localStorage.getItem('api'));
                var token   = api.token;

				// only execute code below once api login is done and successful
				if (token !== undefined) {

					var paymentPostData = $('#tab-payment input[type="text"], #tab-payment input[type="hidden"], #tab-payment input[type="radio"]:checked, #tab-payment input[type="checkbox"]:checked, #tab-payment select, #tab-payment textarea');

					$('#content').attr('data-api-token', token);

					// get products in cart
	    			Orders.getProducts(token);

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

				} else {
					// system error message
					swal({
					  	title: "System Error!",
					  	text: "An unkown error has occured, please try again later or contact system administrator.",
					  	type: "error"
					},
					function() {
						// redirect back to the orders list page
					  	window.location.href = $('#button-discard').attr('href');
					});
				}
			}
    	});
        
        
        /****************************************************
         * Discard/Cancel Order Draft Button
         * @event : click
         ****************************************************/

        $document.on('click', '#button-discard', function(e) {
            e.preventDefault();
            var that = $(this);
            swal({
                title: "You are about to leave this page!",
                text: "By leaving this page, your draft will be discarded. Are you sure you want to discard this draft?",
                type: "warning",
                showCancelButton: true,
                confirmButtonClass: "btn-default",
                confirmButtonText: "Discard",
                closeOnConfirm: false,
                showLoaderOnConfirm: true
            },
            function(isConfirm){
                if (isConfirm) {
                    window.location.href = that.attr('href');
                }
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
                		// success code here...
                		swal({
						  	title: "Order Created!",
						  	text: "A new order has been successfully created. Now you'll be redirected.",
						  	type: "success"
						},
						function() {
                            var utoken = $('#content').data('token');
                            var url    = `index.php?route=sale/order/info&order_id=${json['order_id']}&token=${utoken}`;
						    window.location.href = url;
						});
                	});
                }
            });
    	});
        
        
        /****************************************************
         * Open New Address Modal [link]
         * @event : click
         ****************************************************/
    	
    	$document.on('click', '#addNewAddress', function(e) {
			e.preventDefault();
			$('#newAddressModal').find('.form-group .text-danger').remove();
			$('select#input-payment-zone').prop('disabled', true);
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
							$('#newAddressModal').find('form')[0].reset();
						}
						$('#newAddressModal').find('#newadbook').css({'opacity':1});
						('#submitAddressForm').prop('disabled', false);
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
				var zonesSelect = $('select#input-payment-zone');
				zonesSelect.prop('disabled', true);
    			$.ajax({
    				url: 'index.php?route=localisation/zone/get_zones_by_country_id&token='+token,
    				type: 'GET',
					data: {country_id: $(this).val()},
    				dataType: 'json',
					success: function (json) {
						var html = `<option value="">--- Please Select ---</option>`;
						if (json['zones']) {
							for (var i in json['zones']) {
								html += `<option value="${json['zones'][i]['zone_id']}">${json['zones'][i]['name']}</option>`;
							}
							zonesSelect.prop('disabled', false);
						}
						zonesSelect.html(html);
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
				var token = $('#content').attr('data-api-token');
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

        $(document).on('keyup change', 'td.prd-quantity>input, td.quantity>input', function(e) {
            var keyCode = (e.keyCode ? e.keyCode : e.which);
            if (keyCode == 13) {
                var trow = $(this).closest('tr');
                var qty  = parseInt($(this).val());
                if (typeof qty === "number" && qty > 0) {
                    Orders.updateProduct(trow.attr('data-cart-id'), trow.attr('data-cart-id'), $(this).val());
                } else {
                    swal("Error!", "Invalid item quantity. Quantity value must be greater than or equal to 1.", "error");
                    $(this).val($(this).attr('data-qty')).focus();
                    return false;
                }
            }
        });
    };

    initProcessOrder();

}(jQuery));