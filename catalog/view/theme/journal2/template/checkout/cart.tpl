<?php echo $header; ?>
<div id="container" class="container j-container">
  <ul class="breadcrumb">
    <?php foreach ($breadcrumbs as $breadcrumb) { ?>
    <li><a href="<?php echo $breadcrumb['href']; ?>"><?php echo $breadcrumb['text']; ?></a></li>
    <?php } ?>
  </ul>
  <?php if ($attention) { ?>
  <div class="alert alert-info information"><i class="fa fa-info-circle"></i> <?php echo $attention; ?>
    <button type="button" class="close" data-dismiss="alert">&times;</button>
  </div>
  <?php } ?>
  <?php if ($success) { ?>
  <div class="alert alert-success success"><i class="fa fa-check-circle"></i> <?php echo $success; ?>
    <button type="button" class="close" data-dismiss="alert">&times;</button>
  </div>
  <?php } ?>
  <?php if ($error_warning) { ?>
  <div class="alert alert-danger warning"><i class="fa fa-exclamation-circle"></i> <?php echo $error_warning; ?>
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
    <div id="content" class="<?php echo $class; ?> sc-page">
      <h1 class="heading-title"><?php echo $heading_title; ?>
        <?php if ($weight) { ?>
        &nbsp;(<?php echo $weight; ?>)
        <?php } ?>
      </h1>
      <?php echo $content_top; ?>
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
      <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data">
        <div class="table-responsive cart-info">
          <table class="table table-condensed">
            <thead>
              <tr>
                <th class="text-left image"><?php echo $column_image; ?></th>
                <th class="text-left name searchable"><?php echo $column_name; ?></th>
                <th class="text-left category searchable">Category</th>
                <th class="text-left model searchable">SKU</th>
                <th class="text-left quantity"><?php echo $column_quantity; ?></th>
                <th class="text-right price"><?php echo $column_price; ?></th>
                <th class="text-right total"><?php echo $column_total; ?></th>
                <th></th>
              </tr>
            </thead>
            <tbody>
              <?php foreach ($products as $product) { ?>
              <tr>
                <td class="text-center image"><?php if ($product['thumb']) { ?>
                  <a href="<?php echo $product['href']; ?>"><img src="<?php echo $product['thumb']; ?>" alt="<?php echo $product['name']; ?>" title="<?php echo $product['name']; ?>" class="img-thumbnail" /></a>
                  <?php } ?></td>
                <td class="text-left name searchable"><a href="<?php echo $product['href']; ?>"><?php echo $product['name']; ?></a>
                  <?php if (!$product['stock']) { ?>
                  <span class="text-danger">***</span>
                  <span class="stock-alert">
                    <i class="fa fa-exclamation-triangle"></i> This item is not available in the desired quantity or not in stock.
                  </span>
                  <?php } ?>
                  <?php if ($product['option']) { ?>
                  <?php foreach ($product['option'] as $option) { ?>
                  <br />
                  <small><?php echo $option['name']; ?>: <?php echo $option['value']; ?></small>
                  <?php } ?>
                  <?php } ?>
                  <?php if ($product['reward']) { ?>
                  <br />
                  <small><?php echo $product['reward']; ?></small>
                  <?php } ?>
                  <?php if ($product['recurring']) { ?>
                  <br />
                  <span class="label label-info"><?php echo $text_recurring_item; ?></span> <small><?php echo $product['recurring']; ?></small>
                  <?php } ?></td>
                <td class="text-left category searchable"><?php echo $product['category']; ?></td>
                <td class="text-left model searchable"><?php echo $product['model']; ?></td>
                <td class="text-center quantity <?php echo (!$product['stock']) ? 'add_to_cart-disabled' : '' ?>">
                  <span class="qty" data-cart-id="<?php echo $product[version_compare(VERSION, '2.1', '<') ? 'key' : 'cart_id']; ?>">
                    <a href="javascript:;" class="journal-stepper" onclick="Journal.removeProductFromCart(<?php echo $product['product_id']; ?>, this)">-</a>
                    <input name="quantity" value="<?php echo $product['cart_qty'] ?>" size="10" data-min-value="0" id="quantity_<?php echo $product['product_id']; ?>" class="form-control product-info1" type="text" data-cart-qty="<?php echo $product['cart_qty'] ?>" data-product-id="<?php echo $product['product_id'] ?>" <?php echo (!$product['stock']) ? 'disabled' : '' ?>>
                    <?php if (!$product['stock']) : ?>
                    <a href="javascript:;" class="journal-stepper">+</a>
                    <?php else : ?>
                    <a href="javascript:;" class="journal-stepper" onclick="Journal.addToCart(<?php echo $product['product_id']; ?>, this)">+</a>
                    <?php endif; ?>
                  </span>
                </td>
                <td class="text-right price"><?php echo (!$this->config->get('config_hide_price')) ? $product['price'] : ''; ?></td>
                <td class="text-right total"><?php echo (!$this->config->get('config_hide_price')) ? $product['total'] : ''; ?></td>
                <td class="text-right remove-from-cart">
                    <a href="<?php echo $remove; ?>" data-toggle="tooltip" title="<?php echo $button_remove; ?>" class="btn-remove-cart-item" onclick="cart.remove('<?php echo $product[version_compare(VERSION, '2.1', '<') ? 'key' : 'cart_id']; ?>');"><i class="fa fa-trash-o"></i></a>
                </td>
              </tr>
              <?php } ?>
              <?php foreach ($vouchers as $vouchers) { ?>
              <tr>
                <td></td>
                <td class="text-left name"><?php echo $vouchers['description']; ?></td>
                <td class="text-left"></td>
                <td class="text-left quantity">
                  <div class="input-group btn-block" style="max-width: 200px;">
                    <input type="text" name="" value="1" size="1" disabled="disabled" class="form-control" />
                    <span class="input-group-btn"><button type="button" data-toggle="tooltip" title="<?php echo $button_remove; ?>" class="btn btn-danger" onclick="voucher.remove('<?php echo $vouchers['key']; ?>');"><i class="fa fa-times-circle"></i></button></span>
                  </div>
                </td>
                <td class="text-right price"><?php echo $vouchers['amount']; ?></td>
                <td class="text-right total"><?php echo $vouchers['amount']; ?></td>
              </tr>
              <?php } ?>
            </tbody>
            <?php if (!$this->config->get('config_hide_price')) { ?>
            <tfoot>
              <?php foreach ($totals as $total) : ?>
              <tr>
                <th colspan="6" class="text-right" style=""><?php echo $total['title']; ?></th>
                <th align="center" class="text-right cart-subtotal" style=""><?php echo $total['text']; ?></th>
                <td style="padding:10px 6px; background-color:white">&nbsp;</td>
              </tr>
              <?php endforeach; ?>
            </tfoot>
            <?php } ?>
          </table>
        </div>
      </form>
      <div class="action-area">
        <?php /* //start-php-comment
        <?php if (version_compare(VERSION, '2.2', '<')): ?>
        <?php if ($coupon || $voucher || $reward || $shipping) { ?>
        <h3><?php echo $text_next; ?></h3>
        <p><?php echo $text_next_choice; ?></p>
        <div class="panel-group" id="accordion"><?php echo $coupon; ?><?php echo $voucher; ?><?php echo $reward; ?><?php echo $shipping; ?></div>
        <?php } ?>
        <?php else: ?>
        <?php if ($modules) { ?>
        <h3><?php echo $text_next; ?></h3>
        <p><?php echo $text_next_choice; ?></p>
        <div class="panel-group" id="accordion">
          <?php foreach ($modules as $module) { ?>
          <?php echo $module; ?>
          <?php } ?>
        </div>
        <?php } ?>
        <?php endif; ?>
        <div class="row">
          <div class="col-sm-4 col-sm-offset-8 cart-total">
            <table class="table table-bordered" id="total">
              <?php foreach ($totals as $total) { ?>
              <tr>
                <td class="text-right right"><strong><?php echo $total['title']; ?>:</strong></td>
                <td class="text-right right"><?php echo $total['text']; ?></td>
              </tr>
              <?php } ?>
            </table>
          </div>
        </div>
        //end-php-comment */ ?>
        <div class="buttons">
          <div class="pull-left"><a href="<?php echo $continue; ?>" class="btn-default button"><?php echo $button_shopping; ?></a></div>
          <div class="pull-right"><a href="<?php echo $checkout; ?>" class="btn-primary button"><?php echo $button_checkout; ?></a></div>
        </div>
      </div>
      <?php echo $content_bottom; ?></div>
    </div>
    <?php echo (!empty($import_modal)) ? $import_modal : ''; ?>
</div>
<?php echo $footer; ?> 
