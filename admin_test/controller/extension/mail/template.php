<?php

class ControllerExtensionMailTemplate extends Controller {

	protected $data = array();

	private $error = array();

	private $_css = array(
		'view/stylesheet/extension/emailtemplate.css'
	);

	private $_js = array(
		'view/javascript/emailtemplate/core.js'
	);

	private $content_count = 3;

	public function __construct($registry) {
		parent::__construct($registry);

		$this->load->language('extension/mail/template');

		$this->load->model('extension/mail/template');
	}

	/**
	 * List Of Email Templates & Config
	 */
	public function index() {
		if (!$this->installed()) {
			$this->response->redirect($this->url->link('extension/mail/template/installer', 'token='.$this->session->data['token'], true));
		} else {
			$chk = $this->db->query("SELECT count(1) AS total FROM `". DB_PREFIX . "emailtemplate`");

			if ($chk->num_rows  && $chk->row['total'] <= 1) {
				$this->response->redirect($this->url->link('extension/mail/template/installer', 'token='.$this->session->data['token'], true));
			}
		}

		if ($this->model_extension_mail_template->checkVersion() !== false) {
			if ($this->model_extension_mail_template->upgrade()) {
				$this->session->data['success'] = $this->language->get('upgrade_success');

				$this->response->redirect($this->url->link('extension/mail/template', 'token='.$this->session->data['token'], true));
			}
		}

		$url = '';

		if (isset($this->request->get['filter_type'])) {
			$url .= '&filter_type=' . $this->request->get['filter_type'];
		}

		if (isset($this->request->get['sort'])) {
			$url .= '&sort=' . $this->request->get['sort'];
		} else {
			$url .= '&sort=modified';
		}

		if (isset($this->request->get['order'])) {
			$url .= '&order=' . $this->request->get['order'];
		} else {
			$url .= '&order=DESC';
		}

		if (isset($this->request->get['page'])) {
			$url .= '&page=' . $this->request->get['page'];
		}

		if (isset($this->request->get['action'])) {
			if (empty($this->request->post['selected'])) {
				$this->session->data['attention'] = $this->language->get('error_template_selection_empty');

				$this->response->redirect($this->url->link('extension/mail/template', 'token='.$this->session->data['token'] . $url, true));
			}

			switch($this->request->get['action']) {
				case 'delete':
					$result = $this->model_extension_mail_template->deleteTemplate($this->request->post['selected']);

					if ($result) {
						$this->session->data['success'] = sprintf($this->language->get('success_delete_template'), $result, (($result > 1) ? "'s" : ""));

						$this->session->data['attention'] = sprintf($this->language->get('text_template_changed'), $this->url->link('extension/mail/template/modification', 'token='.$this->session->data['token'], true));

						$this->response->redirect($this->url->link('extension/mail/template', 'token='.$this->session->data['token'] . $url, true));
					}
				break;

				case 'disable':
				case 'enable':
					$result = $this->model_extension_mail_template->updateTemplatesStatus($this->request->post['selected'], ($this->request->get['action'] == 'enable'));

					if ($result) {
						$this->session->data['success'] = sprintf($this->language->get('success_status_template_update'), $result, (($result > 1) ? "'s" : ""));

						$this->session->data['attention'] = sprintf($this->language->get('text_template_changed'), $this->url->link('extension/mail/template/modification', 'token='.$this->session->data['token'], true));

						$this->response->redirect($this->url->link('extension/mail/template', 'token='.$this->session->data['token'] . $url, true));
					}
				break;

				case 'delete_shortcode':
					foreach ($this->request->post['selected'] as $template_id) {
						$this->model_extension_mail_template->deleteTemplateShortcodes($template_id);
					}

					$this->session->data['success'] = $this->language->get('success_delete_shortcode');

					$this->response->redirect($this->url->link('extension/mail/template', 'token='.$this->session->data['token'] . $url, true));
				break;
			}
		}

		$this->_setTitle();

		$this->_messages();

		$this->_breadcrumbs();

		$this->data['action'] = $this->url->link('extension/mail/template', 'token='.$this->session->data['token'] . $url, true);

		$this->data['cancel'] = $this->url->link('extension/extension', 'token='.$this->session->data['token'] . '&type=mail', true);

		$this->data['config_url'] = $this->url->link('extension/mail/template/config', 'token='.$this->session->data['token'] . '&id=1', true);
		$this->data['modification_url'] = $this->url->link('extension/mail/template/modification', 'token='.$this->session->data['token'], true);
		$this->data['send_url'] = $this->url->link('extension/mail/template/send_email', 'token='.$this->session->data['token'], true);
		$this->data['logs_url'] = $this->url->link('extension/mail/template/logs', 'token='.$this->session->data['token'], true);

		$this->data['support_url'] = 'http://support.opencart-templates.co.uk/open.php';

		if (defined('VERSION')) {
			$ocVer = VERSION;
		} else {
			$ocVer = '';
		}

		$i = 1;
		foreach(array('name'=>$this->config->get("config_owner").' - '.$this->config->get("config_name"), 'email'=>$this->config->get("config_email"), 'protocol'=>$this->config->get("config_mail_protocol"), 'storeUrl'=>HTTP_CATALOG, 'version'=>$this->model_extension_mail_template->getVersion(), 'opencartVersion'=>$ocVer, 'phpVersion'=>phpversion()) as $key=>$val) {
			$this->data['support_url'] .= (($i == 1) ? '?' : '&amp;') . $key . '=' . html_entity_decode($val,ENT_QUOTES,'UTF-8');
			$i++;
		}

		$this->data['action_insert_template'] = $this->url->link('extension/mail/template/template', 'token='.$this->session->data['token'], true);

		$this->data['clear_cache_url'] = $this->url->link('extension/mail/template/clear', 'token='.$this->session->data['token'], true);

		$this->data['button_clear_cache'] = $this->language->get('button_clear_cache');
		$this->data['button_restore'] = $this->language->get('button_restore');

		$this->data['templates_restore'] = array();

		$template_restore = $this->model_extension_mail_template->getTemplatesRestore();

		if ($template_restore) {
			foreach($template_restore as $key) {
				$this->data['templates_restore'][] = array(
					'name' => $key,
					'url' => $this->url->link('extension/mail/template/template_restore', 'token='.$this->session->data['token'] . '&key='. $key, true)
				);
			}
		}

		$this->_template_list();

		$this->load->model('localisation/language');

		$this->data['languages'] = $this->model_localisation_language->getLanguages();

		$this->_js[] = 'view/javascript/emailtemplate/extension.js';

		$this->_output('extension/mail/template/extension');
	}

	/**
	 * Config Form
	 */
	public function config() {
		if (isset($this->request->get['action'])) {
			switch($this->request->get['action']) {
				case 'create':
					if (!empty($this->request->post['id'])) {
						$copy_id = $this->request->post['id'];
					} else if (!empty($this->request->get['id'])) {
						$copy_id = $this->request->get['id'];
					}

					if ($copy_id && $this->_validateConfigCreate($this->request->post)) {
						$newId = $this->model_extension_mail_template->cloneConfig($copy_id, $this->request->post);

						if ($newId) {
							$this->session->data['success'] = $this->language->get('success_config');
							$this->response->redirect($this->url->link('extension/mail/template/config', 'token='.$this->session->data['token'].'&id='.$newId, true));
						}
					}
					break;
				case 'delete':
					if (isset($this->request->get['id']) && $this->model_extension_mail_template->deleteConfig($this->request->get['id'])) {
						if ($this->request->get['id'] == 0) {
							$this->session->data['success'] = $this->language->get('success_config_restore');
						} else {
							$this->session->data['success'] = $this->language->get('success_config_delete');
						}
					}

					$this->response->redirect($this->url->link('extension/mail/template/config', 'token='.$this->session->data['token'] . '&id=1', true));
					break;
			}
		}

		// Save
	    if (isset($this->request->get['id']) && ($this->request->server['REQUEST_METHOD'] == 'POST') && $this->_validateConfig($this->request->post)) {
			$request = $this->request->post;

			$checkboxes = array(
				'emailtemplate_config_email_responsive',
				'emailtemplate_config_log',
				'emailtemplate_config_log_read',
				'emailtemplate_config_showcase_cycle',
				'emailtemplate_config_showcase_related',
				'emailtemplate_config_status',
				'emailtemplate_config_view_browser_theme'
			);

			foreach($checkboxes as $checkbox) {
				if (!isset($request[$checkbox])) {
					$request[$checkbox] = 0;
				}
			}
		    if (!isset($request['emailtemplate_config_order_products']['quantity_column'])) {
			    $request['emailtemplate_config_order_products']['quantity_column'] = 0;
		    }
		    if (!isset($request['emailtemplate_config_order_products']['admin_stock'])) {
			    $request['emailtemplate_config_order_products']['admin_stock'] = 0;
		    }

	        // check style changed
	        $config = $this->model_extension_mail_template->getConfig($this->request->get['id'], true);
	        if ($config['emailtemplate_config_style'] != $request['emailtemplate_config_style']) {
	            $request = $this->_config_style($request);
	        }

	        // Fix for summernote editor - empty content
		    foreach (array(
	             'emailtemplate_config_page_footer_text',
	             'emailtemplate_config_header_html',
	             'emailtemplate_config_head_text',
	             'emailtemplate_config_footer_text',
	             'emailtemplate_config_view_browser_text'
             ) as $key) {
			    if(!empty($request[$key])){
				    if(is_array($request[$key])) {
				    	foreach ($request[$key] as $language_id => $val) {
						    if ( strip_tags(html_entity_decode($request[$key][$language_id], ENT_QUOTES, 'UTF-8')) == '') {
							    $request[$key][$language_id] = '';
						    }
					    }
				    }
			    } elseif ( strip_tags(html_entity_decode($request[$key], ENT_QUOTES, 'UTF-8')) == '') {
				    $request[$key] = '';
			    }
		    }

	        // Combine
			foreach(array(
				'emailtemplate_config_header_spacing' => 2,
				'emailtemplate_config_footer_spacing' => 2,
				'emailtemplate_config_page_spacing' => 2,

				'emailtemplate_config_page_padding' => 4,
				'emailtemplate_config_showcase_padding' => 4,
				'emailtemplate_config_footer_padding' => 4,

		        'emailtemplate_config_header_border_radius' => 4,
		        'emailtemplate_config_header_border_top' => 2,
		        'emailtemplate_config_header_border_bottom' => 2,
		        'emailtemplate_config_header_border_right' => 2,
		        'emailtemplate_config_header_border_left' => 2,

		        'emailtemplate_config_footer_border_radius' => 4,
		        'emailtemplate_config_footer_border_top' => 2,
		        'emailtemplate_config_footer_border_bottom' => 2,
		        'emailtemplate_config_footer_border_right' => 2,
		        'emailtemplate_config_footer_border_left' => 2,

		        'emailtemplate_config_page_border_radius' => 4,
		        'emailtemplate_config_page_border_top' => 2,
		        'emailtemplate_config_page_border_bottom' => 2,
		        'emailtemplate_config_page_border_right' => 2,
		        'emailtemplate_config_page_border_left' => 2,

		        'emailtemplate_config_showcase_border_radius' => 4,
		        'emailtemplate_config_showcase_border_top' => 2,
		        'emailtemplate_config_showcase_border_bottom' => 2,
		        'emailtemplate_config_showcase_border_right' => 2,
		        'emailtemplate_config_showcase_border_left' => 2
			) as $key => $length){
	        	if (empty($request[$key])) {
			        $request[$key] = '';
		        }

				if (is_array($request[$key]) && count($request[$key]) == $length){
					ksort($request[$key]);

					// Remove white space
					foreach($request[$key] as $i => $val) {
						$request[$key][$i] = preg_replace('/\s+/','',$val);
					}

					$request[$key] = implode(', ', $request[$key]);
				}
			}

	        if ($this->model_extension_mail_template->updateConfig($this->request->get['id'], $request)) {
	            $this->session->data['success'] = $this->language->get('success_config');
	        }

	        if (!empty($this->request->post['setting'])) {
		        $this->load->model('setting/setting');

		        $this->model_setting_setting->editSetting('emailtemplate', $this->request->post['setting']);
	        }

            $this->response->redirect($this->url->link('extension/mail/template/config', 'token='.$this->session->data['token'].'&id='.$this->request->get['id'], true));
	    }

	    $this->_messages();

		$this->_css[] = 'view/javascript/bootstrap/css/bootstrap-colorpicker.min.css';
		$this->_css[] = 'view/javascript/summernote/summernote.css';
		$this->_js[] = 'view/javascript/summernote/summernote.js';
		$this->_js[] = 'view/javascript/summernote/opencart.js';
		$this->_js[] = 'view/javascript/bootstrap/js/bootstrap-colorpicker.min.js';
		$this->_js[] = 'view/javascript/bootstrap/js/bootstrap-checkbox.min.js';
		$this->_js[] = 'view/javascript/emailtemplate/config.js';

		if (isset($this->request->get['id'])) {
			$this->_config_form();
			$this->_output('extension/mail/template/config');
		} else {
			$this->_config_form_create();
			$this->_output('extension/mail/template/config_create_form');
		}
	}

	/**
	 * Template Details
	 */
	public function template() {
		if (isset($this->request->get['id'], $this->request->get['action'])) {
			switch($this->request->get['action']) {
				case 'delete':
					$result = $this->model_extension_mail_template->deleteTemplate($this->request->get['id']);

					if ($result) {
						$this->session->data['success'] = sprintf($this->language->get('success_delete_template'), $result, (($result > 1) ? "'s" : ""));
						$this->response->redirect($this->url->link('extension/mail/template', 'token='.$this->session->data['token'], true));
					}
				break;

				case 'delete_shortcode':
					if (isset($this->request->post['shortcode_selection'])) {
						if ($this->model_extension_mail_template->deleteTemplateShortcodes($this->request->get['id'], array('emailtemplate_shortcode_id' => $this->request->post['shortcode_selection']))) {
							$this->session->data['success'] = $this->language->get('success_delete_shortcode');
						}
					} else {
						if ($this->model_extension_mail_template->deleteTemplateShortcodes($this->request->get['id'])) {
							$this->session->data['success'] = $this->language->get('success_delete_shortcode');
						}
					}
				break;

				case 'default_shortcode':
					if ($this->model_extension_mail_template->insertDefaultTemplateShortcodes($this->request->get['id'])) {
						$this->session->data['success'] = $this->language->get('text_success');
					}
				break;
			}

			$url = '&id='.$this->request->get['id'];

			if (isset($this->request->get['sort'])) {
				$url .= '&sort=' . $this->request->get['sort'];
			}
			if (isset($this->request->get['order'])) {
				$url .= '&order=' . $this->request->get['order'];
			}
			if (isset($this->request->get['page'])) {
				$url .= '&page=' . $this->request->get['page'];
			}

			$this->response->redirect($this->url->link('extension/mail/template/template', 'token='.$this->session->data['token'] . $url, true));
		}

		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->_validateTemplate($this->request->post)) {
			$url = '';

			if (isset($this->request->get['id'])) {
				// Update
				$request = $this->request->post;

				$original = $this->model_extension_mail_template->getTemplate($this->request->get['id']);

				$checkboxes = array(
					'emailtemplate_mail_html',
					'emailtemplate_mail_plain_text',
					'emailtemplate_mail_queue',
					'emailtemplate_view_browser',
					'emailtemplate_attach_invoice',
					'emailtemplate_showcase',
					'emailtemplate_status',
					'emailtemplate_log'
				);

				foreach($checkboxes as $checkbox) {
					if (!isset($request[$checkbox])) {
						$request[$checkbox] = 0;
					}
				}

				// Fix for summernote editor - empty content
				for ($i = 1; $i <= $this->content_count; $i++) {
					if(!empty($request['emailtemplate_description_content' . $i])){
						foreach(array_keys($request['emailtemplate_description_content' . $i]) as $langId){
							if(strip_tags(html_entity_decode($request['emailtemplate_description_content' . $i][$langId], ENT_QUOTES, 'UTF-8')) == ''){
								$request['emailtemplate_description_content' . $i][$langId] = '';
							}
						}
					}
				}

				if ($this->model_extension_mail_template->updateTemplate($this->request->get['id'], $request)) {
					$this->session->data['success'] = $this->language->get('text_success');

					if($original['emailtemplate_status'] != $request['emailtemplate_status']){
						$this->session->data['attention'] = sprintf($this->language->get('text_template_changed'), $this->url->link('extension/mail/template/modification', 'token='.$this->session->data['token'], true));
					}
				}
				$url .= '&id='.$this->request->get['id'];
			} else {
				// Insert
				$request = $this->request->post;

				// Key
				if (!$request['emailtemplate_key'] && $request['emailtemplate_key_select']) {
					$defaultTemplate = $this->model_extension_mail_template->getTemplate($request['emailtemplate_key_select']);

					$request['default_emailtemplate_id'] = $defaultTemplate['emailtemplate_id'];

					unset($defaultTemplate['emailtemplate_id']);
					unset($defaultTemplate['emailtemplate_label']);
					unset($defaultTemplate['emailtemplate_modified']);

					$request = array_merge($defaultTemplate, $request);

					$result = $this->model_extension_mail_template->getTemplateDescription(array('emailtemplate_id' => $request['default_emailtemplate_id']));

					foreach($result as $row) {
						foreach($row as $col => $val) {
							if(!isset($request[$col]) || !is_array($request[$col])){
								$request[$col] = array();
							}
							$request[$col][$row['language_id']] = $val;
						}
					}

					$request['emailtemplate_key'] = $request['emailtemplate_key_select'];
					$request['emailtemplate_default'] = 0;
					$request['emailtemplate_shortcodes'] = 0;
					$request['store_id'] = 'NULL';
				} else {
					$request['emailtemplate_default'] = 1;
					$request['emailtemplate_shortcodes'] = 1;
				}

				$id = $this->model_extension_mail_template->insertTemplate($request);

				if ($id) {
					$url .= '&id='.$id;
					$this->session->data['success'] = $this->language->get('success_insert');
				}
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

			$this->response->redirect($this->url->link('extension/mail/template/template', 'token='.$this->session->data['token'] . $url, true));
		}

		$this->_css[] = 'view/javascript/summernote/summernote.css';
		$this->_js[] = 'view/javascript/summernote/summernote.js';
		$this->_js[] = 'view/javascript/summernote/opencart.js';
		$this->_js[] = 'view/javascript/bootstrap/js/bootstrap-checkbox.min.js';
		$this->_js[] = 'view/javascript/emailtemplate/template.js';

		if (isset($this->request->get['id'])) {
			$this->_template_form();
			$this->_output('extension/mail/template/template_form');
		} else {
			$this->_template_form_create();
			$this->_output('extension/mail/template/template_create_form');
		}
	}

	/**
	 * Logs
	 */
	public function logs() {
		$this->load->model('customer/customer');
		$this->load->model('customer/customer_group');

		$this->model_extension_mail_template->clearTemplateLogs();

		foreach(array(
			'button_cancel',
			'button_delete',
			'button_edit_template',
			'button_html',
			'button_load',
			'button_plain_text',
			'button_reply',
			'column_from',
			'column_sent',
			'column_read',
			'column_subject',
			'column_to',
			'entry_config',
			'entry_store',
			'heading_logs',
			'text_confirm',
			'text_customer',
			'text_from',
			'text_no_results',
			'text_read',
			'text_read_last',
			'text_resend',
			'text_search',
			'text_select',
			'text_subject',
			'text_template',
			'text_to'
		) as $var) {
			$this->data[$var] = $this->language->get($var);
		}

		if (isset($this->request->get['store_id']) && is_numeric($this->request->get['store_id'])) {
			$this->data['filter_store_id'] = $this->request->get['store_id'];
		} else {
			$this->data['filter_store_id'] = null;
		}

		if (isset($this->request->get['filter_emailtemplate_id'])) {
			$this->data['filter_emailtemplate_id'] = $this->request->get['filter_emailtemplate_id'];
		} else {
			$this->data['filter_emailtemplate_id'] = '';
		}
		if (isset($this->request->get['filter_emailtemplate_config_id'])) {
			$this->data['filter_emailtemplate_config_id'] = $this->request->get['filter_emailtemplate_config_id'];
		} else {
			$this->data['filter_emailtemplate_config_id'] = '';
		}

		if (isset($this->request->get['filter_store_id'])) {
			$this->data['filter_store_id'] = $this->request->get['filter_store_id'];
		} else {
			$this->data['filter_store_id'] = '';
		}

		if (isset($this->request->get['filter_customer_id'])) {
			$this->data['filter_customer_id'] = $this->request->get['filter_customer_id'];
		} else {
			$this->data['filter_customer_id'] = '';
		}

		if (isset($this->request->get['sort'])) {
			$sort = $this->request->get['sort'];
		} else {
			$sort = 'sent';
		}

		if (isset($this->request->get['order'])) {
			$order = $this->request->get['order'];
		} else {
			$order = 'DESC';
		}

		if (isset($this->request->get['page'])) {
			$page = $this->request->get['page'];
		} else {
			$page = 1;
		}

		if (isset($this->request->get['limit']) && $this->request->get['limit'] <= 100) {
			$limit = $this->request->get['limit'];
		} else {
			$limit = $this->config->get('config_limit_admin');
		}

		$url = '';
		if ($order == 'ASC') {
			$url .= '&order=ASC';
		} else {
			$url .= '&order=DESC';
		}

		if (isset($this->request->get['limit'])) {
			$url .= '&limit=' . $this->request->get['limit'];
		}

		if (isset($this->request->get['filter_emailtemplate_id'])) {
			$url .= '&filter_emailtemplate_id=' . $this->request->get['filter_emailtemplate_id'];
		}

		if (isset($this->request->get['filter_customer_id'])) {
			$url .= '&filter_customer_id=' . $this->request->get['filter_customer_id'];
		}

		if (isset($this->request->get['filter_store_id'])) {
			$url .= '&filter_store_id=' . $this->request->get['filter_store_id'];
		}

		if (!empty($this->request->post['selected'])) {
			$result = $this->model_extension_mail_template->deleteLogs($this->request->post['selected']);
			if ($result) {
				$this->session->data['success'] = sprintf($this->language->get('success_delete_log'), $result, ($result > 1 ? '\'s' : ''));
			}
			$this->response->redirect($this->url->link('extension/mail/template/logs', 'token='.$this->session->data['token'].$url, true));
		}

		$this->_setTitle($this->language->get('heading_logs'));

		$this->_messages();

		$this->_breadcrumbs(array('heading_logs' => array(
			'link' => 'extension/mail/template/logs'
		)));

		$filter = array();
		$filter['start'] = ($page - 1) * $limit;
		$filter['limit'] = $limit;
		$filter['order'] = $order;
		$filter['sort'] = $sort;
		$filter['emailtemplate_id'] = $this->data['filter_emailtemplate_id'];
		$filter['store_id'] = $this->data['filter_store_id'];
		$filter['customer_id'] = $this->data['filter_customer_id'];

		$result = $this->model_extension_mail_template->getTemplateLogs($filter);

		$total = $this->model_extension_mail_template->getTotalTemplateLogs($filter);

		$link = $this->url->link('extension/mail/template/logs', 'token='.$this->session->data['token'] . $url . '&page={page}', true);

		$this->_renderPagination($link, $page, $total, $limit, 'select');

		if (isset($this->request->get['page'])) {
			$url .= '&page=' . $this->request->get['page'];
		}

		$this->data['action'] = $this->url->link('extension/mail/template/logs', 'token='.$this->session->data['token'] . $url, true);

		$this->data['cancel'] = $this->url->link('extension/mail/template', 'token='.$this->session->data['token'], true);

		$this->data['logs'] = array();

		foreach($result as $row) {
			$row['emailtemplate_log_preview'] = $this->_truncate_str($row['emailtemplate_log_subject'], 50);

			if ($row['emailtemplate_log_sent'] && $row['emailtemplate_log_sent'] != '0000-00-00 00:00:00') {
				$time = strtotime($row['emailtemplate_log_sent']);
				if (date('Ymd') == date('Ymd', $time)) {
					$row['emailtemplate_log_sent'] = date($this->language->get('time_format'), $time);
				} else {
					$row['emailtemplate_log_sent'] = date($this->language->get('date_format_short'), $time);
				}
			} else {
				$row['emailtemplate_log_sent'] = '';
			}

			if ($row['emailtemplate_log_read'] && $row['emailtemplate_log_read'] != '0000-00-00 00:00:00') {
				$time = strtotime($row['emailtemplate_log_read']);
				if (date('Ymd') == date('Ymd', $time)) {
					$row['emailtemplate_log_read'] = date($this->language->get('time_format'), $time);
				} else {
					$row['emailtemplate_log_read'] = date($this->language->get('date_format_short'), $time);
				}
			} else {
				$row['emailtemplate_log_read'] = '';
			}

			if ($row['emailtemplate_id']) {
				$row['emailtemplate'] = $this->model_extension_mail_template->getTemplate($row['emailtemplate_id'], $this->config->get('config_language_id'), true);
				if ($row['emailtemplate']) {
					$row['emailtemplate']['url_edit'] = $this->url->link('extension/mail/template/template', 'token='.$this->session->data['token'] . '&id=' . $row['emailtemplate_id'], true);

					$row['resend'] = $this->url->link('extension/mail/template/send_email', 'token='.$this->session->data['token'] . '&emailtemplate_log_id=' . $row['emailtemplate_log_id'], true);
				}
			}

			if ($row['store_id'] >= 0) {
				$stores = $this->model_extension_mail_template->getStores($row['store_id']);

				if (isset($stores[$row['store_id']])) {
					$row['store'] = $stores[$row['store_id']];
				} else {
					$row['store'] = current($stores);
				}
			}

			$row['action'] = array();

			if ($row['customer_id']) {
				$customer = $this->model_customer_customer->getCustomer($row['customer_id']);
				if ($customer) {
					$row['customer'] = $customer;
					$row['customer']['url_edit'] = $this->url->link('customer/customer/edit', 'token='.$this->session->data['token'] . '&customer_id=' . $row['customer_id'], true);
				}
			} else {
				$customer = $this->model_customer_customer->getCustomerByEmail($row['emailtemplate_log_to']);
				if ($customer) {
					$row['customer'] = $customer;
					$row['customer_id'] = $customer['customer_id'];
					$row['customer']['url_edit'] = $this->url->link('customer/customer/edit', 'token='.$this->session->data['token'] . '&customer_id=' . $row['customer_id'], true);
				}
			}

			$this->data['logs'][] = $row;
		}

		$this->data['emailtemplates'] = $this->model_extension_mail_template->getTemplates(array(), true);

		$emailtemplate_configs = $this->model_extension_mail_template->getConfigs(array(), true, true);

		if ($emailtemplate_configs) {
			$this->data['emailtemplate_configs'] = array();

			foreach($emailtemplate_configs as $row) {
				$this->data['emailtemplate_configs'][] = array(
					'emailtemplate_config_id' => $row['emailtemplate_config_id'],
					'emailtemplate_config_name' => $row['emailtemplate_config_name']
				);
			}
		}

		$this->data['stores'] = $this->model_extension_mail_template->getStores();

		if (isset($this->request->get['filter_customer_id'])) {
			$customer = $this->model_customer_customer->getCustomer($this->request->get['customer_id']);

			$this->data['filter_customer'] = strip_tags(html_entity_decode($customer['firstname'] . ' ' . $customer['lastname'], ENT_QUOTES, 'UTF-8'));
		} else {
			$this->data['filter_customer'] = '';
		}

		$url = '';
		if ($order == 'ASC') {
			$url .= '&order=DESC';
		} else {
			$url .= '&order=ASC';
		}

		if (isset($this->request->get['limit'])) {
			$url .= '&limit=' . $this->request->get['limit'];
		}

		if (isset($this->request->get['filter_emailtemplate_id'])) {
			$url .= '&filter_emailtemplate_id=' . $this->request->get['filter_emailtemplate_id'];
		}

		if (isset($this->request->get['filter_customer_id'])) {
			$url .= '&filter_customer_id=' . $this->request->get['filter_customer_id'];
		}

		if (isset($this->request->get['filter_customer'])) {
			$url .= '&filter_customer=' . $this->request->get['filter_customer'];
		}

		if (isset($this->request->get['filter_customer_group_id'])) {
			$url .= '&filter_customer_group_id=' . $this->request->get['filter_customer_group_id'];
		}

		if (isset($this->request->get['filter_store_id'])) {
			$url .= '&filter_store_id=' . $this->request->get['filter_store_id'];
		}

		$this->data['sort'] = $sort;
		$this->data['order'] = $order;
		$this->data['total'] = $total;

		foreach(array('subject', 'to', 'from',  'sent', 'read', 'store', 'emailtemplate') as $var) {
			$this->data['sort_'.$var] = $this->url->link('extension/mail/template/logs', 'token='.$this->session->data['token'] . '&sort=' . $var . $url, true);
		}

		$this->_js[] = 'view/javascript/emailtemplate/logs.js';

		$this->_output('extension/mail/template/logs');
	}

	/**
	 * Get Template & Parse Tags
	 */
	public function get_template() {
		if (!isset($this->request->get['id'])) return false;

		$return = array();

		$template_data = array(
			'emailtemplate_id' => $this->request->get['id']
		);

		if (isset($this->request->get['store_id'])) {
			$template_data['store_id'] = $this->request->get['store_id'];
		}

		if (isset($this->request->get['language_id'])) {
			$template_data['language_id'] = $this->request->get['language_id'];

			$template = $this->model_extension_mail_template->load($template_data);

			if ($template) {
				$template->data['insert_shortcodes'] = false;

				if (isset($this->request->get['parse']) && !$this->request->get['parse']) {
					$template->data['parse_shortcodes'] = false;
				}

				$template->build();

				$return[$template_data['language_id']] = $template->data;
			}
		} else {
			$this->load->model('localisation/language');

			$languages = $this->model_localisation_language->getLanguages();

			foreach($languages as $language) {
				$template_data['language_id'] = $language['language_id'];

				$template = $this->model_extension_mail_template->load($template_data);

				if ($template) {
					$template->data['insert_shortcodes'] = false;

					if (isset($this->request->get['parse']) && !$this->request->get['parse']) {
						$template->data['parse_shortcodes'] = false;
					}

					if ($template) {
						$template->build();

						$return[$language['language_id']] = $template->data;
					}
				}
			}
		}

		$this->response->addHeader('Content-Type: application/json');
		$this->response->setOutput(json_encode($return));
		return true;
	}

	/**
	 * Get Template Shortcodes
	 *
	 * @deprecated
	 */
	public function get_template_shortcodes() {
		$filter = array();

		if (!empty($this->request->get['id'])) {
			$filter['emailtemplate_id'] = $this->request->get['id'];
		} elseif (!empty($this->request->get['key'])) {
			$filter['emailtemplate_key'] = $this->request->get['key'];
		} else {
			return false;
		}

		$return = $this->model_extension_mail_template->getTemplateShortcodes($filter, true);

		$this->response->addHeader('Content-Type: application/json');
		$this->response->setOutput(json_encode($return));
		return true;
	}

	/**
	 * Edit Shortcode
	 */
	public function template_shortcode() {
		if (!isset($this->request->get['id'])) {
			$this->response->redirect($this->url->link('extension/mail/template', 'token='.$this->session->data['token'], true));
		}

		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->_validateTemplateShortcode($this->request->post)) {
			$url = '';
			$return = array();

			if (isset($this->request->get['id'])) {
				if ($this->model_extension_mail_template->updateTemplateShortcode($this->request->get['id'], $this->request->post)) {
					$return['success'] = $this->language->get('text_success');
				}
			} else {
				$id = $this->model_extension_mail_template->insertTemplateShortcode($this->request->post);
				if ($id) {
					$url .= '&id='.$id;
					$return['success'] = $this->language->get('success_insert');
				}
			}

			$this->response->addHeader('Content-Type: application/json');
			$this->response->setOutput(json_encode($return));

			return true;
		}

		$this->_template_shortcode_form();

		$this->_css[] = 'view/stylesheet/emailtemplate/modal.css';

		$this->_output('extension/mail/template/template_shortcode_form');
	}

	/**
	 * Restore Template
	 */
	public function template_restore($data = array()) {
		if (!isset($this->request->get['key'])) {
			$this->response->redirect($this->url->link('extension/mail/template', 'token='.$this->session->data['token'], true));
		}

		$template_info = $this->model_extension_mail_template->getTemplate($this->request->get['key']);

		if ($template_info) {
			$this->model_extension_mail_template->deleteTemplate($template_info['emailtemplate_id']);
		}

		$new_id = $this->model_extension_mail_template->installTemplate($this->request->get['key']);

		if ($new_id) {
			$this->session->data['success'] = $this->language->get('success_restore');

			$this->session->data['attention'] = sprintf($this->language->get('text_template_changed'), $this->url->link('extension/mail/template/modification', 'token='.$this->session->data['token'], true));

			$this->response->redirect($this->url->link('extension/mail/template/template', 'token='.$this->session->data['token'] . '&id='.$new_id, true));
		}
	}

	/**
	 * Fetch Template & Parse Tags
	 */
	public function fetch_template($request = array()) {
		if (empty($request)) {
			$request = $this->request->get;
		}

		$template_data = array();

		if (isset($request['id'])) {
			$template_data['emailtemplate_id'] = $this->request->get['id'];
		}
		if (isset($request['store_id'])) {
			$template_data['store_id'] = $this->request->get['store_id'];
		}
		if (isset($request['language_id'])) {
			$template_data['language_id'] = $this->request->get['language_id'];
		}
		if (isset($request['customer_id'])) {
			$template_data['customer_id'] = $this->request->get['customer_id'];
		}

		if (empty($template_data)) return false;

		$template_data['emailtemplate_log_id'] = false;

		$template = $this->model_extension_mail_template->load($template_data);

		if ($template) {
			$template->data['insert_shortcodes'] = false;

			if (isset($request['parse']) && !$request['parse']) {
				$template->data['parse_shortcodes'] = false;
			}

			if (isset($request['order_id'])) {
				$this->load->model('sale/order');

				$order_info = $this->model_sale_order->getOrder($request['order_id']);

				if ($order_info) {
					$template->addData($order_info);

					$template->data['payment_address'] = $this->_formatAddress($order_info, 'payment', $order_info['payment_address_format']);
					$template->data['shipping_address'] = $this->_formatAddress($order_info, 'shipping', $order_info['shipping_address_format']);
				}
			}

			if (isset($request['return_id'])) {
				$this->load->model('sale/return');

				$return_info = $this->model_sale_return->getReturn($request['return_id']);

				if ($return_info) {
					$template->addData($return_info);

					if ($return_info['order_id']) {
						$this->load->model('sale/order');

						$order_info = $this->model_sale_order->getOrder($return_info['order_id']);

						if ($order_info) {
							$template->addData($order_info);
						}
					}
				}
			}

			$template->build();

			if (isset($request['output']) && isset($template->data['emailtemplate'][$request['output']])) {
				$html = html_entity_decode($template->data['emailtemplate'][$request['output']], ENT_QUOTES, 'UTF-8');
			} else {
				$template->data['wrapper_tpl'] = false;

				$html = $template->fetch();
			}

			echo $html;
			exit;
		}
	}

	/**
	 * Fetch Template Log
	 */
	public function fetch_log($request = array()) {
		$request = array_merge($request, $this->request->get);

		if (empty($request['id'])) {
			return false;
		}

		$log = $this->model_extension_mail_template->getTemplateLog($request['id']);

		if (empty($log)) {
			return false;
		}

		$log['emailtemplate_log_preview'] = $this->_truncate_str($log['emailtemplate_log_subject'], 50);

		$log['emailtemplate_log_text'] = nl2br($log['emailtemplate_log_text']);

		if ($log['emailtemplate_log_sent'] && $log['emailtemplate_log_sent'] != '0000-00-00 00:00:00') {
			$time = strtotime($log['emailtemplate_log_sent']);
			if (date('Ymd') == date('Ymd', $time)) {
				$log['emailtemplate_log_sent'] = date($this->language->get('time_format'), $time);
			} else {
				$log['emailtemplate_log_sent'] = date($this->language->get('date_format_long'), $time);
			}
		} else {
			$log['emailtemplate_log_sent'] = '';
		}

		if ($log['emailtemplate_log_read'] && $log['emailtemplate_log_read'] != '0000-00-00 00:00:00') {
			$time = strtotime($log['emailtemplate_log_read']);
			if (date('Ymd') == date('Ymd', $time)) {
				$log['emailtemplate_log_read'] = date($this->language->get('time_format'), $time);
			} else {
				$log['emailtemplate_log_read'] = date($this->language->get('date_format_short'), $time);
			}
		} else {
			$log['emailtemplate_log_read'] = '';
		}

		if ($log['emailtemplate_log_read_last'] && $log['emailtemplate_log_read_last'] != '0000-00-00 00:00:00') {
			$time = strtotime($log['emailtemplate_log_read_last']);
			if (date('Ymd') == date('Ymd', $time)) {
				$log['emailtemplate_log_read_last'] = date($this->language->get('time_format'), $time);
			} else {
				$log['emailtemplate_log_read_last'] = date($this->language->get('date_format_short'), $time);
			}
		} else {
			$log['emailtemplate_log_read_last'] = '';
		}

		$template = $this->model_extension_mail_template->load(array(
			'emailtemplate_id' => 1,
			'emailtemplate_log_id' => false
		));

		if ($template) {
			$content = html_entity_decode($log['emailtemplate_log_content'], ENT_QUOTES, 'UTF-8');

			$template->fetch(null, $content);

			$log['emailtemplate_log_html'] = $template->getHtml();

			if (isset($request['output']) && $request['output'] == 'html') {
				echo $log['emailtemplate_log_html'];
				exit;
			} else {
				$this->response->addHeader('Content-Type: application/json');
				$this->response->setOutput(json_encode($log));
				return true;
			}
		}
	}

	/**
	 * Load example email
	 */
	public function preview_email() {
		if (!isset($_SERVER['HTTP_X_REQUESTED_WITH'])) {
			$this->response->redirect($this->url->link('extension/mail/template', 'token='.$this->session->data['token'], true));
		}

		if (isset($this->request->post['language_id'])) {
			$language_id = (int)$this->request->post['language_id'];
		} elseif (isset($this->request->get['language_id'])) {
			$language_id = (int)$this->request->get['language_id'];
		} else {
			$language_id = $this->config->get('config_language_id');
		}

		$overwrite = array();

		if (isset($_POST['data'])) {
			parse_str($_POST['data'], $overwrite);

			if (isset($this->request->get['emailtemplate_config_id'])) {
				foreach($overwrite as $key => $val) {
					if (strpos($key, 'emailtemplate_config_') === 0 && substr($key, -3) != '_id') {
						unset($overwrite[$key]);
						$overwrite[substr($key, 21)] = $val;
					}
				}
			} else {
				foreach($overwrite as $key => $val) {
					if (strpos($key, 'emailtemplate_') === 0 &&
						strpos($key, 'emailtemplate_config_') !== 0 &&
						strpos($key, 'emailtemplate_description_') !== 0 &&
						substr($key, -3) != '_id') {
						unset($overwrite[$key]);
						$overwrite[substr($key, 14)] = $val;
					}
				}

				foreach($overwrite as $key => $val) {
					if (strpos($key, 'emailtemplate_description_') === 0 && substr($key, -3) != '_id') {
						if (isset($val[$language_id])) {
							$val = $val[$language_id];
						}
						unset($overwrite[$key]);
						$overwrite[substr($key, 26)] = $val;
					}
				}
			}
		}

		$load_data = array();

		if (isset($this->request->get['emailtemplate_id'])) {
			$load_data['emailtemplate_id'] = $this->request->get['emailtemplate_id'];
		}

		if (isset($this->request->get['emailtemplate_config_id'])) {
			$load_data['emailtemplate_config_id'] = $this->request->get['emailtemplate_config_id'];

			if (!empty($overwrite)) {
				$overwrite = array('config' => $overwrite);
			}
		}

		if (isset($this->request->get['store_id'])) {
			$load_data['store_id'] = $this->request->get['store_id'];
		}

		$load_data['language_id'] = $language_id;

		$load_data['emailtemplate_log_id'] = false;

		$template = $this->model_extension_mail_template->load($load_data, $overwrite);

		if (!$template) {
			unset($load_data['store_id']);
			$template = $this->model_module_emailtemplate->load($load_data, $overwrite);
		}

		if (!$template) {
			unset($load_data['language_id']);
			$template = $this->model_module_emailtemplate->load($load_data, $overwrite);
		}

		if (!$template) {
			$template = $this->model_module_emailtemplate->load(1, $overwrite);
		}

		if ($template) {
			if (isset($this->request->get['emailtemplate_id'])) {
				$template->data['emailtemplate'] = array_merge($template->data['emailtemplate'], $overwrite);
			}

			// Load defualt shortcodes as data
			$default_shortcodes = $this->model_extension_mail_template->getTemplateShortcodes($template->data['emailtemplate']['emailtemplate_id']);

			if ($default_shortcodes) {
				foreach ($default_shortcodes as $row) {
					if (!isset($template->data[$row['emailtemplate_shortcode_code']])) {
						$template->data[$row['emailtemplate_shortcode_code']] = $row['emailtemplate_shortcode_example'];
					}
				}
			}

			$template->build();

			if ($template->data['emailtemplate']['content1'] == '') {
				$this->language->load('extension/mail/emailtemplate');

				$template->data['emailtemplate']['content1'] = $this->language->get('text_example');
			}

			echo $template->getHtml();
		}

		exit;
	}

	/**
	 * Clear email template cache
	 */
	public function clear() {
		$this->model_extension_mail_template->clear();

		$this->session->data['success'] = $this->language->get('success_clear_cache');

		$this->response->redirect($this->url->link('extension/mail/template', 'token='.$this->session->data['token'], true));
	}

	/**
	 * Test email
	 */
	public function send_email() {
		if (isset($this->request->get['emailtemplate_config_id'])) {
			$config = $this->model_extension_mail_template->getConfig($this->request->get['emailtemplate_config_id'], true);

			$this->load->model('setting/store');

			$store_info = $this->model_setting_store->getStore($config['store_id']);

			if ($store_info && !empty($store_info['email'])) {
				$store_email = $store_info['email'];
			} else {
				$store_email = $this->config->get('config_email');
			}

			$overwrite = array();

			if (isset($_POST['data'])) {
				parse_str($_POST['data'], $overwrite);

				foreach ($overwrite as $key => $val) {
					if (strpos($key, 'emailtemplate_config_') === 0 && substr($key, -3) != '_id') {
						unset($overwrite[$key]);
						$overwrite[substr($key, 21)] = $val;
					}
				}
			}

			$template_load = array(
				'emailtemplate_config_id' => $this->request->get['emailtemplate_config_id'],
				'store_id' => $config['store_id'],
				'language_id' => $config['language_id']
			);

			$result = $this->_sendTestEmail($store_email, $template_load, $overwrite);

			if ($result) {
				$this->session->data['success'] = $this->language->get('success_send');
			}

			$return = array();
			$return['success'] = $this->language->get('success_send');

			$this->response->addHeader('Content-Type: application/json');
			$this->response->setOutput(json_encode($return));

		} elseif (isset($this->request->get['emailtemplate_id'])) {
				$overwrite = array();

				if (isset($_POST['data'])) {
					parse_str($_POST['data'], $overwrite);

					foreach($overwrite as $key => $val) {
						if (strpos($key, 'emailtemplate_') === 0 && substr($key, -3) != '_id') {
							unset($overwrite[$key]);
							$overwrite[substr($key, 21)] = $val;
						}
					}
				}

				$template_load = array(
					'emailtemplate_id' => $this->request->get['emailtemplate_id']
				);

				$result = $this->_sendTestEmail($this->config->get('config_email'), $template_load, $overwrite, false);

				if ($result) {
					$this->session->data['success'] = $this->language->get('success_send');
				}

				$return = array();
				$return['success'] = $this->language->get('success_send');

				$this->response->addHeader('Content-Type: application/json');
				$this->response->setOutput(json_encode($return));

		} elseif (isset($this->request->get['emailtemplate_log_id'])) {

			$result = $this->_sendEmailTemplateLog($this->request->get['emailtemplate_log_id']);

			if ($result) {
				$this->session->data['success'] = $this->language->get('success_send');
			}

			$this->response->redirect($this->url->link('extension/mail/template/logs', 'token='.$this->session->data['token'], true));

		} else {

			$result = $this->_sendTestEmail($this->config->get('config_email'), $this->config->get('config_store_id'));

			if ($result) {
				$this->session->data['success'] = $this->language->get('success_send');
			}

			$this->response->redirect($this->url->link('extension/mail/template', 'token='.$this->session->data['token'], true));
		}
	}

	/**
	 * Test module modifications
	 */
	public function modification() {
		$this->model_extension_mail_template->updateModification('core');

		$this->model_extension_mail_template->updateModification();

		$this->session->data['success'] = $this->language->get('success_test');

		$this->session->data['attention'] = sprintf($this->language->get('text_modifications_refresh'), $this->url->link('extension/modification/refresh', 'token='.$this->session->data['token'], true));

		if (isset($this->request->server['HTTP_REFERER'])) {
			$referer = html_entity_decode($this->request->server['HTTP_REFERER'], ENT_QUOTES, 'UTF-8');

			if ($referer) {
				$url = parse_url($referer, PHP_URL_QUERY);

				parse_str($url, $url_query);

				if (isset($url_query['route']) && isset($url_query['id'])) {
					$this->response->redirect($this->url->link($url_query['route'], 'token='.$this->session->data['token'] . '&id=' . $url_query['id'], true));
				}
			}
		}

		$this->response->redirect($this->url->link('extension/mail/template', 'token='.$this->session->data['token'], true));
	}

	/**
	 * Check module installed
	 */
	public function installed() {
		$chk = $this->db->query("SELECT * FROM " . DB_PREFIX . "extension WHERE `type` = 'email' AND `code` = 'template' LIMIT 1");
		if (!$chk->num_rows) {
			$this->session->data['error'] = sprintf($this->language->get('error_missing_module'), $this->url->link('extension/extension', 'token='.$this->session->data['token'] . '&type=mail', true));
			return false;
		}

		$this->load->model('extension/modification');

		// Modification added
		$modification_info = $this->model_extension_modification->getModificationByCode("emailtemplates_core");

		if (!$modification_info) {
			$this->model_extension_mail_template->updateModification('core');

			$modification_info = $this->model_extension_modification->getModificationByCode("emailtemplates_core");

			if (!$modification_info) {
				$this->session->data['error'] = sprintf($this->language->get('error_missing_modifications'), $this->url->link('extension/modification/refresh', 'token='.$this->session->data['token'], true));
				return false;
			}
		}

		// Modifications refreshed?
		if (!method_exists('Language', 'setPath')) {
			$this->session->data['error'] = sprintf($this->language->get('error_refresh_modifications'), $this->url->link('extension/modification/refresh', 'token='.$this->session->data['token'], true));
			return false;
		}

		// Email templates table?
		$chk = $this->db->query("SHOW TABLES LIKE '". DB_PREFIX . "emailtemplate'");
		if (!$chk->num_rows) {
			$this->session->data['error'] = sprintf($this->language->get('error_missing_module'), $this->url->link('extension/extension', 'token='.$this->session->data['token'] . '&type=mail', true));
			return false;
		}

		return true;
	}

	/**
	 * Opencart module install
	 */
	public function install() {
		$this->model_extension_mail_template->install();

		$this->model_extension_mail_template->updateModification('core');
	}

	/**
	 * Install module
	 */
	public function installer() {
		if ($this->installed()) {
			$this->data['install'] = true;

			$chk = $this->db->query("SELECT count(1) as count FROM `". DB_PREFIX . "emailtemplate`");

			if ($chk->num_rows  && $chk->row['count'] > 1) {
				$this->response->redirect($this->url->link('extension/mail/template', 'token='.$this->session->data['token'], true));
			}
		} else {
			$this->data['install'] = false;
		}

		if ($this->request->server['REQUEST_METHOD'] == 'POST') {
			$this->load->model('setting/setting');

			$stores = $this->model_extension_mail_template->getStores();

			foreach($stores as $store) {
				$store_config = $this->model_setting_setting->getSetting("config", $store['store_id']);

				$config_data = array(
					'emailtemplate_config_name' => $store["name"],
					'emailtemplate_config_version' => $this->model_extension_mail_template->getVersion(),
					'store_id' => $store["store_id"]
				);

				$this->model_setting_setting->deleteSetting('emailtemplate', $store["store_id"]);

				if (!empty($store_config['config_logo']) && file_exists(DIR_IMAGE . $store_config['config_logo'])) {
					$config_data['emailtemplate_config_logo'] = $store_config['config_logo'];

					list($config_data['emailtemplate_config_logo_width'], $config_data['emailtemplate_config_logo_height']) = getimagesize(DIR_IMAGE . $store_config['config_logo']);
				}

				if ($store["store_id"] == 0) {
					$this->model_extension_mail_template->updateConfig(1, $config_data);
				} else {
					$this->model_extension_mail_template->cloneConfig(1, $config_data);
				}
			}

			if (isset($this->request->post['original_templates'])) {
				foreach (array_keys($this->request->post['original_templates']) as $key) {
					$emailtemplate_id = $this->model_extension_mail_template->installTemplate($key);
				}
			}

			$this->model_extension_mail_template->updateModification();

			// Events
			/*$this->load->model('extension/event');

			if ($this->model_extension_event) {
				$this->model_extension_event->deleteEvent('emailtemplate');
				$this->model_extension_event->addEvent('emailtemplate', 'catalog/model/account/return/addReturn/after', 'extension/mail/template/send_return_mail');
			}*/

			$this->session->data['success'] = $this->language->get('install_success');

			$this->response->redirect($this->url->link('extension/mail/template', 'token='.$this->session->data['token'], true));
		}

		foreach(array(
			'button_cancel',
			'button_install',
			'heading_install',
			'template_admin_affiliate_approve',
			'template_admin_affiliate_transaction',
			'template_admin_customer_approve',
			'template_admin_customer_create',
			'template_admin_customer_reward',
			'template_admin_customer_transaction',
			'template_admin_newsletter',
			'template_admin_return_history',
			'template_admin_voucher',
			'template_affiliate_forgotten',
			'template_affiliate_register',
			'template_affiliate_register_admin',
			'template_customer_forgotten',
			'template_customer_register',
			'template_customer_register_admin',
			'template_information_contact',
			'template_information_contact_customer',
			'template_order_admin',
			'template_order_customer',
			'template_order_return',
			'template_order_update',
			'template_order_voucher',
			'template_order_openbay_confirm',
			'template_order_openbay_update',
			'template_openbay_admin',
			'template_product_review',
			'text_admin',
			'text_affiliate',
			'text_all',
			'text_customer',
			'text_order',
			'text_openbay',
			'text_no',
			'text_yes'
		) as $var) {
			$this->data[$var] = $this->language->get($var);
		}

		$this->_setTitle($this->language->get('heading_install'));

		$this->_messages();

		$this->_breadcrumbs();

		$this->data['action'] = $this->url->link('extension/mail/template/installer', 'token='.$this->session->data['token'], true);
		$this->data['cancel'] = $this->url->link('extension/extension', 'token='.$this->session->data['token'] . '&type=mail', true);

		$this->_js[] = 'view/javascript/bootstrap/js/bootstrap-checkbox.min.js';

		$this->_output('extension/mail/template/install');
	}

	/**
	* Delete module settings for each store.
	*/
	public function uninstall() {
		if (!$this->user->hasPermission('modify', 'extension/mail/template')) {
			$this->session->data['error'] = $this->language->get('error_permission');

			$this->response->redirect($this->url->link('extension/extension', 'token='.$this->session->data['token'] . '&type=mail', true));
		}

		$this->load->model('setting/store');
		$this->load->model('setting/setting');

		$stores = $this->model_setting_store->getStores();

		if ($stores) {
			foreach ($stores as $store) {
				$this->model_setting_setting->deleteSetting("emailtemplate", $store['store_id']);
			}
		}

		$this->model_extension_mail_template->uninstall();

		$this->session->data['success'] = $this->language->get('uninstall_success');
	}

	/**
	 * Upgrade Extension
	 */
	public function upgrade() {
		if ($this->model_extension_mail_template->upgrade()) {
			$this->session->data['success'] = $this->language->get('upgrade_success');
		}

		$this->response->redirect($this->url->link('extension/mail/template', 'token='.$this->session->data['token'], true));
	}


	/**
	 * Get Extension Form
	 */
	private function _config_form() {

		foreach(array(
			'button_cancel',
			'button_create',
			'button_configs',
			'button_default',
			'button_delete',
			'button_preview',
			'button_save',
			'button_test',
			'button_update_preview',
			'button_withimages',
			'button_withoutimages',
	        'entry_admin_stock',
	        'entry_bg_color',
	        'entry_bg_image',
	        'entry_body',
			'entry_body_font_color',
			'entry_body_heading_color',
			'entry_body_link_color',
			'entry_border',
			'entry_border_radius',
	        'entry_bottom_left',
	        'entry_bottom_right',
			'entry_color',
			'entry_corner_image',
			'entry_customer_group',
			'entry_end',
			'entry_email_width',
	        'entry_font_size',
	        'entry_font_family',
			'entry_footer',
			'entry_footer_text',
			'entry_head',
			'entry_head_text',
			'entry_header',
			'entry_header_html',
			'entry_height',
			'entry_image_repeat',
			'entry_label',
			'entry_language',
			'entry_layout',
			'entry_limit',
			'entry_link_style',
			'entry_log',
			'entry_log_read',
			'entry_logo',
			'entry_logo_resize_options',
			'entry_mail_queue',
			'entry_overlap',
			'entry_padding',
			'entry_page_align',
			'entry_per_row',
			'entry_product_image_height',
			'entry_product_image_width',
			'entry_quantity_column',
			'entry_responsive',
			'entry_section_color',
			'entry_selection',
			'entry_showcase',
	        'entry_showcase_cycle',
	        'entry_showcase_related',
			'entry_spacing',
			'entry_status',
			'entry_start',
			'entry_store',
			'entry_style',
			'entry_text_align',
			'entry_title',
			'entry_token',
			'entry_theme',
			'entry_top_left',
			'entry_top_right',
			'entry_type',
			'entry_view_browser_text',
			'entry_view_browser_theme',
			'entry_width',
			'entry_wrapper',
			'heading_config',
			'heading_config',
			'heading_content',
			'heading_cronjob',
			'heading_footer',
			'heading_header',
			'heading_logs',
			'heading_orders',
			'heading_page',
			'heading_preview',
			'heading_sections',
			'heading_settings',
			'heading_shadow',
			'heading_showcase',
			'heading_style',
			'text_help_email_width',
			'text_help_header_height',
			'text_help_logo',
			'text_help_logo_font',
			'text_align',
			'text_baseline',
			'text_bestsellers',
			'text_bottom',
			'text_bottom_left',
			'text_bottom_right',
			'text_button',
			'text_center',
			'text_color',
			'text_confirm',
			'text_create_config',
			'text_default',
			'text_desktop',
			'text_disabled',
			'text_end',
			'text_enabled',
	        'text_fluid',
	        'text_header_head',
			'text_height',
			'text_latest',
			'text_left',
			'text_logo',
			'text_middle',
			'text_mobile',
			'text_no',
			'text_none',
			'text_order',
			'text_path',
			'text_popular',
			'text_products',
			'text_right',
			'text_search',
			'text_select',
			'text_start',
	        'text_style_change',
			'text_specials',
			'text_tablet',
			'text_text_color',
			'text_top',
			'text_top_left',
			'text_top_right',
			'text_url',
			'text_width',
			'text_yes'
		) as $var) {
			$this->data[$var] = $this->language->get($var);
		}

		$this->_breadcrumbs(array('heading_config' => array(
			'link' => 'extension/mail/template/config',
			'params' => '&id='.$this->request->get['id']
		)));

		$this->load->model('localisation/language');

		$this->data['languages'] = $this->model_localisation_language->getLanguages();

		$this->data['emailtemplate_config'] = $this->model_extension_mail_template->getConfig($this->request->get['id']);

		if (!$this->data['emailtemplate_config']) {
			$this->response->redirect($this->url->link('extension/mail/template', 'token='.$this->session->data['token'], true));
		}

		$this->data['id'] = $this->data['emailtemplate_config_id'] = $this->request->get['id'];

		foreach(EmailTemplateConfigDAO::describe() as $col => $type) {
			if (isset($this->request->post[$col])) {
				$this->data['emailtemplate_config'][$col] = $this->request->post[$col];
			}
		}

		foreach($this->data['emailtemplate_config'] as $col => $val) {
			$key = (strpos($col, 'emailtemplate_config_') === 0 && substr($col, -3) != '_id') ? substr($col, 21) : $col;

			if (!isset($this->data['emailtemplate_config'][$key])) {
				unset($this->data['emailtemplate_config'][$col]);
				$this->data['emailtemplate_config'][$key] = $val;
			}
		}

		$this->data['setting'] = array();

		if (isset($this->request->post['setting']['emailtemplate_token'])) {
			$this->data['setting']['emailtemplate_token'] = $this->request->post['setting']['emailtemplate_token'];
		} elseif ($this->config->get('emailtemplate_token')) {
			$this->data['setting']['emailtemplate_token'] = $this->config->get('emailtemplate_token');
		} else {
			$this->data['setting']['emailtemplate_token'] = sha1(uniqid(mt_rand(), 1));
		}

		$this->data['cron_request_url'] = HTTPS_CATALOG . 'index.php?route=extension/mail/cron&token=' . $this->data['setting']['emailtemplate_token'];
		$this->data['cron_request_path'] = '/path/to/php -q ' . substr(DIR_CATALOG, 0, -8) . 'oc_cli.php catalog extension/mail/cron &token=' . $this->data['setting']['emailtemplate_token'];

		$this->load->model('tool/image');

		if ($this->data['emailtemplate_config']['modified']) {
			$modified = strtotime($this->data['emailtemplate_config']['modified']);
			if (date('Ymd') == date('Ymd', $modified)) {
				$this->data['emailtemplate_config']['modified'] = date($this->language->get('time_format'), $modified);
			} else {
				$this->data['emailtemplate_config']['modified'] = date($this->language->get('date_format_short'), $modified);
			}
		}

		if ($this->data['emailtemplate_config']['logo'] && file_exists(DIR_IMAGE . $this->data['emailtemplate_config']['logo'])) {
			if ($this->data['emailtemplate_config']['logo_width'] > 0 && $this->data['emailtemplate_config']['logo_height'] > 0) {
				$this->data['emailtemplate_config']['logo_thumb'] = $this->model_tool_image->resize($this->data['emailtemplate_config']['logo'], $this->data['emailtemplate_config']['logo_width'], $this->data['emailtemplate_config']['logo_height']);
			} else {
				$this->data['emailtemplate_config']['logo_thumb'] = $this->model_tool_image->resize($this->data['emailtemplate_config']['logo'], 100, 100);
			}
		} else {
			$this->data['emailtemplate_config']['logo_thumb'] = $this->model_tool_image->resize('no_image.png', 100, 100);
		}

		if ($this->data['emailtemplate_config']['header_bg_image'] && file_exists(DIR_IMAGE . $this->data['emailtemplate_config']['header_bg_image'])) {
			$this->data['emailtemplate_config']['header_bg_image_thumb'] = $this->model_tool_image->resize($this->data['emailtemplate_config']['header_bg_image'], 100, 100);
		} else {
			$this->data['emailtemplate_config']['header_bg_image_thumb'] = $this->model_tool_image->resize('no_image.png', 100, 100);
		}

		if ($this->data['emailtemplate_config']['body_bg_image'] && file_exists(DIR_IMAGE . $this->data['emailtemplate_config']['body_bg_image'])) {
			$this->data['emailtemplate_config']['body_bg_image_thumb'] = $this->model_tool_image->resize($this->data['emailtemplate_config']['body_bg_image'], 100, 100);
		} else {
			$this->data['emailtemplate_config']['body_bg_image_thumb'] = $this->model_tool_image->resize('no_image.png', 100, 100);
		}

		foreach(array('footer_text', 'header_html', 'head_text', 'page_footer_text', 'showcase_title', 'view_browser_text') as $var) {
			if (!isset($this->data['emailtemplate_config'][$var])) {
				$this->data['emailtemplate_config'][$var] = '';
			}
			if (!is_array($this->data['emailtemplate_config'][$var])) {
				$val = html_entity_decode($this->data['emailtemplate_config'][$var], ENT_QUOTES, 'UTF-8');

				$this->data['emailtemplate_config'][$var] = array();

				foreach ($this->data['languages'] as $language) {
					$this->data['emailtemplate_config'][$var][$language['language_id']] = $val;
				}
			}
		}

		foreach(array(
			'header_border_top', 'header_border_bottom', 'header_border_right', 'header_border_left',
	        'footer_border_top', 'footer_border_bottom', 'footer_border_right', 'footer_border_left',
	        'page_border_top', 'page_border_bottom', 'page_border_right', 'page_border_left',
	        'showcase_border_top', 'showcase_border_bottom', 'showcase_border_right', 'showcase_border_left'
        ) as $var) {
			if (!isset($this->data['emailtemplate_config'][$var])) {
				$this->data['emailtemplate_config'][$var] = '';
			}
			if (!is_array($this->data['emailtemplate_config'][$var])) {
				$this->data['emailtemplate_config'][$var] = explode(', ', $this->data['emailtemplate_config'][$var]);
			}
			if (!is_array($this->data['emailtemplate_config'][$var])) {
				$this->data['emailtemplate_config'][$var] = array($this->data['emailtemplate_config'][$var], '');
			}
			if (!isset($this->data['emailtemplate_config'][$var][0])) {
				$this->data['emailtemplate_config'][$var][0] = 0;
			}
			if (!isset($this->data['emailtemplate_config'][$var][1])) {
				$this->data['emailtemplate_config'][$var][1] = '';
			}
		}

		foreach (array('header_spacing', 'footer_spacing', 'page_spacing') as $var) {
			if (!isset($this->data['emailtemplate_config'][$var])) {
				$this->data['emailtemplate_config'][$var] = '';
			}
			if (!is_array($this->data['emailtemplate_config'][$var])) {
				$this->data['emailtemplate_config'][$var] = explode(', ', $this->data['emailtemplate_config'][$var]);
			}
			if (!isset($this->data['emailtemplate_config'][$var][0])) {
				$this->data['emailtemplate_config'][$var][0] = 0;
			}
			if (!isset($this->data['emailtemplate_config'][$var][1])) {
				$this->data['emailtemplate_config'][$var][1] = 0;
			}
		}

		foreach (array('page_padding', 'footer_padding', 'showcase_padding', 'header_border_radius', 'footer_border_radius', 'page_border_radius', 'showcase_border_radius') as $var) {
			if (!isset($this->data['emailtemplate_config'][$var])) {
				$this->data['emailtemplate_config'][$var] = '';
			}
			if ($this->data['emailtemplate_config'][$var] && is_string($this->data['emailtemplate_config'][$var])) {
				$this->data['emailtemplate_config'][$var] = explode(', ', $this->data['emailtemplate_config'][$var]);
			}
			if (!is_array($this->data['emailtemplate_config'][$var])) {
				$this->data['emailtemplate_config'][$var] = array((int)$this->data['emailtemplate_config'][$var]);
			}
			for ($i = 0; $i < 4; $i++) {
				if (!isset($this->data['emailtemplate_config'][$var][$i])) {
					$this->data['emailtemplate_config'][$var][$i] = 0;
				}
			}
		}

		if (defined("HTTP_IMAGE")) {
			$url =  HTTP_IMAGE;
		} elseif ($this->config->get('config_url')) {
			$url = $this->config->get('config_url') . 'image/';
		} else {
			$url = HTTP_CATALOG . 'image/';
		}

		if ($this->data['emailtemplate_config']['order_products'] && !is_array($this->data['emailtemplate_config']['order_products'])) {
			$this->data['emailtemplate_config']['order_products'] = unserialize(base64_decode($this->data['emailtemplate_config']['order_products']));
		}
		if (!isset($this->data['emailtemplate_config']['order_products']['quantity_column'])) {
			$this->data['emailtemplate_config']['order_products']['quantity_column'] = 1;
		}
		if (!isset($this->data['emailtemplate_config']['order_products']['admin_stock'])) {
			$this->data['emailtemplate_config']['order_products']['admin_stock'] = 1;
		}
		if (!isset($this->data['emailtemplate_config']['order_products']['layout'])) {
			$this->data['emailtemplate_config']['order_products']['layout'] = 'default';
		}
		if (!isset($this->data['emailtemplate_config']['order_products']['image_width'])) {
			$this->data['emailtemplate_config']['order_products']['image_width'] = 100;
		}
		if (!isset($this->data['emailtemplate_config']['order_products']['image_height'])) {
			$this->data['emailtemplate_config']['order_products']['image_height'] = 100;
		}

		foreach (array('top','bottom','left','right') as $var) {
			if ($this->data['emailtemplate_config']['shadow_'.$var] && is_string($this->data['emailtemplate_config']['shadow_'.$var])) {
				$this->data['emailtemplate_config']['shadow_'.$var] = unserialize(base64_decode($this->data['emailtemplate_config']['shadow_'.$var]));
			} elseif (!is_array($this->data['emailtemplate_config']['shadow_'.$var])) {
				$this->data['emailtemplate_config']['shadow_'.$var] = array('start' => '', 'end' => '', 'overlap' => 0, 'length' => 0);
			}
		}

		foreach (array('left', 'right') as $col) {
			if (!empty($this->data['emailtemplate_config']['shadow_top'][$col.'_img']) && file_exists(DIR_IMAGE . $this->data['emailtemplate_config']['shadow_top'][$col.'_img'])) {
				$this->data['emailtemplate_config']['shadow_top'][$col.'_thumb'] = $url . $this->data['emailtemplate_config']['shadow_top'][$col.'_img'];
			} else {
				$this->data['emailtemplate_config']['shadow_top'][$col.'_img'] = '';
				$this->data['emailtemplate_config']['shadow_top'][$col.'_thumb'] = '';
			}

			if (!empty($this->data['emailtemplate_config']['shadow_bottom'][$col.'_img']) && file_exists(DIR_IMAGE . $this->data['emailtemplate_config']['shadow_bottom'][$col.'_img'])) {
				$this->data['emailtemplate_config']['shadow_bottom'][$col.'_thumb'] = $url . $this->data['emailtemplate_config']['shadow_bottom'][$col.'_img'];
			} else {
				$this->data['emailtemplate_config']['shadow_bottom'][$col.'_img'] = '';
				$this->data['emailtemplate_config']['shadow_bottom'][$col.'_thumb'] = '';
			}
		}

		$this->data['action_delete'] = $this->url->link('extension/mail/template/config', 'token='.$this->session->data['token'] . '&id=' . $this->request->get['id'] . '&action=delete', true);

		if ($this->request->get['id'] == 1) {
		    $this->_setTitle($this->language->get('heading_config') . ' - ' . $this->language->get('button_default'));
		} else {
		    $this->_setTitle($this->language->get('heading_config') . ' - ' . $this->data['emailtemplate_config']['name']);

		    $this->data['action_default'] = $this->url->link('extension/mail/template/config', 'token='.$this->session->data['token'] . '&id=1', true);

		    $this->load->model('localisation/language');

		    $this->data['languages'] = $this->model_localisation_language->getLanguages();

		    $this->data['stores'] = $this->model_extension_mail_template->getStores();

		    $this->load->model('customer/customer_group');

		    $this->data['customer_groups'] = $this->model_customer_customer_group->getCustomerGroups();
		}

		$this->data['url_insert_config'] = $this->url->link('extension/mail/template/config', 'token='.$this->session->data['token'], true);

		$this->data['url_send_email'] = $this->url->link('extension/mail/template/send_email', 'token='.$this->session->data['token'] . '&emailtemplate_config_id=' . $this->request->get['id'], true);

		$emailtemplate_configs = $this->model_extension_mail_template->getConfigs(array(), true, true);

		if ($emailtemplate_configs) {
			$this->data['action_configs'] = array();

			foreach($emailtemplate_configs as $row) {
				$this->data['action_configs'][] = array(
					'id' => $row['emailtemplate_config_id'],
					'name' => $row['emailtemplate_config_name'],
					'url' =>$this->url->link('extension/mail/template/config', 'token='.$this->session->data['token'] . '&id=' . $row['emailtemplate_config_id'], true)
				);
			}
		}

		$this->data['action'] = $this->url->link('extension/mail/template/config', 'token='.$this->session->data['token'] . '&id=' . $this->request->get['id'], true);

		$this->data['cancel'] = $this->url->link('extension/mail/template', 'token='.$this->session->data['token'], true);

		$this->load->model('tool/image');

		$this->data['no_image'] = $this->model_tool_image->resize('no_image.png', 100, 100);

		$this->data['no_shadow_image'] = $this->model_tool_image->resize('no_image.png', 17, 17);

		# Installed Themes
		$this->data['themes'] = array();
		$directories = glob(DIR_CATALOG . 'view/theme/*', GLOB_ONLYDIR);
		foreach ($directories as $directory) {
			$this->data['themes'][] = basename($directory);
		}

		if (!empty($this->data['emailtemplate_config']['language_id'])) {
			$language_id = $this->data['emailtemplate_config']['language_id'];
		} else {
			$language_id = $this->config->get('config_language_id');
		}

		if (isset($this->data['emailtemplate_config']['store_id'])) {
			$store_id = $this->data['emailtemplate_config']['store_id'];
		} else {
			$store_id = 0;
		}

		$customer_group_id = $this->config->get('config_customer_group_id');

		if ($this->data['emailtemplate_config']['showcase'] == 'products' && $this->data['emailtemplate_config']['showcase_selection']) {
			$showcase_selection = explode(',', $this->data['emailtemplate_config']['showcase_selection']);

			if ($showcase_selection) {
				$this->load->model('extension/mail/template/product');

				$this->data['showcase_selection'] = array();

				foreach($showcase_selection as $product_id) {
					$product_info = $this->model_extension_mail_template_product->getProduct((int)$product_id, $language_id, $store_id, $customer_group_id);

					if ($product_info) {
						$this->data['showcase_selection'][] = array(
							'product_id' => (int)$product_id,
							'name' => $product_info['name']
						);
					}
				}
			}
		}
	}

	/**
	 * Get create config form
	 */
	private function _config_form_create() {
		foreach(array(
	        'button_cancel',
	        'button_create',
	        'entry_config',
	        'entry_customer_group',
	        'entry_label',
	        'entry_language',
	        'entry_status',
	        'entry_store',
	        'heading_condition',
	        'heading_config_create',
	        'text_help_config_create',
	        'text_disabled',
	        'text_enabled',
	        'text_select'
        ) as $var) {
			$this->data[$var] = $this->language->get($var);
		}

		$this->_messages();

		$this->data['action'] = $this->url->link('extension/mail/template/config', 'token='.$this->session->data['token'] . '&action=create', true);
		$this->data['cancel'] = $this->url->link('extension/mail/template', 'token='.$this->session->data['token'], true);

		$this->data['insertMode'] = true;

		$this->data['emailtemplate_config'] = array();

		foreach(EmailTemplateConfigDAO::describe() as $col => $type) {
			$key = (strpos($col, 'emailtemplate_config_') === 0 && substr($col, -3) != '_id') ? substr($col, 21) : $col;
			if (isset($this->request->post[$col])) {
				$this->data['emailtemplate_config'][$key] = $this->request->post[$col];
			} else {
				$this->data['emailtemplate_config'][$key] = '';
			}
		}

		$this->data['emailtemplate_configs'] = $this->model_extension_mail_template->getConfigs(array(), true, true);

		$this->load->model('localisation/language');

		$this->data['languages'] = $this->model_localisation_language->getLanguages();

		$this->data['stores'] = $this->model_extension_mail_template->getStores();

		$this->load->model('customer/customer_group');

		$this->data['customer_groups'] = $this->model_customer_customer_group->getCustomerGroups();

		$this->_setTitle($this->language->get('heading_config_create'));

		$this->_breadcrumbs(array('heading_config_create' => array(
			'link' => 'extension/mail/template/config'
		)));
	}

	/**
	 * Get Templates
	 */
	private function _config_style(array $data) {
		foreach(array('top', 'bottom', 'left', 'right') as $place) {
			$data['emailtemplate_config_header_border_'.$place] = '';
			$data['emailtemplate_config_header_border_radius_'.$place] = '';

			$data['emailtemplate_config_footer_border_'.$place] = '';
			$data['emailtemplate_config_footer_border_radius_'.$place] = '';

			$data['emailtemplate_config_page_border_'.$place] = '';
			$data['emailtemplate_config_page_border_radius_'.$place] = '';

			$data['emailtemplate_config_showcase_border_'.$place] = '';
			$data['emailtemplate_config_showcase_border_radius_'.$place] = '';

			foreach(array('length', 'overlap', 'start', 'end', 'left_img', 'right_img') as $var) {
				$data['emailtemplate_config_shadow_'.$place][$var] = '';
				$data['emailtemplate_config_shadow_'.$place][$var] = '';
				$data['emailtemplate_config_shadow_'.$place][$var] = '';
				$data['emailtemplate_config_shadow_'.$place][$var] = '';
			}
		}

		$data['emailtemplate_config_head_section_bg_color'] = '';

		$data['emailtemplate_config_header_section_bg_color'] = '';
		$data['emailtemplate_config_header_border_radius'] = '';
		$data['emailtemplate_config_header_border_top'] = '';
		$data['emailtemplate_config_header_border_bottom'] = '';
		$data['emailtemplate_config_header_border_left'] = '';
		$data['emailtemplate_config_header_border_right'] = '';
		$data['emailtemplate_config_header_spacing'] = '';

		$data['emailtemplate_config_body_bg_color'] = '';
		$data['emailtemplate_config_body_section_bg_color'] = '';
		$data['emailtemplate_config_page_border_radius'] = '';
		$data['emailtemplate_config_page_border_top'] = '';
		$data['emailtemplate_config_page_border_bottom'] = '';
		$data['emailtemplate_config_page_border_left'] = '';
		$data['emailtemplate_config_page_border_right'] = '';
		$data['emailtemplate_config_page_spacing'] = '';

		$data['emailtemplate_config_showcase_bg_color'] = '';
		$data['emailtemplate_config_showcase_section_bg_color'] = '';
		$data['emailtemplate_config_showcase_border_radius'] = '';
		$data['emailtemplate_config_showcase_border_top'] = '';
		$data['emailtemplate_config_showcase_border_bottom'] = '';
		$data['emailtemplate_config_showcase_border_left'] = '';
		$data['emailtemplate_config_showcase_border_right'] = '';
		$data['emailtemplate_config_showcase_spacing'] = '';

		$data['emailtemplate_config_footer_bg_color'] = '';
		$data['emailtemplate_config_footer_section_bg_color'] = '';
		$data['emailtemplate_config_footer_border_radius'] = '';
		$data['emailtemplate_config_footer_border_top'] = '';
		$data['emailtemplate_config_footer_border_bottom'] = '';
		$data['emailtemplate_config_footer_border_left'] = '';
		$data['emailtemplate_config_footer_border_right'] = '';
		$data['emailtemplate_config_footer_spacing'] = '';

		switch($data['emailtemplate_config_style']) {
			case 'white':
				$data['emailtemplate_config_wrapper_tpl'] = '_main.tpl';
				$data['emailtemplate_config_body_bg_color'] = '#FFFFFF';
				$data['emailtemplate_config_page_bg_color'] = '#F9F9F9';
				$data['emailtemplate_config_body_font_color'] = '#333333';

				$data['emailtemplate_config_shadow_top'] = array(
					'length' => '',
					'overlap' => '',
					'start' => '',
					'end' => '',
					'left_img' => '',
					'right_img' => ''
				);

				$data['emailtemplate_config_shadow_bottom'] = array(
					'length' => 9,
					'overlap' => 8,
					'start' => '#d4d4d4',
					'end' => '#ffffff',
					'left_img' => 'catalog/emailtemplate/white/bottom_left.png',
					'right_img' => 'catalog/emailtemplate/white/bottom_right.png'
				);

				$data['emailtemplate_config_shadow_left'] = array(
					'length' => 9,
					'overlap' => 8,
					'start' => '#ffffff',
					'end' => '#d4d4d4'
				);

				$data['emailtemplate_config_shadow_right'] = array(
					'length' => 9,
					'overlap' => 8,
					'start' => '#d4d4d4',
					'end' => '#ffffff'
				);
			break;

			case 'page':
				$data['emailtemplate_config_wrapper_tpl'] = '_main.tpl';
				$data['emailtemplate_config_body_bg_color'] = '#F9F9F9';
				$data['emailtemplate_config_page_bg_color'] = '#FFFFFF';
				$data['emailtemplate_config_body_font_color'] = '#333333';

				$data['emailtemplate_config_shadow_top'] = array(
					'length' => '',
					'overlap' => '',
					'start' => '',
					'end' => '',
					'left_img' => '',
					'right_img' => ''
				);

				$data['emailtemplate_config_shadow_bottom'] = array(
					'length' => 9,
					'overlap' => 8,
					'start' => '#d4d4d4',
					'end' => '#f8f8f8',
					'left_img' => 'catalog/emailtemplate/gray/bottom_left.png',
					'right_img' => 'catalog/emailtemplate/gray/bottom_right.png'
				);

				$data['emailtemplate_config_shadow_left'] = array(
					'length' => 9,
					'overlap' => 8,
					'start' => '#f8f8f8',
					'end' => '#d4d4d4'
				);

				$data['emailtemplate_config_shadow_right'] = array(
					'length' => 9,
					'overlap' => 8,
					'start' => '#d4d4d4',
					'end' => '#f8f8f8'
				);
			break;

			case 'clean':
				$data['emailtemplate_config_wrapper_tpl'] = '_main.tpl';
				$data['emailtemplate_config_body_bg_color'] = '#FFFFFF';
				$data['emailtemplate_config_page_bg_color'] = '#FFFFFF';
				$data['emailtemplate_config_body_font_color'] = '#333333';
			break;

			case 'border':
				$data['emailtemplate_config_wrapper_tpl'] = '_main.tpl';
				$data['emailtemplate_config_body_font_color'] = '#333333';
				foreach(array('bottom', 'left', 'right') as $place) {
					$data['emailtemplate_config_shadow_'.$place] = array(
						'length' => 1,
						'overlap' => 0,
						'start' => '#515151',
						'end' => '#515151',
						'left_img' => '',
						'right_img' => ''
					);
				}
			break;

			case 'crisp':
				$data['emailtemplate_config_wrapper_tpl'] = '_main.tpl';
				$data['emailtemplate_config_body_bg_color'] = '#575757';
				$data['emailtemplate_config_body_section_bg_color'] = '#FFFFFF';
				$data['emailtemplate_config_body_font_color'] = '#333333';

				$data['emailtemplate_config_header_bg_color'] = '';
				$data['emailtemplate_config_header_bg_image'] = '';
				$data['emailtemplate_config_header_section_bg_color'] = '#FFFFFF';

				$data['emailtemplate_config_page_bg_color'] = '#FFFFFF';
				$data['emailtemplate_config_page_border_radius'] = '8, 8, 0, 0';

				$data['emailtemplate_config_page_border_top'] =
				$data['emailtemplate_config_page_border_left'] =
				$data['emailtemplate_config_page_border_right'] = '2, #cfcfcf';

				$data['emailtemplate_config_showcase_bg_color'] = '#FFFFFF';
				$data['emailtemplate_config_showcase_section_bg_color'] = '#e6e6e6';
				$data['emailtemplate_config_showcase_border_bottom'] =
				$data['emailtemplate_config_showcase_border_left'] =
				$data['emailtemplate_config_showcase_border_right'] = '2, #cfcfcf';

				$data['emailtemplate_config_footer_bg_color'] = '#575757';

				foreach(array('top', 'bottom', 'left', 'right') as $place) {
					$data['emailtemplate_config_shadow_'.$place] = array(
						'length' => '',
						'overlap' => '',
						'start' => '',
						'end' => '',
						'left_img' => '',
						'right_img' => ''
					);
				}
			break;

			case 'sections':
				$data['emailtemplate_config_wrapper_tpl'] = '_main.tpl';
				$data['emailtemplate_config_body_bg_color'] = '#FFFFFF';
				$data['emailtemplate_config_page_bg_color'] = '#FFFFFF';
				$data['emailtemplate_config_body_section_bg_color'] = '#FFFFFF';
				$data['emailtemplate_config_body_font_color'] = '#333333';
				$data['emailtemplate_config_header_section_bg_color'] = $data['emailtemplate_config_header_bg_color'];

				$rand = array('0', '1', '2', '3', '4', '5', '6', '7', '8', '9', 'a', 'b', 'c', 'd', 'e', 'f');
				$data['emailtemplate_config_head_section_bg_color'] = '#'.$rand[rand(0,15)].$rand[rand(0,15)].$rand[rand(0,15)].$rand[rand(0,15)].$rand[rand(0,15)].$rand[rand(0,15)];
				$data['emailtemplate_config_footer_section_bg_color'] = '#'.$rand[rand(0,15)].$rand[rand(0,15)].$rand[rand(0,15)].$rand[rand(0,15)].$rand[rand(0,15)].$rand[rand(0,15)];

				foreach(array('top', 'bottom', 'left', 'right') as $place) {
					$data['emailtemplate_config_shadow_'.$place] = array(
						'length' => '',
						'overlap' => '',
						'start' => '',
						'end' => '',
						'left_img' => '',
						'right_img' => ''
					);
				}
			break;
		}

		return $data;
	}

	/**
	 * Get Templates
	 */
	private function _template_list($data = null) {
		if (is_null($data)) $data = $this->request->get;

		foreach(array(
			'button_cancel',
			'button_default',
			'button_delete',
			'button_clear',
			'button_disable',
			'button_enable',
			'button_logs',
			'button_modification',
			'button_test',
			'button_tools',
			'column_config',
			'column_key',
			'column_label',
			'column_modified',
			'column_status',
			'column_shortcodes',
			'heading_config',
			'heading_modification',
			'heading_templates',
			'heading_title',
			'text_admin',
			'text_affiliate',
			'text_all',
			'text_confirm',
			'text_customer',
			'text_create_template',
			'text_order'
		) as $var) {
			$this->data[$var] = $this->language->get($var);
		}

		$this->data['version'] = $this->model_extension_mail_template->getVersion();

		if (isset($data['store_id']) && is_numeric($data['store_id'])) {
			$this->data['templates_store_id'] = $data['store_id'];
		} else {
			$this->data['templates_store_id'] = NULL;
		}

		if (isset($data['customer_group_id'])) {
			$this->data['templates_customer_group_id'] = $data['customer_group_id'];
		} else {
			$this->data['templates_customer_group_id'] = '';
		}

		if (isset($data['key'])) {
			$this->data['templates_key'] = $data['key'];
		} else {
			$this->data['templates_key'] = '';
		}

		if (isset($data['filter_type'])) {
			$this->data['emailtemplate_type'] = $data['filter_type'];
		} else {
			$this->data['emailtemplate_type'] = '';
		}

		if (isset($this->request->get['sort'])) {
			$sort = $this->request->get['sort'];
		} else {
			$sort = 'label';
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

		$limit = 15;
		$filter = array(
			'language_id' => $this->config->get('config_language_id'),
			'store_id' => $this->data['templates_store_id'],
			'customer_group_id' => $this->data['templates_customer_group_id'],
			'emailtemplate_key' => $this->data['templates_key'],
			'emailtemplate_default' => 1,
			'sort'  => $sort,
			'order' => $order,
			'start' => ($page - 1) * $limit,
			'limit' => $limit
		);

		if (!empty($this->data['emailtemplate_type'])) {
			$filter['emailtemplate_type'] = $this->data['emailtemplate_type'];
		}

		if (isset($data['not_emailtemplate_id'])) {
			$filter['not_emailtemplate_id'] = $data['not_emailtemplate_id'];
		}

		if (isset($data['default'])) {
			$filter['emailtemplate_default'] = $data['default'];
		}

		$emailtemplate_configs = array();
		foreach($this->model_extension_mail_template->getConfigs() as $emailtemplate_config){
			$emailtemplate_configs[$emailtemplate_config['emailtemplate_config_id']] = $emailtemplate_config;
		}

		$templates_total = $this->model_extension_mail_template->getTotalTemplates($filter);
		$results = $this->model_extension_mail_template->getTemplates($filter);

		$this->data['templates'] = array();
		foreach ($results as $item) {
			$row = array(
				'id' 		  	=> $item['emailtemplate_id'],
				'emailtemplate_config_id' => $item['emailtemplate_config_id'],
				'store_id' 		=> $item['store_id'],
				'customer_group_id' => $item['customer_group_id'],
				'key'    	  	=> $item['emailtemplate_key'],
				'name'    	  	=> $item['emailtemplate_label'] ? $item['emailtemplate_label'] : $item['emailtemplate_key'],
				'label'    	  	=> $item['emailtemplate_label'],
				'template'    	=> $item['emailtemplate_template'],
				'status'      	=> $item['emailtemplate_status'],
				'default'      	=> $item['emailtemplate_default'],
				'shortcodes'    => $item['emailtemplate_shortcodes'],
				'action'		=> $this->url->link('extension/mail/template/template', 'token='.$this->session->data['token'] . '&id=' . $item['emailtemplate_id'], true),
				'selected'	  	=> isset($this->request->post['selected']) && in_array($item['emailtemplate_id'], $this->request->post['selected'])
			);

			if(isset($emailtemplate_configs[$item['emailtemplate_config_id']])){
				$row['config'] = $emailtemplate_configs[$item['emailtemplate_config_id']]['emailtemplate_config_name'];
				$row['config_url'] = $this->url->link('extension/mail/template/config', 'token='.$this->session->data['token'] . '&id=' . $item['emailtemplate_config_id'], true);
			}

			$modified = strtotime($item['emailtemplate_modified']);
			if (date('Ymd') == date('Ymd', $modified)) {
				//$row['modified'] = date($this->language->get('time_format'), $modified);
				$row['modified'] = date('H:i', $modified);
			} else {
				$row['modified'] = date($this->language->get('date_format_short'), $modified);
			}

			$row['custom_templates'] = $this->model_extension_mail_template->getTemplates(array(
				'emailtemplate_key' => $item['emailtemplate_key'],
				'emailtemplate_default' => 0
			));

			$row['custom_count'] = count($row['custom_templates']);

			foreach ($row['custom_templates'] as $i => $custom_templates) {
				$row['custom_templates'][$i]['action'] = $this->url->link('extension/mail/template/template', 'token='.$this->session->data['token'] . '&id=' . $custom_templates['emailtemplate_id'], true);
			}

			if ($item['store_id'] >= 0) {
				$stores = $this->model_extension_mail_template->getStores($item['store_id']);

				if (isset($stores[$row['store_id']])) {
					$row['store'] = $stores[$row['store_id']];
				} else {
					$row['store'] = current($stores);
				}
			}

			if ($item['customer_group_id']) {
				$this->load->model('customer/customer_group');

				$row['customer_group'] = $this->model_customer_customer_group->getCustomerGroup($item['customer_group_id']);
			}

			$this->data['templates'][] = $row;
		}

		$this->data['emailtemplate_types'] = $this->model_extension_mail_template->getTemplateTypes();

		$this->data['token'] = $this->session->data['token'];

		$url = '';

		if (isset($this->request->get['filter_type'])) {
			$url .= '&filter_type=' . $this->request->get['filter_type'];
		}

		if ($order == 'ASC') {
			$url .= '&order=DESC';
		} else {
			$url .= '&order=ASC';
		}

		if (isset($data['page'])) {
			$url .= '&page=' . $data['page'];
		}

		$this->data['sort_label'] = $this->url->link('extension/mail/template', 'token='.$this->session->data['token'] . '&sort=label' . $url, true);
		$this->data['sort_key'] = $this->url->link('extension/mail/template', 'token='.$this->session->data['token'] . '&sort=key' . $url, true);
		$this->data['sort_template'] = $this->url->link('extension/mail/template', 'token='.$this->session->data['token'] . '&sort=template' . $url, true);
		$this->data['sort_shortcodes'] = $this->url->link('extension/mail/template', 'token='.$this->session->data['token'] . '&sort=shortcodes' . $url, true);
		$this->data['sort_default'] = $this->url->link('extension/mail/template', 'token='.$this->session->data['token'] . '&sort=default' . $url, true);
		$this->data['sort_config'] = $this->url->link('extension/mail/template', 'token='.$this->session->data['token'] . '&sort=config' . $url, true);
		$this->data['sort_content'] = $this->url->link('extension/mail/template', 'token='.$this->session->data['token'] . '&sort=content' . $url, true);
		$this->data['sort_status'] = $this->url->link('extension/mail/template', 'token='.$this->session->data['token'] . '&sort=status' . $url, true);
		$this->data['sort_store'] = $this->url->link('extension/mail/template', 'token='.$this->session->data['token'] . '&sort=store' . $url, true);
		$this->data['sort_modified'] = $this->url->link('extension/mail/template', 'token='.$this->session->data['token'] . '&sort=modified' . $url, true);
		$this->data['sort_customer_group'] = $this->url->link('extension/mail/template', 'token='.$this->session->data['token'] . '&sort=customer_group' . $url, true);

		$this->data['sort'] = $sort;
		$this->data['order'] = $order;

		$url = '';

		if (isset($data['sort'])) {
			$url .= '&sort=' . $data['sort'];
		}

		if (isset($data['order'])) {
			$url .= '&order=' . $data['order'];
		}

		if (isset($this->request->get['filter_type'])) {
			$url .= '&filter_type=' . $this->request->get['filter_type'];
		}

		$link = $this->url->link('extension/mail/template', 'token='.$this->session->data['token'] . $url . '&page={page}', true);

		$this->_renderPagination($link, $page, $templates_total, $limit);
	}


	/**
	 * Get Template Shortcodes
	 */
	private function _shortcodes_list($data = null) {
		if (is_null($data)) $data = $this->request->get;

		if (!isset($data['id'])) {
			return false;
		}

		$this->data['shortcode_emailtemplate_id'] = $data['id'];

		if (isset($this->request->get['sort'])) {
			$sort = $this->request->get['sort'];
		} else {
			$sort = 'code';
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

		if (isset($data['limit'])) {
			$limit = $data['limit'];
		} else {
			$limit = 15;
		}

		$filter = array(
			'emailtemplate_id'  => $this->data['shortcode_emailtemplate_id'],
			'start' => ($page - 1) * $limit,
			'limit' => $limit,
			'sort'  => $sort,
			'order' => $order
		);

		if (!empty($data['shortcodes_language'])) {
			$filter['emailtemplate_shortcode_type'] = '';
		} else {
			$filter['emailtemplate_shortcode_type'] = 'auto';
		}

		$results = $this->model_extension_mail_template->getTemplateShortcodes($filter);

		$total = $this->model_extension_mail_template->getTotalTemplateShortcodes($filter);

		$this->data['shortcodes'] = array();
		foreach ($results as $item) {
			$example = html_entity_decode($item['emailtemplate_shortcode_example'], ENT_QUOTES, 'UTF-8');

			if (strlen($example) > 300) {
				$example = strip_tags($example);
				$example = substr($example, 0, 300);
				$example = substr($example, 0, strrpos($example, ' '));
				$example .= '...';
			}

			$this->data['shortcodes'][] = array(
				'id' 	   => $item['emailtemplate_shortcode_id'],
				'code' 	   => $item['emailtemplate_shortcode_code'],
				'type' 	   => $item['emailtemplate_shortcode_type'],
				'example'  => $example,
				'url_edit'  => $this->url->link('extension/mail/template/template_shortcode', 'token='.$this->session->data['token'].'&id='.$item['emailtemplate_shortcode_id'], true)
			);
		}

		$url = '';
		if (isset($this->request->get['sort'])) {
			$url .= '&sort=' . $this->request->get['sort'];
		}

		if (isset($this->request->get['order'])) {
			$url .= '&order=' . $this->request->get['order'];
		}

		if (!empty($data['shortcodes_language'])) {
			$url .= '&shortcodes_language=' . $data['shortcodes_language'];
		}

		if (isset($this->request->get['id'])) {
			$url .= '&id='.$this->request->get['id'];
		}

		$link = $this->url->link('extension/mail/template/template', 'token='.$this->session->data['token'] . $url . '&page={page}', true) . '#tab-shortcodes';

		$this->_renderPagination($link, $page, $total, $limit, 'select');

		$url = '';
		if ($order == 'ASC') {
			$url .= '&order=DESC';
		} else {
			$url .= '&order=ASC';
		}
		if (isset($this->request->get['id'])) {
			$url .= '&id='.$this->request->get['id'];
		}
		if (!empty($data['shortcodes_language'])) {
			$url .= '&shortcodes_language=' . $data['shortcodes_language'];
		}

		$this->data['sort_code'] = $this->url->link('extension/mail/template/template', 'token='.$this->session->data['token'] . '&sort=code' . $url, true);
		$this->data['sort_example'] = $this->url->link('extension/mail/template/template', 'token='.$this->session->data['token'] . '&sort=example' . $url, true);

		$url = '';
		if (isset($this->request->get['id'])) {
			$url .= '&id='.$this->request->get['id'];
		}
		if (!empty($data['shortcodes_language'])) {
			$url .= '&shortcodes_language=' . $data['shortcodes_language'];
		}
		if ($sort) {
			$url .= '&sort=' . $sort;
		}
		if ($order) {
			$url .= '&order=' . $order;
		}

		$this->data['action'] = $this->url->link('extension/mail/template/template', 'token='.$this->session->data['token'] . $url, true);

		$this->data['sort'] = $sort;
		$this->data['order'] = $order;

		$url = '';
		if (isset($this->request->get['id'])) {
			$url .= '&id='.$this->request->get['id'];
		}
		if ($sort) {
			$url .= '&sort=' . $sort;
		}
		if ($order) {
			$url .= '&order=' . $order;
		}

		if (isset($this->request->get['shortcodes_language'])) {
			$this->data['filter_shortcodes_language'] = 1;

			$this->data['action_shortcodes_language'] = $this->url->link('extension/mail/template/template', 'token='.$this->session->data['token'] . $url, true);
		} else {
			$this->data['filter_shortcodes_language'] = 0;

			$this->data['action_shortcodes_language'] = $this->url->link('extension/mail/template/template', 'token='.$this->session->data['token'] . '&shortcodes_language=1' . $url, true);
		}
	}

	/**
	 * Get template form
	 */
	private function _template_form() {
		if (empty($this->request->get['id'])) {
			$this->response->redirect($this->url->link('extension/mail/template', 'token='.$this->session->data['token'], true));
		}

		$this->load->model('tool/image');

		foreach(array(
			'button_add',
			'button_cancel',
			'button_clear',
			'button_create',
			'button_delete',
			'button_default',
			'button_default_template',
			'button_language_shortcodes',
			'button_templates',
			'button_preview',
			'button_save',
			'button_test',
			'button_update_preview',
			'button_withimages',
			'button_withoutimages',
			'entry_attach_invoice',
			'entry_attach_invoice_info',
			'entry_comment',
			'entry_condition',
			'entry_content_count',
			'entry_customer_group',
			'entry_key',
			'entry_label',
			'entry_language',
			'entry_language_files',
			'entry_log_template',
			'entry_mail_to',
			'entry_mail_from',
			'entry_mail_html',
			'entry_mail_plain_text',
			'entry_mail_queue',
			'entry_mail_sender',
			'entry_mail_replyto',
			'entry_mail_replyto_name',
			'entry_mail_cc',
			'entry_mail_bcc',
			'entry_mail_attachment',
			'entry_order_status',
			'entry_preheader',
	        'entry_showcase_template',
			'entry_status',
			'entry_store',
			'entry_subject',
			'entry_template_config',
			'entry_template_file',
			'entry_type',
			'entry_unsubscribe',
			'entry_view_browser',
			'entry_wrapper',
			'column_code',
			'column_example',
			'heading_mail',
			'heading_settings',
			'heading_shortcodes',
			'heading_template_edit',
			'heading_preview',
			'text_add_editor',
			'text_admin',
			'text_catalog',
			'text_create_template',
			'text_config',
			'text_confirm',
			'text_default',
			'text_desktop',
			'text_disabled',
			'text_enabled',
	        'text_help_shortcodes',
			'text_mobile',
			'text_placeholder_custom',
			'text_select',
			'text_select_auto',
			'text_tablet',
			'text_no',
			'text_yes'
		) as $var) {
			$this->data[$var] = $this->language->get($var);
		}

		$this->_messages();

		$emailtemplate = $this->model_extension_mail_template->getTemplate($this->request->get['id'], 0);

		if (!$emailtemplate) {
			$this->response->redirect($this->url->link('extension/mail/template', 'token='.$this->session->data['token'], true));
		}

		$result = $this->model_extension_mail_template->getTemplateDescription(array('emailtemplate_id' => $emailtemplate['emailtemplate_id']));

		$emailtemplate['descriptions'] = array();
		foreach($result as $row) {
			$emailtemplate['descriptions'][$row['language_id']] = $row;
		}

		$config = $this->data['emailtemplate_config'] = $this->model_extension_mail_template->getConfig(array(
			'store_id' => ($emailtemplate['store_id']) ? $emailtemplate['store_id'] : 0
		));

		// Default and similar templates
		$this->data['template_similar'] = array();

		if ($emailtemplate['emailtemplate_default']) {
			$this->data['default_emailtemplate_id'] = $emailtemplate['emailtemplate_id'];
		}

		$templates = $this->model_extension_mail_template->getTemplates(array('emailtemplate_key' => $emailtemplate['emailtemplate_key']));

		if ($templates) {
			foreach($templates as $template) {
				if ($template['emailtemplate_id'] != $emailtemplate['emailtemplate_id']) {

					if ($template['emailtemplate_default']) {
						$this->data['default_emailtemplate_id'] = $template['emailtemplate_id'];

						$this->data['template_default_url'] = $this->url->link('extension/mail/template/template', 'token='.$this->session->data['token'] . '&id='.$template['emailtemplate_id'], true);
					} else {
						$this->data['template_similar'][] = array(
							'name' => $template['emailtemplate_label'],
							'url' => $this->url->link('extension/mail/template/template', 'token='.$this->session->data['token'] . '&id='.$template['emailtemplate_id'], true)
						);
					}

				}
			}
		}

		if (isset($this->request->get['shortcodes_language'])) {
			$shortcodes_language = 'language';
		} else {
			$shortcodes_language = '';
		}

		$this->_shortcodes_list(array('id' => $emailtemplate['emailtemplate_id'], 'limit' => 30, 'shortcodes_language' => $shortcodes_language));

		if (!empty($this->data['shortcodes'])) {
			$this->data['shortcodes_data'] = array();

			foreach($this->data['shortcodes'] as $row) {
				$this->data['shortcodes_data'][$row['code']] = $row['example'];
			}
		}

		$this->data['action'] = $this->url->link('extension/mail/template/template', 'token='.$this->session->data['token'] . '&id=' . $this->request->get['id'], true);

		$this->data['action_insert_template'] = $this->url->link('extension/mail/template/template', 'token='.$this->session->data['token'] . '&key=' . $emailtemplate['emailtemplate_key'], true);

		$this->_setTitle($emailtemplate['emailtemplate_label'] . ' &raquo; ' . $this->language->get('heading_template_edit'));

		$this->_breadcrumbs(array('heading_template_edit' => array(
			'link' => 'extension/mail/template/template',
			'params' => '&id='.$this->request->get['id']
		)));

		$this->data['cancel'] = $this->url->link('extension/mail/template', 'token='.$this->session->data['token'], true);

		$this->load->model('localisation/language');

		$this->data['languages'] = $this->model_localisation_language->getLanguages();

		$this->data['emailtemplate'] = array();

		foreach(EmailTemplateDAO::describe() as $col => $type) {
			$key = (strpos($col, 'emailtemplate_') === 0 && substr($col, -3) != '_id') ? substr($col, 14) : $col;
			if (isset($this->request->post[$col])) {
				$this->data['emailtemplate'][$key] = $this->request->post[$col];
			} elseif (isset($emailtemplate[$col])) {
				$this->data['emailtemplate'][$key] = $emailtemplate[$col];
			} else {
				$this->data['emailtemplate'][$key] = '';
			}
		}

		$this->data['content_count'] = $this->content_count;

		$descriptionCols = EmailTemplateDescriptionDAO::describe();

		$this->data['emailtemplate_description'] = array();

		foreach($this->data['languages'] as &$language) {
			$row = array();

			if ($language['language_id'] == $this->config->get('config_language_id')) {
				$language['default'] = 1;
			} else {
				$language['default'] = 0;
			}

			foreach($descriptionCols as $col => $type) {
				$key = (strpos($col, 'emailtemplate_description_') === 0) ? substr($col, 26) : $col;

				if (isset($this->request->post[$col][$language['language_id']])) {
					$value = $this->request->post[$col][$language['language_id']];
				} elseif (isset($emailtemplate['descriptions'][$language['language_id']][$col])) {
					$value = $emailtemplate['descriptions'][$language['language_id']][$col];
				} else {
					$value = '';
				}

				$row[$key] = $value;
			}

			$this->data['emailtemplate_description'][$language['language_id']] = $row;
		}
		unset($language);

		$modified = strtotime($this->data['emailtemplate']['modified']);
		if (date('Ymd') == date('Ymd', $modified)) {
			$this->data['emailtemplate']['modified'] = date($this->language->get('time_format'), $modified);
		} else {
			$this->data['emailtemplate']['modified'] = date($this->language->get('date_format_short'), $modified);
		}

		$this->data['emailtemplate_files'] = $this->model_extension_mail_template->getTemplateFiles($config['emailtemplate_config_theme']);

		if (substr($this->data['emailtemplate']['key'], 0, 6) == 'admin.') {
			$this->data['emailtemplate_template_path'] = 'admin/view/template/emailtemplate/';
		} else {
			$this->data['emailtemplate_template_path'] = 'catalog/view/theme/' . $config['emailtemplate_config_theme'] . '/template/extension/mail/';
		}

		if ($this->data['emailtemplate']['emailtemplate_config_id']) {
			$this->data['config_url'] = $this->url->link('extension/mail/template/config', 'token='.$this->session->data['token'] . '&id=' . $this->data['emailtemplate']['emailtemplate_config_id'], true);
		} else {
			$this->data['config_url'] = $this->url->link('extension/mail/template/config', 'token='.$this->session->data['token'] . '&id=1', true);
		}

		$this->data['emailtemplate_configs'] = $this->model_extension_mail_template->getConfigs(array(), true, true);

		if (isset($emailtemplate['emailtemplate_id'])) {
			$this->data['emailtemplate_shortcodes'] = $this->model_extension_mail_template->getTemplateShortcodes(array('emailtemplate_id' => $emailtemplate['emailtemplate_id']), true);

			// Get defualt template shortcodes
			if (empty($this->data['emailtemplate_shortcodes'])) {
				$this->data['emailtemplate_shortcodes'] = $this->model_extension_mail_template->getTemplateShortcodes(array('emailtemplate_key' => $emailtemplate['emailtemplate_key']), true);
			}
		}

		$this->data['no_image'] = $this->model_tool_image->resize('no_image.png', 100, 100);

		$this->data['stores'] = $this->model_extension_mail_template->getStores();

		$this->load->model('customer/customer_group');

		$this->data['customer_groups'] = $this->model_customer_customer_group->getCustomerGroups();

		$key = isset($this->request->get['key']) ? $this->request->get['key'] : $this->data['emailtemplate']['key'];

		switch($key) {
			case 'order.admin':
			case 'order.customer':
			case 'order.update':
				$this->load->model('localisation/order_status');

				$this->data['order_statuses'] = $this->model_localisation_order_status->getOrderStatuses();

				$this->data['text_help_subject'] = $this->language->get('text_help_subject_order');
			break;
		}

		if ($this->config->get('pdf_invoice')) {
			$this->data['pdf_invoice_installed'] = true;
		}
	}

	/**
	 * Get create template form
	 */
	private function _template_form_create() {
		foreach(array(
			'button_cancel',
			'button_create',
			'entry_key',
			'entry_label',
			'heading_template_create',
			'text_help_template_key',
			'text_admin',
			'text_catalog',
			'text_select',
			'text_placeholder_custom'
		) as $var) {
			$this->data[$var] = $this->language->get($var);
		}

		$this->_messages();

		$this->data['action'] = $this->url->link('extension/mail/template/template', 'token='.$this->session->data['token'], true);
		$this->data['cancel'] = $this->url->link('extension/mail/template', 'token='.$this->session->data['token'], true);

		$this->data['insertMode'] = true;

		$this->data['emailtemplate_keys'] = $this->model_extension_mail_template->getTemplateKeys();

		$this->data['emailtemplate'] = array();

		foreach(EmailTemplateDAO::describe() as $col => $type) {
			$key = (strpos($col, 'emailtemplate_') === 0 && substr($col, -3) != '_id') ? substr($col, 14) : $col;
			if (isset($this->request->post[$col])) {
				$this->data['emailtemplate'][$key] = $this->request->post[$col];
			} else {
				$this->data['emailtemplate'][$key] = '';
			}
		}

		if (isset($this->request->post['emailtemplate_key_select'])) {
			$this->data['emailtemplate']['key_select'] = $this->request->post['emailtemplate_key_select'];
		} elseif (isset($this->request->get['key'])) {
			$this->data['emailtemplate']['key_select'] = $this->request->get['key'];
		} else {
			$this->data['emailtemplate']['key_select'] = '';
		}

		$this->_setTitle($this->language->get('heading_template_create'));

		$this->_breadcrumbs(array('heading_template_create' => array(
			'link' => 'extension/mail/template/template'
		)));
	}

	/**
	 * Get template shortcode form
	 */
	private function _template_shortcode_form() {
		foreach(array(
			'heading_template_shortcode',
			'button_save',
			'entry_code',
			'entry_example',
			'entry_type',
			'text_auto',
			'text_language'
		) as $var) {
			$this->data[$var] = $this->language->get($var);
		}

		$this->_messages();

		$this->data['action'] = $this->url->link('extension/mail/template/template_shortcode', 'token='.$this->session->data['token'] . '&id=' . $this->request->get['id'], true);

		$shortcodes = $this->model_extension_mail_template->getTemplateShortcodes(array('emailtemplate_shortcode_id' => $this->request->get['id']));
		$shortcode = $shortcodes[0];

		$this->_breadcrumbs(array('heading_template_shortcode' => array(
			'link' => 'extension/mail/template/template_shortcode',
			'params' => '&id='.$this->request->get['id']
		)));

		$this->_setTitle($this->language->get('heading_template_shortcode') . ' &raquo; ' . $shortcode['emailtemplate_shortcode_code']);

		$this->data['cancel'] = $this->url->link('extension/mail/template/template', 'token='.$this->session->data['token'] . '&id=' . $shortcode['emailtemplate_id'], true);

		$this->data['shortcode'] = array();

		foreach(EmailTemplateShortCodesDAO::describe() as $col => $type) {
			$key = (strpos($col, 'emailtemplate_shortcode_') === 0 && substr($col, -3) != '_id') ? substr($col, 24) : $col;
			if (isset($this->request->post[$col])) {
				$this->data['shortcode'][$key] = $this->request->post[$col];
			} elseif (isset($shortcode[$col])) {
				$this->data['shortcode'][$key] = $shortcode[$col];
			} else {
				$this->data['shortcode'][$key] = '';
			}
		}
	}

	/**
	 * Send Test Email with demo template
	 */
	private function _sendTestEmail($toAddress, $template_data = array(), $overwrite = array(), $preview = true) {
		if (empty($template_data)) {
			$template_data = array(
				'emailtemplate_id' => 1,
				'store_id' => 0
			);
		}

		$template = $this->model_extension_mail_template->load($template_data, $overwrite);

		if (!$template) return false;

		if (isset($template_data['emailtemplate_id']) && $template_data['emailtemplate_id'] != 1) {
			$template->data['emailtemplate'] = array_merge($template->data['emailtemplate'], $overwrite);

			// Load defualt shortcodes as data
			$default_shortcodes = $this->model_extension_mail_template->getTemplateShortcodes($template->data['emailtemplate']['emailtemplate_id']);

			if ($default_shortcodes) {
				foreach ($default_shortcodes as $row) {
					if (!isset($template->data[$row['emailtemplate_shortcode_code']])) {
						$template->data[$row['emailtemplate_shortcode_code']] = $row['emailtemplate_shortcode_example'];
					}
				}
			}
		}

		$template->data['insert_shortcodes'] = false;
		$template->data['parse_shortcodes'] = false;

	    $mail = new Mail();
		$mail->protocol = $this->config->get('config_mail_protocol');
		$mail->parameter = $this->config->get('config_mail_parameter');
		$mail->smtp_hostname = $this->config->get('config_mail_smtp_hostname');
		$mail->smtp_username = $this->config->get('config_mail_smtp_username');
		$mail->smtp_password = html_entity_decode($this->config->get('config_mail_smtp_password'), ENT_QUOTES, 'UTF-8');
		$mail->smtp_port = $this->config->get('config_mail_smtp_port');
		$mail->smtp_timeout = $this->config->get('config_mail_smtp_timeout');

		$mail->setTo($toAddress);
        $mail->setFrom($this->config->get('config_email'));
        $mail->setSender(html_entity_decode($this->config->get('config_name'), ENT_QUOTES, 'UTF-8'));
        $mail->setSubject(html_entity_decode($this->config->get('config_name'), ENT_QUOTES, 'UTF-8'));

        if ($preview) {
	        $this->language->load('extension/mail/emailtemplate');

	        $template->fetch(null, $this->language->get('text_example'));
        }

        $template->build();

		$mail->setText($template->getPlainText());

        $template->hook($mail);

        $mail->send();

        $this->model_extension_mail_template->sent();

        return true;
	}

	/**
	 * Send Test Email with demo template
	 */
	private function _sendEmailTemplateLog($emailtemplate_log_id) {
		$log = $this->model_extension_mail_template->getTemplateLog($emailtemplate_log_id);

		if ($log) {
			$mail = new Mail();
			$mail->protocol = !empty($log['emailtemplate_log_protocol']) ? $log['emailtemplate_log_protocol'] : $this->config->get('config_mail_protocol');
			$mail->parameter = !empty($log['emailtemplate_log_parameter']) ? $log['emailtemplate_log_parameter'] : $this->config->get('config_mail_parameter');

			$smtp = unserialize(base64_decode($log['emailtemplate_log_smtp']));
			$mail->smtp_hostname = isset($smtp['hostname']) ? $smtp['hostname'] : $this->config->get('config_mail_smtp_hostname');
			$mail->smtp_username = isset($smtp['username']) ? $smtp['username'] : $this->config->get('config_mail_smtp_username');
			$mail->smtp_password = html_entity_decode(isset($smtp['password']) ? $smtp['password'] : $this->config->get('config_mail_smtp_password'), ENT_QUOTES, 'UTF-8');
			$mail->smtp_port = isset($smtp['port']) ? $smtp['port'] : $this->config->get('config_mail_smtp_port');
			$mail->smtp_timeout = isset($smtp['timeout']) ? $smtp['timeout'] : $this->config->get('config_mail_smtp_timeout');

			$mail->setTo($log['emailtemplate_log_to']);
			$mail->setFrom($log['emailtemplate_log_from']);

			$file = DIR_CACHE . 'mail_queue/' . $log['emailtemplate_log_id'];

			if (file_exists($file)) {
				$mail->setHtml(file_get_contents($file));
				unlink($file);
			} else {
				// Load template if html not found
				$template_load = array(
					'emailtemplate_id' => $log['emailtemplate_id'],
					'store_id' => $log['store_id'],
					'language_id' => $log['language_id'],
					'emailtemplate_log_id' => false
				);

				$template = $this->model_extension_mail_template->load($template_load);

				if (!$template) {
					$template_load['emailtemplate_id'] = 1;
					$template = $this->model_extension_mail_template->load($template_load);
					if (!$template) return false;
				}

				$template->data['insert_shortcodes'] = false;
				$template->data['parse_shortcodes'] = false;

				$template->build();
				$template->fetch(null, $log['emailtemplate_log_content']);
				$mail->setHtml($template->getHtml());
			}

			if ($log['emailtemplate_log_sender']) {
				$mail->setSender(html_entity_decode($log['emailtemplate_log_sender'], ENT_QUOTES, 'UTF-8'));
			}

			if ($log['emailtemplate_log_subject']) {
				$mail->setSubject(html_entity_decode($log['emailtemplate_log_subject'], ENT_QUOTES, 'UTF-8'));
			}

			if ($log['emailtemplate_log_text']) {
				$mail->setText(html_entity_decode($log['emailtemplate_log_text'], ENT_QUOTES, 'UTF-8'));
			}

			if ($log['emailtemplate_log_cc']) {
				$mail->setCc($log['emailtemplate_log_cc']);
			}

			if ($log['emailtemplate_log_bcc']) {
				$mail->setBcc($log['emailtemplate_log_bcc']);
			}

			if ($log['emailtemplate_log_attachment']) {
				$log['emailtemplate_log_attachment'] = unserialize(base64_decode($log['emailtemplate_log_attachment']));
				foreach ($log['emailtemplate_log_attachment'] as $attachment) {
					if (file_exists($attachment)) {
						$mail->addAttachment($attachment);
					}
				}
			}

			$mail->setMailQueue(false);

	        $mail->send();

			$this->db->query("UPDATE " . DB_PREFIX . "emailtemplate_logs SET emailtemplate_log_sent = NOW(), emailtemplate_log_is_sent = 1 WHERE emailtemplate_log_id = " . (int)$log['emailtemplate_log_id']);
		}

		return true;
	}

	/**
	 * Populates $this->data with error_* keys using data from $this->error
	 */
	private function _messages() {
		# Attention
		if (isset($this->session->data['attention'])) {
			$this->data['error_attention'] = $this->session->data['attention'];
			unset($this->session->data['attention']);
		} else {
			$this->data['error_attention'] = '';
		}

		# Error
		if (isset($this->session->data['error'])) {
			$this->data['error_warning'] = $this->session->data['error'];
			unset($this->session->data['error']);
		} else {
			$this->data['error_warning'] = '';
		}
		foreach ($this->error as $key => $val) {
			$this->data["error_{$key}"] = $val;
		}

		# Success
		if (isset($this->session->data['success'])) {
			$this->data['success'] = $this->session->data['success'];
			unset($this->session->data['success']);
		} else {
			$this->data['success'] = '';
		}
	}

	/**
	 * Populates breadcrumbs array for $this->data
	 */
	private function _breadcrumbs($crumbs = array(), $home = true) {
		$bc = array();
		$bc_map = array(
			'text_home' => array('link' => getDashboard($this->user), 'params' => ''),
			'text_extensions' => array('link' => 'extension/extension', 'params' => '&type=mail')
		);

		if ($home) {
			$bc_map = array_merge($bc_map, array('heading_templates' => array('link' => 'extension/mail/template')));
		}
		$bc_map = array_merge($bc_map, $crumbs);

		foreach ($bc_map as $name => $item) {
			$bc[]= array(
				'text' => $this->language->get($name),
				'href' => $this->url->link($item['link'], 'token='.$this->session->data['token'] . (isset($item['params']) ? $item['params'] : ''), true)
			);
		}
   		$this->data['breadcrumbs'] = $bc;
	}

	private function _validateConfigCreate($data)
	{
		if (!$this->user->hasPermission('modify', 'extension/mail/template')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}

		if (!isset($data['emailtemplate_config_name']) || $data['emailtemplate_config_name'] == '') {
			$this->error['emailtemplate_config_name'] = $this->language->get('error_required');
		}

		if ($this->error) {
			if (!isset($this->error['warning'])) {
				$this->error['warning'] = $this->language->get('error_warning');
			}
			return false;
		} else {
			return true;
		}
	}

	private function _validateConfig($data) {
		if (!$this->user->hasPermission('modify', 'extension/mail/template')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}

		if (!isset($data['emailtemplate_config_name']) || $data['emailtemplate_config_name'] == '') {
			$this->error['emailtemplate_config_name'] = $this->language->get('error_required');
		}

		# Check directory and images exist
		if (!empty($data['emailtemplate_config_theme'])) {
			$dir = DIR_CATALOG . 'view/theme/' . $data['emailtemplate_config_theme'] . '/template/extension/mail/_main.tpl';
			if (!file_exists($dir)) {
				$this->error['emailtemplate_config_theme'] = sprintf($this->language->get('error_theme'), $dir);
			}
		}

		# Validate logo contains space or special character
		if ($data['emailtemplate_config_logo']) {
			$logo = $data['emailtemplate_config_logo'];
			if ($logo && preg_match('/[^\w.-]/', basename($logo))) {
				$this->error['emailtemplate_config_logo'] = sprintf($this->language->get('error_logo_filename'), $logo);
			}
		}

		if ($this->error) {
			if (!isset($this->error['warning'])) {
				$this->error['warning'] = $this->language->get('error_warning');
			}
			return false;
		} else {
			return true;
		}
	}

	/**
	 * Validate template form data
	 */
	private function _validateTemplate($data) {
		if (!$this->user->hasPermission('modify', 'extension/mail/template')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}

		// #1 key empty and select no set #2 either empty
		if (($data['emailtemplate_key'] == '' && !isset($data['emailtemplate_key_select'])) ||
			($data['emailtemplate_key'] == '' && empty($data['emailtemplate_key_select']))) {
			$this->error['emailtemplate_key'] = $this->language->get('error_required');
		} elseif ($data['emailtemplate_key'] != '' && !empty($data['emailtemplate_key_select'])) {
			$this->error['emailtemplate_key'] = $this->language->get('error_key_select');
		}

		if (empty($data['emailtemplate_label'])) {
			$this->error['emailtemplate_label'] = $this->language->get('error_required');
		}

		if (isset($data['emailtemplate_mail_attachment']) && $data['emailtemplate_mail_attachment']) {
			$attachments = explode(',', $data['emailtemplate_mail_attachment']);
			$dir = substr(DIR_SYSTEM, 0, -7); // remove 'system/'

			foreach($attachments as $attachment){
				$attachment = trim($attachment);
				if (!file_exists($dir.$attachment)) {
					$this->error['emailtemplate_mail_attachment'] = sprintf($this->language->get('error_file_not_exists'), $dir.$attachment);
					break;
				}
			}
		}

		if (isset($data['emailtemplate_attach_invoice']) && !$this->config->get('pdf_invoice')) {
			$this->error['emailtemplate_attach_invoice'] = $this->language->get('error_pdf_invoice');
		}

		if ($this->error && !isset($this->error['warning'])) {
			$this->error['warning'] = $this->language->get('error_warning');
		}

		if (!$this->error) {
			return true;
		} else {
			return false;
		}
	}

	/**
	 * Validate template shortcode form data
	 */
	private function _validateTemplateShortcode($data) {
		if (!$this->user->hasPermission('modify', 'extension/mail/template')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}

		if (!isset($data['emailtemplate_shortcode_code']) || $data['emailtemplate_shortcode_code'] == '') {
			$this->error['emailtemplate_shortcode_code'] = $this->language->get('error_required');
		}

		if (!isset($data['emailtemplate_shortcode_type']) || $data['emailtemplate_shortcode_type'] == '') {
			$this->error['emailtemplate_shortcode_type'] = $this->language->get('error_required');
		}

		if ($this->error && !isset($this->error['warning'])) {
			$this->error['warning'] = $this->language->get('error_warning');
		}

		if (!$this->error) {
			return true;
		} else {
			return false;
		}
	}


	/**
	 * Format Address
	 *
	 * @param Array data eg array(firstname=>'', shipping_firstname=>'', payment_firstname=>'')
	 * @param String prefix of address: '' or 'shipping' or 'payment'
	 * @param String address formatting e.g '{firstname}...'
	 */
	private function _formatAddress($address, $address_prefix = '', $format = null) {
		$find = array();
		$replace = array();
		if ($address_prefix != "") {
			$address_prefix = trim($address_prefix, '_') . '_';
		}
		if (is_null($format) || $format == '') {
			$format = '{firstname} {lastname}' . "\n" . '{company}' . "\n" . '{address_1}' . "\n" . '{address_2}' . "\n" . '{city} {postcode}' . "\n" . '{zone}' . "\n" . '{country}';
		}
		$vars = array(
				'firstname',
				'lastname',
				'company',
				'address_1',
				'address_2',
				'city',
				'postcode',
				'zone',
				'zone_code',
				'country'
		);
		foreach($vars as $var) {
			$find[$var] = '{'.$var.'}';
			if ($address_prefix && isset($address[$address_prefix.$var])) {
				$replace[$var] =  $address[$address_prefix.$var];
			} elseif (isset($address[$var])) {
				$replace[$var] =  $address[$var];
			} else {
				$replace[$var] =  '';
			}
		}
		return str_replace(array("\r\n", "\r", "\n"), '<br />', preg_replace(array("/\s\s+/", "/\r\r+/", "/\n\n+/"), '<br />', trim(str_replace($find, $replace, $format))));
	}

	/**
	 * Truncate Text
	 *
	 * @param string $text
	 * @param int $limit
	 * @param string $ellipsis
	 * @return string
	 */
	private function _truncate_str($str, $length = 100, $breakWords = true, $append = '...') {
		$str = strip_tags(html_entity_decode($str, ENT_QUOTES, 'UTF-8'));

		$strLength = utf8_strlen($str);
		if ($strLength <= $length) {
			return $str;
		}

		if (!$breakWords) {
			while ($length < $strLength AND preg_match('/^\pL$/', utf8_substr($str, $length, 1))) {
				$length++;
			}
		}

		$str = utf8_substr($str, 0, $length) . $append;
		$str = preg_replace('/\s{3,}/',' ', $str);
		$str = trim($str);

		return $str;
	}


	/**
	 * Output Page
	 *
	 * @param string $template - template file path
	 * @param array $children
	 */
	private function _setTitle($title = '') {
		if ($title == '') {
			$title = $this->language->get('heading_title');
		} else {
			$title .= ' - ' . $this->language->get('heading_title');
		}

		$this->data['title'] = $title;

		$this->document->setTitle(strip_tags($title));

		return $this;
	}

	/**
	 * Output Page
	 *
	 * @param string $template - template file path
	 */
	private function _output($tpl) {
		if ($this->_css) {
			foreach($this->_css as $file) {
				$this->document->addStyle($file);
			}
		}

		if ($this->_js) {
			foreach($this->_js as $file) {
				$this->document->addScript($file);
			}
		}

		$this->data['header'] = $this->load->controller('common/header');
		$this->data['column_left'] = $this->load->controller('common/column_left');
		$this->data['footer'] = $this->load->controller('common/footer');

		$this->response->setOutput($this->load->view($tpl, $this->data));
	}

	/**
	 * Pagination
	 *
	 * @param string $url
	 * @param int $page - current page number
	 * @param int $total - total rows count
	 */
	private function _renderPagination($url, $page, $total, $limit = null, $style = '') {
		$pagination = new Pagination();
		$pagination->total = $total;
		$pagination->paging_style = $style;
		$pagination->page = $page;
		$pagination->limit = ($limit == null) ? $this->config->get('config_limit_admin') : $limit;
		$pagination->text = $this->language->get('text_pagination');
		$pagination->url = $url;

		$this->data['pagination'] = $pagination->render();

		$this->data['pagination_results'] = sprintf($this->language->get('text_pagination'), ($pagination->total) ? (($page - 1) * $pagination->limit) + 1 : 0, ((($page - 1) * $pagination->limit) > ($pagination->total - $pagination->limit)) ? $pagination->total : ((($page - 1) * $pagination->limit) + $pagination->limit), $pagination->total, ceil($pagination->total / $pagination->limit));
	}

	private function _link($link, $isAdmin = false) {
		if ($isAdmin) {
			return $this->url->link($link, 'token='.$this->session->data['token'], true);
		} else {
			if ($this->config->get('config_secure') && defined('HTTPS_SERVER') && defined('HTTPS_CATALOG')) {
				return str_replace(HTTPS_SERVER, HTTPS_CATALOG, $this->url->link($link, '', true));
			} else {
				return str_replace(HTTP_SERVER, HTTP_CATALOG, $this->url->link($link, '', true));
			}
		}
	}

}
?>