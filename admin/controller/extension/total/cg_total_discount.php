<?php
class ControllerExtensionTotalCgTotalDiscount extends Controller {
	private $error = array();
	
	public function installCgTotalDiscount() {
         $this->db->query("CREATE TABLE IF NOT EXISTS `" . DB_PREFIX . "total_discount_group_options` (
       	 	`option_id` int(11) NOT NULL AUTO_INCREMENT,
  		    `customer_group_id` int(11) NOT NULL,
  		    `title` varchar(128) NOT NULL,
  		    `total_from` decimal(15,4) NOT NULL,
  		    `total_to` decimal(15,4) NOT NULL,
  		    `discount` decimal(15,4) NOT NULL,
  		    `type` char(1) NOT NULL,
  		    `tax_class` int(11) NOT NULL,
  		    PRIMARY KEY (`option_id`)
            ) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;");
		 }

	public function index() {
		$this->installCgTotalDiscount();
		$this->load->language('extension/total/cg_total_discount');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('setting/setting');

		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validate()) {
			$status = false;

			foreach ($this->request->post['cg_total_discount'] as $cg_discount_status) {
				if ($cg_discount_status['status']) {
					$status = true;

					break;
				}
			}
			$data = array();
			$data = $this->request->post['cgd_options'];
			$this->load->model('extension/total/cg_total_discount');
			$this->model_extension_total_cg_total_discount->addDiscountOptions($data);
			$this->model_setting_setting->editSetting('cg_total_discount', array_merge($this->request->post, array('cg_total_discount_status' => $status)));

			$this->session->data['success'] = $this->language->get('text_success');
			
			
			if(isset($this->request->post['save_stay']) && $this->request->post['save_stay'] =1 ){
			$this->response->redirect($this->url->link('extension/total/cg_total_discount', 'token=' . $this->session->data['token'], true));
			}else{
            $this->response->redirect($this->url->link('extension/extension', 'token=' . $this->session->data['token'] . '&type=total', true));
			}
			
			
		}
		

		$data['heading_title'] = $this->language->get('heading_title');

		$data['text_edit'] = $this->language->get('text_edit');
		$data['text_enabled'] = $this->language->get('text_enabled');
		$data['text_disabled'] = $this->language->get('text_disabled');
		$data['text_none'] = $this->language->get('text_none');
		$data['text_percentage'] = $this->language->get('text_percentage');
		$data['text_fixed_amount'] = $this->language->get('text_fixed_amount');
		
		$data['tab_global'] = $this->language->get('tab_global');
		
		$data['entry_title'] = $this->language->get('entry_title');
		$data['entry_total_from'] = $this->language->get('entry_total_from');
		$data['entry_total_to'] = $this->language->get('entry_total_to');
		$data['entry_customer_group_discount'] = $this->language->get('entry_customer_group_discount');
		$data['entry_customer_group_discount_type'] = $this->language->get('entry_customer_group_discount_type');
		$data['entry_tax_class'] = $this->language->get('entry_tax_class');
		$data['entry_status'] = $this->language->get('entry_status');
		$data['entry_sort_order'] = $this->language->get('entry_sort_order');
		$data['entry_global_sort_order'] = $this->language->get('entry_global_sort_order');
		
		$data['help_title'] = $this->language->get('help_title');
		$data['help_discount'] = $this->language->get('help_discount');
		$data['help_discount_type'] = $this->language->get('help_discount_type');
		$data['help_total_from'] = $this->language->get('help_total_from');
		$data['help_total_to'] = $this->language->get('help_total_to');
		$data['help_tax_class'] = $this->language->get('help_tax_class');
		$data['help_global_sort_order'] = $this->language->get('help_global_sort_order');

		$data['button_save'] = $this->language->get('button_save');
		$data['button_cancel'] = $this->language->get('button_cancel');
		$data['button_remove'] = $this->language->get('button_remove');
		$data['button_add_discount_options'] = $this->language->get('button_add_discount_options');
		$data['button_save_stay'] = $this->language->get('button_save_stay');

		if (isset($this->error['warning'])) {
			$data['error_warning'] = $this->error['warning'];
		} else {
			$data['error_warning'] = '';
		}

		$data['breadcrumbs'] = array();

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('text_home'),
			'href' => $this->url->link(getDashboard($this->user), 'token=' . $this->session->data['token'], true)
		);

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('text_total'),
			'href' => $this->url->link('extension/extension', 'token=' . $this->session->data['token'], '&type=total', true)
		);

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('heading_title'),
			'href' => $this->url->link('extension/total/cg_total_discount', 'token=' . $this->session->data['token'], true)
		);

		$data['action'] = $this->url->link('extension/total/cg_total_discount', 'token=' . $this->session->data['token'], true);

		$data['cancel'] = $this->url->link('extension/total', 'token=' . $this->session->data['token'], '&type=total', true);
		
		if (isset($this->request->post['layout_route'])) {
			$data['cgd_options'] = $this->request->post['layout_route'];
		} elseif (isset($this->request->get['layout_id'])) {
			$data['cgd_options'] = $this->model_design_layout->getLayoutRoutes($this->request->get['layout_id']);
		} else {
			$data['cgd_options'] = array();
		}
				
		$this->load->model('customer/customer_group');
		
		$data['customer_groups'] = array();
		$results = $this->model_customer_customer_group->getCustomerGroups();

		foreach ($results as $result) {
			$data['customer_groups'][] = array(
				'customer_group_id' => $result['customer_group_id'],
				'name'              => $result['name']
			);
		}
		
		
		$data['total_discount_group_options'] = array();
		$this->load->model('extension/total/cg_total_discount');
		$results2 = $this->model_extension_total_cg_total_discount->getOptions();
		 

		foreach ($results2 as $result2) {
			$data['total_discount_group_options'][] = array(
				'customer_group_id'     			=> $result2['customer_group_id'],
				'cgd_options_title'              	=> $result2['title'],
				'cgd_options_total_from'            => $result2['total_from'],
				'cgd_options_total_to'              => $result2['total_to'],
				'cgd_options_discount'              => $result2['discount'],
				'cgd_options_type'              	=> $result2['type'],
				'cgd_options_tax_class'           	=> $result2['tax_class']
			);
		}
		
		if (isset($this->request->post['cg_total_discount'])) {
			$data['cg_total_discount'] = $this->request->post['cg_total_discount'];
		} else {
			$data['cg_total_discount'] = $this->config->get('cg_total_discount');
		}
		
		$data['cg_total_discount_sort_order'] = $this->config->get('cg_total_discount_sort_order');

		$this->load->model('localisation/tax_class');

		$data['tax_classes'] = $this->model_localisation_tax_class->getTaxClasses();

		$data['header'] = $this->load->controller('common/header');
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['footer'] = $this->load->controller('common/footer');

		$this->response->setOutput($this->load->view('extension/total/cg_total_discount.tpl', $data));
	}

	private function validate() {
		if (!$this->user->hasPermission('modify', 'extension/total/cg_total_discount')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}

		return !$this->error;
	}
}