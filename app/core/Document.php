<?php

class Document {


	// REGISTRY
	private $_registry = NULL;


	// PROPERTIES
	private $_styles = array();
	private $_scripts = array();
	private $_metas = array();



	// CONSTRUCT
	public function __construct($Registry) {
		$this->_registry = $Registry;
	}



	/**
	 * 
	 * @param String $file
	 *
	 */
	final public function add_style($file = '') {
		if ( isset($file) AND !empty($file) ):
			if ( file_exists( ABS_PATH.'/themes/'.$this->_registry->get('config')->get('app_theme').'/assets/css/'.$file ) ):
				array_push($this->_styles, $this->_registry->get('config')->get('base_url').'/themes/'.$this->_registry->get('config')->get('app_theme').'/assets/css/'.$file);
			endif;
		endif;
	}



	/**
	 *
	 * @param String $file
	 *
	 */
	final public function add_script($file = '') {
		if ( isset($file) AND !empty($file) ):
			if ( file_exists( ABS_PATH.'/themes/'.$this->_registry->get('config')->get('app_theme').'/assets/js/'.$file ) ):
				array_push($this->_scripts, $this->_registry->get('config')->get('base_url').'/themes/'.$this->_registry->get('config')->get('app_theme').'/assets/js/'.$file);
			endif;
		endif;
	}



   /**
	*
	* This method will allow to add meta tags with name & content
	* directly into the Document object. Later we can use them to
	* manipulate DOM.
	*
	* @param String $name
	* @param String $content
	*
	*/
	final public function add_meta($name = NULL, $content = NULL) {
		if ( isset($name) AND !empty($name) AND $name != NULL AND isset($content) AND !empty($content) AND $content != NULL ):
			array_push($this->_metas, array('name' => $name, 'content' => $content));
		endif;
	}



	/**
	 *
	 * @return array()
	 *
	 */
	final public function get_styles() {
		return $this->_styles;
	}



	/**
	 *
	 * @return array()
	 *
	 */
	final public function get_scripts() {
		return $this->_scripts;
	}



   /**
	*
	* This method will return an Array object that contain all the meta
	* tags added in the Controllers. We can use this method perior to
	* The Twig rendering process to append meta tags from Controllers.
	*
	* @return Array()
	*
	*/
	final public function get_metas() {
		return $this->_metas;
	}
}

?>