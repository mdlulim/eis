<?php
class ModelUserTeam extends Model {
	public function addTeam($data) {
		$this->db->query("INSERT INTO " . DB_PREFIX . "team SET team_name = '" . $this->db->escape($data['team_name']) . "', sales_manager = '" . $this->db->escape($data['sales_manager']) . "'");
	
		return $this->db->getLastId();
	}

	public function editTeam($team_id, $data) {
		$this->db->query("UPDATE " . DB_PREFIX . "team SET team_name = '" . $this->db->escape($data['team_name']) . "', sales_manager = '" . $this->db->escape($data['sales_manager']). "' WHERE team_id = '" . (int)$team_id . "'");
	}

	public function deleteTeam($team_id) {
		$this->db->query("DELETE FROM " . DB_PREFIX . "team WHERE team_id = '" . (int)$team_id . "'");
	}

	public function getTeam($team_id) {
		$query = $this->db->query("SELECT DISTINCT * FROM " . DB_PREFIX . "team WHERE team_id = '" . (int)$team_id . "'");

		$team = array(
			'team_name'       => $query->row['team_name'],
			'sales_manager'       => $query->row['sales_manager'],
		);

		return $team;
	}
	
	public function getTeamBySalesmanager($sales_manager_id) { 
		$query = $this->db->query("SELECT  * FROM " . DB_PREFIX . "team WHERE sales_manager = '" . (int)$sales_manager_id . "'");

		$team = array(
			'team_id'       => $query->row['team_id']
		);

		return $team;
	}

	public function getTeams($data = array()) {
		$sql = "SELECT * FROM " . DB_PREFIX . "team";
		
		if (!empty($data['filter_team_name']) || !empty($data['filter_salesrep_id'])) {
			$sql .= " where team_id > '0'";
		}
		
		if (!empty($data['filter_team_name'])) {
			$sql .= " AND team_name LIKE '" . $this->db->escape($data['filter_team_name']) . "%'";
		}

		if (!empty($data['filter_salesrep_id'])) {
			$sql .= " AND sales_manager LIKE '" . $this->db->escape($data['filter_salesrep_id']) . "'";
		}
		
		$sql .= " ORDER BY team_name";

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

	public function getTotalTeam($data = array()) {
		
		$sql = "SELECT COUNT(*) AS total FROM " . DB_PREFIX . "team";
		
		if (!empty($data['filter_team_name']) || !empty($data['filter_salesrep_id'])) {
			$sql .= " where team_id > '0'";
		}
		
		if (!empty($data['filter_team_name'])) {
			$sql .= " AND team_name LIKE '" . $this->db->escape($data['filter_team_name']) . "%'";
		}

		if (!empty($data['filter_salesrep_id'])) {
			$sql .= " AND sales_manager LIKE '" . $this->db->escape($data['filter_salesrep_id']) . "'";
		}
		$query = $this->db->query($sql);
		return $query->row['total'];
	}
	
	public function getTeamName($team_name) {
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "team WHERE team_name = '" . $this->db->escape($team_name) . "'");

		return $query->row;
	}
	
	public function getTotalTeamBySalesmanager($sales_manager) {
		
		$sql = "SELECT * FROM " . DB_PREFIX . "team where sales_manager=".$sales_manager."";
		$query = $this->db->query($sql);
		return $query->row;
	}

}