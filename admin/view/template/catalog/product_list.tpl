<?php echo $header; ?><?php echo $column_left; ?>
<div id="content">
  <div class="page-header">
    <div class="container-fluid">
      <div class="pull-right"><a href="<?php echo $add; ?>" data-toggle="tooltip" title="<?php echo $button_add; ?>" class="btn btn-primary"><i class="fa fa-plus"></i></a>
        <button type="submit" form="form-product" formaction="<?php echo $copy; ?>" data-toggle="tooltip" title="<?php echo $button_copy; ?>" class="btn btn-default"><i class="fa fa-copy"></i></button>
        <button type="button" id="1" data-toggle="tooltip" title="Enable" class="btn btn-success btnBulkAssign" onclick="massAction(this)" disabled><i class="fa fa-play"></i></button>
        <button type="button" id = "5"data-toggle="modal" data-target="#myModal" title="Assign" class="btn btn-info btnBulkAssign" disabled><i class="fa fa-link"></i></button>
        <button type="button" id="3" data-toggle="tooltip" title="Disable" class="btn btn-warning btnBulkAssign" onclick="massAction(this)" disabled><i class="fa fa-pause"></i></button>
        <button type="button" id="4" data-toggle="tooltip" title="<?php echo $button_delete; ?>" class="btn btn-danger btnBulkAssign" onclick="massAction(this)" disabled><i class="fa fa-trash-o"></i></button>
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
                <label class="control-label" for="input-name"><?php echo $entry_name; ?></label>
                <input type="text" name="filter_name" value="<?php echo $filter_name; ?>" placeholder="<?php echo $entry_name; ?>" id="input-name" class="form-control" />
                <!--<select name="filter_product_id" class="form-control">
                  <option value="">Select Product</option>
                    <?php foreach ($Dropdownproducts as $Dproduct) {  ?>
                <?php if ($Dproduct['product_id'] == $filter_product_id) { ?>
                <option value="<?php echo $Dproduct['product_id']; ?>" selected="selected"><?php echo $Dproduct['name']; ?></option>
                <?php } else { ?>
                <option value="<?php echo $Dproduct['product_id']; ?>"><?php echo $Dproduct['name']; ?></option>
                <?php } ?>
                <?php } ?>
                    
                </select>-->
              </div>
              <div class="form-group">
                <label class="control-label" for="input-model"><?php echo $entry_model; ?></label>
                <input type="text" name="filter_model" value="<?php echo $filter_model; ?>" placeholder="<?php echo $entry_model; ?>" id="input-model" class="form-control" />
                <!--<select name="filter_model" class="form-control">
                  <option value="">Select Model</option>
                    <?php foreach ($Dropdownmodels as $Dmodel) {  ?>
                <?php if ($Dmodel['model'] == $filter_model) { ?>
                <option value="<?php echo $Dmodel['model']; ?>" selected="selected"><?php echo $Dmodel['model']; ?></option>
                <?php } else { ?>
                <option value="<?php echo $Dmodel['model']; ?>"><?php echo $Dmodel['model']; ?></option>
                <?php } ?>
                <?php } ?>
                    
                </select>-->
              </div>
            </div>
            <div class="col-sm-4">
              <div class="form-group">
                <label class="control-label" for="input-price"><?php echo $entry_price; ?></label>

                <input type="text" name="filter_price" value="<?php echo $filter_price; ?>" placeholder="<?php echo $entry_price; ?>" id="input-price" class="form-control" />
              </div>
              <div class="form-group">
                <label class="control-label" for="input-quantity"><?php echo $entry_quantity; ?></label>
                <input type="text" name="filter_quantity" value="<?php echo $filter_quantity; ?>" placeholder="<?php echo $entry_quantity; ?>" id="input-quantity" class="form-control" />
              </div>
            </div>
            <div class="col-sm-4">
              <div class="form-group">
                <label class="control-label" for="input-status"><?php echo $entry_status; ?></label>
                <select name="filter_status" id="input-status" class="form-control">
                  <option value="*"></option>
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
              <!--div class="form-group">
                <label class="control-label" for="input-image"><?php echo $entry_image; ?></label>
                <select name="filter_image" id="input-image" class="form-control">
                  <option value="*"></option>
                  <?php if ($filter_image) { ?>
                  <option value="1" selected="selected"><?php echo $text_enabled; ?></option>
                  <?php } else { ?>
                  <option value="1"><?php echo $text_enabled; ?></option>
                  <?php } ?>
                  <?php if (!$filter_image && !is_null($filter_image)) { ?>
                  <option value="0" selected="selected"><?php echo $text_disabled; ?></option>
                  <?php } else { ?>
                  <option value="0"><?php echo $text_disabled; ?></option>
                  <?php } ?>
                </select>
              </div-->
              <button type="button" id="button-filter" class="btn btn-primary pull-right"><i class="fa fa-search"></i> Search</button>
              <button type="button" id="button-filter-reset" class="btn btn-primary pull-right" style="margin-right:10px;"><i class="fa fa-refresh"></i> Reset</button>
            </div>
          </div>
        </div>
        <form action="" method="post" enctype="multipart/form-data" id="form-product">
          <div class="table-responsive">
            <table class="table table-bordered table-hover">
              <thead>
                <tr>
                  <td style="width: 1px;">
                  <!--ul class="" style="padding: 0px;">
                     <li style="display: inline-block" -->
                     <input type="checkbox" onclick="$('input[name*=\'selected\']').prop('checked', this.checked);" />
                     <!--/li>
                      <li style="display: inline-block">
                        <select id="massaction" class="form-control" onchange="massAction()" style="width: 63px; height: 19px;" >
                           <option value="">Action</option>
                           <option value="enable">Enable</option>
                           <option value="disable">Disable</option>
                           <option type="button" value="delete">Delete</option>
                        </select>
                     </li>
                  </ul -->
                  </td>
                  <td class="text-center"><?php echo $column_image; ?></td>
                  <td class="text-left"><?php if ($sort == 'pd.name') { ?>
                    <a href="<?php echo $sort_name; ?>" class="<?php echo strtolower($order); ?>"><?php echo $column_name; ?></a>
                    <?php } else { ?>
                    <a href="<?php echo $sort_name; ?>"><?php echo $column_name; ?></a>
                    <?php } ?></td>
                  <td class="text-left"><?php if ($sort == 'p.model') { ?>
                    <a href="<?php echo $sort_model; ?>" class="<?php echo strtolower($order); ?>"><?php echo $column_model; ?></a>
                    <?php } else { ?>
                    <a href="<?php echo $sort_model; ?>"><?php echo $column_model; ?></a>
                    <?php } ?></td>
                  <td class="text-right"><?php if ($sort == 'p.price') { ?>
                    <a href="<?php echo $sort_price; ?>" class="<?php echo strtolower($order); ?>"><?php echo $column_price; ?></a>
                    <?php } else { ?>
                    <a href="<?php echo $sort_price; ?>"><?php echo $column_price; ?></a>
                    <?php } ?></td>
                  <td class="text-right"><?php if ($sort == 'p.quantity') { ?>
                    <a href="<?php echo $sort_quantity; ?>" class="<?php echo strtolower($order); ?>"><?php echo $column_quantity; ?></a>
                    <?php } else { ?>
                    <a href="<?php echo $sort_quantity; ?>"><?php echo $column_quantity; ?></a>
                    <?php } ?></td>
                  <td class="text-left"><?php if ($sort == 'p.status') { ?>
                    <a href="<?php echo $sort_status; ?>" class="<?php echo strtolower($order); ?>"><?php echo $column_status; ?></a>
                    <?php } else { ?>
                    <a href="<?php echo $sort_status; ?>"><?php echo $column_status; ?></a>
                    <?php } ?></td>
                  <td class="text-right"><?php echo $column_action; ?></td>
                </tr>
              </thead>
              <tbody>
                <?php if ($products) { ?>
                <?php foreach ($products as $product) { ?>
                <tr>
                  <td class="text-center"><?php if (in_array($product['product_id'], $selected)) { ?>
                    <input type="checkbox" name="selected[]" value="<?php echo $product['product_id']; ?>" checked="checked" />
                    <?php } else { ?>
                    <input type="checkbox" name="selected[]" value="<?php echo $product['product_id']; ?>" />
                    <?php } ?></td>
                  <td class="text-center"><?php if ($product['image']) { ?>
                    <img src="<?php echo $product['image']; ?>" alt="<?php echo $product['name']; ?>" class="img-thumbnail" />
                    <?php } else { ?>
                    <span class="img-thumbnail list"><i class="fa fa-camera fa-2x"></i></span>
                    <?php } ?></td>
                  <td class="text-left"><?php echo $product['name']; ?></td>
                  <td class="text-left"><?php echo $product['model']; ?></td>
                  <td class="text-right"><?php if ($product['special']) { ?>
                    <span style="text-decoration: line-through;"><?php echo $product['price']; ?></span><br/>
                    <div class="text-danger"><?php echo $product['special']; ?></div>
                    <?php } else { ?>
                    <?php echo $product['price']; ?>
                    <?php } ?></td>
                  <td class="text-right"><?php if ($product['quantity'] <= 0) { ?>
                    <span class="label label-warning"><?php echo $product['quantity']; ?></span>
                    <?php } elseif ($product['quantity'] <= 5) { ?>
                    <span class="label label-danger"><?php echo $product['quantity']; ?></span>
                    <?php } else { ?>
                    <span class="label label-success"><?php echo $product['quantity']; ?></span>
                    <?php } ?></td>
                  <td class="text-left"><?php echo $product['status']; ?></td>
                  <td class="text-right"><a href="<?php echo $product['edit']; ?>" data-toggle="tooltip" title="<?php echo $button_edit; ?>" class="btn btn-primary"><i class="fa fa-pencil"></i></a></td>
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

            
  <!---------------------------------- Modal ----------------------------------------->
  <div class="modal fade" id="myModal" role="dialog">
    <div class="modal-dialog">
    
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Assign Products</h4>
        </div>
        <div class="modal-body">
        <!--form action="" method="post" enctype="multipart/form-data" id="form-assign-product" class="form-horizontal" -->
          <div class="form-group">
                  <label class="col-sm-2 control-label" for="input-category"><span data-toggle="tooltip" title="<?php echo $help_category; ?>"><?php echo $entry_category; ?></span></label>
                  <div class="col-sm-10">
                    <input type="text" name="category" value="" placeholder="<?php echo $entry_category; ?>" id="input-category" class="form-control" />
                    <div id="product-category" class="well well-sm" style="height: 150px; overflow: auto;">
                      <?php foreach ($product_categories as $product_category) { ?>
                      <div id="product-category<?php echo $product_category['category_id']; ?>"><i class="fa fa-minus-circle"></i> <?php echo $product_category['name']; ?>
                        <input type="hidden" name="product_category[]" value="<?php echo $product_category['category_id']; ?>" />
                      </div>
                      <?php } ?>
                    </div>
                  </div>
                </div>
          </div>
        
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
          <button type="button" id="2" class="btn btn-success" onclick="massAction(this)" data-dismiss="modal">Assign</button>
        </div>
      <!--/form -->   
      </div>
      
    </div>
  </div>
  <!-- ----------------------------Modal --------------------------------------------->


        </form>
        <div class="row">
          <div class="col-sm-6 text-left"><?php echo $pagination; ?></div>
          <div class="col-sm-6 text-right"><?php echo $results; ?></div>
        </div>
      </div>
    </div>
  </div>
  <script type="text/javascript"><!--
$('form input[type="checkbox"]').on('change', function() {
	if ($('form input[type="checkbox"]:checked').length > 0) {
		$('.btnBulkAssign').prop('disabled', false);
    } else {
		$('.btnBulkAssign').prop('disabled', true);
    }
});

function massAction(elem) {

    var clickedValue = elem.id;
    if(clickedValue == 1){
      //enable
      var url = 'index.php?route=catalog/product/enableProduct&token=<?php echo $token; ?>';
      document.getElementById("form-product").action = url;  //Setting form action to "success.php" page
      confirm('<?php echo $text_enable; ?>') ? $('#form-product').submit() : false;
    }else if(clickedValue == 2){
      //Assigin
       var url = 'index.php?route=catalog/product/assignProduct&token=<?php echo $token; ?>';
      document.getElementById("form-product").action = url;  //Setting form action to "success.php" page
      confirm('<?php echo "Are you sure?"; ?>') ? $('#form-product').submit() : false;

       
    } else if(clickedValue == 3){
      //Disable
      var url = 'index.php?route=catalog/product/disableProduct&token=<?php echo $token; ?>';
       document.getElementById("form-product").action = url;  //Setting form action to "success.php" page
       confirm('<?php echo $text_disable; ?>') ? $('#form-product').submit() : false;
    }else if(clickedValue == 4){
      //Delete
       var url = 'index.php?route=catalog/product/delete&token=<?php echo $token; ?>';
       document.getElementById("form-product").action = url;  //Setting form action to "success.php" page
       confirm('<?php echo $text_confirm; ?>') ? $('#form-product').submit() : false;
    }

}
$('#button-filter').on('click', function() {
  var url = 'index.php?route=catalog/product&token=<?php echo $token; ?>';
  var filter_name = $('input[name=\'filter_name\']').val();
  if (filter_name) {
    url += '&filter_name=' + encodeURIComponent(filter_name);
  }
  var filter_product_id = $('select[name=\'filter_product_id\']').val();
  if (filter_product_id) {
    url += '&filter_product_id=' + encodeURIComponent(filter_product_id);
  }
  var filter_model = $('input[name=\'filter_model\']').val();
  
  if (filter_model) {
    url += '&filter_model=' + encodeURIComponent(filter_model);
  }
  
  /*var filter_model = $('select[name=\'filter_model\']').val();
  if (filter_model) {
    url += '&filter_model=' + encodeURIComponent(filter_model);
  }*/
  var filter_price = $('input[name=\'filter_price\']').val();
  if (filter_price) {
    url += '&filter_price=' + encodeURIComponent(filter_price);
  }
  var filter_quantity = $('input[name=\'filter_quantity\']').val();
  if (filter_quantity) {
    url += '&filter_quantity=' + encodeURIComponent(filter_quantity);
  }
  var filter_status = $('select[name=\'filter_status\']').val();
  if (filter_status != '*') {
    url += '&filter_status=' + encodeURIComponent(filter_status);
  }
  /*var filter_image = $('select[name=\'filter_image\']').val();
  if (filter_image != '*') {
    url += '&filter_image=' + encodeURIComponent(filter_image);
  }*/
  location = url;
});
$('#button-filter-reset').on('click', function() {
  var url = 'index.php?route=catalog/product&token=<?php echo $token; ?>';
  location = url;
});
//--></script>
  <script type="text/javascript"><!--
$('input[name=\'filter_name\']').autocomplete({
  'source': function(request, response) {
    $.ajax({
      url: 'index.php?route=catalog/product/autocomplete&token=<?php echo $token; ?>&filter_name=' +  encodeURIComponent(request),
      dataType: 'json',
      success: function(json) {
        response($.map(json, function(item) {
          return {
            label: item['name'],
            value: item['product_id']
          }
        }));
      }
    });
  },
  'select': function(item) {
    $('input[name=\'filter_name\']').val(item['label']);
  }
});
$('input[name=\'filter_model\']').autocomplete({
  'source': function(request, response) {
    $.ajax({
      url: 'index.php?route=catalog/product/autocomplete&token=<?php echo $token; ?>&filter_model=' +  encodeURIComponent(request),
      dataType: 'json',
      success: function(json) {
        response($.map(json, function(item) {
          return {
            label: item['model'],
            value: item['product_id']
          }
        }));
      }
    });
  },
  'select': function(item) {
    $('input[name=\'filter_model\']').val(item['label']);
  }
});
//--></script>

</div>
<script>
  // Category
$('input[name=\'category\']').autocomplete({
	'source': function(request, response) {
		$.ajax({
			url: 'index.php?route=catalog/category/autocomplete&token=<?php echo $token; ?>&filter_name=' +  encodeURIComponent(request),
			dataType: 'json',
			success: function(json) {
				response($.map(json, function(item) {
					return {
						label: item['name'],
						value: item['category_id']
					}
				}));
			}
		});
	},
	'select': function(item) {
		$('input[name=\'category\']').val('');

		$('#product-category' + item['value']).remove();

		$('#product-category').append('<div id="product-category' + item['value'] + '"><i class="fa fa-minus-circle"></i> ' + item['label'] + '<input type="hidden" name="product_category[]" value="' + item['value'] + '" /></div>');
	}
});

$('#product-category').delegate('.fa-minus-circle', 'click', function() {
	$(this).parent().remove();
});

// Filter
$('input[name=\'filter\']').autocomplete({
	'source': function(request, response) {
		$.ajax({
			url: 'index.php?route=catalog/filter/autocomplete&token=<?php echo $token; ?>&filter_name=' +  encodeURIComponent(request),
			dataType: 'json',
			success: function(json) {
				response($.map(json, function(item) {
					return {
						label: item['name'],
						value: item['filter_id']
					}
				}));
			}
		});
	},
	'select': function(item) {
		$('input[name=\'filter\']').val('');

		$('#product-filter' + item['value']).remove();

		$('#product-filter').append('<div id="product-filter' + item['value'] + '"><i class="fa fa-minus-circle"></i> ' + item['label'] + '<input type="hidden" name="product_filter[]" value="' + item['value'] + '" /></div>');
	}
});
</script>
<?php echo $footer; ?>
