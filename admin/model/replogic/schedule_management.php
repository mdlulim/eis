<?php
class ModelReplogicScheduleManagement extends Model {
	public function addScheduleManagement($data) {
		$this->db->query("INSERT INTO " . DB_PREFIX . "appointment SET appointment_name = '" . $this->db->escape($data['appointment_name']) . "', appointment_description = '" . $this->db->escape($data['appointment_description']) . "',salesrep_id = '" . $this->db->escape($data['salesrep_id']) . "',appointment_date = '" . $this->db->escape($data['appointment_date']) . "',customer_id = '" . $this->db->escape($data['customer_id']) . "'");
	
		return $this->db->getLastId();
	}

	public function editScheduleManagement($appointment_id, $data) {
		$this->db->query("UPDATE " . DB_PREFIX . "appointment SET appointment_name = '" . $this->db->escape($data['appointment_name']) . "', appointment_description = '" . $this->db->escape($data['appointment_description']) . "',salesrep_id = '" . $this->db->escape($data['salesrep_id']) . "',appointment_date = '" . $this->db->escape($data['appointment_date']) . "',customer_id = '" . $this->db->escape($data['customer_id']) . "' WHERE appointment_id = '" . (int)$appointment_id . "'");
	}

	public function deleteAppointment($appointment_id) {
		$this->db->query("DELETE FROM " . DB_PREFIX . "appointment WHERE appointment_id = '" . (int)$appointment_id . "'");
	}

	public function getappointment($appointment_id) {
		$query = $this->db->query("SELECT DISTINCT * FROM " . DB_PREFIX . "appointment WHERE appointment_id = '" . (int)$appointment_id . "'");

		return $query->row;
	}

	public function getScheduleManagement($data = array()) {
		$sql = "SELECT * FROM " . DB_PREFIX . "appointment";

		$sql .= " ORDER BY appointment_name";

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
		$query = $this->db->query("SELECT COUNT(*) AS total FROM " . DB_PREFIX . "appointment");

		return $query->row['total'];
	}

}