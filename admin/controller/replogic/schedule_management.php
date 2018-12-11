<?php
class ControllerReplogicScheduleManagement extends Controller {
	private $error = array();
	public function index() {
		$this->document->addStyle('view/stylesheet/custom.css');
		$this->load->language('replogic/schedule_management');
		$this->document->setTitle($this->language->get('heading_title'));
		$this->load->model('replogic/schedule_management');
		$this->getList();
	}
	public function add() {

		# stylesheets (CSS) files
		$this->document->addStyle('view/javascript/jquery/datetimepicker/bootstrap-datetimepicker.min.css');
		$this->document->addStyle('view/stylesheet/material-icons/material-icons.css');
		$this->document->addStyle('view/javascript/bootstrap-sweetalert/sweetalert.css');
		$this->document->addStyle('view/stylesheet/custom.css');
		$this->document->addStyle('view/stylesheet/location_management.css');

		// Javascript file(s)
		$this->document->addScript('view/javascript/bootstrap-sweetalert/sweetalert.min.js');
		$this->document->addScript('view/javascript/bootstrap-sweetalert/sweetalert-data.js');
		$this->document->addScript('view/javascript/schedule_management.js');

		$this->load->language('replogic/schedule_management');
		$this->document->setTitle($this->language->get('heading_title'));
		$this->load->model('replogic/schedule_management');
		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateForm()) {
			$lastid = $this->model_replogic_schedule_management->addScheduleManagement($this->request->post);
			$this->session->data['success'] = $this->language->get('text_success');
			$url = '';
			if (isset($this->request->get['filter_appointment_name'])) {
			$url .= '&filter_appointment_name=' . urlencode(html_entity_decode($this->request->get['filter_appointment_name'], ENT_QUOTES, 'UTF-8'));
			}
			
			if (isset($this->request->get['filter_customer_id'])) {
				$url .= '&filter_customer_id=' . $this->request->get['filter_customer_id'];
			}
			
			if (isset($this->request->get['filter_type'])) {
				$url .= '&filter_type=' . $this->request->get['filter_type'];
			}
	
			if (isset($this->request->get['filter_salesrep_id'])) {
				$url .= '&filter_salesrep_id=' . $this->request->get['filter_salesrep_id'];
			}
			
			if (isset($this->request->get['filter_appointment_from'])) {
				$url .= '&filter_appointment_from=' . $this->request->get['filter_appointment_from'];
			}
	
			if (isset($this->request->get['filter_appointment_to'])) {
				$url .= '&filter_appointment_to=' . $this->request->get['filter_appointment_to'];
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
			$this->response->redirect($this->url->link('replogic/schedule_management/view', 'token=' . $this->session->data['token'] . '&appointment_id=' . $lastid . $url, true));
		}
		$this->getForm();
	}
	public function edit() {

		# stylesheets (CSS) files
		$this->document->addStyle('view/javascript/jquery/datetimepicker/bootstrap-datetimepicker.min.css');
		$this->document->addStyle('view/stylesheet/material-icons/material-icons.css');
		$this->document->addStyle('view/javascript/bootstrap-sweetalert/sweetalert.css');
		$this->document->addStyle('view/stylesheet/custom.css');
		$this->document->addStyle('view/stylesheet/location_management.css');

		// Javascript file(s)
		$this->document->addScript('view/javascript/bootstrap-sweetalert/sweetalert.min.js');
		$this->document->addScript('view/javascript/bootstrap-sweetalert/sweetalert-data.js');
		$this->document->addScript('view/javascript/schedule_management.js');

		$this->load->language('replogic/schedule_management');
		$this->document->setTitle($this->language->get('heading_title'));
		$this->load->model('replogic/schedule_management');
		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateForm()) {
			$this->model_replogic_schedule_management->editScheduleManagement($this->request->get['appointment_id'], $this->request->post);
			$this->session->data['success'] = $this->language->get('text_success');
			$url = '';
			
			if (isset($this->request->get['filter_appointment_name'])) {
				$url .= '&filter_appointment_name=' . urlencode(html_entity_decode($this->request->get['filter_appointment_name'], ENT_QUOTES, 'UTF-8'));
			}
			
			if (isset($this->request->get['filter_customer_id'])) {
				$url .= '&filter_customer_id=' . $this->request->get['filter_customer_id'];
			}
			
			if (isset($this->request->get['filter_type'])) {
				$url .= '&filter_type=' . $this->request->get['filter_type'];
			}
	
			if (isset($this->request->get['filter_salesrep_id'])) {
				$url .= '&filter_salesrep_id=' . $this->request->get['filter_salesrep_id'];
			}
			
			if (isset($this->request->get['filter_appointment_from'])) {
				$url .= '&filter_appointment_from=' . $this->request->get['filter_appointment_from'];
			}
	
			if (isset($this->request->get['filter_appointment_to'])) {
				$url .= '&filter_appointment_to=' . $this->request->get['filter_appointment_to'];
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
			
			if (isset($this->request->get['type'])) 
			{ 
				$this->response->redirect($this->url->link('customer/customer_info/appointmentView', 'appointment_id='.$this->request->get['appointment_id'].'&type='.$this->request->get['type'].'&customer_id='.$this->request->get['customer_id'].'&token=' . $this->session->data['token'], true));
			}
			else
			{ 
				$this->response->redirect($this->url->link('replogic/schedule_management/view', 'token=' . $this->session->data['token'] . '&appointment_id=' . $this->request->get['appointment_id'] . $url, true));
			}
		}
		$this->getForm();
	}
	public function delete() {
		$this->load->language('replogic/schedule_management');
		$this->document->setTitle($this->language->get('heading_title'));
		$this->load->model('replogic/schedule_management');
		if (isset($this->request->post['selected'])) {
			foreach ($this->request->post['selected'] as $appointment_id) {
				$this->model_replogic_schedule_management->deleteAppointment($appointment_id);
			}
			$this->session->data['success'] = $this->language->get('text_success');
			$url = '';
			
			if (isset($this->request->get['filter_appointment_name'])) {
			$url .= '&filter_appointment_name=' . urlencode(html_entity_decode($this->request->get['filter_appointment_name'], ENT_QUOTES, 'UTF-8'));
			}
			
			if (isset($this->request->get['filter_customer_id'])) {
				$url .= '&filter_customer_id=' . $this->request->get['filter_customer_id'];
			}
			
			if (isset($this->request->get['filter_type'])) {
				$url .= '&filter_type=' . $this->request->get['filter_type'];
			}
	
			if (isset($this->request->get['filter_salesrep_id'])) {
				$url .= '&filter_salesrep_id=' . $this->request->get['filter_salesrep_id'];
			}
			
			if (isset($this->request->get['filter_appointment_from'])) {
				$url .= '&filter_appointment_from=' . $this->request->get['filter_appointment_from'];
			}
	
			if (isset($this->request->get['filter_appointment_to'])) {
				$url .= '&filter_appointment_to=' . $this->request->get['filter_appointment_to'];
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
			$this->response->redirect($this->url->link('replogic/schedule_management', 'token=' . $this->session->data['token'] . $url, true));
		}
		$this->getList();
	}
	protected function getList() {
		
		if (isset($this->request->get['filter_appointment_name'])) {
			$filter_appointment_name = $this->request->get['filter_appointment_name'];
		} else {
			$filter_appointment_name = null;
		}
		
		if (isset($this->request->get['filter_customer_id'])) {
			$filter_customer_id = $this->request->get['filter_customer_id'];
		} else {
			$filter_customer_id = null;
		}
		
		if (isset($this->request->get['filter_type'])) {
			$filter_type = $this->request->get['filter_type'];
		} else {
			$filter_type = null;
		}
		if (isset($this->request->get['filter_appointment_from'])) {
			$filter_appointment_from = $this->request->get['filter_appointment_from'];
		} else {
			$filter_appointment_from = null;
		}
		if (isset($this->request->get['filter_appointment_to'])) {
			$filter_appointment_to = $this->request->get['filter_appointment_to'];
		} else {
			$filter_appointment_to = null;
		}
		if (isset($this->request->get['filter_salesrep_id'])) {
			$filter_salesrep_id = $this->request->get['filter_salesrep_id'];
		} else {
			$filter_salesrep_id = null;
		}
		
		if (isset($this->request->get['sort'])) {
			$sort = $this->request->get['sort'];
		} else {
			$sort = 'appointment_date';
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
		if (isset($this->request->get['filter_appointment_name'])) {
			$url .= '&filter_appointment_name=' . urlencode(html_entity_decode($this->request->get['filter_appointment_name'], ENT_QUOTES, 'UTF-8'));
		}
		
		if (isset($this->request->get['filter_customer_id'])) {
			$url .= '&filter_customer_id=' . $this->request->get['filter_customer_id'];
		}
		
		if (isset($this->request->get['filter_type'])) {
			$url .= '&filter_type=' . $this->request->get['filter_type'];
		}
		if (isset($this->request->get['filter_salesrep_id'])) {
			$url .= '&filter_salesrep_id=' . $this->request->get['filter_salesrep_id'];
		}
		
		if (isset($this->request->get['filter_appointment_from'])) {
			$url .= '&filter_appointment_from=' . $this->request->get['filter_appointment_from'];
		}
		if (isset($this->request->get['filter_appointment_to'])) {
			$url .= '&filter_appointment_to=' . $this->request->get['filter_appointment_to'];
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
			'href' => $this->url->link('replogic/schedule_management', 'token=' . $this->session->data['token'] . $url, true)
		);
		$data['add'] = $this->url->link('replogic/schedule_management/add', 'token=' . $this->session->data['token'] . $url, true);
		$data['delete'] = $this->url->link('replogic/schedule_management/delete', 'token=' . $this->session->data['token'] . $url, true);
		$data['schedule_managements'] = array();
		$filter_data = array(
			'filter_appointment_name'	  => $filter_appointment_name,
			'filter_customer_id'  => $filter_customer_id,
			'filter_appointment_from'	  => $filter_appointment_from,
			'filter_appointment_to'	  => $filter_appointment_to,
			'filter_salesrep_id' => $filter_salesrep_id,
			'filter_type' => $filter_type,
			'sort'  => $sort,
			'order' => $order,
			'start' => ($page - 1) * $this->config->get('config_limit_admin'),
			'limit' => $this->config->get('config_limit_admin')
		);
		$this->load->model('user/user');
		$this->load->model('user/user_group');
		
		$current_user = $this->session->data['user_id'];
		$current_user_group_id = $this->model_user_user->getUser($current_user); ;
		$current_user_group = $this->model_user_user_group->getUserGroup($current_user_group_id['user_group_id']); ;
		//print_r($current_user_group); exit;
		if($current_user_group_id['user_group_id'] == '15' || $current_user_group_id['user_group_id'] == '19')
		{
			$data['access'] = 'yes';
			$allaccess = true;
			$current_user_id = 0;
		}
		else
		{ 
			$data['access'] = 'yes';
			$allaccess = false;
			$current_user_id = $this->session->data['user_id'];
			
		}
		
		$schedule_management_total = $this->model_replogic_schedule_management->getTotalScheduleManagement($filter_data, $allaccess, $current_user_id);
		$results = $this->model_replogic_schedule_management->getScheduleManagement($filter_data, $allaccess, $current_user_id);
		
		$this->load->model('replogic/sales_rep_management');
		 $data['salesReps'] = $this->model_replogic_sales_rep_management->getSalesRepsDropdown($allaccess, $current_user_id);
		
		foreach ($results as $result) {

			# appointment date
			$appointmentDate = date("D d M Y", strtotime($result['appointment_date'])); 
			$appointmentDate.= " at " . date("<b>g:i A</b>", strtotime($result['appointment_date']));

			# visit date
			$visitDate = (!empty($result['checkin']) && $result['checkin']<>"") ? date("D d M Y", strtotime($result['checkin'])) : "";
			$visitDate.= (!empty($result['checkin']) && $result['checkin']<>"") ? " at " . date("<b>g:i A</b>", strtotime($result['checkin'])) : "";
			$apointResult = $this->model_replogic_schedule_management->getprospective($result['customer_id']);
			//var_dump($apointResult['name']);die;
			if ($result['type'] == "New Business"){
				$ustomer_Name = $apointResult['name'];
			}else{
				$ustomer_Name = $result['customer_name'];
			}
			
			$data['appointments'][] = array(
				'appointment_id'   => $result['appointment_id'],
				'appointment_name' => $result['appointment_name'],
				'appointment_type' => $result['type'],
				'salesrep_name'    => $result['salesrepname'],
				'customer_name'    => $ustomer_Name,
				'appointment_date' => $appointmentDate,
				'visit_date'       => $visitDate,
				'tasks'            => $this->url->link('replogic/tasks', 'token=' . $this->session->data['token'] . '&appointment_id=' . $result['appointment_id'] . $url, true),
				'notes'            => $this->url->link('replogic/notes', 'token=' . $this->session->data['token'] . '&appointment_id=' . $result['appointment_id'] . $url, true),
				'view'             => $this->url->link('replogic/schedule_management/view', 'token=' . $this->session->data['token'] . '&appointment_id=' . $result['appointment_id'] . $url, true),
				'edit'             => $this->url->link('replogic/schedule_management/edit', 'token=' . $this->session->data['token'] . '&appointment_id=' . $result['appointment_id'] . $url, true)
			);
		}
		
		$this->load->model('user/user_group');
		$this->load->model('user/user');
		$this->load->model('customer/customer');
		$user_group_id = $this->model_user_user_group->getUserGroupByName('Sales Manager');
		$data['sales_managers'] = $this->model_user_user->getUsersByGroupId($user_group_id['user_group_id']);
		
		$data['customers'] = $this->model_customer_customer->getCustomers();
		
		if($filter_customer_id)
		{
			$filtercustomerinfo = $this->model_customer_customer->getCustomer($filter_customer_id);
			$data['filter_customer'] = $filtercustomerinfo['firstname'];
		}
		else
		{
			$data['filter_customer'] = '';
		}
		
		if($filter_salesrep_id)
		{
			$salesreinfo = $this->model_replogic_sales_rep_management->getsalesrep($filter_salesrep_id);
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
		$data['column_name'] = $this->language->get('column_name');
		$data['column_action'] = $this->language->get('column_action');
		$data['button_add'] = $this->language->get('button_add');
		$data['button_edit'] = $this->language->get('button_edit');
		$data['button_delete'] = $this->language->get('button_delete');
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
		
		if (isset($this->request->get['filter_appointment_name'])) {
			$url .= '&filter_appointment_name=' . urlencode(html_entity_decode($this->request->get['filter_appointment_name'], ENT_QUOTES, 'UTF-8'));
		}
		if (isset($this->request->get['filter_customer_id'])) {
			$url .= '&filter_customer_id=' . $this->request->get['filter_customer_id'];
		}
		
		if (isset($this->request->get['filter_type'])) {
			$url .= '&filter_type=' . $this->request->get['filter_type'];
		}
		
		if (isset($this->request->get['filter_salesrep_id'])) {
			$url .= '&filter_salesrep_id=' . $this->request->get['filter_salesrep_id'];
		}
		
		if (isset($this->request->get['filter_appointment_from'])) {
			$url .= '&filter_appointment_from=' . $this->request->get['filter_appointment_from'];
		}
		if (isset($this->request->get['filter_appointment_to'])) {
			$url .= '&filter_appointment_to=' . $this->request->get['filter_appointment_to'];
		}
		
		if ($order == 'ASC') {
			$url .= '&order=DESC';
		} else {
			$url .= '&order=ASC';
		}
		if (isset($this->request->get['page'])) {
			$url .= '&page=' . $this->request->get['page'];
		}
		$data['sort_name'] = $this->url->link('replogic/schedule_management', 'token=' . $this->session->data['token'] . '&sort=appointment_name' . $url, true);
		$data['sort_appointment_date'] = $this->url->link('replogic/schedule_management', 'token=' . $this->session->data['token'] . '&sort=appointment_date' . $url, true);
		$data['sort_type'] = $this->url->link('replogic/schedule_management', 'token=' . $this->session->data['token'] . '&sort=type' . $url, true);
		$data['sort_salesrepname'] = $this->url->link('replogic/schedule_management', 'token=' . $this->session->data['token'] . '&sort=salesrepname' . $url, true);
		$url = '';
		
		if (isset($this->request->get['filter_appointment_name'])) {
			$url .= '&filter_appointment_name=' . urlencode(html_entity_decode($this->request->get['filter_appointment_name'], ENT_QUOTES, 'UTF-8'));
		}
		
		if (isset($this->request->get['filter_customer_id'])) {
			$url .= '&filter_customer_id=' . $this->request->get['filter_customer_id'];
		}
		
		if (isset($this->request->get['filter_type'])) {
			$url .= '&filter_type=' . $this->request->get['filter_type'];
		}
		if (isset($this->request->get['filter_salesrep_id'])) {
			$url .= '&filter_salesrep_id=' . $this->request->get['filter_salesrep_id'];
		}
		
		if (isset($this->request->get['filter_appointment_from'])) {
			$url .= '&filter_appointment_from=' . $this->request->get['filter_appointment_from'];
		}
		if (isset($this->request->get['filter_appointment_to'])) {
			$url .= '&filter_appointment_to=' . $this->request->get['filter_appointment_to'];
		}
		
		if (isset($this->request->get['sort'])) {
			$url .= '&sort=' . $this->request->get['sort'];
		}
		if (isset($this->request->get['order'])) {
			$url .= '&order=' . $this->request->get['order'];
		}
		$pagination = new Pagination();
		$pagination->total = $schedule_management_total;
		$pagination->page = $page;
		$pagination->limit = $this->config->get('config_limit_admin');
		$pagination->url = $this->url->link('replogic/schedule_management', 'token=' . $this->session->data['token'] . $url . '&page={page}', true);
		$data['pagination'] = $pagination->render();
		$data['results'] = sprintf($this->language->get('text_pagination'), ($schedule_management_total) ? (($page - 1) * $this->config->get('config_limit_admin')) + 1 : 0, ((($page - 1) * $this->config->get('config_limit_admin')) > ($schedule_management_total - $this->config->get('config_limit_admin'))) ? $schedule_management_total : ((($page - 1) * $this->config->get('config_limit_admin')) + $this->config->get('config_limit_admin')), $schedule_management_total, ceil($schedule_management_total / $this->config->get('config_limit_admin')));
		$data['filter_appointment_name'] = $filter_appointment_name;
		$data['filter_customer_id'] = $filter_customer_id;
		$data['filter_appointment_from'] = $filter_appointment_from;
		$data['filter_appointment_to'] = $filter_appointment_to;
		$data['filter_salesrep_id'] = $filter_salesrep_id;
		$data['filter_type'] = $filter_type;
		$data['sort'] = $sort;
		$data['order'] = $order;
		$data['header'] = $this->load->controller('common/header');
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['footer'] = $this->load->controller('common/footer');
		$this->response->setOutput($this->load->view('replogic/schedule_management_list', $data));
	}
	protected function getForm() {
		$data['heading_title'] = $this->language->get('heading_title');
		
		$data['text_form'] = !isset($this->request->get['appointment_id']) ? $this->language->get('text_add') : $this->language->get('text_edit');
		$data['text_select_all'] = $this->language->get('text_select_all');
		$data['text_unselect_all'] = $this->language->get('text_unselect_all');
		$data['entry_name'] = $this->language->get('entry_name');
		$data['entry_appointment_description'] = $this->language->get('entry_appointment_description');
		$data['entry_appointment_date'] = $this->language->get('entry_appointment_date');
		$data['entry_customer'] = $this->language->get('entry_customer');
		$data['entry_duration'] = $this->language->get('entry_duration');
		$data['entry_available_times'] = $this->language->get('entry_available_times');
		
		$data['entry_sales'] = $this->language->get('entry_sales');
		$data['entry_access'] = $this->language->get('entry_access');
		$data['entry_modify'] = $this->language->get('entry_modify');
		$data['button_save'] = $this->language->get('button_save');
		$data['button_cancel'] = $this->language->get('button_cancel');
		$data['token'] = $this->session->data['token'];
		if (isset($this->error['warning'])) {
			$data['error_warning'] = $this->error['warning'];
		} else {
			$data['error_warning'] = '';
		}
		if (isset($this->error['appointment_name'])) {
			$data['error_appointment_name'] = $this->error['appointment_name'];
		} else {
			$data['error_appointment_name'] = '';
		}
		
		if (isset($this->error['appointment_description'])) {
			$data['error_appointment_description'] = $this->error['appointment_description'];
		} else {
			$data['error_appointment_description'] = '';
		}
		
		if (isset($this->error['appointment_date'])) {
			$data['error_appointment_date'] = $this->error['appointment_date'];
		} else {
			$data['error_appointment_date'] = '';
		}
		
		if (isset($this->error['salesrep_id'])) {
			$data['error_salesrep_id'] = $this->error['salesrep_id'];
		} else {
			$data['error_salesrep_id'] = '';
		}
		
		if (isset($this->error['type'])) {
			$data['error_type'] = $this->error['type'];
		} else {
			$data['error_type'] = '';
		}
		
		if (isset($this->error['bcustomer_name'])) {
			$data['error_bcustomer_name'] = $this->error['bcustomer_name'];
		} else {
			$data['error_bcustomer_name'] = '';
		}
		
		if (isset($this->error['address'])) {
			$data['error_address'] = $this->error['address'];
		} else {
			$data['error_address'] = '';
		}
		
		if (isset($this->error['appointment_address'])) {
			$data['error_appointment_address'] = $this->error['appointment_address'];
		} else {
			$data['error_appointment_address'] = '';
		}
		
		if (isset($this->error['customer_id'])) {
			$data['error_customer_id'] = $this->error['customer_id'];
		} else {
			$data['error_customer_id'] = '';
		}
		
		if (isset($this->error['hour'])) {
			$data['error_hour'] = $this->error['hour'];
		} else {
			$data['error_hour'] = '';
		}
		
		if (isset($this->error['minutes'])) {
			$data['error_minutes'] = $this->error['minutes'];
		} else {
			$data['error_minutes'] = '';
		}
		$url = '';
		if (isset($this->request->get['filter_appointment_name'])) {
			$url .= '&filter_appointment_name=' . urlencode(html_entity_decode($this->request->get['filter_appointment_name'], ENT_QUOTES, 'UTF-8'));
		}
		if (isset($this->request->get['filter_customer_id'])) {
			$url .= '&filter_customer_id=' . $this->request->get['filter_customer_id'];
		}
		
		if (isset($this->request->get['filter_salesrep_id'])) {
			$url .= '&filter_salesrep_id=' . $this->request->get['filter_salesrep_id'];
		}
		
		if (isset($this->request->get['filter_appointment_from'])) {
			$url .= '&filter_appointment_from=' . $this->request->get['filter_appointment_from'];
		}
		if (isset($this->request->get['filter_appointment_to'])) {
			$url .= '&filter_appointment_to=' . $this->request->get['filter_appointment_to'];
		}
		
		if (isset($this->request->get['filter_type'])) {
			$url .= '&filter_type=' . $this->request->get['filter_type'];
		}
		
		if (isset($this->request->get['type'])) {
			$url .= '&type=' . $this->request->get['type'];
		}
		
		if (isset($this->request->get['customer_id'])) {
			$url .= '&customer_id=' . $this->request->get['customer_id'];
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
			'href' => $this->url->link('replogic/schedule_management', 'token=' . $this->session->data['token'] . $url, true)
		);
		if (!isset($this->request->get['appointment_id'])) {
			$data['action'] = $this->url->link('replogic/schedule_management/add', 'token=' . $this->session->data['token'] . $url, true);
		} else {
			$data['action'] = $this->url->link('replogic/schedule_management/edit', 'token=' . $this->session->data['token'] . '&appointment_id=' . $this->request->get['appointment_id'] . $url, true);
		}
		if(isset($this->request->get['type']))
		{
			$data['cancel'] = $this->url->link('customer/customer_info/appointmentView', 'appointment_id='.$this->request->get['appointment_id'].'&type='.$this->request->get['type'].'&customer_id='.$this->request->get['customer_id'].'&token=' . $this->session->data['token'], true);
		}
		else
		{
			if(isset($this->request->get['appointment_id'])){
				$data['cancel'] = $this->url->link('replogic/schedule_management/view', 'appointment_id='.$this->request->get['appointment_id'].'&token=' . $this->session->data['token'] . $url, true);
			} else {
				$data['cancel'] = $this->url->link('replogic/schedule_management', 'token=' . $this->session->data['token'] . $url, true);
			}
		}
		if (isset($this->request->get['appointment_id']) && $this->request->server['REQUEST_METHOD'] != 'POST') {
			$appointment_info = $this->model_replogic_schedule_management->getappointment($this->request->get['appointment_id']);
			
		}
		if (isset($this->request->post['appointment_name'])) {
			$data['appointment_name'] = $this->request->post['appointment_name'];
		} elseif (!empty($appointment_info)) {
			 $data['appointment_name'] = $appointment_info['appointment_name']; 
		} else {
			$data['appointment_name'] = '';
		}
		
		if (isset($this->request->post['appointment_date'])) {
			$data['appointment_date'] = $this->request->post['appointment_date'];
		} elseif (!empty($appointment_info)) {
			$time = strtotime($appointment_info['appointment_date']);
			$myFormatForView = date("d-m-Y g:i A", $time); 
			$data['appointment_date'] = $myFormatForView;
		} else {
			$data['appointment_date'] = '';
		}
		
		if (isset($this->request->post['salesrep_id'])) {
			$data['salesrep_id'] = $this->request->post['salesrep_id'];
		} elseif (!empty($appointment_info)) {
			$data['salesrep_id'] = $appointment_info['salesrep_id'];
		} else {
			$data['salesrep_id'] = '';
		}
		
		if (isset($this->request->post['type'])) {
			$data['type'] = $this->request->post['type'];
		} elseif (!empty($appointment_info)) {
			$data['type'] = $appointment_info['type'];
		} else {
			$data['type'] = '';
		}

		/*******************************************
		 * Available and booked times
		 *******************************************/
		
		$data['booked_times']    = array();
		$data['available_times'] = array("08:00","09:00","10:00","11:00","12:00","13:00","14:00","15:00","16:00","17:00");

		// today's full date
		if (!empty($appointment_info)) {
			$data['booked_times'][]   = date('H:i', strtotime($data['appointment_date']));
			$data['appointment_date'] = date('l, d F Y', strtotime($data['appointment_date']));
		} else {
			$data['appointment_date'] = date('l, d F Y');
		}

		// page url
		$data['redirect_url'] = $this->url->link('replogic/schedule_management', 'token=' . $this->session->data['token'] . $url, true);
		
		$prospect_info = array();
		if($data['type'] === 'New Business')
		{
			$prospect_info = $this->model_replogic_schedule_management->getprospective($appointment_info['customer_id']);
		}
		
		if (isset($this->request->post['bcustomer_name'])) {
			$data['bcustomer_name'] = $this->request->post['bcustomer_name'];
		} elseif (!empty($prospect_info)) {
			$data['bcustomer_name'] = $prospect_info['name'];
		} else {
			$data['bcustomer_name'] = '';
		}
		
		if (isset($this->request->post['address'])) {
			$data['address'] = $this->request->post['address'];
		} elseif (!empty($prospect_info)) {
			$data['address'] = $prospect_info['address'];
		} else {
			$data['address'] = '';
		}
		
		if (isset($this->request->post['appointment_address'])) {
			$data['appointment_address'] = $this->request->post['appointment_address'];
		} elseif (!empty($appointment_info)) {
			$data['appointment_address'] = $appointment_info['appointment_address'];
		} else {
			$data['appointment_address'] = '';
		}
		
		if (isset($this->request->post['customer_id'])) {
			$data['customer_id'] = $this->request->post['customer_id'];
		} elseif (!empty($appointment_info)) {
			$data['customer_id'] = $appointment_info['customer_id'];
		} else {
			$data['customer_id'] = '';
		}
		
		if (isset($this->request->post['hour'])) {
			$data['hour'] = $this->request->post['hour'];
		} elseif (!empty($appointment_info)) {
			 $data['hour'] = $appointment_info['duration_hours']; 
		} else {
			$data['hour'] = '';
		}
		
		if (isset($this->request->post['minutes'])) {
			$data['minutes'] = $this->request->post['minutes'];
		} elseif (!empty($appointment_info)) {
			 $data['minutes'] = $appointment_info['duration_minutes']; 
		} else {
			$data['minutes'] = '';
		}
		
		if (isset($this->request->post['appointment_description'])) {
			$data['appointment_description'] = $this->request->post['appointment_description'];
		} elseif (!empty($appointment_info)) {
			$data['appointment_description'] = $appointment_info['appointment_description'];
		} else {
			$data['appointment_description'] = '';
		}
		
		$this->load->model('user/user_group');
		$this->load->model('user/user');
		$user_group_id = $this->model_user_user_group->getUserGroupByName('Sales Manager');
		$data['users'] = $this->model_user_user->getUsersByGroupId($user_group_id['user_group_id']); ;
	   
	   //print_r($data['users']); exit;
	   
	    $current_user = $this->session->data['user_id'];
		$current_user_group_id = $this->model_user_user->getUser($current_user); ;
		$current_user_group = $this->model_user_user_group->getUserGroup($current_user_group_id['user_group_id']); ;
		//print_r($current_user_group); exit;
		if($current_user_group['name'] == 'Company admin' || $current_user_group['name'] == 'Administrator')
		{
			$allaccess = true;
			$current_user_id = 0;
		}
		else
		{ 
			$allaccess = false;
			$current_user_id = $this->session->data['user_id'];
			
		}
	   
	   $this->load->model('replogic/sales_rep_management');
	   $data['salesReps'] = $this->model_replogic_sales_rep_management->getSalesRepsDropdown($allaccess, $current_user_id);
	   
	   $this->load->model('customer/customer');
	   
	   if (isset($this->request->post['salesrep_id'])) {
			$data['sales_manager'] = $this->request->post['salesrep_id'];
		} elseif (!empty($appointment_info)) {
			$data['sales_manager'] = $appointment_info['salesrep_id'];
		} else {
			$data['sales_manager'] = '';
		}
		
		if($data['sales_manager'])
		{
			if($current_user_group_id['user_group_id'] == '16' )
			{ 
				$allaccess = true;
				$current_user_id = $this->session->data['user_id'];
			}
			else
			{
				$allaccess = false;
				$current_user_id = 0;
			}
			$filter_customerdata = array('filter_salesrep_id' => $data['sales_manager']);
	   		$data['customers'] = $this->model_customer_customer->getCustomers($filter_customerdata,$allaccess,$current_user_id);
			
		}
		else
		{
			$data['customers'] = '';
		}
		$ignore = array(
			getDashboard($this->user),
			'common/startup',
			'common/login',
			'common/logout',
			'common/forgotten',
			'common/reset',			
			'common/footer',
			'common/header',
			'error/not_found',
			'error/permission'
		);
		
		$data['header'] = $this->load->controller('common/header');
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['footer'] = $this->load->controller('common/footer');
		$this->response->setOutput($this->load->view('replogic/schedule_management_form', $data));
	}
	
	public function view() {
	
		$this->load->language('replogic/schedule_management');
		$this->document->setTitle($this->language->get('heading_title'));
		$this->load->model('replogic/schedule_management');
	
		$data['heading_title'] = $this->language->get('heading_title');
		
		$data['text_form'] = !isset($this->request->get['appointment_id']) ? $this->language->get('text_add') : $this->language->get('text_edit');
		$data['text_select_all'] = $this->language->get('text_select_all');
		$data['text_unselect_all'] = $this->language->get('text_unselect_all');
		$data['entry_name'] = $this->language->get('entry_name');
		$data['entry_appointment_description'] = $this->language->get('entry_appointment_description');
		$data['entry_appointment_date'] = $this->language->get('entry_appointment_date');
		$data['entry_customer'] = $this->language->get('entry_customer');
		$data['entry_duration'] = $this->language->get('entry_duration');
		
		$data['entry_sales'] = $this->language->get('entry_sales');
		$data['entry_access'] = $this->language->get('entry_access');
		$data['entry_modify'] = $this->language->get('entry_modify');
		$data['button_save'] = $this->language->get('button_save');
		$data['button_cancel'] = $this->language->get('button_cancel');
		$data['token'] = $this->session->data['token'];
		if (isset($this->error['warning'])) {
			$data['error_warning'] = $this->error['warning'];
		} else {
			$data['error_warning'] = '';
		}
		if (isset($this->error['appointment_name'])) {
			$data['error_appointment_name'] = $this->error['appointment_name'];
		} else {
			$data['error_appointment_name'] = '';
		}
		
		if (isset($this->error['appointment_description'])) {
			$data['error_appointment_description'] = $this->error['appointment_description'];
		} else {
			$data['error_appointment_description'] = '';
		}
		
		if (isset($this->error['appointment_date'])) {
			$data['error_appointment_date'] = $this->error['appointment_date'];
		} else {
			$data['error_appointment_date'] = '';
		}
		
		if (isset($this->error['salesrep_id'])) {
			$data['error_salesrep_id'] = $this->error['salesrep_id'];
		} else {
			$data['error_salesrep_id'] = '';
		}
		
		if (isset($this->error['type'])) {
			$data['error_type'] = $this->error['type'];
		} else {
			$data['error_type'] = '';
		}
		
		if (isset($this->error['bcustomer_name'])) {
			$data['error_bcustomer_name'] = $this->error['bcustomer_name'];
		} else {
			$data['error_bcustomer_name'] = '';
		}
		
		if (isset($this->error['address'])) {
			$data['error_address'] = $this->error['address'];
		} else {
			$data['error_address'] = '';
		}
		
		if (isset($this->error['appointment_address'])) {
			$data['error_appointment_address'] = $this->error['appointment_address'];
		} else {
			$data['error_appointment_address'] = '';
		}
		
		if (isset($this->error['customer_id'])) {
			$data['error_customer_id'] = $this->error['customer_id'];
		} else {
			$data['error_customer_id'] = '';
		}
		
		if (isset($this->error['hour'])) {
			$data['error_hour'] = $this->error['hour'];
		} else {
			$data['error_hour'] = '';
		}
		
		if (isset($this->error['minutes'])) {
			$data['error_minutes'] = $this->error['minutes'];
		} else {
			$data['error_minutes'] = '';
		}
		$url = '';
		if (isset($this->request->get['filter_appointment_name'])) {
			$url .= '&filter_appointment_name=' . urlencode(html_entity_decode($this->request->get['filter_appointment_name'], ENT_QUOTES, 'UTF-8'));
		}
		if (isset($this->request->get['filter_customer_id'])) {
			$url .= '&filter_customer_id=' . $this->request->get['filter_customer_id'];
		}
		
		if (isset($this->request->get['filter_salesrep_id'])) {
			$url .= '&filter_salesrep_id=' . $this->request->get['filter_salesrep_id'];
		}
		
		if (isset($this->request->get['filter_appointment_from'])) {
			$url .= '&filter_appointment_from=' . $this->request->get['filter_appointment_from'];
		}
		if (isset($this->request->get['filter_appointment_to'])) {
			$url .= '&filter_appointment_to=' . $this->request->get['filter_appointment_to'];
		}
		
		if (isset($this->request->get['filter_type'])) {
			$url .= '&filter_type=' . $this->request->get['filter_type'];
		}
		
		if (isset($this->request->get['type'])) {
			$url .= '&type=' . $this->request->get['type'];
		}
		
		if (isset($this->request->get['customer_id'])) {
			$url .= '&customer_id=' . $this->request->get['customer_id'];
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
			'href' => $this->url->link('replogic/schedule_management', 'token=' . $this->session->data['token'] . $url, true)
		);
		
		$data['editurl'] = $this->url->link('replogic/schedule_management/edit', 'token=' . $this->session->data['token'] . '&appointment_id=' . $this->request->get['appointment_id'] . $url, true);
		
		if(isset($this->request->get['type']))
		{
			$data['cancel'] = $this->url->link('customer/customer_info/appointmentView', 'appointment_id='.$this->request->get['appointment_id'].'&type='.$this->request->get['type'].'&customer_id='.$this->request->get['customer_id'].'&token=' . $this->session->data['token'], true);
		}
		else
		{
			$data['cancel'] = $this->url->link('replogic/schedule_management', 'token=' . $this->session->data['token'] . $url, true);
		}
		if (isset($this->request->get['appointment_id']) && $this->request->server['REQUEST_METHOD'] != 'POST') {
			$appointment_info = $this->model_replogic_schedule_management->getappointment($this->request->get['appointment_id']);
			
		}
		if (isset($this->request->post['appointment_name'])) {
			$data['appointment_name'] = $this->request->post['appointment_name'];
		} elseif (!empty($appointment_info)) {
			 $data['appointment_name'] = $appointment_info['appointment_name']; 
		} else {
			$data['appointment_name'] = '';
		}
		
		if (isset($this->request->post['appointment_date'])) {
			$data['appointment_date'] = $this->request->post['appointment_date'];
		} elseif (!empty($appointment_info)) {
			$time = strtotime($appointment_info['appointment_date']);
			$myFormatForView = date("d-m-Y g:i A", $time); 
			$data['appointment_date'] = $myFormatForView;
		} else {
			$data['appointment_date'] = '';
		}
		
		if (isset($this->request->post['salesrep_id'])) {
			$data['salesrep_id'] = $this->request->post['salesrep_id'];
		} elseif (!empty($appointment_info)) {
			$data['salesrep_id'] = $appointment_info['salesrep_id'];
		} else {
			$data['salesrep_id'] = '';
		}
		
		if (isset($this->request->post['type'])) {
			$data['type'] = $this->request->post['type'];
		} elseif (!empty($appointment_info)) {
			$data['type'] = $appointment_info['type'];
		} else {
			$data['type'] = '';
		}
		
		$prospect_info = array();
		if($data['type'] === 'New Business')
		{
			$prospect_info = $this->model_replogic_schedule_management->getprospective($appointment_info['customer_id']);
		}
		
		if (isset($this->request->post['bcustomer_name'])) {
			$data['bcustomer_name'] = $this->request->post['bcustomer_name'];
		} elseif (!empty($prospect_info)) {
			$data['bcustomer_name'] = $prospect_info['name'];
		} else {
			$data['bcustomer_name'] = '';
		}
		
		if (isset($this->request->post['address'])) {
			$data['address'] = $this->request->post['address'];
		} elseif (!empty($prospect_info)) {
			$data['address'] = $prospect_info['address'];
		} else {
			$data['address'] = '';
		}
		
		if (isset($this->request->post['appointment_address'])) {
			$data['appointment_address'] = $this->request->post['appointment_address'];
		} elseif (!empty($appointment_info)) {
			$data['appointment_address'] = $appointment_info['appointment_address'];
		} else {
			$data['appointment_address'] = '';
		}
		
		if (isset($this->request->post['customer_id'])) {
			$data['customer_id'] = $this->request->post['customer_id'];
		} elseif (!empty($appointment_info)) {
			$data['customer_id'] = $appointment_info['customer_id'];
		} else {
			$data['customer_id'] = '';
		}
		
		if (isset($this->request->post['hour'])) {
			$data['hour'] = $this->request->post['hour'];
		} elseif (!empty($appointment_info)) {
			 $data['hour'] = $appointment_info['duration_hours']; 
		} else {
			$data['hour'] = '';
		}
		
		if (isset($this->request->post['minutes'])) {
			$data['minutes'] = $this->request->post['minutes'];
		} elseif (!empty($appointment_info)) {
			 $data['minutes'] = $appointment_info['duration_minutes']; 
		} else {
			$data['minutes'] = '';
		}
		
		if (isset($this->request->post['appointment_description'])) {
			$data['appointment_description'] = $this->request->post['appointment_description'];
		} elseif (!empty($appointment_info)) {
			$data['appointment_description'] = $appointment_info['appointment_description'];
		} else {
			$data['appointment_description'] = '';
		}
		
		$this->load->model('user/user_group');
		$this->load->model('user/user');
		$user_group_id = $this->model_user_user_group->getUserGroupByName('Sales Manager');
		$data['users'] = $this->model_user_user->getUsersByGroupId($user_group_id['user_group_id']); ;
	   
	   //print_r($data['users']); exit;
	   
	    $current_user = $this->session->data['user_id'];
		$current_user_group_id = $this->model_user_user->getUser($current_user); ;
		$current_user_group = $this->model_user_user_group->getUserGroup($current_user_group_id['user_group_id']); ;
		//print_r($current_user_group); exit;
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
	   
	   $this->load->model('replogic/sales_rep_management');
	   $data['salesReps'] = $this->model_replogic_sales_rep_management->getSalesRepsDropdown($allaccess, $current_user_id);
	   
	   $this->load->model('customer/customer');
	   
	   if (isset($this->request->post['salesrep_id'])) {
			$data['sales_manager'] = $this->request->post['salesrep_id'];
		} elseif (!empty($appointment_info)) {
			$data['sales_manager'] = $appointment_info['salesrep_id'];
		} else {
			$data['sales_manager'] = '';
		}
		
		if($data['sales_manager'])
		{
			if($current_user_group_id['user_group_id'] == '16' )
			{ 
				$allaccess = true;
				$current_user_id = $this->session->data['user_id'];
			}
			else
			{
				$allaccess = false;
				$current_user_id = 0;
			}
			$filter_customerdata = array('filter_salesrep_id' => $data['sales_manager']);
	   		$data['customers'] = $this->model_customer_customer->getCustomers($filter_customerdata,$allaccess,$current_user_id);
			
		}
		else
		{
			$data['customers'] = '';
		}
		$ignore = array(
			getDashboard($this->user),
			'common/startup',
			'common/login',
			'common/logout',
			'common/forgotten',
			'common/reset',			
			'common/footer',
			'common/header',
			'error/not_found',
			'error/permission'
		);
		
		$data['header'] = $this->load->controller('common/header');
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['footer'] = $this->load->controller('common/footer');
		$this->response->setOutput($this->load->view('replogic/schedule_management_view', $data));
	}
	protected function validateForm() {
		if (!$this->user->hasPermission('modify', 'replogic/schedule_management')) {
			$this->error['warning'] = $this->language->get('error_schedule_management');
		}
		if ((utf8_strlen($this->request->post['appointment_name']) < 3) || (utf8_strlen($this->request->post['appointment_name']) > 64)) {
			$this->error['appointment_name'] = $this->language->get('error_appointment_name');
		}
		
		/*if ((utf8_strlen($this->request->post['appointment_description']) < 3) || (utf8_strlen($this->request->post['appointment_description']) > 64)) {
			$this->error['appointment_description'] = $this->language->get('error_appointment_description');
		}*/
		
		if ((utf8_strlen($this->request->post['appointment_date']) < 3) || (utf8_strlen($this->request->post['appointment_date']) > 64)) {
			$this->error['appointment_date'] = $this->language->get('error_appointment_date');
		}
		
		if ($this->request->post['hour'] == '') {
			$this->error['hour'] = $this->language->get('error_hour');
		}
		
		if ($this->request->post['minutes'] == '') {
			$this->error['minutes'] = $this->language->get('error_minutes');
		}
		
		if ($this->request->post['salesrep_id'] == '') {
			$this->error['salesrep_id'] = $this->language->get('error_salesrep_id');
		}
		
		if ($this->request->post['type'] == '') {
			$this->error['type'] = $this->language->get('error_type');
		}
		else if($this->request->post['type'] == 'New Business')
		{
			if ($this->request->post['bcustomer_name'] == '') 
			{
				$this->error['bcustomer_name'] = $this->language->get('error_bcustomer_name');
			}
			if ($this->request->post['address'] == '') 
			{
				$this->error['address'] = $this->language->get('error_address');
			}
		}
		else if($this->request->post['type'] == 'Existing Business')
		{
			if ($this->request->post['customer_id'] == '') 
			{
				$this->error['customer_id'] = $this->language->get('error_customer_id');
			}
			
			if ($this->request->post['appointment_address'] == '') 
			{
				$this->error['appointment_address'] = $this->language->get('error_appointment_address');
			}
			
		}
		
		return !$this->error;
	}
	
	public function getaddress() {
		
		$this->load->model('customer/customer');
		$customer_id = $this->request->post['customer_id'];
		if($customer_id)
		{
			$cust = $this->model_customer_customer->getCustomerAddressDefault($customer_id);
			$address = $cust['address']; 
		}
		else
		{
			$address = '';
		}
		
		$this->response->addHeader('Content-Type: application/json');
		$this->response->setOutput(json_encode($address));
	}
	
	public function getCustomer() {
		
		$this->load->model('customer/customer');
		$salesrep_id = $this->request->post['salesrep_id'];
		
		if($current_user_group['name'] == 'Sales Manager' )
		{ 
			$allaccess = true;
			$current_user_id = $this->session->data['user_id'];
		}
		else
		{
			$allaccess = false;
			$current_user_id = 0;
		}
		
		$filter_data = array('filter_salesrep_id' => $salesrep_id);
		
		$customer = $this->model_customer_customer->getCustomers($filter_data,$allaccess,$current_user_id);
		
		$this->response->addHeader('Content-Type: application/json');
		$this->response->setOutput(json_encode($customer));
	}	

	public function scheduleAppointment() {

		$this->load->model('replogic/schedule_management');
		$this->load->language('replogic/schedule_management');

		$json = array();

		if (!$this->user->hasPermission('modify', 'replogic/schedule_management')) {

			/*******************************************
			 * If user does not have modify permissions
			 *******************************************/

			$json['success'] = true;
			$json['error']   = $this->language->get('error_schedule_management');

		} elseif ($this->request->server['REQUEST_METHOD'] == 'POST') {

			$bookedTimes = array();
			$results     = $this->model_replogic_schedule_management->getSalesRepAppointmentTimesByDate($this->request->post['salesrep_id'], date('Y-m-d', strtotime($this->request->post['appointment_date'])));

			if (!empty($results)) {
				foreach($results as $value) {
					$bookedTimes[] = $value['appointment_time'];
				}
			}

			if (in_array(date('H', strtotime($this->request->post['appointment_time'])), $bookedTimes)) {

				/*******************************************
				 * If scheduled date/time is already booked
				 *******************************************/

				$json['success'] = false;
				$json['error']   = $this->language->get('error_time_already_booked');

			} else {

				/*******************************************
				 * Schedule Appointment
				 *******************************************/

				$data         = $this->request->post;
				$data['type'] = $this->request->post['appointment_type'];

				/*******************************************
				 * This is used to determine appointment 
				 * duration in hours and minutes.
				 * -----------------------------------------
				 * We assume that:
				 * - A single day is equal to 12 hours
				 * - A single week is equal to 5 days
				 *******************************************/
				
				if ($this->request->post['appointment_duration_all_day']) {
					$data['hour']    = 12; // 12 [hours a day]
					$data['minutes'] = 0;
				} else {

					if (preg_match('/Day/', $this->request->post['appointment_duration'])) {
						$duration 		 = explode(" ", $this->request->post['appointment_duration']);
						$data['hour']    = intval($duration[0]) * 12; // (num of days) * 12 [hours a day]
						$data['minutes'] = 0;
					} elseif (preg_match('/Week/', $this->request->post['appointment_duration'])) {
						$duration 		 = explode(" ", $this->request->post['appointment_duration']);
						$data['hour']    = intval($duration[0]) * 5 * 12; // (num of weeks) * 5 [days a week] * 12 [hours a day]
						$data['minutes'] = 0;
					} else {
						$duration        = explode(":", $this->request->post['appointment_duration']);
						$data['hour']    = $duration[0];
						$data['minutes'] = $duration[1];
					}
				}
				// appointment date and time
				$date = $this->request->post['appointment_date'];
				$time = $this->request->post['appointment_time'];
				$data['appointment_date'] = date("Y-m-d H:i:s", strtotime("$date $time"));

				// save appointment to database using model
				$appointmentId = $this->model_replogic_schedule_management->addScheduleManagement($data);
				if (!empty($appointmentId) && is_numeric($appointmentId)) {
					$json['success']        = true;
					$json['message']        = $this->language->get('text_appointment_add_success');
					$json['appointment_id'] = $appointmentId;
				} else {
					$json['success']        = false;
					$json['error']          = $this->language->get('error_appointment_add_generic');
				}
			}
		}

		$this->response->addHeader('Content-Type: application/json');
		$this->response->setOutput(json_encode($json));
	}

	public function getSalesRepAppointmentTimesByDate() {
		$json = array();
		$this->load->model('replogic/schedule_management');

		if (!empty($this->request->get['salesrep_id']) && !empty($this->request->get['date'])) {
			$date  = date('Y-m-d', strtotime($this->request->get['date']));
			$times = $this->model_replogic_schedule_management->getSalesRepAppointmentTimesByDate($this->request->get['salesrep_id'], $date);
			$json['booked_times'] = array();
			$json['date'] = $date;
			if (!empty($times)) {
				foreach($times as $time) {
					$json['booked_times'][] = $time['appointment_time'];
				}
			}
		}
		$this->response->addHeader('Content-Type: application/json');
		$this->response->setOutput(json_encode($json));
	}
}