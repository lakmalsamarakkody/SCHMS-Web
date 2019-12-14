<?php

use Carbon\Carbon;
use Illuminate\Database\Capsule\Manager as DB;

class Portal extends Controller {
    
    public function index(){

        //CHECK LOGIN STATUS
        if( !isset($_SESSION['user']) OR $_SESSION['user']['is_login'] != true ):
            header( 'Location:' . $this->config->get('base_url') . '/portal/login' );
            exit();
        

        // TODO
        // else:

            // GET USER TYPE
            // IF USER IS STAFF/ADMIN : RETURN 404
            // IF USER IS STUDENT : REDIREDT TO STUDENT METHOD
            // IF USER IS PARENT  : REDIRECT TO PARENT METHOD

        endif;


    }

    public function login(){

        // SITE DETAILS
        $data['app']['url']         = $this->config->get('base_url');
        $data['app']['title']       = $this->config->get('site_title');
        $data['app']['theme']       = $this->config->get('app_theme');

        // HEADER/FOOTER
        $data['template']['header'] = $this->load->controller('common/header', $data);
        $data['template']['footer'] = $this->load->controller('common/footer', $data);

        // TODO
        // LOGIN USER
        // SET SESSION
        // REDIRECT USER TO INDEX METHOD

        // RENDER VIEW
        $this->load->view('portal/login', $data);

    }


    public function student(){

        // SITE DETAILS
        $data['app']['url']         = $this->config->get('base_url');
        $data['app']['title']       = $this->config->get('site_title');
        $data['app']['theme']       = $this->config->get('app_theme');

        // HEADER/FOOTER
        $data['template']['header'] = $this->load->controller('common/header', $data);
        $data['template']['topmenu'] = $this->load->controller('common/topmenu', $data);
        $data['template']['footer'] = $this->load->controller('common/footer', $data);

        // RENDER VIEW
        $this->load->view('portal/student', $data);

    }

}
?>