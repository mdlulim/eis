<?php
class ControllerReplogicCustomerContact extends Controller {
	private $error = array();

	public function index() {
		$this->load->language('replogic/customer_contact');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('replogic/customer_contact');

		$this->getList();
	}
	
	public function autocomplete() {
		$json = array();

		if (isset($this->request->get['filter_name']) || isset($this->request->get['filter_email'])) {
			if (isset($this->request->get['filter_name'])) {
				$filter_name = $this->request->get['filter_name'];
			} else {
				$filter_name = '';
			}

			$this->load->model('replogic/customer_contact');

			$filter_data = array(
				'filter_name'  => $filter_name,
				'start'        => 0,
				'limit'        => 5
			);

			$results = $this->model_replogic_customer_contact->getcustomercontacts($filter_data);

			foreach ($results as $result) {
				$name = $result['first_name'] ." ". $result['last_name'];
				$json[] = array(
					'customer_con_id'       => $result['customer_con_id'],
					'name'              => strip_tags(html_entity_decode($name, ENT_QUOTES, 'UTF-8'))
				);
			}
		}

		$sort_order = array();

		foreach ($json as $key => $value) {
			$sort_order[$key] = $value['name'];
		}

		array_multisort($sort_order, SORT_ASC, $json);

		$this->response->addHeader('Content-Type: application/json');
		$this->response->setOutput(json_encode($json));
	}
	
	public function AjaxDelete() {
		$this->load->model('replogic/customer_contact');
		$id = $this->request->get['id'];
		$this->model_replogic_customer_contact->deleteCustomercontact($id);
		
		$json = 'success';
		$this->response->addHeader('Content-Type: application/json');
		$this->response->setOutput(json_encode($json));
	}

	public function add() {
		$this->load->language('replogic/customer_contact');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('replogic/customer_contact');

		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateForm()) {
			$this->model_replogic_customer_contact->addCustomercontact($this->request->post);

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

			$this->response->redirect($this->url->link('replogic/customer_contact', 'token=' . $this->session->data['token'] . $url, true));
		}

		$this->getForm();
	}

	public function edit() {
		$this->load->language('replogic/customer_contact');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('replogic/customer_contact');

		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateForm()) {
			$this->model_replogic_customer_contact->editCustomercontact($this->request->get['customer_con_id'], $this->request->post);

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

			if (isset($this->request->get['type'])) 
			{ 
				$this->response->redirect($this->url->link('customer/customer_info/CustomerContactView', 'customer_con_id='.$this->request->get['customer_con_id'].'&type='.$this->request->get['type'].'&customer_id='.$this->request->get['customer_id'].'&token=' . $this->session->data['token'], true));
				
			}
			else
			{ 
				$this->response->redirect($this->url->link('replogic/customer_contact', 'token=' . $this->session->data['token'] . $url, true));
			}
		}

		$this->getForm();
	}

	public function delete() {
		$this->load->language('replogic/customer_contact');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('replogic/customer_contact');

		if (isset($this->request->post['selected'])) {
			foreach ($this->request->post['selected'] as $customer_con_id) {
				$this->model_replogic_customer_contact->deleteCustomercontact($customer_con_id);
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

			$this->response->redirect($this->url->link('replogic/customer_contact', 'token=' . $this->session->data['token'] . $url, true));
		}

		$this->getList();
	}

	protected function getList() {
		
		if (isset($this->request->get['filter_customer_contact_id'])) {
			$filter_customer_contact_id = $this->request->get['filter_customer_contact_id'];
		} else {
			$filter_customer_contact_id = null;
		}

		if (isset($this->request->get['filter_email'])) {
			$filter_email = $this->request->get['filter_email'];
		} else {
			$filter_email = null;
		}

		if (isset($this->request->get['filter_customer_id'])) {
			$filter_customer_id = $this->request->get['filter_customer_id'];
		} else {
			$filter_customer_id = null;
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
			'href' => $this->url->link(getDashboard($this->user), 'token=' . $this->session->data['token'], true)
		);

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('heading_title'),
			'href' => $this->url->link('replogic/customer_contact', 'token=' . $this->session->data['token'] . $url, true)
		);

		$data['add'] = $this->url->link('replogic/customer_contact/add', 'token=' . $this->session->data['token'] . $url, true);
		$data['delete'] = $this->url->link('replogic/customer_contact/delete', 'token=' . $this->session->data['token'] . $url, true);

		$data['customer_contacts'] = array();

		$filter_data = array(
			'filter_customer_contact_id'	  => $filter_customer_contact_id,
			'filter_email'	  => $filter_email,
			'filter_customer_id' => $filter_customer_id,
			'sort'  => $sort,
			'order' => $order,
			'start' => ($page - 1) * $this->config->get('config_limit_admin'),
			'limit' => $this->config->get('config_limit_admin')
		);

		$customer_contact_total = $this->model_replogic_customer_contact->getTotalCustomercontact($filter_data);

		$results = $this->model_replogic_customer_contact->getcustomercontacts($filter_data);
		
		$this->load->model('customer/customer');
		
		foreach ($results as $result) {
		
	    $customers = $this->model_customer_customer->getCustomer($result['customer_id']); ;
		
		$sales_manag = $user['firstname'] ." ". $user['lastname']." (".$user['username'].")";
			$data['customer_contacts'][] = array(
				'customer_con_id' => $result['customer_con_id'],
				'email' => $result['email'],
				'customer' => $customers['firstname'],
				'name'          => $result['first_name'] . '&nbsp;' . $result['last_name'],
				'view'          => $this->url->link('replogic/customer_contact/view', 'token=' . $this->session->data['token'] . '&customer_con_id=' . $result['customer_con_id'] . $url, true),
				'edit'          => $this->url->link('replogic/customer_contact/edit', 'token=' . $this->session->data['token'] . '&customer_con_id=' . $result['customer_con_id'] . $url, true)
			);
		}
		
		$data['customers'] = $this->model_customer_customer->getCustomers();
		$data['allcustomer_contacts'] = $this->model_replogic_customer_contact->getcustomercontacts($filter_data = array('filter_customer_id' => $customer_id));
		
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
		
		if (isset($this->request->get['filter_customer_contact_id'])) {
			$url .= '&filter_customer_contact_id=' . $this->request->get['filter_customer_contact_id'];
		}

		if (isset($this->request->get['filter_customer_id'])) {
			$url .= '&filter_customer_id=' . $this->request->get['filter_customer_id'];
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

		$data['sort_name'] = $this->url->link('replogic/customer_contact', 'token=' . $this->session->data['token'] . '&sort=name' . $url, true);

		$url = '';
		
		if (isset($this->request->get['filter_customer_contact_id'])) {
			$url .= '&filter_customer_contact_id=' . $this->request->get['filter_customer_contact_id'];
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
		$pagination->total = $customer_contact_total;
		$pagination->page = $page;
		$pagination->limit = $this->config->get('config_limit_admin');
		$pagination->url = $this->url->link('replogic/customer_contact', 'token=' . $this->session->data['token'] . $url . '&page={page}', true);

		$data['pagination'] = $pagination->render();

		$data['results'] = sprintf($this->language->get('text_pagination'), ($customer_contact_total) ? (($page - 1) * $this->config->get('config_limit_admin')) + 1 : 0, ((($page - 1) * $this->config->get('config_limit_admin')) > ($customer_contact_total - $this->config->get('config_limit_admin'))) ? $customer_contact_total : ((($page - 1) * $this->config->get('config_limit_admin')) + $this->config->get('config_limit_admin')), $customer_contact_total, ceil($customer_contact_total / $this->config->get('config_limit_admin')));

		$data['filter_customer_contact_id'] = $filter_customer_contact_id;
		$data['filter_email'] = $filter_email;
		$data['filter_customer_id'] = $filter_customer_id;
		$data['sort'] = $sort;
		$data['order'] = $order;

		$data['header'] = $this->load->controller('common/header');
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['footer'] = $this->load->controller('common/footer');

		$this->response->setOutput($this->load->view('replogic/customer_contact_list', $data));
	}
	
	public function View() { 
	
		$this->load->language('replogic/customer_contact');
		$this->load->model('customer/customer');
		$this->load->model('replogic/customer_contact');
		
		$customer_id = $this->request->get['customer_id'];
		$customerdetails = $this->model_customer_customer->getCustomer($customer_id);
		$data['customername'] = $customerdetails['firstname'];
		$data['customer_id'] = $customer_id;
		
		$this->document->setTitle($this->language->get('heading_title'));
		$data['heading_title'] = $this->language->get('heading_title');
		
		$data['text_form'] = !isset($this->request->get['customer_con_id']) ? $this->language->get('text_add') : $this->language->get('text_edit');
		$data['text_select_all'] = $this->language->get('text_select_all');
		$data['text_unselect_all'] = $this->language->get('text_unselect_all');

		$data['entry_first_name'] = $this->language->get('entry_first_name');
		$data['entry_last_name'] = $this->language->get('entry_last_name');
		$data['entry_email'] = $this->language->get('entry_email');
		$data['entry_cellphone_number'] = $this->language->get('entry_cellphone_number');
		$data['entry_telephone_number'] = $this->language->get('entry_telephone_number');
		$data['entry_customer'] = $this->language->get('entry_customer');
		$data['entry_role'] = $this->language->get('entry_role');
		
		$data['entry_access'] = $this->language->get('entry_access');
		$data['entry_modify'] = $this->language->get('entry_modify');

		$data['button_cancel'] = $this->language->get('button_cancel');

		$url = '';

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
			'href' => $this->url->link('replogic/customer_contact', 'token=' . $this->session->data['token'] . $url, true)
		);

		$data['cancel'] = $this->url->link('replogic/customer_contact', 'token=' . $this->session->data['token'] . $url, true);
		$data['editurl'] = $this->url->link('replogic/customer_contact/edit', 'customer_con_id='.$this->request->get['customer_con_id'].'&token=' . $this->session->data['token'] . $url, true);

		if (isset($this->request->get['customer_con_id']) && $this->request->server['REQUEST_METHOD'] != 'POST') {
			$customer_contact_info = $this->model_replogic_customer_contact->getcustomercontact($this->request->get['customer_con_id']);
		}

		$data['first_name'] = $customer_contact_info['first_name']; 
		$data['last_name'] = $customer_contact_info['last_name'];
		$data['email'] = $customer_contact_info['email'];
		$data['telephone_number'] = $customer_contact_info['telephone_number'];
		$data['cellphone_number'] = $customer_contact_info['cellphone_number'];
		$data['role'] = $customer_contact_info['role'];
		$data['ccustomer_id'] = $customer_contact_info['customer_id'];
		
		$this->load->model('customer/customer');
	   $data['customers'] = $this->model_customer_customer->getCustomers();
		
		$data['header'] = $this->load->controller('common/header');
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['footer'] = $this->load->controller('common/footer');

		$this->response->setOutput($this->load->view('replogic/customer_contact_view', $data));
	
	}
	
	protected function getForm() {
		$data['heading_title'] = $this->language->get('heading_title');
		
		$data['text_form'] = !isset($this->request->get['customer_con_id']) ? $this->language->get('text_add') : $this->language->get('text_edit');
		$data['text_select_all'] = $this->language->get('text_select_all');
		$data['text_unselect_all'] = $this->language->get('text_unselect_all');

		$data['entry_first_name'] = $this->language->get('entry_first_name');
		$data['entry_last_name'] = $this->language->get('entry_last_name');
		$data['entry_email'] = $this->language->get('entry_email');
		$data['entry_cellphone_number'] = $this->language->get('entry_cellphone_number');
		$data['entry_telephone_number'] = $this->language->get('entry_telephone_number');
		$data['entry_customer'] = $this->language->get('entry_customer');
		$data['entry_role'] = $this->language->get('entry_role');
		
		$data['entry_access'] = $this->language->get('entry_access');
		$data['entry_modify'] = $this->language->get('entry_modify');

		$data['button_save'] = $this->language->get('button_save');
		$data['button_cancel'] = $this->language->get('button_cancel');

		if (isset($this->error['warning'])) {
			$data['error_warning'] = $this->error['warning'];
		} else {
			$data['error_warning'] = '';
		}

		if (isset($this->error['first_name'])) {
			$data['error_first_name'] = $this->error['first_name'];
		} else {
			$data['error_first_name'] = '';
		}
		
		if (isset($this->error['last_name'])) {
			$data['error_last_name'] = $this->error['last_name'];
		} else {
			$data['error_last_name'] = '';
		}
		
		if (isset($this->error['email'])) {
			$data['error_email'] = $this->error['email'];
		} else {
			$data['error_email'] = '';
		}
		
		if (isset($this->error['telephone_number'])) {
			$data['error_telephone_number'] = $this->error['telephone_number'];
		} else {
			$data['error_telephone_number'] = '';
		}
		
		if (isset($this->error['cellphone_number'])) {
			$data['error_cellphone_number'] = $this->error['cellphone_number'];
		} else {
			$data['error_cellphone_number'] = '';
		}
		
		if (isset($this->error['customer_id'])) {
			$data['error_customer_id'] = $this->error['customer_id'];
		} else {
			$data['error_customer_id'] = '';
		}
		
		if (isset($this->error['role'])) {
			$data['error_role'] = $this->error['role'];
		} else {
			$data['error_role'] = '';
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
		
		if (isset($this->request->get['type'])) {
			$url .= '&type=' . $this->request->get['type'];
		}
		
		if (isset($this->request->get['customer_id'])) {
			$url .= '&customer_id=' . $this->request->get['customer_id'];
		}

		$data['breadcrumbs'] = array();

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('text_home'),
			'href' => $this->url->link('common/sales_dashboard', 'token=' . $this->session->data['token'], true)
		);

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('heading_title'),
			'href' => $this->url->link('replogic/customer_contact', 'token=' . $this->session->data['token'] . $url, true)
		);

		if (!isset($this->request->get['customer_con_id'])) {
			$data['action'] = $this->url->link('replogic/customer_contact/add', 'token=' . $this->session->data['token'] . $url, true);
		} else {
			$data['action'] = $this->url->link('replogic/customer_contact/edit', 'token=' . $this->session->data['token'] . '&customer_con_id=' . $this->request->get['customer_con_id'] . $url, true);
		}

		if(isset($this->request->get['type']))
		{
			$data['cancel'] = $this->url->link('customer/customer_info/CustomerContactView', 'customer_con_id='.$this->request->get['customer_con_id'].'&type='.$this->request->get['type'].'&customer_id='.$this->request->get['customer_id'].'&token=' . $this->session->data['token'], true);
		}
		else
		{
			$data['cancel'] = $this->url->link('replogic/customer_contact', 'token=' . $this->session->data['token'] . $url, true);
		}

		if (isset($this->request->get['customer_con_id']) && $this->request->server['REQUEST_METHOD'] != 'POST') {
			$customer_contact_info = $this->model_replogic_customer_contact->getcustomercontact($this->request->get['customer_con_id']);
		}

		if (isset($this->request->post['first_name'])) {
			$data['first_name'] = $this->request->post['first_name'];
		} elseif (!empty($customer_contact_info)) {
			 $data['first_name'] = $customer_contact_info['first_name']; 
		} else {
			$data['first_name'] = '';
		}
		
		if (isset($this->request->post['last_name'])) {
			$data['last_name'] = $this->request->post['last_name'];
		} elseif (!empty($customer_contact_info)) {
			$data['last_name'] = $customer_contact_info['last_name'];
		} else {
			$data['last_name'] = '';
		}
		
		if (isset($this->request->post['email'])) {
			$data['email'] = $this->request->post['email'];
		} elseif (!empty($customer_contact_info)) {
			$data['email'] = $customer_contact_info['email'];
		} else {
			$data['email'] = '';
		}
		
		if (isset($this->request->post['telephone_number'])) {
			$data['telephone_number'] = $this->request->post['telephone_number'];
		} elseif (!empty($customer_contact_info)) {
			$data['telephone_number'] = $customer_contact_info['telephone_number'];
		} else {
			$data['telephone_number'] = '';
		}
		
		if (isset($this->request->post['cellphone_number'])) {
			$data['cellphone_number'] = $this->request->post['cellphone_number'];
		} elseif (!empty($customer_contact_info)) {
			$data['cellphone_number'] = $customer_contact_info['cellphone_number'];
		} else {
			$data['cellphone_number'] = '';
		}
		
		if (isset($this->request->post['role'])) {
			$data['role'] = $this->request->post['role'];
		} elseif (!empty($customer_contact_info)) {
			$data['role'] = $customer_contact_info['role'];
		} else {
			$data['role'] = '';
		}
		
		$this->load->model('customer/customer');
	    $data['customers'] = $this->model_customer_customer->getCustomers();
	    if (isset($this->request->post['customer_id'])) {
			$data['customer_id'] = $this->request->post['customer_id'];
		} elseif (!empty($customer_contact_info)) {
			$data['customer_id'] = $customer_contact_info['customer_id'];
		} else {
			$data['customer_id'] = '';
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

		$this->response->setOutput($this->load->view('replogic/customer_contact_form', $data));
	}

	protected function validateForm() {
		if (!$this->user->hasPermission('modify', 'replogic/customer_contact')) {
			$this->error['warning'] = $this->language->get('error_customer_contact');
		}

		if ((utf8_strlen($this->request->post['first_name']) < 3) || (utf8_strlen($this->request->post['first_name']) > 64)) {
			$this->error['first_name'] = $this->language->get('error_first_name');
		}
		
		if ((utf8_strlen($this->request->post['last_name']) < 3) || (utf8_strlen($this->request->post['last_name']) > 64)) {
			$this->error['last_name'] = $this->language->get('error_last_name');
		}
		
		if ((utf8_strlen($this->request->post['email']) > 96) || !filter_var($this->request->post['email'], FILTER_VALIDATE_EMAIL)) {
			$this->error['email'] = $this->language->get('error_email');
		}
		
		/*if ((utf8_strlen($this->request->post['role']) < 3) || (utf8_strlen($this->request->post['role']) > 64)) {
			$this->error['role'] = $this->language->get('error_role');
		}
		
		if (utf8_strlen($this->request->post['telephone_number']) < 10) {
			$this->error['telephone_number'] = $this->language->get('error_telephone_number');
		}
		
		if (utf8_strlen($this->request->post['cellphone_number']) < 10) {
			$this->error['cellphone_number'] = $this->language->get('error_cellphone_number');
		}
		
		if ($this->request->post['customer_id'] == '') {
			$this->error['customer_id'] = $this->language->get('error_customer_id');
		}*/
		
		return !$this->error;
	}

}
