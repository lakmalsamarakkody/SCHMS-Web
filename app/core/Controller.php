<?php

class Controller {


	// PROPERTIES
	protected $_registry = NULL;



	// INIT
	public function __construct($registry) {
		$this->_registry = $registry;
	}



	// MAJIC METHOD
	public function __get($key) {
		return $this->_registry->get($key);
	}



	final protected function load_view($view, $param = array()) {
		if ( isset($view) AND !empty($view) AND $view != NULL AND is_array($param) ):
			if ( file_exists(ABS_PATH.'/themes/'.$this->_registry->get('config')->get('app_theme').'/'.$view.".html") ):

				// DOCUMENT ( $_styles )
				( !is_array(isset($param['styles'])) ) ? $param['styles'] = array() : null;
				foreach ( $this->_registry->get('document')->get_styles() AS $style ):
					array_push( $param['styles'], $style );
				endforeach;

				// DOCUMENT ( $_scripts )
				( !is_array(isset($param['scripts'])) ) ? $param['scripts'] = array() : null;
				foreach ( $this->_registry->get('document')->get_scripts() AS $script ):
					array_push( $param['scripts'], $script );
				endforeach;

				/**
				*
				* We can pull the meta tags that added directly from Controllers
				* using out Document object & Here we'll append them to our DOM
				* before executing Twig render process.
				*
				*/
				( !is_array(isset($param['metas'])) ) ? $param['metas'] = array() : null;
				foreach ( $this->_registry->get('document')->get_metas() AS $metas ):
					array_push( $param['metas'], $metas );
				endforeach;

				return $this->_registry->get('twig')->render( $view.'.html', $param );
			endif;
		endif;
	}
}

?>