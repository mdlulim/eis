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
        
          <div class="row">
            <!--<div class="col-sm-3">
              <div class="form-group">
                <input type="text" name="filter_address" value="<?php echo $filter_address; ?>" placeholder="Search Address" id="input-address" class="form-control" style="border-radius:25px;" />
              </div>
            </div>-->
            <div class="col-sm-2">
              <div class="form-group">
                <select name="filter_salesrep_id" id="input-sales_manager" class="form-control">
                        <option value="">Select Sales Rep</option>
                        <?php foreach ($salesReps as $salesRep) { ?>
                        <?php if ($salesRep['salesrep_id'] == $filter_salesrep_id) { ?>
                        <option value="<?php echo $salesRep['salesrep_id']; ?>" selected="selected"><?php echo $salesRep['salesrep_name']; ?> <?php echo $salesRep['salesrep_lastname']; ?></option>
                        <?php } else { ?>
                        <option value="<?php echo $salesRep['salesrep_id']; ?>"><?php echo $salesRep['salesrep_name']; ?> <?php echo $salesRep['salesrep_lastname']; ?></option>
                        <?php } ?>
                        <?php } ?>
                      </select>
              </div>
            </div>
            <div class="col-sm-3">
              <div class="form-group">
                <select name="filter_team_id" id="input-team" class="form-control">
                        <option value="">Select Team</option>
                        <?php foreach ($teams as $team) {  ?>
                        <?php if ($team['team_id'] == $filter_team_id) { ?>
                        <option value="<?php echo $team['team_id']; ?>" selected="selected"><?php echo $team['team_name']; ?></option>
                        <?php } else { ?>
                        <option value="<?php echo $team['team_id']; ?>"><?php echo $team['team_name']; ?></option>
                        <?php } ?>
                        <?php } ?>
                      </select>
              </div>
            </div>
            <div class="col-sm-3">
              <div class="form-group">
                <select name="filter_customer_id" id="input-customer" class="form-control">
                        <option value="">Select Customer</option>
                        <?php foreach ($customers as $customer) { ?>
                        <?php if ($customer['customer_id'] == $filter_customer_id) { ?>
                        <option value="<?php echo $customer['customer_id']; ?>" selected="selected"><?php echo $customer['firstname']; ?> <?php echo $customer['lastname']; ?></option>
                        <?php } else { ?>
                        <option value="<?php echo $customer['customer_id']; ?>"><?php echo $customer['firstname']; ?> <?php echo $customer['lastname']; ?></option>
                        <?php } ?>
                        <?php } ?>
                      </select>
              </div>
            </div>
            <div class="col-sm-1">
              <div class="form-group">
                <button type="button" id="button-filter" class="btn btn-primary pull-right"><i class="fa fa-filter"></i> Filter</button>
              </div>
            </div>
            
            <div class="col-sm-1">
              <div class="form-group">
                <button type="button" id="button-filter-reset" class="btn btn-primary pull-right" style="margin-right:10px;"><i class="fa fa-filter"></i> Reset</button>
              </div>
            </div>
            
          </div>  
          
           
         
          <div class="table-responsive">
            <table class="table table-bordered table-hover">
              
              <tbody>
               <tr>
              		<td>
                    	<div id="map"></div>
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
									
									map.fitBounds(bounds);
								}
								
								</script>
                                <style>
								#map { height: 400px; width: 100%; }
								
								</style>
                    </td> 
               </tr>
              </tbody>
            </table>
          </div>
        
          <div class="table-responsive" style="margin-bottom:15px;" >
            <table class="table table-bordered table-hover" style="margin-bottom:0px !important;">
              <thead style="background-color:#CCCCCC;">
                <tr>
                  <td class="text-center" >Sales Rep Name</td>
                    <td class="text-left" ><?php if ($sort == 'name') { ?>
                    <a href="<?php echo $sort_name; ?>" class="<?php echo strtolower($order); ?>">Team</a>
                    <?php } else { ?>
                    <a href="<?php echo $sort_name; ?>">Team</a>
                    <?php } ?></td>
                  <td class="text-left" >Last Check</td>
                  <td class="text-left" ><?php if ($sort == 'name') { ?>
                    <a href="<?php echo $sort_name; ?>" class="<?php echo strtolower($order); ?>">Customer</a>
                    <?php } else { ?>
                    <a href="<?php echo $sort_name; ?>">Customer</a>
                    <?php } ?></td>
                  <td class="text-left"><?php if ($sort == 'name') { ?>
                    <a href="<?php echo $sort_name; ?>" class="<?php echo strtolower($order); ?>">Check In Location</a>
                    <?php } else { ?>
                    <a href="<?php echo $sort_name; ?>">Check In Location</a>
                    <?php } ?></td>  
                  
                  <td class="text-left" width="200">Current Location</td>
                </tr>
              </thead>
              <tbody>
                <?php if ($locations) { ?>
                    <?php foreach ($locations as $location) { ?>
                        
                            <tr>
                              <td class="text-center"><?php echo $location['sales_manager']; ?></td>
                              <td class="text-left"><?php echo $location['team']; ?></td>
                              <td class="text-left"><?php echo $location['last_check']; ?></td>
                              <td class="text-left"><?php  echo $location['customer']; ?></td>
                              <td class="text-left"><?php echo $location['checkin_location']; ?></td>
                              <td class="text-left" width="200"><?php  echo $location['current_location']; ?></td>
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
  
        <div class="row">
          <div class="col-sm-6 text-left"><?php echo $pagination; ?></div>
          <div class="col-sm-6 text-right"><?php echo $results; ?></div>
        </div>
      </div>
    </div>
  </div>
</div>
<script type="text/javascript"><!--
$('#button-filter').on('click', function() {
	var url = 'index.php?route=replogic/location_management&token=<?php echo $token; ?>';

	var filter_address = $('input[name=\'filter_address\']').val();

	if (filter_address) {
		url += '&filter_address=' + encodeURIComponent(filter_address);
	}

	var filter_salesrep_id = $('select[name=\'filter_salesrep_id\']').val();

	if (filter_salesrep_id) {
		url += '&filter_salesrep_id=' + encodeURIComponent(filter_salesrep_id);
	}
	
	var filter_customer_id = $('select[name=\'filter_customer_id\']').val();

	if (filter_customer_id) {
		url += '&filter_customer_id=' + encodeURIComponent(filter_customer_id);
	}
	
	var filter_team_id = $('select[name=\'filter_team_id\']').val();

	if (filter_team_id) {
		url += '&filter_team_id=' + encodeURIComponent(filter_team_id);
	}

	
//alert(url);
	location = url;
});
$('#button-filter-reset').on('click', function() {
	var url = 'index.php?route=replogic/location_management&token=<?php echo $token; ?>';

	location = url;
});
//--></script>
 

<?php echo $footer; ?> 