<?php
class ControllerCustomerCustomerExportImport extends Controller { 
	
	public function index() {
		$this->load->language('customer/customer_export_import');
		$this->document->setTitle($this->language->get('heading_title'));
		$this->load->model('customer/customer_export_import');
		$this->getForm();
	}


	public function upload() {
		$this->load->language('customer/customer_export_import');
		$this->document->setTitle($this->language->get('heading_title'));
		$this->load->model('customer/customer_export_import');
		
		if (($this->request->server['REQUEST_METHOD'] == 'POST' && ($this->validateUploadForm())) ) {
			if ((isset( $this->request->files['upload'] )) && (is_uploaded_file($this->request->files['upload']['tmp_name']))) {
				
				$this->load->model('replogic/sales_rep_management');
				$this->load->model('customer/customer_group');
				$this->load->model('localisation/country');
				
				set_time_limit(0);
				ini_set('memory_limit', '1G');
				ini_set("auto_detect_line_endings", true);
				
				$file = $_FILES['upload']['tmp_name'];
				$handle = fopen($file,"r");
				$i = 1;
				while ($data = fgetcsv($handle,1000,",","'")) // parses the line it reads for fields in CSV format and returns an array containing the fields read.
				{ 
					if($i == 2)
					{ 
						$customer_id = trim($data[0]);
						$firstname = trim($data[1]);
						$lastname = trim($data[2]);
						$email = trim($data[3]);
						$telephone = trim($data[4]);
						$companyname = trim($data[5]);
						$address1 = trim($data[6]);
						$address2 = trim($data[7]);
						$city = trim($data[8]);
						$postcode = trim($data[9]);
						$country = trim($data[10]);
						$region = trim($data[11]);
						$password = trim($data[12]);
						$newsletter = trim($data[13]);
						$companygroup = trim($data[14]);
						$approved = trim($data[15]);
						$paymentmethod = trim($data[16]);
						$salesrep = trim($data[17]);
						$status = trim($data[18]);
						
						if(!empty($salesrep))
						{
							$sales = $this->model_replogic_sales_rep_management->getSalesrepByName($salesrep);
							$salesrep_id = $sales['salesrep_id'];
						}
						else
						{
							$salesrep_id = '';
						}
						
						if(!empty($companygroup))
						{
							$groupname = $this->model_customer_customer_group->getCustomerGroupByName($companygroup);
							$customer_group_id = $groupname['customer_group_id'];
						}
						else
						{
							$customer_group_id = '';
						}
						
						if(!empty($country))
						{ 
							$countryname = $this->model_localisation_country->getCountriesByName($country);
							
							$country_id = $countryname['country_id'];
						}
						else
						{
							$country_id = '';
						}
						
						if(!empty($region))
						{
							$zonename = $this->model_localisation_country->getRegionByName($region);
							$zone_id = $zonename['zone_id'];
						}
						else
						{
							$zone_id = '';
						}
						
						$data_array = array(
										'customer_id' => $customer_id,
										'firstname' => $firstname,
										'lastname' => $lastname,
										'email' => $email,
										'telephone' => $telephone,
										'companyname' => $companyname,
										'address1' => $address1,
										'address2' => $address2,
										'city' => $city,
										'postcode' => $postcode,
										'country' => $country_id,
										'region' => $zone_id,
										'password' => $password,
										'newsletter' => $newsletter,
										'companygroup' => $customer_group_id,
										'approved' => $approved,
										'paymentmethod' => $paymentmethod,
										'salesrep' => $salesrep_id,
										'status' => $status
									);
						
						if ($data[0]!='') // if column 1 is not empty
						{
							$this->model_customer_customer_export_import->importCsvCustomerDataUpdate($data_array);  // parse the data to model
							
						}
						else
						{ 
							$this->model_customer_customer_export_import->importCsvCustomerDataInsert($data_array); 
						}
						
					}
					
					$i++;
				}
				$this->session->data['success'] = 'CSV Successfully Imported!';
				
			}
		}

		$this->response->redirect($this->url->link('customer/customer_export_import', 'token=' . $this->session->data['token'], true));
	}

	
	public function download() {
		$this->load->language( 'customer/customer_export_import' );
		$this->document->setTitle($this->language->get('heading_title'));
		$this->load->model( 'customer/customer_export_import' );
		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateDownloadForm()) {
					
					$min = null;
					if (isset( $this->request->post['min'] ) && ($this->request->post['min']!='')) {
						$min = $this->request->post['min'];
					}
					$max = null;
					if (isset( $this->request->post['max'] ) && ($this->request->post['max']!='')) {
						$max = $this->request->post['max'];
					}
					
					if (($min==null) || ($max==null)) {
						$this->model_customer_customer_export_import->downloadCsv();
					} elseif(($min!=null) || ($max!=null)) {
						$this->model_customer_customer_export_import->downloadCsv($min, $max);
					}
					
			}
			//$this->response->redirect( $this->url->link( 'customer/customer_export_import', 'token='.$this->request->get['token'], $this->ssl) );
		
		$this->getForm();
	}


	public function settings() {
		$this->load->language('customer/customer_export_import');
		$this->document->setTitle($this->language->get('heading_title'));
		$this->load->model('customer/customer_export_import');
		if (($this->request->server['REQUEST_METHOD'] == 'POST') && ($this->validateSettingsForm())) {
			
			$this->load->model('setting/setting');
			$this->model_setting_setting->editSetting('customer_export_import', $this->request->post);
			$this->session->data['success'] = $this->language->get('text_success_settings');
			$this->response->redirect($this->url->link('customer/customer_export_import', 'token=' . $this->session->data['token'], $this->ssl));
		}
		$this->getForm();
	}


	protected function getForm() {
		$data = array();
		$data['heading_title'] = $this->language->get('heading_title');
		
		$data['text_export_type_category'] = ($data['exist_filter']) ? $this->language->get('text_export_type_category') : $this->language->get('text_export_type_category_old');
		$data['text_export_type_product'] = ($data['exist_filter']) ? $this->language->get('text_export_type_product') : $this->language->get('text_export_type_product_old');
		$data['text_export_type_poa'] = $this->language->get('text_export_type_poa');
		$data['text_export_type_option'] = $this->language->get('text_export_type_option');
		$data['text_export_type_attribute'] = $this->language->get('text_export_type_attribute');
		$data['text_export_type_filter'] = $this->language->get('text_export_type_filter');
		$data['text_export_type_customer'] = $this->language->get('text_export_type_customer');
		$data['text_yes'] = $this->language->get('text_yes');
		$data['text_no'] = $this->language->get('text_no');
		$data['text_loading_notifications'] = $this->language->get( 'text_loading_notifications' );
		$data['text_retry'] = $this->language->get('text_retry');

		$data['entry_export'] = $this->language->get( 'entry_export' );
		$data['entry_import'] = $this->language->get( 'entry_import' );
		$data['entry_export_type'] = $this->language->get( 'entry_export_type' );
		$data['entry_range_type'] = $this->language->get( 'entry_range_type' );
		$data['entry_start_id'] = $this->language->get( 'entry_start_id' );
		$data['entry_start_index'] = $this->language->get( 'entry_start_index' );
		$data['entry_end_id'] = $this->language->get( 'entry_end_id' );
		$data['entry_end_index'] = $this->language->get( 'entry_end_index' );
		$data['entry_incremental'] = $this->language->get( 'entry_incremental' );
		$data['entry_upload'] = $this->language->get( 'entry_upload' );
		$data['entry_settings_use_option_id'] = $this->language->get( 'entry_settings_use_option_id' );
		$data['entry_settings_use_option_value_id'] = $this->language->get( 'entry_settings_use_option_value_id' );
		$data['entry_settings_use_attribute_group_id'] = $this->language->get( 'entry_settings_use_attribute_group_id' );
		$data['entry_settings_use_attribute_id'] = $this->language->get( 'entry_settings_use_attribute_id' );
		$data['entry_settings_use_filter_group_id'] = $this->language->get( 'entry_settings_use_filter_group_id' );
		$data['entry_settings_use_filter_id'] = $this->language->get( 'entry_settings_use_filter_id' );
		$data['entry_settings_use_export_cache'] = $this->language->get( 'entry_settings_use_export_cache' );
		$data['entry_settings_use_import_cache'] = $this->language->get( 'entry_settings_use_import_cache' );

		$data['tab_export'] = $this->language->get( 'tab_export' );
		$data['tab_import'] = $this->language->get( 'tab_import' );
		$data['tab_settings'] = $this->language->get( 'tab_settings' );

		$data['button_export'] = $this->language->get( 'button_export' );
		$data['button_import'] = $this->language->get( 'button_import' );
		$data['button_settings'] = $this->language->get( 'button_settings' );
		$data['button_export_id'] = $this->language->get( 'button_export_id' );
		$data['button_export_page'] = $this->language->get( 'button_export_page' );

		$data['help_range_type'] = $this->language->get( 'help_range_type' );
		$data['help_incremental_yes'] = $this->language->get( 'help_incremental_yes' );
		$data['help_incremental_no'] = $this->language->get( 'help_incremental_no' );
		$data['help_import'] = ($data['exist_filter']) ? $this->language->get( 'help_import' ) : $this->language->get( 'help_import_old' );
		$data['help_format'] = $this->language->get( 'help_format' );

		$data['error_select_file'] = $this->language->get('error_select_file');
		$data['error_post_max_size'] = str_replace( '%1', ini_get('post_max_size'), $this->language->get('error_post_max_size') );
		$data['error_upload_max_filesize'] = str_replace( '%1', ini_get('upload_max_filesize'), $this->language->get('error_upload_max_filesize') );
		$data['error_id_no_data'] = $this->language->get('error_id_no_data');
		$data['error_page_no_data'] = $this->language->get('error_page_no_data');
		$data['error_param_not_number'] = $this->language->get('error_param_not_number');
		$data['error_notifications'] = $this->language->get('error_notifications');
		$data['error_no_news'] = $this->language->get('error_no_news');
		$data['error_batch_number'] = $this->language->get('error_batch_number');
		$data['error_min_item_id'] = $this->language->get('error_min_item_id');

		if (!empty($this->session->data['export_import_error']['errstr'])) {
			$this->error['warning'] = $this->session->data['export_import_error']['errstr'];
		}

 		if (isset($this->error['warning'])) {
			$data['error_warning'] = $this->error['warning'];
			if (!empty($this->session->data['export_import_nochange'])) {
				$data['error_warning'] .= "<br />\n".$this->language->get( 'text_nochange' );
			}
		} else {
			$data['error_warning'] = '';
		}

		unset($this->session->data['export_import_error']);
		unset($this->session->data['export_import_nochange']);

		if (isset($this->session->data['success'])) {
			$data['success'] = $this->session->data['success'];
		
			unset($this->session->data['success']);
		} else {
			$data['success'] = '';
		}

		$data['breadcrumbs'] = array();
		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('text_home'),
			'href' => $this->url->link('common/dashboard', 'token=' . $this->session->data['token'], $this->ssl)
		);
		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('heading_title'),
			'href' => $this->url->link('customer/customer_export_import', 'token=' . $this->session->data['token'], $this->ssl)
		);

		$data['back'] = $this->url->link('common/dashboard', 'token=' . $this->session->data['token'], $this->ssl);
		$data['button_back'] = $this->language->get( 'button_back' );
		$data['import'] = $this->url->link('customer/customer_export_import/upload', 'token=' . $this->session->data['token'], $this->ssl);
		$data['export'] = $this->url->link('customer/customer_export_import/download', 'token=' . $this->session->data['token'], $this->ssl);
		$data['settings'] = $this->url->link('customer/customer_export_import/settings', 'token=' . $this->session->data['token'], $this->ssl);

		if (isset($this->request->post['export_type'])) {
			$data['export_type'] = $this->request->post['export_type'];
		} else {
			$data['export_type'] = 'p';
		}

		if (isset($this->request->post['range_type'])) {
			$data['range_type'] = $this->request->post['range_type'];
		} else {
			$data['range_type'] = 'id';
		}

		if (isset($this->request->post['min'])) {
			$data['min'] = $this->request->post['min'];
		} else {
			$data['min'] = '';
		}

		if (isset($this->request->post['max'])) {
			$data['max'] = $this->request->post['max'];
		} else {
			$data['max'] = '';
		}

		if (isset($this->request->post['incremental'])) {
			$data['incremental'] = $this->request->post['incremental'];
		} else {
			$data['incremental'] = '1';
		}

		if (isset($this->request->post['customer_export_import_settings_firstname'])) {
			$data['settings_firstname'] = $this->request->post['customer_export_import_settings_firstname'];
		} else if ($this->config->get( 'customer_export_import_settings_firstname' )) {
			$data['settings_firstname'] = '1';
		} else {
			$data['settings_firstname'] = '0';
		}

		if (isset($this->request->post['customer_export_import_settings_lastname'])) {
			$data['settings_lastname'] = $this->request->post['customer_export_import_settings_lastname'];
		} else if ($this->config->get( 'customer_export_import_settings_lastname' )) {
			$data['settings_lastname'] = '1';
		} else {
			$data['settings_lastname'] = '0';
		}

		if (isset($this->request->post['customer_export_import_settings_email'])) {
			$data['settings_email'] = $this->request->post['customer_export_import_settings_email'];
		} else if ($this->config->get( 'customer_export_import_settings_email' )) {
			$data['settings_email'] = '1';
		} else {
			$data['settings_email'] = '0';
		}

		if (isset($this->request->post['customer_export_import_settings_telephone'])) {
			$data['settings_telephone'] = $this->request->post['customer_export_import_settings_telephone'];
		} else if ($this->config->get( 'customer_export_import_settings_telephone' )) {
			$data['settings_telephone'] = '1';
		} else {
			$data['settings_telephone'] = '0';
		}

		if (isset($this->request->post['customer_export_import_settings_companyname'])) {
			$data['settings_companyname'] = $this->request->post['customer_export_import_settings_companyname'];
		} else if ($this->config->get( 'customer_export_import_settings_companyname' )) {
			$data['settings_companyname'] = '1';
		} else {
			$data['settings_companyname'] = '0';
		}

		if (isset($this->request->post['customer_export_import_settings_address1'])) {
			$data['settings_address1'] = $this->request->post['customer_export_import_settings_address1'];
		} else if ($this->config->get( 'customer_export_import_settings_address1' )) {
			$data['settings_address1'] = '1';
		} else {
			$data['settings_address1'] = '0';
		}

		if (isset($this->request->post['customer_export_import_settings_address2'])) {
			$data['settings_address2'] = $this->request->post['customer_export_import_settings_address2'];
		} else if ($this->config->get( 'customer_export_import_settings_address2' )) {
			$data['settings_address2'] = '1';
		} else {
			$data['settings_address2'] = '0';
		}

		if (isset($this->request->post['customer_export_import_settings_city'])) {
			$data['settings_city'] = $this->request->post['customer_export_import_settings_city'];
		} else if ($this->config->get( 'customer_export_import_settings_city' )) {
			$data['settings_city'] = '1';
		} else {
			$data['settings_city'] = '0';
		}
		
		if (isset($this->request->post['customer_export_import_settings_postcode'])) {
			$data['settings_postcode'] = $this->request->post['customer_export_import_settings_postcode'];
		} else if ($this->config->get( 'customer_export_import_settings_postcode' )) {
			$data['settings_postcode'] = '1';
		} else {
			$data['settings_postcode'] = '0';
		}
		
		if (isset($this->request->post['customer_export_import_settings_country'])) {
			$data['settings_country'] = $this->request->post['customer_export_import_settings_country'];
		} else if ($this->config->get( 'customer_export_import_settings_country' )) {
			$data['settings_country'] = '1';
		} else {
			$data['settings_country'] = '0';
		}
		
		if (isset($this->request->post['customer_export_import_settings_region'])) {
			$data['settings_region'] = $this->request->post['customer_export_import_settings_region'];
		} else if ($this->config->get( 'customer_export_import_settings_region' )) {
			$data['settings_region'] = '1';
		} else {
			$data['settings_region'] = '0';
		}
		
		if (isset($this->request->post['customer_export_import_settings_password'])) {
			$data['settings_password'] = $this->request->post['customer_export_import_settings_password'];
		} else if ($this->config->get( 'customer_export_import_settings_password' )) {
			$data['settings_password'] = '1';
		} else {
			$data['settings_password'] = '0';
		}
		
		if (isset($this->request->post['customer_export_import_settings_newsletter'])) {
			$data['settings_newsletter'] = $this->request->post['customer_export_import_settings_newsletter'];
		} else if ($this->config->get( 'customer_export_import_settings_newsletter' )) {
			$data['settings_newsletter'] = '1';
		} else {
			$data['settings_newsletter'] = '0';
		}
		
		if (isset($this->request->post['customer_export_import_settings_companygroup'])) {
			$data['settings_companygroup'] = $this->request->post['customer_export_import_settings_companygroup'];
		} else if ($this->config->get( 'customer_export_import_settings_companygroup' )) {
			$data['settings_companygroup'] = '1';
		} else {
			$data['settings_companygroup'] = '0';
		}
		
		if (isset($this->request->post['customer_export_import_settings_approved'])) {
			$data['settings_approved'] = $this->request->post['customer_export_import_settings_approved'];
		} else if ($this->config->get( 'customer_export_import_settings_approved' )) {
			$data['settings_approved'] = '1';
		} else {
			$data['settings_approved'] = '0';
		}
		
		if (isset($this->request->post['customer_export_import_settings_paymentmethod'])) {
			$data['settings_paymentmethod'] = $this->request->post['customer_export_import_settings_paymentmethod'];
		} else if ($this->config->get( 'customer_export_import_settings_paymentmethod' )) {
			$data['settings_paymentmethod'] = '1';
		} else {
			$data['settings_paymentmethod'] = '0';
		}
		
		if (isset($this->request->post['customer_export_import_settings_salesrep'])) {
			$data['settings_salesrep'] = $this->request->post['customer_export_import_settings_salesrep'];
		} else if ($this->config->get( 'customer_export_import_settings_salesrep' )) {
			$data['settings_salesrep'] = '1';
		} else {
			$data['settings_salesrep'] = '0';
		}
		
		if (isset($this->request->post['customer_export_import_settings_status'])) {
			$data['settings_status'] = $this->request->post['customer_export_import_settings_status'];
		} else if ($this->config->get( 'customer_export_import_settings_status' )) {
			$data['settings_status'] = '1';
		} else {
			$data['settings_status'] = '0';
		}

		
		$data['token'] = $this->session->data['token'];

		$this->document->addStyle('view/stylesheet/export_import.css');

		$data['header'] = $this->load->controller('common/header');
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['footer'] = $this->load->controller('common/footer');

		$this->response->setOutput($this->load->view( ((version_compare(VERSION, '2.2.0.0') >= 0) ? 'customer/export_import' : 'customer/export_import.tpl'), $data));
	}


	protected function validateDownloadForm() {
		if (!$this->user->hasPermission('access', 'customer/customer_export_import')) {
			$this->error['warning'] = $this->language->get('error_permission');
			return false;
		}

		return true;
	}


	protected function validateUploadForm() {
		if (!$this->user->hasPermission('modify', 'customer/customer_export_import')) {
			$this->error['warning'] = $this->language->get('error_permission');
		} else if (!isset( $this->request->post['incremental'] )) {
			$this->error['warning'] = $this->language->get( 'error_incremental' );
		} else if ($this->request->post['incremental'] != '0') {
			if ($this->request->post['incremental'] != '1') {
				$this->error['warning'] = $this->language->get( 'error_incremental' );
			}
		}

		if (!isset($this->request->files['upload']['name'])) {
			if (isset($this->error['warning'])) {
				$this->error['warning'] .= "<br /\n" . $this->language->get( 'error_upload_name' );
			} else {
				$this->error['warning'] = $this->language->get( 'error_upload_name' );
			}
		} else {
			$ext = strtolower(pathinfo($this->request->files['upload']['name'], PATHINFO_EXTENSION));
			if (($ext != 'csv') ) {
				if (isset($this->error['warning'])) {
					$this->error['warning'] .= "<br /\n" . $this->language->get( 'error_upload_ext' );
				} else {
					$this->error['warning'] = $this->language->get( 'error_upload_ext' );
				}
			}
		}

		if (!$this->error) {
			return true;
		} else {
			return false;
		}
	}


	protected function validateSettingsForm() {
		if (!$this->user->hasPermission('access', 'customer/customer_export_import')) {
			$this->error['warning'] = $this->language->get('error_permission');
			return false;
		}

		return true;
	}


	
}
?>