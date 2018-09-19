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

    public function getContactPricingExport($min,$max) {
		
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

    public function downloadCsv($min,$max) {
	
		set_time_limit(0);
		ini_set('memory_limit', '1G');
		ini_set("auto_detect_line_endings", true);
		
		$cwd = getcwd();
		$dir = (strcmp(VERSION,'3.0.0.0')>=0) ? 'library/export_import' : 'PHPExcel';
		chdir( DIR_SYSTEM.$dir );
		require_once( 'Classes/PHPExcel.php' );
		PHPExcel_Cell::setValueBinder( new PHPExcel_Cell_ExportImportValueBinder() );
		chdir( $cwd );
		
		set_time_limit( 1800 );
		
		$filename 	= "Contact-Pricing-Export-".date('d-m-Y-H:i:s').".xls";
			// create a new workbook
			$workbook = new PHPExcel();
			// set some default styles
			$workbook->getDefaultStyle()->getFont()->setName('Arial');
			$workbook->getDefaultStyle()->getFont()->setSize(10);
			//$workbook->getDefaultStyle()->getAlignment()->setIndent(0.5);
			$workbook->getDefaultStyle()->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
			$workbook->getDefaultStyle()->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
			$workbook->getDefaultStyle()->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_GENERAL);
			// pre-define some commonly used styles
			$box_format = array(
				'fill' => array(
					'type'      => PHPExcel_Style_Fill::FILL_SOLID,
					'color'     => array( 'rgb' => 'F0F0F0')
				),
			);
			
		$workbook->setActiveSheetIndex(0);
		$worksheet = $workbook->getActiveSheet();
		$worksheet->setTitle( 'Contact Pricing' );
		
		$skuExportSettings 		= 1;
		$cnameExportSettings 	= 1;
		$priceExportSettings 	= 1;
		
		$table_columns = array(array('name' => 'SKU','required'=>'1','size'=>'15'));
		
		//$skuExportSettings 	? array_push($table_columns, array('name' => 'SKU','required'=>'1','size'=>'25')) : '';
		$cnameExportSettings 	? array_push($table_columns, array('name' => 'Contact Pricing','required'=>'1','size'=>'15')) : '';
		$priceExportSettings 	? array_push($table_columns, array('name' => 'Price','required'=>'1','size'=>'25')) : '';
	    //print_r($table_columns); exit;
		
		$column = 0;
		// First Row Set height
		$worksheet->getRowDimension(1)->setRowHeight(30);
		//print_r($table_columns); exit;
	    foreach($table_columns as $field)
	    {
			$name = $field['name'];
			$size = $field['size'];
	     	$workbook->getActiveSheet()->setCellValueByColumnAndRow($column, 1, $name);
			$worksheet->getColumnDimensionByColumn($column)->setWidth($size);
			
			$alpha = array('A','B','C','D','E','F','G','H','I','J','K', 'L','M','N','O','P','Q','R','S','T','U','V','W','X ','Y','Z');
			$col = $alpha[$column]. '1';
			if($field['required'])
			{
				$worksheet->getStyle($col)->getFill()->setFillType(\PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setARGB('00ff0000');
				$style = array(
					'font' => array('bold' => true,),
					'borders' => array('allborders' => array('style' => PHPExcel_Style_Border::BORDER_THIN)),
					'alignment' => array('horizontal' => \PHPExcel_Style_Alignment::HORIZONTAL_CENTER,),
					);
				$worksheet->getStyle($col)->applyFromArray($style);
			}
			else
			{
				$style = array(
					'font' => array('bold' => true,),
					'borders' => array('allborders' => array('style' => PHPExcel_Style_Border::BORDER_THIN)),
					'alignment' => array('horizontal' => \PHPExcel_Style_Alignment::HORIZONTAL_CENTER,),
					);
				$worksheet->getStyle($col)->applyFromArray($style);
			}
			
			$column++;
			
	    }
		
		$this->load->model('catalog/price');
		$contactPricingList 	= $this->model_catalog_price->getContactPricingExport($min,$max);
		//var_dump($contactPricingList);die;
		$excel_row = 2;
		foreach ($contactPricingList as $key => $contactPricing) {
    		
			$worksheet->getRowDimension($excel_row)->setRowHeight(25);
			
            //$customerID 	= $customer['customer_id'];
            
    		$sku 	= ($skuExportSettings) 	? $contactPricing['sku'] : '';
    		$c_name = ($cnameExportSettings) 		? $contactPricing['c_name'] : '';
    		$price 	= ($priceExportSettings) 	? $contactPricing['price'] : '';
    		
			$lineData = array($sku);
			
			//$skuExportSettings 	? array_push($lineData, $sku) : '';
			$cnameExportSettings 	? array_push($lineData, $c_name) : '';
			$priceExportSettings 	? array_push($lineData, $price) : '';
			
			$i=0;
			foreach($lineData as $key => $value)
			{
				$workbook->getActiveSheet()->setCellValueByColumnAndRow($i, $excel_row, $value);
				$i++;
			}
			
		   $excel_row++;
			
    	}
		
		$object_writer = PHPExcel_IOFactory::createWriter($workbook, 'Excel5');
	  	header('Content-Type: application/vnd.ms-excel');
	  	header('Content-Disposition: attachment;filename="' . $filename . '"');
	  	$object_writer->save('php://output');
		
		
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