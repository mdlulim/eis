<?php echo $header; ?><?php echo $column_left; ?>
<div id="content">
  <div class="page-header">
    <div class="container-fluid">
      <div class="pull-right">
      	<button type="button" class="btn btn-info" data-toggle="modal" data-target="#myModal"  id="popup" title="Assign Sales Rep to Team"><i class="fa fa-user-plus" style="font-size:14px;"></i></button>
        <button type="button" class="btn btn-info" data-toggle="modal" data-target="#Modalunassign"  id="popupunassign" title="Sales Rep to Unassign Team"><i class="fa fa-user-times" style="font-size:14px;"></i></button>
        <a href="<?php echo $add; ?>" data-toggle="tooltip" title="<?php echo $button_add; ?>" class="btn btn-primary"><i class="fa fa-plus"></i></a>
        <button type="button" data-toggle="tooltip" title="<?php echo $button_delete; ?>" id="button-delete" class="btn btn-danger" onclick="confirm('<?php echo $text_confirm; ?>') ? $('#form-user').submit() : false;"><i class="fa fa-trash-o"></i></button>
        <?php if(isset($team_id)) {?>
        <a href="<?php echo $cancel; ?>" data-toggle="tooltip" title="<?php echo $button_cancel; ?>" class="btn btn-default"><i class="fa fa-reply"></i></a>
        <?php } ?>
        <span data-toggle="tooltip" title="" data-original-title="Minimum amount a customer can purchase a voucher for.">Voucher Min</span>
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
              <?php if(!isset($team_id)) { ?>
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
              <?php } else { ?>
              <input type="hidden" name="team_id" value="<?php echo $team_id; ?>"/>
              <?php } ?>
            </div>
            <div class="col-sm-6" style="margin-bottom:10px;">
              
              
              <div class="form-group">
                <label class="control-label" for="input-name">Email</label>
                <input type="text" name="filter_email" value="<?php echo $filter_email; ?>" placeholder="Email" id="input-name" class="form-control" />
              </div>
            </div>
            <button type="button" id="button-filter" class="btn btn-primary pull-right"><i class="fa fa-filter"></i> Filter</button>
            <button type="button" id="button-filter-reset" class="btn btn-primary pull-right" style="margin-right:10px;"><i class="fa fa-filter"></i> Reset</button>
          </div>
           
        </div>
        <script type="text/javascript">
		$(document).ready(function () {
    $("#popup").click(function () {
        $('#bookId').val($(this).data('id'));
        var array = $.map($('input[name="selected[]"]:checked'), function(c){return c.value; })
		$('#sales_rep_ids').val(array);
		
    });
	
	document.getElementById('assign').onclick = function() {
        document.getElementById('form-popup').submit();
        return false;
    };
	


$("#popupunassign").click(function () {
        $('#bookId').val($(this).data('id'));
        var array = $.map($('input[name="selected[]"]:checked'), function(c){return c.value; })
		$('#unsales_rep_ids').val(array);
		
    });
	
	document.getElementById('unassign').onclick = function() {
        document.getElementById('form-unassign').submit();
        return false;
    };
	
});
		</script>
        <div id="myModal" class="modal fade" role="dialog">
          <form action="<?php echo $assign; ?>" method="post" enctype="multipart/form-data" id="form-popup">
          <input type="hidden" name="sales_rep_ids" id="sales_rep_ids" value=""  />
          <div class="modal-dialog">
        
            <!-- Modal content-->
            <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Assign Sales Rep to Team</h4>
              </div>
              <div class="modal-body">
                <p><strong>Select Team</strong> </p>
                <select name="team_id" class="form-control">
                	<option value="">Select Sales Team</option>
                	<?php foreach ($teams as $team) {  ?>
                    	<option value="<?php echo $team['team_id']; ?>"><?php echo $team['team_name']; ?></option>
                	<?php } ?>
                </select>
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-primary" id="assign">Assign</button>
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
              </div>
            </div>
        
          </div>
          </form>
        </div>
        <div id="Modalunassign" class="modal fade" role="dialog">
          <form action="<?php echo $unassign; ?>" method="post" enctype="multipart/form-data" id="form-unassign">
          <input type="hidden" name="sales_rep_ids" id="unsales_rep_ids" value=""  />
          <div class="modal-dialog">
        
            <!-- Modal content-->
            <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Sales Rep to Unassign Team</h4>
              </div>
              <div class="modal-body">
                <p><strong>Are you Sure want to Unassign Sales rep from the team</strong> </p>
                
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-primary" id="unassign">Unassign</button>
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
              </div>
            </div>
        
          </div>
          </form>
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

	var team_id = $('select[name=\'filter_team_id\']').val();

	if (team_id) {
		url += '&filter_team_id=' + encodeURIComponent(team_id);
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
	<?php if($_REQUEST['team_id']) { ?>
	var team_id = $('input[name=\'team_id\']').val();
	var url = 'index.php?route=replogic/sales_rep_management&token=<?php echo $token; ?>&team_id=' + team_id + '';
	<?php } else { ?>
	var url = 'index.php?route=replogic/sales_rep_management&token=<?php echo $token; ?>';
	<?php } ?>

	location = url;
});
//--></script>
<script type="text/javascript"><!--
$('input[name^=\'selected\']').on('change', function() {
	
	var selected = $('input[name^=\'selected\']:checked');

	if (selected.length) {
		$('#button-delete').prop('disabled', false);
		$('#popup').prop('disabled', false);
		$('#popupunassign').prop('disabled', false);
	}

});

$('#button-delete').prop('disabled', true);
$('#popup').prop('disabled', true);
$('#popupunassign').prop('disabled', true);

$('input[name^=\'selected\']:first').trigger('change');

//--></script> 
<?php echo $footer; ?> 