<?php
class ModelCustomerCustomer extends Model {
	public function addCustomer($data) {
		
		// Hide Customer Group
		//$data['customer_group_id'] = 1;

		$invited = (isset($this->request->post['send_invitation']) && $this->request->post['send_invitation'] == "yes") ? 1 : 0;
		
		if(isset($data['salesrep_id']))
		{
			$this->db->query("INSERT INTO " . DB_PREFIX . "customer SET customer_group_id = '" . (int)$data['customer_group_id'] . "', salesrep_id = '" . (int)$data['salesrep_id'] . "', firstname = '" . $this->db->escape($data['firstname']) . "', lastname = '" . $this->db->escape($data['firstname']) . "', payment_method = '" . $this->db->escape($data['payment_method']) . "', email = '" . $this->db->escape($data['email']) . "', telephone = '" . $this->db->escape($data['telephone']) . "', fax = '" . $this->db->escape($data['fax']) . "', custom_field = '" . $this->db->escape(isset($data['custom_field']) ? json_encode($data['custom_field']) : '') . "', newsletter = '" . (int)$data['newsletter'] . "', salt = '" . $this->db->escape($salt = token(9)) . "', password = '', status = '" . (int)$data['status'] . "', approved = '" . (int)$data['approved'] . "', safe = '" . (int)$data['safe'] . "', date_added = NOW(), invited = " . (int)$invited);
		
		}
		else
		{
			$this->db->query("INSERT INTO " . DB_PREFIX . "customer SET customer_group_id = '" . (int)$data['customer_group_id'] . "', firstname = '" . $this->db->escape($data['firstname']) . "', lastname = '" . $this->db->escape($data['firstname']) . "', payment_method = '" . $this->db->escape($data['payment_method']) . "', email = '" . $this->db->escape($data['email']) . "', telephone = '" . $this->db->escape($data['telephone']) . "', fax = '" . $this->db->escape($data['fax']) . "', custom_field = '" . $this->db->escape(isset($data['custom_field']) ? json_encode($data['custom_field']) : '') . "', newsletter = '" . (int)$data['newsletter'] . "', salt = '" . $this->db->escape($salt = token(9)) . "', password = '', status = '" . (int)$data['status'] . "', approved = '" . (int)$data['approved'] . "', safe = '" . (int)$data['safe'] . "', date_added = NOW(), invited = " . (int)$invited);
			
		}
		$customer_id = $this->db->getLastId();
		if (isset($data['address'])) {
			$this->load->model('localisation/geo_zone');
			$this->load->model('localisation/country');
			foreach ($data['address'] as $address) {
				
				// Start Get Latitude and Longitude 
					$geo_zone_info = $this->model_localisation_geo_zone->getGeoZone($address['zone_id']);
					$stat_name = $geo_zone_info['name'];
					$country_info = $this->model_localisation_country->getCountry($address['country_id']);
					$county_name = $country_info['name'];
					$customeraddress = $address['address_1']." ".$address['address_2']." ".$address['postcode']." ".$address['city']." ".$stat_name." ".$county_name;
					
					$customerlatitude = '';
					$customerlongitude = '';
					
					$url = "http://maps.google.com/maps/api/geocode/json?address=".urlencode($customeraddress)."&sensor=false&region=India";
					$ch = curl_init();
					curl_setopt($ch, CURLOPT_URL, $url);
					curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
					curl_setopt($ch, CURLOPT_PROXYPORT, 3128);
					curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
					curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
					$response = curl_exec($ch);
					curl_close($ch);
					$response_a = json_decode($response);
					$customerlatitude = $response_a->results[0]->geometry->location->lat;
					$customerlongitude = $response_a->results[0]->geometry->location->lng;
				// End Get Latitude and Longitude 
				
				//Hide the firstname, lastname, company
				$address['firstname'] = '';
				$address['lastname'] = '';
				$address['company'] = '';
				
				//$this->db->query("INSERT INTO " . DB_PREFIX . "address SET customer_id = '" . (int)$customer_id . "', firstname = '" . $this->db->escape($address['firstname']) . "', lastname = '" . $this->db->escape($address['lastname']) . "', company = '" . $this->db->escape($address['company']) . "', address_1 = '" . $this->db->escape($address['address_1']) . "', address_2 = '" . $this->db->escape($address['address_2']) . "', city = '" . $this->db->escape($address['city']) . "', postcode = '" . $this->db->escape($address['postcode']) . "', country_id = '" . (int)$address['country_id'] . "', zone_id = '" . (int)$address['zone_id'] . "', custom_field = '" . $this->db->escape(isset($address['custom_field']) ? json_encode($address['custom_field']) : '') . "', latitude = '" . $customerlatitude . "', longitude = '" . $customerlongitude . "'");
				
				$this->db->query("INSERT INTO " . DB_PREFIX . "address SET customer_id = '" . (int)$customer_id . "', firstname = '" . $this->db->escape($data['firstname']) . "', lastname = '" . $this->db->escape($data['firstname']) . "', company = '" . $this->db->escape($data['firstname']) . "', address_1 = '" . $this->db->escape($address['address_1']) . "', address_2 = '" . $this->db->escape($address['address_2']) . "', city = '" . $this->db->escape($address['city']) . "', postcode = '" . $this->db->escape($address['postcode']) . "', country_id = '" . (int)$address['country_id'] . "', zone_id = '" . (int)$address['zone_id'] . "', custom_field = '" . $this->db->escape(isset($address['custom_field']) ? json_encode($address['custom_field']) : '') . "', latitude = '" . $customerlatitude . "', longitude = '" . $customerlongitude . "'");
				if (isset($address['default'])) {
					$address_id = $this->db->getLastId();
					$this->db->query("UPDATE " . DB_PREFIX . "customer SET address_id = '" . (int)$address_id . "' WHERE customer_id = '" . (int)$customer_id . "'");
				}
			}
		}
		
		return $customer_id;
	}
	public function addCustomerActivity($customer_id, $ip, $data) {
		$this->db->query("INSERT INTO " . DB_PREFIX . "customer_activity SET customer_id = '" . (int)$customer_id . "', `key` = 'customer_invitation', data = '" . $this->db->escape(json_encode($data)) . "', ip = '" . $this->db->escape($ip) . "', date_added = NOW()");
	}
	public function editCustomer($customer_id, $data) { 
		if (!isset($data['custom_field'])) {
			$data['custom_field'] = array();
		}
		
		// Hide Customer Group
		//$data['customer_group_id'] = 1;
		
		if(isset($data['salesrep_id']))
		{ 
			$this->db->query("UPDATE " . DB_PREFIX . "customer SET customer_group_id = '" . (int)$data['customer_group_id'] . "', salesrep_id = '" . (int)$data['salesrep_id'] . "', firstname = '" . $this->db->escape($data['firstname']) . "', lastname = '" . $this->db->escape($data['firstname']) . "', payment_method = '" . $this->db->escape($data['payment_method']) . "', email = '" . $this->db->escape($data['email']) . "', telephone = '" . $this->db->escape($data['telephone']) . "', fax = '" . $this->db->escape($data['fax']) . "', custom_field = '" . $this->db->escape(isset($data['custom_field']) ? json_encode($data['custom_field']) : '') . "', newsletter = '" . (int)$data['newsletter'] . "', status = '" . (int)$data['status'] . "', approved = '" . (int)$data['approved'] . "', safe = '" . (int)$data['safe'] . "' WHERE customer_id = '" . (int)$customer_id . "'");
		
		}
		else
		{
			$this->db->query("UPDATE " . DB_PREFIX . "customer SET customer_group_id = '" . (int)$data['customer_group_id'] . "', firstname = '" . $this->db->escape($data['firstname']) . "', lastname = '" . $this->db->escape($data['firstname']) . "', payment_method = '" . $this->db->escape($data['payment_method']) . "', email = '" . $this->db->escape($data['email']) . "', telephone = '" . $this->db->escape($data['telephone']) . "', fax = '" . $this->db->escape($data['fax']) . "', custom_field = '" . $this->db->escape(isset($data['custom_field']) ? json_encode($data['custom_field']) : '') . "', newsletter = '" . (int)$data['newsletter'] . "', status = '" . (int)$data['status'] . "', approved = '" . (int)$data['approved'] . "', safe = '" . (int)$data['safe'] . "' WHERE customer_id = '" . (int)$customer_id . "'");
		}
		/*if ($data['password']) {
			$this->db->query("UPDATE " . DB_PREFIX . "customer SET salt = '" . $this->db->escape($salt = token(9)) . "', password = '" . $this->db->escape(sha1($salt . sha1($salt . sha1($data['password'])))) . "' WHERE customer_id = '" . (int)$customer_id . "'");
		}*/
		$this->db->query("DELETE FROM " . DB_PREFIX . "address WHERE customer_id = '" . (int)$customer_id . "'");
		if (isset($data['address'])) {
		
			$this->load->model('localisation/geo_zone');
			$this->load->model('localisation/country');
			
			foreach ($data['address'] as $address) {
				if (!isset($address['custom_field'])) {
					$address['custom_field'] = array();
				}
				
				// Start Get Latitude and Longitude 
					$geo_zone_info = $this->model_localisation_geo_zone->getGeoZone($address['zone_id']);
					$stat_name = $geo_zone_info['name'];
					$country_info = $this->model_localisation_country->getCountry($address['country_id']);
					$county_name = $country_info['name'];
					$customeraddress = $address['address_1']." ".$address['address_2']." ".$address['postcode']." ".$address['city']." ".$stat_name." ".$county_name;
					
					$customerlatitude = '';
					$customerlongitude = '';
					
					$url = "http://maps.google.com/maps/api/geocode/json?address=".urlencode($customeraddress)."&sensor=false";
					$ch = curl_init();
					curl_setopt($ch, CURLOPT_URL, $url);
					curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
					curl_setopt($ch, CURLOPT_PROXYPORT, 3128);
					curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
					curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
					$response = curl_exec($ch);
					curl_close($ch);
					$response_a = json_decode($response);
					$customerlatitude = $response_a->results[0]->geometry->location->lat;
					$customerlongitude = $response_a->results[0]->geometry->location->lng;
					
				// End Get Latitude and Longitude 
				
				//$this->db->query("INSERT INTO " . DB_PREFIX . "address SET address_id = '" . (int)$address['address_id'] . "', customer_id = '" . (int)$customer_id . "', firstname = '" . $this->db->escape($address['firstname']) . "', lastname = '" . $this->db->escape($address['lastname']) . "', company = '" . $this->db->escape($address['company']) . "', address_1 = '" . $this->db->escape($address['address_1']) . "', address_2 = '" . $this->db->escape($address['address_2']) . "', city = '" . $this->db->escape($address['city']) . "', postcode = '" . $this->db->escape($address['postcode']) . "', country_id = '" . (int)$address['country_id'] . "', zone_id = '" . (int)$address['zone_id'] . "', custom_field = '" . $this->db->escape(isset($address['custom_field']) ? json_encode($address['custom_field']) : '') . "', latitude = '" . $customerlatitude . "', longitude = '" . $customerlongitude . "'");
				
				$this->db->query("INSERT INTO " . DB_PREFIX . "address SET address_id = '" . (int)$address['address_id'] . "', customer_id = '" . (int)$customer_id . "', firstname = '" . $this->db->escape($data['firstname']) . "', lastname = '" . $this->db->escape($data['firstname']) . "', company = '" . $this->db->escape($data['firstname']) . "', address_1 = '" . $this->db->escape($address['address_1']) . "', address_2 = '" . $this->db->escape($address['address_2']) . "', city = '" . $this->db->escape($address['city']) . "', postcode = '" . $this->db->escape($address['postcode']) . "', country_id = '" . (int)$address['country_id'] . "', zone_id = '" . (int)$address['zone_id'] . "', custom_field = '" . $this->db->escape(isset($address['custom_field']) ? json_encode($address['custom_field']) : '') . "', latitude = '" . $customerlatitude . "', longitude = '" . $customerlongitude . "'");
				if (isset($address['default'])) {
					$address_id = $this->db->getLastId();
					$this->db->query("UPDATE " . DB_PREFIX . "customer SET address_id = '" . (int)$address_id . "' WHERE customer_id = '" . (int)$customer_id . "'");
				}
			}
		}
	}
	public function updateCustomerPassword($customer_id, $password) {
		$this->db->query("UPDATE " . DB_PREFIX . "customer SET salt = '" . $this->db->escape($salt = token(9)) . "', password = '" . $this->db->escape(sha1($salt . sha1($salt . sha1($password)))) . "', invited = 1, prompt_change_password = 1 WHERE customer_id = '" . (int)$customer_id . "'");
	}
	public function editToken($customer_id, $token) {
		$this->db->query("UPDATE " . DB_PREFIX . "customer SET token = '" . $this->db->escape($token) . "' WHERE customer_id = '" . (int)$customer_id . "'");
	}
	public function deleteCustomer($customer_id) {
		$this->db->query("DELETE FROM " . DB_PREFIX . "customer WHERE customer_id = '" . (int)$customer_id . "'");
		$this->db->query("DELETE FROM " . DB_PREFIX . "customer_activity WHERE customer_id = '" . (int)$customer_id . "'");
		$this->db->query("DELETE FROM " . DB_PREFIX . "customer_reward WHERE customer_id = '" . (int)$customer_id . "'");
		$this->db->query("DELETE FROM " . DB_PREFIX . "customer_transaction WHERE customer_id = '" . (int)$customer_id . "'");
		$this->db->query("DELETE FROM " . DB_PREFIX . "customer_ip WHERE customer_id = '" . (int)$customer_id . "'");
		$this->db->query("DELETE FROM " . DB_PREFIX . "address WHERE customer_id = '" . (int)$customer_id . "'");
	}
	public function getCustomer($customer_id) { 
		$query = $this->db->query("SELECT DISTINCT * FROM " . DB_PREFIX . "customer WHERE customer_id = '" . (int)$customer_id . "'");
		return $query->row;
	}
	public function getCustomerByEmail($email) {
		$query = $this->db->query("SELECT DISTINCT * FROM " . DB_PREFIX . "customer WHERE LCASE(email) = '" . $this->db->escape(utf8_strtolower($email)) . "'");
		return $query->row;
	}
	public function getCustomers($data = array(), $allaccess=false, $current_user_id) {
		
		if($allaccess)
		{
			$sql = "SELECT c.*, CONCAT(c.firstname) AS name, cgd.name AS customer_group, ca.key, (SELECT ca.data FROM oc_customer_activity ca WHERE ca.customer_id = c.customer_id ORDER BY ca.customer_activity_id DESC LIMIT 0,1) AS customer_activity, MAX(ca.date_added) AS last_activity_date FROM " . DB_PREFIX . "customer c LEFT JOIN " . DB_PREFIX . "customer_group_description cgd ON (c.customer_group_id = cgd.customer_group_id) LEFT JOIN " . DB_PREFIX . "customer_activity ca ON ca.customer_id = c.customer_id AND ca.key = 'login' LEFT JOIN oc_salesrep sr on sr.salesrep_id = c.salesrep_id LEFT JOIN oc_team tm on tm.team_id = sr.sales_team_id WHERE tm.sales_manager = '".$current_user_id."' and cgd.language_id = '" . (int)$this->config->get('config_language_id') . "'";
			
		} else {
			$sql = "SELECT c.*, CONCAT(c.firstname) AS name, cgd.name AS customer_group, ca.key, (SELECT ca.data FROM oc_customer_activity ca WHERE ca.customer_id = c.customer_id ORDER BY ca.customer_activity_id DESC LIMIT 0,1) AS customer_activity, MAX(ca.date_added) AS last_activity_date FROM " . DB_PREFIX . "customer c LEFT JOIN " . DB_PREFIX . "customer_group_description cgd ON (c.customer_group_id = cgd.customer_group_id) LEFT JOIN " . DB_PREFIX . "customer_activity ca ON ca.customer_id = c.customer_id AND ca.key = 'login' LEFT JOIN oc_salesrep sr on sr.salesrep_id = c.salesrep_id WHERE cgd.language_id = '" . (int)$this->config->get('config_language_id') . "'";
		}
		$implode = array();
		if (!empty($data['filter_name'])) {
			$implode[] = "CONCAT(c.firstname, ' ', c.lastname) LIKE '%" . $this->db->escape($data['filter_name']) . "%'";
		}
		if (!empty($data['filter_email'])) {
			$implode[] = "c.email LIKE '" . $this->db->escape($data['filter_email']) . "%'";
		}
		if (isset($data['filter_newsletter']) && !is_null($data['filter_newsletter'])) {
			$implode[] = "c.newsletter = '" . (int)$data['filter_newsletter'] . "'";
		}
		if (!empty($data['filter_customer_group_id'])) {
			$implode[] = "c.customer_group_id = '" . (int)$data['filter_customer_group_id'] . "'";
		}
		
		if (!empty($data['filter_salesrep_id'])) {
			$implode[] = "c.salesrep_id = '" . (int)$data['filter_salesrep_id'] . "'";
		}
		
		if (!empty($data['filter_team_id'])) {
			$implode[] = "sr.sales_team_id = '" . (int)$data['filter_team_id'] . "'";
		}
		
		if (!empty($data['filter_customer_id'])) {
			$implode[] = "c.customer_id = '" . (int)$data['filter_customer_id'] . "'";
		}
		
		if (!empty($data['filter_email_id'])) {
			$implode[] = "c.customer_id = '" . (int)$data['filter_email_id'] . "'";
		}
		if (!empty($data['filter_ip'])) {
			$implode[] = "c.customer_id IN (SELECT customer_id FROM " . DB_PREFIX . "customer_ip WHERE ip = '" . $this->db->escape($data['filter_ip']) . "')";
		}
		if (isset($data['filter_status']) && !is_null($data['filter_status'])) {
			$implode[] = "c.status = '" . (int)$data['filter_status'] . "'";
		}
		if (isset($data['filter_approved']) && !is_null($data['filter_approved'])) {
			$implode[] = "c.approved = '" . (int)$data['filter_approved'] . "'";
		}
		if (isset($data['filter_wholesale']) && !is_null($data['filter_wholesale'])) {
			$implode[] = "c.invited = '" . (int)$data['filter_wholesale'] . "'";
		}
		if (!empty($data['filter_date_added'])) {
			$implode[] = "DATE(c.date_added) = DATE('" . $this->db->escape($data['filter_date_added']) . "')";
		}
		if ($implode) {
			$sql .= " AND " . implode(" AND ", $implode);
		}
		$sort_data = array(
			'name',
			'c.email',
			'customer_group',
			'c.status',
			'c.approved',
			'c.ip',
			'c.date_added'
		);
		$sql .= " GROUP BY c.customer_id";
		if (isset($data['sort']) && in_array($data['sort'], $sort_data)) {
			$sql .= " ORDER BY " . $data['sort'];
		} else {
			$sql .= " ORDER BY name";
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
		} else {
		}
		$query = $this->db->query($sql);
		return $query->rows;
	}
	public function getProspectiveCustomer($prospect_id) { 
		$query = $this->db->query("SELECT DISTINCT p.*, p.prospect_id AS customer_id, p.name AS firstname FROM " . DB_PREFIX . "prospective_customer p WHERE p.prospect_id = " . (int)$prospect_id);
		return $query->row;
	}
	
	public function getProspectiveCustomers($data = array()) {

		$sql  = "SELECT p.*, p.prospect_id AS customer_id, p.name AS firstname FROM " . DB_PREFIX . "prospective_customer p ";
		$sql .= "INNER JOIN " . DB_PREFIX . "salesrep_checkins c on c.customer_id = p.prospect_id ";
		$sql .= "INNER JOIN " . DB_PREFIX . "appointment a on a.appointment_id = c.appointment_id ";
		$sql .= "LEFT JOIN " . DB_PREFIX . "salesrep sr on sr.salesrep_id = c.salesrep_id ";
		$sql .= "WHERE a.type = 'New Business' ";
		
		$implode = array();

		if (!empty($data['filter_name'])) {
			$implode[] = "CONCAT(c.firstname, ' ', c.lastname) LIKE '%" . $this->db->escape($data['filter_name']) . "%'";
		}
		
		if (!empty($data['filter_salesrep_id'])) {
			$implode[] = "c.salesrep_id = '" . (int)$data['filter_salesrep_id'] . "'";
		}
		
		if (!empty($data['filter_team_id'])) {
			$implode[] = "sr.sales_team_id = '" . (int)$data['filter_team_id'] . "'";
		}
		
		if (!empty($data['filter_customer_id'])) {
			$implode[] = "p.prospect_id = '" . (int)$data['filter_customer_id'] . "'";
		}
		
		if (!empty($data['filter_date_added'])) {
			$implode[] = "DATE(p.created) = DATE('" . $this->db->escape($data['filter_date_added']) . "')";
		}

		if ($implode) {
			$sql .= " AND " . implode(" AND ", $implode);
		}

		$sort_data = array(
			'name',
			'p.created'
		);
		$sql .= " GROUP BY p.prospect_id";

		if (isset($data['sort']) && in_array($data['sort'], $sort_data)) {
			$sql .= " ORDER BY " . $data['sort'];
		} else {
			$sql .= " ORDER BY name";
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
	
	public function getCustomersCustomerExportImport($min,$max) {
		
		$sql = "SELECT c.customer_id AS customer_id, c.firstname AS firstname, c.lastname AS lastname, c.payment_method AS payment_method, c.email AS email, c.telephone AS telephone, c.newsletter AS newsletter, c.status AS status, c.approved AS approved, c.address_id AS address_id, c.password AS password, cgd.name AS customer_group, ad.company AS companyname, ad.address_1 AS address_1, ad.address_2 AS address_2, ad.city AS city, ad.postcode AS postcode, CONCAT(sr.salesrep_name, ' ', sr.salesrep_lastname) AS salesrep, tm.team_name AS salesteam, co.name as country, zn.name as region FROM " . DB_PREFIX . "customer c LEFT JOIN " . DB_PREFIX . "customer_group_description cgd ON (c.customer_group_id = cgd.customer_group_id) left join ".DB_PREFIX."salesrep sr ON (c.salesrep_id = sr.salesrep_id) left join ".DB_PREFIX."address ad ON (c.address_id = ad.address_id) left join ".DB_PREFIX."country co on (ad.country_id = co.country_id) left join ".DB_PREFIX."zone zn on (ad.zone_id = zn.zone_id) left join ".DB_PREFIX."team as tm ON (sr.sales_team_id = tm.team_id) WHERE cgd.language_id = '" . (int)$this->config->get('config_language_id') . "'";
		
		if($min !='' && $max != '')
		{
			$sql .= " and c.customer_id BETWEEN ".$min." AND ".$max."";
		}
		
		$sql .= " order by c.customer_id ASC";
		//echo $sql; exit;
		$query = $this->db->query($sql);
		return $query->rows;
		
	
	}
	public function approve($customer_id) {
		$customer_info = $this->getCustomer($customer_id);
		if ($customer_info) {
			$this->db->query("UPDATE " . DB_PREFIX . "customer SET approved = '1' WHERE customer_id = '" . (int)$customer_id . "'");
			$this->load->model('setting/store');
			$store_info = $this->model_setting_store->getStore($customer_info['store_id']);
			if ($store_info) {
				$store_name = $store_info['name'];
				$store_url = $store_info['url'] . 'index.php?route=account/login';
			} else {
				$store_name = $this->config->get('config_name');
				$store_url = HTTP_CATALOG . 'index.php?route=account/login';
			}
			$this->load->model('localisation/language');
			
			$language_info = $this->model_localisation_language->getLanguage($customer_info['language_id']);
			if ($language_info) {
				$language_code = $language_info['code'];
			} else {
				$language_code = $this->config->get('config_language');
			}
			$language = new Language($language_code);
			$language->load($language_code);
			$language->load('mail/customer');
				
			$message  = sprintf($language->get('text_approve_welcome'), html_entity_decode($store_name, ENT_QUOTES, 'UTF-8')) . "\n\n";
			$message .= $language->get('text_approve_login') . "\n";
			$message .= $store_url . "\n\n";
			$message .= $language->get('text_approve_services') . "\n\n";
			$message .= $language->get('text_approve_thanks') . "\n";
			$message .= html_entity_decode($store_name, ENT_QUOTES, 'UTF-8');
			$mail = new Mail();
			$mail->protocol = $this->config->get('config_mail_protocol');
			$mail->parameter = $this->config->get('config_mail_parameter');
			$mail->smtp_hostname = $this->config->get('config_mail_smtp_hostname');
			$mail->smtp_username = $this->config->get('config_mail_smtp_username');
			$mail->smtp_password = html_entity_decode($this->config->get('config_mail_smtp_password'), ENT_QUOTES, 'UTF-8');
			$mail->smtp_port = $this->config->get('config_mail_smtp_port');
			$mail->smtp_timeout = $this->config->get('config_mail_smtp_timeout');
			$mail->setTo($customer_info['email']);
			$mail->setFrom($this->config->get('config_email'));
			$mail->setSender(html_entity_decode($store_name, ENT_QUOTES, 'UTF-8'));
			$mail->setSubject(sprintf($language->get('text_approve_subject'), html_entity_decode($store_name, ENT_QUOTES, 'UTF-8')));
			$mail->setText($message);
			$mail->send();
		}
	}
	public function getAddress($address_id) {
		$address_query = $this->db->query("SELECT * FROM " . DB_PREFIX . "address WHERE address_id = '" . (int)$address_id . "'");
		if ($address_query->num_rows) {
			$country_query = $this->db->query("SELECT * FROM `" . DB_PREFIX . "country` WHERE country_id = '" . (int)$address_query->row['country_id'] . "'");
			if ($country_query->num_rows) {
				$country = $country_query->row['name'];
				$iso_code_2 = $country_query->row['iso_code_2'];
				$iso_code_3 = $country_query->row['iso_code_3'];
				$address_format = $country_query->row['address_format'];
			} else {
				$country = '';
				$iso_code_2 = '';
				$iso_code_3 = '';
				$address_format = '';
			}
			$zone_query = $this->db->query("SELECT * FROM `" . DB_PREFIX . "zone` WHERE zone_id = '" . (int)$address_query->row['zone_id'] . "'");
			if ($zone_query->num_rows) {
				$zone = $zone_query->row['name'];
				$zone_code = $zone_query->row['code'];
			} else {
				$zone = '';
				$zone_code = '';
			}
			return array(
				'address_id'     => $address_query->row['address_id'],
				'customer_id'    => $address_query->row['customer_id'],
				'firstname'      => $address_query->row['firstname'],
				'lastname'       => $address_query->row['lastname'],
				'company'        => $address_query->row['company'],
				'address_1'      => $address_query->row['address_1'],
				'address_2'      => $address_query->row['address_2'],
				'postcode'       => $address_query->row['postcode'],
				'city'           => $address_query->row['city'],
				'zone_id'        => $address_query->row['zone_id'],
				'zone'           => $zone,
				'zone_code'      => $zone_code,
				'country_id'     => $address_query->row['country_id'],
				'country'        => $country,
				'iso_code_2'     => $iso_code_2,
				'iso_code_3'     => $iso_code_3,
				'address_format' => $address_format,
				'custom_field'   => json_decode($address_query->row['custom_field'], true),
				'latitude'      => $address_query->row['latitude'],
				'longitude'      => $address_query->row['longitude']
			);
		}
	}
	public function getAddresses($customer_id) {
		$address_data = array();
		$query = $this->db->query("SELECT address_id FROM " . DB_PREFIX . "address WHERE customer_id = '" . (int)$customer_id . "'");
		foreach ($query->rows as $result) {
			$address_info = $this->getAddress($result['address_id']);
			if ($address_info) {
				$address_data[$result['address_id']] = $address_info;
			}
		}
		return $address_data;
	}
	public function getTotalCustomersDash($data = array(), $current_user_id) { 
		
		$sql = "SELECT COUNT(*) AS total FROM oc_customer ap left join oc_salesrep sr on sr.salesrep_id = ap.salesrep_id left join oc_team tm on tm.team_id = sr.sales_team_id"; 
		
		$implode = array();
		
		$implode[] = "tm.sales_manager = '" . $current_user_id . "'";
		
		if (!empty($data['filter_date_added'])) {
			$implode[] = "DATE(date_added) = DATE('" . $this->db->escape($data['filter_date_added']) . "')";
		}
		
		if (isset($data['filter_approved']) && !is_null($data['filter_approved'])) {
			$implode[] = "approved = 0";
		}
		if ($implode) {
			$sql .= " WHERE " . implode(" AND ", $implode);
		}
	//echo $sql; exit;		
		$query = $this->db->query($sql);
		return $query->row['total'];
	}
	
	public function getTotalCustomers($data = array(), $allaccess=false, $current_user_id=null) {
		
		$implode = array();
		if($allaccess)
		{
			$sql = "SELECT COUNT(*) AS total FROM " . DB_PREFIX . "customer ap left join oc_salesrep sr on sr.salesrep_id = ap.salesrep_id left join oc_team tm on tm.team_id = sr.sales_team_id";
			$implode[] = "tm.sales_manager = '" . $current_user_id . "'";
			if (!empty($data['filter_salesrep_id'])) {
				$implode[] = "ap.salesrep_id = '" . (int)$data['filter_salesrep_id'] . "'";
			}
		}
		else
		{
			$sql = "SELECT COUNT(*) AS total FROM " . DB_PREFIX . "customer";
			
			if (!empty($data['filter_salesrep_id'])) {
				$implode[] = "salesrep_id = '" . (int)$data['filter_salesrep_id'] . "'";
			}
			
		}
		if (!empty($data['filter_name'])) {
			$implode[] = "CONCAT(firstname, ' ', lastname) LIKE '%" . $this->db->escape($data['filter_name']) . "%'";
		}
		
		if (!empty($data['filter_customer_id'])) {
			$implode[] = "customer_id = '" . (int)$data['filter_customer_id'] . "'";
		}
		
		if (!empty($data['filter_email_id'])) {
			$implode[] = "customer_id = '" . (int)$data['filter_email_id'] . "'";
		}
		if (!empty($data['filter_email'])) {
			$implode[] = "email LIKE '" . $this->db->escape($data['filter_email']) . "%'";
		}
		
		if (isset($data['filter_newsletter']) && !is_null($data['filter_newsletter'])) {
			$implode[] = "newsletter = '" . (int)$data['filter_newsletter'] . "'";
		}
		if (!empty($data['filter_customer_group_id'])) {
			$implode[] = "customer_group_id = '" . (int)$data['filter_customer_group_id'] . "'";
		}
		if (!empty($data['filter_ip'])) {
			$implode[] = "customer_id IN (SELECT customer_id FROM " . DB_PREFIX . "customer_ip WHERE ip = '" . $this->db->escape($data['filter_ip']) . "')";
		}
		if (isset($data['filter_status']) && !is_null($data['filter_status'])) {
			$implode[] = "status = '" . (int)$data['filter_status'] . "'";
		}
		if (isset($data['filter_approved']) && !is_null($data['filter_approved'])) {
			$implode[] = "approved = '" . (int)$data['filter_approved'] . "'";
		}
		if (!empty($data['filter_date_added'])) { 
			$implode[] = "DATE(date_added) = DATE('" . $this->db->escape($data['filter_date_added']) . "')";
		}
		if ($implode) {
			$sql .= " WHERE " . implode(" AND ", $implode);
		}
//echo $sql; exit;
		$query = $this->db->query($sql);
		return $query->row['total'];
	}
	public function getTotalCustomersAwaitingApproval() {
		$query = $this->db->query("SELECT COUNT(*) AS total FROM " . DB_PREFIX . "customer WHERE status = '0' OR approved = '0'");
		return $query->row['total'];
	}
	public function getTotalAddressesByCustomerId($customer_id) {
		$query = $this->db->query("SELECT COUNT(*) AS total FROM " . DB_PREFIX . "address WHERE customer_id = '" . (int)$customer_id . "'");
		return $query->row['total'];
	}
	public function getTotalAddressesByCountryId($country_id) {
		$query = $this->db->query("SELECT COUNT(*) AS total FROM " . DB_PREFIX . "address WHERE country_id = '" . (int)$country_id . "'");
		return $query->row['total'];
	}
	public function getTotalAddressesByZoneId($zone_id) {
		$query = $this->db->query("SELECT COUNT(*) AS total FROM " . DB_PREFIX . "address WHERE zone_id = '" . (int)$zone_id . "'");
		return $query->row['total'];
	}
	public function getTotalCustomersByCustomerGroupId($customer_group_id) {
		$query = $this->db->query("SELECT COUNT(*) AS total FROM " . DB_PREFIX . "customer WHERE customer_group_id = '" . (int)$customer_group_id . "'");
		return $query->row['total'];
	}
	public function addHistory($customer_id, $comment) {
		$this->db->query("INSERT INTO " . DB_PREFIX . "customer_history SET customer_id = '" . (int)$customer_id . "', comment = '" . $this->db->escape(strip_tags($comment)) . "', date_added = NOW()");
	}
	public function getHistories($customer_id, $start = 0, $limit = 10) {
		if ($start < 0) {
			$start = 0;
		}
		if ($limit < 1) {
			$limit = 10;
		}
		$query = $this->db->query("SELECT comment, date_added FROM " . DB_PREFIX . "customer_history WHERE customer_id = '" . (int)$customer_id . "' ORDER BY date_added DESC LIMIT " . (int)$start . "," . (int)$limit);
		return $query->rows;
	}
	public function getTotalHistories($customer_id) {
		$query = $this->db->query("SELECT COUNT(*) AS total FROM " . DB_PREFIX . "customer_history WHERE customer_id = '" . (int)$customer_id . "'");
		return $query->row['total'];
	}
	public function addTransaction($customer_id, $description = '', $amount = '', $order_id = 0) {
		$customer_info = $this->getCustomer($customer_id);
		if ($customer_info) {
			$this->db->query("INSERT INTO " . DB_PREFIX . "customer_transaction SET customer_id = '" . (int)$customer_id . "', order_id = '" . (int)$order_id . "', description = '" . $this->db->escape($description) . "', amount = '" . (float)$amount . "', date_added = NOW()");
			$this->load->language('mail/customer');
			$this->load->model('setting/store');
			$store_info = $this->model_setting_store->getStore($customer_info['store_id']);
			if ($store_info) {
				$store_name = $store_info['name'];
			} else {
				$store_name = $this->config->get('config_name');
			}
			$message  = sprintf($this->language->get('text_transaction_received'), $this->currency->format($amount, $this->config->get('config_currency'))) . "\n\n";
			$message .= sprintf($this->language->get('text_transaction_total'), $this->currency->format($this->getTransactionTotal($customer_id), $this->session->data['currency']));
			$mail = new Mail();
			$mail->protocol = $this->config->get('config_mail_protocol');
			$mail->parameter = $this->config->get('config_mail_parameter');
			$mail->smtp_hostname = $this->config->get('config_mail_smtp_hostname');
			$mail->smtp_username = $this->config->get('config_mail_smtp_username');
			$mail->smtp_password = html_entity_decode($this->config->get('config_mail_smtp_password'), ENT_QUOTES, 'UTF-8');
			$mail->smtp_port = $this->config->get('config_mail_smtp_port');
			$mail->smtp_timeout = $this->config->get('config_mail_smtp_timeout');
			$mail->setTo($customer_info['email']);
			$mail->setFrom($this->config->get('config_email'));
			$mail->setSender(html_entity_decode($store_name, ENT_QUOTES, 'UTF-8'));
			$mail->setSubject(sprintf($this->language->get('text_transaction_subject'), html_entity_decode($this->config->get('config_name'), ENT_QUOTES, 'UTF-8')));
			$mail->setText($message);
			$mail->send();
		}
	}
	public function deleteTransaction($order_id) {
		$this->db->query("DELETE FROM " . DB_PREFIX . "customer_transaction WHERE order_id = '" . (int)$order_id . "'");
	}
	public function getTransactions($customer_id, $start = 0, $limit = 10) {
		if ($start < 0) {
			$start = 0;
		}
		if ($limit < 1) {
			$limit = 10;
		}
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "customer_transaction WHERE customer_id = '" . (int)$customer_id . "' ORDER BY date_added DESC LIMIT " . (int)$start . "," . (int)$limit);
		return $query->rows;
	}
	public function getTotalTransactions($customer_id) {
		$query = $this->db->query("SELECT COUNT(*) AS total  FROM " . DB_PREFIX . "customer_transaction WHERE customer_id = '" . (int)$customer_id . "'");
		return $query->row['total'];
	}
	public function getTransactionTotal($customer_id) {
		$query = $this->db->query("SELECT SUM(amount) AS total FROM " . DB_PREFIX . "customer_transaction WHERE customer_id = '" . (int)$customer_id . "'");
		return $query->row['total'];
	}
	public function getTotalTransactionsByOrderId($order_id) {
		$query = $this->db->query("SELECT COUNT(*) AS total FROM " . DB_PREFIX . "customer_transaction WHERE order_id = '" . (int)$order_id . "'");
		return $query->row['total'];
	}
	public function addReward($customer_id, $description = '', $points = '', $order_id = 0) {
		$customer_info = $this->getCustomer($customer_id);
		if ($customer_info) {
			$this->db->query("INSERT INTO " . DB_PREFIX . "customer_reward SET customer_id = '" . (int)$customer_id . "', order_id = '" . (int)$order_id . "', points = '" . (int)$points . "', description = '" . $this->db->escape($description) . "', date_added = NOW()");
			$this->load->language('mail/customer');
			$this->load->model('setting/store');
			$store_info = $this->model_setting_store->getStore($customer_info['store_id']);
			if ($store_info) {
				$store_name = $store_info['name'];
			} else {
				$store_name = $this->config->get('config_name');
			}
			$message  = sprintf($this->language->get('text_reward_received'), $points) . "\n\n";
			$message .= sprintf($this->language->get('text_reward_total'), $this->getRewardTotal($customer_id));
			$mail = new Mail();
			$mail->protocol = $this->config->get('config_mail_protocol');
			$mail->parameter = $this->config->get('config_mail_parameter');
			$mail->smtp_hostname = $this->config->get('config_mail_smtp_hostname');
			$mail->smtp_username = $this->config->get('config_mail_smtp_username');
			$mail->smtp_password = html_entity_decode($this->config->get('config_mail_smtp_password'), ENT_QUOTES, 'UTF-8');
			$mail->smtp_port = $this->config->get('config_mail_smtp_port');
			$mail->smtp_timeout = $this->config->get('config_mail_smtp_timeout');
			$mail->setTo($customer_info['email']);
			$mail->setFrom($this->config->get('config_email'));
			$mail->setSender(html_entity_decode($store_name, ENT_QUOTES, 'UTF-8'));
			$mail->setSubject(sprintf($this->language->get('text_reward_subject'), html_entity_decode($store_name, ENT_QUOTES, 'UTF-8')));
			$mail->setText($message);
			$mail->send();
		}
	}
	public function deleteReward($order_id) {
		$this->db->query("DELETE FROM " . DB_PREFIX . "customer_reward WHERE order_id = '" . (int)$order_id . "' AND points > 0");
	}
	public function getRewards($customer_id, $start = 0, $limit = 10) {
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "customer_reward WHERE customer_id = '" . (int)$customer_id . "' ORDER BY date_added DESC LIMIT " . (int)$start . "," . (int)$limit);
		return $query->rows;
	}
	public function getTotalRewards($customer_id) {
		$query = $this->db->query("SELECT COUNT(*) AS total FROM " . DB_PREFIX . "customer_reward WHERE customer_id = '" . (int)$customer_id . "'");
		return $query->row['total'];
	}
	public function getRewardTotal($customer_id) {
		$query = $this->db->query("SELECT SUM(points) AS total FROM " . DB_PREFIX . "customer_reward WHERE customer_id = '" . (int)$customer_id . "'");
		return $query->row['total'];
	}
	public function getTotalCustomerRewardsByOrderId($order_id) {
		$query = $this->db->query("SELECT COUNT(*) AS total FROM " . DB_PREFIX . "customer_reward WHERE order_id = '" . (int)$order_id . "' AND points > 0");
		return $query->row['total'];
	}
	public function getIps($customer_id, $start = 0, $limit = 10) {
		if ($start < 0) {
			$start = 0;
		}
		if ($limit < 1) {
			$limit = 10;
		}
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "customer_ip WHERE customer_id = '" . (int)$customer_id . "' ORDER BY date_added DESC LIMIT " . (int)$start . "," . (int)$limit);
		
		return $query->rows;
	}
	public function getTotalIps($customer_id) {
		$query = $this->db->query("SELECT COUNT(*) AS total FROM " . DB_PREFIX . "customer_ip WHERE customer_id = '" . (int)$customer_id . "'");
		return $query->row['total'];
	}
	public function getTotalCustomersByIp($ip) {
		$query = $this->db->query("SELECT COUNT(*) AS total FROM " . DB_PREFIX . "customer_ip WHERE ip = '" . $this->db->escape($ip) . "'");
		return $query->row['total'];
	}
	public function getTotalLoginAttempts($email) {
		$query = $this->db->query("SELECT * FROM `" . DB_PREFIX . "customer_login` WHERE `email` = '" . $this->db->escape($email) . "'");
		return $query->row;
	}
	public function deleteLoginAttempts($email) {
		$this->db->query("DELETE FROM `" . DB_PREFIX . "customer_login` WHERE `email` = '" . $this->db->escape($email) . "'");
	}
	
	public function getCustomerBySalesRep($salesrep_id) { 
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "customer WHERE salesrep_id = '" . (int)$salesrep_id . "'");
		return $query->rows;
	}
	
	public function getCustomerAddressDefault($customer_id) { 
	
	$query = $this->db->query("SELECT *, CONCAT(ad.address_1, ' ', ad.address_2) as address FROM " . DB_PREFIX . "customer as cs left join oc_address ad on (cs.address_id = ad.address_id) where cs.customer_id = ".$customer_id."");
		return $query->row;
	}
	
	public function addnewaddress($data) { 
	
	$query = $this->db->query("INSERT INTO " . DB_PREFIX . "address SET customer_id = '" . $this->db->escape($data['customer_id']) . "', firstname = '" . $this->db->escape($data['firstname']) . "', lastname = '" . $this->db->escape($data['firstname']) . "', company = '" . $this->db->escape($data['firstname']) . "', address_1 = '" . $this->db->escape($data['address_1']) . "', address_2 = '" . $this->db->escape($data['address_2']) . "', city = '" . $this->db->escape($data['city']) . "', postcode = '" . $this->db->escape($data['postcode']) . "', country_id = '" . (int)$data['country_id'] . "', zone_id = '" . (int)$data['zone_id'] . "'");
		$add_id = $this->db->getLastId();
		return $add_id;
	}
	
}