<?php

// LOCATE CAPSULE
use Illuminate\Database\Capsule\Manager as Capsule;

class Database {

	private $_registry = NULL;

	public function __construct($registry) {

		// INIT REGISTRY
		$this->_registry = $registry;

		if ( !empty($this->_registry->get('config')->get('db_host')) AND $this->_registry->get('config')->get('db_host') != NULL ):

			// INIT CAPSULE
			$Capsule = new Capsule;


			// ADD CONNECTION
			$Capsule->addConnection([
				'driver' => $this->_registry->get('config')->get('db_driver'),
				'host' => $this->_registry->get('config')->get('db_host'),
				'database' => $this->_registry->get('config')->get('db_name'),
				'username' => $this->_registry->get('config')->get('db_user'),
				'password' => $this->_registry->get('config')->get('db_pass'),
				'charset' => $this->_registry->get('config')->get('db_charset'),
				'collation' => $this->_registry->get('config')->get('db_collation'),
				'prefix' => $this->_registry->get('config')->get('db_prefix')
			]);


			// BOOT ELOQUENT
			$Capsule->bootEloquent();

		endif;
	}
}

?>