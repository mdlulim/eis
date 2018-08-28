<?php echo $header; ?><?php echo $column_left; ?>

<div id="content">
  <div class="page-header">
    <div class="container-fluid">
    	<?php if($deletebutton) { ?>
        <div class="pull-right">
        	<button type="button" data-toggle="tooltip" title="<?php echo $button_delete; ?>" id="button-delete" class="btn btn-danger" onclick="confirm('<?php echo $text_confirm; ?>') ? $('#form-user').submit() : false;"><i class="fa fa-trash-o"></i></button>
      	</div>
       <?php } ?>
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
        <h3 class="panel-title"><i class="fa fa-globe"></i> <?php //echo $text_list; ?>Sales rep Location Management</h3>
      </div>
      <div class="panel-body">
        
            <div class="well">
            	<h3>Filters</h3>
          		<div class="row">
            <!--<div class="col-sm-3">
              <div class="form-group">
                <input type="text" name="filter_address" value="<?php echo $filter_address; ?>" placeholder="Search Address" id="input-address" class="form-control" style="border-radius:25px;" />
              </div>
            </div>-->
  <?php if($filtersales == 'yes') { ?>          
            <div class="col-sm-6">
              <div class="form-group">
              	<label class="control-label" for="input-price">Team Name</label>
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
              <div class="form-group">
              	<label class="control-label" for="input-price">Sales Rep Name</label>
                <select name="filter_salesrep_id" id="input-sales_manager" class="form-control">
                      		<option value="">Select Sales Rep</option> 
                           <?php if($salesReps) { ?>
                            <?php foreach ($salesReps as $salesRep) { ?>
                                <?php if ($salesRep['salesrep_id'] == $filter_salesrep_id) { ?>
                                <option value="<?php echo $salesRep['salesrep_id']; ?>" selected="selected"><?php echo $salesRep['salesrep_name']; ?> <?php echo $salesRep['salesrep_lastname']; ?></option>
                                <?php } else { ?>
                                <option value="<?php echo $salesRep['salesrep_id']; ?>"><?php echo $salesRep['salesrep_name']; ?> <?php echo $salesRep['salesrep_lastname']; ?></option>
                                <?php } ?>
                            <?php } ?>
                          <?php } ?>
                         
                      </select>
              </div>
            </div>
            
            <div class="col-sm-6">
              <div class="form-group">
              	<label class="control-label" for="input-price">Customer Name</label>
                <select name="filter_customer_id" id="input-customer" class="form-control">
                        <option value="">Select Customer</option>
                       	<?php if($customers) { ?>
                            <?php foreach ($customers as $customer) { ?>
                            <?php if ($customer['customer_id'] == $filter_customer_id) { ?>
                            <option value="<?php echo $customer['customer_id']; ?>" selected="selected"><?php echo $customer['firstname']; ?></option>
                            <?php } else { ?>
                            <option value="<?php echo $customer['customer_id']; ?>"><?php echo $customer['firstname']; ?></option>
                            <?php } ?>
                            <?php } ?>
                        <?php } else { ?>
                        
                        	<option value="">Not Found</option>
                        <?php } ?>
                      </select>
              </div>
              <div class="form-group">
                
                <button type="button" id="button-filter" class="btn btn-primary" style="float:left;"><i class="fa fa-search"></i> Search</button>
                <button type="button" id="button-locate-all" class="btn btn-primary" style="float:left;margin-left:12px;" title="Select the sales reps you wish to locate from the table below and click on the Locate selected button."><i class="fa fa-filter"></i>Locate Selected</button>
                <label class="col-sm-2 control-label" for="input-voucher-min" style="float:left;padding-left:0px;top:-3px;"><span data-toggle="tooltip" title="Select the sales reps you wish to locate from the table below and click on the Locate selected button." style="font-size:27px;"></span></label>
                <input type="hidden" id="checkin_id" name="checkin_id" value=""  />
                
              </div>
            </div>
            
            <script type="text/javascript"><!--
$('select[name=\'filter_team_id\']').on('change', function() {
	$.ajax({ 
		url: 'index.php?route=replogic/location_management/GetSalesRep&token=<?php echo $token; ?>&team_id=' + this.value,
		dataType: 'json',
		beforeSend: function() {
			$('select[name=\'filter_team_id\']').after(' <i class="fa fa-circle-o-notch fa-spin"></i>');
		},
		complete: function() {
			$('.fa-spin').remove();
		},
		success: function(json) {
			
			html = '<option value="">Select Sales Rep</option>';
			
			if (json && json != '') {
				for (i = 0; i < json.length; i++) {
					html += '<option value="' + json[i]['salesrep_id'] + '"';

					html += '>' + json[i]['name'] + '</option>';
				}
			} else {
				html += '<option value="0" selected="selected">Not Found</option>';
			}

			$('select[name=\'filter_salesrep_id\']').html(html);
			
			html1 = '<option value="">Select Customer</option>';
			$('select[name=\'filter_customer_id\']').html(html1);
		},
		error: function(xhr, ajaxOptions, thrownError) {
			alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
		}
	});
});
//$('select[name=\'filter_team_id\']').trigger('change');
//--></script>

			<script type="text/javascript"><!--
$('select[name=\'filter_salesrep_id\']').on('change', function() {
	$.ajax({ 
		url: 'index.php?route=replogic/location_management/GetCustomerBySalesrep&token=<?php echo $token; ?>&salesrep_id=' + this.value,
		dataType: 'json',
		beforeSend: function() {
			$('select[name=\'filter_salesrep_id\']').after(' <i class="fa fa-circle-o-notch fa-spin"></i>');
		},
		complete: function() {
			$('.fa-spin').remove();
		},
		success: function(json) {
			
			html = '<option value="">Select Customer</option>';
			
			if (json && json != '') {
				for (i = 0; i < json.length; i++) {
					html += '<option value="' + json[i]['customer_id'] + '"';

					html += '>' + json[i]['name'] + '</option>';
				}
			} else {
				html += '<option value="" selected="selected">Not Found</option>';
			}

			$('select[name=\'filter_customer_id\']').html(html);
			
		},
		error: function(xhr, ajaxOptions, thrownError) {
			alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
		}
	});
});
//$('select[name=\'filter_team_id\']').trigger('change');
//--></script>
<script type="text/javascript"><!--
$('#button-filter').on('click', function() {
	var url = 'index.php?route=replogic/location_management&token=<?php echo $token; ?>';

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
//--></script>
            
   <?php } else { ?>
   			<div class="col-sm-6">
              <div class="form-group">
              	<label class="control-label" for="input-price">Team Name</label>
                <input type="text" name="filter_teamname" value="<?php echo $filter_teamname; ?>" placeholder="Team Name" id="input-name" class="form-control" />
                <input type="hidden" name="filter_team_id" value="<?php echo $filter_team_id; ?>" />
                <!--<select name="filter_team_id" id="input-team" class="form-control">
                        <option value="">Select Team</option>
                        <?php foreach ($teams as $team) {  ?>
                        <?php if ($team['team_id'] == $filter_team_id) { ?>
                        <option value="<?php echo $team['team_id']; ?>" selected="selected"><?php echo $team['team_name']; ?></option>
                        <?php } else { ?>
                        <option value="<?php echo $team['team_id']; ?>"><?php echo $team['team_name']; ?></option>
                        <?php } ?>
                        <?php } ?>
                      </select>-->
              </div>
              <div class="form-group">
              	<label class="control-label" for="input-price">Sales Rep Name</label>
                <input type="text" name="filter_salesrep" value="<?php echo $filter_salesrep; ?>" placeholder="Sales Rep Name" id="input-salesrep" class="form-control" />
                <input type="hidden" name="filter_salesrep_id" value="<?php echo $filter_salesrep_id; ?>" />
                <!--<select name="filter_salesrep_id" id="input-sales_manager" class="form-control">
                      		<option value="">Select Sales Rep</option> 
                           <?php if($salesReps) { ?>
                            <?php foreach ($salesReps as $salesRep) { ?>
                                <?php if ($salesRep['salesrep_id'] == $filter_salesrep_id) { ?>
                                <option value="<?php echo $salesRep['salesrep_id']; ?>" selected="selected"><?php echo $salesRep['salesrep_name']; ?> <?php echo $salesRep['salesrep_lastname']; ?></option>
                                <?php } else { ?>
                                <option value="<?php echo $salesRep['salesrep_id']; ?>"><?php echo $salesRep['salesrep_name']; ?> <?php echo $salesRep['salesrep_lastname']; ?></option>
                                <?php } ?>
                            <?php } ?>
                          <?php } ?>
                         
                      </select>-->
              </div>
            </div>
            
            <div class="col-sm-6">
              <div class="form-group">
              	<label class="control-label" for="input-price">Customer Name</label>
                 <input type="text" name="filter_customer" value="<?php echo $filter_customer; ?>" placeholder="Customer Name" id="input-customer" class="form-control" />
   				 <input type="hidden" name="filter_customer_id" value="<?php echo $filter_customer_id; ?>" id="customer_id">
                <!--<select name="filter_customer_id" id="input-customer" class="form-control">
                        <option value="">Select Customer</option>
                       	<?php if($customers) { ?>
                            <?php foreach ($customers as $customer) { ?>
                            <?php if ($customer['customer_id'] == $filter_customer_id) { ?>
                            <option value="<?php echo $customer['customer_id']; ?>" selected="selected"><?php echo $customer['firstname']; ?></option>
                            <?php } else { ?>
                            <option value="<?php echo $customer['customer_id']; ?>"><?php echo $customer['firstname']; ?></option>
                            <?php } ?>
                            <?php } ?>
                        <?php } else { ?>
                        
                        	<option value="">Not Found</option>
                        <?php } ?>
                      </select>-->
              </div>
              <div class="form-group">
                
                <button type="button" id="button-filter" class="btn btn-primary" style="float:left;margin-top:23px;"><i class="fa fa-search"></i> Search</button>
                <button type="button" id="button-locate-all" class="btn btn-primary" style="float:left;margin-left:12px;margin-top:23px;" title="Select the sales reps you wish to locate from the table below and click on the Locate selected button."><i class="fa fa-filter"></i>Locate Selected</button>
                <label class="col-sm-2 control-label" for="input-voucher-min" style="float:left;padding-left:0px;top:-3px;margin-top:23px;"><span data-toggle="tooltip" title="Select the sales reps you wish to locate from the table below and click on the Locate selected button." style="font-size:27px;"></span></label>
                <input type="hidden" id="checkin_id" name="checkin_id" value=""  />
                
              </div>
            </div>
 <script type="text/javascript"><!--
$('#button-filter').on('click', function() {
	var url = 'index.php?route=replogic/location_management&token=<?php echo $token; ?>';

	var filter_salesrep_id = $('input[name=\'filter_salesrep_id\']').val();

	if (filter_salesrep_id) {
		url += '&filter_salesrep_id=' + encodeURIComponent(filter_salesrep_id);
	}
	
	var filter_customer_id = $('input[name=\'filter_customer_id\']').val();

	if (filter_customer_id) {
		url += '&filter_customer_id=' + encodeURIComponent(filter_customer_id);
	}
	
	var filter_team_id = $('input[name=\'filter_team_id\']').val();

	if (filter_team_id) {
		url += '&filter_team_id=' + encodeURIComponent(filter_team_id);
	}

	
//alert(url);
	location = url;
});
//--></script>           
<script type="text/javascript"><!--
$('input[name=\'filter_teamname\']').autocomplete({
	'source': function(request, response) {
		$.ajax({
			url: 'index.php?route=user/team/autocomplete&token=<?php echo $token; ?>&filter_name=' +  encodeURIComponent(request),
			dataType: 'json',
			success: function(json) {
				response($.map(json, function(item) {
					return {
						label: item['name'],
						value: item['team_id']
					}
				}));
			}
		});
	},
	'select': function(item) {
		$('input[name=\'filter_teamname\']').val(item['label']);
		$('input[name=\'filter_team_id\']').val(item['value']);
	}
});
$('input[name=\'filter_salesrep\']').autocomplete({
	'source': function(request, response) {
		$.ajax({
			url: 'index.php?route=replogic/sales_rep_management/autocomplete&token=<?php echo $token; ?>&filter_name=' +  encodeURIComponent(request),
			dataType: 'json',
			success: function(json) {
				response($.map(json, function(item) {
					return {
						label: item['name'],
						value: item['salesrep_id']
					}
				}));
			}
		});
	},
	'select': function(item) {
		$('input[name=\'filter_salesrep\']').val(item['label']);
		$('input[name=\'filter_salesrep_id\']').val(item['value']);
	}
});
$('input[name=\'filter_customer\']').autocomplete({
	'source': function(request, response) {
		$.ajax({
			url: 'index.php?route=customer/customer/autocomplete&token=<?php echo $token; ?>&filter_name=' +  encodeURIComponent(request),
			dataType: 'json',
			success: function(json) {
				response($.map(json, function(item) {
					return {
						label: item['name'],
						value: item['customer_id']
					}
				}));
			}
		});
	},
	'select': function(item) {
		$('input[name=\'filter_customer\']').val(item['label']);
		$('input[name=\'filter_customer_id\']').val(item['value']);
	}
});
//--></script>
            
   <?php } ?>
            </div>
              
         	</div>
           
          <div class="table-responsive">
            <table class="table table-bordered table-hover">
              
              <tbody>
               <tr>
              		<td>
                    	<div id="map"></div>
                        <div id="legend"></div>
                        
                                <!--<script async defer src="https://maps.googleapis.com/maps/api/js?key=AIzaSyA6ycZiGobIPuZ8wtXalf2m2MtxAzncn_Q&callback=initMap&sensor=false"> </script>-->
                                <script async defer src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCxPjLdmrrKDJKWM58YgvjEyRB6al2ASW0"></script>  
                                <script type="text/javascript">
								
								
								$(window).load(function(){
								 	initMap();
								 });
								 
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
									
									<?php if(!empty($locationsmaps)) { ?>
										map.fitBounds(bounds);
									<?php } ?>
								}
								
								</script>
                                <style>
								#map { height: 400px; width: 100%; }
								#map-canvas { height: 400px;width: 100%; }
								#legend { font-family: Arial, sans-serif;background: #fff;border-radius: 5px;bottom:25px!important;right:100px!important; }
							    #legend div { background:#FFFFFF;float:left;margin:5px;padding:5px;font-size:13px; }
							    #legend img { vertical-align: middle; }

								</style>
                    </td> 
               </tr>
              </tbody>
            </table>
          </div>
          
          <form action="<?php echo $delete; ?>" method="post" enctype="multipart/form-data" id="form-user">  
          <div class="table-responsive" style="margin-bottom:15px;" >
            <table class="table table-bordered table-hover" style="margin-bottom:0px !important;">
              <thead>
                <tr>
                  <td style="width: 1px;" class="text-center"><input type="checkbox" onclick="$('input[name*=\'selected\']').prop('checked', this.checked);" id="chkbx" /></td>
                  <td class="text-center" width="200">Sales Rep Name</td>
                    <td class="text-left" width="200"><?php if ($sort == 'name') { ?>
                    <a href="<?php echo $sort_name; ?>" class="<?php echo strtolower($order); ?>">Team</a>
                    <?php } else { ?>
                    <a href="<?php echo $sort_name; ?>">Team</a>
                    <?php } ?></td>
                  <td class="text-left" width="200">Last Check In</td>
                  <td class="text-left" width="200"><?php if ($sort == 'name') { ?>
                    <a href="<?php echo $sort_name; ?>" class="<?php echo strtolower($order); ?>">Customer Name</a>
                    <?php } else { ?>
                    <a href="<?php echo $sort_name; ?>">Customer Name</a>
                    <?php } ?></td>
                  <td class="text-left" width="215"><?php if ($sort == 'name') { ?>
                    <a href="<?php echo $sort_name; ?>" class="<?php echo strtolower($order); ?>">Self Reported Location</a>
                    <?php } else { ?>
                    <a href="<?php echo $sort_name; ?>">Self Reported Location</a>
                    <?php } ?></td>  
                  
                  <td class="text-left" width="200">GPS Check In Location</td>
                </tr>
              </thead>
              <tbody>
                <?php if ($locations) { ?>
                    <?php foreach ($locations as $location) { ?>
                        
                            <tr>
                              <td class="text-center"><?php if (in_array($location['checkin_id'], $selected)) { ?>
                                <input type="checkbox" name="selected[]" value="<?php echo $location['checkin_id']; ?>" checked="checked" />
                                <?php } else { ?>
                                <input type="checkbox" name="selected[]" value="<?php echo $location['checkin_id']; ?>" />
                                <?php } ?></td>
                              <td class="text-center" width="200"><?php echo $location['sales_manager']; ?></td>
                              <td class="text-left" width="200"><?php echo $location['team']; ?></td>
                              <td class="text-left" width="200"><?php echo $location['last_check']; ?></td>
                              <td class="text-left" width="200"><?php  echo $location['customer']; ?></td>
                              <td class="text-left" width="200"><?php  echo $location['current_location']; ?></td>
                              <td class="text-left" width="200"><?php echo $location['checkin_location']; ?></td>
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
          </form>
  
        <div class="row">
          <div class="col-sm-6 text-left"><?php echo $pagination; ?></div>
          <div class="col-sm-6 text-right"><?php echo $results; ?></div>
        </div>
      </div>
    </div>
  </div>
</div>
<div class="modal fade" id="popupmyModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <h4 class="modal-title" id="myModalLabel">Sales Rep Location</h4>
          </div>
          <div class="modal-body">
              <div style="margin-bottom:10px;"><b>GPS Check in location of selected sales representatives</b></div>
              <div id="map-canvas"></div>
          </div>
          <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
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


//--></script>

<script type="text/javascript"><!--
$('input[name^=\'selected\']').on('change', function() { 
	
	var selected = $('input[name^=\'selected\']:checked');
	
	if (selected.length) 
	{
		$('#button-locate-all').prop('disabled', false);
		
	}
	else
	{
		$('#button-locate-all').prop('disabled', true);
		
	}
	
});
$('#button-locate-all').prop('disabled', true);
$('#chkbx').on('click', function() { 
        if (this.checked == true)
            $('#button-locate-all').prop('disabled', false);
        else
            $('#button-locate-all').prop('disabled', true);
    });
//--></script>
  
<script type="text/javascript">
 
 // $('#button-locate-all').on('click', function () { 
 $(document).on('click', '#button-locate-all', function (e) {
  		  e.preventDefault();
		  $('#map-canvas').empty();
          $('#popupmyModal').modal('show');
      });
 
  $('#popupmyModal').on('shown.bs.modal', function () {
        
		var array = $.map($('input[name="selected[]"]:checked'), function(c){return c.value; })
		  $('#checkin_id').val(array);
		
		  $.ajax({
              url: 'index.php?route=replogic/location_management/Popupmap&token=<?php echo $token; ?>',
		  	  type: 'post',
		  	  data: $('#checkin_id'),
		  	  dataType: 'json',
              success: function (responce) {
                 
                      var data = responce;
                      var locations = [];
                      // validation: remove any null values to prevent map errors
                      for (var i=0; i<data.length; i++) { 
                          if (data[i].latitude != null && data[i].latitude != "null" && data[i].longitude != null && data[i].longitude != "null") {
                              locations.push({latitude: data[i].latitude, longitude: data[i].longitude, name: data[i].name, icon: data[i].icon, chkaddress: data[i].chkaddress});
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

          var marker, i;

          // loop through locations and create markers for the map
          for (i = 0; i < locations.length; i++) { 
              
			  var addrname = locations[i].chkaddress+' (' + locations[i].name + ' )';
			  //alert(addrname);
			  marker = new google.maps.Marker({
                  position: new google.maps.LatLng(locations[i].latitude, locations[i].longitude),
				  name:addrname,
                  map: map,
				  icon: locations[i].icon
              });
              google.maps.event.addListener(marker, 'click', (function(marker, i) {
                  return function() {
                      infowindow.setContent(addrname);
                      infowindow.open(map, marker);
                  }
              })(marker, i));
          }
      };
  
</script>
<script type="text/javascript"><!--
$('input[name^=\'selected\']').on('change', function() { 
	
	var selected = $('input[name^=\'selected\']:checked');

	if (selected.length) {
		$('#button-delete').prop('disabled', false);
	}
	else
	{
		$('#button-delete').prop('disabled', true);
	}

});
$('#button-delete').prop('disabled', true);
$('input[name^=\'selected\']:first').trigger('change');
$('input:checkbox').change(function () {
   var selected = $('input[name^=\'selected\']:checked');

	if (selected.length) {
		$('#button-delete').prop('disabled', false);
	}
	else
	{
		$('#button-delete').prop('disabled', true);
	}
})
//--></script> 
<?php echo $footer; ?> 
