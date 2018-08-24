(function ($) {
    "use strict";

    var initQuoteDetails = function() {

    	/*==============================================
    	=            API Processing [Calls]            =
    	==============================================*/
    	
  		// page load functions
    	$(document).ready(function() {

    		/*----------  api login  ----------*/

    		var apiLoginUrl = $('#content').data('catalog')+'index.php?route=api/login';
    		var token = $('#content').data('api-token');
    		var apiKey = $('#content').data('api-key');
    		$.ajax({
				url: apiLoginUrl,
				type: 'post',
				dataType: 'json',
				data: 'key='+apiKey,
				crossDomain: true,
				success: function(json) {
			        if (json['error']) {
			    		if (json['error']['key']) {
			    			$('#content > .container-fluid').prepend('<div class="alert alert-danger"><i class="fa fa-exclamation-circle"></i> ' + json['error']['key'] + ' <button type="button" class="close" data-dismiss="alert">&times;</button></div>');
			    		}

			            if (json['error']['ip']) {
			    			$('#content > .container-fluid').prepend('<div class="alert alert-danger"><i class="fa fa-exclamation-circle"></i> ' + json['error']['ip'] + ' <button type="button" id="button-ip-add" data-loading-text="<?php echo $text_loading; ?>" class="btn btn-danger btn-xs pull-right"><i class="fa fa-plus"></i> <?php echo $button_ip_add; ?></button></div>');
			    		}
			        }

			        if (json['token']) {
						$('#content').attr('data-api-token', json['token']);
					}
				},
				error: function(xhr, ajaxOptions, thrownError) {
					alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
				}
			}).done(function() {

				// only execute code below once api login is done and successful
				if ($('#content').data('api-token')) {

					/*----------  payment address api  ----------*/
					
					var token             = $('#content').data('api-token');
					var catalog           = $('#content').data('catalog');
					var paymentAddressUrl = catalog + 'index.php?route=api/payment/address&callfrom=orderform&token=' + token + '&store_id=0';
					$.ajax({
						url: paymentAddressUrl,
						type: 'post',
						data: $('#tab-payment input[type="text"], #tab-payment input[type="hidden"], #tab-payment input[type="radio"]:checked, #tab-payment input[type="checkbox"]:checked, #tab-payment select, #tab-payment textarea'),
						dataType: 'json',
						crossDomain: true,
						beforeSend: function() {
							$('#button-payment-address').button('loading');
						},
						complete: function() {
							$('#button-payment-address').button('reset');
						},
						success: function(json) {

							// Check for errors
							if (json['error']) {
								if (json['error']['warning']) {
									$('#content > .container-fluid').prepend('<div class="alert alert-danger"><i class="fa fa-exclamation-circle"></i> ' + json['error']['warning'] + ' <button type="button" class="close" data-dismiss="alert">&times;</button></div>');
								}

								for (i in json['error']) {
									var element = $('#input-payment-' + i.replace('_', '-'));

									if ($(element).parent().hasClass('input-group')) {
										$(element).parent().after('<div class="text-danger">' + json['error'][i] + '</div>');
									} else {
										$(element).after('<div class="text-danger">' + json['error'][i] + '</div>');
									}
								}

								// Highlight any found errors
								$('.text-danger').parentsUntil('.form-group').parent().addClass('has-error');
							} else {
								
								/*----------  payment methods api  ----------*/
								
								var token = $('#content').data('api-token');
								var paymentMethodsUrl = $('#content').data('catalog') + 'index.php?route=api/payment/methods&token=' + token + '&store_id=0';
								$.ajax({
									url: paymentMethodsUrl,
									dataType: 'json',
									crossDomain: true,
									beforeSend: function() {
										$('#button-payment-address').button('loading');
									},
									complete: function() {
										$('#button-payment-address').button('reset');
									},
									success: function(json) {
										if (json['error']) {
											$('#content > .container-fluid').prepend('<div class="alert alert-danger"><i class="fa fa-exclamation-circle"></i> ' + json['error'] + ' <button type="button" class="close" data-dismiss="alert">&times;</button></div>');
										} else {
											var html = '<option value="">'+$('input[name="text_select"]').val()+'</option>';

											if (json['payment_methods']) {
												for (var i in json['payment_methods']) {
													if (json['payment_methods'][i]['code'] == $('select[name="payment_method"] option:selected').val()) {
														html += '<option value="' + json['payment_methods'][i]['code'] + '" selected="selected">' + json['payment_methods'][i]['title'] + '</option>';
													} else {
														html += '<option value="' + json['payment_methods'][i]['code'] + '">' + json['payment_methods'][i]['title'] + '</option>';
													}
												}
											}
					
											$('select[name="payment_method"]').html(html);
										}
									},
									error: function(xhr, ajaxOptions, thrownError) {
										alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
									}
								});
							}
						},
						error: function(xhr, ajaxOptions, thrownError) {
							alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
						}
					});

					/*----------  shipping address api  ----------*/
					
					var shippingAddressUrl = catalog + 'index.php?route=api/shipping/address&callfrom=orderform&token=' + token + '&store_id=0';
					$.ajax({
						url: shippingAddressUrl,
						type: 'post',
						data: $('#tab-shipping input[type="text"], #tab-shipping input[type="hidden"], #tab-shipping input[type="radio"]:checked, #tab-shipping input[type="checkbox"]:checked, #tab-shipping select, #tab-shipping textarea'),
						dataType: 'json',
						crossDomain: true,
						beforeSend: function() {
							$('#button-shipping-address').button('loading');
						},
						complete: function() {
							$('#button-shipping-address').button('reset');
						},
						success: function(json) {

							// Check for errors
							if (json['error']) {
								if (json['error']['warning']) {
									$('#content > .container-fluid').prepend('<div class="alert alert-danger"><i class="fa fa-exclamation-circle"></i> ' + json['error']['warning'] + ' <button type="button" class="close" data-dismiss="alert">&times;</button></div>');
								}

								for (i in json['error']) {
									var element = $('#input-shipping-' + i.replace('_', '-'));

									if ($(element).parent().hasClass('input-group')) {
										$(element).parent().after('<div class="text-danger">' + json['error'][i] + '</div>');
									} else {
										$(element).after('<div class="text-danger">' + json['error'][i] + '</div>');
									}
								}

								// Highlight any found errors
								$('.text-danger').parentsUntil('.form-group').parent().addClass('has-error');
							} else {

								/*----------  shipping methods api  ----------*/
								
								var shippingMethodUrl = catalog + 'index.php?route=api/shipping/methods&token=' + token + '&store_id=0';
								$.ajax({
									url: shippingMethodUrl,
									dataType: 'json',
									beforeSend: function() {
										$('#button-shipping-address').button('loading');
									},
									complete: function() {
										$('#button-shipping-address').button('reset');
									},
									success: function(json) {
										if (json['error']) {
											$('#content > .container-fluid').prepend('<div class="alert alert-danger"><i class="fa fa-exclamation-circle"></i> ' + json['error'] + ' <button type="button" class="close" data-dismiss="alert">&times;</button></div>');
										} else { 
											// Shipping Methods
											var html = '<option value="">'+$('input[name="text_select"]').val()+'</option>';

											if (json['shipping_methods']) {
												for (var i in json['shipping_methods']) {
													html += '<optgroup label="' + json['shipping_methods'][i]['title'] + '">';

													if (!json['shipping_methods'][i]['error']) {
														for (var j in json['shipping_methods'][i]['quote']) {
															if (json['shipping_methods'][i]['quote'][j]['code'] == $('select[name="shipping_method"] option:selected').val()) {
																html += '<option value="' + json['shipping_methods'][i]['quote'][j]['code'] + '" selected="selected">' + json['shipping_methods'][i]['quote'][j]['title'] + ' - ' + json['shipping_methods'][i]['quote'][j]['text'] + '</option>';
															} else {
																html += '<option value="' + json['shipping_methods'][i]['quote'][j]['code'] + '">' + json['shipping_methods'][i]['quote'][j]['title'] + ' - ' + json['shipping_methods'][i]['quote'][j]['text'] + '</option>';
															}
														}
													} else {
														html += '<option value="" style="color: #F00;" disabled="disabled">' + json['shipping_method'][i]['error'] + '</option>';
													}

													html += '</optgroup>';
												}
											}

											$('select[name="shipping_method"]').html(html);
										}
									},
									error: function(xhr, ajaxOptions, thrownError) {
										alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
									}
								});
							}
						},
						error: function(xhr, ajaxOptions, thrownError) {
							alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
						}
					});

					/*----------  api products  ----------*/

					var token          = $('#content').data('api-token');
					var apiProductsUrl = $('#content').data('catalog')+'index.php?route=api/cart/products&token=' + token + '&store_id=0';
					$.ajax({
						url: apiProductsUrl,
						type: 'post',
						dataType: 'json',
						crossDomain: true,
						success: function(json) {

							// Check for errors
							if (json['error']) {
								$('#button-save').attr('disabled', true);
								$('#content > .container-fluid').prepend('<div class="alert alert-danger"><i class="fa fa-exclamation-circle"></i> ' + json['error'] + ' <button type="button" class="close" data-dismiss="alert">&times;</button></div>');
							}
						},
						error: function(xhr, ajaxOptions, thrownError) {
							$('#button-save').attr('disabled', true);
							alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
						}
					});
				}
	    		
			});

				
    	});
    	
    	
    	/*=====  End of API Processing [Calls]  ======*/
    	

    	/*============================================
    	=            Add shipping address            =
    	============================================*/
    	
    	// open modal
    	$(document).on('click', '#newaddress',  function() {
    		$('#newAddressModal').modal('show');
    	});

    	// submit [AJAX] form
    	$(document).on('click', 'button#submitAddressForm', function() {
		    var newaddressline1 = $('#newaddressline1').val();
		    var city            = $('#city').val();
		    var country         = $('#input-payment-country').val();
			var zone            = $('#input-payment-zone').val();
		    if (newaddressline1.trim() == '' ) {
		        alert('Please Enter Address Line 1.');
		        $('#newaddressline1').focus();
		        return false;
			} else if(city.trim() == '' ){
		        alert('Please Enter City.');
		        $('#city').focus();
		        return false;
			} else if(country.trim() == '' ){
		        alert('Please Select Country.');
		        $('#input-payment-country').focus();
		        return false;
			} else if(zone.trim() == '' ){
		        alert('Please Select Region / State.');
		        $('#input-payment-zone').focus();
		        return false;
		    } else {
		        $.ajax({
		            type: 'POST',
		            url: 'submit_form.php',
					url: 'index.php?route=customer/customer/addaddress&token=' + $('#content').data('token'),
		            data: $('#newAddressModal input[type="text"], #newAddressModal input[type="hidden"], #newAddressModal select'),
		            beforeSend: function () {
		                $('.submitBtn').attr("disabled", true);
		                $('.modal-body').css('opacity', '.5');
		            },
		            success:function(json){
		                $('#newAddressModal').modal('hide');
						
						var lastid = json['address_id'];
						
						html       = '';
						html       = '<option value="">Select Shipping Address</option>';

						if (json['addresses']) {
							for (i in json['addresses']) {
								if (json['addresses'][i]['address_id'] == lastid) {
									html += '<option value="' + json['addresses'][i]['address_id'] + '" selected="selected">' + json['addresses'][i]['address_1'] + ' ' + json['addresses'][i]['address_2'] + ',' + json['addresses'][i]['city'] + ',' + json['addresses'][i]['zone'] + ',' + json['addresses'][i]['country'] + '</option>';
								} else {
									html += '<option value="' + json['addresses'][i]['address_id'] + '">' + json['addresses'][i]['address_1'] + ' ' + json['addresses'][i]['address_2'] + ',' + json['addresses'][i]['city'] + ',' + json['addresses'][i]['zone'] + ',' + json['addresses'][i]['country'] + '</option>';
								}
							}
						}

						$('select[name="shippingaddress"]').html(html);
						$('select[name="shippingaddress"]').trigger('change');
		            }
		        });
		    }
		});
    	
    	/*=====  End of Add shipping address  ======*/

    	/*=================================================
    	=            Shipping method functions            =
    	=================================================*/
    	
    	// shipping method [on change event]
    	$(document).on('change', 'select[name="shipping_method"]', function() {
    		var token = $('#content').data('api-token');
    		var shippingMethodUrl = $('#content').data('catalog')+'index.php?route=api/shipping/method&token=' + token + '&store_id=0';
			$.ajax({
				url: shippingMethodUrl,
				type: 'post',
				data: 'shipping_method=' + $('select[name="shipping_method"] option:selected').val(),
				dataType: 'json',
				crossDomain: true,
				beforeSend: function() {
					$('#button-shipping-method').button('loading');
				},
				complete: function() {
					$('#button-shipping-method').button('reset');
				},
				success: function(json) {
					$('.alert, .text-danger').remove();
					$('.form-group').removeClass('has-error');

					if (json['error']) {
						$('#content > .container-fluid').prepend('<div class="alert alert-danger"><i class="fa fa-exclamation-circle"></i> ' + json['error'] + ' <button type="button" class="close" data-dismiss="alert">&times;</button></div>');

						// Highlight any found errors
						$('select[name="shipping_method"]').closest('.form-group').addClass('has-error');
					}

					if (json['success']) {
						$('#content > .container-fluid').prepend('<div class="alert alert-success"><i class="fa fa-check-circle"></i> ' + json['success'] + ' <button type="button" class="close" data-dismiss="alert">&times;</button></div>');

						// Refresh products, vouchers and totals
						$('#button-refresh').trigger('click');
					}
				},
				error: function(xhr, ajaxOptions, thrownError) {
					alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
				}
			});
		});
    	
    	/*=====  End of Shipping method functions  ======*/


    	/*==============================================
    	=            Convert quote to order            =
    	==============================================*/
    	
    	$(document).on('click', '#button-save',  function (e) {
    		e.preventDefault();
    		if ($(this).attr('disabled') == undefined) {
	    		if (confirm('Are you sure you want to convert this quote to order?')) {
	    			var token   = $('#content').data('token');
	    			var quoteId = $('#content').data('quote-id');
	    			window.location.href = 'index.php?route=replogic/order_quotes/approve&token=' + token + '&quote_id=' + quoteId;
	    		}
    		}
    	});
    	
    	/*=====  End of Convert quote to order  ======*/
    	
    };
    initQuoteDetails();

}(jQuery));
