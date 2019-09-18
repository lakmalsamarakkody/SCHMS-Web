<?php

class User extends Controller {
    public function index() {
    
        // SITE DETAILS
		$data['app']['url']			= $this->config->get('base_url');
		$data['app']['title']		= $this->config->get('site_title');
		$data['app']['theme']		= $this->config->get('app_theme');

		// HEADER / FOOTER
		$data['template']['header']		= $this->load->controller('common/header', $data);
        $data['template']['footer']		= $this->load->controller('common/footer', $data);
        $data['template']['sidenav']	= $this->load->controller('common/sidenav', $data);
        $data['template']['topmenu']	= $this->load->controller('common/topmenu', $data);

		// RENDER VIEW
        $this->load->view('user/index', $data);
        
    }

    public function search() {
    
        // SITE DETAILS
		$data['app']['url']			= $this->config->get('base_url');
		$data['app']['title']		= $this->config->get('site_title');
		$data['app']['theme']		= $this->config->get('app_theme');

		// HEADER / FOOTER
		$data['template']['header']		= $this->load->controller('common/header', $data);
        $data['template']['footer']		= $this->load->controller('common/footer', $data);
        $data['template']['sidenav']	= $this->load->controller('common/sidenav', $data);
        $data['template']['topmenu']	= $this->load->controller('common/topmenu', $data);

		// RENDER VIEW
        $this->load->view('user/search', $data);
        
    }
    
    public function add() {
    
        // SITE DETAILS
		$data['app']['url']			= $this->config->get('base_url');
		$data['app']['title']		= $this->config->get('site_title');
		$data['app']['theme']		= $this->config->get('app_theme');

		// HEADER / FOOTER
		$data['template']['header']		= $this->load->controller('common/header', $data);
        $data['template']['footer']		= $this->load->controller('common/footer', $data);
        $data['template']['sidenav']	= $this->load->controller('common/sidenav', $data);
        $data['template']['topmenu']	= $this->load->controller('common/topmenu', $data);

        //CHECK LOGIN STATUS
		if( !isset($_SESSION['user']) OR $_SESSION['user']['is_login'] != true ):

			header( 'Location:' . $this->config->get('base_url') . '/logout' );
			exit();

		endif;

        // RETRIVE USER_ROLE
        $this->load->model('user/role');

        foreach( $this->model_user_role->select('id', 'role')->get() as $key => $element ):
            $data['user']['roles'][$key]['id'] = $element->id;
            $data['user']['roles'][$key]['name'] = $element->role;
        endforeach;

		// RENDER VIEW
        $this->load->view('user/add', $data);
        
    }


    public function ajax_add() {

        /**
         * This method will receive ajax request from
         * the front end with the following payload
         *    - role_id
         *    - username
         *    - pass
         *    - pass_confirm
         *    - email
         * 
         * We need to validate the data and then perform
         * the following tasks.
         *    - validate
         *    - CRUD
         *    - response ( JSON )
         */

        // SET JSON HEADER
        header('Content-Type: application/json');

        // VALIDATION : ROLE ID
        if ( GUMP::is_valid($this->request->post, array('role_id' => 'required|integer|max_len,2')) !== true ):
            echo json_encode( array( "error" => "We didn't got valid role id ?" ), JSON_PRETTY_PRINT );
            exit();
        endif;

        // VALIDATION : USERNAME
        $is_valid_username = GUMP::is_valid($this->request->post, array('username' => 'required|alpha_numeric|min_len,6|max_len,20'));
        if ( $is_valid_username !== true ):
            echo json_encode( array( "error" => $is_valid_username[0] ), JSON_PRETTY_PRINT );
            exit();
        endif;

        // VALIDATION : PASS
        $is_valid_password = GUMP::is_valid($this->request->post, array('pass' => 'required|alpha_numeric|min_len,6|max_len,255'));
        if ( $is_valid_password !== true ):
            echo json_encode( array( "error" => $is_valid_password[0] ), JSON_PRETTY_PRINT );
            exit();
        endif;

        // VALIDATION : PASS CONFIRM
        if ( $this->request->post['pass'] !== $this->request->post['pass_confirm'] ):
            echo json_encode( array( "error" => "Entered Passwords doesn't match" ), JSON_PRETTY_PRINT );
            exit();
        endif;

        // VALIDATION : EMAIL
        $is_valid_email = GUMP::is_valid($this->request->post, array('email' => 'required|valid_email|max_len,50'));
        if ( $is_valid_email  !== true ):
            echo json_encode( array( "error" => $is_valid_email[0] ), JSON_PRETTY_PRINT );
            exit();
        endif;

        // MODEL
        $this->load->model('user');

        $this->model_user->role_id = $this->request->post['role_id'];
        $this->model_user->username = $this->request->post['username'];
        $this->model_user->password = password_hash($this->request->post['pass'], PASSWORD_DEFAULT);
        $this->model_user->email = $this->request->post['email'];
        
        // SUBMIT
        if ( $this->model_user->save() ):
            echo json_encode( array( "status" => "success" ), JSON_PRETTY_PRINT );
        else:
            echo json_encode( array( "status" => "failed" ), JSON_PRETTY_PRINT );
        endif;

    }
    
}
?>