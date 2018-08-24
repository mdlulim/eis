<?php echo $header; ?><?php echo $column_left; ?>
<div id="content">
  <div class="page-header">
    <div class="container-fluid">
      <div class="pull-right"><a onclick="confirm('<?php echo $text_confirm; ?>') ? location.href='<?php echo $reset; ?>' : false;" data-toggle="tooltip" title="<?php echo $button_reset; ?>" class="btn btn-danger"><i class="fa fa-refresh"></i></a></div>
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
                <label class="control-label" for="input-product">Product Name</label>
               
                <select name="filter_product_id" class="form-control">
                	<option value="">Select Product Name</option>
                    <?php foreach ($Dorpdownproducts as $Dproduct) {  ?>
                <?php if ($Dproduct['product_id'] == $filter_product_id) { ?>
                <option value="<?php echo $Dproduct['product_id']; ?>" selected="selected"><?php echo $Dproduct['name']; ?></option>
                <?php } else { ?>
                <option value="<?php echo $Dproduct['product_id']; ?>"><?php echo $Dproduct['name']; ?></option>
                <?php } ?>
                <?php } ?>
                    
                </select>
                
              </div>
            </div>
            <div class="col-sm-6">
              <div class="form-group">
                <label class="control-label" for="input-model">Model</label>
               
                <select name="filter_model" class="form-control">
                	<option value="">Select Model</option>
                    <?php foreach ($dropdownmodels as $Dmodel) {  ?>
                <?php if ($Dmodel['model'] == $filter_model) { ?>
                <option value="<?php echo $Dmodel['model']; ?>" selected="selected"><?php echo $Dmodel['model']; ?></option>
                <?php } else { ?>
                <option value="<?php echo $Dmodel['model']; ?>"><?php echo $Dmodel['model']; ?></option>
                <?php } ?>
                <?php } ?>
                    
                </select>
                
              </div>
              <button type="button" id="button-filter" class="btn btn-primary pull-right"><i class="fa fa-search"></i> Search</button>
              <button type="button" id="button-filter-reset" class="btn btn-primary pull-right" style="margin-right:10px;"><i class="fa fa-refresh"></i> Reset</button>
            </div>
            
          </div>
        </div>
      
        <div class="table-responsive">
          <table class="table table-bordered">
            <thead>
              <tr>
                <td class="text-left"><?php echo $column_name; ?></td>
                <td class="text-left"><?php echo $column_model; ?></td>
                <td class="text-left"><?php echo $column_viewed; ?></td>
                <td class="text-left"><?php echo $column_percent; ?></td>
              </tr>
            </thead>
            <tbody>
              <?php if ($products) { ?>
              <?php foreach ($products as $product) { ?>
              <tr>
                <td class="text-left"><?php echo $product['name']; ?></td>
                <td class="text-left"><?php echo $product['model']; ?></td>
                <td class="text-left"><?php echo $product['viewed']; ?></td>
                <td class="text-left"><?php echo $product['percent']; ?></td>
              </tr>
              <?php } ?>
              <?php } else { ?>
              <tr>
                <td class="text-center" colspan="4"><?php echo $text_no_results; ?></td>
              </tr>
              <?php } ?>
            </tbody>
          </table>
        </div>
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
	url = 'index.php?route=report/product_viewed&token=<?php echo $token; ?>';
	
	var filter_product_id = $('select[name=\'filter_product_id\']').val();

	if (filter_product_id) {
		url += '&filter_product_id=' + encodeURIComponent(filter_product_id);
	}

	var filter_model = $('select[name=\'filter_model\']').val();

	if (filter_model) {
		url += '&filter_model=' + encodeURIComponent(filter_model);
	}
		
	location = url;
});

$('#button-filter-reset').on('click', function() {
	url = 'index.php?route=report/product_viewed&token=<?php echo $token; ?>';
	location = url;
});

//--></script>
<?php echo $footer; ?>