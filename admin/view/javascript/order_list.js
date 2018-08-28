(function($) {
    "use strict";

    var $document     = $(document);
    var initOrderList = function() {
        
        /****************************************************
         * Show create order modal
         * @event : click
         ****************************************************/
    	
    	$document.on('click', '#createOrder', function(e) {
    		e.preventDefault();
    		// reset controls
			$('input[name="contract_pricing"]').val('--');
			$('button#createOrderBtn').attr('disabled', true);
    		$('#createOrderModal').modal("show");
    	});
        
        /****************************************************
         * Customer select [create order modal]
         * @event : change
         ****************************************************/

    	$document.on('change', '#createOrderModal select[name="customer"]', function() {
    		// reset controls
			$('input[name="contract_pricing"]').val('--');
			$('button#createOrderBtn').attr('disabled', true);

			// if customer is selected
    		if ($(this).val().length > 0) {
	    		var token           = $('#content').data('token');
	    		var customerId      = $(this).val();
	    		var contractPricing = $(this).find(':selected').data('contract-pricing');

	    		// populate contract pricing
	    		$('input[name="contract_pricing"]').val(contractPricing);

	    		// enable continue button
	    		$('button#createOrderBtn').attr('disabled', false);
    		}
    	});
        
        /****************************************************
         * Continue button
         * @event : click
         ****************************************************/

        $document.on('submit', '#createOrderModal form', function(e) {
            e.preventDefault();
            var data = $(this).serializeObject();
            if (typeof data === "object" && data.customer.length > 0) {
                $('.loader-wrapper').show();
                var comment = (data.comment.length > 0) ? `&comment=${data.comment}` : ``;
                window.location.href = `index.php?route=${data.route}&token=${data.token}&customer=${data.customer}${comment}`;     
            }
        });
    	
    };

    initOrderList();

}(jQuery));