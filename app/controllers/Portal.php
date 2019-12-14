<?php

use Carbon\Carbon;
use Illuminate\Database\Capsule\Manager as DB;

class Portal extends Controller {
    
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