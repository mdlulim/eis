<?php
class ModelReplogicNotes extends Model {
	public function addNote($data) {
		$this->db->query("INSERT INTO " . DB_PREFIX . "notes SET note_title = '" . $this->db->escape($data['note_title']) . "', salesrep_id = '" . $this->db->escape($data['salesrep_id']) . "', note_content = '" . $this->db->escape($data['note_description']) . "', appointment_id = '" . $this->db->escape($data['appointment_id']) . "'");
	
		return $this->db->getLastId();
	}

	public function editNote($note_id, $data) {
		$this->db->query("UPDATE " . DB_PREFIX . "notes SET note_title = '" . $this->db->escape($data['note_title']) . "', salesrep_id = '" . $this->db->escape($data['salesrep_id']) . "', note_content = '" . $this->db->escape($data['note_description']) . "', appointment_id = '" . $this->db->escape($data['appointment_id']) . "'WHERE note_id = '" . (int)$note_id . "'");
	}

	public function deleteNote($note_id) { 
		$this->db->query("DELETE FROM " . DB_PREFIX . "notes WHERE note_id = '" . (int)$note_id . "'");
	}

	public function getNote($note_id) {
		$query = $this->db->query("SELECT DISTINCT * FROM " . DB_PREFIX . "notes WHERE note_id = '" . (int)$note_id . "'");

		return $query->row;;
	}

	public function getNotes($data = array()) {
		$sql = "SELECT * FROM " . DB_PREFIX . "notes";

		$sql .= " WHERE appointment_id = ".$data['appointment_id']."";
		
		if (!empty($data['filter_note_title'])) {
			$sql .= " AND note_title LIKE '" . $this->db->escape($data['filter_note_title']) . "%'";
		}

		if (!empty($data['filter_salesrep_id'])) {
			$sql .= " AND salesrep_id LIKE '" . $this->db->escape($data['filter_salesrep_id']) . "'";
		}
		
		$sql .= " ORDER BY note_title";

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

	public function getTotalNotes($data = array()) {
		$sql = "SELECT COUNT(*) AS total FROM " . DB_PREFIX . "notes";
		
		$sql .= " WHERE appointment_id = ".$data['appointment_id']."";
		
		if (!empty($data['filter_note_title'])) {
			$sql .= " AND note_title LIKE '" . $this->db->escape($data['filter_note_title']) . "%'";
		}

		if (!empty($data['filter_salesrep_id'])) {
			$sql .= " AND salesrep_id LIKE '" . $this->db->escape($data['filter_salesrep_id']) . "'";
		}
		
		$query = $this->db->query($sql);
		return $query->row['total'];
	}

}