<?php
class ModelReplogicOrderQuotes extends Model {
	public function deleteOrder($quote_id) {
		$this->db->query("DELETE FROM `" . DB_PREFIX . "replogic_order_quote` WHERE quote_id = '" . (int)$quote_id . "'");
		
	}	
	
	public function getOrders($data = array()) {
		$sql = "SELECT * FROM " . DB_PREFIX . "replogic_order_quote";
		
		$sql .= " where quote_id > '0'";
		
		if (isset($data['filter_order_status'])) {
			$sql .= " AND status = '" . (int)$data['filter_order_status'] . "'";
		} 

		if (!empty($data['filter_quote_id'])) {
			$sql .= " AND quote_id = '" . (int)$data['filter_quote_id'] . "'";
		}

		if (!empty($data['filter_customer_id'])) {
			$sql .= " AND customer_id = '" . (int)$data['filter_customer_id'] . "'";
		}

		if (!empty($data['filter_date_added'])) {
			$sql .= " AND DATE(date_added) = DATE('" . $this->db->escape($data['filter_date_added']) . "')";
		}

		if (!empty($data['filter_date_modified'])) {
			$sql .= " AND DATE(date_modified) = DATE('" . $this->db->escape($data['filter_date_modified']) . "')";
		}

		if (!empty($data['filter_total'])) {
			$sql .= " AND o.total = '" . (float)$data['filter_total'] . "'";
		}

		$sort_data = array(
			'quote_id',
			'customer_id',
			'status',
			'date_added',
			'date_modified'
			
		);

		if (isset($data['sort']) && in_array($data['sort'], $sort_data)) {
			$sql .= " ORDER BY " . $data['sort'];
		} else {
			$sql .= " ORDER BY quote_id";
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
	
	public function statuschange($quote_id, $stats) {
		$query = $this->db->query("UPDATE " . DB_PREFIX . "replogic_order_quote set status = '". $stats ."' WHERE quote_id = '" . (int)$quote_id . "'");

		return $query->rows;
	}
	
	public function getOrderTotals($quote_id) {
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "replogic_order_quote WHERE quote_id = '" . (int)$quote_id . "' ORDER BY sort_order");

		return $query->rows;
	}

	public function getTotalOrders($data = array()) {
		$sql = "SELECT COUNT(*) AS total FROM `" . DB_PREFIX . "replogic_order_quote`";

		$sql .= " where quote_id > '0'";
		
		if (isset($data['filter_order_status'])) {
			$sql .= " AND status = '" . (int)$data['filter_order_status'] . "'";
		} 

		if (!empty($data['filter_quote_id'])) {
			$sql .= " AND quote_id = '" . (int)$data['filter_quote_id'] . "'";
		}

		if (!empty($data['filter_customer_id'])) {
			$sql .= " AND customer_id = '" . (int)$data['filter_customer_id'] . "'";
		}

		if (!empty($data['filter_date_added'])) {
			$sql .= " AND DATE(date_added) = DATE('" . $this->db->escape($data['filter_date_added']) . "')";
		}

		if (!empty($data['filter_date_modified'])) {
			$sql .= " AND DATE(date_modified) = DATE('" . $this->db->escape($data['filter_date_modified']) . "')";
		}

		if (!empty($data['filter_total'])) {
			$sql .= " AND o.total = '" . (float)$data['filter_total'] . "'";
		}

		$query = $this->db->query($sql);

		return $query->row['total'];
	}
	
	

}
