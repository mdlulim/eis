<?php echo $header; ?><?php echo $column_left; ?>
<div id="content">
	<div class="page-header">
		<div class="container-fluid">
			<div class="pull-right">
				<a href="<?php echo $back; ?>" data-toggle="tooltip" title="<?php echo $button_back; ?>" class="btn btn-default"><i class="fa fa-reply"></i></a>
			</div>
			<h1><?php echo $heading_title; ?></h1>
			<ul class="breadcrumb">
				<?php foreach ($breadcrumbs as $breadcrumb) { ?>
				<li><a href="<?php echo $breadcrumb['href']; ?>"><?php echo $breadcrumb['text']; ?></a></li>
				<?php } ?>
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
					<li><a href="#tab-import" data-toggle="tab"><?php echo $tab_import; ?></a></li>
					<li><a href="#tab-settings" data-toggle="tab"><?php echo $tab_settings; ?></a></li>
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
										
                                        <input type="radio" name="export_type" value="u" checked="checked" />
										<?php echo $text_export_type_customer; ?>
										<br />
									</td>
								</tr>

								<tr id="range_type">
									<td style="vertical-align:top;"><?php echo $entry_range_type; ?><span class="help"><?php echo $help_range_type; ?></span><br />
										<input type="hidden" name="range_type" value="id" id="range_type_id" checked="checked">
										<span class="id" style="margin-right: 5px;float:left;margin-top:7px;"><?php echo $entry_start_id; ?></span>
										<input type="text" name="min" value="<?php echo $min; ?>" placeholder="Id From" class="form-control" style="float:left;width:150px;" />
										<span class="id" style="margin-right: 10px;margin-left:10px;float:left;margin-top:7px;"><?php echo $entry_end_id; ?></span>
										<input type="text" name="max" value="<?php echo $max; ?>" placeholder="Id To" class="form-control" style="float:left;width:150px;" />
									</td>
								</tr>

								<tr>
									<td class="buttons"><a onclick="downloadData();" class="btn btn-primary"><span><?php echo $button_export; ?></span></a></td>
								</tr>
							</table>
						</form>
					</div>

					<div class="tab-pane" id="tab-import">
						<form action="<?php echo $import; ?>" method="post" enctype="multipart/form-data" id="import" class="form-horizontal">
							<table class="form">
								<tr>
									<td>
										<?php echo $entry_import; ?>
										<!--<span class="help"><?php echo $help_import; ?></span>-->
										<span class="help"><?php echo $help_format; ?></span>
									</td>
								</tr>
								<!--<tr>
									<td>
										<?php echo $entry_incremental; ?><br />
										<input type="radio" name="incremental" value="1" checked="checked" />
										<?php echo $text_yes; ?> <?php echo $help_incremental_yes; ?>
										<br />
										
									</td>
								</tr>-->
								<tr>
									<td><?php echo $entry_upload; ?><br /><br /><input type="file" name="upload" id="upload" /> <b id="siz" style="margin-left:77px;"></b></td>
								</tr>
								<tr>
									<td class="buttons"><a onclick="uploadData();" class="btn btn-primary"><span><?php echo $button_import; ?></span></a></td>
								</tr>
							</table>
						</form>
					</div>

					<div class="tab-pane" id="tab-settings">
						<form action="<?php echo $settings; ?>" method="post" enctype="multipart/form-data" id="settings" class="form-horizontal">
							<table class="form">
								<!--<tr>
									<td>
										<label>
										<?php if($settings_firstname) { ?>
                                        	<input type="checkbox" name="customer_export_import_settings_firstname" value="1" checked="checked" disabled="disabled" /> First Name
                                        <?php } else { ?>    
                                        	<input type="checkbox" name="customer_export_import_settings_firstname" value="1" /> First Name
                                        <?php } ?>
										</label>
									</td>
								</tr>
								<tr>
									<td>
										<label>
										<?php if($settings_lastname) { ?>
                                        	<input type="checkbox" name="customer_export_import_settings_lastname" value="1" checked="checked" disabled="disabled" /> Last Name
                                        <?php } else { ?>
                                        	<input type="checkbox" name="customer_export_import_settings_lastname" value="1" /> Last Name
                                        <?php } ?>
										</label>
									</td>
								</tr>-->
                                <tr>
									<td>
										<label style="color:#FF0000;">
										<?php if($settings_companyname) { ?>
                                        	<input type="checkbox" name="customer_export_import_settings_companyname" value="1" checked="checked" disabled="disabled" /> Company Name
                                            <input type="hidden" name="customer_export_import_settings_companyname" value="1" />
                                        <?php } else { ?>
                                        	<input type="checkbox" name="customer_export_import_settings_companyname" value="1" /> Company Name
                                        <?php } ?>
										</label>
									</td>
								</tr>
								<tr>
									<td>
										<label style="color:#FF0000;">
										<?php if($settings_telephone) { ?>
                                        	<input type="checkbox" name="customer_export_import_settings_telephone" value="1" checked="checked" disabled="disabled" /> Telephone
                                            <input type="hidden" name="customer_export_import_settings_telephone" value="1" />
                                        <?php } else { ?>
                                        	<input type="checkbox" name="customer_export_import_settings_telephone" value="1" /> Telephone
                                        <?php } ?>
										</label>
									</td>
								</tr>
                                <tr>
									<td>
										<label style="color:#FF0000;">
										<?php if($settings_email) { ?>
                                        	<input type="checkbox" name="customer_export_import_settings_email" value="1" checked="checked" disabled="disabled" /> Email
                                            <input type="hidden" name="customer_export_import_settings_email" value="1" />
                                        <?php } else { ?>
                                        	<input type="checkbox" name="customer_export_import_settings_email" value="1" /> Email
                                        <?php } ?>
										</label>
									</td>
								</tr>
                                <tr>
									<td>
										<label style="color:#FF0000;">
										<?php if($settings_companygroup) { ?>
                                        	<input type="checkbox" name="customer_export_import_settings_companygroup" value="1" checked="checked" disabled="disabled" /> Contract Pricing
                                            <input type="hidden" name="customer_export_import_settings_companygroup" value="1" />
                                        <?php } else { ?>    
                                            <input type="checkbox" name="customer_export_import_settings_companygroup" value="1" /> Contract Pricing
                                        <?php } ?>
										</label>
									</td>
								</tr>
                                <tr>
									<td>
										<label style="color:#FF0000;">
                                        <?php if($settings_paymentmethod) { ?>
											<input type="checkbox" name="customer_export_import_settings_paymentmethod" value="1" checked="checked" disabled="disabled" /> Preferred Payment Method
                                            <input type="hidden" name="customer_export_import_settings_paymentmethod" value="1" />
                                        <?php } else { ?>    
                                            <input type="checkbox" name="customer_export_import_settings_paymentmethod" value="1" /> Preferred Payment Method
                                        <?php } ?>
										</label>
									</td>
								</tr>
                                <tr>
									<td>
										<label>
                                        <?php if($settings_salesteam) { ?>
											<input type="checkbox" name="customer_export_import_settings_salesteam" value="1" checked="checked" /> Sales Team
                                        <?php } else { ?>    
                                            <input type="checkbox" name="customer_export_import_settings_salesteam" value="1" /> Sales Team
                                        <?php } ?>
										</label>
									</td>
								</tr>
                                <tr>
									<td>
										<label>
                                        <?php if($settings_salesrep) { ?>
											<input type="checkbox" name="customer_export_import_settings_salesrep" value="1" checked="checked" /> Sales Rep
                                        <?php } else { ?>    
                                            <input type="checkbox" name="customer_export_import_settings_salesrep" value="1" /> Sales Rep
                                        <?php } ?>
										</label>
									</td>
								</tr>
                                <tr>
									<td>
										<label style="color:#FF0000;">
                                        <?php if($settings_status) { ?>
											<input type="checkbox" name="customer_export_import_settings_status" value="1" checked="checked" disabled="disabled" /> Account Status
                                            <input type="hidden" name="customer_export_import_settings_status" value="1" />
                                        <?php } else { ?>    
                                            <input type="checkbox" name="customer_export_import_settings_status" value="1" /> Account Status
                                        <?php } ?>
										</label>
									</td>
								</tr>
								<tr>
									<td>
										<label style="color:#FF0000;">
										<?php if($settings_address1) { ?>
                                        	<input type="checkbox" name="customer_export_import_settings_address1" value="1" checked="checked" disabled="disabled" /> Address line 1
                                            <input type="hidden" name="customer_export_import_settings_address1" value="1" />
                                        <?php } else { ?>    
                                            <input type="checkbox" name="customer_export_import_settings_address1" value="1" /> Address line 1
                                        <?php } ?>
										</label>
									</td>
								</tr>
                                <tr>
									<td>
										<label>
										<?php if($settings_address2) { ?>
                                        	<input type="checkbox" name="customer_export_import_settings_address2" value="1" checked="checked" /> Address line 2
                                        <?php } else { ?>    
                                            <input type="checkbox" name="customer_export_import_settings_address2" value="1" /> Address line 2
                                        <?php } ?>
										</label>
									</td>
								</tr>
                                <tr>
									<td>
										<label style="color:#FF0000;">
										<?php if($settings_city) { ?>
                                        	<input type="checkbox" name="customer_export_import_settings_city" value="1" checked="checked" disabled="disabled" /> City
                                            <input type="hidden" name="customer_export_import_settings_city" value="1" />
                                        <?php } else { ?>    
                                            <input type="checkbox" name="customer_export_import_settings_city" value="1" /> City
                                        <?php } ?>
										</label>
									</td>
								</tr>
								<tr>
									<td>
										<label>
										<?php if($settings_postcode) { ?>
                                        	<input type="checkbox" name="customer_export_import_settings_postcode" value="1" checked="checked" /> Postcode
                                        <?php } else { ?>    
                                            <input type="checkbox" name="customer_export_import_settings_postcode" value="1" /> Postcode
                                        <?php } ?>
										</label>
									</td>
								</tr>
								<tr>
									<td>
										<label style="color:#FF0000;">
										<?php if($settings_country) { ?>
                                        	<input type="checkbox" name="customer_export_import_settings_country" value="1" checked="checked" disabled="disabled" /> Country
                                            <input type="hidden" name="customer_export_import_settings_country" value="1" />
                                        <?php } else { ?>    
                                            <input type="checkbox" name="customer_export_import_settings_country" value="1" /> Country
                                        <?php } ?>
										</label>
									</td>
								</tr>
                                <tr>
									<td>
										<label style="color:#FF0000;">
										<?php if($settings_region) { ?>
                                        	<input type="checkbox" name="customer_export_import_settings_region" value="1" checked="checked" disabled="disabled" /> Region/State
                                            <input type="hidden" name="customer_export_import_settings_region" value="1" />
                                        <?php } else { ?>    
                                            <input type="checkbox" name="customer_export_import_settings_region" value="1" /> Region/State
                                        <?php } ?>
										</label>
									</td>
								</tr>
                                <!--<tr>
									<td>
										<label>
										<?php if($settings_password) { ?>
                                        	<input type="checkbox" name="customer_export_import_settings_password" value="1" checked="checked" /> Password
                                        <?php } else { ?>    
                                            <input type="checkbox" name="customer_export_import_settings_password" value="1" /> Password
                                        <?php } ?>
										</label>
									</td>
								</tr>
                                <tr>
									<td>
										<label>
										<?php if($settings_newsletter) { ?>
                                        	<input type="checkbox" name="customer_export_import_settings_newsletter" value="1" checked="checked" /> Newsletter
                                        <?php } else { ?>    
                                            <input type="checkbox" name="customer_export_import_settings_newsletter" value="1" /> Newsletter
                                        <?php } ?>
										</label>
									</td>
								</tr>
                                
                                <tr>
									<td>
										<label>
                                        <?php if($settings_approved) { ?>
											<input type="checkbox" name="customer_export_import_settings_approved" value="1" checked="checked" /> Approved
                                        <?php } else { ?>    
                                            <input type="checkbox" name="customer_export_import_settings_approved" value="1" /> Approved
                                        <?php } ?>
										</label>
									</td>
								</tr>-->
                                
                                <tr>
									<td>
										<label>
                                        <?php if($settings_defaultaddress) { ?>
											<input type="checkbox" name="customer_export_import_settings_defaultaddress" value="1" checked="checked" /> Default Address
                                        <?php } else { ?>    
                                            <input type="checkbox" name="customer_export_import_settings_defaultaddress" value="1" /> Default Address
                                        <?php } ?>
										</label>
									</td>
								</tr>
                                
								<tr>
									<td class="buttons"><a onclick="updateSettings();" class="btn btn-primary"><span><?php echo $button_settings; ?></span></a></td>
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
