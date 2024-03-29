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
            <label class="col-sm-2 control-label" for="input-username"><?php echo $entry_name; ?></label>
            <div class="col-sm-10">
              <input type="text" name="salesrep_name" value="<?php echo $salesrep_name; ?>" placeholder="<?php echo $entry_name; ?>" id="input-username" class="form-control" />
              <?php if ($error_salesrep_name) { ?>
              <div class="text-danger"><?php echo $error_salesrep_name; ?></div>
              <?php } ?>
            </div>
          </div>
          <div class="form-group required">
            <label class="col-sm-2 control-label" for="input-username"><?php echo $entry_lastname; ?></label>
            <div class="col-sm-10">
              <input type="text" name="salesrep_lastname" value="<?php echo $salesrep_lastname; ?>" placeholder="<?php echo $entry_lastname; ?>" id="input-username" class="form-control" />
             <?php if ($error_salesrep_lastname) { ?>
              <div class="text-danger"><?php echo $error_salesrep_lastname; ?></div>
              <?php } ?>
            </div>
          </div>
          
          <div class="form-group required">
            <label class="col-sm-2 control-label" for="input-user-group"><?php echo $entry_sales_team; ?></label>
            <div class="col-sm-10">
              <?php if($team_id == '') { ?>
              <select name="sales_team_id" id="input-sales_manager" class="form-control">
             	<option value="">Select Team</option>
                <?php foreach ($teams as $team) {  ?>
                <?php if ($team['team_id'] == $sales_team_id) { ?>
                <option value="<?php echo $team['team_id']; ?>" selected="selected"><?php echo $team['team_name']; ?></option>
                <?php } else { ?>
                <option value="<?php echo $team['team_id']; ?>"><?php echo $team['team_name']; ?></option>
                <?php } ?>
                <?php } ?>
              </select>
              <?php if ($error_sales_team_id) { ?>
              <div class="text-danger"><?php echo $error_sales_team_id; ?></div>
              <?php } ?>
              
              <?php } else { ?>
              
              <?php 
              	
                if($form_action == 'add')
                {
                	$dis = 'disabled="disabled"';
                }
                else
                {
                	$dis = '';
                }
                
              ?>
              <input type="hidden" name="sales_team_id" value="<?php echo $team_id;?>"  />
          	 <select name="sales_team_id" id="input-sales_manager" class="form-control" <?php echo $dis; ?> >
             	<option value="">Select Team</option>
                <?php foreach ($teams as $team) {  ?>
                <?php if ($team['team_id'] == $team_id) { ?>
                <option value="<?php echo $team['team_id']; ?>" selected="selected"><?php echo $team['team_name']; ?></option>
                <?php } else { ?>
                <option value="<?php echo $team['team_id']; ?>"><?php echo $team['team_name']; ?></option>
                <?php } ?>
                <?php } ?>
              </select>
          <?php } ?>
              
            </div>
          </div>
          
          <div class="form-group required">
            <label class="col-sm-2 control-label" for="input-username"><?php echo $entry_email; ?></label>
            <div class="col-sm-10">
              <?php if(isset($_REQUEST['salesrep_id'])) { ?>
              	<input type="text" name="email" value="<?php echo $email; ?>" readonly="readonly" placeholder="<?php echo $entry_email; ?>" id="input-email" class="form-control" />
              <?php } else { ?>
              	<input type="text" name="email" value="<?php echo $email; ?>" placeholder="<?php echo $entry_email; ?>" id="input-email" class="form-control" />
              <?php } ?>
              <?php if ($error_email) { ?>
              <div class="text-danger"><?php echo $error_email; ?></div>
              <?php } ?>
            </div>
          </div>
          
          <div class="form-group required">
            <label class="col-sm-2 control-label" for="input-username"><?php echo $entry_tel; ?></label>
            <div class="col-sm-10">
              <input type="text" name="tel" value="<?php echo $tel; ?>" maxlength="10" placeholder="<?php echo $entry_tel; ?>" id="input-tel" class="form-control" />
              <?php if ($error_tel) { ?>
              <div class="text-danger"><?php echo $error_tel; ?></div>
              <?php } ?>
            </div>
          </div>
          
          <div class="form-group required">
            <label class="col-sm-2 control-label" for="input-username"><?php echo $entry_cell; ?></label>
            <div class="col-sm-10">
              <input type="text" name="cell" value="<?php echo $cell; ?>" maxlength="10" placeholder="<?php echo $entry_cell; ?>" id="input-cell" class="form-control" />
              <?php if ($error_cell) { ?>
              <div class="text-danger"><?php echo $error_cell; ?></div>
              <?php } ?>
            </div>
          </div>
          
          <!--<div class="form-group required">
            <label class="col-sm-2 control-label" for="input-username"><?php echo $entry_password; ?></label>
            <div class="col-sm-10">
              <input type="password" name="password" value="<?php echo $password; ?>" placeholder="<?php echo $entry_password; ?>" id="input-password" class="form-control" />
              <?php if ($error_password) { ?>
              <div class="text-danger"><?php echo $error_password; ?></div>
              <?php } ?>
            </div>
          </div>-->
          
        </form>
      </div>
    </div>
  </div>
  
</div>
<?php echo $footer; ?> 