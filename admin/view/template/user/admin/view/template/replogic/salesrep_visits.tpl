<?php echo $header; ?>
<?php echo $column_left; ?>

<div id="content" class="lm__wrapper" data-page-id="salesrep_visit_info" data-token="<?php echo $token; ?>" data-salesrep-id="<?php echo $salesrep_id; ?>">
    <div class="page-header">
        <div class="container-fluid">
            <div class="pull-right">
                <a href="<?php echo $button_reload; ?>" data-toggle="tooltip" title="Refresh" id="button-reload" class="btn btn-primary">
                    <i class="fa fa-refresh"></i>
                </a>
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

        <!-- Warning messages -->
        <?php if ($error_warning) : ?>
        <div class="alert alert-danger"><i class="fa fa-exclamation-circle"></i> <?php echo $error_warning; ?>
            <button type="button" class="close" data-dismiss="alert">&times;</button>
        </div>
        <?php endif; ?>
        <?php if ($success) : ?>
        <div class="alert alert-success"><i class="fa fa-check-circle"></i> <?php echo $success; ?>
            <button type="button" class="close" data-dismiss="alert">&times;</button>
        </div>
        <?php endif; ?>
        <!-- /Warning messages -->

        <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title"><i class="fa fa-info-circle" style="font-size:23px;"></i> <?php echo $text_list; ?><strong><?php echo $salesrep_name; ?></strong></h3>
            </div>
            <div class="panel-body">
                <ul class="nav nav-tabs">
                    <li><a href="<?php echo $generaltab; ?>">General</a></li>
                    <li><a href="<?php echo $appointmenttab; ?>">Appointment</a></li>
                    <li><a href="<?php echo $customerstab; ?>">Customers</a></li>
                    <li class="active"><a href="javascript:void(0);">Visits</a></li>
                    <li><a href="<?php echo $orderstab; ?>">Orders</a></li>
                    <li><a href="<?php echo $quotestab; ?>">Quotes</a></li>
                </ul>

                <div class="row">
                    <div class="col-md-12">
                        <div class="lm-wrapper">
                            <div class="lm-leftnav open">
                                <div class="lm-leftnav-header">
                                    <div class="row">
                                        <div class="col-sm-3">
                                            <i class="fa fa-map-marker text-danger"></i>
                                            Location:
                                        </div>
                                        <div class="col-sm-9 bold" style="padding-top:4px">
                                            <?php echo $current_location['location']; ?>
                                        </div>
                                    </div>
                                </div>
                                <div class="lm-leftnav-filter">
                                    <form action="" name="filters" role="form" id="frm-filters">
                                        <div class="row">
                                            <div class="form-group">
                                                <label class="col-sm-3 text-right" for="srv__lmf-type">Type:</label>
                                                <div class="col-sm-9">
                                                    <select id="srv__lmf-type" name="type" class="form-control">
                                                        <option value="customer" <?php echo ($filter_type=="customer") ? 'selected' : ''; ?>>Existing Business</option>
                                                        <option value="prospect" <?php echo ($filter_type=="prospect") ? 'selected' : ''; ?>>New Business</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="form-group">
                                                <label class="col-sm-3 text-right" for="srv__lmf-customer"><?php echo $select_customer_label; ?></label>
                                                <div class="col-sm-9">
                                                    <select id="srv__lmf-customer" name="customers" class="form-control">
                                                        <option value=""><?php echo $select_customer; ?></option>
                                                        <?php if (!empty($customers)) :?>
                                                            <?php foreach($customers as $customer) :?>
                                                            <option value="<?php echo $customer['customer_id']; ?>" <?php echo ($filter_customer_id==$customer['customer_id']) ? 'selected' : ''; ?>>
                                                                <?php echo $customer['firstname']; ?>
                                                            </option>
                                                            <?php endforeach; ?>
                                                        <?php endif; ?>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="form-group">
                                                <label class="col-sm-3 text-right">Date:</label>
                                                <div class="col-sm-9">
                                                    <div>
                                                        <input type='text' id="input__filter_date" class="form-control" value="<?php echo $filter_date;?>" />
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                                <div class="lm-leftnav-vlist">
                                    <ul>
                                        <?php if (!empty($locations)) : ?>
                                            <?php foreach($locations as $location) : ?>
                                            <li class="<?php echo ($location['visit_type'] == 'New Business') ? 'new-business' : 'existing-business'; ?>" data-rep-id="<?php echo $location['salesrep_id']; ?>" data-marker-id="<?php echo $location['checkin_id']; ?>">
                                                <div class="vlist-item">
                                                    <div class="vlist-item-header">
                                                        <i class="material-icons">event</i>
                                                        <span><?php echo date('h:i A', strtotime($location['checkin'])); ?> &nbsp;&nbsp; <?php echo date('d F, Y', strtotime($location['checkin'])); ?></span>
                                                    </div>
                                                    <div class="vlist-item-body">
                                                        <div class="row">
                                                            <div class="col-xs-4">
                                                                <div class="loc__last-checkin">
                                                                    <i class="material-icons">beenhere</i>
                                                                    <span><?php echo $location['last_check']; ?></span>
                                                                </div>
                                                            </div>
                                                            <div class="col-xs-8">
                                                                <div class="loc__checkin-address">
                                                                <?php echo $location['checkin_location']; ?>
                                                            </div>
                                                            <div class="loc__customer-name">
                                                                <i class="material-icons">domain</i>
                                                                <span><?php echo $location['customer_name']; ?></span>
                                                            </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </li>
                                            <?php endforeach; ?>
                                        <?php else: ?>
                                        <p class="no-data-found">No results found for the specified filters</p>
                                        <?php endif; ?>
                                    </ul>
                                </div>
                            </div>
                            <div class="lm-leftnav-toggle">
                                <i></i>
                            </div>
                            <div class="lm-map-container">
                                <div id="lm-map"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
    </div>
</div>

<!-- Modal(s) -->
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
<?php
/* ====================================================================================
   DO NOT REMOVE CODE BELOW THIS LINE [ Google Map | JavaScript ]
   ==================================================================================== */
?>
<script>

    // store booked times into localStorage
    localStorage.setItem('booked_times', '<?php echo json_encode($booked_times); ?>');

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
        content.push('<div class="col__legend"><img src="view/image/gmap__checkin_icon.png" /> <?php echo $gmap_legend__checkin; ?></div>');
        content.push('<div class="col__legend"><img src="view/image/gmap__location_icon.png" /> <?php echo $gmap_legend__location; ?></div>');
        content.push('<div class="col__legend"><img src="view/image/gmap__customer_icon.png" /> <?php echo $gmap_legend__customer; ?></div>');
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
        <?php if (!empty($markers_salesreps)) : ?>
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
                    id              : '<?php echo $marker_checkin['id']?>',
                    lat             : '<?php echo $marker_checkin['latitude']?>',
                    lng             : '<?php echo $marker_checkin['longitude']?>',
                    name            : '<?php echo $marker_checkin['name']?>',
                    customer        : '<?php echo $marker_checkin['customer']?>',
                    customer_address: '<?php echo $marker_checkin['customer_address']?>',
                    address         : '<?php echo $marker_checkin['address']?>',
                    gps_address     : '<?php echo $marker_checkin['gps_address']?>',
                    last_seen       : '<?php echo $marker_checkin['last_seen']; ?>',
                    visit_date      : '<?php echo $marker_checkin['visit_date']; ?>',
                    visit_time      : '<?php echo $marker_checkin['visit_time']; ?>',
                    icon            : '<?php echo $marker_checkin['icon']; ?>'
                }
                createMarker(obj, "checkin");
            <?php endforeach; ?>
        <?php endif; ?>
        // </use:php>

        locationSelected = $(".lm-leftnav-vlist>ul>li");
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
</script>
<script async defer src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCxPjLdmrrKDJKWM58YgvjEyRB6al2ASW0&callback=initMap"></script>

<?php
/* ====================================================================================
   DO NOT REMOVE CODE ABOVE THIS LINE [ Google Map | JavaScript ]
   ==================================================================================== */
?>

<?php echo $footer; ?> 