<?php
class ModelExtensionTotalCgTotalDiscount extends Model {
	public function getTotal($total ) {

		$this->load->language('extension/total/cg_total_discount');

		$discount_total = 0;
		$discount = 0;

		if (!$this->customer->getGroupId()){
        	$cgid = $this->config->get('config_customer_group_id');
        } else {
        	$cgid = $this->customer->getGroupId();
        }
        
        
        $all_cg_total_discounts = $this->config->get('cg_total_discount');
		$cg_total_discount = $all_cg_total_discounts[$cgid];
		
     	$cart_total = $this->cart->getTotal();
     	$sub_total = $this->cart->getSubTotal();
     	
     	$options = array();
     	$options = $this->model_extension_total_cg_total_discount->getDiscountByCustomerGroup($cgid, $cart_total);
     	
     	foreach($options as $option){
     		$options = array(
     			'cgtitle' => $option['title'],
     			'cgdiscount' => $option['discount'],
     			'cgdiscount_type' => $option['type'],
     			'cgtax_class' => $option['tax_class']
     			
     		);
     	
     	}
        
        if ($cg_total_discount['status'] && !empty($options)) {
			if ($options['cgdiscount_type'] == 'F') {
				$discount = $options['cgdiscount'];
			} elseif ($options['cgdiscount_type'] == 'P') {
				$discount = ($options['cgdiscount'] / 100) * $cart_total;
			}
						
			if ($options['cgtax_class']) {
				$tax_rates = $this->tax->getRates($sub_total - ($sub_total - $discount), $options['cgtax_class']);

				foreach ($tax_rates as $tax_rate) {
					if ($tax_rate['type'] == 'P') {
						$taxes[$tax_rate['tax_rate_id']] -= $tax_rate['amount'];
						}
					}
				}
		}

		$discount_total += $discount;
        
        if ($discount_total > $cart_total) {
			$discount_total = $cart_total;
		}

		if ($cg_total_discount['status'] && !empty($options)) {
			$total['totals'][] = array(
				'code'       => 'cg_total_discount',
				'title'		 => (!empty($options['cgtitle']) ? sprintf($this->language->get('text_customer_group_discount_title'), $options['cgtitle']) : $this->language->get('text_customer_group_discount')),
				'value'      => -$discount_total,
				'sort_order' => $this->config->get('cg_total_discount_sort_order')
			);
			

			$total['total'] -= $discount_total;
			
		}
		
	}
	
	public function getDiscountByCustomerGroup($cgid, $sub_total){
		$sql = "SELECT * FROM " . DB_PREFIX . "total_discount_group_options WHERE customer_group_id = '" . (int)$cgid . "' AND $sub_total BETWEEN total_from AND total_to";
		$query = $this->db->query($sql);

		return $query->rows;
		}
		
		
	
	
	
}