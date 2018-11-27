<?php echo $header; ?>
               <style>
                .inline-edit {
                    display:none;
                    margin-right: 0px;
                    margin-left: 0px;
                    clear:both;
                }
                .inline-edit input {
                    max-width:90%;
                    cursor: text;
                    border:1px solid #ccc;
                }

                td > span,/*.inline-edit +span,*/  span {
                    cursor: pointer;
                }
                
              
                </style>
			
               <style>
                .inline-edit-price {
                    display:none;
                    margin-right: 0px;
                    margin-left: 0px;
                    clear:both;
                }
                .inline-edit-price input {
                    max-width:90%;
                    cursor: text;
                    border:1px solid #ccc;
                }

                 .inline-edit-price input.customer-group-price
                {
                    text-align: left;
                }


                td > span,/*.inline-edit-price +span,*/  span {
                    cursor: pointer;
                }

                td > span,/*.inline-edit-price +span,*/ .groupPlusPrice span{
                    cursor: pointer;
                }
                
              
                </style>
			<?php echo $column_left; ?>
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
              </div>
              <div class="form-group">
                <label class="control-label" for="input-model"><?php echo $entry_model; ?></label>
                <input type="text" name="filter_model" value="<?php echo $filter_model; ?>" placeholder="<?php echo $entry_model; ?>" id="input-model" class="form-control" />
              
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
                  
                     <input type="checkbox" onclick="$('input[name*=\'selected\']').prop('checked', this.checked);" />
                   
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

                 <?php if ($config_show_admin_product_customer_group_prices_in_product_list == 1){ ?>
				 <td><?php echo $column_customer_group_prices; ?></td>
                 <?php } ?>
			

                 <?php if ($config_show_admin_product_customer_groups_in_product_list == 1){ ?>
				 <td><?php echo $column_customer_groups; ?></td>
                 <?php } ?>
			
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
  
                <?php if ($config_show_admin_product_customer_group_prices_in_product_list == 1){ ?>
                <?php $existing_cg = array(); ?>
                <td class="left">
                    <div class="inline-edit-price"  style="display:none;" id="customer-group-price-<?php echo $product['product_id']; ?>" value="<?php echo $product['product_id']; ?>">
                <div style="width:100px;overflow-y:auto;overflow-x:hidden;">
                      <?php foreach ($customer_groups as $customer_group) { ?>
                    <?php foreach($product['product_customer_group_prices'] as $group_price){ ?>
                    <?php if ($group_price['customer_group_id'] == $customer_group['customer_group_id']) { ?>
                        <?php echo "<span style=\"font-weight:bold\">" . $customer_group['name'] . ":</span> "; ?>
                         <input type="text" class="customer-group-price" style="cursor:pointer;width:100px;" nowrap="nowrap" 
                            name="product_customer_group_price[<?php echo $customer_group['customer_group_id']; ?>]" size="100" 
                            value="<?php echo isset($group_price['price']) ? $group_price['price'] : ''; ?>" /> 
                            <?php array_push($existing_cg, $customer_group['customer_group_id']); ?><br /><br />
                            <span class="error" style="color:#ff0000;" id="customer-group-price-error-<?php echo $customer_group['customer_group_id']; ?>"></span>
                     <?php } ?>
                     <?php } ?>
                     <?php if(!in_array($customer_group['customer_group_id'], $existing_cg)){ ?>
                     <?php echo "<span style=\"font-weight:bold\">" . $customer_group['name'] . ":</span> "; ?>
                         <input type="text" class="customer-group-price" style="cursor:pointer;width:100px;" nowrap="nowrap" 
                            name="product_customer_group_price[<?php echo $customer_group['customer_group_id']; ?>]" size="100" 
                            value="<?php echo isset($group_price['price']) ? "0.0000" : ''; ?>" /><br /><br />
                     <?php } ?>
                     <?php } ?>
                      
                    <div style="text-align:center;width:100%; background:#1e91cf;padding:5px;cursor:pointer;margin:2px 0px;">
                            <a style="color:#fff;" onclick="save_customer_group_prices(this,<?php echo $product['product_id']; ?>)"><?php echo $text_save ?></a>
                        </div>
                      <div class="close-input" style="text-align:center;width:100%; background:#1e91cf;padding:5px;cursor:pointer;">
                            <a style="color:#fff;"><?php echo $text_close; ?></a>
                        </div>
                   </div>
                </div>

                <?php 
                $test = array();
       
                foreach ($customer_groups as $customer_group) { ?>
                   <div class="groupPlusPrice">
                      <span id="groupPlusPrice-<?php echo $customer_group['customer_group_id']; ?>">
                    <?php foreach($product['product_customer_group_prices'] as $group_price){ ?>
                    <?php if ($group_price['customer_group_id'] == $customer_group['customer_group_id']) { ?>
          
                    <?php array_push($test, $customer_group['customer_group_id']); ?>
                <?php echo "<span style=\"font-weight:bold\">" . $customer_group['name'] . ":</span> "; echo isset($customer_group['customer_group_id']) ? $group_price['price'] : ''; ?>
                <?php } ?>
                     <?php } ?>
                <?php if(!in_array($customer_group['customer_group_id'], $test)){ ?>
                <?php echo "<span style=\"font-weight:bold\">" . $customer_group['name'] . ":</span> "; echo isset($customer_group['customer_group_id']) ? "0.0000" : ''; ?>
		              </span>
                <?php } ?>
                
                   </div>
                <?php } ?>
                </td>
                <?php } ?>




			

                <?php if ($config_show_admin_product_customer_groups_in_product_list == 1){ ?>
                <td style="padding:5px;" nowrap="nowrap" >
                    <div class="inline-edit" style="display:none" id="customer-group-<?php echo $product['product_id']; ?>" value="<?php echo $product['product_id']; ?>">
                        <div style="height:100%;overflow-y:auto;overflow-x:hidden;">                            
                            <?php foreach ($customer_groups as $customer_group) { ?>
                            <?php $checked = in_array($customer_group['customer_group_id'], $product['product_customer_groups']) ? "checked" : ''?>
                            <label><input type="checkbox" style="cursor:pointer;" value="<?php echo $customer_group['customer_group_id']; ?>"<?php echo $checked; ?> 
                                onclick="save_customer_groups(this,<?php echo $product['product_id']; ?>)">&nbsp;<span><?php echo $customer_group['name']; ?></span></label>
                            <br/>
                            <?php } ?>   
                        </div>
                        <div class="close-input" style="text-align:center;width:100%; background:#1e91cf;padding:5px;cursor:pointer;">
                            <a style="color:#fff;"><?php echo $text_close; ?></a>
                        </div>
                    </div>                                
                    <span>
                    <?php $found = false; ?>
                    <?php foreach ($customer_groups as $customer_group) { ?>
                        <?php if(in_array($customer_group['customer_group_id'], $product['product_customer_groups'])) { ?>
                            <?php $found = true ?>
                            <div><?php echo $customer_group['name']; ?></div>
                        <?php } ?>
                    <?php } ?>
                    <?php if(!$found) {; ?>- - -<?php } ?>
                    </span>                
                </td>
            <?php } ?>
			
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
          <h4 class="modal-title">Assign Products To Contact Pricing</h4>
        </div>
        <div class="modal-body">
        <!--form action="" method="post" enctype="multipart/form-data" id="form-assign-product" class="form-horizontal" -->
         
          <div class="form-group" id="myCategory" style="display: none;">
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
        
          <div class="" id="myStore">
                <label class="col-sm-2 control-label"></label>
                <div class="col-sm-10">
                  <div class="well well-sm" style="height: 150px; overflow: auto;">
                    
                    <?php foreach ($groups as $group) { ?>
                    <div class="checkbox">
                      <label>
                        <?php if (in_array($group['customer_group_id'], $product_store)) { ?>
                        <input type="checkbox" name="product_store[]" value="<?php echo $group['customer_group_id']; ?>" checked="checked" />
                        <?php echo $group['name']; ?>
                        <?php } else { ?>
                        <input type="checkbox" name="product_store[]" value="<?php echo $group['customer_group_id'] ?>" />
                        <?php echo $group['name']; ?>
                        <?php } ?>
                      </label>
                    </div>
                    <?php } ?>
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
                    $(document).ready(function() { 
                        $('.inline-edit').each(function(index, wrapper) {
                            $(this).next().not('.hide-edit').click(function() {
                                $(wrapper).show();
                            })
                        });
                        $('div.close-input').click(function() {
                            $(this).closest('.inline-edit').hide();
                        });                                               
                        
                    });
                    
                      function save_customer_groups(input,id) {
                      var customer_group = $(input).val();
                      var checked        = $(input).is(':checked') ? '1':'0';
                      
                      $(input).css('cursor','progress');
                      $.ajax({
                         url: 'index.php?route=catalog/product/saveCustomerGroup&product_id='+id+'&customer_group_id='+customer_group+'&checked='+checked+'&token=<?php echo $token; ?>',
                         dataType: 'json',
                         data: {},
                         success: function(customer_group) {         
                            var customer_groups = $('#customer-group-'+id).next('span');                        
                            var customer_groups_list = '';
                            $('#customer-group-'+id+' input').each(function(index) {
                                if($(this).is(':checked')) {
                                    customer_groups_list = customer_groups_list + $(this).next('span').html() + '<br/>';
                                }
                            });
                            if(customer_groups_list == '') customer_groups_list = '- - -';
                            customer_groups.html(customer_groups_list);
                            
                         }
                      });
                      $(input).css('cursor','default');
                   }
                //--></script>
			
               <script type="text/javascript"><!--
                    $(document).ready(function() { 
                        $('.inline-edit-price').each(function(index, wrapper) {
                            $(this).siblings().click(function() {
                                $(wrapper).show();
                            })
                        });
                        $('div.close-input').click(function() {
                            $(this).closest('.inline-edit-price').hide();
                        });                                               
                        
                    });
                    
                      function save_customer_group_prices(btn,id) {
                      var input_product_customer_group_price = $('product_customer_group_price-'+id+' input');
                      var customer_group_price = $(input_product_customer_group_price).val();
                      $(customer_group_price).css('cursor','progress');
                      $.ajax({
                         url: 'index.php?route=catalog/product/saveCustomerGroupPrices&product_id='+id+'&token=<?php echo $token; ?>',
                         type: 'GET',
                         dataType: 'json',
                         data: $('#customer-group-price-'+id+' input').serialize(),
                         success: function(data) {
                            $('#customer-group-price-'+id + ' span.error').html('');
                            if(data['error']) {
                               for(var customer_group_id in data['error']) {
                                  $('#customer-group-price-'+id).find('#customer-group-price-error-'+customer_group_id).html(data['error'][customer_group_id]);
                               }
                            }
                            else {
                               for(var customer_group_id in data['value']) {
                               var priceTmp = parseFloat(data['value'][customer_group_id]['price']);
                               var price = priceTmp.toFixed(4);

                                  $('#customer-group-price-'+id).siblings('div.groupPlusPrice').find('#groupPlusPrice-'+data['value'][customer_group_id]['customer_group_id']).html("<span style=\"font-weight:bold\">" +data['value'][customer_group_id]['name']+ ": </span>" + price);
                               }			       
                               $(btn).closest('.inline-edit-price').hide();
                            }
                         }
                      });
                      $(input_product_customer_group_price).css('cursor','default');
                      
                   }
                //--></script>
			
  <script type="text/javascript"><!--


$('form input[type="checkbox"]').on('change', function() {
	if ($('form input[type="checkbox"]:checked').length > 0) {
		$('.btnBulkAssign').prop('disabled', false);
    } else {
		$('.btnBulkAssign').prop('disabled', true);
    }
});
//Assign Option
function massAction(elem) {

    var clickedValue = elem.id;
    if(clickedValue == 1){
      //enable
      var url = 'index.php?route=catalog/product/enableProduct&token=<?php echo $token; ?>';
      document.getElementById("form-product").action = url;  //Setting form action to "success.php" page
      confirm('<?php echo $text_enable; ?>') ? $('#form-product').submit() : false;
    }else if(clickedValue == 2){
       var url = 'index.php?route=catalog/product/assignProductToCustomerGroup&token=<?php echo $token; ?>';
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