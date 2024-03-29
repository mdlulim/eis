<?php
class ModelSaleReturn extends Model {
	public function addReturn($data) {
		$this->db->query("INSERT INTO `" . DB_PREFIX . "return` SET order_id = '" . (int)$data['order_id'] . "', product_id = '" . (int)$data['product_id'] . "', customer_id = '" . (int)$data['customer_id'] . "', firstname = '" . $this->db->escape($data['firstname']) . "', lastname = '" . $this->db->escape($data['lastname']) . "', email = '" . $this->db->escape($data['email']) . "', telephone = '" . $this->db->escape($data['telephone']) . "', product = '" . $this->db->escape($data['product']) . "', model = '" . $this->db->escape($data['model']) . "', quantity = '" . (int)$data['quantity'] . "', opened = '" . (int)$data['opened'] . "', return_reason_id = '" . (int)$data['return_reason_id'] . "', return_action_id = '" . (int)$data['return_action_id'] . "', return_status_id = '" . (int)$data['return_status_id'] . "', comment = '" . $this->db->escape($data['comment']) . "', date_ordered = '" . $this->db->escape($data['date_ordered']) . "', date_added = NOW(), date_modified = NOW()");
	
		return $this->db->getLastId();
	}

	public function editReturn($return_id, $data) {
		$this->db->query("UPDATE `" . DB_PREFIX . "return` SET order_id = '" . (int)$data['order_id'] . "', product_id = '" . (int)$data['product_id'] . "', customer_id = '" . (int)$data['customer_id'] . "', firstname = '" . $this->db->escape($data['firstname']) . "', lastname = '" . $this->db->escape($data['lastname']) . "', email = '" . $this->db->escape($data['email']) . "', telephone = '" . $this->db->escape($data['telephone']) . "', product = '" . $this->db->escape($data['product']) . "', model = '" . $this->db->escape($data['model']) . "', quantity = '" . (int)$data['quantity'] . "', opened = '" . (int)$data['opened'] . "', return_reason_id = '" . (int)$data['return_reason_id'] . "', return_action_id = '" . (int)$data['return_action_id'] . "', comment = '" . $this->db->escape($data['comment']) . "', date_ordered = '" . $this->db->escape($data['date_ordered']) . "', date_modified = NOW() WHERE return_id = '" . (int)$return_id . "'");
	}

	public function deleteReturn($return_id) {
		$this->db->query("DELETE FROM `" . DB_PREFIX . "return` WHERE return_id = '" . (int)$return_id . "'");
		$this->db->query("DELETE FROM " . DB_PREFIX . "return_history WHERE return_id = '" . (int)$return_id . "'");
	}

	public function checkOrderExist($order_id, $customer_id){
		$status_id = 5;
		$flag = 0; // there is no order with a selected customer
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "order WHERE order_id = '".$order_id."' AND customer_id = '".$customer_id."' ");
		if($query->row['order_id']){
		
			if($query->row['order_status_id'] == 5){ 
				$flag = 1; //order status is confirmed
			}else{
				$flag = 2; //order status is not confirmed
			}
		}
		return $flag;	
	}

	public function getReturn($return_id) {
		$query = $this->db->query("SELECT DISTINCT *, (SELECT CONCAT(c.firstname, ' ', c.lastname) FROM " . DB_PREFIX . "customer c WHERE c.customer_id = r.customer_id) AS customer FROM `" . DB_PREFIX . "return` r WHERE r.return_id = '" . (int)$return_id . "'");
		return $query->row;
	}

	public function getReturns($data = array()) {
		$sql = "SELECT *, CONCAT(r.firstname, ' ', r.lastname) AS customer, (SELECT rs.name FROM " . DB_PREFIX . "return_status rs WHERE rs.return_status_id = r.return_status_id AND rs.language_id = '" . (int)$this->config->get('config_language_id') . "') AS status FROM `" . DB_PREFIX . "return` r";

		$implode = array();

		if (!empty($data['filter_return_id'])) {
			$implode[] = "r.return_id = '" . (int)$data['filter_return_id'] . "'";
		}

		if (!empty($data['filter_order_id'])) {
			$implode[] = "r.order_id = '" . (int)$data['filter_order_id'] . "'";
		}

		if (!empty($data['filter_customer'])) {
			$implode[] = "CONCAT(r.firstname, ' ', r.lastname) LIKE '" . $this->db->escape($data['filter_customer']) . "%'";
		}
		
		if (!empty($data['filter_customer_id'])) {
			$implode[] = "r.customer_id = '" . (int)$data['filter_customer_id'] . "'";
		}
		
		if (!empty($data['filter_product_id'])) {
			$implode[] = "r.product_id = '" . (int)$data['filter_product_id'] . "'";
		}

		if (!empty($data['filter_product'])) {
			$implode[] = "r.product = '" . $this->db->escape($data['filter_product']) . "'";
		}

		if (!empty($data['filter_model'])) {
			$implode[] = "r.model = '" . $this->db->escape($data['filter_model']) . "'";
		}

		if (!empty($data['filter_return_status_id'])) {
			$implode[] = "r.return_status_id = '" . (int)$data['filter_return_status_id'] . "'";
		}

		if (!empty($data['filter_date_added'])) {
			$implode[] = "DATE(r.date_added) = DATE('" . $this->db->escape($data['filter_date_added']) . "')";
		}

		if (!empty($data['filter_date_modified'])) {
			$implode[] = "DATE(r.date_modified) = DATE('" . $this->db->escape($data['filter_date_modified']) . "')";
		}

		if ($implode) {
			$sql .= " WHERE " . implode(" AND ", $implode);
		}

		$sort_data = array(
			'r.return_id',
			'r.order_id',
			'customer',
			'r.product',
			'r.model',
			'status',
			'r.date_added',
			'r.date_modified'
		);

		if (isset($data['sort']) && in_array($data['sort'], $sort_data)) {
			$sql .= " ORDER BY " . $data['sort'];
		} else {
			$sql .= " ORDER BY r.return_id";
		}

		if (isset($data['order']) && ($data['order'] == 'DESC')) {
			$sql .= " DESC";
		} else {
			$sql .= " ASC";
		}

		if (isset($data['start']) || isset($data['limit'])) {
			if ($data['start'] < 0) {
				$data['start'] = 0;
			}

			if ($data['limit'] < 1) {
				$data['limit'] = 20;
			}

			$sql .= " LIMIT " . (int)$data['start'] . "," . (int)$data['limit'];
		}

		$query = $this->db->query($sql);

		return $query->rows;
	}

	public function getTotalReturns($data = array()) {
		$sql = "SELECT COUNT(*) AS total FROM `" . DB_PREFIX . "return`r";

		$implode = array();

		if (!empty($data['filter_return_id'])) {
			$implode[] = "r.return_id = '" . (int)$data['filter_return_id'] . "'";
		}

		if (!empty($data['filter_customer'])) {
			$implode[] = "CONCAT(r.firstname, ' ', r.lastname) LIKE '" . $this->db->escape($data['filter_customer']) . "%'";
		}

		if (!empty($data['filter_order_id'])) {
			$implode[] = "r.order_id = '" . $this->db->escape($data['filter_order_id']) . "'";
		}
		
		if (!empty($data['filter_customer_id'])) {
			$implode[] = "r.customer_id = '" . (int)$data['filter_customer_id'] . "'";
		}
		
		if (!empty($data['filter_product_id'])) {
			$implode[] = "r.product_id = '" . (int)$data['filter_product_id'] . "'";
		}
		
		if (!empty($data['filter_product'])) {
			$implode[] = "r.product = '" . $this->db->escape($data['filter_product']) . "'";
		}

		if (!empty($data['filter_model'])) {
			$implode[] = "r.model = '" . $this->db->escape($data['filter_model']) . "'";
		}

		if (!empty($data['filter_return_status_id'])) {
			$implode[] = "r.return_status_id = '" . (int)$data['filter_return_status_id'] . "'";
		}

		if (!empty($data['filter_date_added'])) {
			$implode[] = "DATE(r.date_added) = DATE('" . $this->db->escape($data['filter_date_added']) . "')";
		}

		if (!empty($data['filter_date_modified'])) {
			$implode[] = "DATE(r.date_modified) = DATE('" . $this->db->escape($data['filter_date_modified']) . "')";
		}

		if ($implode) {
			$sql .= " WHERE " . implode(" AND ", $implode);
		}

		$query = $this->db->query($sql);

		return $query->row['total'];
	}

	public function getTotalReturnsByReturnStatusId($return_status_id) {
		$query = $this->db->query("SELECT COUNT(*) AS total FROM `" . DB_PREFIX . "return` WHERE return_status_id = '" . (int)$return_status_id . "'");

		return $query->row['total'];
	}

	public function getTotalReturnsByReturnReasonId($return_reason_id) {
		$query = $this->db->query("SELECT COUNT(*) AS total FROM `" . DB_PREFIX . "return` WHERE return_reason_id = '" . (int)$return_reason_id . "'");

		return $query->row['total'];
	}

	public function getTotalReturnsByReturnActionId($return_action_id) {
		$query = $this->db->query("SELECT COUNT(*) AS total FROM `" . DB_PREFIX . "return` WHERE return_action_id = '" . (int)$return_action_id . "'");

		return $query->row['total'];
	}

	public function addReturnHistory($return_id, $data) {
		$this->db->query("UPDATE `" . DB_PREFIX . "return` SET return_status_id = '" . (int)$data['return_status_id'] . "', date_modified = NOW() WHERE return_id = '" . (int)$return_id . "'");

		$this->db->query("INSERT INTO " . DB_PREFIX . "return_history SET return_id = '" . (int)$return_id . "', return_status_id = '" . (int)$data['return_status_id'] . "', notify = '" . (isset($data['notify']) ? (int)$data['notify'] : 0) . "', comment = '" . $this->db->escape($data['comment']) . "', date_added = NOW()");
		$return_history_id = $this->db->getLastId();

		if ($data['notify']) {
			$return_query = $this->db->query("SELECT *, rs.name AS status FROM `" . DB_PREFIX . "return` r LEFT JOIN " . DB_PREFIX . "return_status rs ON (r.return_status_id = rs.return_status_id) WHERE r.return_id = '" . (int)$return_id . "' AND rs.language_id = '" . (int)$this->config->get('config_language_id') . "'");

			if ($return_query->num_rows) {
				$this->load->language('mail/return');


			$this->load->model('extension/mail/template');
			$this->load->model('sale/order');

			$order_info = $this->model_sale_order->getOrder($return_query->row['order_id']);

			$template_load = array('key' => 'admin.return_history');

			if (isset($order_info['store_id'])) {
				$template_load['store_id'] = $order_info['store_id'];
			}

			if (isset($order_info['language_id'])) {
				$template_load['language_id'] = $order_info['language_id'];
			}

			if (isset($order_info['customer_id'])) {
				$template_load['customer_id'] = $order_info['customer_id'];
			}

			$template = $this->model_extension_mail_template->load($template_load);

			$template->addData($return_query->row);

			/*if ($return_query->row['product_id']) {
				$this->load->model('catalog/product');

				$product_info = $this->model_catalog_product->getProduct($return_query->row['product_id']);

				$template->addData($product_info, 'product');
			}*/

			if ($order_info) {
				$template->addData($order_info, 'order');

				$template->data['order_id'] = $order_info['order_id'];

				$template->data['return_link'] = $order_info['store_url'] . 'index.php?route=' . rawurlencode('account/return/info') . '&return_id=' . $return_id;
			} else {
				$template->data['return_link'] = HTTP_CATALOG . 'index.php?route=' . rawurlencode('account/return/info') . '&return_id=' . $return_id;
			}

			$this->load->model('localisation/return_reason');
			$return_reason_info = $this->model_localisation_return_reason->getReturnReason($return_query->row['return_reason_id']);

			if ($return_reason_info) {
				$template->data['reason'] = $return_reason_info['name'];
			}

			$template->data['return_id'] = $return_id;

			$template->data['date_added'] = date($this->language->get('date_format_short'), strtotime($return_query->row['date_added']));

			$template->data['comment'] = (isset($data['comment'])) ? (strcmp($data['comment'], strip_tags($html_str = html_entity_decode($data['comment'], ENT_QUOTES, 'UTF-8'))) == 0) ? nl2br($data['comment']) : $html_str : '';

			$template->data['opened'] = $return_query->row['opened'] ? $this->language->get('text_yes') : $this->language->get('text_no');
			
				$subject = sprintf($this->language->get('text_subject'), html_entity_decode($this->config->get('config_name'), ENT_QUOTES, 'UTF-8'), $return_id);

				$message  = $this->language->get('text_return_id') . ' ' . $return_id . "\n";
				$message .= $this->language->get('text_date_added') . ' ' . date($this->language->get('date_format_short'), strtotime($return_query->row['date_added'])) . "\n\n";
				$message .= $this->language->get('text_return_status') . "\n";
				$message .= $return_query->row['status'] . "\n\n";

				if ($data['comment']) {
					$message .= $this->language->get('text_comment') . "\n\n";
					$message .= strip_tags(html_entity_decode($data['comment'], ENT_QUOTES, 'UTF-8')) . "\n\n";
				}

				$message .= $this->language->get('text_footer');

				$mail = new Mail();
				$mail->protocol = $this->config->get('config_mail_protocol');
				$mail->parameter = $this->config->get('config_mail_parameter');
				$mail->smtp_hostname = $this->config->get('config_mail_smtp_hostname');
				$mail->smtp_username = $this->config->get('config_mail_smtp_username');
				$mail->smtp_password = html_entity_decode($this->config->get('config_mail_smtp_password'), ENT_QUOTES, 'UTF-8');
				$mail->smtp_port = $this->config->get('config_mail_smtp_port');
				$mail->smtp_timeout = $this->config->get('config_mail_smtp_timeout');

				$mail->setTo($return_query->row['email']);
				$mail->setFrom($this->config->get('config_email'));
				$mail->setSender(html_entity_decode($this->config->get('config_name'), ENT_QUOTES, 'UTF-8'));
				$mail->setSubject($subject);
				$mail->setText($message);
				
            $template->hook($mail);

			$mail->send();

			$this->model_extension_mail_template->sent();

			$this->db->query("UPDATE " . DB_PREFIX . "return_history SET comment = '" . $this->db->escape($template->data['comment']) . "' WHERE return_history_id = '" . (int)$return_history_id . "'");
			}
		}
	}

	public function getReturnHistories($return_id, $start = 0, $limit = 10) {
		if ($start < 0) {
			$start = 0;
		}

		if ($limit < 1) {
			$limit = 10;
		}

		$query = $this->db->query("SELECT rh.date_added, rs.name AS status, rh.comment, rh.notify FROM " . DB_PREFIX . "return_history rh LEFT JOIN " . DB_PREFIX . "return_status rs ON rh.return_status_id = rs.return_status_id WHERE rh.return_id = '" . (int)$return_id . "' AND rs.language_id = '" . (int)$this->config->get('config_language_id') . "' ORDER BY rh.date_added ASC LIMIT " . (int)$start . "," . (int)$limit);

		return $query->rows;
	}

	public function getTotalReturnHistories($return_id) {
		$query = $this->db->query("SELECT COUNT(*) AS total FROM " . DB_PREFIX . "return_history WHERE return_id = '" . (int)$return_id . "'");

		return $query->row['total'];
	}

	public function getTotalReturnHistoriesByReturnStatusId($return_status_id) {
		$query = $this->db->query("SELECT COUNT(*) AS total FROM " . DB_PREFIX . "return_history WHERE return_status_id = '" . (int)$return_status_id . "'");

		return $query->row['total'];
	}
}
