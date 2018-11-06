<?php 
class ModelExtensionModulePimFTP extends Model {
	public function validate() {
  	$this->language->load('extension/module/pim_ftp');
    $error = array();
    if ((utf8_strlen($this->request->post['alias']) < 1) || (utf8_strlen($this->request->post['alias']) > 64)) {
			$error['error_ftp_alias'] = $this->language->get('error_ftp_alias');
		} else if(!isset($this->request->get['alias']) || (isset($this->request->get['alias']) && $this->request->get['alias']!= $this->request->post['alias'])) {  // check if this volume alias already exist.
  		$current_volumes = $this->config->get('pim_volumes');
  		if (!empty($current_volumes) && is_array($current_volumes)) { 
    		foreach ($current_volumes as $key => $volume) {
      		if (is_array($volume)) {
        		foreach ($volume as $vkey => $val) {
        		  if ($vkey == $this->request->post['alias']) {
          		  $error['error_alias_exist'] = $this->language->get('error_alias_exist'); 
        		  }
        		}
      		}
    		}
    		
  		}  		
  		
		}
    if ((utf8_strlen($this->request->post['path']) < 1) || (utf8_strlen($this->request->post['path']) > 600)) {
			$error['error_ftp_path'] = $this->language->get('error_ftp_path');
		}
    if ((utf8_strlen($this->request->post['host']) < 1) || (utf8_strlen($this->request->post['host']) > 600)) {
			$error['error_ftp_host'] = $this->language->get('error_ftp_host');
		}		
    if ((utf8_strlen($this->request->post['user']) < 1) || (utf8_strlen($this->request->post['user']) > 600)) {
			$error['error_ftp_user'] = $this->language->get('error_ftp_user');
		}
    if ((utf8_strlen($this->request->post['pass']) < 1) || (utf8_strlen($this->request->post['pass']) > 600)) {
			$error['error_ftp_pass'] = $this->language->get('error_ftp_pass');
		}	
    if ((utf8_strlen($this->request->post['port']) < 1) || (utf8_strlen($this->request->post['port']) > 4)) {
			$error['error_ftp_port'] = $this->language->get('error_ftp_port');
		}			
    return $error;
	}



}
?>