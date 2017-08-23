<?php
class ModelExtensionMailTemplate extends Model {

	private $content_count = 3;

	/**
	 * Load Email Template
	 *
	 * @param mixed   $load
	 *        null    load default email template (1)
	 *        array   load email template using array key(s)
	 *        int     load email template using `emailtemplate_id`
	 *        string  load email template using `emailtemplate_key`
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

		if ($this->customer && $this->customer->isLogged()) {
			$customer_id = $this->customer->getId();
			$customer_group_id = $this->customer->getGroupId();
		} elseif (!empty($load['customer_id'])) {
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
		$config_keys = array('title', 'name', 'url', 'ssl', 'owner', 'address', 'email', 'telephone', 'fax', 'country_id', 'currency', 'zone_id', 'tax', 'tax_default', 'customer_price');

		foreach($config_keys as $key) {
			if (!isset($this->emailtemplate->data['store_' . $key])) {
				$this->emailtemplate->data['store_' . $key] = $this->config->get('config_' . $key);
			}
		}

		// Fallback for store_id = 0
		if (!$this->emailtemplate->data['store_url']) {
			$this->emailtemplate->data['store_url'] = HTTP_SERVER;
		}

		if (!$this->emailtemplate->data['store_ssl']) {
			$this->emailtemplate->data['store_ssl'] = HTTPS_SERVER;
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
				$unserialized = @unserialize(base64_decode($this->emailtemplate->data['config'][$var]));
				$this->emailtemplate->data['config'][$var] = ($unserialized !== false) ? $unserialized : $this->emailtemplate->data['config'][$var];

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

		if ($this->emailtemplate->data['config']['order_products'] && !is_array($this->emailtemplate->data['config']['order_products'])) {
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

				$this->emailtemplate->data['config']['logo'] = $this->model_tool_image->resize($this->emailtemplate->data['config']['logo'], $this->emailtemplate->data['config']['logo_width'], $this->emailtemplate->data['config']['logo_height']);
			} else {
				$this->emailtemplate->data['config']['logo'] = $image_url . $this->emailtemplate->data['config']['logo'];
			}
		}

		$this->emailtemplate->data['config']['template_dir'] = DIR_TEMPLATE . $this->emailtemplate->data['config']['theme'] . '/template/extension/mail/';

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

		// Language file
		if ($this->emailtemplate->data['emailtemplate']['language_files']) {
			$language_files = explode(',', $this->emailtemplate->data['emailtemplate']['language_files']);

			if ($language_files) {
				foreach ($language_files as $language_file) {
					$this->language->load(trim($language_file));
				}
			}
		}

		$this->emailtemplate->language_data = $this->language->load('extension/mail/emailtemplate');

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

			$this->emailtemplate->data['showcase_selection'] = $this->getShowcase($customer_id, $this->emailtemplate->data['config']);
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

		$this->emailtemplate->data['account_url'] = $this->url->link('account/account', '', true);
		$this->emailtemplate->data['contact_url'] = $this->url->link('information/contact', '', true);
		$this->emailtemplate->data['home_url'] = $this->url->link('common/home');

		if ($emailtemplate['shortcodes'] == 1){
			$result = $this->getTemplateShortcodes($emailtemplate['emailtemplate_id']);

			if ($result) {
				$default_shortcodes = array();

				foreach ($result as $row) {
					$parts = explode('.', $row['emailtemplate_shortcode_code']);

					if (isset($parts[1])) {
						$default_shortcodes[$parts[0] . '_' . $parts[1]] = '';
					} else {
						$default_shortcodes[$parts[0]] = '';
					}
				}

				$this->emailtemplate->setDefaultShortcodes($default_shortcodes);
			}
		}

		if ($emailtemplate['wrapper_tpl']) {
			$this->emailtemplate->data['wrapper_tpl'] = $emailtemplate['wrapper_tpl'];
		} elseif ($emailtemplate_config['wrapper_tpl']) {
			$this->emailtemplate->data['wrapper_tpl'] = $emailtemplate_config['wrapper_tpl'];
		}

		if ($emailtemplate['log'] || $emailtemplate_config['log']) {
			$this->emailtemplate->data['emailtemplate_log_id'] = $this->createTemplateLog();
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

			$log_data['emailtemplate_log_attachment'] = $this->emailtemplate->data['mail']['attachments'] ? base64_encode(serialize($this->emailtemplate->data['mail']['attachments'])) : '';

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

	public function getShowcase($customer_id, $emailtemplate_config) {
		$showcase_selection = array();

		$this->load->model('extension/mail/template/product');
		//$this->load->model('tool/image');

		$products = array();
		$order_products = array();

		if ($emailtemplate_config['showcase_related'] && $this->emailtemplate->get('order_id')) {
			$this->load->model('account/order');

			$result = $this->model_account_order->getOrderProducts($this->emailtemplate->get('order_id'));
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
			$limit = count($order_products) + $emailtemplate_config['showcase_limit'];

			switch($emailtemplate_config['showcase']) {
				case 'bestsellers':
					$result = $this->model_extension_mail_template_product->getBestSellerProducts($limit, $customer_id);
					break;

				case 'latest':
					$result = $this->model_extension_mail_template_product->getLatestProducts($limit, $customer_id);
					break;

				case 'specials':
					$result = $this->model_extension_mail_template_product->getProductSpecials($limit, $customer_id);
					break;

				case 'popular':
					$result = $this->model_extension_mail_template_product->getPopularProducts($limit, $customer_id);
					break;

				case 'products':
					if ($emailtemplate_config['showcase_selection']) {
						$result = array();
						$selection = explode(',', $emailtemplate_config['showcase_selection']);
						foreach($selection as $product_id) {
							if ($product_id && !isset($products[$product_id])) {
								$row = $this->model_extension_mail_template_product->getProduct((int)$product_id);
								if ($row) {
									$result[] = $row;
								}
							}
						}
					}
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

		if (isset($this->session->data['currency'])) {
			$currency_code = $this->session->data['currency'];
		} else {
			$currency_code = $this->config->get('config_currency');
		}

		if (!empty($products)) {
			foreach($products as $product) {
				if (!isset($product['product_id'])) continue;

				if ($product['image']) {
					$product['image'] = $this->model_tool_image->resize($product['image'], 100, 100);
				}

				if (($this->config->get('config_customer_price') && $this->customer->isLogged()) || !$this->config->get('config_customer_price')) {
					$price = $this->currency->format($this->tax->calculate($product['price'], $product['tax_class_id'], $this->config->get('config_tax')), $currency_code);
				} else {
					$price = false;
				}

				if ((float)$product['special']) {
					$special = $this->currency->format($this->tax->calculate($product['special'], $product['tax_class_id'], $this->config->get('config_tax')), $currency_code);
				} else {
					$special = false;
				}

				$url = $this->url->link('product/product', 'product_id=' . $product['product_id']);

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

	/**
	 * Get Template Log
	 * @param array $id
	 * @return array
	 */
	public function getTemplateLog($data) {
		$query = "SELECT * FROM " . DB_PREFIX . "emailtemplate_logs";

		$where = array();

		if (is_array($data)) {
			if (isset($data['emailtemplate_log_id'])) {
				$where[] = "`emailtemplate_log_id` = '" . (int)$data['emailtemplate_log_id'] . "'";
			}

			if (isset($data['emailtemplate_log_enc'])) {
				$where[] = "`emailtemplate_log_enc` = '" . $this->db->escape($data['emailtemplate_log_enc']) . "'";
			}

			if (isset($data['emailtemplate_log_status'])) {
				$where[] = "`emailtemplate_log_status` = '" . (int)$data['emailtemplate_log_status'] . "'";
			}
		} else {
			$where[] = "`emailtemplate_log_id` = '" . (int)$data . "'";
		}

		$query .= " WHERE " . implode(" AND ", $where) . " LIMIT 1";

		$result = $this->_fetch($query);

		return $result->row;
	}

	/**
	 * Get Template Logs
	 * @param array $id
	 * @return array
	 */
	public function getTemplateLogs($data) {
		$query = "SELECT * FROM " . DB_PREFIX . "emailtemplate_logs";

		$where = array();

		if (is_array($data)) {
			if (isset($data['emailtemplate_log_is_sent'])) {
				$where[] = "`emailtemplate_log_is_sent` = '" . (int)$data['emailtemplate_log_is_sent'] . "'";
			}
		} else {
			$where[] = "`emailtemplate_log_id` = '" . (int)$data . "'";
		}

		$query .= " WHERE " . implode(" AND ", $where) . " ORDER BY emailtemplate_log_added ASC";

		$result = $this->db->query($query);

		return $result->rows;
	}

	/**
	 * Create Log
	 */
	public function createTemplateLog() {
		$query = "INSERT INTO " . DB_PREFIX . "emailtemplate_logs (`emailtemplate_log_id`, `emailtemplate_log_added`, `emailtemplate_log_status`) VALUES (NULL, NOW(), 0)";

		$this->db->query($query);

		return $this->db->getLastId();
	}

	/**
	 * Record Products In Showcase
	 */
	public function recordProductsInShowcase() {
		if (empty($this->emailtemplate->data['config']) ||
			empty($this->emailtemplate->data['config']['showcase_cycle']) ||
			empty($this->emailtemplate->data['showcase_selection']) ||
			empty($this->emailtemplate->data['mail']['to'])) {
			return false;
		}

		if ($this->customer && $this->customer->isLogged()) {
			$customer_id = $this->customer->getId();
		} else {
			$this->load->model('account/customer');

			$email = $this->emailtemplate->data['mail']['to'];

			$customer_info = $this->model_account_customer->getCustomerByEmail($email);

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

	public function updateTemplateLog($emailtemplate_log_id, $data) {
		$query = "UPDATE " . DB_PREFIX . "emailtemplate_logs SET `emailtemplate_log_sent` = " . ($data['emailtemplate_log_is_sent'] ? 'NOW()' : 'NULL') . ", emailtemplate_log_type = 'SYSTEM', `emailtemplate_log_status` = 1, emailtemplate_log_enc = '" . $this->db->escape($data['emailtemplate_log_enc']) . "', emailtemplate_log_to = '" . $this->db->escape($data['emailtemplate_log_to']) . "', emailtemplate_log_from = '" . $this->db->escape($data['emailtemplate_log_from']) . "', emailtemplate_log_sender = '" . $this->db->escape($data['emailtemplate_log_sender']) . "', emailtemplate_log_cc = '" . $this->db->escape($data['emailtemplate_log_cc']) . "', emailtemplate_log_bcc = '" . $this->db->escape($data['emailtemplate_log_bcc']) . "', emailtemplate_log_attachment = '" . $this->db->escape($data['emailtemplate_log_attachment']) . "', emailtemplate_log_subject = '" . $this->db->escape($data['emailtemplate_log_subject']) . "', emailtemplate_log_text = '" . $this->db->escape($data['emailtemplate_log_text']) . "', emailtemplate_log_content = '" . $this->db->escape($data['emailtemplate_log_content']) . "', emailtemplate_log_is_sent = '" . (int)$data['emailtemplate_log_is_sent'] . "', store_id = '" . (int)$data['store_id'] . "', language_id = '" . (int)$data['language_id'] . "', customer_id = '" . (int)$data['customer_id'] . "', emailtemplate_id = '" . (int)$data['emailtemplate_id'] . "', emailtemplate_config_id = '" . (int)$data['emailtemplate_config_id'] . "' WHERE emailtemplate_log_id = " . (int)$emailtemplate_log_id;

		$this->db->query($query);
	}

	public function disableTemplateLog($emailtemplate_log_id) {
		$query = "UPDATE " . DB_PREFIX . "emailtemplate_logs SET `emailtemplate_log_status` = 0 WHERE emailtemplate_log_id = " . (int)$emailtemplate_log_id;

		$this->db->query($query);
	}

	public function readTemplateLog($emailtemplate_log_id, $enc) {
		$query = "UPDATE " . DB_PREFIX . "emailtemplate_logs SET emailtemplate_log_read_last = NOW() WHERE emailtemplate_log_id = '" . (int)$emailtemplate_log_id . "' AND emailtemplate_log_enc = '" . $this->db->escape($enc) . "'";

		$this->db->query($query);

		if ($this->db->countAffected() > 0) {
			$sql = "UPDATE " . DB_PREFIX . "emailtemplate_logs SET emailtemplate_log_read = NOW() WHERE emailtemplate_log_id = '" . (int)$emailtemplate_log_id . "' AND emailtemplate_log_read IS NULL";
			$this->db->query($sql);

			return true;
		}
	}

	/**
	 * Get Templates
	 *
	 * @return array
	 */
	public function getTemplates($data = array()) {
		$where = array();

		if (isset($data['store_id'])) {
			if (is_numeric($data['store_id'])) {
				$where[] = "e.`store_id` = '".(int)$data['store_id']."'";
			} else {
				$where[] = "e.`store_id` IS NULL";
			}
		}

		if (isset($data['language_id']) && $data['language_id'] != 0) {
			$where[] = "ed.`language_id` = '".(int)$data['language_id']."'";
		}

		if (isset($data['customer_group_id']) && $data['customer_group_id'] != 0) {
			$where[] = "e.`customer_group_id` = '".(int)$data['customer_group_id']."'";
		}

		if (isset($data['emailtemplate_key']) && $data['emailtemplate_key'] != "") {
			$where[] = "e.`emailtemplate_key` = '".$this->db->escape($data['emailtemplate_key'])."'";
		}

		if (isset($data['emailtemplate_status']) && $data['emailtemplate_status'] != "") {
			$where[] = "e.`emailtemplate_status` = '".$this->db->escape($data['emailtemplate_status'])."'";
		} else {
			$where[] = "e.`emailtemplate_status` = 1";
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

		if (isset($data['language_id']) && $data['language_id'] != 0) {
			$query = "SELECT e.*, ed.* FROM " . DB_PREFIX . "emailtemplate e LEFT JOIN `" . DB_PREFIX . "emailtemplate_description` ed ON(ed.emailtemplate_id = e.emailtemplate_id)";
		} else {
			$query = "SELECT e.* FROM " . DB_PREFIX . "emailtemplate e";
		}

		if (!empty($where)) {
			$query .= ' WHERE ' . implode(' AND ', $where);
		}

		$sort_data = array(
			'label' => 'e.`emailtemplate_label`',
			'key' => 'e.`emailtemplate_key`',
			'template' => 'e.`emailtemplate_template`',
			'modified' => 'e.`emailtemplate_modified`',
			'shortcodes' => 'e.`emailtemplate_shortcodes`',
			'status' => 'e.`emailtemplate_status`',
			'id' => 'e.`emailtemplate_id`',
			'store' => 'e.`store_id`',
			'customer' => 'e.`customer_group_id`',
			'language' => 'ed.`language_id`'
		);

		if (isset($data['sort']) && in_array($data['sort'], array_keys($sort_data))) {
			$query .= " ORDER BY " . $sort_data[$data['sort']];
		} else {
			$query .= " ORDER BY e.`emailtemplate_label`";
		}

		if (isset($data['order']) && ($data['order'] == 'DESC')) {
			$query .= " DESC";
		} else {
			$query .= " ASC";
		}

		if (isset($data['start']) || isset($data['limit'])) {
			if ($data['start'] < 0) {
				$data['start'] = 0;
			}
			if ($data['limit'] < 1) {
				$data['limit'] = 20;
			}
			$query .= " LIMIT " . (int)$data['start'] . "," . (int)$data['limit'];
		}

		$result = $this->_fetch($query);

		return $result->rows;
	}

	/**
	 * Get Template
	 * @param array $data
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

		$result = $this->_fetch($query);

		return ($limit == 1) ? $result->row : $result->rows;
	}

	/**
	 * Get template shortcodes
	 */
	public function getTemplateShortcodes($emailtemplate_id) {
		$query = "SELECT * FROM `" . DB_PREFIX . "emailtemplate_shortcode` WHERE `emailtemplate_id` = '" . (int)$emailtemplate_id . "' ORDER BY `emailtemplate_shortcode_id` ASC";

		$result = $this->_fetch($query);

		return $result->rows;
	}

	/**
	 * Insert Template Short Codes
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

	/**
	 * Get Email Template Config
	 *
	 * @param int||array $identifier
	 * @param bool $outputFormatting
	 * @return array
	 */
	public function getConfig($data, $outputFormatting = false) {
		$where = array();

		if (is_array($data)) {
			if (isset($data['store_id'])) {
				$where[] = "`store_id` = '".(int)$data['store_id']."'";
			}

			if (isset($data['language_id'])) {
				$where[] = "(`language_id` = '".(int)$data['language_id']."' OR `language_id` = 0)";
			}
		} elseif (is_numeric($data)) {
			$where[] = "`emailtemplate_config_id` = '" . (int)$data . "'";
		} else {
			return false;
		}

		$query = "SELECT * FROM " . DB_PREFIX . "emailtemplate_config";

		if (!empty($where)) {
			$query .= " WHERE " . implode(" AND ", $where);
		}

		$query .= " ORDER BY `language_id` DESC LIMIT 1";

		$result = $this->_fetch($query);

		return $result->row;
	}

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

		if (isset($data['status']) && $data['status'] != "") {
			$where[] = "AND ec.`emailtemplate_config_status` = '".$this->db->escape($data['status'])."'";
		} else {
			$where[] = "AND ec.`emailtemplate_config_status` = 1";
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
			if ($data['start'] < 0) {
				$data['start'] = 0;
			}
			if ($data['limit'] < 1) {
				$data['limit'] = 20;
			}
			$query .= " LIMIT " . (int)$data['start'] . "," . (int)$data['limit'];
		}

		$result = $this->_fetch($query);

		return $result->rows;
	}

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
	private function _fetch($query) {
		$queryName = 'emailtemplate_sql_'.md5($query);

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