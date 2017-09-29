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

	public function getSalesReps($data = array()) {
		$sql = "SELECT * FROM " . DB_PREFIX . "salesrep";

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

		$query = $this->db->query($sql);

		return $query->rows;
	}

	public function getTotalScheduleManagement() {
		$query = $this->db->query("SELECT COUNT(*) AS total FROM " . DB_PREFIX . "salesrep");

		return $query->row['total'];
	}
	
	public function getTeams() {
		$query = $this->db->query("SELECT * FROM `" . DB_PREFIX . "team`");

		return $query->rows;
	}

}