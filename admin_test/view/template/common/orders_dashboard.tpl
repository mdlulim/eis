<?=$header?><?=$column_left?>
  <div id="content" class="orders-dashboard-wrapper">

    <div class="page-header">
      <div class="container-fluid">
        <div class="row">
          <div class="col-lg-12">
            <h1>Orders Management</h1>
            <div class="dropdown pull-right">
              <button class="btn btn-primary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <i class="fa fa-plus"></i>&nbsp;
                Quick Actions
              </button>
              <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                <a class="dropdown-item" href="<?=$add_user_link?>">Add User</a>
                <a class="dropdown-item" href="<?=$add_product_link?>">Add New Product</a>
                <a class="dropdown-item" href="<?=$add_customer_link?>">New Customer</a>
                <a class="dropdown-item" href="<?=$add_salesrep_link?>">Add Sales Rep</a>
                <a class="dropdown-item" href="<?=$add_appointment_link?>">Create Appointment</a>
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
                    <i class="fa fa-clock-o"></i>
                  </div>
                  <div class="col-xs-9">
                    <h2><?=$orders_in_progress?></h2>
                    <span>ORDERS IN PROGRESS</span>
                  </div>
                </div>
              </div>
              <div class="tile-footer">
                <a href="<?=$orders_processing_view_more?>">View more...</a>
              </div>
            </div>
        </div>

        <div class="col-lg-3 col-md-6 col-sm-6 col-xs-12">
          <div class="tile tile-success">
              <div class="tile-body">
                <div class="row">
                  <div class="col-xs-3">
                    <i class="fa fa-check-square-o"></i>
                  </div>
                  <div class="col-xs-9">
                    <h2><?=$orders_completed?></h2>
                    <span>ORDERS COMPLETED</span>
                  </div>
                </div>
              </div>
              <div class="tile-footer">
                <a href="<?=$orders_completed_view_more?>">View more...</a>
              </div>
          </div>
        </div>

        <div class="col-lg-3 col-md-6 col-sm-6 col-xs-12">
          <div class="tile <?=$stock_alerts_tile?>">
            <div class="tile-body">
              <div class="row">
                <div class="col-xs-3">
                  <i class="fa fa-exclamation-triangle"></i>
                </div>
                <div class="col-xs-9">
                  <h2><?=$stock_alerts?></h2>
                  <span>PRODUCT STOCK ALERTS</span>
                </div>
              </div>
            </div>
            <div class="tile-footer">
              <a href="<?=$stock_alert_view_more?>">View more...</a>
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
              <a href="<?=$quotes_view_more?>">View more...</a>
            </div>
          </div>
        </div>
      </div>

      <div class="row">
        <div class="col-lg-12">
          <div class="panel panel-default">
            <div class="panel-heading">
              <h3 class="panel-title"><i class="fa fa-user"></i> Customers by Orders</h3>
              <h3 class="panel-title" style="float:right;">
                <a href="<?=$order_view_more?>" >View more...</a>
              </h3>
            </div>
            <div class="table-responsive">
              <table class="table" id="customersByOrdersTbl">
                <thead>
                  <tr>
                    <th>Customer</th>
                    <th>Total Value</th>
                    <th>Last Order Date</th>
                    <th>Sales Rep</th>
                    <th>Wholesale Activity</th>
                    <th class="text-right">Action</th>
                  </tr>
                </thead>
                <tbody>
                  <?php if ($customers_by_orders) : ?>
                  <?php foreach ($customers_by_orders as $order) : ?>
                  <tr>
                    <td><?=$order['customer_name']?></td>
                    <td>R <?=$order['total_value']?></td>
                    <td><?=$order['last_order_date']?></td>
                    <td><?=$order['sales_rep']?></td>
                    <td><?=$order['wholesale_activity']?></td>
                    <td class="text-right">
                      <a href="<?=$order['view']?>" data-toggle="tooltip" title="<?=$button_view?>" class="btn btn-info"><i class="fa fa-eye"></i></a>
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

    </div>
  </div>
  <!-- Page loader -->
  <div class="loader-wrapper">
    <div class="loader"></div>
  </div>
  <!-- /Page loader -->
<?=$footer?>
