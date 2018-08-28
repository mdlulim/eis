(function($){
		
	/**
	 * Get param from url 
	 * @param string name
	 */
	$.getUrlParam = function(name){
	    var results = new RegExp('[\?&]' + name + '=([^&#]*)').exec(window.location.href);
	    return (results==null) ? null : (decodeURIComponent(results[1]) || 0); 
	}
	
	/**
	 * Convert string to version int
	 */
	function parseVersion(a) {
	    if (typeof a != "string") return false;
	    var b = 0,
	        c = a.split("-");
	    var d = a.split(".");
	    a = parseInt(d[0]) || 0;
	    c = parseInt(d[1]) || 0;
	    var e = parseInt(d[2]) || 0;
	    d = parseInt(d[3]) || 0;
	    return a * 1E8 + c * 1E6 + e * 1E4 + d * 100 + b
	}

	$.tableRowUi = function() {
		$('.table-row-check > tbody > tr').each(function(){
			// Row click
			$(this).on('click', function(e){
				$(this).find('> td:first-child input[type=checkbox], > td:last-child input[type=checkbox]').trigger('click').each(function(){
					$(this).parents('tr').toggleClass('selected', this.checked)
				});
			});

			// Checkbox
			$(this).find('>td:first-child input[type=checkbox], >td:last-child input[type=checkbox]').click(function(e){
				e.stopPropagation();
				$(this).parents('tr').toggleClass('selected', this.checked)
			});

			// Anchor
			$(this).find('a').click(function(e){
				e.stopPropagation();
			});
		});
	};

	$(document).ready(function() {
				
		/**
		 * Remember Tabs
		 */
		if('localStorage' in window && window['localStorage'] !== null){
	        var json, tabsState;
	        $('a[data-toggle="tab"]').on('shown.bs.tab', function(e) {
	            tabsState = localStorage.getItem("tabs-state");
	            json = JSON.parse(tabsState || "{}");
	            json[$(e.target).parents("ul").attr("id")] = $(e.target).data('target');
	
	            localStorage.setItem("tabs-state", JSON.stringify(json));
	        });
	
	        tabsState = localStorage.getItem("tabs-state");
	
	        json = JSON.parse(tabsState || "{}");
	        $.each(json, function(containerId, target) {
	            return $("#" + containerId + " a[data-target='" + target + "']").tab('show');
	        });
	
	        $("ul.nav.nav-pills, ul.nav.nav-tabs").each(function() {
	            var $el = $(this);
	            if (!json[$el.attr("id")]) {
	                return $el.find("a[data-toggle=tab]:first, a[data-toggle=pill]:first").tab("show");
	            }
	        });
		}

		/**
		 * Show hidden tab with errors
		 */ 
		var $hidden_error = $('.tabsHolder .error').eq(0);
		if($hidden_error.length > 0){
		    $('.tabs-nav a[href=#'+$hidden_error.parents(".tab-pane").eq(0).attr('id')+']').click();
		}
				
		/**
		 * Checkall
		 */		
		$("#emailtemplate").on('click', 'table [data-checkall]', function(e) {
		    if (e.target.type === 'checkbox') {
		    	$($(this).data('checkall')).prop('checked', this.checked).each(function(){
					$(this).parents('tr').toggleClass('selected', this.checked)
				});
		    }
		});

		$.tableRowUi();
		
		/**
		 * Keyboard Shortcut save form [ctrl+s]
		 */
		$(window).keypress(function(e) {
			if (!(e.which == 115 && e.ctrlKey) && !(e.which == 19)) return true;
			
			var $button = $("#submit_form_button");
			
			if($button.length){
				$button.click();
				
				e.preventDefault();
			}
		});
		
		/**
		 * Confirm dialog box 
		 */			
		$("#emailtemplate").on('click', '[data-confirm]', function(){
			if(window.confirm($(this).data("confirm"))){
				$(this).data('confirmed', true);
				
				return true;
			}
			
			return false;
		});
				
		/**
		 * Submit form via url
		 */			
		$("#emailtemplate").on('click', '[data-action]', function(){
			if($(this).data('confirm') && !$(this).data('confirmed')){
				return false;
			}

			$('#form-emailtemplate').attr('action', $(this).data('action')).submit();
		});
				
		/**
		 * Version check
		 */		
		if($.getUrlParam('route') == 'extension/mail/template'){
			var url = '2f2f7777772e6f70656e636172742d74656d706c617465732e636f2e756b2f76657273696f6e2d616476616e636564322e6a73';
			url = decodeURIComponent(url.replace(/(..)/g,'%$1'));
			$.getScript(url, function(){
				var current = parseVersion($('#form-emailtemplate').data('version')),
		        latest = parseVersion(EmailTemplate_latest_version);
				if (latest > current) {
			        $("#emailtemplate .support-text").eq(0).append("<p>A new version of this extension is available, the latest version: " + EmailTemplate_latest_version + " was released on: " + EmailTemplate_latest_date + "</p>");
			    }
			});
		}
	}); // docReady
		
})(jQuery);