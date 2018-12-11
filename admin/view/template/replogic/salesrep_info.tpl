<?php echo $header; ?><?php echo $column_left; ?>
<div id="content">
  <div class="page-header">
    <div class="container-fluid">
      <div class="pull-right">
        <a href="<?php echo $edit; ?>" data-toggle="tooltip" title="<?php echo $button_edit; ?>" class="btn btn-primary"><i class="fa fa-pencil"></i></a>
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
        <h3 class="panel-title"><i class="fa fa-info-circle" style="font-size:23px;"></i> <?php echo $text_list; ?><strong><?php echo $salesrepname; ?></strong></h3>
      </div>
      <div class="panel-body">
        
        <ul class="nav nav-tabs">
            <li class="active"><a href="javascript:void()">General</a></li>
            <li><a href="<?php echo $appointmenttab; ?>" >Appointment</a></li>
            <li><a href="<?php echo $customerstab; ?>" >Customers</a></li>
            <li><a href="<?php echo $visitstab; ?>" >Visits</a></li>
            <li><a href="<?php echo $orderstab; ?>" >Orders</a></li>
            <li><a href="<?php echo $quotestab; ?>" >Quotes</a></li>
            
          </ul>
          
       <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" id="form-user" class="form-horizontal">
         
          <div class="form-group">
            <label class="col-sm-2 control-label" for="input-username">Sales Rep First Name</label>
            <div class="col-sm-10">
              <input type="text" name="salesrep_name" value="<?php echo $salesrepinfo['salesrep_name']; ?>" class="form-control" disabled="disabled" />
            </div>
          </div>
         
          <div class="form-group">
            <label class="col-sm-2 control-label" for="input-username">Sales Rep Last Name</label>
            <div class="col-sm-10">
              <input type="text" name="salesrep_name" value="<?php echo $salesrepinfo['salesrep_lastname']; ?>" class="form-control" disabled="disabled" />
            </div>
          </div>
          
          <div class="form-group">
            <label class="col-sm-2 control-label" for="input-username">Team Name</label>
            <div class="col-sm-10">
              <input type="text" value="<?php echo $teamname; ?>" class="form-control" disabled="disabled" />
            </div>
          </div>
          
          <div class="form-group">
            <label class="col-sm-2 control-label" for="input-username">Email</label>
            <div class="col-sm-10">
              <input type="text" value="<?php echo $salesrepinfo['email']; ?>" class="form-control" disabled="disabled" />
            </div>
          </div>
          
          <div class="form-group">
            <label class="col-sm-2 control-label" for="input-username">Telephone Number</label>
            <div class="col-sm-10">
              <input type="text" value="<?php echo $salesrepinfo['tel']; ?>" class="form-control" disabled="disabled" />
            </div>
          </div>
          
          <div class="form-group">
            <label class="col-sm-2 control-label" for="input-username">Cell Number</label>
            <div class="col-sm-10">
              <input type="text" value="<?php echo $salesrepinfo['cell']; ?>" class="form-control" disabled="disabled" />
            </div>
          </div>

          <?php if ($show_resend_password) { ?>
          <div class="form-group">
            <div class="col-sm-10 col-sm-push-2">
              <a href="javascript:void()" class="btn btn-default" id="resend-password" data-repname="<?php echo $salesrepinfo['salesrep_name']; ?>" data-salesrep-id="<?php echo $salesrepinfo['salesrep_id']; ?>" data-token='<?php echo $token; ?>'>
                <i class="fa fa-send"></i>
                Resend Password
              </a>
            </div>
          </div>
          <?php } ?>
          
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
$('#button-filter').on('click', function() {
	var url = 'index.php?route=replogic/sales_rep_management&token=<?php echo $token; ?>';

	var filter_sales_rep_name = $('input[name=\'filter_sales_rep_name\']').val();
	
	var filter_sales_rep_name = $.trim(filter_sales_rep_name);
	if (filter_sales_rep_name) {
		url += '&filter_sales_rep_name=' + encodeURIComponent(filter_sales_rep_name);
	}

	var team_id = $('select[name=\'filter_team_id\']').val();

	if (team_id) {
		url += '&filter_team_id=' + encodeURIComponent(team_id);
	}
	
	var filter_customer_id = $('select[name=\'filter_customer_id\']').val();

	if (filter_customer_id) {
		url += '&filter_customer_id=' + encodeURIComponent(filter_customer_id);
	}

	var filter_email = $('input[name=\'filter_email\']').val();
	var filter_email = $.trim(filter_email);
	if (filter_email) {
		url += '&filter_email=' + encodeURIComponent(filter_email);
	}
	
//alert(url);
	location = url;
});
$('#button-filter-reset').on('click', function() {
	<?php if($_REQUEST['team_id']) { ?>
	var team_id = $('input[name=\'team_id\']').val();
	var url = 'index.php?route=replogic/sales_rep_management&token=<?php echo $token; ?>&team_id=' + team_id + '';
	<?php } else { ?>
	var url = 'index.php?route=replogic/sales_rep_management&token=<?php echo $token; ?>';
	<?php } ?>

	location = url;
});
//--></script>
<script type="text/javascript"><!--
$('input[name^=\'selected\']').on('change', function() {
	
	var selected = $('input[name^=\'selected\']:checked');

	if (selected.length) {
		$('#button-delete').prop('disabled', false);
		$('#popup').prop('disabled', false);
		$('#popupunassign').prop('disabled', false);
	}

});

$('#button-delete').prop('disabled', true);
$('#popup').prop('disabled', true);
$('#popupunassign').prop('disabled', true);

$('input[name^=\'selected\']:first').trigger('change');

//--></script> 
<?php echo $footer; ?> 