<?php
class ModelReplogicTasks extends Model {
	public function addTasks($data) {
		$this->db->query("INSERT INTO " . DB_PREFIX . "tasks SET task_name = '" . $this->db->escape($data['task_name']) . "', task_description = '" . $this->db->escape($data['task_description']) . "', status = '" . $this->db->escape($data['status']) . "', appointment_id = '" . $this->db->escape($data['appointment_id']) . "', salesrep_id = '" . $this->db->escape($data['salesrep_id']) . "'");
	
		return $this->db->getLastId();
	}

	public function editTasks($task_id, $data) {
		$this->db->query("UPDATE " . DB_PREFIX . "tasks SET task_name = '" . $this->db->escape($data['task_name']) . "', task_description = '" . $this->db->escape($data['task_description']) . "', status = '" . $this->db->escape($data['status']) . "', appointment_id = '" . $this->db->escape($data['appointment_id']) . "', salesrep_id = '" . $this->db->escape($data['salesrep_id']) . "'WHERE task_id = '" . (int)$task_id . "'");
	}

	public function deleteTasks($task_id) { 
		$this->db->query("DELETE FROM " . DB_PREFIX . "tasks WHERE task_id = '" . (int)$task_id . "'");
	}

	public function getTask($task_id) {
		$query = $this->db->query("SELECT DISTINCT * FROM " . DB_PREFIX . "tasks WHERE task_id = '" . (int)$task_id . "'");

		return $query->row;
	}

	public function getTasks($data = array()) {
		$sql = "SELECT * FROM " . DB_PREFIX . "tasks";

		if (!empty($data['appointment_id']) ) {
			$sql .= " where task_id > '0'";
		}
		
		if (!empty($data['appointment_id'])) {
			$sql .= " AND appointment_id LIKE '" . $this->db->escape($data['appointment_id']) . "'";
		}
		
		$sql .= " ORDER BY task_name";

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

	public function getTotalTasks($data = array()) {
		$sql = "SELECT COUNT(*) AS total FROM " . DB_PREFIX . "tasks";
		if (!empty($data['appointment_id']) ) {
			$sql .= " where task_id > '0'";
		}
		
		if (!empty($data['appointment_id'])) {
			$sql .= " AND appointment_id LIKE '" . $this->db->escape($data['appointment_id']) . "'";
		}
		
		$query = $this->db->query($sql);
		return $query->row['total'];
	}

}