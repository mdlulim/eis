<<<<<<< HEAD
<?php echo $header; ?><?php echo $column_left; ?>
<div id="content">
  <div class="page-header">
    <div class="container-fluid">
      <div class="pull-right">
      	<button type="submit" form="form-mproduct" data-toggle="tooltip" title="" class="btn btn-primary" data-original-title="Save"><i class="fa fa-save"></i></button>
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
            <input type="hidden" name="customer_id" value="<?php echo $customer_id; ?>" />
            
          
          
              
             
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
                    <li <?php echo $df; ?> >
                    <!--<a href="#tab-address<?php echo $address_row; ?>" data-toggle="tab"><i class="fa fa-minus-circle" onclick="$('#address a:first').tab('show'); $('#address a[href=\'#tab-address<?php echo $address_row; ?>\']').parent().remove(); $('#tab-address<?php echo $address_row; ?>').remove();"></i> <?php if ($customer_contact['first_name']=='') { ?><?php echo 'Customer Contact ';?> <?php echo $address_row; ?><?php } else { ?><?php echo $customer_contact['first_name'].' '.$customer_contact['last_name']; ?><?php } ?></a>-->
                    <?php if($customer_contact['customer_con_id']) { ?>
                    	<?php if (isset($error_customer_contact[$address_row]['first_name']) || isset($error_customer_contact[$address_row]['last_name']) || isset($error_customer_contact[$address_row]['email']) || isset($error_customer_contact[$address_row]['telephone_number']) || isset($error_customer_contact[$address_row]['cellphone_number'])) { ?>
                        <a style="color:#f56b6b;" href="#tab-address<?php echo $address_row; ?>" data-toggle="tab"><i class="fa fa-minus-circle" onclick="confirm('<?php echo $text_confirm; ?>') ? delt(<?php echo $customer_contact['customer_con_id']; ?>,<?php echo $customer_id; ?>) : false;"></i> <?php if ($customer_contact['first_name']=='') { ?><?php echo 'Customer Contact ';?> <?php echo $address_row; ?><?php } else { ?><?php echo $customer_contact['first_name'].' '.$customer_contact['last_name']; ?><?php } ?></a>
                        <?php } else { ?>
                        <a href="#tab-address<?php echo $address_row; ?>" data-toggle="tab"><i class="fa fa-minus-circle" onclick="confirm('<?php echo $text_confirm; ?>') ? delt(<?php echo $customer_contact['customer_con_id']?>,<?php echo $customer_id; ?>) : false;"></i> <?php if ($customer_contact['first_name']=='') { ?><?php echo 'Customer Contact ';?> <?php echo $address_row; ?><?php } else { ?><?php echo $customer_contact['first_name'].' '.$customer_contact['last_name']; ?><?php } ?></a>
                        <?php } ?>
                    <?php } else { ?>
                        <?php if (isset($error_customer_contact[$address_row]['first_name']) || isset($error_customer_contact[$address_row]['last_name']) || isset($error_customer_contact[$address_row]['email']) || isset($error_customer_contact[$address_row]['telephone_number']) || isset($error_customer_contact[$address_row]['cellphone_number'])) { ?>
                        <a style="color:#f56b6b;" href="#tab-address<?php echo $address_row; ?>" data-toggle="tab"><i class="fa fa-minus-circle" onclick="$('#address a:first').tab('show'); $('#address a[href=\'#tab-address<?php echo $address_row; ?>\']').parent().remove(); $('#tab-address<?php echo $address_row; ?>').remove();"></i> <?php if ($customer_contact['first_name']=='') { ?><?php echo 'Customer Contact ';?> <?php echo $address_row; ?><?php } else { ?><?php echo $customer_contact['first_name'].' '.$customer_contact['last_name']; ?><?php } ?></a>
                        <?php } else { ?>
                        <a href="#tab-address<?php echo $address_row; ?>" data-toggle="tab"><i class="fa fa-minus-circle" onclick="$('#address a:first').tab('show'); $('#address a[href=\'#tab-address<?php echo $address_row; ?>\']').parent().remove(); $('#tab-address<?php echo $address_row; ?>').remove();"></i> <?php if ($customer_contact['first_name']=='') { ?><?php echo 'Customer Contact ';?> <?php echo $address_row; ?><?php } else { ?><?php echo $customer_contact['first_name'].' '.$customer_contact['last_name']; ?><?php } ?></a>
                        <?php } ?>
                     <?php } ?>
                    
                    <!--<a href="#tab-address<?php echo $address_row; ?>" data-toggle="tab"><?php echo $customer_contact['first_name'].' '.$customer_contact['last_name']; ?></a></li>-->
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
                      <input type="hidden" name="customer_contact[<?php echo $address_row; ?>][customer_con_id]" value="<?php echo $customer_contact['customer_con_id']; ?>" />
                     <input type="hidden" name="customer_contact[<?php echo $address_row; ?>][customer_id]" value="<?php echo $customer_id ?>" id="input-customer_id" />
                      
                      
                      <div class="form-group required">
                        <label class="col-sm-2 control-label" for="input-username"><?php echo $entry_first_name; ?></label>
                        <div class="col-sm-10">
                          <input type="text" name="customer_contact[<?php echo $address_row; ?>][first_name]" value="<?php echo $customer_contact['first_name']; ?>" placeholder="<?php echo $entry_first_name; ?>" id="input-username" class="form-control cstm" />
                          <?php if (isset($error_customer_contact[$address_row]['first_name'])) { ?>
                          <div class="text-danger"><?php echo $error_customer_contact[$address_row]['first_name']; ?></div>
                          <?php } ?>
                        
                        </div>
                      </div>
                      
                      <div class="form-group required">
                        <label class="col-sm-2 control-label" for="input-username"><?php echo $entry_last_name; ?></label>
                        <div class="col-sm-10">
                          <input type="text" name="customer_contact[<?php echo $address_row; ?>][last_name]" value="<?php echo $customer_contact['last_name']; ?>" placeholder="<?php echo $entry_last_name; ?>" id="input-username" class="form-control cstm" />
                          
                          <?php if (isset($error_customer_contact[$address_row]['last_name'])) { ?>
                          <div class="text-danger"><?php echo $error_customer_contact[$address_row]['last_name']; ?></div>
                          <?php } ?>
                        </div>
                      </div>
                      
                      <div class="form-group required">
                        <label class="col-sm-2 control-label" for="input-email"><?php echo $entry_email; ?></label>
                        <div class="col-sm-10">
                          <input type="text" name="customer_contact[<?php echo $address_row; ?>][email]" value="<?php echo $customer_contact['email']; ?>" placeholder="<?php echo $entry_email; ?>" id="input-email" class="form-control cstm" />
                          
                          <?php if (isset($error_customer_contact[$address_row]['email'])) { ?>
                          <div class="text-danger"><?php echo $error_customer_contact[$address_row]['email']; ?></div>
                          <?php } ?>
                        </div>
                      </div>
                      
                      <div class="form-group">
                        <label class="col-sm-2 control-label" for="input-telephone_number"><?php echo $entry_telephone_number; ?></label>
                        <div class="col-sm-10">
                          <input type="text" name="customer_contact[<?php echo $address_row; ?>][telephone_number]" value="<?php echo $customer_contact['telephone_number']; ?>" placeholder="<?php echo $entry_telephone_number; ?>" id="input-telephone_number" class="form-control" maxlength="10" />
                           <?php if (isset($error_customer_contact[$address_row]['telephone_number'])) { ?>
                          <div class="text-danger"><?php echo $error_customer_contact[$address_row]['telephone_number']; ?></div>
                          <?php } ?>
                          
                        </div>
                      </div>
                      
                      <div class="form-group">
                        <label class="col-sm-2 control-label" for="input-cellphone_number"><?php echo $entry_cellphone_number; ?></label>
                        <div class="col-sm-10">
                          <input type="text" name="customer_contact[<?php echo $address_row; ?>][cellphone_number]" value="<?php echo $customer_contact['cellphone_number']; ?>" placeholder="<?php echo $entry_cellphone_number; ?>" id="input-cellphone_number" class="form-control" maxlength="10" />
                          <?php if (isset($error_customer_contact[$address_row]['cellphone_number'])) { ?>
                          <div class="text-danger"><?php echo $error_customer_contact[$address_row]['cellphone_number']; ?></div>
                          <?php } ?>
                        </div>
                      </div>
                      
                      <div class="form-group">
                        <label class="col-sm-2 control-label" for="input-role"><?php echo $entry_role; ?></label>
                        <div class="col-sm-10">
                          <input type="text" name="customer_contact[<?php echo $address_row; ?>][role]" value="<?php echo $customer_contact['role']; ?>" placeholder="<?php echo $entry_role; ?>" id="input-role" class="form-control" />
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
<script src="https://ajax.aspnetcdn.com/ajax/jquery.validate/1.9/jquery.validate.min.js"></script>
<script type="text/javascript">
$(document).ready(function ($) {
 $('#tab-general1').on('change',function(e){ 
//e.preventDefault()

//var flag =false; 
$('.cstm').each(function(){ //alert(this.value);
 
  if(this.value)
  {
  	$('#address-add').show();
  }
  else
  {
  	$('#address-add').hide();
  }
  
});

});
});
</script>
<script type="text/javascript">
 function delt(id,cid) { 
 
 $.ajax({ 
		url: 'index.php?route=replogic/customer_contact/AjaxDelete&token=<?php echo $token; ?>&id=' + id,
		dataType: 'json',
		success: function(json) {
			
			window.location.href = 'index.php?route=customer/customer_info&type=customercontact&customer_id='+ cid +'&token=<?php echo $token; ?>';
			
		},
		error: function(xhr, ajaxOptions, thrownError) {
			alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
		}
	});
 
 }
</script>
<script type="text/javascript"><!--
var address_row = <?php echo $address_row; ?>;

function addAddress() {
	
	$('#address-add').hide();
	
	html  = '<div class="tab-pane" id="tab-address' + address_row + '">';
	html += '  <input type="hidden" name="customer_contact[' + address_row + '][customer_con_id]" value="" />';
	html += '  <input type="hidden" name="customer_contact[<?php echo $address_row; ?>][customer_id]" value="<?php echo $customer_id ?>" id="input-customer_id" />';

	html += '  <div class="form-group required">';
	html += '    <label class="col-sm-2 control-label" for="input-firstname"><?php echo $entry_first_name; ?></label>';
	html += '    <div class="col-sm-10"><input type="text" name="customer_contact[' + address_row + '][first_name]" placeholder="<?php echo $entry_first_name; ?>" id="input-firstname' + address_row + '" class="form-control cstm" /></div>';
	html += '  </div>';
	
	html += '  <div class="form-group required">';
	html += '    <label class="col-sm-2 control-label" for="input-lastname"><?php echo $entry_last_name; ?></label>';
	html += '    <div class="col-sm-10"><input type="text" name="customer_contact[' + address_row + '][last_name]" placeholder="<?php echo $entry_last_name; ?>" id="input-lastname' + address_row + '" class="form-control cstm" /></div>';
	html += '  </div>';
	
	html += '  <div class="form-group required">';
	html += '    <label class="col-sm-2 control-label" for="input-email"><?php echo $entry_email; ?></label>';
	html += '    <div class="col-sm-10"><input type="text" name="customer_contact[' + address_row + '][email]" placeholder="<?php echo $entry_email; ?>" id="input-email' + address_row + '" class="form-control cstm" /></div>';
	html += '  </div>';
	
	html += '  <div class="form-group">';
	html += '    <label class="col-sm-2 control-label" for="input-telephone_number"><?php echo $entry_telephone_number; ?></label>';
	html += '    <div class="col-sm-10"><input type="text" name="customer_contact[' + address_row + '][telephone_number]" placeholder="<?php echo $entry_telephone_number; ?>" id="input-telephone_number' + address_row + '" class="form-control" maxlength="10" /></div>';
	html += '  </div>';
	
	html += '  <div class="form-group">';
	html += '    <label class="col-sm-2 control-label" for="input-cellphone_number"><?php echo $entry_cellphone_number; ?></label>';
	html += '    <div class="col-sm-10"><input type="text" name="customer_contact[' + address_row + '][cellphone_number]" placeholder="<?php echo $entry_cellphone_number; ?>" id="input-email' + address_row + '" class="form-control" maxlength="10" /></div>';
	html += '  </div>';
	
	html += '  <div class="form-group">';
	html += '    <label class="col-sm-2 control-label" for="input-role"><?php echo $entry_role; ?></label>';
	html += '    <div class="col-sm-10"><input type="text" name="customer_contact[' + address_row + '][role]" placeholder="<?php echo $entry_role; ?>" id="input-role' + address_row + '" class="form-control" /></div>';
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


<script type="text/javascript">
  (function ($, W, D)
  {
  var JQUERY4U = {};
  JQUERY4U.UTIL =
      {
          setupFormValidation: function ()
          {
          //form validation rules
          $("#form-customer").validate({ 
              rules: {
              'first_name[]': "required"
             
              },
              messages: {
              'first_name[]': "Please Enter Name"
              },
              submitHandler: function (form) {
              form.submit();
              }
          });
        }
      }
  //when the dom has loaded setup form validation rules
  $(D).ready(function ($) {
      JQUERY4U.UTIL.setupFormValidation();
  });
  })(jQuery, window, document);
</script>
<style type="text/css">
    #form-customer .form-group label.error {
    color: #FB3A3A;
    display: inline-block;
    margin: 0px 0 0px 0px;
    padding: 0;
    text-align: left;
    }
</style>
  
=======
<?php echo $header; ?><?php echo $column_left; ?>
<div id="content">
  <div class="page-header">
    <div class="container-fluid">
      <div class="pull-right">
      	<button type="submit" form="form-mproduct" data-toggle="tooltip" title="" class="btn btn-primary" data-original-title="Save"><i class="fa fa-save"></i></button>
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
            <input type="hidden" name="customer_id" value="<?php echo $customer_id; ?>" />
            
          
          
              
             
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
                    <li <?php echo $df; ?> >
                    <!--<a href="#tab-address<?php echo $address_row; ?>" data-toggle="tab"><i class="fa fa-minus-circle" onclick="$('#address a:first').tab('show'); $('#address a[href=\'#tab-address<?php echo $address_row; ?>\']').parent().remove(); $('#tab-address<?php echo $address_row; ?>').remove();"></i> <?php if ($customer_contact['first_name']=='') { ?><?php echo 'Customer Contact ';?> <?php echo $address_row; ?><?php } else { ?><?php echo $customer_contact['first_name'].' '.$customer_contact['last_name']; ?><?php } ?></a>-->
                    <?php if($customer_contact['customer_con_id']) { ?>
                    	<?php if (isset($error_customer_contact[$address_row]['first_name']) || isset($error_customer_contact[$address_row]['last_name']) || isset($error_customer_contact[$address_row]['email']) || isset($error_customer_contact[$address_row]['telephone_number']) || isset($error_customer_contact[$address_row]['cellphone_number'])) { ?>
                        <a style="color:#f56b6b;" href="#tab-address<?php echo $address_row; ?>" data-toggle="tab"><i class="fa fa-minus-circle" onclick="confirm('<?php echo $text_confirm; ?>') ? delt(<?php echo $customer_contact['customer_con_id']; ?>,<?php echo $customer_id; ?>) : false;"></i> <?php if ($customer_contact['first_name']=='') { ?><?php echo 'Customer Contact ';?> <?php echo $address_row; ?><?php } else { ?><?php echo $customer_contact['first_name'].' '.$customer_contact['last_name']; ?><?php } ?></a>
                        <?php } else { ?>
                        <a href="#tab-address<?php echo $address_row; ?>" data-toggle="tab"><i class="fa fa-minus-circle" onclick="confirm('<?php echo $text_confirm; ?>') ? delt(<?php echo $customer_contact['customer_con_id']?>,<?php echo $customer_id; ?>) : false;"></i> <?php if ($customer_contact['first_name']=='') { ?><?php echo 'Customer Contact ';?> <?php echo $address_row; ?><?php } else { ?><?php echo $customer_contact['first_name'].' '.$customer_contact['last_name']; ?><?php } ?></a>
                        <?php } ?>
                    <?php } else { ?>
                        <?php if (isset($error_customer_contact[$address_row]['first_name']) || isset($error_customer_contact[$address_row]['last_name']) || isset($error_customer_contact[$address_row]['email']) || isset($error_customer_contact[$address_row]['telephone_number']) || isset($error_customer_contact[$address_row]['cellphone_number'])) { ?>
                        <a style="color:#f56b6b;" href="#tab-address<?php echo $address_row; ?>" data-toggle="tab"><i class="fa fa-minus-circle" onclick="$('#address a:first').tab('show'); $('#address a[href=\'#tab-address<?php echo $address_row; ?>\']').parent().remove(); $('#tab-address<?php echo $address_row; ?>').remove();"></i> <?php if ($customer_contact['first_name']=='') { ?><?php echo 'Customer Contact ';?> <?php echo $address_row; ?><?php } else { ?><?php echo $customer_contact['first_name'].' '.$customer_contact['last_name']; ?><?php } ?></a>
                        <?php } else { ?>
                        <a href="#tab-address<?php echo $address_row; ?>" data-toggle="tab"><i class="fa fa-minus-circle" onclick="$('#address a:first').tab('show'); $('#address a[href=\'#tab-address<?php echo $address_row; ?>\']').parent().remove(); $('#tab-address<?php echo $address_row; ?>').remove();"></i> <?php if ($customer_contact['first_name']=='') { ?><?php echo 'Customer Contact ';?> <?php echo $address_row; ?><?php } else { ?><?php echo $customer_contact['first_name'].' '.$customer_contact['last_name']; ?><?php } ?></a>
                        <?php } ?>
                     <?php } ?>
                    
                    <!--<a href="#tab-address<?php echo $address_row; ?>" data-toggle="tab"><?php echo $customer_contact['first_name'].' '.$customer_contact['last_name']; ?></a></li>-->
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
                      <input type="hidden" name="customer_contact[<?php echo $address_row; ?>][customer_con_id]" value="<?php echo $customer_contact['customer_con_id']; ?>" />
                     <input type="hidden" name="customer_contact[<?php echo $address_row; ?>][customer_id]" value="<?php echo $customer_id ?>" id="input-customer_id" />
                      
                      
                      <div class="form-group required">
                        <label class="col-sm-2 control-label" for="input-username"><?php echo $entry_first_name; ?></label>
                        <div class="col-sm-10">
                          <input type="text" name="customer_contact[<?php echo $address_row; ?>][first_name]" value="<?php echo $customer_contact['first_name']; ?>" placeholder="<?php echo $entry_first_name; ?>" id="input-username" class="form-control cstm" />
                          <?php if (isset($error_customer_contact[$address_row]['first_name'])) { ?>
                          <div class="text-danger"><?php echo $error_customer_contact[$address_row]['first_name']; ?></div>
                          <?php } ?>
                        
                        </div>
                      </div>
                      
                      <div class="form-group required">
                        <label class="col-sm-2 control-label" for="input-username"><?php echo $entry_last_name; ?></label>
                        <div class="col-sm-10">
                          <input type="text" name="customer_contact[<?php echo $address_row; ?>][last_name]" value="<?php echo $customer_contact['last_name']; ?>" placeholder="<?php echo $entry_last_name; ?>" id="input-username" class="form-control cstm" />
                          
                          <?php if (isset($error_customer_contact[$address_row]['last_name'])) { ?>
                          <div class="text-danger"><?php echo $error_customer_contact[$address_row]['last_name']; ?></div>
                          <?php } ?>
                        </div>
                      </div>
                      
                      <div class="form-group required">
                        <label class="col-sm-2 control-label" for="input-email"><?php echo $entry_email; ?></label>
                        <div class="col-sm-10">
                          <input type="text" name="customer_contact[<?php echo $address_row; ?>][email]" value="<?php echo $customer_contact['email']; ?>" placeholder="<?php echo $entry_email; ?>" id="input-email" class="form-control cstm" />
                          
                          <?php if (isset($error_customer_contact[$address_row]['email'])) { ?>
                          <div class="text-danger"><?php echo $error_customer_contact[$address_row]['email']; ?></div>
                          <?php } ?>
                        </div>
                      </div>
                      
                      <div class="form-group">
                        <label class="col-sm-2 control-label" for="input-telephone_number"><?php echo $entry_telephone_number; ?></label>
                        <div class="col-sm-10">
                          <input type="text" name="customer_contact[<?php echo $address_row; ?>][telephone_number]" value="<?php echo $customer_contact['telephone_number']; ?>" placeholder="<?php echo $entry_telephone_number; ?>" id="input-telephone_number" class="form-control" maxlength="10" />
                           <?php if (isset($error_customer_contact[$address_row]['telephone_number'])) { ?>
                          <div class="text-danger"><?php echo $error_customer_contact[$address_row]['telephone_number']; ?></div>
                          <?php } ?>
                          
                        </div>
                      </div>
                      
                      <div class="form-group">
                        <label class="col-sm-2 control-label" for="input-cellphone_number"><?php echo $entry_cellphone_number; ?></label>
                        <div class="col-sm-10">
                          <input type="text" name="customer_contact[<?php echo $address_row; ?>][cellphone_number]" value="<?php echo $customer_contact['cellphone_number']; ?>" placeholder="<?php echo $entry_cellphone_number; ?>" id="input-cellphone_number" class="form-control" maxlength="10" />
                          <?php if (isset($error_customer_contact[$address_row]['cellphone_number'])) { ?>
                          <div class="text-danger"><?php echo $error_customer_contact[$address_row]['cellphone_number']; ?></div>
                          <?php } ?>
                        </div>
                      </div>
                      
                      <div class="form-group">
                        <label class="col-sm-2 control-label" for="input-role"><?php echo $entry_role; ?></label>
                        <div class="col-sm-10">
                          <input type="text" name="customer_contact[<?php echo $address_row; ?>][role]" value="<?php echo $customer_contact['role']; ?>" placeholder="<?php echo $entry_role; ?>" id="input-role" class="form-control" />
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
<script type="text/javascript">
$(document).ready(function ($) {
 $('#tab-general1').on('change',function(e){ 
//e.preventDefault()

//var flag =false; 
$('.cstm').each(function(){ //alert(this.value);
 
  if(this.value)
  {
  	$('#address-add').show();
  }
  else
  {
  	$('#address-add').hide();
  }
  
});

});
});
</script>
<script type="text/javascript">
 function delt(id,cid) { 
 
 $.ajax({ 
		url: 'index.php?route=replogic/customer_contact/AjaxDelete&token=<?php echo $token; ?>&id=' + id,
		dataType: 'json',
		success: function(json) {
			
			window.location.href = 'index.php?route=customer/customer_info&type=customercontact&customer_id='+ cid +'&token=<?php echo $token; ?>';
			
		},
		error: function(xhr, ajaxOptions, thrownError) {
			alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
		}
	});
 
 }
</script>
<script type="text/javascript"><!--
var address_row = <?php echo $address_row; ?>;

$(document).ready(function() {
  if ($('.nav-pills > li > a[style="color:#f56b6b;"]').length > 0) {
    $('.nav-pills > li > a[style="color:#f56b6b;"]').click();
  }
});

function addAddress() {
	
	$('#address-add').hide();
	
	html  = '<div class="tab-pane" id="tab-address' + address_row + '">';
	html += '  <input type="hidden" name="customer_contact[' + address_row + '][customer_con_id]" value="" />';
	html += '  <input type="hidden" name="customer_contact[<?php echo $address_row; ?>][customer_id]" value="<?php echo $customer_id ?>" id="input-customer_id" />';

	html += '  <div class="form-group required">';
	html += '    <label class="col-sm-2 control-label" for="input-firstname"><?php echo $entry_first_name; ?></label>';
	html += '    <div class="col-sm-10"><input type="text" name="customer_contact[' + address_row + '][first_name]" placeholder="<?php echo $entry_first_name; ?>" id="input-firstname' + address_row + '" class="form-control cstm" /></div>';
	html += '  </div>';
	
	html += '  <div class="form-group required">';
	html += '    <label class="col-sm-2 control-label" for="input-lastname"><?php echo $entry_last_name; ?></label>';
	html += '    <div class="col-sm-10"><input type="text" name="customer_contact[' + address_row + '][last_name]" placeholder="<?php echo $entry_last_name; ?>" id="input-lastname' + address_row + '" class="form-control cstm" /></div>';
	html += '  </div>';
	
	html += '  <div class="form-group required">';
	html += '    <label class="col-sm-2 control-label" for="input-email"><?php echo $entry_email; ?></label>';
	html += '    <div class="col-sm-10"><input type="text" name="customer_contact[' + address_row + '][email]" placeholder="<?php echo $entry_email; ?>" id="input-email' + address_row + '" class="form-control cstm" required /></div>';
	html += '  </div>';
	
	html += '  <div class="form-group">';
	html += '    <label class="col-sm-2 control-label" for="input-telephone_number"><?php echo $entry_telephone_number; ?></label>';
	html += '    <div class="col-sm-10"><input type="text" name="customer_contact[' + address_row + '][telephone_number]" placeholder="<?php echo $entry_telephone_number; ?>" id="input-telephone_number' + address_row + '" class="form-control" maxlength="10" /></div>';
	html += '  </div>';
	
	html += '  <div class="form-group">';
	html += '    <label class="col-sm-2 control-label" for="input-cellphone_number"><?php echo $entry_cellphone_number; ?></label>';
	html += '    <div class="col-sm-10"><input type="text" name="customer_contact[' + address_row + '][cellphone_number]" placeholder="<?php echo $entry_cellphone_number; ?>" id="input-email' + address_row + '" class="form-control" maxlength="10" /></div>';
	html += '  </div>';
	
	html += '  <div class="form-group">';
	html += '    <label class="col-sm-2 control-label" for="input-role"><?php echo $entry_role; ?></label>';
	html += '    <div class="col-sm-10"><input type="text" name="customer_contact[' + address_row + '][role]" placeholder="<?php echo $entry_role; ?>" id="input-role' + address_row + '" class="form-control" /></div>';
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
  
>>>>>>> origin/master
<?php echo $footer; ?> 