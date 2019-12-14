<?php

use Carbon\Carbon;
use Illuminate\Database\Capsule\Manager as DB;

class Messages extends Controller {
    
    public function index(){

        //CHECK LOGIN STATUS
        if( !isset($_SESSION['user']) OR $_SESSION['user']['is_login'] != true ):
            header( 'Location:' . $this->config->get('base_url') . '/portal/login' );
            exit();
        endif;

		// SITE DETAILS
		$data['app']['url']			= $this->config->get('base_url');
		$data['app']['title']		= $this->config->get('site_title');
		$data['app']['theme']		= $this->config->get('app_theme');

		// HEADER / FOOTER
		$data['template']['header']		= $this->load->controller('common/header', $data);
		$data['template']['footer']		= $this->load->controller('common/footer', $data);
        $data['template']['topmenu']	= $this->load->controller('common/topmenu', $data);
        $data['template']['sidenav']	= $this->load->controller('common/sidenav', $data);
        
        // QUERY MESSAGE CONVERSATIONS


        // LOAD CONVERSATIONS
        $this->load->view('messages/index', $data);

    }

}
?>