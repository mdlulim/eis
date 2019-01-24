<?php echo $header; ?><?php echo $column_left; ?>
<div id="content" data-token="<?php echo $token; ?>">
  <div class="page-header">
    <div class="container-fluid">
      <h1> <?php echo $heading_title; ?></h1>
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
        <h3 class="panel-title"><i class="fa fa-print"></i> <?php echo $heading_title; ?></h3>
      </div>
      <div class="panel-body">
        <div class="well">
        	<h3 style="margin-bottom:0">Filters</h3>
            <hr style="margin-top:15px">
            <div class="row filters">
                <div class="col-sm-6">
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
                  
                
                  <!--div class="col-sm-4">
                    <div class="form-group">
                        <label class="control-label">Product Name</label>
                        <div class="col-md-12 col-xs-9 p-l-0">
                            <select name="filter_product_id" class="form-control">
                                    <option value="">Select Product Name</option>
                                    <?php foreach ($Dorpdownproducts as $Dproduct) {  ?>
                                <?php if ($Dproduct['product_id'] == $filter_product_id) { ?>
                                <option value="<?php echo $Dproduct['product_id']; ?>" selected="selected"><?php echo $Dproduct['name']; ?></option>
                                <?php } else { ?>
                                <option value="<?php echo $Dproduct['product_id']; ?>"><?php echo $Dproduct['name']; ?></option>
                                <?php } ?>
                                <?php } ?>
                                    
                                </select>
                        </div>
                    </div>
                </div-->
                <div class="col-sm-6">
                    <div class="form-group">
                        <label class="control-label">Model </label>
                        <div class="col-md-12 col-xs-9 p-l-0">
                            <select name="filter_model" class="form-control">
                                    <option value="">Select Model</option>
                                    <?php foreach ($dropdownmodels as $Dmodel) {  ?>
                                <?php if ($Dmodel['model'] == $filter_model) { ?>
                                <option value="<?php echo $Dmodel['model']; ?>" selected="selected"><?php echo $Dmodel['model']; ?></option>
                                <?php } else { ?>
                                <option value="<?php echo $Dmodel['model']; ?>"><?php echo $Dmodel['model']; ?></option>
                                <?php } ?>
                                <?php } ?>
                                    
                            </select>
                        </div>
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
                <table id="productViewedReportDataTable" class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Product Name</th>
                            <th>Model</th>
                            <th>Viewed</th>
                            <th>Percent</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach($products as $product) : ?>
                        <tr>
                            <td><?=$product['name']?></td>
                            <td><?=$product['model']?></td>
                            <td><?=$product['viewed']?></td>
                            <td><?=$product['percent']?></td>
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