<?php

use Carbon\Carbon;
use Illuminate\Database\Capsule\Manager as DB;

class Student extends Controller {
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
        $this->load->model('class');
        $this->load->model('grade');
		$this->load->model('student');
        $this->load->model('student/attendance');
        
        $date_now = Carbon::now()->isoFormat('YYYY-MM-DD');

        // STUDENT TOTAL CARD
		$data['student']['total']['all'] = $this->model_student->select('id')->count();
		$data['student']['total']['male'] = $this->model_student->select('id')->where('gender', '=', 'male')->count();
		$data['student']['total']['female'] = $this->model_student->select('id')->where('gender', '=', 'female')->count();

        // PRESENT TODAY CARD
        $data['student']['attendance']['all'] = $this->model_student_attendance->select('id')->where('date', '=', $date_now)->count();
        
		$data['student']['attendance']['male'] = DB::table('student_attendance')
		->join('student', 'student_attendance.student_id', '=', 'student.id')
		->select('student.id')
		->where('date', '=', $date_now)
		->where('gender', '=', 'male')
        ->count();
        
		$data['student']['attendance']['female'] = DB::table('student_attendance')
		->join('student', 'student_attendance.student_id', '=', 'student.id')
		->select('student.id')
		->where('date', '=', $date_now)
		->where('gender', '=', 'female')
        ->count();

        // ABSENT CARD
		$data['student']['absent']['all'] = $data['student']['total']['all'] - $data['student']['attendance']['all'];
		$data['student']['absent']['male'] = $data['student']['total']['male'] - $data['student']['attendance']['male'];
        $data['student']['absent']['female'] = $data['student']['total']['female'] - $data['student']['attendance']['female'];
        
        // CLASS STUDENT TOTAL CHART
        foreach ( $this->model_class->select('id','grade_id','name')->get() as $key => $element ):
            $grade = $this->model_grade->select('name')->where('id', '=', $element->grade_id)->first()->name;
            $data['classes'][$key]['name'] = $grade." - ".$element->name;
            $data['classes'][$key]['total'] = $this->model_student->select('id')->where('class_id', '=', $element->id)->count();
        endforeach;

		// RENDER VIEW
        $this->load->view('student/index', $data);
        
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

        // MODELS
        $this->load->model('student');
        $this->load->model('student/subject');
        $this->load->model('student/sport');
        $this->load->model('class');
        $this->load->model('grade');
        $this->load->model('district');
        $this->load->model('subject');
        $this->load->model('exam');
        $this->load->model('exam/type');
        $this->load->model('sport');
        $this->load->model('religion');

        //STUDENT CLASS
        foreach( $this->model_class->select('id', 'grade_id', 'staff_id', 'name')->get() as $key => $element ):
            $data['student_class'][$key]['id'] = $element->id;
            $data['student_class'][$key]['grade']['id'] = $element->grade_id;
            $data['student_class'][$key]['staff']['id'] = $element->staff_id;
            $data['student_class'][$key]['name'] = $element->name;

            $data['student_class'][$key]['grade']['name'] = $this->model_grade->select('name')->where('id', '=', $element->grade_id)->first()->name;
        endforeach;

        //GRADE
        foreach( $this->model_grade->select('id', 'name')->orderBy('name')->get() as $key => $element ):
            $data['student_grade'][$key]['id'] = $element->id;
            $data['student_grade'][$key]['name'] = $element->name;
        endforeach;

        // CITY
        foreach( $this->model_student->select('city')->orderBy('city')->distinct()->get() as $key => $element ):
            $data['student_city'][$key]['name'] = $element->city;
        endforeach;

        //DISTRICT
        foreach( $this->model_district->select('id', 'province_id', 'name')->orderBy('name')->get() as $key => $element ):
            $data['student_district'][$key]['id'] = $element->id;
            $data['student_district'][$key]['province']['id'] = $element->province_id;
            $data['student_district'][$key]['name'] = $element->name;
        endforeach;

        //SUBJECT
        foreach( $this->model_subject->select('id', 'name', 'si_name')->orderBy('name')->get() as $key => $element ):
            $data['student_subject'][$key]['id'] = $element->id;
            $data['student_subject'][$key]['name'] = $element->name;
            $data['student_subject'][$key]['si_name'] = $element->si_name;
        endforeach;

        //EXAM
        foreach( $this->model_exam->select('id', 'type_id','year')->orderBy('year', 'DESC')->get() as $key => $element ):
            $data['student_exam'][$key]['id'] = $element->id;
            $data['student_exam'][$key]['type_id'] = $element->type_id;
            $data['student_exam'][$key]['year'] = $element->year;

            $data['student_exam'][$key]['type']['name'] = $this->model_exam_type->select('name')->where('id', '=', $element->type_id)->first()->name;
        endforeach;

        //SPORT
        foreach( $this->model_sport->select('id', 'name')->orderBy('name')->get() as $key => $element ):
            $data['student_sport'][$key]['id'] = $element->id;
            $data['student_sport'][$key]['name'] = $element->name;
        endforeach;

        //RELIGION
        foreach( $this->model_religion->select('id', 'name')->orderBy('name')->get() as $key => $element ):
            $data['student_religion'][$key]['id'] = $element->id;
            $data['student_religion'][$key]['name'] = $element->name;
        endforeach;

        // CHECK SUBMIT
        if ( isset($this->request->post['isSubmited']) ):

            // PERSIST DATA
            $data['form']['field']['addno'] = ( isset($this->request->post['addno']) AND !empty($this->request->post['addno']) ) ? $this->request->post['addno'] : "";
            $data['form']['field']['adddate'] = ( isset($this->request->post['adddate']) AND !empty($this->request->post['adddate']) ) ? $this->request->post['adddate'] : "";
            $data['form']['field']['dob'] = ( isset($this->request->post['dob']) AND !empty($this->request->post['dob']) ) ? $this->request->post['dob'] : "";
            $data['form']['field']['name'] = ( isset($this->request->post['name']) AND !empty($this->request->post['name']) ) ? $this->request->post['name'] : "";
            $data['form']['field']['class'] = ( isset($this->request->post['class']) AND !empty($this->request->post['class']) ) ? $this->request->post['class'] : "";
            $data['form']['field']['grade'] = ( isset($this->request->post['grade']) AND !empty($this->request->post['grade']) ) ? $this->request->post['grade'] : "";
            $data['form']['field']['gender'] = ( isset($this->request->post['gender']) AND !empty($this->request->post['gender']) ) ? $this->request->post['gender'] : "";
            $data['form']['field']['city'] = ( isset($this->request->post['city']) AND !empty($this->request->post['city']) ) ? $this->request->post['city'] : "";
            $data['form']['field']['district'] = ( isset($this->request->post['district']) AND !empty($this->request->post['district']) ) ? $this->request->post['district'] : "";
            $data['form']['field']['subject'] = ( isset($this->request->post['subject']) AND !empty($this->request->post['subject']) ) ? $this->request->post['subject'] : "";
            $data['form']['field']['sport'] = ( isset($this->request->post['sport']) AND !empty($this->request->post['sport']) ) ? $this->request->post['sport'] : "";
            $data['form']['field']['religion'] = ( isset($this->request->post['religion']) AND !empty($this->request->post['religion']) ) ? $this->request->post['religion'] : "";

            // Eloquent OBJECT
            $student = $this->model_student->select('id', 'admission_no', 'admission_date', 'class_id', 'full_name', 'initials', 'surname', 'dob', 'gender', 'email', 'phone_mobile', 'address', 'city', 'district_id', 'religion_id');

            // FILTER ( ADMISSION NO )
            if ( isset($this->request->post['addno']) AND !empty($this->request->post['addno']) ):
                $student->where(function($query) {
                    $query->where('admission_no', '=', $this->request->post['addno']);
                });
            endif;

            // FILTER ( ADMISSION DATE )
            if ( isset($this->request->post['adddate']) AND !empty($this->request->post['adddate']) ):
                $student->where(function($query) {
                    $query->where('admission_date', '=', $this->request->post['adddate']);
                });
            endif;

            // FILTER ( BIRTHDAY )
            if ( isset($this->request->post['dob']) AND !empty($this->request->post['dob']) ):
                $student->where(function($query) {
                    $query->where('dob', '=', $this->request->post['dob']);
                });
            endif;

            // FILTER ( NAME )
            if ( isset($this->request->post['name']) AND !empty($this->request->post['name']) ):
                $student->where(function($query) {
                    $query->where('full_name', 'LIKE', '%'.$this->request->post['name'].'%');
                });
            endif;

            // FILTER ( CLASS )
            if ( isset($this->request->post['class']) AND !empty($this->request->post['class']) ):
                $student->where(function($query) {
                    $query->where('class_id', '=', $this->request->post['class']);
                });
            endif;

            // FILTER ( GRADE )
            if ( isset($this->request->post['grade']) AND !empty($this->request->post['grade']) ):
                $class = $this->model_class->select('id')->where('grade_id', '=', $this->request->post['grade'])->get();
                if ( $class != NULL ):
                    $classes = array();
                    foreach ( $class as $key => $element ):
                        array_push($classes, $element->id);
                    endforeach;
                    $student->where(function($query) use ($classes) {
                        $query->whereIn('class_id', $classes);
                    });
                endif; 
            endif;

            // FILTER ( GENDER )
            if ( isset($this->request->post['gender']) AND !empty($this->request->post['gender']) ):
                $student->where(function($query) {
                    $query->where('gender', '=', $this->request->post['gender']);
                });
            endif;

            // FILTER (CITY)
            if ( isset($this->request->post['city']) AND !empty($this->request->post['city']) ):
                $student->where(function($query) {
                    $query->where('city', 'LIKE', '%'.$this->request->post['city'].'%');
                });
            endif;

            // FILTER (DISTRICT)
            if ( isset($this->request->post['district']) AND !empty($this->request->post['district']) ):
                $student->where(function($query) {
                    $query->where('district_id', '=', $this->request->post['district']);
                });
            endif;

            // FILTER (SUBJECT)
            if ( isset($this->request->post['subject']) AND !empty($this->request->post['subject']) ):
                $subject = $this->model_student_subject->select('student_id')->where('subject_id','=', $this->request->post['subject'])->get();
                if ( $subject != NULL):
                    $subjects = array();
                    foreach ( $subject as $key => $element ):
                        array_push($subjects,$element->student_id);
                    endforeach;
                    $student->where(function($query) use ($subjects) {
                        $query->whereIn('id', $subjects);
                    });
                endif;
            endif;

            // FILTER (SPORT)
            if ( isset($this->request->post['sport']) AND !empty($this->request->post['sport']) ):
                $sport = $this->model_student_sport->select('student_id')->where('sport_id','=', $this->request->post['sport'])->get();
                if ( $sport != NULL):
                    $sports = array();
                    foreach ( $sport as $key => $element ):
                        array_push($sports,$element->student_id);
                    endforeach;
                    $student->where(function($query) use ($sports) {
                        $query->whereIn('id', $sports);
                    });
                endif;
            endif;

            // FILTER (RELIGION)
            if ( isset($this->request->post['religion']) AND !empty($this->request->post['religion']) ):
                $student->where(function($query) {
                    $query->where('religion_id', '=', $this->request->post['religion']);
                });
            endif;

            // APPEND DATA TO ARRAY
            foreach( $student->get() as $key => $value ):
                $data['students'][$key]['id'] = $value->id;
                $data['students'][$key]['admission_no'] = $value->admission_no;
                $data['students'][$key]['name'] = $value->full_name;
                $data['students'][$key]['gender'] = $value->gender;
                $data['students'][$key]['dob'] = $value->dob;
                $data['students'][$key]['class'] = $value->class_id;
                $data['students'][$key]['city'] = $value->city;
            endforeach;

        endif;

		// RENDER VIEW
        $this->load->view('student/search', $data);
        
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
        foreach( $this->model_religion->select('id', 'name')->orderBy('name')->get() as $key => $element ):
            $data['student_religion'][$key]['id'] = $element->id;
            $data['student_religion'][$key]['name'] = $element->name;
        endforeach;

        //DISTRICT
        foreach( $this->model_district->select('id', 'province_id', 'name')->orderBy('name')->get() as $key => $element ):
            $data['student_district'][$key]['id'] = $element->id;
            $data['student_district'][$key]['province']['id'] = $element->province_id;
            $data['student_district'][$key]['name'] = $element->name;
        endforeach;

        //RELATIONSHIP
        foreach( $this->model_student_relation->select('id', 'name')->orderBy('name')->get() as $key => $element ):
            $data['student_relation_type'][$key]['id'] = $element->id;
            $data['student_relation_type'][$key]['name'] = $element->name;
        endforeach;

		// RENDER VIEW
        $this->load->view('student/add', $data);
        
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

    public function ajax_add() {

        //CHECK LOGIN STATUS
		if( !isset($_SESSION['user']) OR $_SESSION['user']['is_login'] != true ):
			header( 'Location:' . $this->config->get('base_url') . '/logout' );
			exit();
		endif;

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
        **/

        // SET JSON HEADER
        header('Content-Type: application/json');

        //MODEL
        $this->load->model('student');
        $this->load->model('parent');
        $this->load->model('student/parent');
        $this->load->model('student/class');

        // VALIDATION : STUDENT
        // VALIDATION : admission_number
        $is_valid_admission_number = GUMP::is_valid($this->request->post, array('admission_number' => 'numeric|max_len,6'));
        if ( $is_valid_admission_number !== true ):
            echo json_encode( array( "status" => "failed", "error" => "Please enter a valid number less or equal to six digits" ), JSON_PRETTY_PRINT );
            exit();
        endif;

            // CHECK ADMISSION NUMBER 
            if ( GUMP::is_valid($this->request->post, array('admission_number' => 'required')) === true ):

                // ADMISSION NUMBER IS INSERTED : CHECK FOR DUPLICATE
                if ( $this->model_student->select('id')->where('admission_no', '=', $this->request->post['admission_number'])->first() != NULL ):
                    echo json_encode( array( "status" => "failed", "error" => "inserted admission number is already present" ), JSON_PRETTY_PRINT );
                    exit();
                endif;

            // ADMISSION NUMBER IS EMPTY : INCREMENT BY ONE TO THE LAST ADMISSION NUMBER
            else:
                $last_admission = $this->model_student->select('admission_no')->orderBy('admission_no', 'DESC')->take(1)->first();
                if ( $last_admission == NULL ):
                    $this->request->post['admission_number'] = 1;
                else:
                    $this->request->post['admission_number'] = $last_admission->admission_no +1;
                endif;                
            endif;

        // VALIDATION : admission_date
        $is_valid_admission_date = GUMP::is_valid($this->request->post, array('admission_date' => 'required|date'));
        if ( $is_valid_admission_date !== true ):
            echo json_encode( array("status" => "failed", "error" => "Please select a admission date" ), JSON_PRETTY_PRINT );
            exit();
        endif;

        // VALIDATION : class
        $is_valid_class = GUMP::is_valid($this->request->post, array('class' => 'required|numeric|max_len,3'));
        if ( $is_valid_class !== true ):
            echo json_encode( array("status" => "failed", "error" => "Please select a class" ), JSON_PRETTY_PRINT );
            exit();
        endif;

        // // VALIDATION : subject
        // $is_valid_subject = GUMP::is_valid($this->request->post, array('subject' => 'required|numeric|max_len,3'));
        // if ( $is_valid_subject !== true ):
        //     echo json_encode( array("status" => "failed", "error" => $is_valid_subject[0] ), JSON_PRETTY_PRINT );
        //     exit();
        // endif;

        // VALIDATION : full_name
        $is_valid_full_name = GUMP::is_valid($this->request->post, array('full_name' => 'required|valid_name|max_len,100'));
        if ( $is_valid_full_name !== true ):
            echo json_encode( array("status" => "failed", "error" => "Please enter student full name" ), JSON_PRETTY_PRINT );
            exit();
        endif;

        // VALIDATION : initials
        $is_valid_initials = GUMP::is_valid($this->request->post, array('initials' => 'required|alpha_space|max_len,20'));
        if ( $is_valid_initials !== true ):
            echo json_encode( array("status" => "failed", "error" => "Please enter student initials" ), JSON_PRETTY_PRINT );
            exit();
        endif;

        // VALIDATION : surname
        $is_valid_surname = GUMP::is_valid($this->request->post, array('surname' => 'required|valid_name|max_len,30'));
        if ( $is_valid_surname !== true ):
            echo json_encode( array("status" => "failed", "error" => "Please enter a valid surname" ), JSON_PRETTY_PRINT );
            exit();
        endif;

        // VALIDATION : date_of_birth
        $is_valid_date_of_birth = GUMP::is_valid($this->request->post, array('date_of_birth' => 'required|date'));
        if ( $is_valid_date_of_birth !== true ):
            echo json_encode( array("status" => "failed", "error" => "Please enter student Date of Birth" ), JSON_PRETTY_PRINT );
            exit();
        endif;

        // VALIDATION : gender
        $is_valid_gender = GUMP::is_valid($this->request->post, array('gender' => 'required|contains_list,Male;Female'));
        if ( $is_valid_gender !== true ):
            echo json_encode( array("status" => "failed", "error" => "Please select a gender" ), JSON_PRETTY_PRINT );
            exit();
        endif;

        // VALIDATION : email
        $is_valid_email = GUMP::is_valid($this->request->post, array('email' => 'valid_email'));
        if ( $is_valid_email !== true ):
            echo json_encode( array("status" => "failed", "error" => "Please enter a valid email" ), JSON_PRETTY_PRINT );
            exit();
        endif;

            // email IS ENTERED : CHECK FOR DUPLICATE
            if ( $this->request->post['email'] !== ""):
                if ( $this->model_student->select('id')->where('email', '=', $this->request->post['email'])->first() != NULL ):
                    echo json_encode( array("status" => "failed", "error" => "This Email is already present" ), JSON_PRETTY_PRINT );
                    exit();
                endif;
            endif;

        // VALIDATION : mobile_number
        $is_valid_mobile_number = GUMP::is_valid($this->request->post, array('mobile_number' => 'numeric|exact_len,10'));
        if ( $is_valid_mobile_number !== true ):
            echo json_encode( array("status" => "failed", "error" => "Please enter a valid 10 digit mobile number" ), JSON_PRETTY_PRINT );
            exit();
        endif;

        // VALIDATION : address
        $is_valid_address = GUMP::is_valid($this->request->post, array('address' => 'required|street_address|max_len,50'));
        if ( $is_valid_address !== true ):
            echo json_encode( array("status" => "failed", "error" => "Please enter a valid address" ), JSON_PRETTY_PRINT );
            exit();
        endif;

        // VALIDATION : city
        $is_valid_city = GUMP::is_valid($this->request->post, array('city' => 'required|alpha|max_len,20'));
        if ( $is_valid_city !== true ):
            echo json_encode( array("status" => "failed", "error" => "Please enter a valid city name" ), JSON_PRETTY_PRINT );
            exit();
        endif;

        // VALIDATION : district
        $is_valid_district = GUMP::is_valid($this->request->post, array('district' => 'numeric|max_len,2'));
        if ( $is_valid_district !== true AND $this->request->post['district'] != "null" ):
            echo json_encode( array("status" => "failed", "error" => "Invalid district name" ), JSON_PRETTY_PRINT );
            exit();
        endif;

        // VALIDATION : birth_place
        $is_valid_birth_place = GUMP::is_valid($this->request->post, array('birth_place' => 'valid_name|max_len,30'));
        if ( $is_valid_birth_place !== true ):
            echo json_encode( array("status" => "failed", "error" => "Please enter a valid birth place" ), JSON_PRETTY_PRINT );
            exit();
        endif;

        // VALIDATION : religion
        $is_valid_religion = GUMP::is_valid($this->request->post, array('religion' => 'numeric|max_len,2'));
        if ( $is_valid_religion !== true AND $this->request->post['district'] != "null" ):
            echo json_encode( array("status" => "failed", "error" => "Invalid religion name" ), JSON_PRETTY_PRINT );
            exit();
        endif;

        // VALIDATION : FIRST GUARDIAN
        // VALIDATION : first_guardian_full_name
        $is_valid_first_guardian_full_name = GUMP::is_valid($this->request->post, array('first_guardian_full_name' => 'required|valid_name|max_len,100'));
        if ( $is_valid_first_guardian_full_name !== true ):
            echo json_encode( array("status" => "failed", "error" => "Please enter a valid full name for guardian" ), JSON_PRETTY_PRINT );
            exit();
        endif;

        // VALIDATION : first_guardian_initials
        $is_valid_first_guardian_initials = GUMP::is_valid($this->request->post, array('first_guardian_initials' => 'required|alpha_space|max_len,20'));
        if ( $is_valid_first_guardian_initials !== true ):
            echo json_encode( array("status" => "failed", "error" => "Please enter valid initials for guardian" ), JSON_PRETTY_PRINT );
            exit();
        endif;

        // VALIDATION : first_guardian_surname
        $is_valid_first_guardian_surname = GUMP::is_valid($this->request->post, array('first_guardian_surname' => 'required|valid_name|max_len,20'));
        if ( $is_valid_first_guardian_surname !== true ):
            echo json_encode( array("status" => "failed", "error" => "Please enter a valid surname for guardian" ), JSON_PRETTY_PRINT );
            exit();
        endif;

        // VALIDATION : first_guardian_date_of_birth
        $is_valid_first_guardian_date_of_birth = GUMP::is_valid($this->request->post, array('first_guardian_date_of_birth' => 'required|date'));
        if ( $is_valid_first_guardian_date_of_birth !== true ):
            echo json_encode( array("status" => "failed", "error" => "Please enter a valid date of birth for guardian" ), JSON_PRETTY_PRINT );
            exit();
        endif;

        // VALIDATION : first_guardian_relation
        $is_valid_first_guardian_relation = GUMP::is_valid($this->request->post, array('first_guardian_relation' => 'required|numeric|max_len,2'));
        if ( $is_valid_first_guardian_relation !== true ):
            echo json_encode( array("status" => "failed", "error" => "Please select a relation for guardian" ), JSON_PRETTY_PRINT );
            exit();
        endif;

        // VALIDATION : first_guardian_gender
        $is_valid_first_guardian_gender = GUMP::is_valid($this->request->post, array('first_guardian_gender' => 'required|contains_list,Male;Female'));
        if ( $is_valid_first_guardian_gender !== true ):
            echo json_encode( array("status" => "failed", "error" => "Please select relevant gender for guardian" ), JSON_PRETTY_PRINT );
            exit();
        endif;

        // VALIDATION : first_guardian_nic
        $is_valid_first_guardian_nic = GUMP::is_valid($this->request->post, array('first_guardian_nic' => "required"));
        if ( $is_valid_first_guardian_nic === true ):
            if ( preg_match("/^([0-9]{9}[x|X|v|V]|[0-9]{12})$/", $this->request->post['first_guardian_nic']) == false ):
                echo json_encode( array("status" => "failed", "error" => "Wrong NIC Format in Guardian NIC" ), JSON_PRETTY_PRINT );
                exit();
            endif;
        else:
            echo json_encode( array("status" => "failed", "error" => "Please enter a valid NIC number for guardian" ), JSON_PRETTY_PRINT );
            exit();
        endif;

        // VALIDATION : first_guardian_telephone
        $is_valid_first_guardian_telephone = GUMP::is_valid($this->request->post, array('first_guardian_telephone' => 'numeric|max_len,10'));
        if ( $is_valid_first_guardian_telephone !== true ):
            echo json_encode( array("status" => "failed", "error" => "Please enter a valid 10 digit telephone number for guardian" ), JSON_PRETTY_PRINT );
            exit();
        endif;

        // VALIDATION : first_guardian_mobile_number
        $is_valid_first_guardian_mobile_number = GUMP::is_valid($this->request->post, array('first_guardian_mobile_number' => 'numeric|max_len,10'));
        if ( $is_valid_first_guardian_mobile_number !== true ):
            echo json_encode( array("status" => "failed", "error" => "Please enter a valid 10 digit mobile number for guardian" ), JSON_PRETTY_PRINT );
            exit();
        endif;

        // VALIDATION : first_guardian_occupation
        $is_valid_first_guardian_occupation = GUMP::is_valid($this->request->post, array('first_guardian_occupation' => 'required|valid_name|max_len,50'));
        if ( $is_valid_first_guardian_occupation !== true ):
            echo json_encode( array("status" => "failed", "error" => "Please enter a occupation for guardian" ), JSON_PRETTY_PRINT );
            exit();
        endif;

        // VALIDATION : first_guardian_position
        $is_valid_first_guardian_position = GUMP::is_valid($this->request->post, array('first_guardian_position' => 'valid_name|max_len,50'));
        if ( $is_valid_first_guardian_position !== true ):
            echo json_encode( array("status" => "failed", "error" => "Please enter a valid position name for guardian" ), JSON_PRETTY_PRINT );
            exit();
        endif;

        // VALIDATION : first_guardian_income
        $is_valid_first_guardian_income = GUMP::is_valid($this->request->post, array('first_guardian_income' => 'numeric|max_len,10'));
        if ( $is_valid_first_guardian_income !== true ):
            echo json_encode( array("status" => "failed", "error" => "Please enter a valid monthly income value for guardian" ), JSON_PRETTY_PRINT );
            exit();
        endif;

        // VALIDATION : first_guardian_email
        $is_valid_first_guardian_email = GUMP::is_valid($this->request->post, array('first_guardian_email' => 'valid_email'));
        if ( $is_valid_first_guardian_email !== true ):
            echo json_encode( array("status" => "failed", "error" => "Please enter a valid email for guardian" ), JSON_PRETTY_PRINT );
            exit();
        endif;

        // VALIDATION : first_guardian_address
        $is_valid_first_guardian_address = GUMP::is_valid($this->request->post, array('first_guardian_address' => 'required|street_address|max_len,50'));
        if ( $is_valid_first_guardian_address !== true ):
            echo json_encode( array("status" => "failed", "error" => "Please enter a valid address for guardian" ), JSON_PRETTY_PRINT );
            exit();
        endif;

        // VALIDATION : first_guardian_city
        $is_valid_first_guardian_city = GUMP::is_valid($this->request->post, array('first_guardian_city' => 'required|valid_name|max_len,20'));
        if ( $is_valid_first_guardian_city !== true ):
            echo json_encode( array("status" => "failed", "error" => "Please enter a valid city for guardian" ), JSON_PRETTY_PRINT );
            exit();
        endif;

        // VALIDATION : first_guardian_district
        $is_valid_first_guardian_district = GUMP::is_valid($this->request->post, array('first_guardian_district' => 'numeric|max_len,2'));
        if ( $is_valid_first_guardian_district !== true AND $this->request->post['first_guardian_district'] !== "null" ):
            echo json_encode( array("status" => "failed", "error" => "Please select a valid district for guardian" ), JSON_PRETTY_PRINT );
            exit();
        endif;

        $this->model_student->admission_no = $this->request->post['admission_number'];
        $this->model_student->admission_date = $this->request->post['admission_date'];
        $this->model_student->class_id = $this->request->post['class'];
        // $this->model_student->subject_id = $this->request->post['subject'];
        $this->model_student->full_name = $this->request->post['full_name'];
        $this->model_student->initials = $this->request->post['initials'];
        $this->model_student->surname = $this->request->post['surname'];
        $this->model_student->dob = $this->request->post['date_of_birth'];
        $this->model_student->gender = $this->request->post['gender'];
        $this->model_student->email = ( $this->request->post['email'] == "" ) ? null : $this->request->post['email'];
        $this->model_student->phone_mobile = ( $this->request->post['mobile_number'] == "" ) ? null : $this->request->post['mobile_number'];
        $this->model_student->address = $this->request->post['address'];
        $this->model_student->city = $this->request->post['city'];
        $this->model_student->district_id = ( $this->request->post['district'] == "null" ) ? null : $this->request->post['district'];
        $this->model_student->birth_place = ( $this->request->post['birth_place'] == "" ) ? null : $this->request->post['birth_place'];
        $this->model_student->religion_id = ( $this->request->post['religion'] == "null" )  ? null : $this->request->post['religion'];

        $parent = $this->model_parent->select('id')->where('nic', '=', $this->request->post['first_guardian_nic'])->first();

        if ( $parent !== null ):

            // SUBMIT
            if ( $this->model_student->save() ):    

                // INITIATE : STUDENT HAS PARENT RECORD
                $this->model_student_parent->student_id = $this->model_student->id;
                $this->model_student_parent->parent_id = $parent->id;
                $this->model_student_parent->relation_id = $this->request->post['first_guardian_relation'];

                // CHECK : STUDENT HAS PARENT QUERY
                if ( $this->model_student_parent->save() ):

                    // INITIATE : STUDENT HAS CLASS RECORD
                    $this->model_student_class->student_id = $this->model_student->id;
                    $this->model_student_class->class_id = $this->request->post['class'];

                    // FETCHING INDEX NO    
                    $index_no = $this->model_student_class->select('index_no')->where('class_id', '=' , $this->request->post['class'])->orderBy('index_no', 'DESC')->take(1)->first();
                    
                    // ASSIGNING INDEX_NO
                    if ( $index_no !== NULL ):
                        $newindex_no = $index_no->index_no + 1;
                        $this->model_student_class->index_no = $newindex_no;
                    else:
                        $this->model_student_class->index_no = 1;
                    endif;

                    // CHECK : STUDENT HAS CLASS QUERY
                    if ( $this->model_student_class->save() ):
                        echo json_encode( array( "status" => "success" ), JSON_PRETTY_PRINT );
                    else:
                        echo json_encode( array( "status" => "failed" ), JSON_PRETTY_PRINT );
                    endif;

                else:
                    echo json_encode( array( "status" => "failed" ), JSON_PRETTY_PRINT );
                endif;

                

            else:
                echo json_encode( array( "status" => "failed" ), JSON_PRETTY_PRINT );
            endif;
            
        else:

            $this->model_parent->full_name = $this->request->post['first_guardian_full_name'];
            $this->model_parent->initials = $this->request->post['first_guardian_initials'];
            $this->model_parent->surname = $this->request->post['first_guardian_surname'];
            $this->model_parent->dob = $this->request->post['first_guardian_date_of_birth'];
            $this->model_parent->gender = $this->request->post['first_guardian_gender'];
            $this->model_parent->nic = $this->request->post['first_guardian_nic'];
            $this->model_parent->phone_home = ( $this->request->post['first_guardian_telephone'] == "" )  ? null : $this->request->post['first_guardian_telephone'];
            $this->model_parent->phone_mobile = ( $this->request->post['first_guardian_mobile_number'] == "" )  ? null : $this->request->post['first_guardian_mobile_number'];
            $this->model_parent->occupation = $this->request->post['first_guardian_occupation'];
            $this->model_parent->position = ( $this->request->post['first_guardian_position'] == "" )  ? null : $this->request->post['first_guardian_position'];
            $this->model_parent->income = ( $this->request->post['first_guardian_income'] == "" )  ? null : $this->request->post['first_guardian_income'];
            $this->model_parent->email = ( $this->request->post['first_guardian_email'] == "" )  ? null : $this->request->post['first_guardian_email'];
            $this->model_parent->address = $this->request->post['first_guardian_address'];
            $this->model_parent->city = $this->request->post['first_guardian_city'];
            $this->model_parent->district_id = ( $this->request->post['first_guardian_district'] == "null" ) ? null : $this->request->post['first_guardian_district'];

            // SUBMIT
            if ( $this->model_student->save() AND $this->model_parent->save() ):

                // INITIATE : STUDENT HAS PARENT RECORD
                $this->model_student_parent->student_id = $this->model_student->id;
                $this->model_student_parent->parent_id = $this->model_parent->id;
                $this->model_student_parent->relation_id = $this->request->post['first_guardian_relation'];

                // CHECK : STUDENT HAS PARENT QUERY
                if ( $this->model_student_parent->save() ):

                    // INITIATE : STUDENT HAS CLASS RECORD
                    $this->model_student_class->student_id = $this->model_student->id;
                    $this->model_student_class->class_id = $this->request->post['class'];

                    $index_no = $this->model_student_class->select('index_no')->where('class_id', '=' , $this->request->post['class'])->orderBy('index_no', 'DESC')->take(1)->first();
                    
                    if ( $index_no !== NULL ):
                        $index_no = $index_no->index_no + 1;
                        $this->model_student_class->index_no = $index_no;
                    else:
                        $this->model_student_class->index_no = 1;
                    endif;

                    // CHECK : STUDENT HAS CLASS QUERY
                    if ( $this->model_student_class->save() ):
                        echo json_encode( array( "status" => "success" ), JSON_PRETTY_PRINT );
                    else:
                        echo json_encode( array( "status" => "failed" ), JSON_PRETTY_PRINT );
                    endif;

                else:
                    echo json_encode( array( "status" => "failed" ), JSON_PRETTY_PRINT );
                endif;

            else:
                echo json_encode( array( "status" => "failed" ), JSON_PRETTY_PRINT );
            endif;

        endif;
    }

    public function profile($student_id) {

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
        $this->load->model('user');
        $this->load->model('user/role');

        // QUERY ( USER ROLES )
        foreach( $this->model_user_role->get() as $key => $element ):
            $data['user']['roles'][$key]['id'] = $element->id;
            $data['user']['roles'][$key]['name'] = $element->name;
        endforeach;

        // USER THEMES
        $data['user']['themes'][1]['name'] = 'Default';
        $data['user']['themes'][2]['name'] = 'Dark';

        // CHECK EXISTING STUDENT
        $student = $this->model_student->where('id', '=', $student_id)->first();

        // VIEW ERROR IF NO STUDENT EXIST
        if ( $student == null ){
            return http_response_code(404);
        }

        // BIO DATA
        $data['student'] = $student;

        $class_data = DB::table('student')
        ->join('class', 'student.class_id', 'class.id')
        ->join('grade', 'class.grade_id', 'grade.id')
        ->join('religion', 'student.religion_id', 'religion.id')
        ->where('student.id', '=', $student->id)
        ->select('class.name as class_name', 'grade.name as grade_name', 'religion.name as religion')
        ->first();
        $data['grade']['name'] = $class_data->grade_name;
        $data['class']['letter'] = $class_data->class_name;
        $data['class']['name'] = $class_data->grade_name . " - " . $class_data->class_name;
        $data['religion']['name'] = $class_data->religion;

        // PRENT
        $parents = $this->model_student_parent->select('parent_id','relation_id')->where('student_id', '=', $student_id)->get();
        if ( $parents !== null ):
            foreach( $parents as $key => $el ):
                $data['parents'][$key] = $this->model_parent->find($el->parent_id);
                $data['parents'][$key]['relation'] = $this->model_student_relation->where('id', '=', $el->relation_id)->first();
                unset($el);
            endforeach;
        endif;

        // SETTINGS DATA
        $settings_data = $this->model_user->select('role_id', 'theme')->where('ref_id', '=', $student_id)->where('user_type', '=', "student")->first();
        if ( $settings_data !== NULL):
            $data['settings']['user_role']['id'] = $settings_data->role_id;
            $data['settings']['user_role']['name'] = $this->model_user_role->where('id', '=', $settings_data->role_id)->first()->name;
            $data['settings']['theme'] = $settings_data->theme;
        endif;

        // RENDER VIEW
        $this->load->view('student/profile', $data);
    }
    
}
?>