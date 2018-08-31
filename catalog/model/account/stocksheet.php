<?php
class ModelAccountStocksheet extends Model {
	public function addWishlist($product_id) {
		$this->db->query("DELETE FROM " . DB_PREFIX . "customer_wishlist WHERE customer_id = '" . (int)$this->customer->getId() . "' AND product_id = '" . (int)$product_id . "'");

		$this->db->query("INSERT INTO " . DB_PREFIX . "customer_wishlist SET customer_id = '" . (int)$this->customer->getId() . "', product_id = '" . (int)$product_id . "', date_added = NOW()");
	}

	public function deleteStocksheet($sku) {
		$this->db->query("DELETE FROM " . DB_PREFIX . "stocksheet WHERE customer_id = '" . (int)$this->customer->getId() . "' AND sku = '" . (int)$sku . "'");
	}

	public function getStocksheet() {
        $query = $this->db->query("SELECT * FROM " . DB_PREFIX . "stocksheet WHERE customer_id = '" . (int)$this->customer->getId() . "'");

		return $query->rows;
	}

	public function getTotalWishlist() {
		$query = $this->db->query("SELECT COUNT(*) AS total FROM " . DB_PREFIX . "stocksheet WHERE customer_id = '" . (int)$this->customer->getId() . "'");

		return $query->row['total'];
	}
}
