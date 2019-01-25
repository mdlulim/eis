<?php
class ControllerCommonOrdersDashboard extends Controller {
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
		$this->document->addScript('view/javascript/dashboard.js');
		
		/*=====  End of Add Files (Includes)  ======*/

		$this->load->language('common/orders_dashboard');
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
		
		$this->load->model('user/user_group');
		$this->load->model('user/user');
		$current_user = $this->session->data['user_id'];
		$current_user_group_id = $this->model_user_user->getUser($current_user);
		$current_user_group = $this->model_user_user_group->getUserGroup($current_user_group_id['user_group_id']);

		/*==========================================
		=            Page Filters            =
		==========================================*/

		$this->pageFilterProcessing($data);
		
		/*=====  End of Page Filters  ======*/
		
		/*============================================
		=            Quick Actions Dropdown          =
		============================================*/

		$data['add_user_link'] =  $this->url->link('user/user/add', "token=$token", true);
		$data['add_product_link'] = $this->url->link('catalog/product/add', "token=$token", true);
		$data['add_customer_link'] = $this->url->link('customer/customer/add', "token=$token", true);
		$data['add_appointment_link'] = $this->url->link('replogic/schedule_management/add', "token=$token", true);
		$data['add_salesrep_link'] = $this->url->link('replogic/sales_rep_management/add', "token=$token", true);
		
		/*=====  End of Quick Actions Dropdown  ======*/
				
		$this->response->setOutput($this->load->view('common/orders_dashboard', $data));
		
	}

	protected function pageFilterProcessing(&$data) {

		/*======================================
		=            Initialization            =
		======================================*/
		
		$filters = array();
		$token = $this->session->data['token'];
		$url = $this->url->link('common/orders_dashboard', "token=$token", true);
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
		
		/*=====  End of Filters  ======*/

		
		/*=============================
		=            Tiles            =
		=============================*/
	
		$this->load->model('sale/order');

		/*----------  Orders In Progress  ----------*/
		$data['orders_in_progress'] = $this->model_sale_order->getOrdersInProgressCount($filters);

		/*----------  Orders Completed  ----------*/
		$data['orders_completed'] = $this->model_sale_order->getOrdersCompletedCount($filters);

		/*----------  Product Stock Alerts  ----------*/
		$this->load->model('catalog/product');
		$filters['filter_quantity'] = 0;
		$data['stock_alerts'] = $this->model_catalog_product->getProductStockAlerts($filters);
		$data['stock_alerts_tile'] = ($data['stock_alerts'] == 0) ? "tile-default" : "tile-warning";

		/*----------  Quotes Awaiting Approval  ----------*/
		$this->load->model('replogic/order_quotes');

		# get number of quotes awaiting approval
		$data['unapproved_quotes'] = $this->model_replogic_order_quotes->getQuotesAwaitingApprovalCount($filters);		
		$data['unapproved_quotes_tile'] = ($data['unapproved_quotes'] == 0) ? "tile-default" : "tile-danger";
		
		# View more link(s)
		$data['order_view_more'] = $this->url->link('sale/order', "token=$token", true);
		$data['orders_processing_view_more'] = $this->url->link('sale/order', "token=$token&filter_order_status=" . $this->language->get('order_status_processing_id'), true);
		$data['orders_completed_view_more'] = $this->url->link('sale/order', "token=$token&filter_order_status=" . $this->language->get('order_status_confirmed_id'), true);
		$data['stock_alert_view_more'] = $this->url->link('catalog/product', "token=$token&filter_quantity=0", true);
		$data['quotes_view_more'] = $this->url->link('replogic/order_quotes', "token=$token&filter_order_status=" . $this->language->get('quote_status_pending_id'), true);
	
		/*=====  End of Tiles  ======*/
		
		/*=============================================
		=        Customers by Orders [table]           =
		=============================================*/

		$this->load->model('customer/customer');
		$this->load->model('replogic/sales_rep_management');
		
		$data['customers_by_orders'] = array();
		$customersByOrders = $this->model_sale_order->getCustomersByOrders($filters);

		if (!empty($customersByOrders) && is_array($customersByOrders)) {
			foreach ($customersByOrders as $key => $value) {
				# get customer and sales rep details
				$customer = $this->model_customer_customer->getCustomer($value['customer_id']);
				$salesrep = $this->model_replogic_sales_rep_management->getsalesrep($customer['salesrep_id']);

				# Last order date
				$lastOrderDate = date("d M Y", strtotime($value['last_order_date']));
				$lastOrderDate.= " at " . date("<b>g:i A</b>", strtotime($value['last_order_date']));

				$data['customers_by_orders'][] = array(
					'customer_name' => $value['customer'],
					'total_value' => number_format($value['total_value'], 2),
					'last_order_date' => $lastOrderDate,
					'sales_rep' => $salesrep['salesrep_name'].' '.$salesrep['salesrep_lastname'],
					'wholesale_activity' => '', /** @TODO: add wholesale activity */
					'view' => $this->url->link('sale/order', "token=$token&filter_customer_id=".$value['customer_id'], true)
				);
			}
		}
	
		/*=====  End of Customers by Orders  ======*/ 

	}
}
