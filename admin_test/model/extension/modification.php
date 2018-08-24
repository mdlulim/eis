<?php
class ModelExtensionModification extends Model {
	public function addModification($data) {
		$this->db->query("INSERT INTO " . DB_PREFIX . "modification SET code = '" . $this->db->escape($data['code']) . "', name = '" . $this->db->escape($data['name']) . "', author = '" . $this->db->escape($data['author']) . "', version = '" . $this->db->escape($data['version']) . "', link = '" . $this->db->escape($data['link']) . "', xml = '" . $this->db->escape($data['xml']) . "', status = '" . (int)$data['status'] . "', date_added = NOW()");
	}

	public function deleteModification($modification_id) {
		$this->db->query("DELETE FROM " . DB_PREFIX . "modification WHERE modification_id = '" . (int)$modification_id . "'");
	}

	public function enableModification($modification_id) {
		$this->db->query("UPDATE " . DB_PREFIX . "modification SET status = '1' WHERE modification_id = '" . (int)$modification_id . "'");
	}

	public function disableModification($modification_id) {
		$this->db->query("UPDATE " . DB_PREFIX . "modification SET status = '0' WHERE modification_id = '" . (int)$modification_id . "'");
	}

	public function getModification($modification_id) {
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "modification WHERE modification_id = '" . (int)$modification_id . "'");

		return $query->row;
	}

	public function getModifications($data = array()) {
		$sql = "SELECT * FROM " . DB_PREFIX . "modification";
		
		$sql .=" where modification_id > 0";
		
		if (!empty($data['filter_modification_id'])) {
			$sql .= " AND modification_id = '" . $this->db->escape($data['filter_modification_id']) . "'";
		}
		
		if (!empty($data['filter_author_name'])) {
			$sql .= " AND author = '" . $this->db->escape($data['filter_author_name']) . "'";
		}
		
		if (!empty($data['filter_version'])) {
			$sql .= " AND version = '" . $this->db->escape($data['filter_version']) . "'";
		}
		
		if (isset($data['filter_status']) && !is_null($data['filter_status'])) {
			$sql .= " AND status = '" . (int)$data['filter_status'] . "'";
		}
		
		if (isset($data['filter_date_added'])) {
			
			$fromdate = date('Y-m-d H:i:s', strtotime($data['filter_date_added'])); 
			$todate1 = date('Y-m-d', strtotime($data['filter_date_added'])); 
			$todate = $todate1." 23:59:59"; 
			$sql .= " AND date_added >= '" . $fromdate . "' AND date_added <= '" . $todate . "'";
			
		}

		$sort_data = array(
			'name',
			'author',
			'version',
			'status',
			'date_added'
		);

		if (isset($data['sort']) && in_array($data['sort'], $sort_data)) {
			$sql .= " ORDER BY " . $data['sort'];
		} else {
			$sql .= " ORDER BY name";
		}

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
	
	public function getModificationsByGroup($group) {
		
		$sql = "SELECT * FROM " . DB_PREFIX . "modification group by ".$group."";
		$query = $this->db->query($sql);

		return $query->rows;
		
	}
	
	public function getTotalModifications($data = array()) {
		$sql = "SELECT COUNT(*) AS total FROM " . DB_PREFIX . "modification";
		
		$sql .=" where modification_id > 0";
		
		if (!empty($data['filter_modification_id'])) {
			$sql .= " AND modification_id = '" . $this->db->escape($data['filter_modification_id']) . "'";
		}
		
		if (!empty($data['filter_author_name'])) {
			$sql .= " AND author = '" . $this->db->escape($data['filter_author_name']) . "'";
		}
		
		if (!empty($data['filter_version'])) {
			$sql .= " AND version = '" . $this->db->escape($data['filter_version']) . "'";
		}
		
		if (isset($data['filter_status']) && !is_null($data['filter_status'])) {
			$sql .= " AND status = '" . (int)$data['filter_status'] . "'";
		}
		
		if (isset($data['filter_date_added'])) {
			$fromdate = date('Y-m-d H:i:s', strtotime($data['filter_date_added'])); 
			$todate1 = date('Y-m-d', strtotime($data['filter_date_added'])); 
			$todate = $todate1." 23:59:59"; 
			$sql .= " AND date_added >= '" . $fromdate . "' AND date_added <= '" . $todate . "'";
		}
		
		$query = $this->db->query($sql);

		return $query->row['total'];
	}
	
	public function getModificationByCode($code) {
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "modification WHERE code = '" . $this->db->escape($code) . "'");

		return $query->row;
	}	
}