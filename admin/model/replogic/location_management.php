<?php
class ModelReplogicLocationManagement extends Model {
	

	public function deletelocation($checkin_id) { 
		$this->db->query("DELETE FROM " . DB_PREFIX . "salesrep_checkins WHERE checkin_id = '" . (int)$checkin_id . "'");
}
	public function getLocationsDash($data = array()) {
		$sql = "SELECT rc.*,CONCAT(sr.salesrep_name,' ',sr.salesrep_lastname) AS salesrep_name,CONCAT(cs.firstname,' ',cs.lastname) AS customer_name, ca.latitude AS customer_lat,ca.longitude AS customer_lng ";
		$sql.= "FROM ".DB_PREFIX."salesrep_checkins rc ";
		$sql.= "LEFT JOIN ".DB_PREFIX."customer cs ON cs.customer_id=rc.customer_id ";
		$sql.= "LEFT JOIN ".DB_PREFIX."address ca ON ca.address_id=cs.address_id ";
		$sql.= "LEFT JOIN ".DB_PREFIX."salesrep sr ON sr.salesrep_id=rc.salesrep_id ";
		$sql.= "LEFT JOIN ".DB_PREFIX."team tm on tm.team_id=sr.sales_team_id";

		/*===============================
		=            Filters            =
		===============================*/

		$condition = false;
		
		switch (TRUE) {
			case (isset($filters['filter_date'])):
				# filter by date...
				$sql .= " WHERE DATE_FORMAT(rc.checkin,'%Y-%m-%d')='".$filters['filter_date']."'";
				$condition = true;
				break;

			case (isset($filters['filter_month'])):
				# filter by month...
				$sql .= " WHERE DATE_FORMAT(rc.checkin,'%Y-%m')='".$filters['filter_month']."'";
				$condition = true;
				break;

			case (isset($filters['filter_year'])):
				# filter by year...
				$sql .= " WHERE DATE_FORMAT(rc.checkin,'%Y')='".$filters['filter_year']."'";
				$condition = true;
				break;

			case (isset($filters['filter_date_from']) && isset($filters['filter_date_to'])):
				# filter by date range...
				$sql .= " WHERE DATE_FORMAT(rc.checkin,'%Y-%m-%d')>='".$filters['filter_date_from']."'";
				$sql .= " AND DATE_FORMAT(rc.checkin,'%Y-%m-%d')<='".$filters['filter_date_to']."'";
				$condition = true;
				break;
		}

		if (isset($filters['filter_user'])) {
			# filter by user [role]...
			$sql .= ($condition) ? " AND " : " WHERE ";
			$sql .= "tm.sales_manager=".$filters['filter_user'];
		}
		
		/*=====  End of Filters  ======*/
		
		$query = $this->db->query($sql);
		return $query->rows;

	}

	public function getCheckins($data = array(), $group_by_salesrep = false) {

		if (!empty($data['filter_team_id'])) {

			/***************************************
			 * Filter by sales team id
			 ***************************************/

			if ($group_by_salesrep || !empty($data['filter_groupby_salesrep'])) {
				$sql = "SELECT c.*, a.type FROM " . DB_PREFIX . "salesrep_checkins c LEFT JOIN " . DB_PREFIX . "salesrep_checkins c2 ON (c.salesrep_id = c2.salesrep_id AND c.checkin_id = c2.checkin_id) INNER JOIN " . DB_PREFIX . "appointment a ON a.appointment_id=c.appointment_id LEFT JOIN " . DB_PREFIX . "salesrep sr ON c.salesrep_id = sr.salesrep_id WHERE c2.checkin_id IS NULL AND sr.sales_team_id = ".(int)$data['filter_team_id'];
			} else {
				$sql = "SELECT c.*, a.type FROM " . DB_PREFIX . "salesrep_checkins c INNER JOIN " . DB_PREFIX . "appointment a ON a.appointment_id=c.appointment_id LEFT JOIN " . DB_PREFIX . "salesrep sr ON c.salesrep_id = sr.salesrep_id WHERE c.checkin_id > 0 AND sr.sales_team_id = ".(int)$data['filter_team_id'];
			}

		} else {

			/***************************************
			 * Create select statement
			 ***************************************/

			if ($group_by_salesrep || !empty($data['filter_groupby_salesrep'])) {
				$sql = "SELECT c.*, a.type FROM " . DB_PREFIX . "salesrep_checkins c LEFT JOIN " . DB_PREFIX . "salesrep_checkins c2 ON (c.salesrep_id = c2.salesrep_id AND c.checkin_id < c2.checkin_id) INNER JOIN " . DB_PREFIX . "appointment a ON a.appointment_id=c.appointment_id WHERE c2.checkin_id IS NOT NULL";
			} else {
				$sql = "SELECT c.*, a.type FROM " . DB_PREFIX . "salesrep_checkins c INNER JOIN " . DB_PREFIX . "appointment a ON a.appointment_id = c.appointment_id WHERE c.checkin_id > 0";
			}
		}

		/***************************************
		 * Filter by sales rep id
		 ***************************************/

		if (!empty($data['filter_salesrep_id'])) {
			$sql .= " AND c.salesrep_id = " . (int)$data['filter_salesrep_id'];
		}

		/***************************************
		 * Filter by customer type
		 ***************************************/

		if (isset($data['filter_customer_type'])) {
			$sql .= " AND a.type = '" . $data['filter_customer_type'] . "'";
		}

		/***************************************
		 * Filter by customer id
		 ***************************************/

		if (!empty($data['filter_customer_id'])) {
			$sql .= " AND c.customer_id = " . (int)$data['filter_customer_id'];
		}

		/***************************************
		 * Filter by location [address]
		 ***************************************/

		if (isset($data['filter_address'])) {
			$sql .= " AND c.location LIKE '%" . $data['filter_address'] . "%'";
		}

		/***************************************
		 * Filter by date range [check in]
		 ***************************************/

		if (!empty($data['filter_date_from']) && !empty($data['filter_date_to']))  { 
			$fromdate = date('Y-m-d H:i:s', strtotime($data['filter_date_from'])); 
			$todate = date('Y-m-d H:i:s', strtotime($data['filter_date_to'])); 
			$sql .= " AND c.checkin >= '" . $fromdate . "' AND c.checkin <= '" . $todate . "'";
		}

		/***************************************
		 * Filter by specific date
		 ***************************************/
		
		if (!empty($data['filter_date']))  { 
			$sql .= " AND DATE_FORMAT(c.checkin, '%Y-%m-%d') = '" . $this->db->escape($data['filter_date']) . "'";
		}

		/***************************************
		 * Filter by specific month
		 ***************************************/
		
		if (!empty($data['filter_month']))  { 
			$sql .= " AND DATE_FORMAT(c.checkin, '%Y-%m') = '" . $this->db->escape($data['filter_month']) . "'";
		}

		// set order of results
		$sql .= " ORDER BY c.checkin_id";

		// order: ascending or descending
		if (isset($data['order']) && ($data['order'] == 'DESC')) {
			$sql .= " DESC";
		} else {
			$sql .= " DESC";
		}

		// set results start index and/or limit
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
	
	public function getLocations($data = array(), $group_by_salesrep=false) {
		
		if (!isset($data['filter_team_id'])) {

			$sql = "SELECT ck.*, a.type FROM " . DB_PREFIX . "salesrep_checkins ck INNER JOIN " . DB_PREFIX . "appointment a ON a.appointment_id = ck.appointment_id ";
				
			if (isset($data['filter_groupby_salesrep'])) {
				$sql .= " WHERE ck.checkin_id IN (SELECT MAX(checkin_id) FROM " . DB_PREFIX . "salesrep_checkins GROUP BY salesrep_id)";
			} else {
				$sql .= " WHERE ck.checkin_id > '0'";
			}
			
			if (isset($data['filter_address'])) {
				$sql .= " AND ck.location LIKE '%" . $data['filter_address'] . "%'";
			} 
	
			if (!empty($data['filter_salesrep_id'])) {
				$sql .= " AND ck.salesrep_id = '" . (int)$data['filter_salesrep_id'] . "'";
			}

			if (isset($data['filter_customer_type'])) {
				$sql .= " AND a.type = '" . $data['filter_customer_type'] . "'";
			}
	
			if (!empty($data['filter_customer_id'])) {
				$sql .= " AND ck.customer_id = '" . (int)$data['filter_customer_id'] . "'";
			}
			
			if (!empty($data['filter_date_from']) && !empty($data['filter_date_to']))  { 
				$fromdate = date('Y-m-d H:i:s', strtotime($data['filter_date_from'])); 
				$todate = date('Y-m-d H:i:s', strtotime($data['filter_date_to'])); 
				$sql .= " AND ck.checkin >= '" . $fromdate . "' AND ck.checkin <= '" . $todate . "'";
			}
			
			if (!empty($data['filter_date']))  { 
				$sql .= " AND DATE_FORMAT(ck.checkin, '%Y-%m-%d') = '" . $this->db->escape($data['filter_date']) . "'";
			}
			
			if (!empty($data['filter_month']))  { 
				$sql .= " AND DATE_FORMAT(ck.checkin, '%Y-%m') = '" . $this->db->escape($data['filter_month']) . "'";
			}

			if ($group_by_salesrep) {
				$sql .= " GROUP BY ck.salesrep_id";
			}
			
			$sql .= " ORDER BY ck.checkin_id";
			
		} else {
			$sql = "SELECT ck.*, a.type FROM oc_salesrep_checkins ck INNER JOIN " . DB_PREFIX . "appointment a ON a.appointment_id = ck.appointment_id LEFT JOIN " . DB_PREFIX . "salesrep sr on ck.salesrep_id = sr.salesrep_id WHERE sr.sales_team_id = ".$data['filter_team_id'].""; 
			
			if (isset($data['filter_groupby_salesrep'])) {
				$sql .= " AND ck.checkin_id IN (SELECT MAX(ck.checkin_id) FROM " . DB_PREFIX . "salesrep_checkins GROUP BY ck.salesrep_id)";	
			}
			
			if (isset($data['filter_address'])) {
				$sql .= " AND ck.location LIKE '" . $data['filter_address'] . "'";
			} 
	
			if (!empty($data['filter_salesrep_id'])) {
				$sql .= " AND ck.salesrep_id = '" . (int)$data['filter_salesrep_id'] . "'";
			}

			if (isset($data['filter_customer_type'])) {
				$sql .= " AND a.type = '" . $data['filter_customer_type'] . "'";
			}
	
			if (!empty($data['filter_customer_id'])) {
				$sql .= " AND ck.customer_id = '" . (int)$data['filter_customer_id'] . "'";
			}
			
			if (!empty($data['filter_date_from']) && !empty($data['filter_date_to'])) { 
				$fromdate = date('Y-m-d H:i:s', strtotime($data['filter_date_from'])); 
				$todate = date('Y-m-d H:i:s', strtotime($data['filter_date_to'])); 
				$sql .= " AND ck.checkin >= '" . $fromdate . "' AND ck.checkin <= '" . $todate . "'";
			}
			
			if (!empty($data['filter_date']))  { 
				$sql .= " AND DATE_FORMAT(ck.checkin, '%Y-%m-%d') = '" . $this->db->escape($data['filter_date']) . "'";
			}
			
			if (!empty($data['filter_month']))  { 
				$sql .= " AND DATE_FORMAT(ck.checkin, '%Y-%m') = '" . $this->db->escape($data['filter_month']) . "'";
			}

			if ($group_by_salesrep) {
				$sql .= " GROUP BY ck.salesrep_id";
			}
			
			$sql .= " ORDER BY ck.checkin_id";

		}

		if (isset($data['order']) && ($data['order'] == 'DESC')) {
			$sql .= " DESC";
		} else {
			$sql .= " DESC";
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

	public function getSalesRepLocation($salesrep_id) {
		$query = $this->db->query("SELECT DISTINCT * FROM " . DB_PREFIX . "salesrep_checkins WHERE salesrep_id = '" . (int)$salesrep_id . "' ORDER BY checkin_id DESC LIMIT 0,1");

		return $query->row;
	}

	public function getLocation($checkin_id) {
		$query = $this->db->query("SELECT DISTINCT * FROM " . DB_PREFIX . "salesrep_checkins WHERE checkin_id = '" . (int)$checkin_id . "'");

		return $query->row;;
	}
	public function getTotalLocations($data = array()) {
		if(!isset($data['filter_team_id']))
		{
			$sql = "SELECT * FROM `" . DB_PREFIX . "salesrep_checkins`";

			$sql .= " where checkin_id > '0'";
			
			if (isset($data['filter_address'])) {
				$sql .= " AND location LIKE '%" . $data['filter_address'] . "%'";
			} 
	
			if (!empty($data['filter_salesrep_id'])) {
				$sql .= " AND salesrep_id = '" . (int)$data['filter_salesrep_id'] . "'";
			}
	
			if (!empty($data['filter_customer_id'])) {
				$sql .= " AND customer_id = '" . (int)$data['filter_customer_id'] . "'";
			}
			
			if (!empty($data['filter_date_from']) && !empty($data['filter_date_to'])) 
			{ 
				$fromdate = date('Y-m-d H:i:s', strtotime($data['filter_date_from'])); 
				$todate = date('Y-m-d H:i:s', strtotime($data['filter_date_to'])); 
				$sql .= " AND checkin >= '" . $fromdate . "' AND checkin <= '" . $todate . "'";
			}
			
			if (isset($data['filter_groupby_salesrep'])) {
				$sql .= " group by salesrep_id";
			}
		
		}
		else
		{
			$sql = "SELECT * FROM oc_salesrep_checkins ck left join oc_salesrep sr on ck.salesrep_id = sr.salesrep_id where sr.sales_team_id = ".$data['filter_team_id'].""; 	
			if (isset($data['filter_address'])) {
				$sql .= " AND ck.location LIKE '" . $data['filter_address'] . "'";
			} 
	
			if (!empty($data['filter_salesrep_id'])) {
				$sql .= " AND ck.salesrep_id = '" . (int)$data['filter_salesrep_id'] . "'";
			}
	
			if (!empty($data['filter_customer_id'])) {
				$sql .= " AND ck.customer_id = '" . (int)$data['filter_customer_id'] . "'";
			}
			
			if (!empty($data['filter_date_from']) && !empty($data['filter_date_to'])) 
			{ 
				$fromdate = date('Y-m-d H:i:s', strtotime($data['filter_date_from'])); 
				$todate = date('Y-m-d H:i:s', strtotime($data['filter_date_to'])); 
				$sql .= " AND ck.checkin >= '" . $fromdate . "' AND ck.checkin <= '" . $todate . "'";
			}
			
			if (isset($data['filter_groupby_salesrep'])) {
				$sql .= " group by ck.salesrep_id";
			}
		}
//echo $sql; exit;
		$query = $this->db->query($sql);
		$total = $query->num_rows;
		return $total;
	}
	
}