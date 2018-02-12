<?php
class ModelReplogicSalesRepManagement extends Model {
	public function addSalesRep($data) {
		$this->db->query("INSERT INTO " . DB_PREFIX . "salesrep SET salesrep_name = '" . $this->db->escape($data['salesrep_name']) . "', salesrep_lastname = '" . $this->db->escape($data['salesrep_lastname']) . "',email = '" . $this->db->escape($data['email']) . "',sales_team_id = '" . $this->db->escape($data['sales_team_id']) . "',cell = '" . $this->db->escape($data['cell']) . "',tel = '" . $this->db->escape($data['tel']) . "'");
	
		$salesrep_id = $this->db->getLastId();
		
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "rep_settings order by company_id asc LIMIT 1");

		$row = $query->row;
		$company_id = $row['company_id']; 
		
		$service_url = 'http://46.101.26.246:8000/api/v1/salesrep/register';
		$curl = curl_init($service_url);
		$curl_post_data = array(
				'company_id' => $company_id,
				'rep_id' => $salesrep_id,
				'username' => $data['email'],
				'email' => $data['email']);
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($curl, CURLOPT_POST, true);
		curl_setopt($curl, CURLOPT_POSTFIELDS, $curl_post_data);
		$curl_response = curl_exec($curl);
		if ($curl_response === false) {
			$info = curl_getinfo($curl);
			curl_close($curl);
			die('error occured during curl exec. Additioanl info: ' . var_export($info));
		}
		curl_close($curl);
		$decoded = json_decode($curl_response);
	//echo $decoded->message; exit;
		if (isset($decoded->error) && $decoded->error == 'Not Found') {
			$message = $decoded->message;
		}
		else
		{
				$message = $decoded->message;
		}
		
		//var_export($decoded->response);
		
		
		return $message;
	}

	public function CheckEmailByApi($email) {
		
		$service_url = "http://46.101.26.246:8000/api/v1/users/search/$email";
		$curl = curl_init($service_url);
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
		$curl_response = curl_exec($curl);
		if ($curl_response === false) {
			 $info = curl_getinfo($curl);
			 curl_close($curl);
			 die('error occured during curl exec. Additioanl info: ' . var_export($info));
		}
		curl_close($curl);
		$decoded = json_decode($curl_response);
		
		return $decoded;
		
	}
	
	public function editSalesRep($salesrep_id, $data) {
		$this->db->query("UPDATE " . DB_PREFIX . "salesrep SET salesrep_name = '" . $this->db->escape($data['salesrep_name']) . "', salesrep_lastname = '" . $this->db->escape($data['salesrep_lastname']) . "',email = '" . $this->db->escape($data['email']) . "',sales_team_id = '" . $this->db->escape($data['sales_team_id']) . "',cell = '" . $this->db->escape($data['cell']) . "',tel = '" . $this->db->escape($data['tel']) . "' WHERE salesrep_id = '" . (int)$salesrep_id . "'");
	}

	public function deleteSalesRep($salesrep_id) {
		
		
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "rep_settings order by company_id asc LIMIT 1");

		$row = $query->row;
		$company_id = $row['company_id']; 
		
		$service_url = 'http://46.101.26.246:8000/api/v1/salesrep';
		$curl = curl_init($service_url);
		$curl_post_data = array(
				'c_id' => $company_id,
				'r_id' => $salesrep_id);
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($curl, CURLOPT_POST, true);
		curl_setopt($curl, CURLOPT_POSTFIELDS, $curl_post_data);
		$curl_response = curl_exec($curl);
		if ($curl_response === false) {
			$info = curl_getinfo($curl);
			curl_close($curl);
			die('error occured during curl exec. Additioanl info: ' . var_export($info));
		}
		curl_close($curl);
		$decoded = json_decode($curl_response);
	//echo $decoded->message; exit;
		if (isset($decoded->error) && $decoded->error == 'Not Found') {
			$message = $decoded->message;
		}
		else
		{
				$message = $decoded->message;
		}
		
		
		$this->db->query("DELETE FROM " . DB_PREFIX . "salesrep WHERE salesrep_id = '" . (int)$salesrep_id . "'");
		
	}
	
	public function AssignSalesRep($sales_rep_id,$team_id) { 
		
		$this->db->query("UPDATE " . DB_PREFIX . "salesrep SET sales_team_id = '".$team_id."' WHERE salesrep_id = '" . (int)$sales_rep_id . "'");
	}
	
	public function UnAssignSalesRep($sales_rep_id,$team_id) { 
		
		$this->db->query("UPDATE " . DB_PREFIX . "salesrep SET sales_team_id = '".$team_id."' WHERE salesrep_id = '" . (int)$sales_rep_id . "'");
	}

	public function getsalesrep($salesrep_id) {
		$query = $this->db->query("SELECT DISTINCT * FROM " . DB_PREFIX . "salesrep WHERE salesrep_id = '" . (int)$salesrep_id . "'");

		return $query->row;
	}
	
	public function getSalesRepByTeam($team_id) { 
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "salesrep WHERE sales_team_id = '" . (int)$team_id . "'");

		return $query->rows;
	}

	public function getSalesReps($data = array(), $allaccess=false, $current_user_id) { 
		
		if($allaccess)
		{
			if(!empty($data['filter_customer_id']))
			{
				$sql = "SELECT * FROM " . DB_PREFIX . "salesrep sr left join oc_customer cu on cu.salesrep_id = sr.salesrep_id";
				$sql .= " where sr.salesrep_id > '0'";
				$sql .= " and cu.customer_id = ".$data['filter_customer_id']."";
			}
			else
			{
				$sql = "SELECT * FROM " . DB_PREFIX . "salesrep";
				if (!empty($data['filter_sales_rep_name']) || !empty($data['team_id']) || !empty($data['filter_email']) || !empty($data['filter_team_id']) ) 
				{
					$sql .= " where salesrep_id > '0'";
				}
			}
		}
		else
		{
			if(!empty($data['filter_customer_id']))
			{
				$sql = "SELECT * FROM oc_salesrep sr left join oc_team tm on tm.team_id = sr.sales_team_id left join oc_customer cu on cu.salesrep_id = sr.salesrep_id where tm.sales_manager = ".$current_user_id." and cu.customer_id = ".$data['filter_customer_id'].""; 
			}
			else
			{
				$sql = "SELECT * FROM oc_salesrep sr left join oc_team tm on tm.team_id = sr.sales_team_id where tm.sales_manager = ".$current_user_id.""; 
			}
		}
		
		if (!empty($data['filter_sales_rep_name'])) {
			
			$sql .= " AND CONCAT(salesrep_name,' ',salesrep_lastname) like '%" . $this->db->escape($data['filter_sales_rep_name']) . "%'";
			
		}
		
		if (!empty($data['filter_email'])) {
			$sql .= " AND email LIKE '" . $this->db->escape($data['filter_email']) . "%'";
		}

		if (!empty($data['team_id'])) {
			$sql .= " AND sales_team_id LIKE '" . $this->db->escape($data['team_id']) . "'";
		}
		
		if (!empty($data['filter_team_id'])) {
			$sql .= " AND sales_team_id LIKE '" . $this->db->escape($data['filter_team_id']) . "'";
		}
		
		$sql .= " ORDER BY salesrep_name";

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
	
	public function getSalesRepsDropdown($allaccess, $current_user_id) {
		
		if($allaccess)
		{
			$sql = "SELECT * FROM " . DB_PREFIX . "salesrep";
		}
		else
		{
			$sql = "SELECT * FROM oc_salesrep sr left join oc_team tm on tm.team_id = sr.sales_team_id where tm.sales_manager = ".$current_user_id.""; 
		}
		
//echo $sql; exit;
		$query = $this->db->query($sql);

		return $query->rows;
	}


	public function getTotalScheduleManagement($data = array(), $allaccess, $current_user_id) {
		
		if($allaccess)
		{
			if(!empty($data['filter_customer_id']))
			{
				$sql = "SELECT COUNT(*) AS total FROM " . DB_PREFIX . "salesrep sr left join oc_customer cu on cu.salesrep_id = sr.salesrep_id";
				$sql .= " where sr.salesrep_id > '0'";
				$sql .= " and cu.customer_id = ".$data['filter_customer_id']."";
			}
			else
			{
				$sql = "SELECT COUNT(*) AS total FROM " . DB_PREFIX . "salesrep";
				if (!empty($data['filter_sales_rep_name']) || !empty($data['team_id']) || !empty($data['filter_email']) || !empty($data['filter_team_id']) ) 
				{
					$sql .= " where salesrep_id > '0'";
				}
			}
		}
		else
		{
			if(!empty($data['filter_customer_id']))
			{
				$sql = "SELECT COUNT(*) AS total FROM oc_salesrep sr left join oc_team tm on tm.team_id = sr.sales_team_id left join oc_customer cu on cu.salesrep_id = sr.salesrep_id where tm.sales_manager = ".$current_user_id." and cu.customer_id = ".$data['filter_customer_id'].""; 
			}
			else
			{
				$sql = "SELECT COUNT(*) AS total FROM oc_salesrep sr left join oc_team tm on tm.team_id = sr.sales_team_id where tm.sales_manager = ".$current_user_id.""; 
			}
		}
		
		if (!empty($data['filter_sales_rep_name'])) {
			$sql .= " AND CONCAT(salesrep_name,' ',salesrep_lastname) like '%" . $this->db->escape($data['filter_sales_rep_name']) . "%'";
			
		}
		
		if (!empty($data['filter_email'])) {
			$sql .= " AND email LIKE '" . $this->db->escape($data['filter_email']) . "%'";
		}

		if (!empty($data['team_id'])) {
			$sql .= " AND sales_team_id LIKE '" . $this->db->escape($data['team_id']) . "'";
		}
		
		if (!empty($data['filter_team_id'])) {
			$sql .= " AND sales_team_id LIKE '" . $this->db->escape($data['filter_team_id']) . "'";
		}
		
		$query = $this->db->query($sql);
		return $query->row['total'];
	}
	
	public function getTeams() {
		$query = $this->db->query("SELECT * FROM `" . DB_PREFIX . "team`");

		return $query->rows;
	}
	
	public function getSalesrepByEmail($email) {
		$query = $this->db->query("SELECT DISTINCT * FROM " . DB_PREFIX . "salesrep WHERE LCASE(email) = '" . $this->db->escape(utf8_strtolower($email)) . "'");

		return $query->row;
	}

}