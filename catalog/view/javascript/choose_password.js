(function ($) {
    "use strict";

    var initPasswordStrength = function () {
    	$(document).on('keyup', '#input-password', function() {
    		var strength = 0;
    		var password = $(this).val();

    		// Reset
    		$('.password-strength').html('').removeClass('weak short strong good');
    		$('#button-change-password').attr('disabled', true);
    		$('.password-match').html('').removeClass('text-success text-danger');
    		$('#input-confirm').val('');

    		// if password is too short in length [i.e. less than 8 characters], display message and exit.
    		if (password.length < 8) {
                $('span.password-strength-label').show();
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
                $('span.password-strength-label').show();
				$('.password-strength')
				.addClass('weak')
    			.html('Weak');
				return;
			} else if (strength == 2) {
                $('span.password-strength-label').show();
				$('.password-strength')
				.addClass('average')
    			.html('Average');
				return;
			} else {
                $('span.password-strength-label').show();
				$('.password-strength')
				.addClass('strong')
    			.html('Strong');
				return;
            }
    	});
    };

    var initPasswordMatch = function () {
    	$(document).on('keyup', '#input-confirm', function() {
    		var password1 = $('#input-password').val();
            var password2 = $(this).val();
            var submitBtn = $('#button-change-password');

    		// Reset
    		$('.password-match')
    		.html('')
            .removeClass('text-success text-danger');

            submitBtn.attr('disabled', true);

    		if (password1 === password2) {
    			$('.password-match')
    			.html('Passwords match!')
    			.addClass('text-success');

    			if ($('.password-strength').hasClass('average') || $('.password-strength').hasClass('strong')) {
    				submitBtn.attr('disabled', false);
    			}

    		} else {
    			$('.password-match')
    			.html('Passwords do not match!')
    			.addClass('text-danger');
    		}
    	});
    };

    initPasswordStrength();
    initPasswordMatch();

}(jQuery));