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
            
            if (location.search.indexOf('back') !== -1) {

                var api     = JSON.parse(localStorage.getItem('api'));
                var token   = api.token;

                $('#content').attr('data-api-token', token);

                // get order line items
                Orders.getProducts(token);

            } else {
                Orders.init();
            }
    	});

        
        /****************************************************
         * Discard/Cancel Button 
         * @event : click
         ****************************************************/

        $document.on('click', '#button-cancel', function(e) {
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
         * Continue/Save Button
         * @event : click
         ****************************************************/

        $document.on('click', '#button-save', function(e) {
            var that = $(this);
            e.preventDefault();
            swal({
                title: "Continue with Order!",
                text: "To continue creating the order you will now be asked to add shipping and payment details.",
                type: "info",
                showCancelButton: true,
                confirmButtonClass: "btn-default",
                confirmButtonText: "Continue",
                closeOnConfirm: false,
                showLoaderOnConfirm: true
            },
            function(isConfirm){
                if (isConfirm) {
                    var api = {
                        key  : $('#content').data('api-key'),
                        token: $('#content').data('api-token')
                    };
                    localStorage.setItem('api', JSON.stringify(api));
                    window.location.href = that.data('href');
                }
            });
        });
        
        
        /****************************************************
         * Product Search Autocomplete Input
         * @event : keyup or click
         ****************************************************/
    	
    	$document.on('keyup click', 'input#product-autocomplete', function(e) {
    		$(this).parent().find('ul>li').hide();
    		$('button#addProductBtn').attr('disabled', true);
    		if ($(this).parent().find("ul>li.add-to-cart:Contains('" + $(this).val() + "')")) {
    			$(this).parent().find("ul").show();
    			$(this).parent().find("ul>li.add-to-cart:Contains('" + $(this).val() + "')").show();
    		}
            $(this).parent().find('span.clear-text').addClass('show');
    	});


        $document.on('click', '.autocomplete-wrapper>span.clear-text', function() {
            $(this).removeClass('show');
            $('input#product-autocomplete').val('').focus();
            $('button#addProductBtn').attr('disabled', true);
            $('#quantity').val('');
            $(this).parent().find('ul').hide();
        });
        
        
        /****************************************************
         * Product list [ul] selection
         * @event : click
         ****************************************************/

    	$document.on('click', 'div.autocomplete-wrapper>ul>li', function(event) {
    		$('input#product-autocomplete').val($(this).data('product-name'))
    		.attr('data-product-id', $(this).data('product-id'))
    		.attr('data-product-name', $(this).data('product-name'))
    		.attr('data-product-image', $(this).data('product-image'))
    		.attr('data-product-model', $(this).data('product-model'))
    		.attr('data-product-qty', $(this).data('product-qty'))
    		.attr('data-product-price', $(this).data('product-price'));
    		$('div.autocomplete-wrapper>ul').hide().children('li').show();
    		$('input#quantity').val(1);
    		$('button#addProductBtn').attr('disabled', false);
    	});
        
        
        /****************************************************
         * Add Product Button
         * @event : click
         ****************************************************/

    	$document.on('click', 'button#addProductBtn', function() {
            // add single product to cart
            Orders.addProduct($('input#product-autocomplete').attr('data-product-id'), $('#quantity').val());
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