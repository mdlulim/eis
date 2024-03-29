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
        <h3 class="panel-title"><i class="fa fa-info-circle" style="font-size:23px;"></i> User Info : <strong><?php echo $username; ?></strong></h3>
      </div>
      <div class="panel-body">
        <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" id="form-user" class="form-horizontal">
          <div class="form-group">
            <label class="col-sm-2 control-label" for="input-username"><?php echo $entry_username; ?></label>
            <div class="col-sm-10">
              <input type="text" name="username" value="<?php echo $username; ?>" placeholder="<?php echo $entry_username; ?>" id="input-username" class="form-control" disabled="disabled" />
            </div>
          </div>
          <div class="form-group">
            <label class="col-sm-2 control-label" for="input-user-group"><?php echo $entry_user_group; ?></label>
            <div class="col-sm-10">
              <select name="user_group_id" id="input-user-group" class="form-control" disabled="disabled">
                <?php foreach ($user_groups as $user_group) { ?>
                
                    <?php if($current_user_group['name'] == 'System Administrator') {  ?>
                       <?php if($user_group['name'] != 'Administrator' && $user_group['name'] != 'Company admin') { ?>
                            <?php if ($user_group['user_group_id'] == $user_group_id) { ?>
                            	<option value="<?php echo $user_group['user_group_id']; ?>" selected="selected"><?php echo $user_group['name']; ?></option>
                            <?php } else if ($user_group['name'] == $dashboard){  ?>
                        		<option value="<?php echo $user_group['user_group_id']; ?>" selected="selected"><?php echo $user_group['name']; ?></option>
                        	<?php } else { ?>
                           		<option value="<?php echo $user_group['user_group_id']; ?>"><?php echo $user_group['name']; ?></option>
                            <?php } ?>
                        <?php } ?>
                    <?php } else {  ?>
                    	<?php if ($user_group['user_group_id'] == $user_group_id) { ?>
                       		<option value="<?php echo $user_group['user_group_id']; ?>" selected="selected"><?php echo $user_group['name']; ?></option>
                        <?php } else if ($user_group['name'] == $dashboard){  ?>
                        	<option value="<?php echo $user_group['user_group_id']; ?>" selected="selected"><?php echo $user_group['name']; ?></option>
                        <?php } else { ?>
                        	<option value="<?php echo $user_group['user_group_id']; ?>"><?php echo $user_group['name']; ?></option>
                        <?php } ?>
                    <?php } ?>
                <?php } ?>
              </select>
            </div>
          </div>
          <div class="form-group">
            <label class="col-sm-2 control-label" for="input-firstname"><?php echo $entry_firstname; ?></label>
            <div class="col-sm-10">
              <input type="text" name="firstname" value="<?php echo $firstname; ?>" placeholder="<?php echo $entry_firstname; ?>" id="input-firstname" class="form-control" disabled="disabled" />
            </div>
          </div>
          <div class="form-group">
            <label class="col-sm-2 control-label" for="input-lastname"><?php echo $entry_lastname; ?></label>
            <div class="col-sm-10">
              <input type="text" name="lastname" value="<?php echo $lastname; ?>" placeholder="<?php echo $entry_lastname; ?>" id="input-lastname" class="form-control" disabled="disabled" />
            </div>
          </div>
          <div class="form-group">
            <label class="col-sm-2 control-label" for="input-email"><?php echo $entry_email; ?></label>
            <div class="col-sm-10">
              <input type="text" name="email" value="<?php echo $email; ?>" placeholder="<?php echo $entry_email; ?>" id="input-email" class="form-control" disabled="disabled" />
            </div>
          </div>
          <div class="form-group">
            <label class="col-sm-2 control-label" for="input-status"><?php echo $entry_status; ?></label>
            <div class="col-sm-10">
              <select name="status" id="input-status" class="form-control" disabled="disabled">
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
          <?php if ($show_resend_password) { ?>
          <div class="form-group">
            <div class="col-sm-10 col-sm-push-2">
              <a href="javascript:void()" class="btn btn-default" id="resend-password" data-username='<?=$firstname?>' data-userid='<?=$user_id?>' data-token='<?=$token?>'>
                <i class="fa fa-send"></i>
                Resend Password
              </a>
            </div>
          </div>
          <?php } ?>
        </form>
      </div>
    </div>
  </div>
</div>

<!-- Page loader -->
<div class="loader-wrapper" style="display:none">
  <div class="loader"></div>
</div>
<!-- /Page loader -->
<?php echo $footer; ?> 