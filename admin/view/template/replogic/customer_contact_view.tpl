<?php echo $header; ?><?php echo $column_left; ?>
<div id="content">
  <div class="page-header">
    <div class="container-fluid">
      <div class="pull-right">
        <a href="<?php echo $editurl; ?>" data-toggle="tooltip" title="Edit" class="btn btn-primary"><i class="fa fa-pencil"></i> Edit</a>
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
    <div class="panel panel-default">
      <div class="panel-heading">
        <h3 class="panel-title"><i class="fa fa-eye"></i> View Customer Contact</h3>
      </div>
      <div class="panel-body">
        <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" id="form-user" class="form-horizontal">
          <div class="form-group">
            <label class="col-sm-2 control-label" for="input-username"><?php echo $entry_first_name; ?></label>
            <div class="col-sm-10">
              <input type="text" value="<?php echo $first_name; ?>" readonly="readonly" class="form-control" />
              
            </div>
          </div>
          <div class="form-group">
            <label class="col-sm-2 control-label" for="input-username"><?php echo $entry_last_name; ?></label>
            <div class="col-sm-10">
              <input type="text" value="<?php echo $last_name; ?>" readonly="readonly" class="form-control" />
            </div>
          </div>
          <div class="form-group">
            <label class="col-sm-2 control-label" for="input-user-group"><?php echo $entry_customer; ?></label>
            <div class="col-sm-10">
              <select name="customer_id" id="input-sales_manager" class="form-control" disabled="disabled">
             	<option value="">Select Customer</option>
                <?php foreach ($customers as $customer) {  ?>
                <?php if ($customer['customer_id'] == $ccustomer_id) { ?>
                <option value="<?php echo $customer['customer_id']; ?>" selected="selected"><?php echo $customer['firstname']; ?></option>
                <?php } else { ?>
                <option value="<?php echo $customer['customer_id']; ?>"><?php echo $customer['firstname']; ?></option>
                <?php } ?>
                <?php } ?>
              </select>
             
            </div>
          </div>
          
          <div class="form-group">
            <label class="col-sm-2 control-label" for="input-username"><?php echo $entry_email; ?></label>
            <div class="col-sm-10">
              <input type="text" value="<?php echo $email; ?>" readonly="readonly" class="form-control" />
              
            </div>
          </div>
          
          <div class="form-group">
            <label class="col-sm-2 control-label" for="input-username"><?php echo $entry_telephone_number; ?></label>
            <div class="col-sm-10">
              <input type="text" value="<?php echo $telephone_number; ?>" readonly="readonly" class="form-control" />
              
            </div>
          </div>
          
          <div class="form-group">
            <label class="col-sm-2 control-label" for="input-username"><?php echo $entry_cellphone_number; ?></label>
            <div class="col-sm-10">
              <input type="text" value="<?php echo $cellphone_number; ?>" readonly="readonly" class="form-control" />
             
            </div>
          </div>
          
          <div class="form-group">
            <label class="col-sm-2 control-label" for="input-username"><?php echo $entry_role; ?></label>
            <div class="col-sm-10">
              <input type="text" value="<?php echo $role; ?>" readonly="readonly" class="form-control" />
              
            </div>
          </div>
          
        </form>
      </div>
    </div>
  </div>
  
</div>
<?php echo $footer; ?> 