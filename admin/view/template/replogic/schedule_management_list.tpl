<?php echo $header; ?><?php echo $column_left; ?>
<div id="content">
  <div class="page-header">
    <div class="container-fluid">
      <div class="pull-right"><a href="<?php echo $add; ?>" data-toggle="tooltip" title="<?php echo $button_add; ?>" class="btn btn-primary"><i class="fa fa-plus"></i></a>
        <button type="button" data-toggle="tooltip" title="<?php echo $button_delete; ?>" class="btn btn-danger" onclick="confirm('<?php echo $text_confirm; ?>') ? $('#form-user').submit() : false;"><i class="fa fa-trash-o"></i></button>
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
          <div class="row">
            <div class="col-sm-6">
              <div class="form-group">
                <label class="control-label" for="input-name">Appointment Name</label>
                <input type="text" name="filter_appointment_name" value="<?php echo $filter_appointment_name; ?>" placeholder="Appointment Name" id="input-name" class="form-control" />
              </div>
              <div class="form-group fromdate">
                <label class="control-label" for="input-model">Appointment Date From</label>
                <input type="text" name="filter_appointment_from" value="<?php echo $filter_appointment_from; ?>" placeholder="DD-MM-YYYY" data-date-format="DD-MM-YYYY" id="input-model" class="form-control" style="float:left;width:84%;" />
                <span class="input-group-btn" style="float:left;">
                  <button type="button" class="btn btn-default"><i class="fa fa-calendar"></i></button>
                  </span>
               
              </div>
            </div>
            <div class="col-sm-6" style="margin-bottom:10px;">
              <div class="form-group">
                <label class="control-label" for="input-price">Sales Rep Name</label>
                
                	<select name="filter_salesrep_id" id="input-sales_manager" class="form-control">
                        <option value="">Select Sales Rep Name</option>
                        <?php foreach ($salesReps as $salesRep) { ?>
                        <?php if ($salesRep['salesrep_id'] == $filter_salesrep_id) { ?>
                        <option value="<?php echo $salesRep['salesrep_id']; ?>" selected="selected"><?php echo $salesRep['salesrep_name']; ?> <?php echo $salesRep['salesrep_lastname']; ?></option>
                        <?php } else { ?>
                        <option value="<?php echo $salesRep['salesrep_id']; ?>"><?php echo $salesRep['salesrep_name']; ?> <?php echo $salesRep['salesrep_lastname']; ?></option>
                        <?php } ?>
                        <?php } ?>
                      </select>
              </div>
              <div class="form-group todate">
                <label class="control-label" for="input-quantity">Appointment Date To</label>
                <input type="text" name="filter_appointment_to" value="<?php echo $filter_appointment_to; ?>" placeholder="DD-MM-YYYY" data-date-format="DD-MM-YYYY" id="input-model" class="form-control" style="float:left;width:84%;" />
                <span class="input-group-btn" style="float:left;">
                  <button type="button" class="btn btn-default"><i class="fa fa-calendar"></i></button>
                  </span>
              </div>
            </div>
            <button type="button" id="button-filter" class="btn btn-primary pull-right"><i class="fa fa-filter"></i> Filter</button>
            <button type="button" id="button-filter-reset" class="btn btn-primary pull-right" style="margin-right:10px;"><i class="fa fa-filter"></i> Reset</button>
          </div>
           
        </div>
        
        <form action="<?php echo $delete; ?>" method="post" enctype="multipart/form-data" id="form-user">
          <div class="table-responsive">
            <table class="table table-bordered table-hover">
              <thead>
                <tr>
                  <td style="width: 1px;" class="text-center"><input type="checkbox" onclick="$('input[name*=\'selected\']').prop('checked', this.checked);" /></td>
                  <td class="text-left"><?php if ($sort == 'name') { ?>
                    <a href="<?php echo $sort_name; ?>" class="<?php echo strtolower($order); ?>"><?php echo $column_name; ?></a>
                    <?php } else { ?>
                    <a href="<?php echo $sort_name; ?>"><?php echo $column_name; ?></a>
                    <?php } ?></td>
                  <td class="text-left">Sales Rep Name</td>
                  <td class="text-left">Appointment Date</td>
                  
                  <td class="text-right"><?php echo $column_action; ?></td>
                </tr>
              </thead>
              <tbody>
                <?php if($access == 'yes') { ?>
                <?php if ($schedule_managements) { ?>
                    <?php foreach ($schedule_managements as $schedule_management) { ?>
                        
                            <tr>
                              <td class="text-center"><?php if (in_array($schedule_management['appointment_id'], $selected)) { ?>
                                <input type="checkbox" name="selected[]" value="<?php echo $schedule_management['appointment_id']; ?>" checked="checked" />
                                <?php } else { ?>
                                <input type="checkbox" name="selected[]" value="<?php echo $schedule_management['appointment_id']; ?>" />
                                <?php } ?></td>
                              <td class="text-left"><?php echo $schedule_management['appointment_name']; ?></td>
                              <td class="text-left"><?php echo $schedule_management['sales_manager']; ?></td>
                               <td class="text-left"><?php echo $schedule_management['appointment_date']; ?></td>
                              <td class="text-right"><a href="<?php echo $schedule_management['tasks']; ?>" data-toggle="tooltip" title="Tasks" class="btn btn-primary"><i class="fa fa-tasks"></i></a>&nbsp;<a href="<?php echo $schedule_management['notes']; ?>" data-toggle="tooltip" title="Notes" class="btn btn-primary"><i class="fa fa-sticky-note"></i></a>&nbsp;<a href="<?php echo $schedule_management['edit']; ?>" data-toggle="tooltip" title="<?php echo $button_edit; ?>" class="btn btn-primary"><i class="fa fa-pencil"></i></a></td>
                            </tr>
                     <?php } ?>
                    <?php } else { ?>
                    <tr>
                      <td class="text-center" colspan="5"><?php echo $text_no_results; ?></td>
                    </tr>
                    <?php } ?>
                <?php } else { ?>
                	<tr>
                        <td class="text-center" colspan="5">You Don't have Permission to access the Schedule Manegement.</td>
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
	var url = 'index.php?route=replogic/schedule_management&token=<?php echo $token; ?>';

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
	var url = 'index.php?route=replogic/schedule_management&token=<?php echo $token; ?>';

	location = url;
});
//--></script>
<script type="text/javascript"><!--
$('.fromdate').datetimepicker({
	pickTime: false,
	//defaultDate: new Date(),
    //format:'DD/MM/YYYY HH:mm'

});
$('.todate').datetimepicker({
	pickTime: false,
	//defaultDate: new Date(),
    //format:'DD/MM/YYYY HH:mm'

});
//--></script>
<?php echo $footer; ?> 