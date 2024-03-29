<?php
class Language {
	private $default = 'en-gb';
	private $directory;
private $path = DIR_LANGUAGE;
	private $data = array();

	public function __construct($directory = '') {
		$this->directory = $directory;
	}

	public function setPath($path) {
		if (!is_dir($path)) {
			trigger_error('Error: check path exists: '.$path);
			exit;
		}

		$this->path = $path;
	}
	
	public function get($key) {
		return (isset($this->data[$key]) ? $this->data[$key] : $key);
	}
	
	public function set($key, $value) {
		$this->data[$key] = $value;
	}
	
	// Please dont use the below function i'm thinking getting rid of it.
	public function all() {
		return $this->data;
	}
	
	// Please dont use the below function i'm thinking getting rid of it.
	public function merge(&$data) {
		array_merge($this->data, $data);
	}
			
	public function load($filename, &$data = array()) {
		$_ = array();

		$file = $this->path . 'english/' . $filename . '.php';
		
		// Compatibility code for old extension folders
		$old_file = DIR_LANGUAGE . 'english/' . str_replace('extension/', '', $filename) . '.php';
		
		if (is_file($file)) {
			// Manual Modification Override
			$base = substr(DIR_SYSTEM, 0, -7);
			$modification_file = DIR_MODIFICATION . substr($file, strlen($base));

			if (is_file($modification_file)) {
				require($modification_file);
			} else {
				require($file);
			}
		} elseif (is_file($old_file)) {
			require(modification($old_file));
		}

		$file = $this->path . $this->default . '/' . $filename . '.php';

		// Compatibility code for old extension folders
		$old_file = DIR_LANGUAGE . $this->default . '/' . str_replace('extension/', '', $filename) . '.php';
		
		if (is_file($file)) {
			// Manual Modification Override
			$base = substr(DIR_SYSTEM, 0, -7);
			$modification_file = DIR_MODIFICATION . substr($file, strlen($base));

			if (is_file($modification_file)) {
				require($modification_file);
			} else {
				require($file);
			}
		} elseif (is_file($old_file)) {
			require(modification($old_file));
		}

		$file = $this->path . $this->directory . '/' . $filename . '.php';

		// Compatibility code for old extension folders
		$old_file = DIR_LANGUAGE . $this->directory . '/' . str_replace('extension/', '', $filename) . '.php';
		
		if (is_file($file)) {
			require(modification($file));
		} elseif (is_file($old_file)) {
			require(modification($old_file));
		}

		$this->data = array_merge($this->data, $_);

		return $this->data;
	}
}
