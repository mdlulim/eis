<?php echo $header; ?><?php echo $column_left; ?>
<div id="content" data-api-key="<?php echo $api_key; ?>" data-catalog="<?php echo $catalog; ?>" data-token="<?php echo $token; ?>" data-order-id="<?php echo $order_id; ?>">
  <div class="page-header">
    <div class="container-fluid">
      <div class="pull-right">
        <div style="float:left">
          <button type="button" data-toggle="tooltip" id="button-confirm" title="Confirm Order" class="btn btn-success" disabled="disabled">
            <i class="fa fa-check"></i>&nbsp;
            Confirm Order
          </button>
        </div>
        <div style="float:right;margin-left:8px;">
          <a href="<?php echo $back_url; ?>" data-toggle="tooltip" title="Back" class="btn btn-default" style="float:right;">
            <i class="fa fa-reply"></i>
          </a>
        </div>
        <div style="float:right;margin-left:8px;">
          <a href="<?php echo $cancel_url; ?>" data-toggle="tooltip" id="button-cancel" title="<?php echo $button_cancel; ?>" class="btn btn-danger" style="float:right;">
            <i class="fa fa-times"></i>&nbsp;
            Discard
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

    <?php echo $products_out_of_stock_warning; ?>
    
    <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" id="form-user" class="form-horizontal">
    <input type="hidden" id="button-refresh" />
    <input type="hidden" id="button-payment-address" />
    <input type="hidden" id="button-shipping-address" />
    <input type="hidden" name="order_id" value="<?php echo $order_id?>" />
    <input type="hidden" name="order_status_id" value="<?php echo $order_status_id?>" />
    <input type="hidden" name="text_select" value="<?php echo $text_select?>">
    <input type="hidden" name="payment_code" value="<?php echo $payment_code; ?>">
    <input type="hidden" name="shipping_code" value="<?php echo $shipping_code; ?>">
    
    <div id="tab-customer" style="display:none">
        <input type="hidden" name="currency" value="<?php echo $currency_code; ?>" />
        <input type="hidden" name="customer" value="<?php echo $customer; ?>" />
        <input type="hidden" name="customer_group_id" value="<?php echo $customer_group_id; ?>" />
        <input type="hidden" name="customer_id" value="<?php echo $customer_id; ?>" />
        <input type="hidden" name="customer_contact_id" value="<?php echo @$customer_contact_id; ?>" />
        <input type="hidden" name="email" value="<?php echo $email; ?>" />
        <input type="hidden" name="firstname" value="<?php echo $firstname; ?>" />
        <input type="hidden" name="lastname" value="<?php echo $lastname; ?>" />
        <input type="hidden" name="store_id" value="<?php echo $store_id; ?>" />
        <input type="hidden" name="telephone" value="<?php echo $telephone; ?>" />
         
    </div>
    
    <div id="tab-shipping" style="display:none">
        <input type="hidden" name="address_1" value="<?php echo $shipping_address_1; ?>" />
        <input type="hidden" name="address_2" value="<?php echo $shipping_address_2; ?>" />
        <input type="hidden" name="city" value="<?php echo $shipping_city; ?>" />
        <input type="hidden" name="company" value="<?php echo $shipping_company; ?>" />
        <input type="hidden" name="country_id" value="<?php echo $shipping_country_id; ?>" />
        <input type="hidden" name="firstname" value="<?php echo $shipping_firstname; ?>" />
        <input type="hidden" name="lastname" value="<?php echo $shipping_lastname; ?>" />
        <input type="hidden" name="postcode" value="<?php echo $shipping_postcode; ?>" />
        <input type="hidden" name="zone_id" value="<?php echo $shipping_zone_id; ?>" />
    </div>
    
    <div id="tab-payment" style="display:none">
        <input type="hidden" name="address_1" value="<?php echo $payment_address_1; ?>" />
        <input type="hidden" name="address_2"  value="<?php echo $payment_address_2; ?>" />
        <input type="hidden" name="city" value="<?php echo $payment_city; ?>" />
        <input type="hidden" name="company" value="<?php echo $payment_company; ?>" />
        <input type="hidden" name="country_id" value="<?php echo $payment_country_id; ?>" />
        <input type="hidden" name="firstname" value="<?php echo $payment_firstname; ?>" />
        <input type="hidden" name="lastname" value="<?php echo $payment_lastname; ?>" />
        <input type="hidden" name="postcode" value="<?php echo $payment_postcode; ?>" />
        <input type="hidden" name="zone_id" value="<?php echo $payment_zone_id; ?>" />
    </div>
    
    <div class="panel panel-default">
      <div class="panel-heading">
        <h3 class="panel-title"><i class="fa fa-shopping-cart"></i> New Order</h3>
      </div>
      <div class="panel-body" style="padding-bottom:0px;">
      
      <div class="row">
      <div class="col-md-4">
        <div class="panel panel-default" style="min-height:195px;">
          <div class="panel-heading" style="padding-left:5px;">
            <h4 class="panel-title"> Order Information</h4>
          </div>
          <div class="panel-body">
            <div class="row">
              <div class="col-md-5 text-right p-r-0">Channel :</div> 
              <div class="col-md-7">
                <b><a href="javascript:void(0)" style="color: #666;"><?php echo $channelname; ?></a></b>
              </div>
            </div>
            <div class="row" style="padding-top:5px;">
              <div class="col-md-5 text-right p-r-0">Sales Admin : </div>
              <div class="col-md-7"><b> <?php echo $user['firstname']; ?> <?php echo $user['lastname']; ?></b></div>
            </div>
            <div class="row" style="padding-top:5px;">
              <div class="col-md-5 text-right p-r-0">Status : </div>
              <div class="col-md-7">
                <?php if ($order_status_id == $order_statuses['pending']) : ?>
                <b><a class="btn-warning" style="padding:2px 5px;border-radius:5px;">Pending</a></b>
                <?php elseif ($order_status_id == $order_statuses['processing']) : ?>
                <b><a class="btn-default" style="padding:2px 5px;border-radius:5px;border:1px solid #000;">Processing</a></b>
                <?php elseif ($order_status_id == $order_statuses['confirmed']) : ?>
                <b><a class="btn-success" style="padding:2px 5px;border-radius:5px;">Order Confirmed</a></b>
                <?php elseif ($order_status_id == $order_statuses['cancelled']) : ?>
                <b><a class="btn-danger" style="padding:2px 5px;border-radius:5px;">Cancelled</a></b>
                <?php endif; ?>
              </div>
            </div>
            <div class="row" style="padding-top:5px;">
              <div class="col-md-5 text-right p-r-0">Total (<?php echo $currency_code; ?>) : </div> 
              <div class="col-md-7"><b><span id="total">0.00</span></b></div>
            </div>
          </div>
        </div>
      </div>
      <div class="col-md-4">
        <div class="panel panel-default" style="min-height:195px;">
          <div class="panel-heading" style="padding-left:5px;">
            <h4 class="panel-title">Customer Information</h4>
          </div>
          <div class="panel-body">
            <div class="row">
              <div class="col-md-5 text-right p-r-0">Customer : </div>
              <div class="col-md-7"><b> <?php echo $customer; ?></b></div>
            </div>
            <div class="row" style="padding-top:5px;">
              <div class="col-md-5 text-right p-r-0">Contract Pricing : </div>
              <div class="col-md-7"><b> <?php echo $customer_group; ?></b></div>
            </div>
            <div class="row" style="padding-top:5px;">
              <div class="col-md-5 text-right p-r-0">Email : </div>
              <div class="col-md-7"><b> <?php echo $email; ?></b></div>
            </div>
            <div class="row" style="padding-top:5px;">
              <div class="col-md-5 text-right p-r-0">Telephone : </div>
              <div class="col-md-7"><b> <?php echo $telephone; ?></b></div>
            </div>
            <div class="row" style="padding-top:5px;">
              <div class="col-md-5 text-right p-r-0">Address : </div>
              <div class="col-md-7" style="padding-right: 0px;"><b style="text-align: initial;"> <?php echo $customer_address['address_1']; ?>, <?php echo $customer_address['address_2']; ?> <?php echo $customer_address['city']; ?>, <?php echo $customer_address['zone']; ?>, <?php echo $customer_address['country']; ?></b></div>
            </div>
          </div>
        </div>
      </div>
      <div class="col-md-4">
        <div class="panel panel-default" style="min-height:195px;">
          <div class="panel-heading" style="padding-left:5px;">
            <h4 class="panel-title">Requested By</h4>
          </div>
          <div class="panel-body">
            <div class="row">
              <div class="col-md-5 text-right p-r-0">Customer Contact : </div>
              <div class="col-md-7"><b> <?php echo $contact['first_name']; ?> <?php echo $contact['last_name']; ?></b></div>
            </div>
            <div class="row" style="padding-top:5px;">
              <div class="col-md-5 text-right p-r-0">Email : </div>
              <div class="col-md-7"><b> <?php echo $contact['email']; ?></b></div>
            </div>
            <div class="row" style="padding-top:5px;">
              <div class="col-md-5 text-right p-r-0">Telephone : </div>
              <div class="col-md-7"><b> <?php echo $contact['telephone_number']; ?></b></div>
            </div>
            <div class="row" style="padding-top:5px;">
              <div class="col-md-5 text-right p-r-0">Order Date : </div>
              <div class="col-md-7"><b> <?php echo $order_date; ?></b></div>
            </div>
          </div>
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
            <label class="col-sm-2 control-label" for="input-shipping-address">Shipping Address</label>
            <div class="col-sm-10">
              <select name="shippingaddress" id="input-shipping-address" class="form-control">
                <option value="">Select Shipping Address</option>
                <?php foreach ($addresses as $address) : ?>
                  <?php if ($address['address_id'] == $shipaddress['address_id']) : ?>
                    <option value="<?=$address['address_id']?>" selected="selected"><?=$address['address_1'] .' '. $address['address_2'] . ', ' . $address['city'] . ', ' . $address['zone']. ', ' . $address['country']; ?></option>
                  <?php else : ?>
                    <option value="<?=$address['address_id']?>"><?=$address['address_1'] .' '. $address['address_2'] . ', ' . $address['city'] . ', ' . $address['zone']. ', ' . $address['country']; ?></option>
                  <?php endif; ?>
                <?php endforeach; ?>
              </select>
              <div style="width:100%;float:left;">
                <a id="addNewAddress" class="btn" style="padding-left:0px;" >
                  <i class="fa fa-plus"></i> Add New Address
                </a>
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
                <option value="">Shipping Method</option>
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
              <textarea id="input-comment" class="form-control" name="comment"><?=$comment?></textarea>
            </div>
          </div>
        
      </div>

      <div class="panel-footer">
        <div id="product-list-table" class="table-responsive" style="display:none">
          <hr>
          <ul style="display:none">
            <?php if (!empty($order_products)) :?>
              <?php foreach($order_products as $product) : ?>
              <li data-product-id="<?php echo $product['product_id']?>" data-quantity="<?php echo $product['quantity']?>"><?php echo $product['name']?></li>
              <?php endforeach; ?>
            <?php endif; ?>
          </ul>
          <table class="table table-bordered">
            <thead>
              <tr>
                <th class="text-left"><?php echo $column_image; ?></th>
                <th class="text-left"><?php echo $column_product; ?></th>
                <th class="text-left"><?php echo $column_model; ?></th>
                <th class="text-right"><?php echo $column_quantity; ?></th>
                <th class="text-right"><?php echo $column_price; ?></th>
                <th class="text-right"><?php echo $column_total; ?></th>
                <th class="text-right">Action</th>
              </tr>
            </thead>
            <tbody></tbody>
            <tfoot></tfoot>
          </table>
        </div>
      </div>
    </div>
    </form>
    
  </div> 
  <div id="newAddressModal" class="modal fade" role="dialog">
    <form action="" method="post" enctype="multipart/form-data" >
      <input type="hidden" name="customer_id" value="<?php echo $customer_id; ?>" />
      <input type="hidden" name="firstname" value="<?php echo $customer; ?>" />
      <div class="modal-dialog">
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
              <label for="country-select" class="control-label"><?php echo $entry_country; ?></label>
              <select name="country_id" id="country-select" class="form-control">
                <option value=""><?=$text_select?></option>
                <?php foreach ($countries as $country) : ?>
                  <?php if ($country['country_id'] == $customer_address['country_id']) : ?>
                  <option value="<?php echo $country['country_id']; ?>" selected="selected"><?php echo $country['name']; ?></option>
                  <?php else : ?>
                  <option value="<?php echo $country['country_id']; ?>"><?php echo $country['name']; ?></option>
                  <?php endif; ?>
                <?php endforeach; ?>
              </select>
            </div>
            <div class="form-group required">
              <label for="input-payment-zone" class="control-label"><?php echo $entry_zone; ?></label>
              <select name="zone_id" id="input-payment-zone" class="form-control">
                <option value=""><?=$text_select?></option>
                <?php foreach ($zones as $zone) : ?>
                  <option value="<?=$zone['zone_id']?>"><?=$zone['name']?></option>
                <?php endforeach; ?>
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
<div class="loader-wrapper" style="display:none">
  <div class="loader"></div>
</div>
<!-- /Page loader -->
<?php echo $footer; ?> 