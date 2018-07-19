<?php
class ControllerCommonSalesDashboard extends Controller {
	public function index() {

		$token = $this->session->data['token'];

		/*==================================
		=       Add Files (Includes)       =
		==================================*/

		# stylesheets (CSS) files
		$this->document->addStyle('view/javascript/jquery/datetimepicker/bootstrap-datetimepicker.min.css');
		$this->document->addStyle('view/javascript/datatables/datatables.min.css');
		$this->document->addStyle('view/javascript/bootstrap-sweetalert/sweetalert.css');
		$this->document->addStyle('view/stylesheet/custom.css');

		# javascript (JS) files
		$this->document->addScript('view/javascript/jquery/datetimepicker/bootstrap-datetimepicker.min.js');
		$this->document->addScript('view/javascript/datatables/datatables.min.js');
		$this->document->addScript('view/javascript/bootstrap-sweetalert/sweetalert.min.js');
		$this->document->addScript('view/javascript/bootstrap-sweetalert/sweetalert-data.js');
		$this->document->addScript('view/javascript/common.js');
		$this->document->addScript('view/javascript/dashboard.js');
		
		# controller(s)
		$data['header'] = $this->load->controller('common/header');
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['footer'] = $this->load->controller('common/footer');
		
		/*=====  End of Add Files (Includes)  ======*/

		$this->load->language('common/sales_dashboard');
		$this->document->setTitle($this->language->get('heading_title'));
		$data['heading_title'] = $this->language->get('heading_title');
		
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
		
		/*=====  End of Page Filters  ======*/
		
		/*============================================
		=            Quick Actions Dropdown          =
		============================================*/

		$data['add_customer_link'] = $this->url->link('customer/customer/add', "token=$token", true);
		$data['add_appointment_link'] = $this->url->link('replogic/schedule_management/add', "token=$token", true);
		$data['add_salesrep_link'] = $this->url->link('replogic/sales_rep_management/add', "token=$token", true);
		
		/*=====  End of Quick Actions Dropdown  ======*/
				
		$this->response->setOutput($this->load->view('common/sales_dashboard', $data));
	}

	protected function pageFilterProcessing(&$data) {

		/*======================================
		=            Initialization            =
		======================================*/
		
		$filters = array();
		$token = $this->session->data['token'];
		$url = $this->url->link('common/sales_dashboard', "token=$token", true);
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
		
		
		/*========================================================
		=            Location Management [Google Map]            =
		========================================================*/
		
		$this->load->model('replogic/location_management');
		$this->load->model('replogic/sales_rep_management');

		$locations = $this->model_replogic_location_management->getLocationsDash($filters);
		$data['locations_map'] = array();

		if (!empty($locations) && is_array($locations)) {
			foreach ($locations as $location) {
				
				# Check in address/location
				$address = $location['location'];
				
				# curl
				$url = "http://maps.google.com/maps/api/geocode/json?address=".urlencode($address)."&sensor=false";
				$ch = curl_init();
				curl_setopt($ch, CURLOPT_URL, $url);
				curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
				curl_setopt($ch, CURLOPT_PROXYPORT, 3128);
				curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
				curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
				$response = curl_exec($ch);
				curl_close($ch);
				$decodedResponse = json_decode($response);
				if (isset($decodedResponse->results[0])) {
					$latitude = $decodedResponse->results[0]->geometry->location->lat;
					$longitude = $decodedResponse->results[0]->geometry->location->lng;
					
					$data['locations_map'][] = array('latitude'=>$latitude,'longitude'=>$longitude,'name'=>$address." ( ".$location['salesrep_name']." )",'icon'=>'view/image/salesrep-checkin.png');
					$data['locations_map'][] = array('latitude'=>$location['customer_lat'],'longitude'=>$location['customer_lng'],'name'=>$location['customer_name'],'icon'=>'view/image/customer.png');
				}
				
				# Gps Check in address/location
				$gpsaddress = $location['checkin_location'];
				
				# curl
				$url = "http://maps.google.com/maps/api/geocode/json?address=".urlencode($gpsaddress)."&sensor=false";
				$ch = curl_init();
				curl_setopt($ch, CURLOPT_URL, $url);
				curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
				curl_setopt($ch, CURLOPT_PROXYPORT, 3128);
				curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
				curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
				$response = curl_exec($ch);
				curl_close($ch);
				$decodedResponse = json_decode($response);
				if (isset($decodedResponse->results[0])) {
					$gpslatitude = $decodedResponse->results[0]->geometry->location->lat;
					$gpslongitude = $decodedResponse->results[0]->geometry->location->lng;
					
					$data['locations_map'][] = array('latitude'=>$gpslatitude,'longitude'=>$gpslongitude,'name'=>$gpsaddress." ( ".$location['salesrep_name']." )",'icon'=>'view/image/GPS.png');
					
				}
			
			}
		}

		# location-management view more link
		$data['location_view_more'] = $this->url->link('replogic/location_management', "token=$token", true);
		
		/*=====  End of Location Management [Google Map]  ======*/

	}
}