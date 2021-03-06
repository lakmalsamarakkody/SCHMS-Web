<?php

class Parents extends Controller {
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
        $this->load->model('parent');
        $this->load->model('user');

        // CHECK PERMISSION : index
        if ( $this->model_user->find($_SESSION['user']['id'])->hasPermission('parents-index-view') ):
            $data['permission']['parents']['index']['view'] = true;
        else:
            $data['permission']['parents']['index']['view'] = false;
        endif;

        // PARENT TOTAL CARD
        $data['parent']['total']['all'] = $this->model_parent->select('id')->count();
        $data['parent']['total']['male'] = $this->model_parent->select('id')->where('gender', '=', 'male')->count();
        $data['parent']['total']['female'] = $this->model_parent->select('id')->where('gender', '=', 'female')->count();

        // PARENT ABOVE AVERAGE INCOME CARD
        $data['parent']['above']['income']['all'] = $this->model_parent->select('id')->where('income', '>=', '25000')->count();
        $data['parent']['above']['income']['male'] = $this->model_parent->select('id')->where('gender', '=', 'male')->where('income', '>=', '25000')->count();
        $data['parent']['above']['income']['female'] = $this->model_parent->select('id')->where('gender', '=', 'female')->where('income', '>=', '25000')->count();

        // PARENT BELOW AVERAGE INCOME CARD
        $data['parent']['below']['income']['all'] = $this->model_parent->select('id')->where('income', '<', '25000')->count();
        $data['parent']['below']['income']['male'] = $this->model_parent->select('id')->where('gender', '=', 'male')->where('income', '<', '25000')->count();
        $data['parent']['below']['income']['female'] = $this->model_parent->select('id')->where('gender', '=', 'female')->where('income', '<', '25000')->count();

        // PARENT MOST OCCUPATION CARD
        $data['parent']['most']['occupation']['all'] = $this->model_parent->select('occupation')->distinct()->get('occupation');
        $data['parent']['most']['occupation']['male'] = $this->model_parent->select('occupation')->distinct()->get('occupation')->where('gender', '=', 'male')->count();
        $data['parent']['most']['occupation']['female'] = $this->model_parent->select('occupation')->distinct()->get('occupation')->where('gender', '=', 'female')->count();

        // BMI OVERALL PIE CHART
        $data['overall_below_income'] = $this->model_parent->select('id')->where('parent.income', '<', '25000')->count();
        $data['overall_average_income'] = $this->model_parent->select('id')->where('parent.income', '>=', '25000')->where('parent.income', '<=', '45000')->count();
        $data['overall_above_income'] = $this->model_parent->select('id')->where('parent.income', '>', '45000')->count();
        
		// RENDER VIEW
        $this->load->view('parents/index', $data);
        
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

        // MODEL
        $this->load->model('student');
        $this->load->model('student/parent');
        $this->load->model('student/relation');
        $this->load->model('parent');
        $this->load->model('class');
        $this->load->model('grade');
        $this->load->model('staff');
        $this->load->model('sport');
        $this->load->model('religion');
        $this->load->model('user');

        // CHECK PERMISSION : search
        if ( $this->model_user->find($_SESSION['user']['id'])->hasPermission('parents-search-view') ):
            $data['permission']['parents']['search']['view'] = true;
        else:
            $data['permission']['parents']['search']['view'] = false;
        endif;

        // CHECK PERMISSION : parent-profile
        if ( $this->model_user->find($_SESSION['user']['id'])->hasPermission('parents-profile-view') ):
            $data['permission']['parent']['profile']['view'] = true;
        else:
            $data['permission']['parent']['profile']['view'] = false;
        endif;

        // RELATIONSHIP
		foreach( $this->model_student_relation->select('id', 'name')->orderBy('name')->get() as $key => $element ):
			$data['student_relations'][$key]['id'] = $element->id;
			$data['student_relations'][$key]['name']= $element->name;
        endforeach;

        // CITIES
        foreach( $this->model_parent->select('city')->distinct('city')->orderBy('city')->get() as $key => $element ):
            if ( $element->city != NULL):
            $data['cities'][$key]['name'] = $element->city;
            endif;
        endforeach;

        // OCCUPATIONS
        foreach( $this->model_parent->select('occupation')->distinct('occupation')->orderBy('occupation')->get() as $key => $element ):
			$data['occupations'][$key]['name'] = $element->occupation;
        endforeach;

        // POSITIONS
        foreach( $this->model_parent->select('position')->distinct('position')->orderBy('position')->get() as $key => $element ):
            if ( $element->position != NULL):
                $data['positions'][$key]['name'] = $element->position;
            endif;
        endforeach;

        // CLASS
		foreach( $this->model_class->select('id', 'grade_id', 'staff_id','name')->orderBy('grade_id')->orderBy('name')->get() as $key => $element ):
			$data['classes'][$key]['id'] = $element->id;
			$data['classes'][$key]['grade']['id'] = $element->grade_id;
			$data['classes'][$key]['name'] = $element->name;

			// GET GRADE DETAILS
			$data['classes'][$key]['grade']['name'] = $this->model_grade->select('name')->where('id', '=', $element->grade_id)->first()->name;

			// GET STAFF DETAILS
			if ( $element->staff_id !== NULL):
				$data['classes'][$key]['staff'] = $this->model_staff->select('initials', 'surname')->where('id', '=', $element->staff_id)->first()->toArray();
			else:
				$data['classes'][$key]['staff'] = "";
			endif;				
			
		endforeach;

		// GRADE
		foreach( $this->model_grade->select('id', 'name')->orderBy('id')->get() as $key => $element ):
			$data['grades'][$key]['id'] = $element->id;
			$data['grades'][$key]['name']= $element->name;
        endforeach;
        
        // CHECK SUBMIT
        if ( isset($this->request->post['isSubmited']) ):

            $data['form']['field']['gnic'] = ( isset($this->request->post['gnic']) AND !empty($this->request->post['gnic']) ) ? $this->request->post['gnic'] : "";
            $data['form']['field']['gname'] = ( isset($this->request->post['gname']) AND !empty($this->request->post['gname']) ) ? $this->request->post['gname'] : "";
            $data['form']['field']['grelation'] = ( isset($this->request->post['grelation']) AND !empty($this->request->post['grelation']) ) ? $this->request->post['grelation'] : "";
            $data['form']['field']['ggen'] = ( isset($this->request->post['ggen']) AND !empty($this->request->post['ggen']) ) ? $this->request->post['ggen'] : "";
            $data['form']['field']['gcity'] = ( isset($this->request->post['gcity']) AND !empty($this->request->post['gcity']) ) ? $this->request->post['gcity'] : "";
            $data['form']['field']['goccu'] = ( isset($this->request->post['goccu']) AND !empty($this->request->post['goccu']) ) ? $this->request->post['goccu'] : "";
            $data['form']['field']['gpos'] = ( isset($this->request->post['gpos']) AND !empty($this->request->post['gpos']) ) ? $this->request->post['gpos'] : "";
            $data['form']['field']['gincome'] = ( isset($this->request->post['gincome']) AND !empty($this->request->post['gincome']) ) ? $this->request->post['gincome'] : "";
            $data['form']['field']['saddno'] = ( isset($this->request->post['saddno']) AND !empty($this->request->post['saddno']) ) ? $this->request->post['saddno'] : "";
            $data['form']['field']['sname'] = ( isset($this->request->post['sname']) AND !empty($this->request->post['sname']) ) ? $this->request->post['sname'] : "";
            $data['form']['field']['sclass'] = ( isset($this->request->post['sclass']) AND !empty($this->request->post['sclass']) ) ? $this->request->post['sclass'] : "";
            $data['form']['field']['sgrade'] = ( isset($this->request->post['sgrade']) AND !empty($this->request->post['sgrade']) ) ? $this->request->post['sgrade'] : "";


            /**
             * GET RELEVENT PARENT_ID
             */

            // Eloquent OBJECT
            $parents = $this->model_parent->select('id');

            // FILTER ( NIC NO )
            if ( isset($this->request->post['gnic']) AND !empty($this->request->post['gnic']) ):
                $parents->where(function($query) {
                    $query->where('nic', '=', $this->request->post['gnic']);
                });
            endif;

            // FILTER ( NAME )
            if ( isset($this->request->post['gname']) AND !empty($this->request->post['gname']) ):
                $parents->where(function($query) {
                    $query->where('full_name', 'LIKE', '%'.$this->request->post['gname'].'%');
                });
            endif;

            // FILTER ( GENDER )
            if ( isset($this->request->post['ggen']) AND !empty($this->request->post['ggen']) ):
                $parents->where(function($query) {
                    $query->where('gender', '=', $this->request->post['ggen']);
                });
            endif;

            // FILTER ( CITY )
            if ( isset($this->request->post['gcity']) AND !empty($this->request->post['gcity']) ):
                $parents->where(function($query) {
                    $query->where('city', '=', $this->request->post['gcity']);
                });
            endif;

            // FILTER ( OCCUPATION )
            if ( isset($this->request->post['goccu']) AND !empty($this->request->post['goccu']) ):
                $parents->where(function($query) {
                    $query->where('occupation', '=', $this->request->post['goccu']);
                });
            endif;

            // FILTER ( INCOME )
            if ( isset($this->request->post['gincome']) AND !empty($this->request->post['gincome']) ):
                $parents->where(function($query) {
                    $query->where('income', '>=', $this->request->post['gincome']);
                });
            endif;

            $parent_ids = array();
            foreach( $parents->get() as $el ):
                array_push($parent_ids, $el->id);
            endforeach;

            /**
             * GET RELEVENT STUDENT_ID
             */

            // Eloquent OBJECT
            $students = $this->model_student->select('id');

            // FILTER ( ADMISSION NO )
            if ( isset($this->request->post['saddno']) AND !empty($this->request->post['saddno']) ):
                $students->where(function($query) {
                    $query->where('admission_no', '=', $this->request->post['saddno']);
                });
            endif;

            // FILTER ( NAME )
            if ( isset($this->request->post['sname']) AND !empty($this->request->post['sname']) ):
                $students->where(function($query) {
                    $query->where('full_name', 'LIKE', '%'.$this->request->post['sname'].'%');
                });
            endif;

            // FILTER ( CLASS )
            if ( isset($this->request->post['sclass']) AND !empty($this->request->post['sclass']) ):
                $students->where(function($query) {
                    $query->where('class_id', '=', $this->request->post['sclass']);
                });
            endif;

            // FILTER ( GRADE )
            if ( isset($this->request->post['sgrade']) AND !empty($this->request->post['sgrade']) ):
                $class = $this->model_class->select('id')->where('grade_id', '=', $this->request->post['sgrade'])->get();
                if ( $class != NULL ):
                    $classes = array();
                    foreach ( $class as $key => $element ):
                        array_push($classes, $element->id);
                    endforeach;
                    $students->where(function($query) use ($classes) {
                        $query->whereIn('class_id', $classes);
                    });
                endif; 
            endif;

            $student_ids = array();
            foreach( $students->get() as $el ):
                array_push($student_ids, $el->id);
            endforeach;

            // RELATION
            $parent_relation = $this->model_student_parent->select('id', 'parent_id');

            // FILTER ( RELATION ID )
            if ( isset($this->request->post['grelation']) AND !empty($this->request->post['grelation']) ):
                $parent_relation->where(function($query) {
                    $query->where('relation_id', '=', $this->request->post['grelation']);
                });
            endif;

            // CROSS MATCH ( is non empty array )
            $parent_relation->whereIn('student_id', $student_ids);
            $parent_relation->whereIn('parent_id', $parent_ids);

            foreach( $parent_relation->groupBy('parent_id')->get() as $key => $el ):

                /**
                 * Query details of the parents using the parent table by
                 * $el->parent_id and append them into the twig buffer
                 */
                $parent_data = $this->model_parent->find($el->parent_id);

                // TWIG
                $data['parents'][$key]['id'] = $parent_data->id;
                $data['parents'][$key]['nic'] = $parent_data->nic;
                $data['parents'][$key]['name'] = $parent_data->initials." ".$parent_data->surname;
                $data['parents'][$key]['gender'] = $parent_data->gender;
                $data['parents'][$key]['dob'] = $parent_data->dob;
                $data['parents'][$key]['occupation'] = $parent_data->occupation;
                $data['parents'][$key]['mobile'] = $parent_data->phone_mobile;
                $data['parents'][$key]['city'] = $parent_data->city;

            endforeach;

        endif;
        
		// RENDER VIEW
        $this->load->view('parents/search', $data);
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

        //  MODEL
        $this->load->model('student');
        $this->load->model('student/relation');
        $this->load->model('student/class');
        $this->load->model('student/parent');
        $this->load->model('class');
        $this->load->model('grade');       
        $this->load->model('district');
        $this->load->model('province');
        $this->load->model('user');

        // CHECK PERMISSION : add
        if ( $this->model_user->find($_SESSION['user']['id'])->hasPermission('parents-add-view') ):
            $data['permission']['parents']['add']['view'] = true;
        else:
            $data['permission']['parents']['add']['view'] = false;
        endif;


        //STUDENT CLASS
        foreach( $this->model_class->select('id', 'grade_id', 'staff_id', 'name')->get() as $key => $element ):
            $data['student_class'][$key]['id'] = $element->id;
            $data['student_class'][$key]['grade']['id'] = $element->grade_id;
            $data['student_class'][$key]['staff']['id'] = $element->staff_id;
            $data['student_class'][$key]['name'] = $element->name;

            $data['student_class'][$key]['grade']['name'] = $this->model_grade->select('name')->where('id', '=', $element->grade_id)->first()->name;
        endforeach;

        //RELATIONSHIP
        foreach( $this->model_student_relation->select('id', 'name')->orderBy('name')->get() as $key => $element ):
            $data['relation_type'][$key]['id'] = $element->id;
            $data['relation_type'][$key]['name'] = $element->name;
        endforeach;

        //DISTRICT
        foreach( $this->model_district->select('id', 'province_id', 'name')->orderBy('name')->get() as $key => $element ):
            $data['districts'][$key]['id'] = $element->id;
            $data['districts'][$key]['province']['id'] = $element->province_id;
            $data['districts'][$key]['name'] = $element->name;
        endforeach;

        // CHECK SUBMIT ( STUDENT SEARCH )
        if ( isset($this->request->post['isSubmited']) ):

            $student = $this->model_student->select('id', 'admission_no', 'admission_date', 'full_name', 'class_id', 'gender', 'dob', 'address', 'city');

            // FILTER ( ADMISSION NO )
            if ( isset($this->request->post['addno']) AND !empty($this->request->post['addno']) ):
                $student->where(function($query) {
                    $query->where('admission_no', '=', $this->request->post['addno']);
                });
                $data['search']['query']['addno'] = $this->request->post['addno'];
            endif;

            // FILTER ( ADMISSION DATE )
            if ( isset($this->request->post['admission_date']) AND !empty($this->request->post['admission_date']) ):
                $student->where(function($query) {
                    $query->where('admission_date', '=', $this->request->post['admission_date']);
                });
                $data['search']['query']['admission_date'] = $this->request->post['admission_date'];
            endif;

            // FILTER ( NAME )
            if ( isset($this->request->post['name']) AND !empty($this->request->post['name']) ):
                $student->where(function($query) {
                    $query->where('full_name', 'LIKE', '%'.$this->request->post['name'].'%');
                });
                $data['search']['query']['name'] = $this->request->post['name'];
            endif;

            // FILTER ( CLASS ID )
            if ( isset($this->request->post['class']) AND !empty($this->request->post['class']) AND $this->request->post['class'] != '- Select Class -' ):
                $student->where(function($query) {
                    $query->where('class_id', '=', $this->request->post['class']);
                });
                $data['search']['query']['class'] = $this->request->post['class'];
            endif;

            // APPEND DATA TO ARRAY
            foreach( $student->get() as $key => $value ):
                $data['search']['students'][$key]['id'] = $value->id;
                $data['search']['students'][$key]['admission_no'] = $value->admission_no;
                $data['search']['students'][$key]['admission_date'] = $value->admission_date;
                $data['search']['students'][$key]['name'] = $value->full_name;

                // GET CLASS NAME
                $grade_id = $this->model_class->select('grade_id')->where('id', '=', $value->class_id)->first();
                $grade_name = $this->model_grade->select('name')->where('id', '=', $grade_id->grade_id)->first();
                $class_name = $this->model_class->select('name')->where('id', '=', $value->class_id)->first();

                $data['search']['students'][$key]['class'] = $grade_name->name." - ".$class_name->name;

                // GET INDEX
                $data['search']['students'][$key]['index'] = $this->model_student_class->select('index_no')->where('student_id', '=', $value->id)->where('class_id', '=', $value->class_id)->first()->index_no;


                $data['search']['students'][$key]['gender'] = $value->gender;
                $data['search']['students'][$key]['dob'] = $value->dob;
                $data['search']['students'][$key]['address'] = $value->address;
                $data['search']['students'][$key]['city'] = $value->city;
                
                // CHECK FOR 2 PARENTS
                $is_available = $this->model_student_parent->select('id')->where('student_id', '=', $value->id)->count();

                if ($is_available >= 2):
                    $data['search']['students'][$key]['disabled'] = true;
                else:
                    $data['search']['students'][$key]['disabled'] = false;
                endif;

            endforeach;

        endif;

		// RENDER VIEW
        $this->load->view('parents/add', $data);        
    }

    public function ajax_retrive_province_by_district($id) {

        //CHECK LOGIN STATUS
		if( !isset($_SESSION['user']) OR $_SESSION['user']['is_login'] != true ):
			header( 'Location:' . $this->config->get('base_url') . '/logout' );
			exit();
		endif;

        // SET JSON HEADER
        header('Content-Type: application/json');

        // MODEL
        $this->load->model('district');
        $this->load->model('province');

        $province_id = $this->model_district->select('province_id')->where('id', '=', $id)->first()->province_id;

        echo json_encode(array( "status" => "success", "data" => $this->model_province->select('id', 'name')->where('id', '=', $province_id)->first() ));

    }

    public function ajax_addparent() {

        //CHECK LOGIN STATUS
		if( !isset($_SESSION['user']) OR $_SESSION['user']['is_login'] != true ):
			header( 'Location:' . $this->config->get('base_url') . '/logout' );
			exit();
		endif;
        

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

        // MODEL
        $this->load->model('parent');
        $this->load->model('student/parent');
        $this->load->model('user');


        // SET JSON HEADER
        header('Content-Type: application/json');

        // PERMISSION
        if ( !$this->model_user->find($_SESSION['user']['id'])->hasPermission('parents-add-view') ):
            echo json_encode( array( "error" => "Permission denied" ), JSON_PRETTY_PRINT );
            exit();
        endif;

        // SECOND GUARDIAN VALIDATION
        // VALIDATION : second_guardian_full_name
        $is_valid_second_guardian_full_name = GUMP::is_valid($this->request->post, array('second_guardian_full_name' => 'required|valid_name|max_len,100'));
        if ( $is_valid_second_guardian_full_name !== true ):
            echo json_encode( array( "error" => "Please insert full name" ), JSON_PRETTY_PRINT );
            exit();
        endif;

        // VALIDATION : second_guardian_initials
        $is_valid_second_guardian_initials = GUMP::is_valid($this->request->post, array('second_guardian_initials' => 'required|alpha_space|max_len,20'));
        if ( $is_valid_second_guardian_initials !== true ):
            echo json_encode( array( "error" => "Please insert initials" ), JSON_PRETTY_PRINT );
            exit();
        endif;

        // VALIDATION : second_guardian_surname
        $is_valid_second_guardian_surname = GUMP::is_valid($this->request->post, array('second_guardian_surname' => 'required|valid_name|max_len,20'));
        if ( $is_valid_second_guardian_surname !== true ):
            echo json_encode( array( "error" => "Please insert surname" ), JSON_PRETTY_PRINT );
            exit();
        endif;

        // VALIDATION : second_guardian_date_of_birth
        $is_valid_second_guardian_date_of_birth = GUMP::is_valid($this->request->post, array('second_guardian_date_of_birth' => 'required|date'));
        if ( $is_valid_second_guardian_date_of_birth !== true ):
            echo json_encode( array( "error" => "Please insert date of birth" ), JSON_PRETTY_PRINT );
            exit();
        endif;

        // VALIDATION : second_guardian_relation
        $is_valid_second_guardian_relation = GUMP::is_valid($this->request->post, array('second_guardian_relation' => 'required|numeric|max_len,2'));
        if ( $is_valid_second_guardian_relation !== true ):
            echo json_encode( array( "error" => "Please select a relation type" ), JSON_PRETTY_PRINT );
            exit();
        endif;

            // CHECK : RELATION TYPE EXISTS
            $is_duplicate_student_parent = $this->model_student_parent->select('id')->where('relation_id', '=' , $this->request->post['second_guardian_relation'])->where('student_id', '=' , $this->request->post['student_id'])->first();
            if ( $is_duplicate_student_parent != NULL ):
                echo json_encode( array( "error" => "This relation type exists" ), JSON_PRETTY_PRINT );
                exit();
            endif;

        // VALIDATION : second_guardian_gender
        $is_valid_second_guardian_gender = GUMP::is_valid($this->request->post, array('second_guardian_gender' => 'required|contains_list,Male;Female'));
        if ( $is_valid_second_guardian_gender !== true ):
            echo json_encode( array( "error" => "Please select a gender" ), JSON_PRETTY_PRINT );
            exit();
        endif;

        // VALIDATION : second_guardian_nic
        $is_valid_second_guardian_nic = GUMP::is_valid($this->request->post, array('second_guardian_nic' => "required"));
        if ( $is_valid_second_guardian_nic === true ):
            if ( preg_match("/^([0-9]{9}[x|X|v|V]|[0-9]{12})$/", $this->request->post['second_guardian_nic']) == false ):
                echo json_encode( array( "error" => "Please enter valid NIC number" ), JSON_PRETTY_PRINT );
                exit();
            endif;
        else:
            echo json_encode( array( "error" => "Please enter a NIC number" ), JSON_PRETTY_PRINT );
            exit();
        endif;

        // VALIDATION : second_guardian_telephone
        $is_valid_second_guardian_telephone = GUMP::is_valid($this->request->post, array('second_guardian_telephone' => 'required|numeric|max_len,10'));
        if ( $is_valid_second_guardian_telephone !== true AND $this->request->post['second_guardian_telephone'] !== "" ):
            echo json_encode( array( "error" => "Please insert valid 10 digit telephone number" ), JSON_PRETTY_PRINT );
            exit();
        endif;

        // VALIDATION : second_guardian_mobile_number
        $is_valid_second_guardian_mobile_number = GUMP::is_valid($this->request->post, array('second_guardian_mobile_number' => 'required|numeric|max_len,10'));
        if ( $is_valid_second_guardian_mobile_number !== true AND $this->request->post['second_guardian_mobile_number'] !== "" ):
            echo json_encode( array( "error" => "Please insert valid 10 digit mobile number" ), JSON_PRETTY_PRINT );
            exit();
        endif;

        // VALIDATION : second_guardian_occupation
        $is_valid_second_guardian_occupation = GUMP::is_valid($this->request->post, array('second_guardian_occupation' => 'required|alpha_space|max_len,50'));
        if ( $is_valid_second_guardian_occupation !== true ):
            echo json_encode( array( "error" => "Please insert a occupation" ), JSON_PRETTY_PRINT );
            exit();
        endif;

        // VALIDATION : second_guardian_position
        $is_valid_second_guardian_position = GUMP::is_valid($this->request->post, array('second_guardian_position' => 'alpha_space|max_len,50'));
        if ( $is_valid_second_guardian_position !== true ):
            echo json_encode( array( "error" => "Please insert a position" ), JSON_PRETTY_PRINT );
            exit();
        endif;

        // VALIDATION : second_guardian_income
        $is_valid_second_guardian_income = GUMP::is_valid($this->request->post, array('second_guardian_income' => 'numeric|max_len,10'));
        if ( $is_valid_second_guardian_income !== true ):
            echo json_encode( array( "error" => "Please insert a valid monthly income" ), JSON_PRETTY_PRINT );
            exit();
        endif;

        // VALIDATION : second_guardian_email
        $is_valid_second_guardian_email = GUMP::is_valid($this->request->post, array('second_guardian_email' => 'valid_email'));
        if ( $is_valid_second_guardian_email !== true ):
            echo json_encode( array( "error" => "Please insert a valid email" ), JSON_PRETTY_PRINT );
            exit();
        endif;

        // VALIDATION : second_guardian_address
        $is_valid_second_guardian_address = GUMP::is_valid($this->request->post, array('second_guardian_address' => 'required|street_address|max_len,50'));
        if ( $is_valid_second_guardian_address !== true ):
            echo json_encode( array( "error" => "Please insert a valid address" ), JSON_PRETTY_PRINT );
            exit();
        endif;

        // VALIDATION : second_guardian_city
        $is_valid_second_guardian_city = GUMP::is_valid($this->request->post, array('second_guardian_city' => 'required|alpha|max_len,20'));
        if ( $is_valid_second_guardian_city !== true ):
            echo json_encode( array( "error" => "Please insert a valid city" ), JSON_PRETTY_PRINT );
            exit();
        endif;

        // VALIDATION : second_guardian_district
        $is_valid_second_guardian_district = GUMP::is_valid($this->request->post, array('second_guardian_district' => 'numeric|max_len,2'));
        if ( $is_valid_second_guardian_district !== true AND $this->request->post['second_guardian_district'] != "null" ):
            echo json_encode( array( "error" => "Please select a valid district" ), JSON_PRETTY_PRINT );
            exit();
        endif;

        // MODEL
        $this->load->model('parent');
        $this->load->model('student/parent');

        $parent = $this->model_parent->select('id')->where('nic', '=', $this->request->post['second_guardian_nic'])->first();
            
        // SUBMIT
        if ( $parent !== null ):

            // INITIATE : STUDENT HAS PARENT RECORD
            $this->model_student_parent->student_id = $this->request->post['student_id'];
            $this->model_student_parent->parent_id = $parent->id;
            $this->model_student_parent->relation_id = $this->request->post['second_guardian_relation'];

            // CHECK : STUDENT HAS PARENT QUERY
            if ( $this->model_student_parent->save() ):
                echo json_encode( array( "status" => "success" ), JSON_PRETTY_PRINT );
            else:
                echo json_encode( array( "status" => "failed" ), JSON_PRETTY_PRINT );
            endif;

        else:
            // G2 POST DATA
            $this->model_parent->full_name = $this->request->post['second_guardian_full_name'];
            $this->model_parent->initials = $this->request->post['second_guardian_initials'];
            $this->model_parent->surname = $this->request->post['second_guardian_surname'];
            $this->model_parent->dob = $this->request->post['second_guardian_date_of_birth'];
            $this->model_parent->gender = $this->request->post['second_guardian_gender'];
            $this->model_parent->nic = $this->request->post['second_guardian_nic'];
            $this->model_parent->phone_home = ( $this->request->post['second_guardian_telephone'] == "" )  ? null : $this->request->post['second_guardian_telephone'];
            $this->model_parent->phone_mobile = ( $this->request->post['second_guardian_mobile_number'] == "" )  ? null : $this->request->post['second_guardian_mobile_number'];
            $this->model_parent->occupation = $this->request->post['second_guardian_occupation'];
            $this->model_parent->position = ( $this->request->post['second_guardian_position'] == "" )  ? null : $this->request->post['second_guardian_position'];
            $this->model_parent->income = ( $this->request->post['second_guardian_income'] == "" )  ? null : $this->request->post['second_guardian_income'];
            $this->model_parent->email = ( $this->request->post['second_guardian_email'] == "" )  ? null : $this->request->post['second_guardian_email'];
            $this->model_parent->address = $this->request->post['second_guardian_address'];
            $this->model_parent->city = $this->request->post['second_guardian_city'];
            $this->model_parent->district_id = ( $this->request->post['second_guardian_district'] == "null" ) ? null : $this->request->post['second_guardian_district'];

            if ( $this->model_parent->save() ):

                // INITIATE : STUDENT HAS PARENT RECORD
                $this->model_student_parent->student_id = $this->request->post['student_id'];
                $this->model_student_parent->parent_id = $this->model_parent->id;
                $this->model_student_parent->relation_id = $this->request->post['second_guardian_relation'];

                // CHECK : STUDENT HAS PARENT QUERY
                if ( $this->model_student_parent->save() ):
                    echo json_encode( array( "status" => "success" ), JSON_PRETTY_PRINT );
                else:
                    echo json_encode( array( "status" => "failed" ), JSON_PRETTY_PRINT );
                endif;

            else:
                echo json_encode( array( "status" => "failed" ), JSON_PRETTY_PRINT );
            endif;

        endif;
    }

    public function profile($parent_id) {

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
        $this->load->model('parent');
        $this->load->model('student');
        $this->load->model('student/parent');
        $this->load->model('student/relation');
        $this->load->model('religion');
        $this->load->model('district');
        $this->load->model('class');
        $this->load->model('grade');
        $this->load->model('user');
        $this->load->model('user/role');

        // CHECK PERMISSION : profile
        if ( $this->model_user->find($_SESSION['user']['id'])->hasPermission('parents-profile-view') ):
            $data['permission']['parents']['profile']['view'] = true;
        else:
            $data['permission']['parents']['profile']['view'] = false;
        endif;

        // CHECK PERMISSION : edit
        if ( $this->model_user->find($_SESSION['user']['id'])->hasPermission('parents-profile-edit') ):
            $data['permission']['parents']['profile']['edit'] = true;
        else:
            $data['permission']['parents']['profile']['edit'] = false;
        endif;

        // CHECK PERMISSION : delete
        if ( $this->model_user->find($_SESSION['user']['id'])->hasPermission('parents-profile-delete') ):
            $data['permission']['parents']['profile']['delete'] = true;
        else:
            $data['permission']['parents']['profile']['delete'] = false;
        endif;

        // PROFILE PICTURE UPLOAD
        if ( isset($_FILES['propic']) && $_FILES["propic"]["error"] == 0 ):

            // CHECK SIZE
            $size_mb = $_FILES['propic']['size'] / 1048576;

            // CHECK PERMISSION : propic
            if ( $this->model_user->find($_SESSION['user']['id'])->hasPermission('parents-profile-edit-propic') ):
                $data['permission']['parent']['profile']['edit']['propic'] = true;
                // SAVE
                if ( $size_mb < 1 AND $_FILES['propic']['type'] == 'image/jpeg' OR $_FILES['propic']['type'] == 'image/jpg' ):
                    move_uploaded_file($_FILES['propic']['tmp_name'], ABS_PATH.'/data/uploads/propics/parent/'.$this->request->post['parent_id'].'.jpg');
                else:
                    $data['propic']['upload']['failed']['status'] = true;
                    $data['propic']['upload']['failed']['message'] = "Profile picture upload failed. Image should less than 1MB and in JPG/JPEG format";
                endif;
            else:
                $data['permission']['parent']['profile']['edit']['propic'] = false;
                $data['propic']['upload']['failed']['status'] = true;
                $data['propic']['upload']['failed']['message'] = "You are not allowed to change profile picture";
            endif;
        endif;

        //QUERY ( CLASS )
        foreach( $this->model_class->select('id', 'grade_id', 'staff_id', 'name')->get() as $key => $element ):
            $data['classes'][$key]['id'] = $element->id;
            $data['classes'][$key]['grade']['id'] = $element->grade_id;
            $data['classes'][$key]['staff']['id'] = $element->staff_id;
            $data['classes'][$key]['name'] = $element->name;

            $data['classes'][$key]['grade']['name'] = $this->model_grade->select('name')->where('id', '=', $element->grade_id)->first()->name;
        endforeach;

        //QUERY ( RELATIONSHIP )
		foreach( $this->model_student_relation->select('id', 'name')->orderBy('id')->get() as $key => $element ):
			$data['student_relations'][$key]['id'] = $element->id;
			$data['student_relations'][$key]['name']= $element->name;
		endforeach;

        // QUERY ( RELIGION )
        foreach( $this->model_religion->select('id', 'name')->orderBy('name')->get() as $key => $element ):
            $data['religions'][$key]['id'] = $element->id;
            $data['religions'][$key]['name'] = $element->name;
        endforeach;

        // QUERY ( DISTRICT )
        foreach( $this->model_district->select('id', 'name')->orderBy('name')->get() as $key => $element ):
            $data['districts'][$key]['id'] = $element->id;
            $data['districts'][$key]['name'] = $element->name;
        endforeach;

        // QUERY ( USER ROLES )
        foreach( $this->model_user_role->get() as $key => $element ):
            $data['user']['roles'][$key]['id'] = $element->id;
            $data['user']['roles'][$key]['name'] = $element->name;
        endforeach;

        // USER STATUS
        $data['user']['status'][1]['name'] = 'Active';
        $data['user']['status'][2]['name'] = 'Inactive';

        // USER THEMES
        $data['user']['themes'][1]['name'] = 'Default';
        $data['user']['themes'][2]['name'] = 'Dark';

        // CHECK EXISTING PARENT
        $parent = $this->model_parent->where('id', '=', $parent_id)->first();

        // VIEW ERROR IF NO parent EXIST
        if ( $parent == null ){
            return http_response_code(404);
        }

        // BIO DATA
        $data['parent'] = $parent;

        // STUDENT DATA
        foreach ( $this->model_student_parent->where('parent_id', '=', $parent_id)->get() as $key => $element ):
            $data['students'][$key]['relation_id'] = $element->relation_id;
            $data['students'][$key]['details'] = $this->model_student->where('id', '=', $element->student_id)->first();
        endforeach;

        // STUDENT COUNT
        $data['student']['count'] = $this->model_student_parent->select('id')->where('parent_id', '=', $parent_id)->get()->count();

        // SETTINGS DATA
        $settings_data = $this->model_user->where('ref_id', '=', $parent_id)->where('user_type', '=', "parent")->first();
        if ( $settings_data !== NULL):
            $data['settings']['user_role']['id'] = $settings_data->role_id;
            $data['settings']['user_role']['name'] = $this->model_user_role->where('id', '=', $settings_data->role_id)->first()->name;
            $data['settings']['username'] = $settings_data->username;
            ( $settings_data->password !== NULL ) ? $data['settings']['password'] = "Password exists" : $data['settings']['password'] = "No password";
            $data['settings']['theme'] = $settings_data->theme;
            $data['settings']['status'] = $settings_data->status;
        endif;

        // RENDER VIEW
        $this->load->view('parents/profile', $data);
    }

    public function ajax_updateparent() {
        
        // CHECK LOGIN STATUS
		if( !isset($_SESSION['user']) OR $_SESSION['user']['is_login'] != true ):
			header( 'Location:' . $this->config->get('base_url') . '/logout' );
			exit();
        endif;

		// SET JSON HEADER
        header('Content-Type: application/json');

        // MODEL
        $this->load->model('parent');
        $this->load->model('student/parent');
        $this->load->model('user');
        $this->load->model('notification');

        // PERMISSION
        if ( !$this->model_user->find($_SESSION['user']['id'])->hasPermission('parents-profile-edit') ):
            echo json_encode( array( "status" => "failed", "message" => "Permission denied" ), JSON_PRETTY_PRINT );
            exit();
        endif;

        if ( isset($this->request->post['parent_id']) AND !empty($this->request->post['parent_id']) ):
            $is_valid_parent_id = $this->model_parent->select('id')->where('id', '=', $this->request->post['parent_id']);

            if ( $is_valid_parent_id->first() !== NULL ):

                // IS CHANGED NIC
                $current_nic = $this->model_parent->select('nic')->where('id', '=', $this->request->post['parent_id'])->first();
                if ( $current_nic->nic != $this->request->post['nic']):
                    // NIC IS CHANGED : CHECK FOR DUPLICATE
                    if ( $this->model_parent->select('id')->where('nic', '=', $this->request->post['nic'])->first() != NULL ):
                        echo json_encode( array( "status" => "failed", "message" => "This NIC already exists" ), JSON_PRETTY_PRINT );
                        exit();
                    endif;
                endif;

                // VALIDATION : full_name
                $is_valid_full_name = GUMP::is_valid($this->request->post, array('full_name' => 'required|valid_name|max_len,100'));
                if ( $is_valid_full_name !== true ):
                    echo json_encode( array("status" => "failed", "message" => "Please enter valid full name" ), JSON_PRETTY_PRINT );
                    exit();
                endif;

                // VALIDATION : initials
                $is_valid_initials = GUMP::is_valid($this->request->post, array('initials' => 'required|alpha_space|max_len,20'));
                if ( $is_valid_initials !== true ):
                    echo json_encode( array("status" => "failed", "message" => "Please enter student initials" ), JSON_PRETTY_PRINT );
                    exit();
                endif;

                // VALIDATION : surname
                $is_valid_surname = GUMP::is_valid($this->request->post, array('surname' => 'required|valid_name|max_len,30'));
                if ( $is_valid_surname !== true ):
                    echo json_encode( array("status" => "failed", "message" => "Please enter a valid surname" ), JSON_PRETTY_PRINT );
                    exit();
                endif;

                // VALIDATION : dob
                $is_valid_dob = GUMP::is_valid($this->request->post, array('dob' => 'required|date'));
                if ( $is_valid_dob !== true ):
                    echo json_encode( array("status" => "failed", "message" => "Please enter student Date of Birth" ), JSON_PRETTY_PRINT );
                    exit();
                endif;

                // VALIDATION : gender
                $is_valid_gender = GUMP::is_valid($this->request->post, array('gender' => 'required|contains_list,Male;Female'));
                if ( $is_valid_gender !== true ):
                    echo json_encode( array("status" => "failed", "message" => "Please select a gender" ), JSON_PRETTY_PRINT );
                    exit();
                endif;

                // VALIDATION : email
                $is_valid_email = GUMP::is_valid($this->request->post, array('email' => 'valid_email'));
                if ( $is_valid_email !== true ):
                    echo json_encode( array("status" => "failed", "message" => "Please enter a valid email" ), JSON_PRETTY_PRINT );
                    exit();
                endif;

                // VALIDATION : phone_home
                $is_valid_phone_home = GUMP::is_valid($this->request->post, array('phone_home' => 'numeric|exact_len,10'));
                if ( $is_valid_phone_home !== true ):
                    echo json_encode( array("status" => "failed", "message" => "Please enter a valid 10 digit landline number" ), JSON_PRETTY_PRINT );
                    exit();
                endif;

                // VALIDATION : phone_mobile
                $is_valid_phone_mobile = GUMP::is_valid($this->request->post, array('phone_mobile' => 'numeric|exact_len,10'));
                if ( $is_valid_phone_mobile !== true ):
                    echo json_encode( array("status" => "failed", "message" => "Please enter a valid 10 digit mobile number" ), JSON_PRETTY_PRINT );
                    exit();
                endif;

                // VALIDATION : occupation
                $is_valid_occupation = GUMP::is_valid($this->request->post, array('occupation' => 'required|alpha_space|max_len,50'));
                if ( $is_valid_occupation !== true ):
                    echo json_encode( array("status" => "failed", "message" => "Please enter a valid occupation name" ), JSON_PRETTY_PRINT );
                    exit();
                endif;

                // VALIDATION : position
                $is_valid_position = GUMP::is_valid($this->request->post, array('position' => 'alpha_space|max_len,50'));
                if ( $is_valid_position !== true ):
                    echo json_encode( array("status" => "failed", "message" => "Please enter a valid position in current occupation" ), JSON_PRETTY_PRINT );
                    exit();
                endif;

                // VALIDATION : income
                $is_valid_income = GUMP::is_valid($this->request->post, array('income' => 'numeric|min_len,4'));
                if ( $is_valid_income !== true ):
                    echo json_encode( array("status" => "failed", "message" => "Please enter a minimum of 4 digit income value" ), JSON_PRETTY_PRINT );
                    exit();
                endif;

                // VALIDATION : address
                $is_valid_address = GUMP::is_valid($this->request->post, array('address' => 'required|street_address|max_len,50'));
                if ( $is_valid_address !== true ):
                    echo json_encode( array("status" => "failed", "message" => "Please enter a valid address" ), JSON_PRETTY_PRINT );
                    exit();
                endif;

                // VALIDATION : city
                $is_valid_city = GUMP::is_valid($this->request->post, array('city' => 'required|alpha|max_len,20'));
                if ( $is_valid_city !== true ):
                    echo json_encode( array("status" => "failed", "message" => "Please enter a valid city name" ), JSON_PRETTY_PRINT );
                    exit();
                endif;

                if ( $this->request->post['district_id'] == "null" ):
                    $this->request->post['district_id'] = NULL;
                endif;
                
                // VALIDATION : disrict_id
                $is_valid_disrict_id = GUMP::is_valid($this->request->post, array('disrict_id' => 'numeric|min_len,1|max_len,2'));
                if ( $is_valid_disrict_id !== true AND $this->request->post['disrict_id'] != "null" ):
                    echo json_encode( array("status" => "failed", "message" => "Please select a valid disrict" ), JSON_PRETTY_PRINT );
                    exit();
                endif;

                // VALIDATION : nic
                $is_valid_nic = GUMP::is_valid($this->request->post, array('nic' => "required"));
                if ( $is_valid_nic === true ):
                    if ( preg_match("/^([0-9]{9}[x|X|v|V]|[0-9]{12})$/", $this->request->post['nic']) == false ):
                        echo json_encode( array( "error" => "Please enter valid NIC number" ), JSON_PRETTY_PRINT );
                        exit();
                    endif;
                else:
                    echo json_encode( array( "error" => "Please enter a NIC number" ), JSON_PRETTY_PRINT );
                    exit();
                endif;

                // VALIDATION : status
                $is_valid_status = GUMP::is_valid($this->request->post, array('status' => 'required|contains_list,Active;Deactive'));
                if ( $is_valid_status !== true ):
                    echo json_encode( array("status" => "failed", "message" => "Please select a valid user account status" ), JSON_PRETTY_PRINT );
                    exit();
                endif;

                if ( $this->request->post['role_id'] == "null" ):
                    $this->request->post['role_id'] = NULL;
                endif;

                // VALIDATION : role_id
                $is_valid_role_id = GUMP::is_valid($this->request->post, array('role_id' => 'numeric|min_len,1|max_len,2'));
                if ( $is_valid_role_id !== true ):
                    echo json_encode( array("status" => "failed", "message" => "Please select a valid user role" ), JSON_PRETTY_PRINT );
                    exit();
                endif;

                // VALIDATION : username
                $is_valid_username = GUMP::is_valid($this->request->post, array('username' => 'alpha_numeric|min_len,6|max_len,20'));
                if ( $is_valid_username !== true ):
                    echo json_encode( array("status" => "failed", "message" => "Please select a valid username of minimum 6 characters" ), JSON_PRETTY_PRINT );
                    exit();
                endif;

                // VALIDATION : password
                $is_valid_password = GUMP::is_valid($this->request->post, array('password' => 'alpha_numeric|min_len,6|max_len,20'));
                if ( $is_valid_password !== true ):
                    echo json_encode( array("status" => "failed", "message" => "Please select a valid password of minimum 6 characters without any special characters and spaces except dash(-),underscore(_)" ), JSON_PRETTY_PRINT );
                    exit();
                endif;

                // VALIDATION : confirm_password
                $is_valid_confirm_password = GUMP::is_valid($this->request->post, array('confirm_password' => 'alpha_numeric|min_len,6|max_len,20'));
                if ( $is_valid_confirm_password !== true ):
                    echo json_encode( array("status" => "failed", "message" => "Please enter a valid confirmation password as same as the password" ), JSON_PRETTY_PRINT );
                    exit();
                endif;

                // CHECK : PASSWORD = CONFIRM PASSWORD
                if ( $this->request->post['confirm_password'] != $this->request->post['password'] ):
                    echo json_encode( array("status" => "failed", "message" => "Password and confirm password doesn't match" ), JSON_PRETTY_PRINT );
                    exit();
                endif;

                // CHECK ANY USER AVAILABLE
                $is_available_user = $this->model_user->select('id')->where('user_type', '=', 'parent')->where('ref_id', '=', $this->request->post['parent_id']);
                if ( $is_available_user->first() != NULL):
                     // IS CHANGED USERNAME
                    $current_username = $this->model_user->select('username')->where('user_type', '=', 'parent')->where('ref_id', '=', $this->request->post['parent_id'])->first();
                    if ( $current_username->username != $this->request->post['username']):
                        // USERNAME IS CHANGED : CHECK FOR DUPLICATE
                        if ( $this->model_user->select('id')->where('username', '=', $this->request->post['username'])->first() != NULL ):
                            echo json_encode( array( "status" => "failed", "message" => "this username already exists" ), JSON_PRETTY_PRINT );
                            exit();
                        endif;
                    endif;
                endif;

                // UPDATE PROCESS
                try {
                    $this->model_parent->find($this->request->post['parent_id'])->update([

                        // UPDATE BIO
                        'full_name' => $this->request->post['full_name'],
                        'initials' => $this->request->post['initials'],
                        'surname' => $this->request->post['surname'],
                        'gender' => $this->request->post['gender'],
                        'dob' => $this->request->post['dob'],
                        'phone_mobile' => $this->request->post['phone_mobile'],
                        'phone_home' => $this->request->post['phone_home'],
                        'occupation' => $this->request->post['occupation'],
                        'position' => $this->request->post['position'],
                        'income' => $this->request->post['income'],
                        'email' => $this->request->post['email'],
                        'address' => $this->request->post['address'],
                        'city' => $this->request->post['city'],
                        'district_id' => $this->request->post['district_id'],

                        // UPDATE ACADEMIC
                        'nic' => $this->request->post['nic'],
                    ]);

                    // UPDATE STUDENT HAS PARENT
                    // $this->model_parent_class->where('parent_id', '=', $this->request->post['parent_id'])->update(['class_id' => $this->request->post['class_id']]);

                    // UPDATE SETTINGS IF AVAILABLE USER FOUND
                    $is_available_user = $this->model_user->select('id')->where('user_type', '=', 'parent')->where('ref_id', '=', $this->request->post['parent_id']);
                    if ( $is_available_user->first() != NULL):

                        // UPDATE STATUS,ROLE,USERNAME
                        $this->model_user->where('user_type', '=', 'parent')->where('ref_id', '=', $this->request->post['parent_id'])->update([
                            'status' => $this->request->post['status'],
                            'role_id' => $this->request->post['role_id'],
                            'username' => $this->request->post['username'],
                        ]);

                        // UPDATE PASSWORD
                        if ( isset($this->request->post['password']) == TRUE AND !empty( $this->request->post['password']) == TRUE ):
                            $this->model_user->where('user_type', '=', 'parent')->where('ref_id', '=', $this->request->post['parent_id'])->update(['password' => password_hash($this->request->post['password'], PASSWORD_DEFAULT)]);
                            // INITIATE : NOTIFICATION
                            $this->model_notification->sender_id = $_SESSION['user']['id'];
                            $this->model_notification->receiver_id = $is_available_user->first()->id;
                            $this->model_notification->title = "Password changed";
                            $this->model_notification->body = "Your password has been changed by System Administrator";
                            $this->model_notification->save();
                        endif;

                    // CREATE A USER IF STATUS IS ACTIVE
                    elseif ( $this->request->post['status'] == "Active" OR !empty($this->request->post['username']) ):

                        // VALIDATION : role_id
                        $is_valid_role_id = GUMP::is_valid($this->request->post, array('role_id' => 'required|numeric|min_len,1|max_len,2'));
                        if ( $is_valid_role_id !== true ):
                            echo json_encode( array("status" => "failed", "message" => "Please select a valid user role" ), JSON_PRETTY_PRINT );
                            exit();
                        endif;

                        // VALIDATION : username
                        $is_valid_username = GUMP::is_valid($this->request->post, array('username' => 'required|alpha_numeric|min_len,6|max_len,20'));
                        if ( $is_valid_username !== true ):
                            echo json_encode( array("status" => "failed", "message" => "Please select a valid username of minimum 6 characters" ), JSON_PRETTY_PRINT );
                            exit();
                        endif;

                        // USERNAME ASSIGNED : CHECK FOR DUPLICATE
                        if ( $this->model_user->select('id')->where('username', '=', $this->request->post['username'])->first() != NULL ):
                            echo json_encode( array( "status" => "failed", "message" => "this username already exists" ), JSON_PRETTY_PRINT );
                            exit();
                        endif;

                        // VALIDATION : password
                        $is_valid_password = GUMP::is_valid($this->request->post, array('password' => 'required|alpha_numeric|min_len,6|max_len,20'));
                        if ( $is_valid_password !== true ):
                            echo json_encode( array("status" => "failed", "message" => "Please select a valid password of minimum 6 characters without any special characters and spaces except dash(-),underscore(_)" ), JSON_PRETTY_PRINT );
                            exit();
                        endif;                        

                        // INITIATE : USER RECORD
                        $this->model_user->user_type = "parent";
                        $this->model_user->ref_id = $this->request->post['parent_id'];
                        $this->model_user->role_id = $this->request->post['role_id'];
                        $this->model_user->username = $this->request->post['username'];
                        $this->model_user->password = password_hash($this->request->post['password'], PASSWORD_DEFAULT);
                        $this->model_user->status = $this->request->post['status'];

                        // CHECK : USER RECORD QUERY
                        if ( $this->model_user->save() ):

                            // INITIATE : NOTIFICATION
                            $this->model_notification->sender_id = $_SESSION['user']['id'];
                            $this->model_notification->receiver_id = $this->model_user->id;
                            $this->model_notification->title = "Account Activated";
                            $this->model_notification->body = "Your account has been activated by System Administrator";
                            $this->model_notification->save();
                            
                            echo json_encode( array( "status" => "success" ), JSON_PRETTY_PRINT );
                            exit();
                            
                        else:
                            echo json_encode( array( "status" => "failed", "message" => "Unable create user. Please set username and password" ), JSON_PRETTY_PRINT );
                            exit();
                        endif;
                    endif;

                    echo json_encode( array("status" => "success"), JSON_PRETTY_PRINT );
                    exit();

                } catch (\Illuminate\Database\QueryException $e) {
                    // var_dump( $e->errorInfo );
                    echo json_encode( array( "status" => "failed", "message" => "Unable to edit parent. Please contact your System Administrator" ), JSON_PRETTY_PRINT );
                    exit();
                }

            else:
                // NO RECORD FOUND TO UPDATE
				echo json_encode( array( "status" => "failed", "message" => "No Parent record found to modify" ), JSON_PRETTY_PRINT );
				exit();
			endif;
        else:
            // PARENT ID IS NOT SET
			echo json_encode( array( "status" => "failed", "message" => "Please select a valid Parent record" ), JSON_PRETTY_PRINT );
			exit();
		endif;
    }

    public function ajax_removeparent() {
        
        // CHECK LOGIN STATUS
		if( !isset($_SESSION['user']) OR $_SESSION['user']['is_login'] != true ):
			header( 'Location:' . $this->config->get('base_url') . '/logout' );
			exit();
		endif;

		// SET JSON HEADER
        header('Content-Type: application/json');

        // MODEL
        $this->load->model('parent');
        $this->load->model('student/parent');
        $this->load->model('user');

		// PERMISSION
        if ( !$this->model_user->find($_SESSION['user']['id'])->hasPermission('parents-profile-delete') ):
            echo json_encode( array( "status" => "failed", "message" => "Permission denied" ), JSON_PRETTY_PRINT );
            exit();
        endif;
        
        if ( isset($this->request->post['parent_id']) AND !empty($this->request->post['parent_id']) ):
            $is_valid_parent_id = $this->model_parent->select('id')->where('id', '=', $this->request->post['parent_id']);

            if ( $is_valid_parent_id->first() !== NULL ):

                // CHECK PARENT HAS STUDENTS
                if( $this->model_student_parent->select('id')->where('parent_id', '=', $this->request->post['parent_id'])->first() != NULL ):
                    echo json_encode( array( "status" => "failed", "message" => "Parent already assigned to one or more students. Please retry after removing." ), JSON_PRETTY_PRINT );
                    exit();
                endif;

                // PROCEED TO DELETE
				if ( $this->model_parent->find($this->request->post['parent_id'])->delete() ):
					echo json_encode( array( "status" => "success" ), JSON_PRETTY_PRINT );
					exit();
				else:
					echo json_encode( array( "status" => "failed", "message" => "Cannot delete this parent. Please contact system administrator" ), JSON_PRETTY_PRINT );
                    exit();
				endif;
            else:
                // NO RECORD FOUND TO DELETE
				echo json_encode( array( "status" => "failed", "message" => "No parent record found" ), JSON_PRETTY_PRINT );
				exit();
			endif;
        else:
            // parent ID IS NOT SET
			echo json_encode( array( "status" => "failed", "message" => "Please select a valid parent record" ), JSON_PRETTY_PRINT );
			exit();
		endif;
    }
}
?>