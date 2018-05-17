<?php echo $header; ?><?php echo $column_left; ?>
<div id="content">
  <div class="page-header">
    <div class="container-fluid">
      <div class="pull-right"><a href="<?php echo $invoice; ?>" target="_blank" data-toggle="tooltip" title="<?php echo $button_invoice_print; ?>" class="btn btn-info"><i class="fa fa-print"></i></a> <a href="<?php echo $shipping; ?>" target="_blank" data-toggle="tooltip" title="<?php echo $button_shipping_print; ?>" class="btn btn-info"><i class="fa fa-truck"></i></a> <a href="<?php echo $edit; ?>" data-toggle="tooltip" title="<?php echo $button_edit; ?>" class="btn btn-primary"><i class="fa fa-pencil"></i></a> <a href="<?php echo $cancel; ?>" data-toggle="tooltip" title="<?php echo $button_cancel; ?>" class="btn btn-default"><i class="fa fa-reply"></i></a></div>
      <h1><?php echo $heading_title; ?></h1>
      <ul class="breadcrumb">
        <?php foreach ($breadcrumbs as $breadcrumb) { ?>
        <li><a href="<?php echo $breadcrumb['href']; ?>"><?php echo $breadcrumb['text']; ?></a></li>
        <?php } ?>
      </ul>
    </div>
  </div>
  <div class="container-fluid">
    
    <div class="panel panel-default">
      <div class="panel-heading">
        <h3 class="panel-title"><i class="fa fa-shopping-cart"></i> Order Id : <strong>#<?php echo $order_id; ?></strong></h3>
      </div>
      <div class="panel-body" style="padding-bottom:0px;">
    	
        <div class="row">
      <div class="col-md-4">
        <div class="panel panel-default" style="min-height:215px;" >
          <div class="panel-heading">
            <h4 class="panel-title"> Order Details</h4>
          </div>
          <table class="table">
            <tr>
              <td style="text-align:center;">
                <span class="ctm">
                	<div class="col-md-5 rightalign1">Channel :</div> 
                    <div class="col-md-7 paddingleft1"><b> <a href="javascript:void(0)" style="color: #666;">Saleslogic Rep<?php //echo $store_name; ?></a></b></div>
                    </span><br>
                <span class="ctm">
                	<div class="col-md-5 rightalign1">Sales Rep : </div>
                    <div class="col-md-7 paddingleft1"><b> <?php echo $ssfirstname; ?> <?php echo $sslastname; ?></b></div>
                    </span><br>
                <span class="ctm">
                	<div class="col-md-5 rightalign1" style="padding-left:0px;">Date Confirmed : </div>
                    	<div class="col-md-7 paddingleft1"><b><?php echo $date_added; ?></b></div>
                        </span><br>
                <span class="ctm">
                	<div class="col-md-5 rightalign1" style="padding-left:0px;padding-right:14px;">Payment Method : </div>
                    	<div class="col-md-7 paddingleft1"><b><?php echo $payment_method; ?></b></div>
                        </span><br>
                <span class="ctm">
                	<div class="col-md-5 rightalign1" style="padding-left:0px;">Shipping Method : </div>
                    	<div class="col-md-7 paddingleft1"><b><?php echo $shipping_method; ?></b></div>
                        </span><br>
                <span class="ctm">
                	<div class="col-md-5 rightalign1">Status : </div>
                    	<div class="col-md-7 paddingleft1"><b><a class="btn-success" style="padding:2px 5px;border-radius:5px;">Order Confirmed</a></b></div>
                        </span><br>
                <span class="ctm">
                	<div class="col-md-5 rightalign1">Total(ZAR) : </div> 
                    <?php $orderval = end($totals); ?>
                    <div class="col-md-7 paddingleft1"><b> <?php echo $orderval['text']; ?></b></div>
                    </span><br>
                
               </td>
            
            </tr>
            
          </table>
        </div>
      </div>
      <div class="col-md-4">
        <div class="panel panel-default" style="min-height:215px;">
          <div class="panel-heading">
            <h4 class="panel-title">Customer Information</h4>
          </div>
          <table class="table">
            <tr>
              <td style="text-align:center;">
                <span class="ctm">
                	<div class="col-md-6 rightalign1">Customer : </div>
                    <div class="col-md-6 paddingleft1"><b> <?php echo $firstname; ?></b></div>
                </span><br>
                <span class="ctm">
                	<div class="col-md-6 rightalign1">Contract Pricing : </div>
                    <div class="col-md-6 paddingleft1"><b> <?php echo $customer_group; ?></b></div>
                </span><br>
                <span class="ctm">
                	<div class="col-md-6 rightalign1">Email : </div>
                    <div class="col-md-6 paddingleft1"><b> <?php echo $email; ?></b></div>
                </span><br>
                <span class="ctm">
                	<div class="col-md-6 rightalign1">Telephone : </div>
                    <div class="col-md-6 paddingleft1"><b> <?php echo $telephone; ?></b></div>
                </span><br>
                <span class="ctm">
                	<div class="col-md-6 rightalign1">Address : </div>
                    <div class="col-md-6 paddingleft1" style="padding-right: 0px;"><b style="text-align:initial;"> <?php echo $shipaddress['address_1']; ?>, <?php echo $shipaddress['address_2']; ?> <?php echo $shipaddress['city']; ?>, <?php echo $shipaddress['zone']; ?>, <?php echo $shipaddress['country']; ?></b></div>
                </span><br>
                
               </td>
            
            </tr>
            
          </table>
        </div>
      </div>
      <style>
		  .ctm{line-height:21px;}
		  .rightalign1 {text-align: right;}
		  .paddingleft1 {padding-left: 0px;}
		  .paddingleft1 b{ float:left;}
		  .btn-warning1{background-color: white;border: 1px solid #000;border-radius: 5px;color: #666666;padding: 0 10px;}
		  .panel-heading h4{font-weight:bold;}
	  </style>
      <div class="col-md-4">
        <div class="panel panel-default" style="min-height:215px;">
          <div class="panel-heading">
            <h4 class="panel-title">Requested By</h4>
          </div>
          <table class="table">
            <tr>
              <td style="text-align:center;">
                <span class="ctm">
                	<div class="col-md-6 rightalign1">Customer Contact : </div>
                    <div class="col-md-6 paddingleft1"><b> <?php echo $ccfirstname; ?> <?php echo $cclastname; ?></b></div>
                </span><br>
                <span class="ctm">
                	<div class="col-md-6 rightalign1">Email : </div>
                    <div class="col-md-6 paddingleft1"><b> <?php echo $ccemail; ?></b></div>
                </span><br>
                <span class="ctm">
                	<div class="col-md-6 rightalign1">Telephone : </div>
                    <div class="col-md-6 paddingleft1"><b> <?php echo $cctelephone; ?></b></div>
                </span><br>
                <span class="ctm">
                	<div class="col-md-6 rightalign1">Quote Id : </div>
                    <div class="col-md-6 paddingleft1"><b> #<?php echo $quote_id; ?></b></div>
                </span><br>
                <span class="ctm">
                	<div class="col-md-6 rightalign1">Date Added : </div>
                    <div class="col-md-6 paddingleft1"><b> <?php echo $Qdate_added; ?></b></div>
                </span><br>
                
               </td>
            
            </tr>
            
          </table>
        </div>
      </div>
    </div>    
        
        <div class="panel" style="border:1px solid #e8e8e8;"></div>
        
        <ul class="nav nav-tabs">
          <li class="active"><a href="#tab-orderinfo" data-toggle="tab">Order Info</a></li>
          <li><a href="#tab-history" data-toggle="tab"><?php echo $tab_history; ?></a></li>
          <li><a href="#tab-additional" data-toggle="tab"><?php echo $tab_additional; ?></a></li>
          <?php foreach ($tabs as $tab) { ?>
          <li><a href="#tab-<?php echo $tab['code']; ?>" data-toggle="tab"><?php echo $tab['title']; ?></a></li>
          <?php } ?>
        </ul>
        <div class="tab-content" style="margin-bottom:25px;">
          <div class="tab-pane active" id="tab-orderinfo">
            <div class="row">
             <div class="col-md-4">
                <div class="panel panel-default" style="min-height:180px;">
                  <div class="panel-heading">
                    <h3 class="panel-title"><?php echo $text_payment_address; ?></h3>
                  </div>
                  <table class="table table-bordered">
                  <tbody>
                    <tr>
                      <td class="text-left"><?php echo $payment_address; ?></td>
                    </tr>
                  </tbody>
                </table>
                </div>
             </div>
             
             <div class="col-md-4">
                <div class="panel panel-default" style="min-height:180px;">
                  <div class="panel-heading">
                    <h3 class="panel-title"><?php echo $text_shipping_address; ?></h3>
                  </div>
                  <table class="table table-bordered">
                  <tbody>
                    <tr>
                      <?php if ($shipping_method) { ?>
                      <td class="text-left"><?php echo $shipping_address; ?></td>
                      <?php } ?>
                    </tr>
                  </tbody>
                </table>
                </div>
             </div>
             
             <div class="col-md-4">
                <div class="panel panel-default" style="min-height:180px;">
                  <div class="panel-heading">
                    <h3 class="panel-title"><?php echo $text_comment; ?></h3>
                  </div>
                  <table class="table table-bordered">
                  <tbody>
                    <tr>
                      <td class="text-left"><?php echo $comment; ?></td>
                    </tr>
                  </tbody>
                </table>
                </div>
             </div>
             </div>
             
             <table class="table table-bordered">
          <thead>
            <tr>
              <td class="text-left"><?php echo $column_image; ?></td>
              <td class="text-left"><?php echo $column_product; ?></td>
              <td class="text-left"><?php echo $column_model; ?></td>
              <td class="text-right"><?php echo $column_quantity; ?></td>
              <td class="text-right"><?php echo $column_price; ?></td>
              <td class="text-right"><?php echo $column_total; ?></td>
            </tr>
          </thead>
          <tbody>
            <?php foreach ($products as $product) { ?>
            <tr>
           	  <td class="text-left"><img src="<?php echo $product['image']; ?>" /></td>
              <td class="text-left"><a href="<?php echo $product['href']; ?>"><?php echo $product['name']; ?></a>
                <?php foreach ($product['option'] as $option) { ?>
                <br />
                <?php if ($option['type'] != 'file') { ?>
                &nbsp;<small> - <?php echo $option['name']; ?>: <?php echo $option['value']; ?></small>
                <?php } else { ?>
                &nbsp;<small> - <?php echo $option['name']; ?>: <a href="<?php echo $option['href']; ?>"><?php echo $option['value']; ?></a></small>
                <?php } ?>
                <?php } ?></td>
              <td class="text-left"><?php echo $product['model']; ?></td>
              <td class="text-right"><?php echo $product['quantity']; ?></td>
              <td class="text-right"><?php echo $product['price']; ?></td>
              <td class="text-right"><?php echo $product['total']; ?></td>
            </tr>
            <?php } ?>
            <?php foreach ($vouchers as $voucher) { ?>
            <tr>
              <td class="text-left"><a href="<?php echo $voucher['href']; ?>"><?php echo $voucher['description']; ?></a></td>
              <td class="text-left"></td>
              <td class="text-right">1</td>
              <td class="text-right"><?php echo $voucher['amount']; ?></td>
              <td class="text-right"><?php echo $voucher['amount']; ?></td>
            </tr>
            <?php } ?>
            <?php foreach ($totals as $total) { ?>
            <tr>
              <td colspan="5" class="text-right"><?php echo $total['title']; ?></td>
              <td class="text-right"><?php echo $total['text']; ?></td>
            </tr>
            <?php } ?>
          </tbody>
        </table>
            
          </div>
          <div class="tab-pane" id="tab-history">
            <div id="history"></div>
            
            <div class="text-left">
              <button onclick="onpopup()" data-loading-text="<?php echo $text_loading; ?>" class="btn btn-primary"><i class="fa fa-plus-circle"></i> <?php echo $button_history_add; ?></button>
            </div>
            
          </div>
          <div class="tab-pane" id="tab-additional">
            <?php if ($account_custom_fields) { ?>
            <div class="table-responsive">
              <table class="table table-bordered">
                <thead>
                  <tr>
                    <td colspan="2"><?php echo $text_account_custom_field; ?></td>
                  </tr>
                </thead>
                <tbody>
                  <?php foreach ($account_custom_fields as $custom_field) { ?>
                  <tr>
                    <td><?php echo $custom_field['name']; ?></td>
                    <td><?php echo $custom_field['value']; ?></td>
                  </tr>
                  <?php } ?>
                </tbody>
              </table>
            </div>
            <?php } ?>
            <?php if ($payment_custom_fields) { ?>
            <div class="table-responsive">
              <table class="table table-bordered">
                <thead>
                  <tr>
                    <td colspan="2"><?php echo $text_payment_custom_field; ?></td>
                  </tr>
                </thead>
                <tbody>
                  <?php foreach ($payment_custom_fields as $custom_field) { ?>
                  <tr>
                    <td><?php echo $custom_field['name']; ?></td>
                    <td><?php echo $custom_field['value']; ?></td>
                  </tr>
                  <?php } ?>
                </tbody>
              </table>
            </div>
            <?php } ?>
            <?php if ($shipping_method && $shipping_custom_fields) { ?>
            <div class="table-responsive">
              <table class="table table-bordered">
                <thead>
                  <tr>
                    <td colspan="2"><?php echo $text_shipping_custom_field; ?></td>
                  </tr>
                </thead>
                <tbody>
                  <?php foreach ($shipping_custom_fields as $custom_field) { ?>
                  <tr>
                    <td><?php echo $custom_field['name']; ?></td>
                    <td><?php echo $custom_field['value']; ?></td>
                  </tr>
                  <?php } ?>
                </tbody>
              </table>
            </div>
            <?php } ?>
            <div class="table-responsive">
              <table class="table table-bordered">
                <thead>
                  <tr>
                    <td colspan="2"><?php echo $text_browser; ?></td>
                  </tr>
                </thead>
                <tbody>
                  <tr>
                    <td><?php echo $text_ip; ?></td>
                    <td><?php echo $ip; ?></td>
                  </tr>
                  <?php if ($forwarded_ip) { ?>
                  <tr>
                    <td><?php echo $text_forwarded_ip; ?></td>
                    <td><?php echo $forwarded_ip; ?></td>
                  </tr>
                  <?php } ?>
                  <tr>
                    <td><?php echo $text_user_agent; ?></td>
                    <td><?php echo $user_agent; ?></td>
                  </tr>
                  <tr>
                    <td><?php echo $text_accept_language; ?></td>
                    <td><?php echo $accept_language; ?></td>
                  </tr>
                </tbody>
              </table>
            </div>
          </div>
          <?php foreach ($tabs as $tab) { ?>
          <div class="tab-pane" id="tab-<?php echo $tab['code']; ?>"><?php echo $tab['content']; ?></div>
          <?php } ?>
        </div>
        
        
        
      </div>
    </div>
    
  </div>
  <div id="myModal" class="modal fade" role="dialog">
          <form action="" method="post" enctype="multipart/form-data" >
           <input type="hidden" name="customer_id" value="<?php echo $customer_id; ?>" />
           <input type="hidden" name="firstname" value="<?php echo $firstname; ?>" />
           
          <div class="modal-dialog">
        
            <!-- Modal content-->
            <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Add Order History</h4>
              </div>
              <div class="modal-body" id="newadbook">
                
                                   <div class="form-group">
                                      <label class="control-label" for="input-order-status"><?php echo $entry_order_status; ?></label>
                                        <select name="order_status_id" id="input-order-status" class="form-control">
                                          <?php foreach ($order_statuses as $order_statuses) { ?>
                                          <?php if ($order_statuses['order_status_id'] == $order_status_id) { ?>
                                          <option value="<?php echo $order_statuses['order_status_id']; ?>" selected="selected"><?php echo $order_statuses['name']; ?></option>
                                          <?php } else { ?>
                                          <option value="<?php echo $order_statuses['order_status_id']; ?>"><?php echo $order_statuses['name']; ?></option>
                                          <?php } ?>
                                          <?php } ?>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                      <label class="control-label" for="input-override"><span data-toggle="tooltip" title="<?php echo $help_override; ?>"><?php echo $entry_override; ?></span></label>
                                        <input type="checkbox" name="override" value="1" id="input-override" style="margin-left:10px;top:3px;" />
                                    </div>
                                    <div class="form-group">
                                      <label class="control-label" for="input-notify"><?php echo $entry_notify; ?></label>
                                        <input type="checkbox" name="notify" value="1" id="input-notify" style="margin-left:10px;top:3px;" />
                                    </div>
                                    <div class="form-group">
                                      <label class="control-label" for="input-comment"><?php echo $entry_comment; ?></label>
                                        <textarea name="comment" rows="8" id="input-comment" class="form-control"></textarea>
                                    </div>
                                   
                
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-primary submitBtn" onclick="submitAddressForm()" >Add History</button>
                <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
              </div>
            </div>
        
          </div>
          </form>
        </div>
  <script type="text/javascript">
	
		function onpopup()
		{
		 
			$('#myModal').modal('show'); 
			
		}
	
	function submitAddressForm(){
   	 $.ajax({
		url: '<?php echo $catalog; ?>index.php?route=api/order/history&token=' + token + '&store_id=<?php echo $store_id; ?>&order_id=<?php echo $order_id; ?>',
		type: 'post',
		dataType: 'json',
		data: 'order_status_id=' + encodeURIComponent($('select[name=\'order_status_id\']').val()) + '&notify=' + ($('input[name=\'notify\']').prop('checked') ? 1 : 0) + '&override=' + ($('input[name=\'override\']').prop('checked') ? 1 : 0) + '&append=' + ($('input[name=\'append\']').prop('checked') ? 1 : 0) + '&comment=' + encodeURIComponent($('textarea[name=\'comment\']').val()),
		beforeSend: function() {
			$('#button-history').button('loading');
		},
		complete: function() {
			$('#button-history').button('reset');
		},
		success: function(json) {
			$('.alert').remove();

			if (json['error']) {
				$('#history').before('<div class="alert alert-danger"><i class="fa fa-exclamation-circle"></i> ' + json['error'] + ' <button type="button" class="close" data-dismiss="alert">&times;</button></div>');
			}

			if (json['success']) {
				$('#myModal').modal('hide');
				$('#history').load('index.php?route=sale/order/history&token=<?php echo $token; ?>&order_id=<?php echo $order_id; ?>');

				$('#history').before('<div class="alert alert-success"><i class="fa fa-check-circle"></i> ' + json['success'] + ' <button type="button" class="close" data-dismiss="alert">&times;</button></div>');

				$('textarea[name=\'comment\']').val('');
			}
		},
		error: function(xhr, ajaxOptions, thrownError) {
			alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
		}
	});
	}	
		
		</script>
  <script type="text/javascript"><!--
$(document).delegate('#button-ip-add', 'click', function() {
	$.ajax({
		url: 'index.php?route=user/api/addip&token=<?php echo $token; ?>&api_id=<?php echo $api_id; ?>',
		type: 'post',
		data: 'ip=<?php echo $api_ip; ?>',
		dataType: 'json',
		beforeSend: function() {
			$('#button-ip-add').button('loading');
		},
		complete: function() {
			$('#button-ip-add').button('reset');
		},
		success: function(json) {
			$('.alert').remove();

			if (json['error']) {
				$('#content > .container-fluid').prepend('<div class="alert alert-danger"><i class="fa fa-exclamation-circle"></i> ' + json['error'] + ' <button type="button" class="close" data-dismiss="alert">&times;</button></div>');
			}

			if (json['success']) {
				$('#content > .container-fluid').prepend('<div class="alert alert-success"><i class="fa fa-check-circle"></i> ' + json['success'] + ' <button type="button" class="close" data-dismiss="alert">&times;</button></div>');
			}
		},
		error: function(xhr, ajaxOptions, thrownError) {
			alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
		}
	});
});

$(document).delegate('#button-invoice', 'click', function() {
	$.ajax({
		url: 'index.php?route=sale/order/createinvoiceno&token=<?php echo $token; ?>&order_id=<?php echo $order_id; ?>',
		dataType: 'json',
		beforeSend: function() {
			$('#button-invoice').button('loading');
		},
		complete: function() {
			$('#button-invoice').button('reset');
		},
		success: function(json) {
			$('.alert').remove();

			if (json['error']) {
				$('#content > .container-fluid').prepend('<div class="alert alert-danger"><i class="fa fa-exclamation-circle"></i> ' + json['error'] + '</div>');
			}

			if (json['invoice_no']) {
				$('#invoice').html(json['invoice_no']);

				$('#button-invoice').replaceWith('<button disabled="disabled" class="btn btn-success btn-xs"><i class="fa fa-cog"></i></button>');
			}
		},
		error: function(xhr, ajaxOptions, thrownError) {
			alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
		}
	});
});

$(document).delegate('#button-reward-add', 'click', function() {
	$.ajax({
		url: 'index.php?route=sale/order/addreward&token=<?php echo $token; ?>&order_id=<?php echo $order_id; ?>',
		type: 'post',
		dataType: 'json',
		beforeSend: function() {
			$('#button-reward-add').button('loading');
		},
		complete: function() {
			$('#button-reward-add').button('reset');
		},
		success: function(json) {
			$('.alert').remove();

			if (json['error']) {
				$('#content > .container-fluid').prepend('<div class="alert alert-danger"><i class="fa fa-exclamation-circle"></i> ' + json['error'] + '</div>');
			}

			if (json['success']) {
                $('#content > .container-fluid').prepend('<div class="alert alert-success"><i class="fa fa-check-circle"></i> ' + json['success'] + '</div>');

				$('#button-reward-add').replaceWith('<button id="button-reward-remove" data-toggle="tooltip" title="<?php echo $button_reward_remove; ?>" class="btn btn-danger btn-xs"><i class="fa fa-minus-circle"></i></button>');
			}
		},
		error: function(xhr, ajaxOptions, thrownError) {
			alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
		}
	});
});

$(document).delegate('#button-reward-remove', 'click', function() {
	$.ajax({
		url: 'index.php?route=sale/order/removereward&token=<?php echo $token; ?>&order_id=<?php echo $order_id; ?>',
		type: 'post',
		dataType: 'json',
		beforeSend: function() {
			$('#button-reward-remove').button('loading');
		},
		complete: function() {
			$('#button-reward-remove').button('reset');
		},
		success: function(json) {
			$('.alert').remove();

			if (json['error']) {
				$('#content > .container-fluid').prepend('<div class="alert alert-danger"><i class="fa fa-exclamation-circle"></i> ' + json['error'] + '</div>');
			}

			if (json['success']) {
                $('#content > .container-fluid').prepend('<div class="alert alert-success"><i class="fa fa-check-circle"></i> ' + json['success'] + '</div>');

				$('#button-reward-remove').replaceWith('<button id="button-reward-add" data-toggle="tooltip" title="<?php echo $button_reward_add; ?>" class="btn btn-success btn-xs"><i class="fa fa-plus-circle"></i></button>');
			}
		},
		error: function(xhr, ajaxOptions, thrownError) {
			alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
		}
	});
});

$(document).delegate('#button-commission-add', 'click', function() {
	$.ajax({
		url: 'index.php?route=sale/order/addcommission&token=<?php echo $token; ?>&order_id=<?php echo $order_id; ?>',
		type: 'post',
		dataType: 'json',
		beforeSend: function() {
			$('#button-commission-add').button('loading');
		},
		complete: function() {
			$('#button-commission-add').button('reset');
		},
		success: function(json) {
			$('.alert').remove();

			if (json['error']) {
				$('#content > .container-fluid').prepend('<div class="alert alert-danger"><i class="fa fa-exclamation-circle"></i> ' + json['error'] + '</div>');
			}

			if (json['success']) {
                $('#content > .container-fluid').prepend('<div class="alert alert-success"><i class="fa fa-check-circle"></i> ' + json['success'] + '</div>');

				$('#button-commission-add').replaceWith('<button id="button-commission-remove" data-toggle="tooltip" title="<?php echo $button_commission_remove; ?>" class="btn btn-danger btn-xs"><i class="fa fa-minus-circle"></i></button>');
			}
		},
		error: function(xhr, ajaxOptions, thrownError) {
			alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
		}
	});
});

$(document).delegate('#button-commission-remove', 'click', function() {
	$.ajax({
		url: 'index.php?route=sale/order/removecommission&token=<?php echo $token; ?>&order_id=<?php echo $order_id; ?>',
		type: 'post',
		dataType: 'json',
		beforeSend: function() {
			$('#button-commission-remove').button('loading');
		},
		complete: function() {
			$('#button-commission-remove').button('reset');
		},
		success: function(json) {
			$('.alert').remove();

			if (json['error']) {
				$('#content > .container-fluid').prepend('<div class="alert alert-danger"><i class="fa fa-exclamation-circle"></i> ' + json['error'] + '</div>');
			}

			if (json['success']) {
                $('#content > .container-fluid').prepend('<div class="alert alert-success"><i class="fa fa-check-circle"></i> ' + json['success'] + '</div>');

				$('#button-commission-remove').replaceWith('<button id="button-commission-add" data-toggle="tooltip" title="<?php echo $button_commission_add; ?>" class="btn btn-success btn-xs"><i class="fa fa-plus-circle"></i></button>');
			}
		},
		error: function(xhr, ajaxOptions, thrownError) {
			alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
		}
	});
});

var token = '';

// Login to the API
$.ajax({
	url: '<?php echo $catalog; ?>index.php?route=api/login',
	type: 'post',
	dataType: 'json',
	data: 'key=<?php echo $api_key; ?>',
	crossDomain: true,
	success: function(json) {
		$('.alert').remove();

        if (json['error']) {
    		if (json['error']['key']) {
    			$('#content > .container-fluid').prepend('<div class="alert alert-danger"><i class="fa fa-exclamation-circle"></i> ' + json['error']['key'] + ' <button type="button" class="close" data-dismiss="alert">&times;</button></div>');
    		}

            if (json['error']['ip']) {
    			$('#content > .container-fluid').prepend('<div class="alert alert-danger"><i class="fa fa-exclamation-circle"></i> ' + json['error']['ip'] + ' <button type="button" id="button-ip-add" data-loading-text="<?php echo $text_loading; ?>" class="btn btn-danger btn-xs pull-right"><i class="fa fa-plus"></i> <?php echo $button_ip_add; ?></button></div>');
    		}
        }

        if (json['token']) {
			token = json['token'];
		}
	},
	error: function(xhr, ajaxOptions, thrownError) {
		alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
	}
});

$('#history').delegate('.pagination a', 'click', function(e) {
	e.preventDefault();

	$('#history').load(this.href);
});

$('#history').load('index.php?route=sale/order/history&token=<?php echo $token; ?>&order_id=<?php echo $order_id; ?>');

$('#button-history').on('click', function() {
	/*
	if (typeof verifyStatusChange == 'function'){
		if (verifyStatusChange() == false){
			return false;
		} else{
			addOrderInfo();
		}
	} else{
		addOrderInfo();
	}*/

	$.ajax({
		url: '<?php echo $catalog; ?>index.php?route=api/order/history&token=' + token + '&store_id=<?php echo $store_id; ?>&order_id=<?php echo $order_id; ?>',
		type: 'post',
		dataType: 'json',
		data: 'order_status_id=' + encodeURIComponent($('select[name=\'order_status_id\']').val()) + '&notify=' + ($('input[name=\'notify\']').prop('checked') ? 1 : 0) + '&override=' + ($('input[name=\'override\']').prop('checked') ? 1 : 0) + '&append=' + ($('input[name=\'append\']').prop('checked') ? 1 : 0) + '&comment=' + encodeURIComponent($('textarea[name=\'comment\']').val()),
		beforeSend: function() {
			$('#button-history').button('loading');
		},
		complete: function() {
			$('#button-history').button('reset');
		},
		success: function(json) {
			$('.alert').remove();

			if (json['error']) {
				$('#history').before('<div class="alert alert-danger"><i class="fa fa-exclamation-circle"></i> ' + json['error'] + ' <button type="button" class="close" data-dismiss="alert">&times;</button></div>');
			}

			if (json['success']) {
				$('#history').load('index.php?route=sale/order/history&token=<?php echo $token; ?>&order_id=<?php echo $order_id; ?>');

				$('#history').before('<div class="alert alert-success"><i class="fa fa-check-circle"></i> ' + json['success'] + ' <button type="button" class="close" data-dismiss="alert">&times;</button></div>');

				$('textarea[name=\'comment\']').val('');
			}
		},
		error: function(xhr, ajaxOptions, thrownError) {
			alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
		}
	});
});

function changeStatus(){
	var status_id = $('select[name="order_status_id"]').val();

	$('#openbay-info').remove();

	$.ajax({
		url: 'index.php?route=extension/openbay/getorderinfo&token=<?php echo $token; ?>&order_id=<?php echo $order_id; ?>&status_id=' + status_id,
		dataType: 'html',
		success: function(html) {
			$('#history').after(html);
		}
	});
}

function addOrderInfo(){
	var status_id = $('select[name="order_status_id"]').val();

	$.ajax({
		url: 'index.php?route=extension/openbay/addorderinfo&token=<?php echo $token; ?>&order_id=<?php echo $order_id; ?>&status_id=' + status_id,
		type: 'post',
		dataType: 'html',
		data: $(".openbay-data").serialize()
	});
}

$(document).ready(function() {
	changeStatus();
});

$('select[name="order_status_id"]').change(function(){
	changeStatus();
});
//--></script> 
</div>
<?php echo $footer; ?> 
