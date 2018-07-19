<?php
/**
 * Created by PhpStorm.
 * User: kiroshan
 * Date: 2017/03/03
 * Time: 7:22 AM
 */

class ModelCatalogPrice extends Model {

    public function addPrice($data) {
        /*  $this->db->query("INSERT INTO `" . DB_PREFIX . "price_to_contract` SET sku = '" .  $data['sku'] . "',
          contract_id = '" . $data['contract_id'] . "' ,price ='". $data['price'] ."'");*/
        $product_id = $this->getProductID($data['sku']);

        $this->db->query( "REPLACE INTO `" . DB_PREFIX . "product_to_customer_group_prices` SET product_id='".$product_id['product_id']."', customer_group_id ='".$data['customer_group_id']."' , price ='".$data['price']."'");

        $this->db->query( "REPLACE INTO `" . DB_PREFIX . "product_to_customer_group` SET product_id='".$product_id['product_id']."', customer_group_id ='".$data['customer_group_id']."'");

    }

    public function editPrice($id, $data) {
        /* $this->db->query("UPDATE `" . DB_PREFIX . "price_to_contract` SET sku = '" . $data['sku'] . "',
         contract_id = '" . $data['contract_id'] . "',price ='". $data['price'] ."' WHERE price_id = '" . $id . "'");
 */

        $product_id = $this->getProductID($data['sku']);

        $this->db->query( "UPDATE `" . DB_PREFIX . "product_to_customer_group_prices` SET product_id='".$product_id['product_id']."', customer_group_id ='".$data['customer_group_id']."' , price ='".$data['price']."'  WHERE product_id='".$product_id['product_id']."' AND customer_group_id='".$data['customer_group_id']."'");

    }

    public function deletePrice($id) { 
        $val = explode("-",$id);
		$pid = $val[0];
		$cid = $val[1];
		$this->db->query("DELETE FROM `" . DB_PREFIX . "product_to_customer_group_prices` WHERE product_id = '" . $pid . "' and customer_group_id = '" . $cid . "'");
    }

    public function getPrice($id,$customer_id) {
        //$query = $this->db->query("SELECT p2c.*, c.id AS c_id, c.contract_name AS c_name FROM oc_price_to_contract p2c INNER JOIN oc_contracts c ON p2c.contract_id = c.id WHERE price_id = '" . $id . "'");
        $query = $this->db->query("SELECT p2c.*,cgd.name AS c_name, pd.sku AS sku, cgd.customer_group_id AS c_id FROM oc_product_to_customer_group_prices p2c inner join oc_customer_group_description cgd ON p2c.customer_group_id = cgd.customer_group_id INNER JOIN oc_product pd ON p2c.product_id = pd.product_id WHERE p2c.customer_group_id = '".$customer_id."' AND p2c.product_id ='".$id."'");
        return $query->row;
    }

    public function getPrices($data = array()){

        // $sql = "SELECT p2c.*, c.id AS c_id, c.contract_name AS c_name FROM oc_price_to_contract p2c INNER JOIN oc_contracts c ON p2c.contract_id = c.id ";
        $sql = "SELECT p2c.*,cgd.name AS c_name, pd.sku AS sku, cgd.customer_group_id AS c_id FROM oc_product_to_customer_group_prices p2c inner join oc_customer_group_description cgd ON p2c.customer_group_id = cgd.customer_group_id INNER JOIN oc_product pd ON p2c.product_id = pd.product_id ";
		
		$sql .= "where p2c.product_id > 0";
		
		if (!empty($data['filter_sku'])) {
			//$sql .= " AND pd.sku = '" . $this->db->escape($data['filter_sku']) . "'";
			$sql .= " AND pd.sku LIKE '%" . $this->db->escape($data['filter_sku']) . "%'";
		}
		
		if (!empty($data['filter_customer_group_id'])) {
			$sql .= " AND cgd.customer_group_id = '" . $this->db->escape($data['filter_customer_group_id']) . "'";
		}
		
		if ($data['filter_groupby_sku']) {
			$sql .= " group By pd.sku";
		}
		
        /*
        $sort_data = array(
            'fgd.name',
            'fg.sort_order'
        );

        if (isset($data['sort']) && in_array($data['sort'], $sort_data)) {
            $sql .= " ORDER BY " . $data['sort'];
        } else {
            $sql .= " ORDER BY fgd.name";
        }

        if (isset($data['order']) && ($data['order'] == 'DESC')) {
            $sql .= " DESC";
        } else {
            $sql .= " ASC";
        }*/

        if (isset($data['start']) || isset($data['limit'])) {
            if ($data['start'] < 0) {
                $data['start'] = 0;
            }

            if ($data['limit'] < 1) {
                $data['limit'] = 20;
            }

            $sql .= " LIMIT " . (int)$data['start'] . "," . (int)$data['limit'];
        }
      
        $query = $this->db->query($sql);

        return $query->rows;
    }
    public function getTotalPrice($data= array()) {
        //$query = $this->db->query("SELECT COUNT(*) AS total FROM `" . DB_PREFIX . "product_to_customer_group_prices`");
		
		$sql = "SELECT COUNT(*) AS total FROM oc_product_to_customer_group_prices p2c inner join oc_customer_group_description cgd ON p2c.customer_group_id = cgd.customer_group_id INNER JOIN oc_product pd ON p2c.product_id = pd.product_id ";
		
		$sql .= "where p2c.product_id > 0";
		
		if (!empty($data['filter_sku'])) {
			$sql .= " AND pd.sku = '" . $this->db->escape($data['filter_sku']) . "'";
		}
		
		if (!empty($data['filter_customer_group_id'])) {
			$sql .= " AND cgd.customer_group_id = '" . $this->db->escape($data['filter_customer_group_id']) . "'";
		}
		
		$query = $this->db->query($sql);

        return $query->row['total'];
    }

    public function importCsvData($data,$contract){
        $sku = $data[0];
        $price = $data[1];
        /*$this->db->query("REPLACE INTO `" . DB_PREFIX . "price_to_contract` SET sku = '" .  $sku . "',
		contract_id = '" . $contract . "' ,price ='". $price ."'");
*/
        $product_id = $this->getProductID($sku);

        $this->db->query( "REPLACE INTO `" . DB_PREFIX . "product_to_customer_group_prices` SET product_id='".$product_id['product_id']."', customer_group_id ='".$contract."' , price ='".$price."'");
        $this->db->query( "REPLACE INTO `" . DB_PREFIX . "product_to_customer_group` SET product_id='".$product_id['product_id']."', customer_group_id ='".$contract."'");


    }
	
	public function getCustomerGroups(){
        $sql = "SELECT * FROM `" . DB_PREFIX . "customer_group_description`";

        $query = $this->db->query($sql);

        return $query->rows;
    }
	
    public function getPricesByGroupSku(){
        $sql = "SELECT p2c.*,cgd.name AS c_name, pd.sku AS sku, cgd.customer_group_id AS c_id FROM oc_product_to_customer_group_prices p2c inner join oc_customer_group_description cgd ON p2c.customer_group_id = cgd.customer_group_id INNER JOIN oc_product pd ON p2c.product_id = pd.product_id group by pd.sku";

        $query = $this->db->query($sql);

        return $query->rows;
    }

    public function getProductID($sku){
        $sql = "SELECT product_id FROM oc_product WHERE sku ='".$sku."'";

        $query = $this->db->query($sql);

        return $query->row;
    }


}