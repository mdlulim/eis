
<?php echo $header; ?><?php echo $column_left; ?>

<div id="content" data-page-id="customer_info" data-token="<?php echo $token; ?>" data-page-url="<?php echo $reload_cus_url; ?>">
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
        <h3 class="panel-title"><i class="fa fa-info-circle" style="font-size:23px;"></i> <?php echo $text_list; ?><strong><?php echo $customername; ?></strong></h3>
      </div>
      <div class="panel-body">
        
        <ul class="nav nav-tabs">
            <li><a href="<?php echo $generaltab; ?>" >General</a></li>
            <li><a href="<?php echo $appointmenttab; ?>" >Appointment</a></li>
            <li><a href="<?php echo $customerstab; ?>" >Customer Contact</a></li>
            <li class="active"><a href="javascript:void()" >Visits</a></li>
            <li><a href="<?php echo $orderstab; ?>" >Orders</a></li>
            <li><a href="<?php echo $quotestab; ?>" >Quotes</a></li>
            <li><a href="<?php echo $historytab; ?>" >History</a></li>
            <li><a href="<?php echo $transactionstab; ?>" >Transactions</a></li>
            <li><a href="<?php echo $rewardpointstab; ?>" >Reward Points</a></li>
            <li><a href="<?php echo $ipaddressestab; ?>" >IP Addresses</a></li>
            
          </ul>
        
         <div class="well">
         	<h3>Filters</h3>
          <div class="row">
            <!--<div class="col-sm-3">
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
            </div>-->
            <div class="col-sm-6">
              <div class="form-group">
                <label class="control-label" for="input-date-added">Visit Date From</label>
                <div class="input-group date">
                  <input type="text" name="filter_date_from" value="<?php echo $filter_date_from; ?>" placeholder="Date From" data-date-format="DD-MM-YYYY hh:mm A" id="input-date-from" class="form-control" />
                  <span class="input-group-btn">
                  <button type="button" class="btn btn-default"><i class="fa fa-calendar"></i></button>
                  </span></div>
              </div>
              
            </div>
            <div class="col-sm-6">
              <div class="form-group">
                <label class="control-label" for="input-date-added">Visit Date To</label>
                <div class="input-group date">
                  <input type="text" name="filter_date_to" value="<?php echo $filter_date_to; ?>" placeholder="Date To" data-date-format="DD-MM-YYYY hh:mm A" id="input-date-to" class="form-control" />
                  <span class="input-group-btn">
                  <button type="button" class="btn btn-default"><i class="fa fa-calendar"></i></button>
                  </span></div>
              </div>
              <div class="form-group">
                <button type="button" id="button-filter" class="btn btn-primary pull-right"><i class="fa fa-search"></i> Search</button>
                <button type="button" id="button-filter-reset" class="btn btn-primary pull-right" style="margin-right:10px;"><i class="fa fa-refresh"></i> Reset</button>
              </div>
            </div>
            
            
            
          </div>  
         </div>
          <div class="table-responsive" style="margin-bottom:15px;" >
            <table class="table table-bordered table-hover" style="margin-bottom:0px !important;">
              <thead >
                <tr>
                  <td class="text-left" >Sales Rep Name</td>
                  <td class="text-left" >Last Check in</td>
                    <td class="text-left" >Visit date</td>
                  <td class="text-left" >Duration</td>
                  <td class="text-left" width="236">Self reported location</td>  
                  <td class="text-left" width="200">GPS Check in Location</td>
                  <td class="text-right" width="110">Action</td>
                </tr>
              </thead>
              <tbody>
              <input type="hidden" value="" id="modalcheckinid" />
                 <?php if ($locations) { ?>
                    <?php foreach ($locations as $location) { ?>
                        
                            <tr>
                              <td class="text-left"><?php  echo $location['salesrepname']; ?></td>
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

<!-- ===========================LOCATION MANAGEMENT================================================ -->

<div class="panel-body">
              <div class="lm-map-container">
                   <div id="lm-map"> </div>
              </div>

<?php
/* ====================================================================================
   DO NOT REMOVE CODE BELOW THIS LINE [ Google Map | JavaScript ]
   ==================================================================================== */
?>
<script>

    var map;
    var markers = [];
    var infoWindow;
    var locationSelected;
    var geocoder;

    function initMap() {
        var southAfrica = { lat: -27.4457987, lng: 21.4340156 }; // map center [default]

        var legend  = document.createElement('div');
        legend.id   = 'gmap-legend';
        var content = [];
        content.push('<div class="col__legend"><img src="view/image/gmap__checkin_icon.png" /> Rep Checked In</div>');
        content.push('<div class="col__legend"><img src="view/image/gmap__location_icon.png" /> Rep GPS Location</div>');
        content.push('<div class="col__legend"><img src="view/image/gmap__customer_icon.png" /> Customer</div>');
        legend.innerHTML = content.join('');
        legend.index = 1;

        map = new google.maps.Map(document.getElementById('lm-map'), {
            center: southAfrica,
            zoom: 5,
            mapTypeId: 'roadmap',
            mapTypeControlOptions: {style: google.maps.MapTypeControlStyle.DROPDOWN_MENU}
        });

        map.controls[google.maps.ControlPosition.RIGHT_BOTTOM].push(legend);
        infoWindow = new google.maps.InfoWindow();
        geocoder   = new google.maps.Geocoder();

        /*************************************************************
         * Sales reps current location
         *************************************************************/
        // <use:php> 
        // # loop through location markers
        <?php
        //var_dump($markers_salesreps);die();
         if (!empty($markers_salesreps)) : ?>
            <?php foreach($markers_salesreps as $marker_salesrep) : ?>
                var obj = {
                    id      : '<?php echo $marker_salesrep['id']?>',
                    lat     : '<?php echo $marker_salesrep['latitude']?>',
                    lng     : '<?php echo $marker_salesrep['longitude']?>',
                    name    : '<?php echo $marker_salesrep['name']?>',
                    address : '<?php echo $marker_salesrep['address']?>',
                    icon    : '<?php echo $marker_salesrep['icon']; ?>'
                }
                createMarker(obj, "salesrep");
              
            <?php endforeach; ?>
        <?php endif; ?>
        // </use:php>


        /*************************************************************
         * Customer location
         *************************************************************/
        // <use:php> 
        // # loop through location markers
        <?php if (!empty($markers_customers)) : ?>
       
            <?php foreach($markers_customers as $marker_customer) : ?>
                var obj = {
                    last_visit : '<?php echo $marker_customer['last_visited']?>',
                    id         : '<?php echo $marker_customer['id']?>',
                    lat        : '<?php echo $marker_customer['latitude']?>',
                    lng        : '<?php echo $marker_customer['longitude']?>',
                    name       : '<?php echo $marker_customer['name']?>',
                    address    : '<?php echo $marker_customer['address']?>',
                    icon       : '<?php echo $marker_customer['icon']; ?>',
                    sr_name    : '<?php echo $marker_customer['salesrep_name']; ?>',
                    sr_id      : '<?php echo $marker_customer['salesrep_id']; ?>'
                }
                createMarker(obj, "customer");
            <?php endforeach; ?>
        <?php endif; ?>
        // </use:php>


        /*************************************************************
         * GPS [Check-in] location
         *************************************************************/
        // <use:php> 
        // # loop through location markers
        <?php if (!empty($markers_checkins)) : ?>
            <?php foreach($markers_checkins as $marker_checkin) : ?>
                var obj = {
                    id      : '<?php echo $marker_checkin['id']?>',
                    lat     : '<?php echo $marker_checkin['latitude']?>',
                    lng     : '<?php echo $marker_checkin['longitude']?>',
                    name    : '<?php echo $marker_checkin['name']?>',
                    address : '<?php echo $marker_checkin['address']?>',
                    icon    : '<?php echo $marker_checkin['icon']; ?>'
                }
                createMarker(obj, "salesrep");
            <?php endforeach; ?>
        <?php endif; ?>
        // </use:php>
        
        locationSelected = $("section.lm__show_map-marker");
        locationSelected.on("click", function() {
            var markerId = $(this).data("marker-id");
            if ($(this).hasClass("has__infoWindow")) {
                infoWindow.close(map, markers[markerId]);
                $(this).removeClass("has__infoWindow");
            } else {
                if (markerId !== undefined && markerId != "none") {
                    google.maps.event.trigger(markers[markerId], 'click');
                    $(this).addClass("has__infoWindow");
                }
            }
        });
    }

    function createMarker(data, type) {

        // geocoder
        geocoder.geocode({'address': data.address}, function(results, status) {
            if (status === "OK") {
                if (results.length) {
                    var coordinates = results[0].geometry.location;
                    var html   = getInfoWindowContent(data, type);
                    var marker = new google.maps.Marker({
                        position: coordinates,
                        name: data.id,
                        map: map,
                        icon: data.icon
                    });
                    google.maps.event.addListener(marker, 'click', function() {
                        infoWindow.setContent(html);
                        infoWindow.open(map, marker);
                    });
                    markers.push(marker);
                }
            } else {
                /////// an error has occured: write relevant code underneath ///////
            }
        });
    }

    function getInfoWindowContent(data, type) {
        var html = ``;
        switch(type) {
            case 'customer':
                html += `<div class="gmap__infowindow ${type}">`;
                html += `<div class="row">`;
                html += `<div class="col__icon"><i class='material-icons'>&#xe0af</i></div>`;
                html += `<div class="col__content"><b>${data.name}</b><br/>${data.address}</div>`;
                html += `</div>`;
                html += `<div class="row"><hr/></div>`;
                html += `<div class="row">`;
                html += `<div class="col__icon">&nbsp;</div>`;
                html += `<div class="col__content"><b>Last visited:</b> ${data.last_visit}<br/>`;
                html += `<a href="#" data-toggle="appointment-modal" data-cname="${data.name}" data-cid="${data.id}" data-srname="${data.sr_name}" data-srid="${data.sr_id}" data-addr="${data.address}">Schedule Appointment...</a></div>`;
                html += `</div>`;
                html += `</div>`;
                break;
            
            case 'salesrep':
                html += `<div class="gmap__infowindow ${type}">`;
                html += `<div class="row">`;
                html += `<div class="col__icon"><i class='material-icons'>&#xe7fd</i></div>`;
                html += `<div class="col__content">Sales Rep: <b>${data.name}</b></div>`;
                html += `</div>`;
                html += `<div class="row" style="margin-top:13px">`;
                html += `<div class="col__icon"><i class='material-icons text-danger'>&#xe55f</i></div>`;
                html += `<div class="col__content"><b>GPS Address</b><br/>${data.address}</div>`;
                html += `</div>`;
                html += `</div>`;
                break;
        }
        return html;
    }
</script>
<script async defer src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCxPjLdmrrKDJKWM58YgvjEyRB6al2ASW0&callback=initMap"></script>

<?php
/* ====================================================================================
   DO NOT REMOVE CODE ABOVE THIS LINE [ Google Map | JavaScript ]
   ==================================================================================== */
?>
            </div>
<?php
/** ===========================END LOCATION MANAGEMENT============================================= */
 ?>
      </div>
    </div>
  </div>
</div>
<?php
/** ===========================Modal Schedule Appointment============================================= */
 ?>
 <div class="modal fade" id="modalScheduleAppointment" tabindex="-1" role="dialog" aria-labelledby="modalScheduleAppointmentLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal__loader-overlay"><div>Please waiting whilst processing...</div></div>
            <form id="form__schedule-appointment" action=" " method="post" novalidate>
                <input type="hidden" name="appointment_type" id="input__appointment_type" value="<?php echo ($filter_type=='customer') ? 'Existing Business' : 'New Business'; ?>">
                <input type="hidden" name="customer_id" id="input__customer_id">
                <input type="hidden" name="salesrep_id" id="input__salesrep_id">
                <input type="hidden" name="appointment_address" id="input__appointment_address">
                <input type="hidden" name="appointment_time" id="input__appointment_time">
                <input type="hidden" name="bcustomer_name" id="input__customer_name">
                <input type="hidden" id="input__salesrep_name">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="modalScheduleAppointmentLabel">Create Appointment</h4>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="form-group has-feedback required">
                            <label class="col-sm-3 text-right" for="input__appointment_title">Appointment Title:</label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control" id="input__appointment_title" name="appointment_name" required>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group">
                            <label class="col-sm-3 text-right" for="">Customer:</label>
                            <div class="col-sm-3" style="padding-top:8px"><span id="customer_name">-</span></div>
                            <label class="col-sm-3 text-right" for="input__salesrep">Sales Rep Name:</label>
                            <div class="col-sm-3" style="padding-top:8px"><span id="salesrep_name">-</span></div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group required">
                            <label class="col-sm-3 text-right" for="input__appointment_duration">Duration:</label>
                            <div class="col-sm-6">
                                <select class="form-control" name="appointment_duration" id="input__appointment_duration">
                                    <option value="0:30" selected>30 minutes</option>
                                    <option value="1:00">1 hour</option>
                                    <option value="1:30">1.5 hours</option>
                                    <option value="2:00">2 hours</option>
                                    <option value="3:00">3 hours</option>
                                    <option value="4:00">4 hours</option>
                                    <option value="5:00">5 hours</option>
                                    <option value="6:00">6 hours</option>
                                    <option value="7:00">7 hours</option>
                                    <option value="8:00">8 hours</option>
                                    <option value="9:00">9 hours</option>
                                    <option value="10:00">10 hours</option>
                                    <option value="11:00">11 hours</option>
                                    <option value="1 Day">1 day</option>
                                    <option value="2 Days">2 days</option>
                                    <option value="3 Day">3 days</option>
                                    <option value="4 Day">4 days</option>
                                    <option value="1 Week">1 Week</option>
                                    <option value="2 Weeks">2 Weeks</option>
                                </select>
                            </div>
                            <div class="col-sm-3">
                                <div class="checkbox">
                                    <label>
                                        <input name="appointment_duration_all_day" type="checkbox" id="input__all_day_check">
                                        All day meeting
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group required">
                            <label class="col-sm-3 text-right">Date:</label>
                            <div class="col-sm-6">
                                <div>
                                    <input type='text' name="appointment_date" id="input__appointment_date" class="form-control" value="<?php echo date('l, d F Y');?>" />
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group required">
                            <label class="col-sm-3 text-right">Available Times:</label>
                            <div class="col-sm-9">
                                <div class="row row__available-times">
                                    <?php if (!empty($available_times)) : ?>
                                        <?php foreach ($available_times as $time) : ?>
                                            <?php if (in_array($time, $booked_times)) : ?>
                                            <div class="col-sm-2 disabled"><?php echo $time; ?></div>
                                            <?php else: ?>
                                            <div class="col-sm-2"><?php echo $time; ?></div>
                                            <?php endif; ?>
                                        <?php endforeach; ?>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group">
                            <label class="col-sm-3 text-right" for="">Description:</label>
                            <div class="col-sm-9">
                                <textarea name="appointment_description" class="form-control"></textarea>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary" disabled> &nbsp;&nbsp;Create&nbsp;&nbsp; </button>
                    <button type="button" class="btn btn-default" data-dismiss="modal"> &nbsp;&nbsp;Cancel&nbsp;&nbsp; </button>
                </div>
            </form>
        </div>
    </div>
</div>


  <!-- /Modal(s) -->
      
 <div class="modal fade" id="popupmyModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <h4 class="modal-title" id="myModalLabel">Sales Rep Location</h4>
          </div>
          <div class="modal-body">
              <div id="map-canvas"></div>
          </div>
          <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
              </div>
          
        </div>
      </div>
    </div>
<script type="text/javascript">
  

 // $('#button-locate-all').on('click', function () { 
 $(document).on('click', '.popmap', function (e) {
  		  var checkinid = $(this).data('id');
		  $('#modalcheckinid').val(checkinid);
		  e.preventDefault();
		  $('#map-canvas').empty();
          $('#popupmyModal').modal('show');
      });
 
  $('#popupmyModal').on('shown.bs.modal', function () {
        
		var checkinid = $('#modalcheckinid').val();
		
		  $.ajax({
              url: 'index.php?route=replogic/location_management/PopupmapSingle&token=<?php echo $token; ?>',
		  	  type: 'post',
		  	  data: 'checkin_id='+checkinid,
		  	  dataType: 'json',
              success: function (responce) {

                 
                      var data = responce;
                      var locations = [];

                      // validation: remove any null values to prevent map errors
                      for (var i=0; i<data.length; i++) { 
                          if (data[i].latitude != null && data[i].latitude != "null" && data[i].longitude != null && data[i].longitude != "null") {
                              locations.push({latitude: data[i].latitude, longitude: data[i].longitude, name: data[i].name, icon: data[i].icon});
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



<script type="text/javascript"><!--
$('#button-filter').on('click', function() {
	var url = 'index.php?route=customer/customer_info&type=visits&customer_id=<?php echo $customer_id; ?>&token=<?php echo $token; ?>';

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
	var url = 'index.php?route=customer/customer_info&type=visits&customer_id=<?php echo $customer_id; ?>&token=<?php echo $token; ?>';

	location = url;
});

//--></script>
<script type="text/javascript"><!--
$('.date').datetimepicker({
	//pickTime: false
});
//--></script>
<?php echo $footer; ?> 