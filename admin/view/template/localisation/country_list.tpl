<?php echo $header; ?><?php echo $column_left; ?>
<div id="content">
  <div class="page-header">
    <div class="container-fluid">
      <div class="pull-right"><a href="<?php echo $add; ?>" data-toggle="tooltip" title="<?php echo $button_add; ?>" class="btn btn-primary"><i class="fa fa-plus"></i></a>
        <button type="button" data-toggle="tooltip" title="<?php echo $button_delete; ?>" class="btn btn-danger" onclick="confirm('<?php echo $text_confirm; ?>') ? $('#form-country').submit() : false;"><i class="fa fa-trash-o"></i></button>
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
          <h3>Filters</h3>
          <div class="row">
            <div class="col-sm-6">
              <div class="form-group">
                <label class="control-label" for="input-name">Country Name</label>
                <select name="filter_name" id="input-name" class="form-control">
                  <option value="*">Select User Name</option>
                  <?php foreach($Dropdownnames as $Dname) { ?>
                    <?php if($Dname['name'] == $filter_name ) { ?>
                      <option value="<?php echo $Dname['name']; ?>" selected="selected"><?php echo $Dname['name']; ?></option>
                      <?php } else { ?>
                      <option value="<?php echo $Dname['name']; ?>"><?php echo $Dname['name']; ?></option>
                      <?php } ?>
                  <?php } ?>
                </select>
              </div>
              
            </div>
            <div class="col-sm-6">
              <div class="form-group">
                <label class="control-label" for="input-name">Country Code</label>
                <input name="filter_code" type='text' value="<?php echo $filter_code; ?>"  placeholder="Country Code" class="form-control" class="form-control"  />
              </div>
              <div class="form-group">
                <button type="button" id="button-filter" class="btn btn-primary pull-right"><i class="fa fa-search"></i> Search</button>
                <button type="button" id="button-filter-reset" class="btn btn-primary pull-right" style="margin-right:10px;"><i class="fa fa-refresh"></i> Reset</button>  
              </div>
            </div>
            
          </div>
           
        </div>
        
        <form action="<?php echo $delete; ?>" method="post" enctype="multipart/form-data" id="form-country">
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
                  <td class="text-left"><?php if ($sort == 'iso_code_2') { ?>
                    <a href="<?php echo $sort_iso_code_2; ?>" class="<?php echo strtolower($order); ?>"><?php echo $column_iso_code_2; ?></a>
                    <?php } else { ?>
                    <a href="<?php echo $sort_iso_code_2; ?>"><?php echo $column_iso_code_2; ?></a>
                    <?php } ?></td>
                  <td class="text-left"><?php if ($sort == 'iso_code_3') { ?>
                    <a href="<?php echo $sort_iso_code_3; ?>" class="<?php echo strtolower($order); ?>"><?php echo $column_iso_code_3; ?></a>
                    <?php } else { ?>
                    <a href="<?php echo $sort_iso_code_3; ?>"><?php echo $column_iso_code_3; ?></a>
                    <?php } ?></td>
                  <td class="text-right"><?php echo $column_action; ?></td>
                </tr>
              </thead>
              <tbody>
                <?php if ($countries) { ?>
                <?php foreach ($countries as $country) { ?>
                <tr>
                  <td class="text-center"><?php if (in_array($country['country_id'], $selected)) { ?>
                    <input type="checkbox" name="selected[]" value="<?php echo $country['country_id']; ?>" checked="checked" />
                    <?php } else { ?>
                    <input type="checkbox" name="selected[]" value="<?php echo $country['country_id']; ?>" />
                    <?php } ?></td>
                  <td class="text-left"><?php echo $country['name']; ?></td>
                  <td class="text-left"><?php echo $country['iso_code_2']; ?></td>
                  <td class="text-left"><?php echo $country['iso_code_3']; ?></td>
                  <td class="text-right"><!--<a href="<?php echo $country['edit']; ?>" data-toggle="tooltip" title="<?php echo $button_edit; ?>" class="btn btn-primary"><i class="fa fa-pencil"></i></a>--><a href="<?php echo $country['view']; ?>" data-toggle="tooltip" title="View Country" class="btn btn-info"><i class="fa fa-eye"></i></a></td>
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
<style>
  .form-group + .form-group{border-top:none;}
</style>
<script type="text/javascript"><!--
$('#button-filter').on('click', function() {
  var url = 'index.php?route=localisation/country&token=<?php echo $token; ?>';
  var filter_name = $('select[name=\'filter_name\']').val();
  if (filter_name != '*') {
    url += '&filter_name=' + encodeURIComponent(filter_name);
  }
  
  var filter_code = $('input[name=\'filter_code\']').val();
  if (filter_code) {
    url += '&filter_code=' + encodeURIComponent(filter_code);
  }
  
  location = url;
});
$('#button-filter-reset').on('click', function() {
  
  var url = 'index.php?route=localisation/country&token=<?php echo $token; ?>';
  location = url;
});
//--></script>
<?php echo $footer; ?>