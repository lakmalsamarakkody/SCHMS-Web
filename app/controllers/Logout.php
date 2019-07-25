<?php

class Logout extends Controller {
    public function index() {

        //Logout
        session_destroy();
        header( 'Location: ' . $this->config->get('base_url') . "/login" );

    }
}

?>