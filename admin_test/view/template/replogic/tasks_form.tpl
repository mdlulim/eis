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
          <input type="hidden" name="appointment_id" value="<?php echo $appointment_id; ?>"  />
          <div class="form-group required">
            <label class="col-sm-2 control-label" for="input-username"><?php echo $entry_task_name; ?></label>
            <div class="col-sm-10">
              <input type="text" name="task_name" value="<?php echo $task_name; ?>" placeholder="<?php echo $entry_task_name; ?>" id="input-username" class="form-control" />
              <?php if ($error_task_name) { ?>
              <div class="text-danger"><?php echo $error_task_name; ?></div>
              <?php } ?>
            </div>
          </div>
          <div class="form-group required">
            <label class="col-sm-2 control-label" for="input-username"><?php echo $entry_salesrep; ?></label>
            <div class="col-sm-10">
              <select name="salesrep_id" id="input-sales_manager" class="form-control">
                <option value="">Select Sales Rep</option>
                <?php foreach ($salesReps as $salesRep) { ?>
                <?php if ($salesRep['salesrep_id'] == $salesrep_id) { ?>
                <option value="<?php echo $salesRep['salesrep_id']; ?>" selected="selected"><?php echo $salesRep['salesrep_name']; ?> <?php echo $salesRep['salesrep_lastname']; ?></option>
                <?php } else { ?>
                <option value="<?php echo $salesRep['salesrep_id']; ?>"><?php echo $salesRep['salesrep_name']; ?> <?php echo $salesRep['salesrep_lastname']; ?></option>
                <?php } ?>
                <?php } ?>
              </select>
              <?php if ($error_salesrep_id) { ?>
              <div class="text-danger"><?php echo $error_salesrep_id; ?></div>
              <?php } ?>
            </div>
          </div>
          <div class="form-group required">
            <label class="col-sm-2 control-label" for="input-username"><?php echo $entry_task_description; ?></label>
            <div class="col-sm-10">
              <textarea name="task_description" id="input-description" class="form-control" cols="10" rows="10" placeholder="<?php echo $entry_task_description; ?>"><?php echo $task_description; ?></textarea>
              <?php if ($error_task_description) { ?>
              <div class="text-danger"><?php echo $error_task_description; ?></div>
              <?php } ?>
            </div>
          </div>
          <div class="form-group">
                <label class="col-sm-2 control-label" for="input-status"><?php echo $entry_status; ?></label>
                <div class="col-sm-10">
                  <select name="status" id="input-status" class="form-control">
                    <?php if ($status) { ?>
                    <option value="0"><?php echo $text_disabled; ?></option>
                    <option value="1" selected="selected"><?php echo $text_enabled; ?></option>
                    <?php } else { ?>
                    <option value="0" selected="selected"><?php echo $text_disabled; ?></option>
                    <option value="1"><?php echo $text_enabled; ?></option>
                    <?php } ?>
                  </select>
                </div>
              </div>
          
          
        </form>
      </div>
    </div>
  </div>
</div>
<?php echo $footer; ?> 