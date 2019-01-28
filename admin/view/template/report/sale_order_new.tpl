<?php echo $header; ?><?php echo $column_left; ?>
<div id="content" data-token="<?php echo $token; ?>">
  <div class="page-header">
    <div class="container-fluid">
      <h1><?php echo $report_heading_title; ?></h1>
      <ul class="breadcrumb">
        <?php foreach ($breadcrumbs as $breadcrumb) { ?>
        <li><a href="<?php echo $breadcrumb['href']; ?>"><?php echo $breadcrumb['text']; ?></a></li>
        <?php } ?>
      </ul>
    </div>
  </div>
  <div class="container-fluid">
    <div class="panel panel-default">
      <div class="panel-heading">
        <h3 class="panel-title"><i class="fa fa-print"></i> <?php echo $report_heading_title; ?></h3>
      </div>
      <div class="panel-body">
        <div class="well">
        	<h3 style="margin-bottom:0">Filters</h3>
            <hr style="margin-top:15px">
            <div class="row filters">
                <div class="col-sm-4">
                    <div class="row">
                        <label class="control-label">Order Date Range</label>
                        <div class="col-md-12 col-xs-9 p-l-0">
                            <div id="reportrange" class="report-range-picker">
                                <i class="fa fa-calendar"></i>&nbsp;
                                <span></span> &nbsp;<i class="fa fa-caret-down"></i>
                            </div>
                        </div>
                    </div>
                    <div class="row m-t-15">
                        <label class="control-label">Order Status</label>
                        <div class="col-md-12 col-xs-9 p-l-0">
                            <select id="input-status" name="filter_order_status_id" class="selectpicker form-control" data-live-search="true">
                                <option value="">All</option>
                                <?php foreach ($order_statuses as $order_status) { ?>
                                <?php if ($order_status['order_status_id'] == $filter_order_status) { ?>
                                <option value="<?php echo $order_status['order_status_id']; ?>" selected="selected"><?php echo $order_status['name']; ?></option>
                                <?php } else { ?>
                                <option value="<?php echo $order_status['order_status_id']; ?>"><?php echo $order_status['name']; ?></option>
                                <?php } ?>
                                <?php } ?>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="col-sm-4">
                    <div class="row">
                        <label class="control-label">Sales Rep Name</label>
                        <div class="col-md-12 col-xs-9 p-l-0">
                            <select id="input-salesrep" name="filter_salesrep" class="selectpicker form-control" data-live-search="true">
                                <option value="" data-subtext="Sales Reps">All</option>
                                <?php if (!empty($salesreps)) : ?>
                                <?php foreach ($salesreps as $salesrep) : ?>
                                <option value="<?=$salesrep['salesrep_id']?>" <?=($salesrep['salesrep_id']===$filter_salesrep) ? "selected" : ""?>><?=$salesrep['salesrep_name']?> <?=$salesrep['salesrep_lastname']?></option>
                                <?php endforeach; ?>
                                <?php endif; ?>
                            </select>
                        </div>
                    </div>
                    <div class="row m-t-15">
                        <label class="control-label">Sales Manager</label>
                        <div class="col-md-12 col-xs-9 p-l-0">
                            <select id="input-sales_manager" name="filter_sales_manager" class="selectpicker form-control" data-live-search="true">
                                <option value="" data-subtext="Sales Managers">All</option>
                                <?php if (!empty($sales_managers)) : ?>
                                <?php foreach ($sales_managers as $sales_manager) : ?>
                                <option value="<?=$sales_manager['user_id']?>" <?=($sales_manager['user_id']===$filter_sales_manager) ? "selected" : ""?>><?=$sales_manager['firstname']?> <?=$sales_manager['lastname']?></option>
                                <?php endforeach; ?>
                                <?php endif; ?>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="col-sm-4">
                    <div class="row">
                        <label class="control-label">Payment Method</label>
                        <div class="col-md-12 col-xs-9 p-l-0">
                            <select name="filter_payment_method" class="selectpicker form-control" data-live-search="true">
                                <option value="">All</option>
                                <?php if (!empty($payment_methods)) : ?>
                                <?php foreach ($payment_methods as $payment_method) : ?>
                                <option value="<?=$payment_method['code']?>" <?=($payment_method['code']===$filter_payment_method) ? "selected" : ""?>><?=$payment_method['name']?></option>
                                <?php endforeach; ?>
                                <?php endif; ?>
                            </select>
                        </div>
                    </div>
                    <div class="row m-t-15">
                        <label class="control-label">Shipping Method</label>
                        <div class="col-md-12 col-xs-9 p-l-0">
                            <select name="filter_shipping_method" class="form-control">
                                <option value="">All</option>
                                <?php if (!empty($shipping_methods)) : ?>
                                <?php foreach ($shipping_methods as $shipping_method) : ?>
                                <option value="<?=$shipping_method['code']?>" <?=($shipping_method['code']===$filter_shipping_method) ? "selected" : ""?>><?=$shipping_method['name']?></option>
                                <?php endforeach; ?>
                                <?php endif; ?>
                            </select>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row m-t-15">
                <div class="col-sm-12 pull-right">
                    <button type="button" id="button-filter" class="btn btn-primary pull-right"><i class="fa fa-search"></i> Generate Report</button>
                    <button type="button" id="button-filter-reset" class="btn btn-primary pull-right" style="margin-right:10px;"><i class="fa fa-refresh"></i> Reset</button>
                </div>
            </div>
        </div>

        <?php if ($results) : ?>
        <div class="report-results">    

            <h4 style="margin-top:35px;"><?php echo $report_title; ?></h4>
            <p style="color:#91969a; margin-top:-5px; margin-bottom:20px">List of orders <?=$filter_date_start?> - <?=$filter_date_end?></p>
            
            <div class="row m-b-20">
                <div class="col-md-12">
                    <div id="export-buttons"></div>
                </div>
            </div>
            <div class="table-responsive">
                <table id="salesReportDataTable" class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Date From</th>
                            <th>Date To</th>
                            <th>Total Orders</th>
                            <th>Total Items</th>
                            <th>Tax</th>
                            <th>Order Value</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach($orders as $order) : ?>
                        <tr>
                            <td><?=$order['date_start']?></td>
                            <td><?=$order['date_end']?></td>
                            <td><?=(int)$order['orders']?></td>
                            <td><?=(int)$order['products']?></td>
                            <td><?=$order['tax']?></td>
                            <td><?=$order['total']?></td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
        <?php endif; ?>
        
      </div>
    </div>
  </div>

</div>
<!-- Page loader -->
<div class="loader-wrapper" style="display:none">
	<div class="loader"></div>
</div>
<!-- /Page loader -->
<?php echo $footer; ?>
