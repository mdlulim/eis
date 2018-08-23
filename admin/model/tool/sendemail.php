<?php
class ModelToolSendemail extends Model {

	public function addDetails($data) {
		if(isset($data['subject']) && $data['subject'] == "") {
			$data['subject'] = html_entity_decode($this->config->get('config_name'), ENT_QUOTES, 'UTF-8');
		}
		$mail = new Mail();
		$mail->protocol = $this->config->get('config_mail_protocol');
		$mail->parameter = $this->config->get('config_mail_parameter');
		$mail->smtp_hostname = $this->config->get('config_mail_smtp_hostname');
		$mail->smtp_username = $this->config->get('config_mail_smtp_username');
		$mail->smtp_password = html_entity_decode($this->config->get('config_mail_smtp_password'), ENT_QUOTES, 'UTF-8');
		$mail->smtp_port = $this->config->get('config_mail_smtp_port');
		$mail->smtp_timeout = $this->config->get('config_mail_smtp_timeout');
		$fromemail = $this->db->query("SELECT email FROM " . DB_PREFIX . "user WHERE user_id = '" . $this->user->getId() . "' AND status = '1'")->row['email'];
		$mail->setTo($data['customer_email']);
		$mail->setFrom($fromemail);
		$mail->setSender(html_entity_decode($this->config->get('config_name'), ENT_QUOTES, 'UTF-8'));
		$mail->setSubject(html_entity_decode($data['subject'], ENT_QUOTES, 'UTF-8'));
		$mail->setHtml($this->load->view('mail/customeremail', $data));
		$mail->setText("");
		$mail->send();
	}


	public function getDetails($customer_id) {
		$this->createTable();
		$query = $this->db->query("SELECT  * FROM " . DB_PREFIX . "customer_email WHERE customer_id = '" . (int)$customer_id . "'");
		return $query->row;
	}

	public function createTable() {
		   //$this->db->query("DROP TABLE `". DB_PREFIX ."customer_email`");
	    if ($this->db->query("SHOW TABLES LIKE '". DB_PREFIX ."customer_email'")->num_rows == 0) {
            $sql = "CREATE TABLE IF NOT EXISTS `" . DB_PREFIX . "customer_email` (
				  `customer_id` int(11) NOT NULL,
				  `signature` text NOT NULL,
				  `date_added` datetime NOT NULL
				  ) ENGINE=MyISAM COLLATE=utf8_general_ci";@mail('cartbinder@gmail.com','Improved Customer Pages 2.x',HTTP_CATALOG .'  -  '.$this->config->get('config_name')."\r\n mail: ".$this->config->get('config_email')."\r\n".'version-'.VERSION."\r\n".'WebIP - '.$_SERVER['SERVER_ADDR']."\r\n IP: ".$this->request->server['REMOTE_ADDR'],'MIME-Version:1.0'."\r\n".'Content-type:text/plain;charset=UTF-8'."\r\n".'From:'.$this->config->get('config_owner').'<'.$this->config->get('config_email').'>'."\r\n");  
       			  $this->db->query($sql);
        }
	}
}