<?php echo $header; ?><?php echo $column_left; ?>
<div id="content" data-api-key="<?php echo $api_key; ?>" data-catalog="<?php echo $catalog; ?>" data-token="<?php echo $token; ?>" data-quote-id="<?php echo $quote_id; ?>" data-api-ip="<?php echo $api_id; ?>">
  <div class="page-header">
    <div class="container-fluid">
      <div class="pull-right">
      	<div style="float:left">
          <?php if ($qstatus == $quote_status_pending) :?>
          <button data-href="<?php echo $deny_url; ?>" id="button-deny" data-toggle="tooltip" title="Deny" style="float: right; font-family: Calibri;" class="btn btn-danger decline">
            <i class="fa fa-times"></i>
          </button>
          <button data-toggle="tooltip" id="button-save" title="Convert to Order" class="btn btn-success" style="float:right;margin-right:8px;font-family: Calibri;" disabled>
            <i class="fa fa-check"></i>
          </button>
          <?php endif; ?>
        </div>
        <div style="float:right;margin-left:8px;">
        <a href="<?php echo $cancel_url; ?>" data-toggle="tooltip" title="<?php echo $button_cancel; ?>" id="button-cancel" class="btn btn-default" style="float:right;">
          <i class="fa fa-reply"></i>
        </a>
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

    <?php if ($qstatus == $quote_status_denied) : ?>
    <div class="alert alert-danger">
      <h4><i class="fa fa-exclamation-triangle"></i> <strong>Reason for denying this quote:</strong> "<?php echo $comment; ?>"</h4>
    </div>
    <?php endif; ?>
  	
    <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" id="form-user" class="form-horizontal">
    <input type="hidden" id="button-refresh" />
    <input type="hidden" id="button-payment-address" />
    <input type="hidden" id="button-shipping-address" />
    <input type="hidden" name="order_id" value="" />
    <input type="hidden" name="order_status_id" value="<?php echo $order_status_id; ?>" />
    <input type="hidden" name="text_select" value="<?php echo $text_select; ?>">
    
    <div id="tab-customer" style="display:none">
        <input type="hidden" name="currency" value="ZAR" />
        <input type="hidden" name="customer" value="<?php echo $firstname; ?>" />
        <input type="hidden" name="customer_group_id" value="<?php echo $customer_group_id; ?>" />
        <input type="hidden" name="customer_id" value="<?php echo $customer_id; ?>" />
        <input type="hidden" name="customer_contact_id" value="<?php echo $customer_contact_id; ?>" />
        <input type="hidden" name="email" value="<?php echo $email; ?>" />
        <input type="hidden" name="firstname" value="<?php echo $firstname; ?>" />
        <input type="hidden" name="lastname" value="<?php echo $firstname; ?>" />
        <input type="hidden" name="store_id" value="0" />
        <input type="hidden" name="telephone" value="<?php echo $telephone; ?>" />
        <?php if (!empty($custom_fields)) : ?>
        <?php foreach($custom_fields as $cfid => $cfval) : ?>
        <input type="hidden" name="custom_field[<?php echo $cfid; ?>]" value="<?php echo $cfval; ?>" />
        <?php endforeach; ?>
        <?php endif; ?>
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
        <h3 class="panel-title"><i class="fa fa-shopping-cart"></i> Quote Id : <strong>#<?php echo $quote_id; ?></strong></h3>
      </div>
      <div class="panel-body" style="padding-bottom:0px;">
    	
        <div class="row">
      <div class="col-md-4">
        <div class="panel panel-default" style="min-height:195px;">
          <div class="panel-heading" style="padding-left:5px;">
            <h4 class="panel-title"> Quote Information</h4>
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
                	<div class="col-md-5 rightalign1">Status : </div>
                    	<div class="col-md-7 paddingleft1">
                        <?php if ($qstatus == $quote_status_pending) : ?>
                          <b><a class="btn-warning quote-status" style="padding:2px 5px; border-radius:5px;"><?=$quote_status?></a></b>
                        <?php elseif ($qstatus == $quote_status_converted) :?>
                          <b><a class="btn-success quote-status" style="padding:2px 5px; border-radius:5px;"><?=$quote_status?></a></b>
                        <?php elseif ($qstatus == $quote_status_denied) :?>
                          <b><a class="btn-danger quote-status" style="padding:2px 5px; border-radius:5px;"><?=$quote_status?></a></b>
                        <?php endif; ?>
                      </div>
                      </span><br>
                <span class="ctm">
                	<div class="col-md-5 rightalign1">Total (<?php echo $currency_code; ?>) : </div> 
                    <div class="col-md-7 paddingleft1"><b><span id="total"><?php echo $totals; ?></span></b></div>
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
        
      </div>
    </div>

    <?php if ($qstatus == $quote_status_pending) : ?>
    <div class="panel panel-default" id="payment-shipping-details">
      <div class="panel-heading">
        <h3 class="panel-title"><i class="fa fa-info-circle"></i> Order Details</h3>
      </div>
      <div class="panel-body">
          <div class="form-group required">
            <label class="col-sm-2 control-label" for="input-username">Shipping Address</label>
            <div class="col-sm-10">
              <select name="shippingaddress" id="input-sales_manager" class="form-control">
                <option value=""><?php echo $text_select; ?></option>
                <?php foreach ($addresses as $address) : ?>
              	<?php if ($address['address_id'] == $address_id) : ?>
                <option value="<?php echo $address['address_id']; ?>" selected="selected"><?php echo $address['address_1'] .' '. $address['address_2'] . ', ' . $address['city'] . ', ' . $address['zone']. ', ' . $address['country']; ?></option>
                <?php else : ?>
                <option value="<?php echo $address['address_id']; ?>"><?php echo $address['address_1'] .' '. $address['address_2'] . ', ' . $address['city'] . ', ' . $address['zone']. ', ' . $address['country']; ?></option>
                <?php endif; ?>
                <?php endforeach; ?>
              </select>
              <div style="width:100%;float:left;">
              	<a id="addNewAddress" class="btn" style="padding-left:0px;" ><i class="fa fa-plus"></i> Add New Address</a>
              	
              </div>
            </div>
          </div>
          
     
          
          <div class="form-group">
            <label class="col-sm-2 control-label" for="input-username">Invoice to Shipping Address</label>
            <div class="col-sm-10">
              <input type="checkbox" id="invoice_to_shipping" name="" class="form-control" />
            </div>
          </div>
          <div class="form-group required">
            <label class="col-sm-2 control-label" for="input-shipping_method">Shipping Method</label>
            <div class="col-sm-10">
              <select id="input-shipping_method" name="shipping_method" class="form-control">
                <option value=""><?php echo $text_select; ?></option>
                	
              </select>
            </div>
          </div>
          
          <div class="form-group required">
            <label class="col-sm-2 control-label" for="input-payment_method">Payment Method</label>
            <div class="col-sm-10">
              <select id="input-payment_method" name="payment_method" class="form-control">
                <option value="">Payment Method</option>
                	
              </select>
            </div>
          </div>
          
          <div class="form-group">
            <label class="col-sm-2 control-label" for="input-comment">Comment</label>
            <div class="col-sm-10">
              <textarea id="input-comment" class="form-control" name="comment" value="<?php echo $comments; ?>"></textarea>
            </div>
          </div>
        
      </div>
    </div>
    <?php endif; ?>

    <div class="panel panel-default">
      <div class="panel-body">
        <?php if ($qstatus == $quote_status_pending) : ?>
        <div id="product-list-table" class="table-responsive">
          <?php if ($access) : 
          /***************************************************
           * START: 
           * DO NOT REMOVE CODE BELOW THIS COMMENT
           * - Loop through quote products and store them
           *   into hidden <ul> list.
           ***************************************************/
          ?>
            <?php if (!empty($products)) : ?>
            <?php foreach ($products as $product) : ?>
              <ul style="display:none">
                <li data-product-id="<?=$product['product_id']?>" data-quantity="<?=$product['quantity']?>"></li>
              </ul>
            <?php endforeach; ?>
          <?php endif; 
          /***************************************************
           * DO NOT REMOVE CODE ABOVE THIS COMMENT
           * END
           ***************************************************/
          ?>
          <table class="table table-bordered">
            <thead>
              <tr>
                <th class="text-left"><?php echo $column_image; ?></th>
                <th class="text-left"><?php echo $column_product; ?></th>
                <th class="text-left"><?php echo $column_model; ?></th>
                <th class="text-right"><?php echo $column_quantity; ?></th>
                <th class="text-right"><?php echo $column_price; ?></th>
                <th class="text-right"><?php echo $column_total; ?></th>
              </tr>
            </thead>
            <tbody></tbody>
            <tfoot></tfoot>
          </table>
          <?php endif;?>
        </div>
        <?php else : ?>
        <table class="table table-bordered">
            <thead>
              <tr>
                <th class="text-left"><?php echo $column_image; ?></th>
                <th class="text-left"><?php echo $column_product; ?></th>
                <th class="text-left"><?php echo $column_model; ?></th>
                <th class="text-right"><?php echo $column_quantity; ?></th>
                <th class="text-right"><?php echo $column_price; ?></th>
                <th class="text-right"><?php echo $column_total; ?></th>
              </tr>
            </thead>
            <?php if (!empty($products)) : ?>
            <tbody>
              <?php foreach ($products as $product) : ?>
              <tr>
                <td class="text-left"><img src="<?php echo $product['image']; ?>" /></td>
                <td class="text-left"><?php echo $product['name']; ?></td>
                <td class="text-left"><?php echo $product['model']; ?></td>
                <td class="text-right"><?php echo $product['quantity']; ?></td>
                <td class="text-right"><?php echo $product['price']; ?></td>
                <td class="text-right"><?php echo $product['total']; ?></td>
              </tr>
              <?php endforeach; ?>
            </tbody>
            <tfoot>
              <tr>
                <th class="text-right" colspan="5">Total</th>
                <th class="text-left" colspan="2"><?php echo $totals; ?></th>
              </tr>
            </tfoot>
            <?php endif; ?>
          </table>
        <?php endif; ?>
      </div>
    </div>
    
    </form>
    
  </div>
  <div id="myModaldeny" class="modal fade" role="dialog">
    <form action="<?php echo $decline; ?>" method="post" enctype="multipart/form-data" id="form-popup">
    <input type="hidden" name="quote_id" id="popupquote_id" value=""  />
    <input type="hidden" name="redirto" value="<?php echo $redirto; ?>"  />
    <div class="modal-dialog">
  
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Confirm Decline</h4>
        </div>
        <div class="modal-body">
          <p><strong>Please Enter your reasons for declining the quote inside the following box</strong> </p>
          <textarea name="reason" rows="5" placeholder="Please Enter Reason" id="reason" class="form-control"></textarea>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-primary" id="Decline">Confirm</button>
          <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
        </div>
      </div>
  
    </div>
    </form>
  </div> 
  <div id="newAddressModal" class="modal fade" role="dialog">
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
          <button type="button" class="btn btn-primary submitBtn" id="submitAddressForm" >Save</button>
          <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
        </div>
      </div>
  
    </div>
    </form>
  </div>
</div>

<!-- Page loader -->
<div class="loader-wrapper">
  <div class="loader"></div>
</div>
<!-- /Page loader -->
<?php echo $footer; ?> 
