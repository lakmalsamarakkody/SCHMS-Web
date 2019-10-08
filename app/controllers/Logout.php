<?php

class Logout extends Controller {
    public function index() {

        //Logout
        session_destroy();
        // header( 'Location: ' . "http://davidsilvacollege.int" );
        header( 'Location: ' . $this->config->get('base_url') . "/login" );

    }
}

?>