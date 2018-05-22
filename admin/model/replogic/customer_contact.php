<?php
class ModelReplogicCustomerContact extends Model {
	public function addCustomercontact($data) {
		$this->db->query("INSERT INTO " . DB_PREFIX . "customer_contact SET first_name = '" . $this->db->escape($data['first_name']) . "', last_name = '" . $this->db->escape($data['last_name']) . "',email = '" . $this->db->escape($data['email']) . "', telephone_number = '" . $this->db->escape($data['telephone_number']) . "',cellphone_number = '" . $this->db->escape($data['cellphone_number']) . "',customer_id = '" . $this->db->escape($data['customer_id']) . "',role = '" . $this->db->escape($data['role']) . "'");
	
		return $this->db->getLastId();
	}

	public function editCustomercontact($customer_con_id, $data) {
		$this->db->query("UPDATE " . DB_PREFIX . "customer_contact SET first_name = '" . $this->db->escape($data['first_name']) . "', last_name = '" . $this->db->escape($data['last_name']) . "',email = '" . $this->db->escape($data['email']) . "',telephone_number = '" . $this->db->escape($data['telephone_number']) . "',cellphone_number = '" . $this->db->escape($data['cellphone_number']) . "',customer_id = '" . $this->db->escape($data['customer_id']) . "',role = '" . $this->db->escape($data['role']) . "' WHERE customer_con_id = '" . (int)$customer_con_id . "'");
	}

	public function deleteCustomercontact($customer_con_id) {
		
		$this->db->query("DELETE FROM " . DB_PREFIX . "customer_contact WHERE customer_con_id = '" . (int)$customer_con_id . "'");
	}

	public function getcustomercontact($customer_con_id) { 
		$query = $this->db->query("SELECT DISTINCT * FROM " . DB_PREFIX . "customer_contact WHERE customer_con_id = '" . (int)$customer_con_id . "'");

		return $query->row;
	}

	public function getcustomercontacts($data = array()) {
		$sql = "SELECT * FROM " . DB_PREFIX . "customer_contact";
		
		if (!empty($data['filter_customer_contact_id']) || !empty($data['filter_customer_id']) || !empty($data['filter_email']) ) {
			$sql .= " where customer_con_id > '0'";
		}
		
		if (!empty($data['filter_customer_contact_id'])) {
			$sql .= " AND customer_con_id = '" . $this->db->escape($data['filter_customer_contact_id']) . "'";
		}
		
		if (!empty($data['filter_email'])) {
			$sql .= " AND customer_con_id = '" . $this->db->escape($data['filter_email']) . "'";
		}

		if (!empty($data['filter_customer_id'])) {
			$sql .= " AND customer_id = '" . $this->db->escape($data['filter_customer_id']) . "'";
		}
		
		$sql .= " ORDER BY first_name";

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

	public function getTotalCustomercontact($data = array()) {
		
		$sql = "SELECT COUNT(*) AS total FROM " . DB_PREFIX . "customer_contact";
		
		if (!empty($data['filter_customer_contact_id']) || !empty($data['filter_customer_id']) || !empty($data['filter_email']) ) {
			$sql .= " where customer_con_id > '0'";
		}
		
		if (!empty($data['filter_customer_contact_id'])) {
			$sql .= " AND customer_con_id = '" . $this->db->escape($data['filter_customer_contact_id']) . "'";
		}
		
		if (!empty($data['filter_email'])) {
			$sql .= " AND customer_con_id = '" . $this->db->escape($data['filter_email']) . "'";
		}

		if (!empty($data['filter_customer_id'])) {
			$sql .= " AND customer_id LIKE '" . $this->db->escape($data['filter_customer_id']) . "'";
		}
		
		$query = $this->db->query($sql);
		return $query->row['total'];
	}
	
	public function getTeams() {
		$query = $this->db->query("SELECT * FROM `" . DB_PREFIX . "team`");

		return $query->rows;
	}
	
		
	public function addMultiCustomercontact($data) {
		//print_r($data['customer_contact']); exit;
		//$this->db->query("DELETE FROM " . DB_PREFIX . "customer_contact WHERE customer_id = '" . (int)($data['customer_id']) . "'");
		
		foreach ($this->request->post['customer_contact'] as $key => $value) {
			
			if($value!='') {
			
			if($value['customer_con_id'] == '' ) {
			
				$this->db->query("INSERT INTO " . DB_PREFIX . "customer_contact SET first_name = '" . $this->db->escape($value['first_name']) . "', last_name = '" . $this->db->escape($value['last_name']) . "',email = '" . $this->db->escape($value['email']) . "', telephone_number = '" . $this->db->escape($value['telephone_number']) . "',cellphone_number = '" . $this->db->escape($value['cellphone_number']) . "',customer_id = '" . $this->db->escape($value['customer_id']) . "',role = '" . $this->db->escape($value['role']) . "'");
				return $this->db->getLastId();
				
			} else {
				
				$this->db->query("UPDATE " . DB_PREFIX . "customer_contact SET first_name = '" . $this->db->escape($value['first_name']) . "', last_name = '" . $this->db->escape($value['last_name']) . "',email = '" . $this->db->escape($value['email']) . "',telephone_number = '" . $this->db->escape($value['telephone_number']) . "',cellphone_number = '" . $this->db->escape($value['cellphone_number']) . "',customer_id = '" . $this->db->escape($value['customer_id']) . "',role = '" . $this->db->escape($value['role']) . "' WHERE customer_con_id = '" . (int)$value['customer_con_id'] . "'");
				
			}
		 }	
			
		}
		
	}

}