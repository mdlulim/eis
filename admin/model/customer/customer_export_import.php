<?php
class ModelCustomerCustomerExportImport extends Model {

	public function deleteCustomerRowById($data){
		$result = null;
		if ( !empty($data['customer_id']) && empty($data['address1']) && empty($data['companyname']) && empty($data['city']) && empty($data['postcode']) && empty($data['region']) && empty($data['country']) )
		{
			$sqlCheck = "SELECT * FROM ".DB_PREFIX."customer WHERE customer_id =".$data['customer_id'];
			$result = $this->db->query($sqlCheck);
		}

		return $result;
	}

	public function checkEmailIfExist($email) { 
		
		$sel = "SELECT * from ".DB_PREFIX."customer where email = '".$email."'";
		$query = $this->db->query($sel);
		$val = $query->row;
		if($val['email'] != ''){
			return true;
		}else{
			return false;
		}
	}
	public function importCsvCustomerDataUpdate($data) {
		$customer_id = $data['customer_id'];
		
		//$this->deleteCustomerRowById($data, $customer_id);

	    if(!empty($data['companyname']) || !empty($data['telephone'])  || !empty($data['email']) || !empty($data['status'])){
			$sql = 'UPDATE '.DB_PREFIX.'customer SET ';
		}
		
		
		if ($this->config->get( 'customer_export_import_settings_companyname' ) && ($data['companyname'] != '') ) {
			$sql .= 'firstname = '.'"'.$data['companyname'].'"'.', ';
			$sql .= 'lastname = '.'"'.$data['companyname'].'"'.', ';
		}
		
		if ($this->config->get( 'customer_export_import_settings_email' ) && ($data['email'] != '') ) {
			if($this->uploadValidateEmail($data['customer_id'], $data['email']))
			{
				$sql .= 'email = "'.$data['email'].'", ';
			}
		}
		
		if ($this->config->get( 'customer_export_import_settings_paymentmethod' ) && ($data['paymentmethod'] != '') ) {
			$sql .= 'payment_method = "'.$data['paymentmethod'].'", ';
		}
		
		if ($this->config->get( 'customer_export_import_settings_telephone' ) && ($data['telephone'] != '')) {
			$sql .= 'telephone = "'.$data['telephone'].'", ';
		}
		
		if ($this->config->get( 'customer_export_import_settings_salesrep' ) && ($data['salesrep'] != '')) {
			$sql .= 'salesrep_id = "'. (int)$data['salesrep'].'", ';
		}
		
		if ($this->config->get( 'customer_export_import_settings_companygroup' ) && ($data['companygroup'] != '')) {
			if($data['companygroup'] == 0)
			{ 
				$sql .= 'customer_group_id = 1, ';
			}
			else
			{
				$sql .= 'customer_group_id = '. (int)$data['companygroup'].', ';
			}
		}
	
		if ($this->config->get( 'customer_export_import_settings_status' ) && ($data['status'] != '')) {
			if($data['status'] == 'TRUE' || $data['status'] == '=TRUE()' || $data['status'] == '1' || $data['status'] == 'True')
			{
				$data['status'] = 1;
			}
			else
			{
				$data['status'] = 0;
			}
			$sql .= 'status = "'.$data['status'].'", ';
		}
		
		$sql1 = rtrim($sql, ', '); 
		if(empty($data['companyname']) || empty($data['telephone'])  || empty($data['email']) || empty($data['status'])){
			$sql1 .= 'WHERE email='.$data['email'];
		}
		
		
		//echo $sql1; exit;
		$this->db->query($sql1);
		
		if (!empty($data['address1']) || !empty($data['companyname']) || !empty($data['city']) || !empty($data['postcode']) || !empty($data['region']) || !empty($data['country']) )
		{ 
		
			// $dlt = "DELETE FROM ".DB_PREFIX."address where customer_id = '".(int)$data['customer_id']."' and firstname = '".$data['companyname']."' and lastname = '".$data['companyname']."' and company = '".$data['companyname']."' and address_1 = '".$data['address1']."' and city = '".$data['city']."' and postcode = '".$data['postcode']."' and country_id = '".$data['country']."' and zone_id = '".$data['region']."'"; 
			
			// $this->db->query($dlt);
			
			$adr = 'INSERT '.DB_PREFIX.'address SET ';
			
			$adr .= 'customer_id = '.(int)$data['customer_id'].', ';
			
			if ($this->config->get( 'customer_export_import_settings_companyname' ) && ($data['companyname'] != '') ) {
				$adr .= 'firstname = '.'"'.$data['companyname'].'"'.', ';
				$adr .= 'lastname = '.'"'.$data['companyname'].'"'.', ';
				$adr .= 'company = '.'"'.$data['companyname'].'"'.', ';
			}
			
			if ($this->config->get( 'customer_export_import_settings_address1' ) && ($data['address1'] != '') ) {
				$adr .= 'address_1 = "'.$data['address1'].'", ';
			}
			
			if ($this->config->get( 'customer_export_import_settings_address2' ) && ($data['address2'] != '') ) {
				$adr .= 'address_2 = "'.$data['address2'].'", ';
			}
			
			if ($this->config->get( 'customer_export_import_settings_city' ) && ($data['city'] != '') ) {
				$adr .= 'city = "'.$data['city'].'", ';
			}
			
			if ($this->config->get( 'customer_export_import_settings_postcode' ) && ($data['postcode'] != '') ) {
				$adr .= 'postcode = "'.$data['postcode'].'", ';
			}
			
			if ($this->config->get( 'customer_export_import_settings_country' ) && ($data['country'] != '') ) {
				$adr .= 'country_id = "'.$data['country'].'", ';
			}
			
			if ($this->config->get( 'customer_export_import_settings_region' ) && ($data['region'] != '') ) {
				$adr .= 'zone_id = "'.$data['region'].'", ';
			}
			
			$adr1 = rtrim($adr, ', '); 
			$this->db->query($adr1);
			$address_id = $this->db->getLastId();
			if ($this->config->get( 'customer_export_import_settings_defaultaddress' ) && ($data['defaultaddress'] != '') ) 
			{
				if($data['defaultaddress'] == 'TRUE' || $data['defaultaddress'] == '=TRUE()' || $data['defaultaddress'] == '1' || $data['defaultaddress'] == 'True')
				{
					$this->db->query("UPDATE " . DB_PREFIX . "customer SET address_id = '" . (int)$address_id . "' WHERE customer_id = '" . (int)$data['customer_id'] . "'");
				}
				
			}	
		
		}
	
	}
		
	public function importCsvCustomerDataInsert($data) { 
		
		$sel = "SELECT * from ".DB_PREFIX."customer where email = '".$data['email']."'";
		$query = $this->db->query($sel);
		$val = $query->row;
		
		if($val)
		{
			$customer_id = $val['customer_id'];
		}
		else
		{
			$customer_id = '';
		}
		
		if(!empty($val['email']))
		{
			$sql = "UPDATE ".DB_PREFIX."customer SET ";
		} else {
			if(!empty($data['companyname']) && !empty($data['telephone'])  && !empty($data['email']) && !empty($data['status'])){
				$sql = 'INSERT INTO '.DB_PREFIX.'customer SET ';
				$sql .= 'date_added = NOW(), ';
			}
			
			
		}
		
		if ($this->config->get( 'customer_export_import_settings_companyname' ) && ($data['companyname'] != '') ) {
			$companyname = $data['companyname'] ;
			$sql .= 'firstname ='.'"'.$companyname.'"'.', ';
			$sql .= 'lastname ='.'"'.$companyname.'"'.', ';
			//$sql .= "lastname = ".$data['companyname'].", ";
		}
		
		if ($this->config->get( 'customer_export_import_settings_email' ) && ($data['email'] != '') ) {
			if($this->uploadValidateEmail($data['customer_id'], $data['email']))
			{
				$email =  $data['email'];
				$sql .= 'email ="'.$email.'", ';
				//$sql .= "email = '".$data['email']."', ";
			}
		}
		
		if ($this->config->get( 'customer_export_import_settings_paymentmethod' ) && ($data['paymentmethod'] != '') ) {
			$payment_method =  $data['paymentmethod'];
			$sql .= 'payment_method ="'.$payment_method.'", ';
			//$sql .= "payment_method = '".$data['paymentmethod']."', ";
		}
		
		if ($this->config->get( 'customer_export_import_settings_telephone' ) && ($data['telephone'] != '')) {
			$telephone =  $data['telephone'];
			$sql .= 'telephone ="'.$telephone.'", ';
			//$sql .= "telephone = '".$data['telephone']."', ";
		}
		
		if ($this->config->get( 'customer_export_import_settings_salesrep' ) && ($data['salesrep'] != '')) {
			$sql .= 'salesrep_id = '. (int)$data['salesrep'].', ';
		}
		
		if ($this->config->get( 'customer_export_import_settings_companygroup' ) && ($data['companygroup'] != '')) {
			if($data['companygroup'] == 0)
			{
				$customer_group_id =1;
				$sql .= 'customer_group_id ='.$customer_group_id.', ';
			}
			else
			{
				$sql .= 'customer_group_id = '. (int)$data['companygroup'].', ';
			}
		}
	
		if ($this->config->get( 'customer_export_import_settings_status' ) && ($data['status'] != '')) {
			
			if($data['status'] == 'TRUE' || $data['status'] == '=TRUE()' || $data['status'] == '1' || $data['status'] == 'True')
			{
				$data['status'] = 1;
			}
			else
			{
				$data['status'] = 0;
			}
			$sql .= 'status = '.$data['status'].', ';
		}
		
		$sql1 = rtrim($sql, ', '); 
		
        if(empty($val['email'])){
		}else{
			$sql1 .= ' WHERE email="'.$data['email'].'"';
		}
		
		$this->db->query($sql1);
		
		if(empty($customer_id))
		{
			$customer_id = $this->db->getLastId();
		}
		
		
		if (!empty($data['address1']) || !empty($data['companyname']) || !empty($data['city']) || !empty($data['postcode']) || !empty($data['region']) || !empty($data['country']) )
		{ 
			
			if($customer_id)
			{ 
				$dlt = 'DELETE FROM '.DB_PREFIX.'address where customer_id = '.(int)$customer_id.' and firstname = '.'"'.$data['companyname'].'"'.' and lastname = '.'"'.$data['companyname'].'"'.' and company = '.'"'.$data['companyname'].'"'.' and address_1 = "'.$data['address1'].'" and city = "'.$data['city'].'" and postcode = "'.$data['postcode'].'" and country_id = "'.$data['country'].'" and zone_id ="'.$data['region'].'"';
				$this->db->query($dlt);
			} 
			
			// $this->db->query($dlt);
			
			$adr = 'INSERT '.DB_PREFIX.'address SET ';
			
			if($customer_id)
			{
				$adr .= 'customer_id = '.(int)$customer_id.', ';
			}
			else
			{
				$adr .= 'customer_id = '.(int)$data['customer_id'].', ';
			}
			
			if ($this->config->get( 'customer_export_import_settings_companyname' ) && ($data['companyname'] != '') ) {
				$adr .= 'firstname = '.'"'.$data['companyname'].'"'.', ';
				$adr .= 'lastname = '.'"'.$data['companyname'].'"'.', ';
				$adr .= 'company = '.'"'.$data['companyname'].'"'.', ';
			}
			
			if ($this->config->get( 'customer_export_import_settings_address1' ) && ($data['address1'] != '') ) {
				$adr .= 'address_1 = "'.$data['address1'].'", ';
			}
			
			if ($this->config->get( 'customer_export_import_settings_address2' ) && ($data['address2'] != '') ) {
				$adr .= 'address_2 = "'.$data['address2'].'", ';
			}
			
			if ($this->config->get( 'customer_export_import_settings_city' ) && ($data['city'] != '') ) {
				$adr .= 'city = "'.$data['city'].'", ';
			}
			
			if ($this->config->get( 'customer_export_import_settings_postcode' ) && ($data['postcode'] != '') ) {
				$adr .= 'postcode = "'.$data['postcode'].'", ';
			}
			
			if ($this->config->get( 'customer_export_import_settings_country' ) && ($data['country'] != '') ) {
				$adr .= 'country_id = "'.$data['country'].'", ';
			}
			
			if ($this->config->get( 'customer_export_import_settings_region' ) && ($data['region'] != '') ) {
				$adr .= 'zone_id = '.$data['region'].', ';
			}
			
			$adr1 = rtrim($adr, ', '); 
		    //echo $adr1; exit;	
			$this->db->query($adr1);
			$address_id = $this->db->getLastId();
			//var_dump($address_id);die;
			if($customer_id )
			{
				if ($this->config->get( 'customer_export_import_settings_defaultaddress' ) && ($data['defaultaddress'] != '')) 
				{
					if($data['defaultaddress'] == 'TRUE' || $data['defaultaddress'] == '=TRUE()' || $data['defaultaddress'] == '1' || $data['defaultaddress'] == 'True')
					{
						$this->db->query("UPDATE " . DB_PREFIX . "customer SET address_id = '" . (int)$address_id . "' WHERE customer_id = '" . (int)$customer_id . "'");
					}
				}
			}
			else
			{
				if ($this->config->get( 'customer_export_import_settings_defaultaddress' ) && ($data['defaultaddress'] != '')) 
				{
					if($data['defaultaddress'] == 'TRUE' || $data['defaultaddress'] == '=TRUE()' || $data['defaultaddress'] == '1' || $data['defaultaddress'] == 'True')
					{
						$this->db->query("UPDATE " . DB_PREFIX . "customer SET address_id = '" . (int)$address_id . "' WHERE customer_id = '" . (int)$data['customer_id'] . "'");
					}
				}
			}
		
		}

		
		
	}

	public function uploadValidateEmail($customer_id, $email) {
	
	$this->load->model('customer/customer');
	$customer_info = $this->model_customer_customer->getCustomerByEmail($email);
		if (!empty($customer_id)) {
			if ($customer_info) {
				$this->error['warning'] = 'Exits';
			}
		} else {
			if ($customer_info && ($customer_id != $customer_info['customer_id'])) {
				$this->error['warning'] = 'Exits';
			}
		}
		
		return !$this->error;
	
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
		
		$filename 	= "Customer-Export-".date('d-m-Y-H:i:s').".xls";
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
		$worksheet->setTitle( 'Customers' );
		
		$emailExportSettings 		= $this->config->get( 'customer_export_import_settings_email' );
		$telephoneExportSettings 	= $this->config->get( 'customer_export_import_settings_telephone' );
		$salesRepExportSettings 	= $this->config->get( 'customer_export_import_settings_salesrep' );
		$companyGroupExportSettings = $this->config->get( 'customer_export_import_settings_companygroup' );
		$statusExportSettings 		= $this->config->get( 'customer_export_import_settings_status' );
		$address1ExportSettings 	= $this->config->get( 'customer_export_import_settings_address1' );
		$address2ExportSettings 	= $this->config->get( 'customer_export_import_settings_address2' );
		$cityExportSettings 		= $this->config->get( 'customer_export_import_settings_city' );
		$postCodeExportSettings 	= $this->config->get( 'customer_export_import_settings_postcode' );
		$countryExportSettings 		= $this->config->get( 'customer_export_import_settings_country' );
		$regionExportSettings 		= $this->config->get( 'customer_export_import_settings_region' );
		$companyNameExportSettings 	= $this->config->get( 'customer_export_import_settings_companyname' );
		$paymentmethodExportSettings 	= $this->config->get( 'customer_export_import_settings_paymentmethod' );
		$salesTeamExportSettings 	= $this->config->get( 'customer_export_import_settings_salesteam' );
		$defaultaddressExportSettings 	= $this->config->get( 'customer_export_import_settings_defaultaddress' );
		
		$table_columns = array(array('name' => 'Customer ID','required'=>'1','size'=>'15'));
		
		$companyNameExportSettings 	? array_push($table_columns, array('name' => 'Company Name','required'=>'1','size'=>'25')) : '';
		$telephoneExportSettings 	? array_push($table_columns, array('name' => 'Telephone','required'=>'1','size'=>'15')) : '';
		$emailExportSettings 	? array_push($table_columns, array('name' => 'Email','required'=>'1','size'=>'25')) : '';
		$companyGroupExportSettings 	? array_push($table_columns, array('name' => 'Contract Pricing','required'=>'1','size'=>'15')) : '';
		$paymentmethodExportSettings 	? array_push($table_columns, array('name' => 'Preferred Payment Method','required'=>'1','size'=>'25')) : '';
		$salesTeamExportSettings 	? array_push($table_columns, array('name' => 'Sales Team','required'=>'0','size'=>'18')) : '';
		$salesRepExportSettings 	? array_push($table_columns, array('name' => 'Sales Rep','required'=>'0','size'=>'18')) : '';
		$statusExportSettings 	? array_push($table_columns, array('name' => 'Account Status','required'=>'1','size'=>'15')) : '';
		$address1ExportSettings 	? array_push($table_columns, array('name' => 'Address 1','required'=>'1','size'=>'25')) : '';
		$address2ExportSettings 	? array_push($table_columns, array('name' => 'Address 2','required'=>'0','size'=>'25')) : '';
		$cityExportSettings 	? array_push($table_columns, array('name' => 'City','required'=>'1','size'=>'12')) : '';
		$postCodeExportSettings 	? array_push($table_columns, array('name' => 'Postcode','required'=>'0','size'=>'12')) : '';
		$countryExportSettings 	? array_push($table_columns, array('name' => 'Country','required'=>'1','size'=>'18')) : '';
		$regionExportSettings 	? array_push($table_columns, array('name' => 'Region/State','required'=>'1','size'=>'18')) : '';
		$defaultaddressExportSettings 	? array_push($table_columns, array('name' => 'Default Address','required'=>'0','size'=>'15')) : '';
		
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
		
		$this->load->model('customer/customer');
		$customers 	= $this->model_customer_customer->getCustomersCustomerExportImport($min,$max);
		
		$excel_row = 2;
		foreach ($customers as $key => $customer) {
    		
			$worksheet->getRowDimension($excel_row)->setRowHeight(25);
			
			$customerID 	= $customer['customer_id'];
    		$companyname 	= ($companyNameExportSettings) 	? $customer['firstname'] : '';
    		$email 			= ($emailExportSettings) 		? $customer['email'] : '';
    		$telephone 		= ($telephoneExportSettings) 	? $customer['telephone'] : '';
    		$address1 		= ($address1ExportSettings) 	? $customer['address_1'] : '';
    		$address2 		= ($address2ExportSettings) 	? $customer['address_2'] : '';
    		$city 			= ($cityExportSettings) 		? $customer['city'] : '';
    		$postcode 		= ($postCodeExportSettings) 	? $customer['postcode'] : '';
    		$country 		= ($countryExportSettings) 		? $customer['country'] : '';
    		$region 		= ($regionExportSettings) 		? $customer['region'] : '';
    		$customer_group = ($companyGroupExportSettings) ? $customer['customer_group'] : '';
    		$salesrep 		= ($salesRepExportSettings) ? $customer['salesrep'] : '';
			$salesteam 		= ($salesTeamExportSettings) ? $customer['salesteam'] : '';
			$payment_method = ($paymentmethodExportSettings) ? $customer['payment_method'] : '';
    		
			if ($defaultaddressExportSettings) {
    			$defaultaddress = ($customer['address_id'] == '0') ? 'False' : 'True';
    		} else {
    			$defaultaddress = '';
    		}
    		if ($statusExportSettings) {
    			$status = ($customer['status'] == '1') ? 'True' : 'False';
    		} else {
    			$status = '';
    		}
    		
			$lineData = array($customerID);
			
			$companyNameExportSettings 	? array_push($lineData, $companyname) : '';
			$telephoneExportSettings 	? array_push($lineData, $telephone) : '';
			$emailExportSettings 	? array_push($lineData, $email) : '';
			$companyGroupExportSettings 	? array_push($lineData, $customer_group) : '';
			$paymentmethodExportSettings 	? array_push($lineData, $payment_method) : '';
			$salesTeamExportSettings 	? array_push($lineData, $salesteam) : '';
			$salesRepExportSettings 	? array_push($lineData, $salesrep) : '';
			$statusExportSettings 	? array_push($lineData, $status) : '';
			$address1ExportSettings 	? array_push($lineData, $address1) : '';
			$address2ExportSettings 	? array_push($lineData, $address2) : '';
			$cityExportSettings 	? array_push($lineData, $city) : '';
			$postCodeExportSettings 	? array_push($lineData, $postcode) : '';
			$countryExportSettings 	? array_push($lineData, $country) : '';
			$regionExportSettings 	? array_push($lineData, $region) : '';
			$defaultaddressExportSettings 	? array_push($lineData, $defaultaddress) : '';
			
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
	
	public function downloadCsv1($min,$max) {
	
		set_time_limit(0);
		ini_set('memory_limit', '1G');
		ini_set("auto_detect_line_endings", true);
		
		$this->load->model('customer/customer');
		$customers 	= $this->model_customer_customer->getCustomersCustomerExportImport($min,$max);
		//print_r($customers); exit;
		$filename 	= "Customer-Export-".date('d-m-Y-H:i:s').".csv";
		$delimiter 	= ",";
		// set customer export/import configuration settings
		//$firstnameExportSettings 	= $this->config->get( 'customer_export_import_settings_firstname' );
		//$lastnameExportSettings 		= $this->config->get( 'customer_export_import_settings_lastname' );
		$emailExportSettings 		= $this->config->get( 'customer_export_import_settings_email' );
		$telephoneExportSettings 	= $this->config->get( 'customer_export_import_settings_telephone' );
		$salesRepExportSettings 	= $this->config->get( 'customer_export_import_settings_salesrep' );
		$companyGroupExportSettings = $this->config->get( 'customer_export_import_settings_companygroup' );
		//$newsletterExportSettings 	= $this->config->get( 'customer_export_import_settings_newsletter' );
		$statusExportSettings 		= $this->config->get( 'customer_export_import_settings_status' );
		//$passwordExportSettings 	= $this->config->get( 'customer_export_import_settings_password' );
		$approvedExportSettings 	= $this->config->get( 'customer_export_import_settings_approved' );
		$address1ExportSettings 	= $this->config->get( 'customer_export_import_settings_address1' );
		$address2ExportSettings 	= $this->config->get( 'customer_export_import_settings_address2' );
		$cityExportSettings 		= $this->config->get( 'customer_export_import_settings_city' );
		$postCodeExportSettings 	= $this->config->get( 'customer_export_import_settings_postcode' );
		$countryExportSettings 		= $this->config->get( 'customer_export_import_settings_country' );
		$regionExportSettings 		= $this->config->get( 'customer_export_import_settings_region' );
		$companyNameExportSettings 	= $this->config->get( 'customer_export_import_settings_companyname' );
		$paymentmethodExportSettings 	= $this->config->get( 'customer_export_import_settings_paymentmethod' );
		$salesTeamExportSettings 	= $this->config->get( 'customer_export_import_settings_salesteam' );
		$defaultaddressExportSettings 	= $this->config->get( 'customer_export_import_settings_defaultaddress' );
		// create a file pointer
    	$f = fopen('php://memory', 'w');
    	$fields = array('Customer ID');
		
		//$firstnameExportSettings 	? array_push($fields, 'First Name') : '';
		//$lastnameExportSettings 	? array_push($fields, 'Last Name') : '';
		$companyNameExportSettings 	? array_push($fields, 'Company Name') : '';
		$telephoneExportSettings 	? array_push($fields, 'Telephone') : '';
		$emailExportSettings 	? array_push($fields, 'Email') : '';
		$companyGroupExportSettings 	? array_push($fields, 'Contract Pricing') : '';
		$paymentmethodExportSettings 	? array_push($fields, 'Preferred Payment Method') : '';
		$salesTeamExportSettings 	? array_push($fields, 'Sales Team') : '';
		$salesRepExportSettings 	? array_push($fields, 'Sales Rep') : '';
		$statusExportSettings 	? array_push($fields, 'Account Status') : '';
		$address1ExportSettings 	? array_push($fields, 'Address 1') : '';
		$address2ExportSettings 	? array_push($fields, 'Address 2') : '';
		$cityExportSettings 	? array_push($fields, 'City') : '';
		$postCodeExportSettings 	? array_push($fields, 'Postcode') : '';
		$countryExportSettings 	? array_push($fields, 'Country') : '';
		$regionExportSettings 	? array_push($fields, 'Region/State') : '';
		//$passwordExportSettings 	? array_push($fields, 'Password') : '';
		//$newsletterExportSettings 	? array_push($fields, 'Newsletter') : '';
		$approvedExportSettings 	? array_push($fields, 'Approved') : '';
		$defaultaddressExportSettings 	? array_push($fields, 'Default Address') : '';
		
		
		fputcsv($f, $fields, $delimiter);
    	// output each row of the data, format line as csv and write to file pointer
		//print_r($customers); exit;
    	foreach ($customers as $key => $customer) {
    		$customerID 	= $customer['customer_id'];
    		$companyname 		= ($companyNameExportSettings) 	? $customer['firstname'] : '';
    		//$lastname 		= ($lastnameExportSettings) 	? $customer['lastname'] : '';
    		$email 			= ($emailExportSettings) 		? $customer['email'] : '';
    		$telephone 		= ($telephoneExportSettings) 	? $customer['telephone'] : '';
    		//$companyname 	= ($companyNameExportSettings) 	? $customer['companyname'] : '';
    		$address1 		= ($address1ExportSettings) 	? $customer['address_1'] : '';
    		$address2 		= ($address2ExportSettings) 	? $customer['address_2'] : '';
    		$city 			= ($cityExportSettings) 		? $customer['city'] : '';
    		$postcode 		= ($postCodeExportSettings) 	? $customer['postcode'] : '';
    		$country 		= ($countryExportSettings) 		? $customer['country'] : '';
    		$region 		= ($regionExportSettings) 		? $customer['region'] : '';
    		//$password 		= ($passwordExportSettings) 	? $customer['password'] : '';
    		$customer_group = ($companyGroupExportSettings) ? $customer['customer_group'] : '';
    		$salesrep 		= ($salesRepExportSettings) ? $customer['salesrep'] : '';
			$salesteam 		= ($salesTeamExportSettings) ? $customer['salesteam'] : '';
			$payment_method = ($paymentmethodExportSettings) ? $customer['payment_method'] : '';
    		
			if ($defaultaddressExportSettings) {
    			$defaultaddress = ($customer['address_id'] == '0') ? 'False' : 'True';
    		} else {
    			$defaultaddress = '';
    		}
    		if ($statusExportSettings) {
    			$status = ($customer['status'] == '1') ? 'True' : 'False';
    		} else {
    			$status = '';
    		}
    		
			$lineData = array($customerID);
			
			//$firstnameExportSettings 	? array_push($lineData, $firstname) : '';
			//$lastnameExportSettings 	? array_push($lineData, $lastname) : '';
			$companyNameExportSettings 	? array_push($lineData, $companyname) : '';
			$telephoneExportSettings 	? array_push($lineData, $telephone) : '';
			$emailExportSettings 	? array_push($lineData, $email) : '';
			$companyGroupExportSettings 	? array_push($lineData, $customer_group) : '';
			$paymentmethodExportSettings 	? array_push($lineData, $payment_method) : '';
			$salesTeamExportSettings 	? array_push($lineData, $salesteam) : '';
			$salesRepExportSettings 	? array_push($lineData, $salesrep) : '';
			$statusExportSettings 	? array_push($lineData, $status) : '';
			$address1ExportSettings 	? array_push($lineData, $address1) : '';
			$address2ExportSettings 	? array_push($lineData, $address2) : '';
			$cityExportSettings 	? array_push($lineData, $city) : '';
			$postCodeExportSettings 	? array_push($lineData, $postcode) : '';
			$countryExportSettings 	? array_push($lineData, $country) : '';
			$regionExportSettings 	? array_push($lineData, $region) : '';
			//$passwordExportSettings 	? array_push($lineData, $password) : '';
			//$newsletterExportSettings 	? array_push($lineData, $newsletter) : '';
			$approvedExportSettings 	? array_push($lineData, $approved) : '';
			$defaultaddressExportSettings 	? array_push($lineData, $defaultaddress) : '';
			
			fputcsv($f, $lineData, $delimiter);
    	}
    	//move back to beginning of file
    	fseek($f, 0);
    	//set headers to download file rather than displayed
	    header('Content-Type: text/csv');
	    header('Content-Disposition: attachment; filename="' . $filename . '";');
	    
	    //output all remaining data on a file pointer
	    fpassthru($f);
	    exit;
		
	}
	
}
?>