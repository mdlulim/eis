<?php echo $header; ?><?php echo $column_left; ?>
<div id="content">
    <div class="page-header">
        <div class="container-fluid">
            <div class="pull-right"><a href="<?php echo $add; ?>" data-toggle="tooltip" title="<?php echo $button_add; ?>" class="btn btn-primary"><i class="fa fa-plus"></i></a>
                <a href="<?php echo $import_csv; ?>" class="btn btn-primary">Import CSV</a>
                <button type="button" data-toggle="tooltip" title="<?php echo $button_delete; ?>" class="btn btn-danger" onclick="confirm('<?php echo $text_confirm; ?>') ? $('#form-filter').submit() : false;"><i class="fa fa-trash-o"></i></button>
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
                            <label class="control-label" for="input-name">SKU</label>
                            <select name="filter_sku" id="input-name" class="form-control">
                              <option value="*">Select Sku</option>
                              <?php foreach($Dropdownskus as $Dsku) { ?>
                                <?php if($Dsku['sku']) { ?>
                                <?php if($Dsku['sku'] == $filter_sku) { ?>
                                  <option value="<?php echo $Dsku['sku']; ?>" selected="selected"><?php echo $Dsku['sku']; ?></option>
                                  <?php } else { ?>
                                  <option value="<?php echo $Dsku['sku']; ?>"><?php echo $Dsku['sku']; ?></option>
                                  <?php } ?>
                              <?php } } ?>
                            </select>
                          </div>
                          
                        </div>
                        <div class="col-sm-6">
                          <div class="form-group">
                            <label class="control-label" for="input-name">Customer Group</label>
                            <select name="filter_customer_group_id" id="input-name" class="form-control">
                              <option value="*">Select Customer Group</option>
                              <?php foreach($Dropdowncustomergroup as $customergroup) { ?>
                                <?php if($customergroup['customer_group_id'] == $filter_customer_group_id ) { ?>
                                  <option value="<?php echo $customergroup['customer_group_id']; ?>" selected="selected"><?php echo $customergroup['name']; ?></option>
                                  <?php } else { ?>
                                  <option value="<?php echo $customergroup['customer_group_id']; ?>"><?php echo $customergroup['name']; ?></option>
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
            
                <form action="<?php echo $delete; ?>" method="post" enctype="multipart/form-data" id="form-filter">
                    <div class="table-responsive">
                        <table class="table table-bordered table-hover">
                            <thead>
                            <tr>
                                <td style="width: 1px;" class="text-center"><input type="checkbox" onclick="$('input[name*=\'selected\']').prop('checked', this.checked);" /></td>

                                <td class="text-left"><?php echo $column_sku; ?></td>
                                <td class="text-left"><?php echo $column_contract; ?></td>
                                <td class="text-left"><?php echo $column_price; ?></td>
                                <td class="text-left"><?php echo "Actions"; ?></td>

                            </tr>
                            </thead>
                            <tbody>
                            <?php if ($prices) { ?>
                            <?php foreach ($prices as $price) { ?>
                            <tr>
                                <td class="text-center"><?php if (in_array($price['price_id'], $selected)) { ?>
                                    <input type="checkbox" name="selected[]" value="<?php echo $price['price_id']; ?>" checked="checked" />
                                    <?php } else { ?>
                                    <input type="checkbox" name="selected[]" value="<?php echo $price['price_id']; ?>" />
                                    <?php } ?></td>
                                <td class="text-left"><?php echo $price['sku']; ?></td>
                                <td class="text-left"><?php echo $price['contract']; ?></td>
                                <td class="text-left"><?php echo $price['price']; ?></td>

                                <td class="text-right"><a href="<?php echo $price['edit']; ?>" data-toggle="tooltip" title="<?php echo $button_edit; ?>" class="btn btn-primary"><i class="fa fa-pencil"></i></a></td>
                            </tr>
                            <?php } ?>
                            <?php } else { ?>
                            <tr>
                                <td class="text-center" colspan="7"><?php echo $text_no_results; ?></td>
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
	var url = 'index.php?route=catalog/price&token=<?php echo $token; ?>';

	var filter_sku = $('select[name=\'filter_sku\']').val();

	if (filter_sku != '*') {
		url += '&filter_sku=' + encodeURIComponent(filter_sku);
	}
	
	var filter_customer_group_id = $('select[name=\'filter_customer_group_id\']').val();

	if (filter_customer_group_id != '*') {
		url += '&filter_customer_group_id=' + encodeURIComponent(filter_customer_group_id);
	}

	location = url;
});

$('#button-filter-reset').on('click', function() {
	
	var url = 'index.php?route=catalog/price&token=<?php echo $token; ?>';

	location = url;
});

//--></script>
<?php echo $footer; ?>