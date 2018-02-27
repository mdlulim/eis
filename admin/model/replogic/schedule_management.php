<?php
class ModelReplogicScheduleManagement extends Model {
	public function addScheduleManagement($data) {
		
		$appointment_date = $data['appointment_date'];
		$time = strtotime($data['appointment_date']);
		$mysqltime = date ("Y-m-d H:i:s", $time);
		
		
		if($data['type'] == 'New Business')
		{
			$this->db->query("INSERT INTO " . DB_PREFIX . "prospective_customer SET name = '" . $this->db->escape($data['bcustomer_name']) . "', address = '" . $this->db->escape($data['address']) . "', created = NOW()");
			$customer_id = $this->db->getLastId();
			$appointment_address = '';
		}
		else
		{
			$customer_id = $this->db->escape($data['customer_id']);
			$appointment_address = $this->db->escape($data['appointment_address']);
		}
		
		
		$this->db->query("INSERT INTO " . DB_PREFIX . "appointment SET appointment_name = '" . $this->db->escape($data['appointment_name']) . "', appointment_description = '" . $this->db->escape($data['appointment_description']) . "',salesrep_id = '" . $this->db->escape($data['salesrep_id']) . "',appointment_date = '" . $mysqltime . "',duration_hours = '" . $this->db->escape($data['hour']) . "',duration_minutes = '" . $this->db->escape($data['minutes']) . "',customer_id = '" . $customer_id . "', type = '".$this->db->escape($data['type'])."', appointment_address = '".$appointment_address."'");
		
		return $this->db->getLastId();
	}

	public function editScheduleManagement($appointment_id, $data) {
		
		$query = $this->db->query("SELECT DISTINCT * FROM " . DB_PREFIX . "appointment WHERE appointment_id = '" . (int)$appointment_id . "'");
		$appinfo = $query->row;
		if($appinfo['type'] == 'New Business')
		{ 
			$this->db->query("DELETE FROM " . DB_PREFIX . "prospective_customer WHERE prospect_id = '" . $appinfo['customer_id'] . "'");
		}
		
		if($data['type'] == 'New Business')
		{
			$this->db->query("INSERT INTO " . DB_PREFIX . "prospective_customer SET name = '" . $this->db->escape($data['bcustomer_name']) . "', address = '" . $this->db->escape($data['address']) . "', created = NOW()");
			$customer_id = $this->db->getLastId();
			$appointment_address = '';
		}
		else
		{
			$customer_id = $this->db->escape($data['customer_id']);
			$appointment_address = $this->db->escape($data['appointment_address']);
		}
		
		$appointment_date = $data['appointment_date'];
		$time = strtotime($data['appointment_date']);
		$mysqltime = date ("Y-m-d H:i:s", $time);
		
		$this->db->query("UPDATE " . DB_PREFIX . "appointment SET appointment_name = '" . $this->db->escape($data['appointment_name']) . "', appointment_description = '" . $this->db->escape($data['appointment_description']) . "',salesrep_id = '" . $this->db->escape($data['salesrep_id']) . "',appointment_date = '" . $mysqltime . "',duration_hours = '" . $this->db->escape($data['hour']) . "',duration_minutes = '" . $this->db->escape($data['minutes']) . "',customer_id = '" . $customer_id . "', type = '".$this->db->escape($data['type'])."', appointment_address = '".$appointment_address."' WHERE appointment_id = '" . (int)$appointment_id . "'");
	}

	public function deleteAppointment($appointment_id) {
		
		$this->db->query("DELETE FROM " . DB_PREFIX . "notes WHERE appointment_id = '" . (int)$appointment_id  . "'");
		$this->db->query("DELETE FROM " . DB_PREFIX . "appointment WHERE appointment_id = '" . (int)$appointment_id . "'");
	}

	public function getappointment($appointment_id) {
		$query = $this->db->query("SELECT DISTINCT * FROM " . DB_PREFIX . "appointment WHERE appointment_id = '" . (int)$appointment_id . "'");

		return $query->row;
		
	}
	
	public function getprospective($prospect_id) {
		$query = $this->db->query("SELECT DISTINCT * FROM " . DB_PREFIX . "prospective_customer WHERE prospect_id = '" . (int)$prospect_id . "'");

		return $query->row;
		
	}

	public function getScheduleManagement($data = array(), $allaccess, $current_user_id) {
		
		if($data['sort'] == '')
		{
			$data['sort'] = 'appointment_date';
		}
		
		if($allaccess)
		{
		
			$sql = "SELECT *, CONCAT(sr.salesrep_name,' ',sr.salesrep_lastname) AS salesrepname FROM " . DB_PREFIX . "appointment ap LEFT JOIN " . DB_PREFIX . "salesrep sr ON (ap.salesrep_id = sr.salesrep_id)";
			
			if (!empty($data['filter_appointment_name']) || !empty($data['filter_salesrep_id']) || !empty($data['filter_appointment_from']) || !empty($data['filter_appointment_to']) || !empty($data['filter_customer_id']) || !empty($data['filter_type'])) 		{
				$sql .= " where appointment_id > '0'";
			}
			
			$appointment_name = 'ap.appointment_name';
			$salesrep_id = 'ap.salesrep_id';
			$customer_id = 'ap.customer_id';
			$appointment_date = 'ap.appointment_date';
			$type = 'ap.type';
			$sortby = 'ap.'.$data['sort'];
		}
		else
		{
			$sql = "SELECT *, CONCAT(sr.salesrep_name,' ',sr.salesrep_lastname) AS salesrepname FROM oc_appointment ap left join oc_salesrep sr on sr.salesrep_id = ap.salesrep_id left join oc_team tm on tm.team_id = sr.sales_team_id where tm.sales_manager = ".$current_user_id.""; 
			
			$appointment_name = 'ap.appointment_name';
			$salesrep_id = 'ap.salesrep_id';
			$customer_id = 'ap.customer_id';
			$appointment_date = 'ap.appointment_date';
			$type = 'ap.type';
			$sortby = 'ap.'.$data['sort'];
			
		}
		
		if (!empty($data['filter_type'])) {
			$sql .= " AND ".$type." = '" . $this->db->escape($data['filter_type']) . "'";
		}
		
		if (!empty($data['filter_appointment_name'])) {
			$sql .= " AND ".$appointment_name." LIKE '" . $this->db->escape($data['filter_appointment_name']) . "%'";
		}

		if (!empty($data['filter_salesrep_id'])) {
			$sql .= " AND ".$salesrep_id." LIKE '" . $this->db->escape($data['filter_salesrep_id']) . "'";
		}
		
		if (!empty($data['filter_customer_id'])) {
			$sql .= " AND ".$customer_id." LIKE '" . $this->db->escape($data['filter_customer_id']) . "'";
		}
		
		if (!empty($data['filter_appointment_from']) && !empty($data['filter_appointment_to'])) { 
			$fromdate = date('Y-m-d H:i:s', strtotime($data['filter_appointment_from'])); 
			$todate = date('Y-m-d H:i:s', strtotime($data['filter_appointment_to'])); 
			$sql .= " AND ".$appointment_date." >= '" . $fromdate . "' AND ".$appointment_date." <= '" . $todate . "'";
		}

		if($data['sort'] == 'salesrepname')
		{
			$sortby = 'sr.salesrep_name';	
		}
		
		$sql .= " ORDER BY ".$sortby."";

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
	
	
	public function getTotalScheduleManagement($data = array(), $allaccess, $current_user_id) {
		
		if($allaccess)
		{
		
			$sql = "SELECT COUNT(*) AS total FROM " . DB_PREFIX . "appointment";
			
			if (!empty($data['filter_appointment_name']) || !empty($data['filter_salesrep_id']) || !empty($data['filter_appointment_from']) || !empty($data['filter_appointment_to']) || !empty($data['filter_customer_id']) || !empty($data['filter_type'])) 		{
				$sql .= " where appointment_id > '0'";
			}
			
			$appointment_name = 'appointment_name';
			$salesrep_id = 'salesrep_id';
			$customer_id = 'customer_id';
			$appointment_date = 'appointment_date';
			$type = 'type';
		}
		else
		{
			$sql = "SELECT COUNT(*) AS total FROM oc_appointment ap left join oc_salesrep sr on sr.salesrep_id = ap.salesrep_id left join oc_team tm on tm.team_id = sr.sales_team_id where tm.sales_manager = ".$current_user_id.""; 
			
			$appointment_name = 'ap.appointment_name';
			$salesrep_id = 'ap.salesrep_id';
			$customer_id = 'ap.customer_id';
			$appointment_date = 'ap.appointment_date';
			$type = 'ap.type';
			
		}
		
		if (!empty($data['filter_type'])) {
			$sql .= " AND ".$type." = '" . $this->db->escape($data['filter_type']) . "'";
		}
		
		if (!empty($data['filter_appointment_name'])) {
			$sql .= " AND ".$appointment_name." LIKE '" . $this->db->escape($data['filter_appointment_name']) . "%'";
		}

		if (!empty($data['filter_salesrep_id'])) {
			$sql .= " AND ".$salesrep_id." LIKE '" . $this->db->escape($data['filter_salesrep_id']) . "'";
		}
		
		if (!empty($data['filter_customer_id'])) {
			$sql .= " AND ".$customer_id." LIKE '" . $this->db->escape($data['filter_customer_id']) . "'";
		}
		
		if (!empty($data['filter_appointment_from']) && !empty($data['filter_appointment_to'])) { 
			$fromdate = date('Y-m-d H:i:s', strtotime($data['filter_appointment_from'])); 
			$todate = date('Y-m-d H:i:s', strtotime($data['filter_appointment_to'])); 
			$sql .= " AND ".$appointment_date." >= '" . $fromdate . "' AND ".$appointment_date." <= '" . $todate . "'";
		}
		
		$query = $this->db->query($sql);
		return $query->row['total'];
	}

}