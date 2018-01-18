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
		
		if (!empty($data['filter_salesrep_id'])) {
			$sql .= " AND salesrep_id = '" . (int)$data['filter_salesrep_id'] . "'";
		}

		if (!empty($data['filter_customer_id'])) {
			$sql .= " AND customer_id = '" . (int)$data['filter_customer_id'] . "'";
		}
		
		if (!empty($data['filter_customer_contact_id'])) {
			$sql .= " AND customer_contact_id = '" . (int)$data['filter_customer_contact_id'] . "'";
		}

		if (!empty($data['filter_date_added'])) {
			$sql .= " AND DATE(date_added) = DATE('" . $this->db->escape($data['filter_date_added']) . "')";
		}

		if (!empty($data['filter_date_modified'])) {
			$sql .= " AND DATE(date_modified) = DATE('" . $this->db->escape($data['filter_date_modified']) . "')";
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
	
	public function getOrderquote($quote_id) {
	
		$sql = "SELECT * FROM " . DB_PREFIX . "replogic_order_quote where quote_id = ".$quote_id;
		$query = $this->db->query($sql);

		return $query->row;
	
	}
	
	public function statuschange($quote_id, $stats) {
		$query = $this->db->query("UPDATE " . DB_PREFIX . "replogic_order_quote set status = '". $stats ."' WHERE quote_id = '" . (int)$quote_id . "'");

		return $query->rows;
	}
	
	public function Declinestatuschange($quote_id, $reason) {
		$query = $this->db->query("UPDATE " . DB_PREFIX . "replogic_order_quote set status = '2', comments = '".$reason."' WHERE quote_id = '" . (int)$quote_id . "'");

		return $query->row;
	}
	
	public function QuoteOrderIdUpdate($quote_id, $order_id) {
		$query = $this->db->query("UPDATE " . DB_PREFIX . "replogic_order_quote set order_id = '". $order_id ."' WHERE quote_id = '" . (int)$quote_id . "'");

		return $query->row;
	}
	
	public function SalesRepOrderIdTable($salesrep_id,$ord_id) {
		
		$query = $this->db->query("DELETE FROM " . DB_PREFIX . "salesrep_to_order WHERE salesrep_id = '" . $salesrep_id . "' AND order_id = '" . (int)$ord_id . "'");

		$this->db->query("INSERT " . DB_PREFIX . "salesrep_to_order SET salesrep_id = '" . $salesrep_id . "', order_id = '" . $ord_id . "'");
		
	}
	
	public function CustomerContactOrderIdTable($customer_contact_id,$ord_id) {
		
		$query = $this->db->query("DELETE FROM " . DB_PREFIX . "customercontact_to_order WHERE customer_contact_id = '" . $customer_contact_id . "' AND order_id = '" . (int)$ord_id . "'");

		$this->db->query("INSERT " . DB_PREFIX . "customercontact_to_order SET customer_contact_id = '" . $customer_contact_id . "', order_id = '" . $ord_id . "'");
		
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
		
		if (!empty($data['filter_salesrep_id'])) {
			$sql .= " AND salesrep_id = '" . (int)$data['filter_salesrep_id'] . "'";
		}
		
		if (!empty($data['filter_quote_id'])) {
			$sql .= " AND quote_id = '" . (int)$data['filter_quote_id'] . "'";
		}

		if (!empty($data['filter_customer_id'])) {
			$sql .= " AND customer_id = '" . (int)$data['filter_customer_id'] . "'";
		}
		
		if (!empty($data['filter_customer_contact_id'])) {
			$sql .= " AND customer_contact_id = '" . (int)$data['filter_customer_contact_id'] . "'";
		}

		if (!empty($data['filter_date_added'])) {
			$sql .= " AND DATE(date_added) = DATE('" . $this->db->escape($data['filter_date_added']) . "')";
		}

		if (!empty($data['filter_date_modified'])) {
			$sql .= " AND DATE(date_modified) = DATE('" . $this->db->escape($data['filter_date_modified']) . "')";
		}

		$query = $this->db->query($sql);

		return $query->row['total'];
	}
	
	

}
