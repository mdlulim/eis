<?php
class ControllerSaleOrder extends Controller {
	private $error = array();
	public function index() {

		/*==================================
		=       Add Files (Includes)       =
		==================================*/

		# stylesheets (CSS) files
		$this->document->addStyle('view/stylesheet/custom.css');
		$this->document->addStyle('view/stylesheet/order.css');

		# javascript (JS) files
		$this->document->addScript('view/javascript/functions.js');
		$this->document->addScript('view/javascript/order_list.js');

		/*=====  End of Add Files (Includes)  ======*/

		$this->load->language('sale/order');
		$this->document->setTitle($this->language->get('heading_title'));
		$this->load->model('sale/order');
		$this->getList();
	}

	public function add() {

		/*==================================
		=       Add Files (Includes)       =
		==================================*/

		# stylesheets (CSS) files
		$this->document->addStyle('view/javascript/bootstrap-sweetalert/sweetalert.css');
		$this->document->addStyle('view/stylesheet/custom.css');
		$this->document->addStyle('view/stylesheet/order.css');

		# javascript (JS) files
		$this->document->addScript('view/javascript/bootstrap-sweetalert/sweetalert.min.js');
		$this->document->addScript('view/javascript/bootstrap-sweetalert/sweetalert-data.js');
		$this->document->addScript('view/javascript/functions.js');
		$this->document->addScript('view/javascript/order_add.js');

		/*=====  End of Add Files (Includes)  ======*/

		$this->load->language('sale/order');
		$this->document->setTitle($this->language->get('heading_title'));
		$this->load->model('sale/order');
		$this->getForm('order_add');
	}

	public function processing() {

		/*==================================
		=       Add Files (Includes)       =
		==================================*/

		# stylesheets (CSS) files
		$this->document->addStyle('view/javascript/bootstrap-sweetalert/sweetalert.css');
		$this->document->addStyle('view/stylesheet/custom.css');
		$this->document->addStyle('view/stylesheet/order.css');

		# javascript (JS) files
		$this->document->addScript('view/javascript/bootstrap-sweetalert/sweetalert.min.js');
		$this->document->addScript('view/javascript/bootstrap-sweetalert/sweetalert-data.js');
		$this->document->addScript('view/javascript/functions.js');
		$this->document->addScript('view/javascript/order_processing.js');

		/*=====  End of Add Files (Includes)  ======*/

		$this->load->language('sale/order');
		$this->document->setTitle($this->language->get('heading_title'));
		$this->load->model('sale/order');
		$this->getForm('order_processing');
	}

	public function edit() {

		/*==================================
		=       Add Files (Includes)       =
		==================================*/

		# stylesheets (CSS) files
		$this->document->addStyle('view/javascript/bootstrap-sweetalert/sweetalert.css');
		$this->document->addStyle('view/stylesheet/custom.css');
		$this->document->addStyle('view/stylesheet/order.css');

		# javascript (JS) files
		$this->document->addScript('view/javascript/bootstrap-sweetalert/sweetalert.min.js');
		$this->document->addScript('view/javascript/bootstrap-sweetalert/sweetalert-data.js');
		$this->document->addScript('view/javascript/functions.js');
		$this->document->addScript('view/javascript/order_edit.js');

		/*=====  End of Add Files (Includes)  ======*/

		$this->load->language('sale/order');
		$this->document->setTitle($this->language->get('heading_title'));
		$this->load->model('sale/order');
		$this->getForm('order_edit');
	}
	
	public function delete() {
		$this->load->language('sale/order');
		$this->document->setTitle($this->language->get('heading_title'));
		$this->load->model('sale/order');
		if (isset($this->request->post['selected']) && $this->validate()) {
			foreach ($this->request->post['selected'] as $order_id) {
				$this->model_sale_order->deleteOrder($order_id);
			}
			$this->session->data['success'] = $this->language->get('text_success');
			$url = '';
			if (isset($this->request->get['filter_order_id'])) {
				$url .= '&filter_order_id=' . $this->request->get['filter_order_id'];
			}
	
			if (isset($this->request->get['filter_customer'])) {
				$url .= '&filter_customer=' . urlencode(html_entity_decode($this->request->get['filter_customer'], ENT_QUOTES, 'UTF-8'));
			}
			
			if (isset($this->request->get['filter_customer_id'])) {
				$url .= '&filter_customer_id=' . $this->request->get['filter_customer_id'];
			}
			
			if (isset($this->request->get['filter_customer_contactid'])) {
				$url .= '&filter_customer_contactid=' . $this->request->get['filter_customer_contactid'];
			}
			
			if (isset($this->request->get['filter_salesrepid'])) {
				$url .= '&filter_salesrepid=' . $this->request->get['filter_salesrepid'];
			}
	
			if (isset($this->request->get['filter_order_status'])) {
				$url .= '&filter_order_status=' . $this->request->get['filter_order_status'];
			}
	
			if (isset($this->request->get['filter_total'])) {
				$url .= '&filter_total=' . $this->request->get['filter_total'];
			}
	
			if (isset($this->request->get['filter_date_added'])) {
				$url .= '&filter_date_added=' . $this->request->get['filter_date_added'];
			}
	
			if (isset($this->request->get['filter_date_modified'])) {
				$url .= '&filter_date_modified=' . $this->request->get['filter_date_modified'];
			}
			$this->response->redirect($this->url->link('sale/order', 'token=' . $this->session->data['token'] . $url, true));
		}
		$this->getList();
	}
	
	protected function getList() {
		if (isset($this->request->get['filter_order_id'])) {
			$filter_order_id = $this->request->get['filter_order_id'];
		} else {
			$filter_order_id = null;
		}
		if (isset($this->request->get['filter_customer'])) {
			$filter_customer = $this->request->get['filter_customer'];
		} else {
			$filter_customer = null;
		}
		
		if (isset($this->request->get['filter_customer_id'])) {
			$filter_customer_id = $this->request->get['filter_customer_id'];
		} else {
			$filter_customer_id = null;
		}
		
		if (isset($this->request->get['filter_customer_contactid'])) {
			$filter_customer_contactid = $this->request->get['filter_customer_contactid'];
		} else {
			$filter_customer_contactid = null;
		}
		
		if (isset($this->request->get['filter_salesrepid'])) {
			$filter_salesrepid = $this->request->get['filter_salesrepid'];
		} else {
			$filter_salesrepid = null;
		}
		if (isset($this->request->get['filter_order_status'])) {
			$filter_order_status = $this->request->get['filter_order_status'];
		} else {
			$filter_order_status = null;
		}
		if (isset($this->request->get['filter_total'])) {
			$filter_total = $this->request->get['filter_total'];
		} else {
			$filter_total = null;
		}
		if (isset($this->request->get['filter_date_added'])) {
			$filter_date_added = $this->request->get['filter_date_added'];
		} else {
			$filter_date_added = null;
		}
		if (isset($this->request->get['filter_date_modified'])) {
			$filter_date_modified = $this->request->get['filter_date_modified'];
		} else {
			$filter_date_modified = null;
		}
		if (isset($this->request->get['sort'])) {
			$sort = $this->request->get['sort'];
		} else {
			$sort = 'o.order_id';
		}
		if (isset($this->request->get['order'])) {
			$order = $this->request->get['order'];
		} else {
			$order = 'DESC';
		}
		if (isset($this->request->get['page'])) {
			$page = $this->request->get['page'];
		} else {
			$page = 1;
		}
		$url = '';
		if (isset($this->request->get['filter_order_id'])) {
			$url .= '&filter_order_id=' . $this->request->get['filter_order_id'];
		}
		if (isset($this->request->get['filter_customer'])) {
			$url .= '&filter_customer=' . urlencode(html_entity_decode($this->request->get['filter_customer'], ENT_QUOTES, 'UTF-8'));
		}
		
		if (isset($this->request->get['filter_customer_id'])) {
			$url .= '&filter_customer_id=' . $this->request->get['filter_customer_id'];
		}
		
		if (isset($this->request->get['filter_customer_contactid'])) {
			$url .= '&filter_customer_contactid=' . $this->request->get['filter_customer_contactid'];
		}
		
		if (isset($this->request->get['filter_salesrepid'])) {
			$url .= '&filter_salesrepid=' . $this->request->get['filter_salesrepid'];
		}
		
		if (isset($this->request->get['filter_order_status'])) {
			$url .= '&filter_order_status=' . $this->request->get['filter_order_status'];
		}
		if (isset($this->request->get['filter_total'])) {
			$url .= '&filter_total=' . $this->request->get['filter_total'];
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
			'href' => $this->url->link(getDashboard($this->user), 'token=' . $this->session->data['token'], true)
		);
		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('heading_title'),
			'href' => $this->url->link('sale/order', 'token=' . $this->session->data['token'] . $url, true)
		);
		$data['invoice'] = $this->url->link('sale/order/invoice', 'token=' . $this->session->data['token'], true);
		$data['shipping'] = $this->url->link('sale/order/shipping', 'token=' . $this->session->data['token'], true);
		$data['add'] = $this->url->link('sale/order/add', 'token=' . $this->session->data['token'], true);
		$data['delete'] = $this->url->link('sale/order/delete', 'token=' . $this->session->data['token'], true);
		$data['orders'] = array();
		$filter_data = array(
			'filter_order_id'      => $filter_order_id,
			'filter_customer'	   => $filter_customer,
			'filter_customer_id'   => $filter_customer_id,
			'filter_customer_contactid'   => $filter_customer_contactid,
			'filter_salesrep_id'	   => $filter_salesrepid,
			'filter_order_status'  => $filter_order_status,
			'filter_total'         => $filter_total,
			'filter_date_added'    => $filter_date_added,
			'filter_date_modified' => $filter_date_modified,
			'sort'                 => $sort,
			'order'                => $order,
			'start'                => ($page - 1) * $this->config->get('config_limit_admin'),
			'limit'                => $this->config->get('config_limit_admin')
		);
		$order_total = $this->model_sale_order->getTotalOrders($filter_data);
		$results = $this->model_sale_order->getOrders($filter_data);
		$this->load->model('customer/customer');
		$this->load->model('replogic/sales_rep_management');
		foreach ($results as $result) {
			
			$ord = $this->model_sale_order->getOrder($result['order_id']);
			$cstdetails = $this->model_customer_customer->getCustomer($ord['customer_id']);
			$salesrep = @$this->model_replogic_sales_rep_management->getsalesrep($cstdetails['salesrep_id']);
			$salesrepname = @$salesrep['salesrep_name'].' '.@$salesrep['salesrep_lastname'];
			
			$time = strtotime($result['date_added']);
			$date_added = date("d F, Y g:i A", $time);
			
			$time1 = strtotime($result['date_modified']);
			$date_modified = date("d F, Y g:i A", $time1);
			
			$cname = !empty($result['customer']) ? $result['customer'] : $result['firstname'];
			
			$data['orders'][] = array(
				'order_id'        => $result['order_id'],
				'customercontact' => $result['customercontact'],
				'customer'        => $cname,
				'salesrep'        => $salesrepname,
				'order_status_id' => $ord['order_status_id'],
				'order_status'    => $result['order_status'] ? $result['order_status'] : $this->language->get('text_missing'),
				'total'           => $this->currency->format($result['total'], $result['currency_code'], $result['currency_value']),
				'date_added'      => $date_added,
				'date_modified'   => $date_modified,
				'shipping_code'   => $result['shipping_code'],
				'view'            => $this->url->link('sale/order/info', 'token=' . $this->session->data['token'] . '&order_id=' . $result['order_id'] . $url, true),
				'edit'            => $this->url->link('sale/order/edit', 'token=' . $this->session->data['token'] . '&order_id=' . $result['order_id'] . $url, true)
			);
		}
		
		
		
		$this->load->model('replogic/sales_rep_management');
		$this->load->model('replogic/customer_contact');
		$this->load->model('user/user_group');
		$this->load->model('user/user');
		$current_user = $this->session->data['user_id'];
		$current_user_group_id = $this->model_user_user->getUser($current_user);
		$current_user_group = $this->model_user_user_group->getUserGroup($current_user_group_id['user_group_id']);
		
		if($current_user_group_id['user_group_id'] == '15' || $current_user_group_id['user_group_id'] == '19')
		{
			$allaccess = true;
			$current_user_id = 0;
		}
		else
		{ 
			$allaccess = false;
			$current_user_id = $this->session->data['user_id'];
			
		}

		$data['customers'] = $this->model_customer_customer->getCustomers($filter_data, false, $current_user_id);

		$data['salesrepnames'] = $this->model_replogic_sales_rep_management->getSalesRepsDropdown($allaccess, $current_user_id);
		$data['customercontacts'] = $this->model_replogic_customer_contact->getcustomercontacts();
		
		if($filter_customer_contactid)
		{
			$customercontactinfo = $this->model_replogic_customer_contact->getcustomercontact($filter_customer_contactid);
			$data['filter_customercontact'] = $customercontactinfo['first_name'] ." ". $customercontactinfo['last_name'];
		}
		else
		{
			$data['filter_customercontact'] = '';
		}
		
		if($filter_salesrepid)
		{
			$salesreinfo = $this->model_replogic_sales_rep_management->getsalesrep($filter_salesrepid);
			$data['filter_salesrep'] = $salesreinfo['salesrep_name'] . ' ' . $salesreinfo['salesrep_lastname'];
		}
		else
		{
			$data['filter_salesrep'] = '';
		}
		
		$data['heading_title'] = $this->language->get('heading_title');
		$data['text_list'] = $this->language->get('text_list');
		$data['text_no_results'] = $this->language->get('text_no_results');
		$data['text_confirm'] = $this->language->get('text_confirm');
		$data['text_missing'] = $this->language->get('text_missing');
		$data['text_loading'] = $this->language->get('text_loading');
		$data['column_order_id'] = $this->language->get('column_order_id');
		$data['column_customer'] = $this->language->get('column_customer');
		$data['column_status'] = $this->language->get('column_status');
		$data['column_total'] = $this->language->get('column_total');
		$data['column_date_added'] = $this->language->get('column_date_added');
		$data['column_date_modified'] = $this->language->get('column_date_modified');
		$data['column_action'] = $this->language->get('column_action');
		$data['entry_order_id'] = $this->language->get('entry_order_id');
		$data['entry_customer'] = $this->language->get('entry_customer');
		$data['entry_order_status'] = $this->language->get('entry_order_status');
		$data['entry_total'] = $this->language->get('entry_total');
		$data['entry_date_added'] = $this->language->get('entry_date_added');
		$data['entry_date_modified'] = $this->language->get('entry_date_modified');
		$data['button_invoice_print'] = $this->language->get('button_invoice_print');
		$data['button_shipping_print'] = $this->language->get('button_shipping_print');
		$data['button_add'] = $this->language->get('button_add');
		$data['button_edit'] = $this->language->get('button_edit');
		$data['button_delete'] = $this->language->get('button_delete');
		$data['button_filter'] = $this->language->get('button_filter');
		$data['button_view'] = $this->language->get('button_view');
		$data['button_ip_add'] = $this->language->get('button_ip_add');
		# order statuses
		$data['order_status_pending']    = $this->language->get('order_status_pending_id');
		$data['order_status_processing'] = $this->language->get('order_status_processing_id');
		$data['order_status_confirmed']  = $this->language->get('order_status_confirmed_id');
		$data['order_status_cancelled']  = $this->language->get('order_status_cancelled_id');
		$data['token'] = $this->session->data['token'];
		if (isset($this->error['warning'])) {
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
		
		if (isset($this->request->post['selected'])) {
			$data['selected'] = (array)$this->request->post['selected'];
		} else {
			$data['selected'] = array();
		}
		$url = '';
		if (isset($this->request->get['filter_order_id'])) {
			$url .= '&filter_order_id=' . $this->request->get['filter_order_id'];
		}
		if (isset($this->request->get['filter_customer'])) {
			$url .= '&filter_customer=' . urlencode(html_entity_decode($this->request->get['filter_customer'], ENT_QUOTES, 'UTF-8'));
		}
		
		if (isset($this->request->get['filter_customer_id'])) {
			$url .= '&filter_customer_id=' . $this->request->get['filter_customer_id'];
		}
		
		if (isset($this->request->get['filter_customer_contactid'])) {
			$url .= '&filter_customer_contactid=' . $this->request->get['filter_customer_contactid'];
		}
		
		if (isset($this->request->get['filter_salesrepid'])) {
			$url .= '&filter_salesrepid=' . $this->request->get['filter_salesrepid'];
		}
		if (isset($this->request->get['filter_order_status'])) {
			$url .= '&filter_order_status=' . $this->request->get['filter_order_status'];
		}
		if (isset($this->request->get['filter_total'])) {
			$url .= '&filter_total=' . $this->request->get['filter_total'];
		}
		if (isset($this->request->get['filter_date_added'])) {
			$url .= '&filter_date_added=' . $this->request->get['filter_date_added'];
		}
		if (isset($this->request->get['filter_date_modified'])) {
			$url .= '&filter_date_modified=' . $this->request->get['filter_date_modified'];
		}
		if ($order == 'ASC') {
			$url .= '&order=DESC';
		} else {
			$url .= '&order=ASC';
		}
		if (isset($this->request->get['page'])) {
			$url .= '&page=' . $this->request->get['page'];
		}
		$data['sort_order'] = $this->url->link('sale/order', 'token=' . $this->session->data['token'] . '&sort=o.order_id' . $url, true);
		$data['sort_customer'] = $this->url->link('sale/order', 'token=' . $this->session->data['token'] . '&sort=customer' . $url, true);
		$data['sort_customercontact'] = $this->url->link('sale/order', 'token=' . $this->session->data['token'] . '&sort=oq.customer_contact_id' . $url, true);
		$data['sort_salesrep'] = $this->url->link('sale/order', 'token=' . $this->session->data['token'] . '&sort=salesrep' . $url, true);
		$data['sort_status'] = $this->url->link('sale/order', 'token=' . $this->session->data['token'] . '&sort=order_status' . $url, true);
		$data['sort_total'] = $this->url->link('sale/order', 'token=' . $this->session->data['token'] . '&sort=o.total' . $url, true);
		$data['sort_date_added'] = $this->url->link('sale/order', 'token=' . $this->session->data['token'] . '&sort=o.date_added' . $url, true);
		$data['sort_date_modified'] = $this->url->link('sale/order', 'token=' . $this->session->data['token'] . '&sort=o.date_modified' . $url, true);
		$url = '';
		if (isset($this->request->get['filter_order_id'])) {
			$url .= '&filter_order_id=' . $this->request->get['filter_order_id'];
		}
		if (isset($this->request->get['filter_customer'])) {
			$url .= '&filter_customer=' . urlencode(html_entity_decode($this->request->get['filter_customer'], ENT_QUOTES, 'UTF-8'));
		}
		
		if (isset($this->request->get['filter_customer_id'])) {
			$url .= '&filter_customer_id=' . $this->request->get['filter_customer_id'];
		}
		
		if (isset($this->request->get['filter_customer_contactid'])) {
			$url .= '&filter_customer_contactid=' . $this->request->get['filter_customer_contactid'];
		}
		
		if (isset($this->request->get['filter_salesrepid'])) {
			$url .= '&filter_salesrepid=' . $this->request->get['filter_salesrepid'];
		}
		if (isset($this->request->get['filter_order_status'])) {
			$url .= '&filter_order_status=' . $this->request->get['filter_order_status'];
		}
		if (isset($this->request->get['filter_total'])) {
			$url .= '&filter_total=' . $this->request->get['filter_total'];
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
		$pagination = new Pagination();
		$pagination->total = $order_total;
		$pagination->page = $page;
		$pagination->limit = $this->config->get('config_limit_admin');
		$pagination->url = $this->url->link('sale/order', 'token=' . $this->session->data['token'] . $url . '&page={page}', true);
		$data['pagination'] = $pagination->render();
		$data['results'] = sprintf($this->language->get('text_pagination'), ($order_total) ? (($page - 1) * $this->config->get('config_limit_admin')) + 1 : 0, ((($page - 1) * $this->config->get('config_limit_admin')) > ($order_total - $this->config->get('config_limit_admin'))) ? $order_total : ((($page - 1) * $this->config->get('config_limit_admin')) + $this->config->get('config_limit_admin')), $order_total, ceil($order_total / $this->config->get('config_limit_admin')));
		$data['filter_order_id'] = $filter_order_id;
		$data['filter_customer'] = $filter_customer;
		$data['filter_customer_id'] = $filter_customer_id;
		$data['filter_customer_contactid'] = $filter_customer_contactid;
		$data['filter_salesrepid'] = $filter_salesrepid;
		$data['filter_order_status'] = $filter_order_status;
		$data['filter_total'] = $filter_total;
		$data['filter_date_added'] = $filter_date_added;
		$data['filter_date_modified'] = $filter_date_modified;
		$data['sort'] = $sort;
		$data['order'] = $order;
		$this->load->model('localisation/order_status');
		$data['order_statuses'] = $this->model_localisation_order_status->getOrderStatuses();

		$data['create_order_action'] = $this->url->link('sale/order/add', 'token=' . $this->session->data['token'], true);
		
		$data['header'] = $this->load->controller('common/header');
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['footer'] = $this->load->controller('common/footer');
		$this->response->setOutput($this->load->view('sale/order_list', $data));
	}

	public function getForm($view_name='') {
		$data['heading_title']         = $this->language->get('heading_title');
		$data['text_form']             = !isset($this->request->get['order_id']) ? $this->language->get('text_add') : $this->language->get('text_edit');
		$data['text_no_results']       = $this->language->get('text_no_results');
		$data['text_default']          = $this->language->get('text_default');
		$data['text_select']           = $this->language->get('text_select');
		$data['text_none']             = $this->language->get('text_none');
		$data['text_loading']          = $this->language->get('text_loading');
		$data['text_ip_add']           = sprintf($this->language->get('text_ip_add'), $this->request->server['REMOTE_ADDR']);
		$data['text_product']          = $this->language->get('text_product');
		$data['text_voucher']          = $this->language->get('text_voucher');
		$data['text_order_detail']     = $this->language->get('text_order_detail');
		$data['entry_store']           = $this->language->get('entry_store');
		$data['entry_customer']        = $this->language->get('entry_customer');
		$data['entry_customer_group']  = $this->language->get('entry_customer_group');
		$data['entry_firstname']       = $this->language->get('entry_firstname');
		$data['entry_lastname']        = $this->language->get('entry_lastname');
		$data['entry_email']           = $this->language->get('entry_email');
		$data['entry_telephone']       = $this->language->get('entry_telephone');
		$data['entry_fax']             = $this->language->get('entry_fax');
		$data['entry_comment']         = $this->language->get('entry_comment');
		$data['entry_affiliate']       = $this->language->get('entry_affiliate');
		$data['entry_address']         = $this->language->get('entry_address');
		$data['entry_company']         = $this->language->get('entry_company');
		$data['entry_address_1']       = $this->language->get('entry_address_1');
		$data['entry_address_2']       = $this->language->get('entry_address_2');
		$data['entry_city']            = $this->language->get('entry_city');
		$data['entry_postcode']        = $this->language->get('entry_postcode');
		$data['entry_zone']            = $this->language->get('entry_zone');
		$data['entry_zone_code']       = $this->language->get('entry_zone_code');
		$data['entry_country']         = $this->language->get('entry_country');
		$data['entry_product']         = $this->language->get('entry_product');
		$data['entry_option']          = $this->language->get('entry_option');
		$data['entry_quantity']        = $this->language->get('entry_quantity');
		$data['entry_to_name']         = $this->language->get('entry_to_name');
		$data['entry_to_email']        = $this->language->get('entry_to_email');
		$data['entry_from_name']       = $this->language->get('entry_from_name');
		$data['entry_from_email']      = $this->language->get('entry_from_email');
		$data['entry_theme']           = $this->language->get('entry_theme');
		$data['entry_message']         = $this->language->get('entry_message');
		$data['entry_amount']          = $this->language->get('entry_amount');
		$data['entry_currency']        = $this->language->get('entry_currency');
		$data['entry_shipping_method'] = $this->language->get('entry_shipping_method');
		$data['entry_payment_method']  = $this->language->get('entry_payment_method');
		$data['entry_coupon']          = $this->language->get('entry_coupon');
		$data['entry_voucher']         = $this->language->get('entry_voucher');
		$data['entry_reward']          = $this->language->get('entry_reward');
		$data['entry_order_status']    = $this->language->get('entry_order_status');
		$data['column_image']          = $this->language->get('column_image');
		$data['column_product']        = $this->language->get('column_product');
		$data['column_model']          = $this->language->get('column_model');
		$data['column_quantity']       = $this->language->get('column_quantity');
		$data['column_price']          = $this->language->get('column_price');
		$data['column_total']          = $this->language->get('column_total');
		$data['column_action']         = $this->language->get('column_action');
		$data['button_save']           = $this->language->get('button_save');
		$data['button_cancel']         = $this->language->get('button_cancel');
		$data['button_continue']       = $this->language->get('button_continue');
		$data['button_back']           = $this->language->get('button_back');
		$data['button_refresh']        = $this->language->get('button_refresh');
		$data['button_product_add']    = $this->language->get('button_product_add');
		$data['button_voucher_add']    = $this->language->get('button_voucher_add');
		$data['button_apply']          = $this->language->get('button_apply');
		$data['button_upload']         = $this->language->get('button_upload');
		$data['button_remove']         = $this->language->get('button_remove');
		$data['button_ip_add']         = $this->language->get('button_ip_add');
		$data['tab_order']             = $this->language->get('tab_order');
		$data['tab_customer']          = $this->language->get('tab_customer');
		$data['tab_payment']           = $this->language->get('tab_payment');
		$data['tab_shipping']          = $this->language->get('tab_shipping');
		$data['tab_product']           = $this->language->get('tab_product');
		$data['tab_voucher']           = $this->language->get('tab_voucher');
		$data['tab_total']             = $this->language->get('tab_total');

		// order statuses
		$orderStatuses = array(
			'pending'    => $this->language->get('order_status_pending_id'),
			'processing' => $this->language->get('order_status_processing_id'),
			'confirmed'  => $this->language->get('order_status_confirmed_id'),
			'cancelled'  => $this->language->get('order_status_cancelled_id')
		);
		$data['order_statuses'] = $orderStatuses;

		$url = '';

		if (isset($this->request->get['filter_order_id'])) {
			$url .= '&filter_order_id=' . $this->request->get['filter_order_id'];
		}
		if (isset($this->request->get['filter_customer'])) {
			$url .= '&filter_customer=' . urlencode(html_entity_decode($this->request->get['filter_customer'], ENT_QUOTES, 'UTF-8'));
		}
		
		if (isset($this->request->get['filter_customer_id'])) {
			$url .= '&filter_customer_id=' . $this->request->get['filter_customer_id'];
		}
		
		if (isset($this->request->get['filter_customer_contactid'])) {
			$url .= '&filter_customer_contactid=' . $this->request->get['filter_customer_contactid'];
		}
		
		if (isset($this->request->get['filter_salesrepid'])) {
			$url .= '&filter_salesrepid=' . $this->request->get['filter_salesrepid'];
		}
		if (isset($this->request->get['filter_order_status'])) {
			$url .= '&filter_order_status=' . $this->request->get['filter_order_status'];
		}
		if (isset($this->request->get['filter_total'])) {
			$url .= '&filter_total=' . $this->request->get['filter_total'];
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
			'href' => $this->url->link(getDashboard($this->user), 'token=' . $this->session->data['token'], true)
		);
		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('heading_title'),
			'href' => $this->url->link('sale/order', 'token=' . $this->session->data['token'] . $url, true)
		);

		if (isset($this->request->get['type'])) {
			if (isset($this->request->get['csalesrep_id'])) {
				$data['cancel'] = $this->url->link('replogic/salesrep_info', 'token=' . $this->session->data['token'] . '&type=orders&salesrep_id='.$this->request->get['csalesrep_id'] .  $url, true);
			} else {
				$data['cancel'] = $this->url->link('customer/customer_info', 'token=' . $this->session->data['token'] . '&type=orders&customer_id='.$this->request->get['customer_id'] .  $url, true);
			}
		} else {
			$data['cancel'] = $this->url->link('sale/order', 'token=' . $this->session->data['token'] . $url, true);
		}
		
		$data['token'] = $this->session->data['token'];
		if (isset($this->request->get['order_id'])) {
			$order_info = $this->model_sale_order->getOrder($this->request->get['order_id']);
			# If Order is 'Pending', change status to 'Processing' on page load
			# update order status, and
			# get updated order information
			if (isset($order_info['order_status_id']) && $order_info['order_status_id'] == $orderStatuses['pending']) {
				$this->model_sale_order->updateOrderStatus($this->request->get['order_id'], $orderStatuses['processing']);
				$order_info = $this->model_sale_order->getOrder($this->request->get['order_id']);
			}
		}

		if (!empty($order_info)) {
			$data['order_id']             = $this->request->get['order_id'];
			$data['store_id']             = $order_info['store_id'];
			$data['store_url']            = $this->request->server['HTTPS'] ? HTTPS_CATALOG : HTTP_CATALOG;
			$data['customer']             = $order_info['customer'];
			$data['customer_id']          = $order_info['customer_id'];
			$data['customer_group_id']    = $order_info['customer_group_id'];
			$data['firstname']            = $order_info['firstname'];
			$data['lastname']             = $order_info['lastname'];
			$data['email']                = $order_info['email'];
			$data['telephone']            = $order_info['telephone'];
			$data['fax']                  = $order_info['fax'];
			$data['account_custom_field'] = $order_info['custom_field'];

			$this->load->model('customer/customer');
			$this->load->model('customer/customer_group');
			$this->load->model('replogic/sales_rep_management');
			$this->load->model('replogic/customer_contact');

			$customer_group_info = $this->model_customer_customer_group->getCustomerGroup($order_info['customer_group_id']);
			if ($customer_group_info) {
				$data['customer_group'] = $customer_group_info['name'];
			} else {
				$data['customer_group'] = '';
			}
			
			$data['customer_group_id'] = $order_info['customer_group_id'];
			
			if ($order_info['customer_id'] > 0) {
				$cust                = $this->model_customer_customer->getCustomer($order_info['customer_id']);
				$data['shipaddress'] = $this->model_customer_customer->getAddress($cust['address_id']);
				$data['addresses']   = $this->model_customer_customer->getAddresses($order_info['customer_id']);
				$data['address_id']  = $cust['address_id'];
			
				$quote_info          = $this->model_sale_order->getQuotesByOrderId($order_info['order_id']);
			
				$this->load->model('replogic/customer_contact');
				$cust_con            = $this->model_replogic_customer_contact->getcustomercontact($quote_info['customer_contact_id']);
				$data['ccfirstname'] = $cust_con['first_name'];
				$data['cclastname']  = $cust_con['last_name'];
				$data['ccemail']     = $cust_con['email'];
				$data['cctelephone'] = $cust_con['telephone_number'];
				$data['quote_id']    = $quote_info['quote_id'];
				
				$this->load->model('replogic/sales_rep_management');
				$salesrep            = $this->model_replogic_sales_rep_management->getsalesrep($quote_info['salesrep_id']);
				
				$data['ssfirstname'] = $salesrep['salesrep_name'];
				$data['sslastname']  = $salesrep['salesrep_lastname'];

				$data['Qdate_added'] = date('d M, Y', strtotime($quote_info['date_added']));
			} else {
				$arr                 = array('firstname'=>$order_info['firstname'],'lastname'=>$order_info['lastname'],'company'=>$order_info['shipping_company'],'address_1'=>$order_info['shipping_address_1'],'address_2'=>$order_info['shipping_address_2'],'city'=>$order_info['shipping_city'],'postcode'=>$order_info['shipping_postcode'],'zone'=>$order_info['shipping_zone'],'country'=>$order_info['shipping_country'],'country_id'=>$order_info['shipping_country_id'],'zone_id'=>$order_info['shipping_zone_id']);
				$data['shipaddress'] = $arr;
				
				$ads[]               = array('address_1'=>$order_info['shipping_address_1'],'address_2'=>$order_info['shipping_address_2'],'city'=>$order_info['shipping_city'],'postcode'=>$order_info['shipping_postcode'],'zone'=>$order_info['shipping_zone'],'country'=>$order_info['shipping_country'],'country_id'=>$order_info['shipping_country_id'],'zone_id'=>$order_info['shipping_zone_id']);
				$data['addresses']   = $ads;
				
				$data['address_id']  = '';
				$data['ccfirstname'] = '';
				$data['cclastname']  = '';
				$data['ccemail']     = '';
				$data['cctelephone'] = '';
				$data['quote_id']    = '';
				
				$data['ssfirstname'] = '';
				$data['sslastname']  = '';
				
				$data['Qdate_added'] = '';
			}
			
			$data['isReplogic'] = $order_info['isReplogic'];
			
			if ($order_info['isReplogic']) {
				$data['channelname'] = 'Saleslogic Rep';
			} else {
				$data['channelname'] = $order_info['store_name'];
			}
		
			$data['customer_contact_id']  = $quote_info['customer_contact_id'];
			$cust_con                     = $this->model_replogic_customer_contact->getcustomercontact($quote_info['customer_contact_id']);
			
			$data['ccfirstname']          = $cust_con['first_name'];
			$data['cclastname']           = $cust_con['last_name'];
			$data['ccemail']              = $cust_con['email'];
			$data['cctelephone']          = $cust_con['telephone_number'];
			
			$data['Odate_added']          = date('d M, Y', strtotime($order_info['date_added']));
			$data['payment_firstname']    = $order_info['payment_firstname'];
			$data['payment_lastname']     = $order_info['payment_lastname'];
			$data['payment_company']      = $order_info['payment_company'];
			$data['payment_address_1']    = $order_info['payment_address_1'];
			$data['payment_address_2']    = $order_info['payment_address_2'];
			$data['payment_city']         = $order_info['payment_city'];
			$data['payment_postcode']     = $order_info['payment_postcode'];
			$data['payment_country_id']   = $order_info['payment_country_id'];
			$data['payment_zone_id']      = $order_info['payment_zone_id'];
			$data['payment_custom_field'] = $order_info['payment_custom_field'];
			$data['payment_method']       = $order_info['payment_method'];
			$data['payment_code']         = $order_info['payment_code'];
			$data['shipping_firstname']   = $order_info['shipping_firstname'];
			$data['shipping_lastname']    = $order_info['shipping_lastname'];
			$data['shipping_company']     = $order_info['shipping_company'];
			$data['shipping_address_1']   = $order_info['shipping_address_1'];
			$data['shipping_address_2']   = $order_info['shipping_address_2'];
			$data['shipping_city']        = $order_info['shipping_city'];
			$data['shipping_postcode']    = $order_info['shipping_postcode'];
			$data['shipping_country_id']  = $order_info['shipping_country_id'];
			$data['shipping_zone_id']     = $order_info['shipping_zone_id'];
			$data['shipping_custom_field']= $order_info['shipping_custom_field'];
			$data['shipping_method']      = $order_info['shipping_method'];
			$data['shipping_code']        = $order_info['shipping_code'];

			// Products
			$data['order_products'] = array();
			$this->load->model('tool/image');
			$products = $this->model_sale_order->getOrderProducts($this->request->get['order_id']);

			foreach ($products as $product) {
				if (is_file(DIR_IMAGE . $product['image'])) {
					$image = $this->model_tool_image->resize($product['image'], 40, 40);
				} else {
					$image = $this->model_tool_image->resize('tsc_image.png', 40, 40);
				}
				
				$data['order_products'][] = array(
					'product_id' => $product['product_id'],
					'name'       => $product['name'],
					'image'      => $image,
					'model'      => $product['model'],
					'option'     => $this->model_sale_order->getOrderOptions($this->request->get['order_id'], $product['order_product_id']),
					'quantity'   => $product['quantity'],
					'price'      => $product['price'],
					'total'      => $product['total'],
					'reward'     => $product['reward']
				);
			}
			// Vouchers
			$data['order_vouchers'] = $this->model_sale_order->getOrderVouchers($this->request->get['order_id']);
			$data['coupon'] = '';
			$data['voucher'] = '';
			$data['reward'] = '';
			$data['order_totals'] = array();
			$order_totals = $this->model_sale_order->getOrderTotals($this->request->get['order_id']);
			foreach ($order_totals as $order_total) {
				// If coupon, voucher or reward points
				$start = strpos($order_total['title'], '(') + 1;
				$end = strrpos($order_total['title'], ')');
				if ($start && $end) {
					$data[$order_total['code']] = substr($order_total['title'], $start, $end - $start);
				}
			}
			$data['order_status_id'] = $order_info['order_status_id'];
			$data['comment']         = $order_info['comment'];
			$data['affiliate_id']    = $order_info['affiliate_id'];
			$data['affiliate']       = $order_info['affiliate_firstname'] . ' ' . $order_info['affiliate_lastname'];
			$data['currency_code']   = $order_info['currency_code'];
			
			$data['totals'] = array();
			$totals         = $this->model_sale_order->getOrderTotals($order_info['order_id']);
			foreach ($totals as $total) {
				$data['totals'][] = array(
					'title' => $total['title'],
					'text'  => $this->currency->format($total['value'], $order_info['currency_code'], $order_info['currency_value'])
				);
			}
			$data['comment'] = nl2br($order_info['comment']);
			
		} else {
			$data['order_id'] = 0;
			$data['store_id'] = $this->config->get('config_store_id');
			$data['store_url'] = $this->request->server['HTTPS'] ? HTTPS_CATALOG : HTTP_CATALOG;
			
			$data['customer'] = '';
			$data['customer_id'] = '';
			$data['customer_group_id'] = $this->config->get('config_customer_group_id');
			$data['firstname'] = '';
			$data['lastname'] = '';
			$data['email'] = '';
			$data['telephone'] = '';
			$data['fax'] = '';
			$data['customer_custom_field'] = array();
			$data['addresses'] = array();
			$data['payment_firstname'] = '';
			$data['payment_lastname'] = '';
			$data['payment_company'] = '';
			$data['payment_address_1'] = '';
			$data['payment_address_2'] = '';
			$data['payment_city'] = '';
			$data['payment_postcode'] = '';
			$data['payment_country_id'] = '';
			$data['payment_zone_id'] = '';
			$data['payment_custom_field'] = array();
			$data['payment_method'] = '';
			$data['payment_code'] = '';
			$data['shipping_firstname'] = '';
			$data['shipping_lastname'] = '';
			$data['shipping_company'] = '';
			$data['shipping_address_1'] = '';
			$data['shipping_address_2'] = '';
			$data['shipping_city'] = '';
			$data['shipping_postcode'] = '';
			$data['shipping_country_id'] = '';
			$data['shipping_zone_id'] = '';
			$data['shipping_custom_field'] = array();
			$data['shipping_method'] = '';
			$data['shipping_code'] = '';
			$data['order_products'] = array();
			$data['order_vouchers'] = array();
			$data['order_totals'] = array();
			$data['order_status_id'] = $this->config->get('config_order_status_id');
			$data['comment'] = '';
			$data['affiliate_id'] = '';
			$data['affiliate'] = '';
			$data['currency_code'] = $this->config->get('config_currency');
			$data['coupon'] = '';
			$data['voucher'] = '';
			$data['reward'] = '';
			$data['order_status_id'] = $this->language->get('order_status_confirmed_id');
		}
		// Stores
		$this->load->model('setting/store');
		$data['stores'] = array();
		$data['stores'][] = array(
			'store_id' => 0,
			'name'     => $this->language->get('text_default')
		);
		$results = $this->model_setting_store->getStores();
		foreach ($results as $result) {
			$data['stores'][] = array(
				'store_id' => $result['store_id'],
				'name'     => $result['name']
			);
		}

		// customer details
		$this->load->model('customer/customer');
		if (!empty($this->request->get['customer'])) {
			$data['customer']  = $this->model_customer_customer->getCustomer($this->request->get['customer']);
			$data['addresses'] = $this->model_customer_customer->getAddresses($this->request->get['customer']);
			$url              .= '&customer=' . $this->request->get['customer'];
		} else {
			$data['customer']  = $this->model_customer_customer->getCustomer($data['customer_id']);
			$data['addresses'] = $this->model_customer_customer->getAddresses($data['customer_id']);
		}
		
		// Customer Groups
		$this->load->model('customer/customer_group');
		$customer_group = $this->model_customer_customer_group->getCustomerGroup($data['customer']['customer_group_id']);
		if (!empty($customer_group)) {
			$data['customer_group'] = $customer_group['name'];
		} else {
			$data['customer_group'] = '';
		}

		// get current user
		$this->load->model('user/user');
		$data['user'] = $this->model_user_user->getUser($this->session->data['user_id']);

		// customer address
		$data['customer_address'] = $this->model_customer_customer->getAddress($data['customer']['address_id']);

		// customer contact
		$this->load->model('replogic/customer_contact');
		if (!empty($this->request->get['customer_contact'])) {
			$data['contact'] = $this->model_replogic_customer_contact->getcustomercontact($this->request->get['customer_contact']);
			$url            .= '&customer_contact=' . $this->request->get['customer_contact'];
		} elseif (!empty($order_info['isReplogic']) && $order_info['isReplogic'] == 1) {
			$data['contact'] = $this->model_replogic_customer_contact->getcustomercontact($quote_info['customer_contact_id']);
		} else {
			$data['contact']['customer_con_id']  = 0;
			$data['contact']['first_name']       = $data['customer']['firstname'];
			$data['contact']['last_name']        = '';
			$data['contact']['email']            = $data['customer']['email'];
			$data['contact']['telephone_number'] = $data['customer']['telephone'];
		}

		// Custom Fields
		$this->load->model('customer/custom_field');
		$data['custom_fields'] = array();
		$filter_data = array(
			'sort'  => 'cf.sort_order',
			'order' => 'ASC'
		);
		$custom_fields = $this->model_customer_custom_field->getCustomFields($filter_data);
		foreach ($custom_fields as $custom_field) {
			$data['custom_fields'][] = array(
				'custom_field_id'    => $custom_field['custom_field_id'],
				'custom_field_value' => $this->model_customer_custom_field->getCustomFieldValues($custom_field['custom_field_id']),
				'name'               => $custom_field['name'],
				'value'              => $custom_field['value'],
				'type'               => $custom_field['type'],
				'location'           => $custom_field['location'],
				'sort_order'         => $custom_field['sort_order']
			);
		}

		// get products
		$data['products'] = array();
		$this->load->model('catalog/product');
		$this->load->model('tool/image');
		$products = $this->model_catalog_product->getProducts();
		foreach ($products as $product) {
			if (is_file(DIR_IMAGE . $product['image'])) {
				$image = $this->model_tool_image->resize($product['image'], 40, 40);
			} else {
				$image = $this->model_tool_image->resize('tsc_image.png', 40, 40);
			}
			
			$data['products'][] = array(
				'product_id' => $product['product_id'],
				'name'       => $product['name'],
				'image'      => $image,
				'model'      => $product['model'],
				'quantity'   => $product['quantity'],
				'price'      => $product['price'],
				'total'      => $product['total'],
				'reward'     => $product['reward']
			);
		}

		// comment
		if (empty($data['comment'])) {
			$data['comment'] = (!empty($this->request->get['comment'])) ? $this->request->get['comment'] : '';
		}

		// get countries
		$this->load->model('localisation/country');
		$data['countries'] = $this->model_localisation_country->getCountries();

		// get zones
		$this->load->model('localisation/zone');
		$data['zones'] = $this->model_localisation_zone->getZonesByCountryId($data['customer_address']['country_id']);

		$data['voucher_min'] = $this->config->get('config_voucher_min');

		$this->load->model('sale/voucher_theme');
		$data['voucher_themes'] = $this->model_sale_voucher_theme->getVoucherThemes();

		// API login
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

		$data['process_order_url'] = $this->url->link('sale/order/processing', 'token=' . $this->session->data['token'] . $url, true);
		$data['add_order_url'] = $this->url->link('sale/order/add', 'token=' . $this->session->data['token'] . $url, true);
		$data['cancel_url'] = $this->url->link('sale/order', 'token=' . $this->session->data['token'] . $url, true);
		$data['back_url'] = $this->url->link('sale/order/info', 'token=' . $this->session->data['token'] . '&order_id=' . $data['order_id'] . $url, true);

		// get order date
		if (!empty($order_info['date_added'])) {
			$data['order_date'] = date('d F, Y', strtotime($order_info['date_added']));
		} else {
			$data['order_date'] = date('d F, Y');
		}

		// out($data);die;

		// get currency
		$this->load->model('localisation/currency');
		$data['currency']    = $this->model_localisation_currency->getCurrencyByCode($data['currency_code']);

		$data['header']      = $this->load->controller('common/header');
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['footer']      = $this->load->controller('common/footer');
		if (!empty($order_info)) {
			switch ($view_name) {
				case 'order_edit':
					$this->response->setOutput($this->load->view('sale/order_edit', $data));
					break;

				default:
					$this->response->setOutput($this->load->view('sale/order_form_new', $data));
					break;
			}
		} else {
			switch ($view_name) {
				case 'order_processing':
					$this->response->setOutput($this->load->view('sale/order_processing', $data));
					break;

				default:
					$this->response->setOutput($this->load->view('sale/order_add', $data));
					break;
			}
		}
	}

	public function info() {
		$this->load->model('sale/order');
		if (isset($this->request->get['order_id'])) {
			$order_id = $this->request->get['order_id'];
		} else {
			$order_id = 0;
		}
		$order_info = $this->model_sale_order->getOrder($order_id);
		if ($order_info) {
			$this->load->language('sale/order');
			$this->document->setTitle($this->language->get('heading_title'));
			$data['heading_title'] = $this->language->get('heading_title');
			$data['text_ip_add'] = sprintf($this->language->get('text_ip_add'), $this->request->server['REMOTE_ADDR']);
			$data['text_order_detail'] = $this->language->get('text_order_detail');
			$data['text_customer_detail'] = $this->language->get('text_customer_detail');
			$data['text_option'] = $this->language->get('text_option');
			$data['text_store'] = $this->language->get('text_store');
			$data['text_date_added'] = $this->language->get('text_date_added');
			$data['text_payment_method'] = $this->language->get('text_payment_method');
			$data['text_shipping_method'] = $this->language->get('text_shipping_method');
			$data['text_customer'] = $this->language->get('text_customer');
			$data['text_customer_group'] = $this->language->get('text_customer_group');
			$data['text_email'] = $this->language->get('text_email');
			$data['text_telephone'] = $this->language->get('text_telephone');
			$data['text_invoice'] = $this->language->get('text_invoice');
			$data['text_reward'] = $this->language->get('text_reward');
			$data['text_affiliate'] = $this->language->get('text_affiliate');
			$data['text_order'] = sprintf($this->language->get('text_order'), $this->request->get['order_id']);
			$data['text_payment_address'] = $this->language->get('text_payment_address');
			$data['text_shipping_address'] = $this->language->get('text_shipping_address');
			$data['text_comment'] = $this->language->get('text_comment');
			$data['text_account_custom_field'] = $this->language->get('text_account_custom_field');
			$data['text_payment_custom_field'] = $this->language->get('text_payment_custom_field');
			$data['text_shipping_custom_field'] = $this->language->get('text_shipping_custom_field');
			$data['text_browser'] = $this->language->get('text_browser');
			$data['text_ip'] = $this->language->get('text_ip');
			$data['text_forwarded_ip'] = $this->language->get('text_forwarded_ip');
			$data['text_user_agent'] = $this->language->get('text_user_agent');
			$data['text_accept_language'] = $this->language->get('text_accept_language');
			$data['text_history'] = $this->language->get('text_history');
			$data['text_history_add'] = $this->language->get('text_history_add');
			$data['text_loading'] = $this->language->get('text_loading');
			$data['column_image'] = $this->language->get('column_image');
			$data['column_product'] = $this->language->get('column_product');
			$data['column_model'] = $this->language->get('column_model');
			$data['column_quantity'] = $this->language->get('column_quantity');
			$data['column_price'] = $this->language->get('column_price');
			$data['column_total'] = $this->language->get('column_total');
			$data['entry_order_status'] = $this->language->get('entry_order_status');
			$data['entry_notify'] = $this->language->get('entry_notify');
			$data['entry_override'] = $this->language->get('entry_override');
			$data['entry_comment'] = $this->language->get('entry_comment');
			$data['help_override'] = $this->language->get('help_override');
			$data['button_invoice_print'] = $this->language->get('button_invoice_print');
			$data['button_shipping_print'] = $this->language->get('button_shipping_print');
			$data['button_edit'] = $this->language->get('button_edit');
			$data['button_cancel'] = $this->language->get('button_cancel');
			$data['button_generate'] = $this->language->get('button_generate');
			$data['button_reward_add'] = $this->language->get('button_reward_add');
			$data['button_reward_remove'] = $this->language->get('button_reward_remove');
			$data['button_commission_add'] = $this->language->get('button_commission_add');
			$data['button_commission_remove'] = $this->language->get('button_commission_remove');
			$data['button_history_add'] = $this->language->get('button_history_add');
			$data['button_ip_add'] = $this->language->get('button_ip_add');
			$data['tab_history'] = $this->language->get('tab_history');
			$data['tab_additional'] = $this->language->get('tab_additional');
			$url = '';
			if (isset($this->request->get['filter_order_id'])) {
				$url .= '&filter_order_id=' . $this->request->get['filter_order_id'];
			}
			if (isset($this->request->get['filter_customer'])) {
				$url .= '&filter_customer=' . urlencode(html_entity_decode($this->request->get['filter_customer'], ENT_QUOTES, 'UTF-8'));
			}
			
			if (isset($this->request->get['filter_customer_id'])) {
				$url .= '&filter_customer_id=' . $this->request->get['filter_customer_id'];
			}
			
			if (isset($this->request->get['filter_customer_contactid'])) {
				$url .= '&filter_customer_contactid=' . $this->request->get['filter_customer_contactid'];
			}
			if (isset($this->request->get['filter_order_status'])) {
				$url .= '&filter_order_status=' . $this->request->get['filter_order_status'];
			}
			if (isset($this->request->get['filter_total'])) {
				$url .= '&filter_total=' . $this->request->get['filter_total'];
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
				'href' => $this->url->link(getDashboard($this->user), 'token=' . $this->session->data['token'], true)
			);
			$data['breadcrumbs'][] = array(
				'text' => $this->language->get('heading_title'),
				'href' => $this->url->link('sale/order', 'token=' . $this->session->data['token'] . $url, true)
			);
			$data['shipping'] = $this->url->link('sale/order/shipping', 'token=' . $this->session->data['token'] . '&order_id=' . (int)$this->request->get['order_id'], true);
			$data['invoice'] = $this->url->link('sale/order/invoice', 'token=' . $this->session->data['token'] . '&order_id=' . (int)$this->request->get['order_id'], true);
			$data['edit'] = $this->url->link('sale/order/edit', 'token=' . $this->session->data['token'] . '&order_id=' . (int)$this->request->get['order_id'], true);
			
			if(isset($this->request->get['type']))
			{
				if(isset($this->request->get['csalesrep_id']))
				{
					$data['cancel'] = $this->url->link('replogic/salesrep_info', 'token=' . $this->session->data['token'] . '&type=orders&salesrep_id='.$this->request->get['csalesrep_id'] .  $url, true);
				}
				else
				{
					$data['cancel'] = $this->url->link('customer/customer_info', 'token=' . $this->session->data['token'] . '&type=orders&customer_id='.$this->request->get['customer_id'] .  $url, true);
				}
				
			}
			else
			{
				$data['cancel'] = $this->url->link('sale/order', 'token=' . $this->session->data['token'] . $url, true);
			}
			
			$data['token'] = $this->session->data['token'];
			$data['order_id'] = $this->request->get['order_id'];
			$data['store_id'] = $order_info['store_id'];
			$data['store_name'] = $order_info['store_name'];
			
			if ($order_info['store_id'] == 0) {
				$data['store_url'] = $this->request->server['HTTPS'] ? HTTPS_CATALOG : HTTP_CATALOG;
			} else {
				$data['store_url'] = $order_info['store_url'];
			}
			if ($order_info['invoice_no']) {
				$data['invoice_no'] = $order_info['invoice_prefix'] . $order_info['invoice_no'];
			} else {
				$data['invoice_no'] = '';
			}
			$data['date_added'] = date('d M, Y', strtotime($order_info['date_added']));
			$data['firstname'] = $order_info['firstname'];
			$data['lastname'] = $order_info['lastname'];
			if ($order_info['customer_id']) {
				$data['customer'] = $this->url->link('customer/customer/edit', 'token=' . $this->session->data['token'] . '&customer_id=' . $order_info['customer_id'], true);
			} else {
				$data['customer'] = '';
			}
			$this->load->model('customer/customer_group');
			$customer_group_info = $this->model_customer_customer_group->getCustomerGroup($order_info['customer_group_id']);
			if ($customer_group_info) {
				$data['customer_group'] = $customer_group_info['name'];
			} else {
				$data['customer_group'] = '';
			}
			$data['email'] = $order_info['email'];
			$data['telephone'] = $order_info['telephone'];
			$data['shipping_method'] = $order_info['shipping_method'];
			$data['payment_method'] = $order_info['payment_method'];
			if (strpos($data['payment_method'], 'Pay now using') !== false) {
				$data['payment_method'] = 'Pay now using';
			}
			// Payment Address
			if ($order_info['payment_address_format']) {
				$format = $order_info['payment_address_format'];
			} else {
				$format = '{firstname} ' . "\n" . '{address_1}' . "\n" . '{address_2}' . "\n" . '{city} {postcode}' . "\n" . '{zone}' . "\n" . '{country}';
			}
			$find = array(
				'{firstname}',
				'{lastname}',
				'{company}',
				'{address_1}',
				'{address_2}',
				'{city}',
				'{postcode}',
				'{zone}',
				'{zone_code}',
				'{country}'
			);
			$replace = array(
				'firstname' => $order_info['payment_firstname'],
				'lastname'  => $order_info['payment_lastname'],
				'company'   => $order_info['payment_company'],
				'address_1' => $order_info['payment_address_1'],
				'address_2' => $order_info['payment_address_2'],
				'city'      => $order_info['payment_city'],
				'postcode'  => $order_info['payment_postcode'],
				'zone'      => $order_info['payment_zone'],
				'zone_code' => $order_info['payment_zone_code'],
				'country'   => $order_info['payment_country']
			);
			$data['payment_address'] = str_replace(array("\r\n", "\r", "\n"), '<br />', preg_replace(array("/\s\s+/", "/\r\r+/", "/\n\n+/"), '<br />', trim(str_replace($find, $replace, $format))));
			// Shipping Address
			if ($order_info['shipping_address_format']) {
				$format = $order_info['shipping_address_format'];
			} else {
				$format = '{firstname} ' . "\n" . '{address_1}' . "\n" . '{address_2}' . "\n" . '{city} {postcode}' . "\n" . '{zone}' . "\n" . '{country}';
			}
			$find = array(
				'{firstname}',
				'{lastname}',
				'{company}',
				'{address_1}',
				'{address_2}',
				'{city}',
				'{postcode}',
				'{zone}',
				'{zone_code}',
				'{country}'
			);
			$replace = array(
				'firstname' => $order_info['shipping_firstname'],
				'lastname'  => $order_info['shipping_lastname'],
				'company'   => $order_info['shipping_company'],
				'address_1' => $order_info['shipping_address_1'],
				'address_2' => $order_info['shipping_address_2'],
				'city'      => $order_info['shipping_city'],
				'postcode'  => $order_info['shipping_postcode'],
				'zone'      => $order_info['shipping_zone'],
				'zone_code' => $order_info['shipping_zone_code'],
				'country'   => $order_info['shipping_country']
			);
			$data['shipping_address'] = str_replace(array("\r\n", "\r", "\n"), '<br />', preg_replace(array("/\s\s+/", "/\r\r+/", "/\n\n+/"), '<br />', trim(str_replace($find, $replace, $format))));
			// Uploaded files
			$this->load->model('tool/upload');
			$data['products'] = array();
			$products = $this->model_sale_order->getOrderProducts($this->request->get['order_id']);
			foreach ($products as $product) {
				$option_data = array();
				$options = $this->model_sale_order->getOrderOptions($this->request->get['order_id'], $product['order_product_id']);
				foreach ($options as $option) {
					if ($option['type'] != 'file') {
						$option_data[] = array(
							'name'  => $option['name'],
							'value' => $option['value'],
							'type'  => $option['type']
						);
					} else {
						$upload_info = $this->model_tool_upload->getUploadByCode($option['value']);
						if ($upload_info) {
							$option_data[] = array(
								'name'  => $option['name'],
								'value' => $upload_info['name'],
								'type'  => $option['type'],
								'href'  => $this->url->link('tool/upload/download', 'token=' . $this->session->data['token'] . '&code=' . $upload_info['code'], true)
							);
						}
					}
				}
				
				$this->load->model('tool/image');
				$iquery = $this->db->query("SELECT image FROM " . DB_PREFIX . "product WHERE product_id = '" . $product['product_id'] . "'");
				
				if (is_file(DIR_IMAGE . $iquery->row['image'])) {
					$image = $this->model_tool_image->resize($iquery->row['image'], 40, 40);
				} else {
					$image = $this->model_tool_image->resize('tsc_image.png', 40, 40);
				}
				$data['products'][] = array(
					'order_product_id' => $product['order_product_id'],
					'product_id'       => $product['product_id'],
					'name'    	 	   => $product['name'],
					'model'    		   => $product['model'],
					'option'   		   => $option_data,
					'image'   		   => $image,
					'quantity'		   => $product['quantity'],
					'price'    		   => $this->currency->format($product['price'] + ($this->config->get('config_tax') ? $product['tax'] : 0), $order_info['currency_code'], $order_info['currency_value']),
					'total'    		   => $this->currency->format($product['total'] + ($this->config->get('config_tax') ? ($product['tax'] * $product['quantity']) : 0), $order_info['currency_code'], $order_info['currency_value']),
					'href'     		   => $this->url->link('catalog/product/edit', 'token=' . $this->session->data['token'] . '&product_id=' . $product['product_id'], true)
				);
			}
			$data['vouchers'] = array();
			$vouchers = $this->model_sale_order->getOrderVouchers($this->request->get['order_id']);
			foreach ($vouchers as $voucher) {
				$data['vouchers'][] = array(
					'description' => $voucher['description'],
					'amount'      => $this->currency->format($voucher['amount'], $order_info['currency_code'], $order_info['currency_value']),
					'href'        => $this->url->link('sale/voucher/edit', 'token=' . $this->session->data['token'] . '&voucher_id=' . $voucher['voucher_id'], true)
				);
			}
			$data['totals'] = array();
			$totals = $this->model_sale_order->getOrderTotals($this->request->get['order_id']);
			foreach ($totals as $total) {
				$data['totals'][] = array(
					'title' => $total['title'],
					'text'  => $this->currency->format($total['value'], $order_info['currency_code'], $order_info['currency_value'])
				);
			}
			$data['comment'] = nl2br($order_info['comment']);
			$this->load->model('customer/customer');
			$data['reward'] = $order_info['reward'];
			$data['reward_total'] = $this->model_customer_customer->getTotalCustomerRewardsByOrderId($this->request->get['order_id']);
			$data['affiliate_firstname'] = $order_info['affiliate_firstname'];
			$data['affiliate_lastname'] = $order_info['affiliate_lastname'];
			if ($order_info['affiliate_id']) {
				$data['affiliate'] = $this->url->link('marketing/affiliate/edit', 'token=' . $this->session->data['token'] . '&affiliate_id=' . $order_info['affiliate_id'], true);
			} else {
				$data['affiliate'] = '';
			}
			$data['commission'] = $this->currency->format($order_info['commission'], $order_info['currency_code'], $order_info['currency_value']);
			$this->load->model('marketing/affiliate');
			$data['commission_total'] = $this->model_marketing_affiliate->getTotalTransactionsByOrderId($this->request->get['order_id']);
			$this->load->model('localisation/order_status');
			$order_status_info = $this->model_localisation_order_status->getOrderStatus($order_info['order_status_id']);
			if ($order_status_info) {
				$data['order_status'] = $order_status_info['name'];
			} else {
				$data['order_status'] = '';
			}
			$data['order_statuses'] = $this->model_localisation_order_status->getOrderStatuses();
			$data['order_status_pending_id'] = $this->language->get('order_status_pending_id');
			$data['order_status_processing_id'] = $this->language->get('order_status_processing_id');
			
			if($order_info['customer_id'] > 0)
			{
				$cust = $this->model_customer_customer->getCustomer($order_info['customer_id']);
				$data['shipaddress'] = $this->model_customer_customer->getAddress($cust['address_id']);
			
				$quote_info = $this->model_sale_order->getQuotesByOrderId($order_info['order_id']);
			
				$this->load->model('replogic/customer_contact');
				$cust_con = $this->model_replogic_customer_contact->getcustomercontact(@$quote_info['customer_contact_id']);
				$data['ccfirstname'] = @$cust_con['first_name'];
				$data['cclastname'] = @$cust_con['last_name'];
				$data['ccemail'] = @$cust_con['email'];
				$data['cctelephone'] = @$cust_con['telephone_number'];
				$data['quote_id'] = @$quote_info['quote_id'];
				
				$this->load->model('replogic/sales_rep_management');
				$salesrep = $this->model_replogic_sales_rep_management->getsalesrep(@$quote_info['salesrep_id']);
				
				$data['ssfirstname'] = @$salesrep['salesrep_name'];
				$data['sslastname'] = @$salesrep['salesrep_lastname'];
				
				$data['Qdate_added'] = date('d M, Y', strtotime(@$quote_info['date_added']));
			}
			else
			{
				$arr = array('address_1'=>$order_info['shipping_address_1'],'address_2'=>$order_info['shipping_address_2'],'city'=>$order_info['shipping_city'],'zone'=>$order_info['shipping_zone'],'country'=>$order_info['shipping_country']);
				$data['shipaddress'] = $arr;
				$data['ccfirstname'] = '';
				$data['cclastname'] = '';
				$data['ccemail'] = '';
				$data['cctelephone'] = '';
				$data['quote_id'] = '';
				
				$data['ssfirstname'] = '';
				$data['sslastname'] = '';
				
				$data['Qdate_added'] = '';
			}
			
			$data['isReplogic'] = $order_info['isReplogic'];
			
			if($order_info['isReplogic'])
			{
				$data['channelname'] = 'Saleslogic Rep';
			}
			else
			{
				$data['channelname'] = $order_info['store_name'];
			}
			$data['order_status_id'] = $order_info['order_status_id'];
			$data['account_custom_field'] = $order_info['custom_field'];
			// Custom Fields
			$this->load->model('customer/custom_field');
			$data['account_custom_fields'] = array();
			$filter_data = array(
				'sort'  => 'cf.sort_order',
				'order' => 'ASC'
			);
			$custom_fields = $this->model_customer_custom_field->getCustomFields($filter_data);
			foreach ($custom_fields as $custom_field) {
				if ($custom_field['location'] == 'account' && isset($order_info['custom_field'][$custom_field['custom_field_id']])) {
					if ($custom_field['type'] == 'select' || $custom_field['type'] == 'radio') {
						$custom_field_value_info = $this->model_customer_custom_field->getCustomFieldValue($order_info['custom_field'][$custom_field['custom_field_id']]);
						if ($custom_field_value_info) {
							$data['account_custom_fields'][] = array(
								'name'  => $custom_field['name'],
								'value' => $custom_field_value_info['name']
							);
						}
					}
					if ($custom_field['type'] == 'checkbox' && is_array($order_info['custom_field'][$custom_field['custom_field_id']])) {
						foreach ($order_info['custom_field'][$custom_field['custom_field_id']] as $custom_field_value_id) {
							$custom_field_value_info = $this->model_customer_custom_field->getCustomFieldValue($custom_field_value_id);
							if ($custom_field_value_info) {
								$data['account_custom_fields'][] = array(
									'name'  => $custom_field['name'],
									'value' => $custom_field_value_info['name']
								);
							}
						}
					}
					if ($custom_field['type'] == 'text' || $custom_field['type'] == 'textarea' || $custom_field['type'] == 'file' || $custom_field['type'] == 'date' || $custom_field['type'] == 'datetime' || $custom_field['type'] == 'time') {
						$data['account_custom_fields'][] = array(
							'name'  => $custom_field['name'],
							'value' => $order_info['custom_field'][$custom_field['custom_field_id']]
						);
					}
					if ($custom_field['type'] == 'file') {
						$upload_info = $this->model_tool_upload->getUploadByCode($order_info['custom_field'][$custom_field['custom_field_id']]);
						if ($upload_info) {
							$data['account_custom_fields'][] = array(
								'name'  => $custom_field['name'],
								'value' => $upload_info['name']
							);
						}
					}
				}
			}
			// Custom fields
			$data['payment_custom_fields'] = array();
			foreach ($custom_fields as $custom_field) {
				if ($custom_field['location'] == 'address' && isset($order_info['payment_custom_field'][$custom_field['custom_field_id']])) {
					if ($custom_field['type'] == 'select' || $custom_field['type'] == 'radio') {
						$custom_field_value_info = $this->model_customer_custom_field->getCustomFieldValue($order_info['payment_custom_field'][$custom_field['custom_field_id']]);
						if ($custom_field_value_info) {
							$data['payment_custom_fields'][] = array(
								'name'  => $custom_field['name'],
								'value' => $custom_field_value_info['name'],
								'sort_order' => $custom_field['sort_order']
							);
						}
					}
					if ($custom_field['type'] == 'checkbox' && is_array($order_info['payment_custom_field'][$custom_field['custom_field_id']])) {
						foreach ($order_info['payment_custom_field'][$custom_field['custom_field_id']] as $custom_field_value_id) {
							$custom_field_value_info = $this->model_customer_custom_field->getCustomFieldValue($custom_field_value_id);
							if ($custom_field_value_info) {
								$data['payment_custom_fields'][] = array(
									'name'  => $custom_field['name'],
									'value' => $custom_field_value_info['name'],
									'sort_order' => $custom_field['sort_order']
								);
							}
						}
					}
					if ($custom_field['type'] == 'text' || $custom_field['type'] == 'textarea' || $custom_field['type'] == 'file' || $custom_field['type'] == 'date' || $custom_field['type'] == 'datetime' || $custom_field['type'] == 'time') {
						$data['payment_custom_fields'][] = array(
							'name'  => $custom_field['name'],
							'value' => $order_info['payment_custom_field'][$custom_field['custom_field_id']],
							'sort_order' => $custom_field['sort_order']
						);
					}
					if ($custom_field['type'] == 'file') {
						$upload_info = $this->model_tool_upload->getUploadByCode($order_info['payment_custom_field'][$custom_field['custom_field_id']]);
						if ($upload_info) {
							$data['payment_custom_fields'][] = array(
								'name'  => $custom_field['name'],
								'value' => $upload_info['name'],
								'sort_order' => $custom_field['sort_order']
							);
						}
					}
				}
			}
			// Shipping
			$data['shipping_custom_fields'] = array();
			foreach ($custom_fields as $custom_field) {
				if ($custom_field['location'] == 'address' && isset($order_info['shipping_custom_field'][$custom_field['custom_field_id']])) {
					if ($custom_field['type'] == 'select' || $custom_field['type'] == 'radio') {
						$custom_field_value_info = $this->model_customer_custom_field->getCustomFieldValue($order_info['shipping_custom_field'][$custom_field['custom_field_id']]);
						if ($custom_field_value_info) {
							$data['shipping_custom_fields'][] = array(
								'name'  => $custom_field['name'],
								'value' => $custom_field_value_info['name'],
								'sort_order' => $custom_field['sort_order']
							);
						}
					}
					if ($custom_field['type'] == 'checkbox' && is_array($order_info['shipping_custom_field'][$custom_field['custom_field_id']])) {
						foreach ($order_info['shipping_custom_field'][$custom_field['custom_field_id']] as $custom_field_value_id) {
							$custom_field_value_info = $this->model_customer_custom_field->getCustomFieldValue($custom_field_value_id);
							if ($custom_field_value_info) {
								$data['shipping_custom_fields'][] = array(
									'name'  => $custom_field['name'],
									'value' => $custom_field_value_info['name'],
									'sort_order' => $custom_field['sort_order']
								);
							}
						}
					}
					if ($custom_field['type'] == 'text' || $custom_field['type'] == 'textarea' || $custom_field['type'] == 'file' || $custom_field['type'] == 'date' || $custom_field['type'] == 'datetime' || $custom_field['type'] == 'time') {
						$data['shipping_custom_fields'][] = array(
							'name'  => $custom_field['name'],
							'value' => $order_info['shipping_custom_field'][$custom_field['custom_field_id']],
							'sort_order' => $custom_field['sort_order']
						);
					}
					if ($custom_field['type'] == 'file') {
						$upload_info = $this->model_tool_upload->getUploadByCode($order_info['shipping_custom_field'][$custom_field['custom_field_id']]);
						if ($upload_info) {
							$data['shipping_custom_fields'][] = array(
								'name'  => $custom_field['name'],
								'value' => $upload_info['name'],
								'sort_order' => $custom_field['sort_order']
							);
						}
					}
				}
			}
			$data['ip'] = $order_info['ip'];
			$data['forwarded_ip'] = $order_info['forwarded_ip'];
			$data['user_agent'] = $order_info['user_agent'];
			$data['accept_language'] = $order_info['accept_language'];
			// Additional Tabs
			$data['tabs'] = array();
			if ($this->user->hasPermission('access', 'extension/payment/' . $order_info['payment_code'])) {
				if (is_file(DIR_CATALOG . 'controller/extension/payment/' . $order_info['payment_code'] . '.php')) {
					$content = $this->load->controller('extension/payment/' . $order_info['payment_code'] . '/order');
				} else {
					$content = null;
				}
				if ($content) {
					$this->load->language('extension/payment/' . $order_info['payment_code']);
					$data['tabs'][] = array(
						'code'    => $order_info['payment_code'],
						'title'   => $this->language->get('heading_title'),
						'content' => $content
					);
				}
			}
			$this->load->model('extension/extension');
			$extensions = $this->model_extension_extension->getInstalled('fraud');
			foreach ($extensions as $extension) {
				if ($this->config->get($extension . '_status')) {
					$this->load->language('extension/fraud/' . $extension);
					$content = $this->load->controller('extension/fraud/' . $extension . '/order');
					if ($content) {
						$data['tabs'][] = array(
							'code'    => $extension,
							'title'   => $this->language->get('heading_title'),
							'content' => $content
						);
					}
				}
			}
			
			// The URL we send API requests to
			$data['catalog'] = $this->request->server['HTTPS'] ? HTTPS_CATALOG : HTTP_CATALOG;
			
			// API login
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
			//$this->response->setOutput($this->load->view('sale/order_info', $data));
			$this->response->setOutput($this->load->view('sale/order_info_new', $data));
		} else {
			return new Action('error/not_found');
		}
	}
	
	protected function validate() {
		if (!$this->user->hasPermission('modify', 'sale/order')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}
		return !$this->error;
	}
	
	public function createInvoiceNo() {
		$this->load->language('sale/order');
		$json = array();
		if (!$this->user->hasPermission('modify', 'sale/order')) {
			$json['error'] = $this->language->get('error_permission');
		} elseif (isset($this->request->get['order_id'])) {
			if (isset($this->request->get['order_id'])) {
				$order_id = $this->request->get['order_id'];
			} else {
				$order_id = 0;
			}
			$this->load->model('sale/order');
			$invoice_no = $this->model_sale_order->createInvoiceNo($order_id);
			if ($invoice_no) {
				$json['invoice_no'] = $invoice_no;
			} else {
				$json['error'] = $this->language->get('error_action');
			}
		}
		$this->response->addHeader('Content-Type: application/json');
		$this->response->setOutput(json_encode($json));
	}

	public function addReward() {
		$this->load->language('sale/order');
		$json = array();
		if (!$this->user->hasPermission('modify', 'sale/order')) {
			$json['error'] = $this->language->get('error_permission');
		} else {
			if (isset($this->request->get['order_id'])) {
				$order_id = $this->request->get['order_id'];
			} else {
				$order_id = 0;
			}
			$this->load->model('sale/order');
			$order_info = $this->model_sale_order->getOrder($order_id);
			if ($order_info && $order_info['customer_id'] && ($order_info['reward'] > 0)) {
				$this->load->model('customer/customer');
				$reward_total = $this->model_customer_customer->getTotalCustomerRewardsByOrderId($order_id);
				if (!$reward_total) {
					$this->model_customer_customer->addReward($order_info['customer_id'], $this->language->get('text_order_id') . ' #' . $order_id, $order_info['reward'], $order_id);
				}
			}
			$json['success'] = $this->language->get('text_reward_added');
		}
		$this->response->addHeader('Content-Type: application/json');
		$this->response->setOutput(json_encode($json));
	}

	public function removeReward() {
		$this->load->language('sale/order');
		$json = array();
		if (!$this->user->hasPermission('modify', 'sale/order')) {
			$json['error'] = $this->language->get('error_permission');
		} else {
			if (isset($this->request->get['order_id'])) {
				$order_id = $this->request->get['order_id'];
			} else {
				$order_id = 0;
			}
			$this->load->model('sale/order');
			$order_info = $this->model_sale_order->getOrder($order_id);
			if ($order_info) {
				$this->load->model('customer/customer');
				$this->model_customer_customer->deleteReward($order_id);
			}
			$json['success'] = $this->language->get('text_reward_removed');
		}
		$this->response->addHeader('Content-Type: application/json');
		$this->response->setOutput(json_encode($json));
	}

	public function addCommission() {
		$this->load->language('sale/order');
		$json = array();
		if (!$this->user->hasPermission('modify', 'sale/order')) {
			$json['error'] = $this->language->get('error_permission');
		} else {
			if (isset($this->request->get['order_id'])) {
				$order_id = $this->request->get['order_id'];
			} else {
				$order_id = 0;
			}
			$this->load->model('sale/order');
			$order_info = $this->model_sale_order->getOrder($order_id);
			if ($order_info) {
				$this->load->model('marketing/affiliate');
				$affiliate_total = $this->model_marketing_affiliate->getTotalTransactionsByOrderId($order_id);
				if (!$affiliate_total) {
					$this->model_marketing_affiliate->addTransaction($order_info['affiliate_id'], $this->language->get('text_order_id') . ' #' . $order_id, $order_info['commission'], $order_id);
				}
			}
			$json['success'] = $this->language->get('text_commission_added');
		}
		$this->response->addHeader('Content-Type: application/json');
		$this->response->setOutput(json_encode($json));
	}

	public function removeCommission() {
		$this->load->language('sale/order');
		$json = array();
		if (!$this->user->hasPermission('modify', 'sale/order')) {
			$json['error'] = $this->language->get('error_permission');
		} else {
			if (isset($this->request->get['order_id'])) {
				$order_id = $this->request->get['order_id'];
			} else {
				$order_id = 0;
			}
			$this->load->model('sale/order');
			$order_info = $this->model_sale_order->getOrder($order_id);
			if ($order_info) {
				$this->load->model('marketing/affiliate');
				$this->model_marketing_affiliate->deleteTransaction($order_id);
			}
			$json['success'] = $this->language->get('text_commission_removed');
		}
		$this->response->addHeader('Content-Type: application/json');
		$this->response->setOutput(json_encode($json));
	}

	public function history() {
		$this->load->language('sale/order');
		$data['text_no_results'] = $this->language->get('text_no_results');
		$data['column_date_added'] = $this->language->get('column_date_added');
		$data['column_status'] = $this->language->get('column_status');
		$data['column_notify'] = $this->language->get('column_notify');
		$data['column_comment'] = $this->language->get('column_comment');
		if (isset($this->request->get['page'])) {
			$page = $this->request->get['page'];
		} else {
			$page = 1;
		}
		$data['histories'] = array();
		$this->load->model('sale/order');
		$results = $this->model_sale_order->getOrderHistories($this->request->get['order_id'], ($page - 1) * 10, 10);
		foreach ($results as $result) {
			$data['histories'][] = array(
				'notify'     => $result['notify'] ? $this->language->get('text_yes') : $this->language->get('text_no'),
				'status'     => $result['status'],
				'comment'    => nl2br($result['comment']),
				'date_added' => date($this->language->get('date_format_short'), strtotime($result['date_added']))
			);
		}
		$history_total = $this->model_sale_order->getTotalOrderHistories($this->request->get['order_id']);
		$pagination = new Pagination();
		$pagination->total = $history_total;
		$pagination->page = $page;
		$pagination->limit = 10;
		$pagination->url = $this->url->link('sale/order/history', 'token=' . $this->session->data['token'] . '&order_id=' . $this->request->get['order_id'] . '&page={page}', true);
		$data['pagination'] = $pagination->render();
		$data['results'] = sprintf($this->language->get('text_pagination'), ($history_total) ? (($page - 1) * 10) + 1 : 0, ((($page - 1) * 10) > ($history_total - 10)) ? $history_total : ((($page - 1) * 10) + 10), $history_total, ceil($history_total / 10));
		$this->response->setOutput($this->load->view('sale/order_history', $data));
	}

	public function invoice() {
		$this->load->language('sale/order');
		$data['title'] = $this->language->get('text_invoice');
		if ($this->request->server['HTTPS']) {
			$data['base'] = HTTPS_SERVER;
		} else {
			$data['base'] = HTTP_SERVER;
		}
		$data['direction'] = $this->language->get('direction');
		$data['lang'] = $this->language->get('code');
		$data['text_invoice'] = $this->language->get('text_invoice');
		$data['text_order_detail'] = $this->language->get('text_order_detail');
		$data['text_order_id'] = $this->language->get('text_order_id');
		$data['text_invoice_no'] = $this->language->get('text_invoice_no');
		$data['text_invoice_date'] = $this->language->get('text_invoice_date');
		$data['text_date_added'] = $this->language->get('text_date_added');
		$data['text_telephone'] = $this->language->get('text_telephone');
		$data['text_fax'] = $this->language->get('text_fax');
		$data['text_email'] = $this->language->get('text_email');
		$data['text_website'] = $this->language->get('text_website');
		$data['text_payment_address'] = $this->language->get('text_payment_address');
		$data['text_shipping_address'] = $this->language->get('text_shipping_address');
		$data['text_payment_method'] = $this->language->get('text_payment_method');
		$data['text_shipping_method'] = $this->language->get('text_shipping_method');
		$data['text_comment'] = $this->language->get('text_comment');
		
		$data['column_product'] = $this->language->get('column_product');
		$data['column_model'] = $this->language->get('column_model');
		$data['column_quantity'] = $this->language->get('column_quantity');
		$data['column_price'] = $this->language->get('column_price');
		$data['column_total'] = $this->language->get('column_total');
		$this->load->model('sale/order');
		$this->load->model('setting/setting');
		$data['orders'] = array();
		$orders = array();
		if (isset($this->request->post['selected'])) {
			$orders = $this->request->post['selected'];
		} elseif (isset($this->request->get['order_id'])) {
			$orders[] = $this->request->get['order_id'];
		}
		foreach ($orders as $order_id) {
			$order_info = $this->model_sale_order->getOrder($order_id);
			if ($order_info) {
				$store_info = $this->model_setting_setting->getSetting('config', $order_info['store_id']);
				if ($store_info) {
					$store_address = $store_info['config_address'];
					$store_email = $store_info['config_email'];
					$store_telephone = $store_info['config_telephone'];
					$store_fax = $store_info['config_fax'];
				} else {
					$store_address = $this->config->get('config_address');
					$store_email = $this->config->get('config_email');
					$store_telephone = $this->config->get('config_telephone');
					$store_fax = $this->config->get('config_fax');
				}
				if ($order_info['invoice_no']) {
					$invoice_no = $order_info['invoice_prefix'] . $order_info['invoice_no'];
				} else {
					$invoice_no = '';
				}
				if ($order_info['payment_address_format']) {
					$format = $order_info['payment_address_format'];
				} else {
					$format = '{firstname} {lastname}' . "\n" . '{company}' . "\n" . '{address_1}' . "\n" . '{address_2}' . "\n" . '{city} {postcode}' . "\n" . '{zone}' . "\n" . '{country}';
				}
				$find = array(
					'{firstname}',
					'{lastname}',
					'{company}',
					'{address_1}',
					'{address_2}',
					'{city}',
					'{postcode}',
					'{zone}',
					'{zone_code}',
					'{country}'
				);
				$replace = array(
					'firstname' => $order_info['payment_firstname'],
					'lastname'  => $order_info['payment_lastname'],
					'company'   => $order_info['payment_company'],
					'address_1' => $order_info['payment_address_1'],
					'address_2' => $order_info['payment_address_2'],
					'city'      => $order_info['payment_city'],
					'postcode'  => $order_info['payment_postcode'],
					'zone'      => $order_info['payment_zone'],
					'zone_code' => $order_info['payment_zone_code'],
					'country'   => $order_info['payment_country']
				);
				$payment_address = str_replace(array("\r\n", "\r", "\n"), '<br />', preg_replace(array("/\s\s+/", "/\r\r+/", "/\n\n+/"), '<br />', trim(str_replace($find, $replace, $format))));
				if ($order_info['shipping_address_format']) {
					$format = $order_info['shipping_address_format'];
				} else {
					$format = '{firstname} {lastname}' . "\n" . '{company}' . "\n" . '{address_1}' . "\n" . '{address_2}' . "\n" . '{city} {postcode}' . "\n" . '{zone}' . "\n" . '{country}';
				}
				$find = array(
					'{firstname}',
					'{lastname}',
					'{company}',
					'{address_1}',
					'{address_2}',
					'{city}',
					'{postcode}',
					'{zone}',
					'{zone_code}',
					'{country}'
				);
				$replace = array(
					'firstname' => $order_info['shipping_firstname'],
					'lastname'  => $order_info['shipping_lastname'],
					'company'   => $order_info['shipping_company'],
					'address_1' => $order_info['shipping_address_1'],
					'address_2' => $order_info['shipping_address_2'],
					'city'      => $order_info['shipping_city'],
					'postcode'  => $order_info['shipping_postcode'],
					'zone'      => $order_info['shipping_zone'],
					'zone_code' => $order_info['shipping_zone_code'],
					'country'   => $order_info['shipping_country']
				);
				$shipping_address = str_replace(array("\r\n", "\r", "\n"), '<br />', preg_replace(array("/\s\s+/", "/\r\r+/", "/\n\n+/"), '<br />', trim(str_replace($find, $replace, $format))));
				$this->load->model('tool/upload');
				$product_data = array();
				$products = $this->model_sale_order->getOrderProducts($order_id);
				foreach ($products as $product) {
					$option_data = array();
					$options = $this->model_sale_order->getOrderOptions($order_id, $product['order_product_id']);
					foreach ($options as $option) {
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
							'value' => $value
						);
					}
					$product_data[] = array(
						'name'     => $product['name'],
						'model'    => $product['model'],
						'option'   => $option_data,
						'quantity' => $product['quantity'],
						'price'    => $this->currency->format($product['price'] + ($this->config->get('config_tax') ? $product['tax'] : 0), $order_info['currency_code'], $order_info['currency_value']),
						'total'    => $this->currency->format($product['total'] + ($this->config->get('config_tax') ? ($product['tax'] * $product['quantity']) : 0), $order_info['currency_code'], $order_info['currency_value'])
					);
				}
				$voucher_data = array();
				$vouchers = $this->model_sale_order->getOrderVouchers($order_id);
				foreach ($vouchers as $voucher) {
					$voucher_data[] = array(
						'description' => $voucher['description'],
						'amount'      => $this->currency->format($voucher['amount'], $order_info['currency_code'], $order_info['currency_value'])
					);
				}
				$total_data = array();
				$totals = $this->model_sale_order->getOrderTotals($order_id);
				foreach ($totals as $total) {
					$total_data[] = array(
						'title' => $total['title'],
						'text'  => $this->currency->format($total['value'], $order_info['currency_code'], $order_info['currency_value'])
					);
				}
				$data['orders'][] = array(
					'order_id'	       => $order_id,
					'invoice_no'       => $invoice_no,
					'date_added'       => date($this->language->get('date_format_short'), strtotime($order_info['date_added'])),
					'store_name'       => $order_info['store_name'],
					'store_url'        => rtrim($order_info['store_url'], '/'),
					'store_address'    => nl2br($store_address),
					'store_email'      => $store_email,
					'store_telephone'  => $store_telephone,
					'store_fax'        => $store_fax,
					'email'            => $order_info['email'],
					'telephone'        => $order_info['telephone'],
					'shipping_address' => $shipping_address,
					'shipping_method'  => $order_info['shipping_method'],
					'payment_address'  => $payment_address,
					'payment_method'   => $order_info['payment_method'],
					'product'          => $product_data,
					'voucher'          => $voucher_data,
					'total'            => $total_data,
					'comment'          => nl2br($order_info['comment'])
				);
			}
		}
		$this->response->setOutput($this->load->view('sale/order_invoice', $data));
	}

	public function shipping() {
		$this->load->language('sale/order');
		$data['title'] = $this->language->get('text_shipping');
		if ($this->request->server['HTTPS']) {
			$data['base'] = HTTPS_SERVER;
		} else {
			$data['base'] = HTTP_SERVER;
		}
		$data['direction'] = $this->language->get('direction');
		$data['lang'] = $this->language->get('code');
		$data['text_shipping'] = $this->language->get('text_shipping');
		$data['text_picklist'] = $this->language->get('text_picklist');
		$data['text_order_detail'] = $this->language->get('text_order_detail');
		$data['text_order_id'] = $this->language->get('text_order_id');
		$data['text_invoice_no'] = $this->language->get('text_invoice_no');
		$data['text_invoice_date'] = $this->language->get('text_invoice_date');
		$data['text_date_added'] = $this->language->get('text_date_added');
		$data['text_telephone'] = $this->language->get('text_telephone');
		$data['text_fax'] = $this->language->get('text_fax');
		$data['text_email'] = $this->language->get('text_email');
		$data['text_website'] = $this->language->get('text_website');
		$data['text_contact'] = $this->language->get('text_contact');
		$data['text_shipping_address'] = $this->language->get('text_shipping_address');
		$data['text_shipping_method'] = $this->language->get('text_shipping_method');
		$data['text_sku'] = $this->language->get('text_sku');
		$data['text_upc'] = $this->language->get('text_upc');
		$data['text_ean'] = $this->language->get('text_ean');
		$data['text_jan'] = $this->language->get('text_jan');
		$data['text_isbn'] = $this->language->get('text_isbn');
		$data['text_mpn'] = $this->language->get('text_mpn');
		$data['text_comment'] = $this->language->get('text_comment');
		$data['column_location'] = $this->language->get('column_location');
		$data['column_reference'] = $this->language->get('column_reference');
		
		$data['column_product'] = $this->language->get('column_product');
		$data['column_weight'] = $this->language->get('column_weight');
		$data['column_model'] = $this->language->get('column_model');
		$data['column_quantity'] = $this->language->get('column_quantity');
		$this->load->model('sale/order');
		$this->load->model('catalog/product');
		$this->load->model('setting/setting');
		$data['orders'] = array();
		$orders = array();
		if (isset($this->request->post['selected'])) {
			$orders = $this->request->post['selected'];
		} elseif (isset($this->request->get['order_id'])) {
			$orders[] = $this->request->get['order_id'];
		}
		foreach ($orders as $order_id) {
			$order_info = $this->model_sale_order->getOrder($order_id);
			// Make sure there is a shipping method
			if ($order_info && $order_info['shipping_code']) {
				$store_info = $this->model_setting_setting->getSetting('config', $order_info['store_id']);
				if ($store_info) {
					$store_address = $store_info['config_address'];
					$store_email = $store_info['config_email'];
					$store_telephone = $store_info['config_telephone'];
					$store_fax = $store_info['config_fax'];
				} else {
					$store_address = $this->config->get('config_address');
					$store_email = $this->config->get('config_email');
					$store_telephone = $this->config->get('config_telephone');
					$store_fax = $this->config->get('config_fax');
				}
				if ($order_info['invoice_no']) {
					$invoice_no = $order_info['invoice_prefix'] . $order_info['invoice_no'];
				} else {
					$invoice_no = '';
				}
				if ($order_info['shipping_address_format']) {
					$format = $order_info['shipping_address_format'];
				} else {
					$format = '{firstname} {lastname}' . "\n" . '{company}' . "\n" . '{address_1}' . "\n" . '{address_2}' . "\n" . '{city} {postcode}' . "\n" . '{zone}' . "\n" . '{country}';
				}
				$find = array(
					'{firstname}',
					'{lastname}',
					'{company}',
					'{address_1}',
					'{address_2}',
					'{city}',
					'{postcode}',
					'{zone}',
					'{zone_code}',
					'{country}'
				);
				$replace = array(
					'firstname' => $order_info['shipping_firstname'],
					'lastname'  => $order_info['shipping_lastname'],
					'company'   => $order_info['shipping_company'],
					'address_1' => $order_info['shipping_address_1'],
					'address_2' => $order_info['shipping_address_2'],
					'city'      => $order_info['shipping_city'],
					'postcode'  => $order_info['shipping_postcode'],
					'zone'      => $order_info['shipping_zone'],
					'zone_code' => $order_info['shipping_zone_code'],
					'country'   => $order_info['shipping_country']
				);
				$shipping_address = str_replace(array("\r\n", "\r", "\n"), '<br />', preg_replace(array("/\s\s+/", "/\r\r+/", "/\n\n+/"), '<br />', trim(str_replace($find, $replace, $format))));
				$this->load->model('tool/upload');
				$product_data = array();
				$products = $this->model_sale_order->getOrderProducts($order_id);
				foreach ($products as $product) {
					$option_weight = '';
					$product_info = $this->model_catalog_product->getProduct($product['product_id']);
					if ($product_info) {
						$option_data = array();
						$options = $this->model_sale_order->getOrderOptions($order_id, $product['order_product_id']);
						foreach ($options as $option) {
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
								'value' => $value
							);
							$product_option_value_info = $this->model_catalog_product->getProductOptionValue($product['product_id'], $option['product_option_value_id']);
							if ($product_option_value_info) {
								if ($product_option_value_info['weight_prefix'] == '+') {
									$option_weight += $product_option_value_info['weight'];
								} elseif ($product_option_value_info['weight_prefix'] == '-') {
									$option_weight -= $product_option_value_info['weight'];
								}
							}
						}
						$product_data[] = array(
							'name'     => $product_info['name'],
							'model'    => $product_info['model'],
							'option'   => $option_data,
							'quantity' => $product['quantity'],
							'location' => $product_info['location'],
							'sku'      => $product_info['sku'],
							'upc'      => $product_info['upc'],
							'ean'      => $product_info['ean'],
							'jan'      => $product_info['jan'],
							'isbn'     => $product_info['isbn'],
							'mpn'      => $product_info['mpn'],
							'weight'   => $this->weight->format(($product_info['weight'] + $option_weight) * $product['quantity'], $product_info['weight_class_id'], $this->language->get('decimal_point'), $this->language->get('thousand_point'))
						);
					}
				}
				$data['orders'][] = array(
					'order_id'	       => $order_id,
					'invoice_no'       => $invoice_no,
					'date_added'       => date($this->language->get('date_format_short'), strtotime($order_info['date_added'])),
					'store_name'       => $order_info['store_name'],
					'store_url'        => rtrim($order_info['store_url'], '/'),
					'store_address'    => nl2br($store_address),
					'store_email'      => $store_email,
					'store_telephone'  => $store_telephone,
					'store_fax'        => $store_fax,
					'email'            => $order_info['email'],
					'telephone'        => $order_info['telephone'],
					'shipping_address' => $shipping_address,
					'shipping_method'  => $order_info['shipping_method'],
					'product'          => $product_data,
					'comment'          => nl2br($order_info['comment'])
				);
			}
		}
		$this->response->setOutput($this->load->view('sale/order_shipping', $data));
	}

	public function cancel() {
		$this->load->language('sale/order');
		$json = array();
		if (!$this->user->hasPermission('modify', 'sale/order')) {
			$json['error'] = $this->language->get('error_permission');
		} else {
			$json['error'] = $this->language->get('error_generic');
			if (isset($this->request->get['order_id'])) {
				$this->load->model('sale/order');
				$order = $this->model_sale_order->getOrder($this->request->get['order_id']);
				if (!empty($order)) {
					$this->model_sale_order->updateOrderStatus($order['order_id'], $this->language->get('order_status_cancelled_id'));
					$json['success'] = $this->language->get('text_cancel_success');
				} else {
					$json['error']   = $this->language->get('error_order_not_found');
				}
			}
		}
		$this->response->addHeader('Content-Type: application/json');
		$this->response->setOutput(json_encode($json));
	}
}
