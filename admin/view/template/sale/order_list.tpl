<?php echo $header; ?><?php echo $column_left; ?>
<div id="content" data-token="<?php echo $token; ?>">
  <div class="page-header">
    <div class="container-fluid">
      <div class="pull-right">
        <button type="submit" id="button-shipping" form="form-order" formaction="<?php echo $shipping; ?>" formtarget="_blank" data-toggle="tooltip" title="<?php echo $button_shipping_print; ?>" class="btn btn-info"><i class="fa fa-truck"></i></button>
        <button type="submit" id="button-invoice" form="form-order" formaction="<?php echo $invoice; ?>" formtarget="_blank" data-toggle="tooltip" title="<?php echo $button_invoice_print; ?>" class="btn btn-info"><i class="fa fa-print"></i></button>
        <a id="createOrder" href="<?php echo $add; ?>" data-toggle="tooltip" title="<?php echo $button_add; ?>" class="btn btn-primary"><i class="fa fa-plus"></i></a>
        <button type="button" id="button-delete" form="form-order" formaction="<?php echo $delete; ?>" data-toggle="tooltip" title="<?php echo $button_delete; ?>" class="btn btn-danger"><i class="fa fa-trash-o"></i></button>
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
                <label class="control-label" for="input-order-id"><?php echo $entry_order_id; ?></label>
                <input type="text" name="filter_order_id" value="<?php echo $filter_order_id; ?>" placeholder="<?php echo $entry_order_id; ?>" id="input-order-id" class="form-control" />
              </div>
              <div class="form-group">
                <label class="control-label" for="input-customer"><?php echo $entry_customer; ?></label>
                <input type="text" name="filter_customer" value="<?php echo $filter_customer; ?>" placeholder="<?php echo $entry_customer; ?>" id="input-customer" class="form-control" />
                <!--<select name="filter_customer_id" class="form-control">
                  <option value="">Select Customer Name</option>
                    <?php foreach ($customers as $customer) {  ?>
                <?php if ($customer['customer_id'] == $filter_customer_id) { ?>
                <option value="<?php echo $customer['customer_id']; ?>" selected="selected"><?php echo $customer['firstname']; ?></option>
                <?php } else { ?>
                <option value="<?php echo $customer['customer_id']; ?>"><?php echo $customer['firstname']; ?></option>
                <?php } ?>
                <?php } ?>
                    
                </select>-->
              </div>
            </div>
            <div class="col-sm-4">
              <div class="form-group">
                <label class="control-label" for="input-order-status"><?php echo $entry_order_status; ?></label>
                <select name="filter_order_status" id="input-order-status" class="form-control">
                  <option value="*">Select Status</option>
                  <?php if (isset($order_statuses) && is_array($order_statuses)) : ?>
                    <?php foreach($order_statuses as $key => $selectStatus) : ?>
                      <?php if ($filter_order_status == $selectStatus['order_status_id']) : ?>
                        <option value="<?=$selectStatus['order_status_id']?>" selected="selected">
                          <?=$selectStatus['name']?>
                        </option>
                      <?php else : ?>
                        <option value="<?=$selectStatus['order_status_id']?>">
                          <?=$selectStatus['name']?>
                        </option>
                      <?php endif; ?>
                    <?php endforeach; ?>
                  <?php endif; ?>
                </select>
              </div>
              <div class="form-group">
                <!--<label class="control-label" for="input-total"><?php echo $entry_total; ?></label>
                <input type="text" name="filter_total" value="<?php echo $filter_total; ?>" placeholder="<?php echo $entry_total; ?>" id="input-total" class="form-control" />-->
                 <label class="control-label" for="input-customer">Customer Contact</label>
                   <input type="text" name="filter_customercontact" value="<?php echo $filter_customercontact; ?>" placeholder="Customer Contact" id="input-customercontact" class="form-control" />
                     <input type="hidden" name="filter_customer_contactid" value="<?php echo $filter_customer_contactid; ?>" />
                   <!--<select name="filter_customer_contactid" class="form-control">
                  <option value="">Select Customer Contact</option>
                    <?php foreach ($customercontacts as $customercontact) {  ?>
                <?php if ($customercontact['customer_con_id'] == $filter_customer_contactid) { ?>
                <option value="<?php echo $customercontact['customer_con_id']; ?>" selected="selected"><?php echo $customercontact['first_name']; ?> <?php echo $customercontact['last_name']; ?></option>
                <?php } else { ?>
                <option value="<?php echo $customercontact['customer_con_id']; ?>"><?php echo $customercontact['first_name']; ?> <?php echo $customercontact['last_name']; ?></option>
                <?php } ?>
                <?php } ?>
                    
                </select>-->         
              </div>
            </div>
            <div class="col-sm-4">
              <div class="form-group">
                <label class="control-label" for="input-date-added"><?php echo $entry_date_added; ?></label>
                <div class="input-group date">
                  <input type="text" name="filter_date_added" value="<?php echo $filter_date_added; ?>" placeholder="<?php echo $entry_date_added; ?>" data-date-format="YYYY-MM-DD" id="input-date-added" class="form-control" />
                  <span class="input-group-btn">
                  <button type="button" class="btn btn-default"><i class="fa fa-calendar"></i></button>
                  </span></div>
              </div>
              <!--<div class="form-group">
                <label class="control-label" for="input-date-modified"><?php echo $entry_date_modified; ?></label>
                <div class="input-group date">
                  <input type="text" name="filter_date_modified" value="<?php echo $filter_date_modified; ?>" placeholder="<?php echo $entry_date_modified; ?>" data-date-format="YYYY-MM-DD" id="input-date-modified" class="form-control" />
                  <span class="input-group-btn">
                  <button type="button" class="btn btn-default"><i class="fa fa-calendar"></i></button>
                  </span></div>
              </div>-->
              <div class="form-group">
                <label class="control-label" for="input-customer">Sales Rep Name</label>
                   <input type="text" name="filter_salesrep" value="<?php echo $filter_salesrep; ?>" placeholder="Sales Rep Name" id="input-salesrep" class="form-control" />
                   <input type="hidden" name="filter_salesrepid" value="<?php echo $filter_salesrepid; ?>" />
                   <!--<select name="filter_salesrepid" class="form-control">
                  <option value="">Select Sales Rep Name</option>
                    <?php foreach ($salesrepnames as $salesrepname) {  ?>
                <?php if ($salesrepname['salesrep_id'] == $filter_salesrepid) { ?>
                <option value="<?php echo $salesrepname['salesrep_id']; ?>" selected="selected"><?php echo $salesrepname['salesrep_name']; ?> <?php echo $salesrepname['salesrep_lastname']; ?></option>
                <?php } else { ?>
                <option value="<?php echo $salesrepname['salesrep_id']; ?>"><?php echo $salesrepname['salesrep_name']; ?> <?php echo $salesrepname['salesrep_lastname']; ?></option>
                <?php } ?>
                <?php } ?>
                    
                </select>-->         
              </div>
              <button type="button" id="button-filter" class="btn btn-primary pull-right"><i class="fa fa-search"></i> Search</button>
              <button type="button" id="button-filter-reset" class="btn btn-primary pull-right" style="margin-right:10px;"><i class="fa fa-refresh"></i> Reset</button>
            </div>
          </div>
        </div>
        <form method="post" action="" enctype="multipart/form-data" id="form-order">
          <div class="table-responsive">
            <table class="table table-bordered table-hover">
              <thead>
                <tr>
                  <td style="width: 1px;" class="text-center"><input type="checkbox" onclick="$('input[name*=\'selected\']').prop('checked', this.checked);" /></td>
                  <td class="text-left"><?php if ($sort == 'o.order_id') { ?>
                    <a href="<?php echo $sort_order; ?>" class="<?php echo strtolower($order); ?>"><?php echo $column_order_id; ?></a>
                    <?php } else { ?>
                    <a href="<?php echo $sort_order; ?>"><?php echo $column_order_id; ?></a>
                    <?php } ?></td>
                  <td class="text-left"><?php if ($sort == 'customer') { ?>
                    <a href="<?php echo $sort_customer; ?>" class="<?php echo strtolower($order); ?>"><?php echo $column_customer; ?></a>
                    <?php } else { ?>
                    <a href="<?php echo $sort_customer; ?>"><?php echo $column_customer; ?></a>
                    <?php } ?></td>
                  <td class="text-left"><?php if ($sort == 'oq.customer_contact_id') { ?>
                    <a href="<?php echo $sort_customercontact; ?>" class="<?php echo strtolower($order); ?>">Customer Contact</a>
                    <?php } else { ?>
                    <a href="<?php echo $sort_customercontact; ?>">Customer Contact</a>
                    <?php } ?></td>
                  <td class="text-left"><?php if ($sort == 'salesrep') { ?>
                    <a href="<?php echo $sort_salesrep; ?>" class="<?php echo strtolower($order); ?>">Sales Rep</a>
                    <?php } else { ?>
                    <a href="<?php echo $sort_salesrep; ?>">Sales Rep</a>
                    <?php } ?></td>
                  <td class="text-left"><?php if ($sort == 'o.date_added') { ?>
                    <a href="<?php echo $sort_date_added; ?>" class="<?php echo strtolower($order); ?>"><?php echo $column_date_added; ?></a>
                    <?php } else { ?>
                    <a href="<?php echo $sort_date_added; ?>"><?php echo $column_date_added; ?></a>
                    <?php } ?></td>
                  <td class="text-left"><?php if ($sort == 'o.total') { ?>
                    <a href="<?php echo $sort_total; ?>" class="<?php echo strtolower($order); ?>"><?php echo $column_total; ?></a>
                    <?php } else { ?>
                    <a href="<?php echo $sort_total; ?>"><?php echo $column_total; ?></a>
                    <?php } ?></td>
                  <td class="text-left"><?php if ($sort == 'o.date_modified') { ?>
                    <a href="<?php echo $sort_date_modified; ?>" class="<?php echo strtolower($order); ?>"><?php echo $column_date_modified; ?></a>
                    <?php } else { ?>
                    <a href="<?php echo $sort_date_modified; ?>"><?php echo $column_date_modified; ?></a>
                    <?php } ?></td>
                    <td class="text-left" width="128px"><?php if ($sort == 'order_status') { ?>
                    <a href="<?php echo $sort_status; ?>" class="<?php echo strtolower($order); ?>"><?php echo $column_status; ?></a>
                    <?php } else { ?>
                    <a href="<?php echo $sort_status; ?>"><?php echo $column_status; ?></a>
                    <?php } ?></td>
                  <td class="text-right"><?php echo $column_action; ?></td>
                </tr>
              </thead>
              <tbody>
                <?php if ($orders) { ?>
                <?php foreach ($orders as $order) { ?>
                <tr>
                  <td class="text-center"><?php if (in_array($order['order_id'], $selected)) { ?>
                    <input type="checkbox" name="selected[]" value="<?php echo $order['order_id']; ?>" checked="checked" />
                    <?php } else { ?>
                    <input type="checkbox" name="selected[]" value="<?php echo $order['order_id']; ?>" />
                    <?php } ?>
                    <input type="hidden" name="shipping_code[]" value="<?php echo $order['shipping_code']; ?>" /></td>
                  <td class="text-left"><?php echo $order['order_id']; ?></td>
                  <td class="text-left"><?php echo $order['customer']; ?></td>
                  <td class="text-left"><?php echo $order['customercontact']; ?></td>
                  <td class="text-left"><?php echo $order['salesrep']; ?></td>
                  <td class="text-left"><?php echo $order['date_added']; ?></td>
                  <td class="text-left"><?php echo $order['total']; ?></td>
                  <td class="text-left"><?php echo $order['date_modified']; ?></td>
                  <td class="text-left">
                    <?php if ($order['order_status_id'] == $order_status_confirmed) : ?>
                      <a class="btn-success" style="padding:2px 5px;border-radius:5px;">Order Confirmed</a>
                    <?php elseif ($order['order_status_id'] == $order_status_pending) : ?>
                      <a class="btn-warning" style="padding:2px 5px;border-radius:5px;">Pending</a>
                    <?php elseif ($order['order_status_id'] == $order_status_cancelled) : ?>
                      <a class="btn-warning" style="padding:2px 5px;border-radius:5px;background-color:#DB524B;">Cancelled</a>
                    <?php elseif ($order['order_status_id'] == $order_status_processing) : ?>
                      <a class="btn-warning" style="background-color: white;border: 1px solid #000;border-radius: 5px;color: #666666;padding: 0 10px;">Processing</a>
                    <?php endif; ?>
                  </td>
                  <td class="text-right"><a href="<?php echo $order['view']; ?>" data-toggle="tooltip" title="<?php echo $button_view; ?>" class="btn btn-info"><i class="fa fa-eye"></i></a> <!--<a href="<?php echo $order['edit']; ?>" data-toggle="tooltip" title="<?php echo $button_edit; ?>" class="btn btn-primary"><i class="fa fa-pencil"></i></a>--></td>
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
        </form>
        <div class="row">
          <div class="col-sm-6 text-left"><?php echo $pagination; ?></div>
          <div class="col-sm-6 text-right"><?php echo $results; ?></div>
        </div>
      </div>
    </div>
  </div>

  <!-- Modal -->
  <div class="modal fade" id="createOrderModal" tabindex="-1" role="dialog" aria-labelledby="createOrderModalLabel">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <form action="<?php echo $create_order_action; ?>" method="get">
          <input type="hidden" name="route" value="sale/order/add">
          <input type="hidden" name="token" value="<?php echo $token; ?>">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <h4 class="modal-title" id="createOrderModalLabel">
              Create New Order
            </h4>
          </div>
          <div class="modal-body">
            <p><strong>Create a new order for a customer</strong></p>
            <div class="row">
              <div class="form-group">
                <label class="col-sm-4 col-xs-12 text-right">Customer:</label>
                <div class="col-sm-8 col-xs-12">
                  <select class="form-control" name="customer">
                    <option value="">Select Customer</option>
                    <?php if (!empty($customers)) : ?>
                    <?php foreach($customers as $key => $customer) : ?>
                    <option value="<?php echo $customer['customer_id']; ?>" data-contract-pricing="<?php echo $customer['customer_group']; ?>">
                      <?php echo $customer['firstname']; ?>
                    </option>
                    <?php endforeach; ?>
                    <?php endif; ?>                  </select>
                </div>
              </div>
            </div>
            <div class="row">
              <div class="form-group">
                <label class="col-sm-4 col-xs-12 text-right">Contract Pricing:</label>
                <div class="col-sm-8 col-xs-12">
                  <input type="text" class="form-control" name="contract_pricing" value="--" disabled="disabled" />
                </div>
              </div>
            </div>
            <div class="row">
              <div class="form-group">
                <label class="col-sm-4 col-xs-12 text-right">Comment:</label>
                <div class="col-sm-8 col-xs-12">
                  <textarea class="form-control" name="comment"></textarea>
                </div>
              </div>
            </div>
          </div>
          <div class="modal-footer">
            <button type="submit" id="createOrderBtn" class="btn btn-primary" disabled="disabled">Continue</button>
            <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
          </div>
        </form>
      </div>
    </div>
  </div>
  <style>
  .form-group + .form-group{border-top:none;}
  </style>
 <script type="text/javascript"><!--
$('input[name^=\'selected\']').on('change', function() {
  
  var selected = $('input[name^=\'selected\']:checked');
  if (selected.length) {
    $('#button-delete').prop('disabled', false);
  }
  else
  {
    $('#button-delete').prop('disabled', true);
  }
});
$('#button-delete').prop('disabled', true);
//--></script>   
  <script type="text/javascript"><!--
$('#button-filter').on('click', function() {
  url = 'index.php?route=sale/order&token=<?php echo $token; ?>';
  var filter_order_id = $('input[name=\'filter_order_id\']').val();
  if (filter_order_id) {
    url += '&filter_order_id=' + encodeURIComponent(filter_order_id);
  }
  var filter_customer = $('input[name=\'filter_customer\']').val();
  if (filter_customer) {
    url += '&filter_customer=' + encodeURIComponent(filter_customer);
  }
  
  var filter_customer_id = $('select[name=\'filter_customer_id\']').val();
  if (filter_customer_id) {
    url += '&filter_customer_id=' + encodeURIComponent(filter_customer_id);
  }
  
  /*var filter_customer_contactid = $('select[name=\'filter_customer_contactid\']').val();*/
  var filter_customer_contactid = $('input[name=\'filter_customer_contactid\']').val();
  if (filter_customer_contactid) {
    url += '&filter_customer_contactid=' + encodeURIComponent(filter_customer_contactid);
  }
  
  /*var filter_salesrepid = $('select[name=\'filter_salesrepid\']').val();*/
  var filter_salesrepid = $('input[name=\'filter_salesrepid\']').val();
  if (filter_salesrepid) {
    url += '&filter_salesrepid=' + encodeURIComponent(filter_salesrepid);
  }
  var filter_order_status = $('select[name=\'filter_order_status\']').val();
  if (filter_order_status != '*') {
    url += '&filter_order_status=' + encodeURIComponent(filter_order_status);
  }
  var filter_total = $('input[name=\'filter_total\']').val();
  if (filter_total) {
    url += '&filter_total=' + encodeURIComponent(filter_total);
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
  //var team_id = $('input[name=\'team_id\']').val();
  //var url = 'index.php?route=sale/order&token=<?php echo $token; ?>&team_id=' + team_id + '';
  var url = 'index.php?route=sale/order&token=<?php echo $token; ?>';
  location = url;
});
//--></script> 
  <script type="text/javascript"><!--
$('input[name=\'filter_customer\']').autocomplete({
  'source': function(request, response) {
    $.ajax({
      url: 'index.php?route=customer/customer/autocomplete&token=<?php echo $token; ?>&filter_name=' +  encodeURIComponent(request),
      dataType: 'json',
      success: function(json) {
        response($.map(json, function(item) {
          return {
            label: item['name'],
            value: item['customer_id']
          }
        }));
      }
    });
  },
  'select': function(item) {
    $('input[name=\'filter_customer\']').val(item['label']);
  }
});
$('input[name=\'filter_customercontact\']').autocomplete({
  'source': function(request, response) {
    $.ajax({
      url: 'index.php?route=replogic/customer_contact/autocomplete&token=<?php echo $token; ?>&filter_name=' +  encodeURIComponent(request),
      dataType: 'json',
      success: function(json) {
        response($.map(json, function(item) {
          return {
            label: item['name'],
            value: item['customer_con_id']
          }
        }));
      }
    });
  },
  'select': function(item) {
    $('input[name=\'filter_customercontact\']').val(item['label']);
    $('input[name=\'filter_customer_contactid\']').val(item['value']);
  }
});
$('input[name=\'filter_salesrep\']').autocomplete({
  'source': function(request, response) {
    $.ajax({
      url: 'index.php?route=replogic/sales_rep_management/autocomplete&token=<?php echo $token; ?>&filter_name=' +  encodeURIComponent(request),
      dataType: 'json',
      success: function(json) {
        response($.map(json, function(item) {
          return {
            label: item['name'],
            value: item['salesrep_id']
          }
        }));
      }
    });
  },
  'select': function(item) {
    $('input[name=\'filter_salesrep\']').val(item['label']);
    $('input[name=\'filter_salesrepid\']').val(item['value']);
  }
});
//--></script> 
  <script type="text/javascript"><!--
$('input[name^=\'selected\']').on('change', function() {
  $('#button-shipping, #button-invoice').prop('disabled', true);
  var selected = $('input[name^=\'selected\']:checked');
  if (selected.length) {
    $('#button-invoice').prop('disabled', false);
  }
  for (i = 0; i < selected.length; i++) {
    if ($(selected[i]).parent().find('input[name^=\'shipping_code\']').val()) {
      $('#button-shipping').prop('disabled', false);
      break;
    }
  }
});
$('#button-shipping, #button-invoice').prop('disabled', true);
$('input[name^=\'selected\']:first').trigger('change');
// IE and Edge fix!
$('#button-shipping, #button-invoice').on('click', function(e) {
  $('#form-order').attr('action', this.getAttribute('formAction'));
});
$('#button-delete').on('click', function(e) {
  $('#form-order').attr('action', this.getAttribute('formAction'));
  
  if (confirm('<?php echo $text_confirm; ?>')) {
    $('#form-order').submit();
  } else {
    return false;
  }
});
//--></script> 
  <script src="view/javascript/jquery/datetimepicker/bootstrap-datetimepicker.min.js" type="text/javascript"></script>
  <link href="view/javascript/jquery/datetimepicker/bootstrap-datetimepicker.min.css" type="text/css" rel="stylesheet" media="screen" />
  <script type="text/javascript"><!--
$('.date').datetimepicker({
  pickTime: false
});
//--></script></div>

<!-- Page loader -->
<div class="loader-wrapper" style="display:none">
  <div class="loader"></div>
</div>
<!-- /Page loader -->
<?php echo $footer; ?> 