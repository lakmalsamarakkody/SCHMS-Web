<?php

class Session {


    // PROPERTIES
    protected $_registry = NULL;



    public function __construct($Registry) {
        $this->_registry = $Registry;
        
        // START SESSION
        session_start();
	}
}

?>