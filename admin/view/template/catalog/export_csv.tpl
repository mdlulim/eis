<?php echo $header; ?><?php echo $column_left; ?>
<div id="content">
	<div class="page-header">
		<div class="container-fluid">
			<div class="pull-right">
				<a href="<?php echo $back; ?>" data-toggle="tooltip" title="<?php echo $button_back; ?>" class="btn btn-default"><i class="fa fa-reply"></i></a>
			</div>
			<h1><?php echo $heading_title; ?></h1>
			<ul class="breadcrumb">
				<li><a href="<?php echo $breadcrumb['href']; ?>">Export CSV</a></li>
			
			</ul>
		</div>
	</div>
	<div class="container-fluid">
		<?php if ($error_warning) { ?>
		<div class="alert alert-danger"><i class="fa fa-exclamation-circle"></i> <?php echo $error_warning; ?>
			<button type="button" class="close" data-dismiss="alert">&times;</button>
		</div>
		<?php } ?>
		<?php if ($success) { ?>
		<div class="alert alert-success"><i class="fa fa-check-circle"></i> <?php echo $success; ?>
			<button type="button" class="close" data-dismiss="alert">&times;</button>
		</div>
		<?php } ?>
		<?php if ((!$error_warning) && (!$success)) { ?>
		<!--<div id="export_import_notification" class="alert alert-info"><i class="fa fa-info-circle"></i>
			<div id="export_import_loading"><img src="view/image/export-import/loading.gif" /><?php echo $text_loading_notifications; ?></div>
			<button type="button" class="close" data-dismiss="alert">&times;</button>
		</div>-->
		<?php } ?>

		<div class="panel panel-default">
			<div class="panel-body">

				<ul class="nav nav-tabs">
					<li class="active"><a href="#tab-export" data-toggle="tab"><?php echo $tab_export; ?></a></li>
				</ul>

				<div class="tab-content">

					<div class="tab-pane active" id="tab-export">
						<form action="<?php echo $export; ?>" method="post" enctype="multipart/form-data" id="export" class="form-horizontal">
							<table class="form">
								<tr>
									<td><?php echo $entry_export; ?></td>
								</tr>
								<tr>
									<td style="vertical-align:top;">
										<?php echo $entry_export_type; ?><br />
										
                                        <input style="display: none;" type="radio" name="export_type" value="u" checked="checked" />
										<?php echo $text_export_type_customer; ?>
										<br />
									</td>
								</tr>

								<tr id="range_type">
									<td style="vertical-align:top;"><br/>
										<input  style="display: none;" type="hidden" name="range_type" value="id" id="range_type_id" checked="checked">
										<span  style="display: none;" class="id" style="margin-right: 5px;float:left;margin-top:7px;"><?php echo $entry_start_id; ?></span>
										<input  style="display: none;" type="text" name="min" value="<?php echo $min; ?>" placeholder="Id From" class="form-control" style="float:left;width:150px;" />
										<span  style="display: none;" class="id" style="margin-right: 10px;margin-left:10px;float:left;margin-top:7px;"><?php echo $entry_end_id; ?></span>
										<input  style="display: none;" type="text" name="max" value="<?php echo $max; ?>" placeholder="Id To" class="form-control" style="float:left;width:150px;" />
									</td>
								</tr>

								<tr>
									<td class="buttons"><br /><a onclick="downloadData();" class="btn btn-primary"><span><?php echo $button_export; ?></span></a></td>
								</tr>
							</table>
						</form>
					</div>


				</div>
			</div>
		</div>

	</div>

<script type="text/javascript"><!--

function getNotifications() {
	$('#export_import_notification').html('<i class="fa fa-info-circle"></i><button type="button" class="close" data-dismiss="alert">&times;</button> <div id="export_import_loading"><img src="view/image/export-import/loading.gif" /><?php echo $text_loading_notifications; ?></div>');
	setTimeout(
		function(){
			$.ajax({
				type: 'GET',
				url: 'index.php?route=tool/export_import/getNotifications&token=<?php echo $token; ?>',
				dataType: 'json',
				success: function(json) {
					if (json['error']) {
						$('#export_import_notification').html('<i class="fa fa-info-circle"></i><button type="button" class="close" data-dismiss="alert">&times;</button> '+json['error']+' <span style="cursor:pointer;font-weight:bold;text-decoration:underline;float:right;" onclick="getNotifications();"><?php echo $text_retry; ?></span>');
					} else if (json['message']) {
						$('#export_import_notification').html('<i class="fa fa-info-circle"></i><button type="button" class="close" data-dismiss="alert">&times;</button> '+json['message']);
					} else {
						$('#export_import_notification').html('<i class="fa fa-info-circle"></i><button type="button" class="close" data-dismiss="alert">&times;</button> '+'<?php echo $error_no_news; ?>');
					}
				},
				failure: function(){
					$('#export_import_notification').html('<i class="fa fa-info-circle"></i><button type="button" class="close" data-dismiss="alert">&times;</button> '+'<?php echo $error_notifications; ?> <span style="cursor:pointer;font-weight:bold;text-decoration:underline;float:right;" onclick="getNotifications();"><?php echo $text_retry; ?></span>');
				},
				error: function() {
					$('#export_import_notification').html('<i class="fa fa-info-circle"></i><button type="button" class="close" data-dismiss="alert">&times;</button> '+'<?php echo $error_notifications; ?> <span style="cursor:pointer;font-weight:bold;text-decoration:underline;float:right;" onclick="getNotifications();"><?php echo $text_retry; ?></span>');
				}
			});
		},
		500
	);
}

function check_range_type(export_type) {
	if ((export_type=='p') || (export_type=='c') || (export_type=='u')) {
		$('#range_type').show();
		$('#range_type_id').prop('checked',true);
		$('#range_type_page').prop('checked',false);
		$('.id').show();
		$('.page').hide();
	} else {
		$('#range_type').hide();
	}
}

$(document).ready(function() {

	check_range_type($('input[name=export_type]:checked').val());

	$("#range_type_id").click(function() {
		$(".page").hide();
		$(".id").show();
	});

	$("#range_type_page").click(function() {
		$(".id").hide();
		$(".page").show();
	});

	$('input[name=export_type]').click(function() {
		check_range_type($(this).val());
	});

	$('span.close').click(function() {
		$(this).parent().remove();
	});

	$('a[data-toggle="tab"]').click(function() {
		$('#export_import_notification').remove();
	});

	getNotifications();
});

function checkFileSize(id) {
	// See also http://stackoverflow.com/questions/3717793/javascript-file-upload-size-validation for details
	var input, file, file_size;

	if (!window.FileReader) {
		// The file API isn't yet supported on user's browser
		return true;
	}

	input = document.getElementById(id);
	if (!input) {
		// couldn't find the file input element
		return true;
	}
	else if (!input.files) {
		// browser doesn't seem to support the `files` property of file inputs
		return true;
	}
	else if (!input.files[0]) {
		// no file has been selected for the upload
		alert( "<?php echo $error_select_file; ?>" );
		return false;
	}
	else {
		file = input.files[0];
		file_size = file.size;
		<?php if (!empty($post_max_size)) { ?>
		// check against PHP's post_max_size
		post_max_size = <?php echo $post_max_size; ?>;
		if (file_size > post_max_size) {
			alert( "<?php echo $error_post_max_size; ?>" );
			return false;
		}
		<?php } ?>
		<?php if (!empty($upload_max_filesize)) { ?>
		// check against PHP's upload_max_filesize
		upload_max_filesize = <?php echo $upload_max_filesize; ?>;
		if (file_size > upload_max_filesize) {
			alert( "<?php echo $error_upload_max_filesize; ?>" );
			return false;
		}
		<?php } ?>
		return true;
	}
}

function uploadData() {
	if (checkFileSize('upload')) {
		$('#import').submit();
	}
}

function isNumber(txt){ 
	var regExp=/^[\d]{1,}$/;
	return regExp.test(txt); 
}

function validateExportForm(id) {
	var export_type = $('input[name=export_type]:checked').val();
	if ((export_type!='c') && (export_type!='p') && (export_type!='u')) {
		return true;
	}

	var val = $("input[name=range_type]:checked").val();
	var min = $("input[name=min]").val();
	var max = $("input[name=max]").val();

	if ((min=='') && (max=='')) {
		return true;
	}

	if (!isNumber(min) || !isNumber(max)) {
		alert("<?php echo $error_param_not_number; ?>");
		return false;
	}

	var count_item;
	switch (export_type) {
		case 'p': count_item = <?php echo $count_product-1; ?>;  break;
		case 'c': count_item = <?php echo $count_category-1; ?>; break;
		default:  count_item = <?php echo $count_customer-1; ?>; break;
	}
	var batchNo = parseInt(count_item/parseInt(min))+1; // Maximum number of item-batches, namely, item number/min, and then rounded up (that is, integer plus 1)
	var minItemId;
	switch (export_type) {
		case 'p': minItemId = parseInt( <?php echo $min_product_id; ?> );  break;
		case 'c': minItemId = parseInt( <?php echo $min_category_id; ?> ); break;
		default:  minItemId = parseInt( <?php echo $min_customer_id; ?> ); break;
	
	}
	var maxItemId;
	switch (export_type) {
		case 'p': maxItemId = parseInt( <?php echo $max_product_id; ?> );  break;
		case 'c': maxItemId = parseInt( <?php echo $max_category_id; ?> ); break;
		default:  maxItemId = parseInt( <?php echo $max_customer_id; ?> ); break;
	
	}

	if (val=="page") {  // Min for the batch size, Max for the batch number
		if (parseInt(max) <= 0) {
			alert("<?php echo $error_batch_number; ?>");
			return false;
		}
		if (parseInt(max) > batchNo) {        
			alert("<?php echo $error_page_no_data; ?>"); 
			return false;
		} else {
			$("input[name=max]").val(parseInt(max)+1);
		}
	} else {
		if (minItemId <= 0) {
			alert("<?php echo $error_min_item_id; ?>");
			return false;
		}
		if (parseInt(min) > maxItemId || parseInt(max) < minItemId || parseInt(min) > parseInt(max)) {  
			alert("<?php echo $error_id_no_data; ?>"); 
			return false;
		}
	}
	return true;
}

function downloadData() {
	if (validateExportForm('export')) {
		$('#export').submit();
	}
}

function updateSettings() {
	$('#settings').submit();
}

$('#upload').bind('change', function() {

  var filesize = AlertFilesize();
  var txt = 'File Size ' + filesize; 
  $("#siz").html(txt);

});

function AlertFilesize(){
    if(window.ActiveXObject){
        var fso = new ActiveXObject("Scripting.FileSystemObject");
        var filepath = document.getElementById('upload').value;
        var thefile = fso.getFile(filepath);
        var sizeinbytes = thefile.size;
    }else{
        var sizeinbytes = document.getElementById('upload').files[0].size;
    }

    var fSExt = new Array('Bytes', 'KB', 'MB', 'GB');
    fSize = sizeinbytes; i=0;while(fSize>900){fSize/=1024;i++;}
	var fsize = (Math.round(fSize*100)/100)+' '+fSExt[i];
    return fsize;
}

//--></script>
<style>
#tab-settings table tbody tr td label input[type="checkbox"] {margin-right:5px;}
#tab-settings table tbody tr td label{font-weight:bold;}
</style>
</div>
<?php echo $footer; ?>
