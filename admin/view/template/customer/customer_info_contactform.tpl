<?php echo $header; ?><?php echo $column_left; ?>
<div id="content">
  <div class="page-header">
    <div class="container-fluid">
      <div class="pull-right">
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
    <div class="panel panel-default">
      <div class="panel-heading">
        <h3 class="panel-title"><i class="fa fa-info-circle" style="font-size:23px;"></i> <?php echo $text_list; ?><strong><?php echo $customername; ?></strong></h3>
      </div>
      <div class="panel-body">
        
        <ul class="nav nav-tabs">
            <li><a href="<?php echo $generaltab; ?>" >General</a></li>
            <li><a href="<?php echo $appointmenttab; ?>" >Appointment</a></li>
            <li class="active"><a href="javascript:void()" >Customer Contact</a></li>
            <li><a href="<?php echo $visitstab; ?>" >Visits</a></li>
            <li><a href="<?php echo $orderstab; ?>" >Orders</a></li>
            <li><a href="<?php echo $quotestab; ?>" >Quotes</a></li>
            <li><a href="<?php echo $historytab; ?>" >History</a></li>
            <li><a href="<?php echo $transactionstab; ?>" >Transactions</a></li>
            <li><a href="<?php echo $rewardpointstab; ?>" >Reward Points</a></li>
            <li><a href="<?php echo $ipaddressestab; ?>" >Ip Addresses</a></li>
          </ul>
        
        <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" id="form-customer" class="form-horizontal">
        	<input type="hidden" name="type" value="<?php echo $type; ?>" />
            <input type="hidden" name="csalesrep_id" value="<?php echo $csalesrep_id; ?>" />
            
          
          
              
             
          		<div class="tab-content">
            <div class="tab-pane active" id="tab-general1">
              <div class="row">
                <div class="col-sm-3">
                  <ul class="nav nav-pills nav-stacked" id="address">
                    <?php $address_row = 1; ?>
                    <?php foreach ($customer_contacts as $customer_contact) { ?>
                     
                     <?php if($address_row == '1') { ?>
                     	<?php $df = 'class="active"'; ?>
                     <?php } else { ?>
                     	<?php $df = ''; ?>
                     <?php } ?>
                    <li <?php echo $df; ?> ><a href="#tab-address<?php echo $address_row; ?>" data-toggle="tab"><?php echo $customer_contact['first_name'].' '.$customer_contact['last_name']; ?></a></li>
                    <?php $address_row++; ?>
                    <?php } ?>
                    
                    	<li id="address-add"><a onclick="addAddress();"><i class="fa fa-plus-circle"></i> Add Customer Contact</a></li>
                    
                  </ul>
                </div>
                <div class="col-sm-9" >
                  <div class="tab-content">
                    
                    <?php $address_row = 1; ?>
                    <?php foreach ($customer_contacts as $customer_contact) { ?>
                    
                    <?php if($address_row == '1') { ?>
                     	<?php $cls = 'class="tab-pane active"'; ?>
                     <?php } else { ?>
                     	<?php $cls = 'class="tab-pane"'; ?>
                     <?php } ?>
                    
                    <div <?php echo $cls; ?> id="tab-address<?php echo $address_row; ?>">
                      <input type="hidden" name="customer[<?php echo $address_row; ?>][customer_con_id]" value="<?php echo $customer_contact['customer_con_id']; ?>" />
                     
                      <!--<div class="form-group required">
                        <label class="col-sm-2 control-label" for="input-address-1<?php echo $address_row; ?>"><?php echo $entry_address_1; ?></label>
                        <div class="col-sm-10">
                          <input type="text" name="address[<?php echo $address_row; ?>][address_1]" value="<?php echo $address['address_1']; ?>" placeholder="<?php echo $entry_address_1; ?>" id="input-address-1<?php echo $address_row; ?>" class="form-control cstm" />
                          <?php if (isset($error_address[$address_row]['address_1'])) { ?>
                          <div class="text-danger"><?php echo $error_address[$address_row]['address_1']; ?></div>
                          <?php } ?>
                        </div>
                      </div>-->
                      
                      <div class="form-group required">
                        <label class="col-sm-2 control-label" for="input-username"><?php echo $entry_first_name; ?></label>
                        <div class="col-sm-10">
                          <input type="text" name="first_name" value="<?php echo $customer_contact['first_name']; ?>" placeholder="<?php echo $entry_first_name; ?>" id="input-username" class="form-control" />
                         <?php if (isset($error_customer_contact[$address_row]['first_name'])) { ?>
                          <div class="text-danger"><?php echo $error_customer_contact[$address_row]['first_name']; ?></div>
                          <?php } ?>
                        </div>
                      </div>
                      <div class="form-group required">
                        <label class="col-sm-2 control-label" for="input-username"><?php echo $entry_last_name; ?></label>
                        <div class="col-sm-10">
                          <input type="text" name="last_name" value="<?php echo $last_name; ?>" placeholder="<?php echo $entry_last_name; ?>" id="input-username" class="form-control" />
                         <?php if ($error_last_name) { ?>
                          <div class="text-danger"><?php echo $error_last_name; ?></div>
                          <?php } ?>
                        </div>
                      </div>
                      <div class="form-group">
                        <label class="col-sm-2 control-label" for="input-user-group"><?php echo $entry_customer; ?></label>
                        <div class="col-sm-10">
                          <select name="customer_id" id="input-sales_manager" class="form-control">
                            <option value="">Select Customer</option>
                            <?php foreach ($customers as $customer) {  ?>
                            <?php if ($customer['customer_id'] == $customer_id) { ?>
                            <option value="<?php echo $customer['customer_id']; ?>" selected="selected"><?php echo $customer['firstname']; ?></option>
                            <?php } else { ?>
                            <option value="<?php echo $customer['customer_id']; ?>"><?php echo $customer['firstname']; ?></option>
                            <?php } ?>
                            <?php } ?>
                          </select>
                          <?php if ($error_customer_id) { ?>
                          <div class="text-danger"><?php echo $error_customer_id; ?></div>
                          <?php } ?>
                        </div>
                      </div>
                      
                      <div class="form-group required">
                        <label class="col-sm-2 control-label" for="input-username"><?php echo $entry_email; ?></label>
                        <div class="col-sm-10">
                          <input type="text" name="email" value="<?php echo $email; ?>" placeholder="<?php echo $entry_email; ?>" id="input-email" class="form-control" />
                          <?php if ($error_email) { ?>
                          <div class="text-danger"><?php echo $error_email; ?></div>
                          <?php } ?>
                        </div>
                      </div>
                      
                      <div class="form-group">
                        <label class="col-sm-2 control-label" for="input-username"><?php echo $entry_telephone_number; ?></label>
                        <div class="col-sm-10">
                          <input type="text" name="telephone_number" value="<?php echo $telephone_number; ?>" maxlength="10" placeholder="<?php echo $entry_telephone_number; ?>" id="input-tel" class="form-control" />
                          <?php if ($error_telephone_number) { ?>
                          <div class="text-danger"><?php echo $error_telephone_number; ?></div>
                          <?php } ?>
                        </div>
                      </div>
                      
                      <div class="form-group">
                        <label class="col-sm-2 control-label" for="input-username"><?php echo $entry_cellphone_number; ?></label>
                        <div class="col-sm-10">
                          <input type="text" name="cellphone_number" value="<?php echo $cellphone_number; ?>" maxlength="10" placeholder="<?php echo $entry_cellphone_number; ?>" id="input-cell" class="form-control" />
                          <?php if ($error_cellphone_number) { ?>
                          <div class="text-danger"><?php echo $error_cellphone_number; ?></div>
                          <?php } ?>
                        </div>
                      </div>
                      
                      <div class="form-group">
                        <label class="col-sm-2 control-label" for="input-username"><?php echo $entry_role; ?></label>
                        <div class="col-sm-10">
                          <input type="text" name="role" value="<?php echo $role; ?>" placeholder="<?php echo $entry_role; ?>" id="input-cell" class="form-control" />
                          <?php if ($error_role) { ?>
                          <div class="text-danger"><?php echo $error_role; ?></div>
                          <?php } ?>
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
          
                                     
              
        </form>
        
      </div>
    </div>
  </div>
</div>
<script type="text/javascript"><!--
var address_row = <?php echo $address_row; ?>;

function addAddress() {
	
	html  = '<div class="tab-pane" id="tab-address' + address_row + '">';
	html += '  <input type="hidden" name="address[' + address_row + '][address_id]" value="" />';

	html += '  <div class="form-group required">';
	html += '    <label class="col-sm-2 control-label" for="input-address-1' + address_row + '"><?php echo $entry_address_1; ?></label>';
	html += '    <div class="col-sm-10"><input type="text" name="address[' + address_row + '][address_1]" value="" placeholder="<?php echo $entry_address_1; ?>" id="input-address-1' + address_row + '" class="form-control cstm" /></div>';
	html += '  </div>';

	html += '  <div class="form-group">';
	html += '    <label class="col-sm-2 control-label"><?php echo $entry_default; ?></label>';
	html += '    <div class="col-sm-10"><label class="radio"><input type="checkbox" name="address[' + address_row + '][default]" value="" /></label></div>';
	html += '  </div>';

    html += '</div>';

	$('#tab-general1 .tab-content').append(html);

	$('select[name=\'customer_group_id\']').trigger('change');

	$('select[name=\'address[' + address_row + '][country_id]\']').trigger('change');

	$('#address-add').before('<li><a href="#tab-address' + address_row + '" data-toggle="tab"><i class="fa fa-minus-circle" onclick="$(\'#address a:first\').tab(\'show\'); $(\'a[href=\\\'#tab-address' + address_row + '\\\']\').parent().remove(); $(\'#tab-address' + address_row + '\').remove();"></i> Customer Contact ' + address_row + '</a></li>');
	
	//$('#address-add').before('<li><a href="#tab-address' + address_row + '" data-toggle="tab"><?php echo $tab_address; ?> ' + address_row + '</a></li>');

	$('#address a[href=\'#tab-address' + address_row + '\']').tab('show');

	$('#tab-address' + address_row + ' .form-group[data-sort]').detach().each(function() {
		if ($(this).attr('data-sort') >= 0 && $(this).attr('data-sort') <= $('#tab-address' + address_row + ' .form-group').length) {
			$('#tab-address' + address_row + ' .form-group').eq($(this).attr('data-sort')).before(this);
		}

		if ($(this).attr('data-sort') > $('#tab-address' + address_row + ' .form-group').length) {
			$('#tab-address' + address_row + ' .form-group:last').after(this);
		}

		if ($(this).attr('data-sort') < -$('#tab-address' + address_row + ' .form-group').length) {
			$('#tab-address' + address_row + ' .form-group:first').before(this);
		}
	});

	address_row++;
}
//--></script>
  
<?php echo $footer; ?> 