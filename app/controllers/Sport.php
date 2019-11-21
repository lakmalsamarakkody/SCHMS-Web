<?php

use Illuminate\Database\Capsule\Manager as DB;

class Sport extends Controller {
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

        // MODEL
        $this->load->model('sport');
        $this->load->model('coach');
        $this->load->model('student/sport');
        $this->load->model('student/sportAchievement');

        // SPORT CARD
        $data['sport']['total']['all'] = $this->model_sport->select('id')->count();

        // COACH CARD
        $data['coach']['total']['all'] = $this->model_coach->select('id')->count();
        $data['coach']['total']['male'] = $this->model_coach->select('id')->where('gender', '=', 'male')->count();
        $data['coach']['total']['female'] = $this->model_coach->select('id')->where('gender', '=', 'female')->count();

        // SPORT STUDENT CARD
        $data['sport']['student']['total']['all'] = $this->model_student_sport->distinct()->get('student_id')->count();

        $data['sport']['student']['total']['male'] = DB::table('student_has_sport')
		->join('student', 'student_has_sport.student_id', '=', 'student.id')
		->select('student.id')
        ->where('gender', '=', 'male')
        ->distinct()
        ->get('student.id')
        ->count();
        
        $data['sport']['student']['total']['female'] = DB::table('student_has_sport')
		->join('student', 'student_has_sport.student_id', '=', 'student.id')
		->select('student.id')
        ->where('gender', '=', 'female')
        ->distinct()
        ->get('student.id')
        ->count();

        // STUDENT SPORT ACHIEVEMENTS CARD
        $data['sport']['student']['achievement']['all'] = $this->model_student_sportachievement->select('id')->count();

        $data['sport']['student']['achievement']['male'] = DB::table('student_has_sport_achievement')
        ->join('student_has_sport', 'student_has_sport_achievement.student_sport_id', '=', 'student_has_sport.id')
        ->join('student', 'student_has_sport.student_id', '=', 'student.id')
		->select('student.id')
        ->where('gender', '=', 'male')
        ->distinct()
        ->get('student.id')
        ->count();

        $data['sport']['student']['achievement']['female'] = DB::table('student_has_sport_achievement')
        ->join('student_has_sport', 'student_has_sport_achievement.student_sport_id', '=', 'student_has_sport.id')
        ->join('student', 'student_has_sport.student_id', '=', 'student.id')
		->select('student.id')
        ->where('gender', '=', 'female')
        ->distinct()
        ->get('student.id')
        ->count();

        // LATEST ACHIEVEMENT
        $data['sport']['student']['latest']['achievement'] = $this->model_student_sportachievement->select('*')->orderBy('id', 'DESC')->first(1);
        // $data['sport']['student']['latest']['achievement']['description'] = 
        

		// RENDER VIEW
        $this->load->view('sport/index', $data);
        
    }

    public function search_student() {
    
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
        $this->load->model('sport');
        $this->load->model('student');
        $this->load->model('student/sport');

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

        // SPORT
		foreach( $this->model_sport->select('id', 'name')->orderBy('id')->get() as $key => $element ):
			$data['sports'][$key]['id'] = $element->id;
			$data['sports'][$key]['name']= $element->name;
        endforeach;

        // SEARCH STUDENT
        if( isset( $this->request->post['isSubmitedStudent']) ):
            
            // PERSIST DATA
            $data['form']['field']['student_name'] = ( isset($this->request->post['student_name']) AND !empty($this->request->post['student_name']) ) ? $this->request->post['student_name'] : "";
            $data['form']['field']['student_class'] = ( isset($this->request->post['student_class']) AND !empty($this->request->post['student_class']) ) ? $this->request->post['student_class'] : "";
            $data['form']['field']['student_grade'] = ( isset($this->request->post['student_grade']) AND !empty($this->request->post['student_grade']) ) ? $this->request->post['student_grade'] : "";
            $data['form']['field']['student_gender'] = ( isset($this->request->post['student_gender']) AND !empty($this->request->post['student_gender']) ) ? $this->request->post['student_gender'] : "";
            $data['form']['field']['student_sport'] = ( isset($this->request->post['student_sport']) AND !empty($this->request->post['student_sport']) ) ? $this->request->post['student_sport'] : "";

            // Eloquent OBJECT
            $student = $this->model_student->select('id', 'admission_no', 'admission_date', 'class_id', 'full_name', 'initials', 'surname', 'dob', 'gender', 'email', 'phone_mobile', 'address', 'city', 'district_id', 'religion_id');

            // FILTER ( NAME )
            if ( isset($this->request->post['student_name']) AND !empty($this->request->post['student_name']) ):
                $student->where(function($query) {
                    $query->where('full_name', 'LIKE', '%'.$this->request->post['student_name'].'%');
                });
            endif;

            // FILTER ( CLASS )
            if ( isset($this->request->post['student_class']) AND !empty($this->request->post['student_class']) ):
                $student->where(function($query) {
                    $query->where('class_id', '=', $this->request->post['student_class']);
                });
            endif;

            // FILTER ( GRADE )
            if ( isset($this->request->post['student_grade']) AND !empty($this->request->post['student_grade']) ):
                $class = $this->model_class->select('id')->where('grade_id', '=', $this->request->post['student_grade'])->get();
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
            if ( isset($this->request->post['student_gender']) AND !empty($this->request->post['student_gender']) ):
                $student->where(function($query) {
                    $query->where('gender', '=', $this->request->post['student_gender']);
                });
            endif;

            // FILTER (SPORT)
            if ( isset($this->request->post['student_sport']) AND !empty($this->request->post['student_sport']) ):
                $student_sport = $this->model_student_sport->select('student_id')->whereIn('sport_id', $this->request->post['student_sport'])->get();
                $student_ids = array();
                foreach( $student_sport as $el ):
                    array_push($student_ids, $el->student_id);
                endforeach;

                $student->where(function($query) use ($student_ids) {
                    $query->whereIn('id', $student_ids);
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
        $this->load->view('sport/search_student', $data);
        
    }

    public function search_coach() {
    
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
        $this->load->model('sport');
        $this->load->model('coach');
        $this->load->model('coach/sport');

        // SPORT
		foreach( $this->model_sport->select('id', 'name')->orderBy('id')->get() as $key => $element ):
			$data['sports'][$key]['id'] = $element->id;
			$data['sports'][$key]['name']= $element->name;
        endforeach;

        // SEARCH COACH
        if( isset( $this->request->post['isSubmitedCoach']) ):

            // PERSIST DATA
            $data['form']['field']['coach_name'] = ( isset($this->request->post['coach_name']) AND !empty($this->request->post['coach_name']) ) ? $this->request->post['coach_name'] : "";
            $data['form']['field']['coach_sport'] = ( isset($this->request->post['coach_sport']) AND !empty($this->request->post['coach_sport']) ) ? $this->request->post['coach_sport'] : "";
            $data['form']['field']['no_of_sports'] = ( isset($this->request->post['no_of_sports']) AND !empty($this->request->post['no_of_sports']) ) ? $this->request->post['no_of_sports'] : "";
            
            // Eloquent OBJECT
            $coach = $this->model_coach->select('id')->orderBy('id');

            // FILTER ( NAME )
            if ( isset($this->request->post['coach_name']) AND !empty($this->request->post['coach_name']) ):
                $coach->where(function($query) {
                    $query->where('full_name', 'LIKE', '%'.$this->request->post['coach_name'].'%');
                });
            endif;

            // FILTER (SPORT)
            if ( isset($this->request->post['coach_sport']) AND !empty($this->request->post['coach_sport']) ):
                
                $coach_ids = $this->model_coach_sport->select('coach_id')->where('sport_id','=', $this->request->post['coach_sport'])->get();
                if ( $coach_ids != NULL):
                    $coaches = array();
                    foreach ( $coach_ids as $key => $element ):
                        array_push($coaches,$element->coach_id);
                    endforeach;
                    $coach->where(function($query) use ($coaches) {
                        $query->whereIn('id', $coaches);
                    });
                endif;
            endif;

            // FILTER ( NO OF STUDENTS )
            $coachs = array();
            if ( isset($this->request->post['no_of_sports']) AND !empty($this->request->post['no_of_sports']) ):

                $coach = $coach->get();

                $coach_data = array();
                foreach ( $coach as $key => $el ):
                    $coach_data[$el->id]['id'] = $el->id;
                    $coach_data[$el->id]['count'] = $this->model_coach_sport->where('coach_id', '=', $el->id)->count();
                endforeach;

                // if (  ):
                // endif;
                foreach( $coach_data as $k => $e ):
                    if ( $this->request->post['no_of_sports'] == 1 ):
                        if ( $e['count'] == 1 ):
                            array_push($coachs, $e['id']);
                        endif;
                    elseif ( $this->request->post['no_of_sports'] == 'many' ):
                        if ( $e['count'] >= 2 ):
                            array_push($coachs, $e['id']);
                        endif;
                    endif;
                endforeach;

            else:
                foreach( $coach->get() as $key => $el ):
                    array_push($coachs, $el->id);
                endforeach;
            endif;

            $coach_data = $this->model_coach->select('id', 'full_name', 'initials', 'surname', 'nic', 'dob', 'gender', 'email', 'phone_home', 'phone_mobile', 'address', 'city')->whereIn('id', $coachs);

            // APPEND DATA TO ARRAY
            foreach( $coach_data->get() as $key => $value ):
                $data['coaches'][$key]['id'] = $value->id;
                $data['coaches'][$key]['coach_full_name'] = $value->full_name;
                $data['coaches'][$key]['coach_initials'] = $value->initials;
                $data['coaches'][$key]['coach_surname'] = $value->surname;
                $data['coaches'][$key]['nic'] = $value->nic;
                $data['coaches'][$key]['dob'] = $value->dob;
                $data['coaches'][$key]['gender'] = $value->gender;
                $data['coaches'][$key]['email'] = $value->email;
                $data['coaches'][$key]['phone_home'] = $value->phone_home;
                $data['coaches'][$key]['phone_mobile'] = $value->phone_mobile;
                $data['coaches'][$key]['address'] = $value->address;
                $data['coaches'][$key]['city'] = $value->city;
            endforeach;

        endif;

		// RENDER VIEW
        $this->load->view('sport/search_coach', $data);
    }

    public function assign() {
    
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
        $this->load->model('sport');

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

        //SPORT
        foreach( $this->model_sport->select('id', 'name')->orderBy('name')->get() as $key => $element ):
            $data['student_sport'][$key]['id'] = $element->id;
            $data['student_sport'][$key]['name'] = $element->name;
        endforeach;

        // CHECK SUBMIT
        if ( isset($this->request->post['isSubmited']) ):

            $data['form']['field']['addno'] = ( isset($this->request->post['addno']) AND !empty($this->request->post['addno']) ) ? $this->request->post['addno'] : "";
            $data['form']['field']['adddate'] = ( isset($this->request->post['adddate']) AND !empty($this->request->post['adddate']) ) ? $this->request->post['adddate'] : "";
            $data['form']['field']['dob'] = ( isset($this->request->post['dob']) AND !empty($this->request->post['dob']) ) ? $this->request->post['dob'] : "";
            $data['form']['field']['name'] = ( isset($this->request->post['name']) AND !empty($this->request->post['name']) ) ? $this->request->post['name'] : "";
            $data['form']['field']['class'] = ( isset($this->request->post['class']) AND !empty($this->request->post['class']) ) ? $this->request->post['class'] : "";
            $data['form']['field']['grade'] = ( isset($this->request->post['grade']) AND !empty($this->request->post['grade']) ) ? $this->request->post['grade'] : "";
            $data['form']['field']['gender'] = ( isset($this->request->post['gender']) AND !empty($this->request->post['gender']) ) ? $this->request->post['gender'] : "";
            $data['form']['field']['city'] = ( isset($this->request->post['city']) AND !empty($this->request->post['city']) ) ? $this->request->post['city'] : "";

            // Eloquent OBJECT
            $student = $this->model_student->select('id', 'admission_no', 'admission_date', 'class_id', 'full_name', 'initials', 'surname', 'dob', 'gender', 'email', 'phone_mobile', 'address', 'city');

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

            // APPEND DATA TO ARRAY
            foreach( $student->get() as $key => $value ):

                $student_data = DB::table('student')
                    ->join('student_has_class', 'student.id', '=', 'student_has_class.student_id')
                    ->join('class', 'student_has_class.class_id', '=', 'class.id')
                    ->join('grade', 'class.grade_id', '=', 'grade.id')
                    ->select('student_has_class.index_no', 'student_has_class.class_id', 'class.name', 'grade.name')
                    ->where('student.id', '=', $value->id)->first();

                $data['students'][$key]['id'] = $value->id;
                $data['students'][$key]['admission_no'] = $value->admission_no;
                $data['students'][$key]['class'] = $student_data->name;
                $data['students'][$key]['index'] = $student_data->index_no;
                $data['students'][$key]['name'] = $value->initials." ".$value->surname;
                $data['students'][$key]['gender'] = $value->gender;
                $data['students'][$key]['dob'] = $value->dob;
                $data['students'][$key]['city'] = $value->city;
            endforeach;

        endif;

		// RENDER VIEW
        $this->load->view('sport/assign', $data);
        
    }

    public function add_coach() {
    
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
        $this->load->model('sport');
        $this->load->model('district');

        // SPORT
		foreach( $this->model_sport->select('id', 'name')->orderBy('id')->get() as $key => $element ):
			$data['sports'][$key]['id'] = $element->id;
			$data['sports'][$key]['name']= $element->name;
        endforeach;
        
        //DISTRICT
        foreach( $this->model_district->select('id', 'province_id', 'name')->orderBy('name')->get() as $key => $element ):
            $data['student_district'][$key]['id'] = $element->id;
            $data['student_district'][$key]['province']['id'] = $element->province_id;
            $data['student_district'][$key]['name'] = $element->name;
        endforeach;

		// RENDER VIEW
        $this->load->view('sport/add_coach', $data);
        
    }

    public function ajax_addcoach() {

        /**
         * This method will receive ajax request from
         * the front end with the payload
         * 
         *   COACH DATA
         *   sport_ids
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
        **/

        // SET JSON HEADER
        header('Content-Type: application/json');

        //MODEL
        $this->load->model('coach');
        $this->load->model('coach/sport');
        $this->load->model('sport');

        // VALIDATION : COACH
        // VALIDATION : full_name
        $is_valid_full_name = GUMP::is_valid($this->request->post, array('full_name' => 'required|valid_name|max_len,100'));
        if ( $is_valid_full_name !== true ):
            echo json_encode( array( "error" => "Please enter coach full name" ), JSON_PRETTY_PRINT );
            exit();
        endif;

        // VALIDATION : SPORT IDS
        if ( $this->request->post['coach_sports'] !== "null"):

            $this->request->post['coach_sports'] = explode(",", $this->request->post['coach_sports']);
            foreach ( $this->request->post['coach_sports'] as $key => $el ):
                // GUMP VALIDATION
                $is_valid_sport = GUMP::is_valid(array( 0 => $el ), array('0' => 'numeric|min_len,1|max_len,3'));
                if ( $is_valid_sport !== true ):
                    echo json_encode( array( "error" => "Invalid Sports Selected" ), JSON_PRETTY_PRINT );
                    exit();
                endif;

                // DB VALIDATION : VALID SPORTS
                $is_exist = $this->model_sport->select('id')->where('id', '=', $el)->first();
                if ( $is_exist === NULL ):
                    echo json_encode( array( "error" => "Selected sport is not in the system" ), JSON_PRETTY_PRINT );
                    exit();
                endif;
            endforeach;
        else:
            echo json_encode( array( "error" => "Select one or more Sports" ), JSON_PRETTY_PRINT );
            exit();
        endif;

        // VALIDATION : initials
        $is_valid_initials = GUMP::is_valid($this->request->post, array('initials' => 'required|alpha_space|max_len,20'));
        if ( $is_valid_initials !== true ):
            echo json_encode( array( "error" => "Please enter coach initials" ), JSON_PRETTY_PRINT );
            exit();
        endif;

        // VALIDATION : surname
        $is_valid_surname = GUMP::is_valid($this->request->post, array('surname' => 'required|valid_name|max_len,30'));
        if ( $is_valid_surname !== true ):
            echo json_encode( array( "error" => "Please enter a valid surname" ), JSON_PRETTY_PRINT );
            exit();
        endif;

        // VALIDATION : NIC
        $is_valid_nic = GUMP::is_valid($this->request->post, array('nic' => "required"));
        if ( $is_valid_nic === true ):
            if ( preg_match("/^([0-9]{9}[x|X|v|V]|[0-9]{12})$/", $this->request->post['nic']) == false ):
                echo json_encode( array( "error" => "Wrong NIC Format" ), JSON_PRETTY_PRINT );
                exit();
            endif;
        else:
            echo json_encode( array( "error" => "Please enter a valid NIC number" ), JSON_PRETTY_PRINT );
            exit();
        endif;

            // VALIDATION : DUPLICATE NIC
            $is_duplicate = $this->model_coach->select('id')->where('nic', '=', $this->request->post['nic'])->first();
            if ( $is_duplicate !== NULL ):
                echo json_encode( array( "error" => "This NIC number is already in use" ), JSON_PRETTY_PRINT );
                exit();
            endif;

        // VALIDATION : date_of_birth
        $is_valid_date_of_birth = GUMP::is_valid($this->request->post, array('date_of_birth' => 'required|date'));
        if ( $is_valid_date_of_birth !== true ):
            echo json_encode( array( "error" => "Please enter coach Date of Birth" ), JSON_PRETTY_PRINT );
            exit();
        endif;

        // VALIDATION : gender
        $is_valid_gender = GUMP::is_valid($this->request->post, array('gender' => 'required|contains_list,male;female'));
        if ( $is_valid_gender !== true ):
            echo json_encode( array( "error" => "Please select a gender" ), JSON_PRETTY_PRINT );
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
                if ( $this->model_coach->select('id')->where('email', '=', $this->request->post['email'])->first() != NULL ):
                    echo json_encode( array( "error" => "This Email is already present" ), JSON_PRETTY_PRINT );
                    exit();
                endif;
            endif;

        // VALIDATION : phone_number
        $is_valid_phone_number = GUMP::is_valid($this->request->post, array('phone_number' => 'numeric|exact_len,10'));
        if ( $is_valid_phone_number !== true ):
            echo json_encode( array( "error" => "Please enter a valid 10 digit phone number" ), JSON_PRETTY_PRINT );
            exit();
        endif;

        // VALIDATION : mobile_number
        $is_valid_mobile_number = GUMP::is_valid($this->request->post, array('mobile_number' => 'numeric|exact_len,10'));
        if ( $is_valid_mobile_number !== true ):
            echo json_encode( array( "error" => "Please enter a valid 10 digit mobile number" ), JSON_PRETTY_PRINT );
            exit();
        endif;

        // VALIDATION : address
        $is_valid_address = GUMP::is_valid($this->request->post, array('address' => 'required|street_address|max_len,50'));
        if ( $is_valid_address !== true ):
            echo json_encode( array( "error" => "Please enter a valid address" ), JSON_PRETTY_PRINT );
            exit();
        endif;

        // VALIDATION : city
        $is_valid_city = GUMP::is_valid($this->request->post, array('city' => 'required|alpha|max_len,20'));
        if ( $is_valid_city !== true ):
            echo json_encode( array( "error" => "Please enter a valid city name" ), JSON_PRETTY_PRINT );
            exit();
        endif;

        // VALIDATION : district
        $is_valid_district = GUMP::is_valid($this->request->post, array('district' => 'numeric|max_len,2'));
        if ( $is_valid_district !== true AND $this->request->post['district'] != "null" ):
            echo json_encode( array( "error" => "Invalid district name" ), JSON_PRETTY_PRINT );
            exit();
        endif;

        $this->model_coach->full_name = $this->request->post['full_name'];
        $this->model_coach->initials = $this->request->post['initials'];
        $this->model_coach->surname = $this->request->post['surname'];
        $this->model_coach->nic = $this->request->post['nic'];
        $this->model_coach->dob = $this->request->post['date_of_birth'];
        $this->model_coach->gender = $this->request->post['gender'];
        $this->model_coach->email = ( $this->request->post['email'] == "" ) ? null : $this->request->post['email'];
        $this->model_coach->phone_home = ( $this->request->post['phone_number'] == "" ) ? null : $this->request->post['phone_number'];
        $this->model_coach->phone_mobile = ( $this->request->post['mobile_number'] == "" ) ? null : $this->request->post['mobile_number'];
        $this->model_coach->address = $this->request->post['address'];
        $this->model_coach->city = $this->request->post['city'];
        $this->model_coach->district_id = ( $this->request->post['district'] == "" ) ? null : $this->request->post['district'];

        // CREATE COACH RECORD
        if ( $this->model_coach->save() ):

            // SELECT ALL SPORT IDS
            foreach ( $this->request->post['coach_sports'] as $key => $element ):

                try{
                    // CREATE COACH HAS SPORT RECORD
                    $this->model_coach_sport->create([
                        'coach_id' => $this->model_coach->id,
                        'sport_id' => $element
                    ]);
                }catch (Exception $e){
                    echo json_encode( array( "status" => "failed" ), JSON_PRETTY_PRINT );
                    exit();
                }
            endforeach;

            echo json_encode( array( "status" => "success" ), JSON_PRETTY_PRINT );
            exit();
        else:
            echo json_encode( array( "status" => "failed" ), JSON_PRETTY_PRINT );
            exit();
        endif;

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
}
?>