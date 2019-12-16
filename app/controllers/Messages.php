<?php

use Carbon\Carbon;
use Illuminate\Database\Capsule\Manager as DB;

class Messages extends Controller {
    
    public function index($id=null){

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

        // MODELS
        $this->load->model('user');
        $this->load->model('message');
        
        /**
         * We need to display list of all the conversations specific
         * user have at a given time. Conversations will be sorted
         * using the message table with the help of grouping SQL.
         */
        $converstations = $this->model_message->select('id', 'sender_id')->where('receiver_id', '=', $_SESSION['user']['id'])->groupBy('sender_id')->orderBy('created_on', 'desc')->get();
        foreach( $converstations as $key => $element ):

            // RESOLVE SENDER
            $data['converstations'][$key]['user']['username']       = $this->model_user->find($element->sender_id)->username;
            $data['converstations'][$key]['user']['id']             = $element->sender_id;

            // echo "<pre>";
            //     var_dump( $element->sender_id );
            // echo "</pre>";

        endforeach;

        // echo "<pre>";
        //     var_dump( $data['converstations'] );
        // echo "</pre>";


        if ( $id !== null ){
            $this->load->view('messages/single', $data);
        } else {
            // LOAD CONVERSATIONS
            $this->load->view('messages/index', $data);
        }


    }

}
?>