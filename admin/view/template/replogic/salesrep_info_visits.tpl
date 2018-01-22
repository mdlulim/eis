<?php echo $header; ?><?php echo $column_left; ?>

<div id="content">
  <div class="page-header">
    <div class="container-fluid">
    	<div class="pull-right"><a href="<?php echo $cancel; ?>" data-toggle="tooltip" title="<?php echo $button_cancel; ?>" class="btn btn-default"><i class="fa fa-reply"></i></a>
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
        <h3 class="panel-title"><i class="fa fa-info-circle" style="font-size:23px;"></i> <?php echo $text_list; ?><strong><?php echo $salesrepname; ?></strong></h3>
      </div>
      <div class="panel-body">
        
        <ul class="nav nav-tabs">
            <li><a href="<?php echo $generaltab; ?>" >General</a></li>
            <li><a href="<?php echo $appointmenttab; ?>" >Appointment</a></li>
            <li><a href="<?php echo $customerstab; ?>" >Customers</a></li>
            <li class="active"><a href="javascript:void()" >Visits</a></li>
            <li><a href="<?php echo $orderstab; ?>" >Orders</a></li>
            <li><a href="<?php echo $quotestab; ?>" >Quotes</a></li>
            
          </ul>
        
          <div class="row">
            <div class="col-sm-3">
              <div class="form-group">
              	<label class="control-label" for="input-name">Select Customer</label>
                <select name="filter_customer_id" id="input-customer" class="form-control">
                        <option value="">Select Customer</option>
                        <?php foreach ($customers as $customer) { ?>
                        <?php if ($customer['customer_id'] == $filter_customer_id) { ?>
                        <option value="<?php echo $customer['customer_id']; ?>" selected="selected"><?php echo $customer['firstname']; ?></option>
                        <?php } else { ?>
                        <option value="<?php echo $customer['customer_id']; ?>"><?php echo $customer['firstname']; ?></option>
                        <?php } ?>
                        <?php } ?>
                      </select>
              </div>
            </div>
            <div class="col-sm-3">
              <div class="form-group">
                <label class="control-label" for="input-date-added">Visit Date From</label>
                <div class="input-group date">
                  <input type="text" name="filter_date_from" value="<?php echo $filter_date_from; ?>" placeholder="Visit Date From" data-date-format="DD-MM-YYYY hh:mm A" id="input-date-from" class="form-control" />
                  <span class="input-group-btn">
                  <button type="button" class="btn btn-default"><i class="fa fa-calendar"></i></button>
                  </span></div>
              </div>
              
            </div>
            <div class="col-sm-3">
              <div class="form-group">
                <label class="control-label" for="input-date-added">Visit Date To</label>
                <div class="input-group date">
                  <input type="text" name="filter_date_to" value="<?php echo $filter_date_to; ?>" placeholder="Visit Date To" data-date-format="DD-MM-YYYY hh:mm A" id="input-date-to" class="form-control" />
                  <span class="input-group-btn">
                  <button type="button" class="btn btn-default"><i class="fa fa-calendar"></i></button>
                  </span></div>
              </div>
              
            </div>
            <div class="col-sm-3">
              <div class="form-group" style="margin-top:22px;">
                <button type="button" id="button-filter" class="btn btn-primary pull-right"><i class="fa fa-filter"></i> Search</button>
                <button type="button" id="button-filter-reset" class="btn btn-primary pull-right" style="margin-right:10px;"><i class="fa fa-filter"></i> Reset</button>
              </div>
            </div>
            
            
          </div>  
         
          <div class="table-responsive" style="margin-bottom:15px;" >
            <table class="table table-bordered table-hover" style="margin-bottom:0px !important;">
              <thead style="background-color:#CCCCCC;">
                <tr>
                  <td class="text-left" ><?php if ($sort == 'name') { ?>
                    <a href="<?php echo $sort_name; ?>" class="<?php echo strtolower($order); ?>">Customer</a>
                    <?php } else { ?>
                    <a href="<?php echo $sort_name; ?>">Customer</a>
                    <?php } ?></td>
                  <td class="text-center" >Last Check in</td>
                    <td class="text-left" >Visit date</td>
                  <td class="text-left" >Duration</td>
                  <td class="text-left"><?php if ($sort == 'name') { ?>
                    <a href="<?php echo $sort_name; ?>" class="<?php echo strtolower($order); ?>">Self reported location</a>
                    <?php } else { ?>
                    <a href="<?php echo $sort_name; ?>">Self reported location</a>
                    <?php } ?></td>  
                  
                  <td class="text-left" width="200">GPS Check in Location</td>
                  <td class="text-right">Action</td>
                </tr>
              </thead>
              <tbody>
                <?php if ($locations) { ?>
                    <?php foreach ($locations as $location) { ?>
                        
                            <tr>
                              <td class="text-left"><?php  echo $location['customer']; ?></td>
                              <td class="text-left"><?php echo $location['last_check']; ?></td>
                              <td class="text-center"><?php echo $location['visitdate']; ?></td>
                              <td class="text-left"><?php echo $location['duration']; ?></td>
                              <td class="text-left"><?php echo $location['location']; ?></td>
                              <td class="text-left" width="200"><?php  echo $location['checkin_location']; ?></td>
                              <td class="text-right">
                    			<a href="javascript:void()" onclick="viewmap(<?php  echo $location['checkin_id']; ?>)" title="View Map" class="btn btn-primary"><i class="fa fa-map"></i></a>
                                <a href="<?php echo $location['view']; ?>" data-toggle="tooltip" title="<?php echo $button_view; ?>" class="btn btn-info"><i class="fa fa-eye"></i></a>
                                </td>
                            </tr>
                     <?php } ?>
                    <?php } else { ?>
                    <tr>
                      <td class="text-center" colspan="7"><?php echo $text_no_results; ?></td>
                    </tr>
                    <?php } ?>
                
              </tbody>
            </table>
          </div>
  
        <div class="row">
          <div class="col-sm-6 text-left"><?php echo $pagination; ?></div>
          <div class="col-sm-6 text-right"><?php echo $results; ?></div>
        </div>
      </div>
    </div>
  </div>
</div>
<div id="popupmyModal" class="modal fade" role="dialog">
          
          <div class="modal-dialog">
        
            <!-- Modal content-->
            <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Sales Rep Location</h4>
              </div>
              <div class="modal-body">
                <div id="popupmap" style="height:400px;"></div>
                
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
              </div>
            </div>
        
          </div>
          
        </div>
<script type="text/javascript" src="http://maps.google.com/maps/api/js?key=AIzaSyA6ycZiGobIPuZ8wtXalf2m2MtxAzncn_Q&sensor=false"></script>  
  
<script type="text/javascript">
  
  var center = new google.maps.LatLng(59.76522, 18.35002);
 function initialize() {
      var mapOptions = {
          zoom: 4,
          mapTypeId: google.maps.MapTypeId.ROADMAP,
          center: center,
		  gestureHandling: 'greedy'
      };
      map = new google.maps.Map(document.getElementById('popupmap'), mapOptions);
      var marker = new google.maps.Marker({
          map: map,
          position: center
      });
  }
  
  

 // $('#button-locate-all').on('click', function () { 
  function viewmap(checkin_id)
  { 
      $('#popupmyModal').modal({
          backdrop: 'static',
          keyboard: false
      }).on('shown.bs.modal', function () {
          
		  google.maps.event.trigger(map, 'resize');
          map.setCenter(center);
		  
		  $.ajax({
		  url: 'index.php?route=replogic/location_management/Popupmap&token=<?php echo $token; ?>',
		  type: 'post',
		  data: 'checkin_id='+checkin_id,
		  dataType: 'json',
		  success: function(json) { 
			
			//$('#popupmyModal').modal('show');
			//google.maps.event.trigger(map, 'resize');
           // map.setCenter(center);
		   //initialize();
		   
			
		},
		error: function(xhr, ajaxOptions, thrownError) {
			alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
		}
	});
		  
      });
  }
  
  initialize();
  
</script>

<script type="text/javascript"><!--
$('#button-filter').on('click', function() {
	var url = 'index.php?route=replogic/salesrep_info&type=visits&salesrep_id=<?php echo $salesrep_id; ?>&token=<?php echo $token; ?>';

	var filter_customer_id = $('select[name=\'filter_customer_id\']').val();

	if (filter_customer_id) {
		url += '&filter_customer_id=' + encodeURIComponent(filter_customer_id);
	}
	
	var filter_date_from = $('input[name=\'filter_date_from\']').val();

	if (filter_date_from) {
		url += '&filter_date_from=' + encodeURIComponent(filter_date_from);
	}
	
	var filter_date_to = $('input[name=\'filter_date_to\']').val();

	if (filter_date_to) {
		url += '&filter_date_to=' + encodeURIComponent(filter_date_to);
	}
	
	location = url;
});

$('#button-filter-reset').on('click', function() {
	var url = 'index.php?route=replogic/salesrep_info&type=visits&salesrep_id=<?php echo $salesrep_id; ?>&token=<?php echo $token; ?>';

	location = url;
});

//--></script>
<script type="text/javascript"><!--
$('.date').datetimepicker({
	//pickTime: false
});
//--></script>
<?php echo $footer; ?> 