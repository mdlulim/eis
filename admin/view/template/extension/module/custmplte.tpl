<?php echo $header; ?><?php echo $column_left; ?>
<div id="content">
    <div class="page-header">
    <div class="container-fluid">
          <h1><?php echo $heading_title; ?></h1>
          <ul class="breadcrumb">
            <?php foreach ($breadcrumbs as $breadcrumb) { ?>
            <li><a href="<?php echo $breadcrumb['href']; ?>"><?php echo $breadcrumb['text']; ?></a></li>
            <?php } ?>
          </ul>
    </div> 
  </div>
  <div class="page-header">
    <div class="container-fluid">
      <div class="pull-right">
        <button type="submit" form="form-Message" data-toggle="tooltip" title="<?php echo $button_save; ?>" class="btn btn-primary"><i class="fa fa-save"></i></button>
        </div>
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
        <h3 class="panel-title"><i class="fa fa-pencil"></i> <?php echo $text_edit; ?></h3>
      </div>
      <div class="panel-body">
        <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" id="form-Message" class="form-horizontal">
        <ul class="nav nav-tabs" id="language">
                <?php foreach ($languages as $language) { ?>
                <li><a href="#language<?php echo $language['language_id']; ?>" data-toggle="tab"> <?php echo $language['name']; ?></a></li>
                <?php } ?>
              </ul>
        <div class="tab-content">
          <?php foreach ($languages as $language) { ?>
          <!-- Input -->
          <div class="tab-pane" id="language<?php echo $language['language_id']; ?>">
             <!-- textarea -->
              <div class="form-group">
                <label for="custmplte_thankyoutemplate[<?php echo $language['language_id']; ?>]" class="col-sm-2 control-label message"><?php echo $thankyou_custmplte; ?></label>
                <div class="col-sm-10">
                 <textarea id="custmplte_thankyoutemplate<?php echo $language['language_id']; ?>" name="<?php echo $user_id; ?>_custmplte_thankyoutemplate[<?php echo $language['language_id']; ?>][message]" class="form-control summernote" ><?php echo isset($custmplte_thankyoutemplate[$language['language_id']]) ? $custmplte_thankyoutemplate[$language['language_id']]['message'] : ''; ?></textarea>
                 <span class="help">Do not use semicolon </span>
                </div>
              </div>
              <div class="form-group">
                <label for="custmplte_salestemplate[<?php echo $language['language_id']; ?>]" class="col-sm-2 control-label message"><?php echo $sales_custmplte; ?></label>
                <div class="col-sm-10">
                 <textarea id="custmplte_salestemplate<?php echo $language['language_id']; ?>" name="<?php echo $user_id; ?>_custmplte_salestemplate[<?php echo $language['language_id']; ?>][message]" class="form-control summernote" ><?php echo isset($custmplte_salestemplate[$language['language_id']]) ? $custmplte_salestemplate[$language['language_id']]['message'] : ''; ?></textarea>
                 <span class="help">Do not use semicolon </span>
                </div>
              </div>
        </div>
        <?php } ?>
        </div>
        </form>
      </div>
    </div>
  </div>
  <script type="text/javascript" src="view/javascript/summernote/summernote.js"></script>
  <link href="view/javascript/summernote/summernote.css" rel="stylesheet" />
  <script type="text/javascript" src="view/javascript/summernote/opencart.js"></script>
<script type="text/javascript">
$('#language a:first').tab('show');
</script>
</div>
<?php echo $footer; ?>