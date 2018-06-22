<?php
class ControllerReplogicSalesRepManagement extends Controller {
	private $error = array();

	public function index() {
		$this->load->language('replogic/sales_rep_management');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('replogic/sales_rep_management');

		$this->getList();
	}

	public function add() {
		$this->load->language('replogic/sales_rep_management');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('replogic/sales_rep_management');

		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateForm()) {
			$this->model_replogic_sales_rep_management->addSalesRep($this->request->post);

			$this->session->data['success'] = $this->language->get('text_success');

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
			
			if (isset($this->request->get['filter_salesrep_name_id'])) {
				$url .= '&filter_salesrep_name_id=' . $this->request->get['filter_salesrep_name_id'];
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

			if (isset($this->request->get['page'])) {
				$url .= '&page=' . $this->request->get['page'];
			}

			$this->response->redirect($this->url->link('replogic/sales_rep_management', 'token=' . $this->session->data['token'] . $url, true));
		}

		$this->getForm();
	}

	public function edit() {
		$this->load->language('replogic/sales_rep_management');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('replogic/sales_rep_management');

		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateForm()) {
			$this->model_replogic_sales_rep_management->editSalesRep($this->request->get['salesrep_id'], $this->request->post);

			$this->session->data['success'] = $this->language->get('text_success');

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
			
			if (isset($this->request->get['filter_email'])) {
				$url .= '&filter_email=' . $this->request->get['filter_email'];
			}
			
			if (isset($this->request->get['filter_salesrep_name_id'])) {
				$url .= '&filter_salesrep_name_id=' . $this->request->get['filter_salesrep_name_id'];
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

			$this->response->redirect($this->url->link('replogic/sales_rep_management', 'token=' . $this->session->data['token'] . $url, true));
		}

		$this->getForm();
	}

	public function delete() {
		$this->load->language('replogic/sales_rep_management');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('replogic/sales_rep_management');

		if (isset($this->request->post['selected'])) {
			foreach ($this->request->post['selected'] as $salesrep_id) {
				$this->model_replogic_sales_rep_management->deleteSalesRep($salesrep_id);
			}

			$this->session->data['success'] = $this->language->get('text_success');

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
			
			if (isset($this->request->get['filter_salesrep_name_id'])) {
				$url .= '&filter_salesrep_name_id=' . $this->request->get['filter_salesrep_name_id'];
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

			if (isset($this->request->get['page'])) {
				$url .= '&page=' . $this->request->get['page'];
			}

			$this->response->redirect($this->url->link('replogic/sales_rep_management', 'token=' . $this->session->data['token'] . $url, true));
		}

		$this->getList();
	}
	
	public function assign() { 
		$this->load->language('replogic/sales_rep_management');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('replogic/sales_rep_management');

		if (isset($this->request->post['sales_rep_ids']) && $this->request->post['team_id'] != '' ) {
			
			$sales_rep_ids = explode(',',$this->request->post['sales_rep_ids']);
			$team_id = $this->request->post['team_id'];
			
			foreach ($sales_rep_ids as $sales_rep_id) {
				$this->model_replogic_sales_rep_management->AssignSalesRep($sales_rep_id,$team_id);
			}

			$this->session->data['success'] = $this->language->get('text_success');

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
			
			if (isset($this->request->get['filter_email'])) {
				$url .= '&filter_email=' . $this->request->get['filter_email'];
			}
			
			if (isset($this->request->get['filter_salesrep_name_id'])) {
				$url .= '&filter_salesrep_name_id=' . $this->request->get['filter_salesrep_name_id'];
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

			$this->response->redirect($this->url->link('replogic/sales_rep_management', 'token=' . $this->session->data['token'] . $url, true));
		}

		$this->getList();
	}
	
	public function unassign() { 
		$this->load->language('replogic/sales_rep_management');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('replogic/sales_rep_management');

		if (isset($this->request->post['sales_rep_ids'])) {
			
			$sales_rep_ids = explode(',',$this->request->post['sales_rep_ids']);
			$team_id = '';
			
			foreach ($sales_rep_ids as $sales_rep_id) {
				$this->model_replogic_sales_rep_management->UnAssignSalesRep($sales_rep_id,$team_id);
			}

			$this->session->data['success'] = $this->language->get('text_success');

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
			
			if (isset($this->request->get['filter_email'])) {
				$url .= '&filter_email=' . $this->request->get['filter_email'];
			}
			
			if (isset($this->request->get['filter_salesrep_name_id'])) {
				$url .= '&filter_salesrep_name_id=' . $this->request->get['filter_salesrep_name_id'];
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

			$this->response->redirect($this->url->link('replogic/sales_rep_management', 'token=' . $this->session->data['token'] . $url, true));
		}

		$this->getList();
	}

	protected function getList() {
		
		if (isset($this->request->get['filter_sales_rep_name'])) {
			$filter_sales_rep_name = $this->request->get['filter_sales_rep_name'];
		} else {
			$filter_sales_rep_name = null;
		}

		if (isset($this->request->get['filter_email'])) {
			$filter_email = $this->request->get['filter_email'];
		} else {
			$filter_email = null;
		}

		if (isset($this->request->get['team_id'])) {
			$team_id = $this->request->get['team_id'];
		}
		
		if (isset($this->request->get['filter_team_id'])) {
			$filter_team_id = $this->request->get['filter_team_id'];
		}
		else
		{
			$filter_team_id = null;
		}
		
		if (isset($this->request->get['filter_customer_id'])) {
			$filter_customer_id = $this->request->get['filter_customer_id'];
		} else {
			$filter_customer_id = null;
		} 
		
		if (isset($this->request->get['filter_salesrep_name_id'])) {
			$filter_salesrep_name_id = $this->request->get['filter_salesrep_name_id'];
		} else {
			$filter_salesrep_name_id = null;
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

		if (isset($this->request->get['team_id'])) {
			$url .= '&team_id=' . $this->request->get['team_id'];
		}
		
		if (isset($this->request->get['filter_team_id'])) {
			$url .= '&filter_team_id=' . $this->request->get['filter_team_id'];
		}
		
		if (isset($this->request->get['filter_customer_id'])) {
			$url .= '&filter_customer_id=' . $this->request->get['filter_customer_id'];
		}
		
		if (isset($this->request->get['filter_salesrep_name_id'])) {
			$url .= '&filter_salesrep_name_id=' . $this->request->get['filter_salesrep_name_id'];
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
			'href' => $this->url->link('common/sales_dashboard', 'token=' . $this->session->data['token'], true)
		);
		
		if (isset($this->request->get['team_id'])) {
		
			$data['breadcrumbs'][] = array(
			'text' => 'Teams',
			'href' => $this->url->link('user/team', 'token=' . $this->session->data['token'], true)
			);
		
		}

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('heading_title'),
			'href' => $this->url->link('replogic/sales_rep_management', 'token=' . $this->session->data['token'] . $url, true)
		);

		$data['add'] = $this->url->link('replogic/sales_rep_management/add', 'token=' . $this->session->data['token'] . $url, true);
		$data['delete'] = $this->url->link('replogic/sales_rep_management/delete', 'token=' . $this->session->data['token'] . $url, true);
		$data['assign'] = $this->url->link('replogic/sales_rep_management/assign', 'token=' . $this->session->data['token'] . $url, true);
		$data['unassign'] = $this->url->link('replogic/sales_rep_management/unassign', 'token=' . $this->session->data['token'] . $url, true);
		if (isset($this->request->get['team_id'])) {
			$data['cancel'] = $this->url->link('user/team', 'token=' . $this->session->data['token'] . $url, true);
		}
		else
		{
			$data['cancel'] = $this->url->link('replogic/sales_rep_management', 'token=' . $this->session->data['token'] . $url, true);
		}

		$data['sales_rep_managements'] = array();

		$filter_data = array(
			'filter_sales_rep_name'	  => $filter_sales_rep_name,
			'filter_email'	  => $filter_email,
			'team_id' => $team_id,
			'filter_customer_id' => $filter_customer_id,
			'filter_salesrep_name_id' => $filter_salesrep_name_id,
			'filter_team_id' => $filter_team_id,
			'sort'  => $sort,
			'order' => $order,
			'start' => ($page - 1) * $this->config->get('config_limit_admin'),
			'limit' => $this->config->get('config_limit_admin')
		);

		
		$this->load->model('user/user_group');
		$this->load->model('user/user');
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
		
		$this->load->model('user/team');
		$this->load->model('customer/customer');
		if($current_user_group_id['user_group_id'] == '16')
		{
			$filter_salesrep_id = $current_user; 
			
		}
		else
		{
			$filter_salesrep_id = ''; 
		}
		$filter_dataa = array('filter_salesrep_id' => $filter_salesrep_id);
		$data['teams'] = $this->model_user_team->getTeams($filter_dataa);
		$data['customers'] = $this->model_customer_customer->getCustomers();
		
		
		$sales_rep_management_total = $this->model_replogic_sales_rep_management->getTotalScheduleManagement($filter_data,$allaccess, $current_user_id);
		
		$results = $this->model_replogic_sales_rep_management->getSalesReps($filter_data,$allaccess, $current_user_id);
		
		$this->load->model('user/team');
		
		foreach ($results as $result) {
			
		$team = $this->model_user_team->getTeam($result['sales_team_id']); ;
		//print_r($user); exit;
	    $sales_manag = $user['firstname'] ." ". $user['lastname']." (".$user['username'].")";
			$data['sales_rep_managements'][] = array(
				'salesrep_id' => $result['salesrep_id'],
				'email'       => $result['email'],
				'team'        => $team['team_name'],
				'name'        => $result['salesrep_name'] . '&nbsp;' . $result['salesrep_lastname'],
				'edit'        => $this->url->link('replogic/sales_rep_management/edit', 'token=' . $this->session->data['token'] . '&salesrep_id=' . $result['salesrep_id'] . $url, true),
				'view'          => $this->url->link('replogic/salesrep_info', 'type=general&token=' . $this->session->data['token'] . '&salesrep_id=' . $result['salesrep_id'] . $url, true),
			);
		}
		
		$data['team_id'] = $team_id;
		
		$filter_data1 = array('team_id' => $team_id);
		$data['allsalesreps'] = $this->model_replogic_sales_rep_management->getSalesReps($filter_data1,$allaccess, $current_user_id);
		
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
		
		if (isset($this->request->get['filter_salesrep_name_id'])) {
			$url .= '&filter_salesrep_name_id=' . $this->request->get['filter_salesrep_name_id'];
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
		
		if (isset($this->request->get['filter_salesrep_name_id'])) {
			$url .= '&filter_salesrep_name_id=' . $this->request->get['filter_salesrep_name_id'];
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

		$pagination = new Pagination();
		$pagination->total = $sales_rep_management_total;
		$pagination->page = $page;
		$pagination->limit = $this->config->get('config_limit_admin');
		$pagination->url = $this->url->link('replogic/sales_rep_management', 'token=' . $this->session->data['token'] . $url . '&page={page}', true);

		$data['pagination'] = $pagination->render();

		$data['results'] = sprintf($this->language->get('text_pagination'), ($sales_rep_management_total) ? (($page - 1) * $this->config->get('config_limit_admin')) + 1 : 0, ((($page - 1) * $this->config->get('config_limit_admin')) > ($sales_rep_management_total - $this->config->get('config_limit_admin'))) ? $sales_rep_management_total : ((($page - 1) * $this->config->get('config_limit_admin')) + $this->config->get('config_limit_admin')), $sales_rep_management_total, ceil($sales_rep_management_total / $this->config->get('config_limit_admin')));

		$data['filter_sales_rep_name'] = $filter_sales_rep_name;
		$data['filter_email'] = $filter_email;
		$data['filter_team_id'] = $filter_team_id;
		$data['filter_customer_id'] = $filter_customer_id;
		$data['filter_salesrep_name_id'] = $filter_salesrep_name_id;
		$data['team_id'] = $team_id;
		$data['sort'] = $sort;
		$data['order'] = $order;

		$data['header'] = $this->load->controller('common/header');
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['footer'] = $this->load->controller('common/footer');

		$this->response->setOutput($this->load->view('replogic/sales_rep_management_list', $data));
	}

	protected function getForm() {
		$data['heading_title'] = $this->language->get('heading_title');
		
		$data['text_form'] = !isset($this->request->get['salesrep_id']) ? $this->language->get('text_add') : $this->language->get('text_edit');
		$data['text_select_all'] = $this->language->get('text_select_all');
		$data['text_unselect_all'] = $this->language->get('text_unselect_all');

		$data['entry_name'] = $this->language->get('entry_name');
		$data['entry_lastname'] = $this->language->get('entry_lastname');
		$data['entry_email'] = $this->language->get('entry_email');
		$data['entry_cell'] = $this->language->get('entry_cell');
		$data['entry_tel'] = $this->language->get('entry_tel');
		$data['entry_password'] = $this->language->get('entry_password');
		
		$data['entry_sales'] = $this->language->get('entry_sales');
		$data['entry_sales_team'] = $this->language->get('entry_sales_team');
		$data['entry_access'] = $this->language->get('entry_access');
		$data['entry_modify'] = $this->language->get('entry_modify');

		$data['button_save'] = $this->language->get('button_save');
		$data['button_cancel'] = $this->language->get('button_cancel');
		
		$data['form_action'] = !isset($this->request->get['salesrep_id']) ? 'add' : 'edit';

		if (isset($this->error['warning'])) {
			$data['error_warning'] = $this->error['warning'];
		} else {
			$data['error_warning'] = '';
		}

		if (isset($this->error['salesrep_name'])) {
			$data['error_salesrep_name'] = $this->error['salesrep_name'];
		} else {
			$data['error_salesrep_name'] = '';
		}
		
		if (isset($this->error['salesrep_lastname'])) {
			$data['error_salesrep_lastname'] = $this->error['salesrep_lastname'];
		} else {
			$data['error_salesrep_lastname'] = '';
		}
		
		if (isset($this->error['email'])) {
			$data['error_email'] = $this->error['email'];
		} else {
			$data['error_email'] = '';
		}
		
		if (isset($this->error['tel'])) {
			$data['error_tel'] = $this->error['tel'];
		} else {
			$data['error_tel'] = '';
		}
		
		if (isset($this->error['cell'])) {
			$data['error_cell'] = $this->error['cell'];
		} else {
			$data['error_cell'] = '';
		}
		
		if (isset($this->error['sales_team_id'])) {
			$data['error_sales_team_id'] = $this->error['sales_team_id'];
		} else {
			$data['error_sales_team_id'] = '';
		}
		
		/*if (isset($this->error['password'])) {
			$data['error_password'] = $this->error['password'];
		} else {
			$data['error_password'] = '';
		}*/

		$url = '';
		
		if (isset($this->request->get['filter_sales_rep_name'])) {
			$url .= '&filter_sales_rep_name=' . urlencode(html_entity_decode($this->request->get['filter_sales_rep_name'], ENT_QUOTES, 'UTF-8'));
		}

		if (isset($this->request->get['team_id'])) {
			$url .= '&team_id=' . $this->request->get['team_id'];
		}
		
		if (isset($this->request->get['filter_email'])) {
			$url .= '&filter_email=' . $this->request->get['filter_email'];
		}
		
		if (isset($this->request->get['filter_salesrep_name_id'])) {
			$url .= '&filter_salesrep_name_id=' . $this->request->get['filter_salesrep_name_id'];
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

		$data['breadcrumbs'] = array();

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('text_home'),
			'href' => $this->url->link('common/sales_dashboard', 'token=' . $this->session->data['token'], true)
		);

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('heading_title'),
			'href' => $this->url->link('replogic/sales_rep_management', 'token=' . $this->session->data['token'] . $url, true)
		);

		if (!isset($this->request->get['salesrep_id'])) {
			$data['action'] = $this->url->link('replogic/sales_rep_management/add', 'token=' . $this->session->data['token'] . $url, true);
		} else {
			$data['action'] = $this->url->link('replogic/sales_rep_management/edit', 'token=' . $this->session->data['token'] . '&salesrep_id=' . $this->request->get['salesrep_id'] . $url, true);
		}

		$data['cancel'] = $this->url->link('replogic/sales_rep_management', 'token=' . $this->session->data['token'] . $url, true);

		if (isset($this->request->get['salesrep_id']) && $this->request->server['REQUEST_METHOD'] != 'POST') {
			$salesrep_info = $this->model_replogic_sales_rep_management->getsalesrep($this->request->get['salesrep_id']);
		}

		if (isset($this->request->post['salesrep_name'])) {
			$data['salesrep_name'] = $this->request->post['salesrep_name'];
		} elseif (!empty($salesrep_info)) {
			 $data['salesrep_name'] = $salesrep_info['salesrep_name']; 
		} else {
			$data['salesrep_name'] = '';
		}
		
		if (isset($this->request->post['salesrep_lastname'])) {
			$data['salesrep_lastname'] = $this->request->post['salesrep_lastname'];
		} elseif (!empty($salesrep_info)) {
			$data['salesrep_lastname'] = $salesrep_info['salesrep_lastname'];
		} else {
			$data['salesrep_lastname'] = '';
		}
		
		if (isset($this->request->post['email'])) {
			$data['email'] = $this->request->post['email'];
		} elseif (!empty($salesrep_info)) {
			$data['email'] = $salesrep_info['email'];
		} else {
			$data['email'] = '';
		}
		
		if (isset($this->request->post['tel'])) {
			$data['tel'] = $this->request->post['tel'];
		} elseif (!empty($salesrep_info)) {
			$data['tel'] = $salesrep_info['tel'];
		} else {
			$data['tel'] = '';
		}
		
		if (isset($this->request->post['cell'])) {
			$data['cell'] = $this->request->post['cell'];
		} elseif (!empty($salesrep_info)) {
			$data['cell'] = $salesrep_info['cell'];
		} else {
			$data['cell'] = '';
		}
		
		if (isset($this->request->post['sales_team_id'])) {
			$data['sales_team_id'] = $this->request->post['sales_team_id'];
		} elseif (!empty($salesrep_info)) {
			$data['sales_team_id'] = $salesrep_info['sales_team_id'];
		} else {
			$data['sales_team_id'] = '';
		}
		
		/*if (isset($this->request->post['password'])) {
			$data['password'] = $this->request->post['password'];
		} elseif (!empty($salesrep_info)) {
			$data['password'] = $salesrep_info['password'];
		} else {
			$data['password'] = '';
		}*/
		$this->load->model('user/user');
		$this->load->model('user/user_group');
		$this->load->model('user/team');
		$current_user = $this->session->data['user_id'];
		$current_user_group_id = $this->model_user_user->getUser($current_user);
		$current_user_group = $this->model_user_user_group->getUserGroup($current_user_group_id['user_group_id']); 
		if($current_user_group_id['user_group_id'] == '16')
		{
			$filter_salesrep_id = $current_user; 
			
		}
		else
		{
			$filter_salesrep_id = ''; 
		}
		$filter_data = array('filter_salesrep_id' => $filter_salesrep_id);
		$data['teams'] = $this->model_user_team->getTeams($filter_data);
	 //  print_r($data['teams']); exit;
	    if (isset($this->request->get['team_id'])) {
			$data['team_id'] = $this->request->get['team_id'];
		} 

		$ignore = array(
			'common/dashboard',
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

		$this->response->setOutput($this->load->view('replogic/sales_rep_management_form', $data));
	}

	protected function validateForm() {
		if (!$this->user->hasPermission('modify', 'replogic/sales_rep_management')) {
			$this->error['warning'] = $this->language->get('error_sales_rep_management');
		}

		if ((utf8_strlen($this->request->post['salesrep_name']) < 3) || (utf8_strlen($this->request->post['salesrep_name']) > 64)) {
			$this->error['salesrep_name'] = $this->language->get('error_salesrep_name');
		}
		
		if ((utf8_strlen($this->request->post['salesrep_lastname']) < 3) || (utf8_strlen($this->request->post['salesrep_lastname']) > 64)) {
			$this->error['salesrep_lastname'] = $this->language->get('error_salesrep_lastname');
		}
		
		if ((utf8_strlen($this->request->post['email']) > 96) || !filter_var($this->request->post['email'], FILTER_VALIDATE_EMAIL)) {
			$this->error['email'] = $this->language->get('error_email');
		}
		
		/*$salesrep_info = $this->model_replogic_sales_rep_management->getSalesrepByEmail($this->request->post['email']);

		if (!isset($this->request->get['salesrep_id'])) {
			if ($salesrep_info) {
				$this->error['warning'] = $this->language->get('error_exists');
			}
		} else {
			if ($salesrep_info && ($this->request->get['salesrep_id'] != $salesrep_info['salesrep_id'])) {
				$this->error['warning'] = $this->language->get('error_exists');
			}
		}*/
		
		$user_info = $this->model_replogic_sales_rep_management->CheckEmailByApi($this->request->post['email']);

		if (!isset($this->request->get['salesrep_id'])) {
			if (!empty($user_info->data)) {
				$this->error['warning'] = $this->language->get('error_exists');
			}
		}
		
		if (utf8_strlen($this->request->post['tel']) < 10) {
			$this->error['tel'] = $this->language->get('error_tel');
			
		}
		
		$tel = $this->request->post['tel'];
		if(!is_numeric($tel)) {
			$this->error['tel'] = $this->language->get('error_tel');
		}
		
		if (utf8_strlen($this->request->post['cell']) < 10) {
			$this->error['cell'] = $this->language->get('error_cell');
		}
		
		$cell = $this->request->post['cell'];
		if(!is_numeric($cell)) {
			$this->error['cell'] = $this->language->get('error_cell');
		}
		
		if ($this->request->post['sales_team_id'] == '') {
			$this->error['sales_team_id'] = $this->language->get('error_salesrep_id');
		}
		
		/*if ((utf8_strlen($this->request->post['password']) < 3) || (utf8_strlen($this->request->post['password']) > 32)) {
			$this->error['password'] = $this->language->get('error_password');
		}*/

		return !$this->error;
	}
	
	function getsalesrepByteamId()
	{
	
		$this->load->model('replogic/sales_rep_management');
		$team_id = $this->request->post['team_id'];
		
		$salesrep = $this->model_replogic_sales_rep_management->getSalesRepByTeam($team_id);
		$this->response->addHeader('Content-Type: application/json');
		$this->response->setOutput(json_encode($salesrep));
	
	}

}