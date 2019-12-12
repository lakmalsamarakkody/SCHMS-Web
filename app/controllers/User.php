<?php

use Illuminate\Database\Capsule\Manager as DB;

class User extends Controller {
    public function index() {

        //CHECK LOGIN STATUS
		if( !isset($_SESSION['user']) OR $_SESSION['user']['is_login'] != true ):
			header( 'Location:' . $this->config->get('base_url') . '/logout' );
			exit();
		endif;
    
        // SITE DETAILS
		$data['app']['url']			= $this->config->get('base_url');
		$data['app']['title']		= $this->config->get('site_title');
		$data['app']['theme']		= $this->config->get('app_theme');

		// HEADER / FOOTER
		$data['template']['header']		= $this->load->controller('common/header', $data);
        $data['template']['footer']		= $this->load->controller('common/footer', $data);
        $data['template']['sidenav']	= $this->load->controller('common/sidenav', $data);
        $data['template']['topmenu']	= $this->load->controller('common/topmenu', $data);

        // MODEL
        $this->load->model('user');
        $this->load->model('user/role');

        // USER CARDS
        $data['user']['total']['all'] = $this->model_user->select('id')->count();
        $data['user']['total']['active'] = $this->model_user->select('id')->where('status', '=', 'Active')->count();
        $data['user']['total']['disabled'] = $this->model_user->select('id')->where('status', '=', 'Inactive')->count();

        // APEX CHARTS
        // BAR CHART
        foreach( $this->model_user_role->select('id', 'name')->orderBy('name')->get() as $key => $element ):
            $data['user']['roles'][$key]['id'] = $element->id;
            $data['user']['roles'][$key]['role'] = $element->name;
            $data['user']['roles'][$key]['count'] = $this->model_user->select('id')->where('role_id', '=', $element->id)->count();
        endforeach;

		// RENDER VIEW
        $this->load->view('user/index', $data);
        
    }

    public function search() {

        //CHECK LOGIN STATUS
		if( !isset($_SESSION['user']) OR $_SESSION['user']['is_login'] != true ):
			header( 'Location:' . $this->config->get('base_url') . '/logout' );
			exit();
		endif;
    
        // SITE DETAILS
		$data['app']['url']			= $this->config->get('base_url');
		$data['app']['title']		= $this->config->get('site_title');
		$data['app']['theme']		= $this->config->get('app_theme');

		// HEADER / FOOTER
		$data['template']['header']		= $this->load->controller('common/header', $data);
        $data['template']['footer']		= $this->load->controller('common/footer', $data);
        $data['template']['sidenav']	= $this->load->controller('common/sidenav', $data);
        $data['template']['topmenu']	= $this->load->controller('common/topmenu', $data);

        // RETRIVE USER_ROLE
        $this->load->model('user');
        $this->load->model('user/role');

        foreach( $this->model_user_role->select('id', 'name')->orderBy('name')->get() as $key => $element ):
            $data['user']['roles'][$key]['id'] = $element->id;
            $data['user']['roles'][$key]['name'] = $element->name;
        endforeach;

		// RENDER VIEW
        $this->load->view('user/search', $data);
        
    }
    
    public function add() {

        //CHECK LOGIN STATUS
		if( !isset($_SESSION['user']) OR $_SESSION['user']['is_login'] != true ):
			header( 'Location:' . $this->config->get('base_url') . '/logout' );
			exit();
		endif;
    
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

        foreach( $this->model_user_role->select('id', 'name')->orderBy('name')->get() as $key => $element ):
            $data['user']['roles'][$key]['id'] = $element->id;
            $data['user']['roles'][$key]['name'] = $element->name;
        endforeach;

		// RENDER VIEW
        $this->load->view('user/add', $data);
        
    }


    public function ajax_add() {

        //CHECK LOGIN STATUS
		if( !isset($_SESSION['user']) OR $_SESSION['user']['is_login'] != true ):
			header( 'Location:' . $this->config->get('base_url') . '/logout' );
			exit();
		endif;

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

        //  Model
        $this->load->model('user');

        // SET JSON HEADER
        header('Content-Type: application/json');

        // VALIDATION : ROLE ID
        if ( GUMP::is_valid($this->request->post, array('role_id' => 'required|integer|max_len,2')) !== true ):
            echo json_encode( array( "error" => "Please select a user role" ), JSON_PRETTY_PRINT );
            exit();
        endif;

        // VALIDATION : USERNAME
        $is_valid_username = GUMP::is_valid($this->request->post, array('username' => 'required|alpha_numeric|min_len,6|max_len,20'));
        if ( $is_valid_username !== true ):
            echo json_encode( array( "error" => "Please insert a username with minimum 6 characters" ), JSON_PRETTY_PRINT );
            exit();
        endif;

            // USERNAME IS INSERTED : CHECK FOR DUPLICATE
            if ( $this->model_user->select('id')->where('username', '=', $this->request->post['username'])->first() != NULL ):
                echo json_encode( array( "error" => "This username is taken" ), JSON_PRETTY_PRINT );
                exit();
            endif;

        // VALIDATION : PASS
        $is_valid_password = GUMP::is_valid($this->request->post, array('pass' => 'required|alpha_numeric|min_len,6|max_len,255'));
        if ( $is_valid_password !== true ):
            echo json_encode( array( "error" => "Please insert a password with minimum 6 characters" ), JSON_PRETTY_PRINT );
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
            echo json_encode( array( "error" => "Please enter a valid email" ), JSON_PRETTY_PRINT );
            exit();
        endif;

            // email IS ENTERED : CHECK FOR DUPLICATE
            if ( $this->request->post['email'] !== ""):
                if ( $this->model_user->select('id')->where('email', '=', $this->request->post['email'])->first() != NULL ):
                    echo json_encode( array( "error" => "This email is already exist" ), JSON_PRETTY_PRINT );
                    exit();
                endif;
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

    public function permission() {

        //CHECK LOGIN STATUS
		if( !isset($_SESSION['user']) OR $_SESSION['user']['is_login'] != true ):
			header( 'Location:' . $this->config->get('base_url') . '/logout' );
			exit();
		endif;
    
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

        foreach( $this->model_user_role->select('id', 'name')->orderBy('name')->get() as $key => $element ):
            $data['user']['roles'][$key]['id'] = $element->id;
            $data['user']['roles'][$key]['name'] = $element->name;
        endforeach;

		// RENDER VIEW
        $this->load->view('user/permission', $data);
        
    }
    
}
?>