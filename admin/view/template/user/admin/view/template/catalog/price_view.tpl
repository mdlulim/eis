<?php echo $header; ?><?php echo $column_left; ?>
<div id="content">
    <div class="page-header">
        <div class="container-fluid">
            <div class="pull-right">
                <a href="<?php echo $action; ?>" data-toggle="tooltip" title="Edit" class="btn btn-primary"><i class="fa fa-pencil"></i></a>
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
        <h3 class="panel-title"><i class="fa fa-info-circle" style="font-size:23px;"></i> Contract Pricing Info : <strong><?php echo $price_info['sku']; ?></strong></h3>
      </div>
            <div class="panel-body">
                <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" id="form-filter" class="form-horizontal">
                    <div class="form-group">
                        <label class="col-sm-2 control-label" for="input-sort-order"><?php echo $entry_sku; ?></label>
                        <div class="col-sm-10">
                            <input type="text" name="sku" value="<?php echo $price_info['sku']; ?>" placeholder="<?php echo $entry_sku; ?>" id="input-sort-order" class="form-control" disabled="disabled" />
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-2 control-label" for="input-contract"><?php echo $entry_contract; ?></label>
                        <div class="col-sm-10">
                            <select name="customer_group_id" id="input-contract" class="form-control" disabled="disabled">
                                <?php foreach ($customer_groups as $_customer_groups) { ?>
                                <?php if ($_customer_groups['customer_group_id'] == $price_info['customer_group_id']) { ?>
                                <option value="<?php echo $_customer_groups['customer_group_id']; ?>" selected="selected"><?php echo $_customer_groups['name']; ?></option>
                                <?php } else { ?>
                                <option value="<?php echo $_customer_groups['customer_group_id']; ?>"><?php echo $_customer_groups['name']; ?></option>
                                <?php } ?>
                                <?php } ?>
                            </select>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-sm-2 control-label" for="input-sort-order"><?php echo $entry_price; ?></label>
                        <div class="col-sm-10">
                            <input type="text" name="price" value="<?php echo $price_info['price']; ?>" placeholder="<?php echo $entry_price; ?>" id="input-sort-order" class="form-control" disabled="disabled" />
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <script type="text/javascript"><!--
        var filter_row = <?php echo $filter_row; ?>;
        function addFilterRow() {
            html  = '<tr id="filter-row' + filter_row + '">';
            html += '  <td class="text-left" style="width: 70%;"><input type="hidden" name="filter[' + filter_row + '][filter_id]" value="" />';
        <?php foreach ($languages as $language) { ?>
                html += '  <div class="input-group">';
                html += '    <span class="input-group-addon"><img src="view/image/flags/<?php echo $language['image']; ?>" title="<?php echo $language['name']; ?>" /></span><input type="text" name="filter[' + filter_row + '][filter_description][<?php echo $language['language_id']; ?>][name]" value="" placeholder="<?php echo $entry_name ?>" class="form-control" />';
                html += '  </div>';
            <?php } ?>
            html += '  </td>';
            html += '  <td class="text-right"><input type="text" name="filter[' + filter_row + '][sort_order]" value="" placeholder="<?php echo $entry_sort_order; ?>" id="input-sort-order" class="form-control" /></td>';
            html += '  <td class="text-left"><button type="button" onclick="$(\'#filter-row' + filter_row + '\').remove();" data-toggle="tooltip" title="<?php echo $button_remove; ?>" class="btn btn-danger"><i class="fa fa-minus-circle"></i></button></td>';
            html += '</tr>';
            $('#filter tbody').append(html);
            filter_row++;
        }
        //--></script></div>
<?php echo $footer; ?>