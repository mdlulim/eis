<?php
class ControllerCheckoutCart extends Controller {
	public function index() {

		/*==================================
		=       Add Files (Includes)       =
		==================================*/

		# stylesheets (CSS) files
		$this->document->addStyle('admin/view/javascript/bootstrap-sweetalert/sweetalert.css');
		$this->document->addStyle('catalog/view/javascript/datatables/datatables.min.css');
		$this->document->addStyle('catalog/view/javascript/datatables/buttons/buttons.datatables.min.css');
		$this->document->addStyle('catalog/view/stylesheets/custom.css');
		$this->document->addStyle('catalog/view/stylesheets/checkout.css');

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
		$this->document->addScript('catalog/view/javascript/checkout.js');

		/*=====  End of Add Files (Includes)  ======*/
		

		$this->load->language('checkout/cart');

		$this->document->setTitle($this->language->get('heading_title'));

		$data['breadcrumbs'] = array();

		$data['breadcrumbs'][] = array(
			'href' => $this->url->link('common/home'),
			'text' => $this->language->get('text_home')
		);

		$data['breadcrumbs'][] = array(
			'href' => $this->url->link('checkout/cart'),
			'text' => $this->language->get('heading_title')
		);

		if ($this->cart->hasProducts() || !empty($this->session->data['vouchers'])) {
			$data['heading_title'] = $this->language->get('heading_title') . $this->language->get('button_import_to_cart');

			$data['text_recurring_item'] = $this->language->get('text_recurring_item');
			$data['text_next'] = $this->language->get('text_next');
			$data['text_next_choice'] = $this->language->get('text_next_choice');

			$data['column_image'] = $this->language->get('column_image');
			$data['column_name'] = $this->language->get('column_name');
			$data['column_model'] = $this->language->get('column_model');
			$data['column_quantity'] = $this->language->get('column_quantity');
			$data['column_price'] = $this->language->get('column_price');
			$data['column_total'] = $this->language->get('column_total');

			$data['button_update'] = $this->language->get('button_update');
			$data['button_remove'] = $this->language->get('button_remove');
			$data['button_shopping'] = $this->language->get('button_shopping');
			$data['button_checkout'] = $this->language->get('button_checkout');

			if (!$this->cart->hasStock() && (!$this->config->get('config_stock_checkout') || $this->config->get('config_stock_warning'))) {
				$data['error_warning'] = $this->language->get('error_stock');
			} elseif (isset($this->session->data['error'])) {
				$data['error_warning'] = $this->session->data['error'];

				unset($this->session->data['error']);
			} else {
				$data['error_warning'] = '';
			}

			if ($this->config->get('config_customer_price') && !$this->customer->isLogged()) {
				$data['attention'] = sprintf($this->language->get('text_login'), $this->url->link('account/login'), $this->url->link('account/register'));
			} else {
				$data['attention'] = '';
			}

			if (isset($this->session->data['success'])) {
				$data['success'] = $this->session->data['success'];

				unset($this->session->data['success']);
			} else {
				$data['success'] = '';
			}

			$data['action'] = $this->url->link('checkout/cart/edit', '', true);

			if ($this->config->get('config_cart_weight')) {
				$data['weight'] = $this->weight->format($this->cart->getWeight(), $this->config->get('config_weight_class_id'), $this->language->get('decimal_point'), $this->language->get('thousand_point'));
			} else {
				$data['weight'] = '';
			}

			$this->load->model('tool/image');
			$this->load->model('tool/upload');
			$this->load->model('catalog/product');

			// cart
			$cartProductIds = [];
			if ($this->cart->hasProducts()) {
				$cartProducts = $this->cart->getProducts();
				foreach ($cartProducts as $key => $value) {
					$cartProductIds[$value['product_id']] = $value['quantity'];
				}
			}

			$data['products'] = array();

			$products = $this->cart->getProducts();

			foreach ($products as $product) {
				$product_total = 0;

				foreach ($products as $product_2) {
					if ($product_2['product_id'] == $product['product_id']) {
						$product_total += $product_2['quantity'];
					}
				}

				if ($product['minimum'] > $product_total) {
					$data['error_warning'] = sprintf($this->language->get('error_minimum'), $product['name'], $product['minimum']);
				}

				if ($product['image']) {
					$image = $this->model_tool_image->resize($product['image'], $this->config->get($this->config->get('config_theme') . '_image_cart_width'), $this->config->get($this->config->get('config_theme') . '_image_cart_height'));
				} else {
					$image = $this->model_tool_image->resize('no_image.png', $this->config->get('config_image_cart_width'), $this->config->get('config_image_cart_height'));
				}

				$option_data = array();

				foreach ($product['option'] as $option) {
					if ($option['type'] != 'file') {
						$value = $option['value'];
					} else {
						$upload_info = $this->model_tool_upload->getUploadByCode($option['value']);

						if ($upload_info) {
							$value = $upload_info['name'];
						} else {
							$value = '';
						}
					}

					$option_data[] = array(
						'name'  => $option['name'],
						'value' => (utf8_strlen($value) > 20 ? utf8_substr($value, 0, 20) . '..' : $value)
					);
				}

				// Display prices
				if ($this->customer->isLogged() || !$this->config->get('config_customer_price')) {
					$unit_price = $this->tax->calculate($product['price'], $product['tax_class_id'], $this->config->get('config_tax'));
					
					$price = $this->currency->format($unit_price, $this->session->data['currency']);
					$total = $this->currency->format($unit_price * $product['quantity'], $this->session->data['currency']);
				} else {
					$price = false;
					$total = false;
				}

				$recurring = '';

				if ($product['recurring']) {
					$frequencies = array(
						'day'        => $this->language->get('text_day'),
						'week'       => $this->language->get('text_week'),
						'semi_month' => $this->language->get('text_semi_month'),
						'month'      => $this->language->get('text_month'),
						'year'       => $this->language->get('text_year'),
					);

					if ($product['recurring']['trial']) {
						$recurring = sprintf($this->language->get('text_trial_description'), $this->currency->format($this->tax->calculate($product['recurring']['trial_price'] * $product['quantity'], $product['tax_class_id'], $this->config->get('config_tax')), $this->session->data['currency']), $product['recurring']['trial_cycle'], $frequencies[$product['recurring']['trial_frequency']], $product['recurring']['trial_duration']) . ' ';
					}

					if ($product['recurring']['duration']) {
						$recurring .= sprintf($this->language->get('text_payment_description'), $this->currency->format($this->tax->calculate($product['recurring']['price'] * $product['quantity'], $product['tax_class_id'], $this->config->get('config_tax')), $this->session->data['currency']), $product['recurring']['cycle'], $frequencies[$product['recurring']['frequency']], $product['recurring']['duration']);
					} else {
						$recurring .= sprintf($this->language->get('text_payment_cancel'), $this->currency->format($this->tax->calculate($product['recurring']['price'] * $product['quantity'], $product['tax_class_id'], $this->config->get('config_tax')), $this->session->data['currency']), $product['recurring']['cycle'], $frequencies[$product['recurring']['frequency']], $product['recurring']['duration']);
					}
				}

				// get product category
				$category      = $this->model_catalog_product->getCategories($product['product_id']);
				$category_name = '';
				if (!empty($category)) {
					foreach ($category as $cat) {
						$category_name .= (empty($category_name)) ? $cat['name'] : ', '.$cat['name'];
					}
				}

				$data['products'][] = array(
					'product_id'=> $product['product_id'],
					'cart_id'   => $product['cart_id'],
					'thumb'     => $image,
					'name'      => $product['name'],
					'model'     => $product['model'],
            		'cart_qty' => (isset($cartProductIds[$product['product_id']])) ? $cartProductIds[$product['product_id']] : 0,
					'option'    => $option_data,
					'category'  => $category_name,
					'recurring' => $recurring,
					'quantity'  => $product['quantity'],
					'stock'     => $product['stock'] ? true : !(!$this->config->get('config_stock_checkout') || $this->config->get('config_stock_warning')),
					'reward'    => ($product['reward'] ? sprintf($this->language->get('text_points'), $product['reward']) : ''),
					'price'     => $price,
					'total'     => $total,
					'href'      => $this->url->link('product/product', 'product_id=' . $product['product_id'])
				);
			}

			// Gift Voucher
			$data['vouchers'] = array();

			if (!empty($this->session->data['vouchers'])) {
				foreach ($this->session->data['vouchers'] as $key => $voucher) {
					$data['vouchers'][] = array(
						'key'         => $key,
						'description' => $voucher['description'],
						'amount'      => $this->currency->format($voucher['amount'], $this->session->data['currency']),
						'remove'      => $this->url->link('checkout/cart', 'remove=' . $key)
					);
				}
			}

			// Totals
			$this->load->model('extension/extension');

			$totals = array();
			$taxes = $this->cart->getTaxes();
			$total = 0;
			
			// Because __call can not keep var references so we put them into an array. 			
			$total_data = array(
				'totals' => &$totals,
				'taxes'  => &$taxes,
				'total'  => &$total
			);
			
			// Display prices
			if ($this->customer->isLogged() || !$this->config->get('config_customer_price')) {
				$sort_order = array();

				$results = $this->model_extension_extension->getExtensions('total');

				foreach ($results as $key => $value) {
					$sort_order[$key] = $this->config->get($value['code'] . '_sort_order');
				}

				array_multisort($sort_order, SORT_ASC, $results);

				foreach ($results as $result) {
					if ($this->config->get($result['code'] . '_status')) {
						$this->load->model('extension/total/' . $result['code']);
						
						// We have to put the totals in an array so that they pass by reference.
						$this->{'model_extension_total_' . $result['code']}->getTotal($total_data);
					}
				}

				$sort_order = array();

				foreach ($totals as $key => $value) {
					$sort_order[$key] = $value['sort_order'];
				}

				array_multisort($sort_order, SORT_ASC, $totals);
			}

			$data['totals'] = array();

			foreach ($totals as $total) {
				$data['totals'][] = array(
					'title' => $total['title'],
					'text'  => $this->currency->format($total['value'], $this->session->data['currency'])
				);
			}

			$data['continue'] = $this->url->link('common/home');

			$data['checkout'] = $this->url->link('checkout/checkout', '', true);

			$this->load->model('extension/extension');

			$data['modules'] = array();
			
			$files = glob(DIR_APPLICATION . '/controller/extension/total/*.php');

			if ($files) {
				foreach ($files as $file) {
					$result = $this->load->controller('extension/total/' . basename($file, '.php'));
					
					if ($result) {
						$data['modules'][] = $result;
					}
				}
			}

			$data['column_left'] = $this->load->controller('common/column_left');
			$data['column_right'] = $this->load->controller('common/column_right');
			$data['content_top'] = $this->load->controller('common/content_top');
			$data['content_bottom'] = $this->load->controller('common/content_bottom');
			$data['import_modal'] = $this->load->view('module/import_cart');
			$data['footer'] = $this->load->controller('common/footer');
			$data['header'] = $this->load->controller('common/header');

			$this->response->setOutput($this->load->view('checkout/cart', $data));
		} else {
			$data['heading_title'] = $this->language->get('heading_title') . ' ' . $this->language->get('button_import_to_cart');

			$data['text_error'] = $this->language->get('text_empty');

			$data['button_continue'] = $this->language->get('button_continue');

			$data['continue'] = $this->url->link('common/home');

			unset($this->session->data['success']);

			$data['column_left'] = $this->load->controller('common/column_left');
			$data['column_right'] = $this->load->controller('common/column_right');
			$data['content_top'] = $this->load->controller('common/content_top');
			$data['content_bottom'] = $this->load->controller('common/content_bottom');
			$data['import_modal'] = $this->load->view('module/import_cart');
			$data['footer'] = $this->load->controller('common/footer');
			$data['header'] = $this->load->controller('common/header');

			$this->response->setOutput($this->load->view('error/not_found', $data));
		}
	}

	public function add() {
		$this->load->language('checkout/cart');

		$json = array();

		if (isset($this->request->post['product_id'])) {
			$product_id = (int)$this->request->post['product_id'];
		} else {
			$product_id = 0;
		}

		$this->load->model('catalog/product');

		$product_info = $this->model_catalog_product->getProduct($product_id);

		if ($product_info) {
			if (isset($this->request->post['quantity']) && ((int)$this->request->post['quantity'] >= $product_info['minimum'])) {
				$quantity = (int)$this->request->post['quantity'];
			} else {
				$quantity = $product_info['minimum'] ? $product_info['minimum'] : 1;
			}

			if (isset($this->request->post['option'])) {
				$option = array_filter($this->request->post['option']);
			} else {
				$option = array();
			}

			$product_options = $this->model_catalog_product->getProductOptions($this->request->post['product_id']);

			foreach ($product_options as $product_option) {
				if ($product_option['required'] && empty($option[$product_option['product_option_id']])) {
					$json['error']['option'][$product_option['product_option_id']] = sprintf($this->language->get('error_required'), $product_option['name']);
				}
			}

			if (isset($this->request->post['recurring_id'])) {
				$recurring_id = $this->request->post['recurring_id'];
			} else {
				$recurring_id = 0;
			}

			$recurrings = $this->model_catalog_product->getProfiles($product_info['product_id']);

			if ($recurrings) {
				$recurring_ids = array();

				foreach ($recurrings as $recurring) {
					$recurring_ids[] = $recurring['recurring_id'];
				}

				if (!in_array($recurring_id, $recurring_ids)) {
					$json['error']['recurring'] = $this->language->get('error_recurring_required');
				}
			}

			if (!$json) {
				$this->cart->add($this->request->post['product_id'], $quantity, $option, $recurring_id);


                if (strpos($this->config->get('config_template'), 'journal2') === 0) {
                    $this->load->model('tool/image');
                    $json['image'] = Journal2Utils::resizeImage($this->model_tool_image, $product_info['image'], $this->config->get('config_image_cart_width'), $this->config->get('config_image_cart_height'));
                }
            
				$json['success'] = sprintf($this->language->get('text_success'), $this->url->link('product/product', 'product_id=' . $this->request->post['product_id']), $product_info['name'], $this->url->link('checkout/cart'));

				// Unset all shipping and payment methods
				unset($this->session->data['shipping_method']);
				unset($this->session->data['shipping_methods']);
				unset($this->session->data['payment_method']);
				unset($this->session->data['payment_methods']);

				// Totals
				$this->load->model('extension/extension');

				$totals = array();
				$taxes = $this->cart->getTaxes();
				$total = 0;
		
				// Because __call can not keep var references so we put them into an array. 			
				$total_data = array(
					'totals' => &$totals,
					'taxes'  => &$taxes,
					'total'  => &$total
				);

				// Display prices
				if ($this->customer->isLogged() || !$this->config->get('config_customer_price')) {
					$sort_order = array();

					$results = $this->model_extension_extension->getExtensions('total');

					foreach ($results as $key => $value) {
						$sort_order[$key] = $this->config->get($value['code'] . '_sort_order');
					}

					array_multisort($sort_order, SORT_ASC, $results);

					foreach ($results as $result) {
						if ($this->config->get($result['code'] . '_status')) {
							$this->load->model('extension/total/' . $result['code']);

							// We have to put the totals in an array so that they pass by reference.
							$this->{'model_extension_total_' . $result['code']}->getTotal($total_data);
						}
					}

					$sort_order = array();

					foreach ($totals as $key => $value) {
						$sort_order[$key] = $value['sort_order'];
					}

					array_multisort($sort_order, SORT_ASC, $totals);
				}

				$json['total'] = sprintf($this->language->get('text_items'), $this->cart->countProducts() + (isset($this->session->data['vouchers']) ? count($this->session->data['vouchers']) : 0), $this->currency->format($total, $this->session->data['currency']));
			} else {
				$json['redirect'] = str_replace('&amp;', '&', $this->url->link('product/product', 'product_id=' . $this->request->post['product_id']));
			}
		}

		$this->response->addHeader('Content-Type: application/json');
		$this->response->setOutput(json_encode($json));
	}

	public function set() {
		$this->load->language('checkout/cart');
		$this->load->model('catalog/product');

		$json = array();

		if (isset($this->request->post['product_id'])) {
			$product_id = (int)$this->request->post['product_id'];
		} else {
			$product_id = 0;
		}

		// get product info
		$product_info = $this->model_catalog_product->getProduct($product_id);

		if (!empty($product_info)) {

			if (isset($this->request->post['quantity']) && ((int)$this->request->post['quantity'] >= $product_info['minimum'])) {
				$quantity = (int)$this->request->post['quantity'];
			} else {
				$quantity = $product_info['minimum'] ? $product_info['minimum'] : 1;
			}

			if (isset($this->request->post['option'])) {
				$option = array_filter($this->request->post['option']);
			} else {
				$option = array();
			}

			$product_options = $this->model_catalog_product->getProductOptions($this->request->post['product_id']);

			foreach ($product_options as $product_option) {
				if ($product_option['required'] && empty($option[$product_option['product_option_id']])) {
					$json['error']['option'][$product_option['product_option_id']] = sprintf($this->language->get('error_required'), $product_option['name']);
				}
			}

			if (isset($this->request->post['recurring_id'])) {
				$recurring_id = $this->request->post['recurring_id'];
			} else {
				$recurring_id = 0;
			}

			$recurrings = $this->model_catalog_product->getProfiles($product_info['product_id']);

			if ($recurrings) {
				$recurring_ids = array();

				foreach ($recurrings as $recurring) {
					$recurring_ids[] = $recurring['recurring_id'];
				}

				if (!in_array($recurring_id, $recurring_ids)) {
					$json['error']['recurring'] = $this->language->get('error_recurring_required');
				}
			}

			if (!$json) {
				$this->cart->set($this->request->post['product_id'], $quantity, $option, $recurring_id);

				if (isset($this->request->post['action']) && $this->request->post['action'] == "remove") {
					$textSuccess = $this->language->get('text_remove');
				} else {
					$textSuccess = $this->language->get('text_success');
				}

				$json['success'] = sprintf($textSuccess, $this->url->link('product/product', 'product_id=' . $this->request->post['product_id']), $product_info['name'], $this->url->link('checkout/cart'));

				// Unset all shipping and payment methods
				unset($this->session->data['shipping_method']);
				unset($this->session->data['shipping_methods']);
				unset($this->session->data['payment_method']);
				unset($this->session->data['payment_methods']);

				// Totals
				$this->load->model('extension/extension');

				$totals = array();
				$taxes = $this->cart->getTaxes();
				$total = 0;
		
				// Because __call can not keep var references so we put them into an array. 			
				$total_data = array(
					'totals' => &$totals,
					'taxes'  => &$taxes,
					'total'  => &$total
				);

				// Display prices
				if ($this->customer->isLogged() || !$this->config->get('config_customer_price')) {
					$sort_order = array();

					$results = $this->model_extension_extension->getExtensions('total');

					foreach ($results as $key => $value) {
						$sort_order[$key] = $this->config->get($value['code'] . '_sort_order');
					}

					array_multisort($sort_order, SORT_ASC, $results);

					foreach ($results as $result) {
						if ($this->config->get($result['code'] . '_status')) {
							$this->load->model('extension/total/' . $result['code']);

							// We have to put the totals in an array so that they pass by reference.
							$this->{'model_extension_total_' . $result['code']}->getTotal($total_data);
						}
					}

					$sort_order = array();

					foreach ($totals as $key => $value) {
						$sort_order[$key] = $value['sort_order'];
					}

					array_multisort($sort_order, SORT_ASC, $totals);
				}
				$json['currency'] = $this->session->data['currency'];
				$json['cart_total'] = $this->currency->format($total, $this->session->data['currency']);
				$json['total'] = sprintf($this->language->get('text_items'), $this->cart->countProducts() + (isset($this->session->data['vouchers']) ? count($this->session->data['vouchers']) : 0), $this->currency->format($total, $this->session->data['currency']));
			} else {
				$json['redirect'] = str_replace('&amp;', '&', $this->url->link('product/product', 'product_id=' . $this->request->post['product_id']));
			}
		}

		$this->response->addHeader('Content-Type: application/json');
		$this->response->setOutput(json_encode($json));
	}

	public function addcategory() {
		$this->load->language('checkout/cart');
		$this->load->model('catalog/product');

		$json = array();

		if (isset($this->request->post['category_id'])) {
			$category_id = (int)$this->request->post['category_id'];
		} else {
			$category_id = 0;
		}

		$filter_data = array(
			'filter_category_id' => $category_id,
			'filter_sub_category' => true
		);

		// get products by category
		$products = $this->model_catalog_product->getProducts($filter_data);
		$json['products'] = $products;
		$json['category_id'] = $category_id;

		// this might have to change later on
		$quantity = 0;

		if (!empty($products)) {
			foreach ($products as $key => $product) {

				if (!empty($product['product_id'])) {

					$product_info = $this->model_catalog_product->getProduct($product['product_id']);

					if (!empty($product_info)) {

						$this->cart->set($product['product_id'], $quantity);

						// Unset all shipping and payment methods
						unset($this->session->data['shipping_method']);
						unset($this->session->data['shipping_methods']);
						unset($this->session->data['payment_method']);
						unset($this->session->data['payment_methods']);

						// Totals
						$this->load->model('extension/extension');

						$totals = array();
						$taxes = $this->cart->getTaxes();
						$total = 0;
				
						// Because __call can not keep var references so we put them into an array. 			
						$total_data = array(
							'totals' => &$totals,
							'taxes'  => &$taxes,
							'total'  => &$total
						);

						// Display prices
						if ($this->customer->isLogged() || !$this->config->get('config_customer_price')) {
							$sort_order = array();

							$results = $this->model_extension_extension->getExtensions('total');

							foreach ($results as $key => $value) {
								$sort_order[$key] = $this->config->get($value['code'] . '_sort_order');
							}

							array_multisort($sort_order, SORT_ASC, $results);

							foreach ($results as $result) {
								if ($this->config->get($result['code'] . '_status')) {
									$this->load->model('extension/total/' . $result['code']);

									// We have to put the totals in an array so that they pass by reference.
									$this->{'model_extension_total_' . $result['code']}->getTotal($total_data);
								}
							}

							$sort_order = array();

							foreach ($totals as $key => $value) {
								$sort_order[$key] = $value['sort_order'];
							}

							array_multisort($sort_order, SORT_ASC, $totals);
						}
					}
				}
			}
			
			$json['success'] = sprintf($this->language->get('text_success'), $this->url->link('checkout/cart'), $this->cart->countProducts().' item(s)', $this->url->link('checkout/cart'));

			$json['total'] = sprintf($this->language->get('text_items'), $this->cart->countProducts() + (isset($this->session->data['vouchers']) ? count($this->session->data['vouchers']) : 0), $this->currency->format($total, $this->session->data['currency']));
		}

		$this->response->addHeader('Content-Type: application/json');
		$this->response->setOutput(json_encode($json));
	}

	public function edit() {
		$this->load->language('checkout/cart');

		$json = array();

		// Update
		if (!empty($this->request->post['quantity'])) {
			foreach ($this->request->post['quantity'] as $key => $value) {
				$this->cart->update($key, $value);
			}

			$this->session->data['success'] = $this->language->get('text_remove');

			unset($this->session->data['shipping_method']);
			unset($this->session->data['shipping_methods']);
			unset($this->session->data['payment_method']);
			unset($this->session->data['payment_methods']);
			unset($this->session->data['reward']);

			$this->response->redirect($this->url->link('checkout/cart'));
		}

		$this->response->addHeader('Content-Type: application/json');
		$this->response->setOutput(json_encode($json));
	}

	public function remove() {
		$this->load->language('checkout/cart');

		$json = array();

		// Remove
		if (isset($this->request->post['key'])) {
			$this->cart->remove($this->request->post['key']);

			unset($this->session->data['vouchers'][$this->request->post['key']]);

			$json['success'] = $this->language->get('text_remove');

			unset($this->session->data['shipping_method']);
			unset($this->session->data['shipping_methods']);
			unset($this->session->data['payment_method']);
			unset($this->session->data['payment_methods']);
			unset($this->session->data['reward']);

			// Totals
			$this->load->model('extension/extension');

			$totals = array();
			$taxes = $this->cart->getTaxes();
			$total = 0;

			// Because __call can not keep var references so we put them into an array. 			
			$total_data = array(
				'totals' => &$totals,
				'taxes'  => &$taxes,
				'total'  => &$total
			);

			// Display prices
			if ($this->customer->isLogged() || !$this->config->get('config_customer_price')) {
				$sort_order = array();

				$results = $this->model_extension_extension->getExtensions('total');

				foreach ($results as $key => $value) {
					$sort_order[$key] = $this->config->get($value['code'] . '_sort_order');
				}

				array_multisort($sort_order, SORT_ASC, $results);

				foreach ($results as $result) {
					if ($this->config->get($result['code'] . '_status')) {
						$this->load->model('extension/total/' . $result['code']);

						// We have to put the totals in an array so that they pass by reference.
						$this->{'model_extension_total_' . $result['code']}->getTotal($total_data);
					}
				}

				$sort_order = array();

				foreach ($totals as $key => $value) {
					$sort_order[$key] = $value['sort_order'];
				}

				array_multisort($sort_order, SORT_ASC, $totals);
			}

			$json['total'] = sprintf($this->language->get('text_items'), $this->cart->countProducts() + (isset($this->session->data['vouchers']) ? count($this->session->data['vouchers']) : 0), $this->currency->format($total, $this->session->data['currency']));
		}

		$this->response->addHeader('Content-Type: application/json');
		$this->response->setOutput(json_encode($json));
	}

	public function import_old() {
		$this->load->language('checkout/cart');
		$this->load->model('catalog/product');
		$this->load->model('extension/extension');

		set_time_limit(0);
		ini_set('memory_limit', '1G');
		ini_set("auto_detect_line_endings", true);

		$json     = array();
		$formats  = array('xls', 'xlsx', 'csv'); // supported file types
		$colHeads = array('Product Name', 'Category', 'SKU', 'Quantity', 'Unit Price', 'Total'); // expected column headings
		$maxSize  = 5097152;  // maximum file size (5MB)

		if ($this->request->server['REQUEST_METHOD'] == 'POST') {

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
						if (!in_array($header1[0][0], $colHeads)) {
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

						/******************************************************
						 * Add imported content to cart
						 ******************************************************/

						$barcodes   = array();
						$quantities = array();
						$dataItems  = array();

						// loop through data rows [from imported file]
						foreach ($dataRows as $data) {
							if (!empty($data) && count($data) > 0) {
								
								$barcode  = $data['SKU'];           # sku/barcode
								$quantity = (int)$data['Quantity']; # quantity
								
								if (!empty($barcode) && !empty($quantity) && is_numeric($quantity)) {
									$barcodes[]   = $barcode;
									$quantities[] = $quantity;
								}
							}
						}

						// find multiple products from database
						$products = $this->model_catalog_product->getProductsBySku(implode("','",$barcodes));

						if (!empty($products) && count($products) > 0) {

							// Unset all shipping and payment methods
							unset($this->session->data['shipping_method']);
							unset($this->session->data['shipping_methods']);
							unset($this->session->data['payment_method']);
							unset($this->session->data['payment_methods']);

							$found = true;

							// clear first before import
							$this->cart->clear();

							// loop through products
							foreach($products as $product) {

								if ($key = array_search($product['sku'], $barcodes)) {

									// get quantity
									$quantity = $quantities[$key];

									$this->cart->set($product['product_id'], $quantity);

									$totals = array();
									$taxes  = $this->cart->getTaxes();
									$total  = 0;
							
									// Because __call can not keep var references so we put them into an array. 			
									$totalData = array(
										'totals' => &$totals,
										'taxes'  => &$taxes,
										'total'  => &$total
									);

									// Display prices
									if ($this->customer->isLogged() || !$this->config->get('config_customer_price')) {
										$sortOrder = array();

										$results = $this->model_extension_extension->getExtensions('total');

										foreach ($results as $key => $value) {
											$sortOrder[$key] = $this->config->get($value['code'] . '_sort_order');
										}

										array_multisort($sortOrder, SORT_ASC, $results);

										foreach ($results as $result) {
											if ($this->config->get($result['code'] . '_status')) {
												$this->load->model('extension/total/' . $result['code']);

												// We have to put the totals in an array so that they pass by reference.
												$this->{'model_extension_total_' . $result['code']}->getTotal($totalData);
											}
										}

										$sortOrder = array();

										foreach ($totals as $key => $value) {
											$sortOrder[$key] = $value['sort_order'];
										}

										array_multisort($sortOrder, SORT_ASC, $totals);
									}
								}
							}
						}

						if (isset($found) && $found) {
							$json['success'] = sprintf($this->language->get('import_success'), $this->cart->countProducts().' item(s)');
							$json['total']   = sprintf($this->language->get('text_items'), $this->cart->countProducts() + (isset($this->session->data['vouchers']) ? count($this->session->data['vouchers']) : 0), $this->currency->format($total, $this->session->data['currency']));
							$json['records'] = $dataRows;
							$json['headers'] = $header;
							$json['found']   = $products;
						} else {
							if (!isset($json['error'])) {
								$json['error'] = $this->language->get('import_generic_error');
							}
						}
					}
				}
			}
		}

		$this->response->addHeader('Content-Type: application/json');
		$this->response->setOutput(json_encode($json));
	}

	public function items_not_found() {

		if (!empty($this->request->post['items'])) {
							
			// convert json to array
			$decodedText   = html_entity_decode($this->request->post['items']);
			$data['items'] = json_decode($decodedText, true);
		
			/*==================================
			=       Add Files (Includes)       =
			==================================*/

			# stylesheets (CSS) files
			$this->document->addStyle('catalog/view/javascript/datatables/datatables.min.css');
			$this->document->addStyle('catalog/view/javascript/datatables/buttons/buttons.datatables.min.css');
			$this->document->addStyle('catalog/view/stylesheets/custom.css');
			$this->document->addStyle('catalog/view/stylesheets/checkout.css');

			# javascript (JS) files
			$this->document->addScript('catalog/view/javascript/datatables/datatables.min.js');
			$this->document->addScript('catalog/view/javascript/datatables/buttons/datatables.buttons.min.js');
			$this->document->addScript('catalog/view/javascript/datatables/buttons/buttons.flash.min.js');
			$this->document->addScript('catalog/view/javascript/jszip/jszip.min.js');
			$this->document->addScript('catalog/view/javascript/pdfmake/pdfmake.min.js');
			$this->document->addScript('catalog/view/javascript/pdfmake/vfs_fonts.js');
			$this->document->addScript('catalog/view/javascript/datatables/buttons/buttons.html5.min.js');
			$this->document->addScript('catalog/view/javascript/checkout.js');

			/*=====  End of Add Files (Includes)  ======*/
			

			$this->load->language('checkout/cart');

			$this->document->setTitle($this->language->get('heading_title'));

			/******************************************************
			 * Breadcrumbs
			 ******************************************************/

			$data['breadcrumbs'] = array();

			$data['breadcrumbs'][] = array(
				'href' => $this->url->link('common/home'),
				'text' => $this->language->get('text_home')
			);

			$data['breadcrumbs'][] = array(
				'href' => $this->url->link('checkout/cart'),
				'text' => $this->language->get('heading_title')
			);

			/******************************************************
			 * Output content
			 ******************************************************/
			
			$data['heading_title']   = $this->language->get('heading_title');
			$data['error_warning']   = $this->language->get('warning_import_items_not_found');
			$data['button_continue'] = $this->language->get('button_continue');
			$data['continue']        = $this->url->link('common/home');

			$data['column_left']     = $this->load->controller('common/column_left');
			$data['column_right']    = $this->load->controller('common/column_right');
			$data['content_top']     = $this->load->controller('common/content_top');
			$data['content_bottom']  = $this->load->controller('common/content_bottom');
			$data['footer']          = $this->load->controller('common/footer');
			$data['header']          = $this->load->controller('common/header');

			$this->response->setOutput($this->load->view('checkout/cart_import_items', $data));
		}
	}

	public function import() {

		$this->load->language('checkout/cart');
		$this->load->model('catalog/product');
		$this->load->model('extension/extension');

		set_time_limit(0);
		ini_set('memory_limit', '1G');
		ini_set("auto_detect_line_endings", true);

		$json     = array();
		$formats  = array('xls', 'xlsx', 'csv'); // supported file types
		$colHeads = array('Product Name', 'Category', 'SKU', 'Quantity', 'Unit Price', 'Total'); // expected column headings
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
									if (!in_array($header1[0][0], $colHeads)) {
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
											
											$barcode  = $data['SKU'];           # sku/barcode
											$quantity = (int)$data['Quantity']; # quantity
											
											if (!empty($barcode) && !empty($quantity) && is_numeric($quantity)) {
												$barcodes[]   = $barcode;
												$quantities[] = $quantity;
												$dataItems[]  = array('sku'=>$barcode, 'quantity'=>$quantity);
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
								$barcodes[]   = $item['sku'];
								$quantities[] = $item['quantity'];
							}
							
							// find multiple products from database
							$products = $this->model_catalog_product->getProductsBySku(implode("','", $barcodes));

							if (!empty($products) && count($products) > 0) {
								$returnProducts = [];
								foreach($products as $k => &$product) {
									$key = array_search($product['sku'], $barcodes);
									if ($key !== false) {
										$product['cart_import_quantity'] = $quantities[$key];
										$returnProducts[]                = $product;
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
					
					case "add_to_cart":

						if (!empty($this->request->post['products'])) {
							
							// convert json to array
							$decodedText = html_entity_decode($this->request->post['products']);
							$products    = json_decode($decodedText, true);

							if (is_array($products)) {

								// Unset all shipping and payment methods
								unset($this->session->data['shipping_method']);
								unset($this->session->data['shipping_methods']);
								unset($this->session->data['payment_method']);
								unset($this->session->data['payment_methods']);
	
								// clear first before import
								$this->cart->clear();

								foreach($products as $product) {
									if (!empty($product['cart_import_quantity'])) {

										// add item to cart
										$this->cart->add($product['product_id'], $product['cart_import_quantity']);
										
										$totals = array();
										$taxes  = $this->cart->getTaxes();
										$total  = 0;
								
										// Because __call can not keep var references so we put them into an array. 			
										$totalData = array(
											'totals' => &$totals,
											'taxes'  => &$taxes,
											'total'  => &$total
										);

										// Display prices
										if ($this->customer->isLogged() || !$this->config->get('config_customer_price')) {
											$sortOrder = array();

											$results = $this->model_extension_extension->getExtensions('total');

											foreach ($results as $key => $value) {
												$sortOrder[$key] = $this->config->get($value['code'] . '_sort_order');
											}

											array_multisort($sortOrder, SORT_ASC, $results);

											foreach ($results as $result) {
												if ($this->config->get($result['code'] . '_status')) {
													$this->load->model('extension/total/' . $result['code']);

													// We have to put the totals in an array so that they pass by reference.
													$this->{'model_extension_total_' . $result['code']}->getTotal($totalData);
												}
											}

											$sortOrder = array();

											foreach ($totals as $key => $value) {
												$sortOrder[$key] = $value['sort_order'];
											}

											array_multisort($sortOrder, SORT_ASC, $totals);
										}
									}
								}
								$json['success'] = sprintf($this->language->get('import_success'), $this->cart->countProducts().' item(s)');
								$json['total']   = sprintf($this->language->get('text_items'), $this->cart->countProducts() + (isset($this->session->data['vouchers']) ? count($this->session->data['vouchers']) : 0), $this->currency->format($total, $this->session->data['currency']));
							}
						} else {
							$json['error'] = $this->language->get('error_import_cart');
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
