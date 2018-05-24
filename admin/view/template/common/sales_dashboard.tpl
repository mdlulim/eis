<?=$header?><?=$column_left?>
  <div id="content" class="sales-dashboard-wrapper">

    <div class="page-header">
      <div class="container-fluid">
        <div class="row">
          <div class="col-lg-12">
            <h1>Sales Management</h1>
            <div class="dropdown pull-right">
              <button class="btn btn-primary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <i class="fa fa-plus"></i>&nbsp;
                Quick Actions
              </button>
              <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                <a class="dropdown-item" href="<?=$add_appointment_link?>">Create Appointment</a>
                <a class="dropdown-item" href="<?=$add_salesrep_link?>">Add Sales Rep</a>
                <a class="dropdown-item" href="<?=$add_customer_link?>">New Customer</a>
              </div>
            </div>
          </div>
        </div>

        <div class="row" style="margin-bottom: 15px">
          <div class="col-lg-12 time-frame">
            <form action="<?=$filter_form_action?>">
              <label>Time frame:</label>
              <select name="filter_time_frame" id="filter_time_frame" class="form-control">
                <option value="day" <?=$day_selected?>>Day</option>
                <option value="week" <?=$week_selected?>>Week</option>
                <option value="month" <?=$month_selected?>>Month</option>
                <option value="year" <?=$year_selected?>>Year</option>
                <option value="custom" <?=$custom_selected?>>Custom</option>
              </select>
              <div class="tf-no-range" <?=$tf_no_range?>>
                <a href="<?=$filter_prev_link?>" class="btn btn-default" >
                  <i class="fa fa-chevron-left"></i>
                </a>
                <a href="<?=$filter_next_link?>" class="btn btn-default <?=$allow_next_click?>">
                  <i class="fa fa-chevron-right"></i>
                </a>
                <span class="display"><?=$filter_display?></span>
              </div>
              <div class="tf-range" <?=$tf_range?>>
                <span class="tf-from">from</span>
                <input type="text" class="form-control date-picker filter-range-from" id="filter-range-from" value="<?=$filter_date_from?>" />
                <span class="tf-to">to</span>
                <input type="text" class="form-control date-picker filter-range-to" id="filter-range-to" value="<?=$filter_date_to?>" />
                <a href="#" class="btn btn-default" id="btn-custom-filter">
                  <i class="fa fa-search"></i>
                </a>
              </div>
            </form>
          </div>
        </div>

      </div>
    </div>

    <div class="container-fluid">
      <div class="row">

        <div class="col-lg-3 col-md-6 col-sm-6 col-xs-12">
          <div class="tile tile-primary">
              <div class="tile-body">
                <div class="row">
                  <div class="col-xs-3">
                    <i class="fa fa-shopping-cart"></i>
                  </div>
                  <div class="col-xs-9">
                    <h2><?=$total_orders?></h2>
                    <span>TOTAL ORDERS</span>
                  </div>
                </div>
              </div>
              <div class="tile-footer">
                <a href="<?=$order_view_more?>">View more...</a>
              </div>
            </div>
        </div>

        <div class="col-lg-3 col-md-6 col-sm-6 col-xs-12">
          <div class="tile tile-success">
              <div class="tile-body">
                <div class="row">
                  <div class="col-xs-3">
                    <i class="fa fa-line-chart"></i>
                  </div>
                  <div class="col-xs-9">
                    <h2><?=$tr_currency?> <?=$total_revenue?></h2>
                    <span>TOTAL REVENUE</span>
                  </div>
                </div>
              </div>
              <div class="tile-footer">
                <a href="<?=$order_view_more?>">View more...</a>
              </div>
          </div>
        </div>

        <div class="col-lg-3 col-md-6 col-sm-6 col-xs-12">
          <div class="tile tile-warning">
            <div class="tile-body">
              <div class="row">
                <div class="col-xs-3">
                  <i class="fa fa-file-text-o"></i>
                </div>
                <div class="col-xs-9">
                  <h2><?=$total_quotes?></h2>
                  <span>TOTAL QUOTES</span>
                </div>
              </div>
            </div>
            <div class="tile-footer">
              <a href="<?=$quotes_view_more?>">View more...</a>
            </div>
          </div>
        </div>

        <div class="col-lg-3 col-md-6 col-sm-6 col-xs-12">
          <div class="tile <?=$unapproved_quotes_tile?>">
            <div class="tile-body">
              <div class="row">
                <div class="col-xs-3">
                  <i class="fa fa-hourglass-half"></i>
                </div>
                <div class="col-xs-9">
                  <h2><?=$unapproved_quotes?></h2>
                  <span>QUOTES AWAITING APPROVAL</span>
                </div>
              </div>
            </div>
            <div class="tile-footer">
              <a href="<?=$unapproved_quotes_view_more?>">View more...</a>
            </div>
          </div>
        </div>
      </div>

      <div class="row">
        <div class="col-lg-12">
          <div class="panel panel-default">
            <div class="panel-heading">
              <h3 class="panel-title"><i class="fa fa-calendar"></i> Latest Appointments</h3>
              <h3 class="panel-title" style="float:right;">
                <a href="<?=$appointment_view_more?>" >View more...</a>
              </h3>
            </div>
            <div class="table-responsive">
              <table class="table" id="latestAppointmentsTbl">
                <thead>
                  <tr>
                    <th>Customer</th>
                    <th>Sales Rep</th>
                    <th>Appointment Date</th>
                    <th>Appointment Type</th>
                    <th>Visit Date</th>
                    <th class="text-right">Action</th>
                  </tr>
                </thead>
                <tbody>
                  <?php if ($appointments) : ?>
                  <?php foreach ($appointments as $appointment) : ?>
                  <tr>
                    <td><?=$appointment['customer_name']?></td>
                    <td><?=$appointment['salesrep_name']?></td>
                    <td><?=$appointment['appointment_date']?></td>
                    <td><span class="label label-<?=(strtolower($appointment['appointment_type'])=='new business')? 'default' : 'primary' ?>"><?=$appointment['appointment_type']?></span></td>
                    <td><?=$appointment['visit_date']?></td>
                    <td class="text-right">
                      <a href="<?=$appointment['view']?>" data-toggle="tooltip" title="<?=$appointment['customer_name']?>" class="btn btn-info"><i class="fa fa-eye"></i></a>
                    </td>
                  </tr>
                  <?php endforeach; ?>
                  <?php else : ?>
                  <tr><td class="text-center" colspan="6">No results!</td></tr>
                  <?php endif; ?>
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>

      <div class="row">
        <div class="col-lg-12 col-md-12 col-sm-12">
          <div class="panel panel-default">
            <div class="panel-heading">
              <h3 class="panel-title"><i class="fa fa-globe"></i> Sales Rep Location Management</h3>
              <h3 class="panel-title" style="float:right;">
                <a href="<?=$location_view_more?>" >View more...</a>
              </h3>
            </div>
            <div class="panel-body">
              <div id="map"></div>
              <script async defer src="https://maps.googleapis.com/maps/api/js?key=AIzaSyA6ycZiGobIPuZ8wtXalf2m2MtxAzncn_Q&callback=initMap&sensor=false"></script>
              <script type="text/javascript">
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
									
									
									<?php foreach($locations_map as $key => $location) : ?>
									
										<?php if($location['latitude'] != '' && $location['longitude'] != '' ) : ?>
											
											lat = '<?=$location['latitude']?>';
											lng = '<?=$location['longitude']?>';
											name = '<?=$location['name']?>';
							
											marker = new google.maps.Marker({
												position: new google.maps.LatLng(lat,lng),
												name:name,
												map: map,
												icon: '<?=$location['icon']?>'
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
											
									   <?php endif; ?>
									
									<?php endforeach;  ?>
									
									<?php if(!empty($locations_map)) : ?>
										map.fitBounds(bounds);
									<?php endif; ?>
								}
							</script>
              <style>
							  #map { height: 400px; width: 100%; }
							</style>
            </div>
          </div>
          
        </div>
      </div>

    </div>
  </div>
  <!-- Modal(s) -->
  <div class="modal fade" id="modalPromptChangePassword" tabindex="-1" role="dialog" aria-labelledby="modalPromptChangePasswordLabel">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          <h4 class="modal-title" id="modalPromptChangePasswordLabel">Change Password</h4>
        </div>
        <div class="modal-body">
            Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod
            tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,
            quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo
            consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse
            cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non
            proident, sunt in culpa qui officia deserunt mollit anim id est laborum.
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
        </div>
      </div>
    </div>
  </div>
  <!-- /Modal(s) -->

  <!-- Page loader -->
  <div class="loader-wrapper">
    <div class="loader"></div>
  </div>
  <!-- /Page loader -->
<?=$footer?>