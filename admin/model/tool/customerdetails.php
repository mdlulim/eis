<?php
class ModelToolCustomerdetails extends Model {
	public function getDetails($customer_id) {
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "customer_extranotes WHERE customer_id = '".(int)$customer_id."' LIMIT 1");
		return $query->row;
	}

	public function getOtherDetails($customer_id) {
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "customer WHERE customer_id = '".(int)$customer_id."' LIMIT 1");
		return $query->row['telephone'];
	}

	public function getAddressDetails($customer_id) {
		$address_query = $this->db->query("SELECT a.address_1,a.city,a.zone_id,a.country_id FROM " . DB_PREFIX . "address a LEFT JOIN  " . DB_PREFIX . "customer c ON (c.address_id = a.address_id)  WHERE a.customer_id = '" . (int)$customer_id . "'");
		
		if ($address_query->num_rows) {
			$country_query = $this->db->query("SELECT * FROM `" . DB_PREFIX . "country` WHERE country_id = '" . (int)$address_query->row['country_id'] . "'");

			if ($country_query->num_rows) {
				$country = $country_query->row['name'];
			} else {
				$country = '';
			}

			$zone_query = $this->db->query("SELECT * FROM `" . DB_PREFIX . "zone` WHERE zone_id = '" . (int)$address_query->row['zone_id'] . "'");

			if ($zone_query->num_rows) {
				$zone = $zone_query->row['name'];
			} else {
				$zone = '';
			}

			$address_data = array(
				'address_1'      => $address_query->row['address_1'],
				'city'           => $address_query->row['city'],
				'zone'           => $zone,
				'country'        => $country,
			);

			return "<b>Default Address:</b> ".implode(", ", $address_data);
		} else {
			return false;
		}
	}

	public function createTable() {
		 if ($this->db->query("SHOW TABLES LIKE '". DB_PREFIX ."customer_extranotes'")->num_rows == 0) {
            $sql = "CREATE TABLE IF NOT EXISTS `" . DB_PREFIX . "customer_extranotes` (
					  `customer_id` int(11) NOT NULL,
        		      `customer_grade` varchar(8) NOT NULL,
        		      `customer_notes` text NOT NULL)
  					  ENGINE=MyISAM COLLATE=utf8_general_ci";
       			  $this->db->query($sql);
        }
	}
}