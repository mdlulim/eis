<?php echo $header; ?><?php echo $column_left; ?>
<div id="content">
  <div class="page-header">
    <div class="container-fluid">
      <div class="pull-right"><a href="<?php echo $add; ?>" data-toggle="tooltip" title="<?php echo $button_add; ?>" class="btn btn-primary"><i class="fa fa-plus"></i></a>
        <button type="button" data-toggle="tooltip" title="<?php echo $button_delete; ?>" class="btn btn-danger" onclick="confirm('<?php echo $text_confirm; ?>') ? $('#form-attribute').submit() : false;"><i class="fa fa-trash-o"></i></button>
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
                <label class="control-label" for="input-name"><?php echo $column_name; ?></label>
                <input type="text" name="filter_name" value="<?php echo $filter_name; ?>" placeholder="Attribute Name" id="filter_name" class="form-control" />
                 
                <!--select name="filter_attribute_id" id="input-type" class="form-control">
                	<option value="">Select Attribute Name</option>
                     <?php foreach ($Allattributes as $Allattribute) { ?>
                        <?php if ($Allattribute['attribute_id'] == $filter_attribute_id) { ?>
                        <option value="<?php echo $Allattribute['attribute_id']; ?>" selected="selected"><?php echo $Allattribute['name']; ?></option>
                        <?php } else { ?>
                        <option value="<?php echo $Allattribute['attribute_id']; ?>"><?php echo $Allattribute['name']; ?></option>
                        <?php } ?>
                     <?php } ?>
                   
              </select -->
              </div>
              
            </div>
            <div class="col-sm-6" style="margin-bottom:10px;">
              
              <div class="form-group">
                <label class="control-label" for="input-price">Attribute Group</label>
                <select name="filter_attribute_group_id" id="input-type" class="form-control">
                	<option value="">Select Attribute Group</option>
                     <?php foreach ($attribute_groups as $attribute_group) { ?>
                        <?php if ($attribute_group['attribute_group_id'] == $filter_attribute_group_id) { ?>
                        <option value="<?php echo $attribute_group['attribute_group_id']; ?>" selected="selected"><?php echo $attribute_group['name']; ?></option>
                        <?php } else { ?>
                        <option value="<?php echo $attribute_group['attribute_group_id']; ?>"><?php echo $attribute_group['name']; ?></option>
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
      
        <form action="<?php echo $delete; ?>" method="post" enctype="multipart/form-data" id="form-attribute">
          <div class="table-responsive">
            <table class="table table-bordered table-hover">
              <thead>
                <tr>
                  <td style="width: 1px;" class="text-center"><input type="checkbox" onclick="$('input[name*=\'selected\']').prop('checked', this.checked);" /></td>
                  <td class="text-left"><?php if ($sort == 'ad.name') { ?>
                    <a href="<?php echo $sort_name; ?>" class="<?php echo strtolower($order); ?>"><?php echo $column_name; ?></a>
                    <?php } else { ?>
                    <a href="<?php echo $sort_name; ?>"><?php echo $column_name; ?></a>
                    <?php } ?></td>
                  <td class="text-left"><?php if ($sort == 'attribute_group') { ?>
                    <a href="<?php echo $sort_attribute_group; ?>" class="<?php echo strtolower($order); ?>"><?php echo $column_attribute_group; ?></a>
                    <?php } else { ?>
                    <a href="<?php echo $sort_attribute_group; ?>"><?php echo $column_attribute_group; ?></a>
                    <?php } ?></td>
                  <td class="text-right"><?php if ($sort == 'a.sort_order') { ?>
                    <a href="<?php echo $sort_sort_order; ?>" class="<?php echo strtolower($order); ?>"><?php echo $column_sort_order; ?></a>
                    <?php } else { ?>
                    <a href="<?php echo $sort_sort_order; ?>"><?php echo $column_sort_order; ?></a>
                    <?php } ?></td>
                  <td class="text-right"><?php echo $column_action; ?></td>
                </tr>
              </thead>
              <tbody>
                <?php if ($attributes) { ?>
                <?php foreach ($attributes as $attribute) { ?>
                <tr>
                  <td class="text-center"><?php if (in_array($attribute['attribute_id'], $selected)) { ?>
                    <input type="checkbox" name="selected[]" value="<?php echo $attribute['attribute_id']; ?>" checked="checked" />
                    <?php } else { ?>
                    <input type="checkbox" name="selected[]" value="<?php echo $attribute['attribute_id']; ?>" />
                    <?php } ?></td>
                  <td class="text-left"><?php echo $attribute['name']; ?></td>
                  <td class="text-left"><?php echo $attribute['attribute_group']; ?></td>
                  <td class="text-right"><?php echo $attribute['sort_order']; ?></td>
                  <td class="text-right"><a href="<?php echo $attribute['edit']; ?>" data-toggle="tooltip" title="<?php echo $button_edit; ?>" class="btn btn-primary"><i class="fa fa-pencil"></i></a></td>
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
<style>
  .form-group + .form-group{border-top:none;}
  </style>
  <script type="text/javascript"><!--
$('#button-filter').on('click', function() {
	var url = 'index.php?route=catalog/attribute&token=<?php echo $token; ?>';
	
  var filter_name = $('input[name=\'filter_name\']').val();
  if (filter_name) {
		url += '&filter_name=' + encodeURIComponent(filter_name);
	}

	var filter_attribute_id = $('select[name=\'filter_attribute_id\']').val();
	if (filter_attribute_id) {
		url += '&filter_attribute_id=' + encodeURIComponent(filter_attribute_id);
	}
	
	var filter_attribute_group_id = $('select[name=\'filter_attribute_group_id\']').val();
	if (filter_attribute_group_id) {
		url += '&filter_attribute_group_id=' + encodeURIComponent(filter_attribute_group_id);
	}
	
	location = url;
});

$('#button-filter-reset').on('click', function() {
	var url = 'index.php?route=catalog/attribute&token=<?php echo $token; ?>';
	location = url;
});
$('input[name=\'filter_name\']').autocomplete({
	'source': function(request, response) {
		$.ajax({
			url: 'index.php?route=catalog/attribute/autocomplete&token=<?php echo $token; ?>&filter_name=' +  encodeURIComponent(request),
			dataType: 'json',			
			success: function(json) {
				response($.map(json, function(item) {
					return {
						attribute_id: item['attribute_id'],
						label: item['name']		
					}
				}));
			}
		});
	},
	'select': function(item, ui) {
		$('input[name=\'filter_name\']').val(item['label']);
		$('input[name=\'filter_attribute_id\']').val(item['attribute_id']);
	}
});
</script>
<?php echo $footer; ?>
