(function ($) {
    "use strict";

    var initPasswordStrength = function () {
    	$(document).on('keyup', '#password1', function() {
    		var strength = 0;
    		var password = $(this).val();

    		// Reset
    		$('.password-strength').html('').removeClass('weak short strong good');
    		$('#button-change-password').attr('disabled', true);
    		$('.password-match').html('').removeClass('text-success text-danger');
    		$('#password2').val('');

    		// if password is too short in length [i.e. less than 8 characters], display message and exit.
    		if (password.length < 8) {
    			$('.password-strength')
    			.addClass('short')
    			.html('Too short');
    			return;
    		}
    		// if password is more than 12 characters long, increase strength value.
    		if (password.length < 12)
    			strength += 1;
    		// if password contains both lower and uppercase characters, increase strength value.
    		if (password.match(/([a-z].*[A-Z])|([A-Z].*[a-z])/))
    			strength += 1;
    		// If it has numbers and characters, increase strength value.
    		if (password.match(/([a-zA-Z])/) && password.match(/([0-9])/)) 
    			strength += 1;
			// If it has one special character, increase strength value.
			if (password.match(/([!,%,&,@,#,$,^,*,?,_,~])/)) 
				strength += 1;
			// If it has two special characters, increase strength value.
			if (password.match(/(.*[!,%,&,@,#,$,^,*,?,_,~].*[!,%,&,@,#,$,^,*,?,_,~])/)) 
				strength += 1;

			// Calculated strength value, we can return messages
			// If value is less than 2
			if (strength < 2) {
				$('.password-strength')
				.addClass('weak')
    			.html('Weak');
				return;
			} else if (strength == 2) {
				$('.password-strength')
				.addClass('average')
    			.html('Average');
				return;
			} else {
				$('.password-strength')
				.addClass('strong')
    			.html('Strong');
				return;
			}
    	});
    };

    var initPasswordMatch = function () {
    	$(document).on('keyup', '#password2', function() {
    		var password1 = $('#password1').val();
    		var password2 = $(this).val();

    		// Reset
    		$('.password-match')
    		.html('')
    		.removeClass('text-success text-danger');

    		if (password1 === password2) {
    			$('.password-match')
    			.html('Passwords match!')
    			.addClass('text-success');

    			if ($('.password-strength').hasClass('average') || $('.password-strength').hasClass('strong')) {
    				$('#button-change-password').attr('disabled', false);
    			}

    		} else {
    			$('.password-match')
    			.html('Passwords do not match!')
    			.addClass('text-danger');
    		}
    	});
    };

    var initChangePassword = function () {
    	$(document).on('click', '#button-change-password', function(e) {
    		e.preventDefault();
    		var form = $(this).closest('form');
    		var button = $(this);

    		$.ajax({
    			url: form.attr('action'),
    			type: 'POST',
    			data: form.serialize(),
    			beforeSend: function() {
    				$('.loader-wrapper').show();
    			},
    			success: function(xhr) {
    				var res = $.parseJSON(xhr);
    				$('.loader-wrapper').hide();
    				if (res.success) {
    					swal({
						  	title: "Success",
						  	text: res.message,
						  	type: "success"
						},
						function() {
		                    var token = getURLVar('token');
		                    var redirect = "index.php?route=common/sales_dashboard&token="+token;
		                    $('.loader-wrapper').show();
		                    location.href = redirect;
						});
    				} else {
    					swal("Error", res.error, "error");
    				}
    			}
    		});
    	});
    };

    initPasswordStrength();
    initPasswordMatch();
    initChangePassword();

}(jQuery));