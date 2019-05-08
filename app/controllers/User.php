<?php

class User extends Controller {
    public function index() {
    
        $data['user']['uname'] = 'lakmal';

        // RENDER
        $this->load->view('user/index', $data);
    }
}

?>