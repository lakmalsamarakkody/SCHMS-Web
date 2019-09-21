<?php

class Staff extends Controller {
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
        $this->load->view('staff/index', $data);
        
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
        $this->load->view('staff/search', $data);
        
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
        $this->load->model('staff');
        $this->load->model('staff/category');
        $this->load->model('staff/type');
        $this->load->model('class');
        $this->load->model('grade');
        $this->load->model('religion');
        $this->load->model('district');


        // STAFF CATEGORY
        foreach( $this->model_staff_category->select('id', 'name')->get() as $key => $element ):
            $data['staff_category'][$key]['id'] = $element->id;
            $data['staff_category'][$key]['name'] = $element->name;
        endforeach;

        // STAFF TYPE
        foreach( $this->model_staff_type->select('id', 'name', 'category_id')->get() as $key => $element ):
            $data['staff_type'][$key]['id'] = $element->id;
            $data['staff_type'][$key]['name'] = $element->name;
            $data['staff_type'][$key]['category']['id'] = $element->category_id;
        endforeach;

        // CLASS IN CHARGE
        foreach( $this->model_class->select('id', 'grade_id', 'staff_id', 'name')->get() as $key => $element ):
            $data['staff_class'][$key]['id'] = $element->id;
            $data['staff_class'][$key]['grade']['id'] = $element->grade_id;
            $data['staff_class'][$key]['staff']['id'] = $element->staff_id;
            $data['staff_class'][$key]['name'] = $element->name;

            $data['staff_class'][$key]['grade']['name'] = $this->model_grade->select('name')->where('id', '=', $element->grade_id)->first()->name;
        endforeach;

        //RELIGION
        foreach( $this->model_religion->select('id', 'name')->get() as $key => $element ):
            $data['staff_religion'][$key]['id'] = $element->id;
            $data['staff_religion'][$key]['name'] = $element->name;
        endforeach;

        //DISTRICT
        foreach( $this->model_district->select('id', 'province_id', 'name')->get() as $key => $element ):
            $data['staff_district'][$key]['id'] = $element->id;
            $data['staff_district'][$key]['province']['id'] = $element->province_id;
            $data['staff_district'][$key]['name'] = $element->name;
        endforeach;

		// RENDER VIEW
        $this->load->view('staff/add', $data);
        
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
         * the front end with the following payload
         *   - admission_date
         *   - employee_no
         *   - nic_no
         *   - category
         *   - type
         *   - class
         *   - subject_ids
         *   - fn
         *   - ini
         *   - sn
         *   - dob
         *   - rel_id
         *   - gen
         *   - email
         *   - landno
         *   - mobno
         *   - address
         *   - city
         *   - district
         * 
         * We need to validate the data and then perform
         * the following tasks.
         *    - validate
         *    - CRUD
         *    - response ( JSON )
         */

        // MODEL
        $this->load->model('staff');

        // SET JSON HEADER
        header('Content-Type: application/json');

        // VALIDATION : admission_date
        $is_valid_admission_date = GUMP::is_valid($this->request->post, array('admission_date' => 'required|date'));
        if ( $is_valid_admission_date !== true ):
            echo json_encode( array( "error" => "Please insert admission date" ), JSON_PRETTY_PRINT );
            exit();
        endif;

        // VALIDATION : employee_number
        $is_valid_employee_number = GUMP::is_valid($this->request->post, array('employee_number' => 'required|numeric|max_len,6'));
        if ( $is_valid_employee_number !== true ):
            echo json_encode( array( "error" => "Please insert emplyee number" ), JSON_PRETTY_PRINT );
            exit();
        endif;

        // employee_number IS ENTERED : CHECK FOR DUPLICATE
        if ( $this->model_staff->select('id')->where('employee_number', '=', $this->request->post['employee_number'])->first() != NULL ):
            echo json_encode( array( "error" => "Employee ID is already present" ), JSON_PRETTY_PRINT );
            exit();
        endif;

        // VALIDATION : nic_number
        $is_valid_nic_number = GUMP::is_valid($this->request->post, array('nic_number' => "required"));
        if ( $is_valid_nic_number === true ):
            if ( preg_match("/^([0-9]{9}[x|X|v|V]|[0-9]{12})$/", $this->request->post['nic_number']) == false ):
                echo json_encode( array( "error" => "Please insert a valid NIC number" ), JSON_PRETTY_PRINT );
                exit();
            endif;
        else:
            echo json_encode( array( "error" => "Please insert a NIC number" ), JSON_PRETTY_PRINT );
            exit();
        endif;

        // nic_number IS ENTERED : CHECK FOR DUPLICATE
        if ( $this->model_staff->select('id')->where('nic', '=', $this->request->post['nic_number'])->first() != NULL ):
            echo json_encode( array( "error" => "Employee NIC is already present" ), JSON_PRETTY_PRINT );
            exit();
        endif;

        // VALIDATION : category
        $is_valid_category = GUMP::is_valid($this->request->post, array('category' => 'required|numeric|max_len,2'));
        if ( $is_valid_category !== true ):
            echo json_encode( array( "error" => "Please select a valid staff category" ), JSON_PRETTY_PRINT );
            exit();
        endif;

        // VALIDATION : type
        $is_valid_type = GUMP::is_valid($this->request->post, array('type' => 'required|numeric|max_len,2'));
        if ( $is_valid_type !== true ):
            echo json_encode( array( "error" => "Please select a valid staff type" ), JSON_PRETTY_PRINT );
            exit();
        endif;

        // // VALIDATION : class
        // $is_valid_class = GUMP::is_valid($this->request->post, array('class' => 'numeric|max_len,3'));
        // if ( $is_valid_class !== true ):
        //     echo json_encode( array( "error" => $is_valid_class[0] ), JSON_PRETTY_PRINT );
        //     exit();
        // endif;

        // // VALIDATION : subjects
        // $is_valid_subjects = GUMP::is_valid($this->request->post, array('subjects' => 'numeric|max_len,3'));
        // if ( $is_valid_subjects !== true ):
        //     echo json_encode( array( "error" => $is_valid_subjects[0] ), JSON_PRETTY_PRINT );
        //     exit();
        // endif;

        // VALIDATION : full_name
        $is_valid_full_name = GUMP::is_valid($this->request->post, array('full_name' => 'required|valid_name|max_len,100'));
        if ( $is_valid_full_name !== true ):
            echo json_encode( array( "error" => "Please insert full name" ), JSON_PRETTY_PRINT );
            exit();
        endif;

        // VALIDATION : initials
        $is_valid_initials = GUMP::is_valid($this->request->post, array('initials' => 'required|alpha_space|max_len,10'));
        if ( $is_valid_initials !== true ):
            echo json_encode( array( "error" => "Please insert initials" ), JSON_PRETTY_PRINT );
            exit();
        endif;

        // VALIDATION : surname
        $is_valid_surname = GUMP::is_valid($this->request->post, array('surname' => 'required|valid_name|max_len,50'));
        if ( $is_valid_surname !== true ):
            echo json_encode( array( "error" => "Please insert surname" ), JSON_PRETTY_PRINT );
            exit();
        endif;

        // VALIDATION : date_of_birth
        $is_valid_date_of_birth = GUMP::is_valid($this->request->post, array('date_of_birth' => 'required|date'));
        if ( $is_valid_date_of_birth !== true ):
            echo json_encode( array( "error" => "Please insert date of birth" ), JSON_PRETTY_PRINT );
            exit();
        endif;

        // VALIDATION : religion
        $is_valid_religion = GUMP::is_valid($this->request->post, array('religion' => 'numeric|max_len,2'));
        if ( $is_valid_religion !== true AND $this->request->post['religion'] != "null" ):
            echo json_encode( array( "error" => "Please select a valid religion name" ), JSON_PRETTY_PRINT );
            exit();
        endif;

        // VALIDATION : gender
        $is_valid_gender = GUMP::is_valid($this->request->post, array('gender' => 'required|contains_list,Male;Female'));
        if ( $is_valid_gender !== true ):
            echo json_encode( array( "error" => "Please select a valid gender name" ), JSON_PRETTY_PRINT );
            exit();
        endif;

        // VALIDATION : email
        $is_valid_email = GUMP::is_valid($this->request->post, array('email' => 'valid_email'));
        if ( $is_valid_email !== true ):
            echo json_encode( array( "error" => "Please enter a valid email" ), JSON_PRETTY_PRINT );
            exit();
        endif;

            // email IS ENTERED : CHECK FOR DUPLICATE
            if ( $this->request->post['email'] !== ""):
                if ( $this->model_staff->select('id')->where('email', '=', $this->request->post['email'])->first() != NULL ):
                    echo json_encode( array( "error" => "This Employee Email is already present" ), JSON_PRETTY_PRINT );
                    exit();
                endif;
            endif;

        // VALIDATION : telephone
        $is_valid_telephone = GUMP::is_valid($this->request->post, array('telephone' => 'numeric|max_len,10'));
        if ( $is_valid_telephone !== true ):
            echo json_encode( array( "error" => "Please insert a valid 10 digit telephone number" ), JSON_PRETTY_PRINT );
            exit();
        endif;

        // VALIDATION : mobile_number
        $is_valid_mobile_number = GUMP::is_valid($this->request->post, array('mobile_number' => 'numeric|max_len,10'));
        if ( $is_valid_mobile_number !== true ):
            echo json_encode( array( "error" => "Please insert a valid 10 digit mobile number" ), JSON_PRETTY_PRINT );
            exit();
        endif;

        // VALIDATION : address
        $is_valid_address = GUMP::is_valid($this->request->post, array('address' => 'required|street_address|max_len,50'));
        if ( $is_valid_address !== true ):
            echo json_encode( array( "error" => "Please insert a valid address" ), JSON_PRETTY_PRINT );
            exit();
        endif;

        // VALIDATION : city
        $is_valid_city = GUMP::is_valid($this->request->post, array('city' => 'required|valid_name|max_len,20'));
        if ( $is_valid_city !== true ):
            echo json_encode( array( "error" => "Please insert a valid city" ), JSON_PRETTY_PRINT );
            exit();
        endif;

        // VALIDATION : DISTRICT
        $is_valid_district = GUMP::is_valid($this->request->post, array('district' => 'numeric|max_len,2'));
        if ( $is_valid_district !== true AND $this->request->post['district'] != "null" ):
            echo json_encode( array( "error" => "Please select a district" ), JSON_PRETTY_PRINT );
            exit();
        endif;

        //MODEL
        $this->load->model('staff');

        $this->model_staff->admission_date = $this->request->post['admission_date'];
        $this->model_staff->employee_number = $this->request->post['employee_number'];
        $this->model_staff->nic = $this->request->post['nic_number'];
        $this->model_staff->category_id = $this->request->post['category'];
        $this->model_staff->type_id = $this->request->post['type'];
        // $this->model_staff->role_id = $this->request->post['class'];
        // $this->model_staff->role_id = $this->request->post['subjects'];
        $this->model_staff->full_name = $this->request->post['full_name'];
        $this->model_staff->initials = $this->request->post['initials'];
        $this->model_staff->surname = $this->request->post['surname'];
        $this->model_staff->dob = $this->request->post['date_of_birth'];
        $this->model_staff->religion_id = ( $this->request->post['religion'] == "null" )  ? null : $this->request->post['religion'];
        $this->model_staff->gender = $this->request->post['gender'];
        $this->model_staff->email = $this->request->post['email'];
        $this->model_staff->phone_home = $this->request->post['telephone'];
        $this->model_staff->phone_mobile = $this->request->post['mobile_number'];
        $this->model_staff->address = $this->request->post['address'];
        $this->model_staff->city = $this->request->post['city'];
        $this->model_staff->district_id = ( $this->request->post['district'] == "null" )  ? null : $this->request->post['district'];

        // SUBMIT
        if ( $this->model_staff->save() ):
            echo json_encode( array( "status" => "success" ), JSON_PRETTY_PRINT );
        else:
            echo json_encode( array( "status" => "failed" ), JSON_PRETTY_PRINT );
        endif;

    }
}
?>