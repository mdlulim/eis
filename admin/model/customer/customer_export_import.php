<?php

class ModelCustomerCustomerExportImport extends Model {

	public function importCsvCustomerDataUpdate($data) {
	
		$sql = "UPDATE ".DB_PREFIX."customer SET ";
		
		if ($this->config->get( 'customer_export_import_settings_firstname' ) && ($data['firstname'] != '') ) {
			$sql .= "firstname = '".$data['firstname']."', ";
		}
		
		if ($this->config->get( 'customer_export_import_settings_lastname' ) && ($data['lastname'] != '') ) {
			$sql .= "lastname = '".$data['lastname']."', ";
		}
		
		if ($this->config->get( 'customer_export_import_settings_email' ) && ($data['email'] != '') ) {
			if($this->uploadValidateEmail($data['customer_id'], $data['email']))
			{
				$sql .= "email = '".$data['email']."', ";
			}
		}
		
		if ($this->config->get( 'customer_export_import_settings_telephone' ) && ($data['telphone'] != '')) {
			$sql .= "telephone = '".$data['telphone']."', ";
		}
		
		if ($this->config->get( 'customer_export_import_settings_salesrep' ) && ($data['salesrep'] != '')) {
			$sql .= "salesrep_id = '". (int)$data['salesrep']."', ";
		}
		
		if ($this->config->get( 'customer_export_import_settings_companygroup' ) && ($data['companygroup'] != '')) {
			$sql .= "customer_group_id = '". (int)$data['companygroup']."', ";
		}
	
		if ($this->config->get( 'customer_export_import_settings_newsletter' ) && ($data['newsletter'] != '')) {
			if($data['newsletter'] == 'TRUE')
			{
				$data['newsletter'] = 1;
			}
			else
			{
				$data['newsletter'] = 0;
			}
			$sql .= "newsletter = '".$data['newsletter']."', ";
		}
		
		if ($this->config->get( 'customer_export_import_settings_status' ) && ($data['status'] != '')) {
			if($data['status'] == 'TRUE')
			{
				$data['status'] = 1;
			}
			else
			{
				$data['status'] = 0;
			}
			$sql .= "status = '".$data['status']."', ";
		}
		
		if ($this->config->get( 'customer_export_import_settings_password' ) && ($data['password'] != '')) {
			$sql .= "password = '" . $this->db->escape($data['password']) . "', ";
		}
		
		if ($this->config->get( 'customer_export_import_settings_approved' ) && ($data['approved'] != '')) {
			if($data['approved'] == 'TRUE')
			{
				$data['approved'] = 1;
			}
			else
			{
				$data['approved'] = 0;
			}
			$sql .= "approved = '".$data['approved']."', ";
		}
		
		$sql1 = rtrim($sql, ', '); 
		$sql1 .= " WHERE customer_id='".$data['customer_id']."'";
		
		//echo $sql1; exit;
		$this->db->query($sql1);
		
		if (!empty($data['address1']) || !empty($data['address2']) || !empty($data['companyname']) || !empty($data['city']) || !empty($data['postcode']) || !empty($data['region']) || !empty($data['country']) )
		{ 
		
			$dlt = "DELETE FROM ".DB_PREFIX."address where customer_id = '".(int)$data['customer_id']."' and firstname = '".$data['companyname']."' and lastname = '".$data['companyname']."' and company = '".$data['companyname']."' and address_1 = '".$data['address1']."' and address_2 = '".$data['address2']."' and city = '".$data['city']."' and postcode = '".$data['postcode']."' and country_id = '".$data['country']."' and zone_id = '".$data['region']."'"; 
			
			$this->db->query($dlt);
			
			$adr = "INSERT ".DB_PREFIX."address SET ";
			
			$adr .= "customer_id = '".(int)$data['customer_id']."', ";
			
			if ($this->config->get( 'customer_export_import_settings_companyname' ) && ($data['companyname'] != '') ) {
				$adr .= "company = '".$data['companyname']."', ";
			}
			
			if ($this->config->get( 'customer_export_import_settings_companyname' ) && ($data['companyname'] != '') ) {
				$adr .= "firstname = '".$data['companyname']."', ";
			}
			
			if ($this->config->get( 'customer_export_import_settings_companyname' ) && ($data['companyname'] != '') ) {
				$adr .= "lastname = '".$data['companyname']."', ";
			}
			
			if ($this->config->get( 'customer_export_import_settings_address1' ) && ($data['address1'] != '') ) {
				$adr .= "address_1 = '".$data['address1']."', ";
			}
			
			if ($this->config->get( 'customer_export_import_settings_address2' ) && ($data['address2'] != '') ) {
				$adr .= "address_2 = '".$data['address2']."', ";
			}
			
			if ($this->config->get( 'customer_export_import_settings_city' ) && ($data['city'] != '') ) {
				$adr .= "city = '".$data['city']."', ";
			}
			
			if ($this->config->get( 'customer_export_import_settings_postcode' ) && ($data['postcode'] != '') ) {
				$adr .= "postcode = '".$data['postcode']."', ";
			}
			
			if ($this->config->get( 'customer_export_import_settings_country' ) && ($data['country'] != '') ) {
				$adr .= "country_id = '".$data['country']."', ";
			}
			
			if ($this->config->get( 'customer_export_import_settings_region' ) && ($data['region'] != '') ) {
				$adr .= "zone_id = '".$data['region']."', ";
			}
			
			$adr1 = rtrim($adr, ', '); 
		//echo $adr1; exit;	
			
			$this->db->query($adr1);
			$address_id = $this->db->getLastId();
			$this->db->query("UPDATE " . DB_PREFIX . "customer SET address_id = '" . (int)$address_id . "' WHERE customer_id = '" . (int)$data['customer_id'] . "'");
		
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
		
		if($customer_id)
		{
			$sql = "UPDATE ".DB_PREFIX."customer SET ";
		}
		else
		{
			$sql = "INSERT INTO ".DB_PREFIX."customer SET ";
		}
		
		if ($this->config->get( 'customer_export_import_settings_firstname' ) && ($data['firstname'] != '') ) {
			$sql .= "firstname = '".$data['firstname']."', ";
		}
		
		if ($this->config->get( 'customer_export_import_settings_lastname' ) && ($data['lastname'] != '') ) {
			$sql .= "lastname = '".$data['lastname']."', ";
		}
		
		if ($this->config->get( 'customer_export_import_settings_email' ) && ($data['email'] != '') ) {
			if($this->uploadValidateEmail($data['customer_id'], $data['email']))
			{
				$sql .= "email = '".$data['email']."', ";
			}
		}
		
		if ($this->config->get( 'customer_export_import_settings_telephone' ) && ($data['telphone'] != '')) {
			$sql .= "telephone = '".$data['telphone']."', ";
		}
		
		if ($this->config->get( 'customer_export_import_settings_salesrep' ) && ($data['salesrep'] != '')) {
			$sql .= "salesrep_id = '". (int)$data['salesrep']."', ";
		}
		
		if ($this->config->get( 'customer_export_import_settings_companygroup' ) && ($data['companygroup'] != '')) {
			$sql .= "customer_group_id = '". (int)$data['companygroup']."', ";
		}
	
		if ($this->config->get( 'customer_export_import_settings_newsletter' ) && ($data['newsletter'] != '')) {
			if($data['newsletter'] == 'TRUE')
			{
				$data['newsletter'] = 1;
			}
			else
			{
				$data['newsletter'] = 0;
			}
			$sql .= "newsletter = '".$data['newsletter']."', ";
		}
		
		if ($this->config->get( 'customer_export_import_settings_status' ) && ($data['status'] != '')) {
			if($data['status'] == 'TRUE')
			{
				$data['status'] = 1;
			}
			else
			{
				$data['status'] = 0;
			}
			$sql .= "status = '".$data['status']."', ";
		}
		
		if ($this->config->get( 'customer_export_import_settings_password' ) && ($data['password'] != '')) {
			$sql .= "password = '" . $this->db->escape($data['password']) . "', ";
		}
		
		if ($this->config->get( 'customer_export_import_settings_approved' ) && ($data['approved'] != '')) {
			if($data['approved'] == 'TRUE')
			{
				$data['approved'] = 1;
			}
			else
			{
				$data['approved'] = 0;
			}
			$sql .= "approved = '".$data['approved']."', ";
		}
		
		$sql1 = rtrim($sql, ', '); 
		
		if($customer_id)
		{
			$sql1 .= " WHERE customer_id='".$customer_id."'";
			$customer_id = $customer_id;
		}
		//echo $sql1; exit;
		$this->db->query($sql1);
		
		if(empty($customer_id))
		{
			$customer_id = $this->db->getLastId();
		}
		
		if (!empty($data['address1']) || !empty($data['address2']) || !empty($data['companyname']) || !empty($data['city']) || !empty($data['postcode']) || !empty($data['region']) || !empty($data['country']) )
		{ 
		
			if($customer_id)
			{ 
				$dlt = "DELETE FROM ".DB_PREFIX."address where customer_id = '".(int)$customer_id."' and firstname = '".$data['companyname']."' and lastname = '".$data['companyname']."' and company = '".$data['companyname']."' and address_1 = '".$data['address1']."' and address_2 = '".$data['address2']."' and city = '".$data['city']."' and postcode = '".$data['postcode']."' and country_id = '".$data['country']."' and zone_id = '".$data['region']."'";
			} 
			
			$this->db->query($dlt);
			
			$adr = "INSERT ".DB_PREFIX."address SET ";
			
			if($customer_id)
			{
				$adr .= "customer_id = '".(int)$customer_id."', ";
			}
			else
			{
				$adr .= "customer_id = '".(int)$data['customer_id']."', ";
			}
			
			if ($this->config->get( 'customer_export_import_settings_companyname' ) && ($data['companyname'] != '') ) {
				$adr .= "company = '".$data['companyname']."', ";
			}
			
			if ($this->config->get( 'customer_export_import_settings_companyname' ) && ($data['companyname'] != '') ) {
				$adr .= "firstname = '".$data['companyname']."', ";
			}
			
			if ($this->config->get( 'customer_export_import_settings_companyname' ) && ($data['companyname'] != '') ) {
				$adr .= "lastname = '".$data['companyname']."', ";
			}
			
			if ($this->config->get( 'customer_export_import_settings_address1' ) && ($data['address1'] != '') ) {
				$adr .= "address_1 = '".$data['address1']."', ";
			}
			
			if ($this->config->get( 'customer_export_import_settings_address2' ) && ($data['address2'] != '') ) {
				$adr .= "address_2 = '".$data['address2']."', ";
			}
			
			if ($this->config->get( 'customer_export_import_settings_city' ) && ($data['city'] != '') ) {
				$adr .= "city = '".$data['city']."', ";
			}
			
			if ($this->config->get( 'customer_export_import_settings_postcode' ) && ($data['postcode'] != '') ) {
				$adr .= "postcode = '".$data['postcode']."', ";
			}
			
			if ($this->config->get( 'customer_export_import_settings_country' ) && ($data['country'] != '') ) {
				$adr .= "country_id = '".$data['country']."', ";
			}
			
			if ($this->config->get( 'customer_export_import_settings_region' ) && ($data['region'] != '') ) {
				$adr .= "zone_id = '".$data['region']."', ";
			}
			
			$adr1 = rtrim($adr, ', '); 
		//echo $adr1; exit;	
			
			$this->db->query($adr1);
			$address_id = $this->db->getLastId();
			
			if($customer_id)
			{
				$this->db->query("UPDATE " . DB_PREFIX . "customer SET address_id = '" . (int)$address_id . "' WHERE customer_id = '" . (int)$customer_id . "'");
			}
			else
			{
				$this->db->query("UPDATE " . DB_PREFIX . "customer SET address_id = '" . (int)$address_id . "' WHERE customer_id = '" . (int)$data['customer_id'] . "'");
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
		
		$this->load->model('customer/customer');
		$customers 	= $this->model_customer_customer->getCustomersCustomerExportImport($min,$max);
		$filename 	= "Customer-Export-".date('d-m-Y-H:i:s').".csv";
		$delimiter 	= ",";

		// set customer export/import configuration settings
		$firstnameExportSettings 	= $this->config->get( 'customer_export_import_settings_firstname' );
		$lastExportSettings 		= $this->config->get( 'customer_export_import_settings_lastname' );
		$emailExportSettings 		= $this->config->get( 'customer_export_import_settings_email' );
		$telephoneExportSettings 	= $this->config->get( 'customer_export_import_settings_telephone' );
		$salesRepExportSettings 	= $this->config->get( 'customer_export_import_settings_salesrep' );
		$companyGroupExportSettings = $this->config->get( 'customer_export_import_settings_companygroup' );
		$newsletterExportSettings 	= $this->config->get( 'customer_export_import_settings_newsletter' );
		$statusExportSettings 		= $this->config->get( 'customer_export_import_settings_status' );
		$passwordExportSettings 	= $this->config->get( 'customer_export_import_settings_password' );
		$approvedExportSettings 	= $this->config->get( 'customer_export_import_settings_approved' );
		$address1ExportSettings 	= $this->config->get( 'customer_export_import_settings_address1' );
		$address2ExportSettings 	= $this->config->get( 'customer_export_import_settings_address2' );
		$cityExportSettings 		= $this->config->get( 'customer_export_import_settings_city' );
		$postCodeExportSettings 	= $this->config->get( 'customer_export_import_settings_postcode' );
		$countryExportSettings 		= $this->config->get( 'customer_export_import_settings_country' );
		$regionExportSettings 		= $this->config->get( 'customer_export_import_settings_region' );
		$companyNameExportSettings 	= $this->config->get( 'customer_export_import_settings_companyname' );

		// create a file pointer
    	$f = fopen('php://memory', 'w');

    	// set column headers
    	$fields = array('Customer ID', 'First Name', 'Last Name', 'Email', 'Telephone', 'Company Name', 'Address 1', 'Address 2', 'City', 'Postcode', 'Country', 'Region/State', 'Password', 'Newsletter', 'Company Group', 'Approved', 'Payment Method', 'Sales Rep', 'Status');
    	fputcsv($f, $fields, $delimiter);

    	// output each row of the data, format line as csv and write to file pointer
    	foreach ($customers as $key => $customer) {
    		
    		$customerID 	= $customer['customer_id'];
    		$firstname 		= ($firstnameExportSettings) 	? $customer['firstname'] : '';
    		$lastname 		= ($lastnameExportSettings) 	? $customer['lastname'] : '';
    		$email 			= ($emailExportSettings) 		? $customer['email'] : '';
    		$telephone 		= ($telephoneExportSettings) 	? $customer['telephone'] : '';
    		$companyname 	= ($companyNameExportSettings) 	? $customer['companyname'] : '';
    		$address1 		= ($address1ExportSettings) 	? $customer['address1'] : '';
    		$address2 		= ($address2ExportSettings) 	? $customer['address2'] : '';
    		$city 			= ($cityExportSettings) 		? $customer['city'] : '';
    		$postcode 		= ($postCodeExportSettings) 	? $customer['postcode'] : '';
    		$country 		= ($countryExportSettings) 		? $customer['country'] : '';
    		$region 		= ($regionExportSettings) 		? $customer['region'] : '';
    		$password 		= ($passwordExportSettings) 	? $customer['password'] : '';
    		$customer_group = ($companyGroupExportSettings) ? $customer['customer_group'] : '';
    		$salesrep 		= ($salesRepExportSettings) ? $customer['salesrep'] : '';
    		if ($newsletterExportSettings) {
    			$newsletter = ($customer['newsletter'] == '1') ? 'True' : 'False';
    		} else {
    			$newsletter = '';
    		}
    		if ($statusExportSettings) {
    			$status = ($customer['status'] == '1') ? 'True' : 'False';
    		} else {
    			$status = '';
    		}
    		if ($approvedExportSettings) {
    			$approved = ($customer['approved'] == '1') ? 'True' : 'False';
    		} else {
    			$approved = '';
    		}
    		$lineData = array(
    			$customerID,
    			$firstname,
    			$lastname,
    			$email,
    			$telephone,
				$companyname,
				$address1,
				$address2,
				$city,
				$postcode,
				$country,
				$region,
				$password,
				$newsletter,
				$customer_group,
				$approved,
				'',
				$salesrep,
				$status
			);
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
