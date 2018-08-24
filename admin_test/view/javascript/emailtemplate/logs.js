(function($){
	var docReady = function(){

		var refreshPage = function(url) {
			if (!url) return false;
			$.ajax({
				url: url,
				type: 'GET',
				success: function(html) {
					$('#emailtemplate').replaceWith(
						$(html).find('#emailtemplate')
					);
					docReady();
					if (history.pushState) {
						history.pushState(null, null, url);
					}
				}
			});
		}
		
		$('.form-filter').off('change').change(function(){
			var url = 'index.php?route=extension/mail/template/logs&token=' + $.getUrlParam('token');
			
			var filter_emailtemplate_id = $('select[name=\'filter_emailtemplate_id\']').val();			
			if (filter_emailtemplate_id) {
				url += '&filter_emailtemplate_id=' + encodeURIComponent(filter_emailtemplate_id);
			}

			var filter_emailtemplate_config_id = $('select[name=\'filter_emailtemplate_config_id\']').val();
			if (filter_emailtemplate_config_id) {
				url += '&filter_emailtemplate_config_id=' + encodeURIComponent(filter_emailtemplate_config_id);
			}
			
			var filter_store_id = $('select[name=\'filter_store_id\']').val();			
			if (filter_store_id) {
				url += '&filter_store_id=' + encodeURIComponent(filter_store_id);
			}

			var filter_customer_id = $('input[name=\'filter_customer_id\']').val();
			if (filter_customer_id) {
				url += '&filter_customer_id=' + encodeURIComponent(filter_customer_id);
			}

			refreshPage(url);
		});

		$('.pagination select').removeAttr('onchange').off('change').change(function(){
			refreshPage(this.value);
			return false;
		});

		$('.pagination a').off('click').click(function(){
			refreshPage($(this).attr('href'));
			return false;
		});

		if($.fn.autocomplete){
			$('.input-autocomplete-customer').each(function(){
				var $el = $(this), $field = $($el.data('field'));				
				$el.autocomplete({
					source: function(request, response) {
						if(request.length > 1){
							$el.after("<span class='input-group-addon input-autocomplete-loading'><i class='fa fa-circle-o-notch fa-spin'></i></span>");
							$.ajax({
								url: ('index.php?route=customer/customer/autocomplete&token=' + $.getUrlParam('token')),
								type: 'GET',
								dataType: 'json',
								data: {
									filter_name : encodeURIComponent(request)
								},
								success: function(json) {
									response($.map(json, function(item) {
										return {
											label: item['name'],
											value: item['customer_id']
										}
									}));
									$el.next('.input-autocomplete-loading').remove();
								}
							});
						}
					},
					select: function(item) {
						$el.val(item['label']);
						$field.val(item['value']).change();
					}
				});
				
				$el.off('change').change(function(){
					if($el.val() == ''){
						$field.val('').change();
					}
				});
			});
		}
		
		var $row, $field, id, 
			$emailBox = $('#emailBox'),
			$emailBoxText = $('#emailBoxText'),			
			$buttons = $emailBox.find('[data-button]');
		
		var iframe = document.getElementById('emailBoxFrame');
			iframe = (iframe.contentWindow) ? iframe.contentWindow : (iframe.contentDocument.document) ? iframe.contentDocument.document : iframe.contentDocument;
	
		$(".load-email").off('click').click(function(e){
			$row = $(this).parents('tr');
			if($row.hasClass('active')) return;

			$row.siblings().removeClass('active');

			$row.addClass('active');

			$emailBox.find('[data-field]').html('').attr('href', '');
			$emailBox.find('[data-button]').attr('href', '');

			iframe.document.open();
			iframe.document.write('');
			iframe.document.close();

			id = $(this).parents('tr').data('id');
			if(!id) return false;
			$emailBox.data('id', id);

			$emailBox.find('.hide').hide();

			$.ajax({
				url: 'index.php?route=extension/mail/template/fetch_log&token=' + $.getUrlParam('token') + '&id=' +  id,
				dataType: 'json',
				success: function(json) {
					for(var key in json){
						$field = $emailBox.find('[data-field=' + key + ']');

						if($field && json[key]){
							if($field.data('type') == 'mailto'){
								$field.attr('href', 'mailto:' + json[key] + '?subject=' + json['emailtemplate_log_subject']);
							}
							
							$field.html(json[key]);
							
							if($field.parent().hasClass('hide')){
								$field.parent().show();
							}
						}
					}

					if(json['emailtemplate_log_text']){
						$emailBoxText.hide().html(json['emailtemplate_log_text']);
						$buttons.filter('[data-button=plaintext]').show();
					} else {
						$buttons.filter('[data-button=plaintext]').hide();
					}

					if(json['emailtemplate_log_html']){
						iframe.document.open();
						iframe.document.write(json['emailtemplate_log_html']);
						iframe.document.close();
					}

					$buttons.filter('[data-button=reply]').attr('href', 'mailto:' + json['emailtemplate_log_to'] + '?subject=' + json['emailtemplate_log_subject']);

					if($emailBox.hasClass("hide")){
						$emailBox.removeClass("hide");
						$("html, body").animate({ scrollTop:($emailBox.offset().top-10) }, 500, "linear");
					}

					$buttons.filter('[data-button=html]:not(.hide)').click();
				}
			});

			e.stopPropagation();
		});
			
		$buttons.off('click').click(function(e){
			switch($(this).data('button')){
				case 'plaintext':
					$emailBox.find('#emailBoxFrame').hide();
					$emailBoxText.show();

					$(this).hide();
					$buttons.filter('[data-button=html]').show();
					e.preventDefault();
				break;

				case 'html':
					$emailBoxText.hide();
					$emailBox.find('#emailBoxFrame').show();

					$(this).hide();
					$buttons.filter('[data-button=plaintext]').show();
					e.preventDefault();
				break;
			}
		});

	};// docReady

	$(document).ready(docReady);
})(jQuery);