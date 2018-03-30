<?php echo $header; ?><?php echo $column_left; ?>
<div id="content">
  <div class="page-header">
    <div class="container-fluid">
      <div class="pull-right"><!--<a href="<?php echo $refresh; ?>" data-toggle="tooltip" title="<?php echo $button_currency; ?>" class="btn btn-warning"><i class="fa fa fa-refresh"></i></a>--> <a href="<?php echo $add; ?>" data-toggle="tooltip" title="<?php echo $button_add; ?>" class="btn btn-primary"><i class="fa fa-plus"></i></a>
        <button type="button" data-toggle="tooltip" title="<?php echo $button_delete; ?>" class="btn btn-danger" onclick="confirm('<?php echo $text_confirm; ?>') ? $('#form-currency').submit() : false;"><i class="fa fa-trash-o"></i></button>
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
        <h3 class="panel-title"><i class="fa fa-money"></i> <?php echo $text_list; ?></h3>
      </div>
      <div class="panel-body">
      
      	<div class="well">
        	<h3>Filters</h3>
          <div class="row">
            <div class="col-sm-4">
              <div class="form-group">
                <label class="control-label" for="input-name">Currency Title</label>
                <select name="filter_title" id="input-name" class="form-control">
                  <option value="*">Select Currency</option>
                   <?php foreach($DropdownCurrencys as $DCurrency) { ?>
                  	<?php if($DCurrency['title'] == $filter_title ) { ?>
                      <option value="<?php echo $DCurrency['title']; ?>" selected="selected"><?php echo $DCurrency['title']; ?></option>
                      <?php } else { ?>
                      <option value="<?php echo $DCurrency['title']; ?>"><?php echo $DCurrency['title']; ?></option>
                      <?php } ?>
                  <?php } ?>
                </select>
              </div>
            </div>
            <div class="col-sm-4">
              <div class="form-group">
                <label class="control-label" for="input-model">Last Updated</label>
                <div class='input-group date' id='filter_dateupdated'>
                    <input name="filter_dateupdated" type='text' value="<?php echo $filter_dateupdated; ?>"  placeholder="Last Updated" class="form-control" data-date-format="DD-MM-YYYY" class="form-control"  />
                    <span class="input-group-addon">
                        <span class="glyphicon glyphicon-calendar"></span>
                    </span>
                </div>
               
              </div>
            </div>
            <div class="col-sm-4">
              <div class="form-group">
                <label class="control-label" for="input-name">Currency Code</label>
                <select name="filter_code" id="input-name" class="form-control">
                  <option value="*">Select Currency Code</option>
                  <?php foreach($DropdownCurrencys as $DCurrency) { ?>
                  	<?php if($DCurrency['code'] == $filter_code) { ?>
                      <option value="<?php echo $DCurrency['code']; ?>" selected="selected"><?php echo $DCurrency['code']; ?></option>
                      <?php } else { ?>
                      <option value="<?php echo $DCurrency['code']; ?>"><?php echo $DCurrency['code']; ?></option>
                      <?php } ?>
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
      
        <form action="<?php echo $delete; ?>" method="post" enctype="multipart/form-data" id="form-currency">
          <div class="table-responsive">
            <table class="table table-bordered table-hover">
              <thead>
                <tr>
                  <td style="width: 1px;" class="text-center"><input type="checkbox" onclick="$('input[name*=\'selected\']').prop('checked', this.checked);" /></td>
                  <td class="text-left"><?php if ($sort == 'title') { ?>
                    <a href="<?php echo $sort_title; ?>" class="<?php echo strtolower($order); ?>"><?php echo $column_title; ?></a>
                    <?php } else { ?>
                    <a href="<?php echo $sort_title; ?>"><?php echo $column_title; ?></a>
                    <?php } ?></td>
                  <td class="text-left"><?php if ($sort == 'code') { ?>
                    <a href="<?php echo $sort_code; ?>" class="<?php echo strtolower($order); ?>"><?php echo $column_code; ?></a>
                    <?php } else { ?>
                    <a href="<?php echo $sort_code; ?>"><?php echo $column_code; ?></a>
                    <?php } ?></td>
                  <td class="text-right"><?php if ($sort == 'value') { ?>
                    <a href="<?php echo $sort_value; ?>" class="<?php echo strtolower($order); ?>"><?php echo $column_value; ?></a>
                    <?php } else { ?>
                    <a href="<?php echo $sort_value; ?>"><?php echo $column_value; ?></a>
                    <?php } ?></td>
                  <td class="text-left"><?php if ($sort == 'date_modified') { ?>
                    <a href="<?php echo $sort_date_modified; ?>" class="<?php echo strtolower($order); ?>"><?php echo $column_date_modified; ?></a>
                    <?php } else { ?>
                    <a href="<?php echo $sort_date_modified; ?>"><?php echo $column_date_modified; ?></a>
                    <?php } ?></td>
                  <td class="text-right"><?php echo $column_action; ?></td>
                </tr>
              </thead>
              <tbody>
                <?php if ($currencies) { ?>
                <?php foreach ($currencies as $currency) { ?>
                <tr>
                  <td class="text-center"><?php if (in_array($currency['currency_id'], $selected)) { ?>
                    <input type="checkbox" name="selected[]" value="<?php echo $currency['currency_id']; ?>" checked="checked" />
                    <?php } else { ?>
                    <input type="checkbox" name="selected[]" value="<?php echo $currency['currency_id']; ?>" />
                    <?php } ?></td>
                  <td class="text-left"><?php echo $currency['title']; ?></td>
                  <td class="text-left"><?php echo $currency['code']; ?></td>
                  <td class="text-right"><?php echo $currency['value']; ?></td>
                  <td class="text-left"><?php echo $currency['date_modified']; ?></td>
                  <td class="text-right"><a href="<?php echo $currency['edit']; ?>" data-toggle="tooltip" title="<?php echo $button_edit; ?>" class="btn btn-primary"><i class="fa fa-pencil"></i></a></td>
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
  .glyphicon-calendar:before {content: "\e109" !important; }
  </style>
<script type="text/javascript"><!--
$('#button-filter').on('click', function() {
	var url = 'index.php?route=localisation/currency&token=<?php echo $token; ?>';

	var filter_title = $('select[name=\'filter_title\']').val();

	if (filter_title != '*') {
		url += '&filter_title=' + encodeURIComponent(filter_title);
	}
	
	var filter_updated = $('input[name=\'filter_updated\']').val();

	if (filter_updated) {
		url += '&filter_updated=' + encodeURIComponent(filter_updated);
	}
	
	var filter_code = $('select[name=\'filter_code\']').val();

	if (filter_code != '*') {
		url += '&filter_code=' + encodeURIComponent(filter_code);
	}

	location = url;
});

$('#button-filter-reset').on('click', function() {
	
	var url = 'index.php?route=localisation/currency&token=<?php echo $token; ?>';

	location = url;
});

$(function () 
{
		$('#filter_dateupdated').datetimepicker({
			 pickTime: false
		});
				
});

//--></script>
<?php echo $footer; ?> 