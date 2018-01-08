<?php
class ModelReplogicLocationManagement extends Model {
	
	public function getLocations($data = array()) {
		
		if(!isset($data['filter_team_id']))
		{
			$sql = "SELECT * FROM " . DB_PREFIX . "salesrep_checkins";
				
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
			
			$sql .= " ORDER BY checkin_id";
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
//echo $sql; exit;
		$query = $this->db->query($sql);

		return $query->rows;
	}
	public function getLocation($checkin_id) {
		$query = $this->db->query("SELECT DISTINCT * FROM " . DB_PREFIX . "salesrep_checkins WHERE checkin_id = '" . (int)$checkin_id . "'");

		return $query->row;;
	}
	public function getTotalLocations($data = array()) {
		if(!isset($data['filter_team_id']))
		{
			$sql = "SELECT COUNT(*) AS total FROM `" . DB_PREFIX . "salesrep_checkins`";

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
		
		}
		else
		{
			$sql = "SELECT COUNT(*) AS total FROM oc_salesrep_checkins ck left join oc_salesrep sr on ck.salesrep_id = sr.salesrep_id where sr.sales_team_id = ".$data['filter_team_id'].""; 	
			if (isset($data['filter_address'])) {
				$sql .= " AND ck.location LIKE '" . $data['filter_address'] . "'";
			} 
	
			if (!empty($data['filter_salesrep_id'])) {
				$sql .= " AND ck.salesrep_id = '" . (int)$data['filter_salesrep_id'] . "'";
			}
	
			if (!empty($data['filter_customer_id'])) {
				$sql .= " AND ck.customer_id = '" . (int)$data['filter_customer_id'] . "'";
			}
		}

		$query = $this->db->query($sql);

		return $query->row['total'];
	}

}