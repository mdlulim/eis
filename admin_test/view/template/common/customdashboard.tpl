<?php echo $header; ?><?php echo $column_left; ?>
<div id="content">
    <div class="page-header">
      <div class="container-fluid">
        <h1>Dashboard</h1>
        <ul class="breadcrumb">
          <?php foreach ($breadcrumbs as $breadcrumb) { ?>
        	<li><a href="<?php echo $breadcrumb['href']; ?>"><?php echo $breadcrumb['text']; ?></a></li>
          <?php } ?>
        </ul>
      </div>
    </div>
    <div class="container-fluid">
      <div class="row">
        <div class="col-lg-3 col-md-3 col-sm-6">
          <div class="tile">
              <div class="tile-heading">Total Orders <span class="pull-right">
                <?php if ($percentageorder > 0) { ?>
                <i class="fa fa-caret-up"></i>
                <?php } elseif ($percentageorder < 0) { ?>
                <i class="fa fa-caret-down"></i>
                <?php } ?>
                <?php echo $percentageorder; ?>%</span></div>
              <div class="tile-body"><i class="fa fa-shopping-cart"></i>
                <h2 class="pull-right"><?php echo $totalorder; ?></h2>
              </div>
              <div class="tile-footer"><a href="<?php echo $order; ?>">View more...</a></div>
            </div>
          
        </div>
        <div class="col-lg-3 col-md-3 col-sm-6">
          
          <div class="tile">
              <div class="tile-heading">Total Sales <span class="pull-right">
                <?php if ($percentagesale > 0) { ?>
                <i class="fa fa-caret-up"></i>
                <?php } elseif ($percentagesale < 0) { ?>
                <i class="fa fa-caret-down"></i>
                <?php } ?>
                <?php echo $percentagesale; ?>% </span></div>
              <div class="tile-body"><i class="fa fa-credit-card"></i>
                <h2 class="pull-right"><?php echo $totalsale; ?></h2>
              </div>
              <div class="tile-footer"><a href="<?php echo $sale; ?>">View more...</a></div>
          </div>
          
        </div>
        <div class="col-lg-3 col-md-3 col-sm-6">
          <div class="tile">
          <div class="tile-heading">Customers Awaiting Approval <span class="pull-right">
            <?php if ($percentage > 0) { ?>
            <i class="fa fa-caret-up"></i>
            <?php } elseif ($percentage < 0) { ?>
            <i class="fa fa-caret-down"></i>
            <?php } ?>
            <?php echo $percentage; ?>%</span></div>
          <div class="tile-body"><i class="fa fa-user"></i>
            <h2 class="pull-right"><?php echo $total; ?></h2>
          </div>
          <div class="tile-footer"><a href="<?php echo $customer; ?>">View more...</a></div>
        </div>
        </div>
        <div class="col-lg-3 col-md-3 col-sm-6">
          <div class="tile">
          <div class="tile-heading">Order Awaiting Approval <span class="pull-right">
            <?php if ($percentageordwait > 0) { ?>
            <i class="fa fa-caret-up"></i>
            <?php } elseif ($percentageordwait < 0) { ?>
            <i class="fa fa-caret-down"></i>
            <?php } ?>
            <?php echo $percentageordwait; ?>%</span></div>
          <div class="tile-body"><i class="fa fa-user"></i>
            <h2 class="pull-right"><?php echo $totalordwait; ?></h2>
          </div>
          <div class="tile-footer"><a href="<?php echo $ordwait; ?>">View more...</a></div>
        </div>
        </div>
        <!--<div class="col-lg-3 col-md-3 col-sm-6">
          <div class="tile">
              <div class="tile-heading">People Online</div>
              <div class="tile-body"><i class="fa fa-users"></i>
                <h2 class="pull-right"><?php echo $totalonline; ?></h2>
              </div>
              <div class="tile-footer"><a href="<?php echo $online; ?>">View more...</a></div>
            </div>
        </div>-->
        
        <?php if($loginuser != 'Sales Manager') { ?>
        <a href="<?php echo $addteambutton; ?>">
            <div class="col-lg-3 col-md-3 col-sm-6" >
              <div class="tile">
              <div class="tile-footer" style="text-align: center; min-height: 45px; font-weight: bold; padding-top: 14px;"><i class="fa fa-users fw"></i> Add Team</div>
            </div>
            </div>
            </a>
        <?php } ?>
        
        <a href="<?php echo $addappointmentbutton; ?>">
            <div <?php echo $cls; ?>>
              <div class="tile">
              <div class="tile-footer" style="text-align: center; min-height: 45px; font-weight: bold; padding-top: 14px;"><i class="fa fa-calendar"></i> Add Appointment</div>
            </div>
            </div>
        </a>
        
        <?php if($loginuser != 'Sales Manager') { ?>
        <a href="<?php echo $addsalesmangebutton; ?>">
            <div class="col-lg-3 col-md-3 col-sm-6">
              <div class="tile">
              <div class="tile-footer" style="text-align: center; min-height: 45px; font-weight: bold; padding-top: 14px;"><i class="fa fa-user"></i> Add Sales Manager</div>
            </div>
            </div>
         </a>
        <?php } ?>
        
        <a href="<?php echo $addsalesrepbutton; ?>">
        <div <?php echo $cls; ?>>
          <div class="tile">
          <div class="tile-footer" style="text-align: center; min-height: 45px; font-weight: bold; padding-top: 14px;"><i class="fa fa-street-view"></i> Add Sales Rep</div>
        </div>
        </div>
        </a>
      </div>
      <div class="row">
        <div class="col-lg-12 col-md-12 col-sm-12">
          <div class="panel panel-default">
            <div class="panel-heading">
              <h3 class="panel-title"><i class="fa fa-globe"></i> Sales Rep Location Management</h3>
            </div>
            <div class="panel-body">
              <div id="map"></div>
              <div id="legend"></div>
                                <script async defer src="https://maps.googleapis.com/maps/api/js?key=AIzaSyA6ycZiGobIPuZ8wtXalf2m2MtxAzncn_Q&callback=initMap&sensor=false"> </script>
                                <script type="text/javascript">
								/*function initMap() { 
									var uluru = {lat: 29.8587, lng: 31.0218}; 
									var map = new google.maps.Map(document.getElementById('map'), { zoom: 4, center: uluru });
									var marker = new google.maps.Marker({ position: uluru, map: map }); 
								}*/
								
								
								
								function initMap() {

									var latlng = new google.maps.LatLng(-27.4457987, 21.4340156); // default location
									var myOptions = {
										zoom: 4,
										center: latlng,
										zoomControlOptions: true,
										 zoomControlOptions: {
										 style: google.maps.ZoomControlStyle.LARGE
										 },
										gestureHandling: 'greedy',
										mapTypeId: google.maps.MapTypeId.ROADMAP,
										mapTypeControl: true
									};
						
									var map = new google.maps.Map(document.getElementById('map'),myOptions);
									var infowindow = new google.maps.InfoWindow(), marker, lat, lng;
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
							
									map.controls[google.maps.ControlPosition.RIGHT_BOTTOM].push(legend);

									<?php foreach($locationsmaps as $key => $locationsmap ) { ?>
									
										<?php if($locationsmap['latitude'] != '' && $locationsmap['longitude'] != '' ) { ?>
											
											lat = '<?php echo $locationsmap['latitude']; ?>';
											lng = '<?php echo $locationsmap['longitude']; ?>';
											name = '<?php echo $locationsmap['name']; ?>';
							
											marker = new google.maps.Marker({
												position: new google.maps.LatLng(lat,lng),
												name:name,
												map: map,
												icon: '<?php echo $locationsmap['icon']; ?>'
											});
											
											bounds.extend(marker.position); 
											google.maps.event.addListener( marker, 'click', function(e){
												infowindow.setContent( this.name );
												infowindow.open( map, this );
											}.bind( marker ) );
											
											lat = '';
											lng = '';
											name = '';
							
											marker = new google.maps.Marker({
												position: new google.maps.LatLng(lat,lng),
												name:name,
												map: map,
												icon: ''
											}); 
											
									   <?php } ?>
									
									<?php }  ?>
									
									<?php if(!empty($locationsmap)) { ?>
										map.fitBounds(bounds);
									<?php } ?>
								}
								
								</script>
                                <style>
								#map { height: 400px; width: 100%; }
								#legend { font-family: Arial, sans-serif;background: #fff;border-radius: 5px;bottom:25px!important;right:100px!important; }
							    #legend div { background:#FFFFFF;float:left;margin:5px;padding:5px;font-size:13px; }
							    #legend img { vertical-align: middle; }
								</style>
            </div>
          </div>
          
        </div>
        
      </div>
      <div class="row" style="margin-bottom:27px;">
            <div class="col-sm-6">
              <div class="form-group">
                <label class="control-label" for="input-model">Appointment Date From</label>
                <div class='input-group date' id='filter_appointment_from'>
                    <input name="filter_appointment_from" type='text' value="<?php echo $filter_appointment_from; ?>"  placeholder="Date From" class="form-control" data-date-format="DD-MM-YYYY hh:mm A" class="form-control"  />
                    <span class="input-group-addon">
                        <span class="glyphicon glyphicon-calendar"></span>
                    </span>
                </div>
              </div>
              <script type="text/javascript">
            $(function () {
                $('#filter_appointment_from').datetimepicker({
                     //defaultDate: new Date(),
					// inline: true,
                });
            });
        </script>
            </div>
            <div class="col-sm-6" style="margin-bottom:10px;">
              <div class="form-group">
                <label class="control-label" for="input-quantity">Appointment Date To</label>
                <div class='input-group date' id='filter_appointment_to'>
                    <input name="filter_appointment_to" type='text' value="<?php echo $filter_appointment_to; ?>"  placeholder="Date To" class="form-control" data-date-format="DD-MM-YYYY hh:mm A" class="form-control"  />
                    <span class="input-group-addon">
                        <span class="glyphicon glyphicon-calendar"></span>
                    </span>
                </div>
            
        		<script type="text/javascript">
            $(function () {
                $('#filter_appointment_to').datetimepicker({
                    //defaultDate: new Date(),
                   
                });
            });
        </script>
              </div>
              
            </div>
            <button type="button" id="button-filter" class="btn btn-primary pull-right" style="margin-right:18px;"><i class="fa fa-filter"></i> Filter</button>
            <button type="button" id="button-filter-reset" class="btn btn-primary pull-right" style="margin-right:10px;"><i class="fa fa-refresh"></i> Reset</button>
          </div>
      <div class="row">
        <div class="col-lg-4 col-md-12 col-sm-12">
          
      <?php if($loginuser != 'Sales Manager' ) { ?>      
          <!--<div class="panel panel-default">
            <div class="panel-heading">
              <h3 class="panel-title"><i class="fa fa-calendar"></i> Recent Activity</h3>
            </div>
              <ul class="list-group">
                <?php if ($activities) { ?>
                <?php foreach ($activities as $activity) { ?>
                <li class="list-group-item"><?php echo $activity['comment']; ?><br />
                  <small class="text-muted"><i class="fa fa-clock-o"></i> <?php echo $activity['date_added']; ?></small></li>
                <?php } ?>
                <?php } else { ?>
                <li class="list-group-item text-center"><?php echo $text_no_results; ?></li>
                <?php } ?>
              </ul>
          </div>-->    
      <?php } else { ?>
      	<!--<div class="panel panel-default" style="border-right:5px solid;">
      	<div class="panel-heading">
          <h3 class="panel-title"><i class="fa fa-calendar"></i> Appointment Tasks</h3>
       	</div>
        <div class="table-responsive">
                <table class="table">
                  <thead>
                    <tr>
                        <td class="text-left">Tasks Name</td>
                        <td>Sales Rep Name</td>
                      </tr>
                  </thead>
                  <tbody>
                    <?php if ($tasks) { ?>
                    <?php foreach ($tasks as $task) { ?>
                    <tr>
                      <td class="text-left"><a href="<?php echo $task['link']; ?>"><?php echo $task['task_name']; ?></a></td>
                      <td ><?php echo $task['salesrep']; ?></td>
                      
                    </tr>
                    <?php } ?>
                    <?php } else { ?>
                    <tr>
                      <td class="text-center" colspan="6">No results!</td>
                    </tr>
                    <?php } ?>
                  </tbody>
                </table>
  		</div>
        </div>-->
      <?php } ?>
          
        </div>
        <?php if($loginuser != 'Sales Manager' ) { ?>   
        <div class="col-lg-12 col-md-12 col-sm-12">
        <?php } else { ?>
        <!--<div class="col-lg-8 col-md-12 col-sm-12">-->
        <div class="col-lg-12 col-md-12 col-sm-12">
        <?php } ?>
          <div class="panel panel-default">
  		     <div class="panel-heading">
                <h3 class="panel-title"><i class="fa fa-calendar"></i> Latest Appointment</h3>
                <h3 class="panel-title" style="float:right;"><a href="<?php echo $viewmoreappo; ?>" >View more...</a></h3>
              </div>
  		     <div class="table-responsive">
                <table class="table">
                  <thead>
                    <tr>
                        <td class="text-left">Appointment Name</td>
                        <td>Sales Rep Name</td>
                        <td>Appointment Date</td>
                        <td class="text-right">Action</td>
                      </tr>
                  </thead>
                  <tbody>
                    <?php if ($appointments) { ?>
                    <?php foreach ($appointments as $appointment) { ?>
                    <tr>
                      <td class="text-left"><?php echo $appointment['appointment_name']; ?></td>
                      <td ><?php echo $appointment['sales_manager']; ?></td>
                      <td ><?php  echo $appointment['appointment_date']; ?></td>
                      <td class="text-right"><a href="<?php echo $appointment['view']; ?>" data-toggle="tooltip" title="<?php echo $button_view; ?>" class="btn btn-info"><i class="fa fa-eye"></i></a></td>
                    </tr>
                    <?php } ?>
                    <?php } else { ?>
                    <tr>
                      <td class="text-center" colspan="6">No results!</td>
                    </tr>
                    <?php } ?>
                  </tbody>
                </table>
  </div>
		  </div>

        </div>
      </div>
    </div>
  </div>
  <script type="text/javascript"><!--
$('#button-filter').on('click', function() {
	var url = 'index.php?route=common/dashboard&token=<?php echo $token; ?>';

	var filter_appointment_name = $('input[name=\'filter_appointment_name\']').val();

	if (filter_appointment_name) {
		url += '&filter_appointment_name=' + encodeURIComponent(filter_appointment_name);
	}

	var filter_salesrep_id = $('select[name=\'filter_salesrep_id\']').val();

	if (filter_salesrep_id) {
		url += '&filter_salesrep_id=' + encodeURIComponent(filter_salesrep_id);
	}

	var filter_appointment_from = $('input[name=\'filter_appointment_from\']').val();

	if (filter_appointment_from) {
		url += '&filter_appointment_from=' + encodeURIComponent(filter_appointment_from);
	}
	
	var filter_appointment_to = $('input[name=\'filter_appointment_to\']').val();

	if (filter_appointment_to) {
		url += '&filter_appointment_to=' + encodeURIComponent(filter_appointment_to);
	}

	var filter_appointment_to = $('input[name=\'filter_appointment_to\']').val();
//alert(url);
	location = url;
});
$('#button-filter-reset').on('click', function() {
	var url = 'index.php?route=common/dashboard&token=<?php echo $token; ?>';

	location = url;
});
//--></script>

        <style>
		   .glyphicon-calendar:before {content: "\e109" !important; }
		   </style>
<?php echo $footer; ?>