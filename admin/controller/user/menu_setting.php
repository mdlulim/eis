<?php
class ControllerUserMenuSetting extends Controller {
	private $error = array();

	public function index() {
		$this->load->language('user/menu_setting');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('user/user_group');
		$this->load->model('user/menu_setting');

		$this->getForm();
	}

	public function edit() {
		$this->load->language('user/menu_setting');
		$this->load->model('user/menu_setting');
		$this->load->model('user/user_group');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('user/user_group');

		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateForm()) {
			
			$this->model_user_menu_setting->editmenusetting($this->request->get['user_group_id'], $this->request->post);

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

			$this->response->redirect($this->url->link('user/user_permission', 'token=' . $this->session->data['token'] . $url, true));
		}

		$this->getForm();
	}

	protected function getForm() {
		$data['heading_title'] = $this->language->get('heading_title');
		
		$data['text_form'] = !isset($this->request->get['user_group_id']) ? $this->language->get('text_add') : $this->language->get('text_edit');
		$data['text_select_all'] = $this->language->get('text_select_all');
		$data['text_unselect_all'] = $this->language->get('text_unselect_all');

		$data['entry_name'] = $this->language->get('entry_name');
		$data['entry_access'] = $this->language->get('entry_access');
		$data['entry_modify'] = $this->language->get('entry_modify');

		$data['button_save'] = $this->language->get('button_save');
		$data['button_cancel'] = $this->language->get('button_cancel');

		if (isset($this->error['warning'])) {
			$data['error_warning'] = $this->error['warning'];
		} else {
			$data['error_warning'] = '';
		}

		if (isset($this->error['user_group_id'])) {
			$data['error_user_group_id'] = $this->error['user_group_id'];
		} else {
			$data['error_user_group_id'] = '';
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
		
		if (isset($this->request->get['user_group_id'])) {
			$url .= '&user_group_id=' . $this->request->get['user_group_id'];
		}
		
		$data['breadcrumbs'] = array();

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('text_home'),
			'href' => $this->url->link(getDashboard($this->user), 'token=' . $this->session->data['token'], true)
		);

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('heading_title'),
			'href' => $this->url->link('user/user_permission', 'token=' . $this->session->data['token'] . $url, true)
		);

		$data['action'] = $this->url->link('user/menu_setting/edit', 'token=' . $this->session->data['token'] . $url, true);
		
		$data['cancel'] = $this->url->link('user/user_permission', 'token=' . $this->session->data['token'] . $url, true);

		if (isset($this->request->get['user_group_id']) && $this->request->server['REQUEST_METHOD'] != 'POST') {
			$user_group_info = $this->model_user_user_group->getUserGroup($this->request->get['user_group_id']);
		}

		$data['user_group_id'] = $this->request->get['user_group_id'];
		$data['usergroups'] = $this->model_user_user_group->getUserGroups();
		
		$data['token'] = $this->session->data['token'];
		
		/*******************************************************************
		 *	Get menu settings for a specific user group
		 *******************************************************************/

		$groupMenuItems = $this->model_user_menu_setting->getCAllMenuSettings($this->request->get['user_group_id']);
		
		$userGroupMenuItems = [];
		foreach ($groupMenuItems as $key => $value) {
			$userGroupMenuItems[] = $value['menu_id'];
		}
		$data['userGroupMenuItems'] = $userGroupMenuItems;
		
		$menuitems = $this->model_user_menu_setting->getAllmenusetting();
		
		foreach($menuitems as $key => &$value){
			$children = $this->model_user_menu_setting->getSubMenu($value['menu_id']);
			if (is_array($children) && !empty($children)) {
				$value['children'] = $children;
				foreach ($value['children'] as $k => &$v) {
					$grandchildren = $this->model_user_menu_setting->getSubMenu($v['menu_id']);
					if (is_array($grandchildren) && !empty($grandchildren)) {
						$v['children'] = $grandchildren;
						
						foreach ($v['children'] as $t => &$l) {
							$lastchildren = $this->model_user_menu_setting->getSubMenu($l['menu_id']);
							if (is_array($lastchildren) && !empty($lastchildren)) {
								$l['children'] = $lastchildren;
							}
						}
						
					}
				}
			}
		}
		$data['menuitems'] = $menuitems;
		// echo "<pre>";
		// print_r($data['menuitems']); 
		// echo "</pre>";exit;
		
		$ignore = array(
			getDashboard($this->user),
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

		$this->response->setOutput($this->load->view('user/menu_setting', $data));
	}

	protected function validateForm() {
		if (!$this->user->hasPermission('modify', 'user/menu_setting')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}

		if ($this->request->post['user_group_id'] == '') {
			$this->error['user_group_id'] = $this->language->get('error_user_group_id');
		}

		return !$this->error;
	}

}