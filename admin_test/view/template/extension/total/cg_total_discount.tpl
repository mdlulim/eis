<?php echo $header; ?><?php echo $column_left; ?>
<div id="content">
  <div class="page-header">
    <div class="container-fluid">
      <div class="pull-right">
      <button type="submit" form="form-cg-total-discount" input type="hidden" id="save_stay" name="save_stay" value="1" data-toggle="tooltip" title="<?php echo $button_save_stay; ?>" class="btn btn-success"><?php echo $button_save_stay; ?></button>
        <button type="submit" form="form-cg-total-discount" data-toggle="tooltip" title="<?php echo $button_save; ?>" class="btn btn-primary"><i class="fa fa-save"></i></button>
        <a href="<?php echo $cancel; ?>" data-toggle="tooltip" title="<?php echo $button_cancel; ?>" class="btn btn-default"><i class="fa fa-reply"></i></a></div>
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
    <div class="panel panel-default">
      <div class="panel-heading">
        <h3 class="panel-title"><i class="fa fa-pencil"></i> <?php echo $text_edit; ?></h3>
      </div>
      <div class="panel-body">
        <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" id="form-cg-total-discount" class="form-horizontal">
          <ul class="nav nav-tabs" id="customer_group">
          <li><a href="#tab-global-sort-order" data-toggle="tab"><?php echo $tab_global; ?></a></li>
            <?php foreach ($customer_groups as $customer_group) { ?>
            <li><a href="#tab-<?php echo $customer_group['customer_group_id']; ?>" data-toggle="tab"><?php echo $customer_group['name']; ?></a></li>
            <?php } ?>
          </ul>
          <div class="tab-content">
          <div class="tab-pane" id="tab-global-sort-order">
            <label class="col-sm-2 control-label" for="input-global-sort-order"><span data-toggle="tooltip" title="<?php echo $help_global_sort_order; ?>"><?php echo $entry_global_sort_order; ?></span></label>
            <div class="col-sm-10">
              <input type="text" name="cg_total_discount_sort_order" value="<?php if(isset($cg_total_discount_sort_order)) { echo $cg_total_discount_sort_order; } ?>" placeholder="<?php echo $entry_global_sort_order; ?>" id="input-global-sort-order" class="form-control" />
            </div>
       </div>
            <?php foreach ($customer_groups as $customer_group) { ?>
            <div class="tab-pane" id="tab-<?php echo $customer_group['customer_group_id']; ?>">
            <table id="discount<?php echo $customer_group['customer_group_id']; ?>" class="table table-striped table-bordered table-hover">
            <thead>
              <tr>
               <td class="text-left"><span data-toggle="tooltip" title="<?php echo $help_title; ?>"><?php echo $entry_title; ?></span></td>
               <td class="text-left"><span data-toggle="tooltip" title="<?php echo $help_total_from; ?>"><?php echo $entry_total_from; ?></span></td>
               <td class="text-left"><span data-toggle="tooltip" title="<?php echo $help_total_to; ?>"><?php echo $entry_total_to; ?></td>
               <td class="text-left"><span data-toggle="tooltip" title="<?php echo $help_discount; ?>"><?php echo $entry_customer_group_discount; ?></span></td>
               <td class="text-left"><span data-toggle="tooltip" title="<?php echo $help_discount_type; ?>"><?php echo $entry_customer_group_discount_type; ?></span></td>
               <td class="text-left"><span data-toggle="tooltip" title="<?php echo $help_tax_class; ?>"><?php echo $entry_tax_class; ?></span></td> 
              </tr>
            </thead>
            <tbody>
              <?php $discount_row = 0; ?>
              <?php foreach ($total_discount_group_options as $group_option) { ?>
              <?php if ($group_option['customer_group_id'] == $customer_group['customer_group_id']) { ?>
              <tr id="discount-row<?php echo $customer_group['customer_group_id'] . $discount_row; ?>">
              <td><input type="text" name="cgd_options[<?php echo $discount_row; ?>][title]" value="<?php echo $group_option['cgd_options_title']; ?>" placeholder="<?php echo $entry_title; ?>" id="input-title<?php echo $discount_row; ?>" class="form-control" /></td>
              <td><input type="text" name="cgd_options[<?php echo $discount_row; ?>][total_from]" value="<?php echo $group_option['cgd_options_total_from']; ?>" placeholder="<?php echo $entry_total_from; ?>" id="input-total<?php echo $discount_row; ?>" class="form-control" /></td>
              <td><input type="text" name="cgd_options[<?php echo $discount_row; ?>][total_to]" value="<?php echo $group_option['cgd_options_total_to']; ?>" placeholder="<?php echo $entry_total_to; ?>" id="input-total<?php echo $discount_row; ?>" class="form-control" /></td>
              <td><input type="text" name="cgd_options[<?php echo $discount_row; ?>][discount]" value="<?php echo $group_option['cgd_options_discount']; ?>" placeholder="<?php echo $entry_customer_group_discount; ?>" id="input-discount<?php echo $discount_row; ?>" class="form-control" /></td>
              <input type="hidden" name="cgd_options[<?php echo $discount_row; ?>][customer_group]" value="<?php echo $customer_group['customer_group_id']; ?>"  id="input-customer-group<?php echo $discount_row; ?>" class="form-control" />
                <td class="text-left"><select name="cgd_options[<?php echo $discount_row; ?>][discount_type]" id="input-discount-type<?php echo $discount_row; ?>" class="form-control">
                    <?php if ($group_option['cgd_options_type'] == 'P') { ?>
                    <option value="P" selected="selected"><?php echo $text_percentage; ?></option>
                    <option value="F"><?php echo $text_fixed_amount; ?></option>
                    <?php } else { ?>
                    <option value="P"><?php echo $text_percentage; ?></option>
                    <option value="F" selected="selected"><?php echo $text_fixed_amount; ?></option>
                    <?php } ?>
                  </select>
                  <td><select name="cgd_options[<?php echo $discount_row; ?>][tax_class_id]" id="input-tax-class<?php echo $discount_row; ?>" class="form-control">
                    <option value="0"><?php echo $text_none; ?></option>
                    <?php foreach ($tax_classes as $tax_class) { ?>
                    <?php if ($group_option['cgd_options_tax_class'] == $tax_class['tax_class_id']) { ?>
                    <option value="<?php echo $tax_class['tax_class_id']; ?>" selected="selected"><?php echo $tax_class['title']; ?></option>
                    <?php } else { ?>
                    <option value="<?php echo $tax_class['tax_class_id']; ?>"><?php echo $tax_class['title']; ?></option>
                    <?php } ?>
                    <?php } ?>
                  </select></td></td>
                <td class="text-left"><button type="button" onclick="$('#discount-row<?php echo $customer_group['customer_group_id'] . $discount_row; ?>').remove();" data-toggle="tooltip" title="<?php echo $button_remove; ?>" class="btn btn-danger"><i class="fa fa-minus-circle"></i></button></td>
              </tr>
              <?php } ?>
              <?php $discount_row++; ?>
              <?php } ?>
            </tbody>
            <tfoot>
              <tr>
                <td colspan="6"></td>
                <?php $current_group = $customer_group['customer_group_id']; ?>
                <td class="text-left"><button type="button" onclick="addDiscountOptions(<?php echo $current_group; ?>);" data-toggle="tooltip" title="<?php echo $button_add_discount_options; ?>" class="btn btn-primary"><i class="fa fa-plus-circle"></i></button></td>
              </tr>
            </tfoot>
          </table>
              <div class="form-group">
                <label class="col-sm-2 control-label" for="input-status<?php echo $customer_group['customer_group_id']; ?>"><?php echo $entry_status; ?></label>
                <div class="col-sm-10">
                  <select name="cg_total_discount[<?php echo $customer_group['customer_group_id']; ?>][status]" id="input-status<?php echo $customer_group['customer_group_id']; ?>" class="form-control">
                    <?php if (isset($cg_total_discount[$customer_group['customer_group_id']]) && $cg_total_discount[$customer_group['customer_group_id']]['status']) { ?>
                    <option value="1" selected="selected"><?php echo $text_enabled; ?></option>
                    <option value="0"><?php echo $text_disabled; ?></option>
                    <?php } else { ?>
                    <option value="1"><?php echo $text_enabled; ?></option>
                    <option value="0" selected="selected"><?php echo $text_disabled; ?></option>
                    <?php } ?>
                  </select>
                </div>
              </div>
            </div>
            <?php } ?>
          </div>
        </form>
      </div>
    </div>
  </div>
  <script type="text/javascript"><!--
$('#customer_group a:first').tab('show');
//--></script>
 
<script type="text/javascript"><!--
var discount_row = <?php echo $discount_row; ?>;

function addDiscountOptions(current_group) {

	html  = '<tr id="discount-row'+ current_group + discount_row + '">';
	html += '<td><input type="text" name="cgd_options[' + discount_row + '][title]" value="" placeholder="<?php echo $entry_title; ?>" id="input-title[' + discount_row + ']" class="form-control" /></td>';
	html += '<td><input type="text" name="cgd_options[' + discount_row + '][total_from]" value="" placeholder="<?php echo $entry_total_from; ?>" id="input-total-from[' + discount_row + ']" class="form-control" /></td>';
	html += '<td><input type="text" name="cgd_options[' + discount_row + '][total_to]" value="" placeholder="<?php echo $entry_total_to; ?>" id="input-total_to[' + discount_row + ']" class="form-control" /></td>';
	html += '<td><input type="text" name="cgd_options[' + discount_row + '][discount]" value="" placeholder="<?php echo $entry_customer_group_discount; ?>" id="input-discount[' + discount_row + ']" class="form-control" /></td>';
	html += '<input type="hidden" name="cgd_options[' + discount_row + '][customer_group]" value="'+ current_group + '"  id="input-customer-group[' + discount_row + ']" class="form-control" />';
	html += '  <td class="text-left"><select name="cgd_options[' + discount_row + '][discount_type]" class="form-control">';
	html += '  <option value="P"><?php echo $text_percentage; ?></option>';
	html += '  <option value="F"><?php echo $text_fixed_amount; ?></option>'; 
	html += '  </select></td>';
	html += '  <td class="text-left"><select name="cgd_options[' + discount_row + '][tax_class_id]" id="input-tax-class' + current_group + '" class="form-control">';
	html += '  <option value="0"><?php echo $text_none; ?></option>';
	<?php foreach ($tax_classes as $tax_class) { ?>
	html += '  <option value="<?php echo $tax_class['tax_class_id']; ?>"><?php echo $tax_class['title']; ?></option>';
		<?php } ?>
	html += '  </select></td>';	
	html += '  <td class="text-left"><button type="button" onclick="$(\'#discount-row' + current_group + discount_row +'\').remove();" data-toggle="tooltip" title="<?php echo $button_remove; ?>" class="btn btn-danger"><i class="fa fa-minus-circle"></i></button></td>';
	html += '</tr>';
	
	$('#discount'+ current_group +' tbody').append(html);
	discount_row++;
}
//--></script>

</div>
<?php echo $footer; ?> 