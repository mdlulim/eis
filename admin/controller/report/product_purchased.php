<?php
class ControllerReportProductPurchased extends Controller {
	public function index() {
		$this->load->language('report/product_purchased');

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
		$this->document->addScript('view/javascript/report/product_purchased.js');

		/*=====  End of Add Files (Includes)  ======*/

		$this->document->setTitle($this->language->get('heading_title'));
		$filter = false;
		
		/*******************************************
		 * Filters
		 *******************************************/
		$filter = false;
        
		// return DATE FROM filter
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
		// return Order status filter
		if (isset($this->request->get['filter_order_status_id'])) {
			$data['filter_order_status_id'] = $this->request->get['filter_order_status_id'];
			$url                      .= '&filter_order_status_id=' . $data['filter_order_status_id'];
			$filter                    = true;
		} else {
			$data['filter_order_status_id'] = '';
		}
		if (isset($this->request->get['page'])) {
			$page = $this->request->get['page'];
		} else {
			$page = 1;
		}

		$url = '';

		if (isset($this->request->get['page'])) {
			$url .= '&page=' . $this->request->get['page'];
		}

		$data['breadcrumbs'] = array();

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('text_home'),
			'href' => $this->url->link(getDashboard($this->user), 'token=' . $this->session->data['token'], true)
		);

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('heading_title'),
			'href' => $this->url->link('report/product_purchased', 'token=' . $this->session->data['token'] . $url, true)
		);

		$this->load->model('report/product');

		$data['products'] = array();

		if ($filter) {
			$data['results'] = true;
			$filter_data = array(
				'filter_date_start'	      => date('Y-m-d', strtotime($data['filter_date_start'])),
				'filter_date_end'	      => date('Y-m-d', strtotime($data['filter_date_end'])),
				'filter_order_status_id'       => $data['filter_order_status_id'],
				'start' => ($page - 1) * $this->config->get('config_limit_admin'),
				'limit' => $this->config->get('config_limit_admin')
			);

			$product_total = $this->model_report_product->getTotalPurchased($filter_data);
			$results = $this->model_report_product->getPurchased($filter_data);

			foreach ($results as $result) {
				$data['products'][] = array(
					'name'       => $result['name'],
					'model'      => $result['model'],
					'quantity'   => $result['quantity'],
					'total'      => $this->currency->format($result['total'], $this->config->get('config_currency'))
				);
			}
		}

		$data['heading_title'] = $this->language->get('heading_title');
		$data['filter'] = $filter;
		$data['text_list'] = $this->language->get('text_list');
		$data['text_no_results'] = $this->language->get('text_no_results');
		$data['text_confirm'] = $this->language->get('text_confirm');
		$data['text_all_status'] = $this->language->get('text_all_status');

		$data['column_name'] = $this->language->get('column_name');
		$data['column_model'] = $this->language->get('column_model');
		$data['column_quantity'] = $this->language->get('column_quantity');
		$data['column_total'] = $this->language->get('column_total');

		$data['entry_date_start'] = $this->language->get('entry_date_start');
		$data['entry_date_end'] = $this->language->get('entry_date_end');
		$data['entry_status'] = $this->language->get('entry_status');

		$data['button_filter'] = $this->language->get('button_filter');

		$data['token'] = $this->session->data['token'];

		$this->load->model('localisation/order_status');

		$data['order_statuses'] = $this->model_localisation_order_status->getOrderStatuses();

		$url = '';

		if (isset($this->request->get['filter_date_start'])) {
			$url .= '&filter_date_start=' . $this->request->get['filter_date_start'];
		}

		if (isset($this->request->get['filter_date_end'])) {
			$url .= '&filter_date_end=' . $this->request->get['filter_date_end'];
		}

		if (isset($this->request->get['filter_order_status_id'])) {
			$url .= '&filter_order_status_id=' . $this->request->get['filter_order_status_id'];
		}

		$pagination = new Pagination();
		$pagination->total = $product_total;
		$pagination->page = $page;
		$pagination->limit = $this->config->get('config_limit_admin');
		$pagination->url = $this->url->link('report/product_purchased', 'token=' . $this->session->data['token'] . $url . '&page={page}', true);

		$data['pagination'] = $pagination->render();

		$data['results'] = sprintf($this->language->get('text_pagination'), ($product_total) ? (($page - 1) * $this->config->get('config_limit_admin')) + 1 : 0, ((($page - 1) * $this->config->get('config_limit_admin')) > ($product_total - $this->config->get('config_limit_admin'))) ? $product_total : ((($page - 1) * $this->config->get('config_limit_admin')) + $this->config->get('config_limit_admin')), $product_total, ceil($product_total / $this->config->get('config_limit_admin')));

		$data['filter_date_start'] = $data['filter_date_start'];
		$data['filter_date_end'] = $data['filter_date_end'];
		$data['filter_order_status_id'] = $data['filter_order_status_id'];

		$data['header'] = $this->load->controller('common/header');
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['footer'] = $this->load->controller('common/footer');

		$this->response->setOutput($this->load->view('report/product_purchased_new', $data));
	}
}