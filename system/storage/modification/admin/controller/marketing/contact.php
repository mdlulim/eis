<?php
class ControllerMarketingContact extends Controller {
	private $error = array();

	public function index() {
		$this->load->language('marketing/contact');

		$this->document->setTitle($this->language->get('heading_title'));

		$data['heading_title'] = $this->language->get('heading_title');

		$data['text_default'] = $this->language->get('text_default');
		$data['text_newsletter'] = $this->language->get('text_newsletter');
		$data['text_customer_all'] = $this->language->get('text_customer_all');
		$data['text_customer'] = $this->language->get('text_customer');
		$data['text_customer_group'] = $this->language->get('text_customer_group');
		$data['text_affiliate_all'] = $this->language->get('text_affiliate_all');
		$data['text_affiliate'] = $this->language->get('text_affiliate');
		$data['text_product'] = $this->language->get('text_product');
		$data['text_loading'] = $this->language->get('text_loading');

		$data['entry_store'] = $this->language->get('entry_store');
		$data['entry_to'] = $this->language->get('entry_to');
		$data['entry_customer_group'] = $this->language->get('entry_customer_group');
		$data['entry_customer'] = $this->language->get('entry_customer');
		$data['entry_affiliate'] = $this->language->get('entry_affiliate');
		$data['entry_product'] = $this->language->get('entry_product');
		$data['entry_subject'] = $this->language->get('entry_subject');
		$data['entry_message'] = $this->language->get('entry_message');

		$data['entry_template'] = $this->language->get('entry_template');
		$data['entry_preheader'] = $this->language->get('entry_preheader');
		$data['warning_template_content'] = $this->language->get('warning_template_content');
		$data['text_select'] = $this->language->get('text_select');

		$this->load->model('localisation/language');
		$this->load->model('extension/mail/template');

        $templates = $this->model_extension_mail_template->getTemplates(array(
			'emailtemplate_key' => 'admin.newsletter'
		));

		$data['email_templates'] = array();

		foreach($templates as $row) {
			$label = $row['emailtemplate_label'];

			if ($row['emailtemplate_default']) {
				$label = $this->language->get('text_default') . ' - ' . $label;
			}

			$data['email_templates'][] = array(
				'value' => $row['emailtemplate_id'],
				'label' => $label
			);
		}

		$data['languages'] = $this->model_localisation_language->getLanguages();

        $data['templates_action'] = $this->url->link('extension/mail/template/get_template', 'token='.$this->session->data['token'], true);

		$data['help_customer'] = $this->language->get('help_customer');
		$data['help_affiliate'] = $this->language->get('help_affiliate');
		$data['help_product'] = $this->language->get('help_product');

		$data['button_send'] = $this->language->get('button_send');
		$data['button_cancel'] = $this->language->get('button_cancel');

		$data['token'] = $this->session->data['token'];

		$data['breadcrumbs'] = array();

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('text_home'),
			'href' => $this->url->link(getDashboard($this->user), 'token=' . $this->session->data['token'], true)
		);

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('heading_title'),
			'href' => $this->url->link('marketing/contact', 'token=' . $this->session->data['token'], true)
		);

		$data['cancel'] = $this->url->link('marketing/contact', 'token=' . $this->session->data['token'], true);

		$this->load->model('setting/store');

		$data['stores'] = $this->model_setting_store->getStores();

		$this->load->model('customer/customer_group');

		$data['customer_groups'] = $this->model_customer_customer_group->getCustomerGroups();

		$data['header'] = $this->load->controller('common/header');
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['footer'] = $this->load->controller('common/footer');

		$this->response->setOutput($this->load->view('marketing/contact_lang', $data));
	}

	public function send() {
		$this->load->language('marketing/contact');

		$json = array();

		if ($this->request->server['REQUEST_METHOD'] == 'POST') {
			if (!$this->user->hasPermission('modify', 'marketing/contact')) {
				$json['error']['warning'] = $this->language->get('error_permission');
			}

			if (!$this->request->post['subject']) {
				$json['error']['subject'] = $this->language->get('error_subject');
			}

			if (!$this->request->post['message']) {
				$json['error']['message'] = $this->language->get('error_message');
			}

			if (!$json) {
				$this->load->model('setting/store');

				$store_info = $this->model_setting_store->getStore($this->request->post['store_id']);

				if ($store_info) {
					$store_name = $store_info['name'];
				} else {
					$store_name = $this->config->get('config_name');
				}
				
				$this->load->model('setting/setting');
				$setting = $this->model_setting_setting->getSetting('config', $this->request->post['store_id']);
				$store_email = isset($setting['config_email']) ? $setting['config_email'] : $this->config->get('config_email');

				$this->load->model('customer/customer');
$this->load->model('journal2/newsletter');

				$this->load->model('customer/customer_group');

				$this->load->model('marketing/affiliate');

				$this->load->model('sale/order');

				if (isset($this->request->get['page'])) {
					$page = $this->request->get['page'];
				} else {
					$page = 1;
				}

				$email_total = 0;

				$emails = array();

				switch ($this->request->post['to']) {
					case 'newsletter':
						$customer_data = array(
							'filter_newsletter' => 1,
							'start'             => ($page - 1) * 10,
							'limit'             => 10
						);

						$email_total = $this->model_journal2_newsletter->getTotalSubscribers();

						$results = $this->model_journal2_newsletter->getSubscribers($customer_data);

						foreach ($results as $result) {
							$emails[] = array(
								'email' => $result['email'],
								'customer_id' => isset($result['customer_id']) ? $result['customer_id'] : 0,
								'store_id' => isset($result['store_id']) ? $result['store_id'] : 0,
								'language_id' => isset($result['language_id']) ? $result['language_id'] : 0
							);
						}
						break;
					case 'customer_all':
						$customer_data = array(
							'start' => ($page - 1) * 10,
							'limit' => 10
						);

						$email_total = $this->model_customer_customer->getTotalCustomers($customer_data);

						$results = $this->model_customer_customer->getCustomers($customer_data);

						foreach ($results as $result) {
							$emails[] = array(
								'email' => $result['email'],
								'customer_id' => isset($result['customer_id']) ? $result['customer_id'] : 0,
								'store_id' => isset($result['store_id']) ? $result['store_id'] : 0,
								'language_id' => isset($result['language_id']) ? $result['language_id'] : 0
							);
						}
						break;
					case 'customer_group':
						$customer_data = array(
							'filter_customer_group_id' => $this->request->post['customer_group_id'],
							'start'                    => ($page - 1) * 10,
							'limit'                    => 10
						);

						$email_total = $this->model_customer_customer->getTotalCustomers($customer_data);

						$results = $this->model_customer_customer->getCustomers($customer_data);

						foreach ($results as $result) {
							$emails[] = array(
								'email' => $result['email'],
								'customer_id' => isset($result['customer_id']) ? $result['customer_id'] : 0,
								'store_id' => isset($result['store_id']) ? $result['store_id'] : 0,
								'language_id' => isset($result['language_id']) ? $result['language_id'] : 0
							);
						}
						break;
					case 'customer':
						if (!empty($this->request->post['customer'])) {
							foreach ($this->request->post['customer'] as $customer_id) {
								$customer_info = $this->model_customer_customer->getCustomer($customer_id);

								if ($customer_info) {
									$email_total = 1;

									$emails[] = array(
										'customer' => $customer_info,
										'email' => $customer_info['email'],
										'customer_id' => $customer_info['customer_id'],
										'store_id' => $customer_info['store_id'],
										'language_id' => $customer_info['language_id']
									);
								}
							}
						}
						break;
					case 'affiliate_all':
						$affiliate_data = array(
							'start' => ($page - 1) * 10,
							'limit' => 10
						);

						$email_total = $this->model_marketing_affiliate->getTotalAffiliates($affiliate_data);

						$results = $this->model_marketing_affiliate->getAffiliates($affiliate_data);

						foreach ($results as $result) {
							$emails[] = array(
								'email' => $result['email'],
								'affiliate_id' => $result['affiliate_id']
							);
						}
						break;
					case 'affiliate':
						if (!empty($this->request->post['affiliate'])) {
							foreach ($this->request->post['affiliate'] as $affiliate_id) {
								$affiliate_info = $this->model_marketing_affiliate->getAffiliate($affiliate_id);

								if ($affiliate_info) {
									$email_total = 1;

									$emails[] = array(
										'affiliate' => $affiliate_info,
										'email' => $affiliate_info['email'],
										'affiliate_id' => $affiliate_info['affiliate_id']
									);
								}
							}
						}
						break;
					case 'product':
						if (isset($this->request->post['product'])) {
							$email_total = $this->model_sale_order->getTotalEmailsByProductsOrdered($this->request->post['product']);

							$results = $this->model_sale_order->getEmailsByProductsOrdered($this->request->post['product'], ($page - 1) * 10, 10);

							foreach ($results as $result) {
								$emails[] = array(
								'email' => $result['email'],
								'customer_id' => isset($result['customer_id']) ? $result['customer_id'] : 0,
								'store_id' => isset($result['store_id']) ? $result['store_id'] : 0,
								'language_id' => isset($result['language_id']) ? $result['language_id'] : 0
							);
							}
						}
						break;
				}

				if ($emails) {
					$json['success'] = sprintf($this->language->get('text_success_sent'), $email_total);

					$start = ($page - 1) * 10;
					$end = $start + 10;

					if ($end < $email_total) {
						if ($start) {
			$json['success'] = sprintf($this->language->get('text_sent'), $start, $email_total);
		} else {
			$json['success'] = sprintf($this->language->get('text_sent'), count($emails), $email_total);
		}
					}

					if ($end < $email_total) {
						$json['next'] = str_replace('&amp;', '&', $this->url->link('marketing/contact/send', 'token=' . $this->session->data['token'] . '&page=' . ($page + 1), true));
					} else {
						$json['next'] = '';
					}

					foreach ($emails as $email_info) {
						$email = $email_info['email'];

						if (isset($email_info['language_id']) && $email_info['language_id']) {
							$language_id = $email_info['language_id'];
						} else {
							$language_id = $this->config->get('config_language_id');
						}

						if ($this->request->post['store_id'] == 0 && isset($email_info['store_id'])) {
 							$store_id = $email_info['store_id'];
						} else {
							$store_id = $this->request->post['store_id'];
						}

						$this->load->model('extension/mail/template');

						$template_load = array(
							'key' => 'admin.newsletter',
							'language_id' => $language_id,
							'store_id' => $store_id
						);

						if (isset($email_info['customer']) && isset($email_info['customer']['customer_id'])) {
							$template_load['customer_id'] = $email_info['customer']['customer_id'];
						} elseif (isset($email_info['customer_id'])) {
							if ($email_info['customer_id']) {
								$template_load['customer_id'] = $email_info['customer_id'];
							} else {
								$this->load->model('customer/customer');

								$customer_info = $this->model_customer_customer->getCustomerByEmail($email);

								if ($customer_info) {
									$template_load['customer_id'] = $email_info['customer_id'];
								}
							}
						}

						$template = $this->model_extension_mail_template->load($template_load);

						if (isset($email_info['customer'])) {
							$template->addData($email_info['customer']);
							unset($email_info['customer']);
						} elseif (isset($template_load['customer_id'])) {
							$customer_info = $this->model_customer_customer->getCustomer($template_load['customer_id']);
							if ($customer_info) {
								$template->addData($customer_info);
							}
						}

						if (isset($email_info['affiliate'])) {
							$template->addData($email_info['affiliate']);
							unset($email_info['affiliate']);
						} elseif (isset($email_info['affiliate_id'])) {
							$affiliate_info = $this->model_sale_affiliate->getAffiliate($email_info['affiliate_id']);
							$template->addData($affiliate_info);
						}

						if (!empty($template->data['emailtemplate']['unsubscribe_text']) && in_array($this->request->post['to'], array('newsletter', 'customer_all', 'customer_group', 'customer'))) {
							$url = (isset($store_info['url']) ? $store_info['url'] : HTTP_CATALOG) . 'index.php?route=' . rawurlencode('account/newsletter/unsubscribe') . '&code='.md5($email);
							$template->data['unsubscribe'] = sprintf(html_entity_decode($template->data['emailtemplate']['unsubscribe_text'], ENT_QUOTES, 'UTF-8'), $url);
					    }

						if (is_array($this->request->post['subject']) && !empty($this->request->post['subject'][$language_id])) {
							$subject = $this->request->post['subject'][$language_id];
						} else {
							$subject = $this->config->get('config_name');
						}

						if (is_array($this->request->post['preview']) && !empty($this->request->post['preview'][$language_id])) {
							$template->data['preheader_preview'] = $this->request->post['preview'][$language_id];
						}

						if (is_array($this->request->post['message']) && !empty($this->request->post['message'][$language_id])) {
							$body = $this->request->post['message'][$language_id];
						} else {
							$body = $store_name;
						}

						$template->addData($email_info);
		
					$message  = '<html dir="ltr" lang="en">' . "\n";
					$message .= '  <head>' . "\n";
					$message .= '    <title></title>' . "\n";
					$message .= '    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">' . "\n";
					$message .= '  </head>' . "\n";
					$message .= '  <body>' . html_entity_decode($message, ENT_QUOTES, 'UTF-8') . '</body>' . "\n";
					$message .= '</html>' . "\n";

					
						if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
							$mail = new Mail();
							$mail->protocol = $this->config->get('config_mail_protocol');
							$mail->parameter = $this->config->get('config_mail_parameter');
							$mail->smtp_hostname = $this->config->get('config_mail_smtp_hostname');
							$mail->smtp_username = $this->config->get('config_mail_smtp_username');
							$mail->smtp_password = html_entity_decode($this->config->get('config_mail_smtp_password'), ENT_QUOTES, 'UTF-8');
							$mail->smtp_port = $this->config->get('config_mail_smtp_port');
							$mail->smtp_timeout = $this->config->get('config_mail_smtp_timeout');

							$mail->setTo($email);
							$mail->setFrom($store_email);
							$mail->setSender(html_entity_decode($store_name, ENT_QUOTES, 'UTF-8'));
							
							$template->build();

							$template->fetch(null, $body);

							$mail->setSubject($subject);

							$template->hook($mail);
							$mail->send();
							$this->model_extension_mail_template->sent();
						}
					}
				} else {
					$json['error']['email'] = $this->language->get('error_email');
				}
			}
		}

		$this->response->addHeader('Content-Type: application/json');
		$this->response->setOutput(json_encode($json));
	}
}