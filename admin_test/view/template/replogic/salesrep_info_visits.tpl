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
        <div class="well">
          <div class="row">
          	<h3>Filters</h3>
            <div class="col-sm-3">
              <div class="form-group">
              	<label class="control-label" for="input-name">Customer Name</label>
                <select name="filter_customer_id" id="input-customer" class="form-control">
                        <option value="">Customer Name</option>
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
                <button type="button" id="button-filter" class="btn btn-primary pull-right"><i class="fa fa-search"></i> Search</button>
                <button type="button" id="button-filter-reset" class="btn btn-primary pull-right" style="margin-right:10px;"><i class="fa fa-refresh"></i> Reset</button>
              </div>
            </div>
            
            
          </div>  
        </div>
         
          <div class="table-responsive" style="margin-bottom:15px;" >
            <table class="table table-bordered table-hover" style="margin-bottom:0px !important;">
              <thead>
                <tr>
                  <td class="text-left" width="140"><?php if ($sort == 'name') { ?>
                    <a href="<?php echo $sort_name; ?>" class="<?php echo strtolower($order); ?>">Customer Name</a>
                    <?php } else { ?>
                    <a href="<?php echo $sort_name; ?>">Customer Name</a>
                    <?php } ?></td>
                  <td class="text-center" width="100" >Last Check in</td>
                    <td class="text-left" width="140" >Visit date</td>
                  <td class="text-left" >Duration</td>
                  <td class="text-left"><?php if ($sort == 'name') { ?>
                    <a href="<?php echo $sort_name; ?>" class="<?php echo strtolower($order); ?>">Self reported location</a>
                    <?php } else { ?>
                    <a href="<?php echo $sort_name; ?>">Self reported location</a>
                    <?php } ?></td>  
                  
                  <td class="text-left" width="200">GPS Check in Location</td>
                  <td class="text-right" width="110">Action</td>
                </tr>
              </thead>
              <tbody>
              <input type="hidden" value="" id="modalcheckinid" />
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
                    			<a href="javascript:void()" data-id="<?php  echo $location['checkin_id']; ?>" title="View Map" class="btn btn-primary popmap"><i class="fa fa-map"></i></a>
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

 <style>
       #map-canvas {
          height: 400px;
          width: 100%;
       }
    </style>       
 <div class="modal fade" id="popupmyModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <h4 class="modal-title" id="myModalLabel">Sales Rep Location</h4>
          </div>
          <div class="modal-body">
              <div style="float:left;width:100%;">
              <div class="form-group">
                    <label for="inputName" class="control-label">Self Reported Location</label>
                    <input class="form-control" id="popupselfreport" value="" type="text" readonly="readonly">
                </div>
                <div class="form-group">
                    <label for="inputName" class="control-label">GPS Check In Location</label>
                    <input class="form-control" id="popupgps" value="" type="text" readonly="readonly">
                </div>
                <div class="form-group">
                    <label for="inputName" class="control-label">Customer Address</label>
                    <input class="form-control" id="popupcustomer" value="" type="text" readonly="readonly">
                </div>
              </div>
              <div id="map-canvas"></div>
              <div id="legend"></div>
          </div>
          <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
              </div>
        </div>
      </div>
    </div>
<script async defer src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCxPjLdmrrKDJKWM58YgvjEyRB6al2ASW0"></script>  
<script type="text/javascript">
  

 // $('#button-locate-all').on('click', function () { 
 $(document).on('click', '.popmap', function (e) {
  		  var checkinid = $(this).data('id');
		  $('#modalcheckinid').val(checkinid);
		  e.preventDefault();
		  $('#map-canvas').empty();
		  $('#legend').empty();
          $('#popupmyModal').modal('show');
      });
 
  $('#popupmyModal').on('shown.bs.modal', function () {
        
		var checkinid = $('#modalcheckinid').val();
		
		  $.ajax({
              url: 'index.php?route=replogic/location_management/PopupmapSingle&token=<?php echo $token; ?>',
		  	  type: 'post',
		  	  data: 'checkin_id='+checkinid,
		  	  dataType: 'json',
			  beforeSend: function() {
				  $('#popupselfreport').val('');
				  $('#popupgps').val('');
				  $('#popupcustomer').val('');
				},
              success: function (responce) {

                 	  var selflocation = responce['selflocation'];
					  var gpslocation = responce['gpslocation'];
					  var customeraddress = responce['customeraddress'];
					  
					  $('#popupselfreport').val(selflocation);
				      $('#popupgps').val(gpslocation);
				      $('#popupcustomer').val(customeraddress);
                      
                      var locations = [];

                      // validation: remove any null values to prevent map errors
                      for (var i=0; i<responce['mappin'].length; i++) { 
                          
						  if (responce['mappin'][i].latitude != null && responce['mappin'][i].latitude != "null" && responce['mappin'][i].longitude != null && responce['mappin'][i].longitude != "null") {
                              locations.push({latitude: responce['mappin'][i].latitude, longitude: responce['mappin'][i].longitude, name: responce['mappin'][i].name, icon: responce['mappin'][i].icon});
                          }
                      }
					  
                      // initialize map with markers
                      initialize(locations);
                  
              }
          });
      });
  
  	 // var map;

      // initialize map
      function initialize(locations) {
          map = new google.maps.Map(document.getElementById('map-canvas'), {
              zoom: 10,
              center: new google.maps.LatLng(locations[0].latitude, locations[0].longitude),
              mapTypeId: google.maps.MapTypeId.ROADMAP,
			  gestureHandling: 'greedy'
          });

          var infowindow = new google.maps.InfoWindow();
		  var bounds = new google.maps.LatLngBounds();
		  
		  var icons = {
						  parking: {
							name: 'Rep Checked In',
							icon: 'view/image/salesrep-checkin.png'
						  },
						  library: {
							name: 'GPS Location',
							icon: 'view/image/GPS.png'
						  },
						  info: {
							name: 'Customer',
							icon: 'view/image/customer2.png'
						  }
						};
						
			var legend = document.getElementById('legend');
			for (var key in icons) {
			  var type = icons[key];
			  var name = type.name;
			  var icon = type.icon;
			  var div = document.createElement('div');
			  div.innerHTML = '<img src="' + icon + '"> ' + name;
			  legend.appendChild(div);
			}
		  
          var marker, i;

          // loop through locations and create markers for the map
          for (i = 0; i < locations.length; i++) { 
              marker = new google.maps.Marker({
                  position: new google.maps.LatLng(locations[i].latitude, locations[i].longitude),
				  name:locations[i].name,
                  map: map,
				  icon: locations[i].icon
              });
			  
			bounds.extend(marker.position); 
			
              google.maps.event.addListener(marker, 'click', (function(marker, i) {
                  return function() {
                      infowindow.setContent(locations[i].name);
                      infowindow.open(map, marker);
                  }
              })(marker, i));
          }
		  
		  map.fitBounds(bounds);
		  
      };
  
</script>
  <style>
	#map { height: 450px; width: 100%; }
	#map-canvas { height: 400px;width: 100%;margin-top:15px;float:left; }
	#legend { font-family: Arial, sans-serif;background: #fff;border-radius: 5px;float:right; }
	#legend div { background:#FFFFFF;float:left;margin:5px;padding:5px;font-size:13px; }
	#legend img { vertical-align: middle; }
	
	.modal-body{float:left;padding-top:0px;}
	.modal-body .form-group {width:100%!important;clear:both;padding:9px 0px;}
	.modal-body .form-group + .form-group{border-top:none!important;}
	.modal-body .form-group .control-label {float:left;width:145px!important;margin-top:8px;}
	.modal-body .form-group .form-control {float:left;width:418px!important;}

  </style>


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