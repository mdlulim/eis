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
            <label class="col-sm-2 control-label" for="input-username"><?php echo $entry_name; ?></label>
            <div class="col-sm-10">
              <input type="text" name="note_title" value="<?php echo $note_title; ?>" placeholder="<?php echo $entry_name; ?>" id="input-username" class="form-control" />
              <?php if ($error_note_title) { ?>
              <div class="text-danger"><?php echo $error_note_title; ?></div>
              <?php } ?>
            </div>
          </div>
          <!--<div class="form-group required">
            <label class="col-sm-2 control-label" for="input-user-group"><?php echo $entry_sales; ?></label>
            <div class="col-sm-10">
              <select name="salesrep_id" id="input-sales_manager" class="form-control">
                <option value="">Select Sales Manager</option>
                <?php foreach ($users as $user) { ?>
                <?php if ($user['user_id'] == $sales_manager) { ?>
                <option value="<?php echo $user['user_id']; ?>" selected="selected"><?php echo $user['firstname']; ?> <?php echo $user['lastname']; ?>&nbsp;(<?php echo $user['username']; ?>)</option>
                <?php } else { ?>
                <option value="<?php echo $user['user_id']; ?>"><?php echo $user['firstname']; ?> <?php echo $user['lastname']; ?>&nbsp;(<?php echo $user['username']; ?>)</option>
                <?php } ?>
                <?php } ?>
              </select>
              <?php if ($error_salesrep_id) { ?>
              <div class="text-danger"><?php echo $error_salesrep_id; ?></div>
              <?php } ?>
            </div>
          </div>-->
          
          <div class="form-group required">
            <label class="col-sm-2 control-label" for="input-username"><?php echo $entry_note_description; ?></label>
            <div class="col-sm-10">
              <textarea name="note_description" id="input-description" class="form-control" cols="10" rows="10" placeholder="<?php echo $entry_note_description; ?>"><?php echo $note_description; ?></textarea>
              <?php if ($error_note_description) { ?>
              <div class="text-danger"><?php echo $error_note_description; ?></div>
              <?php } ?>
            </div>
          </div>
          
          
        </form>
      </div>
    </div>
  </div>
</div>
<?php echo $footer; ?> 