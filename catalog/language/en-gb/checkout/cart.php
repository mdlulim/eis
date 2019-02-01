<?php
// Heading
$_['heading_title']            = 'Shopping Cart';

// Text
$_['text_success']             = 'Success: You have added <a href="%s">%s</a> to your <a href="%s">shopping cart</a>!';
$_['text_remove']              = 'Success: You have modified your shopping cart!';
$_['text_login']               = 'Attention: You must <a href="%s">login</a> or <a href="%s">create an account</a> to view prices!';
$_['text_items']               = '%s item(s)';
// $_['text_items']               = '%s item(s) - %s';
$_['text_points']              = 'Reward Points: %s';
$_['text_next']                = 'What would you like to do next?';
$_['text_next_choice']         = 'Choose if you have a discount code or reward points you want to use or would like to estimate your delivery cost.';
$_['text_empty']               = 'Your shopping cart is empty!';
$_['text_day']                 = 'day';
$_['text_week']                = 'week';
$_['text_semi_month']          = 'half-month';
$_['text_month']               = 'month';
$_['text_year']                = 'year';
$_['text_trial']               = '%s every %s %s for %s payments then ';
$_['text_recurring']           = '%s every %s %s';
$_['text_length']              = ' for %s payments';
$_['text_until_cancelled']     = 'until cancelled';
$_['text_recurring_item']      = 'Recurring Item';
$_['text_payment_recurring']   = 'Payment Profile';
$_['text_trial_description']   = '%s every %d %s(s) for %d payment(s) then';
$_['text_payment_description'] = '%s every %d %s(s) for %d payment(s)';
$_['text_payment_cancel']      = '%s every %d %s(s) until canceled';

$_['text_upload_success']      = 'File successfully uploaded and validated.';
$_['text_validate_success']    = 'Successfully validated import. Click continue button below to Add Items to Shopping Cart!';

$_['text_add_multiple_success']= 'You have successfully added %s item(s) to your shopping cart!';

// Import
$_['button_import_to_cart']    = '
<form id="form-cart-importer" enctype="multipart/form-data">
	<input type="file" name="import" id="import" style="display:none">
	<button type="button" class="btn btn-default btn-sm pull-right" id="import-cart" onclick="Importer.triggerFileUpload(this);"><i></i> Import to Cart</button>
</form>';

// Clear cart
$_['button_clear_cart'] = '<button type="button" class="btn btn-default btn-sm pull-right" id="clear-cart" onclick="cart.clear();"><i></i> Clear Cart</button>';

$_['import_success']           = 'You have added %s to your shopping cart!';
$_['import_file_type_error']   = 'The file type imported is not supported, please upload your file in CSV, XLS and XLSX';
$_['import_file_size_error']   = 'The File you have imported has exceeded the maximum size, please make sure that your file is not more than 5MB';
$_['import_generic_error']     = 'An unexpected error has occured, please try again!';

// Column
$_['column_image']             = 'Image';
$_['column_name']              = 'Product Name';
$_['column_model']             = 'Model';
$_['column_quantity']          = 'Quantity';
$_['column_price']             = 'Unit Price';
$_['column_total']             = 'Total';

// Warning
$_['warning_import_items_not_found'] = 'Below is the list of records [or items] imported to cart that were not found in the system.';

// Error
$_['error_stock']              = 'Products marked with *** are not available in the desired quantity or not in stock!';
$_['error_minimum']            = 'Minimum order amount for %s is %s!';
$_['error_required']           = '%s required!';
$_['error_product']            = 'Warning: There are no products in your cart!';
$_['error_recurring_required'] = 'Please select a payment recurring!';
$_['error_no_product_to_add']  = 'Sorry, no products to add to cart!'; 

$_['error_import_upload']         = '%s out of %s item(s) found in the system. Do you wish to continue importing or view items?';
$_['error_import_cart']           = 'Sorry, no items to add to cart. An unexpected error has occured. Please cancel and try again!';
$_['error_import_no_items_found'] = '%s out of %s item(s) found in the system. Only existing item(s) can be imported to cart!';