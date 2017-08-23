<?php
class ControllerExtensionModuleSofacebook extends Controller {
	public function index($setting) {
		$this->load->language('extension/module/so_facebook');
		$data['heading_title'] = $setting['name'];	
		$this->document->addStyle('catalog/view/javascript/so_facebook/css/styles.css');
		
		$default = array(
			'objlang' 				=> $this->language,
			'name' 					=> '',
			'module_description'	=> array(),
			'disp_title_module'		=> '1',
			'status'				=> '1',

			'class_suffix'			=> '',
			'pageid'				=> '121579357898967',
			'height'				=> '500',
			'width' 				=> '250',
			'stream'				=> '1',
			'hide_cover'			=> '0',
			'small_header'			=> '0',
			'show_facepile'			=> '1',
			'bordercolor'			=> '065791',
			
			'post_text'				=> '',
			'pre_text'				=> '',
			'use_cache'				=> '0',
			'cache_time'			=> '3600'
		);
		$data =  array_merge($default,$setting);//check data empty setting
		$this->load->model('localisation/language');
		$data['languages'] = $this->model_localisation_language->getLanguages();

		$data['disp_title_module'] 		= (int)$setting['disp_title_module'] ;
		if (isset($setting['module_description'][$this->config->get('config_language_id')])) {
			$data['head_name'] = html_entity_decode($setting['module_description'][$this->config->get('config_language_id')]['head_name'], ENT_QUOTES, 'UTF-8');
		}else{
			$data['head_name']  = $setting['head_name'];
		}
		// caching
		$use_cache = (int)$setting['use_cache'];
		$cache_time = (int)$setting['cache_time'];
		$folder_cache = DIR_CACHE.'so/Facebook/';
		if(!file_exists($folder_cache))
			mkdir ($folder_cache, 0777, true);
		if (!class_exists('Cache_Lite'))
			require_once (DIR_SYSTEM . 'library/so/facebook/Cache_Lite/Lite.php');

		$options = array(
			'cacheDir' => $folder_cache,
			'lifeTime' => $cache_time
		);
		$Cache_Lite = new Cache_Lite($options);
		if ($use_cache){
			$this->hash = md5( serialize($setting));
			$_data = $Cache_Lite->get($this->hash);
			if (!$_data) {
				$_data = $this->load->view('extension/module/so_facebook/default.tpl', $data);
				$Cache_Lite->save($_data);
				return  $_data;
			} else {
				return  $_data;
			}
		}else{
			if(file_exists($folder_cache))
				$Cache_Lite->_cleanDir($folder_cache);
			return $this->load->view('extension/module/so_facebook/default.tpl', $data);
		}
	}
}