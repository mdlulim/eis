<?php echo $header; ?><?php echo $column_left; ?>

<div id="content">
  <div class="page-header">
    <div class="container-fluid">
      <div class="pull-right"><a href="<?php echo $add; ?>" data-toggle="tooltip" title="<?php echo $button_add; ?>" class="btn btn-primary"><i class="fa fa-plus"></i></a>
        <button type="button" data-toggle="tooltip" title="<?php echo $button_delete; ?>" id="button-delete" class="btn btn-danger" onclick="confirm('<?php echo $text_confirm; ?>') ? $('#form-user').submit() : false;"><i class="fa fa-trash-o"></i></button>
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
              <!--<div class="form-group">
                <label class="control-label" for="input-name">Appointment Name</label>
                <input type="text" name="filter_appointment_name" value="<?php echo $filter_appointment_name; ?>" placeholder="Appointment Name" id="input-name" class="form-control" />
              </div>-->
              <div class="form-group">
                <label class="control-label" for="input-price">Customer Name</label>
                <input type="text" name="filter_customer" value="<?php echo $filter_customer; ?>" placeholder="Customer Name" id="input-customer" class="form-control" />
          <input type="hidden" name="filter_customer_id" value="<?php echo $filter_customer_id; ?>" id="customer_id">
                <!--<select name="filter_customer_id" class="form-control">
                  <option value="">Customer Name</option>
                    <?php foreach ($customers as $customer) {  ?>
                <?php if ($customer['customer_id'] == $filter_customer_id) { ?>
                <option value="<?php echo $customer['customer_id']; ?>" selected="selected"><?php echo $customer['firstname']; ?></option>
                <?php } else { ?>
                <option value="<?php echo $customer['customer_id']; ?>"><?php echo $customer['firstname']; ?></option>
                <?php } ?>
                <?php } ?>
                    
                </select>-->
              </div>
              <div class="form-group fromdate">
                <label class="control-label" for="input-model">Appointment Date From</label>
                <!--<input type="text" name="filter_appointment_from" value="<?php echo $filter_appointment_from; ?>" placeholder="DD-MM-YYYY" data-date-format="DD-MM-YYYY" id="input-model" class="form-control" style="float:left;width:84%;" />
                <span class="input-group-btn" style="float:left;">
                  <button type="button" class="btn btn-default"><i class="fa fa-calendar"></i></button>
                  </span>-->
                
                <div class='input-group date' id='filter_appointment_from'>
                    <input name="filter_appointment_from" type='text' value="<?php echo $filter_appointment_from; ?>"  placeholder="Date From" class="form-control" data-date-format="DD-MM-YYYY hh:mm A" class="form-control"  />
                    <span class="input-group-addon">
                        <span class="glyphicon glyphicon-calendar"></span>
                    </span>
                </div>
           <style>
       .glyphicon-calendar:before {content: "\e109" !important; }
       </style>
              <script type="text/javascript">
            $(function () {
                $('#filter_appointment_from').datetimepicker({
                     //defaultDate: new Date(),
          // inline: true,
                });
            });
        </script>  
               
              </div>
            </div>
            <div class="col-sm-4">
              <div class="form-group">
                <label class="control-label" for="input-price">Sales Rep Name</label>
                  <input type="text" name="filter_salesrep" value="<?php echo $filter_salesrep; ?>" placeholder="Sales Rep Name" id="input-salesrep" class="form-control" />
                    <input type="hidden" name="filter_salesrep_id" value="<?php echo $filter_salesrep_id; ?>" />
                  <!--<select name="filter_salesrep_id" id="input-sales_manager" class="form-control">
                        <option value="">Select Sales Rep Name</option>
                        <?php foreach ($salesReps as $salesRep) { ?>
                        <?php if ($salesRep['salesrep_id'] == $filter_salesrep_id) { ?>
                        <option value="<?php echo $salesRep['salesrep_id']; ?>" selected="selected"><?php echo $salesRep['salesrep_name']; ?> <?php echo $salesRep['salesrep_lastname']; ?></option>
                        <?php } else { ?>
                        <option value="<?php echo $salesRep['salesrep_id']; ?>"><?php echo $salesRep['salesrep_name']; ?> <?php echo $salesRep['salesrep_lastname']; ?></option>
                        <?php } ?>
                        <?php } ?>
                      </select>-->
              </div>
              <div class="form-group todate">
                <label class="control-label" for="input-quantity">Appointment Date To</label>
                <!--<input type="text" name="filter_appointment_to" value="<?php echo $filter_appointment_to; ?>" placeholder="DD-MM-YYYY" data-date-format="DD-MM-YYYY" id="input-model" class="form-control" style="float:left;width:84%;" />
                <span class="input-group-btn" style="float:left;">
                  <button type="button" class="btn btn-default"><i class="fa fa-calendar"></i></button>
                  </span>-->
                  
                  <div class='input-group date' id='filter_appointment_to'>
                    <input name="filter_appointment_to" type='text' value="<?php echo $filter_appointment_to; ?>"  placeholder="Date To" class="form-control" data-date-format="DD-MM-YYYY hh:mm A" class="form-control"  />
                    <span class="input-group-addon">
                        <span class="glyphicon glyphicon-calendar"></span>
                    </span>
                </div>
            
            <script type="text/javascript">
            $(function () {
                $('#filter_appointment_to').datetimepicker({
                    //defaultDate: new Date(),
                   
                });
            });
        </script>
                  
              </div>
            </div>
            <div class="col-sm-4">
              <div class="form-group">
                <label class="control-label" for="input-price">Business Type</label>
                
                  <select name="filter_type" id="input-type" class="form-control">
                        <option value="">Select Business Type</option>
                        <?php if($filter_type == 'New Business') { ?>
                            <option value="New Business" selected="selected">New Business</option>
                        <?php } else { ?>
                            <option value="New Business">New Business</option>
                        <?php } ?>
                        <?php if($filter_type == 'Existing Business') { ?>
                            <option value="Existing Business" selected="selected">Existing Business</option>
                        <?php } else { ?>
                            <option value="Existing Business">Existing Business</option>
                        <?php } ?>
                      </select>
              </div>
              <div class="form-group" style="margin-top:23px;">
                <button type="button" id="button-filter" class="btn btn-primary pull-right"><i class="fa fa-search"></i> Search</button>
                <button type="button" id="button-filter-reset" class="btn btn-primary pull-right" style="margin-right:10px;"><i class="fa fa-refresh"></i> Reset</button>  
              </div>
            </div>
            
          </div>
           
        </div>
        
        <form action="<?php echo $delete; ?>" method="post" enctype="multipart/form-data" id="form-user">
          <div class="table-responsive">
            <table class="table table-bordered table-hover">
              <thead>
                <tr>
                  <th style="width: 1px;" class="text-center">
                    <input type="checkbox" onclick="$('input[name*=\'selected\']').prop('checked', this.checked);" />
                  </th>
                  <th class="text-left">Customer</th>
                  <th class="text-left">
                    <?php if ($sort == 'salesrepname') : ?>
                    <a href="<?php echo $sort_salesrepname; ?>" class="<?php echo strtolower($order); ?>">Sales Rep</a>
                    <?php else: ?>
                    <a href="<?php echo $sort_salesrepname; ?>">Sales Rep</a>
                    <?php endif; ?>
                  </th>
                  <th class="text-left">
                    <?php if ($sort == 'appointment_date') : ?>
                    <a href="<?php echo $sort_appointment_date; ?>" class="<?php echo strtolower($order); ?>">Appointment Date</a>
                    <?php else : ?>
                    <a href="<?php echo $sort_appointment_date; ?>">Appointment Date</a>
                    <?php endif; ?>
                  </th>
                  <th class="text-left">
                    <?php if ($sort == 'type') : ?>
                    <a href="<?php echo $sort_type; ?>" class="<?php echo strtolower($order); ?>">Appointment Type</a>
                    <?php else : ?>
                    <a href="<?php echo $sort_type; ?>">Business Type</a>
                    <?php endif; ?>
                  </th>
                  <th class="text-left">Visit Date</th>
                  <th class="text-right"><?php echo $column_action; ?></th>
                </tr>
              </thead>
              <tbody>
                <?php if ($access == 'yes') : ?>
                  <?php if (!empty($appointments)) : ?>
                    <?php foreach ($appointments as $appointment) : ?>
                    <tr>
                      <td class="text-center">
                        <?php if (in_array($appointment['appointment_id'], $selected)) : ?>
                        <input type="checkbox" name="selected[]" value="<?php echo $appointment['appointment_id']; ?>" checked="checked" />
                        <?php else : ?>
                        <input type="checkbox" name="selected[]" value="<?php echo $appointment['appointment_id']; ?>" />
                        <?php endif; ?>
                      </td>
                      <td class="text-left"><?php echo $appointment['customer_name']; ?></td>
                      <td class="text-left"><?php echo $appointment['salesrep_name']; ?></td>
                      <td class="text-left"><?php echo $appointment['appointment_date']; ?></td>
                      <td class="text-left"><span class="label label-<?=(strtolower($appointment['appointment_type'])=='new business')? 'default' : 'primary' ?>" style="font-size:14px;"><?=$appointment['appointment_type']?></span></td>
                      <td class="text-left"><?php echo $appointment['visit_date']; ?></td>
                      <td class="text-right">
                        <a href="<?php echo $appointment['notes']; ?>" data-toggle="tooltip" title="Notes" class="btn btn-primary"><i class="fa fa-sticky-note"></i></a>
                        <a href="<?php echo $appointment['view']; ?>" data-toggle="tooltip" title="View Appointment" class="btn btn-info"><i class="fa fa-eye"></i></a>
                      </td>
                    </tr>
                    <?php endforeach; ?>
                  <?php else : ?>
                  <tr>
                    <td class="text-center" colspan="7"><?php echo $text_no_results; ?></td>
                  </tr>
                  <?php endif; ?>
                <?php else : ?>
                <tr>
                  <td class="text-center" colspan="7">You Don't have Permission to access the Schedule Manegement.</td>
                </tr>
                <?php endif; ?>
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
<script type="text/javascript"><!--
$('#button-filter').on('click', function() {
  var url = 'index.php?route=replogic/schedule_management&token=<?php echo $token; ?>';
  var filter_appointment_name = $('input[name=\'filter_appointment_name\']').val();
  if (filter_appointment_name) {
    url += '&filter_appointment_name=' + encodeURIComponent(filter_appointment_name);
  }

  var filter_salesrep_id = $('input[name=\'filter_salesrep_id\']').val();

  if (filter_salesrep_id) {
    url += '&filter_salesrep_id=' + encodeURIComponent(filter_salesrep_id);
  }
  
  var filter_customer_id = $('input[name=\'filter_customer_id\']').val();

  if (filter_customer_id) {
    url += '&filter_customer_id=' + encodeURIComponent(filter_customer_id);
  }

  var filter_appointment_from = $('input[name=\'filter_appointment_from\']').val();

  if (filter_appointment_from) {
    url += '&filter_appointment_from=' + encodeURIComponent(filter_appointment_from);
  }
  
  var filter_appointment_to = $('input[name=\'filter_appointment_to\']').val();

  if (filter_appointment_to) {
    url += '&filter_appointment_to=' + encodeURIComponent(filter_appointment_to);
  }

  var filter_type = $('select[name=\'filter_type\']').val();

  if (filter_type) {
    url += '&filter_type=' + encodeURIComponent(filter_type);
  }
//alert(url);
  location = url;
});
$('#button-filter-reset').on('click', function() {
  var url = 'index.php?route=replogic/schedule_management&token=<?php echo $token; ?>';
  location = url;
});
//--></script>
<script type="text/javascript"><!--
$('input[name^=\'selected\']').on('change', function() {
  
  var selected = $('input[name^=\'selected\']:checked');
  if (selected.length) {
    $('#button-delete').prop('disabled', false);
  }
});
$('#button-delete').prop('disabled', true);
$('input[name^=\'selected\']:first').trigger('change');
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
    $('input[name=\'filter_salesrep_id\']').val(item['value']);
  }
});
//--></script> 

<?php echo $footer; ?> 