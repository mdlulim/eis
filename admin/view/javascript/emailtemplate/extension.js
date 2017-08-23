(function($){
	function UpdateQueryString(key, value, url) {
	    if (!url) url = window.location.href;
	    var re = new RegExp("([?&])" + key + "=.*?(&|#|$)(.*)", "gi"),
	        hash;

	    if (re.test(url)) {
	        if (typeof value !== 'undefined' && value !== null) {
	            return url.replace(re, '$1' + key + "=" + value + '$2$3');
	    	} else {
	            hash = url.split('#');
	            url = hash[0].replace(re, '$1$3').replace(/(&|\?)$/, '');
	            if (typeof hash[1] !== 'undefined' && hash[1] !== null) {
	                url += '#' + hash[1];
	            }
	            return url;
	        }
	    } else {
	        if (typeof value !== 'undefined' && value !== null) {
	            var separator = url.indexOf('?') !== -1 ? '&' : '?';
	            hash = url.split('#');
	            url = hash[0] + separator + key + '=' + value;
	            if (typeof hash[1] !== 'undefined' && hash[1] !== null) {
	                url += '#' + hash[1];
	            }
	            return url;
	        } else {
	            return url;
	        }
	    }
	}
	
	$(document).ready(function() {
		
		/**
		 * Form Filter
		 */		
		$('input[name=filter_type]').on('change', function() {
			var $el = $('#form-emailtemplate');
			var url = 'index.php?route=extension/mail/template&token=' + $.getUrlParam('token') + '&filter_type=' + encodeURIComponent($(this).val());
						
			$el.find('.ajax-filter').addClass('ajax-loading').html('<i class="fa fa-spinner fa-spin fa-5x" style="color:#009afd"></i>');
			
			$(this).parent().addClass('active').siblings().removeClass('active');
			
			url = UpdateQueryString('filter_type', $(this).val(), url);

			$.ajax({
				url: url,
				type: 'GET',
				dataType: 'html',
				success: function(html) {
					if(html){
						$el.find('.ajax-filter').removeClass('ajax-loading').html(
							$(html).find('.ajax-filter').html()
						);
						
						$.tableRowUi();
					}
				}
			});
		});
		
	});		
})(jQuery);