<?php
class ControllerReplogicScheduleManagement extends Controller {
	private $error = array();

	public function index() {
		$this->load->language('replogic/schedule_management');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('replogic/schedule_management');

		$this->getList();
	}

	public function add() {
		$this->load->language('replogic/schedule_management');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('replogic/schedule_management');

		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateForm()) {
			$this->model_replogic_schedule_management->addScheduleManagement($this->request->post);

			$this->session->data['success'] = $this->language->get('text_success');

			$url = '';

			if (isset($this->request->get['sort'])) {
				$url .= '&sort=' . $this->request->get['sort'];
			}

			if (isset($this->request->get['order'])) {
				$url .= '&order=' . $this->request->get['order'];
			}

			if (isset($this->request->get['page'])) {
				$url .= '&page=' . $this->request->get['page'];
			}

			$this->response->redirect($this->url->link('replogic/schedule_management', 'token=' . $this->session->data['token'] . $url, true));
		}

		$this->getForm();
	}

	public function edit() {
		$this->load->language('replogic/schedule_management');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('replogic/schedule_management');

		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateForm()) {
			$this->model_replogic_schedule_management->editScheduleManagement($this->request->get['appointment_id'], $this->request->post);

			$this->session->data['success'] = $this->language->get('text_success');

			$url = '';

			if (isset($this->request->get['sort'])) {
				$url .= '&sort=' . $this->request->get['sort'];
			}

			if (isset($this->request->get['order'])) {
				$url .= '&order=' . $this->request->get['order'];
			}

			if (isset($this->request->get['page'])) {
				$url .= '&page=' . $this->request->get['page'];
			}

			$this->response->redirect($this->url->link('replogic/schedule_management', 'token=' . $this->session->data['token'] . $url, true));
		}

		$this->getForm();
	}

	public function delete() {
		$this->load->language('replogic/schedule_management');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('replogic/schedule_management');

		if (isset($this->request->post['selected'])) {
			foreach ($this->request->post['selected'] as $appointment_id) {
				$this->model_replogic_schedule_management->deleteAppointment($appointment_id);
			}

			$this->session->data['success'] = $this->language->get('text_success');

			$url = '';

			if (isset($this->request->get['sort'])) {
				$url .= '&sort=' . $this->request->get['sort'];
			}

			if (isset($this->request->get['order'])) {
				$url .= '&order=' . $this->request->get['order'];
			}

			if (isset($this->request->get['page'])) {
				$url .= '&page=' . $this->request->get['page'];
			}

			$this->response->redirect($this->url->link('replogic/schedule_management', 'token=' . $this->session->data['token'] . $url, true));
		}

		$this->getList();
	}

	protected function getList() {
		
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
			'href' => $this->url->link('replogic/schedule_management', 'token=' . $this->session->data['token'] . $url, true)
		);

		$data['add'] = $this->url->link('replogic/schedule_management/add', 'token=' . $this->session->data['token'] . $url, true);
		$data['delete'] = $this->url->link('replogic/schedule_management/delete', 'token=' . $this->session->data['token'] . $url, true);

		$data['schedule_managements'] = array();

		$filter_data = array(
			'filter_appointment_name'	  => $filter_appointment_name,
			'filter_appointment_from'	  => $filter_appointment_from,
			'filter_appointment_to'	  => $filter_appointment_to,
			'filter_salesrep_id' => $filter_salesrep_id,
			'sort'  => $sort,
			'order' => $order,
			'start' => ($page - 1) * $this->config->get('config_limit_admin'),
			'limit' => $this->config->get('config_limit_admin')
		);

		$schedule_management_total = $this->model_replogic_schedule_management->getTotalScheduleManagement($filter_data);

		$results = $this->model_replogic_schedule_management->getScheduleManagement($filter_data);
		
		$this->load->model('user/user');
		$this->load->model('user/user_group');
		
		$current_user = $this->session->data['user_id'];
		$current_user_group_id = $this->model_user_user->getUser($current_user); ;
		$current_user_group = $this->model_user_user_group->getUserGroup($current_user_group_id); ;
		//print_r($current_user_group); exit;
		if($current_user_group['name'] == 'Company admin' || $current_user_group['name'] == 'Administrator')
		{
			$data['access'] = 'yes';
		}
		else
		{
			$data['access'] = 'no';
		}
		
		foreach ($results as $result) {
			
		$user = $this->model_user_user->getUser($result['salesrep_id']); ;
		//print_r($user); exit;
	    $sales_manag = $user['firstname'] ." ". $user['lastname']." (".$user['username'].")";
			$data['schedule_managements'][] = array(
				'appointment_id' => $result['appointment_id'],
				'appointment_name'          => $result['appointment_name'],
				'sales_manager'          => $sales_manag,
				'appointment_date'          => date('d-m-y H:i:s', strtotime($result['appointment_date'])),
				'notes'          => $this->url->link('replogic/notes', 'token=' . $this->session->data['token'] . '&appointment_id=' . $result['appointment_id'] . $url, true),
				'edit'          => $this->url->link('replogic/schedule_management/edit', 'token=' . $this->session->data['token'] . '&appointment_id=' . $result['appointment_id'] . $url, true)
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

		if (isset($this->request->post['selected'])) {
			$data['selected'] = (array)$this->request->post['selected'];
		} else {
			$data['selected'] = array();
		}

		$url = '';
		
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

		$data['sort_name'] = $this->url->link('replogic/schedule_management', 'token=' . $this->session->data['token'] . '&sort=name' . $url, true);

		$url = '';
		
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
		$pagination->url = $this->url->link('replogic/schedule_management', 'token=' . $this->session->data['token'] . $url . '&page={page}', true);

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

		$this->response->setOutput($this->load->view('replogic/schedule_management_list', $data));
	}

	protected function getForm() {
		$data['heading_title'] = $this->language->get('heading_title');
		
		$data['text_form'] = !isset($this->request->get['appointment_id']) ? $this->language->get('text_add') : $this->language->get('text_edit');
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

		if (isset($this->error['appointment_name'])) {
			$data['error_appointment_name'] = $this->error['appointment_name'];
		} else {
			$data['error_appointment_name'] = '';
		}
		
		if (isset($this->error['appointment_description'])) {
			$data['error_appointment_description'] = $this->error['appointment_description'];
		} else {
			$data['error_appointment_description'] = '';
		}
		
		if (isset($this->error['appointment_date'])) {
			$data['error_appointment_date'] = $this->error['appointment_date'];
		} else {
			$data['error_appointment_date'] = '';
		}

		$url = '';

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
			'href' => $this->url->link('replogic/schedule_management', 'token=' . $this->session->data['token'] . $url, true)
		);

		if (!isset($this->request->get['appointment_id'])) {
			$data['action'] = $this->url->link('replogic/schedule_management/add', 'token=' . $this->session->data['token'] . $url, true);
		} else {
			$data['action'] = $this->url->link('replogic/schedule_management/edit', 'token=' . $this->session->data['token'] . '&appointment_id=' . $this->request->get['appointment_id'] . $url, true);
		}

		$data['cancel'] = $this->url->link('replogic/schedule_management', 'token=' . $this->session->data['token'] . $url, true);

		if (isset($this->request->get['appointment_id']) && $this->request->server['REQUEST_METHOD'] != 'POST') {
			$appointment_info = $this->model_replogic_schedule_management->getappointment($this->request->get['appointment_id']);
		}

		if (isset($this->request->post['appointment_name'])) {
			$data['appointment_name'] = $this->request->post['appointment_name'];
		} elseif (!empty($appointment_info)) {
			 $data['appointment_name'] = $appointment_info['appointment_name']; 
		} else {
			$data['appointment_name'] = '';
		}
		
		if (isset($this->request->post['appointment_date'])) {
			$data['appointment_date'] = $this->request->post['appointment_date'];
		} elseif (!empty($appointment_info)) {
			$data['appointment_date'] = $appointment_info['appointment_date'];
		} else {
			$data['appointment_date'] = '';
		}
		
		if (isset($this->request->post['customer_id'])) {
			$data['customer_id'] = $this->request->post['customer_id'];
		} elseif (!empty($appointment_info)) {
			$data['customer_id'] = $appointment_info['customer_id'];
		} else {
			$data['customer_id'] = '';
		}
		
		if (isset($this->request->post['appointment_description'])) {
			$data['appointment_description'] = $this->request->post['appointment_description'];
		} elseif (!empty($appointment_info)) {
			$data['appointment_description'] = $appointment_info['appointment_description'];
		} else {
			$data['appointment_description'] = '';
		}
		
		$this->load->model('user/user_group');
		$this->load->model('user/user');
		$user_group_id = $this->model_user_user_group->getUserGroupByName('Sales Manager');
		$data['users'] = $this->model_user_user->getUsersByGroupId($user_group_id['user_group_id']); ;
	   //print_r($data['users']); exit;
	   
	   $this->load->model('customer/customer');
	   $data['customers'] = $this->model_customer_customer->getCustomers(); ;
	
		if (isset($this->request->post['sales_manager'])) {
			$data['sales_manager'] = $this->request->post['sales_manager'];
		} elseif (!empty($appointment_info)) {
			$data['sales_manager'] = $appointment_info['salesrep_id'];
		} else {
			$data['sales_manager'] = '';
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

		$this->response->setOutput($this->load->view('replogic/schedule_management_form', $data));
	}

	protected function validateForm() {
		if (!$this->user->hasPermission('modify', 'replogic/schedule_management')) {
			$this->error['warning'] = $this->language->get('error_schedule_management');
		}

		if ((utf8_strlen($this->request->post['appointment_name']) < 3) || (utf8_strlen($this->request->post['appointment_name']) > 64)) {
			$this->error['appointment_name'] = $this->language->get('error_appointment_name');
		}
		
		if ((utf8_strlen($this->request->post['appointment_description']) < 3) || (utf8_strlen($this->request->post['appointment_description']) > 64)) {
			$this->error['appointment_description'] = $this->language->get('error_appointment_description');
		}
		
		if ((utf8_strlen($this->request->post['appointment_date']) < 3) || (utf8_strlen($this->request->post['appointment_date']) > 64)) {
			$this->error['appointment_date'] = $this->language->get('error_appointment_date');
		}

		return !$this->error;
	}

}