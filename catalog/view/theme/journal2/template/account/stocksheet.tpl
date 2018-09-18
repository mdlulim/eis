<?php echo $header; ?>
<div id="container" class="container j-container">
  <ul class="breadcrumb">
    <?php foreach ($breadcrumbs as $breadcrumb) { ?>
    <li><a href="<?php echo $breadcrumb['href']; ?>"><?php echo $breadcrumb['text']; ?></a></li>
    <?php } ?>
  </ul>
  <?php if ($success) { ?>
  <div class="alert alert-success success"><i class="fa fa-check-circle"></i> <?php echo $success; ?>
    <button type="button" class="close" data-dismiss="alert">&times;</button>
  </div>
  <?php } ?>
  <div class="row"><?php echo $column_left; ?><?php echo $column_right; ?>
    <?php if ($column_left && $column_right) { ?>
    <?php $class = 'col-sm-6'; ?>
    <?php } elseif ($column_left || $column_right) { ?>
    <?php $class = 'col-sm-9'; ?>
    <?php } else { ?>
    <?php $class = 'col-sm-12'; ?>
    <?php } ?>
    <div id="content" class="<?php echo $class; ?>">
      <h1 class="heading-title">
        <?php echo $heading_title; ?>
        <?php echo $button_import; ?>
        <span>
          <a href="<?php echo $addStocksheetToCart; ?>" class="btn btn-default btn-sm pull-right" onclick="return confirm('Please note that all current cart items will be replaced with contents from this order, should line Items have no stock or are disabled it will not be added to your cart.');">
            <i class="fa fa-repeat"></i> Add sheet to cart 
          </a>
        </span>
      </h1>
      <?php echo $content_top; ?>
      <div class="content wishlist-info">
      <?php if ($products) { ?>
      <div class="row datatable-custom-filters" data-filter-columns="[1,2,3]">
        <div class="col-sm-6"><div id="export-buttons"></div></div>
        <div class="col-sm-6 pull-right">
          <form class="form-inline" style="float:right">
            <div class="form-group">
              <label class="sr-only">Search</label>
              <div class="input-group">
                <input type="text" class="form-control input-filter" placeholder="Search">
                <div class="input-group-btn">
                  <button type="button" class="btn btn-primary"><span class="fa fa-search"></span></button>
                  <button type="button" class="btn btn-default dropdown-toggle">
                    <span class="caret"></span>
                  </button>
                  <ul class="dropdown-menu dropdown-menu-right">
                    <li>
                      <a class="checkbox">
                        <label>
                          <input type="checkbox" checked="checked" value="1">Product Name
                        </label>
                      </a>
                    </li>
                    <li>
                      <a class="checkbox">
                        <label>
                          <input type="checkbox" checked="checked" value="2">Category
                        </label>
                      </a>
                    </li>
                    <li>
                      <a class="checkbox">
                        <label>
                          <input type="checkbox" checked="checked" value="3">SKU
                        </label>
                      </a>
                    </li>
                  </ul>
                </div>
              </div>
            </div>
          </form>
        </div>
      </div>
        <div class="table-responsive">
      <table class="table table-bordered table-hover">
        <thead>
          <tr>
            <td class="text-left image"><?php echo $column_image; ?></td>
            <td class="text-left name"><?php echo $column_name; ?></td>
            <td class="text-left model"><?php echo $column_model; ?></td>
            <td class="text-right stock"><?php echo $column_stock; ?></td>
            <td class="text-right price"><?php echo $column_price; ?></td>
            <td class="text-right action"><!--<?php echo $column_action; ?>--></td>
          </tr>
        </thead>
        <tbody>
          <?php foreach ($products as $product) { ?>
          <tr>
            <td class="text-left image"><?php if ($product['thumb']) { ?>
              <a href="<?php echo $product['href']; ?>"><img src="<?php echo $product['thumb']; ?>" alt="<?php echo $product['name']; ?>" title="<?php echo $product['name']; ?>" /></a>
              <?php } ?></td>
            <td class="text-left name"><a href="<?php echo $product['href']; ?>"><?php echo $product['name']; ?></a></td>
            <td class="text-left model"><?php echo $product['model']; ?></td>
            <td class="text-right stock"><input type="text" name="stock" value="<?php echo $product['stock']; ?>" maxlength="4" size="4"/></td>
            <td class="text-right price">
              <?php if (!$this->config->get('config_hide_price') && $product['price']) { ?>
              <div class="price">
                <?php if (!$product['special']) { ?>
                <?php echo $product['price']; ?>
                <?php } else { ?>
                <b><?php echo $product['special']; ?></b> <s><?php echo $product['price']; ?></s>
                <?php } ?>
              </div>
              <?php } ?></td>
              <td class="text-right action <?php echo isset($product['labels']) && is_array($product['labels']) && isset($product['labels']['outofstock']) ? 'outofstock' : ''; ?>">
                <a onclick="cart.add('<?php echo $product['product_id']; ?>');" data-toggle="tooltip" title="<?php echo $button_cart; ?>" class="btn-addtocart">
                  <i class="fa fa-shopping-cart"></i>
                </a>
                <a href="<?php echo $product['remove']; ?>" data-toggle="tooltip" title="<?php echo $button_remove; ?>" class="btn-remove">
                  <i class="fa fa-trash-o"></i>
                </a>
              </td>
          </tr>
          <?php } ?>
        </tbody>
      </table>
        </div>
      <?php } else { ?>
      <p><?php echo $text_empty; ?></p>
      <?php } ?>
        </div>
      <div class="buttons">
        <!--div class="pull-right"><a href="<?php echo $continue; ?>" class="btn btn-primary button"><?php echo $button_continue; ?></a></div-->
      </div>
      <?php echo $content_bottom; ?></div>
    </div>
    <?php echo (!empty($import_modal)) ? $import_modal : ''; ?>
</div>
<?php echo $footer; ?> 