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

	public function getAppointments($filters) {
		$sql = "SELECT ap.appointment_id,ap.appointment_name,ap.appointment_description,ap.appointment_date,ap.type,IF(type='New Business',pc.prospect_id,cs.customer_id) AS customer_id,IF(type='New Business',pc.name,cs.firstname) AS customer_name,sc.checkin_id,sc.checkin,sc.checkout,CONCAT(sr.salesrep_name,' ',sr.salesrep_lastname) AS salesrep_name ";
		$sql.= "FROM ".DB_PREFIX."appointment ap ";
		$sql.= "LEFT JOIN ".DB_PREFIX."customer cs on cs.customer_id = ap.customer_id ";
		$sql.= "LEFT JOIN ".DB_PREFIX."salesrep sr ON sr.salesrep_id=ap.salesrep_id ";
		$sql.= "LEFT JOIN ".DB_PREFIX."team tm ON tm.team_id=sr.sales_team_id ";
		$sql.= "LEFT JOIN ".DB_PREFIX."prospective_customer pc ON pc.prospect_id=ap.customer_id ";
		$sql.= "LEFT JOIN ".DB_PREFIX."salesrep_checkins sc on sc.appointment_id=ap.appointment_id ";

		/*===============================
		=            Filters            =
		===============================*/

		$condition = false;
		
		switch (TRUE) {
			case (isset($filters['filter_date'])):
				# filter by date...
				$sql .= " WHERE DATE_FORMAT(ap.appointment_date,'%Y-%m-%d')='".$filters['filter_date']."'";
				$condition = true;
				break;

			case (isset($filters['filter_month'])):
				# filter by month...
				$sql .= " WHERE DATE_FORMAT(ap.appointment_date,'%Y-%m')='".$filters['filter_month']."'";
				$condition = true;
				break;

			case (isset($filters['filter_year'])):
				# filter by year...
				$sql .= " WHERE DATE_FORMAT(ap.appointment_date,'%Y')='".$filters['filter_year']."'";
				$condition = true;
				break;

			case (isset($filters['filter_date_from']) && isset($filters['filter_date_to'])):
				# filter by date range...
				$sql .= " WHERE DATE_FORMAT(ap.appointment_date,'%Y-%m-%d')>='".$filters['filter_date_from']."'";
				$sql .= " AND DATE_FORMAT(ap.appointment_date,'%Y-%m-%d')<='".$filters['filter_date_to']."'";
				$condition = true;
				break;
		}

		if (isset($filters['filter_user'])) {
			# filter by user [role]...
			$sql .= ($condition) ? " AND " : " WHERE ";
			$sql .= "tm.sales_manager=".$filters['filter_user'];
		}
		
		/*=====  End of Filters  ======*/
		
		$sql .= " ORDER BY ap.appointment_date DESC";
		$query = $this->db->query($sql);
		return $query->rows;
	}

	public function getScheduleManagement($data = array(), $allaccess, $current_user_id) {
		
		if ($data['sort'] == '')
		{
			$data['sort'] = 'appointment_date';
		}
		
		if ($allaccess)
		{
			$sql  = "SELECT ap.*,CONCAT(sr.salesrep_name,' ',sr.salesrep_lastname) AS salesrepname,IF(LCASE(ap.type='new business'), pc.name, cs.firstname) AS customer_name,sc.checkin "; 
			$sql .= "FROM ".DB_PREFIX."appointment ap ";
			$sql .= "LEFT JOIN ".DB_PREFIX."salesrep sr ON (ap.salesrep_id=sr.salesrep_id) ";
			$sql .= "LEFT JOIN ".DB_PREFIX."customer cs ON cs.customer_id=ap.customer_id ";
			$sql .= "LEFT JOIN ".DB_PREFIX."prospective_customer pc ON pc.prospect_id=ap.customer_id ";
			$sql .= "LEFT JOIN ".DB_PREFIX."salesrep_checkins sc ON sc.appointment_id=ap.appointment_id";
			
			if (!empty($data['filter_appointment_name']) || !empty($data['filter_salesrep_id']) || !empty($data['filter_appointment_from']) || !empty($data['filter_appointment_to']) || !empty($data['filter_customer_id']) || !empty($data['filter_type'])) 		{
				$sql .= " where ap.appointment_id > '0'";
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
			$sql = "SELECT ap.*,CONCAT(sr.salesrep_name,' ',sr.salesrep_lastname) AS salesrepname,IF(LCASE(ap.type='new business'), pc.name, cs.firstname) AS customer_name,sc.checkin ";
			$sql .= "FROM ".DB_PREFIX."appointment ap ";
			$sql .= "LEFT JOIN ".DB_PREFIX."salesrep sr ON sr.salesrep_id=ap.salesrep_id ";
			$sql .= "LEFT JOIN ".DB_PREFIX."team tm ON tm.team_id=sr.sales_team_id ";
			$sql .= "LEFT JOIN ".DB_PREFIX."customer cs ON cs.customer_id=ap.customer_id ";
			$sql .= "LEFT JOIN ".DB_PREFIX."prospective_customer pc ON pc.prospect_id=ap.customer_id ";
			$sql .= "LEFT JOIN ".DB_PREFIX."salesrep_checkins sc ON sc.appointment_id=ap.appointment_id ";
			$sql .= "WHERE tm.sales_manager=".$current_user_id;
			
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
			$sql .= " AND ".$salesrep_id." = '" . $this->db->escape($data['filter_salesrep_id']) . "'";
		}
		
		if (!empty($data['filter_customer_id'])) {
			$sql .= " AND ".$customer_id." = '" . $this->db->escape($data['filter_customer_id']) . "'";
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
	
	public function getSalesRepAppointmentTimesByDate($salesrep_id, $appointment_date) {
		$sql    = "SELECT DISTINCT DATE_FORMAT(appointment_date, '%H:00') AS appointment_start, DATE_FORMAT(DATE_ADD(appointment_date, INTERVAL CONCAT(duration_hours,':',duration_minutes) HOUR_MINUTE), '%H:00') AS appointment_end FROM " . DB_PREFIX . "appointment WHERE (DATE_FORMAT(appointment_date, '%Y-%m-%d') = '" . $this->db->escape($appointment_date) . "'  OR appointment_date=DATE_ADD('" . $this->db->escape($appointment_date) . "', INTERVAL CONCAT(duration_hours,':',duration_minutes) HOUR_MINUTE)) AND salesrep_id = " . (int)$this->db->escape($salesrep_id);
		$query  = $this->db->query($sql);
		$result = $query->rows;
		$return = array();
		$times  = array();
		if (!empty($result)) {
			foreach($result as $value) {
				if ($value['appointment_start'] == $value['appointment_end']) {
					$return[]['appointment_time'] = $value['appointment_start'];
					$times[] = $value['appointment_start'];
				} else {
					$start  = strtotime($value['appointment_start']);
					$end    = strtotime($value['appointment_end']);
					for( $i=$start; $i<=$end; $i+=300) {
						if (!in_array(date("H:00", $i), $times)) {
							$return[]['appointment_time'] = date("H:00", $i);
							$times[] = date("H:00", $i);
						}
					}
				}
			}
		}
		return $return;
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