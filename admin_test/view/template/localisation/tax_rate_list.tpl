<?php echo $header; ?><?php echo $column_left; ?>
<div id="content">
  <div class="page-header">
    <div class="container-fluid">
      <div class="pull-right"><a href="<?php echo $add; ?>" data-toggle="tooltip" title="<?php echo $button_add; ?>" class="btn btn-primary"><i class="fa fa-plus"></i></a>
        <button type="button" data-toggle="tooltip" title="<?php echo $button_delete; ?>" class="btn btn-danger" onclick="confirm('<?php echo $text_confirm; ?>') ? $('#form-tax-rate').submit() : false;"><i class="fa fa-trash-o"></i></button>
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
                <label class="control-label" for="input-order-id"><?php echo $column_name; ?></label>
                <select name="filter_name" class="form-control">
                	<option value="">Select Tax Name</option>
                    <?php foreach ($Dropdownnames as $Dname) {  ?>
                <?php if ($Dname['name'] == $filter_name) { ?>
                <option value="<?php echo $Dname['name']; ?>" selected="selected"><?php echo $Dname['name']; ?></option>
                <?php } else { ?>
                <option value="<?php echo $Dname['name']; ?>"><?php echo $Dname['name']; ?></option>
                <?php } ?>
                <?php } ?>
                    
                </select>
              </div>
              <div class="form-group">
                <label class="control-label" for="input-customer">Tax Type</label>
                <select name="filter_type" class="form-control">
                	<option value="">Select Tax Type</option>
                     <?php if ($filter_type == 'P') { ?>
                    <option value="P" selected="selected"><?php echo $text_percent; ?></option>
                    <?php } else { ?>
                    <option value="P"><?php echo $text_percent; ?></option>
                    <?php } ?>
                    <?php if ($filter_type == 'F') { ?>
                    <option value="F" selected="selected"><?php echo $text_amount; ?></option>
                    <?php } else { ?>
                    <option value="F"><?php echo $text_amount; ?></option>
                    <?php } ?>
                    
                </select>
              </div>
            </div>
            <div class="col-sm-4">
              <div class="form-group">
                <label class="control-label" for="input-order-status">Geo Location</label>
                <select name="filter_geozone" class="form-control">
                	<option value="">Select Geo Location</option>
                    <?php foreach ($Dropdown_geozones as $Dgeozone) {  ?>
                <?php if ($Dgeozone['geo_zone_id'] == $filter_geozone) { ?>
                <option value="<?php echo $Dgeozone['geo_zone_id']; ?>" selected="selected"><?php echo $Dgeozone['name']; ?></option>
                <?php } else { ?>
                <option value="<?php echo $Dgeozone['geo_zone_id']; ?>"><?php echo $Dgeozone['name']; ?></option>
                <?php } ?>
                <?php } ?>
                    
                </select>
              </div>
              <div class="form-group">
                <label class="control-label" for="input-date-modified">Date Modified</label>
                <div class="input-group date">
                  <input type="text" name="filter_date_modified" value="<?php echo $filter_date_modified; ?>" placeholder="Date Modified" data-date-format="DD-MM-YYYY" id="input-date-modified" class="form-control" />
                  <span class="input-group-btn">
                  <button type="button" class="btn btn-default"><i class="fa fa-calendar"></i></button>
                  </span></div>
              </div>
            </div>
            <div class="col-sm-4">
              <div class="form-group">
                <label class="control-label" for="input-date-added">Date Added</label>
                <div class="input-group date">
                  <input type="text" name="filter_date_added" value="<?php echo $filter_date_added; ?>" placeholder="Date Added" data-date-format="DD-MM-YYYY" id="input-date-added" class="form-control" />
                  <span class="input-group-btn">
                  <button type="button" class="btn btn-default"><i class="fa fa-calendar"></i></button>
                  </span></div>
              </div>
              
              <button type="button" id="button-filter" class="btn btn-primary pull-right"><i class="fa fa-search"></i> Search</button>
              <button type="button" id="button-filter-reset" class="btn btn-primary pull-right" style="margin-right:10px;"><i class="fa fa-refresh"></i> Reset</button>
            </div>
          </div>
        </div>
      
        <form action="<?php echo $delete; ?>" method="post" enctype="multipart/form-data" id="form-tax-rate">
          <div class="table-responsive">
            <table class="table table-bordered table-hover">
              <thead>
                <tr>
                  <td style="width: 1px;" class="text-center"><input type="checkbox" onclick="$('input[name*=\'selected\']').prop('checked', this.checked);" /></td>
                  <td class="text-left"><?php if ($sort == 'tr.name') { ?>
                    <a href="<?php echo $sort_name; ?>" class="<?php echo strtolower($order); ?>"><?php echo $column_name; ?></a>
                    <?php } else { ?>
                    <a href="<?php echo $sort_name; ?>"><?php echo $column_name; ?></a>
                    <?php } ?></td>
                  <td class="text-right"><?php if ($sort == 'tr.rate') { ?>
                    <a href="<?php echo $sort_rate; ?>" class="<?php echo strtolower($order); ?>"><?php echo $column_rate; ?></a>
                    <?php } else { ?>
                    <a href="<?php echo $sort_rate; ?>"><?php echo $column_rate; ?></a>
                    <?php } ?></td>
                  <td class="text-left"><?php if ($sort == 'tr.type') { ?>
                    <a href="<?php echo $sort_type; ?>" class="<?php echo strtolower($order); ?>"><?php echo $column_type; ?></a>
                    <?php } else { ?>
                    <a href="<?php echo $sort_type; ?>"><?php echo $column_type; ?></a>
                    <?php } ?></td>
                  <td class="text-left"><?php if ($sort == 'gz.name') { ?>
                    <a href="<?php echo $sort_geo_zone; ?>" class="<?php echo strtolower($order); ?>"><?php echo $column_geo_zone; ?></a>
                    <?php } else { ?>
                    <a href="<?php echo $sort_geo_zone; ?>"><?php echo $column_geo_zone; ?></a>
                    <?php } ?></td>
                  <td class="text-left"><?php if ($sort == 'tr.date_added') { ?>
                    <a href="<?php echo $sort_date_added; ?>" class="<?php echo strtolower($order); ?>"><?php echo $column_date_added; ?></a>
                    <?php } else { ?>
                    <a href="<?php echo $sort_date_added; ?>"><?php echo $column_date_added; ?></a>
                    <?php } ?></td>
                  <td class="text-left"><?php if ($sort == 'tr.date_modified') { ?>
                    <a href="<?php echo $sort_date_modified; ?>" class="<?php echo strtolower($order); ?>"><?php echo $column_date_modified; ?></a>
                    <?php } else { ?>
                    <a href="<?php echo $sort_date_modified; ?>"><?php echo $column_date_modified; ?></a>
                    <?php } ?></td>
                  <td class="text-right"><?php echo $column_action; ?></td>
                </tr>
              </thead>
              <tbody>
                <?php if ($tax_rates) { ?>
                <?php foreach ($tax_rates as $tax_rate) { ?>
                <tr>
                  <td class="text-center"><?php if (in_array($tax_rate['tax_rate_id'], $selected)) { ?>
                    <input type="checkbox" name="selected[]" value="<?php echo $tax_rate['tax_rate_id']; ?>" checked="checked" />
                    <?php } else { ?>
                    <input type="checkbox" name="selected[]" value="<?php echo $tax_rate['tax_rate_id']; ?>" />
                    <?php } ?></td>
                  <td class="text-left"><?php echo $tax_rate['name']; ?></td>
                  <td class="text-right"><?php echo $tax_rate['rate']; ?></td>
                  <td class="text-left"><?php echo $tax_rate['type']; ?></td>
                  <td class="text-left"><?php echo $tax_rate['geo_zone']; ?></td>
                  <td class="text-left"><?php echo $tax_rate['date_added']; ?></td>
                  <td class="text-left"><?php echo $tax_rate['date_modified']; ?></td>
                  <td class="text-right"><a href="<?php echo $tax_rate['edit']; ?>" data-toggle="tooltip" title="<?php echo $button_edit; ?>" class="btn btn-primary"><i class="fa fa-pencil"></i></a></td>
                </tr>
                <?php } ?>
                <?php } else { ?>
                <tr>
                  <td class="text-center" colspan="9"><?php echo $text_no_results; ?></td>
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
	url = 'index.php?route=localisation/tax_rate&token=<?php echo $token; ?>';

	var filter_name = $('select[name=\'filter_name\']').val();

	if (filter_name) {
		url += '&filter_name=' + encodeURIComponent(filter_name);
	}

	var filter_type = $('select[name=\'filter_type\']').val();

	if (filter_type) {
		url += '&filter_type=' + encodeURIComponent(filter_type);
	}
	
	var filter_geozone = $('select[name=\'filter_geozone\']').val();

	if (filter_geozone) {
		url += '&filter_geozone=' + encodeURIComponent(filter_geozone);
	}

	var filter_date_added = $('input[name=\'filter_date_added\']').val();

	if (filter_date_added) {
		url += '&filter_date_added=' + encodeURIComponent(filter_date_added);
	}

	var filter_date_modified = $('input[name=\'filter_date_modified\']').val();

	if (filter_date_modified) {
		url += '&filter_date_modified=' + encodeURIComponent(filter_date_modified);
	}

	location = url;
});
$('#button-filter-reset').on('click', function() {
	
	var url = 'index.php?route=localisation/tax_rate&token=<?php echo $token; ?>';

	location = url;
});

$('.date').datetimepicker({
	pickTime: false
});
//--></script>  
<?php echo $footer; ?>