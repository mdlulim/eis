<?php echo $header; ?><?php echo $column_left; ?>
<div id="content">
  <div class="page-header">
    <div class="container-fluid">
      <div class="pull-right"><a href="<?php echo $add; ?>" data-toggle="tooltip" title="<?php echo $button_add; ?>" class="btn btn-primary"><i class="fa fa-plus"></i></a>
        <button type="button" data-toggle="tooltip" title="<?php echo $button_delete; ?>" class="btn btn-danger" onclick="confirm('<?php echo $text_confirm; ?>') ? $('#form-user').submit() : false;"><i class="fa fa-trash-o"></i></button>
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
          <div class="row">
            <div class="col-sm-6">
              <div class="form-group">
                <label class="control-label" for="input-name">Team Name</label>
                <input type="text" name="filter_team_name" value="<?php echo $filter_team_name; ?>" placeholder="Team Name" id="input-name" class="form-control" />
              </div>
              
            </div>
            <?php if($loginuser != 'Sales Manager') { ?>
            <div class="col-sm-6" style="margin-bottom:10px;">
              <div class="form-group">
                <label class="control-label" for="input-price">Sales Manager</label>
                <select name="filter_salesrep_id" class="form-control">
                	<option value="">Select Sales Manager</option>
                    <?php foreach($sales_managers as $sales_manager) { ?>
                    	<?php if ($sales_manager['user_id'] == $filter_salesrep_id) { ?>
                <option value="<?php echo $sales_manager['user_id']; ?>" selected="selected"><?php echo $sales_manager['firstname']; ?> <?php echo $sales_manager['lastname']; ?></option>
                <?php } else { ?>
                <option value="<?php echo $sales_manager['user_id']; ?>"><?php echo $sales_manager['firstname']; ?> <?php echo $sales_manager['lastname']; ?></option>
                <?php } ?>
                    <?php } ?>
                    
                </select>
              </div>
              
            </div>
            <?php } ?>
            <button type="button" id="button-filter" class="btn btn-primary pull-right"><i class="fa fa-filter"></i> Filter</button>
            <button type="button" id="button-filter-reset" class="btn btn-primary pull-right" style="margin-right:10px;"><i class="fa fa-filter"></i> Reset</button>
          </div>
           
        </div>
        
        <form action="<?php echo $delete; ?>" method="post" enctype="multipart/form-data" id="form-user">
          <div class="table-responsive">
            <table class="table table-bordered table-hover">
              <thead>
                <tr>
                  <td style="width: 1px;" class="text-center"><input type="checkbox" onclick="$('input[name*=\'selected\']').prop('checked', this.checked);" /></td>
                  <td class="text-left"><?php if ($sort == 'team_name') { ?>
                    <a href="<?php echo $sort_team_name; ?>" class="<?php echo strtolower($order); ?>"><?php echo $column_team_name; ?></a>
                    <?php } else { ?>
                    <a href="<?php echo $sort_team_name; ?>"><?php echo $column_team_name; ?></a>
                    <?php } ?></td>
                  <?php if($loginuser != 'Sales Manager') { ?>
                  <td class="text-left">Sales Manager</td>
                  <?php } ?>
                  <td class="text-right"><?php echo $column_action; ?></td>
                </tr>
              </thead>
              <tbody>
                <?php if($access == 'yes') { ?>
                <?php if ($teams) { ?>
                    <?php foreach ($teams as $team) { ?>
                        
                            <tr>
                              <td class="text-center"><?php if (in_array($team['team_id'], $selected)) { ?>
                                <input type="checkbox" name="selected[]" value="<?php echo $team['team_id']; ?>" checked="checked" />
                                <?php } else { ?>
                                <input type="checkbox" name="selected[]" value="<?php echo $team['team_id']; ?>" />
                                <?php } ?></td>
                              <td class="text-left"><?php echo $team['team_name']; ?></td>
                             <?php if($loginuser != 'Sales Manager') { ?>
                              <td class="text-left"><?php echo $team['sales_manager']; ?></td>
                             <?php } ?> 
                              <td class="text-right"><a href="<?php echo $team['salesrep']; ?>" data-toggle="tooltip" title="Sales Rep Management" class="btn btn-primary"><i class="fa fa-street-view"></i></a>&nbsp;<a href="<?php echo $team['edit']; ?>" data-toggle="tooltip" title="<?php echo $button_edit; ?>" class="btn btn-primary"><i class="fa fa-pencil"></i></a></td>
                            </tr>
                     <?php } ?>
                    <?php } else { ?>
                    <tr>
                      <td class="text-center" colspan="5"><?php echo $text_no_results; ?></td>
                    </tr>
                    <?php } ?>
                <?php } else { ?>
                	<tr>
                        <td class="text-center" colspan="5">You Don't have Permission to access the Manage Group.</td>
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
</div>
<script type="text/javascript"><!--
$('#button-filter').on('click', function() {
	var url = 'index.php?route=user/team&token=<?php echo $token; ?>';

	var filter_team_name = $('input[name=\'filter_team_name\']').val();

	if (filter_team_name) {
		url += '&filter_team_name=' + encodeURIComponent(filter_team_name);
	}
<?php if($loginuser != 'Sales Manager') { ?>
	var filter_salesrep_id = $('select[name=\'filter_salesrep_id\']').val();

	if (filter_salesrep_id) {
		url += '&filter_salesrep_id=' + encodeURIComponent(filter_salesrep_id);
	}
<?php } ?>
//alert(url);
	location = url;
});
$('#button-filter-reset').on('click', function() {
	var url = 'index.php?route=user/team&token=<?php echo $token; ?>';

	location = url;
});
//--></script>
<?php echo $footer; ?> 