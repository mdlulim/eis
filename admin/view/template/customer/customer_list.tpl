<?php echo $header; ?><?php echo $column_left; ?>
<div id="content">
  <div class="page-header">
    <div class="container-fluid">
      <div class="pull-right"><a href="<?php echo $add; ?>" data-toggle="tooltip" title="<?php echo $button_add; ?>" class="btn btn-primary"><i class="fa fa-plus"></i></a>
        <button id="button-invitation" type="button" data-toggle="tooltip" title="Send Invitation" class="btn btn-primary"><i class="fa fa-paper-plane"></i></button>
        <button id="button-delete" type="button" data-toggle="tooltip" title="<?php echo $button_delete; ?>" class="btn btn-danger" onclick="Confirminvitation('delete','Are you sure want to Delete Customer ?')"><i class="fa fa-trash-o"></i></button>
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
                <!--<select name="filter_customer_id" class="form-control">
                  <option value="">Customer Name</option>
                    <?php foreach ($customerdropdown as $customerd) {  ?>
                <?php if ($customerd['customer_id'] == $filter_customer_id) { ?>
                <option value="<?php echo $customerd['customer_id']; ?>" selected="selected"><?php echo $customerd['firstname']; ?></option>
                <?php } else { ?>
                <option value="<?php echo $customerd['customer_id']; ?>"><?php echo $customerd['firstname']; ?></option>
                <?php } ?>
                <?php } ?>
                    
                </select>-->
              </div>
              <div class="form-group">
                <label class="control-label" for="input-email"><?php echo $entry_email; ?></label>
                <input type="text" name="filter_email" value="<?php echo $filter_email; ?>" placeholder="<?php echo $entry_email; ?>" id="input-email" class="form-control" />
                <!--<select name="filter_email_id" class="form-control">
                  <option value="">Select E-Mail</option>
                    <?php foreach ($customerdropdown as $customerd) {  ?>
                <?php if ($customerd['customer_id'] == $filter_email_id) { ?>
                <option value="<?php echo $customerd['customer_id']; ?>" selected="selected"><?php echo $customerd['email']; ?></option>
                <?php } else { ?>
                <option value="<?php echo $customerd['customer_id']; ?>"><?php echo $customerd['email']; ?></option>
                <?php } ?>
                <?php } ?>
                    
                </select>-->
              </div>
            </div>
            <div class="col-sm-4">
              <div class="form-group">
                <label class="control-label" for="input-customer-group">Contract Pricing</label>
                <select name="filter_customer_group_id" id="input-customer-group" class="form-control">
                  <option value="*">Select Contract Pricing</option>
                  <?php foreach ($customer_groups as $customer_group) { ?>
                  <?php if ($customer_group['customer_group_id'] == $filter_customer_group_id) { ?>
                  <option value="<?php echo $customer_group['customer_group_id']; ?>" selected="selected"><?php echo $customer_group['name']; ?></option>
                  <?php } else { ?>
                  <option value="<?php echo $customer_group['customer_group_id']; ?>"><?php echo $customer_group['name']; ?></option>
                  <?php } ?>
                  <?php } ?>
                </select>
              </div>
              <div class="form-group">
                <label class="control-label" for="input-status"><?php echo $entry_status; ?></label>
                <select name="filter_status" id="input-status" class="form-control">
                  <option value="*">Select Status</option>
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
            </div>
             <div class="col-sm-4" style="display: none;">
              <div class="form-group">
                <label class="control-label" for="input-approved"><?php echo $entry_approved; ?></label>
                <select name="filter_approved" id="input-approved" class="form-control">
                  <option value="*">Select Approval Status</option>
                  <?php if ($filter_approved) { ?>
                  <option value="1" selected="selected"><?php echo $text_yes; ?></option>
                  <?php } else { ?>
                  <option value="1"><?php echo $text_yes; ?></option>
                  <?php } ?>
                  <?php if (!$filter_approved && !is_null($filter_approved)) { ?>
                  <option value="0" selected="selected"><?php echo $text_no; ?></option>
                  <?php } else { ?>
                  <option value="0"><?php echo $text_no; ?></option>
                  <?php } ?>
                </select>
              </div>
            </div>
             <div class="col-sm-4">
              <div class="form-group">
                <label class="control-label" for="input-wholesale"><?php echo $entry_wholesale; ?></label>
                <select name="filter_wholesale" id="input-wholesale" class="form-control">
                  <option value="*">Select Wholesale Status</option>
                  <?php if ($filter_wholesale) { ?>
                  <option value="1" selected="selected">Invited</option>
                  <?php } else { ?>
                  <option value="1"><?php echo "Invited"; ?></option>
                  <?php } ?>
                  <?php if (!$filter_wholesale && !is_null($filter_wholesale)) { ?>
                  <option value="0" selected="selected"><?php echo "Not Invited"; ?></option>
                  <?php } else { ?>
                  <option value="0"><?php echo "Not Invited"; ?></option>
                  <?php } ?>
                </select>
              </div>
            </div>
              <!--<div class="form-group">
                <label class="control-label" for="input-ip"><?php echo $entry_ip; ?></label>
                <input type="text" name="filter_ip" value="<?php echo $filter_ip; ?>" placeholder="<?php echo $entry_ip; ?>" id="input-ip" class="form-control" />
              </div>-->

            <div class="col-sm-4">

              <div class="form-group">
                <label class="control-label" for="input-date-added"><?php echo $entry_date_added; ?></label>
                <div class="input-group date">
                  <input type="text" name="filter_date_added" value="<?php echo $filter_date_added; ?>" placeholder="<?php echo $entry_date_added; ?>" data-date-format="YYYY-MM-DD" id="input-date-added" class="form-control" />
                  <span class="input-group-btn">
                  <button type="button" class="btn btn-default"><i class="fa fa-calendar"></i></button>
                  </span></div>
              </div>
            </div>
            <div class="col-sm-12 pull-right">
              <button type="button" id="button-filter" class="btn btn-primary pull-right"><i class="fa fa-search"></i> Search</button>
               <button type="button" id="button-filter-reset" class="btn btn-primary pull-right" style="margin-right:10px;"><i class="fa fa-refresh"></i> Reset</button>
            </div>
          </div>
        </div>
        <form action="<?php echo $delete; ?>" method="post" enctype="multipart/form-data" id="form-customer">
          <div class="table-responsive">
            <table class="table table-bordered table-hover">
              <thead>
                <tr>
                  <td style="width: 1px;" class="text-center"><input type="checkbox" class="check__bulk-select-all" onclick="$('input[name*=\'selected\']').prop('checked', this.checked);" /></td>
                  <td class="text-left"><?php if ($sort == 'name') { ?>
                    <a href="<?php echo $sort_name; ?>" class="<?php echo strtolower($order); ?>"><?php echo $column_name; ?></a>
                    <?php } else { ?>
                    <a href="<?php echo $sort_name; ?>"><?php echo $column_name; ?></a>
                    <?php } ?></td>
                  <td class="text-left"><?php if ($sort == 'c.email') { ?>
                    <a href="<?php echo $sort_email; ?>" class="<?php echo strtolower($order); ?>"><?php echo $column_email; ?></a>
                    <?php } else { ?>
                    <a href="<?php echo $sort_email; ?>"><?php echo $column_email; ?></a>
                    <?php } ?></td>
                  <td class="text-left"><?php if ($sort == 'customer_group') { ?>
                    <a href="<?php echo $sort_customer_group; ?>" class="<?php echo strtolower($order); ?>"><?php echo $column_customer_group; ?></a>
                    <?php } else { ?>
                    <a href="<?php echo $sort_customer_group; ?>"><?php echo $column_customer_group; ?></a>
                    <?php } ?></td>
                  <td class="text-left"><?php if ($sort == 'c.status') { ?>
                    <a href="<?php echo $sort_status; ?>" class="<?php echo strtolower($order); ?>"><?php echo $column_status; ?></a>
                    <?php } else { ?>
                    <a href="<?php echo $sort_status; ?>"><?php echo $column_status; ?></a>
                    <?php } ?></td>
                  <!--<td class="text-left"><?php if ($sort == 'c.ip') { ?>
                    <a href="<?php echo $sort_ip; ?>" class="<?php echo strtolower($order); ?>"><?php echo $column_ip; ?></a>
                    <?php } else { ?>
                    <a href="<?php echo $sort_ip; ?>"><?php echo $column_ip; ?></a>
                    <?php } ?></td>-->
                  <td class="text-left"><?php if ($sort == 'c.date_added') { ?>
                    <a href="<?php echo $sort_date_added; ?>" class="<?php echo strtolower($order); ?>"><?php echo $column_date_added; ?></a>
                    <?php } else { ?>
                    <a href="<?php echo $sort_date_added; ?>"><?php echo $column_date_added; ?></a>
                    <?php } ?></td>
                    <td class="text-left"><?php if ($sort == 'c.status') { ?>
                    <a href="<?php echo $sort_status; ?>" class="<?php echo strtolower($order); ?>">Wholesale Activity</a>
                    <?php } else { ?>
                    <a href="<?php echo $sort_status; ?>">Wholesale Activity</a>
                    <?php } ?></td>
                  <td class="text-right"><?php echo $column_action; ?></td>
                </tr>
              </thead>
              <tbody>
                <?php if ($customers) { ?>
                <?php foreach ($customers as $customer) { ?>
                <tr>
                  <td class="text-center"><?php if (in_array($customer['customer_id'], $selected)) { ?>
                    <input type="checkbox" name="selected[]" value="<?php echo $customer['customer_id']; ?>" checked="checked" />
                    <?php } else { ?>
                    <input type="checkbox" name="selected[]" value="<?php echo $customer['customer_id']; ?>" />
                    <?php } ?></td>
                  <td class="text-left"><?php echo $customer['name']; ?></td>
                  <td class="text-left"><?php echo $customer['email']; ?></td>
                  <td class="text-left"><?php echo $customer['customer_group']; ?></td>
                  <td class="text-left"><?php echo $customer['status']; ?></td>
                  <!--<td class="text-left"><?php echo $customer['ip']; ?></td>-->
                  <td class="text-left"><?php echo $customer['date_added']; ?></td>
                  <td class="text-left"><?php echo $customer['wholesale_activity']; ?></td>
                  <td class="text-right"><!--<?php if ($customer['approve']) { ?>
                    <a href="<?php echo $customer['approve']; ?>" data-toggle="tooltip" title="<?php echo $button_approve; ?>" class="btn btn-success"><i class="fa fa-thumbs-o-up"></i></a>
                    <?php } else { ?>
                    <button type="button" class="btn btn-success" disabled><i class="fa fa-thumbs-o-up"></i></button>
                    <?php } ?>
                    <div class="btn-group" data-toggle="tooltip" title="<?php echo $button_login; ?>">
                      <button type="button" data-toggle="dropdown" class="btn btn-info dropdown-toggle"><i class="fa fa-lock"></i></button>
                      <ul class="dropdown-menu pull-right">
                        <li><a href="index.php?route=customer/customer/login&token=<?php echo $token; ?>&customer_id=<?php echo $customer['customer_id']; ?>&store_id=0" target="_blank"><?php echo $text_default; ?></a></li>
                        <?php foreach ($stores as $store) { ?>
                        <li><a href="index.php?route=customer/customer/login&token=<?php echo $token; ?>&customer_id=<?php echo $customer['customer_id']; ?>&store_id=<?php echo $store['store_id']; ?>" target="_blank"><?php echo $store['name']; ?></a></li>
                        <?php } ?>
                      </ul>
                    </div>
                    <?php if ($customer['unlock']) { ?>
                    <a href="<?php echo $customer['unlock']; ?>" data-toggle="tooltip" title="<?php echo $button_unlock; ?>" class="btn btn-warning"><i class="fa fa-unlock"></i></a>
                    <?php } else { ?>
                    <button type="button" class="btn btn-warning" disabled><i class="fa fa-unlock"></i></button>
                    <?php } ?>-->
                    <a href="<?php echo $customer['view']; ?>" data-toggle="tooltip" title="<?php echo $customer['name']; ?>" class="btn btn-info"><i class="fa fa-eye"></i></a>
                    <!--<a href="<?php echo $customer['edit']; ?>" data-toggle="tooltip" title="<?php echo $button_edit; ?>" class="btn btn-primary"><i class="fa fa-pencil"></i></a>--></td>
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

  <!-- Page loader -->
  <div class="loader-wrapper" style="display:none">
    <div class="loader"></div>
  </div>
  <!-- /Page loader -->

 <script type="text/javascript"><!--
$('input[name^=\'selected\']').on('change', function() { 
  var selected = $('input[name^=\'selected\']:checked');
  if (selected.length) {
    $('#button-delete').prop('disabled', false);
    $('#button-invitation').prop('disabled', false);
  }
  else
  {
    $('#button-delete').prop('disabled', true);
    $('#button-invitation').prop('disabled', true);
  }
  if (selected.length < 50) {
    $('input[type="checkbox"].check__bulk-select-all').prop('checked', false);
  }
});
$('#button-delete').prop('disabled', true);
$('#button-invitation').prop('disabled', true);
$('input[name^=\'selected\']:first').trigger('change');
$('input:checkbox').change(function () {
   var selected = $('input[name^=\'selected\']:checked');
  if (selected.length) {
    $('#button-delete').prop('disabled', false);
    $('#button-invitation').prop('disabled', false);
  }
  else
  {
    $('#button-delete').prop('disabled', true);
    $('#button-invitation').prop('disabled', true);
  }
})
$('#button-delete').click(function(){
   $('#form-customer').attr('action', '<?php echo $delete; ?>');
});
function Confirminvitation(action, msg)
{
  var x = confirm(msg);
  if (x)
  {
      if(action == 'delete')
    {
      var faction = '<?php echo $delete; ?>';
    }
    else
    {
      var faction = '<?php echo $invitation; ?>';
    }
    var newul = faction.replace(/&amp;/g, "&");
    $('#form-customer').attr('action', newul);
    $('#form-customer').submit()
    return true;
  }
  else {
    return false;
 }
}
//--></script>  
  <script type="text/javascript"><!--
$('#button-filter').on('click', function() {
  url = 'index.php?route=customer/customer&token=<?php echo $token; ?>';
  
  var filter_name = $('input[name=\'filter_name\']').val();
  
  if (filter_name) {
    url += '&filter_name=' + encodeURIComponent(filter_name);
  }
  
  var filter_customer_id = $('select[name=\'filter_customer_id\']').val();
  if (filter_customer_id) {
    url += '&filter_customer_id=' + encodeURIComponent(filter_customer_id);
  }
  
  var filter_email_id = $('select[name=\'filter_email_id\']').val();
  if (filter_email_id) {
    url += '&filter_email_id=' + encodeURIComponent(filter_email_id);
  }
  
  var filter_email = $('input[name=\'filter_email\']').val();
  
  if (filter_email) {
    url += '&filter_email=' + encodeURIComponent(filter_email);
  }
  
  var filter_customer_group_id = $('select[name=\'filter_customer_group_id\']').val();
  
  if (filter_customer_group_id != '*') {
    url += '&filter_customer_group_id=' + encodeURIComponent(filter_customer_group_id);
  } 
  
  var filter_status = $('select[name=\'filter_status\']').val();
  
  if (filter_status != '*') {
    url += '&filter_status=' + encodeURIComponent(filter_status); 
  } 
  
  var filter_approved = $('select[name=\'filter_approved\']').val();
  
  if (filter_approved != '*') {
    url += '&filter_approved=' + encodeURIComponent(filter_approved);
  }

  var filter_wholesale = $('select[name=\'filter_wholesale\']').val();
  
  if (filter_wholesale != '*') {
    url += '&filter_wholesale=' + encodeURIComponent(filter_wholesale);
  }

  var filter_ip = $('input[name=\'filter_ip\']').val();
  
  if (filter_ip) {
    url += '&filter_ip=' + encodeURIComponent(filter_ip);
  }
    
  var filter_date_added = $('input[name=\'filter_date_added\']').val();
  
  if (filter_date_added) {
    url += '&filter_date_added=' + encodeURIComponent(filter_date_added);
  }
  
  location = url;
});
$('#button-filter-reset').on('click', function() {
  var url = 'index.php?route=customer/customer&token=<?php echo $token; ?>';
  location = url;
});
//--></script> 
  <script type="text/javascript"><!--
$('input[name=\'filter_name\']').autocomplete({
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
    $('input[name=\'filter_name\']').val(item['label']);
  } 
});
$('input[name=\'filter_email\']').autocomplete({
  'source': function(request, response) {
    $.ajax({
      url: 'index.php?route=customer/customer/autocomplete&token=<?php echo $token; ?>&filter_email=' +  encodeURIComponent(request),
      dataType: 'json',     
      success: function(json) {
        response($.map(json, function(item) {
          return {
            label: item['email'],
            value: item['customer_id']
          }
        }));
      }
    });
  },
  'select': function(item) {
    $('input[name=\'filter_email\']').val(item['label']);
  } 
});
//--></script> 
  <script type="text/javascript"><!--
$('.date').datetimepicker({
  pickTime: false
});
//--></script>
<style>
.form-group + .form-group{border-top:none!important;}
</style>
</div>
<?php echo $footer; ?> 