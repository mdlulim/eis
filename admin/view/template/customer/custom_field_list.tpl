<?php echo $header; ?><?php echo $column_left; ?>
<div id="content">
  <div class="page-header">
    <div class="container-fluid">
      <div class="pull-right"><a href="<?php echo $add; ?>" data-toggle="tooltip" title="<?php echo $button_add; ?>" class="btn btn-primary"><i class="fa fa-plus"></i></a>
        <button type="button" data-toggle="tooltip" title="<?php echo $button_delete; ?>" class="btn btn-danger" onclick="confirm('<?php echo $text_confirm; ?>') ? $('#form-custom-field').submit() : false;"><i class="fa fa-trash-o"></i></button>
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
                <label class="control-label" for="input-name">Custom Field Name</label>
                <input type="text" name="filter_name" value="<?php echo $filter_name; ?>" placeholder="Custom Field Name" id="input-name" class="form-control" />
              </div>
            </div>
            <div class="col-sm-4">  
              <div class="form-group">
                <label class="control-label" for="input-price">Location</label>
                <select name="filter_location" class="form-control">
                	<option value="">Select Location</option>
                     <?php if ($filter_location == 'account') { ?>
                    <option value="account" selected="selected"><?php echo $text_account; ?></option>
                    <?php } else { ?>
                    <option value="account"><?php echo $text_account; ?></option>
                    <?php } ?>
                    <?php if ($filter_location == 'address') { ?>
                    <option value="address" selected="selected"><?php echo $text_address; ?></option>
                    <?php } else { ?>
                    <option value="address"><?php echo $text_address; ?></option>
                    <?php } ?>
                    
                </select>
              </div>
            </div>
            <div class="col-sm-4">
              
              <div class="form-group">
                <label class="control-label" for="input-price">Type</label>
                <select name="filter_type" id="input-type" class="form-control">
                	<option value="">Select Type</option>
                    <?php if ($filter_type == 'select') { ?>
                    <option value="select" selected="selected"><?php echo $text_select; ?></option>
                    <?php } else { ?>
                    <option value="select"><?php echo $text_select; ?></option>
                    <?php } ?>
                    <?php if ($filter_type == 'radio') { ?>
                    <option value="radio" selected="selected"><?php echo $text_radio; ?></option>
                    <?php } else { ?>
                    <option value="radio"><?php echo $text_radio; ?></option>
                    <?php } ?>
                    <?php if ($filter_type == 'checkbox') { ?>
                    <option value="checkbox" selected="selected"><?php echo $text_checkbox; ?></option>
                    <?php } else { ?>
                    <option value="checkbox"><?php echo $text_checkbox; ?></option>
                    <?php } ?>
                    <?php if ($filter_type == 'text') { ?>
                    <option value="text" selected="selected"><?php echo $text_text; ?></option>
                    <?php } else { ?>
                    <option value="text"><?php echo $text_text; ?></option>
                    <?php } ?>
                    <?php if ($filter_type == 'textarea') { ?>
                    <option value="textarea" selected="selected"><?php echo $text_textarea; ?></option>
                    <?php } else { ?>
                    <option value="textarea"><?php echo $text_textarea; ?></option>
                    <?php } ?>
                    <?php if ($filter_type == 'file') { ?>
                    <option value="file" selected="selected"><?php echo $text_file; ?></option>
                    <?php } else { ?>
                    <option value="file"><?php echo $text_file; ?></option>
                    <?php } ?>
                    <?php if ($filter_type == 'date') { ?>
                    <option value="date" selected="selected"><?php echo $text_date; ?></option>
                    <?php } else { ?>
                    <option value="date"><?php echo $text_date; ?></option>
                    <?php } ?>
                    <?php if ($filter_type == 'time') { ?>
                    <option value="time" selected="selected"><?php echo $text_time; ?></option>
                    <?php } else { ?>
                    <option value="time"><?php echo $text_time; ?></option>
                    <?php } ?>
                    <?php if ($filter_type == 'datetime') { ?>
                    <option value="datetime" selected="selected"><?php echo $text_datetime; ?></option>
                    <?php } else { ?>
                    <option value="datetime"><?php echo $text_datetime; ?></option>
                    <?php } ?>
                
              </select>
              </div>
              <div class="form-group">
            	<button type="button" id="button-filter" class="btn btn-primary pull-right"><i class="fa fa-search"></i> Search</button>
            	<button type="button" id="button-filter-reset" class="btn btn-primary pull-right" style="margin-right:10px;"><i class="fa fa-refresh"></i> Reset</button>
            </div>
              
            </div>
            
          </div>
           
        </div>
      
        <form action="<?php echo $delete; ?>" method="post" enctype="multipart/form-data" id="form-custom-field">
          <div class="table-responsive">
            <table class="table table-bordered table-hover">
              <thead>
                <tr>
                  <td style="width: 1px;" class="text-center"><input type="checkbox" onclick="$('input[name*=\'selected\']').prop('checked', this.checked);" /></td>
                  <td class="text-left" width="230"><?php if ($sort == 'cfd.name') { ?>
                    <a href="<?php echo $sort_name; ?>" class="<?php echo strtolower($order); ?>"><?php echo $column_name; ?></a>
                    <?php } else { ?>
                    <a href="<?php echo $sort_name; ?>"><?php echo $column_name; ?></a>
                    <?php } ?></td>
                  <td class="text-left" width="230"><?php if ($sort == 'cf.location') { ?>
                    <a href="<?php echo $sort_location; ?>" class="<?php echo strtolower($order); ?>"><?php echo $column_location; ?></a>
                    <?php } else { ?>
                    <a href="<?php echo $sort_location; ?>"><?php echo $column_location; ?></a>
                    <?php } ?></td>
                  <td class="text-left" width="230"><?php if ($sort == 'cf.type') { ?>
                    <a href="<?php echo $sort_type; ?>" class="<?php echo strtolower($order); ?>"><?php echo $column_type; ?></a>
                    <?php } else { ?>
                    <a href="<?php echo $sort_type; ?>"><?php echo $column_type; ?></a>
                    <?php } ?></td>
                  <td class="text-left" width="230"><?php if ($sort == 'cf.sort_order') { ?>
                    <a href="<?php echo $sort_sort_order; ?>" class="<?php echo strtolower($order); ?>"><?php echo $column_sort_order; ?></a>
                    <?php } else { ?>
                    <a href="<?php echo $sort_sort_order; ?>"><?php echo $column_sort_order; ?></a>
                    <?php } ?></td>
                  <td class="text-right"><?php echo $column_action; ?></td>
                </tr>
              </thead>
              <tbody>
                <?php if ($custom_fields) { ?>
                <?php foreach ($custom_fields as $custom_field) { ?>
                <tr>
                  <td class="text-center"><?php if (in_array($custom_field['custom_field_id'], $selected)) { ?>
                    <input type="checkbox" name="selected[]" value="<?php echo $custom_field['custom_field_id']; ?>" checked="checked" />
                    <?php } else { ?>
                    <input type="checkbox" name="selected[]" value="<?php echo $custom_field['custom_field_id']; ?>" />
                    <?php } ?></td>
                  <td class="text-left"><?php echo $custom_field['name']; ?></td>
                  <td class="text-left"><?php echo $custom_field['location']; ?></td>
                  <td class="text-left"><?php echo $custom_field['type']; ?></td>
                  <td class="text-left"><?php echo $custom_field['sort_order']; ?></td>
                  <td class="text-right"><!--<a href="<?php echo $custom_field['edit']; ?>" data-toggle="tooltip" title="<?php echo $button_edit; ?>" class="btn btn-primary"><i class="fa fa-pencil"></i></a>--><a href="<?php echo $custom_field['view']; ?>" data-toggle="tooltip" title="View Custom Field" class="btn btn-info"><i class="fa fa-eye"></i></a></td>
                </tr>
                <?php } ?>
                <?php } else { ?>
                <tr>
                  <td class="text-center" colspan="6"><?php echo $text_no_results; ?></td>
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
  </style>
<script type="text/javascript"><!--
$('#button-filter').on('click', function() {
	var url = 'index.php?route=customer/custom_field&token=<?php echo $token; ?>';
	
	var filter_name = $('input[name=\'filter_name\']').val();
	var filter_name = $.trim(filter_name);
	if (filter_name) {
		url += '&filter_name=' + encodeURIComponent(filter_name);
	}
	
	var filter_location = $('select[name=\'filter_location\']').val();

	if (filter_location) {
		url += '&filter_location=' + encodeURIComponent(filter_location);
	}
	
	var filter_type = $('select[name=\'filter_type\']').val();

	if (filter_type) {
		url += '&filter_type=' + encodeURIComponent(filter_type);
	}
	
//alert(url);
	location = url;
});

$('#button-filter-reset').on('click', function() {
	var url = 'index.php?route=customer/custom_field&token=<?php echo $token; ?>';
	location = url;
});
</script>
<?php echo $footer; ?>