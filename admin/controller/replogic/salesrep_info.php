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
		
		$time = strtotime($result['appointment_date']);
		$myFormatForView = date("d-m-Y g:i A", $time); 
			
		$data['schedule_managements'][] = array(
				'appointment_id' => $result['appointment_id'],
				'appointment_name'          => $result['appointment_name'],
				'sales_manager'          => $sales_rep,
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
	   $data['customers'] = $this->model_customer_customer->getCustomers(); ;
	
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
		
		if (isset($this->request->get['filter_name'])) {
			$filter_name = $this->request->get['filter_name'];
		} else {
			$filter_name = null;
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
		
		if (isset($this->request->get['filter_name'])) {
			$url .= '&filter_name=' . urlencode(html_entity_decode($this->request->get['filter_name'], ENT_QUOTES, 'UTF-8'));
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
			'filter_name'              => $filter_name,
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
				'view'          => 'javascript:void()',
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
		
		if (isset($this->request->get['filter_name'])) {
			$url .= '&filter_name=' . urlencode(html_entity_decode($this->request->get['filter_name'], ENT_QUOTES, 'UTF-8'));
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
		
		if (isset($this->request->get['filter_name'])) {
			$url .= '&filter_name=' . urlencode(html_entity_decode($this->request->get['filter_name'], ENT_QUOTES, 'UTF-8'));
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

		$data['filter_name'] = $filter_name;
		$data['filter_customer_group_id'] = $filter_customer_group_id;
		$data['filter_date_added'] = $filter_date_added;

		$this->load->model('customer/customer_group');

		$data['customer_groups'] = $this->model_customer_customer_group->getCustomerGroups();

		$this->load->model('setting/store');

		$data['stores'] = $this->model_setting_store->getStores();

		$data['sort'] = $sort;
		$data['order'] = $order;

		$data['header'] = $this->load->controller('common/header');
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['footer'] = $this->load->controller('common/footer');

		$this->response->setOutput($this->load->view('replogic/salesrep_info_customers', $data));
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

		if (isset($this->request->get['filter_customer'])) {
			$filter_customer = $this->request->get['filter_customer'];
		} else {
			$filter_customer = null;
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

		if (isset($this->request->get['filter_customer'])) {
			$url .= '&filter_customer=' . urlencode(html_entity_decode($this->request->get['filter_customer'], ENT_QUOTES, 'UTF-8'));
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
			'filter_customer'	   => $filter_customer,
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
				'view'          => $this->url->link('sale/order/info', 'token=' . $this->session->data['token'] . '&type=orders&csalesrep_id='.$salesrep_id.'&order_id=' . $result['order_id'] . $url, true),
				'edit'           => $this->url->link('sale/order/edit', 'token=' . $this->session->data['token'] . '&type=orders&csalesrep_id='.$salesrep_id.'&order_id=' . $result['order_id']. $url, true)
			);
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

		if (isset($this->request->get['filter_customer'])) {
			$url .= '&filter_customer=' . urlencode(html_entity_decode($this->request->get['filter_customer'], ENT_QUOTES, 'UTF-8'));
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

		if (isset($this->request->get['filter_customer'])) {
			$url .= '&filter_customer=' . urlencode(html_entity_decode($this->request->get['filter_customer'], ENT_QUOTES, 'UTF-8'));
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
		$data['filter_customer'] = $filter_customer;
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
		
		if (isset($this->request->get['filter_quote_id'])) {
			$filter_quote_id = $this->request->get['filter_quote_id'];
		} else {
			$filter_quote_id = null;
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
		//print_r($current_user_group); exit;
		if($current_user_group['name'] == 'Company admin' || $current_user_group['name'] == 'Administrator')
		{
			$data['delete'] = $this->url->link('replogic/order_quotes/delete', 'token=' . $this->session->data['token'], true);
		}
		else
		{ 
			$data['delete'] = '';
			
		}

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
				$view_button = $this->url->link('replogic/order_quotes/info', 'quote_id='.$result['quote_id'].'&token=' . $this->session->data['token'] . $url, true);
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

		if (isset($this->request->get['filter_customer'])) {
			$url .= '&filter_customer=' . urlencode(html_entity_decode($this->request->get['filter_customer'], ENT_QUOTES, 'UTF-8'));
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

		if (isset($this->request->get['filter_customer'])) {
			$url .= '&filter_customer=' . urlencode(html_entity_decode($this->request->get['filter_customer'], ENT_QUOTES, 'UTF-8'));
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
		$data['filter_customer'] = $filter_customer;
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

	
}