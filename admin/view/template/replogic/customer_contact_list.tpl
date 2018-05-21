<?php echo $header; ?><?php echo $column_left; ?>
<div id="content">
  <div class="page-header">
    <div class="container-fluid">
      <div class="pull-right"><a href="<?php echo $add; ?>" data-toggle="tooltip" title="<?php echo $button_add; ?>" class="btn btn-primary"><i class="fa fa-plus"></i></a>
        <button type="button" data-toggle="tooltip" id="button-delete" title="<?php echo $button_delete; ?>" class="btn btn-danger" onclick="confirm('<?php echo $text_confirm; ?>') ? $('#form-user').submit() : false;"><i class="fa fa-trash-o"></i></button>
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
        <h3 class="panel-title"><i class="fa fa-list"></i> <?php echo $text_list; ?></h3>
      </div>
      <div class="panel-body">
        
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
                <label class="control-label" for="input-name">Email</label>
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
            <div class="col-sm-4">
              <div class="form-group">
                <label class="control-label" for="input-price">Customer Name</label>
                <select name="filter_customer_id" class="form-control">
                	<option value="">Select Customer Name</option>
                    <?php foreach ($customers as $customer) {  ?>
                <?php if ($customer['customer_id'] == $filter_customer_id) { ?>
                <option value="<?php echo $customer['customer_id']; ?>" selected="selected"><?php echo $customer['firstname']; ?></option>
                <?php } else { ?>
                <option value="<?php echo $customer['customer_id']; ?>"><?php echo $customer['firstname']; ?></option>
                <?php } ?>
                <?php } ?>
                    
                </select>
              </div>
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
                  <td style="width: 1px;" class="text-center"><input type="checkbox" onclick="$('input[name*=\'selected\']').prop('checked', this.checked);" /></td>
                  <td class="text-left"><?php echo $column_name; ?></td>
                  <td class="text-left">Customer Name</td>
                  <td class="text-left">Email</td>
                  
                  <td class="text-right"><?php echo $column_action; ?></td>
                </tr>
              </thead>
              <tbody>
                <?php if ($customer_contacts) { ?>
                    <?php foreach ($customer_contacts as $customer_contact) { ?>
                        
                            <tr>
                              <td class="text-center"><?php if (in_array($customer_contact['salesrep_id'], $selected)) { ?>
                                <input type="checkbox" name="selected[]" value="<?php echo $customer_contact['customer_con_id']; ?>" checked="checked" />
                                <?php } else { ?>
                                <input type="checkbox" name="selected[]" value="<?php echo $customer_contact['customer_con_id']; ?>" />
                                <?php } ?></td>
                              <td class="text-left"><?php echo $customer_contact['name']; ?></td>
                              <td class="text-left"><?php echo $customer_contact['customer']; ?></td>
                              <td class="text-left"><?php echo $customer_contact['email']; ?></td>
                              <td class="text-right"><a href="<?php echo $customer_contact['view']; ?>" data-toggle="tooltip" title="View" class="btn btn-info"><i class="fa fa-eye"></i></a>&nbsp;<a href="<?php echo $customer_contact['edit']; ?>" data-toggle="tooltip" title="<?php echo $button_edit; ?>" class="btn btn-primary"><i class="fa fa-pencil"></i></a></td>
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
	var url = 'index.php?route=replogic/customer_contact&token=<?php echo $token; ?>';

	var filter_customer_contact_id = $('select[name=\'filter_customer_contact_id\']').val();

	if (filter_customer_contact_id) {
		url += '&filter_customer_contact_id=' + encodeURIComponent(filter_customer_contact_id);
	}
	
	var filter_email = $('select[name=\'filter_email\']').val();

	if (filter_email) {
		url += '&filter_email=' + encodeURIComponent(filter_email);
	}

	var filter_customer_id = $('select[name=\'filter_customer_id\']').val();

	if (filter_customer_id) {
		url += '&filter_customer_id=' + encodeURIComponent(filter_customer_id);
	}

//alert(url);
	location = url;
});
$('#button-filter-reset').on('click', function() {
	var url = 'index.php?route=replogic/customer_contact&token=<?php echo $token; ?>';

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
<?php echo $footer; ?> 