<?php echo $header; ?><?php echo $column_left; ?>
<div id="content">
  <div class="page-header">
    <div class="container-fluid">
      <div class="pull-right">
      	<div style="float:left">
        <a href="javascript:void();" data-toggle="tooltip" title="Cancel Order" onclick="ConfirmOrderCancel('ordercancel','Are you sure want to Cancel this Order ?')" style="float: right; font-family: Calibri;" class="btn btn-danger"><i class="fa fa-times"></i></a>
        <a data-toggle="tooltip" id="button-save" title="Confirm" class="btn btn-success" style="float:right;margin-right:8px;font-family: Calibri;"><i class="fa fa-check"></i></a>
        </div>
        <div style="float:right;margin-left:8px;">
        <a href="<?php echo $cancel; ?>" data-toggle="tooltip" title="Back" class="btn btn-default" style="float:right;"><i class="fa fa-reply"></i></a>
        </div>
        
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
  	
    <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" id="form-user" class="form-horizontal">
    <input type="hidden" id="button-refresh" />
    <input type="hidden" id="button-payment-address" />
    <input type="hidden" id="button-shipping-address" />
    <input type="hidden" name="order_id" value="<?php echo $order_id; ?>" />
    <input type="hidden" name="order_status_id" value="<?php echo $order_status_id; ?>" />
    
    <div id="tab-customer" style="display:none">
        <input type="hidden" name="currency" value="ZAR" />
        <input type="hidden" name="customer" value="<?php echo $firstname; ?>" />
        <input type="hidden" name="customer_group_id" value="<?php echo $customer_group_id; ?>" />
        <input type="hidden" name="customer_id" value="<?php echo $customer_id; ?>" />
        
        <?php if($customer_id > 0) { ?>
        <input type="hidden" name="customer_contact_id" value="<?php echo $customer_contact_id; ?>" />
        <?php } ?>
        
        <input type="hidden" name="email" value="<?php echo $email; ?>" />
        <input type="hidden" name="firstname" value="<?php echo $firstname; ?>" />
        <input type="hidden" name="lastname" value="<?php echo $firstname; ?>" />
        <input type="hidden" name="store_id" value="0" />
        <input type="hidden" name="telephone" value="<?php echo $telephone; ?>" />
         
    </div>
    
    <div id="tab-shipping" style="display:none">
        <input type="hidden" name="address_1" value="<?php echo $shipaddress['address_1']; ?>" />
        <input type="hidden" name="address_2" value="<?php echo $shipaddress['address_2']; ?>" />
        <input type="hidden" name="city" value="<?php echo $shipaddress['city']; ?>" />
        <input type="hidden" name="company" value="<?php echo $shipaddress['company']; ?>" />
        <input type="hidden" name="country_id" value="<?php echo $shipaddress['country_id']; ?>" />
        <input type="hidden" name="firstname" value="<?php echo $shipaddress['firstname']; ?>" />
        <input type="hidden" name="lastname" value="<?php echo $shipaddress['lastname']; ?>" />
        <input type="hidden" name="postcode" value="<?php echo $shipaddress['postcode']; ?>" />
        <input type="hidden" name="zone_id" value="<?php echo $shipaddress['zone_id']; ?>" />
 
    </div>
    
    <div id="tab-payment" style="display:none">
        <input type="hidden" name="address_1" value="<?php echo $shipaddress['address_1']; ?>" />
        <input type="hidden" name="address_2"  value="<?php echo $shipaddress['address_2']; ?>" />
        <input type="hidden" name="city" value="<?php echo $shipaddress['city']; ?>" />
        <input type="hidden" name="company" value="<?php echo $shipaddress['company']; ?>" />
        <input type="hidden" name="country_id" value="<?php echo $shipaddress['country_id']; ?>" />
        <input type="hidden" name="firstname" value="<?php echo $shipaddress['firstname']; ?>" />
        <input type="hidden" name="lastname" value="<?php echo $shipaddress['lastname']; ?>" />
        <input type="hidden" name="postcode" value="<?php echo $shipaddress['postcode']; ?>" />
        <input type="hidden" name="zone_id" value="<?php echo $shipaddress['zone_id']; ?>" />
 
    </div>
    
    <div class="panel panel-default">
      <div class="panel-heading">
        <h3 class="panel-title"><i class="fa fa-shopping-cart"></i> Order Id : <strong>#<?php echo $order_id; ?></strong></h3>
      </div>
      <div class="panel-body" style="padding-bottom:0px;">
    	
        <div class="row">
      <div class="col-md-4">
        <div class="panel panel-default" style="min-height:195px;">
          <div class="panel-heading" style="padding-left:5px;">
            <h4 class="panel-title"> Order Information</h4>
          </div>
          <table class="table">
            <tr>
              <td style="text-align:center;">
                <span class="ctm">
                	<div class="col-md-5 rightalign1">Channel :</div> 
                    <div class="col-md-7 paddingleft1"><b> <a href="javascript:void(0)" style="color: #666;"><?php echo $channelname; ?><?php //echo $store_name; ?></a></b></div>
                    </span><br>
                <span class="ctm">
                	<div class="col-md-5 rightalign1">Sales Rep : </div>
                    <div class="col-md-7 paddingleft1"><b><?php if($isReplogic) { ?> <?php echo $ssfirstname; ?> <?php echo $sslastname; ?><?php } else { ?>None <?php } ?></b></div>
                    </span><br>
                <span class="ctm">
                	<div class="col-md-5 rightalign1">Status : </div>
                    	<div class="col-md-7 paddingleft1"><b>
                        
                            <?php if($order_status_id == '5' || $order_status_id == '3' || $order_status_id == '15' || $order_status_id == '11') { ?>
                            <a class="btn-success" style="padding:2px 5px;border-radius:5px;">Order Confirmed</a>
                         <?php } else if($order_status_id == '1') { ?>
                            <a class="btn-warning" style="padding:2px 5px;border-radius:5px;">Pending</a>
                         <?php } else if($order_status_id == '2') { ?>
                            <a class="btn-warning" style="background-color: white;border: 1px solid #000;border-radius: 5px;color: #666666;padding: 0 10px;">Processing</a>
                         <?php } else if($order_status_id == '7' || $order_status_id == '10' || $order_status_id == '0') { ?>
                            <a class="btn-warning" style="background-color: #DB524B;border: 1px solid #000;border-radius: 5px;color: #FFFFFF;padding: 0 10px;">Cancelled</a>                         <?php } ?>
                        </b></div>
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
        <div class="panel panel-default" style="min-height:195px;">
          <div class="panel-heading" style="padding-left:5px;">
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
                    <div class="col-md-6 paddingleft1" style="padding-right: 0px;"><b style="text-align: initial;"> <?php echo $shipaddress['address_1']; ?>, <?php echo $shipaddress['address_2']; ?> <?php echo $shipaddress['city']; ?>, <?php echo $shipaddress['zone']; ?>, <?php echo $shipaddress['country']; ?></b></div>
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
        <div class="panel panel-default" style="min-height:195px;">
          <div class="panel-heading" style="padding-left:5px;">
            <h4 class="panel-title">Requested By</h4>
          </div>
          <table class="table">
            <tr>
              <?php if($isReplogic) { ?>
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
                    <div class="col-md-6 paddingleft1"><b> <?php echo $Odate_added; ?></b></div>
                </span><br>
                
               </td>
               <?php } else { ?>
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
                    <div class="col-md-6 paddingleft1" style="padding-right: 0px;"><b style="text-align: initial;"> <?php echo $shipaddress['address_1']; ?>, <?php echo $shipaddress['address_2']; ?> <?php echo $shipaddress['city']; ?>, <?php echo $shipaddress['zone']; ?>, <?php echo $shipaddress['country']; ?></b></div>
                </span><br>
                
               </td>
               <?php } ?>
              
            
            </tr>
            
          </table>
        </div>
      </div>
    </div>    
        
      </div>
    </div>
    <div class="panel panel-default">
      <div class="panel-heading">
        <h3 class="panel-title"><i class="fa fa-info-circle"></i> Order Details</h3>
      </div>
      <div class="panel-body">
          <div class="form-group required">
            <label class="col-sm-2 control-label" for="input-username">Shipping Address</label>
            <div class="col-sm-10">
              <select name="shippingaddress" id="input-sales_manager" class="form-control">
                <option value="" selected="selected">Select Shipping Address</option>
                    <?php foreach ($addresses as $address) { ?>
                    	<?php if($address['address_1'] == $shipping_address_1 && $address['address_2'] == $shipping_address_2 && $address['city'] == $shipping_city && $address['postcode'] == $shipping_postcode && $address['country_id'] == $shipping_country_id && $address['zone_id'] == $shipping_zone_id  ) { ?>
                    <option value="<?php echo $address['address_id']; ?>" selected="selected"><?php echo $address['address_1'] .' '. $address['address_2'] . ', ' . $address['city'] . ', ' . $address['zone']. ', ' . $address['country']; ?></option>
                    <?php } else { ?>
                    <option value="<?php echo $address['address_id']; ?>"><?php echo $address['address_1'] .' '. $address['address_2'] . ', ' . $address['city'] . ', ' . $address['zone']. ', ' . $address['country']; ?></option>
                    <?php } ?>
                    <?php } ?>
              </select>
              <div style="width:100%;float:left;">
              	<a id="newaddress" onclick="onpopup()" class="btn" style="padding-left:0px;" ><i class="fa fa-plus"></i> Add New Address</a>
              	
              </div>
            </div>
          </div>
          
     
          
          <div class="form-group">
            <label class="col-sm-2 control-label" for="input-username">Invoice to Shipping Address</label>
            <div class="col-sm-10">
              <input type="checkbox" name="" class="form-control" />
            </div>
          </div>
          <div class="form-group required">
            <label class="col-sm-2 control-label" for="input-username">Shipping Method</label>
            <div class="col-sm-10">
              <select id="input-shipping_method" name="shipping_method" class="form-control">
                <option value="">Shipping Address</option>
                <?php if ($shipping_code) { ?>
                    <option value="<?php echo $shipping_code; ?>" selected="selected"><?php echo $shipping_method; ?></option>
                <?php } ?>	
              </select>
            </div>
          </div>
          
          <div class="form-group required">
            <label class="col-sm-2 control-label" for="input-username">Payment Method</label>
            <div class="col-sm-10">
              <select id="input-payment_method" name="payment_method" class="form-control">
                <option value="">Payment Method</option>
                <?php if ($payment_code) { ?>
                    <option value="<?php echo $payment_code; ?>" selected="selected"><?php echo $payment_method; ?></option>
                <?php } ?>
                	
              </select>
            </div>
          </div>
          
          <div class="form-group">
            <label class="col-sm-2 control-label" for="input-username">Comment</label>
            <div class="col-sm-10">
              <textarea class="form-control" name="comment"><?php echo $comment; ?></textarea>
            </div>
          </div>
        
      </div>
    </div>
    <div class="panel panel-default">
      <div class="panel-body">
        <?php if($access) { ?>
        <table class="table table-bordered">
          <thead>
            <tr>
              <td style="width: 50%;" class="text-left"><?php echo $text_payment_address; ?></td>
              <?php if ($shipping_method) { ?>
              <td style="width: 50%;" class="text-left"><?php echo $text_shipping_address; ?></td>
              <?php } ?>
            </tr>
          </thead>
          <tbody>
            <tr>
              <td class="text-left"><?php echo $payment_address; ?></td>
              <?php if ($shipping_method) { ?>
              <td class="text-left"><?php echo $shipping_address; ?></td>
              <?php } ?>
            </tr>
          </tbody>
        </table>
        <?php } ?>
        <table class="table table-bordered">
          <thead>
            <tr>
              <td class="text-left"><?php echo $column_image; ?></td>
              <td class="text-left"><?php echo $column_product; ?></td>
              <td class="text-left"><?php echo $column_model; ?></td>
              <td class="text-right"><?php echo $column_quantity; ?></td>
              <td class="text-right"><?php echo $column_price; ?></td>
              <td class="text-right"><?php echo $column_total; ?></td>
              <td class="text-right">Action</td>
            </tr>
          </thead>
          <tbody id="cart">
         
            
            
             <?php if ($order_products) { ?>
                    <?php $product_row = 0; ?>
                    <?php foreach ($order_products as $product) { ?>
                    <tr>
                      <td class="text-left"><img src="<?php echo $product['image']; ?>" /></td>
                      <td class="text-left"><?php echo $product['name']; ?><br />
                        <input type="hidden" name="product[<?php echo $product_row; ?>][product_id]" value="<?php echo $product['product_id']; ?>" />
                        <?php foreach ($product['option'] as $option) { ?>
                        - <small><?php echo $option['name']; ?>: <?php echo $option['value']; ?></small><br />
                        <?php if ($option['type'] == 'select' || $option['type'] == 'radio' || $option['type'] == 'image') { ?>
                        <input type="hidden" name="product[<?php echo $product_row; ?>][option][<?php echo $option['product_option_id']; ?>]" value="<?php echo $option['product_option_value_id']; ?>" />
                        <?php } ?>
                        <?php if ($option['type'] == 'checkbox') { ?>
                        <input type="hidden" name="product[<?php echo $product_row; ?>][option][<?php echo $option['product_option_id']; ?>][]" value="<?php echo $option['product_option_value_id']; ?>" />
                        <?php } ?>
                        <?php if ($option['type'] == 'text' || $option['type'] == 'textarea' || $option['type'] == 'file' || $option['type'] == 'date' || $option['type'] == 'datetime' || $option['type'] == 'time') { ?>
                        <input type="hidden" name="product[<?php echo $product_row; ?>][option][<?php echo $option['product_option_id']; ?>]" value="<?php echo $option['value']; ?>" />
                        <?php } ?>
                        <?php } ?></td>
                      <td class="text-left"><?php echo $product['model']; ?></td>
                      <td class="text-right">
                        <div class="input-group btn-block" style="max-width: 200px;"><input name="product[<?php echo $product_row; ?>][quantity]" value="<?php echo $product['quantity']; ?>" class="form-control" type="text"><span class="input-group-btn"><button type="button" data-toggle="tooltip" title="" data-loading-text="Loading..." class="btn btn-primary" data-original-title="Refresh"><i class="fa fa-refresh"></i></button></span></div>
                        </td>
                      <td class="text-right"><?php echo $product['price']; ?></td>
                      <td class="text-right"><?php echo $product['total']; ?></td>
                      <td class="text-center" style="width: 3px;"><button type="button" value="<?php echo $product['product_id']; ?>" data-toggle="tooltip" title="" data-loading-text="Loading..." class="btn btn-danger" data-original-title="Remove"><i class="fa fa-minus-circle"></i></button></td>
                    </tr>
                    <?php $product_row++; ?>
                    <?php } ?>
                    <?php } ?>
                    
            
        
         <?php foreach ($totals as $total) { ?>
            <tr>
              <td colspan="5" class="text-right"><?php echo $total['title']; ?></td>
              <td class="text-right" style="text-align:center;"><?php echo $total['text']; ?></td>
            </tr>
            <?php } ?>
          </tbody>
        </table>
        
      </div>
    </div>
    
    </form>
    
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
                <h4 class="modal-title">Add New Address</h4>
              </div>
              <div class="modal-body" id="newadbook">
                
                                    <div class="form-group required">
                                        <label for="inputName" class="control-label">Address Line 1</label>
                                        <input class="form-control" name="address_1" id="newaddressline1" placeholder="Enter Address Line 1" type="text">
                                    </div>
                                    <div class="form-group required">
                                        <label for="inputName">Address Line 2</label>
                                        <input class="form-control" name="address_2" id="newaddressline2" placeholder="Enter Address Line 2" type="text">
                                    </div>
                                    <div class="form-group required">
                                        <label for="inputName" class="control-label">City</label>
                                        <input class="form-control" name="city" id="city" placeholder="Enter City" type="text">
                                    </div>
                                    <div class="form-group">
                                        <label for="inputName" class="control-label">Postcode</label>
                                        <input class="form-control" name="postcode" id="city" placeholder="Enter Postcode" type="text">
                                    </div>
                                    <div class="form-group required">
                                        <label for="input-payment-country" class="control-label"><?php echo $entry_country; ?></label>
                                        
                                          <select name="country_id" id="input-payment-country" class="form-control">
                                            <option value=""><?php echo $text_select; ?></option>
                                            <?php foreach ($countries as $country) { ?>
                                                <?php if($country['country_id'] == '193') { ?>
                                                <option value="<?php echo $country['country_id']; ?>" selected="selected"><?php echo $country['name']; ?></option>
                                                <?php } else { ?>
                                                <option value="<?php echo $country['country_id']; ?>"><?php echo $country['name']; ?></option>
                                                <?php } ?>
                                            <?php } ?>
                                          </select>
                                      
                                      </div>
                 				    <div class="form-group required">
                                    <label for="input-payment-zone" class="control-label"><?php echo $entry_zone; ?></label>
                                   
                                      <select name="zone_id" id="input-payment-zone" class="form-control">
                                      </select>
                                    
                                  </div>
                                
                
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-primary submitBtn" onclick="submitAddressForm()" >Save</button>
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
    var newaddressline1 = $('#newaddressline1').val();
    var city = $('#city').val();
    var country = $('#input-payment-country').val();
	var zone = $('#input-payment-zone').val();
    if(newaddressline1.trim() == '' ){
        alert('Please Enter Address Line 1.');
        $('#newaddressline1').focus();
        return false;
	} else if(city.trim() == '' ){
        alert('Please Enter City.');
        $('#city').focus();
        return false;
	} else if(country.trim() == '' ){
        alert('Please Select Country.');
        $('#input-payment-country').focus();
        return false;
	} else if(zone.trim() == '' ){
        alert('Please Select Region / State.');
        $('#input-payment-zone').focus();
        return false;
    }else{
        $.ajax({
            type:'POST',
            url:'submit_form.php',
			url: 'index.php?route=customer/customer/addaddress&token=<?php echo $token; ?>',
            data: $('#myModal input[type=\'text\'], #myModal input[type=\'hidden\'], #myModal select'),
            beforeSend: function () {
                $('.submitBtn').attr("disabled","disabled");
                $('.modal-body').css('opacity', '.5');
            },
            success:function(json){
                $('#myModal').modal('hide');
				
				var lastid = json['address_id'];
				
				html = '';
				html = '<option value="">Select Shipping Address</option>';

						if (json['addresses']) {
							for (i in json['addresses']) {
								if (json['addresses'][i]['address_id'] == lastid) {
									html += '<option value="' + json['addresses'][i]['address_id'] + '" selected="selected">' + json['addresses'][i]['address_1'] + ' ' + json['addresses'][i]['address_2'] + ',' + json['addresses'][i]['city'] + ',' + json['addresses'][i]['zone'] + ',' + json['addresses'][i]['country'] + '</option>';
								} else {
									html += '<option value="' + json['addresses'][i]['address_id'] + '">' + json['addresses'][i]['address_1'] + ' ' + json['addresses'][i]['address_2'] + ',' + json['addresses'][i]['city'] + ',' + json['addresses'][i]['zone'] + ',' + json['addresses'][i]['country'] + '</option>';
								}
							}
						}

						$('select[name=\'shippingaddress\']').html(html);
						$('select[name=\'shippingaddress\']').trigger('change');
				 
            }
        });
    }
}	

$('select[name=\'shippingaddress\']').on('change', function() {
	$.ajax({
		url: 'index.php?route=customer/customer/address&token=<?php echo $token; ?>&address_id=' + this.value,
		dataType: 'json',
		beforeSend: function() {
			$('select[name=\'shippingaddress\']').after(' <i class="fa fa-circle-o-notch fa-spin"></i>');
		},
		complete: function() {
			$('.fa-spin').remove();
		},
		success: function(json) {
			
			<?php if($customer_id > 0 ) { ?>
			var add1 = json['address_1'];
			var add2 = json['address_2'];
			var selpostcode = json['postcode'];
			var selcity = json['city'];
			var selcountryid = json['country_id'];
			var selzoneid = json['zone_id'];
			
			$('#tab-shipping input[name="address_1"]').val(add1);
			$('#tab-shipping input[name="address_2"]').val(add2);
			$('#tab-shipping input[name="city"]').val(selcity);
			$('#tab-shipping input[name="postcode"]').val(selpostcode);
			$('#tab-shipping input[name="zone_id"]').val(selzoneid);
			$('#tab-shipping input[name="country_id"]').val(selcountryid);
			
			$('#tab-payment input[name="address_1"]').val(add1);
			$('#tab-payment input[name="address_2"]').val(add2);
			$('#tab-payment input[name="city"]').val(selcity);
			$('#tab-payment input[name="postcode"]').val(selpostcode);
			$('#tab-payment input[name="zone_id"]').val(selzoneid);
			$('#tab-payment input[name="country_id"]').val(selcountryid);
			
			<?php } ?>
			
			$('#button-refresh').trigger('click');
			$('#button-payment-address').trigger('click');
			$('#button-shipping-address').trigger('click');
			
		},
		error: function(xhr, ajaxOptions, thrownError) {
			alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
		}
	});
});

//$('select[name=\'shippingaddress\']').trigger('change');		
		
		</script>
 <script type="text/javascript">
 
 var shipping_zone_id = '<?php echo $shipping_zone_id; ?>';
 $('#newadbook select[name=\'country_id\']').on('change', function() {
	$.ajax({
		url: 'index.php?route=localisation/country/country&token=<?php echo $token; ?>&country_id=' + this.value,
		dataType: 'json',
		beforeSend: function() {
			$('#newadbook select[name=\'country_id\']').after(' <i class="fa fa-circle-o-notch fa-spin"></i>');
		},
		complete: function() {
			$('#newadbook .fa-spin').remove();
		},
		success: function(json) {
			if (json['postcode_required'] == '1') {
				$('#newadbook input[name=\'postcode\']').closest('.form-group').addClass('required');
			} else {
				$('#newadbook input[name=\'postcode\']').closest('.form-group').removeClass('required');
			}

			html = '<option value=""><?php echo $text_select; ?></option>';

			if (json['zone'] && json['zone'] != '') {
				for (i = 0; i < json['zone'].length; i++) {
        			html += '<option value="' + json['zone'][i]['zone_id'] + '"';

					if (json['zone'][i]['zone_id'] == shipping_zone_id) {
	      				html += ' selected="selected"';
	    			}

	    			html += '>' + json['zone'][i]['name'] + '</option>';
				}
			} else {
				html += '<option value="0" selected="selected"><?php echo $text_none; ?></option>';
			}

			$('#newadbook select[name=\'zone_id\']').html(html);
		},
		error: function(xhr, ajaxOptions, thrownError) {
			alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
		}
	});
});

$('#newadbook select[name=\'country_id\']').trigger('change');
 
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
				location.reload();
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

$(document).ready(function(){

setTimeout(function() {
       
if(token)
{				
				
				$.ajax({
					url: '<?php echo $catalog; ?>index.php?route=api/customer&token=' + token + '&store_id=0',
					type: 'post',
					data: $('#tab-customer input[type=\'text\'], #tab-customer input[type=\'hidden\'], #tab-customer input[type=\'radio\']:checked, #tab-customer input[type=\'checkbox\']:checked, #tab-customer select, #tab-customer textarea'),
					dataType: 'json',
					crossDomain: true,
					beforeSend: function() {
						$('#button-customer').button('loading');
					},
					complete: function() {
						 $('#button-customer').button('reset');
					},
					success: function(json) {
						$('.alert, .text-danger').remove();
						$('.form-group').removeClass('has-error');
			
						if (json['error']) {
							if (json['error']['warning']) {
								$('#content > .container-fluid').prepend('<div class="alert alert-danger"><i class="fa fa-exclamation-circle"></i> ' + json['error']['warning'] + ' <button type="button" class="close" data-dismiss="alert">&times;</button></div>');
							}
			
							for (i in json['error']) { 
								if(i == 'customer_contact_id')
								{
									var element = $('#customer_contact_id');
									var txt = '<div class="text-danger">' + json['error'][i] + '</div>';
									
									$('#input-customer_contact_id').after(txt);
									
								}
								else
								{
									var element = $('#input-' + i.replace('_', '-'));
				
									if (element.parent().hasClass('input-group')) {
										$(element).parent().after('<div class="text-danger">' + json['error'][i] + '</div>');
									} else {
										$(element).after('<div class="text-danger">' + json['error'][i] + '</div>');
									}
								}
							}
			
							// Highlight any found errors
							$('.text-danger').parentsUntil('.form-group').parent().addClass('has-error');
						} else {
							// Refresh products, vouchers and totals
							var request_1 = $.ajax({
								url: '<?php echo $catalog; ?>index.php?route=api/cart/add&token=' + token + '&store_id=0',
								type: 'post',
								data: $('#cart input[name^=\'product\'][type=\'text\'], #cart input[name^=\'product\'][type=\'hidden\'], #cart input[name^=\'product\'][type=\'radio\']:checked, #cart input[name^=\'product\'][type=\'checkbox\']:checked, #cart select[name^=\'product\'], #cart textarea[name^=\'product\']'),
								dataType: 'json',
								crossDomain: true,
								beforeSend: function() {
									$('#button-product-add').button('loading');
								},
								complete: function() {
									$('#button-product-add').button('reset');
								},
								success: function(json) {
									$('.alert, .text-danger').remove();
									$('.form-group').removeClass('has-error');
									$('#button-refresh').trigger('click');
									if (json['error'] && json['error']['warning']) {
										$('#content > .container-fluid').prepend('<div class="alert alert-danger"><i class="fa fa-exclamation-circle"></i> ' + json['error']['warning'] + ' <button type="button" class="close" data-dismiss="alert">&times;</button></div>');
									}
								},
								error: function(xhr, ajaxOptions, thrownError) {
									alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
								}
							});
			
							
							
						}
					},
					error: function(xhr, ajaxOptions, thrownError) {
						alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
					}
				});
				
				$.ajax({
				url: '<?php echo $catalog; ?>index.php?route=api/currency&token=' + token + '&store_id=0',
				type: 'post',
				data: 'currency=ZAR',
				dataType: 'json',
				crossDomain: true,
				beforeSend: function() {
					$('select[name=\'currency\']').after(' <i class="fa fa-circle-o-notch fa-spin"></i>');
				},
				complete: function() {
					$('.fa-spin').remove();
				},
				success: function(json) {
					$('.alert, .text-danger').remove();
					$('.form-group').removeClass('has-error');
		
					if (json['error']) {
						$('#content > .container-fluid').prepend('<div class="alert alert-danger"><i class="fa fa-exclamation-circle"></i> ' + json['error'] + ' <button type="button" class="close" data-dismiss="alert">&times;</button></div>');
		
						
					}
				},
				error: function(xhr, ajaxOptions, thrownError) {
					alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
				}
			});
		
		$('select[name=\'shippingaddress\']').trigger('change');
		
		
	}			
				
    }, 1000);

});
   

$('#cart').delegate('.btn-danger', 'click', function() {
	var node = this;

	$.ajax({
		url: '<?php echo $catalog; ?>index.php?route=api/cart/remove&token=' + token + '&store_id=0',
		type: 'post',
		data: 'key=' + encodeURIComponent(this.value),
		dataType: 'json',
		crossDomain: true,
		beforeSend: function() {
			$(node).button('loading');
		},
		complete: function() {
			$(node).button('reset');
		},
		success: function(json) {
			$('.alert, .text-danger').remove();

			// Check for errors
			if (json['error']) {
				$('#content > .container-fluid').prepend('<div class="alert alert-danger"><i class="fa fa-exclamation-circle"></i> ' + json['error'] + ' <button type="button" class="close" data-dismiss="alert">&times;</button></div>');
			} else { 
				// Refresh products, vouchers and totals
				$('#button-refresh').trigger('click');
				
				$('#button-payment-address').trigger('click');
				$('#button-shipping-address').trigger('click');
				
			}
		},
		error: function(xhr, ajaxOptions, thrownError) {
			alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
		}
	});
});

$('#cart').delegate('.btn-primary', 'click', function() {
    var node = this;

    // Refresh products, vouchers and totals
    $.ajax({
        url: '<?php echo $catalog; ?>index.php?route=api/cart/add&token=' + token + '&store_id=0',
        type: 'post',
        data: $('#cart input[name^=\'product\'][type=\'text\'], #cart input[name^=\'product\'][type=\'hidden\'], #cart input[name^=\'product\'][type=\'radio\']:checked, #cart input[name^=\'product\'][type=\'checkbox\']:checked, #cart select[name^=\'product\'], #cart textarea[name^=\'product\']'),
        dataType: 'json',
        crossDomain: true,
        beforeSend: function() {
            $(node).button('loading');
        },
        complete: function() {
            $(node).button('reset');
        },
        success: function(json) {
            $('.alert, .text-danger').remove();
            $('.form-group').removeClass('has-error');

            if (json['error'] && json['error']['warning']) {
                $('#content > .container-fluid').prepend('<div class="alert alert-danger"><i class="fa fa-exclamation-circle"></i> ' + json['error']['warning'] + ' <button type="button" class="close" data-dismiss="alert">&times;</button></div>');
            }

            if (json['success']) {
				$('#content > .container-fluid').prepend('<div class="alert alert-success"><i class="fa fa-check-circle"></i> ' + json['success'] + ' <button type="button" class="close" data-dismiss="alert">&times;</button></div>');
			}
        },
        error: function(xhr, ajaxOptions, thrownError) {
            alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
        }
    }).done(function() {
        $('#button-refresh').trigger('click');
    });
});

// Add all products to the cart using the api
$('#button-refresh').on('click', function() {
	$.ajax({
		url: '<?php echo $catalog; ?>index.php?route=api/cart/products&token=' + token + '&store_id=0',
		dataType: 'json',
		crossDomain: true,
		success: function(json) {
			$('.alert-danger, .text-danger').remove();

			// Check for errors
			if (json['error']) {
				if (json['error']['warning']) {
					$('#content > .container-fluid').prepend('<div class="alert alert-danger"><i class="fa fa-exclamation-circle"></i> ' + json['error']['warning'] + ' <button type="button" class="close" data-dismiss="alert">&times;</button></div>');
				}

				if (json['error']['stock']) {
					$('#content > .container-fluid').prepend('<div class="alert alert-danger"><i class="fa fa-exclamation-circle"></i> ' + json['error']['stock'] + '</div>');
				}

				if (json['error']['minimum']) {
					for (i in json['error']['minimum']) {
						$('#content > .container-fluid').prepend('<div class="alert alert-danger"><i class="fa fa-exclamation-circle"></i> ' + json['error']['minimum'][i] + ' <button type="button" class="close" data-dismiss="alert">&times;</button></div>');
					}
				}
			}

			var shipping = false;

			html = '';

			if (json['products'].length) {
				for (i = 0; i < json['products'].length; i++) {
					product = json['products'][i];

					html += '<tr>';
					html += '  <td class="text-left"><img src="' + product['image'] + '" alt="' + product['name'] + '" class="img-thumbnail" /></td>';
					html += '  <td class="text-left">' + product['name'] + ' ' + (!product['stock'] ? '<span class="text-danger">***</span>' : '') + '<br />';
					html += '  <input type="hidden" name="product[' + i + '][product_id]" value="' + product['product_id'] + '" />';

					if (product['option']) {
						for (j = 0; j < product['option'].length; j++) {
							option = product['option'][j];

							html += '  - <small>' + option['name'] + ': ' + option['value'] + '</small><br />';

							if (option['type'] == 'select' || option['type'] == 'radio' || option['type'] == 'image') {
								html += '<input type="hidden" name="product[' + i + '][option][' + option['product_option_id'] + ']" value="' + option['product_option_value_id'] + '" />';
							}

							if (option['type'] == 'checkbox') {
								html += '<input type="hidden" name="product[' + i + '][option][' + option['product_option_id'] + '][]" value="' + option['product_option_value_id'] + '" />';
							}

							if (option['type'] == 'text' || option['type'] == 'textarea' || option['type'] == 'file' || option['type'] == 'date' || option['type'] == 'datetime' || option['type'] == 'time') {
								html += '<input type="hidden" name="product[' + i + '][option][' + option['product_option_id'] + ']" value="' + option['value'] + '" />';
							}
						}
					}

					html += '</td>';
					html += '  <td class="text-left">' + product['model'] + '</td>';
					html += '  <td class="text-right"><div class="input-group btn-block" style="max-width: 200px;"><input type="text" name="product[' + i + '][quantity]" value="' + product['quantity'] + '" class="form-control" /><span class="input-group-btn"><button type="button" data-toggle="tooltip" title="<?php echo $button_refresh; ?>" data-loading-text="<?php echo $text_loading; ?>" class="btn btn-primary"><i class="fa fa-refresh"></i></button></span></div></td>';
                    html += '  <td class="text-right">' + product['price'] + '</td>';
					html += '  <td class="text-right">' + product['total'] + '</td>';
					html += '  <td class="text-center" style="width: 3px;"><button type="button" value="' + product['cart_id'] + '" data-toggle="tooltip" title="<?php echo $button_remove; ?>" data-loading-text="<?php echo $text_loading; ?>" class="btn btn-danger"><i class="fa fa-minus-circle"></i></button></td>';
					html += '</tr>';

					if (product['shipping'] != 0) {
						shipping = true;
					}
				}
				if (json['totals'].length) {
					
					for (i = 0; i < json['totals'].length; i++) {
						tot = json['totals'][i];
						html += '<tr>';
						html += '<td colspan="5" class="text-right">' + tot['title'] + '</td>';
						html += '<td class="text-right" colspan="2" style="text-align:center;">' + tot['text'] + '</td>';
						html += '</tr>';
					}
				
			
			}			
				
				$('#button-cart').removeAttr('disabled');
			}
			
			if (json['error']) {
				if (json['error']['warning']) {
					$('#button-cart').attr('disabled','disabled');
				}

				if (json['error']['stock']) {
					$('#button-cart').attr('disabled','disabled');
				}

				if (json['error']['minimum']) {
					for (i in json['error']['minimum']) {
						$('#button-cart').attr('disabled','disabled');
					}
				}
			}

			if (!shipping) {
				$('select[name=\'shipping_method\'] option').removeAttr('selected');
				$('select[name=\'shipping_method\']').prop('disabled', true);
				$('#button-shipping-method').prop('disabled', true);
			} else {
				$('select[name=\'shipping_method\']').prop('disabled', false);
				$('#button-shipping-method').prop('disabled', false);
			}

			if (!json['products'].length && !json['vouchers'].length) {
				html += '<tr>';
				html += '  <td colspan="6" class="text-center"><?php echo $text_no_results; ?></td>';
				html += '</tr>';
			}

			$('#cart').html(html);

			// Totals
			html = '';

			if (json['products'].length) {
				for (i = 0; i < json['products'].length; i++) {
					product = json['products'][i];

					html += '<tr>';
					html += '  <td class="text-left">' + product['name'] + ' ' + (!product['stock'] ? '<span class="text-danger">***</span>' : '') + '<br />';

					if (product['option']) {
						for (j = 0; j < product['option'].length; j++) {
							option = product['option'][j];

							html += '  - <small>' + option['name'] + ': ' + option['value'] + '</small><br />';
						}
					}

					html += '  </td>';
					html += '  <td class="text-left">' + product['model'] + '</td>';
					html += '  <td class="text-right">' + product['quantity'] + '</td>';
					html += '  <td class="text-right">' + product['price'] + '</td>';
					html += '  <td class="text-right">' + product['total'] + '</td>';
					html += '</tr>';
				}
			}

			if (json['vouchers'].length) {
				for (i in json['vouchers']) {
					voucher = json['vouchers'][i];

					html += '<tr>';
					html += '  <td class="text-left">' + voucher['description'] + '</td>';
					html += '  <td class="text-left"></td>';
					html += '  <td class="text-right">1</td>';
					html += '  <td class="text-right">' + voucher['amount'] + '</td>';
					html += '  <td class="text-right">' + voucher['amount'] + '</td>';
					html += '</tr>';
				}
			}

			if (json['totals'].length) {
				for (i in json['totals']) {
					total = json['totals'][i];

					html += '<tr>';
					html += '  <td class="text-right" colspan="4">' + total['title'] + ':</td>';
					html += '  <td class="text-right" colspan="2" style="text-align:center;">' + total['text'] + '</td>';
					html += '</tr>';
				}
			}

			if (!json['totals'].length && !json['products'].length && !json['vouchers'].length) {
				html += '<tr>';
				html += '  <td colspan="5" class="text-center"><?php echo $text_no_results; ?></td>';
				html += '</tr>';
			}

			$('#total').html(html);
		},
		error: function(xhr, ajaxOptions, thrownError) {
			alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
		}
	});
});

$('#button-payment-address').on('click', function() {
	$.ajax({
		url: '<?php echo $catalog; ?>index.php?route=api/payment/address&token=' + token + '&store_id=0',
		type: 'post',
		data: $('#tab-payment input[type=\'text\'], #tab-payment input[type=\'hidden\'], #tab-payment input[type=\'radio\']:checked, #tab-payment input[type=\'checkbox\']:checked, #tab-payment select, #tab-payment textarea'),
		dataType: 'json',
		crossDomain: true,
		beforeSend: function() {
			$('#button-payment-address').button('loading');
		},
		complete: function() {
			$('#button-payment-address').button('reset');
		},
		success: function(json) {
			console.log(json);
			$('.alert, .text-danger').remove();
			$('.form-group').removeClass('has-error');

			// Check for errors
			if (json['error']) {
				if (json['error']['warning']) {
					$('#content > .container-fluid').prepend('<div class="alert alert-danger"><i class="fa fa-exclamation-circle"></i> ' + json['error']['warning'] + ' <button type="button" class="close" data-dismiss="alert">&times;</button></div>');
				}

				for (i in json['error']) {
					var element = $('#input-payment-' + i.replace('_', '-'));

					if ($(element).parent().hasClass('input-group')) {
						$(element).parent().after('<div class="text-danger">' + json['error'][i] + '</div>');
					} else {
						$(element).after('<div class="text-danger">' + json['error'][i] + '</div>');
					}
				}

				// Highlight any found errors
				$('.text-danger').parentsUntil('.form-group').parent().addClass('has-error');
			} else {
				// Payment Methods
				$.ajax({
					url: '<?php echo $catalog; ?>index.php?route=api/payment/methods&token=' + token + '&store_id=0',
					dataType: 'json',
					crossDomain: true,
					beforeSend: function() {
						$('#button-payment-address').button('loading');
					},
					complete: function() {
						$('#button-payment-address').button('reset');
					},
					success: function(json) {
						if (json['error']) {
							$('#content > .container-fluid').prepend('<div class="alert alert-danger"><i class="fa fa-exclamation-circle"></i> ' + json['error'] + ' <button type="button" class="close" data-dismiss="alert">&times;</button></div>');
						} else {
							html = '<option value=""><?php echo $text_select; ?></option>';

							if (json['payment_methods']) {
								for (i in json['payment_methods']) {
									if (json['payment_methods'][i]['code'] == $('select[name=\'payment_method\'] option:selected').val()) {
										html += '<option value="' + json['payment_methods'][i]['code'] + '" selected="selected">' + json['payment_methods'][i]['title'] + '</option>';
									} else {
										html += '<option value="' + json['payment_methods'][i]['code'] + '">' + json['payment_methods'][i]['title'] + '</option>';
									}
								}
							}
	
							$('select[name=\'payment_method\']').html(html);
							$('select[name=\'payment_method\']').trigger('change');
						}
					},
					error: function(xhr, ajaxOptions, thrownError) {
						alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
					}
				}).done(function() {
                    // Refresh products, vouchers and totals
    				$('#button-refresh').trigger('click');

    				// If shipping required got to shipping tab else total tabs
    				if ($('select[name=\'shipping_method\']').prop('disabled')) {
    					$('a[href=\'#tab-total\']').tab('show');
    				} else {
    					$('a[href=\'#tab-shipping\']').tab('show');
    				}
                });
			}
		},
		error: function(xhr, ajaxOptions, thrownError) {
			alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
		}
	});
});

$('#button-shipping-address').on('click', function() {
	$.ajax({
		url: '<?php echo $catalog; ?>index.php?route=api/shipping/address&token=' + token + '&store_id=0',
		type: 'post',
		data: $('#tab-shipping input[type=\'text\'], #tab-shipping input[type=\'hidden\'], #tab-shipping input[type=\'radio\']:checked, #tab-shipping input[type=\'checkbox\']:checked, #tab-shipping select, #tab-shipping textarea'),
		dataType: 'json',
		crossDomain: true,
		beforeSend: function() {
			$('#button-shipping-address').button('loading');
		},
		complete: function() {
			$('#button-shipping-address').button('reset');
		},
		success: function(json) {
			$('.alert, .text-danger').remove();
			$('.form-group').removeClass('has-error');

			// Check for errors
			if (json['error']) {
				if (json['error']['warning']) {
					$('#content > .container-fluid').prepend('<div class="alert alert-danger"><i class="fa fa-exclamation-circle"></i> ' + json['error']['warning'] + ' <button type="button" class="close" data-dismiss="alert">&times;</button></div>');
				}

				for (i in json['error']) {
					var element = $('#input-shipping-' + i.replace('_', '-'));

					if ($(element).parent().hasClass('input-group')) {
						$(element).parent().after('<div class="text-danger">' + json['error'][i] + '</div>');
					} else {
						$(element).after('<div class="text-danger">' + json['error'][i] + '</div>');
					}
				}

				// Highlight any found errors
				$('.text-danger').parentsUntil('.form-group').parent().addClass('has-error');
			} else {
				// Shipping Methods
				var request = $.ajax({
					url: '<?php echo $catalog; ?>index.php?route=api/shipping/methods&token=' + token + '&store_id=0',
					dataType: 'json',
					beforeSend: function() {
						$('#button-shipping-address').button('loading');
					},
					complete: function() {
						$('#button-shipping-address').button('reset');
					},
					success: function(json) {
						if (json['error']) {
							$('#content > .container-fluid').prepend('<div class="alert alert-danger"><i class="fa fa-exclamation-circle"></i> ' + json['error'] + ' <button type="button" class="close" data-dismiss="alert">&times;</button></div>');
						} else { 
							// Shipping Methods
							html = '';
							html = '<option value=""><?php echo $text_select; ?></option>';

							if (json['shipping_methods']) {
								for (i in json['shipping_methods']) {
									html += '<optgroup label="' + json['shipping_methods'][i]['title'] + '">';

									if (!json['shipping_methods'][i]['error']) {
										for (j in json['shipping_methods'][i]['quote']) {
											if (json['shipping_methods'][i]['quote'][j]['code'] == $('select[name=\'shipping_method\'] option:selected').val()) {
												html += '<option value="' + json['shipping_methods'][i]['quote'][j]['code'] + '" selected="selected">' + json['shipping_methods'][i]['quote'][j]['title'] + ' - ' + json['shipping_methods'][i]['quote'][j]['text'] + '</option>';
											} else {
												html += '<option value="' + json['shipping_methods'][i]['quote'][j]['code'] + '">' + json['shipping_methods'][i]['quote'][j]['title'] + ' - ' + json['shipping_methods'][i]['quote'][j]['text'] + '</option>';
											}
										}
									} else {
										html += '<option value="" style="color: #F00;" disabled="disabled">' + json['shipping_method'][i]['error'] + '</option>';
									}

									html += '</optgroup>';
								}
							}

							$('select[name=\'shipping_method\']').html(html);
							$('select[name=\'shipping_method\']').trigger('change');
		
						}
					},
					error: function(xhr, ajaxOptions, thrownError) {
						alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
					}
				}).done(function() {
				    // Refresh products, vouchers and totals
				    $('#button-refresh').trigger('click');

                    $('a[href=\'#tab-total\']').tab('show');
                });
			}
		},
		error: function(xhr, ajaxOptions, thrownError) {
			alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
		}
	});
});

$('#button-save').on('click', function() {
	
	$('.alert, .text-danger').remove();
	
	<?php if($customer_id > '0' ) { ?>
	if ($('select[name=\'shippingaddress\']').val() == '') {
		$('#content > .container-fluid').prepend('<div class="alert alert-danger"><i class="fa fa-exclamation-circle"></i> Please Select Shipping Address. <button type="button" class="close" data-dismiss="alert">&times;</button></div>');
		return false;
	} 
	<?php } ?>
	if ($('input[name=\'order_id\']').val() == 0) {
		var url = '<?php echo $catalog; ?>index.php?route=api/order/add&token=' + token + '&store_id=0';
	} else {
		var url = '<?php echo $catalog; ?>index.php?route=api/order/edit&token=' + token + '&store_id=0&order_id=' + $('input[name=\'order_id\']').val();
	}

	$.ajax({
		url: url,
		type: 'post',
		data: $('select[name=\'payment_method\'] option:selected,  select[name=\'shipping_method\'] option:selected,  input[name=\'order_status_id\'], #tab-total select, textarea[name=\'comment\'], #tab-total input[name=\'affiliate_id\']'),
		dataType: 'json',
		crossDomain: true,
		beforeSend: function() {
			$('#button-save').button('loading');
		},
		complete: function() {
			$('#button-save').button('reset');
		},
		success: function(json) {
			$('.alert, .text-danger').remove();

			if (json['error']) {
				$('#content > .container-fluid').prepend('<div class="alert alert-danger"><i class="fa fa-exclamation-circle"></i> ' + json['error'] + ' <button type="button" class="close" data-dismiss="alert">&times;</button></div>');
			}

			if (json['success']) {
				//$('#content > .container-fluid').prepend('<div class="alert alert-success"><i class="fa fa-check-circle"></i> ' + json['success'] + '  <button type="button" class="close" data-dismiss="alert">&times;</button></div>');

                // Refresh products, vouchers and totals
				//$('#button-refresh').trigger('click');
				var url = 'index.php?route=sale/order/info&token=<?php echo $token; ?>&order_id=<?php echo $order_id; ?>';
				window.location = url;
            }

			if (json['order_id']) {
				$('input[name=\'order_id\']').val(json['order_id']);
			}
		},
		error: function(xhr, ajaxOptions, thrownError) {
			alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
		}
	});
});

// Shipping Method

$('select[name=\'shipping_method\']').on('change', function() {
//$('#button-shipping-method').on('click', function() {
	$.ajax({
		url: '<?php echo $catalog; ?>index.php?route=api/shipping/method&token=' + token + '&store_id=0',
		type: 'post',
		data: 'shipping_method=' + $('select[name=\'shipping_method\'] option:selected').val(),
		dataType: 'json',
		crossDomain: true,
		beforeSend: function() {
			$('#button-shipping-method').button('loading');
		},
		complete: function() {
			$('#button-shipping-method').button('reset');
		},
		success: function(json) {
			$('.alert, .text-danger').remove();
			$('.form-group').removeClass('has-error');

			if (json['error']) {
				$('#content > .container-fluid').prepend('<div class="alert alert-danger"><i class="fa fa-exclamation-circle"></i> ' + json['error'] + ' <button type="button" class="close" data-dismiss="alert">&times;</button></div>');

				// Highlight any found errors
				$('select[name=\'shipping_method\']').closest('.form-group').addClass('has-error');
			}

			if (json['success']) {
				$('#content > .container-fluid').prepend('<div class="alert alert-success"><i class="fa fa-check-circle"></i> ' + json['success'] + ' <button type="button" class="close" data-dismiss="alert">&times;</button></div>');

				// Refresh products, vouchers and totals
				$('#button-refresh').trigger('click');
			}
		},
		error: function(xhr, ajaxOptions, thrownError) {
			alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
		}
	});
});

// Payment Method

$('select[name=\'payment_method\']').on('change', function() {
//$('#button-payment-method').on('click', function() {
	$.ajax({
		url: '<?php echo $catalog; ?>index.php?route=api/payment/method&token=' + token + '&store_id=0',
		type: 'post',
		data: 'payment_method=' + $('select[name=\'payment_method\'] option:selected').val(),
		dataType: 'json',
		crossDomain: true,
		beforeSend: function() {
			$('#button-payment-method').button('loading');
		},
		complete: function() {
			$('#button-payment-method').button('reset');
		},
		success: function(json) {
			$('.alert, .text-danger').remove();
			$('.form-group').removeClass('has-error');

			if (json['error']) {
				$('#content > .container-fluid').prepend('<div class="alert alert-danger"><i class="fa fa-exclamation-circle"></i> ' + json['error'] + ' <button type="button" class="close" data-dismiss="alert">&times;</button></div>');

				// Highlight any found errors
				$('select[name=\'payment_method\']').closest('.form-group').addClass('has-error');
			}

			if (json['success']) {
				$('#content > .container-fluid').prepend('<div class="alert alert-success"><i class="fa fa-check-circle"></i> ' + json['success'] + ' <button type="button" class="close" data-dismiss="alert">&times;</button></div>');

				// Refresh products, vouchers and totals
				$('#button-refresh').trigger('click');
			}
		},
		error: function(xhr, ajaxOptions, thrownError) {
			alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
		}
	});
});

function ConfirmOrderCancel(action, msg)
{ 
  var x = confirm(msg);
  if (x)
  { 
  
  	$.ajax({
		url: '<?php echo $catalog; ?>index.php?route=api/order/history&token=' + token + '&store_id=0&order_id=<?php echo $order_id; ?>',
		type: 'post',
		dataType: 'json',
		data: 'order_status_id=7&notify=0&override=0&append=0&comment=',
		success: function(json) {
			var url = 'index.php?route=sale/order&token=<?php echo $token; ?>';
				window.location = url;
		},
		error: function(xhr, ajaxOptions, thrownError) {
			alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
		}
	});
  	
  }
  else 
  {
    return false;
 }
}

//--></script> 
</div>
<?php echo $footer; ?> 
