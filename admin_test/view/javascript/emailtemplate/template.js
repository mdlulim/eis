(function($){

	var docReady = function(){
		var refreshPage = function(url, selector) {
			var selector = selector || '#emailtemplate';
			if (!url) return false;
			var activeTabIndex = $('#tabs-main > .active').index();
			$.ajax({
				url: url,
				type: 'GET',
				success: function(html) {
					$(selector).html(
						$(html).find(selector).html()
					);

					$('.pagination').parents('.row').replaceWith(
						$(html).find('.pagination').parents('.row')
					);

					docReady();

					if (history.pushState) {
						history.pushState(null, null, url);
					}

					// select tab
					var activeTab = $('#tabs-main').children().eq(activeTabIndex);
					if (activeTab) {
						activeTab.find('a').tab("show");
					}
				}
			});
		}

    	if ($.fn.checkboxpicker) {
			$('.input-control-checkbox').checkboxpicker({ onClass: 'btn-info' });
		} 
		
	    $('#add-condition').off('change').change(function(){
			var $conditions = $('#emailtemplate_conditions');
			var i = $conditions.children(':last-child').data('count');
			if(i >= 1){
				i++;
			} else {
				i = 1;
			}

			var html = '<div class="row row-spacing" data-count="' + i + '">';
			    html += '	<div class="col-md-3"><input type="text" name="emailtemplate_condition[' + i + '][key]" class="form-control" value="' + $(this).find(":selected").text() + '" readonly="readonly" /></div>';
			    html += '	<div class="col-md-3"><select name="emailtemplate_condition[' + i + '][operator]" class="form-control">';
			    html += '		<option value="==">(==) Equal</option>';
				html += '		<option value="!=">(!=) &nbsp;Not Equal</option>';
				html += '		<option value="&gt;">(&gt;) &nbsp;&nbsp;Greater than</option>';
				html += '		<option value="&lt;">(&lt;) &nbsp;&nbsp;Less than</option>';
				html += '		<option value="&gt;=">(&gt;=) Greater than or equal to </option>';
				html += '		<option value="&lt;=">(&lt;=) Less than or equal to </option>';
				html += '		<option value="IN">(IN) Checks if a value exists in comma-delimited string </option>';
				html += '		<option value="NOTIN">(NOTIN) Checks if a value does not exist in comma-delimited string </option>';
				html += '	</select></div>';
				html += '	<div class="col-md-6"><div class="input-group"><input type="text" name="emailtemplate_condition[' + i + '][value]" class="form-control" value="" placeholder="Value" />';
				html += '	<span class="input-group-btn"><button class="btn btn-default btn-remove-row" type="button"><i class="fa fa-trash-o"></i></button></span></div>';
				html += '</div>';
			$conditions.append(html);

			$(this).find('option:selected').removeAttr("selected");
		});
	    
	    $('.shortcode-select').off('click').click(function(){
	        $(this).select();
	        return false;
	    });

		$('.pagination select').removeAttr('onchange').off('change').change(function(){
			refreshPage(this.value, '#tab-shortcodes');
			return false;
		});

		$('.pagination a').off('click').click(function(){
			refreshPage($(this).attr('href'), '#tab-shortcodes');
			return false;
		});
	    
	    $('.add-editor').off('click').click(function(){
	    	var $el = $('#emailtemplate_description_content' + $(this).data('content') + '_' + $(this).data('lang'));	    	
	    	$el.parents('.emailtemplate_content').removeClass('hide');	
	    	
	    	if(typeof CKEDITOR !== "undefined") {
			    CKEDITOR.replace($el.attr('id'));
            } else {
				$el.summernote({
					height: 180
				});
        	}
	    		    	
	    	$(this).remove();
	    });

	    $('.btn-remove-row').each(function(){
			$(this).parents('.row').remove();
		});
	    
	    /**
	     * Preview
	     */
	    var loadPreview = function($preview, callback) {
			var requestUrl = 'index.php?route=extension/mail/template/preview_email&token=' + $.getUrlParam('token') + '&emailtemplate_id=' + $.getUrlParam('id');

			if (document.getElementById('store_id')){
				requestUrl += '&store_id=' + document.getElementById('store_id').value;
			}

			if (document.getElementById('language_id')){
				requestUrl += '&language_id=' + document.getElementById('language_id').value;
			}

			var url_preview = 'index.php?route=extension/mail/template/preview_email&token=' + $.getUrlParam('token') + '&emailtemplate_id=' + $.getUrlParam('id') + '&store_id=' + $preview.data('store') + '&language_id=' + $preview.data('language');

			if(typeof CKEDITOR !== "undefined"){
				for(var instanceName in CKEDITOR.instances){
					CKEDITOR.instances[instanceName].updateElement();
				}
			} else if($.fn.summernote){
				$('textarea.summernote').each(function(){
					$(this).val($(this).summernote('code'));
				});
			}

			var iframe_width;
			$preview.find('.preview-frame').each(function(){
				iframe_width = $('> iframe', this).css('width');

				$(this).addClass('ajax-loading').html('<i class="fa fa-spinner fa-spin fa-5x" style="color:#009afd"></i>')
			});

			$.ajax({
				url: requestUrl,
				type: 'POST',
				data: {
					data: $("#form-emailtemplate").serialize()
				},
				dataType: 'text',
				success: function(data) {
					if(data){
						var iframe = $('#preview-with').removeClass('ajax-loading').html('<iframe></iframe>').children().get(0);
						iframe = (iframe.contentWindow) ? iframe.contentWindow : (iframe.contentDocument.document) ? iframe.contentDocument.document : iframe.contentDocument;

						iframe.document.open();
						iframe.document.write(data);
						iframe.document.close();

						$preview.removeClass('hide');

						$preview.find('.media-icon').removeClass('selected');
						$preview.find('.media-icon').eq(0).addClass('selected');

						if (typeof callback === 'function') {
							callback();
						}
					}
				}
			});

			$preview.find('.media-icon').off('click').click(function(){
				$(this).siblings().removeClass('selected');
				$(this).addClass('selected');
				$preview.find('.preview-frame > iframe').css('width', $(this).data('width'));
			});
		};

		var $preview;

	    $('.btn-inbox-preview').one('click', function(e){
			e.preventDefault();

			var $this = $(this);
			$this.button('loading');

			$preview = $($this.data('target'));

			loadPreview($preview, function() {
				$this.button('reset').remove();
			});
		});

	    $('.template-update').on('click', function(e){
			e.preventDefault();

			var $this = $(this);

			$this.addClass('fa-spin');

			loadPreview($preview, function() {
				$this.removeClass('fa-spin');
			});
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
				url: ('index.php?route=extension/mail/template/send_email&emailtemplate_id=' + $.getUrlParam('id') + '&token=' + $.getUrlParam('token')),
				type: 'POST',
				data: {
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

		var $model_frame = $('#modal-frame');
		
		var initModalFrame = function(e){
			e.preventDefault();
			
			var $el = $(this);
			
			switch($(this).data('modal')){			
				case 'remote':
					$.ajax({
						url: $el.data('url'),
						type: 'GET',
						dataType: 'html',
						success: function(response_load) {
							if(response_load){														
								$model_frame.find('.modal-content').html(response_load);
								
								$model_frame.find('[data-action=save]').off('click').click(function(e){
									$.ajax({
										url: $el.data('url'),
										type: 'POST',										        
								        data: $model_frame.find('.modal-content form').serialize(),
								        dataType: 'json',
								        success: function(response_save){
								        	if(response_save['success']){
								        		$('#form-emailtemplate').prepend("<div class='alert alert-success'><i class='fa fa-exclamation-circle'></i> " + response_save['success'] + "<button type='button' class='close' data-dismiss='alert'>&times;</button></div>")
								        									
								        		$model_frame.removeClass('in');
								        		
								        		if($el.data('refresh')){
								        			$.ajax({
														url: window.location.href,
												        dataType: 'html',
												        success: function(response_html){
												        	$($el.data('refresh')).removeClass('ajax-loading').html($('<div />').html(response_html).find($el.data('refresh')).html())
												        		.find('[data-modal]').click(initModalFrame);
												        	
												        	$model_frame.modal('hide');
												        }
												    });										        			
								        		} else {
								        			$model_frame.modal('hide');
								        		}
								        		
								        		$model_frame.find('.modal-content').html('');
								        	}
								        }
								    });
									e.preventDefault();
								});
								
								$model_frame.modal();
							}
						}
					});
				break;
			}			
		};
		
		$('[data-modal]').off('click').click(initModalFrame);

    }; //docReady

	$(document).ready(docReady);

})(jQuery);