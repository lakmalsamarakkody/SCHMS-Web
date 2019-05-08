<?php

class Loader {

	// PROPERTIES
	protected $_registry = NULL;



	public function __construct($Registry) {
		$this->_registry = $Registry;
	}



	/**
	*
	* @param String $handler
	* @param Array $data
	* @return mixed
	*
	*/
	public function controller($controller, $data = array()) {
		if ( isset($controller) AND !empty($controller) AND $controller != NULL ):
			
			$controller = explode("/", $controller);

			// MAKE UCFIRST IN FINAL FILE
			$loop_index = 0;
			$iteration_count = count($controller);
			foreach ( $controller AS $key => $value ):
				if ( $loop_index == ( $iteration_count - 1 ) ):
					$controller[$key] = ucfirst(strtolower($value));
				endif;
				$loop_index++;
			endforeach;

			// MAKE FINAL FILE PATH
			$controller = implode('/', $controller);

			// FILE EXISTS
			if ( file_exists(ABS_PATH.'/app/controllers/'.$controller.'.php') ):

				// INCLUDE CONTROLLER
				include_once ABS_PATH.'/app/controllers/'.$controller.'.php';

				$controller = explode('/', $controller);

				// MAKE CONTROLLER INSTANCE NAME
				$instance['name'] = null;
				foreach ( $controller AS $key => $value ):
					$instance['name'] .= ucfirst(strtolower($value));
				endforeach;

				// CREATE CONTROLLER INSTANCE
				$controller = new $instance['name']($this->_registry);

				// // RETURN CONTROLLER OUTPUT
				return $controller->index($data);

			endif;

		endif;
	}



	/**
	*
	* @param String $param
	* @return void
	*
	*/
	public function model($param) {

		// CHECK IF WE GOT VALID MODEL PARAM
		$param = explode('/', $param);

	   /*
		* We need to validate directory present if we have
		* more than 1 item in the exploded array. Otherwise
		* parameter needs to be a file directly.
		*
		*/
		if ( count($param) > 1 ):
			if ( is_dir( ABS_PATH.'/app/models/'.$param[0] ) ):
				if ( file_exists( ABS_PATH.'/app/models/'.strtolower($param[0]).'/'.ucfirst(strtolower($param[1])).'.php' ) ):
					$param_error = false;
				else:
					$param_error = true;
				endif;
			else:
				$param_error = true;
			endif;
		else:
			if ( file_exists( ABS_PATH.'/app/models/'.ucfirst(strtolower($param[0])).'.php' ) ):
				$param_error = false;
			else:
				$param_error = true;
			endif;
		endif;


	   /*
		* If we don't have any validation errors it's
		* Ok to continue to the future actions on loading
		* Model into our system.
		*
		*/
		if ( !$param_error ):
			
			if ( count($param) > 1 ):
				$model_name = 'model_'.strtolower($param[0]).'_'.strtolower($param[1]);
				$model_file = strtolower($param[0]).'/'.ucfirst(strtolower($param[1])).'.php';
				$model_instance = ucfirst(strtolower($param[0])).ucfirst(strtolower($param[1])).'_Model';
			else:
				$model_name = 'model_'.strtolower($param[0]);
				$model_file = ucfirst(strtolower($param[0])).'.php';
				$model_instance = ucfirst(strtolower($param[0])).'_Model';
			endif;

			if ( !$this->_registry->has($model_name) ):

				// LOAD MODEL FILE
				include_once ABS_PATH.'/app/models/'.$model_file;

				// INIT MODEL AND UPDATE REGISTRY
				$this->_registry->set($model_name, new $model_instance);

			endif;

		endif;
	}



	/**
	*
	* @param String $view
	* @param Array $param
	* @return String HTML-DOM
	*
	*/
	public function view($view, $param = array()) {
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

				echo $this->_registry->get('twig')->render( $view.'.html', $param );
			endif;
		endif;
	}
}

?>