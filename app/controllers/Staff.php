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

        // SET JSON HEADER
        header('Content-Type: application/json');

        // VALIDATION : ADMISSION DATE
        $is_valid_admission_date = GUMP::is_valid($this->request->post, array('admission_date' => 'required|date'));
        if ( $is_valid_admission_date !== true ):
            echo json_encode( array( "error" => $is_valid_admission_date[0] ), JSON_PRETTY_PRINT );
            exit();
        endif;

        // VALIDATION : EMPLOYEE NO
        $is_valid_username = GUMP::is_valid($this->request->post, array('employee_no' => 'required|integer|max_len,6'));
        if ( $is_valid_username !== true ):
            echo json_encode( array( "error" => $is_valid_username[0] ), JSON_PRETTY_PRINT );
            exit();
        endif;

        // VALIDATION : NIC
        $is_valid_nic = GUMP::is_valid($this->request->post, array('nic_no' => "required"));
        if ( $is_valid_nic === true ):
            if ( preg_match("/^([0-9]{9}[x|X|v|V]|[0-9]{12})$/", $this->request->post['nic_no']) == false ):
                echo json_encode( array( "error" => "Wrong NIC Format" ), JSON_PRETTY_PRINT );
                exit();
            endif;
        else:
            echo json_encode( array( "error" => $is_valid_nic[0] ), JSON_PRETTY_PRINT );
            exit();
        endif;

        // VALIDATION : CATEGORY_ID
        $is_valid_category = GUMP::is_valid($this->request->post, array('category_id' => 'required|integer|max_len,2'));
        if ( $is_valid_category !== true ):
            echo json_encode( array( "error" => "Staff Category field is empty" ), JSON_PRETTY_PRINT );
            exit();
        endif;

        // VALIDATION : TYPE_ID
        $is_valid_type = GUMP::is_valid($this->request->post, array('type_id' => 'required|integer|max_len,2'));
        if ( $is_valid_type !== true ):
            echo json_encode( array( "error" => "Staff type field is empty" ), JSON_PRETTY_PRINT );
            exit();
        endif;

        // VALIDATION : CLASS_ID
        $is_valid_class = GUMP::is_valid($this->request->post, array('class_id' => 'integer|max_len,3'));
        if ( $is_valid_class !== true ):
            echo json_encode( array( "error" => $is_valid_class[0] ), JSON_PRETTY_PRINT );
            exit();
        endif;

        // VALIDATION : SUBJECT_IDS
        $is_valid_subject_ids = GUMP::is_valid($this->request->post, array('subject_ids' => 'integer|max_len,3'));
        if ( $is_valid_subject_ids !== true ):
            echo json_encode( array( "error" => $is_valid_subject_ids[0] ), JSON_PRETTY_PRINT );
            exit();
        endif;

        // VALIDATION : FN
        $is_valid_fn = GUMP::is_valid($this->request->post, array('fn' => 'required|alpha|max_len,100'));
        if ( $is_valid_fn !== true ):
            echo json_encode( array( "error" => $is_valid_fn[0] ), JSON_PRETTY_PRINT );
            exit();
        endif;

        // VALIDATION : INI
        $is_valid_ini = GUMP::is_valid($this->request->post, array('ini' => 'required|alpha|max_len,10'));
        if ( $is_valid_ini !== true ):
            echo json_encode( array( "error" => $is_valid_ini[0] ), JSON_PRETTY_PRINT );
            exit();
        endif;

        // VALIDATION : SN
        $is_valid_sn = GUMP::is_valid($this->request->post, array('sn' => 'required|alpha|max_len,50'));
        if ( $is_valid_sn !== true ):
            echo json_encode( array( "error" => $is_valid_sn[0] ), JSON_PRETTY_PRINT );
            exit();
        endif;

        // VALIDATION : DOB
        $is_valid_dob = GUMP::is_valid($this->request->post, array('dob' => 'required|date'));
        if ( $is_valid_dob !== true ):
            echo json_encode( array( "error" => $is_valid_dob[0] ), JSON_PRETTY_PRINT );
            exit();
        endif;

        // VALIDATION : REL_ID
        $is_valid_rel_id = GUMP::is_valid($this->request->post, array('rel_id' => 'integer|max_len,2'));
        if ( $is_valid_rel_id !== true ):
            echo json_encode( array( "error" => $is_valid_rel_id[0] ), JSON_PRETTY_PRINT );
            exit();
        endif;

        // VALIDATION : GEN
        $is_valid_gen = GUMP::is_valid($this->request->post, array('gen' => 'required|contains_list,(Male;Female)'));
        if ( $is_valid_gen !== true ):
            echo json_encode( array( "error" => $is_valid_gen[0] ), JSON_PRETTY_PRINT );
            exit();
        endif;

        // VALIDATION : EMAIL
        $is_valid_email = GUMP::is_valid($this->request->post, array('email' => 'required|email'));
        if ( $is_valid_email !== true ):
            echo json_encode( array( "error" => $is_valid_email[0] ), JSON_PRETTY_PRINT );
            exit();
        endif;

        // VALIDATION : LANDLINE
        $is_valid_phone_home = GUMP::is_valid($this->request->post, array('phone_home' => 'required|integer|max_len,10'));
        if ( $is_valid_phone_home !== true ):
            echo json_encode( array( "error" => $is_valid_phone_home[0] ), JSON_PRETTY_PRINT );
            exit();
        endif;

        // VALIDATION : MOBILE
        $is_valid_phone_mobile = GUMP::is_valid($this->request->post, array('phone_mobile' => 'required|integer|max_len,10'));
        if ( $is_valid_phone_mobile !== true ):
            echo json_encode( array( "error" => $is_valid_phone_mobile[0] ), JSON_PRETTY_PRINT );
            exit();
        endif;

        // VALIDATION : ADDRESS
        $is_valid_address = GUMP::is_valid($this->request->post, array('address' => 'required|alpha_numeric|max_len,50'));
        if ( $is_valid_address !== true ):
            echo json_encode( array( "error" => $is_valid_address[0] ), JSON_PRETTY_PRINT );
            exit();
        endif;

        // VALIDATION : CITY
        $is_valid_city = GUMP::is_valid($this->request->post, array('city' => 'required|alpha|max_len,20'));
        if ( $is_valid_city !== true ):
            echo json_encode( array( "error" => $is_valid_city[0] ), JSON_PRETTY_PRINT );
            exit();
        endif;

        // VALIDATION : DISTRICT
        $is_valid_dist = GUMP::is_valid($this->request->post, array('dist' => 'required|integer|max_len,2'));
        if ( $is_valid_dist !== true ):
            echo json_encode( array( "error" => $is_valid_dist[0] ), JSON_PRETTY_PRINT );
            exit();
        endif;

        //MODEL
        $this->load->model('staff');

        $this->model_staff->role_id = $this->request->post['admission_date'];
        $this->model_staff->role_id = $this->request->post['employee_no'];
        $this->model_staff->role_id = $this->request->post['nic_no'];
        $this->model_staff->role_id = $this->request->post['category_id'];
        $this->model_staff->role_id = $this->request->post['type_id'];
        $this->model_staff->role_id = $this->request->post['class_id'];
        $this->model_staff->role_id = $this->request->post['subject_ids'];
        $this->model_staff->role_id = $this->request->post['fn'];
        $this->model_staff->role_id = $this->request->post['ini'];
        $this->model_staff->role_id = $this->request->post['sn'];
        $this->model_staff->role_id = $this->request->post['dob'];
        $this->model_staff->role_id = $this->request->post['rel_id'];
        $this->model_staff->role_id = $this->request->post['gen'];
        $this->model_staff->role_id = $this->request->post['email'];
        $this->model_staff->role_id = $this->request->post['phone_home'];
        $this->model_staff->role_id = $this->request->post['phone_mobile'];
        $this->model_staff->role_id = $this->request->post['address'];
        $this->model_staff->role_id = $this->request->post['city'];
        $this->model_staff->role_id = $this->request->post['dist'];

        // SUBMIT
        if ( $this->model_staff->save() ):
            echo json_encode( array( "status" => "success" ), JSON_PRETTY_PRINT );
        else:
            echo json_encode( array( "status" => "failed" ), JSON_PRETTY_PRINT );
        endif;

    }
}
?>