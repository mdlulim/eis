<?php
class ControllerCommonSalesDashboard extends Controller {
	public function index() {

		$token = $this->session->data['token'];

		/*==================================
		=       Add Files (Includes)       =
		==================================*/

		# stylesheets (CSS) files
		$this->document->addStyle('view/javascript/jquery/datetimepicker/bootstrap-datetimepicker.min.css');
		$this->document->addStyle('view/stylesheet/material-icons/material-icons.css');
		$this->document->addStyle('view/javascript/datatables/datatables.min.css');
		$this->document->addStyle('view/javascript/bootstrap-sweetalert/sweetalert.css');
		$this->document->addStyle('view/stylesheet/custom.css');
		$this->document->addStyle('view/stylesheet/location_management.css');

		# javascript (JS) files
		$this->document->addScript('view/javascript/jquery/datetimepicker/bootstrap-datetimepicker.min.js');
		$this->document->addScript('view/javascript/datatables/datatables.min.js');
		$this->document->addScript('view/javascript/bootstrap-sweetalert/sweetalert.min.js');
		$this->document->addScript('view/javascript/bootstrap-sweetalert/sweetalert-data.js');
		$this->document->addScript('view/javascript/common.js');
		$this->document->addScript('view/javascript/dashboard.js');
		$this->document->addScript('view/javascript/location_management.js');
		
		/*=====  End of Add Files (Includes)  ======*/

		$this->load->language('common/sales_dashboard');
		$this->document->setTitle($this->language->get('heading_title'));
		$data['heading_title'] = $this->language->get('heading_title');
		
		# controller(s)
		$data['header'] = $this->load->controller('common/header');
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['footer'] = $this->load->controller('common/footer');
		
		/*======================================================
		=            Check Install Directory Exists            =
		======================================================*/
		
		if (is_dir(dirname(DIR_APPLICATION) . '/install')) {
			$data['error_install'] = $this->language->get('error_install');
		} else {
			$data['error_install'] = '';
		}
		
		/*=====  End of Check Install Directory Exists  ======*/

		/*===========================================
		=            Run Currency Update            =
		===========================================*/
		
		if ($this->config->get('config_currency_auto')) {
			$this->load->model('localisation/currency');
			$this->model_localisation_currency->refresh();
		}
		
		/*=====  End of Run Currency Update  ======*/

		/*==========================================
		=            Page Filters            =
		==========================================*/

		$this->pageFilterProcessing($data);
		//$this->locationManagement();
		
		/*=====  End of Page Filters  ======*/
		
		/*============================================
		  =           Quick Actions Dropdown         =
		============================================*/

		$data['add_customer_link'] = $this->url->link('customer/customer/add', "token=$token", true);
		$data['add_appointment_link'] = $this->url->link('replogic/schedule_management/add', "token=$token", true);
		$data['add_salesrep_link'] = $this->url->link('replogic/sales_rep_management/add', "token=$token", true);
		
		/*=====  End of Quick Actions Dropdown  ======*/
				
		$this->response->setOutput($this->load->view('common/sales_dashboard', $data));
	}
	/*==================== Location Management ===================*/

	protected function locationManagement() {
		$url    = '';
		$data   = array();
		$access = true;

		$this->load->model('user/user_group');
		$this->load->model('user/user');
		$this->load->model('user/team');
		
		$this->load->model('replogic/sales_rep_management');
		$this->load->model('replogic/location_management');
		$this->load->model('customer/customer');
		$this->load->model('user/team');

		# route token
		$data['token'] = $this->session->data['token'];
		

		/*******************************************
		 * Breadcrumbs
		 *******************************************/
		
		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('text_home'),
			'href' => $this->url->link(getDashboard($this->user), 'token=' . $this->session->data['token'], true)
		);
		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('heading_title'),
			'href' => $this->url->link('replogic/location_management', 'token=' . $this->session->data['token'] . $url, true)
		);
		

		/*******************************************
		 * Current user info
		 *******************************************/

		$currentUser      = $this->session->data['user_id'];
		$currentUserGroup = $this->model_user_user->getUser($currentUser);
        
		# if sales manager, get relevant team
		if ($currentUserGroupId['user_group_id'] == '16') {
			$isSalesManager      = true;
			$curentUserSalesTeam = $this->model_user_team->getTeamBySalesmanager($currentUser);
		} else {
			$isSalesManager      = false;
		}


		/*******************************************
		 * Filters | Dropdowns
		 *******************************************/

		$filters = array();

		############### filter by team id ###############
		if (isset($this->request->get['filter_team_id'])) {
			$url .= '&filter_team_id=' . $this->request->get['filter_team_id'];
			$data['filter_team_id']    = $this->request->get['filter_team_id'];
			$filters['filter_team_id'] = $this->request->get['filter_team_id'];
		}

		############### filter by sales rep id ###############
		if (isset($this->request->get['filter_salesrep_id'])) {
			$url .= '&filter_salesrep_id=' . $this->request->get['filter_salesrep_id'];
			$data['filter_salesrep_id']    = $this->request->get['filter_salesrep_id'];
			$filters['filter_salesrep_id'] = $this->request->get['filter_salesrep_id'];
		}

		############### filter by [customer|business] type ###############
		if (isset($this->request->get['filter_type']) && $this->request->get['filter_type'] === "prospect") {
			$url .= '&filter_type=' . $this->request->get['filter_type'];
			$filters['filter_customer_type'] = "New Business";
			$data['filter_type']             = $this->request->get['filter_type'];
			$data['select_customer_label']   = 'Prospect:';
			$data['select_customer']         = 'All Prospects';
			$isProspectCustomer              = true;
		} else {
			$filters['filter_customer_type'] = "Existing Business";
			$data['filter_type']             = "customer";
			$data['select_customer_label']   = 'Customer:';
			$data['select_customer']         = 'All Customers';
			$isProspectCustomer              = false;
		}

		############### filter by customer id ###############
		if (isset($this->request->get['filter_customer_id'])) {
			$url .= '&filter_customer_id=' . $this->request->get['filter_customer_id'];
			$data['filter_customer_id']    = $this->request->get['filter_customer_id'];
			$filters['filter_customer_id'] = $this->request->get['filter_customer_id'];
		}


		/*******************************************
		 * Get teams:
		 * - if 'sales manager' update team id filter
		 *   as 'sales manager' is only assigned one
		 *   team.
		 *******************************************/

		# 
		# sales manager has only one team assigned
		if ($isSalesManager) {
			$data['teams'][] = $curentUserSalesTeam;
		} else {
			$data['teams']   = $this->model_user_team->getTeams();
		}


		/*******************************************
		 * Get sales reps
		 *******************************************/
		
		$data['salesreps'] = $this->model_replogic_sales_rep_management->getSalesReps($filters, $access, $currentUser);


		/*******************************************
		 * Get customers:
		 * - make sure 'filter_customer_id' is not 
		 *   passed to the getCustomers() model 
		 *   function.
		 *******************************************/
		
		$cfilters = $filters;
		unset($cfilters['filter_customer_id']);
		if ($isProspectCustomer) {
			$data['customers'] = $this->model_customer_customer->getProspectiveCustomers($cfilters);
		} else {
			$data['customers'] = $this->model_customer_customer->getCustomers($cfilters, $isSalesManager, $currentUser);
		}


		/*******************************************
		 * Locations | Google Map
		 *******************************************/
         
		$locations = $this->model_replogic_location_management->getLocations($filters);
		
		
		$data['markers_salesreps'] = array();
		$data['markers_customers'] = array();
		$data['markers_checkins']  = array();

		foreach ($locations as $location) {
			
			# get sales rep
			$salesrep = $this->model_replogic_sales_rep_management->getsalesrep($location['salesrep_id']); ;
			$salesrep = $salesrep['salesrep_name'] ." ". $salesrep['salesrep_lastname'];
			
			# get customer or prospect based on type
			if (strtolower($location['type']) === "new business") {

				$customer = $this->model_customer_customer->getProspectiveCustomer($location['customer_id']);
			
				# get prospect address/location
				$customerAddress   = $customer['address'];
				$customerLatitude  = '';
				$customerLongitude = '';

			} else {
				$customer = $this->model_customer_customer->getCustomer($location['customer_id']);
			
				# get customer address/location
				$customerAddress   = $this->model_customer_customer->getAddress($customer['address_id']);
				$customerLatitude  = $customerAddress['latitude'];
				$customerLongitude = $customerAddress['longitude'];
			}
			
			# last check in date/time
			$lastCheckAgo = $this->getHowLongAgo($location['checkin']);
			
			# longitude and latitude
			$latitude  = '';
			$longitude = '';
			
			
			# store sales reps current locations [Google Map]
			$data['markers_salesreps'][] = array(
				'latitude'  => $latitude,
				'longitude' => $longitude,
				'name'      => $salesrep,
				'icon'      => 'view/image/gmap__location_icon.png',
				'id'        => $location['checkin_id'],
				'address'   => $location['location']
			);

			# store customers locations [Google Map]
			$data['markers_customers'][] = array(
				'latitude'     => $customerLatitude,
				'longitude'    => $customerLongitude,
				'name'         => $customer['firstname'],
				'icon'         => 'view/image/gmap__customer_icon.png',
				'id'           => $customer['customer_id'],
				'address'      => $customerAddress,
				'last_visited' => $lastCheckAgo,
				'salesrep_name'=> $salesrep,
				'salesrep_id'  => $location['salesrep_id']
			);

			# store sales reps gps locations [Google Map]
			$data['markers_checkins'][]  = array(
				'latitude'  => $latitude,
				'longitude' => $longitude,
				'name'      => $salesrep,
				'icon'      => 'view/image/gmap__checkin_icon.png',
				'id'        => $location['checkin_id'],
				'address'   => $location['checkin_location']
			);
		}
		$data['locations_map'] = $locationsMap;

		var_dump($data['markers_checkins']);
		var_dump($data['markers_customers']);
		var_dump($data['markers_salesreps']);die();
		
		/*******************************************
		 * Set page output data 
		 *******************************************/
		
		$data['button_reload'] = $this->url->link('replogic/location_management', 'token=' . $data['token'] . $url, true);
		$data['header']        = $this->load->controller('common/header');
		$data['column_left']   = $this->load->controller('common/column_left');
		$data['footer']        = $this->load->controller('common/footer');
		$this->response->setOutput($this->load->view('common/sales_dashboard', $data));
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

	protected function pageFilterProcessing(&$data) {

		$this->load->model('replogic/location_management');
		$this->load->model('user/user_group');
		$this->load->model('user/user');
		$this->load->model('user/team');
		
		$this->load->model('replogic/sales_rep_management');
		$this->load->model('customer/customer');
		$this->load->model('user/team');

		/*======================================
		=            Initialization            =
		======================================*/
		
		$filters = array();
		$token = $this->session->data['token'];
		$url = $this->url->link(getDashboard($this->user), "token=$token", true);
		$data['day_selected'] = "";
		$data['week_selected'] = "";
		$data['month_selected'] = "";
		$data['year_selected'] = "";
		$data['custom_selected'] = "";
		$data['allow_next_click'] = "";
		$data['tf_range'] = "";
		$data['tf_no_range'] = "";
		$data['filter_date_from'] = date("d F Y", strtotime("first day of this month"));
		$data['filter_date_to'] = date("d F Y", strtotime("last day of this month"));
		$data['filter_form_action'] = $url;		# form action
		
		/*=====  End of Initialization  ======*/

		/*============================================
		=            User Role Management            =
		============================================*/
		
		$this->load->model('user/user_group');
		$this->load->model('user/user');
		$currentUser = $this->session->data['user_id'];
		$currentUserGroupId = $this->model_user_user->getUser($currentUser);
	
		$currentUserGroup = $this->model_user_user_group->getUserGroup($currentUserGroupId['user_group_id']);
	
		if ($currentUserGroup['name'] == 'Company admin' || $currentUserGroup['name'] == 'Administrator') {
			$allAccess = true;
			$currentUserId = 0;
		} else { 
			$allAccess = false;
			$currentUserId = $this->session->data['user_id'];
		}
		
		/*=====  End of User Role Management  ======*/

		/*===============================
		=            Filters            =
		===============================*/
		
		if (isset($this->request->get['filter_time_frame'])) {
			switch ($this->request->get['filter_time_frame']) {

				/*----------  filter by day  ----------*/
				case "day":
					$url .= "&filter_time_frame=day";
					if (isset($this->request->get['filter_date'])) {
						$filters['filter_date'] = $this->request->get['filter_date'];
					} else {
						$filters['filter_date'] = date("Y-m-d");
					}

					$data['filter_time_frame'] = $this->request->get['filter_time_frame'];
					$data['filter_display'] = date("l, d F Y", strtotime($filters['filter_date']));
					$data['day_selected'] = "selected";
					$data['tf_range'] = 'style="display:none"';

					# prev and next links
					$data['filter_prev_link'] = "$url&filter_date=".date("Y-m-d", strtotime($filters['filter_date']." -1 day"));
					$data['filter_next_link'] = "$url&filter_date=".date("Y-m-d", strtotime($filters['filter_date']." +1 day"));
					$data['allow_next_click'] = ($filters['filter_date'] >= date("Y-m-d")) ? "disabled": "";
					break;

				/*----------  filter by week  ----------*/
				case "week":
					$url .= "&filter_time_frame=week";
					if (isset($this->request->get['filter_date_from']) && isset($this->request->get['filter_date_to'])) {
						$filters['filter_date_from'] = $this->request->get['filter_date_from'];
						$filters['filter_date_to'] = $this->request->get['filter_date_to'];
					} else {
						$filters['filter_date_from'] = date("Y-m-d", strtotime("monday this week"));
						$filters['filter_date_to'] = date("Y-m-d", strtotime("friday this week"));
					}

					$data['filter_time_frame'] = "week";
					$data['filter_display'] = date('d F', strtotime($filters['filter_date_from']))." - ".date('d F, Y', strtotime($filters['filter_date_to']));
					$data['week_selected'] = "selected";
					$data['tf_range'] = 'style="display:none"';

					# prev and next links
					$data['filter_prev_link'] = "$url&filter_date_from=".date('Y-m-d', strtotime($filters['filter_date_from']." -7 days"))."&filter_date_to=".date('Y-m-d', strtotime($filters['filter_date_to']." -7 days"));
					$data['filter_next_link'] = "$url&filter_date_from=".date('Y-m-d', strtotime($filters['filter_date_from']." +7 days"))."&filter_date_to=".date('Y-m-d', strtotime($filters['filter_date_to']." +7 days"));
					$data['allow_next_click'] = ($filters['filter_date_to'] >= date("Y-m-d")) ? "disabled" : "";
					break;

				/*----------  filter by month  ----------*/
				case "month":
					$url .= "&filter_time_frame=month";
					if (isset($this->request->get['filter_month'])) {
						$filters['filter_month'] = $this->request->get['filter_month'];
					} else {
						$filters['filter_month'] = date("Y-m");
					}

					$data['filter_time_frame'] = "month";
					$data['filter_display'] = date('1 M - 30 M, Y', strtotime($filters['filter_month']));
					$data['month_selected'] = "selected";
					$data['tf_range'] = 'style="display:none"';

					# prev and next links
					$data['filter_prev_link'] = "$url&filter_month=".date('Y-m', strtotime($filters['filter_month']." -1 month"));
					$data['filter_next_link'] = "$url&filter_month=".date('Y-m', strtotime($filters['filter_month']." +1 month"));
					$data['allow_next_click'] = ($filters['filter_month'] >= date("Y-m")) ? "disabled" : "";
					break;

				/*----------  filter by year  ----------*/
				case "year":
					$url .= "&filter_time_frame=year";
					if (isset($this->request->get['filter_year'])) {
						$filters['filter_year'] = $this->request->get['filter_year'];
					} else {
						$filters['filter_year'] = date("Y");
					}

					$data['filter_time_frame'] = "year";
					$data['filter_display'] = "1 January - 31 December, ".$filters['filter_year'];
					$data['year_selected'] = "selected";
					$data['tf_range'] = 'style="display:none"';

					# prev and next links
					$data['filter_prev_link'] = "$url&filter_year=".($filters['filter_year']-1);
					$data['filter_next_link'] = "$url&filter_year=".($filters['filter_year']+1);
					$data['allow_next_click'] = ($filters['filter_year'] >= date("Y")) ? "disabled" : "";
					break;

				/*----------  filter by custom [date range] ----------*/
				case "custom":
					$url .= "&filter_time_frame=custom";
					$filters['filter_date_from'] = date("Y-m-d", strtotime($this->request->get['filter_date_from']));
					$filters['filter_date_to'] = date("Y-m-d", strtotime($this->request->get['filter_date_to']));

					$data['custom_selected'] = "selected";
					$data['tf_no_range'] = 'style="display:none"';
					$data['filter_date_from'] = $this->request->get['filter_date_from'];
					$data['filter_date_to'] = $this->request->get['filter_date_to'];
					break;
				
			}
		} else {
			/*----------  Default [month]  ----------*/
			$url .= "&filter_time_frame=month";
			$filters['filter_month'] = date('Y-m');

			$data['filter_time_frame'] = "month";
			$data['filter_display'] = date('d M', strtotime("first day of this month")) . " - " . date('d M, Y', strtotime("last day of this month"));
			$data['month_selected'] = "selected";
			$data['tf_range'] = 'style="display:none"';

			# prev and next links
			$data['filter_prev_link'] = "$url&filter_month=".date('Y-m', strtotime("last month"));
			$data['filter_next_link'] = "$url&filter_month=".date('Y-m', strtotime("next month"));
			$data['allow_next_click'] = "disabled";
		}

		if ($currentUserGroup['name'] == 'Sales Manager') {
			$filters['filter_user'] = $currentUserId;
		}
		
		/*=====  End of Filters  ======*/

		
		/*=============================
		=            Tiles            =
		=============================*/
	
		$this->load->model('sale/order');
		$this->load->model('replogic/order_quotes');

		/*----------  Total Orders  ----------*/
		$data['total_orders'] = $this->model_sale_order->getTotalOrdersCount($filters);

		/*----------  Total Revenue  ----------*/
		$revenue = $this->model_sale_order->getTotalRevenue($filters);
		$totalRevenue = (!empty($revenue['total'])) ? $revenue['total'] : 0;
		$data['total_revenue'] = number_format($totalRevenue, 2);
		$data['tr_currency'] = (!empty($revenue['currency'])) ? $revenue['currency'] : "R";

		/*----------  Total Quotes  ----------*/
		$data['total_quotes'] = $this->model_replogic_order_quotes->getTotalQuotesCount($filters);

		/*----------  Quotes Awaiting Approval  ----------*/
		$data['unapproved_quotes'] = $this->model_replogic_order_quotes->getQuotesAwaitingApprovalCount($filters);
		$data['unapproved_quotes_tile'] = ($data['unapproved_quotes'] == 0) ? "tile-default" : "tile-danger";
		
		# View more link(s)
		$data['order_view_more'] = $this->url->link('sale/order', "token=$token", true);
		$data['quotes_view_more'] = $this->url->link('replogic/order_quotes', "token=$token", true);

		$data['unapproved_quotes_view_more'] = $this->url->link('replogic/order_quotes', "token=$token&filter_order_status=0");
	
		/*=====  End of Tiles  ======*/
		
		/*=============================================
		=            Latest Appointments            =
		=============================================*/

		$this->load->model('replogic/schedule_management');

		# get appointments
		$appointments = $this->model_replogic_schedule_management->getAppointments($filters);

		if (!empty($appointments) && is_array($appointments)) {
			foreach ($appointments as $appointment) {

				# appointment date
				$appointmentDate = date("D d M Y", strtotime($appointment['appointment_date'])); 
				$appointmentDate.= " at " . date("<b>g:i A</b>", strtotime($appointment['appointment_date']));

				# visit date
				$visitDate = (!empty($appointment['checkin']) && $appointment['checkin']<>"") ? date("D d M Y", strtotime($appointment['checkin'])) : "";
				$visitDate.= (!empty($appointment['checkin']) && $appointment['checkin']<>"") ? " at " . date("<b>g:i A</b>", strtotime($appointment['checkin'])) : "";
				
				$data['appointments'][] = array(
					'appointment_id' => $appointment['appointment_id'],
					'appointment_name' => $appointment['appointment_name'],
					'customer_name' => $appointment['customer_name'],
					'salesrep_name' => $appointment['salesrep_name'],
					'appointment_date' => $appointmentDate,
					'appointment_type' => $appointment['type'],
					'visit_date' => $visitDate,
					'view' => $this->url->link('replogic/schedule_management/edit', "token=$token&appointment_id=".$appointment['appointment_id'], true)
				);
			}
		}

		# appointments view more link 
		$data['appointment_view_more'] = $this->url->link('replogic/schedule_management', "token=$token", true);
	
		/*=====  End of Latest Appointments  ======*/


		$data['token']      = $token;
		$data['reload_url'] = $this->url->link('common/sales_dashboard', "token=$token", true);


		/*******************************************
		 * Locations | Google Map
		 *******************************************/
         
		$locations = $this->model_replogic_location_management->getLocations($filters);
		
		
		$data['markers_salesreps'] = array();
		$data['markers_customers'] = array();
		$data['markers_checkins']  = array();

		foreach ($locations as $location) {
			
			# get sales rep
			$salesrep = $this->model_replogic_sales_rep_management->getsalesrep($location['salesrep_id']); ;
			$salesrep = $salesrep['salesrep_name'] ." ". $salesrep['salesrep_lastname'];
			
			# get customer or prospect based on type
			if (strtolower($location['type']) === "new business") {

				$customer = $this->model_customer_customer->getProspectiveCustomer($location['customer_id']);
			
				# get prospect address/location
				$customerAddress   = $customer['address'];
				$customerLatitude  = '';
				$customerLongitude = '';

			} else {
				$customer = $this->model_customer_customer->getCustomer($location['customer_id']);
			    # get customer address/location
				$cAddress   = $this->model_customer_customer->getAddress($customer['address_id']);
				$customerLatitude  = $cAddress['latitude'];
				$customerLongitude = $cAddress['longitude'];
				$customerAddress   = $cAddress['address_1'].", ";
				$customerAddress  .= (!empty($cAddress['address_2'])) ? $cAddress['address_2'].", " : "";
				$customerAddress  .= $cAddress['city'].", ";
				$customerAddress  .= $cAddress['zone'].", ";
				$customerAddress  .= $cAddress['country'].", ";
				$customerAddress  .= $cAddress['postcode'];

			}
			
			# last check in date/time
			$lastCheckAgo = $this->getHowLongAgo($location['checkin']);
			
			# longitude and latitude
			$latitude  = '';
			$longitude = '';
			
			
			# store sales reps current locations [Google Map]
			$data['markers_salesreps'][] = array(
				'latitude'  => $latitude,
				'longitude' => $longitude,
				'name'      => $salesrep,
				'icon'      => 'view/image/gmap__location_icon.png',
				'id'        => $location['checkin_id'],
				'address'   => $location['location']
			);

			# store customers locations [Google Map]
			$data['markers_customers'][] = array(
				'latitude'     => $customerLatitude,
				'longitude'    => $customerLongitude,
				'name'         => $customer['firstname'],
				'icon'         => 'view/image/gmap__customer_icon.png',
				'id'           => $customer['customer_id'],
				'address'      => $customerAddress,
				'last_visited' => $lastCheckAgo,
				'salesrep_name'=> $salesrep,
				'salesrep_id'  => $location['salesrep_id']
			);

			# store sales reps gps locations [Google Map]
		//if(!empty($location['markers_customers'])){
			
		//}
			$data['markers_checkins'][]  = array(
				'latitude'  => $latitude,
				'longitude' => $longitude,
				'name'      => $salesrep,
				'icon'      => 'view/image/gmap__checkin_icon.png',
				'id'        => $location['checkin_id'],
				'address'   => $location['checkin_location']
			);
		}

		//out($data['markers_customers']);die();

		/*******************************************
		 * Available and booked times
		 *******************************************/
		
		$bookedTimesForToday     = $this->model_replogic_schedule_management->getSalesRepAppointmentTimesByDate($data['filter_salesrep_id'], date('Y-m-d'));
		$data['booked_times']    = array();
		$data['available_times'] = array("08:00","09:00","10:00","11:00","12:00","13:00","14:00","15:00","16:00","17:00");

		if (!empty($bookedTimesForToday)) {
			foreach($bookedTimesForToday as $time) {
				$data['booked_times'][] = $time['appointment_time'];
			}
		}

		
	
		/*========================================================
		=            Location Management [Google Map]            =
		========================================================*/
		
		// $this->load->model('replogic/location_management');
		// $this->load->model('replogic/sales_rep_management');

		// $locations = $this->model_replogic_location_management->getLocationsDash($filters);
		// $data['locations_map'] = array();

		// if (!empty($locations) && is_array($locations)) {
		// 	foreach ($locations as $location) {
				
		// 		# Check in address/location
		// 		$address = $location['checkin_location'];
				
		// 		# curl
		// 		$url = "http://maps.google.com/maps/api/geocode/json?address=".urlencode($address)."&sensor=false&region=India";
		// 		$ch = curl_init();
		// 		curl_setopt($ch, CURLOPT_URL, $url);
		// 		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		// 		curl_setopt($ch, CURLOPT_PROXYPORT, 3128);
		// 		curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
		// 		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
		// 		$response = curl_exec($ch);
		// 		curl_close($ch);
		// 		$decodedResponse = json_decode($response);
		// 		if (isset($decodedResponse->results[0])) {
		// 			$latitude = $decodedResponse->results[0]->geometry->location->lat;
		// 			$longitude = $decodedResponse->results[0]->geometry->location->lng;
					
		// 			$data['locations_map'][] = array('latitude'=>$latitude,'longitude'=>$longitude,'name'=>$location['salesrep_name'],'icon'=>'view/image/green-dot.png');
		// 			$data['locations_map'][] = array('latitude'=>$location['customer_lat'],'longitude'=>$location['customer_lng'],'name'=>$location['customer_name'],'icon'=>'view/image/blue-dot.png');
		// 		}
			
		// 	}
		// }
		// # location-management view more link
	    $data['location_view_more'] = $this->url->link('replogic/location_management', "token=$token", true);
		
		/*=====  End of Location Management [Google Map]  ======*/

	}
}