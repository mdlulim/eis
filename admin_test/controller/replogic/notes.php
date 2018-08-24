<?php
class ControllerReplogicNotes extends Controller {
	private $error = array();

	public function index() {
		$this->load->language('replogic/notes');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('replogic/notes');

		$this->getList();
	}

	public function add() {
		$this->load->language('replogic/notes');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('replogic/notes');

		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateForm()) {
			$this->model_replogic_notes->addNote($this->request->post);

			$this->session->data['success'] = $this->language->get('text_success');

			$url = '';

			if (isset($this->request->get['appointment_id'])) {
			$url .= '&appointment_id=' . $this->request->get['appointment_id'];
			}
			
			if (isset($this->request->get['filter_salesrep_id'])) {
				$url .= '&filter_salesrep_id=' . $this->request->get['filter_salesrep_id'];
			}
			
			if (isset($this->request->get['filter_note_title'])) {
				$url .= '&filter_note_title=' . $this->request->get['filter_note_title'];
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

			$this->response->redirect($this->url->link('replogic/notes', 'token=' . $this->session->data['token'] . '&appointment_id=' . $this->request->get['appointment_id'] . $url, true));
		}

		$this->getForm();
	}

	public function edit() {
		$this->load->language('replogic/notes');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('replogic/notes');

		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateForm()) {
			$this->model_replogic_notes->editNote($this->request->get['note_id'], $this->request->post);

			$this->session->data['success'] = $this->language->get('text_success');

			$url = '';

			if (isset($this->request->get['appointment_id'])) {
			$url .= '&appointment_id=' . $this->request->get['appointment_id'];
			}
			
			if (isset($this->request->get['filter_salesrep_id'])) {
				$url .= '&filter_salesrep_id=' . $this->request->get['filter_salesrep_id'];
			}
			
			if (isset($this->request->get['filter_note_title'])) {
				$url .= '&filter_note_title=' . $this->request->get['filter_note_title'];
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

			$this->response->redirect($this->url->link('replogic/notes', 'token=' . $this->session->data['token'] . '&appointment_id=' . $this->request->get['appointment_id'] . $url, true));
		}

		$this->getForm();
	}

	public function delete() {
		$this->load->language('replogic/notes');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('replogic/notes');

		if (isset($this->request->post['selected'])) { 
			foreach ($this->request->post['selected'] as $note_id) {
				$this->model_replogic_notes->deleteNote($note_id);
			}

			$this->session->data['success'] = $this->language->get('text_success');

			$url = '';
			
			if (isset($this->request->get['appointment_id'])) {
			$url .= '&appointment_id=' . $this->request->get['appointment_id'];
			}
			
			if (isset($this->request->get['filter_salesrep_id'])) {
				$url .= '&filter_salesrep_id=' . $this->request->get['filter_salesrep_id'];
			}
			
			if (isset($this->request->get['filter_note_title'])) {
				$url .= '&filter_note_title=' . $this->request->get['filter_note_title'];
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

			$this->response->redirect($this->url->link('replogic/notes', 'token=' . $this->session->data['token'] . '&appointment_id=' . $this->request->get['appointment_id'] . $url, true));
		}

		$this->getList();
	}

	protected function getList() {
		
		if (isset($this->request->get['filter_note_title'])) {
			$filter_note_title = $this->request->get['filter_note_title'];
		} else {
			$filter_note_title = null;
		}
		
		if (isset($this->request->get['filter_salesrep_id'])) {
			$filter_salesrep_id = $this->request->get['filter_salesrep_id'];
		} else {
			$filter_salesrep_id = null;
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
		
		if (isset($this->request->get['appointment_id'])) {
			$appointment_id = $this->request->get['appointment_id'];
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
		
		if (isset($this->request->get['filter_salesrep_id'])) {
			$url .= '&filter_salesrep_id=' . $this->request->get['filter_salesrep_id'];
		}
		
		if (isset($this->request->get['filter_note_title'])) {
			$url .= '&filter_note_title=' . $this->request->get['filter_note_title'];
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
			'text' => $this->language->get('heading_schedule_management'),
			'href' => $this->url->link('replogic/schedule_management', 'token=' . $this->session->data['token'] . $url, true)
		);
		
		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('heading_title'),
			'href' => $this->url->link('replogic/notes', 'token=' . $this->session->data['token'] . $url, true)
		);

		$data['add'] = $this->url->link('replogic/notes/add', 'token=' . $this->session->data['token'] . $url, true);
		$data['delete'] = $this->url->link('replogic/notes/delete', 'token=' . $this->session->data['token'] . '&appointment_id=' . $this->request->get['appointment_id'] . $url, true);
		$data['cancel'] = $this->url->link('replogic/schedule_management', 'token=' . $this->session->data['token'] . $url, true);

		$data['notes'] = array();

		$filter_data = array(
			'filter_note_title'	  => $filter_note_title,
			'filter_salesrep_id' => $filter_salesrep_id,
			'sort'  => $sort,
			'order' => $order,
			'appointment_id' => $appointment_id,
			'start' => ($page - 1) * $this->config->get('config_limit_admin'),
			'limit' => $this->config->get('config_limit_admin')
		);

		$notes_total = $this->model_replogic_notes->getTotalNotes($filter_data);

		$results = $this->model_replogic_notes->getNotes($filter_data);
		
		$this->load->model('user/user');
		$this->load->model('user/user_group');
		
		$current_user = $this->session->data['user_id'];
		$current_user_group_id = $this->model_user_user->getUser($current_user); ;
		$current_user_group = $this->model_user_user_group->getUserGroup($current_user_group_id); ;
		
		if ($this->user->hasPermission('access', 'replogic/notes'))
		{
			$data['access'] = 'yes';
		}
		else
		{
			$data['access'] = 'no';
		}
		
		$user_group_id = $this->model_user_user_group->getUserGroupByName('Sales Manager');
		$data['sales_managers'] = $this->model_user_user->getUsersByGroupId($user_group_id['user_group_id']);
		
		foreach ($results as $result) {
			
		$user = $this->model_user_user->getUser($result['salesrep_id']); ;
		//print_r($user); exit;
	    $sales_manag = $user['firstname'] ." ". $user['lastname']." (".$user['username'].")";
			//print_r($result); exit;
			$data['notes'][] = array(
				'note_id' => $result['note_id'],
				'note_title'          => $result['note_title'],
				'description'          => $result['note_content'],
				'sales_manager'          => $sales_manag,
				'edit'          => $this->url->link('replogic/notes/edit', 'token=' . $this->session->data['token'] . '&appointment_id=' . $this->request->get['appointment_id'] .'&note_id=' . $result['note_id'] . $url, true)
			);
		}

		$data['heading_title'] = $this->language->get('heading_title');
		
		$data['text_list'] = $this->language->get('text_list');
		$data['text_no_results'] = $this->language->get('text_no_results');
		$data['text_confirm'] = $this->language->get('text_confirm');

		$data['column_note_title'] = $this->language->get('column_note_title');
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
		
		if (isset($this->request->get['appointment_id'])) {
			$url .= '&appointment_id=' . $this->request->get['appointment_id'];
		}
		
		if (isset($this->request->get['filter_salesrep_id'])) {
			$url .= '&filter_salesrep_id=' . $this->request->get['filter_salesrep_id'];
		}
		
		if (isset($this->request->get['filter_note_title'])) {
			$url .= '&filter_note_title=' . $this->request->get['filter_note_title'];
		}
		
		if ($order == 'ASC') {
			$url .= '&order=DESC';
		} else {
			$url .= '&order=ASC';
		}

		if (isset($this->request->get['page'])) {
			$url .= '&page=' . $this->request->get['page'];
		}

		$data['sort_note_title'] = $this->url->link('replogic/notes', 'token=' . $this->session->data['token'] . '&sort=note_title' . $url, true);

		$url = '';

		if (isset($this->request->get['appointment_id'])) {
			$url .= '&appointment_id=' . $this->request->get['appointment_id'];
		}
		
		if (isset($this->request->get['filter_salesrep_id'])) {
			$url .= '&filter_salesrep_id=' . $this->request->get['filter_salesrep_id'];
		}
		
		if (isset($this->request->get['filter_note_title'])) {
			$url .= '&filter_note_title=' . $this->request->get['filter_note_title'];
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
		$pagination->url = $this->url->link('replogic/notes', 'token=' . $this->session->data['token'] . $url . '&page={page}', true);

		$data['pagination'] = $pagination->render();

		$data['results'] = sprintf($this->language->get('text_pagination'), ($notes_total) ? (($page - 1) * $this->config->get('config_limit_admin')) + 1 : 0, ((($page - 1) * $this->config->get('config_limit_admin')) > ($notes_total - $this->config->get('config_limit_admin'))) ? $notes_total : ((($page - 1) * $this->config->get('config_limit_admin')) + $this->config->get('config_limit_admin')), $notes_total, ceil($notes_total / $this->config->get('config_limit_admin')));

		$data['sort'] = $sort;
		$data['order'] = $order;
		$data['appointment_id'] = $appointment_id;
		$data['filter_salesrep_id'] = $filter_salesrep_id;
		$data['filter_note_title'] = $filter_note_title;

		$data['header'] = $this->load->controller('common/header');
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['footer'] = $this->load->controller('common/footer');

		$this->response->setOutput($this->load->view('replogic/notes_list', $data));
	}

	protected function getForm() {
		$data['heading_title'] = $this->language->get('heading_title');
		
		$data['text_form'] = !isset($this->request->get['note_id']) ? $this->language->get('text_add') : $this->language->get('text_edit');
		$data['text_select_all'] = $this->language->get('text_select_all');
		$data['text_unselect_all'] = $this->language->get('text_unselect_all');

		$data['entry_name'] = $this->language->get('entry_name');
		$data['entry_note_description'] = $this->language->get('entry_note_description');
		$data['entry_sales'] = $this->language->get('entry_sales');
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

		if (isset($this->error['note_title'])) {
			$data['error_note_title'] = $this->error['note_title'];
		} else {
			$data['error_note_title'] = '';
		}
		
		if (isset($this->error['note_description'])) {
			$data['error_note_description'] = $this->error['note_description'];
		} else {
			$data['error_note_description'] = '';
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
		
		if (isset($this->request->get['filter_salesrep_id'])) {
			$url .= '&filter_salesrep_id=' . $this->request->get['filter_salesrep_id'];
		}
		
		if (isset($this->request->get['filter_note_title'])) {
			$url .= '&filter_note_title=' . $this->request->get['filter_note_title'];
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
			'href' => $this->url->link('replogic/notes', 'token=' . $this->session->data['token'] . '&appointment_id=' . $this->request->get['appointment_id'] . $url, true)
		);

		if (!isset($this->request->get['note_id'])) {
			$data['action'] = $this->url->link('replogic/notes/add', 'token=' . $this->session->data['token'] . '&appointment_id=' . $this->request->get['appointment_id'] . $url, true);
		} else {
			$data['action'] = $this->url->link('replogic/notes/edit', 'token=' . $this->session->data['token'] . '&appointment_id=' . $this->request->get['appointment_id'] . '&note_id=' . $this->request->get['note_id'] . $url, true);
		}

		$data['cancel'] = $this->url->link('replogic/notes', 'token=' . $this->session->data['token'] . '&appointment_id=' . $this->request->get['appointment_id'] . $url, true);

		if (isset($this->request->get['note_id']) && $this->request->server['REQUEST_METHOD'] != 'POST') {
			$note_info = $this->model_replogic_notes->getNote($this->request->get['note_id']);
		}

		if (isset($this->request->post['note_title'])) {
			$data['note_title'] = $this->request->post['note_title'];
		} elseif (!empty($note_info)) {
			$data['note_title'] = $note_info['note_title'];
		} else {
			$data['note_title'] = '';
		}
		
		if (isset($this->request->post['note_description'])) {
			$data['note_description'] = $this->request->post['note_description'];
		} elseif (!empty($note_info)) {
			$data['note_description'] = $note_info['note_content'];
		} else {
			$data['note_description'] = '';
		}
		
		$this->load->model('user/user_group');
		$this->load->model('user/user');
		$user_group_id = $this->model_user_user_group->getUserGroupByName('Sales Manager');
		$data['users'] = $this->model_user_user->getUsersByGroupId($user_group_id['user_group_id']);
	   //print_r($data['users']); exit;
	
		if (isset($this->request->post['salesrep_id'])) {
			$data['sales_manager'] = $this->request->post['salesrep_id'];
		} elseif (!empty($note_info)) {
			$data['sales_manager'] = $note_info['salesrep_id'];
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

		$this->response->setOutput($this->load->view('replogic/notes_form', $data));
	}

	protected function validateForm() {
		if (!$this->user->hasPermission('modify', 'replogic/notes')) {
			$this->error['warning'] = $this->language->get('error_team');
		}

		if ((utf8_strlen($this->request->post['note_title']) < 3) || (utf8_strlen($this->request->post['note_title']) > 64)) {
			$this->error['note_title'] = $this->language->get('error_note_title');
		}
		
		if ((utf8_strlen($this->request->post['note_description']) < 3)) {
			$this->error['note_description'] = $this->language->get('error_note_description');
		}
		
		/*if ($this->request->post['salesrep_id'] == '') {
			$this->error['salesrep_id'] = $this->language->get('error_salesrep_id');
		}*/

		return !$this->error;
	}

}
