<?php


class App {

	// APP PROPERTIES
	protected $_registry = NULL;
	protected $_route = NULL;
	protected $_controller = array( 'FILE' => 'Home.php', 'INSTANCE' => 'Home' );
	protected $_method = 'index';
	protected $_params = [];



	/**
	 *
	 * This is where Skeleton start processing URL's.
	 * This __construct() method will help to parse URL's
	 * and load needful controllers to the application.
	 * Once we load the controller then Skeleton can call to
	 * the method that responsible.
	 *
	 * @return Void
	 *
	 */
	function __construct($Registry) {

		// REGISTRY
		$this->_registry = $Registry;

		// PARSE ROUTE
		$this->parseRoute();

		// CONFIGURE CONTROLLER ( ORDER : 1 )
		self::configureController();

		// CONFIGURE METHOD ( ORDER : 2 )
		self::configureMethod();

		// CONFIGURE PARAMS ( ORDER : 3 )
		self::configureParams();

		// CALL TO THE METHOD OF THE CONTROLLER
		call_user_func_array( [$this->_controller, $this->_method], $this->_params );

	}



	/**
	 *
	 * This method will parse the $_GET['route] param to
	 * explode each part of the URL into associate array.
	 * Once parsed we can use the array to Identify
	 * Controllers, Methods & Params
	 *
	 * @return Void
	 *
	 */
	private function parseRoute() {
		if ( isset($_GET['route']) AND !empty($_GET['route']) ):
			$this->_route = explode( '/', filter_var(trim($_GET['route'], '/'), FILTER_SANITIZE_URL) );
		endif;
	}



	/**
	 *
	 * Here we parse the file names for controllers that
	 * get passed in the URL. This method will take care
	 * about the final file name of the controller.
	 *
	 * @return String
	 *
	 */
	private function parseControllerFileName($filename) {

		/**
		 *
		 * We have to parse file names with dashes and underscores.
		 * First we look for the dashes, underscores and then we
		 * generate the final file name.
		 *
		 */
		if ( isset($filename) AND ( strpos($filename, '-') OR strpos($filename, '_') ) ):

			// DEVIDE FILE NAME BY DASHES / UNDERSCORES
			if ( strpos($filename, '-') ):
				$filename = explode('-', $filename);
			elseif( strpos($filename, '_') ):
				$filename = explode('_', $filename);
			endif;
			

			// CAPITALIZE FIRST LETTER OF EACH WORD
			foreach( $filename AS $key => $value ):
				$filename[$key] = ucfirst(strtolower($value));
			endforeach;

			// MAKE IT A SINGLE WORD & RETURN
			return implode($filename);

		else:
			return ucfirst(strtolower($filename));
		endif;

	}



	/**
	 *
	 * Here we parse the directory names for the controllers
	 * that get passed in the URL. This method will return the
	 * directory name for any giving string by validating it.
	 *
	 * @return String
	 *
	 */
	private function parseControllerDirectoryName($dirname) {

		if ( isset($dirname) ):
			return strtolower($dirname);
		endif;

	}



	/**
	 *
	 * This is where we decide which part of the URL is used
	 * for the controller. first we search for the directories
	 * and then once we hit the end of directory set we start
	 * looking for the controller file.
	 *
	 * SCAN LEVEL : 3 DIRECTORIES
	 *
	 * @return Void
	 *
	 */
	private function configureController() {

		if ( isset($this->_route[0]) ):

			// SCAN : LEVEL 1
			if ( is_dir( ABS_PATH.'/app/controllers/'.self::parseControllerDirectoryName($this->_route[0]) ) ):
				
				if ( isset($this->_route[1]) ):

					// SCAN : LEVEL 2
					if ( is_dir( ABS_PATH.'/app/controllers/'.self::parseControllerDirectoryName($this->_route[0]).'/'.self::parseControllerDirectoryName($this->_route[1]) ) ):

						if ( isset($this->_route[2]) ):

							// SCAN : LEVEL 3
							if ( is_dir( ABS_PATH.'/app/controllers/'.self::parseControllerDirectoryName($this->_route[0]).'/'.self::parseControllerDirectoryName($this->_route[1]).'/'.self::parseControllerDirectoryName($this->_route[2]) ) ):

								if ( isset($this->_route[3]) and is_file( ABS_PATH.'/app/controllers/'.self::parseControllerDirectoryName($this->_route[0]).'/'.self::parseControllerDirectoryName($this->_route[1]).'/'.self::parseControllerDirectoryName($this->_route[2]).'/'.self::parseControllerFileName($this->_route[3]).'.php' ) ):

									/**
									 *
									 * We found a file for our controller in 3rd
									 * level directory.
									 *
									 */
									$this->_controller['FILE'] = self::parseControllerDirectoryName($this->_route[0]).'/'.self::parseControllerDirectoryName($this->_route[1]).'/'.self::parseControllerDirectoryName($this->_route[2]).'/'.self::parseControllerFileName($this->_route[3]).'.php';
									$this->_controller['INSTANCE'] = self::parseControllerFileName($this->_route[3]);
									unset($this->_route[0]);
									unset($this->_route[1]);
									unset($this->_route[2]);
									unset($this->_route[3]);

								else:

									/**
									 *
									 * We didn't found a file to load as controller
									 * we'll load the Home.php as the default file
									 *
									 */
									$this->_controller['FILE'] = self::parseControllerDirectoryName($this->_route[0]).'/'.self::parseControllerDirectoryName($this->_route[1]).'/'.self::parseControllerDirectoryName($this->_route[2]).'/Home.php';
									$this->_controller['INSTANCE'] = 'Home';
									unset($this->_route[0]);
									unset($this->_route[1]);
									unset($this->_route[2]);

								endif;

							elseif ( file_exists( ABS_PATH.'/app/controllers/'.self::parseControllerDirectoryName($this->_route[0]).'/'.self::parseControllerDirectoryName($this->_route[1]).'/'.self::parseControllerFileName($this->_route[2]).'.php' ) ):

								/**
								 *
								 * We found our controller file in SCAN LEVEL 3
								 * now we set the detected file as the controller
								 * and unset the _route.
								 *
								 */
								$this->_controller['FILE'] = self::parseControllerDirectoryName($this->_route[0]).'/'.self::parseControllerDirectoryName($this->_route[1]).'/'.self::parseControllerFileName($this->_route[2]).'.php';
								$this->_controller['INSTANCE'] = self::parseControllerFileName($this->_route[2]);
								unset($this->_route[0]);
								unset($this->_route[1]);
								unset($this->_route[2]);

							endif;

						endif;

					elseif ( file_exists( ABS_PATH.'/app/controllers/'.self::parseControllerDirectoryName($this->_route[0]).'/'.self::parseControllerFileName($this->_route[1]).'.php' ) ):

						/**
						 *
						 * We found our controller file in SCAN LEVEL 2
						 * now we set the detected file as the controller
						 * and the file name as the INSTANCE name with
						 * leading capotal letter in the word.
						 *
						 */
						$this->_controller['FILE'] = self::parseControllerDirectoryName($this->_route[0]).'/'.self::parseControllerFileName($this->_route[1]).'.php';
						$this->_controller['INSTANCE'] = self::parseControllerFileName($this->_route[1]);
						unset($this->_route[0]);
						unset($this->_route[1]);

					endif;

				endif;
				
			elseif ( file_exists( ABS_PATH.'/app/controllers/'.self::parseControllerFileName($this->_route[0]).'.php' ) ):
				
				/**
				 *
				 * We found our controller file in SCAN LEVEL 1
				 * now we set the detected file as the controller
				 * and the file name as the INSTANCE name with
				 * capital letter in the front. Finally we unset the
				 * param from the _route.
				 *
				 */
				$this->_controller['FILE']  = self::parseControllerFileName($this->_route[0]).'.php';
				$this->_controller['INSTANCE']  = self::parseControllerFileName($this->_route[0]);
				unset($this->_route[0]);
				
			endif;
			
		endif;

		// LOAD CONTROLLER
		require_once ABS_PATH.'/app/controllers/'.$this->_controller['FILE'];

		// CONTROLLER INSTANCE
		$this->_controller = new $this->_controller['INSTANCE']($this->_registry);

		// RESET KEYS ( $this->_route )
		$this->_route = $this->_route ? array_values($this->_route) : [];

	}



	private function configureMethod() {

		// IF METHOD DEFINED
		if ( isset($this->_route[0]) ):
			if ( method_exists($this->_controller, $this->_route[0]) ):
				$this->_method = $this->_route[0];
				unset($this->_route[0]);
			endif;
		endif;

		// RESET KEYS ( $this->_route )
		$this->_route = $this->_route ? array_values($this->_route) : [];

	}



	private function configureParams() {

		// IF PARAMS DEFINED
		if ( isset($this->_route[0]) ):
			$this->_params = $this->_route;
		endif;

	}
}


?>