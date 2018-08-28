(function ($) {
    "use strict";

    var initResendPassword = function () {
    	$(document).on('click', '#resend-password', function(e) {
    		e.preventDefault();
    		var repName  = $(this).data('repname');
    		var repEmail = $(this).data('email');
    		var apiURL   = $(this).data('api-baseurl') + 'user/resetpassword';
    		swal({
				title: "Are you sure?",
				text: "You are about to reset and resend password to "+repName+".",
				type: "info",
				showCancelButton: true,
				confirmButtonText: "Yes, send it!",
				closeOnConfirm: false,
				showLoaderOnConfirm: true
			},
			function(isConfirm){
				if (isConfirm) {
					$.ajax({
		    			url        : apiURL,
		    			type       : 'POST',
		    			data       : { email : repEmail },
		    			dataType   : 'json',
		    			crossDomain: true,
		    			success    : function(json) {
		    				console.log(json);
		    				if (json['status'] == 200) {
		    					swal("Sent!", "Password has been sent to "+repName+".", "success");
		    				} else {
		    					swal("Error!", "An unexpected error has occurred.", "error");
		    				}
		    			}
		    		});
				}
			});
    	});
    };

    initResendPassword();

}(jQuery));
