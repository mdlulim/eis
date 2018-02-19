<?php
class ControllerReplogicSalesrepInfo extends Controller {
	private $error = array();

	public function index() { 
		$this->load->language('replogic/salesrep_info');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('replogic/sales_rep_management');
		
		if($this->request->get['type'] == 'quotes')
		{
			$this->getQuotesTab();
		}
		else if($this->request->get['type'] == 'appointment')
		{
			$this->getAppointmentTab();
		}
		else if($this->request->get['type'] == 'customers')
		{
			$this->getCustomersTab();
		}
		else if($this->request->get['type'] == 'visits')
		{
			$this->getVisitsTab();
		}
		else if($this->request->get['type'] == 'orders')
		{
			$this->getOrdersTab();
		}
		else if($this->request->get['type'] == 'general')
		{
			$this->getGeneralTab();
		}
	}

	protected function getGeneralTab() {
		
		$url = '';

		if (isset($this->request->get['team_id'])) {
			$url .= '&team_id=' . $this->request->get['team_id'];
		}
		
		if (isset($this->request->get['filter_team_id'])) {
			$url .= '&filter_team_id=' . $this->request->get['filter_team_id'];
		}
		
		if (isset($this->request->get['filter_customer_id'])) {
			$url .= '&filter_customer_id=' . $this->request->get['filter_customer_id'];
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
		
		$salesrep_id = $this->request->get['salesrep_id'];
		$salesrepdetails = $this->model_replogic_sales_rep_management->getsalesrep($salesrep_id);
		$data['salesrepname'] = $salesrepdetails['salesrep_name'] ." ". $salesrepdetails['salesrep_lastname'];
		
		$data['breadcrumbs'] = array();

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('text_home'),
			'href' => $this->url->link('common/dashboard', 'token=' . $this->session->data['token'], true)
		);

		$data['breadcrumbs'][] = array(
			'text' => 'Sales Rep Management',
			'href' => $this->url->link('replogic/sales_rep_management', 'token=' . $this->session->data['token'] . $url, true)
		);
		
		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('breadcrum_title'),
			'href' => $this->url->link('replogic/salesrep_info', 'salesrep_id=' . $salesrep_id .'&token=' . $this->session->data['token'] . $url, true)
		);

		
		$data['cancel'] = $this->url->link('replogic/sales_rep_management', 'token=' . $this->session->data['token'] . $url, true);
		
		$data['generaltab'] = $this->url->link('replogic/salesrep_info', 'type=general&salesrep_id=' . $salesrep_id .'&token=' . $this->session->data['token'], true);
		$data['appointmenttab'] = $this->url->link('replogic/salesrep_info', 'type=appointment&salesrep_id=' . $salesrep_id .'&token=' . $this->session->data['token'], true);
		$data['customerstab'] = $this->url->link('replogic/salesrep_info', 'type=customers&salesrep_id=' . $salesrep_id .'&token=' . $this->session->data['token'], true);
		$data['visitstab'] = $this->url->link('replogic/salesrep_info', 'type=visits&salesrep_id=' . $salesrep_id .'&token=' . $this->session->data['token'], true);
		$data['orderstab'] = $this->url->link('replogic/salesrep_info', 'type=orders&salesrep_id=' . $salesrep_id .'&token=' . $this->session->data['token'], true);
		$data['quotestab'] = $this->url->link('replogic/salesrep_info', 'type=quotes&salesrep_id=' . $salesrep_id .'&token=' . $this->session->data['token'], true);
		
		
		$this->load->model('user/team');
		
		$data['salesrepinfo'] = $this->model_replogic_sales_rep_management->getsalesrep($salesrep_id);

		$team = $this->model_user_team->getTeam($data['salesrepinfo']['sales_team_id']); 
		$data['teamname'] = $team['team_name'];
		
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
		
		if (isset($this->request->get['filter_sales_rep_name'])) {
			$url .= '&filter_sales_rep_name=' . urlencode(html_entity_decode($this->request->get['filter_sales_rep_name'], ENT_QUOTES, 'UTF-8'));
		}

		if (isset($this->request->get['team_id'])) {
			$url .= '&team_id=' . $this->request->get['team_id'];
		}
		
		if (isset($this->request->get['filter_team_id'])) {
			$url .= '&filter_team_id=' . $this->request->get['filter_team_id'];
		}
		
		if (isset($this->request->get['filter_customer_id'])) {
			$url .= '&filter_customer_id=' . $this->request->get['filter_customer_id'];
		}
		
		if (isset($this->request->get['filter_email'])) {
			$url .= '&filter_email=' . $this->request->get['filter_email'];
		}
		
		if ($order == 'ASC') {
			$url .= '&order=DESC';
		} else {
			$url .= '&order=ASC';
		}

		if (isset($this->request->get['page'])) {
			$url .= '&page=' . $this->request->get['page'];
		}

		$data['sort_name'] = $this->url->link('replogic/sales_rep_management', 'token=' . $this->session->data['token'] . '&sort=name' . $url, true);

		$url = '';
		
		if (isset($this->request->get['filter_sales_rep_name'])) {
			$url .= '&filter_sales_rep_name=' . urlencode(html_entity_decode($this->request->get['filter_sales_rep_name'], ENT_QUOTES, 'UTF-8'));
		}

		if (isset($this->request->get['team_id'])) {
			$url .= '&team_id=' . $this->request->get['team_id'];
		}
		
		if (isset($this->request->get['filter_team_id'])) {
			$url .= '&filter_team_id=' . $this->request->get['filter_team_id'];
		}
		
		if (isset($this->request->get['filter_customer_id'])) {
			$url .= '&filter_customer_id=' . $this->request->get['filter_customer_id'];
		}
		
		if (isset($this->request->get['filter_email'])) {
			$url .= '&filter_email=' . $this->request->get['filter_email'];
		}
		
		if (isset($this->request->get['sort'])) {
			$url .= '&sort=' . $this->request->get['sort'];
		}

		if (isset($this->request->get['order'])) {
			$url .= '&order=' . $this->request->get['order'];
		}

		$data['header'] = $this->load->controller('common/header');
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['footer'] = $this->load->controller('common/footer');

		$this->response->setOutput($this->load->view('replogic/salesrep_info', $data));
	}
	
	protected function getAppointmentTab() {
		
		$this->load->model('replogic/schedule_management');
		$this->load->model('customer/customer');
		
		$salesrepdetails = $this->model_replogic_sales_rep_management->getsalesrep($salesrep_id);
		$data['salesrepname'] = $salesrepdetails['salesrep_name'] . $salesrepdetails['salesrep_lastname'];
		
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
			$order = 'ASC';
		}

		if (isset($this->request->get['page'])) {
			$page = $this->request->get['page'];
		} else {
			$page = 1;
		}

		$url = '';

		if (isset($this->request->get['type'])) {
			$url .= '&type=' . $this->request->get['type'];
		}
		
		if (isset($this->request->get['salesrep_id'])) {
			$url .= '&salesrep_id=' . $this->request->get['salesrep_id'];
		}
		
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
		
		if (isset($this->request->get['sort'])) {
			$url .= '&sort=' . $this->request->get['sort'];
		}

		if (isset($this->request->get['order'])) {
			$url .= '&order=' . $this->request->get['order'];
		}

		if (isset($this->request->get['page'])) {
			$url .= '&page=' . $this->request->get['page'];
		}
		
		$salesrep_id = $this->request->get['salesrep_id'];
		$data['salesrep_id'] = $salesrep_id;
		$salesrepdetails = $this->model_replogic_sales_rep_management->getsalesrep($salesrep_id);
		$data['salesrepname'] = $salesrepdetails['salesrep_name'] ." ". $salesrepdetails['salesrep_lastname'];
		
		$data['breadcrumbs'] = array();

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('text_home'),
			'href' => $this->url->link('common/dashboard', 'token=' . $this->session->data['token'], true)
		);
		
		$data['breadcrumbs'][] = array(
			'text' => 'Sales Rep Management',
			'href' => $this->url->link('replogic/sales_rep_management', 'token=' . $this->session->data['token'] . $url, true)
		);

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('breadcrum_title'),
			'href' => $this->url->link('replogic/salesrep_info', 'token=' . $this->session->data['token'] . $url, true)
		);

		$data['cancel'] = $this->url->link('replogic/sales_rep_management', 'token=' . $this->session->data['token'], true);
		
		$data['generaltab'] = $this->url->link('replogic/salesrep_info', 'type=general&salesrep_id=' . $salesrep_id .'&token=' . $this->session->data['token'], true);
		$data['appointmenttab'] = $this->url->link('replogic/salesrep_info', 'type=appointment&salesrep_id=' . $salesrep_id .'&token=' . $this->session->data['token'], true);
		$data['customerstab'] = $this->url->link('replogic/salesrep_info', 'type=customers&salesrep_id=' . $salesrep_id .'&token=' . $this->session->data['token'], true);
		$data['visitstab'] = $this->url->link('replogic/salesrep_info', 'type=visits&salesrep_id=' . $salesrep_id .'&token=' . $this->session->data['token'], true);
		$data['orderstab'] = $this->url->link('replogic/salesrep_info', 'type=orders&salesrep_id=' . $salesrep_id .'&token=' . $this->session->data['token'], true);
		$data['quotestab'] = $this->url->link('replogic/salesrep_info', 'type=quotes&salesrep_id=' . $salesrep_id .'&token=' . $this->session->data['token'], true);

		$data['schedule_managements'] = array();

		$filter_data = array(
			'filter_appointment_name'	  => $filter_appointment_name,
			'filter_customer_id'  => $filter_customer_id,
			'filter_appointment_from'	  => $filter_appointment_from,
			'filter_appointment_to'	  => $filter_appointment_to,
			'filter_salesrep_id' => $salesrep_id,
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
		if($current_user_group['name'] == 'Company admin' || $current_user_group['name'] == 'Administrator')
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
			
		$salesrep = $this->model_replogic_sales_rep_management->getsalesrep($result['salesrep_id']); ;
		$sales_rep = $salesrep['salesrep_name'] ." ". $salesrep['salesrep_lastname'];
		
		$customerdetail = $this->model_customer_customer->getCustomer($result['customer_id']); ;
		$customername = $customerdetail['firstname'];
		
		$time = strtotime($result['appointment_date']);
		$myFormatForView = date("d-m-Y g:i A", $time); 
			
		$data['schedule_managements'][] = array(
				'appointment_id' => $result['appointment_id'],
				'appointment_name'          => $result['appointment_name'],
				'sales_manager'          => $sales_rep,
				'customername'          => $customername,
				'appointment_date'          => $myFormatForView,
				'tasks'          => $this->url->link('replogic/tasks', 'token=' . $this->session->data['token'] . '&appointment_id=' . $result['appointment_id'] . $url, true),
				'view'          => $this->url->link('replogic/salesrep_info/appointmentView', 'token=' . $this->session->data['token'] . '&appointment_id=' . $result['appointment_id'] . $url, true)
			);
		}
		
		$this->load->model('user/user_group');
		$this->load->model('user/user');
		$this->load->model('customer/customer');
		$user_group_id = $this->model_user_user_group->getUserGroupByName('Sales Manager');
		$data['sales_managers'] = $this->model_user_user->getUsersByGroupId($user_group_id['user_group_id']);
		
		$data['customers'] = $this->model_customer_customer->getCustomers();
		
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
		
		if (isset($this->request->get['type'])) {
			$url .= '&type=' . $this->request->get['type'];
		}
		
		if (isset($this->request->get['salesrep_id'])) {
			$url .= '&salesrep_id=' . $this->request->get['salesrep_id'];
		}
		
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
		
		if ($order == 'ASC') {
			$url .= '&order=DESC';
		} else {
			$url .= '&order=ASC';
		}

		if (isset($this->request->get['page'])) {
			$url .= '&page=' . $this->request->get['page'];
		}

		$data['sort_name'] = $this->url->link('replogic/salesrep_info', 'token=' . $this->session->data['token'] . '&sort=name' . $url, true);

		$url = '';
		
		if (isset($this->request->get['type'])) {
			$url .= '&type=' . $this->request->get['type'];
		}
		
		if (isset($this->request->get['salesrep_id'])) {
			$url .= '&salesrep_id=' . $this->request->get['salesrep_id'];
		}
		
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
		$pagination->url = $this->url->link('replogic/salesrep_info', 'token=' . $this->session->data['token'] . $url . '&page={page}', true);

		$data['pagination'] = $pagination->render();

		$data['results'] = sprintf($this->language->get('text_pagination'), ($schedule_management_total) ? (($page - 1) * $this->config->get('config_limit_admin')) + 1 : 0, ((($page - 1) * $this->config->get('config_limit_admin')) > ($schedule_management_total - $this->config->get('config_limit_admin'))) ? $schedule_management_total : ((($page - 1) * $this->config->get('config_limit_admin')) + $this->config->get('config_limit_admin')), $schedule_management_total, ceil($schedule_management_total / $this->config->get('config_limit_admin')));

		$data['filter_appointment_name'] = $filter_appointment_name;
		$data['filter_customer_id'] = $filter_customer_id;
		$data['filter_appointment_from'] = $filter_appointment_from;
		$data['filter_appointment_to'] = $filter_appointment_to;
		$data['filter_salesrep_id'] = $filter_salesrep_id;
		$data['sort'] = $sort;
		$data['order'] = $order;

		$data['header'] = $this->load->controller('common/header');
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['footer'] = $this->load->controller('common/footer');

		$this->response->setOutput($this->load->view('replogic/salesrep_info_appointment', $data));
	}
	
	public function appointmentView() {
		
		$this->load->language('replogic/schedule_management');
		$this->load->language('replogic/salesrep_info');
		$this->document->setTitle($this->language->get('heading_title'));
		$this->load->model('replogic/schedule_management');
		
		
		$data['heading_title'] = $this->language->get('heading_title');
		
		$data['text_form'] = 'View Appointment';
		$data['text_select_all'] = $this->language->get('text_select_all');
		$data['text_unselect_all'] = $this->language->get('text_unselect_all');

		$data['entry_name'] = $this->language->get('entry_name');
		$data['entry_appointment_description'] = $this->language->get('entry_appointment_description');
		$data['entry_appointment_date'] = $this->language->get('entry_appointment_date');
		$data['entry_customer'] = $this->language->get('entry_customer');
		
		$data['entry_sales'] = $this->language->get('entry_sales');
		$data['entry_access'] = $this->language->get('entry_access');
		$data['entry_modify'] = $this->language->get('entry_modify');

		$data['button_save'] = $this->language->get('button_save');
		$data['button_cancel'] = $this->language->get('button_cancel');

		if (isset($this->error['warning'])) {
			$data['error_warning'] = $this->error['warning'];
		} else {
			$data['error_warning'] = '';
		}

		$url = '';
		
		if (isset($this->request->get['type'])) {
			$url .= '&type=' . $this->request->get['type'];
		}
		
		if (isset($this->request->get['salesrep_id'])) {
			$url .= '&salesrep_id=' . $this->request->get['salesrep_id'];
		}
		
		if (isset($this->request->get['filter_appointment_name'])) {
			$url .= '&filter_appointment_name=' . urlencode(html_entity_decode($this->request->get['filter_appointment_name'], ENT_QUOTES, 'UTF-8'));
		}

		if (isset($this->request->get['filter_customer_id'])) {
			$url .= '&filter_customer_id=' . $this->request->get['filter_customer_id'];
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
			'href' => $this->url->link('common/dashboard', 'token=' . $this->session->data['token'], true)
		);
		
		$data['breadcrumbs'][] = array(
			'text' => 'Sales Rep Management',
			'href' => $this->url->link('replogic/sales_rep_management', 'token=' . $this->session->data['token'] . $url, true)
		);
		
		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('breadcrum_title'),
			'href' => $this->url->link('replogic/salesrep_info', 'token=' . $this->session->data['token'] . $url, true)
		);

		
		$data['action'] = $this->url->link('replogic/schedule_management/edit', 'token=' . $this->session->data['token'] . '&appointment_id=' . $this->request->get['appointment_id'] . $url, true);
		
		$data['cancel'] = $this->url->link('replogic/salesrep_info', 'token=' . $this->session->data['token'] . $url, true);

		$appointment_info = $this->model_replogic_schedule_management->getappointment($this->request->get['appointment_id']);
			
		$data['appointment_name'] = $appointment_info['appointment_name']; 
		
		$time = strtotime($appointment_info['appointment_date']);
		$myFormatForView = date("d-m-Y g:i A", $time); 
		$data['appointment_date'] = $myFormatForView;
		$data['salesrep_id'] = $appointment_info['salesrep_id'];
		$data['customer_id'] = $appointment_info['customer_id'];
		$data['hour'] = $appointment_info['duration_hours']; 
		$data['minutes'] = $appointment_info['duration_minutes']; 
		$data['appointment_description'] = $appointment_info['appointment_description'];
		
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
	   $data['customers'] = $this->model_customer_customer->getCustomers();
	
		$data['sales_manager'] = $appointment_info['salesrep_id'];
		
		

		$data['header'] = $this->load->controller('common/header');
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['footer'] = $this->load->controller('common/footer');

		$this->response->setOutput($this->load->view('replogic/salesrep_info_appointment_view', $data));
	}
	
	protected function getCustomersTab() {
		
		$this->load->language('customer/customer');
		$this->load->language('replogic/salesrep_info');
		$this->load->model('customer/customer');
		
		$salesrep_id = $this->request->get['salesrep_id'];
		$salesrepdetails = $this->model_replogic_sales_rep_management->getsalesrep($salesrep_id);
		$data['salesrepname'] = $salesrepdetails['salesrep_name'] ." ". $salesrepdetails['salesrep_lastname'];
		$data['salesrep_id'] = $salesrep_id;
		
		if (isset($this->request->get['filter_customer_id'])) {
			$filter_customer_id = $this->request->get['filter_customer_id'];
		} else {
			$filter_customer_id = null;
		}

		if (isset($this->request->get['filter_customer_group_id'])) {
			$filter_customer_group_id = $this->request->get['filter_customer_group_id'];
		} else {
			$filter_customer_group_id = null;
		}

		if (isset($this->request->get['filter_date_added'])) {
			$filter_date_added = $this->request->get['filter_date_added'];
		} else {
			$filter_date_added = null;
		}

		if (isset($this->request->get['sort'])) {
			$sort = $this->request->get['sort'];
		} else {
			$sort = 'name';
		}

		if (isset($this->request->get['order'])) {
			$order = $this->request->get['order'];
		} else {
			$order = 'ASC';
		}

		if (isset($this->request->get['page'])) {
			$page = $this->request->get['page'];
		} else {
			$page = 1;
		}

		$url = '';
		
		if (isset($this->request->get['type'])) {
			$url .= '&type=' . $this->request->get['type'];
		}
		
		if (isset($this->request->get['salesrep_id'])) {
			$url .= '&salesrep_id=' . $this->request->get['salesrep_id'];
		}
		
		if (isset($this->request->get['filter_customer_id'])) {
			$url .= '&filter_customer_id=' . $this->request->get['filter_customer_id'];
		}

		if (isset($this->request->get['filter_customer_group_id'])) {
			$url .= '&filter_customer_group_id=' . $this->request->get['filter_customer_group_id'];
		}

		if (isset($this->request->get['filter_date_added'])) {
			$url .= '&filter_date_added=' . $this->request->get['filter_date_added'];
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
			'text' => 'Sales Rep Management',
			'href' => $this->url->link('replogic/sales_rep_management', 'token=' . $this->session->data['token'] . $url, true)
		);

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('breadcrum_title'),
			'href' => $this->url->link('replogic/salesrep_info', 'token=' . $this->session->data['token'] . $url, true)
		);

		$data['add'] = $this->url->link('customer/customer/add', 'token=' . $this->session->data['token'] . '&type=customers&csalesrep_id='.$salesrep_id, true);
		$data['cancel'] = $this->url->link('replogic/sales_rep_management', 'token=' . $this->session->data['token'], true);
		
		$data['generaltab'] = $this->url->link('replogic/salesrep_info', 'type=general&salesrep_id=' . $salesrep_id .'&token=' . $this->session->data['token'], true);
		$data['appointmenttab'] = $this->url->link('replogic/salesrep_info', 'type=appointment&salesrep_id=' . $salesrep_id .'&token=' . $this->session->data['token'], true);
		$data['customerstab'] = $this->url->link('replogic/salesrep_info', 'type=customers&salesrep_id=' . $salesrep_id .'&token=' . $this->session->data['token'], true);
		$data['visitstab'] = $this->url->link('replogic/salesrep_info', 'type=visits&salesrep_id=' . $salesrep_id .'&token=' . $this->session->data['token'], true);
		$data['orderstab'] = $this->url->link('replogic/salesrep_info', 'type=orders&salesrep_id=' . $salesrep_id .'&token=' . $this->session->data['token'], true);
		$data['quotestab'] = $this->url->link('replogic/salesrep_info', 'type=quotes&salesrep_id=' . $salesrep_id .'&token=' . $this->session->data['token'], true);

		$data['customers'] = array();

		$filter_data = array(
			'filter_customer_id'              => $filter_customer_id,
			'filter_customer_group_id' => $filter_customer_group_id,
			'filter_date_added'        => $filter_date_added,
			'filter_salesrep_id'        => $salesrep_id,
			'sort'                     => $sort,
			'order'                    => $order,
			'start'                    => ($page - 1) * $this->config->get('config_limit_admin'),
			'limit'                    => $this->config->get('config_limit_admin')
		);
		
		$this->load->model('user/user');
		$this->load->model('user/user_group');
		
		$current_user = $this->session->data['user_id'];
		$current_user_group_id = $this->model_user_user->getUser($current_user);
		$current_user_group = $this->model_user_user_group->getUserGroup($current_user_group_id['user_group_id']); 
		//print_r($current_user_group); exit;
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
		
		$customer_total = $this->model_customer_customer->getTotalCustomers($filter_data,$allaccess,$current_user_id);

		$results = $this->model_customer_customer->getCustomers($filter_data,$allaccess,$current_user_id);

		foreach ($results as $result) {
			

			$data['customers'][] = array(
				'customer_id'    => $result['customer_id'],
				//'name'           => $result['name'],
				'name'           => $result['firstname'],
				'email'          => $result['email'],
				'customer_group' => $result['customer_group'],
				'status'         => ($result['status'] ? $this->language->get('text_enabled') : $this->language->get('text_disabled')),
				'ip'             => $result['ip'],
				'date_added'     => date($this->language->get('date_format_short'), strtotime($result['date_added'])),
				'view'          => $this->url->link('customer/customer_info', 'token=' . $this->session->data['token'] . '&type=general&csalesrep_id='.$salesrep_id.'&customer_id=' . $result['customer_id'], true),
				'edit'           => $this->url->link('customer/customer/edit', 'token=' . $this->session->data['token'] . '&type=customers&csalesrep_id='.$salesrep_id.'&customer_id=' . $result['customer_id'], true)
			);
		}

		$data['heading_title'] = $this->language->get('heading_title');

		$data['text_list'] = $this->language->get('text_list');
		$data['text_enabled'] = $this->language->get('text_enabled');
		$data['text_disabled'] = $this->language->get('text_disabled');
		$data['text_yes'] = $this->language->get('text_yes');
		$data['text_no'] = $this->language->get('text_no');
		$data['text_default'] = $this->language->get('text_default');
		$data['text_no_results'] = $this->language->get('text_no_results');
		$data['text_confirm'] = $this->language->get('text_confirm');

		$data['column_name'] = $this->language->get('column_name');
		$data['column_email'] = $this->language->get('column_email');
		$data['column_customer_group'] = $this->language->get('column_customer_group');
		$data['column_date_added'] = $this->language->get('column_date_added');
		$data['column_action'] = $this->language->get('column_action');

		$data['entry_name'] = $this->language->get('entry_name');
		$data['entry_customer_group'] = $this->language->get('entry_customer_group');
		$data['entry_date_added'] = $this->language->get('entry_date_added');

		$data['button_add'] = $this->language->get('button_add');
		$data['button_edit'] = $this->language->get('button_edit');
		$data['button_filter'] = $this->language->get('button_filter');
		
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

		$url = '';
		
		if (isset($this->request->get['type'])) {
			$url .= '&type=' . $this->request->get['type'];
		}
		
		if (isset($this->request->get['salesrep_id'])) {
			$url .= '&salesrep_id=' . $this->request->get['salesrep_id'];
		}
		
		if (isset($this->request->get['filter_customer_id'])) {
			$url .= '&filter_customer_id=' . $this->request->get['filter_customer_id'];
		}

		if (isset($this->request->get['filter_customer_group_id'])) {
			$url .= '&filter_customer_group_id=' . $this->request->get['filter_customer_group_id'];
		}

		if (isset($this->request->get['filter_date_added'])) {
			$url .= '&filter_date_added=' . $this->request->get['filter_date_added'];
		}

		if ($order == 'ASC') {
			$url .= '&order=DESC';
		} else {
			$url .= '&order=ASC';
		}

		if (isset($this->request->get['page'])) {
			$url .= '&page=' . $this->request->get['page'];
		}

		$data['sort_name'] = $this->url->link('replogic/salesrep_info', 'token=' . $this->session->data['token'] . '&sort=name' . $url, true);
		$data['sort_email'] = $this->url->link('replogic/salesrep_info', 'token=' . $this->session->data['token'] . '&sort=c.email' . $url, true);
		$data['sort_customer_group'] = $this->url->link('replogic/salesrep_info', 'token=' . $this->session->data['token'] . '&sort=customer_group' . $url, true);
		$data['sort_date_added'] = $this->url->link('replogic/salesrep_info', 'token=' . $this->session->data['token'] . '&sort=c.date_added' . $url, true);

		$url = '';
		
		if (isset($this->request->get['type'])) {
			$url .= '&type=' . $this->request->get['type'];
		}
		
		if (isset($this->request->get['salesrep_id'])) {
			$url .= '&salesrep_id=' . $this->request->get['salesrep_id'];
		}
		
		if (isset($this->request->get['filter_customer_id'])) {
			$url .= '&filter_customer_id=' . $this->request->get['filter_customer_id'];
		}

		if (isset($this->request->get['filter_customer_group_id'])) {
			$url .= '&filter_customer_group_id=' . $this->request->get['filter_customer_group_id'];
		}

		if (isset($this->request->get['filter_date_added'])) {
			$url .= '&filter_date_added=' . $this->request->get['filter_date_added'];
		}

		if (isset($this->request->get['sort'])) {
			$url .= '&sort=' . $this->request->get['sort'];
		}

		if (isset($this->request->get['order'])) {
			$url .= '&order=' . $this->request->get['order'];
		}

		$pagination = new Pagination();
		$pagination->total = $customer_total;
		$pagination->page = $page;
		$pagination->limit = $this->config->get('config_limit_admin');
		$pagination->url = $this->url->link('replogic/salesrep_info', 'token=' . $this->session->data['token'] . $url . '&page={page}', true);

		$data['pagination'] = $pagination->render();

		$data['results'] = sprintf($this->language->get('text_pagination'), ($customer_total) ? (($page - 1) * $this->config->get('config_limit_admin')) + 1 : 0, ((($page - 1) * $this->config->get('config_limit_admin')) > ($customer_total - $this->config->get('config_limit_admin'))) ? $customer_total : ((($page - 1) * $this->config->get('config_limit_admin')) + $this->config->get('config_limit_admin')), $customer_total, ceil($customer_total / $this->config->get('config_limit_admin')));

		$data['filter_customer_id'] = $filter_customer_id;
		$data['filter_customer_group_id'] = $filter_customer_group_id;
		$data['filter_date_added'] = $filter_date_added;

		$this->load->model('customer/customer_group');

		$data['customer_groups'] = $this->model_customer_customer_group->getCustomerGroups();
		
		$this->load->model('customer/customer');
	    $data['dropdowncustomers'] = $this->model_customer_customer->getCustomers();

		$this->load->model('setting/store');

		$data['stores'] = $this->model_setting_store->getStores();

		$data['sort'] = $sort;
		$data['order'] = $order;

		$data['header'] = $this->load->controller('common/header');
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['footer'] = $this->load->controller('common/footer');

		$this->response->setOutput($this->load->view('replogic/salesrep_info_customers', $data));
	}
	
	public function CustomersView() { 
		
		$this->load->language('customer/customer');
		$this->load->language('replogic/salesrep_info');
		$this->load->model('customer/customer');
		
		$salesrep_id = $this->request->get['salesrep_id'];
		
		$data['heading_title'] = $this->language->get('heading_title');

		$data['text_form'] = !isset($this->request->get['customer_id']) ? $this->language->get('text_add') : $this->language->get('text_edit');
		$data['text_enabled'] = $this->language->get('text_enabled');
		$data['text_disabled'] = $this->language->get('text_disabled');
		$data['text_yes'] = $this->language->get('text_yes');
		$data['text_no'] = $this->language->get('text_no');
		$data['text_select'] = $this->language->get('text_select');
		$data['text_none'] = $this->language->get('text_none');
		$data['text_loading'] = $this->language->get('text_loading');
		$data['text_add_ban_ip'] = $this->language->get('text_add_ban_ip');
		$data['text_remove_ban_ip'] = $this->language->get('text_remove_ban_ip');

		$data['entry_customer_group'] = $this->language->get('entry_customer_group');
		$data['entry_salesrep'] = $this->language->get('entry_salesrep');
		$data['entry_firstname'] = $this->language->get('entry_firstname');
		$data['entry_lastname'] = $this->language->get('entry_lastname');
		$data['entry_email'] = $this->language->get('entry_email');
		$data['entry_telephone'] = $this->language->get('entry_telephone');
		$data['entry_fax'] = $this->language->get('entry_fax');
		$data['entry_password'] = $this->language->get('entry_password');
		$data['entry_confirm'] = $this->language->get('entry_confirm');
		$data['entry_newsletter'] = $this->language->get('entry_newsletter');
		$data['entry_status'] = $this->language->get('entry_status');
		$data['entry_approved'] = $this->language->get('entry_approved');
		$data['entry_safe'] = $this->language->get('entry_safe');
		$data['entry_company'] = $this->language->get('entry_company');
		$data['entry_address_1'] = $this->language->get('entry_address_1');
		$data['entry_address_2'] = $this->language->get('entry_address_2');
		$data['entry_city'] = $this->language->get('entry_city');
		$data['entry_postcode'] = $this->language->get('entry_postcode');
		$data['entry_zone'] = $this->language->get('entry_zone');
		$data['entry_country'] = $this->language->get('entry_country');
		$data['entry_default'] = $this->language->get('entry_default');
		$data['entry_comment'] = $this->language->get('entry_comment');
		$data['entry_description'] = $this->language->get('entry_description');
		$data['entry_amount'] = $this->language->get('entry_amount');
		$data['entry_points'] = $this->language->get('entry_points');

		$data['help_safe'] = $this->language->get('help_safe');
		$data['help_points'] = $this->language->get('help_points');

		$data['button_save'] = $this->language->get('button_save');
		$data['button_cancel'] = $this->language->get('button_cancel');
		$data['button_address_add'] = $this->language->get('button_address_add');
		$data['button_history_add'] = $this->language->get('button_history_add');
		$data['button_transaction_add'] = $this->language->get('button_transaction_add');
		$data['button_reward_add'] = $this->language->get('button_reward_add');
		$data['button_remove'] = $this->language->get('button_remove');
		$data['button_upload'] = $this->language->get('button_upload');

		$data['tab_general'] = $this->language->get('tab_general');
		$data['tab_address'] = $this->language->get('tab_address');
		$data['tab_history'] = $this->language->get('tab_history');
		$data['tab_transaction'] = $this->language->get('tab_transaction');
		$data['tab_reward'] = $this->language->get('tab_reward');
		$data['tab_ip'] = $this->language->get('tab_ip');

		$data['token'] = $this->session->data['token'];

		if (isset($this->request->get['customer_id'])) {
			$data['customer_id'] = $this->request->get['customer_id'];
		} else {
			$data['customer_id'] = 0;
		}

		if (isset($this->error['warning'])) {
			$data['error_warning'] = $this->error['warning'];
		} else {
			$data['error_warning'] = '';
		}

		if (isset($this->error['firstname'])) {
			$data['error_firstname'] = $this->error['firstname'];
		} else {
			$data['error_firstname'] = '';
		}

		if (isset($this->error['lastname'])) {
			$data['error_lastname'] = $this->error['lastname'];
		} else {
			$data['error_lastname'] = '';
		}

		if (isset($this->error['email'])) {
			$data['error_email'] = $this->error['email'];
		} else {
			$data['error_email'] = '';
		}

		if (isset($this->error['telephone'])) {
			$data['error_telephone'] = $this->error['telephone'];
		} else {
			$data['error_telephone'] = '';
		}

		if (isset($this->error['password'])) {
			$data['error_password'] = $this->error['password'];
		} else {
			$data['error_password'] = '';
		}

		if (isset($this->error['confirm'])) {
			$data['error_confirm'] = $this->error['confirm'];
		} else {
			$data['error_confirm'] = '';
		}

		if (isset($this->error['custom_field'])) {
			$data['error_custom_field'] = $this->error['custom_field'];
		} else {
			$data['error_custom_field'] = array();
		}

		if (isset($this->error['address'])) {
			$data['error_address'] = $this->error['address'];
		} else {
			$data['error_address'] = array();
		}
		
		if (isset($this->error['salesrep_id'])) {
			$data['error_salesrep_id'] = $this->error['salesrep_id'];
		} else {
			$data['error_salesrep_id'] = '';
		}

		$url = '';

		if (isset($this->request->get['type'])) {
			$url .= '&type=' . $this->request->get['type'];
		}
		
		if (isset($this->request->get['csalesrep_id'])) {
			$url .= '&salesrep_id=' . $this->request->get['csalesrep_id'];
		}
		
		if (isset($this->request->get['filter_name'])) {
			$url .= '&filter_name=' . urlencode(html_entity_decode($this->request->get['filter_name'], ENT_QUOTES, 'UTF-8'));
		}

		if (isset($this->request->get['filter_email'])) {
			$url .= '&filter_email=' . urlencode(html_entity_decode($this->request->get['filter_email'], ENT_QUOTES, 'UTF-8'));
		}

		if (isset($this->request->get['filter_customer_group_id'])) {
			$url .= '&filter_customer_group_id=' . $this->request->get['filter_customer_group_id'];
		}

		if (isset($this->request->get['filter_status'])) {
			$url .= '&filter_status=' . $this->request->get['filter_status'];
		}

		if (isset($this->request->get['filter_approved'])) {
			$url .= '&filter_approved=' . $this->request->get['filter_approved'];
		}
		
		if (isset($this->request->get['filter_ip'])) {
			$url .= '&filter_ip=' . $this->request->get['filter_ip'];
		}
		
		if (isset($this->request->get['filter_date_added'])) {
			$url .= '&filter_date_added=' . $this->request->get['filter_date_added'];
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
			'text' => 'Sales Rep Management',
			'href' => $this->url->link('replogic/sales_rep_management', 'token=' . $this->session->data['token'] . $url, true)
		);

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('breadcrum_title'),
			'href' => $this->url->link('replogic/salesrep_info', 'token=' . $this->session->data['token'] . $url, true)
		);
		
		$data['breadcrumbs'][] = array(
			'text' => 'Customers View',
			'href' => $this->url->link('replogic/salesrep_info/customersView', 'token=' . $this->session->data['token'].'&customer_id='.$this->request->get['customer_id'].'' . $url, true)
		);

		if(isset($this->request->get['type']))
		{
			$data['cancel'] = $this->url->link('replogic/salesrep_info', 'token=' . $this->session->data['token'] . '&type=customers&salesrep_id='.$this->request->get['csalesrep_id'], true);
			$data['type'] = $this->request->get['type'];
			$data['csalesrep_id'] = $this->request->get['csalesrep_id'];
		}
		else
		{
			$data['cancel'] = $this->url->link('customer/customer', 'token=' . $this->session->data['token'] . $url, true);
			$data['type'] = '';
			$data['csalesrep_id'] = '';
		}

		if (isset($this->request->get['customer_id']) && ($this->request->server['REQUEST_METHOD'] != 'POST')) {
			$customer_info = $this->model_customer_customer->getCustomer($this->request->get['customer_id']);
		}

		$this->load->model('user/user');
		$this->load->model('user/user_group');
		
		$current_user = $this->session->data['user_id'];
		$current_user_group_id = $this->model_user_user->getUser($current_user);
		$current_user_group = $this->model_user_user_group->getUserGroup($current_user_group_id['user_group_id']); 
		//print_r($current_user_group); exit;
		if($current_user_group['name'] == 'Company admin')
		{
			$data['access'] = 'yes';
			$allaccess = true;
			$current_user_id = 0;
		}
		else if($current_user_group['name'] == 'Sales Manager')
		{
			$data['access'] = 'yes';
			$allaccess = false;
			$current_user_id = $this->session->data['user_id'];
		}
		else
		{
			$data['access'] = 'no';
			$allaccess = false;
			$current_user_id = $this->session->data['user_id'];
		}
		
		$this->load->model('replogic/sales_rep_management');

		$data['salesreps'] = $this->model_replogic_sales_rep_management->getSalesRepsDropdown($allaccess, $current_user_id);
		//$data['salesreps'] = '';
		
		$this->load->model('customer/customer_group');

		$data['customer_groups'] = $this->model_customer_customer_group->getCustomerGroups();

		if (isset($this->request->post['customer_group_id'])) {
			$data['customer_group_id'] = $this->request->post['customer_group_id'];
		} elseif (!empty($customer_info)) {
			$data['customer_group_id'] = $customer_info['customer_group_id'];
		} else {
			$data['customer_group_id'] = $this->config->get('config_customer_group_id');
		}
		
		if (isset($this->request->post['salesrep_id'])) {
			$data['salesrep_id'] = $this->request->post['salesrep_id'];
		} elseif (!empty($customer_info)) {
			$data['salesrep_id'] = $customer_info['salesrep_id'];
		}elseif(isset($this->request->get['type']) && $this->request->get['type'] == 'customers') {
			$data['salesrep_id'] = $this->request->get['csalesrep_id'];
		} 
		else {
			$data['salesrep_id'] = '';
		}

		if (isset($this->request->post['firstname'])) {
			$data['firstname'] = $this->request->post['firstname'];
		} elseif (!empty($customer_info)) {
			$data['firstname'] = $customer_info['firstname'];
		} else {
			$data['firstname'] = '';
		}

		if (isset($this->request->post['lastname'])) {
			$data['lastname'] = $this->request->post['lastname'];
		} elseif (!empty($customer_info)) {
			$data['lastname'] = $customer_info['lastname'];
		} else {
			$data['lastname'] = '';
		}

		if (isset($this->request->post['email'])) {
			$data['email'] = $this->request->post['email'];
		} elseif (!empty($customer_info)) {
			$data['email'] = $customer_info['email'];
		} else {
			$data['email'] = '';
		}

		if (isset($this->request->post['telephone'])) {
			$data['telephone'] = $this->request->post['telephone'];
		} elseif (!empty($customer_info)) {
			$data['telephone'] = $customer_info['telephone'];
		} else {
			$data['telephone'] = '';
		}

		if (isset($this->request->post['fax'])) {
			$data['fax'] = $this->request->post['fax'];
		} elseif (!empty($customer_info)) {
			$data['fax'] = $customer_info['fax'];
		} else {
			$data['fax'] = '';
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

		if (isset($this->request->post['custom_field'])) {
			$data['account_custom_field'] = $this->request->post['custom_field'];
		} elseif (!empty($customer_info)) {
			$data['account_custom_field'] = json_decode($customer_info['custom_field'], true);
		} else {
			$data['account_custom_field'] = array();
		}

		if (isset($this->request->post['newsletter'])) {
			$data['newsletter'] = $this->request->post['newsletter'];
		} elseif (!empty($customer_info)) {
			$data['newsletter'] = $customer_info['newsletter'];
		} else {
			$data['newsletter'] = '';
		}

		if (isset($this->request->post['status'])) {
			$data['status'] = $this->request->post['status'];
		} elseif (!empty($customer_info)) {
			$data['status'] = $customer_info['status'];
		} else {
			$data['status'] = true;
		}

		if (isset($this->request->post['approved'])) {
			$data['approved'] = $this->request->post['approved'];
		} elseif (!empty($customer_info)) {
			$data['approved'] = $customer_info['approved'];
		} else {
			$data['approved'] = true;
		}

		if (isset($this->request->post['safe'])) {
			$data['safe'] = $this->request->post['safe'];
		} elseif (!empty($customer_info)) {
			$data['safe'] = $customer_info['safe'];
		} else {
			$data['safe'] = 0;
		}

		if (isset($this->request->post['password'])) {
			$data['password'] = $this->request->post['password'];
		} else {
			$data['password'] = '';
		}

		if (isset($this->request->post['confirm'])) {
			$data['confirm'] = $this->request->post['confirm'];
		} else {
			$data['confirm'] = '';
		}

		$this->load->model('localisation/country');

		$data['countries'] = $this->model_localisation_country->getCountries();

		if (isset($this->request->post['address'])) {
			$data['addresses'] = $this->request->post['address'];
		} elseif (isset($this->request->get['customer_id'])) {
			$data['addresses'] = $this->model_customer_customer->getAddresses($this->request->get['customer_id']);
		} else {
			$data['addresses'] = array();
		}

		if (isset($this->request->post['address_id'])) {
			$data['address_id'] = $this->request->post['address_id'];
		} elseif (!empty($customer_info)) {
			$data['address_id'] = $customer_info['address_id'];
		} else {
			$data['address_id'] = '';
		}

		$data['header'] = $this->load->controller('common/header');
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['footer'] = $this->load->controller('common/footer');

		$this->response->setOutput($this->load->view('replogic/salesrep_info_customers_view', $data));
	}
	
	protected function getOrdersTab() {
		
		$this->load->model('sale/order');
		$this->load->language('sale/order');
		$this->load->language('replogic/salesrep_info');
		
		$salesrep_id = $this->request->get['salesrep_id'];
		$data['salesrep_id'] = $salesrep_id;
		$salesrepdetails = $this->model_replogic_sales_rep_management->getsalesrep($salesrep_id);
		$data['salesrepname'] = $salesrepdetails['salesrep_name'] ." ". $salesrepdetails['salesrep_lastname'];
		
		if (isset($this->request->get['filter_order_id'])) {
			$filter_order_id = $this->request->get['filter_order_id'];
		} else {
			$filter_order_id = null;
		}

		if (isset($this->request->get['filter_customer_id'])) {
			$filter_customer_id = $this->request->get['filter_customer_id'];
		} else {
			$filter_customer_id = null;
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

		if (isset($this->request->get['type'])) {
			$url .= '&type=' . $this->request->get['type'];
		}
		
		if (isset($this->request->get['salesrep_id'])) {
			$url .= '&salesrep_id=' . $this->request->get['salesrep_id'];
		}
		
		if (isset($this->request->get['filter_order_id'])) {
			$url .= '&filter_order_id=' . $this->request->get['filter_order_id'];
		}

		if (isset($this->request->get['filter_customer_id'])) {
			$url .= '&filter_customer_id=' . $this->request->get['filter_customer_id'];
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
			'href' => $this->url->link('common/dashboard', 'token=' . $this->session->data['token'], true)
		);

		$data['breadcrumbs'][] = array(
			'text' => 'Sales Rep Management',
			'href' => $this->url->link('replogic/sales_rep_management', 'token=' . $this->session->data['token'] . $url, true)
		);
		
		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('breadcrum_title'),
			'href' => $this->url->link('replogic/salesrep_info', 'salesrep_id=' . $salesrep_id .'&token=' . $this->session->data['token'] . $url, true)
		);
		
		$data['cancel'] = $this->url->link('replogic/sales_rep_management', 'token=' . $this->session->data['token'] . $url, true);
		
		$data['generaltab'] = $this->url->link('replogic/salesrep_info', 'type=general&salesrep_id=' . $salesrep_id .'&token=' . $this->session->data['token'], true);
		$data['appointmenttab'] = $this->url->link('replogic/salesrep_info', 'type=appointment&salesrep_id=' . $salesrep_id .'&token=' . $this->session->data['token'], true);
		$data['customerstab'] = $this->url->link('replogic/salesrep_info', 'type=customers&salesrep_id=' . $salesrep_id .'&token=' . $this->session->data['token'], true);
		$data['visitstab'] = $this->url->link('replogic/salesrep_info', 'type=visits&salesrep_id=' . $salesrep_id .'&token=' . $this->session->data['token'], true);
		$data['orderstab'] = $this->url->link('replogic/salesrep_info', 'type=orders&salesrep_id=' . $salesrep_id .'&token=' . $this->session->data['token'], true);
		$data['quotestab'] = $this->url->link('replogic/salesrep_info', 'type=quotes&salesrep_id=' . $salesrep_id .'&token=' . $this->session->data['token'], true);
		
		
		$data['orders'] = array();

		$filter_data = array(
			'filter_order_id'      => $filter_order_id,
			'filter_salesrep_id'   => $salesrep_id,
			'filter_customer_id'   => $filter_customer_id,
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
			$salesrep = $this->model_replogic_sales_rep_management->getsalesrep($cstdetails['salesrep_id']);
			$salesrepname = $salesrep['salesrep_name'].' '.$salesrep['salesrep_lastname'];
			
			$data['orders'][] = array(
				'order_id'      => $result['order_id'],
				'customer'      => $result['customer'],
				'salesrep'      => $salesrepname,
				'order_status'  => $result['order_status'] ? $result['order_status'] : $this->language->get('text_missing'),
				'total'         => $this->currency->format($result['total'], $result['currency_code'], $result['currency_value']),
				'date_added'    => date($this->language->get('date_format_short'), strtotime($result['date_added'])),
				'date_modified' => date($this->language->get('date_format_short'), strtotime($result['date_modified'])),
				'shipping_code' => $result['shipping_code'],
				'view'          => $this->url->link('sale/order/info', 'token=' . $this->session->data['token'] . '&csalesrep_id='.$salesrep_id.'&order_id=' . $result['order_id'] . $url, true),
				'edit'           => $this->url->link('sale/order/edit', 'token=' . $this->session->data['token'] . '&csalesrep_id='.$salesrep_id.'&order_id=' . $result['order_id']. $url, true)
			);
		}
		
		$data['customers'] = $this->model_customer_customer->getCustomers();

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
		
		$url = '';

		if (isset($this->request->get['type'])) {
			$url .= '&type=' . $this->request->get['type'];
		}
		
		if (isset($this->request->get['salesrep_id'])) {
			$url .= '&salesrep_id=' . $this->request->get['salesrep_id'];
		}
		
		if (isset($this->request->get['filter_order_id'])) {
			$url .= '&filter_order_id=' . $this->request->get['filter_order_id'];
		}

		if (isset($this->request->get['filter_customer_id'])) {
			$url .= '&filter_customer_id=' . $this->request->get['filter_customer_id'];
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
		$data['sort_salesrep'] = $this->url->link('sale/order', 'token=' . $this->session->data['token'] . '&sort=salesrep' . $url, true);
		$data['sort_status'] = $this->url->link('sale/order', 'token=' . $this->session->data['token'] . '&sort=order_status' . $url, true);
		$data['sort_total'] = $this->url->link('sale/order', 'token=' . $this->session->data['token'] . '&sort=o.total' . $url, true);
		$data['sort_date_added'] = $this->url->link('sale/order', 'token=' . $this->session->data['token'] . '&sort=o.date_added' . $url, true);
		$data['sort_date_modified'] = $this->url->link('sale/order', 'token=' . $this->session->data['token'] . '&sort=o.date_modified' . $url, true);

		$url = '';

		if (isset($this->request->get['type'])) {
			$url .= '&type=' . $this->request->get['type'];
		}
		
		if (isset($this->request->get['salesrep_id'])) {
			$url .= '&salesrep_id=' . $this->request->get['salesrep_id'];
		}
		
		if (isset($this->request->get['filter_order_id'])) {
			$url .= '&filter_order_id=' . $this->request->get['filter_order_id'];
		}

		if (isset($this->request->get['filter_customer_id'])) {
			$url .= '&filter_customer_id=' . $this->request->get['filter_customer_id'];
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
		$pagination->url = $this->url->link('replogic/salesrep_info', 'token=' . $this->session->data['token'] . $url . '&page={page}', true);

		$data['pagination'] = $pagination->render();

		$data['results'] = sprintf($this->language->get('text_pagination'), ($order_total) ? (($page - 1) * $this->config->get('config_limit_admin')) + 1 : 0, ((($page - 1) * $this->config->get('config_limit_admin')) > ($order_total - $this->config->get('config_limit_admin'))) ? $order_total : ((($page - 1) * $this->config->get('config_limit_admin')) + $this->config->get('config_limit_admin')), $order_total, ceil($order_total / $this->config->get('config_limit_admin')));

		$data['filter_order_id'] = $filter_order_id;
		$data['filter_customer_id'] = $filter_customer_id;
		$data['filter_order_status'] = $filter_order_status;
		$data['filter_total'] = $filter_total;
		$data['filter_date_added'] = $filter_date_added;
		$data['filter_date_modified'] = $filter_date_modified;

		$data['sort'] = $sort;
		$data['order'] = $order;

		$this->load->model('localisation/order_status');

		$data['order_statuses'] = $this->model_localisation_order_status->getOrderStatuses();
		
		$data['header'] = $this->load->controller('common/header');
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['footer'] = $this->load->controller('common/footer');

		$this->response->setOutput($this->load->view('replogic/salesrep_info_orders', $data));
	}
	
	protected function getQuotesTab() {
		
		$this->load->model('replogic/order_quotes');
		$this->load->language('replogic/order_quotes');
		$this->load->language('replogic/salesrep_info');
		
		$salesrep_id = $this->request->get['salesrep_id'];
		$salesrepdetails = $this->model_replogic_sales_rep_management->getsalesrep($salesrep_id);
		$data['salesrepname'] = $salesrepdetails['salesrep_name'] ." ". $salesrepdetails['salesrep_lastname'];
		$data['salesrep_id'] = $salesrep_id;
		
		if (isset($this->request->get['filter_quote_id'])) {
			$filter_quote_id = $this->request->get['filter_quote_id'];
		} else {
			$filter_quote_id = null;
		}

		if (isset($this->request->get['filter_customer_id'])) {
			$filter_customer_id = $this->request->get['filter_customer_id'];
		} else {
			$filter_customer_id = null;
		}
		
		if (isset($this->request->get['filter_customer_contact'])) {
			$filter_customer_contact = $this->request->get['filter_customer_contact'];
		} else {
			$filter_customer_contact = null;
		}
		
		if (isset($this->request->get['filter_customer_contact_id'])) {
			$filter_customer_contact_id = $this->request->get['filter_customer_contact_id'];
		} else {
			$filter_customer_contact_id = null;
		}

		if (isset($this->request->get['filter_order_status'])) {
			$filter_order_status = $this->request->get['filter_order_status'];
		} else {
			$filter_order_status = null;
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
			$sort = 'quote_id';
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

		if (isset($this->request->get['type'])) {
			$url .= '&type=' . $this->request->get['type'];
		}
		
		if (isset($this->request->get['salesrep_id'])) {
			$url .= '&salesrep_id=' . $this->request->get['salesrep_id'];
		}
		
		if (isset($this->request->get['filter_quote_id'])) {
			$url .= '&filter_quote_id=' . $this->request->get['filter_quote_id'];
		}
		
		if (isset($this->request->get['filter_customer_id'])) {
			$url .= '&filter_customer_id=' . $this->request->get['filter_customer_id'];
		}
		
		if (isset($this->request->get['filter_customer'])) {
			$url .= '&filter_customer=' . urlencode(html_entity_decode($this->request->get['filter_customer'], ENT_QUOTES, 'UTF-8'));
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
		
		$data['cancel'] = $this->url->link('replogic/sales_rep_management', 'token=' . $this->session->data['token'] . $url, true);
		
		$data['generaltab'] = $this->url->link('replogic/salesrep_info', 'type=general&salesrep_id=' . $salesrep_id .'&token=' . $this->session->data['token'], true);
		$data['appointmenttab'] = $this->url->link('replogic/salesrep_info', 'type=appointment&salesrep_id=' . $salesrep_id .'&token=' . $this->session->data['token'], true);
		$data['customerstab'] = $this->url->link('replogic/salesrep_info', 'type=customers&salesrep_id=' . $salesrep_id .'&token=' . $this->session->data['token'], true);
		$data['visitstab'] = $this->url->link('replogic/salesrep_info', 'type=visits&salesrep_id=' . $salesrep_id .'&token=' . $this->session->data['token'], true);
		$data['orderstab'] = $this->url->link('replogic/salesrep_info', 'type=orders&salesrep_id=' . $salesrep_id .'&token=' . $this->session->data['token'], true);
		$data['quotestab'] = $this->url->link('replogic/salesrep_info', 'type=quotes&salesrep_id=' . $salesrep_id .'&token=' . $this->session->data['token'], true);
		
		$data['breadcrumbs'] = array();

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('text_home'),
			'href' => $this->url->link('common/dashboard', 'token=' . $this->session->data['token'], true)
		);

		$data['breadcrumbs'][] = array(
			'text' => 'Sales Rep Management',
			'href' => $this->url->link('replogic/sales_rep_management', 'token=' . $this->session->data['token'] . $url, true)
		);
		
		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('breadcrum_title'),
			'href' => $this->url->link('replogic/salesrep_info', 'salesrep_id=' . $salesrep_id .'&token=' . $this->session->data['token'] . $url, true)
		);

		$data['invoice'] = $this->url->link('replogic/order_quotes/invoice', 'token=' . $this->session->data['token'], true);
		$data['shipping'] = $this->url->link('replogic/order_quotes/shipping', 'token=' . $this->session->data['token'], true);
		$data['add'] = $this->url->link('replogic/order_quotes/add', 'token=' . $this->session->data['token'], true);
		
		$this->load->model('user/user_group');
		$this->load->model('user/user');
		$current_user = $this->session->data['user_id'];
		$current_user_group_id = $this->model_user_user->getUser($current_user); ;
		$current_user_group = $this->model_user_user_group->getUserGroup($current_user_group_id['user_group_id']); ;
		
		$data['orders'] = array();

		$filter_data = array(
			'filter_quote_id'      => $filter_quote_id,
			'filter_salesrep_id'      => $salesrep_id,
			'filter_customer_id'	   => $filter_customer_id,
			'filter_customer_contact_id'	   => $filter_customer_contact_id,
			'filter_order_status'  => $filter_order_status,
			'filter_date_added'    => $filter_date_added,
			'filter_date_modified' => $filter_date_modified,
			'sort'                 => $sort,
			'order'                => $order,
			'start'                => ($page - 1) * $this->config->get('config_limit_admin'),
			'limit'                => $this->config->get('config_limit_admin')
		);

		$order_quotes_total = $this->model_replogic_order_quotes->getTotalOrders($filter_data);
		
		$data['decline']  = $this->url->link('replogic/order_quotes/decline', 'token=' . $this->session->data['token'] . $url, true);
				
		
		$results = $this->model_replogic_order_quotes->getOrders($filter_data);
		$this->load->model('replogic/customer_contact');
		$this->load->model('customer/customer');
		
		$this->load->model('user/user_group');
		$this->load->model('user/user');
		$current_user = $this->session->data['user_id'];
		$current_user_group_id = $this->model_user_user->getUser($current_user); ;
		$current_user_group = $this->model_user_user_group->getUserGroup($current_user_group_id['user_group_id']); ;
		//print_r($current_user_group); exit;
		
		
		foreach ($results as $result) {
			
			if ($result['status'] == 0) {
				$qstatus = 'Awaiting Approval';
			} elseif ($result['status'] == 1){
				$qstatus = 'Approved';
			}
			elseif ($result['status'] == 2){
				$qstatus = 'Declined';
			}
			
			$objct = json_decode($result['cart']);
			$array = (array) $objct;
			$total = $array['cart_total_price']; 
			
			$cust_con = $this->model_replogic_customer_contact->getcustomercontact($result['customer_contact_id']);
			$customer_contact = $cust_con['first_name'] ." ". $cust_con['last_name'];
			
			$cust = $this->model_customer_customer->getCustomer($result['customer_id']);
			$customer_nm = $cust['firstname'];
			
			if($current_user_group['name'] == 'Company admin' || $current_user_group['name'] == 'Administrator')
			{
				$view_button = $this->url->link('replogic/order_quotes/info', 'redirto=salesrepinfo&quote_id='.$result['quote_id'].'&token=' . $this->session->data['token'] . $url, true);
			}
			else
			{ 
				$view_button = '';
			}
			
			$data['orders'][] = array(
				'quote_id'      => $result['quote_id'],
				'customer'      => $customer_nm,
				'customer_contact'      => $customer_contact,
				'approve'      => $this->url->link('replogic/order/add', 'token=' . $this->session->data['token'] . '&quote_id=' . $result['quote_id'] . $url, true),
				'qstatus'      => $qstatus,
				'status'      => $result['status'],
				'order_id'      => $result['order_id'],
				'order_status'  => $result['order_status'] ? $result['order_status'] : $this->language->get('text_missing'),
				'total'         => $this->currency->format($total, 'ZAR', '1.0000'),
				'date_added'    => date($this->language->get('date_format_short'), strtotime($result['date_added'])),
				'shipping_code' => $result['shipping_code'],
				'view'          => $view_button
			);
		}
		
	    $data['customers'] = $this->model_customer_customer->getCustomers();
		
		$data['customercontacts'] = $this->model_replogic_customer_contact->getcustomercontacts();
		
		$data['heading_title'] = $this->language->get('heading_title');

		$data['text_list'] = $this->language->get('text_list');
		$data['text_no_results'] = $this->language->get('text_no_results');
		$data['text_confirm'] = $this->language->get('text_confirm');
		$data['text_missing'] = $this->language->get('text_missing');
		$data['text_loading'] = $this->language->get('text_loading');

		$data['column_quote_id'] = $this->language->get('column_quote_id');
		$data['column_customer'] = $this->language->get('column_customer');
		$data['column_customer_contact'] = $this->language->get('column_customer_contact');
		$data['column_status'] = $this->language->get('column_status');
		$data['column_total'] = $this->language->get('column_total');
		$data['column_date_added'] = $this->language->get('column_date_added');
		$data['column_date_modified'] = $this->language->get('column_date_modified');
		$data['column_action'] = $this->language->get('column_action');

		$data['entry_quote_id'] = $this->language->get('entry_quote_id');
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

		if (isset($this->request->get['type'])) {
			$url .= '&type=' . $this->request->get['type'];
		}
		
		if (isset($this->request->get['salesrep_id'])) {
			$url .= '&salesrep_id=' . $this->request->get['salesrep_id'];
		}
		
		if (isset($this->request->get['filter_quote_id'])) {
			$url .= '&filter_quote_id=' . $this->request->get['filter_quote_id'];
		}

		if (isset($this->request->get['filter_customer_id'])) {
			$url .= '&filter_customer_id=' . $this->request->get['filter_customer_id'];
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

		if ($order == 'ASC') {
			$url .= '&order=DESC';

		} else {
			$url .= '&order=ASC';
		}

		if (isset($this->request->get['page'])) {
			$url .= '&page=' . $this->request->get['page'];
		}

		$data['sort_order'] = $this->url->link('replogic/order_quotes', 'token=' . $this->session->data['token'] . '&sort=quote_id' . $url, true);
		$data['sort_customer'] = $this->url->link('replogic/order_quotes', 'token=' . $this->session->data['token'] . '&sort=customer' . $url, true);
		$data['sort_customer_contact'] = $this->url->link('replogic/order_quotes', 'token=' . $this->session->data['token'] . '&sort=customer_contact' . $url, true);
		$data['sort_status'] = $this->url->link('replogic/order_quotes', 'token=' . $this->session->data['token'] . '&sort=order_status' . $url, true);
		$data['sort_total'] = $this->url->link('replogic/order_quotes', 'token=' . $this->session->data['token'] . '&sort=total' . $url, true);
		$data['sort_date_added'] = $this->url->link('replogic/order_quotes', 'token=' . $this->session->data['token'] . '&sort=date_added' . $url, true);
		$data['sort_date_modified'] = $this->url->link('replogic/order_quotes', 'token=' . $this->session->data['token'] . '&sort=date_modified' . $url, true);

		$url = '';
		
		if (isset($this->request->get['type'])) {
			$url .= '&type=' . $this->request->get['type'];
		}
		
		if (isset($this->request->get['salesrep_id'])) {
			$url .= '&salesrep_id=' . $this->request->get['salesrep_id'];
		}
		
		if (isset($this->request->get['filter_quote_id'])) {
			$url .= '&filter_quote_id=' . $this->request->get['filter_quote_id'];
		}

		if (isset($this->request->get['filter_customer_id'])) {
			$url .= '&filter_customer_id=' . $this->request->get['filter_customer_id'];
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

		$pagination = new Pagination();
		$pagination->total = $order_quotes_total;
		$pagination->page = $page;
		$pagination->limit = $this->config->get('config_limit_admin');
		$pagination->url = $this->url->link('replogic/salesrep_info', 'token=' . $this->session->data['token'] . $url . '&page={page}', true);

		$data['pagination'] = $pagination->render();

		$data['results'] = sprintf($this->language->get('text_pagination'), ($order_quotes_total) ? (($page - 1) * $this->config->get('config_limit_admin')) + 1 : 0, ((($page - 1) * $this->config->get('config_limit_admin')) > ($order_quotes_total - $this->config->get('config_limit_admin'))) ? $order_quotes_total : ((($page - 1) * $this->config->get('config_limit_admin')) + $this->config->get('config_limit_admin')), $order_quotes_total, ceil($order_quotes_total / $this->config->get('config_limit_admin')));

		$data['filter_quote_id'] = $filter_quote_id;
		$data['filter_customer_id'] = $filter_customer_id;
		$data['filter_customer_contact'] = $filter_customer_contact;
		$data['filter_customer_contact_id'] = $filter_customer_contact_id;
		$data['filter_order_status'] = $filter_order_status;
		$data['filter_date_added'] = $filter_date_added;
		$data['filter_date_modified'] = $filter_date_modified;

		$data['sort'] = $sort;
		$data['order'] = $order;

		$this->load->model('localisation/order_status');

		$data['order_statuses'] = $this->model_localisation_order_status->getOrderStatuses();
		
		$data['header'] = $this->load->controller('common/header');
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['footer'] = $this->load->controller('common/footer');

		$this->response->setOutput($this->load->view('replogic/salesrep_info_quotes', $data));
	}
	
	protected function getVisitsTab() {
		
		$this->load->model('replogic/location_management');
		$this->load->language('replogic/location_management');
		$this->load->language('replogic/salesrep_info');
		
		$salesrep_id = $this->request->get['salesrep_id'];
		$data['salesrep_id'] = $salesrep_id;
		$salesrepdetails = $this->model_replogic_sales_rep_management->getsalesrep($salesrep_id);
		$data['salesrepname'] = $salesrepdetails['salesrep_name'] ." ". $salesrepdetails['salesrep_lastname'];
		
		if (isset($this->request->get['filter_date_from'])) {
			$filter_date_from = $this->request->get['filter_date_from'];
		} else {
			$filter_date_from = null;
		}

		if (isset($this->request->get['filter_customer_id'])) {
			$filter_customer_id = $this->request->get['filter_customer_id'];
		} else {
			$filter_customer_id = null;
		}

		if (isset($this->request->get['filter_date_to'])) {
			$filter_date_to = $this->request->get['filter_date_to'];
		} else {
			$filter_date_to = null;
		}

		if (isset($this->request->get['sort'])) {
			$sort = $this->request->get['sort'];
		} else {
			$sort = 'name';
		}

		if (isset($this->request->get['order'])) {
			$order = $this->request->get['order'];
		} else {
			$order = 'ASC';
		}

		if (isset($this->request->get['page'])) {
			$page = $this->request->get['page'];
		} else {
			$page = 1;
		}

		$url = '';

		if (isset($this->request->get['type'])) {
			$url .= '&type=' . $this->request->get['type'];
		}
		
		if (isset($this->request->get['salesrep_id'])) {
			$url .= '&salesrep_id=' . $this->request->get['salesrep_id'];
		}
		
		if (isset($this->request->get['filter_date_from'])) {
			$url .= '&filter_date_from=' . $this->request->get['filter_date_from'];
		}

		if (isset($this->request->get['filter_customer_id'])) {
			$url .= '&filter_customer_id=' . $this->request->get['filter_customer_id'];
		}

		if (isset($this->request->get['filter_date_to'])) {
			$url .= '&filter_date_to=' . $this->request->get['filter_date_to'];
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
			'text' => 'Sales Rep Management',
			'href' => $this->url->link('replogic/sales_rep_management', 'token=' . $this->session->data['token'] . $url, true)
		);
		
		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('breadcrum_title'),
			'href' => $this->url->link('replogic/salesrep_info', 'salesrep_id=' . $salesrep_id .'&token=' . $this->session->data['token'] . $url, true)
		);

		$data['cancel'] = $this->url->link('replogic/sales_rep_management', 'token=' . $this->session->data['token'] . $url, true);
		
		$data['generaltab'] = $this->url->link('replogic/salesrep_info', 'type=general&salesrep_id=' . $salesrep_id .'&token=' . $this->session->data['token'], true);
		$data['appointmenttab'] = $this->url->link('replogic/salesrep_info', 'type=appointment&salesrep_id=' . $salesrep_id .'&token=' . $this->session->data['token'], true);
		$data['customerstab'] = $this->url->link('replogic/salesrep_info', 'type=customers&salesrep_id=' . $salesrep_id .'&token=' . $this->session->data['token'], true);
		$data['visitstab'] = $this->url->link('replogic/salesrep_info', 'type=visits&salesrep_id=' . $salesrep_id .'&token=' . $this->session->data['token'], true);
		$data['orderstab'] = $this->url->link('replogic/salesrep_info', 'type=orders&salesrep_id=' . $salesrep_id .'&token=' . $this->session->data['token'], true);
		$data['quotestab'] = $this->url->link('replogic/salesrep_info', 'type=quotes&salesrep_id=' . $salesrep_id .'&token=' . $this->session->data['token'], true);
		
		$this->load->model('user/user_group');
		$this->load->model('user/user');
		$this->load->model('user/team');
		$current_user = $this->session->data['user_id'];
		$current_user_group_id = $this->model_user_user->getUser($current_user); ;
		$current_user_group = $this->model_user_user_group->getUserGroup($current_user_group_id['user_group_id']); ;
		//print_r($current_user_group); exit;
		if($current_user_group['name'] == 'Sales Manager')
		{
			$curent_sales_team = $this->model_user_team->getTeamBySalesmanager($current_user);
			$filter_team_id = $curent_sales_team['team_id']; 
			
		}
		else
		{
			$filter_team_id = NULL; 
		}
		
		$filter_data = array(
			'filter_date_from'	  => $filter_date_from,
			'filter_date_to'	  => $filter_date_to,
			'filter_customer_id'	  => $filter_customer_id,
			'filter_team_id'	  => $filter_team_id,
			'filter_salesrep_id' => $salesrep_id,
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
		if($current_user_group['name'] == 'Company admin' || $current_user_group['name'] == 'Administrator')
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

		$location_total = $this->model_replogic_location_management->getTotalLocations($filter_data);
		$results = $this->model_replogic_location_management->getLocations($filter_data);
		
		$this->load->model('replogic/sales_rep_management');
		$this->load->model('customer/customer');
		$this->load->model('user/team');
		
		$this->load->model('user/team');
		if($current_user_group['name'] == 'Sales Manager')
		{
			$salesrep_id = $current_user; 
			
		}
		else
		{
			$salesrep_id = ''; 
		}
		$filter_dataa = array('filter_salesrep_id' => $salesrep_id);
		$data['teams'] = $this->model_user_team->getTeams($filter_dataa);
		
		$data['customers'] = $this->model_customer_customer->getCustomers(); ;
		$data['salesReps'] = $this->model_replogic_sales_rep_management->getSalesRepsDropdown($allaccess, $current_user_id);
		$data['locations'] = array();
		$locationsmaps = array();
		foreach ($results as $result) {
			
		$customer = $this->model_customer_customer->getCustomer($result['customer_id']);
		$customername = $customer['firstname'];
		
		$team = $this->model_user_team->getTeam($salesrep['sales_team_id']); ;
		$teamname = $team['team_name'];
		
		$time = strtotime($result['checkin']);
		$last_check = date("d M Y g:i A", $time);
		
		$last_check_Ago = $this->getHowLongAgo($result['checkin']);
		
		$from = $result['start'];
		$to = $result['end'];
		$duration = $this->dateDiff($from, $to);
		
		$time = strtotime($result['checkin']);
		$visitdate = date("d-m-Y g:i A", $time);
		
		$data['locations'][] = array(
				'checkin_id' => $result['checkin_id'],
				'visitdate'          => $visitdate,
				'duration'          => $duration,
				'customer'          => $customername,
				'last_check'          => $last_check_Ago,
				'checkin_location'          => $result['checkin_location'],
				'location'          => $result['location'],
				'view'          => $this->url->link('replogic/salesrep_info/visitsView', 'token=' . $this->session->data['token'] . '&checkin_id=' . $result['checkin_id'] . $url, true)
				
			);
		
		}
	
		$this->load->model('user/user_group');
		$this->load->model('user/user');
		$user_group_id = $this->model_user_user_group->getUserGroupByName('Sales Manager');
		$data['sales_managers'] = $this->model_user_user->getUsersByGroupId($user_group_id['user_group_id']);
		
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

		$url = '';
		
		if (isset($this->request->get['type'])) {
			$url .= '&type=' . $this->request->get['type'];
		}
		
		if (isset($this->request->get['salesrep_id'])) {
			$url .= '&salesrep_id=' . $this->request->get['salesrep_id'];
		}
		
		if (isset($this->request->get['filter_date_from'])) {
			$url .= '&filter_date_from=' . $this->request->get['filter_date_from'];
		}

		if (isset($this->request->get['filter_customer_id'])) {
			$url .= '&filter_customer_id=' . $this->request->get['filter_customer_id'];
		}

		if (isset($this->request->get['filter_date_to'])) {
			$url .= '&filter_date_to=' . $this->request->get['filter_date_to'];
		}
		
		if ($order == 'ASC') {
			$url .= '&order=DESC';
		} else {
			$url .= '&order=ASC';
		}

		if (isset($this->request->get['page'])) {
			$url .= '&page=' . $this->request->get['page'];
		}

		$data['sort_name'] = $this->url->link('replogic/salesrep_info', 'token=' . $this->session->data['token'] . '&sort=name' . $url, true);

		$url = '';
		
		if (isset($this->request->get['type'])) {
			$url .= '&type=' . $this->request->get['type'];
		}
		
		if (isset($this->request->get['salesrep_id'])) {
			$url .= '&salesrep_id=' . $this->request->get['salesrep_id'];
		}
		
		if (isset($this->request->get['filter_date_from'])) {
			$url .= '&filter_date_from=' . $this->request->get['filter_date_from'];
		}

		if (isset($this->request->get['filter_customer_id'])) {
			$url .= '&filter_customer_id=' . $this->request->get['filter_customer_id'];
		}

		if (isset($this->request->get['filter_date_to'])) {
			$url .= '&filter_date_to=' . $this->request->get['filter_date_to'];
		}
		
		if (isset($this->request->get['sort'])) {
			$url .= '&sort=' . $this->request->get['sort'];
		}

		if (isset($this->request->get['order'])) {
			$url .= '&order=' . $this->request->get['order'];
		}
		
		$pagination = new Pagination();
		$pagination->total = $location_total;
		$pagination->page = $page;
		$pagination->limit = $this->config->get('config_limit_admin');
		$pagination->url = $this->url->link('replogic/salesrep_info', 'token=' . $this->session->data['token'] . $url . '&page={page}', true);

		$data['pagination'] = $pagination->render();

		$data['results'] = sprintf($this->language->get('text_pagination'), ($location_total) ? (($page - 1) * $this->config->get('config_limit_admin')) + 1 : 0, ((($page - 1) * $this->config->get('config_limit_admin')) > ($location_total - $this->config->get('config_limit_admin'))) ? $location_total : ((($page - 1) * $this->config->get('config_limit_admin')) + $this->config->get('config_limit_admin')), $location_total, ceil($location_total / $this->config->get('config_limit_admin')));

		$data['filter_date_from'] = $filter_date_from;
		$data['filter_customer_id'] = $filter_customer_id;
		$data['filter_date_to'] = $filter_date_to;
		$data['filter_salesrep_id'] = $filter_salesrep_id;
		$data['sort'] = $sort;
		$data['order'] = $order;

		$data['header'] = $this->load->controller('common/header');
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['footer'] = $this->load->controller('common/footer');

		$this->response->setOutput($this->load->view('replogic/salesrep_info_visits', $data));
	}
	
	public function visitsView() {
		
		$this->load->language('replogic/location_management');
		$this->load->language('replogic/salesrep_info');
		$this->document->setTitle($this->language->get('heading_title'));
		$this->load->model('replogic/location_management');
		
		
		$data['heading_title'] = $this->language->get('heading_title');
		
		$data['text_form'] = 'View Check In';
		$data['text_select_all'] = $this->language->get('text_select_all');
		$data['text_unselect_all'] = $this->language->get('text_unselect_all');

		$data['entry_name'] = $this->language->get('entry_name');
		$data['entry_appointment_description'] = $this->language->get('entry_appointment_description');
		$data['entry_appointment_date'] = $this->language->get('entry_appointment_date');
		$data['entry_customer'] = $this->language->get('entry_customer');
		
		$data['entry_sales'] = $this->language->get('entry_sales');
		$data['entry_access'] = $this->language->get('entry_access');
		$data['entry_modify'] = $this->language->get('entry_modify');

		$data['button_save'] = $this->language->get('button_save');
		$data['button_cancel'] = $this->language->get('button_cancel');

		if (isset($this->error['warning'])) {
			$data['error_warning'] = $this->error['warning'];
		} else {
			$data['error_warning'] = '';
		}

		$url = '';
		
		if (isset($this->request->get['type'])) {
			$url .= '&type=' . $this->request->get['type'];
		}
		
		if (isset($this->request->get['salesrep_id'])) {
			$url .= '&salesrep_id=' . $this->request->get['salesrep_id'];
		}
		
		if (isset($this->request->get['filter_appointment_name'])) {
			$url .= '&filter_appointment_name=' . urlencode(html_entity_decode($this->request->get['filter_appointment_name'], ENT_QUOTES, 'UTF-8'));
		}

		if (isset($this->request->get['filter_customer_id'])) {
			$url .= '&filter_customer_id=' . $this->request->get['filter_customer_id'];
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
			'href' => $this->url->link('common/dashboard', 'token=' . $this->session->data['token'], true)
		);
		
		$data['breadcrumbs'][] = array(
			'text' => 'Sales Rep Management',
			'href' => $this->url->link('replogic/sales_rep_management', 'token=' . $this->session->data['token'] . $url, true)
		);
		
		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('breadcrum_title'),
			'href' => $this->url->link('replogic/salesrep_info', 'token=' . $this->session->data['token'] . $url, true)
		);

		
		$data['cancel'] = $this->url->link('replogic/salesrep_info', 'token=' . $this->session->data['token'] . $url, true);

		$this->load->model('customer/customer');
		$this->load->model('replogic/sales_rep_management');
		$this->load->model('replogic/schedule_management');
		
		$checkin_info = $this->model_replogic_location_management->getLocation($this->request->get['checkin_id']);
			
		$salesrepinfo = $this->model_replogic_sales_rep_management->getsalesrep($checkin_info['salesrep_id']);
		$data['vsalesrepname'] = $salesrepinfo['salesrep_name']." ".$salesrepinfo['salesrep_lastname'];
		
		$customerinfo = $this->model_customer_customer->getCustomer($checkin_info['salesrep_id']);
		$data['customername'] = $customerinfo['firstname']." ".$customerinfo['lastname'];
		
		$appointmentinfo = $this->model_replogic_schedule_management->getappointment($checkin_info['appointment_id']);
		$data['appointmentname'] = $appointmentinfo['appointment_name'];
		
		$data['location'] = $checkin_info['location'];
		
		$start1 = strtotime($checkin_info['start']);
		$start = date("d-m-Y g:i A", $start1);
		$data['start'] = $start;
		
		$end1 = strtotime($checkin_info['end']);
		$end = date("d-m-Y g:i A", $end1);
		$data['end'] = $end;
		
		$checkin1 = strtotime($checkin_info['checkin']);
		$checkin = date("d-m-Y g:i A", $checkin1);
		$data['checkin'] = $checkin;
		
		$data['checkin_location'] = $checkin_info['checkin_location'];
		$checkout1 = strtotime($checkin_info['checkout']);
		$checkout = date("d-m-Y g:i A", $checkout1);
		$data['checkout'] = $checkout;
		
		$data['remarks'] = $checkin_info['remarks'];
		

		$data['header'] = $this->load->controller('common/header');
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['footer'] = $this->load->controller('common/footer');

		$this->response->setOutput($this->load->view('replogic/salesrep_info_visits_view', $data));
	}
	
	public function dateDiff($time1, $time2, $precision = 6) {
        // If not numeric then convert texts to unix timestamps
	if (!is_int($time1)) {
	    $time1 = strtotime($time1);
	}
	if (!is_int($time2)) {
	    $time2 = strtotime($time2);
	}
	 
	// If time1 is bigger than time2
	// Then swap time1 and time2
	if ($time1 > $time2) {
	    $ttime = $time1;
	    $time1 = $time2;
	    $time2 = $ttime;
	}
	
	// Set up intervals and diffs arrays
	$intervals = array('year','month','day','hour','minute','second');
	$diffs = array();

	// Loop thru all intervals
	foreach ($intervals as $interval) {
	    // Set default diff to 0
	    $diffs[$interval] = 0;
	    // Create temp time from time1 and interval
	    $ttime = strtotime("+1 " . $interval, $time1);
	    
            // Loop until temp time is smaller than time2
	    while ($time2 >= $ttime) {
	        $time1 = $ttime;
		$diffs[$interval]++;
		// Create new temp time from time1 and interval
		$ttime = strtotime("+1 " . $interval, $time1);
	    }
	}

	$count = 0;
	$times = array();
	// Loop thru all diffs
	foreach ($diffs as $interval => $value) {
	    // Break if we have needed precission
	    if ($count >= $precision) {
	        break;
	    }
	    // Add value and interval 
	    // if value is bigger than 0
	    if ($value > 0) {
	        // Add s if value is not 1
		if ($value != 1) {
		    $interval .= "s";
		}
		// Add value and interval to times array
		$times[] = $value . " " . $interval;
		$count++;
	    }
	}

	// Return string with times
	return implode(", ", $times);
    }
	
	public function getHowLongAgo($date, $display = array('Year', 'Month', 'Day', 'Hour', 'Minute', 'Second'), $ago = '') {
        date_default_timezone_set('Australia/Sydney');
        $timestamp = strtotime($date);
        $timestamp = (int) $timestamp;
        $current_time = time();
        $diff = $current_time - $timestamp;

        //intervals in seconds
        $intervals = array(
            'year' => 31556926, 'month' => 2629744, 'week' => 604800, 'day' => 86400, 'hour' => 3600, 'minute' => 60
        );

        //now we just find the difference
        if ($diff == 0) {
            return ' Just now ';
        }

        if ($diff < 60) {
            return $diff == 1 ? $diff . ' second ago ' : $diff . ' seconds ago ';
        }

        if ($diff >= 60 && $diff < $intervals['hour']) {
            $diff = floor($diff / $intervals['minute']);
            return $diff == 1 ? $diff . ' minute ago ' : $diff . ' minutes ago ';
        }

        if ($diff >= $intervals['hour'] && $diff < $intervals['day']) {
            $diff = floor($diff / $intervals['hour']);
            return $diff == 1 ? $diff . ' hour ago ' : $diff . ' hours ago ';
        }

        if ($diff >= $intervals['day'] && $diff < $intervals['week']) {
            $diff = floor($diff / $intervals['day']);
            return $diff == 1 ? $diff . ' day ago ' : $diff . ' days ago ';
        }

        if ($diff >= $intervals['week'] && $diff < $intervals['month']) {
            $diff = floor($diff / $intervals['week']);
            return $diff == 1 ? $diff . ' week ago ' : $diff . ' weeks ago ';
        }

        if ($diff >= $intervals['month'] && $diff < $intervals['year']) {
            $diff = floor($diff / $intervals['month']);
            return $diff == 1 ? $diff . ' month ago ' : $diff . ' months ago ';
        }

        if ($diff >= $intervals['year']) {
            $diff = floor($diff / $intervals['year']);
            return $diff == 1 ? $diff . ' year ago ' : $diff . ' years ago ';
        }
    }
	
	
}