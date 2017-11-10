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
      <div class="row" style="margin-bottom:27px;">
            <div class="col-sm-6">
              <div class="form-group">
                <label class="control-label" for="input-model">Appointment Date From</label>
                <div class='input-group date' id='filter_appointment_from'>
                    <input name="filter_appointment_from" type='text' value="<?php echo $filter_appointment_from; ?>"  placeholder="DD-MM-YYYY hh:mm A" class="form-control" data-date-format="DD-MM-YYYY hh:mm A" class="form-control"  />
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
                    <input name="filter_appointment_to" type='text' value="<?php echo $filter_appointment_to; ?>"  placeholder="DD-MM-YYYY hh:mm A" class="form-control" data-date-format="DD-MM-YYYY hh:mm A" class="form-control"  />
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
            <button type="button" id="button-filter-reset" class="btn btn-primary pull-right" style="margin-right:10px;"><i class="fa fa-filter"></i> Reset</button>
          </div>
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
      </div>
      <div class="row">
        <div class="col-lg-6 col-md-12 col-sm-12">
          <div class="panel panel-default">
            <div class="panel-heading">
              <h3 class="panel-title"><i class="fa fa-globe"></i> World Map</h3>
            </div>
            <div class="panel-body">
              <div id="vmap" style="width: 100%; height: 260px;"></div>
            </div>
          </div>
          <link type="text/css" href="view/javascript/jquery/jqvmap/jqvmap.css" rel="stylesheet" media="screen" />
		  <script type="text/javascript" src="view/javascript/jquery/jqvmap/jquery.vmap.js"></script> 
          <script type="text/javascript" src="view/javascript/jquery/jqvmap/maps/jquery.vmap.world.js"></script> 
          <script type="text/javascript"><!--
        $(document).ready(function() {
            $.ajax({
                url: 'index.php?route=extension/dashboard/map/mapcustom&token=<?php echo $token; ?>',
                dataType: 'json',
                success: function(json) {
                    data = [];
                                
                    for (i in json) {
                        data[i] = json[i]['total'];
                    }
                            
                    $('#vmap').vectorMap({
                        map: 'world_en',
                        backgroundColor: '#FFFFFF',
                        borderColor: '#FFFFFF',
                        color: '#9FD5F1',
                        hoverOpacity: 0.7,
                        selectedColor: '#666666',
                        enableZoom: true,
                        showTooltip: true,
                        values: data,
                        normalizeFunction: 'polynomial',
                        onLabelShow: function(event, label, code) {
                            if (json[code]) {
                                label.html('<strong>' + label.text() + '</strong><br />' + '<?php echo $text_order; ?> ' + json[code]['total'] + '<br />' + '<?php echo $text_sale; ?> ' + json[code]['amount']);
                            }
                        }
                    });			
                },
                error: function(xhr, ajaxOptions, thrownError) {
                    alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
                }
            });			
        });
        //--></script> 
        </div>
        <div class="col-lg-6 col-md-12 col-sm-12">
          <div class="panel panel-default">
            <div class="panel-heading">
              <div class="pull-right"><a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="fa fa-calendar"></i> <i class="caret"></i></a>
                <ul id="range" class="dropdown-menu dropdown-menu-right">
                  <li><a href="day">Today</a></li>
                  <li><a href="week">Week</a></li>
                  <li class="active"><a href="month">Month</a></li>
                  <li><a href="year">Year</a></li>
                </ul>
              </div>
              <h3 class="panel-title"><i class="fa fa-bar-chart-o"></i> Sales Analytics</h3>
            </div>
            <div class="panel-body">
              <div id="chart-sale" style="width: 100%; height: 260px;"></div>
            </div>
          </div>
          <script type="text/javascript" src="view/javascript/jquery/flot/jquery.flot.js"></script>
          <script type="text/javascript" src="view/javascript/jquery/flot/jquery.flot.resize.min.js"></script>
          <script type="text/javascript"><!--
$('#range a').on('click', function(e) {
	e.preventDefault();
	
	$(this).parent().parent().find('li').removeClass('active');
	
	$(this).parent().addClass('active');
	
	$.ajax({
		type: 'get',
		url: 'index.php?route=extension/dashboard/chart/chartcustom&token=<?php echo $token; ?>&range=' + $(this).attr('href'),
		dataType: 'json',
		success: function(json) {
                        if (typeof json['order'] == 'undefined') { return false; }
			var option = {	
				shadowSize: 0,
				colors: ['#9FD5F1', '#1065D2'],
				bars: { 
					show: true,
					fill: true,
					lineWidth: 1
				},
				grid: {
					backgroundColor: '#FFFFFF',
					hoverable: true
				},
				points: {
					show: false
				},
				xaxis: {
					show: true,
            		ticks: json['xaxis']
				}
			}
			
			$.plot('#chart-sale', [json['order'], json['customer']], option);	
					
			$('#chart-sale').bind('plothover', function(event, pos, item) {
				$('.tooltip').remove();
			  
				if (item) {
					$('<div id="tooltip" class="tooltip top in"><div class="tooltip-arrow"></div><div class="tooltip-inner">' + item.datapoint[1].toFixed(2) + '</div></div>').prependTo('body');
					
					$('#tooltip').css({
						position: 'absolute',
						left: item.pageX - ($('#tooltip').outerWidth() / 2),
						top: item.pageY - $('#tooltip').outerHeight(),
						pointer: 'cusror'
					}).fadeIn('slow');	
					
					$('#chart-sale').css('cursor', 'pointer');		
			  	} else {
					$('#chart-sale').css('cursor', 'auto');
				}
			});
		},
        error: function(xhr, ajaxOptions, thrownError) {
           alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
        }
	});
});

$('#range .active a').trigger('click');
//--></script>
        </div>
      </div>
      <div class="row">
        <div class="col-lg-4 col-md-12 col-sm-12">
          
      <?php if($loginuser != 'Sales Manager' ) { ?>      
          <div class="panel panel-default">
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
              
      <?php } else { ?>
      	<div class="panel panel-default" style="border-right:5px solid;">
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
      <?php } ?>
          </div>
        </div>
        <div class="col-lg-8 col-md-12 col-sm-12">
          <div class="panel panel-default">
  		     <div class="panel-heading">
                <h3 class="panel-title"><i class="fa fa-shopping-cart"></i> Latest Appointment</h3>
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