<?php echo $header; ?><?php echo $column_left; ?>

<div id="content">
  <div class="page-header">
    <div class="container-fluid">
      <div class="pull-right"><a href="<?php echo $cancel; ?>" data-toggle="tooltip" title="<?php echo $button_cancel; ?>" class="btn btn-default"><i class="fa fa-reply"></i></a>
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
            <li class="active"><a href="javascript:void()" >Appointment</a></li>
            <li><a href="<?php echo $customerstab; ?>" >Customer Contact</a></li>
            <li><a href="<?php echo $visitstab; ?>" >Visits</a></li>
            <li><a href="<?php echo $orderstab; ?>" >Orders</a></li>
            <li><a href="<?php echo $quotestab; ?>" >Quotes</a></li>
            
          </ul>
        
        <div class="well">
          <div class="row">
            <div class="col-sm-6">
              <!--<div class="form-group">
                <label class="control-label" for="input-name">Appointment Name</label>
                <input type="text" name="filter_appointment_name" value="<?php echo $filter_appointment_name; ?>" placeholder="Appointment Name" id="input-name" class="form-control" />
              </div>-->
              <div class="form-group fromdate">
                <label class="control-label" for="input-model">Appointment Date From</label>
                
                <div class='input-group date' id='filter_appointment_from'>
                    <input name="filter_appointment_from" type='text' value="<?php echo $filter_appointment_from; ?>"  placeholder="DD-MM-YYYY hh:mm A" class="form-control" data-date-format="DD-MM-YYYY hh:mm A" class="form-control"  />
                    <span class="input-group-addon">
                        <span class="glyphicon glyphicon-calendar"></span>
                    </span>
                </div>
           <style>
		   .glyphicon-calendar:before {content: "\e109" !important; }
		   </style>
            	<script type="text/javascript">
            $(function () {
                $('#filter_appointment_from').datetimepicker({
                     //defaultDate: new Date(),
					// inline: true,
                });
            });
        </script>  
               
              </div>
              <!--<div class="form-group">
                <label class="control-label" for="input-price">Customer</label>
                <select name="filter_customer_id" class="form-control">
                	<option value="">Select Customer</option>
                    <?php foreach ($customers as $customer) {  ?>
                <?php if ($customer['customer_id'] == $filter_customer_id) { ?>
                <option value="<?php echo $customer['customer_id']; ?>" selected="selected"><?php echo $customer['firstname']; ?></option>
                <?php } else { ?>
                <option value="<?php echo $customer['customer_id']; ?>"><?php echo $customer['firstname']; ?></option>
                <?php } ?>
                <?php } ?>
                    
                </select>
              </div>-->
            </div>
            <div class="col-sm-6" style="margin-bottom:10px;">
              
              <div class="form-group todate">
                <label class="control-label" for="input-quantity">Appointment Date To</label>
                <!--<input type="text" name="filter_appointment_to" value="<?php echo $filter_appointment_to; ?>" placeholder="DD-MM-YYYY" data-date-format="DD-MM-YYYY" id="input-model" class="form-control" style="float:left;width:84%;" />
                <span class="input-group-btn" style="float:left;">
                  <button type="button" class="btn btn-default"><i class="fa fa-calendar"></i></button>
                  </span>-->
                  
                  <div class='input-group date' id='filter_appointment_to'>
                    <input name="filter_appointment_to" type='text' value="<?php echo $filter_appointment_to; ?>"  placeholder="DD-MM-YYYY hh:mm A" class="form-control" data-date-format="DD-MM-YYYY hh:mm A" class="form-control"  />
                    <span class="input-group-addon">
                        <span class="glyphicon glyphicon-calendar"></span>
                    </span>
                </div>
            
        		<script type="text/javascript">
            $(function () {
                $('#filter_appointment_to').datetimepicker({
                    //defaultDate: new Date(),
                   
                });
            });
        </script>
                  
              </div>
            </div>
            <button type="button" id="button-filter" class="btn btn-primary pull-right"><i class="fa fa-filter"></i> Filter</button>
            <button type="button" id="button-filter-reset" class="btn btn-primary pull-right" style="margin-right:10px;"><i class="fa fa-refresh"></i> Reset</button>
          </div>
           
        </div>
        
        <form action="<?php echo $delete; ?>" method="post" enctype="multipart/form-data" id="form-user">
          <div class="table-responsive">
            <table class="table table-bordered table-hover">
              <thead>
                <tr>
                  <td class="text-left"><?php if ($sort == 'name') { ?>
                    <a href="<?php echo $sort_name; ?>" class="<?php echo strtolower($order); ?>">Appointment Name</a>
                    <?php } else { ?>
                    <a href="<?php echo $sort_name; ?>">Appointment Name</a>
                    <?php } ?></td>
                  
                  <td class="text-left"><?php if ($sort == 'salesrepname') { ?>
                    <a href="<?php echo $sort_salesrepname; ?>" class="<?php echo strtolower($order); ?>">Sales Rep Name</a>
                    <?php } else { ?>
                    <a href="<?php echo $sort_salesrepname; ?>">Sales Rep Name</a>
                    <?php } ?></td>
                  <!--<td class="text-left"><?php if ($sort == 'type') { ?>
                    <a href="<?php echo $sort_type; ?>" class="<?php echo strtolower($order); ?>">Business Type</a>
                    <?php } else { ?>
                    <a href="<?php echo $sort_type; ?>">Business Type</a>
                    <?php } ?></td>-->
                  <td class="text-left"><?php if ($sort == 'appointment_date') { ?>
                    <a href="<?php echo $sort_appointment_date; ?>" class="<?php echo strtolower($order); ?>">Appointment Date</a>
                    <?php } else { ?>
                    <a href="<?php echo $sort_appointment_date; ?>">Appointment Date</a>
                    <?php } ?></td>
                  
                  <td class="text-right"><?php echo $column_action; ?></td>
                </tr>
              </thead>
              <tbody>
                <?php if($access == 'yes') { ?>
                <?php if ($schedule_managements) { ?>
                    <?php foreach ($schedule_managements as $schedule_management) { ?>
                        
                            <tr>
                              <td class="text-left"><?php echo $schedule_management['appointment_name']; ?></td>
                              <td class="text-left"><?php echo $schedule_management['sales_manager']; ?></td>
                             <!-- <td class="text-left"><?php echo $schedule_management['type']; ?></td>-->
                              <td class="text-left"><?php  echo $schedule_management['appointment_date']; ?></td>
                              <td class="text-right"><a href="<?php echo $schedule_management['view']; ?>" data-toggle="tooltip" title="View" class="btn btn-info"><i class="fa fa-eye"></i></a></td>
                            </tr>
                     <?php } ?>
                    <?php } else { ?>
                    <tr>
                      <td class="text-center" colspan="5"><?php echo $text_no_results; ?></td>
                    </tr>
                    <?php } ?>
                <?php } else { ?>
                	<tr>
                        <td class="text-center" colspan="5">You Don't have Permission to access the Appointment Manegement.</td>
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
	var url = 'index.php?route=customer/customer_info&type=appointment&customer_id=<?php echo $customer_id; ?>&token=<?php echo $token; ?>';

	var filter_appointment_name = $('input[name=\'filter_appointment_name\']').val();

	if (filter_appointment_name) {
		url += '&filter_appointment_name=' + encodeURIComponent(filter_appointment_name);
	}

	var filter_salesrep_id = $('select[name=\'filter_salesrep_id\']').val();

	if (filter_salesrep_id) {
		url += '&filter_salesrep_id=' + encodeURIComponent(filter_salesrep_id);
	}
	
	var filter_appointment_from = $('input[name=\'filter_appointment_from\']').val();

	if (filter_appointment_from) {
		url += '&filter_appointment_from=' + encodeURIComponent(filter_appointment_from);
	}
	
	var filter_appointment_to = $('input[name=\'filter_appointment_to\']').val();

	if (filter_appointment_to) {
		url += '&filter_appointment_to=' + encodeURIComponent(filter_appointment_to);
	}

	var filter_appointment_to = $('input[name=\'filter_appointment_to\']').val();
//alert(url);
	location = url;
});
$('#button-filter-reset').on('click', function() {
	var url = 'index.php?route=customer/customer_info&type=appointment&customer_id=<?php echo $customer_id; ?>&token=<?php echo $token; ?>';

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