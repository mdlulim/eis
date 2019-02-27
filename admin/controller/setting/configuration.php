<?php
class ControllerSettingConfiguration extends Controller {
	private $error = array();

	public function index() {

		/*==================================
		=   START: Add Files (Includes)    =
		==================================*/

		# stylesheets (CSS) files
		$this->document->addStyle('view/javascript/bootstrap-sweetalert/sweetalert.css');
        $this->document->addStyle('view/stylesheet/custom.css');
        $this->document->addStyle('view/stylesheet/configuration.css');

		# javascript (JS) files
		$this->document->addScript('view/javascript/bootstrap-sweetalert/sweetalert.min.js');
		$this->document->addScript('view/javascript/bootstrap-sweetalert/sweetalert-data.js');
        $this->document->addScript('view/javascript/configuration.js');

		/*==================================
		=     END: Add Files (Includes)    =
		==================================*/

		$this->load->language('setting/configuration');

		$this->load->model('setting/configuration');

		$this->document->setTitle($this->language->get('heading_title'));

		$data['breadcrumbs'] = array();
		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('text_home'),
			'href' => $this->url->link(getDashboard($this->user), 'token=' . $this->session->data['token'], true)
		);
		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('heading_title'),
			'href' => $this->url->link('setting/configuration', 'token=' . $this->session->data['token'], true)
		);

		$data['types']         = $this->model_setting_configuration->getTypes();
		
		$data['token']         = $this->session->data['token'];

        $data['heading_title'] = $this->language->get('heading_title');

		$data['header']        = $this->load->controller('common/header');
		$data['column_left']   = $this->load->controller('common/column_left');
		$data['footer']        = $this->load->controller('common/footer');

		$this->response->setOutput($this->load->view('setting/configuration', $data));
	}

	public function get() {

		$this->load->language('setting/configuration');

		$this->load->model('setting/configuration');

		$json = array();

		if (!empty($this->request->get['category'])) {
			$data = $this->model_setting_configuration->get($this->request->get['category']);
			if (!empty($data)) {
				foreach ($data as $value) {
					$json[$value['section']][] = $value;
				}
			}
		}

		$this->response->addHeader('Content-Type: application/json');
		$this->response->setOutput(json_encode($json));
	}

	public function add() {

		$this->load->language('setting/configuration');

		$this->load->model('setting/configuration');

		$json = array();

		if (!empty($this->request->post)) {
			$confg_field_id                 = $this->model_setting_configuration->addConfigField($this->request->post);
			$json['success']                = true;
			$json['data']                   = $this->request->post;
			$json['data']['value']          = '';
			$json['data']['confg_field_id'] = $confg_field_id;
		}

		$this->response->addHeader('Content-Type: application/json');
		$this->response->setOutput(json_encode($json));
	}

	public function set() {

		$this->load->language('setting/configuration');

		$this->load->model('setting/configuration');

		$json = array();

		if (!empty($this->request->post)) {
			if (is_array($this->request->post['config_field_id'])) {
				foreach ($this->request->post['config_field_id'] as $config_field_id => $config_field_value) {
					$data = array(
						'config_field_id' => $config_field_id,
						'value'           => $config_field_value
					);
					$this->model_setting_configuration->set($data);
				}
				$json['success'] = true;
			}
		}

		$this->response->addHeader('Content-Type: application/json');
		$this->response->setOutput(json_encode($json));
	}
}