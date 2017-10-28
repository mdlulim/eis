<?php
class ModelReplogicSalesRepManagement extends Model {
	public function addSalesRep($data) {
		$this->db->query("INSERT INTO " . DB_PREFIX . "salesrep SET salesrep_name = '" . $this->db->escape($data['salesrep_name']) . "', salesrep_lastname = '" . $this->db->escape($data['salesrep_lastname']) . "',email = '" . $this->db->escape($data['email']) . "',sales_team_id = '" . $this->db->escape($data['sales_team_id']) . "',cell = '" . $this->db->escape($data['cell']) . "',tel = '" . $this->db->escape($data['tel']) . "',password = '" . $this->db->escape($data['password']) . "'");
	
		return $this->db->getLastId();
	}

	public function editSalesRep($salesrep_id, $data) {
		$this->db->query("UPDATE " . DB_PREFIX . "salesrep SET salesrep_name = '" . $this->db->escape($data['salesrep_name']) . "', salesrep_lastname = '" . $this->db->escape($data['salesrep_lastname']) . "',email = '" . $this->db->escape($data['email']) . "',sales_team_id = '" . $this->db->escape($data['sales_team_id']) . "',cell = '" . $this->db->escape($data['cell']) . "',tel = '" . $this->db->escape($data['tel']) . "',password = '" . $this->db->escape($data['password']) . "' WHERE salesrep_id = '" . (int)$salesrep_id . "'");
	}

	public function deleteSalesRep($salesrep_id) {
		
		$this->db->query("DELETE FROM " . DB_PREFIX . "salesrep WHERE salesrep_id = '" . (int)$salesrep_id . "'");
	}

	public function getsalesrep($salesrep_id) {
		$query = $this->db->query("SELECT DISTINCT * FROM " . DB_PREFIX . "salesrep WHERE salesrep_id = '" . (int)$salesrep_id . "'");

		return $query->row;
	}

	public function getSalesReps($data = array(), $allaccess, $current_user_id) {
		
		if($allaccess)
		{
			$sql = "SELECT * FROM " . DB_PREFIX . "salesrep";
			
			if (!empty($data['filter_sales_rep_name']) || !empty($data['team_id']) || !empty($data['filter_email']) ) 
			{
				$sql .= " where salesrep_id > '0'";
			}
		}
		else
		{
			$sql = "SELECT * FROM oc_salesrep sr left join oc_team tm on tm.team_id = sr.sales_team_id where tm.sales_manager = ".$current_user_id.""; 
		}
		
		if (!empty($data['filter_sales_rep_name'])) {
			
			$sql .= " AND CONCAT(salesrep_name,' ',salesrep_lastname) like '%" . $this->db->escape($data['filter_sales_rep_name']) . "%'";
			
		}
		
		if (!empty($data['filter_email'])) {
			$sql .= " AND email LIKE '" . $this->db->escape($data['filter_email']) . "%'";
		}

		if (!empty($data['team_id'])) {
			$sql .= " AND sales_team_id LIKE '" . $this->db->escape($data['team_id']) . "'";
		}
		
		$sql .= " ORDER BY salesrep_name";

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
	
	public function getSalesRepsDropdown($allaccess, $current_user_id) {
		
		if($allaccess)
		{
			$sql = "SELECT * FROM " . DB_PREFIX . "salesrep";
		}
		else
		{
			$sql = "SELECT * FROM oc_salesrep sr left join oc_team tm on tm.team_id = sr.sales_team_id where tm.sales_manager = ".$current_user_id.""; 
		}
		
//echo $sql; exit;
		$query = $this->db->query($sql);

		return $query->rows;
	}


	public function getTotalScheduleManagement($data = array(), $allaccess, $current_user_id) {
		
		if($allaccess)
		{
			$sql = "SELECT * FROM " . DB_PREFIX . "salesrep";
			
			if (!empty($data['filter_sales_rep_name']) || !empty($data['team_id']) || !empty($data['filter_email']) ) 
			{
				$sql .= " where salesrep_id > '0'";
			}
		}
		else
		{
			$sql = "SELECT * FROM oc_salesrep sr left join oc_team tm on tm.team_id = sr.sales_team_id where tm.sales_manager = ".$current_user_id.""; 
		}
		
		if (!empty($data['filter_sales_rep_name'])) {
			$sql .= " AND CONCAT(salesrep_name,' ',salesrep_lastname) like '%" . $this->db->escape($data['filter_sales_rep_name']) . "%'";
			
		}
		
		if (!empty($data['filter_email'])) {
			$sql .= " AND email LIKE '" . $this->db->escape($data['filter_email']) . "%'";
		}

		if (!empty($data['team_id'])) {
			$sql .= " AND sales_team_id LIKE '" . $this->db->escape($data['team_id']) . "'";
		}
		
		$query = $this->db->query($sql);
		return $query->row['total'];
	}
	
	public function getTeams() {
		$query = $this->db->query("SELECT * FROM `" . DB_PREFIX . "team`");

		return $query->rows;
	}

}