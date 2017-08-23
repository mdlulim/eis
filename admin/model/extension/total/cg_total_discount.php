<?php
class ModelExtensionTotalCgTotalDiscount extends Model {
	public function addDiscountOptions($data) {
		$this->db->query("DELETE FROM " . DB_PREFIX . "total_discount_group_options");

		if (isset($data)) {
			foreach ($data as $cgd_option) {
				$this->db->query("INSERT INTO " . DB_PREFIX . "total_discount_group_options SET customer_group_id = '" . (int)$cgd_option['customer_group'] . "', title = '" . $this->db->escape($cgd_option['title']) . "', total_from = '" . (float)$cgd_option['total_from'] . "', total_to = '" . (float)$cgd_option['total_to'] . "', discount = '" . (float)$cgd_option['discount'] . "', type = '" . $this->db->escape($cgd_option['discount_type']) . "', tax_class = '" . (int)$cgd_option['tax_class_id'] . "'");
			}
		}
	}

	public function getOptions() {
		$sql = "SELECT * FROM " . DB_PREFIX . "total_discount_group_options";
		
		$query = $this->db->query($sql);

		return $query->rows;
	
	}
}