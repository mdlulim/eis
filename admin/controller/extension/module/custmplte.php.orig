<?php
class ControllerExtensionModuleCustmplte extends Controller {
	private $error = array();

	public function index() {
		$this->load->language('extension/module/custmplte');

		$this->document->setTitle($this->language->get('heading_title'));


		$this->load->model('setting/setting');

		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validate()) {

			$this->model_setting_setting->editSetting($this->user->getId().'_custmplte', $this->request->post);

			$this->session->data['success'] = $this->language->get('text_success');

			$this->response->redirect($this->url->link('customer/customer', 'token=' . $this->session->data['token'], 'SSL'));
		}

		$data['heading_title'] = $this->language->get('heading_title');
		$data['text_edit'] = $this->language->get('text_edit');

		$data['thankyou_custmplte'] = $this->language->get('thankyou_custmplte');
		$data['sales_custmplte'] = $this->language->get('sales_custmplte');
		

		$data['button_save'] = $this->language->get('button_save');
		$data['button_cancel'] = $this->language->get('button_cancel');
		$data['text_default'] = $this->language->get('text_default');

		if (isset($this->error['warning'])) {
			$data['error_warning'] = $this->error['warning'];
		} else {
			$data['error_warning'] = '';
		}

		$data['breadcrumbs'] = array();

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('text_home'),
			'href' => $this->url->link(getDashboard($this->user), 'token=' . $this->session->data['token'], 'SSL')
		);

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('text_module'),
			'href' => $this->url->link('extension/extension', 'token=' . $this->session->data['token'], 'SSL')
		);


		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('heading_title'),
			'href' => $this->url->link('extension/module/custmplte', 'token=' . $this->session->data['token'], 'SSL')
		);

		$data['action'] = $this->url->link('extension/module/custmplte', 'token=' . $this->session->data['token'], 'SSL');
		
		$data['cancel'] = $this->url->link('extension/extension', 'token=' . $this->session->data['token'], 'SSL');
		$data['user_id'] = $this->user->getId();

		$data['token'] = $this->session->data['token'];

		if (isset($this->request->post[$this->user->getId().'_custmplte_thankyoutemplate'])) {
			$data['custmplte_thankyoutemplate'] = $this->request->post[$this->user->getId().'_custmplte_thankyoutemplate'];
		} else {
			$data['custmplte_thankyoutemplate'] = $this->config->get($this->user->getId().'_custmplte_thankyoutemplate');
		}

		if (isset($this->request->post[$this->user->getId().'_custmplte_salestemplate'])) {
			$data['custmplte_salestemplate'] = $this->request->post[$this->user->getId().'_custmplte_salestemplate'];
		} else {
			$data['custmplte_salestemplate'] = $this->config->get($this->user->getId().'_custmplte_salestemplate');
		}

		$this->load->model('localisation/language');
		$data['languages'] = $this->model_localisation_language->getLanguages();


		$data['header'] = $this->load->controller('common/header');
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['footer'] = $this->load->controller('common/footer');

		$this->response->setOutput($this->load->view('extension/module/custmplte', $data));
	}

	protected function validate() {
		if (!$this->user->hasPermission('modify', 'extension/module/custmplte')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}
		return !$this->error;
	}
}