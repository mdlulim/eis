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

	public function getTeams($data = array()) {
		$sql = "SELECT * FROM " . DB_PREFIX . "team";

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

		$query = $this->db->query($sql);

		return $query->rows;
	}

	public function getTotalTeam() {
		$query = $this->db->query("SELECT COUNT(*) AS total FROM " . DB_PREFIX . "team");

		return $query->row['total'];
	}

}