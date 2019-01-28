<?php
class ControllerReportSaleOrder extends Controller {
	public function index() {
		$this->load->language('report/sale_order');

		/*==================================
		=       Add Files (Includes)       =
		==================================*/

		# stylesheets (CSS) files
		$this->document->addStyle('view/javascript/datatables/datatables.min.css');
		$this->document->addStyle('view/javascript/bootstrap-sweetalert/sweetalert.css');
		$this->document->addStyle('view/javascript/daterangepicker/daterangepicker.min.css');
		$this->document->addStyle('view/javascript/bootstrap-select/bootstrap-select.min.css');
		$this->document->addStyle('view/stylesheet/report.css');

		# javascript (JS) files
		$this->document->addScript('view/javascript/datatables/datatables.min.js');
		$this->document->addScript('view/javascript/datatables/buttons/datatables.buttons.min.js');
		$this->document->addScript('view/javascript/datatables/buttons/buttons.flash.min.js');
		$this->document->addScript('view/javascript/datatables/buttons/buttons.print.min.js');
		$this->document->addScript('view/javascript/datatables/buttons/buttons.colVis.min.js');
		$this->document->addScript('view/javascript/jszip/jszip.min.js');
		$this->document->addScript('view/javascript/pdfmake/pdfmake.min.js');
		$this->document->addScript('view/javascript/pdfmake/vfs_fonts.js');
		$this->document->addScript('view/javascript/datatables/buttons/buttons.html5.min.js');

		$this->document->addScript('view/javascript/bootstrap-sweetalert/sweetalert.min.js');
		$this->document->addScript('view/javascript/bootstrap-sweetalert/sweetalert-data.js');
		$this->document->addScript('view/javascript/moment/moment.min.js');
		$this->document->addScript('view/javascript/daterangepicker/daterangepicker.min.js');
		$this->document->addScript('view/javascript/bootstrap-select/bootstrap-select.min.js');
		$this->document->addScript('view/javascript/report/sale_order.js');

		/*=====  End of Add Files (Includes)  ======*/

		$this->document->setTitle($this->language->get('heading_title'));
		
		$url    = '';
		$filter = false;

		/*******************************************
		 * Filters
		 *******************************************/

		// Order DATE FROM filter
		if (isset($this->request->get['filter_date_start'])) {
			$data['filter_date_start'] = $this->request->get['filter_date_start'];
			$url                      .= '&filter_date_start=' . $data['filter_date_start'];
			$filter                    = true;
		} else {
			$data['filter_date_start'] = '';
		}

		// Order DATE TO filter
		if (isset($this->request->get['filter_date_end'])) {
			$data['filter_date_end'] = $this->request->get['filter_date_end'];
			$url                    .= '&filter_date_end=' . $data['filter_date_end'];
			$filter                  = true;
		} else {
			$data['filter_date_end'] = '';
		}

		// Order STATUS filter
		if (isset($this->request->get['filter_order_status'])) {
			$data['filter_order_status'] = $this->request->get['filter_order_status'];
			$url                        .= '&filter_order_status=' . $data['filter_order_status'];
			$filter                      = true;
		} else {
			$data['filter_order_status'] = 0;
		}

		// PAYMENT METHOD filter
		if (isset($this->request->get['filter_payment_method'])) {
			$data['filter_payment_method'] = $this->request->get['filter_payment_method'];
			$url                          .= '&filter_payment_method=' . $data['filter_payment_method'];
			$filter                        = true;
		} else {
			$data['filter_payment_method'] = 0;
		}

		// SHIPPING METHOD filter
		if (isset($this->request->get['filter_shipping_method'])) {
			$data['filter_shipping_method'] = $this->request->get['filter_shipping_method'];
			$url                           .= '&filter_shipping_method=' . $data['filter_shipping_method'];
			$filter                         = true;
		} else {
			$data['filter_shipping_method'] = 0;
		}

		// SALESREP filter
		if (isset($this->request->get['filter_salesrep'])) {
			$data['filter_salesrep'] = $this->request->get['filter_salesrep'];
			$url                    .= '&filter_salesrep=' . $data['filter_salesrep'];
			$filter                  = true;
		} else {
			$data['filter_salesrep'] = '';
		}

		// SALES MANAGER filter
		if (isset($this->request->get['filter_sales_manager'])) {
			$data['filter_sales_manager'] = $this->request->get['filter_sales_manager'];
			$url                         .= '&filter_sales_manager=' . $data['filter_sales_manager'];
			$filter                       = true;
		} else {
			$data['filter_sales_manager'] = '';
		}
		

		/*******************************************
		 * Order statuses
		 *******************************************/

		$this->load->model('localisation/order_status');
		$data['order_statuses']    = $this->model_localisation_order_status->getOrderStatuses();
		

		/*******************************************
		 * Breadcrumbs
		 *******************************************/

		$data['breadcrumbs']   = array();
		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('text_home'),
			'href' => $this->url->link(getDashboard($this->user), 'token=' . $this->session->data['token'], true)
		);
		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('heading_title'),
			'href' => $this->url->link('report/sale_order', 'token=' . $this->session->data['token'] . $url, true)
		);

		/*******************************************
		 * Get sales reps
		 *******************************************/
		
		$this->load->model('replogic/sales_rep_management');
		$data['salesreps'] = $this->model_replogic_sales_rep_management->getSalesReps(array(), true);
		

		/*******************************************
		 * Get sales managers
		 *******************************************/

		$this->load->model('user/user_group');
		$this->load->model('user/user');
		$user_group_id          = $this->model_user_user_group->getUserGroupByName('Sales Manager');
		$data['sales_managers'] = $this->model_user_user->getUsersByGroupId($user_group_id['user_group_id']);
		

		/*******************************************
		 * Get payment methods
		 *******************************************/

		$data['payment_methods'] = $this->getPayments();
		

		/*******************************************
		 * Get shipping methods
		 *******************************************/

		$data['shipping_methods'] = $this->getShipping();


		/*******************************************
		 * Get orders
		 *******************************************/

		$this->load->model('report/sale');

		$data['orders']  = array();
		$data['results'] = false;

		if ($filter) {
			$data['results'] = true;
			$filter_data     = array(
				'filter_date_start'	      => date('Y-m-d', strtotime($data['filter_date_start'])),
				'filter_date_end'	      => date('Y-m-d', strtotime($data['filter_date_end'])),
				'filter_order_status_id'  => $data['filter_order_status'],
				'filter_payment_method'   => $data['filter_payment_method'],
				'filter_shipping_method'  => $data['filter_shipping_method'],
				'filter_salesrep'         => $data['filter_salesrep'],
				'filter_sales_manager'    => $data['filter_sales_manager']
			);

			$results = $this->model_report_sale->getOrders($filter_data);
			foreach ($results as $result) {
				$data['orders'][] = array(
					'date_start' => date('d F Y', strtotime($result['date_start'])),
					'date_end'   => date('d F Y', strtotime($result['date_end'])),
					'orders'     => $result['orders'],
					'products'   => $result['products'],
					'tax'        => $this->currency->format($result['tax'], $this->config->get('config_currency')),
					'total'      => $this->currency->format($result['total'], $this->config->get('config_currency'))
				);
			}
		}
        $data['heading_title']     =$this->language->get('heading_title');
		$data['report_title']      = $this->language->get('text_report_title');
		$data['report_heading_title']= $this->language->get('report_heading_title');
		$data['text_list']         = $this->language->get('text_list');
		$data['text_no_results']   = $this->language->get('text_no_results');
		$data['text_confirm']      = $this->language->get('text_confirm');
		$data['text_all_status']   = $this->language->get('text_all_status');

		$data['column_date_start'] = $this->language->get('column_date_start');
		$data['column_date_end']   = $this->language->get('column_date_end');
		$data['column_orders']     = $this->language->get('column_orders');
		$data['column_products']   = $this->language->get('column_products');
		$data['column_tax']        = $this->language->get('column_tax');
		$data['column_total']      = $this->language->get('column_total');

		$data['entry_date_start']  = $this->language->get('entry_date_start');
		$data['entry_date_end']    = $this->language->get('entry_date_end');
		$data['entry_group']       = $this->language->get('entry_group');
		$data['entry_status']      = $this->language->get('entry_status');

		$data['button_filter']     = $this->language->get('button_filter');
		$data['token']             = $this->session->data['token'];

		$data['header']      = $this->load->controller('common/header');
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['footer']      = $this->load->controller('common/footer');

		$this->response->setOutput($this->load->view('report/sale_order_new', $data));
	}

	public function getPayments() {

		$this->load->model('extension/extension');

		$extensions = $this->model_extension_extension->getInstalled('payment');

		foreach ($extensions as $key => $value) {
			if (!is_file(DIR_APPLICATION . 'controller/extension/payment/' . $value . '.php') && !is_file(DIR_APPLICATION . 'controller/payment/' . $value . '.php')) {
				$this->model_extension_extension->uninstall('payment', $value);

				unset($extensions[$key]);
			}
		}

		$data['extensions'] = array();

		// Compatibility code for old extension folders
		$files = glob(DIR_APPLICATION . 'controller/{extension/payment,payment}/*.php', GLOB_BRACE);

		if ($files) {
			foreach ($files as $file) {
				$extension = basename($file, '.php');

				$this->load->language('extension/payment/' . $extension);

				$text_link = $this->language->get('text_' . $extension);

				if ($text_link != 'text_' . $extension) {
					$link = $this->language->get('text_' . $extension);
				} else {
					$link = '';
				}

				$data['extensions'][] = array(
					'name'       => $this->language->get('heading_title'),
					'link'       => $link,
					'code'       => $extension,
					'status'     => $this->config->get($extension . '_status') ? $this->language->get('text_enabled') : $this->language->get('text_disabled'),
					'sort_order' => $this->config->get($extension . '_sort_order'),
					'install'    => $this->url->link('extension/extension/payment/install', 'token=' . $this->session->data['token'] . '&extension=' . $extension, true),
					'uninstall'  => $this->url->link('extension/extension/payment/uninstall', 'token=' . $this->session->data['token'] . '&extension=' . $extension, true),
					'installed'  => in_array($extension, $extensions),
					'edit'       => $this->url->link('extension/payment/' . $extension, 'token=' . $this->session->data['token'], true)
				);
			}
		}
		return $data['extensions'];
	}

	public function getShipping() {

		$this->load->model('extension/extension');

		$extensions = $this->model_extension_extension->getInstalled('shipping');

		foreach ($extensions as $key => $value) {
			if (!is_file(DIR_APPLICATION . 'controller/extension/shipping/' . $value . '.php') && !is_file(DIR_APPLICATION . 'controller/shipping/' . $value . '.php')) {
				$this->model_extension_extension->uninstall('shipping', $value);

				unset($extensions[$key]);
			}
		}

		$data['extensions'] = array();

		// Compatibility code for old extension folders
		$files = glob(DIR_APPLICATION . 'controller/{extension/shipping,shipping}/*.php', GLOB_BRACE);

		if ($files) {
			foreach ($files as $file) {
				$extension = basename($file, '.php');

				$this->load->language('extension/shipping/' . $extension);

				$data['extensions'][] = array(
					'name'       => $this->language->get('heading_title'),
					'code'       => $extension,
					'status'     => $this->config->get($extension . '_status') ? $this->language->get('text_enabled') : $this->language->get('text_disabled'),
					'sort_order' => $this->config->get($extension . '_sort_order'),
					'install'    => $this->url->link('extension/extension/shipping/install', 'token=' . $this->session->data['token'] . '&extension=' . $extension, true),
					'uninstall'  => $this->url->link('extension/extension/shipping/uninstall', 'token=' . $this->session->data['token'] . '&extension=' . $extension, true),
					'installed'  => in_array($extension, $extensions),
					'edit'       => $this->url->link('extension/shipping/' . $extension, 'token=' . $this->session->data['token'], true)
				);
			}
		}
		
		return $data['extensions'];
	}
}
