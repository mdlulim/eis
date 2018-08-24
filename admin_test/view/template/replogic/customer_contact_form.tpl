<?php echo $header; ?><?php echo $column_left; ?>
<div id="content">
  <div class="page-header">
    <div class="container-fluid">
      <div class="pull-right">
        <button type="submit" form="form-user" data-toggle="tooltip" title="<?php echo $button_save; ?>" class="btn btn-primary"><i class="fa fa-save"></i></button>
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
        <h3 class="panel-title"><i class="fa fa-pencil"></i> <?php echo $text_form; ?></h3>
      </div>
      <div class="panel-body">
        <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" id="form-user" class="form-horizontal">
          <div class="form-group required">
            <label class="col-sm-2 control-label" for="input-username"><?php echo $entry_first_name; ?></label>
            <div class="col-sm-10">
              <input type="text" name="first_name" value="<?php echo $first_name; ?>" placeholder="<?php echo $entry_first_name; ?>" id="input-username" class="form-control" />
              <?php if ($error_first_name) { ?>
              <div class="text-danger"><?php echo $error_first_name; ?></div>
              <?php } ?>
            </div>
          </div>
          <div class="form-group required">
            <label class="col-sm-2 control-label" for="input-username"><?php echo $entry_last_name; ?></label>
            <div class="col-sm-10">
              <input type="text" name="last_name" value="<?php echo $last_name; ?>" placeholder="<?php echo $entry_last_name; ?>" id="input-username" class="form-control" />
             <?php if ($error_last_name) { ?>
              <div class="text-danger"><?php echo $error_last_name; ?></div>
              <?php } ?>
            </div>
          </div>
          <div class="form-group">
            <label class="col-sm-2 control-label" for="input-user-group"><?php echo $entry_customer; ?></label>
            <div class="col-sm-10">
              <select name="customer_id" id="input-sales_manager" class="form-control">
             	<option value="">Select Customer</option>
                <?php foreach ($customers as $customer) {  ?>
                <?php if ($customer['customer_id'] == $customer_id) { ?>
                <option value="<?php echo $customer['customer_id']; ?>" selected="selected"><?php echo $customer['firstname']; ?></option>
                <?php } else { ?>
                <option value="<?php echo $customer['customer_id']; ?>"><?php echo $customer['firstname']; ?></option>
                <?php } ?>
                <?php } ?>
              </select>
              <?php if ($error_customer_id) { ?>
              <div class="text-danger"><?php echo $error_customer_id; ?></div>
              <?php } ?>
            </div>
          </div>
          
          <div class="form-group required">
            <label class="col-sm-2 control-label" for="input-username"><?php echo $entry_email; ?></label>
            <div class="col-sm-10">
              <input type="text" name="email" value="<?php echo $email; ?>" placeholder="<?php echo $entry_email; ?>" id="input-email" class="form-control" />
              <?php if ($error_email) { ?>
              <div class="text-danger"><?php echo $error_email; ?></div>
              <?php } ?>
            </div>
          </div>
          
          <div class="form-group">
            <label class="col-sm-2 control-label" for="input-username"><?php echo $entry_telephone_number; ?></label>
            <div class="col-sm-10">
              <input type="text" name="telephone_number" value="<?php echo $telephone_number; ?>" maxlength="10" placeholder="<?php echo $entry_telephone_number; ?>" id="input-tel" class="form-control" />
              <?php if ($error_telephone_number) { ?>
              <div class="text-danger"><?php echo $error_telephone_number; ?></div>
              <?php } ?>
            </div>
          </div>
          
          <div class="form-group">
            <label class="col-sm-2 control-label" for="input-username"><?php echo $entry_cellphone_number; ?></label>
            <div class="col-sm-10">
              <input type="text" name="cellphone_number" value="<?php echo $cellphone_number; ?>" maxlength="10" placeholder="<?php echo $entry_cellphone_number; ?>" id="input-cell" class="form-control" />
              <?php if ($error_cellphone_number) { ?>
              <div class="text-danger"><?php echo $error_cellphone_number; ?></div>
              <?php } ?>
            </div>
          </div>
          
          <div class="form-group">
            <label class="col-sm-2 control-label" for="input-username"><?php echo $entry_role; ?></label>
            <div class="col-sm-10">
              <input type="text" name="role" value="<?php echo $role; ?>" placeholder="<?php echo $entry_role; ?>" id="input-cell" class="form-control" />
              <?php if ($error_role) { ?>
              <div class="text-danger"><?php echo $error_role; ?></div>
              <?php } ?>
            </div>
          </div>
          
        </form>
      </div>
    </div>
  </div>
  
</div>
<?php echo $footer; ?> 