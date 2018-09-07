<?=$header?><?=$column_left?>
  <div id="content" class="sales-dashboard-wrapper" data-page-id="sales_dashboard" data-token="<?php echo $token; ?>" data-page-url="<?php echo $page_url; ?>">

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
                    <td><span class="label label-<?=(strtolower($appointment['appointment_type'])=='new business')? 'default' : 'primary' ?>" style="font-size:14px;"><?=$appointment['appointment_type']?></span></td>
                    <td><?=$appointment['visit_date']?></td>
                    <td class="text-right">
                      <a href="<?=$appointment['view']?>" data-toggle="tooltip" title="<?=$appointment['customer_name']?>" class="btn btn-info"><i class="fa fa-eye"></i></a>
                    </td>
                  </tr>
                  <?php endforeach; ?>
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
              <div class="lm-map-container"><div class="lm-map" id="lm-map"></div></div>

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

  <!-- Page loader -->
  <div class="loader-wrapper">
    <div class="loader"></div>
  </div>
  <!-- /Page loader -->
<?=$footer?>