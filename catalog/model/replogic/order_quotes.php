<?php
class ModelReplogicOrderQuotes extends Model {
	public function deleteOrder($quote_id) {
		$this->db->query("DELETE FROM `" . DB_PREFIX . "replogic_order_quote` WHERE quote_id = '" . (int)$quote_id . "'");
		
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
	
	public function QuoteOrderIdUpdate($quote_id, $order_id) {
		$query = $this->db->query("UPDATE " . DB_PREFIX . "replogic_order_quote set order_id = '". $order_id ."' WHERE quote_id = '" . (int)$quote_id . "'");

		return $query->row;
	}
	
	public function QuoteCustomerContactIdUpdate($quote_id, $customer_contact_id) {
		$query = $this->db->query("UPDATE " . DB_PREFIX . "replogic_order_quote set customer_contact_id = '". $customer_contact_id ."' WHERE quote_id = '" . (int)$quote_id . "'");

		return $query->row;
	}
	
	public function SalesRepOrderIdTable($salesrep_id,$ord_id) {
		
		$query = $this->db->query("DELETE FROM " . DB_PREFIX . "salesrep_to_order WHERE salesrep_id = '" . $salesrep_id . "' AND order_id = '" . (int)$ord_id . "'");

		$this->db->query("INSERT " . DB_PREFIX . "salesrep_to_order SET salesrep_id = '" . $salesrep_id . "', order_id = '" . $ord_id . "'");
		
	}
	
	public function OrderTableIsReplogicUpdate($ord_id) {
		
		$query = $this->db->query("UPDATE " . DB_PREFIX . "order set isReplogic = 1 WHERE order_id = '" . (int)$ord_id . "'");

		return $query->row;
		
	}
	
	public function CustomerContactOrderIdTable($customer_contact_id,$ord_id) {
		
		$query = $this->db->query("DELETE FROM " . DB_PREFIX . "customercontact_to_order WHERE customer_contact_id = '" . $customer_contact_id . "' AND order_id = '" . (int)$ord_id . "'");

		$this->db->query("INSERT " . DB_PREFIX . "customercontact_to_order SET customer_contact_id = '" . $customer_contact_id . "', order_id = '" . $ord_id . "'");
		
	}
	
	

}
