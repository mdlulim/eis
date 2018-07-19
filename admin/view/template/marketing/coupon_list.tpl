<?php echo $header; ?><?php echo $column_left; ?>
<div id="content">
  <div class="page-header">
    <div class="container-fluid">
      <div class="pull-right"><a href="<?php echo $add; ?>" data-toggle="tooltip" title="<?php echo $button_add; ?>" class="btn btn-primary"><i class="fa fa-plus"></i></a>
        <button type="button" data-toggle="tooltip" title="<?php echo $button_delete; ?>" class="btn btn-danger" onclick="confirm('<?php echo $text_confirm; ?>') ? $('#form-coupon').submit() : false;"><i class="fa fa-trash-o"></i></button>
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
            <div class="col-sm-6">
              <div class="form-group">
                <label class="control-label" for="input-name">Coupon Code</label>
                <input type="text" name="filter_code" value="<?php echo $filter_appointment_name; ?>" placeholder="Coupon Code" id="input-name" class="form-control" />
              </div>
              <div class="form-group fromdate">
                <label class="control-label" for="input-model">Date From</label>
                
                <div class='input-group date' id='filter_date_from'>
                    <input name="filter_date_from" type='text' value="<?php echo $filter_date_from; ?>"  placeholder="Date From" class="form-control" data-date-format="DD-MM-YYYY" class="form-control"  />
                    <span class="input-group-addon">
                        <span class="glyphicon glyphicon-calendar"></span>
                    </span>
                </div>
               
              </div>
            </div>
            <div class="col-sm-6">
              <div class="form-group">
                <label class="control-label" for="input-status">Status</label>
                <select name="filter_status" id="input-status" class="form-control">
                  <option value="*">Select Status</option>
                  <?php if ($filter_status) { ?>
                  <option value="1" selected="selected"><?php echo $text_enabled; ?></option>
                  <?php } else { ?>
                  <option value="1"><?php echo $text_enabled; ?></option>
                  <?php } ?>
                  <?php if (!$filter_status && !is_null($filter_status)) { ?>
                  <option value="0" selected="selected"><?php echo $text_disabled; ?></option>
                  <?php } else { ?>
                  <option value="0"><?php echo $text_disabled; ?></option>
                  <?php } ?>
                </select>
              </div>
              <div class="form-group todate">
                <label class="control-label" for="input-quantity">Date To</label>
                                  
                  <div class='input-group date' id='filter_date_to'>
                    <input name="filter_date_to" type='text' value="<?php echo $filter_date_to; ?>"  placeholder="Date To" class="form-control" data-date-format="DD-MM-YYYY" class="form-control"  />
                    <span class="input-group-addon">
                        <span class="glyphicon glyphicon-calendar"></span>
                    </span>
                </div>
              
              </div>
              <div class="form-group">
            		<button type="button" id="button-filter" class="btn btn-primary pull-right"><i class="fa fa-search"></i> Search</button>
            		<button type="button" id="button-filter-reset" class="btn btn-primary pull-right" style="margin-right:10px;"><i class="fa fa-refresh"></i> Reset</button>  
              </div>
            </div>
            
          </div>
           
        </div>
      
        <form action="<?php echo $delete; ?>" method="post" enctype="multipart/form-data" id="form-coupon">
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
                  <td class="text-left"><?php if ($sort == 'code') { ?>
                    <a href="<?php echo $sort_code; ?>" class="<?php echo strtolower($order); ?>"><?php echo $column_code; ?></a>
                    <?php } else { ?>
                    <a href="<?php echo $sort_code; ?>"><?php echo $column_code; ?></a>
                    <?php } ?></td>
                  <td class="text-left"><?php if ($sort == 'discount') { ?>
                    <a href="<?php echo $sort_discount; ?>" class="<?php echo strtolower($order); ?>"><?php echo $column_discount; ?></a>
                    <?php } else { ?>
                    <a href="<?php echo $sort_discount; ?>"><?php echo $column_discount; ?></a>
                    <?php } ?></td>
                  <td class="text-left"><?php if ($sort == 'date_start') { ?>
                    <a href="<?php echo $sort_date_start; ?>" class="<?php echo strtolower($order); ?>"><?php echo $column_date_start; ?></a>
                    <?php } else { ?>
                    <a href="<?php echo $sort_date_start; ?>"><?php echo $column_date_start; ?></a>
                    <?php } ?></td>
                  <td class="text-left"><?php if ($sort == 'date_end') { ?>
                    <a href="<?php echo $sort_date_end; ?>" class="<?php echo strtolower($order); ?>"><?php echo $column_date_end; ?></a>
                    <?php } else { ?>
                    <a href="<?php echo $sort_date_end; ?>"><?php echo $column_date_end; ?></a>
                    <?php } ?></td>
                  <td class="text-left"><?php if ($sort == 'status') { ?>
                    <a href="<?php echo $sort_status; ?>" class="<?php echo strtolower($order); ?>"><?php echo $column_status; ?></a>
                    <?php } else { ?>
                    <a href="<?php echo $sort_status; ?>"><?php echo $column_status; ?></a>
                    <?php } ?></td>
                  <td class="text-right"><?php echo $column_action; ?></td>
                </tr>
              </thead>
              <tbody>
                <?php if ($coupons) { ?>
                <?php foreach ($coupons as $coupon) { ?>
                <tr>
                  <td class="text-center"><?php if (in_array($coupon['coupon_id'], $selected)) { ?>
                    <input type="checkbox" name="selected[]" value="<?php echo $coupon['coupon_id']; ?>" checked="checked" />
                    <?php } else { ?>
                    <input type="checkbox" name="selected[]" value="<?php echo $coupon['coupon_id']; ?>" />
                    <?php } ?></td>
                  <td class="text-left"><?php echo $coupon['name']; ?></td>
                  <td class="text-left"><?php echo $coupon['code']; ?></td>
                  <td class="text-left"><?php echo $coupon['discount']; ?></td>
                  <td class="text-left"><?php echo $coupon['date_start']; ?></td>
                  <td class="text-left"><?php echo $coupon['date_end']; ?></td>
                  <td class="text-left"><?php echo $coupon['status']; ?></td>
                 <td class="text-right"><!--<a href="<?php echo $coupon['edit']; ?>" data-toggle="tooltip" title="<?php echo $button_edit; ?>" class="btn btn-primary"><i class="fa fa-pencil"></i></a>--><a href="<?php echo $coupon['view']; ?>" data-toggle="tooltip" title="View Coupon" class="btn btn-info"><i class="fa fa-eye"></i></a></td>
                </tr>
                <?php } ?>
                <?php } else { ?>
                <tr>
                  <td class="text-center" colspan="8"><?php echo $text_no_results; ?></td>
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
<style>
  .form-group + .form-group{border-top:none;}
  .glyphicon-calendar:before {content: "\e109" !important; }
  </style>
  <script type="text/javascript"><!--
$('#button-filter').on('click', function() {
	var url = 'index.php?route=marketing/coupon&token=<?php echo $token; ?>';

	var filter_code = $('input[name=\'filter_code\']').val();

	if (filter_code) {
		url += '&filter_code=' + encodeURIComponent(filter_code);
	}
	
	var filter_date_from = $('input[name=\'filter_date_from\']').val();

	if (filter_date_from) {
		url += '&filter_date_from=' + encodeURIComponent(filter_date_from);
	}
	
	var filter_date_to = $('input[name=\'filter_date_to\']').val();

	if (filter_date_to) {
		url += '&filter_date_to=' + encodeURIComponent(filter_date_to);
	}

	var filter_status = $('select[name=\'filter_status\']').val();

	if (filter_status != '*') {
		url += '&filter_status=' + encodeURIComponent(filter_status);
	}

	location = url;
});

$('#button-filter-reset').on('click', function() {
	
	var url = 'index.php?route=marketing/coupon&token=<?php echo $token; ?>';

	location = url;
});

$(function () 
{
		$('#filter_date_from').datetimepicker({
			 pickTime: false
		});
		
		$('#filter_date_to').datetimepicker({
			pickTime: false
		   
		});
				
});

//--></script>
<?php echo $footer; ?>
