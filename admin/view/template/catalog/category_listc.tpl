<?php echo $header; ?><?php echo $column_left; ?>
<div id="content">
  <div class="page-header">
    <div class="container-fluid">
      <div class="pull-right"><a href="<?php echo $add; ?>" data-toggle="tooltip" title="<?php echo $button_add; ?>" class="btn btn-primary"><i class="fa fa-plus"></i></a> 
      <!--<a href="<?php echo $repair; ?>" data-toggle="tooltip" title="<?php echo $button_rebuild; ?>" class="btn btn-default"><i class="fa fa-refresh"></i></a>-->
        <button type="button" id="1" data-toggle="tooltip" title="Enable" class="btn btn-success btnBulkAssign" onclick="massAction(this)" disabled><i class="fa fa-play"></i></button>
        <button type="button" id = "4"data-toggle="modal" data-target="#myModal" title="Assign" class="btn btn-info btnBulkAssign" disabled><i class="fa fa-link"></i></button>
        <button type="button" id="2" data-toggle="tooltip" title="Disable" class="btn btn-warning btnBulkAssign" onclick="massAction(this)" disabled><i class="fa fa-pause"></i></button>
        <button type="button" id="3" data-toggle="tooltip" title="<?php echo $button_delete; ?>" class="btn btn-danger btnBulkAssign" onclick="massAction(this)" disabled><i class="fa fa-trash-o"></i></button>
      </div>
      <h1> <?php echo $heading_title; ?></h1>
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
                <label class="control-label" for="input-name"><?php echo $column_id; ?></label>
                <input type="text" name="filter_id" value="<?php echo $filter_id; ?>" placeholder="<?php echo $column_id; ?>" id="filter_id" class="form-control" />
              </div>
            </div>
            <div class="col-sm-4">
              <div class="form-group">
                <label class="control-label" for="input-price"><?php echo $column_name; ?></label>
                <input type="text" name="filter_name" value="<?php echo $filter_name; ?>" placeholder="<?php echo $column_name; ?>" id="filter_name" class="form-control" />
              </div>
            </div>
            <div class="col-sm-4">
              <div class="form-group">
                <label class="control-label" for="input-quantity"><?php echo $column_views; ?></label>
                <input type="text" name="filter_view" value="<?php echo $filter_view; ?>" placeholder="<?php echo $column_views; ?>" id="filter_view" class="form-control" />
              </div>
              <button type="button" id="button-filter" class="btn btn-primary pull-right" onclick="filter();"><i class="fa fa-search"></i> Search</button>
              <button type="button" id="button-filter-reset" class="btn btn-primary pull-right" style="margin-right:10px;"><i class="fa fa-refresh"></i> Reset</button>
            </div>
          </div>
        </div>
        <form action="" method="post" enctype="multipart/form-data" id="form-category">
          <div class="table-responsive">
            <table class="table table-bordered table-hover">
              <thead>
                <tr>
                  <td style="width: 1px;" class="">
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
                  <td width="100"class="left"><?php echo $column_id; ?></td>
                  <td class="text-left"><?php if ($sort == 'name') { ?>
                    <a href="<?php echo $sort_name; ?>" class="<?php echo strtolower($order); ?>"><?php echo $column_name; ?></a>
                    <?php } else { ?>
                    <a href="<?php echo $sort_name; ?>"><?php echo $column_name; ?></a>
                    <?php } ?></td>
                  <td class="center" width="100"><?php echo $column_views; ?></td>
                  <td class="text-right"><?php if ($sort == 'sort_order') { ?>
                    <a href="<?php echo $sort_sort_order; ?>" class="<?php echo strtolower($order); ?>"><?php echo $column_sort_order; ?></a>
                    <?php } else { ?>
                    <a href="<?php echo $sort_sort_order; ?>"><?php echo $column_sort_order; ?></a>
                    <?php } ?></td>
                  <td class="center">Status</td>
                  <td class="text-right"><?php echo $column_action; ?></td>
                </tr>
              </thead>
              <tbody>
                <?php if ($categories) { ?>
                <?php foreach ($categories as $category) { ?>
                <tr>
                
                <tr class="<?php echo  $category['category_id']; ?>">
                  <td class="text-center"><?php if (in_array($category['category_id'], $selected)) { ?>
                    <input type="checkbox" name="selected[]" value="<?php echo $category['category_id']; ?>" checked="checked" />
                    <?php } else { ?>
                    <input type="checkbox" name="selected[]" value="<?php echo $category['category_id']; ?>" />
                    <?php } ?></td>
                  <td class="left"><?php echo $category['category_id']; ?></td>  
                  <td class="text-left"><?php echo $category['name']; ?></td>
                  <td class="center"><?php echo $category['views']; ?></td>
                  <td class="text-right"><?php echo $category['sort_order']; ?></td>
                  <td class="right" >
                  <select name="status" onchange="javascript:CatSelect(this,<?php echo $category['category_id']; ?>)">
                  <?php if ($category['status'] == "1") { ?>
                    <option value="1" selected="selected"><?php echo $text_enabled; ?></option>
                    <option value="0"><?php echo $text_disabled; ?></option>
                    <?php } else { ?>
                    <option value="0" selected="selected"><?php echo $text_disabled; ?></option>
                    <option value="1"><?php echo $text_enabled; ?></option>
                      <?php } ?>
                  </select>
                  </td>
                  <td class="text-right">
                  <a onclick="getproducts(<?php echo $category['category_id']; ?>,'<?php echo $category['name']; ?>')" data-toggle="tooltip" title="View Details" class="btn btn-primary"><i class="fa fa-eye"></i></a>
                  <a href="<?php echo $category['edit']; ?>" data-toggle="tooltip" title="<?php echo $button_edit; ?>" class="btn btn-primary"><i class="fa fa-pencil"></i></a></td>
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

           <!---------------------------------- Modal ----------------------------------------->
  <div class="modal fade" id="myModal" role="dialog">
    <div class="modal-dialog">
    
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Assign Selected  Category To Customer Group</h4>
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
          <button type="button" id="4" class="btn btn-success" onclick="massAction(this)" data-dismiss="modal">Assign</button>
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
</div>
<script type="text/javascript">
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
      var url = 'index.php?route=catalog/category/enableCategory&token=<?php echo $token; ?>';
      document.getElementById("form-category").action = url;  //Setting form action to "success.php" page
      confirm('<?php echo "Are you sure you want to enable selected Category?"; ?>') ? $('#form-category').submit() : false;
    }else if(clickedValue == 2){
      //disable
      var url = 'index.php?route=catalog/category/disableCategory&token=<?php echo $token; ?>';
      document.getElementById("form-category").action = url;  //Setting form action to "success.php" page
      confirm('<?php echo "Are you sure you want to disable selected Category?"; ?>') ? $('#form-category').submit() : false;
    }
    else if(clickedValue == 3){
       var url = 'index.php?route=catalog/category/delete&token=<?php echo $token; ?>';
       document.getElementById("form-category").action = url;  //Setting form action to "success.php" page
      confirm('<?php echo $text_confirm; ?>') ? $('#form-category').submit() : false;
    }else if(clickedValue == 4){
       //Assigin
       var url = 'index.php?route=catalog/product/assignCategoryToCustomerGroup&token=<?php echo $token; ?>';
       document.getElementById("form-product").action = url;  //Setting form action to "success.php" page
       confirm('<?php echo "Are you sure?"; ?>') ? $('#form-product').submit() : false;
     
    }

}

function filter(){
url="index.php?route=catalog/category&token=<?php echo $token; ?>";
var c=$('input[name=\'filter_name\']').val();
if(c){
	url+="&filter_name="+encodeURIComponent(c)
	}
var b=$('input[name=\'filter_id\']').val();
if(b){
	url+="&filter_id="+encodeURIComponent(b)
	}
var a=$('input[name=\'filter_view\']').val();
if(a){
	url+="&filter_view="+encodeURIComponent(a)
	}
location=url
	}
$("tr.filter td input[name='filter_id'],tr.filter td input[name='filter_name'],tr.filter td input[name='filter_view']").bind("keydown",function(a){if(a.keyCode==13){filter()
}
});
function getproducts(id,name) {
    $.ajax({
    url:"index.php?route=catalog/category/getproducts&token=<?php echo $token; ?>&id="+id+"<?php echo $url; ?>",
    dataType:"json",
    success:function(c){
    	if(c.length!=0){
    		var b="";
    		b+='<div class="boxpopup"></div>';
    		b+='<div class="popupcontent scrollbar" id="style-3"><div class="force-overflow">';
    		b+='<div class="buttons"><button class="button">Name: '+name+'</button>&nbsp&nbsp<button class="button">Products: '+c.countp+'</button>&nbsp&nbsp<button class="button">Sub categories : '+c.count+"</button>";
    		console.log(c.count);
    		if(c.count!=0){
    			b+='&nbsp&nbsp<select class="color" onchange="javascript:handleSelect(this)">';
    			b+="<option selected>Please Select</option>";
    			for(var a=c.cats.length-1;a>=0;a--){
    				b+='<option value="'+c.cats[a]["category_id"]+'">'+c.cats[a]["name"]+"</option>"
    				}
    			b+="</select>"
    			}
    		b+='<button class="button rt popupremove1">Exit</button><button class="button rt popupremove2">Save</button></div><br><br>';
    		b+=' <form action="'+c.action+'" method="post" enctype="multipart/form-data" id="form1">';
    		delete c.action;
    		delete c.count;
    		delete c.countp;
    		delete c.cats;
    		b+='<div class="datagrid"><table border="1"><thead><tr><th>Image</th><th>Name</th><th>Model</th><th>Quantity</th><th>Price</th><th>Special Price</th><th>Status</th><th>Action</th></tr></thead>';
    		for(var a in c){
    		var e=c[a];
    		b+="<tbody><tr>";
    		b+='<td><img src="'+e.thumb+'" alt='+e.name+"></img></td>";
    		b+='<td><input class="twitter" type="text" name="content['+e.product_id+'][name]" size="16" value="'+e.name+'"/></td>';
    		b+='<td><input class="twitter" type="text" name="content['+e.product_id+'][model]" size="16" value="'+e.model+'"/></td>';
    		b+='<td><input class="twitter" type="text" name="content['+e.product_id+'][quantity]" size="3" value="'+e.quantity+'"/></td>';
    		b+='<td><input class="twitter" type="text" name="content['+e.product_id+'][price]" size="7" value="'+e.price+'"/></td>';
    		if(e.special!=null){
    			b+='<td><input  class="twitter" type="text" name="content['+e.product_id+'][special]" size="7" value="'+e.special+'"/></td>'
    			}
    		else{
    			b+="<td>No Special price</td>"
    			}
    		b+='<td><select name="content['+e.product_id+'][status]">';
    		if(c[a]["status"]==1){
    			b+='<option value="1" selected>Enabled</option>';
    			b+='<option value="0" >Disabled</option>'
    		}else{
    			b+='<option value="1" >Enabled</option>';
    			b+='<option value="0" selected>Disabled</option>'
    		}
    		b+="</select></td>";
    		b+='<td><a target="_blank" href="'+e.href+'">Edit</a></td>';
    		b+="</tr></tbody>"}b+="</table></div>";b+="</form><br>";
    		b+="</div></div>";c="";
    		$(b).insertBefore("#footer");
    		$(".boxpopup").show();
    		$(".popupcontent").show()
    		}else{
    		var b="";
    		b+='<div class="boxpopup"></div>';
    		b+='<div class="popupcontent" style="text-align:center;"><button class="button rt popupremove1">Exit</button><h2>No products in selected Category</h2><div>';
    		$(b).insertBefore("#footer");$(".boxpopup").show();
    		$(".popupcontent").show();
    		}}});
    		$(document).on("click",".popupremove2",function(){$("#form1").submit()});
    		$(document).on("click",".boxpopup,.popupremove1",function(){$(".popupcontent").html("");$(".boxpopup").remove();$(".popupcontent").remove()});
}
</script>
<link rel="stylesheet" type="text/css" href="view/stylesheet/catview.css">
<script type="text/javascript">
function handleSelect(a){$(".popupcontent").html("");$(".boxpopup").remove();$(".popupcontent").remove();console.log(a);getproducts(a.value,a.options[a.selectedIndex].text)}function CatSelect(b,a){CatAjax(b.value,a);if(b.value==1){$("tr."+a).removeClass("catdis")}else{$("tr."+a).addClass("catdis")}}function CatAjax(a,b){$.ajax({url:"index.php?route=catalog/category/setstatus&token=<?php echo $token; ?>&id="+b+"&value="+a,dataType:"json",success:function(c){console.log("status set")}})};
</script>
<script>
$('#button-filter-reset').on('click', function() {
	
	var url = 'index.php?route=catalog/category&token=<?php echo $token; ?>';

	location = url;
});
</script>
<?php echo $footer; ?>