<?php

class Registry {


	// PROPERTIES
	private $data = array();


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
	 * @param String $value
	 *
	 */
	public function set($key, $value) {
		$this->data[$key] = $value;
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
}

?>