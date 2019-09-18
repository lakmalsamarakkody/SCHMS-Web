<?php

class Student extends Controller {
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
        $this->load->view('student/index', $data);
        
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
        $this->load->view('student/search', $data);
        
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

        // MODELS
        $this->load->model('class');
        $this->load->model('grade');
        $this->load->model('staff');
        $this->load->model('subject');
        $this->load->model('religion');
        $this->load->model('district');
        $this->load->model('student/relation');

        //STUDENT CLASS
        foreach( $this->model_class->select('id', 'grade_id', 'staff_id', 'name')->get() as $key => $element ):
            $data['student_class'][$key]['id'] = $element->id;
            $data['student_class'][$key]['grade']['id'] = $element->grade_id;
            $data['student_class'][$key]['staff']['id'] = $element->staff_id;
            $data['student_class'][$key]['name'] = $element->name;

            $data['student_class'][$key]['grade']['name'] = $this->model_grade->select('name')->where('id', '=', $element->grade_id)->first()->name;
        endforeach;

        //RELIGION
        foreach( $this->model_religion->select('id', 'name')->get() as $key => $element ):
            $data['student_religion'][$key]['id'] = $element->id;
            $data['student_religion'][$key]['name'] = $element->name;
        endforeach;

        //DISTRICT
        foreach( $this->model_district->select('id', 'province_id', 'name')->get() as $key => $element ):
            $data['student_district'][$key]['id'] = $element->id;
            $data['student_district'][$key]['province']['id'] = $element->province_id;
            $data['student_district'][$key]['name'] = $element->name;
        endforeach;

        //RELATIONSHIP
        foreach( $this->model_student_relation->select('id', 'name')->get() as $key => $element ):
            $data['student_relation_type'][$key]['id'] = $element->id;
            $data['student_relation_type'][$key]['name'] = $element->name;
        endforeach;

		// RENDER VIEW
        $this->load->view('student/add', $data);
        
    }

    public function ajax_retrive_province_by_district($id) {

        // SET JSON HEADER
        header('Content-Type: application/json');

        // MODEL
        $this->load->model('district');
        $this->load->model('province');

        $province_id = $this->model_district->select('province_id')->where('id', '=', $id)->first()->province_id;

        echo json_encode(array( "status" => "success", "data" => $this->model_province->select('id', 'name')->where('id', '=', $province_id)->first() ));

    }

    public function ajax_add() {

        /**
         * This method will receive ajax request from
         * the front end with the payload
         * 
         *   STUDENT DATA
         *   addno
         *   adddate
         *   class
         *   subject_ids
         *   fn
         *   initials
         *   sn
         *   dob
         *   gen
         *   email
         *   mobno
         *   address
         *   city
         *   dist
         *   province
         *   bp
         *   rel
         * 
         * // GUARDIAN 1ST DATA
         *   g1fn
         *   g1ini
         *   g1sn
         *   g1dob
         *   g1rel
         *   g1gen
         *   g1nic
         *   g1tel
         *   g1mobi
         *   g1occu
         *   g1pos
         *   g1inc
         *   g1mail
         *   g1address
         *   g1city
         *   g1dist
         *   g1province
         * 
         * We need to validate the data and then perform
         * the following tasks.
         *    - validate
         *    - CRUD
         *    - response ( JSON )
         */

        // SET JSON HEADER
        header('Content-Type: application/json');

        // VALIDATION : addno
        $is_valid_addno = GUMP::is_valid($this->request->post, array('addno' => 'required|integer|max_len,6'));
        if ( $is_valid_addno !== true ):
            echo json_encode( array( "error" => $is_valid_addno[0] ), JSON_PRETTY_PRINT );
            exit();
        endif;

        // VALIDATION : adddate
        $is_valid_adddate = GUMP::is_valid($this->request->post, array('adddate' => 'required|date'));
        if ( $is_valid_adddate !== true ):
            echo json_encode( array( "error" => $is_valid_adddate[0] ), JSON_PRETTY_PRINT );
            exit();
        endif;

        // VALIDATION : class
        $is_valid_class = GUMP::is_valid($this->request->post, array('class' => 'required|integer|max_len,3'));
        if ( $is_valid_class !== true ):
            echo json_encode( array( "error" => $is_valid_class[0] ), JSON_PRETTY_PRINT );
            exit();
        endif;

        // VALIDATION : subject_ids
        $is_valid_subject_ids = GUMP::is_valid($this->request->post, array('subject_ids' => 'required|integer|max_len,3'));
        if ( $is_valid_subject_ids !== true ):
            echo json_encode( array( "error" => $is_valid_subject_ids[0] ), JSON_PRETTY_PRINT );
            exit();
        endif;

        // VALIDATION : fn
        $is_valid_fn = GUMP::is_valid($this->request->post, array('fn' => 'required|alpha|max_len,100'));
        if ( $is_valid_fn !== true ):
            echo json_encode( array( "error" => $is_valid_fn[0] ), JSON_PRETTY_PRINT );
            exit();
        endif;

        // VALIDATION : initials
        $is_valid_initials = GUMP::is_valid($this->request->post, array('initials' => 'required|alpha|max_len,10'));
        if ( $is_valid_initials !== true ):
            echo json_encode( array( "error" => $is_valid_initials[0] ), JSON_PRETTY_PRINT );
            exit();
        endif;

        // VALIDATION : sn
        $is_valid_sn = GUMP::is_valid($this->request->post, array('sn' => 'required|alpha|max_len,20'));
        if ( $is_valid_sn !== true ):
            echo json_encode( array( "error" => $is_valid_sn[0] ), JSON_PRETTY_PRINT );
            exit();
        endif;

        // VALIDATION : dob
        $is_valid_dob = GUMP::is_valid($this->request->post, array('dob' => 'required|date'));
        if ( $is_valid_dob !== true ):
            echo json_encode( array( "error" => $is_valid_dob[0] ), JSON_PRETTY_PRINT );
            exit();
        endif;

        // VALIDATION : gen
        $is_valid_gen = GUMP::is_valid($this->request->post, array('gen' => 'required|contains_list,(Male;Female)'));
        if ( $is_valid_gen !== true ):
            echo json_encode( array( "error" => $is_valid_gen[0] ), JSON_PRETTY_PRINT );
            exit();
        endif;

        // VALIDATION : email
        $is_valid_email = GUMP::is_valid($this->request->post, array('email' => 'required|email'));
        if ( $is_valid_email !== true ):
            echo json_encode( array( "error" => $is_valid_email[0] ), JSON_PRETTY_PRINT );
            exit();
        endif;

        // VALIDATION : mobno
        $is_valid_mobno = GUMP::is_valid($this->request->post, array('mobno' => 'required|integer|max_len,10'));
        if ( $is_valid_mobno !== true ):
            echo json_encode( array( "error" => $is_valid_mobno[0] ), JSON_PRETTY_PRINT );
            exit();
        endif;

        // VALIDATION : address
        $is_valid_address = GUMP::is_valid($this->request->post, array('address' => 'required|alpha_numeric|max_len,50'));
        if ( $is_valid_address !== true ):
            echo json_encode( array( "error" => $is_valid_address[0] ), JSON_PRETTY_PRINT );
            exit();
        endif;

        // VALIDATION : city
        $is_valid_city = GUMP::is_valid($this->request->post, array('city' => 'required|alpha|max_len,20'));
        if ( $is_valid_city !== true ):
            echo json_encode( array( "error" => $is_valid_city[0] ), JSON_PRETTY_PRINT );
            exit();
        endif;

        // VALIDATION : dist
        $is_valid_dist = GUMP::is_valid($this->request->post, array('dist' => 'required|integer|max_len,2'));
        if ( $is_valid_dist !== true ):
            echo json_encode( array( "error" => $is_valid_dist[0] ), JSON_PRETTY_PRINT );
            exit();
        endif;

        // VALIDATION : bp
        $is_valid_bp = GUMP::is_valid($this->request->post, array('bp' => 'required|alpha|max_len,30'));
        if ( $is_valid_bp !== true ):
            echo json_encode( array( "error" => $is_valid_dist[0] ), JSON_PRETTY_PRINT );
            exit();
        endif;

        // VALIDATION : rel
        $is_valid_rel = GUMP::is_valid($this->request->post, array('rel' => 'required|integer|max_len,2'));
        if ( $is_valid_rel !== true ):
            echo json_encode( array( "error" => $is_valid_rel[0] ), JSON_PRETTY_PRINT );
            exit();
        endif;

        // VALIDATION : g1fn
        $is_valid_g1fn = GUMP::is_valid($this->request->post, array('g1fn' => 'required|alpha|max_len,100'));
        if ( $is_valid_g1fn !== true ):
            echo json_encode( array( "error" => $is_valid_g1fn[0] ), JSON_PRETTY_PRINT );
            exit();
        endif;

        // VALIDATION : g1ini
        $is_valid_g1ini = GUMP::is_valid($this->request->post, array('g1ini' => 'required|alpha|max_len,10'));
        if ( $is_valid_g1ini !== true ):
            echo json_encode( array( "error" => $is_valid_g1ini[0] ), JSON_PRETTY_PRINT );
            exit();
        endif;

        // VALIDATION : g1sn
        $is_valid_g1sn = GUMP::is_valid($this->request->post, array('g1sn' => 'required|alpha|max_len,20'));
        if ( $is_valid_g1sn !== true ):
            echo json_encode( array( "error" => $is_valid_g1sn[0] ), JSON_PRETTY_PRINT );
            exit();
        endif;

        // VALIDATION : g1dob
        $is_valid_g1dob = GUMP::is_valid($this->request->post, array('g1dob' => 'required|date'));
        if ( $is_valid_g1dob !== true ):
            echo json_encode( array( "error" => $is_valid_dob[0] ), JSON_PRETTY_PRINT );
            exit();
        endif;

        // VALIDATION : rel
        $is_valid_rel = GUMP::is_valid($this->request->post, array('rel' => 'required|integer|max_len,2'));
        if ( $is_valid_rel !== true ):
            echo json_encode( array( "error" => $is_valid_rel[0] ), JSON_PRETTY_PRINT );
            exit();
        endif;

        // VALIDATION : g1gen
        $is_valid_g1gen = GUMP::is_valid($this->request->post, array('g1gen' => 'required|contains_list,(Male;Female)'));
        if ( $is_valid_g1gen !== true ):
            echo json_encode( array( "error" => $is_valid_gen[0] ), JSON_PRETTY_PRINT );
            exit();
        endif;

        // VALIDATION : g1nic
        $is_valid_g1nic = GUMP::is_valid($this->request->post, array('g1nic' => "required"));
        if ( $is_valid_g1nic === true ):
            if ( preg_match("/^([0-9]{9}[x|X|v|V]|[0-9]{12})$/", $this->request->post['g1nic']) == false ):
                echo json_encode( array( "error" => "Wrong NIC Format" ), JSON_PRETTY_PRINT );
                exit();
            endif;
        else:
            echo json_encode( array( "error" => $is_valid_g1nic[0] ), JSON_PRETTY_PRINT );
            exit();
        endif;

        // VALIDATION : g1tel
        $is_valid_g1tel = GUMP::is_valid($this->request->post, array('g1tel' => 'required|integer|max_len,10'));
        if ( $is_valid_g1tel !== true ):
            echo json_encode( array( "error" => $is_valid_g1tel[0] ), JSON_PRETTY_PRINT );
            exit();
        endif;

        // VALIDATION : g1mobi
        $is_valid_g1mobi = GUMP::is_valid($this->request->post, array('g1mobi' => 'required|integer|max_len,10'));
        if ( $is_valid_g1mobi !== true ):
            echo json_encode( array( "error" => $is_valid_g1mobi[0] ), JSON_PRETTY_PRINT );
            exit();
        endif;

        // VALIDATION : g1occu
        $is_valid_g1occu = GUMP::is_valid($this->request->post, array('g1occu' => 'required|alpha|max_len,50'));
        if ( $is_valid_g1occu !== true ):
            echo json_encode( array( "error" => $is_valid_g1occu[0] ), JSON_PRETTY_PRINT );
            exit();
        endif;

        // VALIDATION : g1pos
        $is_valid_g1sn = GUMP::is_valid($this->request->post, array('g1sn' => 'required|alpha|max_len,50'));
        if ( $is_valid_g1sn !== true ):
            echo json_encode( array( "error" => $is_valid_g1sn[0] ), JSON_PRETTY_PRINT );
            exit();
        endif;

        // VALIDATION : g1inc
        $is_valid_g1inc = GUMP::is_valid($this->request->post, array('g1inc' => 'required|integer|max_len,10'));
        if ( $is_valid_g1inc !== true ):
            echo json_encode( array( "error" => $is_valid_g1inc[0] ), JSON_PRETTY_PRINT );
            exit();
        endif;

        // VALIDATION : g1mail
        $is_valid_g1mail = GUMP::is_valid($this->request->post, array('g1mail' => 'required|g1mail'));
        if ( $is_valid_g1mail !== true ):
            echo json_encode( array( "error" => $is_valid_g1mail[0] ), JSON_PRETTY_PRINT );
            exit();
        endif;

        // VALIDATION : g1address
        $is_valid_g1address = GUMP::is_valid($this->request->post, array('g1address' => 'required|alpha_numeric|max_len,50'));
        if ( $is_valid_g1address !== true ):
            echo json_encode( array( "error" => $is_valid_g1address[0] ), JSON_PRETTY_PRINT );
            exit();
        endif;

        // VALIDATION : g1city
        $is_valid_g1city = GUMP::is_valid($this->request->post, array('g1city' => 'required|alpha|max_len,20'));
        if ( $is_valid_g1city !== true ):
            echo json_encode( array( "error" => $is_valid_g1city[0] ), JSON_PRETTY_PRINT );
            exit();
        endif;

        // VALIDATION : g1dist
        $is_valid_g1dist = GUMP::is_valid($this->request->post, array('g1dist' => 'required|integer|max_len,2'));
        if ( $is_valid_g1dist !== true ):
            echo json_encode( array( "error" => $is_valid_g1dist[0] ), JSON_PRETTY_PRINT );
            exit();
        endif;

        //MODEL
        $this->load->model('student');

        $this->model_student->role_id = $this->request->post['addno'];
        $this->model_student->role_id = $this->request->post['emploadddateyee_no'];
        $this->model_student->role_id = $this->request->post['class'];
        $this->model_student->role_id = $this->request->post['subject_ids'];
        $this->model_student->role_id = $this->request->post['fn'];
        $this->model_student->role_id = $this->request->post['initials'];
        $this->model_student->role_id = $this->request->post['sn'];
        $this->model_student->role_id = $this->request->post['dob'];
        $this->model_student->role_id = $this->request->post['gen'];
        $this->model_student->role_id = $this->request->post['email'];
        $this->model_student->role_id = $this->request->post['mobno'];
        $this->model_student->role_id = $this->request->post['address'];
        $this->model_student->role_id = $this->request->post['city'];
        $this->model_student->role_id = $this->request->post['dist'];
        $this->model_student->role_id = $this->request->post['province'];
        $this->model_student->role_id = $this->request->post['bp'];
        $this->model_student->role_id = $this->request->post['rel'];

        $this->load->model('parent');

        $this->model_parent->role_id = $this->request->post['g1fn'];
        $this->model_parent->role_id = $this->request->post['g1ini'];
        $this->model_parent->role_id = $this->request->post['g1sn'];
        $this->model_parent->role_id = $this->request->post['g1dob'];
        $this->model_parent->role_id = $this->request->post['g1rel'];
        $this->model_parent->role_id = $this->request->post['g1gen'];
        $this->model_parent->role_id = $this->request->post['g1nic'];
        $this->model_parent->role_id = $this->request->post['g1tel'];
        $this->model_parent->role_id = $this->request->post['g1mobi'];
        $this->model_parent->role_id = $this->request->post['g1occu'];
        $this->model_parent->role_id = $this->request->post['g1pos'];
        $this->model_parent->role_id = $this->request->post['g1inc'];
        $this->model_parent->role_id = $this->request->post['g1mail'];
        $this->model_parent->role_id = $this->request->post['g1address'];
        $this->model_parent->role_id = $this->request->post['g1city'];
        $this->model_parent->role_id = $this->request->post['g1dist'];

        // SUBMIT
        if ( $this->model_staff->save() ):
            echo json_encode( array( "status" => "success" ), JSON_PRETTY_PRINT );
        else:
            echo json_encode( array( "status" => "failed" ), JSON_PRETTY_PRINT );
        endif;

    }
    
}
?>