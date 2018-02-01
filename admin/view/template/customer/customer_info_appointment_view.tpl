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
            <label class="col-sm-2 control-label" for="input-username"><?php echo $entry_name; ?></label>
            <div class="col-sm-10">
              <input type="text" name="appointment_name" value="<?php echo $appointment_name; ?>" placeholder="<?php echo $entry_name; ?>" id="input-username" readonly="readonly" class="form-control" />
              
            </div>
          </div>
          <div class="form-group">
            <label class="col-sm-2 control-label" for="input-user-group"><?php echo $entry_sales; ?></label>
            <div class="col-sm-10">
              <select name="salesrep_id" id="input-sales_manager" class="form-control" disabled="disabled">
                <option value="">Select Sales Rep</option>
                <?php foreach ($salesReps as $salesRep) { ?>
                <?php if ($salesRep['salesrep_id'] == $salesrep_id) { ?>
                <option value="<?php echo $salesRep['salesrep_id']; ?>" selected="selected"><?php echo $salesRep['salesrep_name']; ?> <?php echo $salesRep['salesrep_lastname']; ?></option>
                <?php } else { ?>
                <option value="<?php echo $salesRep['salesrep_id']; ?>"><?php echo $salesRep['salesrep_name']; ?> <?php echo $salesRep['salesrep_lastname']; ?></option>
                <?php } ?>
                <?php } ?>
              </select>
               
            </div>
          </div>
          
          <div class="form-group">
            <label class="col-sm-2 control-label" for="input-user-group"><?php echo $entry_customer; ?></label>
            <div class="col-sm-10">
              <select name="customer_id" id="input-sales_manager" class="form-control" disabled="disabled">
                <option value="">Select Customer</option>
                <?php foreach ($customers as $customer) { ?>
                 <?php if ($customer['customer_id'] == $customer_id) { ?>
                	<option value="<?php echo $customer['customer_id']; ?>" selected="selected"><?php echo $customer['firstname']; ?></option>
                 <?php } else { ?>
                 	<option value="<?php echo $customer['customer_id']; ?>" ><?php echo $customer['firstname']; ?></option>
                 <?php } ?>
                <?php } ?>
              </select>
              
            </div>
          </div>
          
          <div class="form-group">
            <label class="col-sm-2 control-label" for="input-username"><?php echo $entry_appointment_date; ?></label>
            
            <div class="input-group date" style="padding-left:14px;">
                  
                <div class='input-group date' id='datetimepicker5'>
                    <input name="appointment_date" readonly="readonly" type='text' value="<?php echo $appointment_date; ?>"  placeholder="DD-MM-YYYY hh:mm A" class="form-control" data-date-format="DD-MM-YYYY hh:mm A" class="form-control"  />
                    
                </div>
           
            </div>
            
          </div>
          <div class="form-group">
            <label class="col-sm-2 control-label" for="input-username">Appointment Duration</label>
            
            
                <div class="input-group" style="float:left;margin-left:15px;">
                <select name="hour" class="form-control" style="float:left;width:135px;" disabled="disabled">
                    <option value="">Select Hours</option>
                    <?php for($i=1;$i<=12;$i++) { ?>
                    	<?php if($i == $hour) { ?>
                        	<option value="<?php echo $i; ?>" selected="selected"><?php echo $i; ?></option>
                        <?php } else { ?>    
                            <option value="<?php echo $i; ?>"><?php echo $i; ?></option>
                        <?php } ?>
                    <?php } ?>
                </select>
               
              </div> 
              <div style="float:left;margin:0px 5px 0px 5px;"><strong style="font-size:23px;">:</strong></div>
              <div style="float:left;">
               <select name="minutes" class="form-control" style="float:left;width:135px;" disabled="disabled">
                            <option value="">Select Minutes</option>
                            <?php if($minutes == '00') { ?>
                            <option value="00" selected="selected">00</option>
                            <?php } else { ?>
                            <option value="00" >00</option>
                            <?php } ?>
                            
                            <?php if($minutes == '15') { ?>
                            <option value="15" selected="selected">15</option>
                            <?php } else { ?>
                            <option value="15" >15</option>
                            <?php } ?>
                            
                            <?php if($minutes == '30') { ?>
                            <option value="30" selected="selected">30</option>
                            <?php } else { ?>
                            <option value="30" >30</option>
                            <?php } ?>
                            
                            <?php if($minutes == '45') { ?>
                            <option value="45" selected="selected">45</option>
                            <?php } else { ?>
                            <option value="45" >45</option>
                            <?php } ?>
                           
                        </select>
                   
      
              </div>
              
            
            
          </div>
          <div class="form-group required">
            <label class="col-sm-2 control-label" for="input-username"><?php echo $entry_appointment_description; ?></label>
            <div class="col-sm-10">
              <textarea name="appointment_description" id="input-description" class="form-control" cols="10" rows="10" readonly="readonly" placeholder="<?php echo $entry_appointment_description; ?>"><?php echo $appointment_description; ?></textarea>
              
            </div>
          </div>
          
        </form>
      </div>
    </div>
  </div>
  
</div>
<?php echo $footer; ?> 