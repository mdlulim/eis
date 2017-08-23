<?php
class ModelExtensionPaymentPaygate extends Model {

	public function getMethod($address, $total){
		$this->load->language('extension/payment/paygate');

		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "zone_to_geo_zone WHERE geo_zone_id = '" . (int)$this->config->get('paygate_geo_zone_id') . "' AND country_id = '" . (int)$address['country_id'] . "' AND (zone_id = '" . (int)$address['zone_id'] . "' OR zone_id = '0')");

		if($this->config->get('paygate_total') > 0 && $this->config->get('paygate_total') > $total){
			$status = false;
		} elseif(!$this->config->get('paygate_geo_zone_id')) {
			$status = true;
		} elseif($query->num_rows) {
			$status = true;
		} else {
			$status = false;
		}

		$method_data = array();

		if($status){
			$method_data = array(
				'code'       => 'paygate',
				'title'      => $this->language->get('text_paygate_checkout'),
				'terms'      => '',
				'sort_order' => $this->config->get('paygate_sort_order')
			);
		}

		return $method_data;
	}
}