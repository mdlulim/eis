(function($) {
    "use strict";

    // jquery contains [case-insensitive]
    jQuery.expr[":"].Contains = jQuery.expr.createPseudo(function(arg) {
	    return function( elem ) {
	        return jQuery(elem).text().toUpperCase().indexOf(arg.toUpperCase()) >= 0;
	    };
	});

    // serialize object
	$.fn.serializeObject = function(){
        var self = this,
            json = {},
            push_counters = {},
            patterns = {
                "validate": /^[a-zA-Z][a-zA-Z0-9_]*(?:\[(?:\d*|[a-zA-Z0-9_]+)\])*$/,
                "key":      /[a-zA-Z0-9_]+|(?=\[\])/g,
                "push":     /^$/,
                "fixed":    /^\d+$/,
                "named":    /^[a-zA-Z0-9_]+$/
            };


        this.build = function(base, key, value){
            base[key] = value;
            return base;
        };

        this.push_counter = function(key){
            if(push_counters[key] === undefined){
                push_counters[key] = 0;
            }
            return push_counters[key]++;
        };

        $.each($(this).serializeArray(), function(){

            // skip invalid keys
            if(!patterns.validate.test(this.name)){
                return;
            }

            var k,
                keys = this.name.match(patterns.key),
                merge = this.value,
                reverse_key = this.name;

            while((k = keys.pop()) !== undefined){

                // adjust reverse_key
                reverse_key = reverse_key.replace(new RegExp("\\[" + k + "\\]$"), '');

                // push
                if(k.match(patterns.push)){
                    merge = self.build([], self.push_counter(reverse_key), merge);
                }

                // fixed
                else if(k.match(patterns.fixed)){
                    merge = self.build([], k, merge);
                }

                // named
                else if(k.match(patterns.named)){
                    merge = self.build({}, k, merge);
                }
            }

            json = $.extend(true, json, merge);
        });

        return json;
    };
}(jQuery));

/*****************************************************************
 *
 * General Functions
 *
 *****************************************************************/

var Functions = {};

/**
 *
 * Add IP Address for API Access
 * @param {string} ip_address    ip address
 * @param {string} token         api session access token
 */
Functions.addApiIpAddress =function(ip_address, token) {
	var url = `index.php?route=user/api/addip&token=${token}&api_id=${api_ip}`
    $.ajax({
        url     : url,
        type    : 'post',
        data    : `ip=${ip_address}`,
        dataType: 'json',
        beforeSend: function() {
            $('#button-ip-add').button('loading');
        },
        complete: function() {
            $('#button-ip-add').button('reset');
        },
        success: function(json) {
            $('.alert').remove();
            if (json['error']) {
                $('#content > .container-fluid').prepend('<div class="alert alert-danger"><i class="fa fa-exclamation-circle"></i> ' + json['error'] + ' <button type="button" class="close" data-dismiss="alert">&times;</button></div>');
            }
            if (json['success']) {
                $('#content > .container-fluid').prepend('<div class="alert alert-success"><i class="fa fa-check-circle"></i> ' + json['success'] + ' <button type="button" class="close" data-dismiss="alert">&times;</button></div>');
            }
        },
        error: function(xhr, ajaxOptions, thrownError) {
            alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
        }
    });
};


/*****************************************************************
 *
 * Orders functions
 *
 *****************************************************************/

var Orders    = {};

/**
 *
 * Initiate Order
 * 
 */
Orders.init = function(callback) {

	/**********************************************
	*            		API Login            
	***********************************************/

	if ($('#content').data('catalog') !== undefined) {

		var catalog     = $('#content').data('catalog');
		var apiLoginUrl = `${catalog}index.php?route=api/login`;
		var apiKey      = $('#content').data('api-key');
		$.ajax({
			url        : apiLoginUrl,
			type       : 'post',
			dataType   : 'json',
			data       : 'key='+apiKey,
			crossDomain: true,
			success: function(json) {
					
				// remove page loader
				$('.loader-wrapper').hide();
				
		        if (json['error']) {
		    		if (json['error']['key']) {
		    			$('#content > .container-fluid').prepend(`<div class="alert alert-danger"><i class="fa fa-exclamation-circle"></i> ${json['error']['key']} <button type="button" class="close" data-dismiss="alert">&times;</button></div>`);
		    		}
		            if (json['error']['ip']) {
		    			$('#content > .container-fluid').prepend(`<div class="alert alert-danger"><i class="fa fa-exclamation-circle"></i> ${json['error']['ip']} <button type="button" id="button-ip-add" data-loading-text="loading..." class="btn btn-danger btn-xs pull-right"><i class="fa fa-plus"></i></button></div>`);
		    		}
		        }

		        if (json['token']) {
		        	// store API TOKEN into the DOM element through data attribute
					$('#content').attr('data-api-token', json['token']);
				}
			},
			error: function(xhr, ajaxOptions, thrownError) {
				alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
			}
		}).done(function() {

			// only execute code below once api login is done and successful
			if ($('#content').data('api-token') !== undefined) {

				// retrive API TOKEN from DOM (data attribute)
				var token = $('#content').data('api-token');

				// customer details tab content (hidden input data)
				var customerTab = $('#tab-customer');
				var storeId     = customerTab.find('input[name="store_id"]').val()

	            /**********************************************
				*             Modify Customer Group            
				***********************************************/

	            var utoken          = $('#content').data('token');
	            var customerGroupId = customerTab.find('input[name="customer_group_id"]').val();
	            var custGrpApiUrl   = `index.php?route=customer/customer/customfield&token=${utoken}&customer_group_id=${customerGroupId}`
	            $.ajax({
	                url        : custGrpApiUrl,
	                type       : 'get',
	                dataType   : 'json',
	                crossDomain: true,
	                success:  function(json) {
	                	console.log(json)
	                    if (json['error']) {
	                    	var message = (json['error']) ? json['error'] : 'Failed to add customer. An unexpected error occured.';
	                    	if (typeof swal === "function") {
			            		swal("Error!", message, "error");
			            	} else {
			            		alert(message);
			            	}
	                    }
	                },
	                error: function(xhr, ajaxOptions, thrownError) {
	                    alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
	                }
	            });

	            /**********************************************
				*               Modify customer(s)            
				***********************************************/

	            var custApiUrl      = `${catalog}index.php?route=api/customer&callfrom=orderform&token=${token}&store_id=${storeId}`;
	            var custApiPostData = {
	                store_id         : storeId,
	                currency         : customerTab.find('input[name="currency"]').val(),
	                customer         : customerTab.find('input[name="customer"]').val(),
	                customer_id      : customerTab.find('input[name="customer_id"]').val(),
	                customer_group_id: customerTab.find('input[name="customer_group_id"]').val(),
	                firstname        : customerTab.find('input[name="firstname"]').val(),
	                lastname         : customerTab.find('input[name="lastname"]').val(),
	                email            : customerTab.find('input[name="email"]').val(),
	                telephone        : customerTab.find('input[name="telephone"]').val()
	            };
	            $.ajax({
	                url        : custApiUrl,
	                type       : 'post',
	                dataType   : 'json',
	                data       : custApiPostData,
	                crossDomain: true,
	                success:  function(json) {
	                    if (json['error']) {
							var message = '';
							if (typeof json['error'] === "object") {
								Object.keys(json['error']).forEach(function(key) {
								    message += `${key}: ${json['error'][key]} `;
								});
							} else {
								message = (json['error']) ? json['error'] : 'Failed to add customer. An unexpected error occured.';
							}
	                    	
	                    	if (typeof swal === "function") {
			            		swal("Error!", message, "error");
			            	} else {
			            		alert(message);
			            	}
	                    }
	                },
	                error: function(xhr, ajaxOptions, thrownError) {
	                    alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
	                }
				});

	            /**********************************************
				*               Callback            
				***********************************************/
				
				if (callback !== undefined) {
					callback();
				}

			} else {
				alert("Error");
			}
		});
	}
};


/**
 *
 * Add Product to Order [Cart]
 * 
 * @param {integer} product id  product identifier
 * @param {integer} quantity    number of products to be added to order/cart
 */
Orders.addProduct = function(product_id, quantity) {
	if ($('#content').data('api-token')) {
		var catalog    = $('#content').data('catalog');
		var token      = $('#content').data('api-token');
		var customerTab= $('#tab-customer');
	   	var storeId    = customerTab.find('input[name="store_id"]').val();
		var url        = `${catalog}index.php?route=api/cart/add&callfrom=orderform&token=${token}&store_id=${storeId}`;
		$.ajax({
	        url        : url,
	        type       : 'post',
	        dataType   : 'json',
	        data       : { product_id: product_id, quantity: quantity },
	        crossDomain: true,
	        beforeSend : function() { 
	        	$('#addProductBtn').attr('disabled', true).html('<i class="fa fa-spinner fa-spin"></i> loading...');
	        },
	        complete   : function() { 
	        	$('#addProductBtn').attr('disabled', false).html('<i class="fa fa-plus"></i> Add Product'); 
	        },
	        success    :  function(json) {
	            if (json['success']) {
              		if ($('input#product-autocomplete').length) {
              			$('input#product-autocomplete').val('').focus();
              			$('#quantity').val('');
              			$('.autocomplete-wrapper>span.clear-text').removeClass('show');
              		}
              		// remove item from the ul
              		$('.autocomplete-wrapper>ul>li[data-product-id="'+product_id+'"]').removeClass('add-to-cart');

                    // get products
		            Orders.getProducts(token);
	            } else {
	            	// error message
	            	var message = '';
	            	if (json['error'] && typeof json['error'] === "string") {
	            		message = json['error'];
	            	} else if (typeof json['error'] === "object") {
	            		if (json['error']['store']) {
	            			message = json['error']['store'];
	            		}
	            	} else {
	            		message = 'Failed to add product. An unexpected error occured.';
	            	}

	            	// display error message
	            	if (typeof swal === "function") {
	            		swal("Error!", message, "error");
	            	} else {
	            		alert(message);
	            	}
	            }
	        },
	        error: function(xhr, ajaxOptions, thrownError) {
	            alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
	        }
	    });
	}
};




/**
 *
 * Add Products to Cart Session [Orders]
 * 
 */
Orders.setProducts = function(callback) {
	if ($('#content').data('api-token')) {
		var catalog     = $('#content').data('catalog');
		var token       = $('#content').data('api-token');
		var customerTab = $('#tab-customer');
	   	var storeId     = customerTab.find('input[name="store_id"]').val();
		var url         = `${catalog}index.php?route=api/cart/add&callfrom=orderform&token=${token}&store_id=${storeId}`;
		var products    = [];

		// get products from the dom
		// build product object array
		$('#product-list-table>ul>li').each(function(i,item) {
			var item     = $(item);
			var id       = item.data('product-id');
			var quantity = item.data('quantity');
			products.push({product_id: id, quantity: quantity});
		});

		$.ajax({
	        url        : url,
	        type       : 'post',
	        dataType   : 'json',
	        data       : {product: products},
	        crossDomain: true,
	        beforeSend : function() { 
	        	$('#addProductBtn').attr('disabled', true).html('<i class="fa fa-spinner fa-spin"></i> loading...');
	        },
	        complete   : function() { 
	        	$('#addProductBtn').attr('disabled', false).html('<i class="fa fa-plus"></i> Add Product'); 
	        },
	        success    :  function(json) {
	            if (json['success']) {
					if ($('input#product-autocomplete').length) {
						$('input#product-autocomplete').val('').focus();
						$('#quantity').val('');
						$('.autocomplete-wrapper>span.clear-text').removeClass('show');
					}

				  	// get products
				  	Orders.getProducts(token);
					
					// callback(s)
					if (callback !== undefined) {
						callback();
					}

				} else {
					// error message
					var message = '';
					if (json['error'] && typeof json['error'] === "string") {
						message = json['error'];
					} else if (typeof json['error'] === "object") {
						if (json['error']['store']) {
							message = json['error']['store'];
						}
					} else {
						message = 'Failed to display products. An unexpected error occured.';
					}

					// display error message
					if (typeof swal === "function") {
						swal("Error!", message, "error");
					} else {
						alert(message);
					}
				}
	        },
	        error: function(xhr, ajaxOptions, thrownError) {
	            alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
	        }
	    });
	}
};


/**
 *
 * Update Product [cart item]
 * @param {integer} key         cart item identifier
 * @param {integer} product id  product identifier
 * @param {integer} quantity    number of cart items
 */
Orders.updateProduct = function(key, product_id, quantity) {
	var catalog    = $('#content').data('catalog');
	var token      = $('#content').data('api-token');
	var customerTab= $('#tab-customer');
   	var storeId    = customerTab.find('input[name="store_id"]').val();
	var url        = `${catalog}index.php?route=api/cart/edit&callfrom=orderform&token=${token}&store_id=${storeId}`;

	$.ajax({
		url       : url,
		type      : 'post',
		data      : {key: key, quantity: quantity},
		dataType  : 'json',
		beforeSend: function() {
			if ($('.sweet-overlay').length === 0) {
				$('.loader-wrapper').show();
			}
		},
		complete  : function() {
			$('.loader-wrapper').hide();
		},
		success   : function(json) {
			if (json['success']) {
				// get products
	            Orders.getProducts(token);
			} else {
				var message = (json['error']) ? json['error'] : 'Failed to update product. An unexpected error occured.';
            	if (typeof swal === "function") {
            		swal("Error!", message, "error");
            	} else {
            		alert(message);
            	}
			}
		}
	});
};


/**
 *
 * Remove Product from Order [Cart]
 * @param {integer} key         cart item identifier
 * @param {integer} product id  product identifier
 */
Orders.removeProduct = function(key, product_id) {
	var catalog    = $('#content').data('catalog');
	var token      = $('#content').data('api-token');
	var customerTab= $('#tab-customer');
   	var storeId    = customerTab.find('input[name="store_id"]').val();
	var url        = `${catalog}index.php?route=api/cart/remove&callfrom=orderform&token=${token}&store_id=${storeId}`;

	$.ajax({
		url       : url,
		type      : 'post',
		data      : { key: key },
		dataType  : 'json',
		beforeSend: function() {
			if ($('.sweet-overlay').length === 0) {
				$('.loader-wrapper').show();
			}
		},
		complete  : function() {
			$('.loader-wrapper').hide();
		},
		success   : function(json) {
			if (json['success']) {
				if ($('input#product-autocomplete').length) {
		    		$('input#product-autocomplete').parent().find(`ul>li[data-product-id="${product_id}"]`).addClass('add-to-cart');
		    	}
		    	// remove trow from the dom
		    	$('#product-list-table>table>tbody>tr[data-product-id="'+product_id+'"]').remove();
	    		// get products
	            Orders.getProducts(token);
			} else {
				var message = (json['error']) ? json['error'] : 'Failed to remove product. An unexpected error occured.';
            	if (typeof swal === "function") {
            		swal("Error!", message, "error");
            	} else {
            		alert(message);
            	}
			}
		}
	});	
};


/**
 *
 * Get Products from Cart [Order]
 * @param {string} token      api session access token
 */
Orders.getProducts = function(token) {

	var catalog = $('#content').data('catalog');
	var customerTab = $('#tab-customer');
	var storeId     = customerTab.find('input[name="store_id"]').val();
	var url         = `${catalog}index.php?route=api/cart/products&callfrom=orderform&token=${token}&store_id=${storeId}`;
	$.ajax({
		url        : url,
		type       : 'get',
		dataType   : 'json',
		crossDomain: true,
		beforeSend : function() {
			if ($('.sweet-overlay').length === 0) {
				$('.loader-wrapper').show();
			}
		},
		complete   : function() {
			$('.loader-wrapper').hide();
		},
		success    : function(json) {

			var productTable = $('#product-list-table table');
			var showProduct  = false;

			$('#product-list-table > .alert').remove();

			// check if there is an error
			// Check for errors
			if (json['error']) {
				if (json['error']['warning']) {
					$('#product-list-table > hr').after(`<div class="alert alert-danger"><i class="fa fa-exclamation-circle"></i> ${json['error']['warning']} <button type="button" class="close" data-dismiss="alert">&times;</button></div>`);
				}

				if (json['error']['stock']) {
					$('#product-list-table > hr').after(`<div class="alert alert-danger"><i class="fa fa-exclamation-circle"></i> ${json['error']['stock']}</div>`);
				}

				if (json['error']['minimum']) {
					var i;
					for (i in json['error']['minimum']) {
						$('#product-list-table > hr').after(`<div class="alert alert-danger"><i class="fa fa-exclamation-circle"></i> ${json['error']['minimum'][i]} <button type="button" class="close" data-dismiss="alert">&times;</button></div>`);
					}
				}
				if ($('#button-save').length) {
					$('#button-save').attr('disabled', true);
				}
				if ($('#button-confirm').length) {
					$('#button-confirm').attr('disabled', true);
				}
			} else {
				if ($('#button-save').length) {
					$('#button-save').attr('disabled', false);
				}
				if ($('#button-confirm').length) {
					if ($('select#input-payment_method').val().length > 0 && $('select#input-shipping_method').val().length > 0) {
						$('#button-confirm').attr('disabled', false);
					}
				}
			}

			// populate product table [tbody]
			if (json['products']) {
				var tbody = '';
				for (var i=0; i<json['products'].length; i++) {
					var stock = (json['products'][i].stock) ? '' : '<span class="text-red">***</span>';
					tbody    += `<tr data-product-id="${json['products'][i].product_id}" data-cart-id="${json['products'][i].cart_id}">`;
					tbody    += `<td class="text-left image"><img src="${json['products'][i].image}" /></td>`;
	                tbody    += `<td class="text-left name">${json['products'][i].name} ${stock}</td>`;
	                tbody    += `<td class="text-left model">${json['products'][i].model}</td>`;
	                tbody    += `<td class="text-right quantity"><input class="form-control" type="number" min="1" value="${json['products'][i].quantity}" data-qty="${json['products'][i].quantity}"/></td>`;
	                tbody    += `<td class="text-right price">${json['products'][i].price}</td>`;
	                tbody    += `<td class="text-right total">${json['products'][i].total}</td>`;
	                // if this is 'sale/order/processing' page
	                // do not allow user to remove item from cart
	                if (window.location.href.indexOf('sale/order/processing') === -1) {
	                	tbody+= `<td class="text-right"><a href="javascript:void();" class="btn btn-danger remove-product" data-product-id="${json['products'][i].product_id}" data-cart-id="${json['products'][i].cart_id}"><i class="fa fa-trash-o"></i></button></td>`;
	                }
					tbody    += `</tr>`;
				}
				productTable.find('tbody').html(tbody);
				showProduct = true;
			}
			// populate product table [tfoot] | totals
			if (json['totals']) {
				var tfoot = '';
				var total = '';
				for (var i=0; i<json['totals'].length; i++) {
					tfoot += `<tr>`;
					tfoot += `<th class="text-right" colspan="5">${json['totals'][i].title}</th>`;
					tfoot += `<th class="text-left" colspan="2">${json['totals'][i].text}</th>`;
					tfoot += `</tr>`;

					// update total
					if (json['totals'][i].title.indexOf('Total ') === 0) {
						total = json['totals'][i].text;
					}
				}
				$('#total').html(total);
				productTable.find('tfoot').html(tfoot);
				showProduct = true;
			}

			if (showProduct) {
				$('#product-list-table').show();
			}
		},
		error: function(xhr, ajaxOptions, thrownError) {
			alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
		}
	});
};


/**
 *
 * Set Payment Address
 * @param {object}   data       data array/object
 * @param {string}   token      api session access token
 * @param {function} scallback  success callback function
 */
Orders.setPaymentAddress = function(data, token, scallback) {
	var catalog     = $('#content').data('catalog');
	var customerTab = $('#tab-customer');
	var storeId     = customerTab.find('input[name="store_id"]').val();
	var url         = `${catalog}index.php?route=api/payment/address&callfrom=orderform&token=${token}&store_id=${storeId}`;
	$.ajax({
		url        : url,
		type       : 'post',
		data       : data,
		dataType   : 'json',
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
				var i;
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
				
				if (typeof scallback !== "undefined") {
					scallback(json);
				}
			}
		},
		error: function(xhr, ajaxOptions, thrownError) {
			alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
		}
	});
};


/**
 *
 * Set Payment Method
 * @param {string} payment_method    selected shipping method
 * @param {string}   token           api session access token
 * @param {function} scallback       success callback function
 */
Orders.setPaymentMethod = function(payment_method, token, scallback) {
	var catalog     = $('#content').data('catalog');
	var customerTab = $('#tab-customer');
	var storeId     = customerTab.find('input[name="store_id"]').val();
	var url         = `${catalog}index.php?route=api/payment/method&token=${token}&store_id=${storeId}`;
	$.ajax({
		url: url,
		type: 'post',
		data: `payment_method=${payment_method}`,
		dataType: 'json',
		crossDomain: true,
		beforeSend: function() {
			$('#button-payment-method').button('loading');
		},
		complete: function() {
			$('#button-payment-method').button('reset');
		},
		success: function(json) {
			$('.alert, .text-danger').remove();
			$('.form-group').removeClass('has-error');

			if (json['error']) {
				$('#content > .container-fluid').prepend(`<div class="alert alert-danger"><i class="fa fa-exclamation-circle"></i> ${json['error']} <button type="button" class="close" data-dismiss="alert">&times;</button></div>`);

				// Highlight any found errors
				$('select[name="payment_method"]').closest('.form-group').addClass('has-error');
			}

			if (json['success']) {
				// $('#content > .container-fluid').prepend(`<div class="alert alert-success"><i class="fa fa-check-circle"></i> ${json['success']} <button type="button" class="close" data-dismiss="alert">&times;</button></div>`);
				if (typeof scallback !== "undefined") {
					scallback(json);
				}
			}
		},
		error: function(xhr, ajaxOptions, thrownError) {
			alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
		}
	});
};


/**
 *
 * Get Payment Methods
 * @param {string} token      api session access token
 */
Orders.getPaymentMethod = function(token) {
	var catalog     = $('#content').data('catalog');
	var customerTab = $('#tab-customer');
	var storeId     = customerTab.find('input[name="store_id"]').val();
	var url         = `${catalog}index.php?route=api/payment/methods&token=${token}&store_id=${storeId}`;
	$.ajax({
		url        : url,
		type       : 'get',
		dataType   : 'json',
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
						} else if (json['payment_methods'][i]['code'] == $('input[name="payment_code"]').val()) {
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
};


/**
 *
 * Set Shipping Address
 * @param {string}   token      api session access token
 * @param {function} scallback  success callback function
 */
Orders.setShippingAddress = function(token, scallback) {
	var catalog     = $('#content').data('catalog');
	var customerTab = $('#tab-customer');
	var storeId     = customerTab.find('input[name="store_id"]').val();
	var url         = `${catalog}index.php?route=api/shipping/address&callfrom=orderform&token=${token}&store_id=${storeId}`;
	$.ajax({
		url        : url,
		type       : 'post',
		data       : $('#tab-shipping input[type="text"], #tab-shipping input[type="hidden"], #tab-shipping input[type="radio"]:checked, #tab-shipping input[type="checkbox"]:checked, #tab-shipping select, #tab-shipping textarea'),
		dataType   : 'json',
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
				if (typeof scallback !== "undefined") {
					scallback(json);
				}
			}
		},
		error: function(xhr, ajaxOptions, thrownError) {
			alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
		}
	});
};


/**
 *
 * Get Shipping Address
 * @param {string}   address_id    customer address identifier
 * @param {function} scallback     success callback function
 */
Orders.getShippingAddress = function(address_id, scallback) {
	var token = $('#content').data('token');
	var url   = `index.php?route=customer/customer/address&token=${token}&address_id=${address_id}`;
	$.ajax({
		url       : url,
		type      : 'get',
		dataType  : 'json',
		beforeSend: function() {
			$('select[name="shipping_address"]').after(' <i class="fa fa-circle-o-notch fa-spin"></i>');
		},
		complete: function() {
			$('#tab-shipping .fa-spin').remove();
		},
		success: function(json) {
			// Reset all fields
			$('#tab-shipping input[type="text"], #tab-shipping input[type="text"], #tab-shipping textarea').val('');
			$('#tab-shipping select option').not('#tab-shipping select[name="shipping_address"]').removeAttr('selected');
			$('#tab-shipping input[type="checkbox"], #tab-shipping input[type="radio"]').removeAttr('checked');

			$('#tab-shipping input[name="firstname"]').val(json['firstname']);
			$('#tab-shipping input[name="lastname"]').val(json['lastname']);
			$('#tab-shipping input[name="company"]').val(json['company']);
			$('#tab-shipping input[name="address_1"]').val(json['address_1']);
			$('#tab-shipping input[name="address_2"]').val(json['address_2']);
			$('#tab-shipping input[name="city"]').val(json['city']);
			$('#tab-shipping input[name="postcode"]').val(json['postcode']);
			$('#tab-shipping select[name="country_id"]').val(json['country_id']);

			shipping_zone_id = json['zone_id'];

			for (i in json['custom_field']) {
				$('#tab-shipping select[name="custom_field[' + i + ']"]').val(json['custom_field'][i]);
				$('#tab-shipping textarea[name="custom_field[' + i + ']"]').val(json['custom_field'][i]);
				$('#tab-shipping input[name^="custom_field[' + i + ']"][type="text"]').val(json['custom_field'][i]);
				$('#tab-shipping input[name^="custom_field[' + i + ']"][type="hidden"]').val(json['custom_field'][i]);
				$('#tab-shipping input[name^="custom_field[' + i + ']"][type="radio"][value="' + json['custom_field'][i] + '"]').prop('checked', true);
				$('#tab-shipping input[name^="custom_field[' + i + ']"][type="checkbox"][value="' + json['custom_field'][i] + '"]').prop('checked', true);

				if (json['custom_field'][i] instanceof Array) {
					for (j = 0; j < json['custom_field'][i].length; j++) {
						$('#tab-shipping input[name^="custom_field[' + i + ']"][type="checkbox"][value="' + json['custom_field'][i][j] + '"]').prop('checked', true);
					}
				}
			}
			$('#tab-shipping select[name="country_id"]').trigger('change');
			if (typeof scallback !== "undefined") {
				scallback(json);
			}
		},
		error: function(xhr, ajaxOptions, thrownError) {
			alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
		}
	});
};


/**
 *
 * Get Payment Methods
 * @param {string} token      api session access token
 */
Orders.getShippingMethod = function(token) {
	var catalog     = $('#content').data('catalog');
	var customerTab = $('#tab-customer');
	var storeId     = customerTab.find('input[name="store_id"]').val();
	var url         = `${catalog}index.php?route=api/shipping/methods&token=${token}&store_id=${storeId}`;
	$.ajax({
		url     : url,
		type    : 'get', 
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
					var i;
					for (i in json['shipping_methods']) {
						html += '<optgroup label="' + json['shipping_methods'][i]['title'] + '">';

						if (!json['shipping_methods'][i]['error']) {
							for (var j in json['shipping_methods'][i]['quote']) {
								if (json['shipping_methods'][i]['quote'][j]['code'] == $('select[name="shipping_method"] option:selected').val()) {
									html += '<option value="' + json['shipping_methods'][i]['quote'][j]['code'] + '" selected="selected">' + json['shipping_methods'][i]['quote'][j]['title'] + ' - ' + json['shipping_methods'][i]['quote'][j]['text'] + '</option>';
								} else if (json['shipping_methods'][i]['quote'][j]['code'] == $('input[name="shipping_code"]').val()) {
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
};


/**
 *
 * Get Payment Methods
 * @param {string} shipping_method    selected shipping method
 * @param {string} token              api session access token
 * @param {function} scallback        success callback function
 */
Orders.setShippingMethod = function(shipping_method, token, scallback) {
	var catalog     = $('#content').data('catalog');
	var customerTab = $('#tab-customer');
	var storeId     = customerTab.find('input[name="store_id"]').val();
	var url         = `${catalog}index.php?route=api/shipping/method&token=${token}&store_id=${storeId}`;
	$.ajax({
		url        : url,
		type       : 'post',
		data       : `shipping_method=${shipping_method}`,
		dataType   : 'json',
		crossDomain: true,
		beforeSend : function() {
			$('#button-shipping-method').button('loading');
		},
		complete: function() {
			$('#button-shipping-method').button('reset');
		},
		success: function(json) {
			$('.alert, .text-danger').remove();
			$('.form-group').removeClass('has-error');

			if (json['error']) {
				$('#content > .container-fluid').prepend(`<div class="alert alert-danger"><i class="fa fa-exclamation-circle"></i> ${json['error']} <button type="button" class="close" data-dismiss="alert">&times;</button></div>`);

				// Highlight any found errors
				$('select[name="shipping_method"]').closest('.form-group').addClass('has-error');
			}

			if (json['success']) {
				// $('#content > .container-fluid').prepend(`<div class="alert alert-success"><i class="fa fa-check-circle"></i> ${json['success']} <button type="button" class="close" data-dismiss="alert">&times;</button></div>`);
				if (typeof scallback !== "undefined") {
					scallback(json);
				}
			}
		},
		error: function(xhr, ajaxOptions, thrownError) {
			alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
		}
	});
};


/**
 *
 * Save/Create new Order
 * @param {string} token         api session access token
 * @param {function} scallback   success callback function
 */
Orders.save = function(token, scallback) {
	var catalog     = $('#content').data('catalog');
	var customerTab = $('#tab-customer');
	var storeId     = customerTab.find('input[name="store_id"]').val();
	var url         = `${catalog}index.php?route=api/order/add&token=${token}&store_id=${storeId}`;
	// order post data
	var orderData   = {
		payment_method : $('select#input-payment_method').val(),
		shipping_method: $('select#input-shipping_method').val(),
		order_status_id: $('input[name="order_status_id"]').val(),
		comment        : $('textarea#input-comment').val()
	};
	$.ajax({
		url        : url,
		type       : 'post',
		data       : orderData,
		dataType   : 'json',
		crossDomain: true,
		beforeSend : function() {
			if ($('.sweet-overlay').length === 0) {
				$('.loader-wrapper').show();
			}
		},
		complete: function() {
			$('.loader-wrapper').hide();
		},
		success: function(json) {
			$('.alert, .text-danger').remove();

			if (json['error']) {
				$('#content > .container-fluid').prepend(`<div class="alert alert-danger"><i class="fa fa-exclamation-circle"></i> ${json['error']} <button type="button" class="close" data-dismiss="alert">&times;</button></div>`);
			}

			if (json['success']) {
				if (typeof scallback !== "undefined") {
					scallback(json);
				} else {
					var utoken = $('#content').data('token');
					var url    = `index.php?route=sale/order&token=${utoken}`;
					window.location.href = url;
				}
            }

			if (json['order_id']) {
				$('input[name="order_id"]').val(json['order_id']);
			}
		},
		error: function(xhr, ajaxOptions, thrownError) {
			alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
		}
	});
};


/**
 *
 * Cancel Order
 * @param {string} token         api session access token
 * @param {function} scallback   success callback function
 */
Orders.cancel = function(token, scallback) {
	var orderId = $('#content').data('order-id');
	var url     = `index.php?route=sale/order/cancel&token=${token}&order_id=${orderId}`;
	$.ajax({
		url        : url,
		type       : 'post',
		dataType   : 'json',
		success: function(json) {
			if (json['error']) {
				swal("Error!", json['error'], "error");
				return;
			}
			if (json['success']) {
				if (typeof scallback !== "undefined") {
					scallback(json);
				} else {
					swal({
						title: "Order Cancelled!",
						text: json['success'],
						type: "success",
					},
					function() {
						window.location.href = `index.php?route=sale/order&token=${token}`;
					});
				}
            }
		},
		error: function(xhr, ajaxOptions, thrownError) {
			alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
		}
	});
};


/*****************************************************************
 *
 * Quotes functions
 *
 *****************************************************************/

var Quotes = {};

/**
 *
 * Initiate Quote
 * 
 */
Quotes.init = function() {

	/**********************************************
	*            		API Login            
	***********************************************/

	if ($('#payment-shipping-details').length) {
		if ($('#content').data('catalog') !== undefined) {

			var catalog     = $('#content').data('catalog');
			var apiLoginUrl = `${catalog}index.php?route=api/login`;
			var apiKey      = $('#content').data('api-key');
			$.ajax({
				url        : apiLoginUrl,
				type       : 'post',
				dataType   : 'json',
				data       : 'key='+apiKey,
				crossDomain: true,
				beforeSend : function() {
					if ($('.sweet-overlay').length === 0) {
						$('.loader-wrapper').show();
					}
				},
				success: function(json) {

					// remove page loader
					$('.loader-wrapper').hide();

			        if (json['error']) {

						var title = "Error!";
						var text  = "An unexpected error has occured, please try again later.";
						var type  = "error";

			    		if (json['error']['key']) {
							text = json['error']['key'];
			    		}
			            if (json['error']['ip']) {
							text = json['error']['ip'];
						}

						swal({
							title: title,
							text : text,
							type : type
						},
						function() {
							window.location.href = $('#button-cancel').attr('href');
						});
			        }

			        if (json['token']) {
			        	// store API TOKEN into the DOM element through data attribute
						$('#content').attr('data-api-token', json['token']);
					}
				},
				error: function(xhr, ajaxOptions, thrownError) {
					alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
				}
			}).done(function() {

				// only execute code below once api login is done and successful
				if ($('#content').data('api-token') !== undefined) {

					// retrive API TOKEN from DOM (data attribute)
					var token = $('#content').data('api-token');

				// 	// customer details tab content (hidden input data)
					var customerTab = $('#tab-customer');
					var storeId     = customerTab.find('input[name="store_id"]').val()

		            /**********************************************
					*            Modify Customer [Custom Fields]            
					***********************************************/

		            var utoken          = $('#content').data('token');
		            var customerGroupId = customerTab.find('input[name="customer_group_id"]').val();
		            var custGrpApiUrl   = `index.php?route=customer/customer/customfield&token=${utoken}&customer_group_id=${customerGroupId}`
		            $.ajax({
		                url        : custGrpApiUrl,
		                type       : 'get',
		                dataType   : 'json',
		                crossDomain: true,
		                success    :  function(json) {
		                    if (json['error']) {
		                    	var message = (json['error']) ? json['error'] : 'An unexpected error occured.';
		                    	if (typeof swal === "function") {
				            		swal("Error!", message, "error");
				            	} else {
				            		alert(message);
				            	}
		                    }
		                },
		                error: function(xhr, ajaxOptions, thrownError) {
		                    alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
		                }
		            }).done(function() {

			            /**********************************************
						*               Modify customer            
						***********************************************/

			            var custApiUrl      = `${catalog}index.php?route=api/customer&callfrom=orderform&token=${token}&store_id=${storeId}`;
			            $.ajax({
			                url        : custApiUrl,
			                type       : 'post',
			                dataType   : 'json',
			                data       : $('#tab-customer input').serialize(),
			                crossDomain: true,
			                success:  function(json) {
			                    if (json['error']) {
			                    	var message = '';
									if (typeof json['error'] === "object") {
										Object.keys(json['error']).forEach(function(key) {
										    message += `${key}: ${json['error'][key]} `;
										});
									} else {
										message = (json['error']) ? json['error'] : 'Failed to add customer. An unexpected error occured.';
									}

			                    	if (typeof swal === "function") {
					            		// swal("Error!", message, "error");
					            		swal({
										  	title: "Error!",
										  	text: message,
										  	type: "error"
										},
										function(){
										  	var utoken           = $('#content').data('token');
											var url              = `index.php?route=replogic/order_quotes&token=${utoken}`;
											window.location.href = url;
											$('.loader-wrapper').show();
										});
					            	} else {
					            		alert(message);
					            	}
			                    }
			                },
			                error: function(xhr, ajaxOptions, thrownError) {
			                    alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
			                }
			            }).done(function() {

				            /**********************************************
							*    Store product line items in cart [API]          
							***********************************************/

							Quotes.setProducts();
						});
					});
		            
				}
			});
		}
	} else {
		$('.loader-wrapper').hide();
	}
};


/**
 *
 * Get Products from Cart [Quote]
 * @param {string} token      api session access token
 */
Quotes.getProducts = function(token) {

	var catalog = $('#content').data('catalog');
	var customerTab = $('#tab-customer');
	var storeId     = customerTab.find('input[name="store_id"]').val();
	var url         = `${catalog}index.php?route=api/cart/products&callfrom=orderform&token=${token}&store_id=${storeId}`;
	$.ajax({
		url        : url,
		type       : 'get',
		dataType   : 'json',
		crossDomain: true,
		beforeSend : function() {
			if ($('.sweet-overlay').length === 0) {
				$('.loader-wrapper').show();
			}
		},
		complete   : function() {
			$('.loader-wrapper').hide();
		},
		success    : function(json) {

			var productTable = $('#product-list-table table');
			var showProduct  = false;
			var error        = false;

			$('#product-list-table > .alert').remove();

			// check if there is an error
			// Check for errors
			if (json['error']) {
				if (json['error']['warning']) {
					error = true;
					$('#product-list-table > table').before(`<div class="alert alert-danger"><i class="fa fa-exclamation-circle"></i> ${json['error']['warning']} <button type="button" class="close" data-dismiss="alert">&times;</button></div>`);
				}

				if (json['error']['stock']) {
					error = true;
					$('#product-list-table > table').before(`<div class="alert alert-danger"><i class="fa fa-exclamation-circle"></i> ${json['error']['stock']}</div>`);
				}

				if (json['error']['minimum']) {
					error = true;
					var i;
					for (i in json['error']['minimum']) {
						$('#product-list-table > table').before(`<div class="alert alert-danger"><i class="fa fa-exclamation-circle"></i> ${json['error']['minimum'][i]} <button type="button" class="close" data-dismiss="alert">&times;</button></div>`);
					}
				}
			}

			// populate product table [tbody]
			if (json['products']) {

				if (json['products'].length === 0) {
					$('#input-shipping_method').prop('disabled', true);
					$('#input-payment_method').prop('disabled', true);
					$('select[name="shippingaddress"]').prop('disabled', true);
					$('#product-list-table > table').before(`<div class="alert alert-danger"><i class="fa fa-exclamation-circle"></i> No items found in your cart.</div>`);
				}

				var tbody = '';
				for (var i=0; i<json['products'].length; i++) {
					var stock = (json['products'][i].stock) ? '' : '<span class="text-red">***</span>';
					tbody    += `<tr data-product-id="${json['products'][i].product_id}" data-cart-id="${json['products'][i].cart_id}">`;
					tbody    += `<td class="text-left image"><img src="${json['products'][i].image}" /></td>`;
	                tbody    += `<td class="text-left name">${json['products'][i].name} ${stock}</td>`;
	                tbody    += `<td class="text-left model">${json['products'][i].model}</td>`;
	                tbody    += `<td class="text-right quantity">${json['products'][i].quantity}</td>`;
	                tbody    += `<td class="text-right price">${json['products'][i].price}</td>`;
	                tbody    += `<td class="text-right total">${json['products'][i].total}</td>`;
					tbody    += `</tr>`;
				}
				productTable.find('tbody').html(tbody);
				showProduct = true;
			}
			// populate product table [tfoot] | totals
			if (json['totals']) {
				var tfoot = '';
				var total = '';
				for (var i=0; i<json['totals'].length; i++) {
					tfoot += `<tr>`;
					tfoot += `<th class="text-right" colspan="5">${json['totals'][i].title}</th>`;
					tfoot += `<th class="text-left" colspan="2">${json['totals'][i].text}</th>`;
					tfoot += `</tr>`;

					// update total
					if (json['totals'][i].title.indexOf('Total ') === 0) {
						total = json['totals'][i].text;
					}
				}
				$('#total').html(total);
				productTable.find('tfoot').html(tfoot);
				showProduct = true;
			}

			if (showProduct) {
				$('#product-list-table').show();
			}

			// if there's an error
			if (error) {
				Quotes.lockConversion();
			}
		},
		error: function(xhr, ajaxOptions, thrownError) {
			alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
		}
	});
};


/**
 *
 * Lock Quote conversion to order
 * 
 */
Quotes.lockConversion = function() {
	$('#input-shipping_method').attr('disabled', true);
	$('#input-payment_method').attr('disabled', true);
	$('#addNewAddress').hide();
	$('select[name="shippingaddress"]').attr('disabled', true);
};


/**
 *
 * Add Product to Quote [Cart]
 * 
 * @param {integer} product id  product identifier
 * @param {integer} quantity    number of products to be added to order/cart
 */
Quotes.setProducts = function() {
	if ($('#content').data('api-token')) {
		var catalog    = $('#content').data('catalog');
		var token      = $('#content').data('api-token');
		var customerTab= $('#tab-customer');
	   	var storeId    = customerTab.find('input[name="store_id"]').val();
		var url        = `${catalog}index.php?route=api/cart/add&callfrom=orderform&token=${token}&store_id=${storeId}`;
		var products    = [];

		// get products from the dom
		// build product object array
		$('#product-list-table>ul>li').each(function(i,item) {
			var item     = $(item);
			var id       = item.data('product-id');
			var quantity = item.data('quantity');
			products.push({product_id: id, quantity: quantity});
		});

		$.ajax({
	        url        : url,
	        type       : 'post',
	        dataType   : 'json',
	        data       : {product: products},
	        crossDomain: true,
	        beforeSend : function() { 
	        	$('#addProductBtn').attr('disabled', true).html('<i class="fa fa-spinner fa-spin"></i> loading...');
	        },
	        complete   : function() { 
	        	$('#addProductBtn').attr('disabled', false).html('<i class="fa fa-plus"></i> Add Product'); 
	        },
	        success    :  function(json) {
	            if (json['error']) {
	            	var message = (json['error']) ? json['error'] : 'Failed to add product. An unexpected error occured.';
	            	if (typeof swal === "function") {
	            		swal("Error!", message, "error");
	            	} else {
	            		alert(message);
	            	}
	            }
	        },
	        error: function(xhr, ajaxOptions, thrownError) {
	            alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
	        }
	    }).done(function() {

            /**********************************************
			* Set Payment Address and Get Payment Methods            
			***********************************************/

			var paymentPostData = $('#tab-payment input[type="text"], #tab-payment input[type="hidden"], #tab-payment input[type="radio"]:checked, #tab-payment input[type="checkbox"]:checked, #tab-payment select, #tab-payment textarea');

			Orders.setPaymentAddress(paymentPostData, token,
			function(json) {
				Orders.getPaymentMethod(token);
			});


            /**********************************************
			* Set Shipping Address and Get Shipping Methods            
			***********************************************/

			Orders.setShippingAddress(token,
			function(json) {
				Orders.getShippingMethod(token);
			});

            /**********************************************
			* Set Payment Address and Get Payment Methods            
			***********************************************/
			
            Quotes.getProducts(token);
	    });
	}
};


/**
 *
 * Convert Quote to Order
 * @param {string} token         api session access token
 * @param {function} scallback   success callback function
 */
Quotes.convert = function(token, scallback) {
	var quoteId     = $('#content').data('quote-id');
	var catalog     = $('#content').data('catalog');
	var customerTab = $('#tab-customer');
	var storeId     = customerTab.find('input[name="store_id"]').val();
	var url         = `${catalog}index.php?route=api/order/add&token=${token}&store_id=${storeId}&quote_id=${quoteId}`;
	// post data object
	var postData    = {
		payment_method : $('select#input-payment_method').val(),
		shipping_method: $('select#input-shipping_method').val(),
		order_status_id: $('input[name="order_status_id"]').val(),
		comment        : $('textarea#input-comment').val()
	};
	$.ajax({
		url        : url,
		type       : 'post',
		data       : postData,
		dataType   : 'json',
		crossDomain: true,
		beforeSend : function() {
			if ($('.sweet-overlay').length === 0) {
				$('.loader-wrapper').show();
			}
		},
		complete: function() {
			$('.loader-wrapper').hide();
		},
		success: function(json) {
			$('.alert, .text-danger').remove();

			if (json['error']) {
				$('#content > .container-fluid').prepend(`<div class="alert alert-danger"><i class="fa fa-exclamation-circle"></i> ${json['error']} <button type="button" class="close" data-dismiss="alert">&times;</button></div>`);
			}

			if (json['success']) {
				if ($('a.quote-status').length) {
					$('a.quote-status').html('Order Confirmed').addClass('success');
				}
				if (typeof scallback !== "undefined") {
					scallback(json);
				} else {
					var utoken = $('#content').data('token');
					var url    = `index.php?route=replogic/order_quotes&token=${utoken}`;
					window.location.href = url;
				}
            }

			if (json['order_id']) {
				$('input[name="order_id"]').val(json['order_id']);
			}
		},
		error: function(xhr, ajaxOptions, thrownError) {
			alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
		}
	});
};


/**
 *
 * Deny Quote
 * @param {integer}  quote_id         api session access token
 * @param {string}   reason           reason for denying the quote
 */
Quotes.deny = function(quote_id, reason) {
	var url = $('#button-deny').data('href');
	$.ajax({
		url       : url,
		type      : 'post',
		dataType  : 'json',
		data      : {quote_id: quote_id, reason: reason},
		beforeSend: function() {
			if ($('.sweet-overlay').length === 0) {
				$('.loader-wrapper').show();
			}
		},
		success   : function(json) {
			if (json['success']) {
				if (typeof swal === "function") {
					swal({
					  	title: "Quote Denied!",
					  	text: "Quote successfully denied. Now you'll be redirected to the quote list.",
					  	type: "success"
					},
					function() {
						window.location.href = $('#button-cancel').attr('href');
					});
				} else {
					alert("Quote successfully denied. Now you'll be redirected to the quote list.");
					window.location.href = $('#button-cancel').attr('href');
				}
			}
			$('.loader-wrapper').hide();
		}
	});
};