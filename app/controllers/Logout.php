<?php

class Logout extends Controller {
    public function index() {
        
        if ( isset($_COOKIE['RememberMe']) ){
            setcookie('RememberMe', '', time()-3600);
        }
        session_destroy();
        header('Location: ' . $this->config->get('base_url') . "/login");
    }
}

?>