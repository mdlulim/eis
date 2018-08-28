(function($){
	$(document).ready(function(){
		var $form = $('#form-emailtemplate');
			
		if ($.fn.colorpicker) {
			$('.input-colorpicker').colorpicker()
		}
		
		if ($.fn.checkboxpicker) {
			$('.input-control-checkbox').checkboxpicker({ onClass: 'btn-info' });
		}

		if ($.fn.autocomplete) {
			$('.input-autocomplete-product').each(function(){
				var $el = $(this),
					$field = $($el.data('field')), 
					$output = $($el.data('output'));	
								
				$el.autocomplete({
					source: function(request, response) {
						if(request.length > 1){
							$el.after("<span class='input-group-addon input-autocomplete-loading'><i class='fa fa-circle-o-notch fa-spin'></i></span>");
							$.ajax({
								url: ('index.php?route=catalog/product/autocomplete&token=' + $.getUrlParam('token') + '&filter_name=' + encodeURIComponent(request)),
								type: 'GET',
								dataType: 'json',
								success: function(json) {
									response($.map(json, function(item) {
										return {
											label: item['name'],
											value: item['product_id']
										}
									}));
									$el.next('.input-autocomplete-loading').remove();
								}
							});
						}
					},
					select: function(item) {
						if($field.val() == '') {
							$field.val(item['value']);
						} else {
							var selection = $field.val().split(',');
							if($.inArray(item['value'], selection) == -1){
								selection.push(item['value']);
								$field.val(selection.join(','));
							}
						}										
						$output.removeClass('hide').find('.list-group').append('<li class="list-group-item" data-id="' + item['value'] + '"><a href="javascript:void(0)" class="badge remove list-group-item-danger"><i class="fa fa-times"></i></a> ' + item['label'] + '</li>');
					}
				});				
				return true;
			});
		}
		
		// Change style preview
		$('select[name="emailtemplate_config_style"], input[name="emailtemplate_config_order_products[layout]"]').change(function(){
			var $preview = $(this).parents('.form-group').find('.img-preview');
			if ($preview) {
				$preview.removeClass(function (index, className) {
					return (className.match(/(^|\s)img-style-\S+/g) || []).join(' ');
				})
				$preview.addClass('img-style-' + $(this).val());
			}
		});

		// Change showcase type
		$('#emailtemplate_config_showcase').change(function(){
			var $tab = $(this).parents('.tab-pane');

			switch($(this).val()){
				case 'products':
					$tab.find('.showcase_products').removeClass('hide');
		  		break;
				default:
					$('#emailtemplate_config_showcase_selection').val('');

					$tab.find('.showcase_selection').empty('');
					$tab.find('.showcase_products').addClass('hide');
			}
		});
		
		// Remove showcase product
		$('#emailtemplate_config_showcase_selection').on('click', '.remove', function(){
			var $item = $(this).parents('li');
			var $field = $('input[name=emailtemplate_config_showcase_selection]');
			
			var values = $.map($field.val().split(','), function(value){ return parseInt(value, 10) });
			var index = $.inArray($item.data('id'), values);
			if(index !== -1){
				values.splice(index, 1);
			}
			$field.val(values.join(','));
			
			$item.remove();
		});

		// Send test email ajax
		$('.send-test-email').click(function(e){
			e.preventDefault();
			var $icon = $(this);

			if (!$icon.is('i')) {
				$icon = $icon.find('i');
			}

			$icon.removeClass('fa-envelope');
			$icon.addClass('fa-refresh fa-spin');

			$.ajax({
				url: ('index.php?route=extension/mail/template/send_email&emailtemplate_config_id=' + $.getUrlParam('id') + '&token=' + $.getUrlParam('token')),
				type: 'POST',
				data: {
					emailtemplate_config_id: $.getUrlParam('id'),
					data: $("#form-emailtemplate").serialize()
				},
				success: function(data) {
					$icon.removeClass('fa-refresh fa-spin');
					$icon.addClass('fa-envelope');

					if (data['success']) {
						$('#form-emailtemplate > .alert').remove();
						$('#form-emailtemplate').prepend("<div class='alert alert-success'><i class='fa fa-exclamation-circle'></i> " + data['success'] + "<button type='button' class='close' data-dismiss='alert'>&times;</button></div>")
					}
				}
			});
		});

		// Preview
		var $preview = $('#preview-mail');
		if ($preview.length) {
			var requestData = {};
						
			requestData['emailtemplate_config_id'] = $.getUrlParam('id');

			requestData['emailtemplate_id'] = 1;

			if(document.getElementById('store_id')){
				requestData['store_id'] = document.getElementById('store_id').value;
			} else {
				requestData['store_id'] = 0;
			}
			
			if(document.getElementById('language_id')){
				requestData['language_id'] = document.getElementById('language_id').value;
			}
			
			// OnLoad fetch preview
			$.ajax({
				url: ('index.php?route=extension/mail/template/preview_email&token=' + $.getUrlParam('token')),
				type: 'GET',
				dataType: 'text',
				data: requestData,
				success: function(data) {
					if(data){
						var iframe = $preview.find('#preview-with').removeClass('ajax-loading').html('<iframe></iframe>').children().get(0);
						iframe = (iframe.contentWindow) ? iframe.contentWindow : (iframe.contentDocument.document) ? iframe.contentDocument.document : iframe.contentDocument;
						iframe.document.open();
						iframe.document.write(data);
						iframe.document.close();
					}
				}
			});

			$preview.find('.media-icon').click(function(){
				$(this).siblings().removeClass('selected');
				$(this).addClass('selected');
				$preview.find('.preview-frame > iframe').css('width', $(this).data('width'));
			});
			
			$preview.find('.preview-image').click(function(){
				var $el = $(this);
				
				if($el.hasClass('preview-no-image')){
					// With Image
					$preview.find('#preview-without').hide();
					$preview.find('#preview-with').show();
					
					$el.addClass('hide');
					$el.prev().removeClass('hide');				
				} else {
					// Without Image
					$preview.find('#preview-without:eq(0)').each(function(){
						if($(this).is(':empty')){
							var $src = $($preview.find('#preview-with > iframe').contents().find("html:eq(0)").clone());
							
							$src.find("img").removeAttr("src");
							$src.find("table,td,div").css("backgroundImage", "").removeAttr("background");
															
							var iframe = $(this).html('<iframe style="width:100%"></iframe>').children().get(0);
							iframe = (iframe.contentWindow) ? iframe.contentWindow : (iframe.contentDocument.document) ? iframe.contentDocument.document : iframe.contentDocument;
							iframe.document.open();
							iframe.document.write($src.html());
							iframe.document.close();
						}
						$preview.find('#preview-with').hide();
						$(this).show();
					});
					
					$el.addClass('hide');
					$el.next().removeClass('hide');					
				}
			});

			$preview.find('.template-update').click(function(e){
				e.preventDefault();
				var $el = $(this);
				
				$el.addClass('fa-spin');
				
				var iframe_width;
				$preview.find('.preview-frame').each(function(){
					iframe_width = $('> iframe', this).css('width');
					
					$(this).addClass('ajax-loading').html('<i class="fa fa-spinner fa-spin fa-5x" style="color:#009afd"></i>')
				});

				var requestUrl = 'index.php?route=extension/mail/template/preview_email&token=' + $.getUrlParam('token') + '&emailtemplate_config_id=' + $.getUrlParam('id') + '&emailtemplate_id=1';

				if (document.getElementById('store_id')){
					requestUrl += '&store_id=' + document.getElementById('store_id').value;
				}

				if (document.getElementById('language_id')){
					requestUrl += '&language_id=' + document.getElementById('language_id').value;
				}

				$.ajax({
					url: requestUrl,
					type: 'post',
					dataType: 'text',
					data: {
						'data': $("#form-emailtemplate").serialize()
					},
					success: function(data) {
						$el.removeClass('fa-spin');
						$el.find('.fa-spinner').remove();
						
						if(data){									
							var iframe = $preview.find('#preview-with').removeClass('ajax-loading').html('<iframe style="width:' + iframe_width + '"></iframe>').contents().get(0);
							iframe = (iframe.contentWindow) ? iframe.contentWindow : (iframe.contentDocument.document) ? iframe.contentDocument.document : iframe.contentDocument;
							iframe.document.open();
							iframe.document.write(data);
							iframe.document.close();
							
							var $src = $($preview.find('#preview-with > iframe').contents().find("html:eq(0)").clone());
							
							$src.find("img").removeAttr("src");
							$src.find("table,td,div").css("backgroundImage", "").removeAttr("background");
							
							var iframe = $preview.find('#preview-without').removeClass('ajax-loading').html('<iframe style="width:' + iframe_width + '"></iframe>').contents().get(0);
							iframe = (iframe.contentWindow) ? iframe.contentWindow : (iframe.contentDocument.document) ? iframe.contentDocument.document : iframe.contentDocument;
							iframe.document.open();
							iframe.document.write($src.html());
							iframe.document.close();								
						}
					}
				});
				
				$el.toggleClass('active');
			});	
		}
	});
	
})(jQuery);