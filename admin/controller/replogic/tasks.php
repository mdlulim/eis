<?php
class ControllerReplogicTasks extends Controller {
	private $error = array();

	public function index() {
		$this->load->language('replogic/tasks');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('replogic/tasks');

		$this->getList();
	}

	public function add() {
		$this->load->language('replogic/tasks');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('replogic/tasks');

		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateForm()) {
			$this->model_replogic_tasks->addTasks($this->request->post);

			$this->session->data['success'] = $this->language->get('text_success');

			$url = '';

			if (isset($this->request->get['appointment_id'])) {
				$url .= '&appointment_id=' . $this->request->get['appointment_id'];
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

			$this->response->redirect($this->url->link('replogic/tasks', 'token=' . $this->session->data['token'] . '&appointment_id=' . $this->request->get['appointment_id'] . $url, true));
		}

		$this->getForm();
	}

	public function edit() {
		$this->load->language('replogic/tasks');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('replogic/tasks');

		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateForm()) {
			$this->model_replogic_tasks->editTasks($this->request->get['task_id'], $this->request->post);

			$this->session->data['success'] = $this->language->get('text_success');

			$url = '';

			if (isset($this->request->get['appointment_id'])) {
				$url .= '&appointment_id=' . $this->request->get['appointment_id'];
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

			$this->response->redirect($this->url->link('replogic/tasks', 'token=' . $this->session->data['token'] . '&appointment_id=' . $this->request->get['appointment_id'] . $url, true));
		}

		$this->getForm();
	}

	public function delete() {
		$this->load->language('replogic/tasks');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('replogic/tasks');

		if (isset($this->request->post['selected'])) { 
			foreach ($this->request->post['selected'] as $task_id) {
				$this->model_replogic_tasks->deleteTasks($task_id);
			}

			$this->session->data['success'] = $this->language->get('text_success');

			$url = '';
			
			if (isset($this->request->get['appointment_id'])) {
				$url .= '&appointment_id=' . $this->request->get['appointment_id'];
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

			$this->response->redirect($this->url->link('replogic/tasks', 'token=' . $this->session->data['token'] . '&appointment_id=' . $this->request->get['appointment_id'] . $url, true));
		}

		$this->getList();
	}

	protected function getList() {
		
		if (isset($this->request->get['appointment_id'])) {
			$appointment_id = $this->request->get['appointment_id'];
		}
		
		if (isset($this->request->get['sort'])) {
			$sort = $this->request->get['sort'];
		} else {
			$sort = 'note_title';
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

		if (isset($this->request->get['appointment_id'])) {
				$url .= '&appointment_id=' . $this->request->get['appointment_id'];
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
			'text' => $this->language->get('heading_schedule_management'),
			'href' => $this->url->link('replogic/schedule_management', 'token=' . $this->session->data['token'] . $url, true)
		);
		
		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('heading_title'),
			'href' => $this->url->link('replogic/tasks', 'token=' . $this->session->data['token'] . $url, true)
		);

		$data['add'] = $this->url->link('replogic/tasks/add', 'token=' . $this->session->data['token'] . $url, true);
		$data['delete'] = $this->url->link('replogic/tasks/delete', 'token=' . $this->session->data['token'] . $url, true);
		$data['cancel'] = $this->url->link('replogic/schedule_management', 'token=' . $this->session->data['token'] . $url, true);

		$data['tasks'] = array();

		$filter_data = array(
			'appointment_id' => $appointment_id,
			'sort'  => $sort,
			'order' => $order,
			'appointment_id' => $this->request->get['appointment_id'],
			'start' => ($page - 1) * $this->config->get('config_limit_admin'),
			'limit' => $this->config->get('config_limit_admin')
		);

		$notes_total = $this->model_replogic_tasks->getTotalTasks($filter_data);

		$results = $this->model_replogic_tasks->getTasks($filter_data);
		
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
		
		 $this->load->model('replogic/sales_rep_management');
	   
	  	foreach ($results as $result) {
			
			$salesrep = $this->model_replogic_sales_rep_management->getsalesrep($result['salesrep_id']); ;
			$sales_rep = $salesrep['salesrep_name'] ." ". $salesrep['salesrep_lastname'];
			
			$data['tasks'][] = array(
				'task_id' => $result['task_id'],
				'task_name'          => $result['task_name'],
				'salesrep'          => $sales_rep,
				'status'          => $result['status'],
				'edit'          => $this->url->link('replogic/tasks/edit', 'token=' . $this->session->data['token'] .'&task_id=' . $result['task_id'] . $url, true)
			);
		}

		$data['heading_title'] = $this->language->get('heading_title');
		
		$data['text_list'] = $this->language->get('text_list');
		$data['text_no_results'] = $this->language->get('text_no_results');
		$data['text_confirm'] = $this->language->get('text_confirm');

		$data['column_task_name'] = $this->language->get('column_task_name');
		$data['column_action'] = $this->language->get('column_action');

		$data['button_add'] = $this->language->get('button_add');
		$data['button_edit'] = $this->language->get('button_edit');
		$data['button_delete'] = $this->language->get('button_delete');

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

		if ($order == 'ASC') {
			$url .= '&order=DESC';
		} else {
			$url .= '&order=ASC';
		}
		
		if (isset($this->request->get['appointment_id'])) {
				$url .= '&appointment_id=' . $this->request->get['appointment_id'];
		}
		
		if (isset($this->request->get['page'])) {
			$url .= '&page=' . $this->request->get['page'];
		}

		$data['sort_task_name'] = $this->url->link('replogic/tasks', 'token=' . $this->session->data['token'] . '&sort=task_name' . $url, true);

		$url = '';

		if (isset($this->request->get['appointment_id'])) {
				$url .= '&appointment_id=' . $this->request->get['appointment_id'];
		}
		
		if (isset($this->request->get['sort'])) {
			$url .= '&sort=' . $this->request->get['sort'];
		}

		if (isset($this->request->get['order'])) {
			$url .= '&order=' . $this->request->get['order'];
		}

		$pagination = new Pagination();
		$pagination->total = $notes_total;
		$pagination->page = $page;
		$pagination->limit = $this->config->get('config_limit_admin');
		$pagination->url = $this->url->link('replogic/tasks', 'token=' . $this->session->data['token'] . $url . '&page={page}', true);

		$data['pagination'] = $pagination->render();

		$data['results'] = sprintf($this->language->get('text_pagination'), ($notes_total) ? (($page - 1) * $this->config->get('config_limit_admin')) + 1 : 0, ((($page - 1) * $this->config->get('config_limit_admin')) > ($notes_total - $this->config->get('config_limit_admin'))) ? $notes_total : ((($page - 1) * $this->config->get('config_limit_admin')) + $this->config->get('config_limit_admin')), $notes_total, ceil($notes_total / $this->config->get('config_limit_admin')));

		$data['sort'] = $sort;
		$data['order'] = $order;

		$data['header'] = $this->load->controller('common/header');
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['footer'] = $this->load->controller('common/footer');

		$this->response->setOutput($this->load->view('replogic/tasks_list', $data));
	}

	protected function getForm() {
		$data['heading_title'] = $this->language->get('heading_title');
		
		$data['text_form'] = !isset($this->request->get['task_id']) ? $this->language->get('text_add') : $this->language->get('text_edit');
		$data['text_select_all'] = $this->language->get('text_select_all');
		$data['text_unselect_all'] = $this->language->get('text_unselect_all');
		$data['text_enabled'] = $this->language->get('text_enabled');
		$data['text_disabled'] = $this->language->get('text_disabled');

		$data['entry_task_name'] = $this->language->get('entry_task_name');
		$data['entry_task_description'] = $this->language->get('entry_task_description');
		$data['entry_status'] = $this->language->get('entry_status');
		$data['entry_salesrep'] = $this->language->get('entry_salesrep');
		$data['entry_access'] = $this->language->get('entry_access');
		$data['entry_modify'] = $this->language->get('entry_modify');

		$data['button_save'] = $this->language->get('button_save');
		$data['button_cancel'] = $this->language->get('button_cancel');
		
		$data['appointment_id'] = $this->request->get['appointment_id'];
		
		if (isset($this->error['warning'])) {
			$data['error_warning'] = $this->error['warning'];
		} else {
			$data['error_warning'] = '';
		}

		if (isset($this->error['task_name'])) {
			$data['error_task_name'] = $this->error['task_name'];
		} else {
			$data['error_task_name'] = '';
		}
		
		if (isset($this->error['task_description'])) {
			$data['error_task_description'] = $this->error['task_description'];
		} else {
			$data['error_task_description'] = '';
		}
		
		if (isset($this->error['salesrep_id'])) {
			$data['error_salesrep_id'] = $this->error['salesrep_id'];
		} else {
			$data['error_salesrep_id'] = '';
		}
		
		$url = '';

		if (isset($this->request->get['appointment_id'])) {
				$url .= '&appointment_id=' . $this->request->get['appointment_id'];
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
			'text' => $this->language->get('heading_schedule_management'),
			'href' => $this->url->link('replogic/schedule_management', 'token=' . $this->session->data['token'] . $url, true)
		);
		
		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('heading_title'),
			'href' => $this->url->link('replogic/tasks', 'token=' . $this->session->data['token'] . '&appointment_id=' . $this->request->get['appointment_id'] . $url, true)
		);

		if (!isset($this->request->get['task_id'])) {
			$data['action'] = $this->url->link('replogic/tasks/add', 'token=' . $this->session->data['token'] . $url, true);
		} else {
			$data['action'] = $this->url->link('replogic/tasks/edit', 'token=' . $this->session->data['token'] . '&task_id=' . $this->request->get['task_id'] . $url, true);
		}

		$data['cancel'] = $this->url->link('replogic/tasks', 'token=' . $this->session->data['token'] . $url, true);

		if (isset($this->request->get['task_id']) && $this->request->server['REQUEST_METHOD'] != 'POST') {
			$task_info = $this->model_replogic_tasks->getTask($this->request->get['task_id']);
		}
//print_r($task_info); exit;
		if (isset($this->request->post['task_name'])) {
			$data['task_name'] = $this->request->post['task_name'];
		} elseif (!empty($task_info)) {
			$data['task_name'] = $task_info['task_name'];
		} else {
			$data['task_name'] = '';
		}
		
		if (isset($this->request->post['task_description'])) {
			$data['task_description'] = $this->request->post['task_description'];
		} elseif (!empty($task_info)) {
			$data['task_description'] = $task_info['task_description'];
		} else {
			$data['task_description'] = '';
		}
		
		if (isset($this->request->post['status'])) {
			$data['status'] = $this->request->post['status'];
		} elseif (!empty($task_info)) {
			$data['status'] = $task_info['status'];
		} else {
			$data['status'] = false;
		}
		
		if (isset($this->request->post['salesrep_id'])) {
			$data['salesrep_id'] = $this->request->post['salesrep_id'];
		} elseif (!empty($task_info)) {
			$data['salesrep_id'] = $task_info['salesrep_id'];
		} else {
			$data['salesrep_id'] = '';
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
	   $this->load->model('replogic/sales_rep_management');
	   
	   $data['salesReps'] = $this->model_replogic_sales_rep_management->getSalesRepsDropdown($allaccess, $current_user_id);
	
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

		$this->response->setOutput($this->load->view('replogic/tasks_form', $data));
	}

	protected function validateForm() {
		if (!$this->user->hasPermission('modify', 'replogic/tasks')) {
			$this->error['warning'] = $this->language->get('error_team');
		}

		if ((utf8_strlen($this->request->post['task_name']) < 3) || (utf8_strlen($this->request->post['task_name']) > 64)) {
			$this->error['task_name'] = $this->language->get('error_task_name');
		}
		
		if ((utf8_strlen($this->request->post['task_description']) < 3)) {
			$this->error['task_description'] = $this->language->get('error_task_description');
		}
		
		if ($this->request->post['salesrep_id'] == '') {
			$this->error['salesrep_id'] = $this->language->get('error_salesrep_id');
		}
		
		return !$this->error;
	}

}