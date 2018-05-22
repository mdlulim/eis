<<<<<<< HEAD
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
        
        <div class="well">
        	<h3>Filters</h3>
          <div class="row">
            <div class="col-sm-4">
              <div class="form-group">
                <label class="control-label" for="input-name">Customer Contact Name</label>
                
                	<select name="filter_customer_contact_id" class="form-control">
                	<option value="">Customer Contact Name</option>
                    <?php foreach ($allcustomer_contacts as $allcustomer_contact) {  ?>
                <?php if ($allcustomer_contact['customer_con_id'] == $filter_customer_contact_id) { ?>
                <option value="<?php echo $allcustomer_contact['customer_con_id']; ?>" selected="selected"><?php echo $allcustomer_contact['first_name']; ?> <?php echo $allcustomer_contact['last_name']; ?></option>
                <?php } else { ?>
                <option value="<?php echo $allcustomer_contact['customer_con_id']; ?>"><?php echo $allcustomer_contact['first_name']; ?> <?php echo $allcustomer_contact['last_name']; ?></option>
                <?php } ?>
                <?php } ?>
                    
                </select>
               </div> 
            </div>
            <div class="col-sm-4">  
              <div class="form-group">
                <label class="control-label" for="input-name">Customer Contact Email</label>
                
                <select name="filter_email" class="form-control">
                	<option value="">Customer Contact Email</option>
                    <?php foreach ($allcustomer_contacts as $allcustomer_contact) {  ?>
                <?php if ($allcustomer_contact['customer_con_id'] == $filter_email) { ?>
                <option value="<?php echo $allcustomer_contact['customer_con_id']; ?>" selected="selected"><?php echo $allcustomer_contact['email']; ?></option>
                <?php } else { ?>
                <option value="<?php echo $allcustomer_contact['customer_con_id']; ?>"><?php echo $allcustomer_contact['email']; ?></option>
                <?php } ?>
                <?php } ?>
                    
                </select>
              </div>
            </div>
            <div class="col-sm-3" style="margin-top:38px;">
            	<button type="button" id="button-filter" class="btn btn-primary pull-right"><i class="fa fa-search"></i> Search</button>
            	<button type="button" id="button-filter-reset" class="btn btn-primary pull-right" style="margin-right:10px;"><i class="fa fa-refresh"></i> Reset</button>
            </div>
          </div>
           
        </div>
        
        <form action="<?php echo $delete; ?>" method="post" enctype="multipart/form-data" id="form-user">
          <div class="table-responsive">
            <table class="table table-bordered table-hover">
              <thead>
                <tr>
                  <td class="text-left">Customer Contact Name</td>
                  <td class="text-left">Customer Contact Email</td>
                  
                  <td class="text-right"><?php echo $column_action; ?></td>
                </tr>
              </thead>
              <tbody>
                <?php if ($customer_contacts) { ?>
                    <?php foreach ($customer_contacts as $customer_contact) { ?>
                        
                            <tr>
                              <td class="text-left"><?php echo $customer_contact['name']; ?></td>
                              <td class="text-left"><?php echo $customer_contact['email']; ?></td>
                              <td class="text-right"><a href="<?php echo $customer_contact['view']; ?>" data-toggle="tooltip" title="View" class="btn btn-primary"><i class="fa fa-eye"></i></a></td>
                            </tr>
                     <?php } ?>
                <?php } else { ?>
                	<tr>
                        <td class="text-center" colspan="5"><?php echo $text_no_results; ?></td>
                    </tr>
                <?php } ?>
              </tbody>
            </table>
          </div>
        </form>
        <div class="row">
          <div class="col-sm-6 text-left"><?php echo $pagination; ?></div>
          <div class="col-sm-6 text-right"><?php echo $results; ?></div>
        </div>
      </div>
    </div>
  </div>
</div>
<script type="text/javascript"><!--
$('#button-filter').on('click', function() {
	var url = 'index.php?route=customer/customer_info&type=customercontact&customer_id=<?php echo $customer_id; ?>&token=<?php echo $token; ?>';

	var filter_customer_contact_id = $('select[name=\'filter_customer_contact_id\']').val();

	if (filter_customer_contact_id) {
		url += '&filter_customer_contact_id=' + encodeURIComponent(filter_customer_contact_id);
	}
	
	var filter_email = $('select[name=\'filter_email\']').val();

	if (filter_email) {
		url += '&filter_email=' + encodeURIComponent(filter_email);
	}

//alert(url);
	location = url;
});
$('#button-filter-reset').on('click', function() {
	var url = 'index.php?route=customer/customer_info&type=customercontact&customer_id=<?php echo $customer_id; ?>&token=<?php echo $token; ?>';

	location = url;
});
//--></script>
 <script type="text/javascript"><!--
$('input[name^=\'selected\']').on('change', function() {
	
	var selected = $('input[name^=\'selected\']:checked');

	if (selected.length) {
		$('#button-delete').prop('disabled', false);
	}

});

$('#button-delete').prop('disabled', true);

$('input[name^=\'selected\']:first').trigger('change');

//--></script> 
=======
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
        
        <div class="well">
        	<h3>Filters</h3>
          <div class="row">
            <div class="col-sm-4">
              <div class="form-group">
                <label class="control-label" for="input-name">Customer Contact Name</label>
                
                	<select name="filter_customer_contact_id" class="form-control">
                	<option value="">Customer Contact Name</option>
                    <?php foreach ($allcustomer_contacts as $allcustomer_contact) {  ?>
                <?php if ($allcustomer_contact['customer_con_id'] == $filter_customer_contact_id) { ?>
                <option value="<?php echo $allcustomer_contact['customer_con_id']; ?>" selected="selected"><?php echo $allcustomer_contact['first_name']; ?> <?php echo $allcustomer_contact['last_name']; ?></option>
                <?php } else { ?>
                <option value="<?php echo $allcustomer_contact['customer_con_id']; ?>"><?php echo $allcustomer_contact['first_name']; ?> <?php echo $allcustomer_contact['last_name']; ?></option>
                <?php } ?>
                <?php } ?>
                    
                </select>
               </div> 
            </div>
            <div class="col-sm-4">  
              <div class="form-group">
                <label class="control-label" for="input-name">Customer Contact Email</label>
                
                <select name="filter_email" class="form-control">
                	<option value="">Customer Contact Email</option>
                    <?php foreach ($allcustomer_contacts as $allcustomer_contact) {  ?>
                <?php if ($allcustomer_contact['customer_con_id'] == $filter_email) { ?>
                <option value="<?php echo $allcustomer_contact['customer_con_id']; ?>" selected="selected"><?php echo $allcustomer_contact['email']; ?></option>
                <?php } else { ?>
                <option value="<?php echo $allcustomer_contact['customer_con_id']; ?>"><?php echo $allcustomer_contact['email']; ?></option>
                <?php } ?>
                <?php } ?>
                    
                </select>
              </div>
            </div>
            <div class="col-sm-3" style="margin-top:38px;">
            	<button type="button" id="button-filter" class="btn btn-primary pull-right"><i class="fa fa-search"></i> Search</button>
            	<button type="button" id="button-filter-reset" class="btn btn-primary pull-right" style="margin-right:10px;"><i class="fa fa-refresh"></i> Reset</button>
            </div>
          </div>
           
        </div>
        
        <form action="<?php echo $delete; ?>" method="post" enctype="multipart/form-data" id="form-user">
          <div class="table-responsive">
            <table class="table table-bordered table-hover">
              <thead>
                <tr>
                  <td class="text-left">Customer Contact Name</td>
                  <td class="text-left">Customer Contact Email</td>
                  
                  <td class="text-right"><?php echo $column_action; ?></td>
                </tr>
              </thead>
              <tbody>
                <?php if ($customer_contacts) { ?>
                    <?php foreach ($customer_contacts as $customer_contact) { ?>
                        
                            <tr>
                              <td class="text-left"><?php echo $customer_contact['name']; ?></td>
                              <td class="text-left"><?php echo $customer_contact['email']; ?></td>
                              <td class="text-right"><a href="<?php echo $customer_contact['view']; ?>" data-toggle="tooltip" title="View" class="btn btn-primary"><i class="fa fa-eye"></i></a></td>
                            </tr>
                     <?php } ?>
                <?php } else { ?>
                	<tr>
                        <td class="text-center" colspan="5"><?php echo $text_no_results; ?></td>
                    </tr>
                <?php } ?>
              </tbody>
            </table>
          </div>
        </form>
        <div class="row">
          <div class="col-sm-6 text-left"><?php echo $pagination; ?></div>
          <div class="col-sm-6 text-right"><?php echo $results; ?></div>
        </div>
      </div>
    </div>
  </div>
</div>
<script type="text/javascript"><!--
$('#button-filter').on('click', function() {
	var url = 'index.php?route=customer/customer_info&type=customercontact&customer_id=<?php echo $customer_id; ?>&token=<?php echo $token; ?>';

	var filter_customer_contact_id = $('select[name=\'filter_customer_contact_id\']').val();

	if (filter_customer_contact_id) {
		url += '&filter_customer_contact_id=' + encodeURIComponent(filter_customer_contact_id);
	}
	
	var filter_email = $('select[name=\'filter_email\']').val();

	if (filter_email) {
		url += '&filter_email=' + encodeURIComponent(filter_email);
	}

//alert(url);
	location = url;
});
$('#button-filter-reset').on('click', function() {
	var url = 'index.php?route=customer/customer_info&type=customercontact&customer_id=<?php echo $customer_id; ?>&token=<?php echo $token; ?>';

	location = url;
});
//--></script>
 <script type="text/javascript"><!--
$('input[name^=\'selected\']').on('change', function() {
	
	var selected = $('input[name^=\'selected\']:checked');

	if (selected.length) {
		$('#button-delete').prop('disabled', false);
	}

});

$('#button-delete').prop('disabled', true);

$('input[name^=\'selected\']:first').trigger('change');

//--></script> 
>>>>>>> origin/master
<?php echo $footer; ?> 