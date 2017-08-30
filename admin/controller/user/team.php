<?php
class ControllerUserTeam extends Controller {
	private $error = array();

	public function index() {
		$this->load->language('user/team');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('user/team');

		$this->getList();
	}

	public function add() {
		$this->load->language('user/team');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('user/team');

		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateForm()) {
			$this->model_user_team->addTeam($this->request->post);

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

			$this->response->redirect($this->url->link('user/team', 'token=' . $this->session->data['token'] . $url, true));
		}

		$this->getForm();
	}

	public function edit() {
		$this->load->language('user/team');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('user/team');

		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateForm()) {
			$this->model_user_team->editTeam($this->request->get['team_id'], $this->request->post);

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

			$this->response->redirect($this->url->link('user/team', 'token=' . $this->session->data['token'] . $url, true));
		}

		$this->getForm();
	}

	public function delete() {
		$this->load->language('user/team');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('user/team');

		if (isset($this->request->post['selected'])) {
			foreach ($this->request->post['selected'] as $team_id) {
				$this->model_user_team->deleteTeam($team_id);
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

			$this->response->redirect($this->url->link('user/team', 'token=' . $this->session->data['token'] . $url, true));
		}

		$this->getList();
	}

	protected function getList() {
		if (isset($this->request->get['sort'])) {
			$sort = $this->request->get['sort'];
		} else {
			$sort = 'team_name';
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
			'href' => $this->url->link('user/team', 'token=' . $this->session->data['token'] . $url, true)
		);

		$data['add'] = $this->url->link('user/team/add', 'token=' . $this->session->data['token'] . $url, true);
		$data['delete'] = $this->url->link('user/team/delete', 'token=' . $this->session->data['token'] . $url, true);

		$data['teams'] = array();

		$filter_data = array(
			'sort'  => $sort,
			'order' => $order,
			'start' => ($page - 1) * $this->config->get('config_limit_admin'),
			'limit' => $this->config->get('config_limit_admin')
		);

		$team_total = $this->model_user_team->getTotalTeam();

		$results = $this->model_user_team->getTeams($filter_data);
		
		$this->load->model('user/user');
		
		foreach ($results as $result) {
			
		$user = $this->model_user_user->getUser($result['sales_manager']); ;
		//print_r($user); exit;
	    $sales_manag = $user['firstname'] . $user['lastname']." (".$user['username'].")";
			
			$data['teams'][] = array(
				'team_id' => $result['team_id'],
				'team_name'          => $result['team_name'],
				'sales_manager'          => $sales_manag,
				'edit'          => $this->url->link('user/team/edit', 'token=' . $this->session->data['token'] . '&team_id=' . $result['team_id'] . $url, true)
			);
		}

		$data['heading_title'] = $this->language->get('heading_title');
		
		$data['text_list'] = $this->language->get('text_list');
		$data['text_no_results'] = $this->language->get('text_no_results');
		$data['text_confirm'] = $this->language->get('text_confirm');

		$data['column_team_name'] = $this->language->get('column_team_name');
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

		if (isset($this->request->get['page'])) {
			$url .= '&page=' . $this->request->get['page'];
		}

		$data['sort_team_name'] = $this->url->link('user/team', 'token=' . $this->session->data['token'] . '&sort=team_name' . $url, true);

		$url = '';

		if (isset($this->request->get['sort'])) {
			$url .= '&sort=' . $this->request->get['sort'];
		}

		if (isset($this->request->get['order'])) {
			$url .= '&order=' . $this->request->get['order'];
		}

		$pagination = new Pagination();
		$pagination->total = $team_total;
		$pagination->page = $page;
		$pagination->limit = $this->config->get('config_limit_admin');
		$pagination->url = $this->url->link('user/team', 'token=' . $this->session->data['token'] . $url . '&page={page}', true);

		$data['pagination'] = $pagination->render();

		$data['results'] = sprintf($this->language->get('text_pagination'), ($team_total) ? (($page - 1) * $this->config->get('config_limit_admin')) + 1 : 0, ((($page - 1) * $this->config->get('config_limit_admin')) > ($team_total - $this->config->get('config_limit_admin'))) ? $team_total : ((($page - 1) * $this->config->get('config_limit_admin')) + $this->config->get('config_limit_admin')), $team_total, ceil($team_total / $this->config->get('config_limit_admin')));

		$data['sort'] = $sort;
		$data['order'] = $order;

		$data['header'] = $this->load->controller('common/header');
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['footer'] = $this->load->controller('common/footer');

		$this->response->setOutput($this->load->view('user/team_list', $data));
	}

	protected function getForm() {
		$data['heading_title'] = $this->language->get('heading_title');
		
		$data['text_form'] = !isset($this->request->get['team_id']) ? $this->language->get('text_add') : $this->language->get('text_edit');
		$data['text_select_all'] = $this->language->get('text_select_all');
		$data['text_unselect_all'] = $this->language->get('text_unselect_all');

		$data['entry_name'] = $this->language->get('entry_name');
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

		if (isset($this->error['team_name'])) {
			$data['error_team_name'] = $this->error['team_name'];
		} else {
			$data['error_team_name'] = '';
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
			'href' => $this->url->link('user/team', 'token=' . $this->session->data['token'] . $url, true)
		);

		if (!isset($this->request->get['team_id'])) {
			$data['action'] = $this->url->link('user/team/add', 'token=' . $this->session->data['token'] . $url, true);
		} else {
			$data['action'] = $this->url->link('user/team/edit', 'token=' . $this->session->data['token'] . '&team_id=' . $this->request->get['team_id'] . $url, true);
		}

		$data['cancel'] = $this->url->link('user/team', 'token=' . $this->session->data['token'] . $url, true);

		if (isset($this->request->get['team_id']) && $this->request->server['REQUEST_METHOD'] != 'POST') {
			$team_info = $this->model_user_team->getTeam($this->request->get['team_id']);
		}

		if (isset($this->request->post['team_name'])) {
			$data['team_name'] = $this->request->post['team_name'];
		} elseif (!empty($team_info)) {
			$data['team_name'] = $team_info['team_name'];
		} else {
			$data['team_name'] = '';
		}
		
		$this->load->model('user/user_group');
		$this->load->model('user/user');
		$user_group_id = $this->model_user_user_group->getUserGroupByName('Sales Manager');
		$data['users'] = $this->model_user_user->getUsersByGroupId($user_group_id['user_group_id']); ;
	   //print_r($data['users']); exit;
	
		if (isset($this->request->post['sales_manager'])) {
			$data['sales_manager'] = $this->request->post['sales_manager'];
		} elseif (!empty($team_info)) {
			$data['sales_manager'] = $team_info['sales_manager'];
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

		$this->response->setOutput($this->load->view('user/team_form', $data));
	}

	protected function validateForm() {
		if (!$this->user->hasPermission('modify', 'user/team')) {
			$this->error['warning'] = $this->language->get('error_team');
		}

		if ((utf8_strlen($this->request->post['team_name']) < 3) || (utf8_strlen($this->request->post['team_name']) > 64)) {
			$this->error['team_name'] = $this->language->get('error_team_name');
		}

		return !$this->error;
	}

}