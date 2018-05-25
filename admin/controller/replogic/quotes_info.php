<?php 
class ControllerReplogicQuotesInfo extends Controller {
	private $error = array();

	public function index() {
		$this->load->language('replogic/order_quotes');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->getForm();
	}

	public function getForm() {
		
		$this->load->model('replogic/order_quotes');
		$this->load->model('sale/order');
		$this->load->model('customer/customer');
		$this->load->model('replogic/customer_contact');
		$this->load->model('replogic/sales_rep_management');
		$this->load->model('catalog/product');
		
		$data['heading_title'] = $this->language->get('heading_title');

		$data['text_form'] = !isset($this->request->get['quote_id']) ? $this->language->get('text_add') : $this->language->get('text_edit');
		$data['text_no_results'] = $this->language->get('text_no_results');
		$data['text_default'] = $this->language->get('text_default');
		$data['text_select'] = $this->language->get('text_select');
		$data['text_none'] = $this->language->get('text_none');
		$data['text_loading'] = $this->language->get('text_loading');
		$data['text_ip_add'] = sprintf($this->language->get('text_ip_add'), $this->request->server['REMOTE_ADDR']);
		$data['text_product'] = $this->language->get('text_product');
		$data['text_voucher'] = $this->language->get('text_voucher');
		$data['text_order_detail'] = $this->language->get('text_order_detail');

		$data['entry_store'] = $this->language->get('entry_store');
		$data['entry_customer'] = $this->language->get('entry_customer');
		$data['entry_customer_group'] = $this->language->get('entry_customer_group');
		$data['entry_firstname'] = $this->language->get('entry_firstname');
		$data['entry_lastname'] = $this->language->get('entry_lastname');
		$data['entry_email'] = $this->language->get('entry_email');
		$data['entry_telephone'] = $this->language->get('entry_telephone');
		$data['entry_fax'] = $this->language->get('entry_fax');
		$data['entry_comment'] = $this->language->get('entry_comment');
		$data['entry_affiliate'] = $this->language->get('entry_affiliate');
		$data['entry_address'] = $this->language->get('entry_address');
		$data['entry_company'] = $this->language->get('entry_company');
		$data['entry_address_1'] = $this->language->get('entry_address_1');
		$data['entry_address_2'] = $this->language->get('entry_address_2');
		$data['entry_city'] = $this->language->get('entry_city');
		$data['entry_postcode'] = $this->language->get('entry_postcode');
		$data['entry_zone'] = $this->language->get('entry_zone');
		$data['entry_zone_code'] = $this->language->get('entry_zone_code');
		$data['entry_country'] = $this->language->get('entry_country');
		$data['entry_product'] = $this->language->get('entry_product');
		$data['entry_option'] = $this->language->get('entry_option');
		$data['entry_quantity'] = $this->language->get('entry_quantity');
		$data['entry_to_name'] = $this->language->get('entry_to_name');
		$data['entry_to_email'] = $this->language->get('entry_to_email');
		$data['entry_from_name'] = $this->language->get('entry_from_name');
		$data['entry_from_email'] = $this->language->get('entry_from_email');
		$data['entry_theme'] = $this->language->get('entry_theme');
		$data['entry_message'] = $this->language->get('entry_message');
		$data['entry_amount'] = $this->language->get('entry_amount');
		$data['entry_currency'] = $this->language->get('entry_currency');
		$data['entry_shipping_method'] = $this->language->get('entry_shipping_method');
		$data['entry_payment_method'] = $this->language->get('entry_payment_method');
		$data['entry_coupon'] = $this->language->get('entry_coupon');
		$data['entry_voucher'] = $this->language->get('entry_voucher');
		$data['entry_reward'] = $this->language->get('entry_reward');
		$data['entry_order_status'] = $this->language->get('entry_order_status');

		$data['column_product'] = $this->language->get('column_product');
		$data['column_image'] = 'Image';
		$data['column_model'] = $this->language->get('column_model');
		$data['column_quantity'] = $this->language->get('column_quantity');
		$data['column_price'] = $this->language->get('column_price');
		$data['column_total'] = $this->language->get('column_total');
		$data['column_action'] = $this->language->get('column_action');

		$data['button_save'] = $this->language->get('button_save');
		$data['button_cancel'] = $this->language->get('button_cancel');
		$data['button_continue'] = $this->language->get('button_continue');
		$data['button_back'] = $this->language->get('button_back');
		$data['button_refresh'] = $this->language->get('button_refresh');
		$data['button_product_add'] = $this->language->get('button_product_add');
		$data['button_voucher_add'] = $this->language->get('button_voucher_add');
		$data['button_apply'] = $this->language->get('button_apply');
		$data['button_upload'] = $this->language->get('button_upload');
		$data['button_remove'] = $this->language->get('button_remove');
		$data['button_ip_add'] = $this->language->get('button_ip_add');

		$data['tab_order'] = $this->language->get('tab_order');
		$data['tab_customer'] = $this->language->get('tab_customer');
		$data['tab_payment'] = $this->language->get('tab_payment');
		$data['tab_shipping'] = $this->language->get('tab_shipping');
		$data['tab_product'] = $this->language->get('tab_product');
		$data['tab_voucher'] = $this->language->get('tab_voucher');
		$data['tab_total'] = $this->language->get('tab_total');

		// quote statuses
		$data['quote_status_pending'] = $this->language->get('quote_status_pending_id');
		$data['quote_status_converted'] = $this->language->get('quote_status_converted_id');
		$data['quote_status_denied'] = $this->language->get('quote_status_denied_id');

		$url = '';

		if (isset($this->request->get['filter_quote_id'])) {
			$url .= '&filter_quote_id=' . $this->request->get['filter_quote_id'];
		}

		if (isset($this->request->get['filter_customer'])) {
			$url .= '&filter_customer=' . urlencode(html_entity_decode($this->request->get['filter_customer'], ENT_QUOTES, 'UTF-8'));
		}
		
		if (isset($this->request->get['filter_customer_id'])) {
			$url .= '&filter_customer_id=' . urlencode(html_entity_decode($this->request->get['filter_customer_id'], ENT_QUOTES, 'UTF-8'));
		}
		
		if (isset($this->request->get['filter_salesrepid'])) {
			$url .= '&filter_salesrepid=' . $this->request->get['filter_salesrepid'];
		}
		
		if (isset($this->request->get['filter_customer_contact_id'])) {
			$url .= '&filter_customer_contact_id=' . $this->request->get['filter_customer_contact_id'];
		}
		
		if (isset($this->request->get['filter_customer_contact'])) {
			$url .= '&filter_customer_contact=' . urlencode(html_entity_decode($this->request->get['filter_customer_contact'], ENT_QUOTES, 'UTF-8'));
		}

		if (isset($this->request->get['filter_order_status'])) {
			$url .= '&filter_order_status=' . $this->request->get['filter_order_status'];
		}

		if (isset($this->request->get['filter_date_added'])) {
			$url .= '&filter_date_added=' . $this->request->get['filter_date_added'];
		}

		if (isset($this->request->get['filter_date_modified'])) {
			$url .= '&filter_date_modified=' . $this->request->get['filter_date_modified'];
		}

		if (isset($this->request->get['sort'])) {
			$url .= '&sort=' . $this->request->get['sort'];
		}

		if (isset($this->request->get['order'])) {
			$url .= '&order=' . $this->request->get['order'];
		}

		if (isset($this->request->get['page'])) {
			$url .= '&page=' . $this->request->get['page'];
		}
		
		$data['breadcrumbs'] = array();

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('text_home'),
			'href' => $this->url->link('common/dashboard', 'token=' . $this->session->data['token'], true)
		);

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('heading_title'),
			'href' => $this->url->link('replogic/order_quotes', 'token=' . $this->session->data['token'] . $url, true)
		);

		$data['cancel'] = $this->url->link('replogic/order_quotes', 'token=' . $this->session->data['token'] . $url, true);
		$data['decline']  = $this->url->link('replogic/order_quotes/decline', 'token=' . $this->session->data['token'] . $url, true);
		
		$data['store_url'] = $this->request->server['HTTPS'] ? HTTPS_CATALOG : HTTP_CATALOG;
		$data['store_name'] = $this->config->get('config_name');
		

		$data['token'] = $this->session->data['token'];

		$quote_id = $this->request->get['quote_id'];
		$quote_info = $this->model_replogic_order_quotes->getOrderquote($this->request->get['quote_id']);
		
		// if($quote_info['status'] == 0)
		// {
		// 	$this->model_replogic_order_quotes->statuschange($quote_id,3);
		// }
		
		$data['Qdate_added'] = date('d M, Y', strtotime($quote_info['date_added']));
		$data['store_url'] = $this->request->server['HTTPS'] ? HTTPS_CATALOG : HTTP_CATALOG;
		$data['store_name'] = $this->config->get('config_name');
		
		$data['comment'] = $quote_info['comments'];
		$data['qstatus'] = $quote_info['status'];
		$data['quote_status'] = $quote_info['quote_status'];
		
		$cust_con = $this->model_replogic_customer_contact->getcustomercontact($quote_info['customer_contact_id']);
		
		$cust = $this->model_customer_customer->getCustomer($quote_info['customer_id']);
		
		$this->load->model('customer/customer_group');
    	$customer_group_info = $this->model_customer_customer_group->getCustomerGroup($cust['customer_group_id']);
		if ($customer_group_info) {
			$data['customer_group'] = $customer_group_info['name'];
		} else {
			$data['customer_group'] = '';
		}
		
		$data['customer_group_id'] = $cust['customer_group_id'];
		$data['customer_id'] = $quote_info['customer_id'];
		$data['customer_contact_id'] = $quote_info['customer_contact_id'];
		
		$salesrep = $this->model_replogic_sales_rep_management->getsalesrep($quote_info['salesrep_id']);
		
		$data['addresses'] = $this->model_customer_customer->getAddresses($quote_info['customer_id']);
		$data['address_id'] = $cust['address_id'];
		
		$data['shipaddress'] = $this->model_customer_customer->getAddress($cust['address_id']);
		
		$this->load->model('localisation/country');

		$data['countries'] = $this->model_localisation_country->getCountries();
		$data['shipping_zone_id'] = '';
		
		$data['ssfirstname'] = $salesrep['salesrep_name'];
		$data['sslastname'] = $salesrep['salesrep_lastname'];
		
		$data['firstname'] = $cust['firstname'];
		$data['lastname'] = $cust['lastname'];
		$data['telephone'] = $cust['telephone'];
		$data['email'] = $cust['email'];
		
		$data['ccfirstname'] = $cust_con['first_name'];
		$data['cclastname'] = $cust_con['last_name'];
		$data['ccemail'] = $cust_con['email'];
		$data['cctelephone'] = $cust_con['telephone_number'];
		$data['quote_id'] = $quote_id;
		
		$data['access'] = false;
			
			$data['products'] = array();
			$objct = json_decode($quote_info['cart']);
			$array = (array) $objct;
			//print_r($array); exit;
			$products = $array['cart_items'];
			
			foreach ($products as $product) { 
				$singleproduct = $this->model_catalog_product->getProduct($product->id);
				
				$this->load->model('tool/image');
				$iquery = $this->db->query("SELECT image FROM " . DB_PREFIX . "product WHERE product_id = '" . $product->id . "'");
				if (is_file(DIR_IMAGE . $iquery->row['image'])) {
					$image = $this->model_tool_image->resize($iquery->row['image'], 40, 40);
				} else {
					$image = $this->model_tool_image->resize('tsc_image.png', 40, 40);
				}
				$data['products'][] = array(
					'product_id' => $product->id,
					'name'       => $product->name,
					'sku'      => $product->sku,
					'model'      => $singleproduct['model'],
					'option'     => '',
					'quantity'   => $product->qty,
					'image'   		   => $image,
					'price'      => $this->currency->format($product->unit_price, 'ZAR', '1.0000'),
					'total'      => $this->currency->format($product->total_price, 'ZAR', '1.0000'),
					'href'     		   => $this->url->link('catalog/product/edit', 'token=' . $this->session->data['token'] . '&product_id=' . $product->id, true),
					'reward'     => ''
				);
			}
			//print_r($data['order_products']); exit;
			$data['vouchers'] = array();
			$data['totals'] = $this->currency->format($array['cart_total_price'], 'ZAR', '1.0000');
			
			// The URL we send API requests to
			$data['catalog'] = $this->request->server['HTTPS'] ? HTTPS_CATALOG : HTTP_CATALOG;
		
		$this->load->model('user/api');

		$api_info = $this->model_user_api->getApi($this->config->get('config_api_id'));

		if ($api_info) {
			
			$data['api_id'] = $api_info['api_id'];
			$data['api_key'] = $api_info['key'];
			$data['api_ip'] = $this->request->server['REMOTE_ADDR'];
		} else {
			$data['api_id'] = '';
			$data['api_key'] = '';
			$data['api_ip'] = '';
		}

		$data['header'] = $this->load->controller('common/header');
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['footer'] = $this->load->controller('common/footer');

		$this->response->setOutput($this->load->view('replogic/order_quotes_details', $data));
	}

}
