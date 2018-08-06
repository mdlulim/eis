<?php 
class ControllerReplogicLocationManagement extends Controller {
	private $error = array(); 
	public function index() {

		/*==================================
		=       Add Files (Includes)       =
		==================================*/

		# stylesheets (CSS) files
		$this->document->addStyle('view/javascript/jquery/datetimepicker/bootstrap-datetimepicker.min.css');
		$this->document->addStyle('view/stylesheet/material-icons/material-icons.css');
		$this->document->addStyle('view/javascript/bootstrap-sweetalert/sweetalert.css');
		$this->document->addStyle('view/stylesheet/custom.css');
		$this->document->addStyle('view/stylesheet/location_management.css');

		# javascript (JS) files
		$this->document->addScript('view/javascript/jquery/datetimepicker/bootstrap-datetimepicker.min.js');
		$this->document->addScript('view/javascript/bootstrap-sweetalert/sweetalert.min.js');
		$this->document->addScript('view/javascript/bootstrap-sweetalert/sweetalert-data.js');
		$this->document->addScript('view/javascript/location_management.js');

		/*=====  End of Add Files (Includes)  ======*/

		$this->load->language('replogic/location_management');
		$this->document->setTitle($this->language->get('heading_title'));
		$this->load->model('replogic/location_management');
		
		$this->locationManagement();
	}
	
	public function delete() { 
		$this->load->language('replogic/location_management');
		$this->document->setTitle($this->language->get('heading_title'));
		$this->load->model('replogic/location_management');
		if (isset($this->request->post['selected'])) { 
			foreach ($this->request->post['selected'] as $checkin_id) {
				$this->model_replogic_location_management->deletelocation($checkin_id);
			}
			$this->session->data['success'] = $this->language->get('text_success');
			$url = '';
			
			if (isset($this->request->get['filter_customer_id'])) {
			$url .= '&filter_customer_id=' . $this->request->get['filter_customer_id'];
			}
			
			if (isset($this->request->get['filter_team_id'])) {
				$url .= '&filter_team_id=' . $this->request->get['filter_team_id'];
			}
			
			if (isset($this->request->get['filter_salesrep_id'])) {
				$url .= '&filter_salesrep_id=' . $this->request->get['filter_salesrep_id'];
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
			$this->response->redirect($this->url->link('replogic/location_management', 'token=' . $this->session->data['token'] . $url, true));
		}
		$this->getList();
	}

	protected function locationManagement() {
		$url    = '';
		$data   = array();
		$access = true;

		$this->load->model('user/user_group');
		$this->load->model('user/user');
		$this->load->model('user/team');
		
		$this->load->model('replogic/sales_rep_management');
		$this->load->model('replogic/schedule_management');
		$this->load->model('customer/customer');
		$this->load->model('user/team');

		# load language files
		$this->load->language('replogic/location_management');

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
			$data['select_customer_label']   = $this->language->get('select_prospect_label');
			$data['select_customer']         = $this->language->get('select_prospect');
			$isProspectCustomer              = true;
		} else {
			$filters['filter_customer_type'] = "Existing Business";
			$data['filter_type']             = "customer";
			$data['select_customer_label']   = $this->language->get('select_customer_label');
			$data['select_customer']         = $this->language->get('select_customer');
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

		$locations                 = $this->model_replogic_location_management->getLocations($filters);
		$data['locations']         = array();
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
				$cAddress          = $this->model_customer_customer->getAddress($customer['address_id']);
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
			
			# store locations
			$data['locations'][] = array(
				'checkin_id'       => $location['checkin_id'],
				'salesrep_id'      => $location['salesrep_id'],
				'salesrep_name'    => $salesrep,
				'customer_name'    => $customer['firstname'],
				'last_check'       => $lastCheckAgo,
				'checkin_location' => $location['checkin_location'],
				'current_location' => $location['location'],
				'visit_type'       => $location['type']
			);

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
				'latitude'         => $latitude,
				'longitude'        => $longitude,
				'name'             => $salesrep,
				'icon'             => 'view/image/gmap__checkin_icon.png',
				'id'               => $location['checkin_id'],
				'customer'         => $customer['firstname'],
				'address'          => $location['checkin_location'],
				'customer_address' => $customerAddress,
				'gps_address'      => $location['location'],
				'visit_date'       => date('d M, Y', strtotime($location['start'])),
				'visit_time'       => date('h:i A', strtotime($location['start'])),
				'last_seen'        => $lastCheckAgo
			);
		}

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

		/*******************************************
		 * Set page output data 
		 *******************************************/

		$data['gmap_legend__checkin']  = $this->language->get('gmap_legend__checkin');
		$data['gmap_legend__location'] = $this->language->get('gmap_legend__location');
		$data['gmap_legend__customer'] = $this->language->get('gmap_legend__customer');

		$data['heading_title']         = $this->language->get('heading_title');

		$data['select_team_label']     = $this->language->get('select_team_label');
		$data['select_team']           = $this->language->get('select_team');
		$data['select_salesrep_label'] = $this->language->get('select_salesrep_label');
		$data['select_salesrep']       = $this->language->get('select_salesrep');

		$data['radio_existing_business'] = $this->language->get('radio_existing_business');
		$data['radio_new_business']      = $this->language->get('radio_new_business');
		
		$data['button_reload'] = $this->url->link('replogic/location_management', 'token=' . $data['token'] . $url, true);
		$data['header']        = $this->load->controller('common/header');
		$data['column_left']   = $this->load->controller('common/column_left');
		$data['footer']        = $this->load->controller('common/footer');
		$this->response->setOutput($this->load->view('replogic/location_management', $data));
	}

	protected function getList() {
		
		if (isset($this->request->get['filter_address'])) {
			$filter_address = $this->request->get['filter_address'];
		} else {
			$filter_address = null;
		}
		if (isset($this->request->get['filter_customer_id'])) {
			$filter_customer_id = $this->request->get['filter_customer_id'];
		} else {
			$filter_customer_id = null;
		}
		if (isset($this->request->get['filter_team_id'])) {
			$filter_team_id = $this->request->get['filter_team_id'];
		} else {
			$filter_team_id = null;
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
		if (isset($this->request->get['filter_address'])) {
			$url .= '&filter_address=' . urlencode(html_entity_decode($this->request->get['filter_address'], ENT_QUOTES, 'UTF-8'));
		}
		if (isset($this->request->get['filter_salesrep_id'])) {
			$url .= '&filter_salesrep_id=' . $this->request->get['filter_salesrep_id'];
		}
		
		if (isset($this->request->get['filter_customer_id'])) {
			$url .= '&filter_customer_id=' . $this->request->get['filter_customer_id'];
		}
		if (isset($this->request->get['filter_team_id'])) {
			$url .= '&filter_team_id=' . $this->request->get['filter_team_id'];
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
			'href' => $this->url->link('replogic/location_management', 'token=' . $this->session->data['token'] . $url, true)
		);
		$data['add'] = $this->url->link('replogic/location_management/add', 'token=' . $this->session->data['token'] . $url, true);
		$data['delete'] = $this->url->link('replogic/location_management/delete', 'token=' . $this->session->data['token'] . $url, true);
		
		if (isset($this->request->post['selected'])) {
			$data['selected'] = (array)$this->request->post['selected'];
		} else {
			$data['selected'] = array();
		}
		
		$this->load->model('user/user_group');
		$this->load->model('user/user');
		$this->load->model('user/team');
		$current_user = $this->session->data['user_id'];
		$current_user_group_id = $this->model_user_user->getUser($current_user); ;
		$current_user_group = $this->model_user_user_group->getUserGroup($current_user_group_id['user_group_id']); ;
		//print_r($current_user_group); exit;
		if($current_user_group_id['user_group_id'] == '16')
		{
			$curent_sales_team = $this->model_user_team->getTeamBySalesmanager($current_user);
			$filter_team_id = $curent_sales_team['team_id']; 
			
		}
		else
		{
			//$filter_team_id = NULL; 
		}
		
		//$data['deletebutton'] = ($current_user_group['name'] == 'Company admin') ? '1' : '0';
		$data['deletebutton'] = ($current_user_group_id['user_group_id'] == '19') ? '1' : '0';
		
		$filter_data = array(
			'filter_groupby_salesrep'	  => true,
			'filter_address'	  => $filter_address,
			'filter_customer_id'	  => $filter_customer_id,
			'filter_team_id'	  => $filter_team_id,
			'filter_salesrep_id' => $filter_salesrep_id,
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
		
		if ($current_user_group_id['user_group_id'] == '15' || $current_user_group_id['user_group_id'] == '19') {
			$data['access']  = 'yes';
			$allaccess       = true;
			$current_user_id = 0;
		} else { 
			$data['access']  = 'yes';
			$allaccess       = false;
			$current_user_id = $this->session->data['user_id'];
			
		}
		
		$location_total = $this->model_replogic_location_management->getTotalLocations($filter_data);
		
		$this->load->model('replogic/sales_rep_management');
		$this->load->model('customer/customer');
		$this->load->model('user/team');
		
		if ($current_user_group_id['user_group_id'] == '16') {
			$data['filtersales'] = 'yes';
			if (isset($this->request->get['filter_team_id'])) {
			
				$filter_team_id = $this->request->get['filter_team_id'];
				$data['salesReps'] = $this->model_replogic_sales_rep_management->getSalesRepByTeam($filter_team_id);
			
				if (isset($this->request->get['filter_salesrep_id'])) {
				
					$data['customers'] = $this->model_customer_customer->getCustomerBySalesRep($this->request->get['filter_salesrep_id']);
				}
				else
				{
					$data['customers'] = '';
				}
			} else if (!empty($filter_team_id)) {
			
				$data['salesReps'] = $this->model_replogic_sales_rep_management->getSalesRepByTeam($filter_team_id);
			
				if (isset($this->request->get['filter_salesrep_id'])) {
				
					$data['customers'] = $this->model_customer_customer->getCustomerBySalesRep($this->request->get['filter_salesrep_id']);
				} else {
					$data['customers'] = '';
				}
			} else {
				$data['customers'] = '';
				$data['salesReps'] = '';
			}
			$salesrep_id = $current_user;
		}
		else
		{
			$data['filtersales'] = 'no';
			$data['customers']   = $this->model_customer_customer->getCustomers('', $allaccess, $this->session->data['user_id']);
			$data['salesReps']   = $this->model_replogic_sales_rep_management->getSalesRepsDropdown($allaccess=true);
			$salesrep_id         = '';
			
			# filter by cutomer id
			if ($filter_customer_id) {
				$filtercustomerinfo = $this->model_customer_customer->getCustomer($filter_customer_id);
				$data['filter_customer'] = $filtercustomerinfo['firstname'];
			} else {
				$data['filter_customer'] = '';
			}
			
			# filter by salesrep id
			if ($filter_salesrep_id) {
				$data['customers']       = $this->model_customer_customer->getCustomerBySalesRep($filter_salesrep_id);
				$salesreinfo             = $this->model_replogic_sales_rep_management->getsalesrep($filter_salesrep_id);
				$data['filter_salesrep'] = $salesreinfo['salesrep_name'] . ' ' . $salesreinfo['salesrep_lastname'];
			} else {
				$data['filter_salesrep'] = '';
			}
			
			# filter by team id
			if ($filter_team_id) {
				$data['salesReps']       = $this->model_replogic_sales_rep_management->getSalesRepByTeam($filter_team_id);
				$teamsinfo               = $this->model_user_team->getTeam($filter_team_id);
				$data['filter_teamname'] = $teamsinfo['team_name'];
			} else {
				$data['filter_teamname'] = '';
			}
		 
		}

		$locations = $this->model_replogic_location_management->getLocations($filter_data);
		
		$filter_dataa  = array('filter_salesrep_id' => $salesrep_id);
		$data['teams'] = $this->model_user_team->getTeams($filter_dataa);
		
		$data['locations'] = array();
		$locationsmaps = array();
		
		foreach ($locations as $location) {
			
			$salesrep     = $this->model_replogic_sales_rep_management->getsalesrep($location['salesrep_id']); ;
			$sales_rep    = $salesrep['salesrep_name'] ." ". $salesrep['salesrep_lastname'];
			
			$customer     = $this->model_customer_customer->getCustomer($location['customer_id']);
			$customername = $customer['firstname'];
			
			$customeraddress   = $this->model_customer_customer->getAddress($customer['address_id']);
			$customerlatitude  = $customeraddress['latitude'];
			$customerlongitude = $customeraddress['longitude'];
			
			$team     = $this->model_user_team->getTeam($salesrep['sales_team_id']); ;
			$teamname = $team['team_name'];
			
			$time = strtotime($location['checkin']);
			$last_check = date("d M Y g:i A", $time);
			
			$last_check_Ago = $this->getHowLongAgo($location['checkin']);
			
			$address = $location['location']; // Address
			
			// Get JSON locations from this request
			
			$latitude = '';
			$longitude = '';
			
			$url = "http://maps.google.com/maps/api/geocode/json?address=".urlencode($address)."&sensor=false&region=India";
			$ch  = curl_init();
			curl_setopt($ch, CURLOPT_URL, $url);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
			curl_setopt($ch, CURLOPT_PROXYPORT, 3128);
			curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
			curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
			$response   = curl_exec($ch);
			curl_close($ch);
			$response_a = json_decode($response);
			$latitude   = $response_a->results[0]->geometry->location->lat;
			$longitude  = $response_a->results[0]->geometry->location->lng;
			
			$data['locations'][] = array(
				'checkin_id'       => $location['checkin_id'],
				'salesrep_id'      => $location['salesrep_id'],
				'salesrep_name'    => $sales_rep,
				'team_name'        => $teamname,
				'customer_name'    => $customername,
				'last_check'       => $last_check_Ago,
				'checkin_location' => $location['checkin_location'],
				'current_location' => $location['location']
			);

			$gpsMarkersSalesReps[] = array('latitude'=>$latitude,'longitude'=>$longitude,'name'=>$sales_rep,'icon'=>'view/image/green-dot.png','id'=>$location['checkin_id']);
			$gpsMarkersCustomers[] = array('latitude'=>$customerlatitude,'longitude'=>$customerlongitude,'name'=>$customername,'icon'=>'view/image/blue-dot.png','id'=>$customer['customer_id']);

			$locationsmaps[] = array('latitude'=>$latitude,'longitude'=>$longitude,'name'=>$sales_rep,'icon'=>'view/image/green-dot.png','id'=>$location['checkin_id']);
			$locationsmaps[] = array('latitude'=>$customerlatitude,'longitude'=>$customerlongitude,'name'=>$customername,'icon'=>'view/image/blue-dot.png','id'=>$customer['customer_id']);
		
		}
		
		// echo "<pre>";
		// print_r($data['locations']);exit;

		$data['locationsmaps'] = $locationsmaps;
		
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
		if (isset($this->request->post['selected'])) {
			$data['selected'] = (array)$this->request->post['selected'];
		} else {
			$data['selected'] = array();
		}
		$url = '';
		
		if (isset($this->request->get['filter_address'])) {
			$url .= '&filter_address=' . urlencode(html_entity_decode($this->request->get['filter_address'], ENT_QUOTES, 'UTF-8'));
		}
		if (isset($this->request->get['filter_salesrep_id'])) {
			$url .= '&filter_salesrep_id=' . $this->request->get['filter_salesrep_id'];
		}
		
		if (isset($this->request->get['filter_customer_id'])) {
			$url .= '&filter_customer_id=' . $this->request->get['filter_customer_id'];
		}
		if (isset($this->request->get['filter_team_id'])) {
			$url .= '&filter_team_id=' . $this->request->get['filter_team_id'];
		}
		
		if ($order == 'ASC') {
			$url .= '&order=DESC';
		} else {
			$url .= '&order=ASC';
		}
		if (isset($this->request->get['page'])) {
			$url .= '&page=' . $this->request->get['page'];
		}
		$data['sort_name'] = $this->url->link('replogic/location_management', 'token=' . $this->session->data['token'] . '&sort=name' . $url, true);
		$url = '';
		
		if (isset($this->request->get['filter_address'])) {
			$url .= '&filter_address=' . urlencode(html_entity_decode($this->request->get['filter_address'], ENT_QUOTES, 'UTF-8'));
		}
		if (isset($this->request->get['filter_salesrep_id'])) {
			$url .= '&filter_salesrep_id=' . $this->request->get['filter_salesrep_id'];
		}
		
		if (isset($this->request->get['filter_customer_id'])) {
			$url .= '&filter_customer_id=' . $this->request->get['filter_customer_id'];
		}
		if (isset($this->request->get['filter_team_id'])) {
			$url .= '&filter_team_id=' . $this->request->get['filter_team_id'];
		}
		
		if (isset($this->request->get['sort'])) {
			$url .= '&sort=' . $this->request->get['sort'];
		}
		if (isset($this->request->get['order'])) {
			$url .= '&order=' . $this->request->get['order'];
		}

		$data['token'] = $this->session->data['token'];
		
		$pagination = new Pagination();
		$pagination->total = $location_total;
		$pagination->page = $page;
		$pagination->limit = $this->config->get('config_limit_admin');
		$pagination->url = $this->url->link('replogic/location_management', 'token=' . $this->session->data['token'] . $url . '&page={page}', true);
		$data['pagination'] = $pagination->render();
		$data['results'] = sprintf($this->language->get('text_pagination'), ($location_total) ? (($page - 1) * $this->config->get('config_limit_admin')) + 1 : 0, ((($page - 1) * $this->config->get('config_limit_admin')) > ($location_total - $this->config->get('config_limit_admin'))) ? $location_total : ((($page - 1) * $this->config->get('config_limit_admin')) + $this->config->get('config_limit_admin')), $location_total, ceil($location_total / $this->config->get('config_limit_admin')));
		$data['filter_address'] = $filter_address;
		$data['filter_customer_id'] = $filter_customer_id;
		$data['filter_team_id'] = $filter_team_id;
		$data['filter_salesrep_id'] = $filter_salesrep_id;
		$data['sort'] = $sort;
		$data['order'] = $order;
		$data['header'] = $this->load->controller('common/header');
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['footer'] = $this->load->controller('common/footer');
		$this->response->setOutput($this->load->view('replogic/location_management', $data));
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
	
	public function Popupmap()
	{ 
		$this->load->model('replogic/location_management');
		$this->load->model('replogic/sales_rep_management');
		$checkin_ids = explode(',',$this->request->post['checkin_id']);
		
		$locationsmaps = array();
		
		foreach($checkin_ids as $checkin_id)
		{
			$location_info = $this->model_replogic_location_management->getLocation($checkin_id);
			
			$salesrep = $this->model_replogic_sales_rep_management->getsalesrep($location_info['salesrep_id']); ;
			$sales_rep = $salesrep['salesrep_name'] ." ". $salesrep['salesrep_lastname'];
			
			$latitude = '';
			$longitude = '';
			$address = $location_info['checkin_location']; // Address
			
			$url = "http://maps.google.com/maps/api/geocode/json?address=".urlencode($address)."&sensor=false&region=India";
			$ch = curl_init();
			curl_setopt($ch, CURLOPT_URL, $url);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
			curl_setopt($ch, CURLOPT_PROXYPORT, 3128);
			curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
			curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
			$response = curl_exec($ch);
			curl_close($ch);
			$response_a = json_decode($response);
			$latitude = $response_a->results[0]->geometry->location->lat;
			$longitude = $response_a->results[0]->geometry->location->lng;
			
			$locationsmaps[] = array('latitude'=>$latitude,'longitude'=>$longitude,'name'=>$sales_rep,'icon'=>'view/image/green-dot.png','chkaddress'=>$address);
			
		}
		
		$this->response->addHeader('Content-Type: application/json');
		$this->response->setOutput(json_encode($locationsmaps));
	}
	
	public function PopupmapSingle()
	{ 
		$this->load->model('replogic/location_management');
		$this->load->model('replogic/sales_rep_management');
		$checkin_id = $this->request->post['checkin_id'];
		
		$location_info = $this->model_replogic_location_management->getLocation($checkin_id);
			
		$salesrep = $this->model_replogic_sales_rep_management->getsalesrep($location_info['salesrep_id']); ;
		$sales_rep = $salesrep['salesrep_name'] ." ". $salesrep['salesrep_lastname'];
			
			$latitude = '';
			$longitude = '';
			$address = $location_info['location']; // Address
			
			$url = "http://maps.google.com/maps/api/geocode/json?address=".urlencode($address)."&sensor=false";
			$ch = curl_init();
			curl_setopt($ch, CURLOPT_URL, $url);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
			curl_setopt($ch, CURLOPT_PROXYPORT, 3128);
			curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
			curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
			$response = curl_exec($ch);
			curl_close($ch);
			$response_a = json_decode($response);
			$latitude = $response_a->results[0]->geometry->location->lat;
			$longitude = $response_a->results[0]->geometry->location->lng;
			
			$Glatitude = '';
			$Glongitude = '';
			$Gaddress = $location_info['checkin_location']; // Address
			
			$Gurl = "http://maps.google.com/maps/api/geocode/json?address=".urlencode($Gaddress)."&sensor=false";
			$Gch = curl_init();
			curl_setopt($Gch, CURLOPT_URL, $Gurl);
			curl_setopt($Gch, CURLOPT_RETURNTRANSFER, 1);
			curl_setopt($Gch, CURLOPT_PROXYPORT, 3128);
			curl_setopt($Gch, CURLOPT_SSL_VERIFYHOST, 0);
			curl_setopt($Gch, CURLOPT_SSL_VERIFYPEER, 0);
			$Gresponse = curl_exec($Gch);
			curl_close($Gch);
			$response_G = json_decode($Gresponse);
			$Glatitude = $response_G->results[0]->geometry->location->lat;
			$Glongitude = $response_G->results[0]->geometry->location->lng;
		
		$locationsmaps = array();	
		$locationsmaps[] = array('location'=>'Current Location','latitude'=>$latitude,'longitude'=>$longitude,'name'=>'Location : '.$sales_rep,'icon'=>'view/image/green-dot.png');
		$locationsmaps[] = array('location'=>'GPS Location','latitude'=>$Glatitude,'longitude'=>$Glongitude,'name'=>'Check In Location : '.$sales_rep,'icon'=>'view/image/blue-dot.png');
		
		$this->response->addHeader('Content-Type: application/json');
		$this->response->setOutput(json_encode($locationsmaps));
	}
	
	public function GetSalesRep() {
		$json = array();
		$this->load->model('replogic/sales_rep_management');
		$salesrep_infos = $this->model_replogic_sales_rep_management->getSalesRepByTeam($this->request->get['team_id']);
		if ($salesrep_infos) {
			foreach($salesrep_infos as $salesrep_info)
			{
				$json[] = array(
					'salesrep_id' => $salesrep_info['salesrep_id'],
					'name'        => $salesrep_info['salesrep_name']." ".$salesrep_info['salesrep_lastname']
				);
			}
		}
		$this->response->addHeader('Content-Type: application/json');
		$this->response->setOutput(json_encode($json));
	}
	
	public function GetCustomerBySalesrep() {
		$json = array();
		$this->load->model('customer/customer');
		$customer_infos = $this->model_customer_customer->getCustomerBySalesRep($this->request->get['salesrep_id']);
		if ($customer_infos) {
			foreach($customer_infos as $customer_info)
			{
				$json[] = array(
					'customer_id'        => $customer_info['customer_id'],
					'name'              => $customer_info['firstname']
				);
			}
		}
		$this->response->addHeader('Content-Type: application/json');
		$this->response->setOutput(json_encode($json));
	}
}
