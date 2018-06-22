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

			if (isset($this->request->get['filter_appointment_name'])) {
			$url .= '&filter_appointment_name=' . urlencode(html_entity_decode($this->request->get['filter_appointment_name'], ENT_QUOTES, 'UTF-8'));
			}
			
			if (isset($this->request->get['filter_customer_id'])) {
				$url .= '&filter_customer_id=' . $this->request->get['filter_customer_id'];
			}
			
			if (isset($this->request->get['filter_type'])) {
				$url .= '&filter_type=' . $this->request->get['filter_type'];
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
			
			if (isset($this->request->get['filter_appointment_name'])) {
				$url .= '&filter_appointment_name=' . urlencode(html_entity_decode($this->request->get['filter_appointment_name'], ENT_QUOTES, 'UTF-8'));
			}
			
			if (isset($this->request->get['filter_customer_id'])) {
				$url .= '&filter_customer_id=' . $this->request->get['filter_customer_id'];
			}
			
			if (isset($this->request->get['filter_type'])) {
				$url .= '&filter_type=' . $this->request->get['filter_type'];
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
			
			if (isset($this->request->get['type'])) 
			{ 
				$this->response->redirect($this->url->link('customer/customer_info/appointmentView', 'appointment_id='.$this->request->get['appointment_id'].'&type='.$this->request->get['type'].'&customer_id='.$this->request->get['customer_id'].'&token=' . $this->session->data['token'], true));
			}
			else
			{ 
				$this->response->redirect($this->url->link('replogic/schedule_management', 'token=' . $this->session->data['token'] . $url, true));
			}
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
			
			if (isset($this->request->get['filter_appointment_name'])) {
			$url .= '&filter_appointment_name=' . urlencode(html_entity_decode($this->request->get['filter_appointment_name'], ENT_QUOTES, 'UTF-8'));
			}
			
			if (isset($this->request->get['filter_customer_id'])) {
				$url .= '&filter_customer_id=' . $this->request->get['filter_customer_id'];
			}
			
			if (isset($this->request->get['filter_type'])) {
				$url .= '&filter_type=' . $this->request->get['filter_type'];
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
		
		if (isset($this->request->get['filter_customer_id'])) {
			$filter_customer_id = $this->request->get['filter_customer_id'];
		} else {
			$filter_customer_id = null;
		}
		
		if (isset($this->request->get['filter_type'])) {
			$filter_type = $this->request->get['filter_type'];
		} else {
			$filter_type = null;
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

		if (isset($this->request->get['filter_appointment_name'])) {
			$url .= '&filter_appointment_name=' . urlencode(html_entity_decode($this->request->get['filter_appointment_name'], ENT_QUOTES, 'UTF-8'));
		}
		
		if (isset($this->request->get['filter_customer_id'])) {
			$url .= '&filter_customer_id=' . $this->request->get['filter_customer_id'];
		}
		
		if (isset($this->request->get['filter_type'])) {
			$url .= '&filter_type=' . $this->request->get['filter_type'];
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

		$data['breadcrumbs'] = array();

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('text_home'),
			'href' => $this->url->link('common/sales_dashboard', 'token=' . $this->session->data['token'], true)
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
			'filter_customer_id'  => $filter_customer_id,
			'filter_appointment_from'	  => $filter_appointment_from,
			'filter_appointment_to'	  => $filter_appointment_to,
			'filter_salesrep_id' => $filter_salesrep_id,
			'filter_type' => $filter_type,
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
		//print_r($results); exit;
		$this->load->model('replogic/sales_rep_management');
		 $data['salesReps'] = $this->model_replogic_sales_rep_management->getSalesRepsDropdown($allaccess, $current_user_id);
		
		foreach ($results as $result) {
			
		$time = strtotime($result['appointment_date']);
		$myFormatForView = date("d-m-Y g:i A", $time); 
			
		$data['schedule_managements'][] = array(
				'appointment_id' => $result['appointment_id'],
				'appointment_name'          => $result['appointment_name'],
				'type'          => $result['type'],
				'sales_manager'          => $result['salesrepname'],
				'appointment_date'          => $myFormatForView,
				'tasks'          => $this->url->link('replogic/tasks', 'token=' . $this->session->data['token'] . '&appointment_id=' . $result['appointment_id'] . $url, true),
				'notes'          => $this->url->link('replogic/notes', 'token=' . $this->session->data['token'] . '&appointment_id=' . $result['appointment_id'] . $url, true),
				'edit'          => $this->url->link('replogic/schedule_management/edit', 'token=' . $this->session->data['token'] . '&appointment_id=' . $result['appointment_id'] . $url, true)
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
		
		if (isset($this->request->get['filter_appointment_name'])) {
			$url .= '&filter_appointment_name=' . urlencode(html_entity_decode($this->request->get['filter_appointment_name'], ENT_QUOTES, 'UTF-8'));
		}

		if (isset($this->request->get['filter_customer_id'])) {
			$url .= '&filter_customer_id=' . $this->request->get['filter_customer_id'];
		}
		
		if (isset($this->request->get['filter_type'])) {
			$url .= '&filter_type=' . $this->request->get['filter_type'];
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

		$data['sort_name'] = $this->url->link('replogic/schedule_management', 'token=' . $this->session->data['token'] . '&sort=appointment_name' . $url, true);
		$data['sort_appointment_date'] = $this->url->link('replogic/schedule_management', 'token=' . $this->session->data['token'] . '&sort=appointment_date' . $url, true);
		$data['sort_type'] = $this->url->link('replogic/schedule_management', 'token=' . $this->session->data['token'] . '&sort=type' . $url, true);
		$data['sort_salesrepname'] = $this->url->link('replogic/schedule_management', 'token=' . $this->session->data['token'] . '&sort=salesrepname' . $url, true);

		$url = '';
		
		if (isset($this->request->get['filter_appointment_name'])) {
			$url .= '&filter_appointment_name=' . urlencode(html_entity_decode($this->request->get['filter_appointment_name'], ENT_QUOTES, 'UTF-8'));
		}
		
		if (isset($this->request->get['filter_customer_id'])) {
			$url .= '&filter_customer_id=' . $this->request->get['filter_customer_id'];
		}
		
		if (isset($this->request->get['filter_type'])) {
			$url .= '&filter_type=' . $this->request->get['filter_type'];
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
		$data['filter_customer_id'] = $filter_customer_id;
		$data['filter_appointment_from'] = $filter_appointment_from;
		$data['filter_appointment_to'] = $filter_appointment_to;
		$data['filter_salesrep_id'] = $filter_salesrep_id;
		$data['filter_type'] = $filter_type;
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
		$data['token'] = $this->session->data['token'];

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
		
		if (isset($this->error['salesrep_id'])) {
			$data['error_salesrep_id'] = $this->error['salesrep_id'];
		} else {
			$data['error_salesrep_id'] = '';
		}
		
		if (isset($this->error['type'])) {
			$data['error_type'] = $this->error['type'];
		} else {
			$data['error_type'] = '';
		}
		
		if (isset($this->error['bcustomer_name'])) {
			$data['error_bcustomer_name'] = $this->error['bcustomer_name'];
		} else {
			$data['error_bcustomer_name'] = '';
		}
		
		if (isset($this->error['address'])) {
			$data['error_address'] = $this->error['address'];
		} else {
			$data['error_address'] = '';
		}
		
		if (isset($this->error['appointment_address'])) {
			$data['error_appointment_address'] = $this->error['appointment_address'];
		} else {
			$data['error_appointment_address'] = '';
		}
		
		if (isset($this->error['customer_id'])) {
			$data['error_customer_id'] = $this->error['customer_id'];
		} else {
			$data['error_customer_id'] = '';
		}
		
		if (isset($this->error['hour'])) {
			$data['error_hour'] = $this->error['hour'];
		} else {
			$data['error_hour'] = '';
		}
		
		if (isset($this->error['minutes'])) {
			$data['error_minutes'] = $this->error['minutes'];
		} else {
			$data['error_minutes'] = '';
		}

		$url = '';

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
		
		if (isset($this->request->get['filter_type'])) {
			$url .= '&filter_type=' . $this->request->get['filter_type'];
		}
		
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
			'href' => $this->url->link('common/sales_dashboard', 'token=' . $this->session->data['token'], true)
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

		if(isset($this->request->get['type']))
		{
			$data['cancel'] = $this->url->link('customer/customer_info/appointmentView', 'appointment_id='.$this->request->get['appointment_id'].'&type='.$this->request->get['type'].'&customer_id='.$this->request->get['customer_id'].'&token=' . $this->session->data['token'], true);
		}
		else
		{
			$data['cancel'] = $this->url->link('replogic/schedule_management', 'token=' . $this->session->data['token'] . $url, true);
		}

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
			$time = strtotime($appointment_info['appointment_date']);
			$myFormatForView = date("d-m-Y g:i A", $time); 
			$data['appointment_date'] = $myFormatForView;
		} else {
			$data['appointment_date'] = '';
		}
		
		if (isset($this->request->post['salesrep_id'])) {
			$data['salesrep_id'] = $this->request->post['salesrep_id'];
		} elseif (!empty($appointment_info)) {
			$data['salesrep_id'] = $appointment_info['salesrep_id'];
		} else {
			$data['salesrep_id'] = '';
		}
		
		if (isset($this->request->post['type'])) {
			$data['type'] = $this->request->post['type'];
		} elseif (!empty($appointment_info)) {
			$data['type'] = $appointment_info['type'];
		} else {
			$data['type'] = '';
		}
		
		$prospect_info = array();
		if($data['type'] === 'New Business')
		{
			$prospect_info = $this->model_replogic_schedule_management->getprospective($appointment_info['customer_id']);
		}
		
		if (isset($this->request->post['bcustomer_name'])) {
			$data['bcustomer_name'] = $this->request->post['bcustomer_name'];
		} elseif (!empty($prospect_info)) {
			$data['bcustomer_name'] = $prospect_info['name'];
		} else {
			$data['bcustomer_name'] = '';
		}
		
		if (isset($this->request->post['address'])) {
			$data['address'] = $this->request->post['address'];
		} elseif (!empty($prospect_info)) {
			$data['address'] = $prospect_info['address'];
		} else {
			$data['address'] = '';
		}
		
		if (isset($this->request->post['appointment_address'])) {
			$data['appointment_address'] = $this->request->post['appointment_address'];
		} elseif (!empty($appointment_info)) {
			$data['appointment_address'] = $appointment_info['appointment_address'];
		} else {
			$data['appointment_address'] = '';
		}
		
		if (isset($this->request->post['customer_id'])) {
			$data['customer_id'] = $this->request->post['customer_id'];
		} elseif (!empty($appointment_info)) {
			$data['customer_id'] = $appointment_info['customer_id'];
		} else {
			$data['customer_id'] = '';
		}
		
		if (isset($this->request->post['hour'])) {
			$data['hour'] = $this->request->post['hour'];
		} elseif (!empty($appointment_info)) {
			 $data['hour'] = $appointment_info['duration_hours']; 
		} else {
			$data['hour'] = '';
		}
		
		if (isset($this->request->post['minutes'])) {
			$data['minutes'] = $this->request->post['minutes'];
		} elseif (!empty($appointment_info)) {
			 $data['minutes'] = $appointment_info['duration_minutes']; 
		} else {
			$data['minutes'] = '';
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
	   
	   if (isset($this->request->post['salesrep_id'])) {
			$data['sales_manager'] = $this->request->post['salesrep_id'];
		} elseif (!empty($appointment_info)) {
			$data['sales_manager'] = $appointment_info['salesrep_id'];
		} else {
			$data['sales_manager'] = '';
		}
		
		if($data['sales_manager'])
		{
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
			$filter_customerdata = array('filter_salesrep_id' => $data['sales_manager']);
	   		$data['customers'] = $this->model_customer_customer->getCustomers($filter_customerdata,$allaccess,$current_user_id);
			
		}
		else
		{
			$data['customers'] = '';
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
		
		/*if ((utf8_strlen($this->request->post['appointment_description']) < 3) || (utf8_strlen($this->request->post['appointment_description']) > 64)) {
			$this->error['appointment_description'] = $this->language->get('error_appointment_description');
		}*/
		
		if ((utf8_strlen($this->request->post['appointment_date']) < 3) || (utf8_strlen($this->request->post['appointment_date']) > 64)) {
			$this->error['appointment_date'] = $this->language->get('error_appointment_date');
		}
		
		if ($this->request->post['hour'] == '') {
			$this->error['hour'] = $this->language->get('error_hour');
		}
		
		if ($this->request->post['minutes'] == '') {
			$this->error['minutes'] = $this->language->get('error_minutes');
		}
		
		if ($this->request->post['salesrep_id'] == '') {
			$this->error['salesrep_id'] = $this->language->get('error_salesrep_id');
		}
		
		if ($this->request->post['type'] == '') {
			$this->error['type'] = $this->language->get('error_type');
		}
		else if($this->request->post['type'] == 'New Business')
		{
			if ($this->request->post['bcustomer_name'] == '') 
			{
				$this->error['bcustomer_name'] = $this->language->get('error_bcustomer_name');
			}
			if ($this->request->post['address'] == '') 
			{
				$this->error['address'] = $this->language->get('error_address');
			}
		}
		else if($this->request->post['type'] == 'Existing Business')
		{
			if ($this->request->post['customer_id'] == '') 
			{
				$this->error['customer_id'] = $this->language->get('error_customer_id');
			}
			
			if ($this->request->post['appointment_address'] == '') 
			{
				$this->error['appointment_address'] = $this->language->get('error_appointment_address');
			}
			
		}
		
		return !$this->error;
	}
	
	public function getaddress() {
		
		$this->load->model('customer/customer');
		$customer_id = $this->request->post['customer_id'];
		if($customer_id)
		{
			$cust = $this->model_customer_customer->getCustomerAddressDefault($customer_id);
			$address = $cust['address']; 
		}
		else
		{
			$address = '';
		}
		
		$this->response->addHeader('Content-Type: application/json');
		$this->response->setOutput(json_encode($address));
	}
	
	public function getCustomer() {
		
		$this->load->model('customer/customer');
		$salesrep_id = $this->request->post['salesrep_id'];
		
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
		
		$filter_data = array('filter_salesrep_id' => $salesrep_id);
		
		$customer = $this->model_customer_customer->getCustomers($filter_data,$allaccess,$current_user_id);
		
		$this->response->addHeader('Content-Type: application/json');
		$this->response->setOutput(json_encode($customer));
	}	

}