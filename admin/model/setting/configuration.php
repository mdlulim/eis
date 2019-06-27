<?php
class ModelSettingConfiguration extends Model {
    public function getTypes() {

		$query = $this->db->query("SELECT category FROM " . DB_PREFIX . "config_field WHERE status = 1 GROUP BY category ORDER BY category ASC");

		return $query->rows;
	}

	public function get($category, $key = null) {

		if (!is_null($key)) {
			$key   = strtolower($category . '_' . $key);
			$query = $this->db->query("SELECT cf.*, cg.value FROM " . DB_PREFIX . "config_field cf LEFT JOIN " . DB_PREFIX . "config cg ON cg.config_field_id = cf.config_field_id WHERE category = '" . $category . "' AND status = 1 AND `key` = '" . $this->db->escape($key) . "'");
			return $query->row;
		} else {
			$query = $this->db->query("SELECT cf.*, cg.value FROM " . DB_PREFIX . "config_field cf LEFT JOIN " . DB_PREFIX . "config cg ON cg.config_field_id = cf.config_field_id WHERE category = '" . $category . "' AND status = 1 ORDER BY sort_order ASC, section ASC, cf.config_field_id ASC");

			return $query->rows;
		}
	}

	public function addConfigField($data) {
		$key = strtolower($data['category'] . '_' . str_replace(array(' ', '-'), '_', $data['name']));
		$sql = "INSERT INTO " . DB_PREFIX . "config_field SET `name` = '" . $this->db->escape($data['name']) . "', `key` = '" . $this->db->escape($key) . "', `category` = '" . $this->db->escape($data['category']) . "', `type` = '" . $this->db->escape($data['type']) . "', `length` = '" . (int)$this->db->escape($data['length']) . "', `values` = '" . $this->db->escape($data['values']) . "', `help` = '" . $this->db->escape($data['help']) . "', `section` = '" . $this->db->escape($data['section']) . "'";
		$this->db->query($sql);
		$config_field_id = $this->db->getLastId();
		$this->db->query("INSERT INTO " . DB_PREFIX . "config SET `config_field_id` = '" . $config_field_id . "', `value` = ''");
		return $config_field_id;
	}

	public function set($data) {
		$this->db->query("UPDATE " . DB_PREFIX . "config SET `value` = '" . $this->db->escape($data['value']) . "' WHERE `config_field_id` = " . (int)$data['config_field_id']);
	}
}