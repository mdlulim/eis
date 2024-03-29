<?php
class ControllerReportProductViewed extends Controller {
	public function index() {
		$this->load->language('report/product_viewed');

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
		$this->document->addScript('view/javascript/report/product_viewed.js');

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
		// return Product Name filter
		if (isset($this->request->get['filter_product_id'])) {
			$data['filter_product_id'] = $this->request->get['filter_product_id'];
			$url                      .= '&filter_product_id=' . $data['filter_product_id'];
			$filter                    = true;
		} else {
			$data['filter_product_id'] = '';
		}
		
		// return Model filter
		if (isset($this->request->get['filter_model'])) {
			$data['filter_model'] = $this->request->get['filter_model'];
			$url                      .= '&filter_model=' . $data['filter_model'];
			$filter                    = true;
		} else {
			$data['filter_model'] = '';
		}


		if (isset($this->request->get['page'])) {
			$page = $this->request->get['page'];
		} else {
			$page = 1;
		}
		
		// if (isset($this->request->get['filter_product_id'])) {
		// 	$filter_product_id = $this->request->get['filter_product_id'];
		// } else {
		// 	$filter_product_id = null;
		// }
		
		// if (isset($this->request->get['filter_model'])) {
		// 	$filter_model = $this->request->get['filter_model'];
		// } else {
		// 	$filter_model = null;
		// }
		
		// $url = '';
		
		// if (isset($this->request->get['filter_product_id'])) {
		// 	$url .= '&filter_product_id=' . $this->request->get['filter_product_id'];
		// }
		
		// if (isset($this->request->get['filter_model'])) {
		// 	$url .= '&filter_model=' . urlencode(html_entity_decode($this->request->get['filter_model'], ENT_QUOTES, 'UTF-8'));
		// }
		
		// if (isset($this->request->get['page'])) {
		// 	$url .= '&page=' . $this->request->get['page'];
		// }

		$data['breadcrumbs'] = array();

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('text_home'),
			'href' => $this->url->link(getDashboard($this->user), 'token=' . $this->session->data['token'], true)
		);

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('heading_title'),
			'href' => $this->url->link('report/product_viewed', 'token=' . $this->session->data['token'] . $url, true)
		);

		$this->load->model('report/product');


		$data['products'] = array();
		$data['results'] = false;
        
		if ($filter) {
			$data['results'] = true;
			$filter_data = array(
				'filter_date_start'	      => date('Y-m-d', strtotime($data['filter_date_start'])),
				'filter_date_end'	      => date('Y-m-d', strtotime($data['filter_date_end'])),
				'filter_product_id'       => $data['filter_order_status'],
				'filter_model'            => $data['filter_order_status'],
				'start' => ($page - 1) * $this->config->get('config_limit_admin'),
				'limit' => $this->config->get('config_limit_admin')
			);

			$product_viewed_total = $this->model_report_product->getTotalProductViews();
			$product_total = $this->model_report_product->getTotalProductsViewed($product_viewed);
			$results = $this->model_report_product->getProductsViewed($filter_data);

			foreach ($results as $result) {
				if ($result['viewed']) {
					$percent = round($result['viewed'] / $product_viewed_total * 100, 2);
				} else {
					$percent = 0;
				}
	
				$data['products'][] = array(
					'name'    => $result['name'],
					'model'   => $result['model'],
					'viewed'  => $result['viewed'],
					'percent' => $percent . '%'
				);
			}
		}
		
		
		$this->load->model('catalog/product');
		$data['filter'] = $filter;
		$data['Dorpdownproducts'] = $this->model_catalog_product->getProducts();
		$data['dropdownmodels'] = $this->model_catalog_product->getProductsModel();

		$data['heading_title'] = $this->language->get('heading_title');

		$data['text_list'] = $this->language->get('text_list');
		$data['text_no_results'] = $this->language->get('text_no_results');
		$data['text_confirm'] = $this->language->get('text_confirm');

		$data['column_name'] = $this->language->get('column_name');
		$data['column_model'] = $this->language->get('column_model');
		$data['column_viewed'] = $this->language->get('column_viewed');
		$data['column_percent'] = $this->language->get('column_percent');

		$data['button_reset'] = $this->language->get('button_reset');
		$data['token'] = $this->session->data['token'];

		$url = '';
		
		if (isset($this->request->get['filter_product_id'])) {
			$url .= '&filter_product_id=' . $this->request->get['filter_product_id'];
		}
		
		if (isset($this->request->get['filter_model'])) {
			$url .= '&filter_model=' . urlencode(html_entity_decode($this->request->get['filter_model'], ENT_QUOTES, 'UTF-8'));
		}
		
		if (isset($this->request->get['page'])) {
			$url .= '&page=' . $this->request->get['page'];
		}

		$data['reset'] = $this->url->link('report/product_viewed/reset', 'token=' . $this->session->data['token'] . $url, true);

		if (isset($this->session->data['error'])) {
			$data['error_warning'] = $this->session->data['error'];

			unset($this->session->data['error']);
		} elseif (isset($this->error['warning'])) {
			$data['error_warning'] = $this->error['warning'];
		} else {
			$data['error_warning'] = '';
		}

		if (isset($this->session->data['success'])) {
			$data['success'] = $this->session->data['success'];

			unset($this->session->data['success']);
		} else {
			$data['success'] = '';
		}

		$pagination = new Pagination();
		$pagination->total = $product_total;
		$pagination->page = $page;
		$pagination->limit = $this->config->get('config_limit_admin');
		$pagination->url = $this->url->link('report/product_viewed', 'token=' . $this->session->data['token'] . '&page={page}', true);

		$data['pagination'] = $pagination->render();

		$data['results'] = sprintf($this->language->get('text_pagination'), ($product_total) ? (($page - 1) * $this->config->get('config_limit_admin')) + 1 : 0, ((($page - 1) * $this->config->get('config_limit_admin')) > ($product_total - $this->config->get('config_limit_admin'))) ? $product_total : ((($page - 1) * $this->config->get('config_limit_admin')) + $this->config->get('config_limit_admin')), $product_total, ceil($product_total / $this->config->get('config_limit_admin')));
		
		$data['filter_product_id'] = $filter_product_id;
		$data['filter_model'] = $filter_model;
		
		$data['header'] = $this->load->controller('common/header');
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['footer'] = $this->load->controller('common/footer');

		$this->response->setOutput($this->load->view('report/product_viewed_new', $data));
	}

	public function reset() {
		$this->load->language('report/product_viewed');

		if (!$this->user->hasPermission('modify', 'report/product_viewed')) {
			$this->session->data['error'] = $this->language->get('error_permission');
		} else {
			$this->load->model('report/product');

			$this->model_report_product->reset();

			$this->session->data['success'] = $this->language->get('text_success');
		}

		$this->response->redirect($this->url->link('report/product_viewed_new', 'token=' . $this->session->data['token'], true));
	}
}