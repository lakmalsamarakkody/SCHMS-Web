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
        $this->load->model('class');
        $this->load->model('grade');

        foreach( $this->model_user_role->select('id', 'name')->orderBy('name')->get() as $key => $element ):
            $data['user']['roles'][$key]['id'] = $element->id;
            $data['user']['roles'][$key]['name'] = $element->name;
        endforeach;

        //STAFF CLASS
        foreach( $this->model_class->select('id', 'grade_id', 'staff_id', 'name')->orderBy('grade_id')->orderBy('name')->get() as $key => $element ):
            $data['classes'][$key]['id'] = $element->id;
            $data['classes'][$key]['grade']['id'] = $element->grade_id;
            $data['classes'][$key]['staff']['id'] = $element->staff_id;
            $data['classes'][$key]['name'] = $element->name;
            $data['classes'][$key]['grade']['name'] = $this->model_grade->select('name')->where('id', '=', $element->grade_id)->first()->name;
            $data['classes'][$key]['class_name'] = $data['classes'][$key]['grade']['name']." - ". $data['classes'][$key]['name'] = $element->name; ;
        endforeach;

        //USER TYPE
        
        

        // SEARCH
        if ( isset($this->request->post['isSubmited'])):

            // PERSIST DATA

            // PERSIST DATA
            $data['form']['field']['role_id'] = ( isset($this->request->post['role_id']) AND !empty($this->request->post['role_id']) ) ? $this->request->post['role_id'] : "";
            $data['form']['field']['ref_id'] = ( isset($this->request->post['ref_id']) AND !empty($this->request->post['ref_id']) ) ? $this->request->post['ref_id'] : "";
            $data['form']['field']['type'] = ( isset($this->request->post['type']) AND !empty($this->request->post['type']) ) ? $this->request->post['type'] : "";
            $data['form']['field']['class_id'] = ( isset($this->request->post['class_id']) AND !empty($this->request->post['class_id']) ) ? $this->request->post['class_id'] : "";
            $data['form']['field']['status'] = ( isset($this->request->post['status']) AND !empty($this->request->post['status']) ) ? $this->request->post['status'] : "";
            $data['form']['field']['username'] = ( isset($this->request->post['username']) AND !empty($this->request->post['username']) ) ? $this->request->post['username'] : "";
            $data['form']['field']['created_on'] = ( isset($this->request->post['created_on']) AND !empty($this->request->post['created_on']) ) ? $this->request->post['created_on'] : "";
            
        endif;

		// RENDER VIEW
        $this->load->view('user/search', $data);
        
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