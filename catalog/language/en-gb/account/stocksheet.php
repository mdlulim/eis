<?php
// Heading
$_['heading_title'] = 'My Stock Sheet';

// Text
$_['text_account']  = 'Account';
$_['text_instock']  = 'In Stock';
$_['text_wishlist'] = 'Stock List (%s)';
$_['text_login']    = 'You must <a href="%s">login</a> or <a href="%s">create an account</a> to save <a href="%s">%s</a> to your <a href="%s">wish list</a>!';
$_['text_success']  = 'Success: You have added <a href="%s">%s</a> to your <a href="%s">stock list</a>!';
$_['text_remove']   = 'Success: You have modified your stock list!';
$_['text_empty']    = 'Your stock sheet is empty.';
$_['text_success_cart'] = "Stock Sheet added to cart successfully";
$_['text_error_cart'] = "Unable to add stocksheet to cart";

$_['text_upload_success']      = 'File successfully uploaded and validated.';
$_['text_validate_success']    = 'Successfully validated import. Click continue button below to Add Items to Stock Sheet!';

// Import
$_['button_import'] = '
<form id="form-stocksheet-importer" enctype="multipart/form-data">
	<input type="file" name="import" id="import" style="display:none">
    <button type="button" class="btn btn-default btn-sm pull-right" onclick="Importer.triggerFileUpload(this);">
        <i></i>
        Import Stock Sheet
    </button>
</form>';

$_['import_success']           = 'You have added %s to your stock sheet!';
$_['import_file_type_error']   = 'The file type imported is not supported, please upload your file in CSV, XLS and XLSX';
$_['import_file_size_error']   = 'The File you have imported has exceeded the maximum size, please make sure that your file is not more than 5MB';
$_['import_generic_error']     = 'An unexpected error has occured, please try again!';

// Warning
$_['warning_import_items_not_found'] = 'Below is the list of records [or items] imported to stock sheet that were not found in the system.';

// Column
$_['column_image']  = 'Image';
$_['column_name']   = 'Product Name';
$_['column_model']  = 'Model';
$_['column_stock']  = 'Stock';
$_['column_price']  = 'Unit Price';
$_['column_action'] = 'Action';

// Error
$_['error_import_upload']      = '%s out of %s item(s) found in the system. Do you wish to continue importing or view items?';
$_['error_import_stocksheet']  = 'Sorry, no items to add to stock sheet. An unexpected error has occured. Please cancel and try again!';