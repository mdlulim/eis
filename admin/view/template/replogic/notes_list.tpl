<?php echo $header; ?><?php echo $column_left; ?>
<div id="content">
  <div class="page-header">
    <div class="container-fluid">
      <div class="pull-right"><a href="<?php echo $add; ?>" data-toggle="tooltip" title="<?php echo $button_add; ?>" class="btn btn-primary"><i class="fa fa-plus"></i></a>
        <button type="button" data-toggle="tooltip" title="<?php echo $button_delete; ?>" class="btn btn-danger" onclick="confirm('<?php echo $text_confirm; ?>') ? $('#form-user').submit() : false;"><i class="fa fa-trash-o"></i></button>
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
                <label class="control-label" for="input-name">Note Title</label>
                <input type="text" name="filter_note_title" value="<?php echo $filter_note_title; ?>" placeholder="Note Title" id="input-name" class="form-control" />
              </div>
              
            </div>
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
                  <td class="text-left"><?php if ($sort == 'note_title') { ?>
                    <a href="<?php echo $sort_note_title; ?>" class="<?php echo strtolower($order); ?>"><?php echo $column_note_title; ?></a>
                    <?php } else { ?>
                    <a href="<?php echo $sort_note_title; ?>"><?php echo $column_note_title; ?></a>
                    <?php } ?></td>
                  <td class="text-left">Sales Manager</td>
                  
                  <td class="text-right"><?php echo $column_action; ?></td>
                </tr>
              </thead>
              <tbody>
                <?php if($access == 'yes') { ?>
                <?php if ($notes) { ?>
                    <?php foreach ($notes as $note) {  ?>
                        
                            <tr>
                              <td class="text-center"><?php if (in_array($note['note_id'], $selected)) { ?>
                                <input type="checkbox" name="selected[]" value="<?php echo $note['note_id']; ?>" checked="checked" />
                                <?php } else { ?>
                                <input type="checkbox" name="selected[]" value="<?php echo $note['note_id']; ?>" />
                                <?php } ?></td>
                              <td class="text-left"><?php echo $note['note_title']; ?></td>
                              <td class="text-left"><?php echo $note['sales_manager']; ?></td>
                              <td class="text-right"><a href="<?php echo $note['edit']; ?>" data-toggle="tooltip" title="<?php echo $button_edit; ?>" class="btn btn-primary"><i class="fa fa-pencil"></i></a></td>
                            </tr>
                     <?php } ?>
                    <?php } else { ?>
                    <tr>
                      <td class="text-center" colspan="5">No any Appointment Notes Available</td>
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
	var url = 'index.php?route=replogic/notes&token=<?php echo $token; ?>&appointment_id=<?php echo $appointment_id; ?>';

	var filter_note_title = $('input[name=\'filter_note_title\']').val();

	if (filter_note_title) {
		url += '&filter_note_title=' + encodeURIComponent(filter_note_title);
	}

	var filter_salesrep_id = $('select[name=\'filter_salesrep_id\']').val();

	if (filter_salesrep_id) {
		url += '&filter_salesrep_id=' + encodeURIComponent(filter_salesrep_id);
	}

//alert(url);
	location = url;
});
$('#button-filter-reset').on('click', function() {
	var url = 'index.php?route=replogic/notes&token=<?php echo $token; ?>&appointment_id=<?php echo $appointment_id; ?>';

	location = url;
});
//--></script>
<?php echo $footer; ?> 