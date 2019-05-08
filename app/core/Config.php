<?php

class Config {


	// PROPERTIES
	private $data = array();


	/**
	 *
	 * @param String $key
	 * @param String $value
	 *
	 */
	public function set($key, $value) {
		$this->data[$key] = $value;
	}



	/**
	 *
	 * @param String $key
	 * @return mixed
	 *
	 */
	public function get($key) {
		return ( isset($this->data[$key]) ? $this->data[$key] : null );
	}



	/**
	 *
	 * @param String $key
	 * @return bool
	 *
	 */
	public function has($key) {
		return isset($this->data[$key]);
	}



	/**
	 *
	 * @param String $filename
	 *
	 */
	public function load($filename) {
		if ( isset($filename) AND !empty($filename) AND !is_numeric($filename) ):
			if ( file_exists(ABS_PATH.'/config/'.$filename.'.php') ):
				$_ = array();
				require_once  ABS_PATH.'/config/'.$filename.'.php';
				$this->data = array_merge($this->data, $_);
			else:
				error_log("[ERROR] Could not load config ".$filename.".php");
			endif;
		endif;
	}
}

?>