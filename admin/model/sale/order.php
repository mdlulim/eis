<?php
class ModelSaleOrder extends Model {
	public function deleteOrder($order_id) {
		$this->db->query("DELETE FROM `" . DB_PREFIX . "order` WHERE order_id = '" . (int)$order_id . "'");
		$this->db->query("DELETE FROM `" . DB_PREFIX . "order_product` WHERE order_id = '" . (int)$order_id . "'");
		$this->db->query("DELETE FROM `" . DB_PREFIX . "order_option` WHERE order_id = '" . (int)$order_id . "'");
		$this->db->query("DELETE FROM `" . DB_PREFIX . "order_voucher` WHERE order_id = '" . (int)$order_id . "'");
		$this->db->query("DELETE FROM `" . DB_PREFIX . "order_total` WHERE order_id = '" . (int)$order_id . "'");
		$this->db->query("DELETE FROM `" . DB_PREFIX . "order_history` WHERE order_id = '" . (int)$order_id . "'");
		$this->db->query("DELETE `or`, ort FROM `" . DB_PREFIX . "order_recurring` `or`, `" . DB_PREFIX . "order_recurring_transaction` `ort` WHERE order_id = '" . (int)$order_id . "' AND ort.order_recurring_id = `or`.order_recurring_id");
		$this->db->query("DELETE FROM `" . DB_PREFIX . "affiliate_transaction` WHERE order_id = '" . (int)$order_id . "'");

		// Delete voucher data as well
		$this->db->query("DELETE FROM `" . DB_PREFIX . "voucher` WHERE order_id = '" . (int)$order_id . "'");
		$this->db->query("DELETE FROM `" . DB_PREFIX . "voucher_history` WHERE order_id = '" . (int)$order_id . "'");
	}	
	
	public function getOrder($order_id) {
		$order_query = $this->db->query("SELECT *, (SELECT CONCAT(c.firstname) FROM " . DB_PREFIX . "customer c WHERE c.customer_id = o.customer_id) AS customer, (SELECT os.name FROM " . DB_PREFIX . "order_status os WHERE os.order_status_id = o.order_status_id AND os.language_id = '" . (int)$this->config->get('config_language_id') . "') AS order_status FROM `" . DB_PREFIX . "order` o WHERE o.order_id = '" . (int)$order_id . "'");

		if ($order_query->num_rows) {
			$country_query = $this->db->query("SELECT * FROM `" . DB_PREFIX . "country` WHERE country_id = '" . (int)$order_query->row['payment_country_id'] . "'");

			if ($country_query->num_rows) {
				$payment_iso_code_2 = $country_query->row['iso_code_2'];
				$payment_iso_code_3 = $country_query->row['iso_code_3'];
			} else {
				$payment_iso_code_2 = '';
				$payment_iso_code_3 = '';
			}

			$zone_query = $this->db->query("SELECT * FROM `" . DB_PREFIX . "zone` WHERE zone_id = '" . (int)$order_query->row['payment_zone_id'] . "'");

			if ($zone_query->num_rows) {
				$payment_zone_code = $zone_query->row['code'];
			} else {
				$payment_zone_code = '';
			}

			$country_query = $this->db->query("SELECT * FROM `" . DB_PREFIX . "country` WHERE country_id = '" . (int)$order_query->row['shipping_country_id'] . "'");

			if ($country_query->num_rows) {
				$shipping_iso_code_2 = $country_query->row['iso_code_2'];
				$shipping_iso_code_3 = $country_query->row['iso_code_3'];
			} else {
				$shipping_iso_code_2 = '';
				$shipping_iso_code_3 = '';
			}

			$zone_query = $this->db->query("SELECT * FROM `" . DB_PREFIX . "zone` WHERE zone_id = '" . (int)$order_query->row['shipping_zone_id'] . "'");

			if ($zone_query->num_rows) {
				$shipping_zone_code = $zone_query->row['code'];
			} else {
				$shipping_zone_code = '';
			}

			$reward = 0;

			$order_product_query = $this->db->query("SELECT * FROM " . DB_PREFIX . "order_product WHERE order_id = '" . (int)$order_id . "'");

			foreach ($order_product_query->rows as $product) {
				$reward += $product['reward'];
			}
			
			if ($order_query->row['affiliate_id']) {
				$affiliate_id = $order_query->row['affiliate_id'];
			} else {
				$affiliate_id = 0;
			}

			$this->load->model('marketing/affiliate');

			$affiliate_info = $this->model_marketing_affiliate->getAffiliate($affiliate_id);

			if ($affiliate_info) {
				$affiliate_firstname = $affiliate_info['firstname'];
				$affiliate_lastname = $affiliate_info['lastname'];
			} else {
				$affiliate_firstname = '';
				$affiliate_lastname = '';
			}

			$this->load->model('localisation/language');

			$language_info = $this->model_localisation_language->getLanguage($order_query->row['language_id']);

			if ($language_info) {
				$language_code = $language_info['code'];
			} else {
				$language_code = $this->config->get('config_language');
			}

			return array(
				'order_id'                => $order_query->row['order_id'],
				'isReplogic'                => $order_query->row['isReplogic'],
				'invoice_no'              => $order_query->row['invoice_no'],
				'invoice_prefix'          => $order_query->row['invoice_prefix'],
				'store_id'                => $order_query->row['store_id'],
				'store_name'              => $order_query->row['store_name'],
				'store_url'               => $order_query->row['store_url'],
				'customer_id'             => $order_query->row['customer_id'],
				'customer'                => $order_query->row['customer'],
				'customer_group_id'       => $order_query->row['customer_group_id'],
				'firstname'               => $order_query->row['firstname'],
				'lastname'                => $order_query->row['lastname'],
				'email'                   => $order_query->row['email'],
				'telephone'               => $order_query->row['telephone'],
				'fax'                     => $order_query->row['fax'],
				'custom_field'            => json_decode($order_query->row['custom_field'], true),
				'payment_firstname'       => $order_query->row['payment_firstname'],
				'payment_lastname'        => $order_query->row['payment_lastname'],
				'payment_company'         => $order_query->row['payment_company'],
				'payment_address_1'       => $order_query->row['payment_address_1'],
				'payment_address_2'       => $order_query->row['payment_address_2'],
				'payment_postcode'        => $order_query->row['payment_postcode'],
				'payment_city'            => $order_query->row['payment_city'],
				'payment_zone_id'         => $order_query->row['payment_zone_id'],
				'payment_zone'            => $order_query->row['payment_zone'],
				'payment_zone_code'       => $payment_zone_code,
				'payment_country_id'      => $order_query->row['payment_country_id'],
				'payment_country'         => $order_query->row['payment_country'],
				'payment_iso_code_2'      => $payment_iso_code_2,
				'payment_iso_code_3'      => $payment_iso_code_3,
				'payment_address_format'  => $order_query->row['payment_address_format'],
				'payment_custom_field'    => json_decode($order_query->row['payment_custom_field'], true),
				'payment_method'          => $order_query->row['payment_method'],
				'payment_code'            => $order_query->row['payment_code'],
				'shipping_firstname'      => $order_query->row['shipping_firstname'],
				'shipping_lastname'       => $order_query->row['shipping_lastname'],
				'shipping_company'        => $order_query->row['shipping_company'],
				'shipping_address_1'      => $order_query->row['shipping_address_1'],
				'shipping_address_2'      => $order_query->row['shipping_address_2'],
				'shipping_postcode'       => $order_query->row['shipping_postcode'],
				'shipping_city'           => $order_query->row['shipping_city'],
				'shipping_zone_id'        => $order_query->row['shipping_zone_id'],
				'shipping_zone'           => $order_query->row['shipping_zone'],
				'shipping_zone_code'      => $shipping_zone_code,
				'shipping_country_id'     => $order_query->row['shipping_country_id'],
				'shipping_country'        => $order_query->row['shipping_country'],
				'shipping_iso_code_2'     => $shipping_iso_code_2,
				'shipping_iso_code_3'     => $shipping_iso_code_3,
				'shipping_address_format' => $order_query->row['shipping_address_format'],
				'shipping_custom_field'   => json_decode($order_query->row['shipping_custom_field'], true),
				'shipping_method'         => $order_query->row['shipping_method'],
				'shipping_code'           => $order_query->row['shipping_code'],
				'comment'                 => $order_query->row['comment'],
				'total'                   => $order_query->row['total'],
				'reward'                  => $reward,
				'order_status_id'         => $order_query->row['order_status_id'],
				'order_status'            => $order_query->row['order_status'],
				'affiliate_id'            => $order_query->row['affiliate_id'],
				'affiliate_firstname'     => $affiliate_firstname,
				'affiliate_lastname'      => $affiliate_lastname,
				'commission'              => $order_query->row['commission'],
				'language_id'             => $order_query->row['language_id'],
				'language_code'           => $language_code,
				'currency_id'             => $order_query->row['currency_id'],
				'currency_code'           => $order_query->row['currency_code'],
				'currency_value'          => $order_query->row['currency_value'],
				'ip'                      => $order_query->row['ip'],
				'forwarded_ip'            => $order_query->row['forwarded_ip'],
				'user_agent'              => $order_query->row['user_agent'],
				'accept_language'         => $order_query->row['accept_language'],
				'date_added'              => $order_query->row['date_added'],
				'date_modified'           => $order_query->row['date_modified']
			);
		} else {
			return;
		}
	}

	public function getOrders($data = array()) {
		
		/*$sql = "SELECT * FROM `" . DB_PREFIX . "order_total` where code LIKE '%sub_total%' AND code LIKE '%total%'"; 
		$query = $this->db->query($sql);
		$rows = $query->rows;
		
		foreach($rows as $row)
		{
			if($row['title'] == 'Sub-Total')
			{
				$title = 'Sub-Total (Excl):';
			}
			else if($row['title'] == 'Total')
			{
				$title = 'Total (Incl):';
			}
			else{
				$title = '';
			}
			
			if($title)
			{
				$sql = "Update `" . DB_PREFIX . "order_total` set title = '".$title."' where order_total_id = '".$row['order_total_id']."'"; 
				$query = $this->db->query($sql);
			}
			
		}*/
		
		if (!empty($data['filter_salesrep_id']) || !empty($data['filter_customer_id']) ) 
		{ 
			$sql = "SELECT o.order_id, (select c.firstname from " . DB_PREFIX . "customer as c where o.customer_id = c.customer_id) AS customer, (select CONCAT(cc.first_name, ' ', cc.last_name) from " . DB_PREFIX . "customer_contact as cc where oq.customer_contact_id = cc.customer_con_id) AS customercontact, (SELECT os.name FROM " . DB_PREFIX . "order_status os WHERE os.order_status_id = o.order_status_id AND os.language_id = '" . (int)$this->config->get('config_language_id') . "') AS order_status, o.shipping_code, o.firstname, o.total, o.currency_code, o.currency_value, o.date_added, o.date_modified FROM `" . DB_PREFIX . "order` o left join oc_customer as c on o.customer_id = c.customer_id";
		}
		else
		{

			$sql = "SELECT o.order_id, (select c.firstname from " . DB_PREFIX . "customer as c where o.customer_id = c.customer_id) AS customer, (select CONCAT(cc.first_name, ' ', cc.last_name) from " . DB_PREFIX . "customer_contact as cc where oq.customer_contact_id = cc.customer_con_id) AS customercontact, (SELECT os.name FROM " . DB_PREFIX . "order_status os WHERE os.order_status_id = o.order_status_id AND os.language_id = '" . (int)$this->config->get('config_language_id') . "') AS order_status, o.shipping_code, o.firstname, o.total, o.currency_code, o.currency_value, o.date_added, o.date_modified FROM `" . DB_PREFIX . "order` o";

		}

		
		
		$sql .= " left join " . DB_PREFIX . "replogic_order_quote oq on o.order_id = oq.order_id";
		
		if (isset($data['filter_order_status'])) {
			$implode = array();

			$order_statuses = explode(',', $data['filter_order_status']);

			foreach ($order_statuses as $order_status_id) {
				$implode[] = "o.order_status_id = '" . (int)$order_status_id . "'";
			}

			if ($implode) {
				$sql .= " WHERE (" . implode(" OR ", $implode) . ")";
			}
		} else {
			$sql .= " WHERE o.order_status_id > '0'";
		}
		
		if (isset($data['filter_customer_contactid'])) {
		
			$sql .= " And oq.customer_contact_id = ".$data['filter_customer_contactid']."";
		
		}

		if (!empty($data['filter_order_id'])) {
			$sql .= " AND o.order_id = '" . (int)$data['filter_order_id'] . "'";
		}
		
		if (!empty($data['filter_salesrep_id'])) {
			$sql .= " AND c.salesrep_id = '" . (int)$data['filter_salesrep_id'] . "'";
		}
		
		if (!empty($data['filter_customer_id'])) {
			$sql .= " AND c.customer_id = '" . (int)$data['filter_customer_id'] . "'";
		}

		if (!empty($data['filter_customer'])) {
			$sql .= " AND CONCAT(o.firstname, ' ', o.lastname) LIKE '%" . $this->db->escape($data['filter_customer']) . "%'";
		}

		if (!empty($data['filter_date_added'])) {
			$sql .= " AND DATE(o.date_added) = DATE('" . $this->db->escape($data['filter_date_added']) . "')";
		}

		if (!empty($data['filter_date_modified'])) {
			$sql .= " AND DATE(o.date_modified) = DATE('" . $this->db->escape($data['filter_date_modified']) . "')";
		}

		if (!empty($data['filter_total'])) {
			$sql .= " AND o.total = '" . (float)$data['filter_total'] . "'";
		}

		$sort_data = array(
			'o.order_id',
			'customer',
			'order_status',
			'o.date_added',
			'o.date_modified',
			'o.total'
		);

		if (isset($data['sort']) && in_array($data['sort'], $sort_data)) {
			$sql .= " ORDER BY " . $data['sort'];
		} else {
			$sql .= " ORDER BY o.order_id";
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
//echo $sql; exit;
		$query = $this->db->query($sql);

		return $query->rows;
	}

	public function getOrderProducts($order_id) {
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "order_product WHERE order_id = '" . (int)$order_id . "'");

		return $query->rows;
	}

	public function getOrderOptions($order_id, $order_product_id) {
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "order_option WHERE order_id = '" . (int)$order_id . "' AND order_product_id = '" . (int)$order_product_id . "'");

		return $query->rows;
	}

	public function getOrderVouchers($order_id) {
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "order_voucher WHERE order_id = '" . (int)$order_id . "'");

		return $query->rows;
	}

	public function getOrderVoucherByVoucherId($voucher_id) {
		$query = $this->db->query("SELECT * FROM `" . DB_PREFIX . "order_voucher` WHERE voucher_id = '" . (int)$voucher_id . "'");

		return $query->row;
	}

	public function getOrderTotals($order_id) {
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "order_total WHERE order_id = '" . (int)$order_id . "' ORDER BY sort_order");

		return $query->rows;
	}

	public function updateOrderStatus($order_id, $order_status_id) {
		$sql = "UPDATE `" . DB_PREFIX . "order` SET order_status_id = '".$order_status_id."', date_modified = NOW() WHERE order_id = '".$order_id."'"; 
		$this->db->query($sql);
	}


	/**
	 * Get total orders [revenue]
	 * @param  array $filters 	an array of filters
	 * @return float          	total orders [revenue]
	 */
	public function getTotalRevenue($filters) {
		$sql = "SELECT SUM(od.total) AS total,IF(cr.symbol_left='',cr.symbol_right,cr.symbol_left) AS currency ";
		$sql.= "FROM ".DB_PREFIX."order od ";
		$sql.= "LEFT JOIN ".DB_PREFIX."customer ct ON ct.customer_id=od.customer_id ";
		$sql.= "LEFT JOIN ".DB_PREFIX."salesrep sr ON sr.salesrep_id=ct.salesrep_id ";
		$sql.= "LEFT JOIN ".DB_PREFIX."team tm on tm.team_id=sr.sales_team_id ";
		$sql.= "LEFT JOIN ".DB_PREFIX."currency cr on cr.currency_id=od.currency_id ";
		$sql.= "WHERE order_status_id=5";

		/*===============================
		=            Filters            =
		===============================*/
		
		switch (TRUE) {
			case (isset($filters['filter_date'])):
				# filter by date...
				$sql .= " AND DATE_FORMAT(od.date_added,'%Y-%m-%d')='".$filters['filter_date']."'";
				break;

			case (isset($filters['filter_month'])):
				# filter by month...
				$sql .= " AND DATE_FORMAT(od.date_added,'%Y-%m')='".$filters['filter_month']."'";
				break;

			case (isset($filters['filter_year'])):
				# filter by year...
				$sql .= " AND DATE_FORMAT(od.date_added,'%Y')='".$filters['filter_year']."'";
				break;

			case (isset($filters['filter_date_from']) && isset($filters['filter_date_to'])):
				# filter by date range...
				$sql .= " AND DATE_FORMAT(od.date_added,'%Y-%m-%d')>='".$filters['filter_date_from']."'";
				$sql .= " AND DATE_FORMAT(od.date_added,'%Y-%m-%d')<='".$filters['filter_date_to']."'";
				break;
		}

		if (isset($filters['filter_user'])) {
			# filter by user [role]...
			$sql .= " AND tm.sales_manager=".$filters['filter_user'];
		}
		
		/*=====  End of Filters  ======*/

		$query = $this->db->query($sql);
		return $query->row;
	}


	/**
	 * Get number of completed orders
	 * @param  array $filters 	an array of filters
	 * @return int          	number of completed orders
	 */
	public function getOrdersInProgressCount($filters) {
		$sql = "SELECT COUNT(*) AS qty FROM ".DB_PREFIX."order od ";
		$sql.= "LEFT JOIN ".DB_PREFIX."customer ct ON ct.customer_id=od.customer_id ";
		$sql.= "LEFT JOIN ".DB_PREFIX."salesrep sr ON sr.salesrep_id=ct.salesrep_id ";
		$sql.= "LEFT JOIN ".DB_PREFIX."team tm on tm.team_id=sr.sales_team_id ";
		$sql.= "WHERE od.order_status_id=2";

		/*===============================
		=            Filters            =
		===============================*/
		
		switch (TRUE) {
			case (isset($filters['filter_date'])):
				# filter by date...
				$sql .= " AND DATE_FORMAT(od.date_added,'%Y-%m-%d')='".$filters['filter_date']."'";
				break;

			case (isset($filters['filter_month'])):
				# filter by month...
				$sql .= " AND DATE_FORMAT(od.date_added,'%Y-%m')='".$filters['filter_month']."'";
				break;

			case (isset($filters['filter_year'])):
				# filter by year...
				$sql .= " AND DATE_FORMAT(od.date_added,'%Y')='".$filters['filter_year']."'";
				break;

			case (isset($filters['filter_date_from']) && isset($filters['filter_date_to'])):
				# filter by date range...
				$sql .= " AND DATE_FORMAT(od.date_added,'%Y-%m-%d')>='".$filters['filter_date_from']."'";
				$sql .= " AND DATE_FORMAT(od.date_added,'%Y-%m-%d')<='".$filters['filter_date_to']."'";
				break;
		}

		if (isset($filters['filter_user'])) {
			# filter by user [role]...
			$sql .= " AND tm.sales_manager=".$filters['filter_user'];
		}
		
		/*=====  End of Filters  ======*/

		$query = $this->db->query($sql);
		return $query->row['qty'];
	}


	/**
	 * Get number of orders
	 * @param  array $filters 	an array of filters
	 * @return int          	number of orders
	 */
	public function getTotalOrdersCount($filters) {
		$sql = "SELECT COUNT(*) AS qty FROM ".DB_PREFIX."order od ";
		$sql.= "LEFT JOIN ".DB_PREFIX."customer ct ON ct.customer_id=od.customer_id ";
		$sql.= "LEFT JOIN ".DB_PREFIX."salesrep sr ON sr.salesrep_id=ct.salesrep_id ";
		$sql.= "LEFT JOIN ".DB_PREFIX."team tm on tm.team_id=sr.sales_team_id ";
		$sql.= "WHERE od.order_status_id > 0";

		/*===============================
		=            Filters            =
		===============================*/
		
		switch (TRUE) {
			case (isset($filters['filter_date'])):
				# filter by date...
				$sql .= " AND DATE_FORMAT(od.date_added,'%Y-%m-%d')='".$filters['filter_date']."'";
				break;

			case (isset($filters['filter_month'])):
				# filter by month...
				$sql .= " AND DATE_FORMAT(od.date_added,'%Y-%m')='".$filters['filter_month']."'";
				break;

			case (isset($filters['filter_year'])):
				# filter by year...
				$sql .= " AND DATE_FORMAT(od.date_added,'%Y')='".$filters['filter_year']."'";
				break;

			case (isset($filters['filter_date_from']) && isset($filters['filter_date_to'])):
				# filter by date range...
				$sql .= " AND DATE_FORMAT(od.date_added,'%Y-%m-%d')>='".$filters['filter_date_from']."'";
				$sql .= " AND DATE_FORMAT(od.date_added,'%Y-%m-%d')<='".$filters['filter_date_to']."'";
				break;
		}

		if (isset($filters['filter_user'])) {
			# filter by user [role]...
			$sql .= " AND tm.sales_manager=".$filters['filter_user'];
		}
		
		/*=====  End of Filters  ======*/

		$query = $this->db->query($sql);
		return $query->row['qty'];
	}


	/**
	 * Get number of completed orders
	 * @param  array $filters 	an array of filters
	 * @return int          	number of completed orders
	 */
	public function getOrdersCompletedCount($filters) {
		$sql = "SELECT COUNT(*) AS qty FROM ".DB_PREFIX."order od ";
		$sql.= "LEFT JOIN ".DB_PREFIX."customer ct ON ct.customer_id=od.customer_id ";
		$sql.= "LEFT JOIN ".DB_PREFIX."salesrep sr ON sr.salesrep_id=ct.salesrep_id ";
		$sql.= "LEFT JOIN ".DB_PREFIX."team tm on tm.team_id=sr.sales_team_id ";
		$sql.= "WHERE od.order_status_id=5";

		/*===============================
		=            Filters            =
		===============================*/
		
		switch (TRUE) {
			case (isset($filters['filter_date'])):
				# filter by date...
				$sql .= " AND DATE_FORMAT(od.date_added,'%Y-%m-%d')='".$filters['filter_date']."'";
				break;

			case (isset($filters['filter_month'])):
				# filter by month...
				$sql .= " AND DATE_FORMAT(od.date_added,'%Y-%m')='".$filters['filter_month']."'";
				break;

			case (isset($filters['filter_year'])):
				# filter by year...
				$sql .= " AND DATE_FORMAT(od.date_added,'%Y')='".$filters['filter_year']."'";
				break;

			case (isset($filters['filter_date_from']) && isset($filters['filter_date_to'])):
				# filter by date range...
				$sql .= " AND DATE_FORMAT(od.date_added,'%Y-%m-%d')>='".$filters['filter_date_from']."'";
				$sql .= " AND DATE_FORMAT(od.date_added,'%Y-%m-%d')<='".$filters['filter_date_to']."'";
				break;
		}

		if (isset($filters['filter_user'])) {
			# filter by user [role]...
			$sql .= " AND tm.sales_manager=".$filters['filter_user'];
		}
		
		/*=====  End of Filters  ======*/

		$query = $this->db->query($sql);
		return $query->row['qty'];
	}


	/**
	 * Get customers by orders
	 * @param  array $filters an array of filters
	 * @return array          an array with customers by orders
	 */
	public function getCustomersByOrders($filters) {
		$sql = "SELECT od.order_id,od.customer_id,SUM(od.total) AS total_value,od.date_added AS last_order_date, ";
		$sql.= "(SELECT cs.firstname FROM ".DB_PREFIX."customer cs WHERE od.customer_id=cs.customer_id) AS customer,od.currency_code,od.currency_value ";
		$sql.= "FROM ".DB_PREFIX."order od ";
		$sql.= "LEFT JOIN ".DB_PREFIX."customer ct ON ct.customer_id=od.customer_id ";
		$sql.= "LEFT JOIN ".DB_PREFIX."salesrep sr ON sr.salesrep_id=ct.salesrep_id ";
		$sql.= "LEFT JOIN ".DB_PREFIX."team tm on tm.team_id=sr.sales_team_id";

		/*===============================
		=            Filters            =
		===============================*/

		$condition = false;
		
		switch (TRUE) {
			case (isset($filters['filter_date'])):
				# filter by date...
				$sql .= " WHERE DATE_FORMAT(od.date_added,'%Y-%m-%d')='".$filters['filter_date']."'";
				$condition = true;
				break;

			case (isset($filters['filter_month'])):
				# filter by month...
				$sql .= " WHERE DATE_FORMAT(od.date_added,'%Y-%m')='".$filters['filter_month']."'";
				$condition = true;
				break;

			case (isset($filters['filter_year'])):
				# filter by year...
				$sql .= " WHERE DATE_FORMAT(od.date_added,'%Y')='".$filters['filter_year']."'";
				$condition = true;
				break;

			case (isset($filters['filter_date_from']) && isset($filters['filter_date_to'])):
				# filter by date range...
				$sql .= " WHERE DATE_FORMAT(od.date_added,'%Y-%m-%d')>='".$filters['filter_date_from']."'";
				$sql .= " AND DATE_FORMAT(od.date_added,'%Y-%m-%d')<='".$filters['filter_date_to']."'";
				$condition = true;
				break;
		}

		if (isset($filters['filter_user'])) {
			# filter by user [role]...
			$sql .= ($condition) ? " AND " : " WHERE ";
			$sql .= "tm.sales_manager=".$filters['filter_user'];
		}

		$sql .= ($condition) ? " AND ct.customer_id != 0 " : " WHERE ct.customer_id != 0 ";
		
		/*=====  End of Filters  ======*/

		$sql.= " GROUP BY od.customer_id ";
		$sql.= " ORDER BY od.order_id DESC";
		$query = $this->db->query($sql);
		return $query->rows;
	}

	public function getTotalOrdersDash($data = array(), $current_user_id) {
		
		$sql = "SELECT COUNT(*) AS total FROM oc_order ord left join oc_customer ct on ct.customer_id = ord.customer_id left join oc_salesrep sr on sr.salesrep_id = ct.salesrep_id left join oc_team tm on tm.team_id = sr.sales_team_id where tm.sales_manager = ".$current_user_id." AND order_status_id > '0'"; 
		
		
		if (!empty($data['filter_date_added'])) {
			$sql .= " AND DATE(ord.date_added) = DATE('" . $this->db->escape($data['filter_date_added']) . "')";
		}

		$query = $this->db->query($sql);

		return $query->row['total'];
	}
	
	public function getTotalOrders($data = array()) {
		
		if (!empty($data['filter_salesrep_id']) || !empty($data['filter_customer_id'])) {
			$sql = "SELECT COUNT(*) AS total FROM `" . DB_PREFIX . "order` o left join oc_customer as c on o.customer_id = c.customer_id";
		} else {
			$sql = "SELECT COUNT(*) AS total FROM `" . DB_PREFIX . "order` o";
		}
		
			$sql .= " left join " . DB_PREFIX . "replogic_order_quote oq on o.order_id = oq.order_id";
		
		if (isset($data['filter_order_status'])) {
			$implode = array();

			$order_statuses = explode(',', $data['filter_order_status']);

			foreach ($order_statuses as $order_status_id) {
				$implode[] = "order_status_id = '" . (int)$order_status_id . "'";
			}

			if ($implode) {
				$sql .= " WHERE (" . implode(" OR ", $implode) . ")";
			}
		} else {
			$sql .= " WHERE order_status_id > '0'";
		}

		if (isset($data['filter_customer_contactid'])) {
		
			$sql .= " And oq.customer_contact_id = ".$data['filter_customer_contactid']."";
		
		}
		
		if (!empty($data['filter_order_id'])) {
			$sql .= " AND o.order_id = '" . (int)$data['filter_order_id'] . "'";
		}
		
		if (!empty($data['filter_salesrep_id'])) {
			$sql .= " AND c.salesrep_id = '" . (int)$data['filter_salesrep_id'] . "'";
		}
		
		if (!empty($data['filter_customer_id'])) {
			$sql .= " AND c.customer_id = '" . (int)$data['filter_customer_id'] . "'";
		}

		if (!empty($data['filter_customer'])) {
			$sql .= " AND CONCAT(o.firstname, ' ', o.lastname) LIKE '%" . $this->db->escape($data['filter_customer']) . "%'";
		}

		if (!empty($data['filter_date_added'])) {
			$sql .= " AND DATE(o.date_added) = DATE('" . $this->db->escape($data['filter_date_added']) . "')";
		}

		if (!empty($data['filter_date_modified'])) {
			$sql .= " AND DATE(o.date_modified) = DATE('" . $this->db->escape($data['filter_date_modified']) . "')";
		}

		if (!empty($data['filter_total'])) {
			$sql .= " AND o.total = '" . (float)$data['filter_total'] . "'";
		}
//echo $sql; exit;
		$query = $this->db->query($sql);

		return $query->row['total'];
	}
	
	public function getTotalOrdersDash2($data = array(), $current_user_id ) {
		
		$sql = "SELECT COUNT(*) AS total FROM oc_order ord left join oc_customer ct on ct.customer_id = ord.customer_id left join oc_salesrep sr on sr.salesrep_id = ct.salesrep_id left join oc_team tm on tm.team_id = sr.sales_team_id where tm.sales_manager = ".$current_user_id." AND order_status_id = '1'"; 
		
		if (!empty($data['filter_date_added'])) {
			$sql .= " AND DATE(ord.date_added) = DATE('" . $this->db->escape($data['filter_date_added']) . "')";
		}
		
		$query = $this->db->query($sql);

		return $query->row['total'];
	}

	public function getTotalOrdersByStoreId($store_id) {
		$query = $this->db->query("SELECT COUNT(*) AS total FROM `" . DB_PREFIX . "order` WHERE store_id = '" . (int)$store_id . "'");

		return $query->row['total'];
	}

	public function getTotalOrdersByOrderStatusId($order_status_id) {
		$query = $this->db->query("SELECT COUNT(*) AS total FROM `" . DB_PREFIX . "order` WHERE order_status_id = '" . (int)$order_status_id . "' AND order_status_id > '0'");

		return $query->row['total'];
	}

	public function getTotalOrdersByProcessingStatus() {
		$implode = array();

		$order_statuses = $this->config->get('config_processing_status');

		foreach ($order_statuses as $order_status_id) {
			$implode[] = "order_status_id = '" . (int)$order_status_id . "'";
		}

		if ($implode) {
			$query = $this->db->query("SELECT COUNT(*) AS total FROM `" . DB_PREFIX . "order` WHERE " . implode(" OR ", $implode));

			return $query->row['total'];
		} else {
			return 0;
		}
	}

	public function getTotalOrdersByCompleteStatus() {
		$implode = array();

		$order_statuses = $this->config->get('config_complete_status');

		foreach ($order_statuses as $order_status_id) {
			$implode[] = "order_status_id = '" . (int)$order_status_id . "'";
		}

		if ($implode) {
			$query = $this->db->query("SELECT COUNT(*) AS total FROM `" . DB_PREFIX . "order` WHERE " . implode(" OR ", $implode) . "");

			return $query->row['total'];
		} else {
			return 0;
		}
	}

	public function getTotalOrdersByLanguageId($language_id) {
		$query = $this->db->query("SELECT COUNT(*) AS total FROM `" . DB_PREFIX . "order` WHERE language_id = '" . (int)$language_id . "' AND order_status_id > '0'");

		return $query->row['total'];
	}

	public function getTotalOrdersByCurrencyId($currency_id) {
		$query = $this->db->query("SELECT COUNT(*) AS total FROM `" . DB_PREFIX . "order` WHERE currency_id = '" . (int)$currency_id . "' AND order_status_id > '0'");

		return $query->row['total'];
	}

	public function createInvoiceNo($order_id) {
		$order_info = $this->getOrder($order_id);

		if ($order_info && !$order_info['invoice_no']) {
			$query = $this->db->query("SELECT MAX(invoice_no) AS invoice_no FROM `" . DB_PREFIX . "order` WHERE invoice_prefix = '" . $this->db->escape($order_info['invoice_prefix']) . "'");

			if ($query->row['invoice_no']) {
				$invoice_no = $query->row['invoice_no'] + 1;
			} else {
				$invoice_no = 1;
			}

			$this->db->query("UPDATE `" . DB_PREFIX . "order` SET invoice_no = '" . (int)$invoice_no . "', invoice_prefix = '" . $this->db->escape($order_info['invoice_prefix']) . "' WHERE order_id = '" . (int)$order_id . "'");

			return $order_info['invoice_prefix'] . $invoice_no;
		}
	}

	public function getOrderHistories($order_id, $start = 0, $limit = 10) {
		if ($start < 0) {
			$start = 0;
		}

		if ($limit < 1) {
			$limit = 10;
		}

		$query = $this->db->query("SELECT oh.date_added, os.name AS status, oh.comment, oh.notify FROM " . DB_PREFIX . "order_history oh LEFT JOIN " . DB_PREFIX . "order_status os ON oh.order_status_id = os.order_status_id WHERE oh.order_id = '" . (int)$order_id . "' AND os.language_id = '" . (int)$this->config->get('config_language_id') . "' ORDER BY oh.date_added ASC LIMIT " . (int)$start . "," . (int)$limit);

		return $query->rows;
	}

	public function getTotalOrderHistories($order_id) {
		$query = $this->db->query("SELECT COUNT(*) AS total FROM " . DB_PREFIX . "order_history WHERE order_id = '" . (int)$order_id . "'");

		return $query->row['total'];
	}

	public function getTotalOrderHistoriesByOrderStatusId($order_status_id) {
		$query = $this->db->query("SELECT COUNT(*) AS total FROM " . DB_PREFIX . "order_history WHERE order_status_id = '" . (int)$order_status_id . "'");

		return $query->row['total'];
	}

	public function getEmailsByProductsOrdered($products, $start, $end) {
		$implode = array();

		foreach ($products as $product_id) {
			$implode[] = "op.product_id = '" . (int)$product_id . "'";
		}

		$query = $this->db->query("SELECT DISTINCT email FROM `" . DB_PREFIX . "order` o LEFT JOIN " . DB_PREFIX . "order_product op ON (o.order_id = op.order_id) WHERE (" . implode(" OR ", $implode) . ") AND o.order_status_id <> '0' LIMIT " . (int)$start . "," . (int)$end);

		return $query->rows;
	}

	public function getTotalEmailsByProductsOrdered($products) {
		$implode = array();

		foreach ($products as $product_id) {
			$implode[] = "op.product_id = '" . (int)$product_id . "'";
		}

		$query = $this->db->query("SELECT DISTINCT email FROM `" . DB_PREFIX . "order` o LEFT JOIN " . DB_PREFIX . "order_product op ON (o.order_id = op.order_id) WHERE (" . implode(" OR ", $implode) . ") AND o.order_status_id <> '0'");

		return $query->row['email'];
	}
	
	public function getQuotesByOrderId($orderid) {
		
		$query = $this->db->query("select * from `" . DB_PREFIX . "replogic_order_quote` where order_id = ".$orderid."");

		return $query->row;
	}
	
}
