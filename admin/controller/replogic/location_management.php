<?php 
class ControllerReplogicLocationManagement extends Controller {
	private $error = array(); 

	public function index() {
		$this->load->language('replogic/location_management');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('replogic/location_management');

		$this->getList();
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
			'href' => $this->url->link('common/dashboard', 'token=' . $this->session->data['token'], true)
		);

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('heading_title'),
			'href' => $this->url->link('replogic/location_management', 'token=' . $this->session->data['token'] . $url, true)
		);

		$data['add'] = $this->url->link('replogic/location_management/add', 'token=' . $this->session->data['token'] . $url, true);
		$data['delete'] = $this->url->link('replogic/location_management/delete', 'token=' . $this->session->data['token'] . $url, true);
		
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
			
		$salesrep = $this->model_replogic_sales_rep_management->getsalesrep($result['salesrep_id']); ;
		$sales_rep = $salesrep['salesrep_name'] ." ". $salesrep['salesrep_lastname'];
		
		$customer = $this->model_customer_customer->getCustomer($result['customer_id']);
		$customername = $customer['firstname'] ." ". $customer['lastname'];
		
		$customeraddress = $this->model_customer_customer->getAddress($customer['address_id']);
		$customerlatitude = $customeraddress['latitude'];
		$customerlongitude = $customeraddress['longitude'];
		
		$team = $this->model_user_team->getTeam($salesrep['sales_team_id']); ;
		$teamname = $team['team_name'];
		
		$time = strtotime($result['checkin']);
		$last_check = date("d M Y g:i A", $time);
		
		$last_check_Ago = $this->getHowLongAgo($result['checkin']);
		
		$address = $result['location']; // Address
		
	// Get JSON results from this request
		
		$latitude = '';
		$longitude = '';
		
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
		
		$data['locations'][] = array(
				'checkin_id' => $result['checkin_id'],
				'sales_manager'          => $sales_rep,
				'team'          => $teamname,
				'customer'          => $customername,
				'last_check'          => $last_check_Ago,
				'checkin_location'          => $result['checkin_location'],
				'current_location'          => $result['location']
				
			);
		$locationsmaps[] = array('latitude'=>$latitude,'longitude'=>$longitude,'name'=>$sales_rep,'icon'=>'view/image/green-dot.png');
		$locationsmaps[] = array('latitude'=>$customerlatitude,'longitude'=>$customerlongitude,'name'=>$customername,'icon'=>'view/image/blue-dot.png');
		
		}
		$data['locationsmaps'] = $locationsmaps;
		 //print_r($locationsmaps); exit;
	//print_r($data['locations']); exit;	
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

		$this->response->setOutput($this->load->view('replogic/location_management_list', $data));
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