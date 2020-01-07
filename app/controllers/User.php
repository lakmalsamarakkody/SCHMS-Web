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

        // //STAFF CLASS
        // foreach( $this->model_class->select('id', 'grade_id', 'staff_id', 'name')->orderBy('grade_id')->orderBy('name')->get() as $key => $element ):
        //     $data['classes'][$key]['id'] = $element->id;
        //     $data['classes'][$key]['grade']['id'] = $element->grade_id;
        //     $data['classes'][$key]['staff']['id'] = $element->staff_id;
        //     $data['classes'][$key]['name'] = $element->name;
        //     $data['classes'][$key]['grade']['name'] = $this->model_grade->select('name')->where('id', '=', $element->grade_id)->first()->name;
        //     $data['classes'][$key]['class_name'] = $data['classes'][$key]['grade']['name']." - ". $data['classes'][$key]['name'] = $element->name; ;
        // endforeach;

        //USER TYPE
        $data['user']['types'][1]['name'] = "staff";
        $data['user']['types'][2]['name'] = "student";
        $data['user']['types'][3]['name'] = "parent";
        $data['user']['types'][4]['name'] = "coach";
        
        // SEARCH
        if ( isset($this->request->post['isSubmited'])):

            // PERSIST DATA
            $data['form']['field']['role_id'] = ( isset($this->request->post['role_id']) AND !empty($this->request->post['role_id']) ) ? $this->request->post['role_id'] : "";
            $data['form']['field']['ref_id'] = ( isset($this->request->post['ref_id']) AND !empty($this->request->post['ref_id']) ) ? $this->request->post['ref_id'] : "";
            $data['form']['field']['type'] = ( isset($this->request->post['type']) AND !empty($this->request->post['type']) ) ? $this->request->post['type'] : "";
            // $data['form']['field']['class_id'] = ( isset($this->request->post['class_id']) AND !empty($this->request->post['class_id']) ) ? $this->request->post['class_id'] : "";
            $data['form']['field']['status'] = ( isset($this->request->post['status']) AND !empty($this->request->post['status']) ) ? $this->request->post['status'] : "";
            $data['form']['field']['username'] = ( isset($this->request->post['username']) AND !empty($this->request->post['username']) ) ? $this->request->post['username'] : "";
            $data['form']['field']['theme'] = ( isset($this->request->post['theme']) AND !empty($this->request->post['theme']) ) ? $this->request->post['theme'] : "";
            $data['form']['field']['created_on'] = ( isset($this->request->post['created_on']) AND !empty($this->request->post['created_on']) ) ? $this->request->post['created_on'] : "";
            
        endif;

        // Eloquent OBJECT
        $user = $this->model_user->select('id', 'ref_id', 'user_type', 'username', 'theme', 'role_id', 'status', 'created_on');

        // FILTER ( ROLE ID )
        if ( isset($this->request->post['role_id']) AND !empty($this->request->post['role_id']) ):
            $user->where(function($query) {
                $query->where('role_id', '=', $this->request->post['role_id']);
            });
        endif;

        // FILTER ( REF ID )
        if ( isset($this->request->post['ref_id']) AND !empty($this->request->post['ref_id']) ):
            $user->where(function($query) {
                $query->where('ref_id', '=', $this->request->post['ref_id']);
            });
        endif;

        // FILTER ( USER TYPE )
        if ( isset($this->request->post['type']) AND !empty($this->request->post['type']) ):
            $user->where(function($query) {
                $query->where('user_type', '=', $this->request->post['type']);
            });
        endif;

        // FILTER ( STATUS )
        if ( isset($this->request->post['status']) AND !empty($this->request->post['status']) ):
            $user->where(function($query) {
                $query->where('status', '=', $this->request->post['status']);
            });
        endif;

        // FILTER ( USERNAME )
        if ( isset($this->request->post['username']) AND !empty($this->request->post['username']) ):
            $user->where(function($query) {
                $query->where('username', 'LIKE', '%'.$this->request->post['username'].'%');
            });
        endif;

        // FILTER ( THEME )
        if ( isset($this->request->post['theme']) AND !empty($this->request->post['theme']) ):
            $user->where(function($query) {
                $query->where('theme', '=', $this->request->post['theme']);
            });
        endif;

        // FILTER ( CREATED ON )
        if ( isset($this->request->post['created_on']) AND !empty($this->request->post['created_on']) ):
            $user->where(function($query) {
                $query->where('created_on', '=', $this->request->post['created_on']);
            });
        endif;

        // APPEND DATA TO ARRAY
        foreach( $user->get() as $key => $value ):
            $data['users'][$key]['id'] = $value->id;
            $data['users'][$key]['ref_id'] = $value->ref_id;
            $data['users'][$key]['user_type'] = $value->user_type;
            $data['users'][$key]['username'] = $value->username;
            $data['users'][$key]['theme'] = $value->theme;
            $data['users'][$key]['role_id'] = $value->role_id;
            $data['users'][$key]['role_name'] = $this->model_user_role->select('name')->where('id', '=', $value->role_id)->first()->name;
            $data['users'][$key]['status'] = $value->status;
            $data['users'][$key]['created_on'] = $value->created_on;
        endforeach;


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


        // RETRIVE USER_ROLE
        $this->load->model('user/role');
        $this->load->model('user/permission');
        $this->load->model('user/rolepermission');

        foreach( $this->model_user_role->select('id', 'name')->orderBy('name')->get() as $key => $element ):
            $data['user']['roles'][$key]['id'] = $element->id;
            $data['user']['roles'][$key]['name'] = $element->name;
        endforeach;

        if ( isset($this->request->post['is_submit']) ):
            
            $data['role_id'] = $this->request->post['role'];
            
            foreach ($this->model_user_permission->all() as $key => $value ):
                $data['permissions'][$key]['id'] = $value->id;
                $data['permissions'][$key]['name'] = $value->name;
            endforeach;

            foreach( $this->model_user_rolepermission->where('role_id', $this->request->post['role'] )->get() as $key => $value):
                $data['rolepermissions'][$key] = $value->permission_id;
            endforeach;

        endif;

		// RENDER VIEW
        $this->load->view('user/permission', $data);
        
    }


    public function ajax_change_theme(){

        // SET JSON HEADER
        header('Content-Type: application/json');

        //CHECK LOGIN STATUS
        if( !isset($_SESSION['user']) OR $_SESSION['user']['is_login'] != true ):
            header( 'Location:' . $this->config->get('base_url') . '/logout' );
            exit();
        endif;

        $validate = GUMP::is_valid($this->request->post,['theme' => 'required|contains,dark light']);
        $is_valid_theme_name = GUMP::is_valid($this->request->post, array('theme' => 'required|contains,Dark Default'));
        
        if ( $is_valid_theme_name !== true  ){
            echo json_encode( array( "status" => "error", "error" => "Invalid theme name." ), JSON_PRETTY_PRINT );
            return;
        }

        // LOAD MODEL
        $this->load->model('user');

        // GET LOGGED IN USER'S MODEL
        $User = $this->model_user->findOrFail($_SESSION['user']['id']);
        $User->theme = $this->request->post['theme'];
        $User->save();

        echo json_encode(array("status" => "success"), JSON_PRETTY_PRINT);
        return;

    }


    // public function ajax_get_roles_permissions(){

    //     // SET JSON HEADER
    //     header('Content-Type: application/json');

    //     $validate = GUMP::is_valid($this->request->post, ['role_id' => 'required']);
        
    //     if ( $validate !== true ){
    //         echo json_encode(array("status" => "error", "error" => "Invalid role id."));
    //         return;
    //     }

    //     $this->load->model('user/role');
    //     $this->load->model('user/rolepermission');
    //     $this->load->model('user/permission');
        
    //     $Role = $this->model_user_role->findOrFail($this->request->post['role_id']);
        
    //     $RoleHasPermission = $this->model_user_rolepermission->where('role_id', $Role->id)->get();

    //     // return var_dump($RoleHasPermission->first()->permission_id);

    //     foreach( $RoleHasPermission as $key => $value ){
    //         $RoleHasPermission[$key]['permission'] = $this->model_user_permission->where('id', $value->permission_id)->first();
    //     }

    //     echo json_encode(array('status' => 'success', 'data' => $RoleHasPermission));
    //     return;

    // }

    
}
?>