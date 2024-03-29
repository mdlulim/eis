<?php
class ControllerCustomerCustomerInfo extends Controller {
	private $error = array();

	public function index() { 
		$this->load->language('customer/customer_info');

		$this->document->setTitle($this->language->get('heading_title'));

		/*==================================
		=       Add Files (Includes)       =
		==================================*/

		# stylesheets (CSS) files
		$this->document->addStyle('view/javascript/bootstrap-sweetalert/sweetalert.css');
		$this->document->addStyle('view/stylesheet/custom.css');

		# javascript (JS) files
		$this->document->addScript('view/javascript/bootstrap-sweetalert/sweetalert.min.js');
		$this->document->addScript('view/javascript/bootstrap-sweetalert/sweetalert-data.js');
		$this->document->addScript('view/javascript/jquery-validation/dist/jquery.validate.min.js');
		$this->document->addScript('view/javascript/customer.js');

		/*=====  End of Add Files (Includes)  ======*/

		$this->load->model('replogic/sales_rep_management');

		// if AJAX | POST, send customer invitation
		if ($this->request->server['REQUEST_METHOD'] == 'POST') {
			if (isset($this->request->post['ajax'])) {
				if (isset($this->request->post['action'])) {
					switch ($this->request->post['action']) {
						case 'send_invitation':
							$this->sendCustomerInvitation();
							break;
					}
				}
			}
		}
		
		if($this->request->get['type'] == 'quotes')
		{
			$this->getQuotesTab();
		}
		else if($this->request->get['type'] == 'customercontact')
		{ 
			//$this->getCustomercontactTab();   // This method to get all customer contact using customer id
			$this->getCustomercontactFormTab();
		}
		else if($this->request->get['type'] == 'appointment')
		{
			$this->getAppointmentTab();
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
		else if($this->request->get['type'] == 'history')
		{
			$this->getHistoryTab();
		}
		else if($this->request->get['type'] == 'transactions')
		{
			$this->getTransactionsTab();
		}
		else if($this->request->get['type'] == 'rewardpoints')
		{
			$this->getRewardpointsTab();
		}
		else if($this->request->get['type'] == 'ipaddresses')
		{
			$this->getIpaddressesTab();
		}
	}
	
	public function customercontact()
	{
		//print_r($_POST); exit;
		//echo "123"; exit;
		
		$this->load->language('customer/customer');
		$this->load->model('replogic/customer_contact');
		$this->load->model('customer/customer');
		$this->load->language('replogic/customer_contact');
		$this->load->language('customer/customer_info');
		
		$this->document->setTitle($this->language->get('heading_title'));

		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateCustomercontactForm()) {
			
			$this->model_replogic_customer_contact->addMultiCustomercontact($this->request->post);
			
			$this->session->data['success'] = $this->language->get('text_success');
			$customer_id = $this->request->post['customer_id'];
			
			$this->response->redirect($this->url->link('customer/customer_info', 'type=customercontact&customer_id=' . $customer_id .'&token=' . $this->session->data['token'], true));
		}
		
		
		$customer_id = $this->request->get['customer_id'];
		$customerdetails = $this->model_customer_customer->getCustomer($customer_id);
		$data['customername'] = $customerdetails['firstname'];
		$data['customer_id'] = $customer_id;
		
		$url = '';

		if (isset($this->request->get['type'])) {
			$url .= '&type=' . $this->request->get['type'];
		}
		
		if (isset($this->request->get['customer_id'])) {
			$url .= '&customer_id=' . $this->request->get['customer_id'];
		}

		$data['breadcrumbs'] = array();

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('text_home'),
			'href' => $this->url->link(getDashboard($this->user), 'token=' . $this->session->data['token'], true)
		);

		$data['breadcrumbs'][] = array(
			'text' => 'Customer Management',
			'href' => $this->url->link('customer/customer', 'token=' . $this->session->data['token'] . $url, true)
		);
		
		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('breadcrum_title'),
			'href' => $this->url->link('customer/customer_info', 'token=' . $this->session->data['token'] . $url, true)
		);

		if (isset($this->request->get['csalesrep_id'])) 
		{
			$data['cancel'] = $this->url->link('replogic/salesrep_info', 'type=customers&salesrep_id='.$this->request->get['csalesrep_id'].'&token=' . $this->session->data['token'], true);
		}
		else
		{
			$data['cancel'] = $this->url->link('customer/customer', 'token=' . $this->session->data['token'] . $url, true);
		}
		
		$data['action'] = $this->url->link('customer/customer_info/customercontact', 'token=' . $this->session->data['token'] . $url, true);
		
		$data['generaltab'] = $this->url->link('customer/customer_info', 'type=general&customer_id=' . $customer_id .'&token=' . $this->session->data['token'], true);
		$data['appointmenttab'] = $this->url->link('customer/customer_info', 'type=appointment&customer_id=' . $customer_id .'&token=' . $this->session->data['token'], true);
		$data['customerstab'] = $this->url->link('customer/customer_info', 'type=customercontact&customer_id=' . $customer_id .'&token=' . $this->session->data['token'], true);
		$data['visitstab'] = $this->url->link('customer/customer_info', 'type=visits&customer_id=' . $customer_id .'&token=' . $this->session->data['token'], true);
		$data['orderstab'] = $this->url->link('customer/customer_info', 'type=orders&customer_id=' . $customer_id .'&token=' . $this->session->data['token'], true);
		$data['quotestab'] = $this->url->link('customer/customer_info', 'type=quotes&customer_id=' . $customer_id .'&token=' . $this->session->data['token'], true);
		$data['historytab'] = $this->url->link('customer/customer_info', 'type=history&customer_id=' . $customer_id .'&token=' . $this->session->data['token'], true);
		$data['transactionstab'] = $this->url->link('customer/customer_info', 'type=transactions&customer_id=' . $customer_id .'&token=' . $this->session->data['token'], true);
		$data['rewardpointstab'] = $this->url->link('customer/customer_info', 'type=rewardpoints&customer_id=' . $customer_id .'&token=' . $this->session->data['token'], true);
		$data['ipaddressestab'] = $this->url->link('customer/customer_info', 'type=ipaddresses&customer_id=' . $customer_id .'&token=' . $this->session->data['token'], true);

		$data['customer_contacts'] = array();

		$filter_data = array(
			'filter_customer_id' => $customer_id
		);

		$customer_contact_total = $this->model_replogic_customer_contact->getTotalCustomercontact($filter_data);

		$data['customer_contacts'] = $this->model_replogic_customer_contact->getcustomercontacts($filter_data);
		 
		$data['customers'] = $this->model_customer_customer->getCustomers($filter_data, $allaccess = true, $this->session->data['user_id']);
		$data['allcustomer_contacts'] = $this->model_replogic_customer_contact->getcustomercontacts($filter_data = array('filter_customer_id' => $customer_id));
		
		$data['heading_title'] = $this->language->get('heading_title');
		
		$data['text_list'] = $this->language->get('text_list');
		$data['text_no_results'] = $this->language->get('text_no_results');
		$data['text_confirm'] = $this->language->get('text_confirm');

		$data['entry_first_name'] = $this->language->get('entry_first_name');
		$data['entry_last_name'] = $this->language->get('entry_last_name');
		$data['entry_email'] = $this->language->get('entry_email');
		$data['entry_cellphone_number'] = $this->language->get('entry_cellphone_number');
		$data['entry_telephone_number'] = $this->language->get('entry_telephone_number');
		$data['entry_customer'] = $this->language->get('entry_customer');
		$data['entry_role'] = $this->language->get('entry_role');
		
		$data['entry_access'] = $this->language->get('entry_access');
		$data['entry_modify'] = $this->language->get('entry_modify');

		$data['button_cancel'] = $this->language->get('button_cancel');
		
		$data['token'] = $this->session->data['token'];

		if (isset($this->error['warning'])) {
			$data['error_warning'] = $this->error['warning'];
		} else {
			$data['error_warning'] = '';
		}
		
		if (isset($this->error['customer_contact'])) {
			$data['error_customer_contact'] = $this->error['customer_contact'];
		} else {
			$data['error_address'] = array();
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
		
		if (isset($this->request->get['customer_id'])) {
			$url .= '&customer_id=' . $this->request->get['customer_id'];
		}

		if (isset($this->request->post['customer_contact'])) {
			$data['customer_contacts'] = $this->request->post['customer_contact'];
		} elseif (isset($this->request->get['customer_id'])) { 
			$data['customer_contacts'] = $this->model_replogic_customer_contact->getcustomercontacts($filter_data);
		} else {
			$data['customer_contacts'] = array();
		}
		//print_r($data['customer_contacts']); exit;
		$data['filter_customer_contact_id'] = $filter_customer_contact_id;
		$data['filter_email'] = $filter_email;
		$data['sort'] = $sort;
		$data['order'] = $order;

		$data['header'] = $this->load->controller('common/header');
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['footer'] = $this->load->controller('common/footer');

		$this->response->setOutput($this->load->view('customer/customer_info_contactform', $data));
		
	}
	
	public function validateCustomercontactForm()
	{
		if (isset($this->request->post['customer_contact'])) {
			foreach ($this->request->post['customer_contact'] as $key => $value) {
				
				if ((utf8_strlen($value['first_name']) < 1) || (utf8_strlen($value['first_name']) > 128)) {
					$this->error['customer_contact'][$key]['first_name'] = $this->language->get('error_first_name');
				}
				
				if ((utf8_strlen($value['last_name']) < 1) || (utf8_strlen($value['last_name']) > 128)) {
					$this->error['customer_contact'][$key]['last_name'] = $this->language->get('error_last_name');
				}
				
				if ((utf8_strlen($value['email']) > 96) || !filter_var($value['email'], FILTER_VALIDATE_EMAIL)) {
					$this->error['customer_contact'][$key]['email'] = $this->language->get('error_email');
				}
				
				if(!empty($value['telephone_number']))
				{
					if( !preg_match("/^[0-9]{3}[0-9]{3}[0-9]{4}$/i", $value['telephone_number']) ) {
						$this->error['customer_contact'][$key]['telephone_number'] = $this->language->get('error_telephone_number');
					}
				}
				
				if(!empty($value['cellphone_number']))
				{
					if( !preg_match("/^[0-9]{3}[0-9]{3}[0-9]{4}$/i", $value['cellphone_number']) ) {
						$this->error['customer_contact'][$key]['cellphone_number'] = $this->language->get('error_cellphone_number');
					}	
				}
				
				/*if ((utf8_strlen($value['telephone_number']) < 1) || (utf8_strlen($value['telephone_number']) > 128)) {
					$this->error['customer_contact'][$key]['telephone_number'] = $this->language->get('error_telephone_number');
				}
				if ((utf8_strlen($value['cellphone_number']) < 1) || (utf8_strlen($value['cellphone_number']) > 128)) {
					$this->error['customer_contact'][$key]['cellphone_number'] = $this->language->get('error_cellphone_number');
				}*/
			}
		}

		if ($this->error && !isset($this->error['warning'])) {
			$this->error['warning'] = $this->language->get('error_warning');
		}

		return !$this->error;
	}
	
	public function getGeneralTab() { 
		
		$this->load->language('customer/customer');
		$this->load->language('customer/customer_info');
		$this->load->model('customer/customer');
		
		$customer_id = $this->request->get['customer_id'];
		$customerdetails = $this->model_customer_customer->getCustomer($customer_id);
		$data['customername'] = $customerdetails['firstname'];
		$data['customer_id'] = $customer_id;
		$data['invited'] = $customerdetails['invited'];
		
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
		$data['text_list'] = $this->language->get('text_list');

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

		$url = '';

		if (isset($this->request->get['type'])) {
			$url .= '&type=' . $this->request->get['type'];
		}
		
		if (isset($this->request->get['customer_id'])) {
			$url .= '&customer_id=' . $this->request->get['customer_id'];
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
			'href' => $this->url->link(getDashboard($this->user), 'token=' . $this->session->data['token'], true)
		);

		$data['breadcrumbs'][] = array(
			'text' => 'Customer Management',
			'href' => $this->url->link('customer/customer', 'token=' . $this->session->data['token'] . $url, true)
		);

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('breadcrum_title'),
			'href' => $this->url->link('customer/customer_info', 'token=' . $this->session->data['token'] . $url, true)
		);
		
		if (isset($this->request->get['csalesrep_id'])) 
		{
			$data['cancel'] = $this->url->link('replogic/salesrep_info', 'type=customers&salesrep_id='.$this->request->get['csalesrep_id'].'&token=' . $this->session->data['token'], true);
		}
		else
		{
			$data['cancel'] = $this->url->link('customer/customer', 'token=' . $this->session->data['token'] . $url, true);
		}
		
		$data['editurl'] = $this->url->link('customer/customer/edit', 'token=' . $this->session->data['token'] . $url, true);
		
		$data['generaltab'] = $this->url->link('customer/customer_info', 'type=general&customer_id=' . $customer_id .'&token=' . $this->session->data['token'], true);
		$data['appointmenttab'] = $this->url->link('customer/customer_info', 'type=appointment&customer_id=' . $customer_id .'&token=' . $this->session->data['token'], true);
		$data['customerstab'] = $this->url->link('customer/customer_info', 'type=customercontact&customer_id=' . $customer_id .'&token=' . $this->session->data['token'], true);
		$data['visitstab'] = $this->url->link('customer/customer_info', 'type=visits&customer_id=' . $customer_id .'&token=' . $this->session->data['token'], true);
		$data['orderstab'] = $this->url->link('customer/customer_info', 'type=orders&customer_id=' . $customer_id .'&token=' . $this->session->data['token'], true);
		$data['quotestab'] = $this->url->link('customer/customer_info', 'type=quotes&customer_id=' . $customer_id .'&token=' . $this->session->data['token'], true);
		$data['historytab'] = $this->url->link('customer/customer_info', 'type=history&customer_id=' . $customer_id .'&token=' . $this->session->data['token'], true);
		$data['transactionstab'] = $this->url->link('customer/customer_info', 'type=transactions&customer_id=' . $customer_id .'&token=' . $this->session->data['token'], true);
		$data['rewardpointstab'] = $this->url->link('customer/customer_info', 'type=rewardpoints&customer_id=' . $customer_id .'&token=' . $this->session->data['token'], true);
		$data['ipaddressestab'] = $this->url->link('customer/customer_info', 'type=ipaddresses&customer_id=' . $customer_id .'&token=' . $this->session->data['token'], true);
		

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

		if (isset($this->request->post['salesrep_id'])) {
			$data['salesrep_id'] = $this->request->post['salesrep_id'];
		} elseif (!empty($customer_info)) {
			$data['salesrep_id'] = $customer_info['salesrep_id'];
		}
		else {
			$data['salesrep_id'] = '';
		}
		
		$this->load->model('replogic/sales_rep_management');
		
		if (isset($this->request->post['team_id'])) {
			$data['team_id'] = $this->request->post['team_id'];
		} else {
			if($customer_info['salesrep_id'])
			{
				$salesrepbyid = $this->model_replogic_sales_rep_management->getsalesrep($customer_info['salesrep_id']);
				$data['team_id'] = $salesrepbyid['sales_team_id'];
			}
			else
			{
				$data['team_id'] = '';
			}
		}
		
		$this->load->model('user/team');
		$data['teams'] = $this->model_user_team->getTeams();
		
		$data['salesreps'] = '';
		if($data['team_id'])
		{
			$data['salesreps'] = $this->model_replogic_sales_rep_management->getSalesRepByTeam($data['team_id']);
		}
		
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
		
		if (isset($this->request->post['payment_method'])) {
			$data['payment_method'] = $this->request->post['payment_method'];
		} elseif (!empty($customer_info)) {
			$data['payment_method'] = $customer_info['payment_method'];
		} else {
			$data['payment_method'] = '';
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

		$this->response->setOutput($this->load->view('customer/customer_info', $data));
	}
	
	protected function getAppointmentTab() {

		$this->document->addStyle('view/stylesheet/custom.css');
		
		$this->load->model('customer/customer');
		$this->load->model('replogic/schedule_management');
		$this->load->language('customer/customer');
		$this->load->language('customer/customer_info');
		
		$customer_id = $this->request->get['customer_id'];
		$customerdetails = $this->model_customer_customer->getCustomer($customer_id);
		$data['customername'] = $customerdetails['firstname'];
		
		if (isset($this->request->get['filter_appointment_name'])) {
			$filter_appointment_name = $this->request->get['filter_appointment_name'];
		} else {
			$filter_appointment_name = null;
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

		if (isset($this->request->get['type'])) {
			$url .= '&type=' . $this->request->get['type'];
		}
		
		if (isset($this->request->get['customer_id'])) {
			$url .= '&customer_id=' . $this->request->get['customer_id'];
		}
		
		if (isset($this->request->get['filter_appointment_name'])) {
			$url .= '&filter_appointment_name=' . urlencode(html_entity_decode($this->request->get['filter_appointment_name'], ENT_QUOTES, 'UTF-8'));
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
		
		$customer_id = $this->request->get['customer_id'];
		$data['customer_id'] = $customer_id;
		$customerdetails = $this->model_customer_customer->getCustomer($customer_id);
		$data['customername'] = $customerdetails['firstname'];
		
		$data['breadcrumbs'] = array();

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('text_home'),
			'href' => $this->url->link(getDashboard($this->user), 'token=' . $this->session->data['token'], true)
		);
		
		$data['breadcrumbs'][] = array(
			'text' => 'Sales Rep Management',
			'href' => $this->url->link('customer/customer', 'token=' . $this->session->data['token'] . $url, true)
		);

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('breadcrum_title'),
			'href' => $this->url->link('customer/customer_info', 'token=' . $this->session->data['token'] . $url, true)
		);

		$data['cancel'] = $this->url->link('replogic/sales_rep_management', 'token=' . $this->session->data['token'], true);
		
		$data['generaltab'] = $this->url->link('customer/customer_info', 'type=general&customer_id=' . $customer_id .'&token=' . $this->session->data['token'], true);
		$data['appointmenttab'] = $this->url->link('customer/customer_info', 'type=appointment&customer_id=' . $customer_id .'&token=' . $this->session->data['token'], true);
		$data['customerstab'] = $this->url->link('customer/customer_info', 'type=customercontact&customer_id=' . $customer_id .'&token=' . $this->session->data['token'], true);
		$data['visitstab'] = $this->url->link('customer/customer_info', 'type=visits&customer_id=' . $customer_id .'&token=' . $this->session->data['token'], true);
		$data['orderstab'] = $this->url->link('customer/customer_info', 'type=orders&customer_id=' . $customer_id .'&token=' . $this->session->data['token'], true);
		$data['quotestab'] = $this->url->link('customer/customer_info', 'type=quotes&customer_id=' . $customer_id .'&token=' . $this->session->data['token'], true);
		$data['historytab'] = $this->url->link('customer/customer_info', 'type=history&customer_id=' . $customer_id .'&token=' . $this->session->data['token'], true);
		$data['transactionstab'] = $this->url->link('customer/customer_info', 'type=transactions&customer_id=' . $customer_id .'&token=' . $this->session->data['token'], true);
		$data['rewardpointstab'] = $this->url->link('customer/customer_info', 'type=rewardpoints&customer_id=' . $customer_id .'&token=' . $this->session->data['token'], true);
		$data['ipaddressestab'] = $this->url->link('customer/customer_info', 'type=ipaddresses&customer_id=' . $customer_id .'&token=' . $this->session->data['token'], true);

		$data['appointments'] = array();

		$filter_data = array(
			'filter_appointment_name'	  => $filter_appointment_name,
			'filter_customer_id'  => $customer_id,
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
			
			# appointment date
			$appointmentDate = date("D d M Y", strtotime($result['appointment_date'])); 
			$appointmentDate.= " at " . date("<b>g:i A</b>", strtotime($result['appointment_date']));

			# visit date
			$visitDate = (!empty($result['checkin']) && $result['checkin']<>"") ? date("D d M Y", strtotime($result['checkin'])) : "";
			$visitDate.= (!empty($result['checkin']) && $result['checkin']<>"") ? " at " . date("<b>g:i A</b>", strtotime($result['checkin'])) : "";
			
			$data['appointments'][] = array(
				'appointment_id'   => $result['appointment_id'],
				'appointment_name' => $result['appointment_name'],
				'appointment_type' => $result['type'],
				'salesrep_name'    => $result['salesrepname'],
				'appointment_date' => $appointmentDate,
				'visit_date'       => $visitDate,
				'tasks'            => $this->url->link('replogic/tasks', 'token=' . $this->session->data['token'] . '&appointment_id=' . $result['appointment_id'] . $url, true),
				'notes'            => $this->url->link('replogic/notes', 'token=' . $this->session->data['token'] . '&appointment_id=' . $result['appointment_id'] . $url, true),
				'view'             => $this->url->link('replogic/schedule_management/view', 'token=' . $this->session->data['token'] . '&appointment_id=' . $result['appointment_id'] . $url, true),
				'edit'             => $this->url->link('customer/customer_info/appointmentView', 'token=' . $this->session->data['token'] . '&appointment_id=' . $result['appointment_id'] . $url, true)
			);
		}
		
		$this->load->model('user/user_group');
		$this->load->model('user/user');
		$this->load->model('customer/customer');
		$user_group_id = $this->model_user_user_group->getUserGroupByName('Sales Manager');
		$data['sales_managers'] = $this->model_user_user->getUsersByGroupId($user_group_id['user_group_id']);
		
		$data['customers'] = $this->model_customer_customer->getCustomers($data, $allaccess = true ,$this->session->data['user_id']);
		
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
		
		if (isset($this->request->get['customer_id'])) {
			$url .= '&customer_id=' . $this->request->get['customer_id'];
		}
		
		if (isset($this->request->get['filter_appointment_name'])) {
			$url .= '&filter_appointment_name=' . urlencode(html_entity_decode($this->request->get['filter_appointment_name'], ENT_QUOTES, 'UTF-8'));
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

		$data['sort_name'] = $this->url->link('customer/customer_info', 'token=' . $this->session->data['token'] . '&sort=appointment_name' . $url, true);
		$data['sort_appointment_date'] = $this->url->link('customer/customer_info', 'token=' . $this->session->data['token'] . '&sort=appointment_date' . $url, true);
		$data['sort_type'] = $this->url->link('customer/customer_info', 'token=' . $this->session->data['token'] . '&sort=type' . $url, true);
		$data['sort_salesrepname'] = $this->url->link('customer/customer_info', 'token=' . $this->session->data['token'] . '&sort=salesrepname' . $url, true);

		$url = '';
		
		if (isset($this->request->get['type'])) {
			$url .= '&type=' . $this->request->get['type'];
		}
		
		if (isset($this->request->get['customer_id'])) {
			$url .= '&customer_id=' . $this->request->get['customer_id'];
		}
		
		if (isset($this->request->get['filter_appointment_name'])) {
			$url .= '&filter_appointment_name=' . urlencode(html_entity_decode($this->request->get['filter_appointment_name'], ENT_QUOTES, 'UTF-8'));
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
		$pagination->url = $this->url->link('customer/customer_info', 'token=' . $this->session->data['token'] . $url . '&page={page}', true);

		$data['pagination'] = $pagination->render();

		$data['results'] = sprintf($this->language->get('text_pagination'), ($schedule_management_total) ? (($page - 1) * $this->config->get('config_limit_admin')) + 1 : 0, ((($page - 1) * $this->config->get('config_limit_admin')) > ($schedule_management_total - $this->config->get('config_limit_admin'))) ? $schedule_management_total : ((($page - 1) * $this->config->get('config_limit_admin')) + $this->config->get('config_limit_admin')), $schedule_management_total, ceil($schedule_management_total / $this->config->get('config_limit_admin')));

		$data['filter_appointment_name'] = $filter_appointment_name;
		$data['filter_appointment_from'] = $filter_appointment_from;
		$data['filter_appointment_to'] = $filter_appointment_to;
		$data['filter_salesrep_id'] = $filter_salesrep_id;
		$data['sort'] = $sort;
		$data['order'] = $order;

		$data['header'] = $this->load->controller('common/header');
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['footer'] = $this->load->controller('common/footer');

		$this->response->setOutput($this->load->view('customer/customer_info_appointment', $data));
	}
	
	public function appointmentView() {
		
		$this->load->language('replogic/schedule_management');
		$this->load->language('customer/customer_info');
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
		
		if (isset($this->request->get['customer_id'])) {
			$url .= '&customer_id=' . $this->request->get['customer_id'];
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
			'href' => $this->url->link(getDashboard($this->user), 'token=' . $this->session->data['token'], true)
		);
		
		$data['breadcrumbs'][] = array(
			'text' => 'Customer Management',
			'href' => $this->url->link('customer/customer', 'token=' . $this->session->data['token'] . $url, true)
		);
		
		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('breadcrum_title'),
			'href' => $this->url->link('customer/customer_info', 'token=' . $this->session->data['token'] . $url, true)
		);

		
		$data['cancel'] = $this->url->link('customer/customer_info', 'token=' . $this->session->data['token'] . $url, true);
		$data['editurl'] = $this->url->link('replogic/schedule_management/edit', 'appointment_id='.$this->request->get['appointment_id'].'&token=' . $this->session->data['token'] . $url, true);

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
	   $data['customers'] = $this->model_customer_customer->getCustomers('', $allaccess ,$this->session->data['user_id']); ;
	
		$data['sales_manager'] = $appointment_info['salesrep_id'];
		
		

		$data['header'] = $this->load->controller('common/header');
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['footer'] = $this->load->controller('common/footer');

		$this->response->setOutput($this->load->view('customer/customer_info_appointment_view', $data));
	}
	
	protected function getCustomercontactTab() {
		
		$this->load->language('replogic/customer_contact');
		$this->load->language('customer/customer_info');
		$this->load->model('customer/customer');
		$this->load->model('replogic/customer_contact');
		
		$customer_id = $this->request->get['customer_id'];
		$customerdetails = $this->model_customer_customer->getCustomer($customer_id);
		$data['customername'] = $customerdetails['firstname'];
		$data['customer_id'] = $customer_id;
		
		if (isset($this->request->get['filter_customer_contact_id'])) {
			$filter_customer_contact_id = $this->request->get['filter_customer_contact_id'];
		} else {
			$filter_customer_contact_id = null;
		}

		if (isset($this->request->get['filter_email'])) {
			$filter_email = $this->request->get['filter_email'];
		} else {
			$filter_email = null;
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

		if (isset($this->request->get['sort'])) {
			$url .= '&sort=' . $this->request->get['sort'];
		}
		
		if (isset($this->request->get['type'])) {
			$url .= '&type=' . $this->request->get['type'];
		}
		
		if (isset($this->request->get['customer_id'])) {
			$url .= '&customer_id=' . $this->request->get['customer_id'];
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
			'text' => 'Customer Management',
			'href' => $this->url->link('customer/customer', 'token=' . $this->session->data['token'] . $url, true)
		);
		
		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('breadcrum_title'),
			'href' => $this->url->link('customer/customer_info', 'token=' . $this->session->data['token'] . $url, true)
		);

		if (isset($this->request->get['csalesrep_id'])) 
		{
			$data['cancel'] = $this->url->link('replogic/salesrep_info', 'type=customers&salesrep_id='.$this->request->get['csalesrep_id'].'&token=' . $this->session->data['token'], true);
		}
		else
		{
			$data['cancel'] = $this->url->link('customer/customer', 'token=' . $this->session->data['token'] . $url, true);
		}
		
		$data['generaltab'] = $this->url->link('customer/customer_info', 'type=general&customer_id=' . $customer_id .'&token=' . $this->session->data['token'], true);
		$data['appointmenttab'] = $this->url->link('customer/customer_info', 'type=appointment&customer_id=' . $customer_id .'&token=' . $this->session->data['token'], true);
		$data['customerstab'] = $this->url->link('customer/customer_info', 'type=customercontact&customer_id=' . $customer_id .'&token=' . $this->session->data['token'], true);
		$data['visitstab'] = $this->url->link('customer/customer_info', 'type=visits&customer_id=' . $customer_id .'&token=' . $this->session->data['token'], true);
		$data['orderstab'] = $this->url->link('customer/customer_info', 'type=orders&customer_id=' . $customer_id .'&token=' . $this->session->data['token'], true);
		$data['quotestab'] = $this->url->link('customer/customer_info', 'type=quotes&customer_id=' . $customer_id .'&token=' . $this->session->data['token'], true);
		$data['historytab'] = $this->url->link('customer/customer_info', 'type=history&customer_id=' . $customer_id .'&token=' . $this->session->data['token'], true);
		$data['transactionstab'] = $this->url->link('customer/customer_info', 'type=transactions&customer_id=' . $customer_id .'&token=' . $this->session->data['token'], true);
		$data['rewardpointstab'] = $this->url->link('customer/customer_info', 'type=rewardpoints&customer_id=' . $customer_id .'&token=' . $this->session->data['token'], true);
		$data['ipaddressestab'] = $this->url->link('customer/customer_info', 'type=ipaddresses&customer_id=' . $customer_id .'&token=' . $this->session->data['token'], true);

		$data['customer_contacts'] = array();

		$filter_data = array(
			'filter_customer_contact_id'	  => $filter_customer_contact_id,
			'filter_email'	  => $filter_email,
			'filter_customer_id' => $customer_id,
			'sort'  => $sort,
			'order' => $order,
			'start' => ($page - 1) * $this->config->get('config_limit_admin'),
			'limit' => $this->config->get('config_limit_admin')
		);

		$customer_contact_total = $this->model_replogic_customer_contact->getTotalCustomercontact($filter_data);

		$results = $this->model_replogic_customer_contact->getcustomercontacts($filter_data);
		
		foreach ($results as $result) {
		
	   		$data['customer_contacts'][] = array(
				'customer_con_id' => $result['customer_con_id'],
				'email' => $result['email'],
				'name'          => $result['first_name'] . '&nbsp;' . $result['last_name'],
				'view'          => $this->url->link('customer/customer_info/CustomerContactView', 'token=' . $this->session->data['token'] . '&customer_con_id=' . $result['customer_con_id'] . $url, true)
			);
		}
		
		$data['customers'] = $this->model_customer_customer->getCustomers($data, $allaccess = true ,$this->session->data['user_id']);
		$data['allcustomer_contacts'] = $this->model_replogic_customer_contact->getcustomercontacts($filter_data = array('filter_customer_id' => $customer_id));
		
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
		
		if (isset($this->request->get['filter_customer_contact_id'])) {
			$url .= '&filter_customer_contact_id=' . $this->request->get['filter_customer_contact_id'];
		}

		if (isset($this->request->get['type'])) {
			$url .= '&type=' . $this->request->get['type'];
		}
		
		if (isset($this->request->get['customer_id'])) {
			$url .= '&customer_id=' . $this->request->get['customer_id'];
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

		$data['sort_name'] = $this->url->link('customer/customer_info', 'token=' . $this->session->data['token'] . '&sort=name' . $url, true);

		$url = '';
		
		if (isset($this->request->get['filter_customer_contact_id'])) {
			$url .= '&filter_customer_contact_id=' . $this->request->get['filter_customer_contact_id'];
		}

		if (isset($this->request->get['type'])) {
			$url .= '&type=' . $this->request->get['type'];
		}
		
		if (isset($this->request->get['customer_id'])) {
			$url .= '&customer_id=' . $this->request->get['customer_id'];
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

		$pagination = new Pagination();
		$pagination->total = $customer_contact_total;
		$pagination->page = $page;
		$pagination->limit = $this->config->get('config_limit_admin');
		$pagination->url = $this->url->link('customer/customer_info', 'token=' . $this->session->data['token'] . $url . '&page={page}', true);

		$data['pagination'] = $pagination->render();

		$data['results'] = sprintf($this->language->get('text_pagination'), ($customer_contact_total) ? (($page - 1) * $this->config->get('config_limit_admin')) + 1 : 0, ((($page - 1) * $this->config->get('config_limit_admin')) > ($customer_contact_total - $this->config->get('config_limit_admin'))) ? $customer_contact_total : ((($page - 1) * $this->config->get('config_limit_admin')) + $this->config->get('config_limit_admin')), $customer_contact_total, ceil($customer_contact_total / $this->config->get('config_limit_admin')));

		$data['filter_customer_contact_id'] = $filter_customer_contact_id;
		$data['filter_email'] = $filter_email;
		$data['sort'] = $sort;
		$data['order'] = $order;

		$data['header'] = $this->load->controller('common/header');
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['footer'] = $this->load->controller('common/footer');

		$this->response->setOutput($this->load->view('customer/customer_info_contact', $data));
		}
		
	protected function getCustomercontactFormTab() { 
		
		$this->load->language('replogic/customer_contact');
		$this->load->language('customer/customer_info');
		$this->load->model('customer/customer');
		$this->load->model('replogic/customer_contact');
		
		$customer_id = $this->request->get['customer_id'];
		$customerdetails = $this->model_customer_customer->getCustomer($customer_id);
		$data['customername'] = $customerdetails['firstname'];
		$data['customer_id'] = $customer_id;
		
		$url = '';

		if (isset($this->request->get['type'])) {
			$url .= '&type=' . $this->request->get['type'];
		}
		
		if (isset($this->request->get['customer_id'])) {
			$url .= '&customer_id=' . $this->request->get['customer_id'];
		}

		$data['breadcrumbs'] = array();

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('text_home'),
			'href' => $this->url->link(getDashboard($this->user), 'token=' . $this->session->data['token'], true)
		);

		$data['breadcrumbs'][] = array(
			'text' => 'Customer Management',
			'href' => $this->url->link('customer/customer', 'token=' . $this->session->data['token'] . $url, true)
		);
		
		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('breadcrum_title'),
			'href' => $this->url->link('customer/customer_info', 'token=' . $this->session->data['token'] . $url, true)
		);

		if (isset($this->request->get['csalesrep_id'])) 
		{
			$data['cancel'] = $this->url->link('replogic/salesrep_info', 'type=customers&salesrep_id='.$this->request->get['csalesrep_id'].'&token=' . $this->session->data['token'], true);
		}
		else
		{
			$data['cancel'] = $this->url->link('customer/customer', 'token=' . $this->session->data['token'] . $url, true);
		}
		
		$data['action'] = $this->url->link('customer/customer_info/customercontact', 'token=' . $this->session->data['token'] . $url, true);
		
		$data['generaltab'] = $this->url->link('customer/customer_info', 'type=general&customer_id=' . $customer_id .'&token=' . $this->session->data['token'], true);
		$data['appointmenttab'] = $this->url->link('customer/customer_info', 'type=appointment&customer_id=' . $customer_id .'&token=' . $this->session->data['token'], true);
		$data['customerstab'] = $this->url->link('customer/customer_info', 'type=customercontact&customer_id=' . $customer_id .'&token=' . $this->session->data['token'], true);
		$data['visitstab'] = $this->url->link('customer/customer_info', 'type=visits&customer_id=' . $customer_id .'&token=' . $this->session->data['token'], true);
		$data['orderstab'] = $this->url->link('customer/customer_info', 'type=orders&customer_id=' . $customer_id .'&token=' . $this->session->data['token'], true);
		$data['quotestab'] = $this->url->link('customer/customer_info', 'type=quotes&customer_id=' . $customer_id .'&token=' . $this->session->data['token'], true);
		$data['historytab'] = $this->url->link('customer/customer_info', 'type=history&customer_id=' . $customer_id .'&token=' . $this->session->data['token'], true);
		$data['transactionstab'] = $this->url->link('customer/customer_info', 'type=transactions&customer_id=' . $customer_id .'&token=' . $this->session->data['token'], true);
		$data['rewardpointstab'] = $this->url->link('customer/customer_info', 'type=rewardpoints&customer_id=' . $customer_id .'&token=' . $this->session->data['token'], true);
		$data['ipaddressestab'] = $this->url->link('customer/customer_info', 'type=ipaddresses&customer_id=' . $customer_id .'&token=' . $this->session->data['token'], true);
		$data['customer_contacts'] = array();

		$filter_data = array(
			//'filter_customer_contact_id'	  => $filter_customer_contact_id,
			//'filter_email'	  => $filter_email,
			'filter_customer_id' => $customer_id
		);

		$customer_contact_total = $this->model_replogic_customer_contact->getTotalCustomercontact($filter_data);

		$data['customer_contacts'] = $this->model_replogic_customer_contact->getcustomercontacts($filter_data);
		 
		$data['customers'] = $this->model_customer_customer->getCustomers($filter_data, $allaccess = true ,$this->session->data['user_id']);
		$data['allcustomer_contacts'] = $this->model_replogic_customer_contact->getcustomercontacts($filter_data = array('filter_customer_id' => $customer_id));
		
		$data['heading_title'] = $this->language->get('heading_title');
		
		$data['text_list'] = $this->language->get('text_list');
		$data['text_no_results'] = $this->language->get('text_no_results');
		$data['text_confirm'] = $this->language->get('text_confirm');

		$data['entry_first_name'] = $this->language->get('entry_first_name');
		$data['entry_last_name'] = $this->language->get('entry_last_name');
		$data['entry_email'] = $this->language->get('entry_email');
		$data['entry_cellphone_number'] = $this->language->get('entry_cellphone_number');
		$data['entry_telephone_number'] = $this->language->get('entry_telephone_number');
		$data['entry_customer'] = $this->language->get('entry_customer');
		$data['entry_role'] = $this->language->get('entry_role');
		
		$data['entry_access'] = $this->language->get('entry_access');
		$data['entry_modify'] = $this->language->get('entry_modify');

		$data['button_cancel'] = $this->language->get('button_cancel');
		
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
		
		if (isset($this->request->get['customer_id'])) {
			$url .= '&customer_id=' . $this->request->get['customer_id'];
		}
		
		$data['filter_customer_contact_id'] = $filter_customer_contact_id;
		$data['filter_email'] = $filter_email;
		$data['sort'] = $sort;
		$data['order'] = $order;

		$data['header'] = $this->load->controller('common/header');
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['footer'] = $this->load->controller('common/footer');

		$this->response->setOutput($this->load->view('customer/customer_info_contactform', $data));
		}
		
	public function CustomerContactView() { 
	
		$this->load->language('replogic/customer_contact');
		$this->load->language('customer/customer_info');
		$this->load->model('customer/customer');
		$this->load->model('replogic/customer_contact');
		
		$customer_id = $this->request->get['customer_id'];
		$customerdetails = $this->model_customer_customer->getCustomer($customer_id);
		$data['customername'] = $customerdetails['firstname'];
		$data['customer_id'] = $customer_id;
		
		$this->document->setTitle($this->language->get('heading_title'));
		$data['heading_title'] = $this->language->get('heading_title');
		
		$data['text_form'] = !isset($this->request->get['customer_con_id']) ? $this->language->get('text_add') : $this->language->get('text_edit');
		$data['text_select_all'] = $this->language->get('text_select_all');
		$data['text_unselect_all'] = $this->language->get('text_unselect_all');

		$data['entry_first_name'] = $this->language->get('entry_first_name');
		$data['entry_last_name'] = $this->language->get('entry_last_name');
		$data['entry_email'] = $this->language->get('entry_email');
		$data['entry_cellphone_number'] = $this->language->get('entry_cellphone_number');
		$data['entry_telephone_number'] = $this->language->get('entry_telephone_number');
		$data['entry_customer'] = $this->language->get('entry_customer');
		$data['entry_role'] = $this->language->get('entry_role');
		
		$data['entry_access'] = $this->language->get('entry_access');
		$data['entry_modify'] = $this->language->get('entry_modify');

		$data['button_cancel'] = $this->language->get('button_cancel');

		$url = '';

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
			'text' => 'Customer Management',
			'href' => $this->url->link('customer/customer', 'token=' . $this->session->data['token'] . $url, true)
		);
		
		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('breadcrum_title'),
			'href' => $this->url->link('customer/customer_info', 'token=' . $this->session->data['token'] . $url, true)
		);

		$data['cancel'] = $this->url->link('customer/customer_info', 'token=' . $this->session->data['token'] . $url, true);
		$data['editurl'] = $this->url->link('replogic/customer_contact/edit', 'customer_con_id='.$this->request->get['customer_con_id'].'&token=' . $this->session->data['token'] . $url, true);

		if (isset($this->request->get['customer_con_id']) && $this->request->server['REQUEST_METHOD'] != 'POST') {
			$customer_contact_info = $this->model_replogic_customer_contact->getcustomercontact($this->request->get['customer_con_id']);
		}

		$data['first_name'] = $customer_contact_info['first_name']; 
		$data['last_name'] = $customer_contact_info['last_name'];
		$data['email'] = $customer_contact_info['email'];
		$data['telephone_number'] = $customer_contact_info['telephone_number'];
		$data['cellphone_number'] = $customer_contact_info['cellphone_number'];
		$data['role'] = $customer_contact_info['role'];
		$data['ccustomer_id'] = $customer_contact_info['customer_id'];
		
		$this->load->model('customer/customer');
	   $data['customers'] = $this->model_customer_customer->getCustomers('', $allaccess = true ,$this->session->data['user_id']);
		
		$data['header'] = $this->load->controller('common/header');
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['footer'] = $this->load->controller('common/footer');

		$this->response->setOutput($this->load->view('customer/customer_info_contact_view', $data));
	
	}
	
	protected function getOrdersTab() {
		
		$this->load->model('sale/order');
		$this->load->model('customer/customer');
		$this->load->model('replogic/customer_contact');
		$this->load->language('sale/order');
		$this->load->language('customer/customer_info');
		
		$customer_id = $this->request->get['customer_id'];
		$data['customer_id'] = $customer_id;
		$customerdetails = $this->model_customer_customer->getCustomer($customer_id);
		$data['customername'] = $customerdetails['firstname'];
		
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
		
		if (isset($this->request->get['customer_id'])) {
			$url .= '&customer_id=' . $this->request->get['customer_id'];
		}

		if (isset($this->request->get['filter_customer_contact_id'])) {
			$url .= '&filter_customer_contact_id=' . $this->request->get['filter_customer_contact_id'];
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
			'href' => $this->url->link(getDashboard($this->user), 'token=' . $this->session->data['token'], true)
		);

		$data['breadcrumbs'][] = array(
			'text' => 'Customer Management',
			'href' => $this->url->link('customer/customer', 'token=' . $this->session->data['token'] . $url, true)
		);
		
		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('breadcrum_title'),
			'href' => $this->url->link('customer/customer_info', 'token=' . $this->session->data['token'] . $url, true)
		);
		
		$data['cancel'] = $this->url->link('customer/customer', 'token=' . $this->session->data['token'] . $url, true);
		
		$data['generaltab'] = $this->url->link('customer/customer_info', 'type=general&customer_id=' . $customer_id .'&token=' . $this->session->data['token'], true);
		$data['appointmenttab'] = $this->url->link('customer/customer_info', 'type=appointment&customer_id=' . $customer_id .'&token=' . $this->session->data['token'], true);
		$data['customerstab'] = $this->url->link('customer/customer_info', 'type=customercontact&customer_id=' . $customer_id .'&token=' . $this->session->data['token'], true);
		$data['visitstab'] = $this->url->link('customer/customer_info', 'type=visits&customer_id=' . $customer_id .'&token=' . $this->session->data['token'], true);
		$data['orderstab'] = $this->url->link('customer/customer_info', 'type=orders&customer_id=' . $customer_id .'&token=' . $this->session->data['token'], true);
		$data['quotestab'] = $this->url->link('customer/customer_info', 'type=quotes&customer_id=' . $customer_id .'&token=' . $this->session->data['token'], true);
		$data['historytab'] = $this->url->link('customer/customer_info', 'type=history&customer_id=' . $customer_id .'&token=' . $this->session->data['token'], true);
		$data['transactionstab'] = $this->url->link('customer/customer_info', 'type=transactions&customer_id=' . $customer_id .'&token=' . $this->session->data['token'], true);
		$data['rewardpointstab'] = $this->url->link('customer/customer_info', 'type=rewardpoints&customer_id=' . $customer_id .'&token=' . $this->session->data['token'], true);
		$data['ipaddressestab'] = $this->url->link('customer/customer_info', 'type=ipaddresses&customer_id=' . $customer_id .'&token=' . $this->session->data['token'], true);
		
		
		$data['orders'] = array();

		$filter_data = array(
			'filter_order_id'            => $filter_order_id,
			'filter_salesrep_id'         => $salesrep_id,
			'filter_customer'	         => $filter_customer,
			'filter_customer_id'         => $customer_id,
			'filter_customer_contactid'  => $filter_customer_contact_id,
			'filter_order_status'        => $filter_order_status,
			'filter_total'               => $filter_total,
			'filter_date_added'          => $filter_date_added,
			'filter_date_modified'       => $filter_date_modified,
			'sort'                       => $sort,
			'order'                      => $order,
			'start'                      => ($page - 1) * $this->config->get('config_limit_admin'),
			'limit'                      => $this->config->get('config_limit_admin')
		);

		$data['customer_contacts'] = $this->model_replogic_customer_contact->getcustomercontacts(array('filter_customer_id'=>$customer_id));

		$order_total = $this->model_sale_order->getTotalOrders($filter_data);

		$results = $this->model_sale_order->getOrders($filter_data);
		$this->load->model('replogic/sales_rep_management');
		foreach ($results as $result) {
			
			$ord = $this->model_sale_order->getOrder($result['order_id']);
			$cstdetails = $this->model_customer_customer->getCustomer($ord['customer_id']);
			$salesrep = $this->model_replogic_sales_rep_management->getsalesrep($cstdetails['salesrep_id']);
			$salesrepname = $salesrep['salesrep_name'].' '.$salesrep['salesrep_lastname'];

			$time = strtotime($result['date_added']);
			$date_added = date("d F, Y g:i A", $time);
			
			$time1 = strtotime($result['date_modified']);
			$date_modified = date("d F, Y g:i A", $time1);
			
			$data['orders'][] = array(
				'order_id'        => $result['order_id'],
				'customer'        => $result['customer'],
				'customercontact' => $result['customercontact'],
				'salesrep'        => $salesrepname,
				'order_status_id' => $ord['order_status_id'],
				'order_status'    => $result['order_status'] ? $result['order_status'] : $this->language->get('text_missing'),
				'total'           => $this->currency->format($result['total'], $result['currency_code'], $result['currency_value']),
				'date_added'      => $date_added,
				'date_modified'   => $date_modified,
				'shipping_code'   => $result['shipping_code'],
				'view'            => $this->url->link('sale/order/info', 'token=' . $this->session->data['token'] . '&order_id=' . $result['order_id'] . $url, true),
				'edit'            => $this->url->link('sale/order/edit', 'token=' . $this->session->data['token'] . '&order_id=' . $result['order_id']. $url, true)
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
		
		$url = '';

		if (isset($this->request->get['type'])) {
			$url .= '&type=' . $this->request->get['type'];
		}
		
		if (isset($this->request->get['customer_id'])) {
			$url .= '&customer_id=' . $this->request->get['customer_id'];
		}
		
		if (isset($this->request->get['filter_order_id'])) {
			$url .= '&filter_order_id=' . $this->request->get['filter_order_id'];
		}

		if (isset($this->request->get['filter_customer'])) {
			$url .= '&filter_customer=' . urlencode(html_entity_decode($this->request->get['filter_customer'], ENT_QUOTES, 'UTF-8'));
		}
		
		if (isset($this->request->get['filter_customer_contact_id'])) {
			$url .= '&filter_customer_contact_id=' . $this->request->get['filter_customer_contact_id'];
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

		$data['sort_order'] = $this->url->link('customer/customer_info', 'token=' . $this->session->data['token'] . '&sort=o.order_id' . $url, true);
		$data['sort_customer'] = $this->url->link('customer/customer_info', 'token=' . $this->session->data['token'] . '&sort=customer' . $url, true);
		$data['sort_salesrep'] = $this->url->link('customer/customer_info', 'token=' . $this->session->data['token'] . '&sort=salesrep' . $url, true);
		$data['sort_status'] = $this->url->link('customer/customer_info', 'token=' . $this->session->data['token'] . '&sort=order_status' . $url, true);
		$data['sort_total'] = $this->url->link('customer/customer_info', 'token=' . $this->session->data['token'] . '&sort=o.total' . $url, true);
		$data['sort_date_added'] = $this->url->link('customer/customer_info', 'token=' . $this->session->data['token'] . '&sort=o.date_added' . $url, true);
		$data['sort_date_modified'] = $this->url->link('customer/customer_info', 'token=' . $this->session->data['token'] . '&sort=o.date_modified' . $url, true);

		$url = '';

		if (isset($this->request->get['type'])) {
			$url .= '&type=' . $this->request->get['type'];
		}
		
		if (isset($this->request->get['customer_id'])) {
			$url .= '&customer_id=' . $this->request->get['customer_id'];
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
		$pagination->url = $this->url->link('customer/customer_info', 'token=' . $this->session->data['token'] . $url . '&page={page}', true);

		$data['pagination'] = $pagination->render();

		$data['results'] = sprintf($this->language->get('text_pagination'), ($order_total) ? (($page - 1) * $this->config->get('config_limit_admin')) + 1 : 0, ((($page - 1) * $this->config->get('config_limit_admin')) > ($order_total - $this->config->get('config_limit_admin'))) ? $order_total : ((($page - 1) * $this->config->get('config_limit_admin')) + $this->config->get('config_limit_admin')), $order_total, ceil($order_total / $this->config->get('config_limit_admin')));

		$data['filter_order_id'] = $filter_order_id;
		$data['filter_customer'] = $filter_customer;
		$data['filter_customer_contact_id'] = $filter_customer_contact_id;
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

		$this->response->setOutput($this->load->view('customer/customer_info_orders', $data));
	}
	
	protected function getQuotesTab() {
		
		$this->load->model('replogic/order_quotes');
		$this->load->model('customer/customer');
		$this->load->language('replogic/order_quotes');
		$this->load->language('customer/customer_info');
		
		$customer_id = $this->request->get['customer_id'];
		$data['customer_id'] = $customer_id;
		$customerdetails = $this->model_customer_customer->getCustomer($customer_id);
		$data['customername'] = $customerdetails['firstname'];
		
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
		
		if (isset($this->request->get['customer_id'])) {
			$url .= '&customer_id=' . $this->request->get['customer_id'];
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
		
		$data['cancel'] = $this->url->link('customer/customer', 'token=' . $this->session->data['token'] . $url, true);
		
		$data['generaltab'] = $this->url->link('customer/customer_info', 'type=general&customer_id=' . $customer_id .'&token=' . $this->session->data['token'], true);
		$data['appointmenttab'] = $this->url->link('customer/customer_info', 'type=appointment&customer_id=' . $customer_id .'&token=' . $this->session->data['token'], true);
		$data['customerstab'] = $this->url->link('customer/customer_info', 'type=customercontact&customer_id=' . $customer_id .'&token=' . $this->session->data['token'], true);
		$data['visitstab'] = $this->url->link('customer/customer_info', 'type=visits&customer_id=' . $customer_id .'&token=' . $this->session->data['token'], true);
		$data['orderstab'] = $this->url->link('customer/customer_info', 'type=orders&customer_id=' . $customer_id .'&token=' . $this->session->data['token'], true);
		$data['quotestab'] = $this->url->link('customer/customer_info', 'type=quotes&customer_id=' . $customer_id .'&token=' . $this->session->data['token'], true);
		$data['historytab'] = $this->url->link('customer/customer_info', 'type=history&customer_id=' . $customer_id .'&token=' . $this->session->data['token'], true);
		$data['transactionstab'] = $this->url->link('customer/customer_info', 'type=transactions&customer_id=' . $customer_id .'&token=' . $this->session->data['token'], true);
		$data['rewardpointstab'] = $this->url->link('customer/customer_info', 'type=rewardpoints&customer_id=' . $customer_id .'&token=' . $this->session->data['token'], true);
		$data['ipaddressestab'] = $this->url->link('customer/customer_info', 'type=ipaddresses&customer_id=' . $customer_id .'&token=' . $this->session->data['token'], true);
		
		$data['breadcrumbs'] = array();

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('text_home'),
			'href' => $this->url->link(getDashboard($this->user), 'token=' . $this->session->data['token'], true)
		);

		$data['breadcrumbs'][] = array(
			'text' => 'Customer Management',
			'href' => $this->url->link('customer/customer', 'token=' . $this->session->data['token'] . $url, true)
		);
		
		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('breadcrum_title'),
			'href' => $this->url->link('customer/customer_info', '&token=' . $this->session->data['token'] . $url, true)
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
			'filter_customer_id'	   => $customer_id,
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
		
		$this->load->model('user/user_group');
		$this->load->model('user/user');
		$current_user = $this->session->data['user_id'];
		$current_user_group_id = $this->model_user_user->getUser($current_user); ;
		$current_user_group = $this->model_user_user_group->getUserGroup($current_user_group_id['user_group_id']); ;
		//print_r($current_user_group); exit;
		
		
		foreach ($results as $result) {
			
			$objct = json_decode($result['cart']);
			$array = (array) $objct;
			$total = $array['cart_total_price']; 
			
			$cust_con = $this->model_replogic_customer_contact->getcustomercontact($result['customer_contact_id']);
			$customer_contact = $cust_con['first_name'] ." ". $cust_con['last_name'];
			
			$cust = $this->model_customer_customer->getCustomer($result['customer_id']);
			$customer_nm = $cust['firstname'];
			
			if($current_user_group['name'] == 'Company admin' || $current_user_group['name'] == 'Administrator')
			{
				$view_button = $this->url->link('replogic/order_quotes/info', 'redirto=customer&quote_id='.$result['quote_id'].'&token=' . $this->session->data['token'] . $url, true);
			}
			else
			{ 
				$view_button = '';
			}
			
			$time = strtotime($result['date_added']);
			$date_added = date("d F, Y g:i A", $time); 
			
			$data['orders'][] = array(
				'quote_id'      => $result['quote_id'],
				'customer'      => $customer_nm,
				'customer_contact'      => $customer_contact,
				'approve'      => $this->url->link('replogic/order/add', 'token=' . $this->session->data['token'] . '&quote_id=' . $result['quote_id'] . $url, true),
				'quote_status'      => $result['quote_status'],
				'status'      => $result['status'],
				'quote_status_id' => $result['status'],
				'total'         => $this->currency->format($total, 'ZAR', '1.0000'),
				'date_added'    => $date_added,
				'shipping_code' => $result['shipping_code'],
				'view'          => $view_button
			);
		}
		
		$data['customercontacts'] = $this->model_replogic_customer_contact->getcustomercontacts(array('filter_customer_id'=>$customer_id));
		
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

		# quotes statuses
		$data['quote_statuses'] = $this->model_replogic_order_quotes->getQuoteStatus();
		$data['quote_status_pending'] = $this->language->get('quote_status_pending_id');
		$data['quote_status_converted'] = $this->language->get('quote_status_converted_id');
		$data['quote_status_denied'] = $this->language->get('quote_status_denied_id');

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
		
		if (isset($this->request->get['customer_id'])) {
			$url .= '&customer_id=' . $this->request->get['customer_id'];
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

		$data['sort_order'] = $this->url->link('customer/customer_info', 'token=' . $this->session->data['token'] . '&sort=quote_id' . $url, true);
		$data['sort_customer'] = $this->url->link('customer/customer_info', 'token=' . $this->session->data['token'] . '&sort=customer' . $url, true);
		$data['sort_customer_contact'] = $this->url->link('customer/customer_info_quotes', 'token=' . $this->session->data['token'] . '&sort=customer_contact' . $url, true);
		$data['sort_status'] = $this->url->link('customer/customer_info', 'token=' . $this->session->data['token'] . '&sort=order_status' . $url, true);
		$data['sort_total'] = $this->url->link('customer/customer_info', 'token=' . $this->session->data['token'] . '&sort=total' . $url, true);
		$data['sort_date_added'] = $this->url->link('customer/customer_info', 'token=' . $this->session->data['token'] . '&sort=date_added' . $url, true);
		$data['sort_date_modified'] = $this->url->link('customer/customer_info', 'token=' . $this->session->data['token'] . '&sort=date_modified' . $url, true);

		$url = '';
		
		if (isset($this->request->get['type'])) {
			$url .= '&type=' . $this->request->get['type'];
		}
		
		if (isset($this->request->get['customer_id'])) {
			$url .= '&customer_id=' . $this->request->get['customer_id'];
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
		$pagination->url = $this->url->link('customer/customer_info', 'token=' . $this->session->data['token'] . $url . '&page={page}', true);

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

		$this->response->setOutput($this->load->view('customer/customer_info_quotes', $data));
	}
	
	protected function getVisitsTab() {
		
		$this->load->model('replogic/location_management');
		$this->load->model('customer/customer');
		$this->load->language('replogic/location_management');
		$this->load->language('customer/customer_info');
		
		$customer_id = $this->request->get['customer_id'];
		$data['customer_id'] = $customer_id;
		$customerdetails = $this->model_customer_customer->getCustomer($customer_id);
		$data['customername'] = $customerdetails['firstname'];
		
		if (isset($this->request->get['filter_date_from'])) {
			$filter_date_from = $this->request->get['filter_date_from'];
		} else {
			$filter_date_from = null;
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
		
		if (isset($this->request->get['customer_id'])) {
			$url .= '&customer_id=' . $this->request->get['customer_id'];
		}
		
		if (isset($this->request->get['filter_date_from'])) {
			$url .= '&filter_date_from=' . $this->request->get['filter_date_from'];
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
			'href' => $this->url->link(getDashboard($this->user), 'token=' . $this->session->data['token'], true)
		);

		$data['breadcrumbs'][] = array(
			'text' => 'Customer Management',
			'href' => $this->url->link('customer/customer', 'token=' . $this->session->data['token'] . $url, true)
		);
		
		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('breadcrum_title'),
			'href' => $this->url->link('customer/customer_info', 'salesrep_id=' . $salesrep_id .'&token=' . $this->session->data['token'] . $url, true)
		);

		$data['cancel'] = $this->url->link('customer/customer', 'token=' . $this->session->data['token'] . $url, true);
		
		$data['generaltab'] = $this->url->link('customer/customer_info', 'type=general&customer_id=' . $customer_id .'&token=' . $this->session->data['token'], true);
		$data['appointmenttab'] = $this->url->link('customer/customer_info', 'type=appointment&customer_id=' . $customer_id .'&token=' . $this->session->data['token'], true);
		$data['customerstab'] = $this->url->link('customer/customer_info', 'type=customercontact&customer_id=' . $customer_id .'&token=' . $this->session->data['token'], true);
		$data['visitstab'] = $this->url->link('customer/customer_info', 'type=visits&customer_id=' . $customer_id .'&token=' . $this->session->data['token'], true);
		$data['orderstab'] = $this->url->link('customer/customer_info', 'type=orders&customer_id=' . $customer_id .'&token=' . $this->session->data['token'], true);
		$data['quotestab'] = $this->url->link('customer/customer_info', 'type=quotes&customer_id=' . $customer_id .'&token=' . $this->session->data['token'], true);
		$data['historytab'] = $this->url->link('customer/customer_info', 'type=history&customer_id=' . $customer_id .'&token=' . $this->session->data['token'], true);
		$data['transactionstab'] = $this->url->link('customer/customer_info', 'type=transactions&customer_id=' . $customer_id .'&token=' . $this->session->data['token'], true);
		$data['rewardpointstab'] = $this->url->link('customer/customer_info', 'type=rewardpoints&customer_id=' . $customer_id .'&token=' . $this->session->data['token'], true);
		$data['ipaddressestab'] = $this->url->link('customer/customer_info', 'type=ipaddresses&customer_id=' . $customer_id .'&token=' . $this->session->data['token'], true);
		
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
			'filter_customer_id'	  => $customer_id,
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
		$data['teams'] = $this->model_user_team->getTeams();
		
		$data['customers'] = $this->model_customer_customer->getCustomers($filter_data, $allaccess ,$this->session->data['user_id']); ;
		$data['salesReps'] = $this->model_replogic_sales_rep_management->getSalesRepsDropdown($allaccess, $current_user_id);
		$data['locations'] = array();
		$locationsmaps = array();
		foreach ($results as $result) {
			
			$salesrepinfo = $this->model_replogic_sales_rep_management->getsalesrep($result['salesrep_id']);
			$salesrepname = $salesrepinfo['salesrep_name']." ".$salesrepinfo['salesrep_lastname'];
			
			$team = $this->model_user_team->getTeam($salesrep['sales_team_id']); ;
			$teamname = $team['team_name'];
			
			$time = strtotime($result['checkin']);
			$last_check = date("d M Y g:i A", $time);
			
			$last_check_Ago = $this->getHowLongAgo($result['checkin']);
			
			$from = $result['start'];
			$to = $result['end'];
			$duration = $this->dateDiff($from, $to);
			
			$time      = strtotime($result['checkin']);
			$visitdate = date("d-m-Y g:i A", $time);
			
			$data['locations'][] = array(
				'checkin_id'       => $result['checkin_id'],
				'visitdate'        => $visitdate,
				'duration'         => $duration,
				'salesrepname'     => $salesrepname,
				'last_check'       => $last_check_Ago,
				'checkin_location' => $result['checkin_location'],
				'location'         => $result['location'],
				'view'             => $this->url->link('customer/customer_info/checkins', 'token=' . $this->session->data['token'] . '&checkin_id=' . $result['checkin_id'] . $url, true)	
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
		
		if (isset($this->request->get['customer_id'])) {
			$url .= '&customer_id=' . $this->request->get['customer_id'];
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

		$data['sort_name'] = $this->url->link('customer/customer_info', 'token=' . $this->session->data['token'] . '&sort=name' . $url, true);

		$url = '';
		
		if (isset($this->request->get['type'])) {
			$url .= '&type=' . $this->request->get['type'];
		}
		
		if (isset($this->request->get['customer_id'])) {
			$url .= '&customer_id=' . $this->request->get['customer_id'];
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
		$pagination->url = $this->url->link('customer/customer_info', 'token=' . $this->session->data['token'] . $url . '&page={page}', true);

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

		$this->response->setOutput($this->load->view('customer/customer_info_visits', $data));
	}
	
	public function visitsView() {
		
		$this->load->language('replogic/location_management');
		$this->load->language('customer/customer_info');
		$this->document->setTitle($this->language->get('heading_title'));
		$this->load->model('replogic/location_management');
		$this->load->model('customer/customer');
		
		$customer_id = $this->request->get['customer_id'];
		$data['customer_id'] = $customer_id;
		$customerdetails = $this->model_customer_customer->getCustomer($customer_id);
		$data['customername'] = $customerdetails['firstname'];
		
		
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
		
		if (isset($this->request->get['customer_id'])) {
			$url .= '&customer_id=' . $this->request->get['customer_id'];
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
			'href' => $this->url->link(getDashboard($this->user), 'token=' . $this->session->data['token'], true)
		);
		
		$data['breadcrumbs'][] = array(
			'text' => 'Customer Management',
			'href' => $this->url->link('customer/customer', 'token=' . $this->session->data['token'] . $url, true)
		);
		
		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('breadcrum_title'),
			'href' => $this->url->link('customer/customer_info', 'token=' . $this->session->data['token'] . $url, true)
		);

		
		$data['cancel'] = $this->url->link('customer/customer_info', 'token=' . $this->session->data['token'] . $url, true);

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

		$this->response->setOutput($this->load->view('customer/customer_info_visits_view', $data));
	}

	public function checkins() {

		$url     = '';
		$data    = array();
		$access  = true;

		/*==================================
		=       Add Files (Includes)       =
		==================================*/

		# stylesheets (CSS) files
		$this->document->addStyle('view/javascript/jquery/datetimepicker/bootstrap-datetimepicker.min.css');
		$this->document->addStyle('view/stylesheet/material-icons/material-icons.css');
		$this->document->addStyle('view/javascript/bootstrap-sweetalert/sweetalert.css');
		$this->document->addStyle('view/stylesheet/custom.css');
		$this->document->addStyle('view/stylesheet/location_management.css');
		$this->document->addStyle('view/stylesheet/customer_checkins.css');

		# javascript (JS) files
		$this->document->addScript('view/javascript/jquery/datetimepicker/bootstrap-datetimepicker.min.js');
		$this->document->addScript('view/javascript/bootstrap-sweetalert/sweetalert.min.js');
		$this->document->addScript('view/javascript/bootstrap-sweetalert/sweetalert-data.js');
		$this->document->addScript('view/javascript/location_management.js');

		# language
		$this->load->language('replogic/location_management');
		$this->load->language('customer/customer_info');

		# models
		$this->load->model('replogic/location_management');
		$this->load->model('customer/customer');
		$this->load->model('replogic/sales_rep_management');
		$this->load->model('replogic/schedule_management');

		/*=====  End of Add Files (Includes)  ======*/

		$this->document->setTitle($this->language->get('heading_title'));
		
		# page title
		$data['heading_title'] = $this->language->get('heading_title');
		$data['token']         = $this->session->data['token'];

		/*******************************************
		 * Check-in information
		 *******************************************/
		
		$checkin = $this->model_replogic_location_management->getLocation($this->request->get['checkin_id']);
		
		# sales rep
		$salesrep                 = $this->model_replogic_sales_rep_management->getsalesrep($checkin['salesrep_id']);
		$data['salesrep_id']      = $checkin['salesrep_id'];
		$data['salesrep_name']    = $salesrep['salesrep_name']." ".$salesrep['salesrep_lastname'];
		
		# appointment
		$appointment              = $this->model_replogic_schedule_management->getappointment($checkin['appointment_id']);
		$data['appointment_id']   = $checkin['appointment_id'];
		$data['appointment_name'] = $appointment['appointment_name'];
		
		
		# customer
		if (strtolower($appointment['type']) === "new business") {

			$customer              = $this->model_customer_customer->getProspectiveCustomer($checkin['customer_id']);
			$data['customer_name'] = $customer['name'];

			# get prospect address/location
			$customerAddress       = $customer['address'];

		} else {
			$customer              = $this->model_customer_customer->getCustomer($checkin['customer_id']);
			$data['customer_name'] = $customer['firstname'];
		
			# get customer address/location
			$cAddress              = $this->model_customer_customer->getAddress($customer['address_id']);
			$customerAddress       = $cAddress['address_1'].", ";
			$customerAddress      .= (!empty($cAddress['address_2'])) ? $cAddress['address_2'].", " : "";
			$customerAddress      .= $cAddress['city'].", ";
			$customerAddress      .= $cAddress['zone'].", ";
			$customerAddress      .= $cAddress['country'].", ";
			$customerAddress      .= $cAddress['postcode'];
		}
		$data['customer_id']      = $checkin['customer_id'];
		$data['customer_address'] = $customerAddress; 

		# location
		$data['location']         = $checkin['location'];
		$data['start']            = date('l, d F Y', strtotime($checkin['start']));
		$data['end']              = date('l, d F Y', strtotime($checkin['end']));
		$data['checkin_time']     = date('h:i A', strtotime($checkin['checkin']));
		$data['checkin_date']     = date('d F, Y', strtotime($checkin['checkin']));
		$data['checkout']         = date('l, d F Y', strtotime($checkin['checkout']));
		$data['checkin_location'] = $checkin['checkin_location'];
		$data['checkin']          = $this->getHowLongAgo($checkin['checkin']);
		$data['remarks']          = $checkin['remarks'];

		# map markers
		$data['marker_salesrep']  = array(
			'id'        => $checkin['checkin_id'],
			'latitude'  => '',
			'longitude' => '',
			'name'      => $data['salesrep_name'],
			'address'   => $checkin['location'],
			'icon'      => 'view/image/gmap__location_icon.png'
		);
		$data['marker_customer']  = array(
			'latitude'     => '',
			'longitude'    => '',
			'name'         => $data['customer_name'],
			'id'           => $checkin['customer_id'],
			'address'      => $data['customer_address'],
			'last_visited' => $data['checkin'],
			'salesrep_name'=> $data['salesrep_name'],
			'salesrep_id'  => $checkin['salesrep_id'],
			'icon'         => 'view/image/gmap__customer_icon.png'
		);
		$data['marker_checkin']   = array(
			'latitude'         => '',
			'longitude'        => '',
			'name'             => $data['salesrep_name'],
			'id'               => $checkin['checkin_id'],
			'customer'         => $data['customer_name'],
			'address'          => $data['checkin_location'],
			'customer_address' => $data['customer_address'],
			'gps_address'      => $data['location'],
			'visit_date'       => date('d M, Y', strtotime($checkin['start'])),
			'visit_time'       => date('h:i A', strtotime($checkin['start'])),
			'last_seen'        => $data['checkin'],
			'icon'             => 'view/image/gmap__checkin_icon.png'
		);

		/*******************************************
		 * Breadcrumbs
		 *******************************************/
		
		$data['breadcrumbs']   = array();
		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('text_home'),
			'href' => $this->url->link(getDashboard($this->user), 'token=' . $data['token'], true)
		);
		$data['breadcrumbs'][] = array(
			'text' => 'Customer Management',
			'href' => $this->url->link('customer/customer', 'token=' . $data['token'], true)
		);
		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('breadcrum_title'),
			'href' => $this->url->link('customer/customer_info&type=visits', 'customer_id=' . $checkin['customer_id'] . '&token=' . $data['token'], true)
		);

		$data['cancel_button']     = $this->url->link('customer/customer_info&type=visits', 'customer_id=' . $checkin['customer_id'] . '&token=' . $data['token'], true);
		$data['text_view_checkin'] = $this->language->get('text_view_checkin');

		/*******************************************
		 * Available and booked times
		 *******************************************/
		
		$bookedTimesForToday     = $this->model_replogic_schedule_management->getSalesRepAppointmentTimesByDate($checkin['salesrep_id'], date('Y-m-d'));
		$data['booked_times']    = array();
		$data['available_times'] = array("08:00","09:00","10:00","11:00","12:00","13:00","14:00","15:00","16:00","17:00");

		if (!empty($bookedTimesForToday)) {
			foreach($bookedTimesForToday as $time) {
				$data['booked_times'][] = $time['appointment_time'];
			}
		}

		/*******************************************
		 * Set page output data 
		 *******************************************/

		$data['gmap_legend__checkin']  = $this->language->get('gmap_legend__checkin');
		$data['gmap_legend__location'] = $this->language->get('gmap_legend__location');
		$data['gmap_legend__customer'] = $this->language->get('gmap_legend__customer');

		$data['text_location']      = $this->language->get('text_location');
		$data['label_remarks']      = $this->language->get('label_remarks');
		$data['text_button_cancel'] = $this->language->get('text_button_cancel');

		$data['header']      = $this->load->controller('common/header');
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['footer']      = $this->load->controller('common/footer');

		$this->response->setOutput($this->load->view('customer/customer_info_checkins', $data));
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
        date_default_timezone_set('Africa/Johannesburg'); 
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
	
	public function getHistoryTab()
	{
		$this->load->language('customer/customer');
		$this->load->language('customer/customer_info');

		$this->load->model('customer/customer');
		
		$customer_id = $this->request->get['customer_id'];
		$data['customer_id'] = $customer_id;
		$customerdetails = $this->model_customer_customer->getCustomer($customer_id);
		$data['customername'] = $customerdetails['firstname'];
		$data['heading_title'] = $this->language->get('heading_title');
		
		$data['cancel'] = $this->url->link('customer/customer', 'token=' . $this->session->data['token'] . $url, true);
		
		$url = '';
		
		if (isset($this->request->get['type'])) {
			$url .= '&type=' . $this->request->get['type'];
		}
		if (isset($this->request->get['customer_id'])) {
			$url .= '&customer_id=' . $this->request->get['customer_id'];
		}
		
		$data['generaltab'] = $this->url->link('customer/customer_info', 'type=general&customer_id=' . $customer_id .'&token=' . $this->session->data['token'], true);
		$data['appointmenttab'] = $this->url->link('customer/customer_info', 'type=appointment&customer_id=' . $customer_id .'&token=' . $this->session->data['token'], true);
		$data['customerstab'] = $this->url->link('customer/customer_info', 'type=customercontact&customer_id=' . $customer_id .'&token=' . $this->session->data['token'], true);
		$data['visitstab'] = $this->url->link('customer/customer_info', 'type=visits&customer_id=' . $customer_id .'&token=' . $this->session->data['token'], true);
		$data['orderstab'] = $this->url->link('customer/customer_info', 'type=orders&customer_id=' . $customer_id .'&token=' . $this->session->data['token'], true);
		$data['quotestab'] = $this->url->link('customer/customer_info', 'type=quotes&customer_id=' . $customer_id .'&token=' . $this->session->data['token'], true);
		$data['historytab'] = $this->url->link('customer/customer_info', 'type=history&customer_id=' . $customer_id .'&token=' . $this->session->data['token'], true);
		$data['transactionstab'] = $this->url->link('customer/customer_info', 'type=transactions&customer_id=' . $customer_id .'&token=' . $this->session->data['token'], true);
		$data['rewardpointstab'] = $this->url->link('customer/customer_info', 'type=rewardpoints&customer_id=' . $customer_id .'&token=' . $this->session->data['token'], true);
		$data['ipaddressestab'] = $this->url->link('customer/customer_info', 'type=ipaddresses&customer_id=' . $customer_id .'&token=' . $this->session->data['token'], true);
		
		$data['text_no_results'] = $this->language->get('text_no_results');

		$data['column_date_added'] = $this->language->get('column_date_added');
		$data['column_comment'] = $this->language->get('column_comment');
		
		$data['breadcrumbs'] = array();

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('text_home'),
			'href' => $this->url->link(getDashboard($this->user), 'token=' . $this->session->data['token'], true)
		);

		$data['breadcrumbs'][] = array(
			'text' => 'Customer Management',
			'href' => $this->url->link('customer/customer', 'token=' . $this->session->data['token'] . $url, true)
		);
		
		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('breadcrum_title'),
			'href' => $this->url->link('customer/customer_info', 'token=' . $this->session->data['token'] . $url, true)
		);
		
		if (isset($this->request->get['page'])) {
			$page = $this->request->get['page'];
		} else {
			$page = 1;
		}

		$data['histories'] = array();

		$results = $this->model_customer_customer->getHistories($this->request->get['customer_id'], ($page - 1) * $this->config->get('config_limit_admin'), $this->config->get('config_limit_admin'));

		foreach ($results as $result) {
			$data['histories'][] = array(
				'comment'    => $result['comment'],
				'date_added' => date($this->language->get('date_format_short'), strtotime($result['date_added']))
			);
		}

		$history_total = $this->model_customer_customer->getTotalHistories($this->request->get['customer_id']);

		$pagination = new Pagination();
		$pagination->total = $history_total;
		$pagination->page = $page;
		$pagination->limit = $this->config->get('config_limit_admin');
		$pagination->url = $this->url->link('customer/customer_info', 'token=' . $this->session->data['token'] . $url . '&page={page}', true);

		$data['pagination'] = $pagination->render();

		$data['results'] = sprintf($this->language->get('text_pagination'), ($history_total) ? (($page - 1) * $this->config->get('config_limit_admin')) + 1 : 0, ((($page - 1) * $this->config->get('config_limit_admin')) > ($history_total - $this->config->get('config_limit_admin'))) ? $history_total : ((($page - 1) * $this->config->get('config_limit_admin')) + $this->config->get('config_limit_admin')), $history_total, ceil($history_total / $this->config->get('config_limit_admin')));

		$data['header'] = $this->load->controller('common/header');
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['footer'] = $this->load->controller('common/footer');
		
		$this->response->setOutput($this->load->view('customer/customer_info_history', $data));
	}
	
	public function getTransactionsTab()
	{
		$this->load->language('customer/customer');
		$this->load->language('customer/customer_info');

		$this->load->model('customer/customer');
		
		$customer_id = $this->request->get['customer_id'];
		$data['customer_id'] = $customer_id;
		$customerdetails = $this->model_customer_customer->getCustomer($customer_id);
		$data['customername'] = $customerdetails['firstname'];
		$data['heading_title'] = $this->language->get('heading_title');
		
		$data['cancel'] = $this->url->link('customer/customer', 'token=' . $this->session->data['token'] . $url, true);
		
		$url = '';
		
		if (isset($this->request->get['type'])) {
			$url .= '&type=' . $this->request->get['type'];
		}
		if (isset($this->request->get['customer_id'])) {
			$url .= '&customer_id=' . $this->request->get['customer_id'];
		}
		
		$data['generaltab'] = $this->url->link('customer/customer_info', 'type=general&customer_id=' . $customer_id .'&token=' . $this->session->data['token'], true);
		$data['appointmenttab'] = $this->url->link('customer/customer_info', 'type=appointment&customer_id=' . $customer_id .'&token=' . $this->session->data['token'], true);
		$data['customerstab'] = $this->url->link('customer/customer_info', 'type=customercontact&customer_id=' . $customer_id .'&token=' . $this->session->data['token'], true);
		$data['visitstab'] = $this->url->link('customer/customer_info', 'type=visits&customer_id=' . $customer_id .'&token=' . $this->session->data['token'], true);
		$data['orderstab'] = $this->url->link('customer/customer_info', 'type=orders&customer_id=' . $customer_id .'&token=' . $this->session->data['token'], true);
		$data['quotestab'] = $this->url->link('customer/customer_info', 'type=quotes&customer_id=' . $customer_id .'&token=' . $this->session->data['token'], true);
		$data['historytab'] = $this->url->link('customer/customer_info', 'type=history&customer_id=' . $customer_id .'&token=' . $this->session->data['token'], true);
		$data['transactionstab'] = $this->url->link('customer/customer_info', 'type=transactions&customer_id=' . $customer_id .'&token=' . $this->session->data['token'], true);
		$data['rewardpointstab'] = $this->url->link('customer/customer_info', 'type=rewardpoints&customer_id=' . $customer_id .'&token=' . $this->session->data['token'], true);
		$data['ipaddressestab'] = $this->url->link('customer/customer_info', 'type=ipaddresses&customer_id=' . $customer_id .'&token=' . $this->session->data['token'], true);
		
		$data['text_no_results'] = $this->language->get('text_no_results');
		$data['text_balance'] = $this->language->get('text_balance');

		$data['column_date_added'] = $this->language->get('column_date_added');
		$data['column_description'] = $this->language->get('column_description');
		$data['column_amount'] = $this->language->get('column_amount');
		
		$data['breadcrumbs'] = array();

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('text_home'),
			'href' => $this->url->link(getDashboard($this->user), 'token=' . $this->session->data['token'], true)
		);

		$data['breadcrumbs'][] = array(
			'text' => 'Customer Management',
			'href' => $this->url->link('customer/customer', 'token=' . $this->session->data['token'] . $url, true)
		);
		
		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('breadcrum_title'),
			'href' => $this->url->link('customer/customer_info', 'token=' . $this->session->data['token'] . $url, true)
		);
		
		if (isset($this->request->get['page'])) {
			$page = $this->request->get['page'];
		} else {
			$page = 1;
		}

		$data['transactions'] = array();

		$results = $this->model_customer_customer->getTransactions($this->request->get['customer_id'], ($page - 1) * 10, 10);

		foreach ($results as $result) {
			$data['transactions'][] = array(
				'amount'      => $this->currency->format($result['amount'], $this->config->get('config_currency')),
				'description' => $result['description'],
				'date_added'  => date($this->language->get('date_format_short'), strtotime($result['date_added']))
			);
		}

		$data['balance'] = $this->currency->format($this->model_customer_customer->getTransactionTotal($this->request->get['customer_id']), $this->config->get('config_currency'));

		$transaction_total = $this->model_customer_customer->getTotalTransactions($this->request->get['customer_id']);

		$pagination = new Pagination();
		$pagination->total = $transaction_total;
		$pagination->page = $page;
		$pagination->limit = $this->config->get('config_limit_admin');
		$pagination->url = $this->url->link('customer/customer_info', 'token=' . $this->session->data['token'] . $url . '&page={page}', true);

		$data['pagination'] = $pagination->render();

		$data['results'] = sprintf($this->language->get('text_pagination'), ($transaction_total) ? (($page - 1) * $this->config->get('config_limit_admin')) + 1 : 0, ((($page - 1) * $this->config->get('config_limit_admin')) > ($transaction_total - $this->config->get('config_limit_admin'))) ? $transaction_total : ((($page - 1) * $this->config->get('config_limit_admin')) + $this->config->get('config_limit_admin')), $transaction_total, ceil($transaction_total / $this->config->get('config_limit_admin')));

		$data['header'] = $this->load->controller('common/header');
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['footer'] = $this->load->controller('common/footer');
		
		$this->response->setOutput($this->load->view('customer/customer_info_transaction', $data));
	}
	
	public function getRewardpointsTab()
	{
		$this->load->language('customer/customer');
		$this->load->language('customer/customer_info');

		$this->load->model('customer/customer');
		
		$customer_id = $this->request->get['customer_id'];
		$data['customer_id'] = $customer_id;
		$customerdetails = $this->model_customer_customer->getCustomer($customer_id);
		$data['customername'] = $customerdetails['firstname'];
		$data['heading_title'] = $this->language->get('heading_title');
		
		$data['cancel'] = $this->url->link('customer/customer', 'token=' . $this->session->data['token'] . $url, true);
		
		$url = '';
		
		if (isset($this->request->get['type'])) {
			$url .= '&type=' . $this->request->get['type'];
		}
		if (isset($this->request->get['customer_id'])) {
			$url .= '&customer_id=' . $this->request->get['customer_id'];
		}
		
		$data['generaltab'] = $this->url->link('customer/customer_info', 'type=general&customer_id=' . $customer_id .'&token=' . $this->session->data['token'], true);
		$data['appointmenttab'] = $this->url->link('customer/customer_info', 'type=appointment&customer_id=' . $customer_id .'&token=' . $this->session->data['token'], true);
		$data['customerstab'] = $this->url->link('customer/customer_info', 'type=customercontact&customer_id=' . $customer_id .'&token=' . $this->session->data['token'], true);
		$data['visitstab'] = $this->url->link('customer/customer_info', 'type=visits&customer_id=' . $customer_id .'&token=' . $this->session->data['token'], true);
		$data['orderstab'] = $this->url->link('customer/customer_info', 'type=orders&customer_id=' . $customer_id .'&token=' . $this->session->data['token'], true);
		$data['quotestab'] = $this->url->link('customer/customer_info', 'type=quotes&customer_id=' . $customer_id .'&token=' . $this->session->data['token'], true);
		$data['historytab'] = $this->url->link('customer/customer_info', 'type=history&customer_id=' . $customer_id .'&token=' . $this->session->data['token'], true);
		$data['transactionstab'] = $this->url->link('customer/customer_info', 'type=transactions&customer_id=' . $customer_id .'&token=' . $this->session->data['token'], true);
		$data['rewardpointstab'] = $this->url->link('customer/customer_info', 'type=rewardpoints&customer_id=' . $customer_id .'&token=' . $this->session->data['token'], true);
		$data['ipaddressestab'] = $this->url->link('customer/customer_info', 'type=ipaddresses&customer_id=' . $customer_id .'&token=' . $this->session->data['token'], true);
		
		$data['text_no_results'] = $this->language->get('text_no_results');
		$data['text_balance'] = $this->language->get('text_balance');

		$data['column_date_added'] = $this->language->get('column_date_added');
		$data['column_description'] = $this->language->get('column_description');
		$data['column_points'] = $this->language->get('column_points');
		
		$data['breadcrumbs'] = array();

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('text_home'),
			'href' => $this->url->link(getDashboard($this->user), 'token=' . $this->session->data['token'], true)
		);

		$data['breadcrumbs'][] = array(
			'text' => 'Customer Management',
			'href' => $this->url->link('customer/customer', 'token=' . $this->session->data['token'] . $url, true)
		);
		
		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('breadcrum_title'),
			'href' => $this->url->link('customer/customer_info', '&token=' . $this->session->data['token'] . $url, true)
		);
		
		if (isset($this->request->get['page'])) {
			$page = $this->request->get['page'];
		} else {
			$page = 1;
		}

		$data['rewards'] = array();

		$results = $this->model_customer_customer->getRewards($this->request->get['customer_id'], ($page - 1) * $this->config->get('config_limit_admin'), $this->config->get('config_limit_admin'));

		foreach ($results as $result) {
			$data['rewards'][] = array(
				'points'      => $result['points'],
				'description' => $result['description'],
				'date_added'  => date($this->language->get('date_format_short'), strtotime($result['date_added']))
			);
		}

		$data['balance'] = $this->model_customer_customer->getRewardTotal($this->request->get['customer_id']);

		$reward_total = $this->model_customer_customer->getTotalRewards($this->request->get['customer_id']);

		$pagination = new Pagination();
		$pagination->total = $reward_total;
		$pagination->page = $page;
		$pagination->limit = $this->config->get('config_limit_admin');
		$pagination->url = $this->url->link('customer/customer_info', 'token=' . $this->session->data['token'] . $url . '&page={page}', true);

		$data['pagination'] = $pagination->render();

		$data['results'] = sprintf($this->language->get('text_pagination'), ($reward_total) ? (($page - 1) * $this->config->get('config_limit_admin')) + 1 : 0, ((($page - 1) * $this->config->get('config_limit_admin')) > ($reward_total - $this->config->get('config_limit_admin'))) ? $reward_total : ((($page - 1) * $this->config->get('config_limit_admin')) + $this->config->get('config_limit_admin')), $reward_total, ceil($reward_total / $this->config->get('config_limit_admin')));

		$data['header'] = $this->load->controller('common/header');
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['footer'] = $this->load->controller('common/footer');
		
		$this->response->setOutput($this->load->view('customer/customer_info_reward', $data));
	}
	
	public function getIpaddressesTab()
	{
		$this->load->language('customer/customer');
		$this->load->language('customer/customer_info');

		$this->load->model('customer/customer');
		
		$customer_id = $this->request->get['customer_id'];
		$data['customer_id'] = $customer_id;
		$customerdetails = $this->model_customer_customer->getCustomer($customer_id);
		$data['customername'] = $customerdetails['firstname'];
		$data['heading_title'] = $this->language->get('heading_title');
		
		$data['cancel'] = $this->url->link('customer/customer', 'token=' . $this->session->data['token'] . $url, true);
		
		$url = '';
		
		if (isset($this->request->get['type'])) {
			$url .= '&type=' . $this->request->get['type'];
		}
		
		if (isset($this->request->get['customer_id'])) {
			$url .= '&customer_id=' . $this->request->get['customer_id'];
		}
		
		$data['generaltab'] = $this->url->link('customer/customer_info', 'type=general&customer_id=' . $customer_id .'&token=' . $this->session->data['token'], true);
		$data['appointmenttab'] = $this->url->link('customer/customer_info', 'type=appointment&customer_id=' . $customer_id .'&token=' . $this->session->data['token'], true);
		$data['customerstab'] = $this->url->link('customer/customer_info', 'type=customercontact&customer_id=' . $customer_id .'&token=' . $this->session->data['token'], true);
		$data['visitstab'] = $this->url->link('customer/customer_info', 'type=visits&customer_id=' . $customer_id .'&token=' . $this->session->data['token'], true);
		$data['orderstab'] = $this->url->link('customer/customer_info', 'type=orders&customer_id=' . $customer_id .'&token=' . $this->session->data['token'], true);
		$data['quotestab'] = $this->url->link('customer/customer_info', 'type=quotes&customer_id=' . $customer_id .'&token=' . $this->session->data['token'], true);
		$data['historytab'] = $this->url->link('customer/customer_info', 'type=history&customer_id=' . $customer_id .'&token=' . $this->session->data['token'], true);
		$data['transactionstab'] = $this->url->link('customer/customer_info', 'type=transactions&customer_id=' . $customer_id .'&token=' . $this->session->data['token'], true);
		$data['rewardpointstab'] = $this->url->link('customer/customer_info', 'type=rewardpoints&customer_id=' . $customer_id .'&token=' . $this->session->data['token'], true);
		$data['ipaddressestab'] = $this->url->link('customer/customer_info', 'type=ipaddresses&customer_id=' . $customer_id .'&token=' . $this->session->data['token'], true);
		
		$data['text_no_results'] = $this->language->get('text_no_results');
		$data['column_ip'] = $this->language->get('column_ip');
		$data['column_total'] = $this->language->get('column_total');
		$data['column_date_added'] = $this->language->get('column_date_added');
		
		$data['breadcrumbs'] = array();

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('text_home'),
			'href' => $this->url->link(getDashboard($this->user), 'token=' . $this->session->data['token'], true)
		);

		$data['breadcrumbs'][] = array(
			'text' => 'Customer Management',
			'href' => $this->url->link('customer/customer', 'token=' . $this->session->data['token'] . $url, true)
		);
		
		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('breadcrum_title'),
			'href' => $this->url->link('customer/customer_info', 'token=' . $this->session->data['token'] . $url, true)
		);
		
		if (isset($this->request->get['page'])) {
			$page = $this->request->get['page'];
		} else {
			$page = 1;
		}

		$data['ips'] = array();

		$results = $this->model_customer_customer->getIps($this->request->get['customer_id'], ($page - 1) * $this->config->get('config_limit_admin'), $this->config->get('config_limit_admin'));

		foreach ($results as $result) {
			$data['ips'][] = array(
				'ip'         => $result['ip'],
				'total'      => $this->model_customer_customer->getTotalCustomersByIp($result['ip']),
				'date_added' => date('d/m/y', strtotime($result['date_added'])),
				'filter_ip'  => $this->url->link('customer/customer', 'token=' . $this->session->data['token'] . '&filter_ip=' . $result['ip'], true)
			);
		}

		$ip_total = $this->model_customer_customer->getTotalIps($this->request->get['customer_id']);

		$pagination = new Pagination();
		$pagination->total = $ip_total;
		$pagination->page = $page;
		$pagination->limit = $this->config->get('config_limit_admin');
		$pagination->url = $this->url->link('customer/customer_info', 'token=' . $this->session->data['token'] . $url . '&page={page}', true);

		$data['pagination'] = $pagination->render();

		$data['results'] = sprintf($this->language->get('text_pagination'), ($ip_total) ? (($page - 1) * $this->config->get('config_limit_admin')) + 1 : 0, ((($page - 1) * $this->config->get('config_limit_admin')) > ($ip_total - $this->config->get('config_limit_admin'))) ? $ip_total : ((($page - 1) * $this->config->get('config_limit_admin')) + $this->config->get('config_limit_admin')), $ip_total, ceil($ip_total / $this->config->get('config_limit_admin')));

		$data['header'] = $this->load->controller('common/header');
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['footer'] = $this->load->controller('common/footer');
		
		$this->response->setOutput($this->load->view('customer/customer_info_ip', $data));
	}


	protected function sendCustomerInvitation() {

		$this->load->model('customer/customer');
		$this->load->model('setting/setting');

		$json['success'] = false;

		$emailClient = $this->config->get('config_mail_client');

		# get rep settings
		$repSettings  = $this->model_setting_setting->getRepSettings();
		$storeUrl     = $repSettings['store_url'];
		$companyEmail = $repSettings['email'];

		# get customer information
		$customer = $this->model_customer_customer->getCustomer($this->request->post['customer_id']);

		# auto-generate password
		$password = randomPassword();

		# update customer password
		$this->model_customer_customer->updateCustomerPassword($customer['customer_id'], $password);

		# add/log customer activity
		$this->model_customer_customer->addCustomerActivity($customer['customer_id'], $customer['ip'], $this->request->post);

		# build data array
		$data['to']      = array('email'=>$customer['email'], 'name'=>$customer['firstname']);
		$data['from']    = array('email'=>$this->config->get('config_email'), 'name'=>$this->config->get('config_name'));
		$data['subject'] = 'New Wholesale Account';

		switch ($emailClient) {
			case 'mandrill':
				# message
				$data['message'] = array(
			        'subject' => $data['subject'],
			        'to'      => array(
			            array(
			                'email' => $data['to']['email'],
			                'type'  => 'to'
			            )
			        ),
			        'global_merge_vars' => array(
			            array(
			                'name'    => 'PASSWORD',
			                'content' => $password
			            ),
			            array(
			                'name'    => 'CUSTOMER_NAME',
			                'content' => $customer['firstname']
			            ),
			            array(
			                'name'    => 'STORE_URL',
			                'content' => $storeUrl
			            ),
			            array(
			                'name'    => 'STORE_NAME',
			                'content' => $this->config->get('config_owner')
			            ),
			            array(
			                'name'    => 'STORE_EMAIL',
			                'content' => $companyEmail
			            ),
			            array(
			                'name'    => 'HELP_GUIDE',
			                'content' => HELP_GUIDE
			            )
			        )
			    );
				$template['name'] = 'baselogic-customer-invite';
				$emailResult      = sendEmail($data, false, $template, $emailClient);
				$json['success']  = (isset($emailResult[0]['status']) && (
					                $emailResult[0]['status'] == "sent" || 
					                $emailResult[0]['status'] == "queued" || 
					                $emailResult[0]['status'] == "scheduled"));
				break;
			
			default:
				# message
				$data['message'] = 'Good day '.$customer['firstname'].', '.$this->config->get('config_owner').' has invited you to purchase stock via their secure online wholesale portal. To access the portal, go to: '.$this->config->get('config_url').'. To log in, use this email address as your username. Your password is : '.$password;

				# load template
				$this->load->model('extension/mail/template');
				$tempData = array(
					'emailtemplate_key' => 'customer.invite'
				);
				
				$template = $this->model_extension_mail_template->load($tempData);

				$template->data['password']      = $password;
				$template->data['customer_name'] = $customer['firstname'];
				$template->data['_url']          = $this->config->get('config_url');
				$template->data['_name']         = $this->config->get('config_owner');
				$template->data['_email']        = $this->config->get('config_email');
				$template->data['help_guide']    = HELP_GUIDE;

				# smtp settings
				$settings['protocol']      = $this->config->get('config_mail_protocol');
				$settings['parameter']     = $this->config->get('config_mail_parameter');
				$settings['smtp_hostname'] = $this->config->get('config_mail_smtp_hostname');
				$settings['smtp_username'] = $this->config->get('config_mail_smtp_username');
				$settings['smtp_password'] = $this->config->get('config_mail_smtp_password');
				$settings['smtp_port']     = $this->config->get('config_mail_smtp_port');
				$settings['smtp_timeout']  = $this->config->get('config_mail_smtp_timeout');

				# send mail and output JSON encoded results back to JS
				$json['success'] = sendEmail($data, $settings, $template);
				break;
		}
		echo json_encode($json);
		
	}

	
	
}