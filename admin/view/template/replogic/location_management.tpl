<?php echo $header; ?>
<?php echo $column_left; ?>
<div id="content" class="lm__wrapper" data-token="<?php echo $token; ?>">
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
        <div class="lm-filters">
            <form action="" name="lm-filters" class="form-inline" id="frm-lm-filters">
                <div class="row">
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="lmf-team">Team:</label>
                            <select id="lmf-team" name="teams" class="form-control">
                                <option value="">All Teams</option>
                                <?php if (!empty($teams)) : ?>
                                    <?php foreach($teams as $team) : ?>
                                    <option value="<?php echo $team['team_id']; ?>" <?php echo ($filter_team_id==$team['team_id']) ? 'selected' : ''; ?>>
                                        <?php echo $team['team_name']; ?>
                                    </option>
                                    <?php endforeach; ?>
                                <?php endif; ?>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="lmf-salesrep">Sales Rep:</label>
                            <select id="lmf-salesrep" name="salesreps" class="form-control">
                                <option value="">All Sales Reps</option>
                                <?php if (!empty($salesreps)) : ?>
                                    <?php foreach($salesreps as $salesrep) : ?>
                                    <option value="<?php echo $salesrep['salesrep_id']; ?>" <?php echo ($filter_salesrep_id==$salesrep['salesrep_id']) ? 'selected' : ''; ?>>
                                        <?php echo $salesrep['salesrep_name']; ?>
                                        <?php echo $salesrep['salesrep_lastname']; ?>
                                    </option>
                                    <?php endforeach; ?>
                                <?php endif; ?>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="row">
                            <div class="col-xs-6">
                                <div class="form-group">
                                    <div class="radio">
                                        <label for="lmf-existing-business">
                                            <input id="lmf-existing-business" class="lmf-type" name="type" type="radio" value="customer" <?php echo ($filter_type=="customer") ? 'checked' : ''; ?>>
                                            <span>Existing Business</span>
                                        </label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xs-6">
                                <div class="form-group">
                                    <div class="radio">
                                        <label for="lmf-new-business">
                                            <input id="lmf-new-business" class="lmf-type" name="type" value="prospect" type="radio" <?php echo ($filter_type=="prospect") ? 'checked' : ''; ?>>
                                            <span>New Business</span>
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="lmf-customer"><?php echo $select_customer_label; ?></label>
                            <select id="lmf-customer" name="customers" class="form-control">
                                <option value=""><?php echo $select_customer; ?></option>
                                <?php if (!empty($customers)) : ?>
                                    <?php foreach($customers as $customer) : ?>
                                    <option value="<?php echo $customer['customer_id']; ?>" <?php echo ($filter_customer_id==$customer['customer_id']) ? 'selected' : ''; ?>>
                                        <?php echo $customer['firstname']; ?>
                                    </option>
                                    <?php endforeach; ?>
                                <?php endif; ?>
                            </select>
                        </div>
                    </div>
                </div>
            </form>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="lm-wrapper">
                    <div class="lm-leftnav open">
                        <div class="lm-leftnav-header">
                            <h3>
                                <i class="fa fa-user"></i>
                                Sales Representatives
                            </h3>
                        </div>
                        <div class="lm-leftnav-list">
                            <ul>
                                <?php if (!empty($locations)) : ?>
                                    <?php foreach($locations as $location) : ?>
                                    <li data-checkin-id="<?php echo $location['checkin_id']; ?>" data-rep-id="<?php echo $location['salesrep_id']; ?>">
                                        <div class="lm-leftnav-list-item">
                                            <h4 class="rep__name">
                                                <i class="fa fa-user"></i>&nbsp;
                                                <?php echo $location['salesrep_name']; ?>
                                            </h4>
                                            <section class="lm__show_map-marker" data-marker-id="<?php echo $location['checkin_id']; ?>">
                                                <div class="row">
                                                    <div class="col-sm-4 col-xs-4">
                                                        <i class="fa fa-map-marker text-danger"></i>
                                                        &nbsp;
                                                        Location:
                                                    </div>
                                                    <div class="col-sm-7 col-xs-7 loc__current-address">
                                                        <?php echo $location['current_location']; ?>
                                                    </div>
                                                    <div class="col-sm-1 col-xs-1" data-toggle="footer">
                                                        <span>
                                                            <i class="fa"></i>
                                                        </span>
                                                    </div>
                                                </div>
                                            </section>
                                            <footer>
                                                <div class="row existing-business">
                                                    <div class="col-sm-4 col-xs-4">
                                                        <span class="loc__last-checkin">
                                                            <i class="material-icons">verified_user</i>
                                                            <span><?php echo $location['last_check']; ?></span>
                                                        </span>
                                                    </div>
                                                    <div class="col-sm-8 col-xs-8">
                                                        <div class="loc__checkin-address">
                                                            <?php echo $location['checkin_location']; ?>
                                                        </div>
                                                        <div class="loc__customer-name">
                                                            <i class="material-icons">domain</i>
                                                            <span><?php echo $location['customer_name']; ?></span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </footer>
                                        </div>
                                    </li>
                                    <?php endforeach; ?>
                                <?php endif; ?>
                            </ul>
                        </div>
                    </div>
                    <div class="lm-leftnav-toggle">
                        <i></i>
                    </div>
                    <div class="lm-map-container">
                        <div id="lm-map" data-></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="modalScheduleAppointment" tabindex="-1" role="dialog" aria-labelledby="modalScheduleAppointmentLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form id="form__schedule-appointment" action=" " method="post">
                <input type="hidden" name="customer_id">
                <input type="hidden" name="salesrep_id">
                <input type="hidden" id="input__salesrep_name">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="modalScheduleAppointmentLabel">Create Appointment</h4>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="form-group required">
                            <label class="col-sm-3 text-right" for="">Appointment Title:</label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control" name="appointment_title" required>
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
                        <div class="form-group">
                            <label class="col-sm-3 text-right" for="input__appointment_duration">Duration:</label>
                            <div class="col-sm-4">
                                <select class="form-control" name="appointment_duration" id="input__appointment_duration">
                                    <option value="0:00">0 minutes</option>
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
                                </select>
                            </div>
                            <div class="col-sm-5">
                                <div class="checkbox">
                                    <label>
                                        <input type="checkbox">
                                        All day
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group">
                            <label class="col-sm-3 text-right">Date:</label>
                            <div class="col-sm-4">
                                <div>
                                    <input type='text' name="appointment_date" id="input__appointment_date" class="form-control" value="<?php echo date('l, d F Y');?>" />
                                </div>
                            </div>
                            <label class="col-sm-2 text-right">Time:</label>
                            <div class="col-sm-3">
                                <div>
                                    <input type='text' name="appointment_time" id="input__appointment_time" class="form-control" value="<?php echo date('g:i A');?>" />
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group">
                            <label class="col-sm-3 text-right" for="">Description:</label>
                            <div class="col-sm-9">
                                <textarea class="form-control"></textarea>
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
                html += `<a href="#" data-toggle="appointment-modal" data-cname="${data.name}" data-cid="${data.id}" data-srname="${data.sr_name}" data-srid="${data.sr_id}">Schedule Appointment...</a></div>`;
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
<?php echo $footer; ?>