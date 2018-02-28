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
            <label class="col-sm-2 control-label" for="input-user-group">Business Type</label>
            <div class="col-sm-10">
              <?php if($type == 'New Business') { ?>
				  <style>
                    .newbusiness{display:block;}
                    .custmr_id{display:none;}
                  </style>
              <?php } else if($type == 'Existing Business') { ?>
              		<style>
                    .newbusiness{display:none;}
                    .custmr_id{display:block;}
                  </style>
              <?php } else  { ?>
              		<style>
                    .newbusiness{display:none;}
                    .custmr_id{display:none;}
                  </style>
              <?php } ?>
              
              
              <select name="type" id="input-type" class="form-control">
                <option value="">Select Business Type</option>
                <?php if($type == 'New Business') { ?>
                	<option value="New Business" selected="selected">New Business</option>
                <?php } else { ?>
                	<option value="New Business">New Business</option>
                <?php } ?>
                <?php if($type == 'Existing Business') { ?>
                	<option value="Existing Business" selected="selected">Existing Business</option>
                <?php } else { ?>
                	<option value="Existing Business">Existing Business</option>
                <?php } ?>
                
              </select>
               <?php if ($error_type) { ?>
              <div class="text-danger"><?php echo $error_type; ?></div>
              <?php } ?>
            </div>
          </div>
          
          <div class="form-group required">
            <label class="col-sm-2 control-label" for="input-username"><?php echo $entry_name; ?></label>
            <div class="col-sm-10">
              <input type="text" name="appointment_name" value="<?php echo $appointment_name; ?>" placeholder="<?php echo $entry_name; ?>" id="input-username" class="form-control" />
              <?php if ($error_appointment_name) { ?>
              <div class="text-danger"><?php echo $error_appointment_name; ?></div>
              <?php } ?>
            </div>
          </div>
          <div class="form-group required">
            <label class="col-sm-2 control-label" for="input-user-group"><?php echo $entry_sales; ?></label>
            <div class="col-sm-10">
              <select name="salesrep_id" id="input-sales_manager" class="form-control">
                <option value="">Select Sales Rep</option>
                <?php foreach ($salesReps as $salesRep) { ?>
                <?php if ($salesRep['salesrep_id'] == $salesrep_id) { ?>
                <option value="<?php echo $salesRep['salesrep_id']; ?>" selected="selected"><?php echo $salesRep['salesrep_name']; ?> <?php echo $salesRep['salesrep_lastname']; ?></option>
                <?php } else { ?>
                <option value="<?php echo $salesRep['salesrep_id']; ?>"><?php echo $salesRep['salesrep_name']; ?> <?php echo $salesRep['salesrep_lastname']; ?></option>
                <?php } ?>
                <?php } ?>
              </select>
               <?php if ($error_salesrep_id) { ?>
              <div class="text-danger"><?php echo $error_salesrep_id; ?></div>
              <?php } ?>
            </div>
          </div>
          
          <div class="form-group required custmr_id">
            <label class="col-sm-2 control-label" for="input-user-group"><?php echo $entry_customer; ?></label>
            <div class="col-sm-10">
              <select name="customer_id" id="input-sales_manager" class="form-control">
                <option value="">Select Customer</option>
                <?php foreach ($customers as $customer) { ?>
                 <?php if ($customer['customer_id'] == $customer_id) { ?>
                	<option value="<?php echo $customer['customer_id']; ?>" selected="selected"><?php echo $customer['firstname']; ?></option>
                 <?php } else { ?>
                 	<option value="<?php echo $customer['customer_id']; ?>" ><?php echo $customer['firstname']; ?></option>
                 <?php } ?>
                <?php } ?>
              </select>
               <?php if ($error_customer_id) { ?>
              <div class="text-danger"><?php echo $error_customer_id; ?></div>
              <?php } ?>
            </div>
          </div>
          
          <div class="form-group required custmr_id">
            <label class="col-sm-2 control-label" for="input-username">Address</label>
            <div class="col-sm-10">
              <input type="text" name="appointment_address" value="<?php echo $appointment_address; ?>" placeholder="Plz Enter Address" id="input-appointment_address" class="form-control" />
              <?php if ($error_appointment_address) { ?>
              <div class="text-danger"><?php echo $error_appointment_address; ?></div>
              <?php } ?>
            </div>
          </div>
          
          <div class="form-group required newbusiness">
            <label class="col-sm-2 control-label" for="input-username">Customer Name</label>
            <div class="col-sm-10">
              <input type="text" name="bcustomer_name" value="<?php echo $bcustomer_name; ?>" placeholder="Enter Customer Name" id="input-bcustomer_name" class="form-control" />
              <?php if ($error_bcustomer_name) { ?>
              <div class="text-danger"><?php echo $error_bcustomer_name; ?></div>
              <?php } ?>
            </div>
          </div>
          
          <div class="form-group required newbusiness">
            <label class="col-sm-2 control-label" for="input-username">Address</label>
            <div class="col-sm-10">
              <input type="text" name="address" value="<?php echo $address; ?>" placeholder="Enter address" id="input-address" class="form-control" />
              <?php if ($error_address) { ?>
              <div class="text-danger"><?php echo $error_address; ?></div>
              <?php } ?>
            </div>
          </div>
          
          <div class="form-group required">
            <label class="col-sm-2 control-label" for="input-username"><?php echo $entry_appointment_date; ?></label>
            
            <div class="input-group date" style="padding-left:14px;">
                  <!--<input type="text" name="appointment_date" value="<?php echo $appointment_date; ?>" placeholder="YYYY-MM-DD" data-date-format="YYYY-MM-DD HH:mm:ss" id="input-date-added" class="form-control" style="width:163px;" />
                  <span class="input-group-btn" style="float:left;">
                  <button type="button" class="btn btn-default"><i class="fa fa-calendar"></i></button>
                  </span>-->
                  
                
                <div class='input-group date' id='datetimepicker5'>
                    <input name="appointment_date" type='text' value="<?php echo $appointment_date; ?>"  placeholder="DD-MM-YYYY hh:mm A" class="form-control" data-date-format="DD-MM-YYYY hh:mm A" class="form-control"  />
                    <span class="input-group-addon">
                        <span class="glyphicon glyphicon-calendar"></span>
                    </span>
                </div>
           <style>
		   .glyphicon-calendar:before {content: "\e109" !important; }
		   </style>
        		<script type="text/javascript">
            $(function () {
                $('#datetimepicker5').datetimepicker({
                    defaultDate: new Date(),
                   
                });
            });
        </script>
      
                     <?php if ($error_appointment_date) { ?>
                  <div class="text-danger" style="width:100%;margin-top:40px;"><?php echo $error_appointment_date; ?></div>
                  <?php } ?>
            </div>
            
          </div>
          <div class="form-group required">
            <label class="col-sm-2 control-label" for="input-username">Appointment Duration</label>
            
            
                <div class="input-group" style="float:left;margin-left:15px;">
                <select name="hour" class="form-control" style="float:left;width:135px;">
                    <option value="">Select Hours</option>
                    <?php for($i=1;$i<=12;$i++) { ?>
                    	<?php if($i == $hour) { ?>
                        	<option value="<?php echo $i; ?>" selected="selected"><?php echo $i; ?></option>
                        <?php } else { ?>    
                            <option value="<?php echo $i; ?>"><?php echo $i; ?></option>
                        <?php } ?>
                    <?php } ?>
                </select>
                  
      
               <?php if ($error_hour) { ?>
              		<div class="text-danger" style="width:100%;margin-top:40px;"><?php echo $error_hour; ?></div>
              <?php } ?>
              </div> 
              <div style="float:left;margin:0px 5px 0px 5px;"><strong style="font-size:23px;">:</strong></div>
              <div style="float:left;">
               <select name="minutes" class="form-control" style="float:left;width:135px;">
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
                   
      
               <?php if ($error_minutes) { ?>
              		<div class="text-danger" style="width:100%;margin-top:40px;"><?php echo $error_minutes; ?></div>
              <?php } ?>
              </div>
              
            
            
          </div>
          <div class="form-group">
            <label class="col-sm-2 control-label" for="input-username"><?php echo $entry_appointment_description; ?></label>
            <div class="col-sm-10">
              <textarea name="appointment_description" id="input-description" class="form-control" cols="10" rows="10" placeholder="<?php echo $entry_appointment_description; ?>"><?php echo $appointment_description; ?></textarea>
              <?php if ($error_appointment_description) { ?>
              <div class="text-danger"><?php echo $error_appointment_description; ?></div>
              <?php } ?>
            </div>
          </div>
          
        </form>
      </div>
    </div>
  </div>
 <script type="text/javascript">
 $(document.body).on('change',"#input-type",function (e) {
   //doStuff
   var optVal= $("#input-type option:selected").val();
   if(optVal == 'New Business')
   {
   		$(".newbusiness").css("display", "block");
		$(".custmr_id").css("display", "none");
   }
   else if(optVal == 'Existing Business')
   {
   		$(".custmr_id").css("display", "block");
		$(".newbusiness").css("display", "none");
   }
   else
   {
   		$(".custmr_id").css("display", "none");
		$(".newbusiness").css("display", "none");
   }
   
});
 </script> 
</div>
<?php echo $footer; ?> 