(function ($) {
    "use strict";

    var initResendPassword = function () {
    	$(document).on('click', '#resend-password', function(e) {
    		e.preventDefault();
    		var userName = $(this).data('username');
    		var token    = $(this).data('token');
    		var userId   = $(this).data('userid');
    		var postData = { ajax:1, action:'resend_password', user_id:userId };
    		swal({
				title: "Are you sure?",
				text: "You are about to resend password to "+userName+".",
				type: "warning",
				showCancelButton: true,
				confirmButtonClass: "btn-info",
				confirmButtonText: "Yes, send it!",
				closeOnConfirm: false
			},
			function(isConfirm){
				if (isConfirm) {
					$.ajax({
		    			url: "index.php?route=user/user/resend_password&token="+token,
		    			type: 'POST',
		    			data: postData,
		    			beforeSend: function() {
		    				$('.loader-wrapper').show();
		    			},
		    			success: function(xhr) {
		    				var res = $.parseJSON(xhr);
		    				$('.loader-wrapper').hide();
		    				if (res.success)
		    					swal("Sent!", "Password has been sent to "+userName+".", "success");
		    				else
		    					swal("Error!", "An unexpected error has occurred.", "error");
		    			}
		    		});
				}
			});
    	});
    };

    initResendPassword();

}(jQuery));