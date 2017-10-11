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
                <label class="control-label" for="input-name">Sales Rep Name</label>
                <input type="text" name="filter_sales_rep_name" value="<?php echo $filter_sales_rep_name; ?>" placeholder="Sales Rep Name" id="input-name" class="form-control" />
              </div>
              
              <div class="form-group">
                <label class="control-label" for="input-name">Email</label>
                <input type="text" name="filter_email" value="<?php echo $filter_email; ?>" placeholder="Email" id="input-name" class="form-control" />
              </div>
              
            </div>
            <div class="col-sm-6" style="margin-bottom:10px;">
              <div class="form-group">
                <label class="control-label" for="input-price">Sales Team</label>
                <select name="filter_team_id" class="form-control">
                	<option value="">Select Sales Team</option>
                    <?php foreach ($teams as $team) {  ?>
                <?php if ($team['team_id'] == $filter_team_id) { ?>
                <option value="<?php echo $team['team_id']; ?>" selected="selected"><?php echo $team['team_name']; ?></option>
                <?php } else { ?>
                <option value="<?php echo $team['team_id']; ?>"><?php echo $team['team_name']; ?></option>
                <?php } ?>
                <?php } ?>
                    
                </select>
              </div>
              
            </div>
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
                  <td class="text-left"><?php if ($sort == 'name') { ?>
                    <a href="<?php echo $sort_name; ?>" class="<?php echo strtolower($order); ?>"><?php echo $column_name; ?></a>
                    <?php } else { ?>
                    <a href="<?php echo $sort_name; ?>"><?php echo $column_name; ?></a>
                    <?php } ?></td>
                  <td class="text-left">Sales Team</td>
                  <td class="text-left">Email</td>
                  
                  <td class="text-right"><?php echo $column_action; ?></td>
                </tr>
              </thead>
              <tbody>
                <?php if ($sales_rep_managements) { ?>
                    <?php foreach ($sales_rep_managements as $sales_rep_management) { ?>
                        
                            <tr>
                              <td class="text-center"><?php if (in_array($sales_rep_management['salesrep_id'], $selected)) { ?>
                                <input type="checkbox" name="selected[]" value="<?php echo $sales_rep_management['salesrep_id']; ?>" checked="checked" />
                                <?php } else { ?>
                                <input type="checkbox" name="selected[]" value="<?php echo $sales_rep_management['salesrep_id']; ?>" />
                                <?php } ?></td>
                              <td class="text-left"><?php echo $sales_rep_management['name']; ?></td>
                              <td class="text-left"><?php echo $sales_rep_management['team']; ?></td>
                              <td class="text-left"><?php echo $sales_rep_management['email']; ?></td>
                              <td class="text-right"><a href="<?php echo $sales_rep_management['edit']; ?>" data-toggle="tooltip" title="<?php echo $button_edit; ?>" class="btn btn-primary"><i class="fa fa-pencil"></i></a></td>
                            </tr>
                     <?php } ?>
                <?php } else { ?>
                	<tr>
                        <td class="text-center" colspan="5"><?php echo $text_no_results; ?></td>
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
	var url = 'index.php?route=replogic/sales_rep_management&token=<?php echo $token; ?>';

	var filter_sales_rep_name = $('input[name=\'filter_sales_rep_name\']').val();
	
	var filter_sales_rep_name = $.trim(filter_sales_rep_name);
	if (filter_sales_rep_name) {
		url += '&filter_sales_rep_name=' + encodeURIComponent(filter_sales_rep_name);
	}

	var filter_team_id = $('select[name=\'filter_team_id\']').val();

	if (filter_team_id) {
		url += '&filter_team_id=' + encodeURIComponent(filter_team_id);
	}

	var filter_email = $('input[name=\'filter_email\']').val();
	var filter_email = $.trim(filter_email);
	if (filter_email) {
		url += '&filter_email=' + encodeURIComponent(filter_email);
	}
	
//alert(url);
	location = url;
});
$('#button-filter-reset').on('click', function() {
	var url = 'index.php?route=replogic/sales_rep_management&token=<?php echo $token; ?>';

	location = url;
});
//--></script>
<?php echo $footer; ?> 