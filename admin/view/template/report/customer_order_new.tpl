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
                    <div class="form-group">
                        <label class="control-label">Products Viewed Date Range</label>
                        <div class="col-md-12 col-xs-9 p-l-0">
                            <div id="reportrange" class="report-range-picker">
                                <i class="fa fa-calendar"></i>&nbsp;
                                <span></span> &nbsp;<i class="fa fa-caret-down"></i>
                            </div>
                        </div>
                    </div>
                </div>
                  
                
                  <div class="col-sm-4">
                   <div class="form-group">
                        <label class="control-label" for="input-customer"><?php echo $entry_customer; ?></label>
                        <!--<input type="text" name="filter_customer" value="<?php echo $filter_customer; ?>" placeholder="<?php echo $entry_customer; ?>" id="input-customer" class="form-control" />-->
                        <select name="filter_customer_id" class="form-control">
                            <option value="">Select Customer Name</option>
                            <?php foreach ($Dropdowncustomers as $Dcustomer) {  ?>
                        <?php if ($Dcustomer['customer_id'] == $filter_customer_id) { ?>
                        <option value="<?php echo $Dcustomer['customer_id']; ?>" selected="selected"><?php echo $Dcustomer['firstname']; ?></option>
                        <?php } else { ?>
                        <option value="<?php echo $Dcustomer['customer_id']; ?>"><?php echo $Dcustomer['firstname']; ?></option>
                        <?php } ?>
                        <?php } ?>
                            
                        </select>
                    </div>
                </div>
                <div class="col-sm-4">
                    <div class="form-group">
                        <label class="control-label"><?php echo $entry_status; ?> </label>
                        <div class="col-md-12 col-xs-9 p-l-0">
                            <select name="filter_order_status_id" id="input-status" class="form-control">
                            <option value="0"><?php echo $text_all_status; ?></option>
                            <?php foreach ($order_statuses as $order_status) { ?>
                            <?php if ($order_status['order_status_id'] == $filter_order_status_id) { ?>
                            <option value="<?php echo $order_status['order_status_id']; ?>" selected="selected"><?php echo $order_status['name']; ?></option>
                            <?php } else { ?>
                            <option value="<?php echo $order_status['order_status_id']; ?>"><?php echo $order_status['name']; ?></option>
                            <?php } ?>
                            <?php } ?>
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

        <?php if ($filter) : ?>
        <div class="report-results">    

            <h4 style="margin-top:35px;"><?php echo $report_title; ?></h4>
            <p style="color:#91969a; margin-top:-5px; margin-bottom:20px">List of orders <?=$filter_date_start?> - <?=$filter_date_end?></p>
            
            <div class="row m-b-20">
                <div class="col-md-12">
                    <div id="export-buttons"></div>
                </div>
            </div>
            <div class="table-responsive">
                <table id="customerOrderReportDataTable" class="table table-bordered">
                    <thead>
                        <tr>
                             <td class="text-left"><?php echo $column_customer; ?></td>
                            <td class="text-left"><?php echo $column_email; ?></td>
                            <td class="text-left"><?php echo $column_customer_group; ?></td>
                            <td class="text-left"><?php echo $column_status; ?></td>
                            <td class="text-left"><?php echo $column_orders; ?></td>
                            <td class="text-left"><?php echo $column_products; ?></td>
                            <td class="text-left"><?php echo $column_total; ?></td>
                            <td class="text-left"><?php echo $column_action; ?></td>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach($customers as $customer) : ?>
                        <tr>
                            <td class="text-left"><?php echo $customer['customer']; ?></td>
                            <td class="text-left"><?php echo $customer['email']; ?></td>
                            <td class="text-left"><?php echo $customer['customer_group']; ?></td>
                            <td class="text-left"><?php echo $customer['status']; ?></td>
                            <td class="text-left"><?php echo $customer['orders']; ?></td>
                            <td class="text-left"><?php echo $customer['products']; ?></td>
                            <td class="text-left"><?php echo $customer['total']; ?></td>
                            <td class="text-left"><a href="<?php echo $customer['edit']; ?>" data-toggle="tooltip" title="<?php echo $button_edit; ?>" class="btn btn-primary"><i class="fa fa-pencil"></i></a></td>
                        
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
