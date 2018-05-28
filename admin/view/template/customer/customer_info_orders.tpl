<?php echo $header; ?><?php echo $column_left; ?>
<div id="content">
  <div class="page-header">
    <div class="container-fluid">
      <div class="pull-right">
        <a href="<?php echo $cancel; ?>" data-toggle="tooltip" title="<?php echo $button_cancel; ?>" class="btn btn-default"><i class="fa fa-reply"></i></a>
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
        <h3 class="panel-title"><i class="fa fa-info-circle" style="font-size:23px;"></i> <?php echo $text_list; ?><strong><?php echo $customername; ?></strong></h3>
      </div>
      <div class="panel-body">
      	
        <ul class="nav nav-tabs">
            <li><a href="<?php echo $generaltab; ?>" >General</a></li>
            <li><a href="<?php echo $appointmenttab; ?>" >Appointment</a></li>
            <li><a href="<?php echo $customerstab; ?>" >Customer Contact</a></li>
            <li><a href="<?php echo $visitstab; ?>" >Visits</a></li>
            <li class="active"><a href="javascript:void()" >Orders</a></li>
            <li><a href="<?php echo $quotestab; ?>" >Quotes</a></li>
            <li><a href="<?php echo $historytab; ?>" >History</a></li>
            <li><a href="<?php echo $transactionstab; ?>" >Transactions</a></li>
            <li><a href="<?php echo $rewardpointstab; ?>" >Reward Points</a></li>
            <li><a href="<?php echo $ipaddressestab; ?>" >IP Addresses</a></li>
          </ul>
      
        <div class="well">
        	<h3>Filters</h3>
          <div class="row">
            <div class="col-sm-3 col-xs-6">
              <div class="form-group">
                <label class="control-label" for="input-order-id"><?php echo $entry_order_id; ?></label>
                <input type="text" name="filter_order_id" value="<?php echo $filter_order_id; ?>" placeholder="<?php echo $entry_order_id; ?>" id="input-order-id" class="form-control" />
              </div>
            </div>
            <div class="col-sm-3 col-xs-6">
              <div class="form-group">
                <label class="control-label" for="customer-contact">Customer Contact</label>
                <select name="filter_customer_contact_id" class="form-control" id="customer-contact">
                  <option value="">Select Customer Contact</option>
                  <?php foreach ($customer_contacts as $customerContact) :  ?>
                  <?php if ($customerContact['customer_con_id'] == $filter_customer_contact_id) : ?>
                    <option value="<?=$customerContact['customer_con_id']?>" selected="selected"><?=$customerContact['first_name']?> <?=$customerContact['last_name']?></option>
                  <?php else : ?>
                    <option value="<?php echo $customerContact['customer_con_id']; ?>"><?=$customerContact['first_name']?> <?=$customerContact['last_name']?></option>
                  <?php endif; ?>
                  <?php endforeach; ?>
                </select>         
              </div>
            </div>
            <div class="col-sm-3 col-xs-6">
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
            </div>
            <div class="col-sm-3 col-xs-6">
              <div class="form-group">
                <label class="control-label" for="input-date-added"><?php echo $entry_date_added; ?></label>
                <div class="input-group date">
                  <input type="text" name="filter_date_added" value="<?php echo $filter_date_added; ?>" placeholder="<?php echo $entry_date_added; ?>" data-date-format="YYYY-MM-DD" id="input-date-added" class="form-control" />
                  <span class="input-group-btn">
                  <button type="button" class="btn btn-default"><i class="fa fa-calendar"></i></button>
                  </span></div>
              </div>
            </div>
            <div class="col-sm-12">
              <button type="button" id="button-filter" class="btn btn-primary pull-right"><i class="fa fa-search"></i> Search</button>
              <button type="button" id="button-filter-reset" class="btn btn-primary pull-right" style="margin-right:10px;"><i class="fa fa-refresh"></i> Reset</button>
            </div>
            <!-- <div class="col-sm-4">
              
              <div class="form-group">
                <label class="control-label" for="input-date-modified"><?php echo $entry_date_modified; ?></label>
                <div class="input-group date">
                  <input type="text" name="filter_date_modified" value="<?php echo $filter_date_modified; ?>" placeholder="<?php echo $entry_date_modified; ?>" data-date-format="YYYY-MM-DD" id="input-date-modified" class="form-control" />
                  <span class="input-group-btn">
                  <button type="button" class="btn btn-default"><i class="fa fa-calendar"></i></button>
                  </span></div>
              </div>
            </div> -->
          </div>
        </div>
        <form method="post" action="" enctype="multipart/form-data" id="form-order">
          <div class="table-responsive">
            <table class="table table-bordered table-hover">
              <thead>
                <tr>
                  <td class="text-right"><?php if ($sort == 'o.order_id') { ?>
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
                  <td class="text-right"><?php if ($sort == 'o.total') { ?>
                    <a href="<?php echo $sort_total; ?>" class="<?php echo strtolower($order); ?>"><?php echo $column_total; ?></a>
                    <?php } else { ?>
                    <a href="<?php echo $sort_total; ?>"><?php echo $column_total; ?></a>
                    <?php } ?></td>
                  <td class="text-left"><?php if ($sort == 'o.date_modified') { ?>
                    <a href="<?php echo $sort_date_modified; ?>" class="<?php echo strtolower($order); ?>"><?php echo $column_date_modified; ?></a>
                    <?php } else { ?>
                    <a href="<?php echo $sort_date_modified; ?>"><?php echo $column_date_modified; ?></a>
                    <?php } ?></td>
                  <td class="text-left"><?php if ($sort == 'order_status') { ?>
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
                  <td class="text-right"><?php echo $order['order_id']; ?></td>
                  <td class="text-left"><?php echo $order['customer']; ?></td>
                  <td class="text-left"><?php echo $order['customercontact']; ?></td>
                  <td class="text-left"><?php echo $order['salesrep']; ?></td>
                  <td class="text-left"><?php echo $order['date_added']; ?></td>
                  <td class="text-right"><?php echo $order['total']; ?></td>
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
	url = 'index.php?route=customer/customer_info&token=<?php echo $token; ?>&type=orders&customer_id=<?php echo $customer_id; ?>';

	var filter_order_id = $('input[name=\'filter_order_id\']').val();

	if (filter_order_id) {
		url += '&filter_order_id=' + encodeURIComponent(filter_order_id);
	}

	var filter_customer = $('input[name=\'filter_customer\']').val();

	if (filter_customer) {
		url += '&filter_customer=' + encodeURIComponent(filter_customer);
	}

  var filter_customer_contact_id = $('select[name=\'filter_customer_contact_id\']').val();

  if (filter_customer_contact_id) {
    url += '&filter_customer_contact_id=' + encodeURIComponent(filter_customer_contact_id);
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
	
	var url = 'index.php?route=customer/customer_info&token=<?php echo $token; ?>&type=orders&customer_id=<?php echo $customer_id; ?>';

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
<?php echo $footer; ?> 