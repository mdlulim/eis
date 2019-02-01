<?php
class ControllerAccountStocksheet extends Controller {
	public function index() {
		if (!$this->customer->isLogged()) {
			$this->session->data['redirect'] = $this->url->link('account/wishlist', '', true);

			$this->response->redirect($this->url->link('account/login', '', true));
		}

		/*==================================
		=       Add Files (Includes)       =
		==================================*/

		# stylesheets (CSS) files
		$this->document->addStyle('admin/view/javascript/bootstrap-sweetalert/sweetalert.css');
		$this->document->addStyle('catalog/view/javascript/datatables/datatables.min.css');
		$this->document->addStyle('catalog/view/javascript/datatables/buttons/buttons.datatables.min.css');
		$this->document->addStyle('catalog/view/stylesheets/custom.css');
		$this->document->addStyle('catalog/view/stylesheets/stocksheet.css');

		# javascript (JS) files
		$this->document->addScript('admin/view/javascript/bootstrap-sweetalert/sweetalert.min.js');
		$this->document->addScript('admin/view/javascript/bootstrap-sweetalert/sweetalert-data.js');
		$this->document->addScript('catalog/view/javascript/datatables/datatables.min.js');
		$this->document->addScript('catalog/view/javascript/datatables/buttons/datatables.buttons.min.js');
		$this->document->addScript('catalog/view/javascript/datatables/buttons/buttons.flash.min.js');
		$this->document->addScript('catalog/view/javascript/jszip/jszip.min.js');
		$this->document->addScript('catalog/view/javascript/pdfmake/pdfmake.min.js');
		$this->document->addScript('catalog/view/javascript/pdfmake/vfs_fonts.js');
		$this->document->addScript('catalog/view/javascript/datatables/buttons/buttons.html5.min.js');
		$this->document->addScript('catalog/view/javascript/importer.js');
		$this->document->addScript('catalog/view/javascript/stocksheet.js');

		/*=====  End of Add Files (Includes)  ======*/

		$this->load->language('account/stocksheet');

		$this->load->model('account/stocksheet');

		$this->load->model('catalog/product');

		$this->load->model('tool/image');
        //customer_id 43
		if (isset($this->request->get['remove'])) {
			// Remove Wishlist
			$this->model_account_stocksheet->deleteStocksheet($this->request->get['remove']);

			$this->session->data['success'] = $this->language->get('text_remove');

			$this->response->redirect($this->url->link('account/stocksheet'));
		}

		$this->document->setTitle($this->language->get('heading_title'));

		$data['breadcrumbs'] = array();

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('text_home'),
			'href' => $this->url->link('common/home')
		);

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('text_account'),
			'href' => $this->url->link('account/account', '', true)
		);

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('heading_title'),
			'href' => $this->url->link('account/stocksheet')
		);

		$data['heading_title'] = $this->language->get('heading_title');

		$data['text_empty'] = $this->language->get('text_empty');

		$data['column_image'] = $this->language->get('column_image');
		$data['column_name'] = $this->language->get('column_name');
		$data['column_model'] = $this->language->get('column_model');
		$data['column_stock'] = $this->language->get('column_stock');
		$data['column_price'] = $this->language->get('column_price');
		$data['column_action'] = $this->language->get('column_action');

		$data['button_continue'] = $this->language->get('button_continue');
		$data['button_cart'] = $this->language->get('button_cart');
        $data['button_remove'] = $this->language->get('button_remove');
        $data['addStocksheetToCart'] = $this->url->link('account/stocksheet/addStocksheetToCart');

		if (isset($this->session->data['success'])) {
			$data['success'] = $this->session->data['success'];

			unset($this->session->data['success']);
		} else {
			$data['success'] = '';
		}

		$data['products'] = array();

		$results = $this->model_account_stocksheet->getStocksheet();
        
		foreach ($results as $result) {
			$product_info = $this->model_catalog_product->getProductSku($result['sku']);

			if (!empty($product_info)) {
				if ($product_info['image']) {
					$image = $this->model_tool_image->resize($product_info['image'], $this->config->get($this->config->get('config_theme') . '_image_wishlist_width'), $this->config->get($this->config->get('config_theme') . '_image_wishlist_height'));
				} else {
					$image = false;
				}

				if ($product_info['quantity'] <= 0) {
					$stock = $product_info['stock_status'];
				} elseif ($this->config->get('config_stock_display')) {
					$stock = $product_info['quantity'];
				} else {
					$stock = $this->language->get('text_instock');
				}

				if ($this->customer->isLogged() || !$this->config->get('config_customer_price')) {
					$price = $this->currency->format($this->tax->calculate($product_info['price'], $product_info['tax_class_id'], $this->config->get('config_tax')), $this->session->data['currency']);
				} else {
					$price = false;
				}

				if ((float)$product_info['special']) {
					$special = $this->currency->format($this->tax->calculate($product_info['special'], $product_info['tax_class_id'], $this->config->get('config_tax')), $this->session->data['currency']);
				} else {
					$special = false;
				}

				$data['products'][] = array(
					'product_id' => $product_info['product_id'],
					'thumb'      => $image,
					'name'       => $product_info['name'],
					'model'      => $product_info['model'],
					'stock'      => $result['quantity'],
					'price'      => $price,
					'special'    => $special,
					'href'       => $this->url->link('product/product', 'product_id=' . $product_info['product_id']),
                    'remove'     => $this->url->link('account/stocksheet', 'remove=' . $product_info['sku'])
				);
			} else {
				$this->model_account_stocksheet->deleteStocksheet($result['sku']);
			}
		}

		$data['import_modal'] = $this->load->view('module/import_stocksheet');
		$data['button_import'] = $this->language->get('button_import');

		$data['continue'] = $this->url->link('account/account', '', true);

		$data['column_left'] = $this->load->controller('common/column_left');
		$data['column_right'] = $this->load->controller('common/column_right');
		$data['content_top'] = $this->load->controller('common/content_top');
		$data['content_bottom'] = $this->load->controller('common/content_bottom');
		$data['footer'] = $this->load->controller('common/footer');
		$data['header'] = $this->load->controller('common/header');

		$this->response->setOutput($this->load->view('account/stocksheet', $data));
	}

	public function add() {
		$this->load->language('account/stocksheet');

		$json = array();

		if (isset($this->request->post['product_id'])) {
			$product_id = $this->request->post['product_id'];
		} else {
			$product_id = 0;
		}

		$this->load->model('catalog/product');

		$product_info = $this->model_catalog_product->getProduct($product_id);

		if ($product_info) {
			if ($this->customer->isLogged()) {
				// Edit customers cart
				$this->load->model('account/stocksheet');

				$this->model_account_stocksheet->addStocksheet($product_info['sku']);

				$json['success'] = sprintf($this->language->get('text_success'), $this->url->link('product/product', 'product_id=' . (int)$this->request->post['product_id']), $product_info['name'], $this->url->link('account/stocksheet'));

				$json['total'] = sprintf($this->language->get('text_stocklist'), $this->model_account_stocksheet->getTotalWishlist());
			} else {
				if (!isset($this->session->data['wishlist'])) {
					$this->session->data['wishlist'] = array();
				}

				$this->session->data['wishlist'][] = $this->request->post['product_id'];

				$this->session->data['wishlist'] = array_unique($this->session->data['wishlist']);

				$json['success'] = sprintf($this->language->get('text_login'), $this->url->link('account/login', '', true), $this->url->link('account/register', '', true), $this->url->link('product/product', 'product_id=' . (int)$this->request->post['product_id']), $product_info['name'], $this->url->link('account/stocksheet'));

				$json['total'] = sprintf($this->language->get('text_wishlist'), (isset($this->session->data['wishlist']) ? count($this->session->data['wishlist']) : 0));
			}
		}

		$this->response->addHeader('Content-Type: application/json');
		$this->response->setOutput(json_encode($json));
    }
    
    public function addStocksheetToCart() {
		$this->cart->clear();	
		unset($this->session->data['shipping_method']);
		unset($this->session->data['shipping_methods']);
		unset($this->session->data['payment_method']);
		unset($this->session->data['payment_methods']);
		$this->load->language('account/stocksheet');
        $this->load->model('account/stocksheet');

		$results = $this->model_account_stocksheet->getStocksheet();

		if ($results) {
				
				foreach($results as $_product_info){
					$this->load->model('catalog/product');
                    $product_info = $this->model_catalog_product->getProductSku($_product_info['sku']);
					if ($product_info) {
						$option_data = array();
                        $this->load->model('account/order');
						$order_options = $this->model_account_order->getOrderOptions('1', $product_info['product_id']);

						foreach ($order_options as $order_option) {
							if ($order_option['type'] == 'select' || $order_option['type'] == 'radio' || $order_option['type'] == 'image') {
								$option_data[$order_option['product_option_id']] = $order_option['product_option_value_id'];
							} elseif ($order_option['type'] == 'checkbox') {
								$option_data[$order_option['product_option_id']][] = $order_option['product_option_value_id'];
							} elseif ($order_option['type'] == 'text' || $order_option['type'] == 'textarea' || $order_option['type'] == 'date' || $order_option['type'] == 'datetime' || $order_option['type'] == 'time') {
								$option_data[$order_option['product_option_id']] = $order_option['value'];
							} elseif ($order_option['type'] == 'file') {
								$option_data[$order_option['product_option_id']] = $this->encryption->encrypt($order_option['value']);
							}
						}

						$this->cart->add($product_info['product_id'], $_product_info['quantity'], $option_data);

                         $this->session->data['success'] = sprintf($this->language->get('text_success_cart'), $this->url->link('checkout/cart'));
                        
					} else {
						$this->session->data['error'] = sprintf($this->language->get('text_error_cart'), $product_info['name']);
					}

				}
		}
		
		$this->response->redirect($this->url->link('checkout/cart'));
	}

	public function import() {

		$this->load->language('account/stocksheet');
		$this->load->model('account/stocksheet');
		$this->load->model('catalog/product');

		set_time_limit(0);
		ini_set('memory_limit', '1G');
		ini_set("auto_detect_line_endings", true);

		$json     = array();
		$formats  = array('xls', 'xlsx', 'csv'); // supported file types
		$colHeads = array('product name', 'category', 'sku', 'model', 'quantity', 'stock', 'unit price', 'total'); // expected column headings
		$maxSize  = 5097152;  // maximum file size (5MB)

		if ($this->request->server['REQUEST_METHOD'] == 'POST') {

			if (isset($this->request->get['action'])) {

				switch ($this->request->get['action']) {

					/******************************************************
					 * Check and Upload file content
					 ******************************************************/

					case "upload":

						if (isset($this->request->files['import'] ) && is_uploaded_file($this->request->files['import']['tmp_name'])) {

							$file = $_FILES['import']['tmp_name'];
							$name = $this->request->files['import']['name'];
							$size = $this->request->files['import']['size'];
							$ext  = strtolower(pathinfo($name, PATHINFO_EXTENSION));

							if (!in_array($ext, $formats)) {

								/******************************************************
								 * File type error | type not supported
								 ******************************************************/

								$json['error'] = $this->language->get('import_file_type_error');

							} else {
								
								if ($size > $maxSize) {

									/******************************************************
									 * File size error | size limit exceeded
									 ******************************************************/

									$json['error'] = $this->language->get('import_file_size_error');

								} else {

									/******************************************************
									 * Perform file import
									 ******************************************************/	

									$inputFileName = $file;
									$inputFileType = PHPExcel_IOFactory::identify($inputFileName);
									$objReader     = PHPExcel_IOFactory::createReader($inputFileType);
									$objPHPExcel   = $objReader->load($inputFileName);
									$sheet         = $objPHPExcel->getSheet(0);
									$highestRow    = $sheet->getHighestRow();
									$highestColumn = $sheet->getHighestColumn();
									$detailsColumn = 2;
									$fields        = array();
									$dataRows      = array();
									$header        = array();
									$found         = true;

									for ($row = 1; $row <= 1; $row++) { 
										$header1 = $sheet->rangeToArray('A' . $row . ':' . $highestColumn . $row, NULL, FALSE, FALSE);
									}
									
									// Check if row has right data [not headings]
									if (!in_array(strtolower($header1[0][0]), $colHeads)) {
										$detailsColumn++;
										for ($row = 2; $row <= 2; $row++) {
											$header1 = $sheet->rangeToArray('A' . $row . ':' . $highestColumn . $row, NULL, FALSE, FALSE);
										}
									}
									
									foreach ($header1 as $key => $val) {
										$header = array_merge($val, $header);
									}

									for ($row = $detailsColumn; $row <= $highestRow; $row++) {
										$sheetdata1 = $sheet->rangeToArray('A' . $row . ':' . $highestColumn . $row, NULL, FALSE, FALSE);
										$sheetdata  = array();
										foreach ($sheetdata1 as $key => $val) {
											$sheetdata = array_merge($val, $sheetdata);
										}
										$dataRows[] = array_combine($header, $sheetdata);
									}
			
									$barcodes   = array();
									$quantities = array();
									$dataItems  = array();
			
									// loop through data rows [from imported file]
									foreach ($dataRows as $data) {
										if (!empty($data) && count($data) > 0) {
											// sku | model
											if (array_key_exists('SKU', $data)) {
												$skuKey = 'SKU';
											} else if (array_key_exists('sku', $data)) {
												$skuKey = 'sku';
											} else if (array_key_exists('Model', $data)) {
												$skuKey = 'Model';
											} else if (array_key_exists('model', $data)) {
												$skuKey = 'model';
											} else {
												$skuKey = 'sku';
											}

											// quantity | stock
											if (array_key_exists('Quantity', $data)) {
												$qtyKey = 'Quantity';
											} else if (array_key_exists('Stock', $data)) {
												$qtyKey = 'Stock';
											} else if (array_key_exists('stock', $data)) {
												$qtyKey = 'stock';
											} else {
												$qtyKey = 'quantity';
											}

											$barcode  = $data[$skuKey];      # sku/barcode
											$quantity = (int)$data[$qtyKey]; # quantity
											
											if (!empty($barcode)) {
												$barcodes[]   = (string)$barcode;
												$quantities[] = $quantity;
												$dataItems[]  = array('sku'=>(string)$barcode, 'quantity'=>$quantity);
											}
										}
									}
			
									// find multiple products from database
									$products      = $this->model_catalog_product->getProductsBySku(implode("','",$barcodes));
									$json['items'] = $dataItems;

									if (!empty($products) && is_array($products)) {
										foreach($dataItems as $key => $item) {
											$skuCode  = array_column($products, 'sku');
											$foundKey = array_search($item['sku'], $skuCode);
											if ($foundKey === false) {
												$json['not_found'][] = $item;
											} else {
												$json['found'][] = $item;
											}
										}
										if (empty($json['not_found'])) {
											$json['success'] = $this->language->get('text_upload_success');
										} else {
											$json['warning'] = sprintf($this->language->get('error_import_upload'), count($json['found']), count($json['items']));
										}
									} else {
										$json['error'] = $this->language->get('import_no_items_found_error');
									}
								}
							}
						}
						break;

					/******************************************************
					 * Validate import data
					 ******************************************************/

					case "validate":

						if (!empty($this->request->post['products']) && is_array($this->request->post['products'])) {

							$barcodes   = array();
							$quantities = array();

							foreach($this->request->post['products'] as $item) {
								$barcodes[]   = (string)$item['sku'];
								$quantities[] = $item['quantity'];
							}
							
							// find multiple products from database
							$products = $this->model_catalog_product->getProductsBySku(implode("','", $barcodes));

							if (!empty($products) && count($products) > 0) {
								$returnProducts = [];
								foreach($products as $k => &$product) {
									$key = array_search($product['sku'], $barcodes);
									if ($key !== false) {
										$product['import_quantity'] = $quantities[$key];
										$returnProducts[]           = $product;
									}
								}
								$json['products'] = json_encode($returnProducts);
								$json['success']  = $this->language->get('text_validate_success');
							}
						}
						
						break;

					/******************************************************
					 * Add products to cart
					 ******************************************************/
					
					case "add_to_stocksheet":

						if (!empty($this->request->post['products'])) {
							
							// convert json to array
							$decodedText = html_entity_decode($this->request->post['products']);
							$products    = json_decode($decodedText, true);

							if (is_array($products)) {

								// add products/items to stock sheet
								$this->model_account_stocksheet->bulkAddStocksheet($products);

								// success response
								$json['success'] = sprintf($this->language->get('import_success'), count($products).' item(s)');
								$json['total']   = sprintf($this->language->get('text_wishlist'), $this->model_account_wishlist->getTotalWishlist());
							}
						} else {
							$json['error'] = $this->language->get('error_import_stocksheet');
						}

						break;
				}
			}
		}
		if (!isset($json['success']) && !isset($json['error']) && !isset($json['warning'])) {
			$json['error'] = $this->language->get('import_generic_error');
		}
		$this->response->addHeader('Content-Type: application/json');
		$this->response->setOutput(json_encode($json));
	}
}
