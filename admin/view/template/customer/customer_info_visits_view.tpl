<?php echo $header; ?><?php echo $column_left; ?>
<div id="content">
  <div class="page-header">
    <div class="container-fluid">
      <div class="pull-right">
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
        <h3 class="panel-title"><i class="fa fa-eye"></i> <?php echo $text_form; ?></h3>
      </div>
      <div class="panel-body">
        <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" id="form-user" class="form-horizontal">
          <div class="form-group">
            <label class="col-sm-2 control-label" for="input-username">Sales Rep Name</label>
            <div class="col-sm-10">
              <input type="text" value="<?php echo $vsalesrepname; ?>" readonly="readonly" class="form-control" />
              
            </div>
          </div>
          
          <div class="form-group">
            <label class="col-sm-2 control-label" for="input-username">Customer Name</label>
            <div class="col-sm-10">
              <input type="text" value="<?php echo $customername; ?>" readonly="readonly" class="form-control" />
              
            </div>
          </div>
          
          <div class="form-group">
            <label class="col-sm-2 control-label" for="input-username">Appointment Name</label>
            <div class="col-sm-10">
              <input type="text" value="<?php echo $appointmentname; ?>" readonly="readonly" class="form-control" />
              
            </div>
          </div>
          
          <div class="form-group">
            <label class="col-sm-2 control-label" for="input-username">Self Reported Location</label>
            <div class="col-sm-10">
              <input type="text" value="<?php echo $location; ?>" readonly="readonly" class="form-control" />
              
            </div>
          </div>
          
          <div class="form-group">
            <label class="col-sm-2 control-label" for="input-username">Check In Start</label>
            <div class="col-sm-10">
              <input type="text" value="<?php echo $start; ?>" readonly="readonly" class="form-control" />
              
            </div>
          </div>
          
          <div class="form-group">
            <label class="col-sm-2 control-label" for="input-username">Check In End</label>
            <div class="col-sm-10">
              <input type="text" value="<?php echo $end; ?>" readonly="readonly" class="form-control" />
              
            </div>
          </div>
          
          <div class="form-group">
            <label class="col-sm-2 control-label" for="input-username">Check In Time</label>
            <div class="col-sm-10">
              <input type="text" value="<?php echo $checkin; ?>" readonly="readonly" class="form-control" />
              
            </div>
          </div>
          
          <div class="form-group">
            <label class="col-sm-2 control-label" for="input-username">Gps Check In Location</label>
            <div class="col-sm-10">
              <input type="text" value="<?php echo $checkin_location; ?>" readonly="readonly" class="form-control" />
              
            </div>
          </div>
          
          <div class="form-group">
            <label class="col-sm-2 control-label" for="input-username">Check Out Time</label>
            <div class="col-sm-10">
              <input type="text" value="<?php echo $checkout; ?>" readonly="readonly" class="form-control" />
              
            </div>
          </div>
          
          <div class="form-group">
            <label class="col-sm-2 control-label" for="input-username">Remarks</label>
            <div class="col-sm-10">
              <textarea class="form-control" cols="10" rows="10" readonly="readonly" ><?php echo $remarks; ?></textarea>
            </div>
          </div>
          
          
          
          
          
        </form>
      </div>
    </div>
  </div>
        
</div>
<?php echo $footer; ?> 