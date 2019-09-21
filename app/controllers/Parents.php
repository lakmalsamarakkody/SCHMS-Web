<?php

class Parents extends Controller {
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
        $this->load->view('parents/index', $data);
        
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
        $this->load->view('parents/search', $data);
        
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

        //  MODEL
        $this->load->model('student');
        $this->load->model('class');
        $this->load->model('grade');
        $this->load->model('student/relation');
        $this->load->model('district');
        $this->load->model('province');


        //STUDENT CLASS
        foreach( $this->model_class->select('id', 'grade_id', 'staff_id', 'name')->get() as $key => $element ):
            $data['student_class'][$key]['id'] = $element->id;
            $data['student_class'][$key]['grade']['id'] = $element->grade_id;
            $data['student_class'][$key]['staff']['id'] = $element->staff_id;
            $data['student_class'][$key]['name'] = $element->name;

            $data['student_class'][$key]['grade']['name'] = $this->model_grade->select('name')->where('id', '=', $element->grade_id)->first()->name;
        endforeach;

        //RELATIONSHIP
        foreach( $this->model_student_relation->select('id', 'name')->get() as $key => $element ):
            $data['relation_type'][$key]['id'] = $element->id;
            $data['relation_type'][$key]['name'] = $element->name;
        endforeach;

        //DISTRICT
        foreach( $this->model_district->select('id', 'province_id', 'name')->get() as $key => $element ):
            $data['districts'][$key]['id'] = $element->id;
            $data['districts'][$key]['province']['id'] = $element->province_id;
            $data['districts'][$key]['name'] = $element->name;
        endforeach;

        // CHECK SUBMIT
        if ( isset($this->request->post['isSubmited']) ):

            $student = $this->model_student->select('id', 'admission_no', 'admission_date', 'full_name', 'class_id');

            // FILTER ( ADMISSION NO )
            if ( isset($this->request->post['addno']) AND !empty($this->request->post['addno']) ):
                $student->where(function($query) {
                    $query->where('admission_no', '=', $this->request->post['addno']);
                });
            endif;

            // FILTER ( ADMISSION DATE )
            if ( isset($this->request->post['admission_date']) AND !empty($this->request->post['admission_date']) ):
                $student->where(function($query) {
                    $query->where('admission_date', '=', $this->request->post['admission_date']);
                });
            endif;

            // FILTER ( NAME )
            if ( isset($this->request->post['name']) AND !empty($this->request->post['name']) ):
                $student->where(function($query) {
                    $query->where('full_name', 'LIKE', '%'.$this->request->post['name'].'%');
                });
            endif;

            // FILTER ( NAME )
            if ( isset($this->request->post['class']) AND !empty($this->request->post['class']) ):
                $student->where(function($query) {
                    $query->where('class-id', '=', $this->request->post['class']);
                });
            endif;

            // APPEND DATA TO ARRAY
            foreach( $student->get() as $key => $value ):
                $data['students'][$key]['id'] = $value->id;
                $data['students'][$key]['admission_no'] = $value->admission_no;
                $data['students'][$key]['admission_date'] = $value->admission_date;
                $data['students'][$key]['name'] = $value->name;
                $data['students'][$key]['class_id'] = $value->class_id;
            endforeach;

            // DISPLAY QUERY ( TEMP )
            echo "<pre>";
                var_dump( $student->toSql() );
            echo "</pre>";

        endif;

		// RENDER VIEW
        $this->load->view('parents/add', $data);
        
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
         * // GUARDIAN 2ND DATA
         *   g2fn
         *   g2ini
         *   g2sn
         *   g2dob
         *   g2rel
         *   g2gen
         *   g2nic
         *   g2tel
         *   g2mobi
         *   g2occu
         *   g2pos
         *   g2inc
         *   g2mail
         *   g2address
         *   g2city
         *   g2dist
         *   g2province
         * 
         * We need to validate the data and then perform
         * the following tasks.
         *    - validate
         *    - CRUD
         *    - response ( JSON )
         */

        // SET JSON HEADER
        header('Content-Type: application/json');

        // SECOND GUARDIAN VALIDATION
        // VALIDATION : second_guardian_full_name
        $is_valid_second_guardian_full_name = GUMP::is_valid($this->request->post, array('second_guardian_full_name' => 'required|alpha|max_len,100'));
        if ( $is_valid_second_guardian_full_name !== true ):
            echo json_encode( array( "error" => "Please select a relation" ), JSON_PRETTY_PRINT );
            exit();
        endif;

        // VALIDATION : second_guardian_initials
        $is_valid_second_guardian_initials = GUMP::is_valid($this->request->post, array('second_guardian_initials' => 'required|alpha|max_len,10'));
        if ( $is_valid_second_guardian_initials !== true ):
            echo json_encode( array( "error" => "Please select a relation" ), JSON_PRETTY_PRINT );
            exit();
        endif;

        // VALIDATION : second_guardian_surname
        $is_valid_second_guardian_surname = GUMP::is_valid($this->request->post, array('second_guardian_surname' => 'required|alpha|max_len,20'));
        if ( $is_valid_second_guardian_surname !== true ):
            echo json_encode( array( "error" => "Please select a relation" ), JSON_PRETTY_PRINT );
            exit();
        endif;

        // VALIDATION : second_guardian_dob
        $is_valid_second_guardian_dob = GUMP::is_valid($this->request->post, array('second_guardian_dob' => 'required|date'));
        if ( $is_valid_second_guardian_dob !== true ):
            echo json_encode( array( "error" => "Please select a relation" ), JSON_PRETTY_PRINT );
            exit();
        endif;

        // VALIDATION : second_guardian_relation
        $is_valid_second_guardian_relation = GUMP::is_valid($this->request->post, array('second_guardian_relation' => 'required|integer|max_len,2'));
        if ( $is_valid_second_guardian_relation !== true ):
            echo json_encode( array( "error" => "Please select a relation type" ), JSON_PRETTY_PRINT );
            exit();
        endif;

        // VALIDATION : second_guardian_gender
        $is_valid_second_guardian_gender = GUMP::is_valid($this->request->post, array('second_guardian_gender' => 'required|contains_list,(Male;Female)'));
        if ( $is_valid_second_guardian_gender !== true ):
            echo json_encode( array( "error" => "Please select a gender" ), JSON_PRETTY_PRINT );
            exit();
        endif;

        // VALIDATION : second_guardian_nic
        $is_valid_second_guardian_nic = GUMP::is_valid($this->request->post, array('second_guardian_nic' => "required"));
        if ( $is_valid_second_guardian_nic === true ):
            if ( preg_match("/^([0-9]{9}[x|X|v|V]|[0-9]{12})$/", $this->request->post['second_guardian_nic']) == false ):
                echo json_encode( array( "error" => "Wrong NIC Format" ), JSON_PRETTY_PRINT );
                exit();
            endif;
        else:
            echo json_encode( array( "error" => "Please enter a NIC number" ), JSON_PRETTY_PRINT );
            exit();
        endif;

        // VALIDATION : second_guardian_telephone
        $is_valid_second_guardian_telephone = GUMP::is_valid($this->request->post, array('second_guardian_telephone' => 'required|integer|max_len,10'));
        if ( $is_valid_second_guardian_telephone !== true ):
            echo json_encode( array( "error" => "Please select a relation" ), JSON_PRETTY_PRINT );
            exit();
        endif;

        // VALIDATION : second_guardian_mobile_number
        $is_valid_second_guardian_mobile_number = GUMP::is_valid($this->request->post, array('second_guardian_mobile_number' => 'required|integer|max_len,10'));
        if ( $is_valid_second_guardian_mobile_number !== true ):
            echo json_encode( array( "error" => "Please select a relation" ), JSON_PRETTY_PRINT );
            exit();
        endif;

        // VALIDATION : second_guardian_occupation
        $is_valid_second_guardian_occupation = GUMP::is_valid($this->request->post, array('second_guardian_occupation' => 'required|alpha|max_len,50'));
        if ( $is_valid_second_guardian_occupation !== true ):
            echo json_encode( array( "error" => "Please select a relation" ), JSON_PRETTY_PRINT );
            exit();
        endif;

        // VALIDATION : second_guardian_position
        $is_valid_second_guardian_position = GUMP::is_valid($this->request->post, array('second_guardian_position' => 'required|alpha|max_len,50'));
        if ( $is_valid_second_guardian_position !== true ):
            echo json_encode( array( "error" => "Please select a relation" ), JSON_PRETTY_PRINT );
            exit();
        endif;

        // VALIDATION : second_guardian_income
        $is_valid_second_guardian_income = GUMP::is_valid($this->request->post, array('second_guardian_income' => 'required|integer|max_len,10'));
        if ( $is_valid_second_guardian_income !== true ):
            echo json_encode( array( "error" => "Please select a relation" ), JSON_PRETTY_PRINT );
            exit();
        endif;

        // VALIDATION : second_guardian_email
        $is_valid_second_guardian_email = GUMP::is_valid($this->request->post, array('second_guardian_email' => 'required|second_guardian_email'));
        if ( $is_valid_second_guardian_email !== true ):
            echo json_encode( array( "error" => "Please select a relation" ), JSON_PRETTY_PRINT );
            exit();
        endif;

        // VALIDATION : second_guardian_address
        $is_valid_second_guardian_address = GUMP::is_valid($this->request->post, array('second_guardian_address' => 'required|alpha_numeric|max_len,50'));
        if ( $is_valid_second_guardian_address !== true ):
            echo json_encode( array( "error" => "Please select a relation" ), JSON_PRETTY_PRINT );
            exit();
        endif;

        // VALIDATION : second_guardian_city
        $is_valid_second_guardian_city = GUMP::is_valid($this->request->post, array('second_guardian_city' => 'required|alpha|max_len,20'));
        if ( $is_valid_second_guardian_city !== true ):
            echo json_encode( array( "error" => "Please select a relation" ), JSON_PRETTY_PRINT );
            exit();
        endif;

        // VALIDATION : second_guardian_district
        $is_valid_second_guardian_district = GUMP::is_valid($this->request->post, array('second_guardian_district' => 'integer|max_len,2'));
        if ( $is_valid_second_guardian_district !== true AND $this->request->post['second_guardian_district'] != NULL ):
            echo json_encode( array( "error" => "Please select a relation" ), JSON_PRETTY_PRINT );
            exit();
        endif;

        // MODEL
        $this->load->model('parent');

        // G2 POST DATA
        $this->model_parent->role_id = $this->request->post['second_guardian_full_name'];
        $this->model_parent->role_id = $this->request->post['second_guardian_initials'];
        $this->model_parent->role_id = $this->request->post['second_guardian_surname'];
        $this->model_parent->role_id = $this->request->post['second_guardian_date_of_birth'];
        $this->model_parent->role_id = $this->request->post['second_guardian_relation'];
        $this->model_parent->role_id = $this->request->post['second_guardian_gender'];
        $this->model_parent->role_id = $this->request->post['second_guardian_nic'];
        $this->model_parent->role_id = $this->request->post['second_guardian_telephone'];
        $this->model_parent->role_id = $this->request->post['second_guardian_mobile_number'];
        $this->model_parent->role_id = $this->request->post['second_guardian_occupation'];
        $this->model_parent->role_id = $this->request->post['second_guardian_position'];
        $this->model_parent->role_id = $this->request->post['second_guardian_income'];
        $this->model_parent->role_id = $this->request->post['second_guardian_email'];
        $this->model_parent->role_id = $this->request->post['second_guardian_address'];
        $this->model_parent->role_id = $this->request->post['second_guardian_city'];
        $this->model_parent->role_id = $this->request->post['second_guardian_district'];
        
        // SUBMIT
        if ( $this->model_parent->save() ):
            echo json_encode( array( "status" => "success" ), JSON_PRETTY_PRINT );
        else:
            echo json_encode( array( "status" => "failed" ), JSON_PRETTY_PRINT );
        endif;
    }
}
?>