<?php
class ModelExtensionMailTemplate extends Model {

	private $version = '2.9.3.9';

	private $content_count = 3;

	private $original_templates = array(
		// Customer
		'customer.register',
		'customer.forgotten',
		'information.contact_customer',
		'admin.customer_approve',
		'admin.customer_create',
		'admin.customer_reward',
		'admin.customer_transaction',
		'admin.newsletter',

		// Order
		'order.customer',
		'order.admin',
		'order.return',
		'order.update',
		'order.voucher',
		'admin.return_history',
		'admin.voucher',

		// Affiliate
		'admin.affiliate_approve',
		'admin.affiliate_transaction',
		'affiliate.forgotten',
		'affiliate.register',

		// Admin
		'customer.register_admin',
		'information.contact',
		'affiliate.register_admin',
		'product.review'
	);

	/**
	 * Load Email Template
	 *
	 * @param mixed   $load
	 *        null    load default email template (1)
	 *        array   load email template using array key(s)
	 *        int     load email template using `emailtemplate_id`
	 *        string  load email template using `emailtemplate_key`
	 * @param array   extra data used to load template
	 * @return object EmailTemplate
	 */
	public function load($load = null, $template_data = array()) {
		if (is_null($load)) {
			$filter = array('emailtemplate_id' => 1);
		} elseif (is_numeric($load) && $load) {
			$filter = array('emailtemplate_id' => $load);
		} elseif (is_string($load) && $load) {
			$filter = array('emailtemplate_key' => $load);
		} elseif (is_array($load)) {
			$filter = array();

			if (!empty($load['emailtemplate_config_id'])) {
				$filter['emailtemplate_config_id'] = $load['emailtemplate_config_id'];
			}

			if (isset($load['emailtemplate_id'])) {
				$filter['emailtemplate_id'] = $load['emailtemplate_id'];
			}

			if (isset($load['order_status_id'])) {
				$filter['order_status_id'] = $load['order_status_id'];
			}

			if (isset($load['emailtemplate_key'])) {
				$filter['emailtemplate_key'] = $load['emailtemplate_key'];
			} elseif (isset($load['key'])) {
				$filter['emailtemplate_key'] = $load['key'];
			}
		}

		if (empty($filter)) {
			$filter = array('emailtemplate_id' => 1);
		}

		$templates = $this->getTemplates($filter);

		if (!$templates) {
			return false;
		}

		if (isset($load['language_id']) && $load['language_id']) {
			$language_id = $load['language_id'];
		} else {
			$language_id = $this->config->get("config_language_id");
		}

		if (isset($load['store_id'])) {
			$store_id = $load['store_id'];
		} else {
			$store_id = $this->config->get("config_store_id");
		}
		if (!$store_id || $store_id < 0) {
			$store_id = 0;
		}

		if (isset($load['customer_id']) && $load['customer_id']) {
			$customer_id = $load['customer_id'];
			$customer_group_id = $this->config->get("config_customer_group_id"); // TODO
		} else {
			$customer_id = 0;
			$customer_group_id = $this->config->get("config_customer_group_id");
		}

		$keys = array(
			'language_id' => $language_id,
			'customer_group_id' => $customer_group_id,
			'store_id' => $store_id
		);

		if (isset($filter['order_status_id'])) {
			$keys['order_status_id'] = $filter['order_status_id'];
		}

		foreach ($templates as &$template) {
			$template['power'] = 0;

			foreach ($keys as $_key => $_value) {
				$template['power'] = $template['power'] << 1;

				if (isset($template[$_key]) && $template[$_key] == $_value) {
					$template['power'] |= 1;
				}
			}

			if (!empty($template['emailtemplate_condition'])) {
				if (!is_array($template['emailtemplate_condition'])) {
					$unserialized = @unserialize(base64_decode($template['emailtemplate_condition']));
					$template['emailtemplate_condition'] = ($unserialized !== false) ? $unserialized : $template['emailtemplate_condition'];
				}
				if (is_array($template['emailtemplate_condition'])) {
					foreach($template['emailtemplate_condition'] as $condition) {
						$template['power'] = $template['power'] << 1;
						$key = trim($condition['key']);

						if (!isset($template_data[$key])) {
							trigger_error('Warning email template(' . $template['emailtemplate_key'] . ') missing data: ' . $key);
							continue;
						}

						$value = $template_data[$key];

						if ($value) {
							switch(html_entity_decode($condition['operator'], ENT_COMPAT, "UTF-8")) {
								case '==':
									if ($value == $condition['value'])
										$template['power'] |= 1;
									break;
								case '!=':
									if ($value != $condition['value'])
										$template['power'] |= 1;
									break;
								case '>':
									if ($value > $condition['value'])
										$template['power'] |= 1;
									break;
								case '<':
									if ($value < $condition['value'])
										$template['power'] |= 1;
									break;
								case '>=':
									if ($value >= $condition['value'])
										$template['power'] |= 1;
									break;
								case '<=':
									if ($value <= $condition['value'])
										$template['power'] |= 1;
									break;
								case 'IN':
									$haystack = explode(',', $condition['value']);
									if (is_array($haystack) && in_array($value, $haystack))
										$template['power'] |= 1;
									break;
								case 'NOTIN':
									$haystack = explode(',', $condition['value']);
									if (is_array($haystack) && !in_array($value, $haystack))
										$template['power'] |= 1;
									break;
							}
						}
					}
				}
			}
		}
		unset($template);

		$emailtemplate = $templates[0];

		if (count($templates) > 1) {
			foreach ($templates as $template) {
				if ($template['emailtemplate_default']) {
					$emailtemplate = $template;
					break;
				}
			}

			foreach ($templates as $template) {
				if ($template['power'] > $emailtemplate['power']) {
					$emailtemplate = $template;
				}
			}
		}

		$description = $this->getTemplateDescription(array(
			'emailtemplate_id' => $emailtemplate['emailtemplate_id'],
			'language_id' => $language_id
		), 1);

		if (!$description) {
			return false;
		}

		foreach($emailtemplate as $key => $val) {
			if (strpos($key, 'emailtemplate_') === 0 && substr($key, -3) != '_id') {
				unset($emailtemplate[$key]);
				$emailtemplate[substr($key, 14)] = $val;
			}
		}

		foreach($description as $key => $val) {
			if (isset($emailtemplate[$key])) continue;

			if (strpos($key, 'emailtemplate_description_') === 0 && substr($key, -3) != '_id') {
				$emailtemplate[substr($key, 26)] = $val;
			} else {
				$emailtemplate[$key] = $val;
			}
		}

		if (!empty($filter['emailtemplate_config_id'])) {
			$template_config = $this->getConfig($filter['emailtemplate_config_id']);
		}
		if (empty($template_config) && $emailtemplate['emailtemplate_config_id']) {
			$template_config = $this->getConfig($emailtemplate['emailtemplate_config_id']);
		}
		if (empty($template_config)){
			$config_load = array('store_id' => $store_id, 'language_id' => $language_id);

			$configs = $this->getConfigs($config_load);

			if (!$configs) {
				$configs = $this->getConfigs();
			}

			if ($configs) {
				if (count($configs) == 1) {
					$template_config = $configs[0];
				} elseif (count($configs) > 1) {
					foreach ($configs as $config) {
						if ($config['language_id'] == $language_id && $config['store_id'] == $store_id) {
							$template_config = $config;
							break;
						}
					}

					if (empty($template_config)) {
						foreach ($configs as $config) {
							if (($config['language_id'] == $language_id || $config['language_id'] == 0) && ($config['store_id'] == $store_id || $config['store_id'] == 0)) {
								$template_config = $config;
								break;
							}
						}
					}

					unset($config);
				}
			}
		}
		if (empty($template_config)) {
			$template_config = $this->getConfig(1);
		}

		$emailtemplate_config = array();

		foreach($template_config as $key => $val) {
			if (strpos($key, 'emailtemplate_config_') === 0 && substr($key, -3) != '_id') {
				unset($emailtemplate_config[$key]);
				$emailtemplate_config[substr($key, 21)] = $val;
			} else {
				$emailtemplate_config[$key] = $val;
			}
		}

		// Start adding data
		$this->load->library('emailtemplate');

		$this->emailtemplate->data['store_id'] = $store_id;

		$this->emailtemplate->data['language_id'] = $language_id;

		$this->emailtemplate->data['customer_id'] = $customer_id;
		$this->emailtemplate->data['customer_group_id'] = $customer_group_id;

		// Fetch store data
		$this->load->model('setting/store');
		$this->load->model('setting/setting');

		$store_info = array_merge(
			$this->model_setting_setting->getSetting("config", $store_id),
			$this->model_setting_store->getStore($store_id)
		);

		$config_keys = array('title', 'name', 'url', 'ssl', 'owner', 'address', 'email', 'telephone', 'fax', 'country_id', 'currency', 'zone_id', 'tax', 'tax_default', 'customer_price');

		foreach($config_keys as $_key) {
			if(isset($this->emailtemplate->data['store_'.$_key])) continue;

			if (isset($store_info[$_key])) {
				$this->emailtemplate->data['store_'.$_key] =  $store_info[$_key];
			} elseif (isset($store_info['config_'.$_key])) {
				$this->emailtemplate->data['store_'.$_key] =  $store_info['config_'.$_key];
			} else {
				$this->emailtemplate->data['store_'.$_key] =  '';
			}
		}

		// Fallback for store_id = 0
		if (!$this->emailtemplate->data['store_url']) {
			$this->emailtemplate->data['store_url'] = HTTP_CATALOG;
		}

		if (!$this->emailtemplate->data['store_ssl']) {
			$this->emailtemplate->data['store_ssl'] = HTTPS_CATALOG;
		}

		$this->emailtemplate->data['title'] = $this->emailtemplate->data['store_name'];

		if(defined('HTTP_IMAGE')){
			$image_url = HTTP_IMAGE;
		} else {
			$image_url = $this->emailtemplate->data['store_url'] . 'image/';
		}

		// Add EmailTemplate
		$this->emailtemplate->data['emailtemplate'] = $emailtemplate;

		$this->emailtemplate->data['config'] = $emailtemplate_config;

		// Add any extra data used to load template
		if ($template_data && is_array($template_data)) {
			foreach ($template_data as $i => $val) {
				if (is_array($val) && !empty($this->emailtemplate->data[$i])) {
					$this->emailtemplate->data[$i] = array_merge($this->emailtemplate->data[$i], $template_data[$i]);
					unset($template_data[$i]);
				}
			}

			$this->emailtemplate->data = array_merge($this->emailtemplate->data, $template_data);
		}

		// Format
		for($i=1; $i <= $this->content_count; $i++) {
			if (!empty($this->emailtemplate->data['emailtemplate']['content'.$i])) {
				$this->emailtemplate->data['emailtemplate']['content'.$i] = html_entity_decode($this->emailtemplate->data['emailtemplate']['content'.$i], ENT_QUOTES, 'UTF-8');
			}
		}

		if ($this->emailtemplate->data['emailtemplate']['comment']) {
			$this->emailtemplate->data['emailtemplate']['comment'] = html_entity_decode($this->emailtemplate->data['emailtemplate']['comment'], ENT_QUOTES, 'UTF-8');
		}

		// Extract multi-language
		foreach (array(
	         'header_html',
	         'head_text',
	         'page_footer_text',
	         'footer_text',
	         'unsubscribe_text',
	         'showcase_title',
	         'view_browser_text'
         ) as $var) {
			if (isset($this->emailtemplate->data['config'][$var])) {
				if (is_string($this->emailtemplate->data['config'][$var])) {
					$this->emailtemplate->data['config'][$var] = html_entity_decode($this->emailtemplate->data['config'][$var], ENT_QUOTES, 'UTF-8');
				} elseif (isset($this->emailtemplate->data['config'][$var][$language_id])) {
					$this->emailtemplate->data['config'][$var] = html_entity_decode($this->emailtemplate->data['config'][$var][$language_id], ENT_QUOTES, 'UTF-8');
				}
			}
		}

		foreach (array(
	         'header_spacing', 'header_border_top', 'header_border_bottom', 'header_border_right', 'header_border_left',
	         'footer_padding', 'footer_spacing', 'footer_border_top', 'footer_border_bottom', 'footer_border_right', 'footer_border_left',
	         'page_padding', 'page_spacing', 'page_border_top', 'page_border_bottom', 'page_border_right', 'page_border_left',
	         'showcase_padding', 'showcase_border_top', 'showcase_border_bottom', 'showcase_border_right', 'showcase_border_left',
         ) as $var) {
			if (isset($this->emailtemplate->data['config'][$var]) && !is_array($this->emailtemplate->data['config'][$var])) {
				$this->emailtemplate->data['config'][$var] = explode(',', $this->emailtemplate->data['config'][$var]);
			}
		}

		$this->emailtemplate->data['config']['border_radius'] = false;
		foreach (array(
	         'header_border_radius','footer_border_radius','page_border_radius', 'showcase_border_radius'
         ) as $var) {
			if (isset($this->emailtemplate->data['config'][$var])) {
				if (!is_array($this->emailtemplate->data['config'][$var])) {
					$this->emailtemplate->data['config'][$var] = explode(',', $this->emailtemplate->data['config'][$var]);
				}
				foreach ($this->emailtemplate->data['config'][$var] as $val) {
					if ((int)$val) {
						$this->emailtemplate->data['config']['border_radius'] = true;
					}
				}
			}
		}

		if ($this->emailtemplate->data['config']['order_products'] && $this->emailtemplate->data['config']['order_products'] && !is_array($this->emailtemplate->data['config']['order_products'])) {
			$unserialized = @unserialize(base64_decode($this->emailtemplate->data['config']['order_products']));
			$this->emailtemplate->data['config']['order_products'] = ($unserialized !== false) ? $unserialized : $this->emailtemplate->data['config']['order_products'];
		}
		if (!isset($this->emailtemplate->data['config']['order_products']['quantity_column'])) {
			$this->emailtemplate->data['config']['order_products']['quantity_column'] = 1;
		}
		if (!isset($this->emailtemplate->data['config']['order_products']['admin_stock'])) {
			$this->emailtemplate->data['config']['order_products']['admin_stock'] = 1;
		}
		if (!isset($this->emailtemplate->data['config']['order_products']['layout'])) {
			$this->emailtemplate->data['config']['order_products']['layout'] = 'default';
		}
		if (!isset($this->emailtemplate->data['emailtemplate_config']['order_products']['image_width'])) {
			$this->emailtemplate->data['emailtemplate_config']['order_products']['image_width'] = 100;
		}
		if (!isset($this->emailtemplate->data['emailtemplate_config']['order_products']['image_height'])) {
			$this->emailtemplate->data['emailtemplate_config']['order_products']['image_height'] = 100;
		}

		// Shadow
		foreach(array('top','bottom','left','right') as $var) {
			if (isset($this->emailtemplate->data['config']['shadow_'.$var]) && !is_array($this->emailtemplate->data['config']['shadow_'.$var])) {
				$unserialized = @unserialize(base64_decode($this->emailtemplate->data['config']['shadow_'.$var]));
				$this->emailtemplate->data['config']['shadow_'.$var] = ($unserialized !== false) ? $unserialized : $this->emailtemplate->data['config']['shadow_'.$var];
			}
		}

		foreach (array('top', 'bottom') as $v) {
			foreach (array('left', 'right') as $h) {
				if (!empty($this->emailtemplate->data['config']['shadow_'.$v][$h.'_img'])) {
					$this->emailtemplate->data['config']['shadow_'.$v][$h.'_img'] = ($this->emailtemplate->data['config']['shadow_'.$v][$h.'_img']) ? $image_url . $this->emailtemplate->data['config']['shadow_'.$v][$h.'_img'] : '';
					$this->emailtemplate->data['config']['shadow_'.$v][$h.'_img_height'] = (int)$this->emailtemplate->data['config']['shadow_'.$v]['length'] + (int)$this->emailtemplate->data['config']['shadow_'.$v]['overlap'];
					$this->emailtemplate->data['config']['shadow_'.$v][$h.'_img_width'] = (int)$this->emailtemplate->data['config']['shadow_'.$h]['length'] + (int)$this->emailtemplate->data['config']['shadow_'.$h]['overlap'];
				}
			}
		}

		foreach(array('left', 'right') as $col) {
			if (isset($this->emailtemplate->data['config']['shadow_top'][$col.'_img']) && file_exists(DIR_IMAGE . $this->emailtemplate->data['config']['shadow_top'][$col.'_img'])) {
				$this->emailtemplate->data['config']['shadow_top'][$col.'_thumb'] = $image_url . $this->emailtemplate->data['config']['shadow_top'][$col.'_img'];
			}

			if (isset($this->emailtemplate->data['config']['shadow_bottom'][$col.'_img']) && file_exists(DIR_IMAGE . $this->emailtemplate->data['config']['shadow_bottom'][$col.'_img'])) {
				$this->emailtemplate->data['config']['shadow_bottom'][$col.'_thumb'] = $image_url . $this->emailtemplate->data['config']['shadow_bottom'][$col.'_img'];
			}
		}

		if ($this->emailtemplate->data['config']['body_bg_image']) {
			$this->emailtemplate->data['config']['body_bg_image'] = $image_url . $this->emailtemplate->data['config']['body_bg_image'];
		}

		if ($this->emailtemplate->data['config']['header_bg_image']) {
			$this->emailtemplate->data['config']['header_bg_image'] = $image_url . $this->emailtemplate->data['config']['header_bg_image'];
		}

		if ($this->emailtemplate->data['config']['logo']) {
			if ($this->emailtemplate->data['config']['logo_width'] && $this->emailtemplate->data['config']['logo_height']) {
				$this->load->model('tool/image');

				$product_image_url = $this->model_tool_image->resize($this->emailtemplate->data['config']['logo'], $this->emailtemplate->data['config']['logo_width'], $this->emailtemplate->data['config']['logo_height']);

				// Replace admin url with store
				$product_image_url = str_replace(HTTP_SERVER, $this->emailtemplate->data['store_url'], $product_image_url);
				$product_image_url = str_replace(HTTPS_SERVER, $this->emailtemplate->data['store_url'], $product_image_url);

				$this->emailtemplate->data['config']['logo'] = $product_image_url;
			} else {
				$this->emailtemplate->data['config']['logo'] = $image_url . $this->emailtemplate->data['config']['logo'];
			}
		}

		$this->emailtemplate->data['config']['template_dir'] = DIR_CATALOG . 'view/theme/' . $this->emailtemplate->data['config']['theme'] . '/template/extension/mail/';

		// Default to px if no unit
		$unit = preg_replace('/[0-9]+/', '', $this->emailtemplate->data['config']['email_width']);

		if (!$unit) {
			$unit = 'px';
			$this->emailtemplate->data['config']['email_width'] .= $unit;
		}

		if ($unit == 'px') {
			$this->emailtemplate->data['config']['email_full_width'] = (int)$this->emailtemplate->data['config']['email_width'] + ((int)$this->emailtemplate->data['config']['shadow_left']['length'] + (int)$this->emailtemplate->data['config']['shadow_right']['length']);

			$this->emailtemplate->data['config']['email_inner_width'] = (int)$this->emailtemplate->data['config']['email_width'];

			if ($this->emailtemplate->data['config']['page_padding'] && count($this->emailtemplate->data['config']['page_padding']) == 4){
				$this->emailtemplate->data['config']['email_inner_width'] -= $this->emailtemplate->data['config']['page_padding'][1] + $this->emailtemplate->data['config']['page_padding'][3];
			}

			if ($this->emailtemplate->data['config']['page_border_left'] && count($this->emailtemplate->data['config']['page_border_left']) == 2){
				$this->emailtemplate->data['config']['email_inner_width'] -= $this->emailtemplate->data['config']['page_border_left'][0];
			}

			if ($this->emailtemplate->data['config']['page_border_right'] && count($this->emailtemplate->data['config']['page_border_right']) == 2){
				$this->emailtemplate->data['config']['email_inner_width'] -= $this->emailtemplate->data['config']['page_border_right'][0];
			}
		} else {
			$this->emailtemplate->data['config']['email_full_width'] = (int)$this->emailtemplate->data['config']['email_width'];

			$this->emailtemplate->data['config']['email_inner_width'] = (int)$this->emailtemplate->data['config']['email_width'];
		}

		$email_inner_width = $this->emailtemplate->data['config']['email_inner_width'];

		$this->emailtemplate->data['config']['email_inner_width'] .= $unit;
		$this->emailtemplate->data['config']['email_full_width'] .= $unit;

		// Language files
		$this->load->model('localisation/language');

		$language_info = $this->model_localisation_language->getLanguage($language_id);

		$oLanguage = new Language($language_info['code']);

		if (substr($emailtemplate['key'], 0, 6) != 'admin.' && defined('DIR_CATALOG')) {
			$oLanguage->setPath(DIR_CATALOG.'language/');
		}

		$oLanguage->load($language_info['code']);

		if ($this->emailtemplate->data['emailtemplate']['language_files']) {
			$language_files = explode(',', $this->emailtemplate->data['emailtemplate']['language_files']);

			if ($language_files) {
				foreach ($language_files as $language_file) {
					$oLanguage->load(trim($language_file));
				}
			}
		}

		$this->emailtemplate->language_data = $oLanguage->load('extension/mail/emailtemplate');

		if ($this->emailtemplate->language_data) {
			$this->emailtemplate->data = array_merge($this->emailtemplate->language_data, $this->emailtemplate->data);
		}

		// Showcase
		if ($this->emailtemplate->data['config']['showcase'] && $this->emailtemplate->data['emailtemplate']['showcase']) {
			if(!empty($this->emailtemplate->data['customer_id'])) {
				$customer_id = $this->emailtemplate->data['customer_id'];
			}  else {
				$customer_id = null;
			}

			$this->emailtemplate->data['showcase_selection'] = $this->getShowcase($customer_id, $store_info, $this->emailtemplate->data['config']);
		}

		if (!empty($this->emailtemplate->data['showcase_selection'])) {
			if (count($this->emailtemplate->data['showcase_selection']) < $this->emailtemplate->data['config']['showcase_per_row']) {
				$this->emailtemplate->data['config']['showcase_item_width'] = $email_inner_width / count($this->emailtemplate->data['showcase_selection']);
				$this->emailtemplate->data['config']['showcase_item_width_outlook'] = $this->emailtemplate->data['config']['showcase_item_width'] - count($this->emailtemplate->data['showcase_selection']);
			} else {
				$this->emailtemplate->data['config']['showcase_item_width'] = $email_inner_width / $this->emailtemplate->data['config']['showcase_per_row'];
				$this->emailtemplate->data['config']['showcase_item_width_outlook'] = $this->emailtemplate->data['config']['showcase_item_width'] - $this->emailtemplate->data['config']['showcase_per_row'];
			}
			$this->emailtemplate->data['config']['showcase_item_width'] = ((int)$this->emailtemplate->data['config']['showcase_item_width']) . $unit;
			$this->emailtemplate->data['config']['showcase_item_width_outlook'] = ((int)$this->emailtemplate->data['config']['showcase_item_width_outlook']) . $unit;
		}

		$this->emailtemplate->data['account_url'] = $this->emailtemplate->data['store_url'] . 'index.php?route=' . rawurlencode('account/account');
		$this->emailtemplate->data['contact_url'] = $this->emailtemplate->data['store_url'] . 'index.php?route=' . rawurlencode('information/contact');
		$this->emailtemplate->data['home_url'] = $this->emailtemplate->data['store_url'] . 'index.php?route=' . rawurlencode('common/home');

		if ($emailtemplate['shortcodes'] == 1){
			$result = $this->getTemplateShortcodes($emailtemplate['emailtemplate_id']);

			if ($result) {
				$default_shortcodes = array();

				foreach ($result as $row) {
					$parts = explode('.', $row['emailtemplate_shortcode_code']);

					if (isset($parts[1])) {
						$default_shortcodes[$parts[0] . '.' . $parts[1]] = '';
					} else {
						$default_shortcodes[$parts[0]] = '';
					}
				}

				$this->emailtemplate->setDefaultShortcodes($default_shortcodes);
			}
		}

		if ($this->emailtemplate->data['emailtemplate']['wrapper_tpl']) {
			$this->emailtemplate->data['wrapper_tpl'] = $this->emailtemplate->data['emailtemplate']['wrapper_tpl'];
		} elseif ($this->emailtemplate->data['config']['wrapper_tpl']) {
			$this->emailtemplate->data['wrapper_tpl'] = $this->emailtemplate->data['config']['wrapper_tpl'];
		}


		if (!isset($template_data['emailtemplate_log_id']) & ($emailtemplate['log'] || $emailtemplate_config['log'])) {
			$this->emailtemplate_log_id = $this->emailtemplate->data['emailtemplate_log_id'] = $this->createTemplateLog();
		}

		return $this->emailtemplate;
	}

	/**
	 * Perform actions after email has been sent.
	 */
	public function sent() {
		if (!$this->emailtemplate || !$this->emailtemplate instanceof EmailTemplate) {
			trigger_error('Error: missing emailtemplate library!');
			return false;
		}

		if (empty($this->emailtemplate->data['emailtemplate'])) {
			trigger_error('Error: missing emailtemplate data!');
			return false;
		}

		// Clear attachments
		if (isset($this->emailtemplate->data['emailtemplate_invoice_pdf']) && file_exists($this->emailtemplate->data['emailtemplate_invoice_pdf'])) {
			unlink($this->emailtemplate->data['emailtemplate_invoice_pdf']);
		}

		// Shortcodes
		if ($this->emailtemplate->data['emailtemplate']['shortcodes'] == 0) {
			$this->insertTemplateShortcodes($this->emailtemplate->data['emailtemplate']['emailtemplate_id'], $this->emailtemplate->data, $this->emailtemplate->language_data);
		}

		$this->recordProductsInShowcase();

		// Log
		if (isset($this->emailtemplate->data['emailtemplate_log_id'])) {
			$log_data = array();

			$log_data['emailtemplate_log_content'] = htmlspecialchars($this->emailtemplate->getHtmlContent(), ENT_COMPAT, 'UTF-8');

			$log_data['emailtemplate_log_enc'] = $this->emailtemplate->getLogCode();

			$log_data['emailtemplate_log_is_sent'] = ($this->emailtemplate->data['mail']['mail_queue']) ? 0 : 1;

			$log_data['emailtemplate_log_attachment'] = base64_encode(serialize($this->emailtemplate->data['mail']['attachments']));

			$log_data['emailtemplate_log_protocol'] = $this->emailtemplate->data['mail']['protocol'];
			$log_data['emailtemplate_log_parameter'] = $this->emailtemplate->data['mail']['parameter'];
			$log_data['emailtemplate_log_smtp'] = base64_encode(serialize($this->emailtemplate->data['mail']['smtp']));

			$log_data['emailtemplate_log_to'] = $this->emailtemplate->data['mail']['to'];
			$log_data['emailtemplate_log_from'] = $this->emailtemplate->data['mail']['from'];
			$log_data['emailtemplate_log_sender'] = $this->emailtemplate->data['mail']['sender'];

			$log_data['emailtemplate_log_cc'] = $this->emailtemplate->data['mail']['cc'];
			$log_data['emailtemplate_log_bcc'] = $this->emailtemplate->data['mail']['bcc'];

			$log_data['emailtemplate_log_subject'] = $this->emailtemplate->data['mail']['subject'];

			$log_data['emailtemplate_log_text'] = $this->emailtemplate->data['mail']['text'];

			$log_data['emailtemplate_id'] = $this->emailtemplate->data['emailtemplate']['emailtemplate_id'];
			$log_data['emailtemplate_config_id'] = $this->emailtemplate->data['config']['emailtemplate_config_id'];
			$log_data['customer_id'] = $this->emailtemplate->data['customer_id'];
			$log_data['store_id'] = $this->emailtemplate->data['store_id'];
			$log_data['language_id'] = $this->emailtemplate->data['language_id'];

			if (isset($this->emailtemplate->data['order_id'])) {
				$log_data['order_id'] = $this->emailtemplate->data['order_id'];
			} else {
				$log_data['order_id'] = 0;
			}

			return $this->updateTemplateLog($this->emailtemplate->data['emailtemplate_log_id'], $log_data);
		}
	}

	public function getShowcase($customer_id, $store_info, $emailtemplate_config) {
		$showcase_selection = array();

		$this->load->model('extension/mail/template/product');
		$this->load->model('tool/image');

		if ($this->model_extension_mail_template_product) {
			$products = array();
			$order_products = array();

			$order_id = $this->emailtemplate->get('order_id');
			$store_id = $this->emailtemplate->get('store_id');
			$customer_group_id = $this->emailtemplate->get('customer_group_id');
			$language_id = $this->emailtemplate->get('language_id');

			if ($emailtemplate_config['showcase_related'] && $order_id) {
				$this->load->model('account/order');

				$result = $this->model_account_order->getOrderProducts($order_id);
				if ($result) {
					foreach($result as $row) {
						$order_products[$row['product_id']] = $row;
					}

					foreach($result as $row) {
						$result2 = $this->model_extension_mail_template_product->getProductRelated($row['product_id']);

						if ($result2) {
							foreach($result2 as $row2) {
								if (!isset($products[$row2['product_id']]) && !isset($order_products[$row2['product_id']])) {
									$products[$row2['product_id']] = $row2;
								}
							}
						}
					}
				}
			}

			if (count($products) < $emailtemplate_config['showcase_limit']) {
				$result = false;
				$limit = count($order_products) + $emailtemplate_config['showcase_limit'];

				switch($emailtemplate_config['showcase']) {
					case 'bestsellers':
						$result = $this->model_extension_mail_template_product->getBestSellerProducts($limit, $language_id, $store_id, $customer_group_id, $customer_id);
						break;

					case 'latest':
						$result = $this->model_extension_mail_template_product->getLatestProducts($limit, $language_id, $store_id, $customer_group_id, $customer_id);
						break;

					case 'specials':
						$result = $this->model_extension_mail_template_product->getProductSpecials($limit, $language_id, $store_id, $customer_group_id, $customer_id);
						break;

					case 'popular':
						$result = $this->model_extension_mail_template_product->getPopularProducts($limit, $language_id, $store_id, $customer_group_id, $customer_id);
						break;

					case 'products':
						if ($emailtemplate_config['showcase_selection']) {
							$result = array();
							$selection = explode(',', $emailtemplate_config['showcase_selection']);
							foreach($selection as $product_id) {
								if ($product_id && !isset($products[$product_id])) {
									$row = $this->model_extension_mail_template_product->getProduct((int)$product_id, $language_id, $store_id, $customer_group_id);
									if ($row) {
										$result[] = $row;
									}
								}
							}
						}
						break;
				}

				if(!empty($result)){
					foreach($result as $row) {
						if (count($products) >= $emailtemplate_config['showcase_limit']) {
							break;
						}
						if (!isset($products[$row['product_id']]) && !isset($order_products[$row['product_id']])) {
							$products[$row['product_id']] = $row;
						}
					}
				}
			}

			if (!empty($products)) {
				foreach($products as $product) {
					if (!isset($product['product_id'])) continue;

					if ($product['image']) {
						$product_image_url = $this->model_tool_image->resize($product['image'], 100, 100);

						// Replace admin url with store
						$product_image_url = str_replace(HTTP_SERVER, $this->emailtemplate->data['store_url'], $product_image_url);
						$product_image_url = str_replace(HTTPS_SERVER, $this->emailtemplate->data['store_url'], $product_image_url);

						$product['image'] = $product_image_url;
					}

					if (!$store_info['config_customer_price']) {
						$price = $this->currency->format($this->tax->calculate($product['price'], $product['tax_class_id'], $store_info['config_tax']), $store_info['config_currency']);
					} else {
						$price = false;
					}

					if (!$store_info['config_customer_price'] && (float)$product['special']) {
						$special = $this->currency->format($this->tax->calculate($product['special'], $product['tax_class_id'], $store_info['config_tax']), $store_info['config_currency']);
					} else {
						$special = false;
					}

					$url = $this->emailtemplate->data['store_url'] . 'index.php?route=' . rawurlencode('product/product') . '&product_id=' . $product['product_id'];

					$showcase = array(
						'product_id' => $product['product_id'],
						'image' => $product['image'],
						'name' => $product['name'],
						'rating' => round($product['rating']),
						'reviews' => $product['reviews'] ? $product['reviews'] : 0,
						'name_short' => $this->_truncate($product['name'], 28, ''),
						'description' => $this->_truncate($product['description'], 100),
						'price' => $price,
						'special' => $special,
						'url' => $url
					);

					if ($showcase['name_short'] != $showcase['name']) {
						$showcase['preview'] = $showcase['name'] . ' - ' . $showcase['description'];
					} else {
						$showcase['preview'] = $showcase['description'];
					}

					$showcase_selection[] = $showcase;
				}

				return $showcase_selection;
			}
		}
	}

	public function getVersion() {
		return $this->version;
	}

	/**
	 * Record Products In Showcase
	 *
	 */
	public function recordProductsInShowcase() {
		if (empty($this->emailtemplate->data['config']) ||
			empty($this->emailtemplate->data['config']['showcase_cycle']) ||
			empty($this->emailtemplate->data['showcase_selection']) ||
			empty($this->emailtemplate->data['mail']['to'])) {
			return false;
		}

		if ($this->emailtemplate->get('customer_id')) {
			$customer_id = $this->emailtemplate->get('customer_id');
		} else {
			$this->load->model('customer/customer');

			$email = $this->emailtemplate->data['mail']['to'];

			$customer_info = $this->model_customer_customer->getCustomerByEmail($email);

			if (!$customer_info || empty($customer_info['customer_id']))
				return false;

			$customer_id = $customer_info['customer_id'];
		}

		foreach($this->emailtemplate->data['showcase_selection'] as $showcase_selection) {
			if (empty($showcase_selection['product_id']))
				continue;

			$product_id = $showcase_selection['product_id'];

			$query = "SELECT 1 FROM " . DB_PREFIX . "emailtemplate_showcase_log WHERE `customer_id` = '" . (int)$customer_id . "' AND product_id = '" . (int)$product_id . "'";
			$result = $this->db->query($query);

			if ($result->row) {
				$query = "UPDATE " . DB_PREFIX . "emailtemplate_showcase_log SET `emailtemplate_showcase_log_count` = `emailtemplate_showcase_log_count` + 1, emailtemplate_showcase_log_modified = NOW() WHERE `customer_id` = '" . (int)$customer_id . "' AND product_id = '" . (int)$product_id . "'";
			} else {
				$query = "INSERT INTO " . DB_PREFIX . "emailtemplate_showcase_log (`customer_id`, `product_id`, emailtemplate_showcase_log_count, emailtemplate_showcase_log_modified) VALUES ('" . (int)$customer_id . "', '" . (int)$product_id . "', 1, NOW())";
			}

			$this->db->query($query);
		}

		return true;
	}

	/**
	 * Get Email Template Config
	 *
	 * @param int||array $identifier
	 * @return array
	 */
	public function getConfig($data = false) {
		$where = array();

		if (is_array($data)) {
			if (isset($data['store_id'])) {
				$where[] = "`store_id` = '". (int)$data['store_id'] ."'";
			}
			if (isset($data['language_id'])) {
				$where[] = "(`language_id` = '". (int)$data['language_id']."' OR `language_id` = 0)";
			}
		} elseif (is_numeric($data)) {
			$where[] = "`emailtemplate_config_id` = '" . (int)$data . "'";
		}

		$query = "SELECT * FROM " . DB_PREFIX . "emailtemplate_config";

		if (!empty($where)) {
			$query .= " WHERE " . implode(" AND ", $where);
		}

		$query .= " ORDER BY `language_id` DESC LIMIT 1";

		$result = $this->_fetch($query, 'config');

		if ($result) {
			$return = $result->row;

			foreach (EmailTemplateConfigDAO::describe() as $col => $type) {
				if (!isset($return[$col])) continue;

				if ($type == EmailTemplateConfigDAO::SERIALIZE && $return[$col]) {
					$unserialized = @unserialize(base64_decode($return[$col]));
					$return[$col] = ($unserialized !== false) ? $unserialized : $return[$col];
				}
			}

			return $return;
		}
	}

	/**
	 * Return array of configs
	 * @param array - $data
	 */
	public function getConfigs($data = array()) {
		$where = array();

		if (isset($data['language_id'])) {
			$where[] = "AND ec.`language_id` = '".(int)$data['language_id']."'";
		} elseif (isset($data['_language_id'])) {
			$where[] = "OR ec.`language_id` = '".(int)$data['_language_id']."'";
		}

		if (isset($data['store_id'])) {
			$where[] = "AND ec.`store_id` = '".(int)$data['store_id']."'";
		} elseif (isset($data['_store_id'])) {
			$where[] = "OR ec.`store_id` = '".(int)$data['_store_id']."'";
		}

		if (isset($data['customer_group_id'])) {
			$where[] = "AND ec.`customer_group_id` = '".(int)$data['customer_group_id']."'";
		} elseif (isset($data['_customer_group_id'])) {
			$where[] = "OR ec.`customer_group_id` = '".(int)$data['_customer_group_id']."'";
		}

		if (isset($data['emailtemplate_config_id'])) {
			if (is_array($data['emailtemplate_config_id'])) {
				$ids = array();
				foreach($data['emailtemplate_config_id'] as $id) { $ids[] = (int)$id; }
				$where[] = "AND ec.`emailtemplate_config_id` IN('".implode("', '", $ids)."')";
			} else {
				$where[] = "AND ec.`emailtemplate_config_id` = '".(int)$data['emailtemplate_config_id']."'";
			}
		}

		if (isset($data['not_emailtemplate_config_id'])) {
			if (is_array($data['not_emailtemplate_config_id'])) {
				$ids = array();
				foreach($data['not_emailtemplate_config_id'] as $id) { $ids[] = (int)$id; }
				$where[] = "AND ec.`emailtemplate_config_id` NOT IN('".implode("', '", $ids)."')";
			} else {
				$where[] = "AND ec.`emailtemplate_config_id` != '".(int)$data['not_emailtemplate_config_id']."'";
			}
		}

		$query = "SELECT ec.* FROM " . DB_PREFIX . "emailtemplate_config ec";
		if (!empty($where)) {
			$query .= ' WHERE ' . ltrim(implode(' ', $where), 'AND');
		}

		$sort_data = array(
			'ec.emailtemplate_config_id',
			'ec.emailtemplate_config_name',
			'ec.emailtemplate_config_modified',
			'ec.store_id',
			'ec.language_id',
			'ec.customer_group_id'
		);
		if (isset($data['sort']) && in_array($data['sort'], $sort_data)) {
			$query .= " ORDER BY `" . $data['sort'] . "`";
		} else {
			$query .= " ORDER BY ec.`emailtemplate_config_name`";
		}

		if (isset($data['order']) && ($data['order'] == 'DESC')) {
			$query .= " DESC";
		} else {
			$query .= " ASC";
		}

		if (isset($data['start']) || isset($data['limit'])) {
			if (!isset($data['start']) || $data['start'] < 0) {
				$data['start'] = 0;
			}
			if ($data['limit'] < 1) {
				$data['limit'] = 20;
			}
			$query .= " LIMIT " . (int)$data['start'] . "," . (int)$data['limit'];
		}

		$result = $this->_fetch($query, 'configs');

		$rows = $result->rows;

		if ($rows) {
			$cols = EmailTemplateConfigDAO::describe();

			foreach ($rows as $key => &$row) {
				foreach ($row as $col => $val) {
					if (isset($cols[$col]) && $cols[$col] == EmailTemplateConfigDAO::SERIALIZE) {
						if ($val) {
							$unserialized = @unserialize(base64_decode($row[$col]));
							$row[$col] = ($unserialized !== false) ? $unserialized : $row[$col];
						}
					}
				}
			}

			return $rows;
		}
	}

	/**
	 * Add new Email Template Config by cloning an existing one.
	 *
	 * @return new row identifier
	 */
	public function cloneConfig($id, $data = array()) {
		$id = (int)$id;
		$inserts = array();
		$cols = EmailTemplateConfigDAO::describe("emailtemplate_config_id", "emailtemplate_config_status", "store_id", "language_id", "customer_group_id");

		if (isset($data['store_id'])) {
			$store_id = (int)$data['store_id'];
		} else {
			$store_id = null;
		}

		if (isset($data['language_id'])) {
			$language_id = (int)$data['language_id'];
		} else {
			$language_id = 0;
		}

		if (isset($data['customer_group_id'])) {
			$customer_group_id = (int)$data['customer_group_id'];
		} else {
			$customer_group_id = 0;
		}

		$colsInsert = '';
		foreach($cols as $col => $type) {
			if (!array_key_exists($col, $data)) {
				$value = "`" . $this->db->escape($col) . "`";
			} else {
				switch ($type) {
					case EmailTemplateAbstract::INT:
						if (strtoupper($data[$col]) == 'NULL') {
							$value = 'NULL';
						} else {
							$value = (int)$data[$col];
						}
						break;
					case EmailTemplateAbstract::FLOAT:
						$value = floatval($data[$col]);
						break;
					case EmailTemplateAbstract::DATE_NOW:
						$value = 'NOW()';
						break;
					case EmailTemplateAbstract::SERIALIZE:
						$value = base64_encode(serialize($data[$col]));
						break;
					default:
						$value = $this->db->escape($data[$col]);
				}
				$value = "'{$value}'";
			}

			$colsInsert .= "{$value}, ";
		}

		$stmnt = "INSERT INTO " . DB_PREFIX . "emailtemplate_config (".implode(array_keys($cols),', ').", emailtemplate_config_status, store_id, language_id, customer_group_id)
                  SELECT ".$colsInsert." 0, '{$store_id}', '{$language_id}', '{$customer_group_id}' FROM " . DB_PREFIX . "emailtemplate_config WHERE emailtemplate_config_id = '". (int)$id . "'";
		$this->db->query($stmnt);

		$emailtemplate_config_id = $this->db->getLastId();

		/*$stmnt = "UPDATE " . DB_PREFIX . "emailtemplate_config SET emailtemplate_config_name = CONCAT(emailtemplate_config_name, ' - {$emailtemplate_config_id}') WHERE emailtemplate_config_id = '{$emailtemplate_config_id}'";
		$this->db->query($stmnt);*/

		$this->clear();

		return $emailtemplate_config_id;
	}

	/**
	 * Edit existing config
	 *
	 * @param int - emailtemplate.emailtemplate_id
	 * @param array - column => value
	 * @return int affected row count
	 */
	public function updateConfig($id, array $data) {
		if (empty($data) && !is_numeric($id)) return false;

		$cols = EmailTemplateConfigDAO::describe();
		$updates = $this->_build_query($cols, $data);
		if (!$updates) return false;

		$sql = "UPDATE " . DB_PREFIX . "emailtemplate_config SET ".implode($updates,", ") . " WHERE emailtemplate_config_id = '". (int)$id . "'";
		$this->db->query($sql);

		$affected = $this->db->countAffected();

		if ($affected > 0) {
			$this->clear();

			return $affected;
		}
		return false;
	}

	/**
	 * Restore config row
	 */
	public function restoreDefaultConfig() {
		$file = DIR_APPLICATION . 'model/extension/mail/template/install/install.config.sql';

		if (file_exists($file)) {
			$stmnts = $this->_parse_sql($file);

			if (isset($stmnts[2]) && substr($stmnts[2], 0, 11) == 'INSERT INTO') {
				$this->db->query($stmnts[2]);

				$this->load->model('setting/setting');

				$store_config = $this->model_setting_setting->getSetting("config", 0);

				$config_data = array(
					'emailtemplate_config_name' => $this->config->get('config_name'),
					'emailtemplate_config_version' => $this->model_extension_mail_template->getVersion(),
					'store_id' => 0
				);

				if (!empty($store_config['config_logo']) && file_exists(DIR_IMAGE . $store_config['config_logo'])) {
					$config_data['emailtemplate_config_logo'] = $store_config['config_logo'];

					list($config_data['emailtemplate_config_logo_width'], $config_data['emailtemplate_config_logo_height']) = getimagesize(DIR_IMAGE . $store_config['config_logo']);
				}

				$this->model_extension_mail_template->updateConfig(1, $config_data);

				return true;
			}
		}
	}

	/**
	 * Delete config row
	 *
	 * @param mixed array||int - emailtemplate.id
	 * @return int - row count effected
	 */
	public function deleteConfig($data) {
		$affected = 0;
		$ids = array();

		if (is_array($data)) {
			foreach($data as $item) {
				$ids[] = (int)$item;
			}
		} else {
			$ids[] = (int)$data;
		}

		if (count($ids)) {
			$queries = array();
			$queries[] = "DELETE FROM " . DB_PREFIX . "emailtemplate_config WHERE emailtemplate_config_id IN('".implode("', '", $ids)."')";
			if (array_search(1, $ids) === false) {
				$queries[] = "UPDATE " . DB_PREFIX . "emailtemplate SET emailtemplate_config_id = '' WHERE emailtemplate_config_id IN('".implode("', '", $ids)."')";
			}

			foreach($queries as $query) {
				$this->db->query($query);
				$affected += $this->db->countAffected();
			}

			$this->clear();

			if (array_search(1, $ids) !== false) {
				$this->restoreDefaultConfig();
			}
		}
		return $affected;
	}

	/**
	 * Get Template
	 * @param int $ident
	 * @param int $language_id
	 * @param int $keyCleanUp
	 * @return array
	 */
	public function getTemplate($ident, $language_id = null, $keyCleanUp = false) {
		$return = array();

		if (is_numeric($ident)) {
			$where = "`emailtemplate_id` = '" . (int)$ident . "'";
		} else {
			$where = "`emailtemplate_key` = '" . $this->db->escape($ident) . "' AND `emailtemplate_default` = 1";
		}

		$query = "SELECT * FROM " . DB_PREFIX . "emailtemplate WHERE " . $where . " LIMIT 1";
		$result = $this->_fetch($query, 'emailtemplate');

		if ($result->row) {
			$return = $result->row;

			$cols = EmailTemplateDAO::describe();

			foreach($cols as $col => $type) {
				if (!isset($return[$col])) continue;

				if ($type == EmailTemplateDAO::SERIALIZE && $return[$col]) {
					$unserialized = @unserialize(base64_decode($return[$col]));
					$return[$col] = ($unserialized !== false) ? $unserialized : $return[$col];
				}

				if ($keyCleanUp) {
					$key = (strpos($col, 'emailtemplate_') === 0 && substr($col, -3) != '_id') ? substr($col, 14) : $col;
					if (!isset($return[$key])) {
						$return[$key] = $return[$col];
						unset($return[$col]);
					}
				}
			}

			if ($language_id) {
				$result = $this->getTemplateDescription(array('emailtemplate_id' => $return['emailtemplate_id'], 'language_id' => $language_id), 1);

				if ($result) {
					$cols = EmailTemplateDescriptionDAO::describe();
					foreach($cols as $col => $type) {
						$key = $col;
						if ($keyCleanUp) {
							$key = (strpos($col, 'emailtemplate_description_') === 0 && substr($col, -3) != '_id') ? substr($col, 24) : $col;
						}

						if (!isset($return[$key])) {
							$return[$key] = $result[$col];
							unset($result[$col]);
						}
					}
				}
			}
		}

		return $return;
	}

	/**
	 * Get Template
	 * @param int $id
	 * @return array
	 */
	public function getTemplateDescription($data = array(), $limit = null) {
		$where = array();
		$query = "SELECT * FROM " . DB_PREFIX . "emailtemplate_description";

		if (isset($data['emailtemplate_id'])) {
			$where[] = "`emailtemplate_id` = '".(int)$data['emailtemplate_id']."'";
		} else {
			return array();
		}

		if (isset($data['language_id'])) {
			$where[] = "`language_id` = '".(int)$data['language_id']."'";
		}

		if (!empty($where)) {
			$query .= ' WHERE ' . implode(' AND ', $where);
		}
		if (is_numeric($limit)) {
			$query .= ' LIMIT ' . (int)$limit;
		}

		$result = $this->_fetch($query, 'emailtemplate_description');

		return ($limit == 1) ? $result->row : $result->rows;
	}

	/**
	 * Return array of templates
	 * @param array - $data
	 */
	public function getTemplates($data = array(), $keyCleanUp = false) {
		$where = array();

		if (isset($data['store_id'])) {
			if (is_numeric($data['store_id'])) {
				$where[] = "e.`store_id` = '".(int)$data['store_id']."'";
			} else {
				$where[] = "e.`store_id` IS NULL";
			}
		}

		if (isset($data['customer_group_id']) && $data['customer_group_id'] != 0) {
			$where[] = "e.`customer_group_id` = '".(int)$data['customer_group_id']."'";
		}

		if (isset($data['emailtemplate_key']) && $data['emailtemplate_key'] != "") {
			$where[] = "e.`emailtemplate_key` = '".$this->db->escape($data['emailtemplate_key'])."'";
		}

		if (isset($data['emailtemplate_type'])) {
			$where[] = "e.`emailtemplate_type` = '".$this->db->escape($data['emailtemplate_type'])."'";
		}

		if (isset($data['emailtemplate_status']) && $data['emailtemplate_status'] != "") {
			$where[] = "e.`emailtemplate_status` = '".$this->db->escape($data['emailtemplate_status'])."'";
		}

		if (isset($data['emailtemplate_default'])) {
			$where[] = "e.`emailtemplate_default` = '" . (int)$data['emailtemplate_default'] . "'";
		}

		if (isset($data['emailtemplate_id'])) {
			if (is_array($data['emailtemplate_id'])) {
				$ids = array();
				foreach($data['emailtemplate_id'] as $id) { $ids[] = (int)$id; }
				$where[] = "e.`emailtemplate_id` IN('".implode("', '", $ids)."')";
			} else {
				$where[] = "e.`emailtemplate_id` = '".(int)$data['emailtemplate_id']."'";
			}
		}

		if (isset($data['not_emailtemplate_id'])) {
			if (is_array($data['not_emailtemplate_id'])) {
				$ids = array();
				foreach($data['not_emailtemplate_id'] as $id) { $ids[] = (int)$id; }
				$where[] = "e.`emailtemplate_id` NOT IN('".implode("', '", $ids)."')";
			} else {
				$where[] = "e.`emailtemplate_id` != '".(int)$data['not_emailtemplate_id']."'";
			}
		}

		$query = "SELECT e.* FROM " . DB_PREFIX . "emailtemplate e";

		if (!empty($where)) {
			$query .= ' WHERE ' . implode(' AND ', $where);
		}

		$sort_data = array(
			'label' => 'e.`emailtemplate_label`',
			'key' => 'e.`emailtemplate_key`',
			'template' => 'e.`emailtemplate_template`',
			'modified' => 'e.`emailtemplate_modified`',
			'default' => 'e.`emailtemplate_default`',
			'shortcodes' => 'e.`emailtemplate_shortcodes`',
			'status' => 'e.`emailtemplate_status`',
			'id' => 'e.`emailtemplate_id`',
			'config' => 'e.`emailtemplate_config_id`',
			'store' => 'e.`store_id`',
			'customer' => 'e.`customer_group_id`',
			'language' => 'ed.`language_id`'
		);

		if (isset($data['sort']) && in_array($data['sort'], array_keys($sort_data))) {
			$query .= " ORDER BY " . $sort_data[$data['sort']];

			if (isset($data['order']) && ($data['order'] == 'DESC')) {
				$query .= " DESC";
			} else {
				$query .= " ASC";
			}
		} else {
			$query .= " ORDER BY e.`emailtemplate_modified` DESC, e.`emailtemplate_label` ASC";
		}

		if (isset($data['start']) || isset($data['limit'])) {
			if (!isset($data['start']) || $data['start'] < 0) {
				$data['start'] = 0;
			}
			if ($data['limit'] < 1) {
				$data['limit'] = 20;
			}
			$query .= " LIMIT " . (int)$data['start'] . "," . (int)$data['limit'];
		}

		$result = $this->_fetch($query, 'emailtemplates');
		if (empty($result->rows)) return array();

		$rows = $result->rows;

		$cols = EmailTemplateDAO::describe();

		foreach($rows as $key => &$row) {
			foreach($row as $col => $val) {
				if (isset($cols[$col]) && $cols[$col] == EmailTemplateDAO::SERIALIZE) {
					if ($val) {
						$unserialized = @unserialize(base64_decode($val));
						$val = ($unserialized !== false) ? $unserialized : $val;
					}
				}

				if ($keyCleanUp) {
					$key = (strpos($col, 'emailtemplate_') === 0 && substr($col, -3) != '_id') ? substr($col, 14) : $col;

					if (!array_key_exists($key, $row)) {
						$row[$key] = $val;
						unset($row[$col]);
					}
				}
			}
		}

		return $rows;
	}

	/**
	 * Get Template Log
	 * @param int $id
	 * @return array
	 */
	public function getTemplateLog($id) {
		$query = "SELECT * FROM " . DB_PREFIX . "emailtemplate_logs WHERE `emailtemplate_log_id` = '". (int)$id . "'";
		$result = $this->db->query($query);

		return $result->row;
	}

	/**
	 * Return array of logs
	 * @param array - $data
	 */
	public function getTemplateLogs($data = array(), $keyCleanUp = false) {
		$where = array();
		$query = "SELECT el.* FROM `" . DB_PREFIX . "emailtemplate_logs` el";

		if (isset($data['store_id']) && is_numeric($data['store_id'])) {
			if (is_numeric($data['store_id'])) {
				$where[] = "el.`store_id` = '".(int)$data['store_id']."'";
			}
		}

		if (isset($data['language_id']) && $data['language_id'] != 0) {
			$where[] = "el.`language_id` = '".(int)$data['language_id']."'";
		}

		if (isset($data['customer_id']) && $data['customer_id'] != 0) {
			$where[] = "(el.`customer_id` = '".(int)$data['customer_id']."' OR emailtemplate_log_to = (SELECT email FROM " . DB_PREFIX . "customer WHERE customer_id = '".(int)$data['customer_id']."' LIMIT 1))";
		}

		if (isset($data['emailtemplate_id']) && $data['emailtemplate_id'] != 0) {
			if (is_array($data['emailtemplate_id'])) {
				$ids = array();
				foreach($data['emailtemplate_id'] as $id) { $ids[] = (int)$id; }
				$where[] = "el.`emailtemplate_id` IN('".implode("', '", $ids)."')";
			} else {
				$where[] = "el.`emailtemplate_id` = '".(int)$data['emailtemplate_id']."'";
			}
		}

		if (isset($data['emailtemplate_config_id']) && $data['emailtemplate_config_id'] != 0) {
			if (is_array($data['emailtemplate_config_id'])) {
				$ids = array();
				foreach($data['emailtemplate_config_id'] as $id) { $ids[] = (int)$id; }
				$where[] = "el.`emailtemplate_config_id` IN('".implode("', '", $ids)."')";
			} else {
				$where[] = "el.`emailtemplate_config_id` = '".(int)$data['emailtemplate_config_id']."'";
			}
		}

		if (!empty($where)) {
			$query .= ' WHERE ' . implode(' AND ', $where);
		}

		$sort_data = array(
			'id' => 'el.`emailtemplate_log_id`',
			'template' => 'el.`emailtemplate_id`',
			'store_id' => 'el.`store_id`',
			'date' => 'el.`emailtemplate_log_sent`',
			'type' => 'el.`emailtemplate_log_type`',
			'to' => 'el.`emailtemplate_log_to`',
			'from' => 'el.`emailtemplate_log_from`',
			'sender' => 'el.`emailtemplate_log_sender`',
			'subject' => 'el.`emailtemplate_log_subject`'
		);
		if (isset($data['sort']) && in_array($data['sort'], array_keys($sort_data))) {
			$query .= " ORDER BY " . $sort_data[$data['sort']];
		} else {
			$query .= " ORDER BY el.`emailtemplate_log_sent`";
		}

		if (isset($data['order']) && ($data['order'] == 'DESC')) {
			$query .= " DESC";
		} else {
			$query .= " ASC";
		}

		if (isset($data['start']) || isset($data['limit'])) {
			if (!isset($data['start']) || $data['start'] < 0) {
				$data['start'] = 0;
			}
			if ($data['limit'] < 1) {
				$data['limit'] = 20;
			}
			$query .= " LIMIT " . (int)$data['start'] . "," . (int)$data['limit'];
		}

		$result = $this->db->query($query);

		if (empty($result->rows)) return array();

		foreach($result->rows as $i => $row) {
			foreach($row as $col => $val) {
				if ($keyCleanUp) {
					$key = (strpos($col, 'emailtemplate_log_') === 0 && substr($col, -3) != '_id') ? substr($col, 18) : $col;
					if (!isset($result->rows[$i][$key])) {
						unset($result->rows[$i][$col]);
						$result->rows[$i][$key] = $val;
					}
				}
			}
		}

		return $result->rows;
	}

	/**
	 * Return top logs
	 * @param array - $data
	 */
	public function getTotalTemplateLogs($data = array()) {
		$where = array();

		$where[] = "el.`emailtemplate_log_sent` IS NOT NULL";

		if (isset($data['store_id']) && is_numeric($data['store_id'])) {
			if (is_numeric($data['store_id'])) {
				$where[] = "el.`store_id` = '".(int)$data['store_id']."'";
			}
		}

		if (isset($data['language_id']) && $data['language_id'] != 0) {
			$where[] = "el.`language_id` = '".(int)$data['language_id']."'";
		}

		if (isset($data['customer_id']) && $data['customer_id'] != 0) {
			$where[] = "el.`customer_id` = '".(int)$data['customer_id']."'";
		}

		if (isset($data['emailtemplate_id']) && $data['emailtemplate_id'] != 0) {
			if (is_array($data['emailtemplate_id'])) {
				$ids = array();
				foreach($data['emailtemplate_id'] as $id) { $ids[] = (int)$id; }
				$where[] = "el.`emailtemplate_id` IN('".implode("', '", $ids)."')";
			} else {
				$where[] = "el.`emailtemplate_id` = '".(int)$data['emailtemplate_id']."'";
			}
		}

		$query = "SELECT COUNT(*) AS total FROM `" . DB_PREFIX . "emailtemplate_logs` el";
		if (!empty($where)) {
			$query .= ' WHERE ' . implode(' AND ', $where);
		}

		$result = $this->db->query($query);
		if (empty($result->row)) return array();

		return $result->row['total'];
	}

	/**
	 * Return last insert id for logs.
	 * @return int
	 */
	public function getLastTemplateLogId() {
		$query = "SELECT MAX(emailtemplate_log_id) as emailtemplate_log_id FROM `" . DB_PREFIX . "emailtemplate_logs`";
		$result = $this->db->query($query);

		return $result->row['emailtemplate_log_id'];
	}


	/**
	 * Return total template(s)
	 * @return int - total rows
	 */
	public function getTotalTemplates($data) {
		$where = array();

		if (isset($data['store_id'])) {
			if (is_numeric($data['store_id'])) {
				$where[] = "e.`store_id` = '".(int)$data['store_id']."'";
			} else {
				$where[] = "e.`store_id` IS NULL";
			}
		}

		if (isset($data['customer_group_id']) && $data['customer_group_id'] != 0) {
			$where[] = "e.`customer_group_id` = '".(int)$data['customer_group_id']."'";
		}

		if (isset($data['emailtemplate_key']) && $data['emailtemplate_key'] != "") {
			$where[] = "e.`emailtemplate_key` = '".$this->db->escape($data['emailtemplate_key'])."'";
		}

		if (isset($data['emailtemplate_type'])) {
			$where[] = "e.`emailtemplate_type` = '".$this->db->escape($data['emailtemplate_type'])."'";
		}

		if (isset($data['emailtemplate_status']) && $data['emailtemplate_status'] != "") {
			$where[] = "e.`emailtemplate_status` = '".$this->db->escape($data['emailtemplate_status'])."'";
		}

		if (isset($data['emailtemplate_default'])) {
			$where[] = "e.`emailtemplate_default` = '" . (int)$data['emailtemplate_default'] . "'";
		}

		if (isset($data['emailtemplate_id'])) {
			if (is_array($data['emailtemplate_id'])) {
				$ids = array();
				foreach($data['emailtemplate_id'] as $id) { $ids[] = (int)$id; }
				$where[] = "e.`emailtemplate_id` IN('".implode("', '", $ids)."')";
			} else {
				$where[] = "e.`emailtemplate_id` = '".(int)$data['emailtemplate_id']."'";
			}
		}

		if (isset($data['not_emailtemplate_id'])) {
			if (is_array($data['not_emailtemplate_id'])) {
				$ids = array();
				foreach($data['not_emailtemplate_id'] as $id) { $ids[] = (int)$id; }
				$where[] = "e.`emailtemplate_id` NOT IN('".implode("', '", $ids)."')";
			} else {
				$where[] = "e.`emailtemplate_id` != '".(int)$data['not_emailtemplate_id']."'";
			}
		}

		if (isset($data['emailtemplate_id'])) {
			if (is_array($data['emailtemplate_id'])) {
				$ids = array();
				foreach($data['emailtemplate_id'] as $id) { $ids[] = (int)$id; }
				$where[] = "e.`emailtemplate_id` IN('".implode("', '", $ids)."')";
			} else {
				$where[] = "e.`emailtemplate_id` = '".(int)$data['emailtemplate_id']."'";
			}
		}

		$query = "SELECT COUNT(*) AS total FROM " . DB_PREFIX . "emailtemplate e";
		if (!empty($where)) {
			$query .= ' WHERE ' . implode(' AND ', $where);
		}

		$result = $this->_fetch($query, 'emailtemplates_total');
		return $result->row['total'];
	}

	/**
	 * Add new template row
	 *
	 * @return new row identifier
	 */
	public function insertTemplate(array $data) {
		if (empty($data)) return false;

		$this->load->model('localisation/language');

		$cols = EmailTemplateDAO::describe('emailtemplate_id');

		$inserts = $this->_build_query($cols, $data);
		if (empty($inserts)) return false;

		$this->db->query("INSERT INTO " . DB_PREFIX . "emailtemplate SET ".implode($inserts,", "));

		$new_id = $this->db->getLastId();

		$languages = $this->model_localisation_language->getLanguages();

		$cols = EmailTemplateDescriptionDAO::describe('emailtemplate_description_id', 'emailtemplate_id', 'language_id');
		$descriptions = array();

		foreach($languages as $language) {
			$langId = $language['language_id'];

			if (!isset($descriptions[$langId])) {
				$descriptions[$langId] = array();
			}

			foreach($cols as $col => $type) {
				if (isset($data[$col][$langId])) {
					$descriptions[$langId][$col] = $data[$col][$langId];
				} else {
					$descriptions[$langId][$col] = '';
				}
			}
		}

		foreach($descriptions as $langId => $data) {
			$data['language_id'] = (int)$langId;
			$data['emailtemplate_id'] = $new_id;

			$this->insertTemplateDescription($data);
		}

		if (!empty($data['default_emailtemplate_id'])) {
			$data = $this->getTemplateShortcodes($data['default_emailtemplate_id']);
			$shortcodes = array();
			foreach($data as $row) {
				$shortcodes[$row['emailtemplate_shortcode_code']] = $row['emailtemplate_shortcode_example'];
			}
			$this->insertTemplateShortcodes($new_id, $shortcodes);
		}

		$this->clear();

		return $new_id;
	}

	/**
	 * Add new template description row
	 *
	 * @return new row identifier
	 */
	public function insertTemplateDescription(array $data) {
		if (empty($data)) return false;

		$cols = EmailTemplateDescriptionDAO::describe('emailtemplate_description_id');

		$inserts = $this->_build_query($cols, $data);
		if (empty($inserts)) return false;

		$sql = "INSERT INTO " . DB_PREFIX . "emailtemplate_description SET ".implode($inserts,", ");
		$this->db->query($sql);

		$new_id = $this->db->getLastId();

		$this->clear();

		return $new_id;
	}

	/**
	 * Insert Template Shortcodes(data)
	 */
	public function insertTemplateShortcodes($id, $data = array(), $language_data = array()) {
		if (isset($data['insert_shortcodes']) && !$data['insert_shortcodes']) return false;

		$this->db->query("DELETE FROM " . DB_PREFIX . "emailtemplate_shortcode WHERE `emailtemplate_id` = '". (int)$id . "'");

		$inserts = array();

		foreach($data as $key => $example) {
			if (in_array($key,  array('config', 'emailtemplate', 'showcase_selection')) || isset($language_data[$key]))
				continue;

			if (is_array($example)) {
				foreach($example as $example2 => $val) {
					if (is_string($val) || is_int($val)) {
						$inserts[$key . '.' . $example2] = "('" . (int)$id . "', 'auto', '" . $this->db->escape($key . '.' . $example2) . "', '" . $this->db->escape($val) . "')";
					} elseif (is_array($val)) {
						$inserts[$key] = "('" . (int)$id . "', 'auto_serialize', '" . $this->db->escape($key) . "', '" . $this->db->escape(base64_encode(serialize($example))) . "')";
						continue;
					}
				}
			} else {
				$inserts[$key] = "('" . (int)$id . "', 'auto', '" . $this->db->escape($key) . "', '" . $this->db->escape($example) . "')";
			}
		}

		if (is_array($language_data)) {
			foreach($language_data as $key => $example) {
				if (in_array($key,  array('config', 'emailtemplate', 'showcase_selection'))) continue;

				if (is_array($example)) {
					foreach($example as $example2 => $val) {
						if (is_string($val) || is_int($val)) {
							$inserts[$key . '.' . $example2] = "('" . (int)$id . "', 'language', '" . $this->db->escape($key . '.' . $example2) . "', '" . $this->db->escape($val) . "')";
						}
					}
				} else {
					$inserts[$key] = "('" . (int)$id . "', 'language', '" . $this->db->escape($key) . "', '" . $this->db->escape($example) . "')";
				}
			}
		}

		if ($inserts) {
			$insert_query = "INSERT INTO " . DB_PREFIX . "emailtemplate_shortcode (emailtemplate_id, emailtemplate_shortcode_type, emailtemplate_shortcode_code, emailtemplate_shortcode_example) VALUES " . implode($inserts, ', ');
			$this->db->query($insert_query);

		}

		$this->db->query("UPDATE " . DB_PREFIX . "emailtemplate SET `emailtemplate_shortcodes` = '1' WHERE `emailtemplate_id` = '". (int)$id . "'");

		$this->clear();
	}

	public function insertDefaultTemplateShortcodes($id) {
		$this->db->query("DELETE FROM " . DB_PREFIX . "emailtemplate_shortcode WHERE `emailtemplate_id` = '". (int)$id . "'");

		$result = $this->db->query("SELECT emailtemplate_key FROM " . DB_PREFIX . "emailtemplate WHERE `emailtemplate_id` = '". (int)$id . "' LIMIT 1");

		if ($result->row) {
			$file = DIR_APPLICATION . 'model/extension/mail/template/install/shortcode/' . $result->row['emailtemplate_key'] . '.sql';

			if (file_exists($file)) {
				$stmnts = $this->_parse_sql($file);

				foreach($stmnts as $stmnt) {
					$stmnt = str_replace('{_ID}', (int)$id, $stmnt);

					$this->db->query($stmnt);
				}
			}

			// Store Data
			$config_keys = array('title', 'name', 'url', 'owner', 'address', 'email', 'telephone', 'fax', 'country_id', 'zone_id', 'tax', 'tax_default', 'customer_price');

			$query = "INSERT INTO `" . DB_PREFIX . "emailtemplate_shortcode` (`emailtemplate_shortcode_code`, `emailtemplate_shortcode_type`, `emailtemplate_shortcode_example`, `emailtemplate_id`) VALUES ";

			foreach($config_keys as $i => $key) {
				$value = $this->config->get('config_'.$key);

				if($key == 'url' && !$value) {
					$value = HTTP_CATALOG;
				}

				$query .= ($i == 0 ? '' : ', ') . "('". $this->db->escape('store_'.$key) . "', 'auto', '". $this->db->escape($value) . "', " . (int)$id . ")";
			}

			$this->db->query($query);
		}

		$this->db->query("UPDATE " . DB_PREFIX . "emailtemplate SET `emailtemplate_shortcodes` = '1' WHERE `emailtemplate_id` = '". (int)$id . "'");

		$this->clear();
	}

	/**
	 * Edit existing template row
	 *
	 * @param int - emailtemplate.id
	 * @param array - column => value
	 * @return returns true if row was updated with new data
	 */
	public function updateTemplate($id, array $data)
	{
		$affected = 0;

		$cols = EmailTemplateDAO::describe('emailtemplate_id');

		$updates = $this->_build_query($cols, $data);

		if ($updates) {
			$sql = "UPDATE " . DB_PREFIX . "emailtemplate SET " . implode($updates, ", ") . " WHERE `emailtemplate_id` = '" . (int)$id . "'";
			$this->db->query($sql);

			$affected += $this->db->countAffected();
		}

		$cols = EmailTemplateDescriptionDAO::describe('emailtemplate_description', 'emailtemplate_id', 'language_id');
		$descriptions = array();

		foreach ($cols as $col => $type) {
			if (isset($data[$col]) && is_array($data[$col])) {
				foreach ($data[$col] as $langId => $val) {
					if (!isset($descriptions[$langId])) {
						$descriptions[$langId] = array();
					}
					$descriptions[$langId][$col] = $val;
				}
			}
		}

		foreach ($descriptions as $langId => $data) {
			$langId = (int)$langId;
			$updates = $this->_build_query($cols, $data);
			if (empty($updates)) continue;

			$result = $this->db->query("SELECT count(`emailtemplate_id`) AS total FROM " . DB_PREFIX . "emailtemplate_description WHERE `emailtemplate_id` = '" . (int)$id . "' AND `language_id` = '{$langId}'");
			if ($result->row['total'] == 0) {
				$query = "INSERT INTO " . DB_PREFIX . "emailtemplate_description SET `emailtemplate_id` = '" . (int)$id . "', `language_id` = '{$langId}', " . implode($updates, ", ");
			} else {
				$query = "UPDATE " . DB_PREFIX . "emailtemplate_description SET " . implode($updates, ", ") . " WHERE `emailtemplate_id` = '" . (int)$id . "' AND `language_id` = '{$langId}'";
			}
			$this->db->query($query);

			if ($affected == 0 && $this->db->countAffected()) {
				$this->db->query("UPDATE " . DB_PREFIX . "emailtemplate SET `emailtemplate_modified` = NOW() WHERE `emailtemplate_id` = '" . (int)$id . "'");
			}
			$affected += $this->db->countAffected();
		}

		if ($affected > 0) {
			$this->clear();

			return $affected;
		}
		return false;
	}

	public function updateTemplatesStatus(array $selected, $status = false) {
		$affected = 0;

		if ($selected) {
			if ($status) {
				$status = 1;
			} else {
				$status = 0;
			}

			foreach($selected as $id){
				$sql = "UPDATE " . DB_PREFIX . "emailtemplate SET emailtemplate_status = '{$status}' WHERE `emailtemplate_id` = '". (int)$id . "'";

				$this->db->query($sql);

				$affected += $this->db->countAffected();
			}
		}

		if ($affected > 0) {
			$this->clear();

			return $affected;
		}
		return false;
	}

	/**
	 * Delete template row
	 *
	 * @param mixed array||int - emailtemplate.id
	 * @return int - row count effected
	 */
	public function deleteTemplate($data) {
		$ids = array();
		if (is_array($data)) {
			foreach($data as $var) {
				$ids[] = (int)$var;
			}
		} else {
			$ids[] = (int)$data;
		}

		if (($key = array_search(1, $ids)) !== false) {
			unset($ids[$key]);
		}

		foreach($ids as $id) {
			$sql = "SELECT emailtemplate_id FROM " . DB_PREFIX . "emailtemplate WHERE emailtemplate_key = (SELECT emailtemplate_key FROM " . DB_PREFIX . "emailtemplate WHERE emailtemplate_id = '". (int)$id . "' AND emailtemplate_default = 1) AND emailtemplate_id != '". (int)$id . "'";
			$result = $this->db->query($sql);
			foreach($result->rows as $row) {
				$ids[] = $row['emailtemplate_id'];
			}
		}

		$queries = array();
		$queries[] = "DELETE FROM `" . DB_PREFIX . "emailtemplate_description` WHERE `emailtemplate_id` IN('".implode("', '", $ids)."')";
		$queries[] = "DELETE FROM `" . DB_PREFIX . "emailtemplate_shortcode` WHERE `emailtemplate_id` IN('".implode("', '", $ids)."')";
		$queries[] = "DELETE FROM " . DB_PREFIX . "emailtemplate WHERE `emailtemplate_id` IN('".implode("', '", $ids)."')";

		foreach($queries as $query) {
			$this->db->query($query);
		}

		$affected = $this->db->countAffected();

		if ($affected > 0) {
			$this->clear();

			return $affected;
		}
		return false;
	}

	/**
	 * Delete template row
	 *
	 * @param mixed array||int - emailtemplate.id
	 * @return int - row count effected
	 */
	public function deleteLogs($data) {
		if (empty($data)) return false;

		$ids = array();
		if (is_array($data)) {
			foreach($data as $var) {
				$ids[] = (int)$var;
			}
		} else {
			$ids[] = (int)$data;
		}

		$query = "DELETE FROM `" . DB_PREFIX . "emailtemplate_logs` WHERE `emailtemplate_log_id` IN('".implode("', '", $ids)."')";

		$this->db->query($query);

		$affected = $this->db->countAffected();

		return $affected;
	}

	/**
	 * Delete template row
	 *
	 * @param mixed array
	 * @return int - row count effected
	 */
	public function deleteTemplateDescription($data) {
		$where = array();
		if (isset($data['language_id'])) {
			$where[] = "`language_id` = '" . (int)$data['language_id'] . "'";
		}

		$query = "DELETE FROM `" . DB_PREFIX . "emailtemplate_description` WHERE ".implode("', '", $where);
		$this->db->query($query);

		$affected = $this->db->countAffected();

		if ($affected > 0) {
			$this->clear();

			return $affected;
		}
		return false;
	}

	/**
	 * Get template keys enum types
	 */
	public function getTemplateKeys() {
		$return = array();
		$query = "SELECT `emailtemplate_key`, count(`emailtemplate_id`) AS `total`
					FROM " . DB_PREFIX . "emailtemplate
				   WHERE `emailtemplate_default` = 1 AND `emailtemplate_key` != ''
				GROUP BY `emailtemplate_key`
				ORDER BY `emailtemplate_key` ASC";
		$result = $this->db->query($query);

		foreach($result->rows as $row) {
			$return[] = array(
				'value' => $row['emailtemplate_key'],
				'label' => $row['emailtemplate_key'] . ($row['total'] > 1 ? (' ('.$row['total'].')') : '')
			);
		}

		return $return;
	}

	/**
	 * Get template types
	 */
	public function getTemplateTypes() {
		$return = array();
		$query = "SELECT `emailtemplate_type`
					FROM " . DB_PREFIX . "emailtemplate
				   WHERE `emailtemplate_default` = 1 AND `emailtemplate_type` != ''
				GROUP BY `emailtemplate_type`
				ORDER BY `emailtemplate_type` ASC";
		$result = $this->db->query($query);

		foreach($result->rows as $row) {
			$return[] = $row['emailtemplate_type'];
		}

		return $return;
	}

	/**
	 * Get template shortcodes
	 */
	public function getTemplateShortcodes($data, $keyCleanUp = false) {
		$where = array();

		if (is_array($data)) {
			if (isset($data['emailtemplate_shortcode_id']) && $data['emailtemplate_shortcode_id'] != 0) {
				$where[] = "es.`emailtemplate_shortcode_id` = '".(int)$data['emailtemplate_shortcode_id']."'";
			}

			if (isset($data['emailtemplate_id']) && $data['emailtemplate_id'] != 0) {
				$where[] = "es.`emailtemplate_id` = '".(int)$data['emailtemplate_id']."'";
			}

			if (!empty($data['emailtemplate_shortcode_type'])) {
				$where[] = "es.`emailtemplate_shortcode_type` = '".$this->db->escape($data['emailtemplate_shortcode_type'])."'";
			}

			if (isset($data['emailtemplate_key'])) {
				$result = $this->db->query("SELECT emailtemplate_id FROM " . DB_PREFIX . "emailtemplate WHERE emailtemplate_key = '".$this->db->escape($data['emailtemplate_key'])."' AND emailtemplate_default = 1 LIMIT 1");
				$where[] = "es.`emailtemplate_id` = '".(int)$result->row['emailtemplate_id']."'";
			}
		} else {
			$where[] = "es.`emailtemplate_id` = '".(int)$data."'";
		}

		$query = "SELECT es.* FROM `" . DB_PREFIX . "emailtemplate_shortcode` es";
		if (!empty($where)) {
			$query .= ' WHERE ' . implode(' AND ', $where);
		}

		$sort_data = array(
			'id' => 'es.`emailtemplate_shortcode_id`',
			'emailtemplate_id' => 'es.`emailtemplate_id`',
			'code' => 'es.`emailtemplate_shortcode_code`',
			'example' => 'es.`emailtemplate_shortcode_example`',
			'type' => 'es.`emailtemplate_shortcode_type`'
		);
		if (isset($data['sort']) && in_array($data['sort'], array_keys($sort_data))) {
			$query .= " ORDER BY " . $sort_data[$data['sort']];
		} else {
			$query .= " ORDER BY es.`emailtemplate_shortcode_code`";
		}

		if (isset($data['order']) && ($data['order'] == 'DESC')) {
			$query .= " DESC";
		} else {
			$query .= " ASC";
		}

		if (is_array($data) && (isset($data['start']) || isset($data['limit']))) {
			if (!isset($data['start']) || $data['start'] < 0) {
				$data['start'] = 0;
			}
			if ($data['limit'] < 1) {
				$data['limit'] = 20;
			}
			$query .= " LIMIT " . (int)$data['start'] . "," . (int)$data['limit'];
		}

		$result = $this->_fetch($query, 'emailtemplate_shortcodes');
		$cols = EmailTemplateShortCodesDAO::describe();

		foreach($result->rows as $key => &$row) {
			if ($row['emailtemplate_shortcode_type'] == 'auto_serialize' && $row['emailtemplate_shortcode_example']) {
				$unserialized = @unserialize(base64_decode($row['emailtemplate_shortcode_example']));
				$row['emailtemplate_shortcode_example'] = ($unserialized !== false) ? $unserialized : $row['emailtemplate_shortcode_example'];
			}

			if ($keyCleanUp) {
				foreach($cols as $col => $type) {
					$key = (strpos($col, 'emailtemplate_shortcode_') === 0 && substr($col, -3) != '_id') ? substr($col, 24) : $col;
					if (!isset($row[$key])) {
						$row[$key] = $row[$col];
						unset($row[$col]);
					}
				}
			}
		}

		return $result->rows;
	}

	/**
	 * Get template shortcodes
	 * @param array - $data
	 */
	public function getTotalTemplateShortcodes($data = array()) {
		$where = array();

		if (is_array($data)) {
			if (isset($data['emailtemplate_shortcode_id']) && $data['emailtemplate_shortcode_id'] != 0) {
				$where[] = "es.`emailtemplate_shortcode_id` = '".(int)$data['emailtemplate_shortcode_id']."'";
			}

			if (isset($data['emailtemplate_id']) && $data['emailtemplate_id'] != 0) {
				$where[] = "es.`emailtemplate_id` = '".(int)$data['emailtemplate_id']."'";
			}

			if (!empty($data['emailtemplate_shortcode_type'])) {
				$where[] = "es.`emailtemplate_shortcode_type` = '".$this->db->escape($data['emailtemplate_shortcode_type'])."'";
			}

			if (isset($data['emailtemplate_key'])) {
				$result = $this->db->query("SELECT emailtemplate_id FROM " . DB_PREFIX . "emailtemplate WHERE emailtemplate_key = '".$this->db->escape($data['emailtemplate_key'])."' AND emailtemplate_default = 1 LIMIT 1");
				$where[] = "es.`emailtemplate_id` = '".(int)$result->row['emailtemplate_id']."'";
			}
		} else {
			$where[] = "es.`emailtemplate_id` = '".(int)$data."'";
		}

		$query = "SELECT COUNT(*) AS total FROM `" . DB_PREFIX . "emailtemplate_shortcode` es";
		if (!empty($where)) {
			$query .= ' WHERE ' . implode(' AND ', $where);
		}

		$result = $this->db->query($query);
		if (empty($result->row)) return array();

		return $result->row['total'];
	}

	/**
	 * Get template for restore
	 * @param array - $data
	 */
	public function getTemplatesRestore() {
		$query = "SELECT GROUP_CONCAT(emailtemplate_key SEPARATOR ', ') AS `keys` FROM " . DB_PREFIX . "emailtemplate WHERE emailtemplate_default = 1 AND emailtemplate_id !=1";
		$result = $this->db->query($query);

		if ($result->row) {
			$keys = explode(', ', $result->row['keys']);

			return array_diff($this->original_templates, $keys);
		}
	}

	/**
	 * Edit shortcode
	 *
	 * @param int - emailtemplate_shortcode.emailtemplate_shortcode_id
	 * @param array - column => value
	 * @return int affected row count
	 */
	public function updateTemplateShortcode($id, array $data) {
		if (empty($data) && !is_numeric($id)) return false;
		$cols = EmailTemplateShortCodesDAO::describe();

		$updates = $this->_build_query($cols, $data);
		if (!$updates) return false;

		$sql = "UPDATE " . DB_PREFIX . "emailtemplate_shortcode SET ".implode($updates,", ") . " WHERE emailtemplate_shortcode_id = '". (int)$id . "'";
		$this->db->query($sql);

		$affected = $this->db->countAffected();

		if ($affected > 0) {
			$this->clear();

			return $affected;
		}
		return false;
	}

	/**
	 * Delete template shortcode(s)
	 * Detech if template is custom and deletes shortcodes for custom templates
	 * @todo admin on load custom template populate from default template if empty
	 *
	 * @param int template_id
	 * @param array selected emailtemplate_shortcode_id - if empty deletes all
	 * @return int - row count effected
	 */
	public function deleteTemplateShortcodes($id, $data = array()) {
		$where = array();
		$where[] = "`emailtemplate_id` = '". (int)$id . "'";

		if (isset($data['emailtemplate_shortcode_id'])) {
			if (is_array($data['emailtemplate_shortcode_id'])) {
				$ids = array();
				foreach($data['emailtemplate_shortcode_id'] as $emailtemplate_shortcode_id) {
					$ids[] = (int)$emailtemplate_shortcode_id;
				}
				$where[] = "`emailtemplate_shortcode_id` IN(". implode(', ', $ids) .")";
			} else {
				$where[] = "`emailtemplate_shortcode_id` = '". (int)$data['emailtemplate_shortcode_id'] . "'";
			}
		}

		if ($where) {
			$this->db->query("DELETE FROM `" . DB_PREFIX . "emailtemplate_shortcode` WHERE ".implode(" AND ", $where));
			$affected = $this->db->countAffected();

			$result = $this->db->query("SELECT 1 FROM `" . DB_PREFIX . "emailtemplate_shortcode` WHERE emailtemplate_id = '". (int)$id . "' LIMIT 1");

			if ($result->num_rows == 0) {
				$this->db->query("UPDATE " . DB_PREFIX . "emailtemplate SET `emailtemplate_shortcodes` = 0 WHERE `emailtemplate_id` = ".$id);
			}

			if ($affected > 0) {
				$this->clear();

				return $affected;
			}
		}
	}

	public function install(){
		$this->load->language('extension/mail/template');

		//$this->load->model('extension/mail/template');

		$files = array('install.sql', 'install.config.sql');

		foreach($files as $filename) {
			$file = DIR_APPLICATION . 'model/extension/mail/template/install/' . $filename;

			if (file_exists($file)) {
				$stmnts = $this->_parse_sql($file);

				foreach($stmnts as $stmnt) {
					$this->db->query($stmnt);
				}
			}
		}

		$this->db->query("UPDATE `" . DB_PREFIX . "emailtemplate_description` SET language_id  = '".(int)$this->config->get('config_language_id')."' WHERE emailtemplate_id = 1");

		// Increase `modification` length
		$this->db->query("ALTER TABLE `" . DB_PREFIX . "modification` CHANGE `xml` `xml` MEDIUMTEXT NOT NULL");

		// Add language_id to `customers`
		$chk = $this->db->query("SHOW COLUMNS FROM `" . DB_PREFIX . "customer` LIKE 'language_id'");
		if (!$chk->num_rows) {
			$this->db->query("ALTER TABLE `" . DB_PREFIX . "customer` ADD `language_id` int(11) NOT NULL DEFAULT '0' AFTER `store_id`");
		}

		// Add weight to `orders`
		$chk = $this->db->query("SHOW COLUMNS FROM `" . DB_PREFIX . "order` LIKE 'weight'");
		if (!$chk->num_rows) {
			$this->db->query("ALTER TABLE `" . DB_PREFIX . "order` ADD `weight` decimal(15,8) NOT NULL DEFAULT '0.00000000' AFTER `invoice_prefix`");
		}

		$this->clear();
	}

	/**
	 * Insert Template from SQL file
	 *
	 * @param string $key
	 * @return int template_id
	 */
	public function installTemplate($key) {
		$emailtemplate_id = false;

		// Load Config
		$config = $this->getConfig(1);

		// Template
		$file = DIR_APPLICATION . 'model/extension/mail/template/install/template/' . $key . '.sql';

		if (!file_exists($file)) {
			trigger_error('Error: Could not template ' .  $file . '!');
			exit();
		}

		foreach($this->_parse_sql($file) as $i => $stmnt) {
			if ($emailtemplate_id) {
				$stmnt = str_replace('{_ID}', (int)$emailtemplate_id, $stmnt);
			}

			$this->db->query($stmnt);

			if ($i == 0) {
				$emailtemplate_id = $this->db->getLastId();
			}
		}

		$emailtemplate = $this->getTemplate($emailtemplate_id);

		if(!$emailtemplate) return false;

		// Template Descriptions
		$this->load->model('localisation/language');

		$languages = $this->model_localisation_language->getLanguages();

		$emailtemplates_description = $this->getTemplateDescription(array('emailtemplate_id' => $emailtemplate_id), 1);

		$replace_language_vars = defined('REPLACE_LANGUAGE_VARIABLES') ? REPLACE_LANGUAGE_VARIABLES : true;

		foreach ($languages as $language) {
			$data = $emailtemplates_description;

			if ($replace_language_vars) {
				$oLanguage = new Language($language['code']);

				if (substr($emailtemplate['emailtemplate_key'], 0, 6) != 'admin.' && defined('DIR_CATALOG')) {
					$oLanguage->setPath(DIR_CATALOG.'language/');
				}

				$oLanguage->load($language['code']);

				$langData = array();

				foreach(explode(',', $emailtemplate['emailtemplate_language_files']) as $language_file) {
					if ($language_file) {
						$_langData = $oLanguage->load(trim($language_file));
						if ($_langData) {
							$langData = array_merge($langData, $_langData);
						}
					}
				}

				$find = array();
				$replace = array();

				foreach($langData as $i => $val) {
					if ((is_string($val) && (strpos($val, '%s') === false) || is_int($val))) {
						$find[$i] = '{$'.$i.'}';
						$replace[$i] = $val;
					}
				}

				foreach($data as $col => $val) {
					if ($val && is_string($val)) {
						$data[$col] = str_replace($find, $replace, $val);
					}
				}
			}

			$data['language_id'] = $language['language_id'];

			$data['emailtemplate_id'] = $emailtemplate_id;

			$this->insertTemplateDescription($data);
		}

		$this->deleteTemplateDescription(array('language_id' => 0, 'emailtemplate_id' => $emailtemplate_id));

		$file = DIR_APPLICATION . 'model/extension/mail/template/install/shortcode/' . $key . '.sql';

		if (file_exists($file)) {
			foreach($this->_parse_sql($file) as $stmnt) {
				$stmnt = str_replace('{_ID}', (int)$emailtemplate_id, $stmnt);

				$this->db->query($stmnt);
			}

			$this->db->query("UPDATE " . DB_PREFIX . "emailtemplate SET emailtemplate_shortcodes = 1 WHERE emailtemplate_id = '".(int)$emailtemplate_id."'");
		}

		$this->clear();

		return $emailtemplate_id;
	}

	/**
	 * Apply upgrade queries
	 */
	public function upgrade() {
		if ($this->checkVersion() === false) return false;

		$result = $this->db->query("SELECT emailtemplate_config_version FROM " . DB_PREFIX . "emailtemplate_config LIMIT 1");
		$current_ver = $result->row['emailtemplate_config_version'];

		$dir = DIR_APPLICATION.'model/extension/mail/template/upgrade/';

		$upgrades = glob($dir.'*.sql');
		natsort($upgrades);

		foreach($upgrades as $i => $file) {
			$ver = substr(substr($file, 0, -4), strlen($dir));

			if (version_compare($current_ver, $ver) >= 0){
				continue;
			}

			$stmnts = $this->_parse_sql($file);
			foreach($stmnts as $stmnt) {
				$this->db->query($stmnt);
			}
		}

		$this->db->query("UPDATE " . DB_PREFIX . "emailtemplate_config SET emailtemplate_config_version = '".$this->db->escape($this->getVersion())."'");

		$this->updateModification('core');

		$this->updateModification();

		$this->clear();

		// Events
		/*$this->load->model('extension/event');

		if ($this->model_extension_event) {
			$this->model_extension_event->deleteEvent('emailtemplate');

			$this->model_extension_event->addEvent('emailtemplate', 'catalog/model/account/return/addReturn/after', 'extension/mail/template/send_return_mail');
		}*/

		return true;
	}

	/**
	 * Method handles removing table
	 */
	public function uninstall() {
		$queries = array();
		$queries[] = "DROP TABLE IF EXISTS " . DB_PREFIX . "emailtemplate";
		$queries[] = "DROP TABLE IF EXISTS " . DB_PREFIX . "emailtemplate_config";
		$queries[] = "DROP TABLE IF EXISTS `" . DB_PREFIX . "emailtemplate_description`";
		$queries[] = "DROP TABLE IF EXISTS `" . DB_PREFIX . "emailtemplate_logs`";
		$queries[] = "DROP TABLE IF EXISTS `" . DB_PREFIX . "emailtemplate_shortcode`";

		foreach($queries as $query) {
			$this->db->query($query);
		}

		$this->load->model('extension/modification');

		// Modification Templates
		$modification_info = $this->model_extension_modification->getModificationByCode('emailtemplates');

		if ($modification_info) {
			$this->model_extension_modification->deleteModification($modification_info['modification_id']);
		}

		// Modification Core
		$modification_info = $this->model_extension_modification->getModificationByCode('emailtemplates_core');

		if ($modification_info) {
			$this->model_extension_modification->deleteModification($modification_info['modification_id']);
		}

		$this->clear();

		// Events
		$this->load->model('extension/event');

		if ($this->model_extension_event) {
			$this->model_extension_event->deleteEvent('emailtemplate');
		}

		return true;
	}

	/**
	 * Create Log
	 */
	public function createTemplateLog() {
		$query = "INSERT INTO " . DB_PREFIX . "emailtemplate_logs (`emailtemplate_log_id`, `emailtemplate_log_added`, `emailtemplate_log_status`) VALUES (NULL, NOW(), 0)";

		$this->db->query($query);

		$this->clear();

		return $this->db->getLastId();
	}

	/**
	 * Clear Template Log
	 */
	public function clearTemplateLogs() {
		$query = "DELETE FROM " . DB_PREFIX . "emailtemplate_logs WHERE emailtemplate_log_to = '' OR (emailtemplate_log_sent = NULL AND DATEDIFF(NOW(), emailtemplate_log_added) > 60)";

		$this->db->query($query);
	}

	public function updateTemplateLog($emailtemplate_log_id, $data) {
		$query = "UPDATE " . DB_PREFIX . "emailtemplate_logs SET `emailtemplate_log_sent` = " . ($data['emailtemplate_log_is_sent'] ? 'NOW()' : 'NULL') . ", emailtemplate_log_type = 'SYSTEM', `emailtemplate_log_status` = 1, emailtemplate_log_enc = '" . $this->db->escape($data['emailtemplate_log_enc']) . "', emailtemplate_log_to = '" . $this->db->escape($data['emailtemplate_log_to']) . "', emailtemplate_log_from = '" . $this->db->escape($data['emailtemplate_log_from']) . "', emailtemplate_log_sender = '" . $this->db->escape($data['emailtemplate_log_sender']) . "', emailtemplate_log_cc = '" . $this->db->escape($data['emailtemplate_log_cc']) . "', emailtemplate_log_bcc = '" . $this->db->escape($data['emailtemplate_log_bcc']) . "', emailtemplate_log_attachment = '" . $this->db->escape($data['emailtemplate_log_attachment']) . "', emailtemplate_log_subject = '" . $this->db->escape($data['emailtemplate_log_subject']) . "', emailtemplate_log_text = '" . $this->db->escape($data['emailtemplate_log_text']) . "', emailtemplate_log_content = '" . $this->db->escape($data['emailtemplate_log_content']) . "', emailtemplate_log_is_sent = '" . (int)$data['emailtemplate_log_is_sent'] . "', store_id = '" . (int)$data['store_id'] . "', language_id = '" . (int)$data['language_id'] . "', customer_id = '" . (int)$data['customer_id'] . "', emailtemplate_id = '" . (int)$data['emailtemplate_id'] . "', emailtemplate_config_id = '" . (int)$data['emailtemplate_config_id'] . "' WHERE emailtemplate_log_id = " . (int)$emailtemplate_log_id;

		$this->db->query($query);
	}

	/**
	 * Get template files
	 *
	 * @return array
	 */
	public function getTemplateFiles($theme) {
		$return = array(
			'catalog' => array(),
			'catalog_default' => array(),
			'admin' => array(),
			'dirs' => array()
		);

		$base = substr(DIR_SYSTEM, 0, -7);
		$dir = 'catalog/view/theme/' . $theme . '/template/extension/mail/';
		$return['dirs']['catalog'] = $dir;
		$files = glob($base.$dir.'*.tpl');
		if ($files) {
			foreach($files as $file) {
				$filename = basename($file);
				if ($filename[0] == '_') continue;
				$return['catalog'][] = $filename;
			}
		}

		if ($theme != "default") {
			$dir = 'catalog/view/theme/default/extension/mail/';
			$return['dirs']['catalog_default'] = $dir;
			$files = glob($base.$dir.'*.tpl');
			if ($files) {
				foreach($files as $file) {
					$filename = basename($file);
					if ($filename[0] == '_') continue;
					$return['catalog_default'][] = $filename;
				}
			}
		}

		$dir = str_replace($base, '', DIR_TEMPLATE) .'extension/mail/';
		$return['dirs']['admin'] = $dir;
		$files = glob($base.$dir.'*.tpl');
		if ($files) {
			foreach($files as $file) {
				$filename = basename($file);
				if ($filename[0] == '_') continue;
				$return['admin'][] = $filename;
			}
		}

		return $return;
	}

	/**
	 * Check version of files with databse
	 */
	public function checkVersion() {
		$result = $this->db->query("SELECT `emailtemplate_config_version` FROM " . DB_PREFIX . "emailtemplate_config WHERE `emailtemplate_config_id` = 1 LIMIT 1");

		if ($result->row && version_compare($this->version, $result->row['emailtemplate_config_version']) > 0) {
			return $result->row['emailtemplate_config_version'];
		}

		return false;
	}

	/**
	 * Get all stores
	 */
	public function getStores() {
		$stores = array();

		$stores[] = array(
			'store_id' => 0,
			'name' => $this->config->get('config_name'),
			'url' => HTTP_CATALOG,
			'ssl' => HTTPS_CATALOG
		);

		$this->load->model('setting/store');

		$result = $this->model_setting_store->getStores();

		if ($result) {
			foreach ($result as $row) {
				$stores[] = array(
					'store_id' => $row['store_id'],
					'name' => $row['name'],
					'url' => $row['url'],
					'ssl' => $row['ssl']
				);
			}
		}

		return $stores;
	}

	public function getUrl($route, $key, $value) {
		$url = "index.php?route=" . rawurlencode($route) . "&" . rawurlencode($key) . "=" . rawurlencode($value);

		if ($this->config->get('config_seo_url')) {
			$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "url_alias WHERE `query` = '" . $this->db->escape($key . '=' . (int)$value) . "'");
			if (!empty($query->row['keyword'])) {
				$url = $query->row['keyword'];
			}
		}

		return $url;
	}

	/**
	 * Update modification
	 */
	public function updateModification($name = '') {
		$this->load->model('extension/modification');

		switch(strtolower($name)){
			case 'core':
				$file = DIR_APPLICATION . 'model/extension/mail/template/install/install.xml';

				if (!file_exists($file)) {
					trigger_error('Missing install file: ' . $file);
					exit;
				}

				$modification_data = array(
					'name' => "Email Templates Core",
					'code' => "emailtemplates_core",
					'author' => "opencart-templates",
					'version' => $this->version,
					'link' => "http://www.opencart-templates.co.uk/advanced_professional_email_template",
					'xml' => file_get_contents($file),
					'status' => 1
				);

				$modification_info = $this->model_extension_modification->getModificationByCode("emailtemplates_core");

				if ($modification_info) {
					$this->model_extension_modification->deleteModification($modification_info['modification_id']);
				}

				if(!empty($modification_data)){
					$this->model_extension_modification->addModification($modification_data);
				}

				break;

			default:
				$query = $this->db->query("SELECT emailtemplate_key FROM ".DB_PREFIX."emailtemplate WHERE `emailtemplate_default` = 1 AND `emailtemplate_status` = 1");

				if($query->rows){
					$modification_data = array(
						'name' => "Email Templates",
						'code' => "emailtemplates",
						'author' => "opencart-templates",
						'version' => $this->version,
						'link' => "http://www.opencart-templates.co.uk/advanced_professional_email_template",
						'status' => 1
					);

					$modification_data['xml'] = "<modification>
	<name>". $modification_data['name'] . "</name>
	<code>". $modification_data['code'] . "</code>
	<author>". $modification_data['author'] . "</author>
	<version>". $modification_data['version'] . "</version>
	<link>". $modification_data['link'] . "</link>";

					foreach($query->rows as $row) {
						$file = DIR_APPLICATION . 'model/extension/mail/template/install/modification/'. $row['emailtemplate_key'] . '.xml';
						if (file_exists($file)) {
							$modification_data['xml'] .= "
	".file_get_contents($file);
						}
					}

					$modification_data['xml'] .= "
</modification>";
				}

				$modification_info = $this->model_extension_modification->getModificationByCode("emailtemplates");

				if ($modification_info) {
					$this->model_extension_modification->deleteModification($modification_info['modification_id']);
				}

				if(!empty($modification_data)){
					$this->model_extension_modification->addModification($modification_data);
				}
				break;
		}

		$this->clear();
	}

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
	 * Method builds mysql for INSERT/UPDATE
	 *
	 * @param array $cols
	 * @param array $data
	 * @return array
	 */
	private function _build_query($cols, $data, $withoutCols = false) {
		if (empty($data)) return $data;
		$return = array();

		foreach ($cols as $col => $type) {
			if (!array_key_exists($col, $data)) continue;

			switch ($type) {
				case EmailTemplateAbstract::INT:
					if (strtoupper($data[$col]) == 'NULL') {
						$value = 'NULL';
					} else {
						$value = (int)$data[$col];
					}
					break;
				case EmailTemplateAbstract::FLOAT:
					$value = floatval($data[$col]);
					break;
				case EmailTemplateAbstract::DATE_NOW:
					$value = 'NOW()';
					break;
				case EmailTemplateAbstract::SERIALIZE:
					$value = "'".base64_encode(serialize($data[$col]))."'";
					break;
				default:
					if (!is_string($data[$col])) {
						trigger_error('Unable to escape, must be string: ' . $col);
						exit;
					}
					$value = "'".$this->db->escape($data[$col])."'";
			}

			if ($withoutCols) {
				$return[] = "'{$value}'";
			} else {
				$return[] = " `".$this->db->escape($col)."` = {$value}";
			}
		}

		return empty($return) ? false : $return;
	}

	/**
	 * Parse SQL file and split into single sql statements.
	 *
	 * @param string $sql - file path
	 * @return array
	 */
	private function _parse_sql($file) {
		$sql = @fread(@fopen($file, 'r'), @filesize($file)) or die('problem reading sql:'.$file);
		$sql = str_replace(" `oc_db_name` ", " `" . DB_DATABASE, $sql);
		$sql = str_replace(" `oc_", " `" . DB_PREFIX, $sql);

		$lines = explode("\n", $sql);
		$linecount = count($lines);
		$sql = "";
		for ($i = 0; $i < $linecount; $i++) {
			if (($i != ($linecount - 1)) || (strlen($lines[$i]) > 0)) {
				if (isset($lines[$i][0]) && $lines[$i][0] != "#") {
					$sql .= $lines[$i] . "\n";
				} else {
					$sql .= "\n";
				}
				$lines[$i] = "";
			}
		}

		$tokens = explode(';', $sql);
		$sql = "";

		$queries = array();
		$matches = array();

		$token_count = count($tokens);
		for ($i = 0; $i < $token_count; $i++) {

			if (($i != ($token_count - 1)) || (strlen($tokens[$i] > 0))) {
				$total_quotes = preg_match_all("/'/", $tokens[$i], $matches);
				$escaped_quotes = preg_match_all("/(?<!\\\\)(\\\\\\\\)*\\\\'/", $tokens[$i], $matches);
				$unescaped_quotes = $total_quotes - $escaped_quotes;

				if (($unescaped_quotes % 2) == 0) {
					$queries[] = trim($tokens[$i]);
					$tokens[$i] = "";
				} else {
					$temp = $tokens[$i] . ';';
					$tokens[$i] = "";
					$complete_stmt = false;

					for ($j = $i + 1; (!$complete_stmt && ($j < $token_count)); $j++) {
						$total_quotes = preg_match_all("/'/", $tokens[$j], $matches);
						$escaped_quotes = preg_match_all("/(?<!\\\\)(\\\\\\\\)*\\\\'/", $tokens[$j], $matches);
						$unescaped_quotes = $total_quotes - $escaped_quotes;

						if (($unescaped_quotes % 2) == 1) {
							$queries[] = trim($temp . $tokens[$j]);
							$tokens[$j] = "";
							$temp = "";
							$complete_stmt = true;
							$i = $j;
						} else {
							$temp .= $tokens[$j] . ';';
							$tokens[$j] = "";
						}

					}
				}
			}
		}

		return $queries;
	}

	/**
	 * Truncate Text
	 *
	 * @param string $text
	 * @param int $limit
	 * @param string $ellipsis
	 * @return string
	 */
	private function _truncate($str, $length = 100, $breakWords = true, $append = '...') {
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
	 * Fetch query with caching
	 */
	private function _fetch($query, $key = '') {
		$queryName = 'emailtemplate_sql_'. (($key) ? $key . '_' : '') . md5($query);

		$result = $this->cache->get($queryName);

		if ($result) {
			$result = (object)$result; // Hack convert back to object if using file cache
		} else {
			$result = $this->db->query($query);

			$this->cache->set($queryName, $result);
		}

		return $result;
	}

	/**
	 * Delete all cache files for emailtemplate
	 */
	public function clear($prefix = 'emailtemplate_sql_') {
		switch ($this->config->get('cache_type')) {
			case 'apc':
			case 'mem':
			case 'memcached':
				$keys = $this->cache->getAllKeys();
				if ($keys) {
					foreach($keys as $key) {
						// CHekc both with and without cache prefix
						if (substr($key, 0, strlen($prefix)) == $prefix) {
							$this->cache->delete($key);
						} elseif (substr($key, 0, strlen(CACHE_PREFIX . $prefix)) == CACHE_PREFIX . $prefix) {
							$this->cache->delete(substr($key, strlen(CACHE_PREFIX)));
						}
					}
				}
				break;
			default:
				$files = glob(DIR_CACHE . 'cache.' . preg_replace('/[^A-Z0-9\._-]/i', '', $prefix) . '*');
				if ($files) {
					foreach ($files as $file) {
						if (is_file($file) && is_writable($file)) {
							unlink($file);
						}
					}
				}
		}
	}
}


/**
 * Data Access Object - Abstract
 */
abstract class EmailTemplateAbstract
{
	/**
	 * Data Types
	 */
	const INT = "INT";
	const TEXT = "TEXT";
	const SERIALIZE = "SERIALIZE";
	const FLOAT = "FLOAT";
	const DATE_NOW = "DATE_NOW";

	/**
	 * Filter from array, by unsetting element(s)
	 * @param string/array $filter - match array key
	 * @param array to be filtered
	 * @return array
	 */
	protected static function filterArray($filter, $array) {
		if ($filter === null) return $array;

		if (is_array($filter)) {
			foreach($filter as $f) {
				unset($array[$f]);
			}
		} else {
			unset($array[$filter]);
		}

		return $array;
	}

}

/**
 * Email Templates `emailtemplate`
 */
class EmailTemplateDAO extends EmailTemplateAbstract
{
	/**
	 * Columns & Data Types.
	 * @see EmailTemplateDAOAbstract::describe()
	 */
	public static function describe() {
		$filter = func_get_args();
		$cols = array(
			'emailtemplate_id' => EmailTemplateAbstract::INT,
			'emailtemplate_key' => EmailTemplateAbstract::TEXT,
			'emailtemplate_label' => EmailTemplateAbstract::TEXT,
			'emailtemplate_type' => EmailTemplateAbstract::TEXT,
			'emailtemplate_template' => EmailTemplateAbstract::TEXT,
			'emailtemplate_modified' => EmailTemplateAbstract::DATE_NOW,
			'emailtemplate_log' => EmailTemplateAbstract::INT,
			'emailtemplate_view_browser' => EmailTemplateAbstract::INT,
			'emailtemplate_mail_attachment' => EmailTemplateAbstract::TEXT,
			'emailtemplate_mail_to' => EmailTemplateAbstract::TEXT,
			'emailtemplate_mail_cc' => EmailTemplateAbstract::TEXT,
			'emailtemplate_mail_bcc' => EmailTemplateAbstract::TEXT,
			'emailtemplate_mail_from' => EmailTemplateAbstract::TEXT,
			'emailtemplate_mail_html' => EmailTemplateAbstract::INT,
			'emailtemplate_mail_plain_text' => EmailTemplateAbstract::INT,
			'emailtemplate_mail_queue' => EmailTemplateAbstract::INT,
			'emailtemplate_mail_sender' => EmailTemplateAbstract::TEXT,
			'emailtemplate_mail_replyto' => EmailTemplateAbstract::TEXT,
			'emailtemplate_mail_replyto_name' => EmailTemplateAbstract::TEXT,
			'emailtemplate_attach_invoice' => EmailTemplateAbstract::INT,
			'emailtemplate_language_files' => EmailTemplateAbstract::TEXT,
			'emailtemplate_wrapper_tpl' => EmailTemplateAbstract::TEXT,
			'emailtemplate_default' => EmailTemplateAbstract::INT,
			'emailtemplate_status' => EmailTemplateAbstract::INT,
			'emailtemplate_shortcodes' => EmailTemplateAbstract::INT,
			'emailtemplate_showcase' => EmailTemplateAbstract::INT,
			'emailtemplate_condition' => EmailTemplateAbstract::SERIALIZE,
			'emailtemplate_config_id' => EmailTemplateAbstract::INT,
			'store_id' => EmailTemplateAbstract::INT,
			'customer_group_id' => EmailTemplateAbstract::INT,
			'order_status_id' => EmailTemplateAbstract::INT,
			'event_id' => EmailTemplateAbstract::INT
		);

		return (!$filter)? $cols : self::filterArray($filter, $cols);
	}
}

/**
 * Email Templates `emailtemplate_description`
 */
class EmailTemplateDescriptionDAO extends EmailTemplateAbstract
{
	/**
	 * Columns & Data Types.
	 * @see EmailTemplateDAOAbstract::describe()
	 */
	public static function describe() {
		$filter = func_get_args();
		$cols = array(
			'emailtemplate_id' => EmailTemplateAbstract::INT,
			'language_id' => EmailTemplateAbstract::INT,
			'emailtemplate_description_subject' => EmailTemplateAbstract::TEXT,
			'emailtemplate_description_preview' => EmailTemplateAbstract::TEXT,
			'emailtemplate_description_content1' => EmailTemplateAbstract::TEXT,
			'emailtemplate_description_content2' => EmailTemplateAbstract::TEXT,
			'emailtemplate_description_content3' => EmailTemplateAbstract::TEXT,
			'emailtemplate_description_comment' => EmailTemplateAbstract::TEXT,
			'emailtemplate_description_unsubscribe_text' => EmailTemplateAbstract::TEXT
		);

		return (!$filter)? $cols : self::filterArray($filter, $cols);
	}
}

/**
 * Email Templates `emailtemplate_shortcode`
 */
class EmailTemplateShortCodesDAO extends EmailTemplateAbstract
{
	/**
	 * Columns & Data Types.
	 * @see EmailTemplateDAOAbstract::describe()
	 */
	public static function describe() {
		$filter = func_get_args();
		$cols = array(
			'emailtemplate_shortcode_id' => EmailTemplateAbstract::INT,
			'emailtemplate_shortcode_code' => EmailTemplateAbstract::TEXT,
			'emailtemplate_shortcode_type' => EmailTemplateAbstract::TEXT,
			'emailtemplate_shortcode_example' => EmailTemplateAbstract::TEXT,
			'emailtemplate_id' => EmailTemplateAbstract::INT
		);

		return (!$filter)? $cols : self::filterArray($filter, $cols);
	}
}


/**
 * Config `emailtemplate_config`
 */
class EmailTemplateConfigDAO extends EmailTemplateAbstract
{
	/**
	 * Columns & Data Types.
	 * @see EmailTemplateAbstract::describe()
	 */
	public static function describe() {
		$filter = func_get_args();
		$cols = array(
			'emailtemplate_config_id' => EmailTemplateAbstract::INT,
			'emailtemplate_config_name' => EmailTemplateAbstract::TEXT,
			'emailtemplate_config_email_width' => EmailTemplateAbstract::TEXT,
			'emailtemplate_config_email_responsive' => EmailTemplateAbstract::INT,
			'emailtemplate_config_wrapper_tpl' => EmailTemplateAbstract::TEXT,
			'emailtemplate_config_page_bg_color' => EmailTemplateAbstract::TEXT,
			'emailtemplate_config_body_bg_color' => EmailTemplateAbstract::TEXT,
			'emailtemplate_config_body_bg_image' => EmailTemplateAbstract::TEXT,
			'emailtemplate_config_body_bg_image_repeat' => EmailTemplateAbstract::TEXT,
			'emailtemplate_config_body_bg_image_position' => EmailTemplateAbstract::TEXT,
			'emailtemplate_config_body_font_family' => EmailTemplateAbstract::TEXT,
			'emailtemplate_config_body_font_size' => EmailTemplateAbstract::INT,
			'emailtemplate_config_body_font_color' => EmailTemplateAbstract::TEXT,
			'emailtemplate_config_body_link_color' => EmailTemplateAbstract::TEXT,
			'emailtemplate_config_body_heading_color' => EmailTemplateAbstract::TEXT,
			'emailtemplate_config_body_section_bg_color' => EmailTemplateAbstract::TEXT,
			'emailtemplate_config_page_align' => EmailTemplateAbstract::TEXT,
			'emailtemplate_config_page_spacing' => EmailTemplateAbstract::TEXT,
			'emailtemplate_config_page_padding' => EmailTemplateAbstract::TEXT,
			'emailtemplate_config_page_border_radius' => EmailTemplateAbstract::TEXT,
			'emailtemplate_config_page_border_top' => EmailTemplateAbstract::TEXT,
			'emailtemplate_config_page_border_bottom' => EmailTemplateAbstract::TEXT,
			'emailtemplate_config_page_border_left' => EmailTemplateAbstract::TEXT,
			'emailtemplate_config_page_border_right' => EmailTemplateAbstract::TEXT,
			'emailtemplate_config_page_footer_text' => EmailTemplateAbstract::SERIALIZE,
			'emailtemplate_config_footer_bg_color' => EmailTemplateAbstract::TEXT,
			'emailtemplate_config_footer_text' => EmailTemplateAbstract::SERIALIZE,
			'emailtemplate_config_footer_align' => EmailTemplateAbstract::TEXT,
			'emailtemplate_config_footer_font_color' => EmailTemplateAbstract::TEXT,
			'emailtemplate_config_footer_font_size' => EmailTemplateAbstract::INT,
			'emailtemplate_config_footer_height' => EmailTemplateAbstract::INT,
			'emailtemplate_config_footer_padding' => EmailTemplateAbstract::TEXT,
			'emailtemplate_config_footer_section_bg_color' => EmailTemplateAbstract::TEXT,
			'emailtemplate_config_footer_spacing' => EmailTemplateAbstract::TEXT,
			'emailtemplate_config_footer_border_radius' => EmailTemplateAbstract::TEXT,
			'emailtemplate_config_footer_border_top' => EmailTemplateAbstract::TEXT,
			'emailtemplate_config_footer_border_bottom' => EmailTemplateAbstract::TEXT,
			'emailtemplate_config_footer_border_left' => EmailTemplateAbstract::TEXT,
			'emailtemplate_config_footer_border_right' => EmailTemplateAbstract::TEXT,
			'emailtemplate_config_header_bg_color' => EmailTemplateAbstract::TEXT,
			'emailtemplate_config_header_bg_image' => EmailTemplateAbstract::TEXT,
			'emailtemplate_config_header_border_radius' => EmailTemplateAbstract::TEXT,
			'emailtemplate_config_header_border_top' => EmailTemplateAbstract::TEXT,
			'emailtemplate_config_header_border_bottom' => EmailTemplateAbstract::TEXT,
			'emailtemplate_config_header_border_left' => EmailTemplateAbstract::TEXT,
			'emailtemplate_config_header_border_right' => EmailTemplateAbstract::TEXT,
			'emailtemplate_config_header_height' => EmailTemplateAbstract::INT,
			'emailtemplate_config_header_html' => EmailTemplateAbstract::SERIALIZE,
			'emailtemplate_config_header_section_bg_color' => EmailTemplateAbstract::TEXT,
			'emailtemplate_config_header_spacing' => EmailTemplateAbstract::TEXT,
			'emailtemplate_config_head_text' => EmailTemplateAbstract::SERIALIZE,
			'emailtemplate_config_head_section_bg_color' => EmailTemplateAbstract::TEXT,
			'emailtemplate_config_view_browser_text' => EmailTemplateAbstract::SERIALIZE,
			'emailtemplate_config_view_browser_theme' => EmailTemplateAbstract::INT,
			'emailtemplate_config_logo' => EmailTemplateAbstract::TEXT,
			'emailtemplate_config_logo_align' => EmailTemplateAbstract::TEXT,
			'emailtemplate_config_logo_font_color' => EmailTemplateAbstract::TEXT,
			'emailtemplate_config_logo_font_size' => EmailTemplateAbstract::INT,
			'emailtemplate_config_logo_height' => EmailTemplateAbstract::INT,
			'emailtemplate_config_logo_width' => EmailTemplateAbstract::INT,
			'emailtemplate_config_shadow_top' => EmailTemplateAbstract::SERIALIZE,
			'emailtemplate_config_shadow_left' => EmailTemplateAbstract::SERIALIZE,
			'emailtemplate_config_shadow_right' => EmailTemplateAbstract::SERIALIZE,
			'emailtemplate_config_shadow_bottom' => EmailTemplateAbstract::SERIALIZE,
			'emailtemplate_config_showcase' => EmailTemplateAbstract::TEXT,
			'emailtemplate_config_showcase_limit' => EmailTemplateAbstract::INT,
			'emailtemplate_config_showcase_selection' => EmailTemplateAbstract::TEXT,
			'emailtemplate_config_showcase_title' => EmailTemplateAbstract::SERIALIZE,
			'emailtemplate_config_showcase_padding' => EmailTemplateAbstract::TEXT,
			'emailtemplate_config_showcase_cycle' => EmailTemplateAbstract::INT,
			'emailtemplate_config_showcase_related' => EmailTemplateAbstract::INT,
			'emailtemplate_config_showcase_bg_color' => EmailTemplateAbstract::TEXT,
			'emailtemplate_config_showcase_section_bg_color' => EmailTemplateAbstract::TEXT,
			'emailtemplate_config_showcase_per_row' => EmailTemplateAbstract::INT,
			'emailtemplate_config_showcase_border_radius' => EmailTemplateAbstract::TEXT,
			'emailtemplate_config_showcase_border_top' => EmailTemplateAbstract::TEXT,
			'emailtemplate_config_showcase_border_bottom' => EmailTemplateAbstract::TEXT,
			'emailtemplate_config_showcase_border_left' => EmailTemplateAbstract::TEXT,
			'emailtemplate_config_showcase_border_right' => EmailTemplateAbstract::TEXT,
			'emailtemplate_config_order_products' => EmailTemplateAbstract::SERIALIZE,
			'emailtemplate_config_link_style' => EmailTemplateAbstract::TEXT,
			'emailtemplate_config_text_align' => EmailTemplateAbstract::TEXT,
			'emailtemplate_config_theme' => EmailTemplateAbstract::TEXT,
			'emailtemplate_config_style' => EmailTemplateAbstract::TEXT,
			'emailtemplate_config_log' => EmailTemplateAbstract::INT,
			'emailtemplate_config_log_read' => EmailTemplateAbstract::INT,
			'emailtemplate_config_status' => EmailTemplateAbstract::INT,
			'emailtemplate_config_version' => EmailTemplateAbstract::TEXT,
			'customer_group_id' => EmailTemplateAbstract::INT,
			'language_id' => EmailTemplateAbstract::INT,
			'store_id' => EmailTemplateAbstract::INT
		);

		return (!$filter)? $cols : self::filterArray($filter, $cols);
	}
}
