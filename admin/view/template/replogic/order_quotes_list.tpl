<?php echo $header; ?><?php echo $column_left; ?>
<div id="content">
  <div class="page-header">
    <div class="container-fluid">
      <div class="pull-right">
        <?php if($delete) { ?>
        <button type="button" id="button-delete" form="form-order" data-toggle="tooltip" title="<?php echo $button_delete; ?>" class="btn btn-danger"><i class="fa fa-trash-o"></i></button>
        <?php } ?>
        <button type="button" id="button-deny" form="form-order" data-toggle="tooltip" title="Deny Quote(s)" class="btn btn-danger"><i class="fa fa-times"></i></button>
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
                <label class="control-label" for="input-order-id"><?php echo $entry_quote_id; ?></label>
                <input type="text" name="filter_quote_id" value="<?php echo $filter_quote_id; ?>" placeholder="<?php echo $entry_quote_id; ?>" id="input-order-id" class="form-control" />
              </div>
              <div class="form-group">
                <label class="control-label" for="input-customer"><?php echo $entry_customer; ?></label>
                <input type="text" name="filter_customer" value="<?php echo $filter_customer; ?>" placeholder="<?php echo $entry_customer; ?>" id="input-customer" class="form-control" />
             <input type="hidden" name="filter_customer_id" value="<?php echo $filter_customer_id; ?>" id="customer_id">       
              </div>
            </div>
            <div class="col-sm-4">
              <div class="form-group">
                <label class="control-label" for="input-order-status"><?php echo $entry_order_status; ?></label>
                <select name="filter_order_status" id="input-order-status" class="form-control">
                  <option value="*">Select Status</option>
                  <?php if (isset($quote_statuses) && is_array($quote_statuses)) : ?>
                    <?php foreach($quote_statuses as $key => $selectStatus) : ?>
                      <?php if ($filter_order_status == $selectStatus['quote_status_id']) : ?>
                        <option value="<?=$selectStatus['quote_status_id']?>" selected="selected">
                          <?=$selectStatus['name']?>
                        </option>
                      <?php else : ?>
                        <option value="<?=$selectStatus['quote_status_id']?>">
                          <?=$selectStatus['name']?>
                        </option>
                      <?php endif; ?>
                    <?php endforeach; ?>
                  <?php endif; ?>
                  
                </select>
              </div>
              <div class="form-group">
                <label class="control-label" for="input-customer">Customer Contact Name</label>
                <input type="text" name="filter_customercontact" value="<?php echo @$filter_customercontact; ?>" placeholder="Customer Contact" id="input-customer-contact" class="form-control" />
             <input type="hidden" name="filter_customer_contact_id" value="<?php echo $filter_customer_contact_id; ?>" id="customer_contact_id">     
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
              <div class="form-group">
                <label class="control-label" for="input-customer">Sales Rep Name</label>
                   <input type="text" name="filter_salesrep" value="<?php echo @$filter_salesrep; ?>" placeholder="Sales Rep Name" id="input-salesrep" class="form-control" />
                   <input type="hidden" name="filter_salesrepid" value="<?php echo $filter_salesrepid; ?>" />        
              </div>
              <div>
              <button type="button" id="button-filter" class="btn btn-primary pull-right"><i class="fa fa-search"></i> Search</button>
              <button type="button" id="button-filter-reset" class="btn btn-primary pull-right" style="margin-right:10px;"><i class="fa fa-refresh"></i> Reset</button>
              </div>
            </div>
          </div>
        </div>
        <form method="post" action="" enctype="multipart/form-data" id="form-order">
          <div class="table-responsive">
            <table class="table table-bordered table-hover">
              <thead>
                <tr>
                  <td style="width: 1px;" class="text-center"><input type="checkbox" onclick="$('input[name*=\'selected\']').prop('checked', this.checked);" /></td>
                  <td class="text-left" width="85"><?php if ($sort == 'quote_id') { ?>
                    <a href="<?php echo $sort_order; ?>" class="<?php echo strtolower($order); ?>"><?php echo $column_quote_id; ?></a>
                    <?php } else { ?>
                    <a href="<?php echo $sort_order; ?>"><?php echo $column_quote_id; ?></a>
                    <?php } ?></td>
                  <td class="text-left" width="82"><?php if ($sort == 'order_id') { ?>
                    <a href="<?php echo $sort_order_id; ?>" class="<?php echo strtolower($order); ?>">Order Id</a>
                    <?php } else { ?>
                    <a href="<?php echo $sort_order_id; ?>">Order Id</a>
                    <?php } ?></td>  
                  <td class="text-left"><?php if ($sort == 'customer') { ?>
                    <a href="<?php echo $sort_customer; ?>" class="<?php echo strtolower($order); ?>"><?php echo $column_customer; ?></a>
                    <?php } else { ?>
                    <a href="<?php echo $sort_customer; ?>"><?php echo $column_customer; ?></a>
                    <?php } ?></td>
                    <td class="text-left"><?php if ($sort == 'customer_contact') { ?>
                    <a href="<?php echo $sort_customer_contact; ?>" class="<?php echo strtolower($order); ?>"><?php echo $column_customer_contact; ?></a>
                    <?php } else { ?>
                    <a href="<?php echo $sort_customer_contact; ?>"><?php echo $column_customer_contact; ?></a>
                    <?php } ?></td>
                    <td class="text-left"><?php if ($sort == 'sort_salesrep_id') { ?>
                    <a href="<?php echo $sort_salesrep_id; ?>" class="<?php echo strtolower($order); ?>">Sales Rep Name</a>
                    <?php } else { ?>
                    <a href="<?php echo $sort_salesrep_id; ?>">Sales Rep Name</a>
                    <?php } ?></td>
                    <td class="text-left"><?php if ($sort == 'date_added') { ?>
                    <a href="<?php echo $sort_date_added; ?>" class="<?php echo strtolower($order); ?>"><?php echo $column_date_added; ?></a>
                    <?php } else { ?>
                    <a href="<?php echo $sort_date_added; ?>"><?php echo $column_date_added; ?></a>
                    <?php } ?></td>
                  <td class="text-left"><?php if ($sort == 'total') { ?>
                    <a href="<?php echo $sort_total; ?>" class="<?php echo strtolower($order); ?>"><?php echo $column_total; ?></a>
                    <?php } else { ?>
                    <a href="<?php echo $sort_total; ?>"><?php echo $column_total; ?></a>
                    <?php } ?></td>
                  <td class="text-left" width="130"><?php if ($sort == 'order_status') { ?>
                    <a href="<?php echo $sort_status; ?>" class="<?php echo strtolower($order); ?>"><?php echo $column_status; ?></a>
                    <?php } else { ?>
                    <a href="<?php echo $sort_status; ?>"><?php echo $column_status; ?></a>
                    <?php } ?></td>
                  <td class="text-left"><?php if ($sort == 'signed') { ?>
                    <a href="<?php echo $sort_signed; ?>" class="<?php echo strtolower($order); ?>"><?php echo $column_signed; ?></a>
                    <?php } else { ?>
                    <a href="<?php echo $sort_signed; ?>"><?php echo $column_signed; ?></a>
                    <?php } ?></td>
                  <td class="text-right"><?php echo $column_action; ?></td>
                </tr>
              </thead>
              <tbody>
                <?php if ($orders) { ?>
                <?php foreach ($orders as $order) { ?>
                <tr>
                  <td class="text-center"><?php if (in_array($order['quote_id'], $selected)) { ?>
                    <input type="checkbox" name="selected[]" value="<?php echo $order['quote_id']; ?>" checked="checked" />
                    <?php } else { ?>
                    <input type="checkbox" name="selected[]" value="<?php echo $order['quote_id']; ?>" />
                    <?php } ?>
                    <input type="hidden" name="shipping_code[]" value="<?php echo $order['shipping_code']; ?>" /></td>
                  <td class="text-left"><?php echo $order['quote_id']; ?></td>
                  <td class="text-left"><?php echo $order['order_id']; ?></td>
                  <td class="text-left"><?php echo $order['customer']; ?></td>
                  <td class="text-left"><?php echo $order['customer_contact']; ?></td>
                  <td class="text-left"><?php echo $order['salesrepname']; ?></td>
                  <td class="text-left"><?php echo $order['date_added']; ?></td>
                  <td class="text-left">
                    <?php if($order['total'] != '') { ?>
                      <?php echo $order['total']; ?>
                    <?php } else { ?>
                     Null
                    <?php } ?>  
                    </td>
                  <td class="text-left" style="min-width:140px;">
                    <?php if ($order['quote_status_id'] == $quote_status_converted) : ?>
                      <a class="btn-success" style="padding:2px 5px;border-radius:5px;"><?=$order['quote_status']?></a>
                    <?php elseif ($order['quote_status_id'] == $quote_status_denied) : ?>
                      <a class="btn-danger" style="padding:2px 5px;border-radius:5px;"><?=$order['quote_status']?></a>
                    <?php elseif ($order['quote_status_id'] == $quote_status_pending) : ?>
                      <a class="btn-warning" style="padding:2px 5px;border-radius:5px;"><?=$order['quote_status']?></a>
                    <?php endif; ?>
                  </td>
                  <td class="text-left"><?php echo ($order['signed']) ? 'Signed' : 'Not Signed'; ?></td>
                  <td class="text-right">
                    
                      <?php if($order['view']) { ?>
                        <a href="<?php echo $order['view']; ?>" data-toggle="tooltip" title="View Quote" class="btn btn-info"><i class="fa fa-eye"></i></a>
                      <?php } ?>
                    
                    </td>
                    
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
         
        <div id="myModal" class="modal fade" role="dialog">
          <form action="<?php echo $decline; ?>" method="post" enctype="multipart/form-data" id="form-popup">
          <input type="hidden" name="quote_id" id="popupquote_id" value=""  />
          <div class="modal-dialog">
        
            <!-- Modal content-->
            <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Confirm Decline</h4>
              </div>
              <div class="modal-body">
                <p><strong>Please Enter reason</strong> </p>
                <textarea name="reason" rows="5" placeholder="Plz Enter Reason" id="reason" class="form-control"></textarea>
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-primary" id="Decline">Confirm</button>
                <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
              </div>
            </div>
        
          </div>
          </form>
        </div>
        <div class="row">
          <div class="col-sm-6 text-left"><?php echo $pagination; ?></div>
          <div class="col-sm-6 text-right"><?php echo $results; ?></div>
        </div>
      </div>
    </div>
  </div>
  <script type="text/javascript">
  
    function onpopup(id)
    {
     
      $('#popupquote_id').val(); 
      $('#popupquote_id').val(id); 
      document.getElementById('reason').value = "";
      $('#myModal').modal('show'); 
      $('#Decline').attr('disabled', 'disabled');
    }
    
    $('#Decline').prop('disabled', true);
    $('#reason').on('keyup',function() {
      if($(this).val()) {
        $('#Decline').prop('disabled' , false);
      }else{
        $('#Decline').prop('disabled' , true);
      }
    });
    
    document.getElementById('Decline').onclick = function() {
        document.getElementById('form-popup').submit();
        return false;
      };
    
    
    </script>
  <script type="text/javascript"><!--
$('#button-filter').on('click', function() {
  url = 'index.php?route=replogic/order_quotes&token=<?php echo $token; ?>';
  var filter_quote_id = $('input[name=\'filter_quote_id\']').val();
  if (filter_quote_id) {
    url += '&filter_quote_id=' + encodeURIComponent(filter_quote_id);
  }
  var filter_customer_id = $('input[name=\'filter_customer_id\']').val();
  if (filter_customer_id) {
    url += '&filter_customer_id=' + encodeURIComponent(filter_customer_id);
  }
  
  var filter_customer_contact_id = $('input[name=\'filter_customer_contact_id\']').val();
  if (filter_customer_contact_id) {
    url += '&filter_customer_contact_id=' + encodeURIComponent(filter_customer_contact_id);
  }
  
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
  location = url;
});
$('#button-filter-reset').on('click', function() {
  var url = 'index.php?route=replogic/order_quotes&token=<?php echo $token; ?>';
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
    $('input[name=\'filter_customer_id\']').val(item['value']);
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
    $('input[name=\'filter_customer_contact_id\']').val(item['value']);
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
$('input[name=\'filter_customer_contact\']').autocomplete({
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
    $('input[name=\'filter_customer_contact\']').val(item['label']);
    $('input[name=\'filter_customer_contact_id\']').val(item['value']);
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
  
  if (selected.length) {
    $('#button-delete').prop('disabled', false);
  }
  for (i = 0; i < selected.length; i++) {
    if ($(selected[i]).parent().find('input[name^=\'shipping_code\']').val()) {
      $('#button-shipping').prop('disabled', false);
      break;
    }
  }
});
$('#button-shipping, #button-invoice, #button-delete').prop('disabled', true);
$('input[name^=\'selected\']:first').trigger('change');
// IE and Edge fix!
$('#button-shipping, #button-invoice').on('click', function(e) {
  $('#form-order').attr('action', this.getAttribute('formAction'));
});
// $('#button-delete').on('click', function(e) {
//   $('#form-order').attr('action', this.getAttribute('formAction'));
  
//   if (confirm('<?php echo $text_confirm; ?>')) {
//     $('#form-order').submit();
//   } else {
//     return false;
//   }
// });
//--></script> 
  <script src="view/javascript/jquery/datetimepicker/bootstrap-datetimepicker.min.js" type="text/javascript"></script>
  <link href="view/javascript/jquery/datetimepicker/bootstrap-datetimepicker.min.css" type="text/css" rel="stylesheet" media="screen" />
  <script type="text/javascript"><!--
$('.date').datetimepicker({
  pickTime: false
});
//--></script>
<script type="text/javascript"><!--
$('input[name^=\'selected\']').on('change', function() { 
  
  var selected = $('input[name^=\'selected\']:checked');
  if (selected.length) {
    $('#button-delete').prop('disabled', false);
    $('#button-deny').prop('disabled', false);
  }
  else
  {
    $('#button-delete').prop('disabled', true);
    $('#button-deny').prop('disabled', true);
  }
});
$('#button-delete').prop('disabled', true);
$('#button-deny').prop('disabled', true);
$('input[name^=\'selected\']:first').trigger('change');
$('input:checkbox').change(function () {
   var selected = $('input[name^=\'selected\']:checked');
  if (selected.length) {
    $('#button-delete').prop('disabled', false);
    $('#button-deny').prop('disabled', false);
  }
  else
  {
    $('#button-delete').prop('disabled', true);
    $('#button-deny').prop('disabled', true);
  }
})
$('#button-delete').click(function(){
  var url = 'index.php?route=replogic/order_quotes/delete&token=<?php echo $token; ?>';
  document.getElementById("form-order").action = url; 
  confirm('<?php echo "Are you sure you want to delete selected Quate(s)?"; ?>') ? $('#form-order').submit() : false;
    
  //  $('#form-order').attr('action', '<?php echo $delete; ?>');
  //   $('#form-order').submit();
});
$('#button-deny').click(function(){
   var url = 'index.php?route=replogic/order_quotes/deny&token=<?php echo $token; ?>';
   document.getElementById("form-order").action = url; 
   confirm('<?php echo "Are you sure you want to Deny selected Quate(s)?"; ?>') ? $('#form-order').submit() : false;
   
  //  $('#form-order').attr('action', '<?php echo $deny; ?>');
  //   $('#form-order').submit();
});
// function Confirmbtn(action, msg)
// {
//   var x = confirm(msg);
//   alert("action"+x);
//   if (x)
//   {
//       if(action == 'delete')
//     {
//       var faction = '<?php echo @$delete; ?>';
//     }
//     else
//     {
//       var faction = '<?php echo @$deny; ?>';
//     }
//     var newul = faction.replace(/&amp;/g, "&");
//     $('#form-order').attr('action', newul);
//     $('#form-order').submit()
//     return true;
//   }
//   else {
//     return false;
//  }
// }
//--></script>
<style>
  .form-group + .form-group{border-top:none;}
  </style>
</div>
<?php echo $footer; ?> 