<?php
class ControllerCommonDashboard extends Controller {
	public function index() {
		$this->load->language('common/dashboard');

		$this->document->setTitle($this->language->get('heading_title'));

		$data['heading_title'] = $this->language->get('heading_title');

		$data['breadcrumbs'] = array();

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('text_home'),
			'href' => $this->url->link('common/dashboard', 'token=' . $this->session->data['token'], true)
		);

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('heading_title'),
			'href' => $this->url->link('common/dashboard', 'token=' . $this->session->data['token'], true)
		);

		// Check install directory exists
		if (is_dir(dirname(DIR_APPLICATION) . '/install')) {
			$data['error_install'] = $this->language->get('error_install');
		} else {
			$data['error_install'] = '';
		}
		
		$data['header'] = $this->load->controller('common/header');
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['footer'] = $this->load->controller('common/footer');

		// Run currency update
		if ($this->config->get('config_currency_auto')) {
			$this->load->model('localisation/currency');

			$this->model_localisation_currency->refresh();
		}
		
		$this->load->model('user/user_group');
		$this->load->model('user/user');
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
		
		if($current_user_group['name'] == 'Company admin' || $current_user_group['name'] == 'Administrator' || $current_user_group['name'] == 'Sales Manager')
		{ 
			
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
			
			$filter_data = array(
			'filter_appointment_from'              => $filter_appointment_from,
			'filter_appointment_to'                => $filter_appointment_to
		    );
			
			$data['filter_appointment_from'] = $filter_appointment_from;
			$data['filter_appointment_to'] = $filter_appointment_to;
		
	// Customer Start //
			$this->load->model('customer/customer');

			if($current_user_group['name'] == 'Sales Manager')
			{ 
				$today = $this->model_customer_customer->getTotalCustomersDash(array('filter_date_added' => date('Y-m-d', strtotime('-1 day'))), $current_user_id);
				$yesterday = $this->model_customer_customer->getTotalCustomersDash(array('filter_date_added' => date('Y-m-d', strtotime('-2 day'))), $current_user_id);
			}
			else
			{
				$today = $this->model_customer_customer->getTotalCustomers(array('filter_date_added' => date('Y-m-d', strtotime('-1 day'))));
				$yesterday = $this->model_customer_customer->getTotalCustomers(array('filter_date_added' => date('Y-m-d', strtotime('-2 day'))));
			}
	
			$difference = $today - $yesterday;
	
			if ($difference && $today) {
				$data['percentage'] = round(($difference / $today) * 100);
			} else {
				$data['percentage'] = 0;
			}
	
			if($current_user_group['name'] == 'Sales Manager')
			{ 
				$customer_total = $this->model_customer_customer->getTotalCustomersDash(array(), $current_user_id);
				
			}
			else
			{
				$customer_total = $this->model_customer_customer->getTotalCustomers();
			}
	
			if ($customer_total > 1000000000000) {
				$data['total'] = round($customer_total / 1000000000000, 1) . 'T';
			} elseif ($customer_total > 1000000000) {
				$data['total'] = round($customer_total / 1000000000, 1) . 'B';
			} elseif ($customer_total > 1000000) {
				$data['total'] = round($customer_total / 1000000, 1) . 'M';
			} elseif ($customer_total > 1000) {
				$data['total'] = round($customer_total / 1000, 1) . 'K';
			} else {
				$data['total'] = $customer_total;
			}
			$data['customer'] = $this->url->link('customer/customer', 'token=' . $this->session->data['token'], true);
	
	// Customer End //	
	
	// Map Start //
	
		$this->load->language('extension/dashboard/map');

		$data['heading_title'] = $this->language->get('heading_title');

		$data['text_order'] = $this->language->get('text_order');
		$data['text_sale'] = $this->language->get('text_sale');
		$data['token'] = $this->session->data['token'];
	
	// Map End //	
	
	// Sale Start //
	
		$this->load->model('report/sale');

		if($current_user_group['name'] == 'Sales Manager')
		{ 
			$todaysale = $this->model_report_sale->getTotalSalesDash(array('filter_date_added' => date('Y-m-d', strtotime('-1 day'))), $current_user_id);
			$yesterdaysale = $this->model_report_sale->getTotalSalesDash(array('filter_date_added' => date('Y-m-d', strtotime('-2 day'))), $current_user_id);
		}
		else
		{
			$todaysale = $this->model_report_sale->getTotalSales(array('filter_date_added' => date('Y-m-d', strtotime('-1 day'))));
			$yesterdaysale = $this->model_report_sale->getTotalSales(array('filter_date_added' => date('Y-m-d', strtotime('-2 day'))));
		}

		$differencesale = $todaysale - $yesterdaysale;

		if ($differencesale && (int)$todaysale) {
			$data['percentagesale'] = round(($differencesale / $todaysale) * 100);
		} else {
			$data['percentagesale'] = 0;
		}

		if($current_user_group['name'] == 'Sales Manager')
		{
			$sale_total = $this->model_report_sale->getTotalSalesDash(array(), $current_user_id);
		}
		else
		{
			$sale_total = $this->model_report_sale->getTotalSales();
		}

		if ($sale_total > 1000000000000) {
			$data['totalsale'] = round($sale_total / 1000000000000, 1) . 'T';
		} elseif ($sale_total > 1000000000) {
			$data['totalsale'] = round($sale_total / 1000000000, 1) . 'B';
		} elseif ($sale_total > 1000000) {
			$data['totalsale'] = round($sale_total / 1000000, 1) . 'M';
		} elseif ($sale_total > 1000) {
			$data['totalsale'] = round($sale_total / 1000, 1) . 'K';
		} else {
			$data['totalsale'] = round($sale_total);
		}

		$data['sale'] = $this->url->link('sale/order', 'token=' . $this->session->data['token'], true);
	
	// Sale End //	
	
	//	Order Start //
	
		$this->load->model('sale/order');

		if($current_user_group['name'] == 'Sales Manager')
		{
			$todayorder = $this->model_sale_order->getTotalOrdersDash(array('filter_date_added' => date('Y-m-d', strtotime('-1 day'))), $current_user_id);
			$yesterdayorder = $this->model_sale_order->getTotalOrdersDash(array('filter_date_added' => date('Y-m-d', strtotime('-2 day'))), $current_user_id);
		}
		else
		{
			$todayorder = $this->model_sale_order->getTotalOrders(array('filter_date_added' => date('Y-m-d', strtotime('-1 day'))));
			$yesterdayorder = $this->model_sale_order->getTotalOrders(array('filter_date_added' => date('Y-m-d', strtotime('-2 day'))));
		}

		$differenceorder = $todayorder - $yesterdayorder;

		if ($differenceorder && $todayorder) {
			$data['percentageorder'] = round(($differenceorder / $todayorder) * 100);
		} else {
			$data['percentageorder'] = 0;
		}

		if($current_user_group['name'] == 'Sales Manager')
		{
			$order_total = $this->model_sale_order->getTotalOrdersDash(array(), $current_user_id);
		}
		else
		{
			$order_total = $this->model_sale_order->getTotalOrders();
		}

		if ($order_total > 1000000000000) {
			$data['totalorder'] = round($order_total / 1000000000000, 1) . 'T';
		} elseif ($order_total > 1000000000) {
			$data['totalorder'] = round($order_total / 1000000000, 1) . 'B';
		} elseif ($order_total > 1000000) {
			$data['totalorder'] = round($order_total / 1000000, 1) . 'M';
		} elseif ($order_total > 1000) {
			$data['totalorder'] = round($order_total / 1000, 1) . 'K';
		} else {
			$data['totalorder'] = $order_total;
		}

		$data['order'] = $this->url->link('sale/order', 'token=' . $this->session->data['token'], true);
	
	// Order End //
	
	// Customers Online Start //
		
		$this->load->model('report/customer');

		$online_total = $this->model_report_customer->getTotalCustomersOnline();

		if ($online_total > 1000000000000) {
			$data['totalonline'] = round($online_total / 1000000000000, 1) . 'T';
		} elseif ($online_total > 1000000000) {
			$data['totalonline'] = round($online_total / 1000000000, 1) . 'B';
		} elseif ($online_total > 1000000) {
			$data['totalonline'] = round($online_total / 1000000, 1) . 'M';
		} elseif ($online_total > 1000) {
			$data['totalonline'] = round($online_total / 1000, 1) . 'K';
		} else {
			$data['totalonline'] = $online_total;
		}

		$data['online'] = $this->url->link('report/customer_online', 'token=' . $this->session->data['token'], true);
		
	// Customers Online End //	
	// Last 5 Orders Start //
		$data['appointments'] = array();

		$filter_data = array(
			'filter_appointment_from'  => $filter_appointment_from,
			'filter_appointment_to'  => $filter_appointment_to,
			'order' => 'DESC',
			'start' => 0,
			'limit' => 5
		);

		$this->load->model('replogic/schedule_management');
		$this->load->model('replogic/sales_rep_management');
		
		//$results = $this->model_sale_order->getOrders($filter_data);
		$results = $this->model_replogic_schedule_management->getScheduleManagement($filter_data, $allaccess, $current_user_id);

		foreach ($results as $result) {
		
			$salesrep = $this->model_replogic_sales_rep_management->getsalesrep($result['salesrep_id']); ;
			$sales_rep = $salesrep['salesrep_name'] ." ". $salesrep['salesrep_lastname'];
		
			$time = strtotime($result['appointment_date']);
			$myFormatForView = date("d-m-Y g:i A", $time); 
			
			$data['appointments'][] = array(
				'appointment_id'   => $result['appointment_id'],
				'appointment_name'   => $result['appointment_name'],
				'sales_manager'          => $sales_rep,
				'appointment_date'          => $myFormatForView,
				'view'       => $this->url->link('replogic/schedule_management/edit', 'token=' . $this->session->data['token'] . '&appointment_id=' . $result['appointment_id'], true)
			);
		}
		$data['viewmoreappo'] = $this->url->link('replogic/schedule_management', 'token=' . $this->session->data['token'], true);
		// Last 5 Orders End //
		// Activity Start //
		
		$data['activities'] = array();

		$this->load->model('report/activity');
		$this->load->language('extension/dashboard/activity');
		$results = $this->model_report_activity->getActivities();

		foreach ($results as $result) {
			$comment = vsprintf($this->language->get('text_' . $result['key']), json_decode($result['data'], true));

			$find = array(
				'customer_id=',
				'order_id=',
				'affiliate_id=',
				'return_id='
			);

			$replace = array(
				$this->url->link('customer/customer/edit', 'token=' . $this->session->data['token'] . '&customer_id=', true),
				$this->url->link('sale/order/info', 'token=' . $this->session->data['token'] . '&order_id=', true),
				$this->url->link('marketing/affiliate/edit', 'token=' . $this->session->data['token'] . '&affiliate_id=', true),
				$this->url->link('sale/return/edit', 'token=' . $this->session->data['token'] . '&return_id=', true)
			);

			$data['activities'][] = array(
				'comment'    => str_replace($find, $replace, $comment),
				'date_added' => date($this->language->get('datetime_format'), strtotime($result['date_added']))
			);
		}
		//Activity End
		// Appointment & Task Start //
		if($current_user_group['name'] == 'Sales Manager')
		{
			$data['loginuser'] = 'Sales Manager';
		}
		else
		{
			$data['loginuser'] = 'Other';
		}
		
		$this->load->model('replogic/tasks');
		$this->load->model('replogic/sales_rep_management');
		$filter_data = array(
			'order' => 'DESC',
			'start' => 0,
			'limit' => 5
		);
		$results = $this->model_replogic_tasks->getTasksDash($filter_data, $current_user_id);
		$data['tasks'] = array();
		foreach ($results as $result) {
			
			$salesrep = $this->model_replogic_sales_rep_management->getsalesrep($result['salesrep_id']); ;
			$sales_rep = $salesrep['salesrep_name'] ." ". $salesrep['salesrep_lastname'];
			
			$data['tasks'][] = array(
				'task_name'          => $result['task_name'],
				'salesrep'          => $sales_rep,
				'link'          => $this->url->link('replogic/tasks/edit', 'token=' . $this->session->data['token'] .'&task_id=' . $result['task_id'] . '&appointment_id=' . $result['appointment_id'], true)
			);
		}
		// Appointment & Task End //
				
			$this->response->setOutput($this->load->view('common/customdashboard', $data));
	}
		else
	{ 
				
		// Dashboard Extensions
		$dashboards = array();

		$this->load->model('extension/extension');

		// Get a list of installed modules
		$extensions = $this->model_extension_extension->getInstalled('dashboard');
		
		// Add all the modules which have multiple settings for each module
		foreach ($extensions as $code) {
			if ($this->config->get('dashboard_' . $code . '_status') && $this->user->hasPermission('access', 'extension/dashboard/' . $code)) {
				$output = $this->load->controller('extension/dashboard/' . $code . '/dashboard');
				
				if ($output) {
					$dashboards[] = array(
						'code'       => $code,
						'width'      => $this->config->get('dashboard_' . $code . '_width'),
						'sort_order' => $this->config->get('dashboard_' . $code . '_sort_order'),
						'output'     => $output
					);
				}
			}
		}

		$sort_order = array();

		foreach ($dashboards as $key => $value) {
			$sort_order[$key] = $value['sort_order'];
		}

		array_multisort($sort_order, SORT_ASC, $dashboards);
		
		// Split the array so the columns width is not more than 12 on each row.
		$width = 0;
		$column = array();
		$data['rows'] = array();
		
		foreach ($dashboards as $dashboard) {
			$column[] = $dashboard;
			
			$width = ($width + $dashboard['width']);
			
			if ($width >= 12) {
				$data['rows'][] = $column;
				
				$width = 0;
				$column = array();
			}
		}
		
		$this->response->setOutput($this->load->view('common/dashboard', $data));
	
	}
		
	}
}