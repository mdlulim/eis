<?php echo $header; ?><?php echo $column_left; ?>
<div id="content">
  <div class="page-header">
    <div class="container-fluid">
      <div class="pull-right">
        <a href="<?php echo $editurl; ?>" data-toggle="tooltip" title="Edit" class="btn btn-primary"><i class="fa fa-pencil"></i></a>
        <a href="<?php echo $cancel; ?>" data-toggle="tooltip" title="<?php echo $button_cancel; ?>" class="btn btn-default"><i class="fa fa-reply"></i></a>
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
    <?php if (isset($error_warning)) { ?>
    <div class="alert alert-danger"><i class="fa fa-exclamation-circle"></i> <?php echo $error_warning; ?>
      <button type="button" class="close" data-dismiss="alert">&times;</button>
    </div>
    <?php } ?>
    <?php if (isset($success)) { ?>
    <div class="alert alert-success"><i class="fa fa-check-circle"></i> <?php echo $success; ?>
      <button type="button" class="close" data-dismiss="alert">&times;</button>
    </div>
    <?php } ?>
    <div class="panel panel-default">
      <div class="panel-heading">
        <h3 class="panel-title"><i class="fa fa-info-circle" style="font-size:23px;"></i> <?php echo $text_list; ?><strong><?php echo $customername; ?></strong></h3>
      </div>
      <div class="panel-body">
        
        <ul class="nav nav-tabs">
            <li class="active"><a href="javascript:void()">General</a></li>
            <li><a href="<?php echo $appointmenttab; ?>" >Appointment</a></li>
            <li><a href="<?php echo $customerstab; ?>" >Customer Contact</a></li>
            <li><a href="<?php echo $visitstab; ?>" >Visits</a></li>
            <li><a href="<?php echo $orderstab; ?>" >Orders</a></li>
            <li><a href="<?php echo $quotestab; ?>" >Quotes</a></li>
            <li><a href="<?php echo $historytab; ?>" >History</a></li>
            <li><a href="<?php echo $transactionstab; ?>" >Transactions</a></li>
            <li><a href="<?php echo $rewardpointstab; ?>" >Reward Points</a></li>
            <li><a href="<?php echo $ipaddressestab; ?>" >IP Addresses</a></li>
          </ul>
          
          <form action="<?=(isset($action)) ? $action : ''; ?>" method="post" enctype="multipart/form-data" id="form-customer" class="form-horizontal">
          <input type="hidden" name="type" value="<?=(isset($type)) ? $type : ''; ?>" />
            <input type="hidden" name="csalesrep_id" value="<?=(isset($csalesrep_id)) ? $csalesrep_id : ''; ?>" />
            
          
          <div class="tab-content">
            <div class="tab-pane active" id="tab-general" style="margin-top:-25px;">
              <div class="row">
                
              <fieldset style="margin: 0px 18px;">        
                  <legend style="width: 173px; padding-top: 24px; padding-left: 14px;">Customer Details</legend>
                  <div class="col-sm-1">
                  
                </div>
                <div class="col-sm-11">
                  <div class="tab-content">
                    <div class="tab-pane active" id="tab-customer">
                      
                      <div class="form-group">
                        <label class="col-sm-3 control-label" for="input-firstname"><?php //echo $entry_firstname; ?>Company Name</label>
                        <div class="col-sm-9">
                          <input type="text" name="firstname" value="<?php echo $firstname; ?>" placeholder="Company Name" id="input-firstname" class="form-control" disabled="disabled" />
                        </div>
                      </div>
                      <div class="form-group">
                        <label class="col-sm-3 control-label" for="input-telephone"><?php echo $entry_telephone; ?></label>
                        <div class="col-sm-9">
                          <input type="text" name="telephone" maxlength="10" value="<?php echo $telephone; ?>" placeholder="<?php echo $entry_telephone; ?>" id="input-telephone" class="form-control" disabled="disabled" />
                         
                        </div>
                      </div>
                      <div class="form-group">
                        <label class="col-sm-3 control-label" for="input-email"><?php echo $entry_email; ?></label>
                        <div class="col-sm-9">
                          <input type="text" name="email" value="<?php echo $email; ?>" placeholder="<?php echo $entry_email; ?>" id="input-email" class="form-control" disabled="disabled" />
                        </div>
                      </div>
                         <?php if($customer_group_id != '1') { ?> 
                      <h2 class="drawline"></h2>
                      <div class="form-group" id="wholesal"  >
                        <label class="col-sm-3 control-label" for="input-customer-group">Wholesale Invitation Status</label>
                        <div class="col-sm-9">

                          <div style="float:left;"> 
                            <input type="text" value="<?php echo ($invited==1) ? 'Invited' : 'Not Invited'?>" disabled="disabled" class="<?php echo ($invited==1) ? 'btn btn-success' : 'btn btn-default'?>" style="width:100px;" />
                          </div>
                          <a href="javascript:void()" id="resend-invitation" data-customername='<?=$customername?>' data-token='<?=$token?>' data-customerid='<?=$customer_id?>'>
                            <div style="float:left;width:150px;padding:8px 5px 8px 15px;margin-left:10px;" class="form-control">
                              <i class="fa fa-paper-plane"></i> (Re)Send Invitation
                            </div>
                          </a>
                        </div>
                      </div>
                       <?php } ?> 
                      <div class="form-group">
                        <label class="col-sm-3 control-label" for="input-customer-group">Contract Pricing</label>
                        <div class="col-sm-9">
                          <select name="customer_group_id" id="input-customer-group" class="form-control" disabled="disabled">
                            <?php foreach ($customer_groups as $customer_group) { ?>
                            <?php if ($customer_group['customer_group_id'] == $customer_group_id) { ?>
                            <option value="<?php echo $customer_group['customer_group_id']; ?>" selected="selected"><?php echo $customer_group['name']; ?></option>
                            <?php } else { ?>
                            <option value="<?php echo $customer_group['customer_group_id']; ?>"><?php echo $customer_group['name']; ?></option>
                            <?php } ?>
                            <?php } ?>
                          </select>
                        </div>
                      </div>
                      
                      <div class="form-group required">
                        <label class="col-sm-3 control-label" for="input-customer-group">Preferred Payment Method</label>
                        <div class="col-sm-9">
                          <select name="payment_method" id="input-customer-group" class="form-control" disabled="disabled">
                            <option value="">Select Preferred Payment Method</option>
                            <?php if($payment_method == 'Quotation') { ?>
                              <option value="Quotation" selected="selected">Quotation</option>
                            <?php } else { ?>
                              <option value="Quotation">Quotation</option>
                            <?php } ?>
                            <?php if($payment_method == 'Cash On Delivery') { ?>
                              <option value="Cash On Delivery" selected="selected">Cash On Delivery</option>
                            <?php } else { ?>
                              <option value="Cash On Delivery">Cash On Delivery</option>
                            <?php } ?>
                            <?php if($payment_method == 'Pay Now Using') { ?>
                              <option value="Pay Now Using" selected="selected">Pay Now Using</option>
                            <?php } else { ?>
                              <option value="Pay Now Using">Pay Now Using</option>
                            <?php } ?>
                           
                          </select>
                          <?php if (isset($error_payment_method)) { ?>
                          <div class="text-danger"><?php echo $error_payment_method; ?></div>
                          <?php } ?>
                        </div>

                      </div>
                      
                      
                      
                      <?php if($access == 'yes') { ?>
                        <h2 class="drawline"></h2>
                      <div class="form-group">
                        <label class="col-sm-3 control-label" for="input-customer-group">Sales Team</label>
                        <div class="col-sm-9">
                          <select name="team_id" id="input-team_id" class="form-control" disabled="disabled">
                            <option value="">Select Sales Team</option>
                            <?php foreach ($teams as $team) { ?>
                            <?php if ($team['team_id'] == $team_id) { ?>
                            <option value="<?php echo $team['team_id']; ?>" selected="selected"><?php echo $team['team_name']; ?></option>
                            <?php } else { ?>
                            <option value="<?php echo $team['team_id']; ?>"><?php echo $team['team_name']; ?></option>
                            <?php } ?>
                            <?php } ?>
                          </select>
                           
                        </div>
                      </div>
                      <div class="form-group">
                        <label class="col-sm-3 control-label" for="input-customer-group"><span data-toggle="tooltip" title="Sales Rep List as per Selection of the Sales Team"><?php echo $entry_salesrep; ?></span></label>
                        <div class="col-sm-9">
                          <select name="salesrep_id" id="input-salesrep-id" class="form-control" disabled="disabled">
                            <option value="">Select Sales Rep</option>
                            <?php foreach ($salesreps as $salesrep) { ?>
                            <?php if ($salesrep['salesrep_id'] == $salesrep_id) { ?>
                            <option value="<?php echo $salesrep['salesrep_id']; ?>" selected="selected"><?php echo $salesrep['salesrep_name']; ?> <?php echo $salesrep['salesrep_lastname']; ?></option>
                            <?php } else { ?>
                            <option value="<?php echo $salesrep['salesrep_id']; ?>"><?php echo $salesrep['salesrep_name']; ?> <?php echo $salesrep['salesrep_lastname']; ?></option>
                            <?php } ?>
                            <?php } ?>
                          </select>
                           <?php if ($error_salesrep_id) { ?>
                          <div class="text-danger"><?php echo $error_salesrep_id; ?></div>
                          <?php } ?>
                        </div>
                      </div>
                      <?php } ?>
                     
                     <h2 class="drawline"></h2>
                      
                      <div class="form-group">
                        <label class="col-sm-3 control-label" for="input-status"><?php echo $entry_status; ?></label>
                        <div class="col-sm-9">
                          <select name="status" id="input-status" class="form-control" disabled="disabled">
                            <?php if ($status) { ?>
                            <option value="1" selected="selected"><?php echo $text_enabled; ?></option>
                            <option value="0"><?php echo $text_disabled; ?></option>
                            <?php } else { ?>
                            <option value="1"><?php echo $text_enabled; ?></option>
                            <option value="0" selected="selected"><?php echo $text_disabled; ?></option>
                            <?php } ?>
                          </select>
                        </div>
                      </div>
                      <input type="hidden" name="approved" value="1"  />
                      
             </div> 
              </div>
             </div>
              </fieldset>    
             <fieldset style="margin: 0px 18px;">        
                  <legend style="width: 100px; padding-top: 24px; padding-left: 14px;">Address</legend>
          <div class="tab-content">
            <div class="tab-pane active" id="tab-general1">
              <div class="row">
                <div class="col-sm-2">
                  <ul class="nav nav-pills nav-stacked" id="address">
                    <?php $address_row = 1; ?>
                    <?php foreach ($addresses as $address) { ?>
                     <?php if(isset($adrs_id) && ($address['address_id'] == $adrs_id) && $adrs_id !='') { ?>

                      <?php $df = 'class="active"'; ?>
                     <?php } else if(isset($adrs_id) && $address_row == '1' && $adrs_id =='') { ?>
                      <?php $df = 'class="active"'; ?>
                     <?php } else { ?>
                      <?php $df = ''; ?>
                     <?php } ?>
                    <li <?php echo $df; ?> ><a href="#tab-address<?php echo $address_row; ?>" data-toggle="tab"><?php echo $tab_address . ' ' . $address_row; ?></a></li>
                    <?php $address_row++; ?>
                    <?php } ?>
                    
                  </ul>
                </div>
                <div class="col-sm-10" >
                  <div class="tab-content">
                    
                    <?php $address_row = 1; ?>
                    <?php foreach ($addresses as $address) { ?>
                    
                    <?php if (isset($adrs_id) && ($address['address_id'] == $adrs_id) && $adrs_id !='') { ?>
                      <?php $cls = 'class="tab-pane active"'; ?>
                    <?php } else if(isset($adrs_id) && $address_row == '1' && $adrs_id =='') { ?>
                      <?php $cls = 'class="tab-pane active"'; ?>
                     <?php } else { ?>
                      <?php $cls = 'class="tab-pane"'; ?>

                     <?php } ?>
                    
                    <div <?php echo $cls; ?> id="tab-address<?php echo $address_row; ?>">
                      <input type="hidden" name="address[<?php echo $address_row; ?>][address_id]" value="<?php echo $address['address_id']; ?>" />
                     
                      <div class="form-group">
                        <label class="col-sm-2 control-label" for="input-address-1<?php echo $address_row; ?>"><?php echo $entry_address_1; ?></label>
                        <div class="col-sm-10">
                          <input type="text" name="address[<?php echo $address_row; ?>][address_1]" value="<?php echo $address['address_1']; ?>" placeholder="<?php echo $entry_address_1; ?>" id="input-address-1<?php echo $address_row; ?>" class="form-control cstm" disabled="disabled" />
                        </div>
                      </div>
                      <div class="form-group">
                        <label class="col-sm-2 control-label" for="input-address-2<?php echo $address_row; ?>"><?php echo $entry_address_2; ?></label>
                        <div class="col-sm-10">
                          <input type="text" name="address[<?php echo $address_row; ?>][address_2]" value="<?php echo $address['address_2']; ?>" placeholder="<?php echo $entry_address_2; ?>" id="input-address-2<?php echo $address_row; ?>" class="form-control" disabled="disabled" />
                        </div>
                      </div>
                      <div class="form-group">
                        <label class="col-sm-2 control-label" for="input-city<?php echo $address_row; ?>"><?php echo $entry_city; ?></label>
                        <div class="col-sm-10">
                          <input type="text" name="address[<?php echo $address_row; ?>][city]" value="<?php echo $address['city']; ?>" placeholder="<?php echo $entry_city; ?>" id="input-city<?php echo $address_row; ?>" class="form-control cstm" disabled="disabled" />
                          </div>
                      </div>
                      <div class="form-group">
                        <label class="col-sm-2 control-label" for="input-postcode<?php echo $address_row; ?>"><?php echo $entry_postcode; ?></label>
                        <div class="col-sm-10">
                          <input type="text" name="address[<?php echo $address_row; ?>][postcode]" value="<?php echo $address['postcode']; ?>" placeholder="<?php echo $entry_postcode; ?>" id="input-postcode<?php echo $address_row; ?>" class="form-control" disabled="disabled" />
                        </div>
                      </div>
                      <div class="form-group">
                        <label class="col-sm-2 control-label" for="input-country<?php echo $address_row; ?>"><?php echo $entry_country; ?></label>
                        <div class="col-sm-10">
                          <select name="address[<?php echo $address_row; ?>][country_id]" id="input-country<?php echo $address_row; ?>" onchange="country(this, '<?php echo $address_row; ?>', '<?php echo $address['zone_id']; ?>');" class="form-control cstm" disabled="disabled">
                            <option value=""><?php echo $text_select; ?></option>
                            <?php foreach ($countries as $country) { ?>
                            <?php if ($country['country_id'] == $address['country_id']) { ?>
                            <option value="<?php echo $country['country_id']; ?>" selected="selected"><?php echo $country['name']; ?></option>
                            <?php } else { ?>
                            <option value="<?php echo $country['country_id']; ?>"><?php echo $country['name']; ?></option>
                            <?php } ?>
                            <?php } ?>
                          </select>
                         
                        </div>
                      </div>
                      <div class="form-group">
                        <label class="col-sm-2 control-label" for="input-zone<?php echo $address_row; ?>"><?php echo $entry_zone; ?></label>
                        <div class="col-sm-10">
                          <select name="address[<?php echo $address_row; ?>][zone_id]" id="input-zone<?php echo $address_row; ?>" class="form-control cstm" disabled="disabled">
                          </select>
                        </div>
                      </div>
                      <div class="form-group">
                        <label class="col-sm-2 control-label"><?php echo $entry_default; ?></label>
                        <div class="col-sm-10">
                          <label class="radio">
                            <?php if (($address['address_id'] == $address_id) || !$addresses) { ?>
                              <input type="checkbox" name="address[<?php echo $address_row; ?>][default]" value="<?php echo $address_row; ?>" checked="checked" disabled="disabled" />
                            <?php } else { ?>
                              <input type="checkbox" name="address[<?php echo $address_row; ?>][default]" value="<?php echo $address_row; ?>" disabled="disabled" />
                            <?php } ?>
                          </label>
                        </div>
                      </div>
                    </div>
                    <?php $address_row++; ?>
                    <?php } ?>
                  </div>
                </div>
              </div>
            </div>
            
          </div>
          </fieldset>
                      
 <style>
  #tab-customer .form-group + .form-group{border-top:none;}
  .drawline{border-top:1px solid #ededed;margin:10px 0px;}
  </style>                   
                    
                  
                
              </div>
            </div>
          </div>
          
        </form>
       
        
      </div>
      
    </div>
  </div>
</div>
<!-- Page loader -->
<div class="loader-wrapper" style="display:none">
  <div class="loader"></div>
</div>
<!-- /Page loader -->

 <script type="text/javascript"><!--
function country(element, index, zone_id) {
  $.ajax({
    url: 'index.php?route=localisation/country/country&token=<?php echo $token; ?>&country_id=' + element.value,
    dataType: 'json',
    beforeSend: function() {
      $('select[name=\'address[' + index + '][country_id]\']').after(' <i class="fa fa-circle-o-notch fa-spin"></i>');
    },
    complete: function() {
      $('.fa-spin').remove();
    },
    success: function(json) {
      if (json['postcode_required'] == '1') {
        $('input[name=\'address[' + index + '][postcode]\']').parent().parent().addClass('required');
      } else {
        $('input[name=\'address[' + index + '][postcode]\']').parent().parent().removeClass('required');
      }

      html = '<option value=""><?php echo $text_select; ?></option>';

      if (json['zone'] && json['zone'] != '') {
        for (i = 0; i < json['zone'].length; i++) {
          html += '<option value="' + json['zone'][i]['zone_id'] + '"';

          if (json['zone'][i]['zone_id'] == zone_id) {
            html += ' selected="selected"';
          }

          html += '>' + json['zone'][i]['name'] + '</option>';
        }
      } else {
        html += '<option value="0"><?php echo $text_none; ?></option>';
      }

      $('select[name=\'address[' + index + '][zone_id]\']').html(html);
    },
    error: function(xhr, ajaxOptions, thrownError) {
      alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
    }
  });
}

$('select[name$=\'[country_id]\']').trigger('change');
//--></script>
<?php echo $footer; ?> 