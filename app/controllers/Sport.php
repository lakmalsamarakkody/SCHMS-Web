<?php

use Carbon\Carbon;
use Illuminate\Database\Capsule\Manager as DB;

class Sport extends Controller {
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
        $this->load->model('sport');
        $this->load->model('coach');
        $this->load->model('student/sport');
        $this->load->model('student/sportAchievement');
        $this->load->model('user');

        // CHECK PERMISSION : index
        if ( $this->model_user->find($_SESSION['user']['id'])->hasPermission('sport-index-view') ):
            $data['permission']['sport']['index']['view'] = true;
        else:
            $data['permission']['sport']['index']['view'] = false;
        endif;

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
        $data['sport']['student']['latest']['achievement'] = $this->model_student_sportachievement->select('*')->orderBy('achieved_on', 'DESC')->first(1);

        // APEX CHARTS
        foreach ( $this->model_student_sport->select('id', 'student_id', 'sport_id')->groupBy('sport_id')->get() as $key => $element ):
            $data['sports'][$key]['name'] = $this->model_sport->select('name')->where('id', '=', $element->sport_id)->first()->name;
            $data['sports'][$key]['count'] = $this->model_student_sport->select('student_id')->where('sport_id', '=', $element->sport_id)->count();
        endforeach;
        

		// RENDER VIEW
        $this->load->view('sport/index', $data);
        
    }

    public function search_student() {

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
        $this->load->model('sport');
        $this->load->model('student');
        $this->load->model('student/class');
        $this->load->model('student/sport');
        $this->load->model('user');

        // CHECK PERMISSION : search_student
        if ( $this->model_user->find($_SESSION['user']['id'])->hasPermission('sport-search_student-view') ):
            $data['permission']['sport']['search_student']['view'] = true;
        else:
            $data['permission']['sport']['search_student']['view'] = false;
        endif;

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
                $data['students'][$key]['name'] = $value->initials." ". $value->surname;
                $data['students'][$key]['gender'] = $value->gender;
                $data['students'][$key]['dob'] = $value->dob;
                $data['students'][$key]['class']['id'] = $value->class_id;
                $data['students'][$key]['index'] = $this->model_student_class->select('index_no')->where('student_id', '=', $value->id)->where('class_id', '=', $value->class_id)->first()->index_no;
                $data['students'][$key]['city'] = $value->city;

                // QUERY CLASS DATA
                $class = $this->model_class->where('id', '=', $value->class_id)->first();
                $grade = $this->model_grade->where('id', '=', $class->grade_id)->first();
                $data['students'][$key]['class']['name'] = $grade->name." - ".$class->name;

                // SPORTS ENGAGED BY STUDENT
                foreach ( $this->model_student_sport->where('student_id', '=', $value->id)->get() as $key2 => $element ):
                    $data['students'][$key]['sport'][$key2]['id'] = $element->sport_id;
                    $data['students'][$key]['sport'][$key2]['name'] = $this->model_sport->select('name')->where('id', '=', $element->sport_id)->first()->name;
                endforeach;
            endforeach;

        endif;

		// RENDER VIEW
        $this->load->view('sport/search_student', $data);
        
    }

    public function ajax_removestudentsport() {

        //CHECK LOGIN STATUS
		if( !isset($_SESSION['user']) OR $_SESSION['user']['is_login'] != true ):
			header( 'Location:' . $this->config->get('base_url') . '/logout' );
			exit();
        endif;
        
        // SET JSON HEADER
		header('Content-Type: application/json');

        // MODEL
        $this->load->model('student/sport');
        $this->load->model('student');

        // VALIDATION : student_id
        $is_valid_student_id = GUMP::is_valid($this->request->post, array('student_id' => 'required|numeric|max_len,6'));
        if ( $is_valid_student_id !== true ):
            echo json_encode( array( "status" => "failed", "message" => "Please select a valid student" ), JSON_PRETTY_PRINT );
            exit();
        endif;

        // IS EXIST : student_id
        $is_exist_student_id = $this->model_student->where('id', '=', $this->request->post['student_id'])->first();
        if ( $is_exist_student_id == NULL ):
            echo json_encode( array( "status" => "failed", "message" => "Please select a valid student" ), JSON_PRETTY_PRINT );
            exit();
        endif;

        // REMOVE CURRENT RECORDS
		if ( $this->model_student_sport->where('student_id', '=', $this->request->post['student_id'])->delete() ):
			echo json_encode( array( "status" => "success" ), JSON_PRETTY_PRINT );
		else:
			echo json_encode( array( "status" => "failed", "message" => "Deletion failed. Please contact your System Administrator" ), JSON_PRETTY_PRINT );
		endif;

    }

    public function search_coach() {

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
        $this->load->model('sport');
        $this->load->model('coach');
        $this->load->model('coach/sport');
        $this->load->model('user');

        // CHECK PERMISSION : search_coach
        if ( $this->model_user->find($_SESSION['user']['id'])->hasPermission('sport-search_coach-view') ):
            $data['permission']['sport']['search_coach']['view'] = true;
        else:
            $data['permission']['sport']['search_coach']['view'] = false;
        endif;

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
                
                $sport_id = $this->model_coach_sport->select('sport_id')->where('coach_id', '=', $value->id)->first()->sport_id;
                $data['coaches'][$key]['sport'] = $this->model_sport->select('name')->where('id', '=', $sport_id)->first()->name;
            endforeach;

        endif;

		// RENDER VIEW
        $this->load->view('sport/search_coach', $data);
    }

    public function assign() {

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
        $this->load->model('sport');
        $this->load->model('user');

        // CHECK PERMISSION : assign
        if ( $this->model_user->find($_SESSION['user']['id'])->hasPermission('sport-assign-view') ):
            $data['permission']['sport']['assign']['view'] = true;
        else:
            $data['permission']['sport']['assign']['view'] = false;
        endif;

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

            // APPEND DATA TO ARRAY
            foreach( $student->get() as $key => $value ):

                $student_data = DB::table('student')
                    ->join('student_has_class', 'student.id', '=', 'student_has_class.student_id')
                    ->join('class', 'student_has_class.class_id', '=', 'class.id')
                    ->join('grade', 'class.grade_id', '=', 'grade.id')
                    ->select('student_has_class.index_no', 'student_has_class.class_id', 'class.name', 'grade.name')
                    ->where('student.id', '=', $value->id)->first();

                foreach ( $this->model_student_sport->where('student_id', '=', $value->id)->get() as $key2 => $el ):
                    $data['students'][$key]['sport'][$key2] = $el->sport_id;
                endforeach;

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

    public function ajax_assign_sport() {

        // SET JSON HEADER
		header('Content-Type: application/json');

        //CHECK LOGIN STATUS
		if( !isset($_SESSION['user']) OR $_SESSION['user']['is_login'] != true ):
			header( 'Location:' . $this->config->get('base_url') . '/logout' );
			exit();
        endif;

        // MODEL
        $this->load->model('student');
        $this->load->model('sport');
        $this->load->model('student/sport');
        $this->load->model('notification');
        $this->load->model('user');

        // VALIDATION : student_id
        $is_valid_student_id = GUMP::is_valid($this->request->post, array('student_id' => 'required|numeric|max_len,6'));
        if ( $is_valid_student_id !== true ):
            echo json_encode( array( "status" => "failed", "message" => "Please select a valid student" ), JSON_PRETTY_PRINT );
            exit();
        endif;

        // IS EXIST : student_id
        $is_exist_student_id = $this->model_student->where('id', '=', $this->request->post['student_id'])->first();
        if ( $is_exist_student_id == NULL ):
            echo json_encode( array( "status" => "failed", "message" => "Please select a valid student" ), JSON_PRETTY_PRINT );
            exit();
        endif;

        // REMOVE CURRENT RECORDS
        if ( $this->model_student_sport->where('student_id', '=', $this->request->post['student_id'])->first() !== NULL ):
            if ($this->model_student_sport->where('student_id', '=', $this->request->post['student_id'])->delete() == FALSE ):
                echo json_encode( array( "status" => "failed", "message" => "Couldn't Assign Sports. Please contact your System Administrator" ), JSON_PRETTY_PRINT );
                exit();
            endif;
        endif;

        // SEPERATE DATA BY COMMAS TO ARRAY
        $sports = explode(",", $this->request->post['sports']);

        foreach( $sports as $key => $element ):

            try{
                // CHECK IS SPORT EXISTS
                $is_exist_sport = $this->model_sport->where('id', '=', $element)->first();
                if ( $is_exist_sport !== NULL ):
                    // CREATE STUDENT HAS SPORT RECORD
                    $this->model_student_sport->create([
                        'student_id' => $this->request->post['student_id'],
                        'sport_id' => $element
                    ]);

                    // CHECK AVAILABLE USER
                    $available_user = $this->model_user->select('id')->where('ref_id', '=', $this->request->post['student_id'])->where('user_type', '=', 'student')->first();
                    if ( $available_user != NULL ):
                        // INITIATE : NOTIFICATION
                        $this->model_notification->sender_id = $_SESSION['user']['id'];
                        $this->model_notification->receiver_id = $available_user->id;
                        $this->model_notification->title = "Sports List Updated";
                        $this->model_notification->body = "Your engaged sport list has been updated";
                        $this->model_notification->save();
                    endif;
                else:
                    echo json_encode( array( "status" => "success" ), JSON_PRETTY_PRINT );
                    exit();
                endif;
            }catch (Exception $e){
                echo json_encode( array( "status" => "failed" , "message" => "Sport assign process failed. Please contact your System Administrator" ), JSON_PRETTY_PRINT );
                exit();
            }

        endforeach;
        echo json_encode( array("status" => "success"), JSON_PRETTY_PRINT );
        exit();
    }

    public function add_coach() {

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
        $this->load->model('sport');
        $this->load->model('district');
        $this->load->model('user');

        // CHECK PERMISSION : add_coach
        if ( $this->model_user->find($_SESSION['user']['id'])->hasPermission('sport-add_coach-view') ):
            $data['permission']['sport']['add_coach']['view'] = true;
        else:
            $data['permission']['sport']['add_coach']['view'] = false;
        endif;

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

        //CHECK LOGIN STATUS
		if( !isset($_SESSION['user']) OR $_SESSION['user']['is_login'] != true ):
			header( 'Location:' . $this->config->get('base_url') . '/logout' );
			exit();
		endif;

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

        // VALIDATION : full_name
        $is_valid_full_name = GUMP::is_valid($this->request->post, array('full_name' => 'required|valid_name|max_len,100'));
        if ( $is_valid_full_name !== true ):
            echo json_encode( array( "error" => "Please enter coach full name" ), JSON_PRETTY_PRINT );
            exit();
        endif;

        // VALIDATION : admission_date
        $is_valid_admission_date = GUMP::is_valid($this->request->post, array('admission_date' => 'date'));
        if ( $is_valid_admission_date !== true AND $this->request->post['admission_date'] != "" ):
            echo json_encode( array( "error" => "Invalid admission date" ), JSON_PRETTY_PRINT );
            exit();
        endif;
        // SET CURRENT DATE IF ADMISSION DATE NOT INSERTED
        if ( $this->request->post['admission_date'] == "" ):
            $this->request->post['admission_date'] = Carbon::now()->isoFormat('YYYY-MM-DD');
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
        
        $this->model_coach->admission_date = $this->request->post['admission_date'];
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

    public function profile_coach($coach_id) {

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
        $this->load->model('coach');
        $this->load->model('coach/sport');
        $this->load->model('sport');
        $this->load->model('district');
        $this->load->model('user');
        $this->load->model('user/role');

        // CHECK PERMISSION : profile_coach
        if ( $this->model_user->find($_SESSION['user']['id'])->hasPermission('sport-profile_coach-view') ):
            $data['permission']['sport']['profile_coach']['view'] = true;
        else:
            $data['permission']['sport']['profile_coach']['view'] = false;
        endif;

        // PROFILE PICTURE UPLOAD
        if ( isset($_FILES['propic']) && $_FILES["propic"]["error"] == 0 ):

            // CHECK SIZE
            $size_mb = $_FILES['propic']['size'] / 1048576;

            // CHECK PERMISSION : propic
            if ( $this->model_user->find($_SESSION['user']['id'])->hasPermission('coach-profile-edit-propic') ):
                $data['permission']['coach']['profile']['edit']['propic'] = true;
                // SAVE
                if ( $size_mb < 1 AND $_FILES['propic']['type'] == 'image/jpeg' OR $_FILES['propic']['type'] == 'image/jpg' ):
                    move_uploaded_file($_FILES['propic']['tmp_name'], ABS_PATH.'/data/uploads/propics/coach/'.$this->request->post['coach_id'].'.jpg');
                else:
                    $data['propic']['upload']['failed']['status'] = true;
                    $data['propic']['upload']['failed']['message'] = "Profile picture upload failed. Image should less than 1MB and in JPG/JPEG format";
                endif;
            else:
                $data['permission']['coach']['profile']['edit']['propic'] = false;
                $data['propic']['upload']['failed']['status'] = true;
                $data['propic']['upload']['failed']['message'] = "You are not allowed to change profile picture";
            endif;
        endif;

        // SPORT
		foreach( $this->model_sport->select('id', 'name')->orderBy('id')->get() as $key => $element ):
			$data['sports'][$key]['id'] = $element->id;
			$data['sports'][$key]['name']= $element->name;
        endforeach;

        // QUERY ( DISTRICT )
        foreach( $this->model_district->select('id', 'name')->orderBy('name')->get() as $key => $element ):
            $data['districts'][$key]['id'] = $element->id;
            $data['districts'][$key]['name'] = $element->name;
        endforeach;

        // BIO DATA : SPORTS
        $sports = $this->model_coach_sport->select('sport_id')->where('coach_id', '=', $coach_id);
        $coach_sport_ids = array();
        foreach ( $sports->get() as $key => $element ):
            array_push($coach_sport_ids, $element->sport_id);
        endforeach;
        $data['coach_sports'] = $coach_sport_ids;

        // QUERY ( USER ROLES )
        foreach( $this->model_user_role->get() as $key => $element ):
            $data['user']['roles'][$key]['id'] = $element->id;
            $data['user']['roles'][$key]['name'] = $element->name;
        endforeach;

        // CHECK EXISTING STAFF
        $coach = $this->model_coach->where('id', '=', $coach_id)->first();

        // VIEW ERROR IF NO COACH EXIST
        if ( $coach == null ){
            return http_response_code(404);
        }

        // BIO DATA
        $data['coach'] = $coach;

        // SETTINGS DATA
        $settings_data = $this->model_user->where('ref_id', '=', $coach_id)->where('user_type', '=', "coach")->first();
        if ( $settings_data !== NULL):
            $data['settings']['user_role']['id'] = $settings_data->role_id;
            $data['settings']['user_role']['name'] = $this->model_user_role->where('id', '=', $settings_data->role_id)->first()->name;
            $data['settings']['username'] = $settings_data->username;
            ( $settings_data->password !== NULL ) ? $data['settings']['password'] = "Password exists" : $data['settings']['password'] = "No password";
            $data['settings']['theme'] = $settings_data->theme;
            $data['settings']['status'] = $settings_data->status;
        endif;

        // RENDER VIEW
        $this->load->view('sport/profile_coach', $data);
    }

    public function ajax_updatecoach(){

        // CHECK LOGIN STATUS
		if( !isset($_SESSION['user']) OR $_SESSION['user']['is_login'] != true ):
			header( 'Location:' . $this->config->get('base_url') . '/logout' );
			exit();
		endif;

		// SET JSON HEADER
        header('Content-Type: application/json');

        // MODEL
        $this->load->model('coach');
        $this->load->model('coach/sport');
        $this->load->model('sport');
        $this->load->model('user');
        $this->load->model('notification');

        if ( isset($this->request->post['coach_id']) AND !empty($this->request->post['coach_id']) ):
            $is_valid_coach_id = $this->model_coach->select('id')->where('id', '=', $this->request->post['coach_id']);

            if ( $is_valid_coach_id->first() !== NULL ):

                // IS CHANGED NIC
                $current_nic = $this->model_coach->select('nic')->where('id', '=', $this->request->post['coach_id'])->first();
                if ( $current_nic->nic != $this->request->post['nic']):
                    // NIC IS CHANGED : CHECK FOR DUPLICATE
                    if ( $this->model_coach->select('id')->where('nic', '=', $this->request->post['nic'])->first() != NULL ):
                        echo json_encode( array( "status" => "failed", "message" => "This NIC already exists" ), JSON_PRETTY_PRINT );
                        exit();
                    endif;
                endif;

                // IS CHANGED EMAIL
                $current_email = $this->model_coach->select('email')->where('id', '=', $this->request->post['coach_id'])->first();
                if ( $current_email->email != $this->request->post['email']):
                    // EMAIL IS CHANGED : CHECK FOR DUPLICATE
                    if ( $this->model_coach->select('id')->where('email', '=', $this->request->post['email'])->first() != NULL ):
                        echo json_encode( array( "status" => "failed", "message" => "This email already exists" ), JSON_PRETTY_PRINT );
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

                // VALIDATION : nic
                $is_valid_nic = GUMP::is_valid($this->request->post, array('nic' => "required"));
                if ( $is_valid_nic === true ):
                    if ( preg_match("/^([0-9]{9}[x|X|v|V]|[0-9]{12})$/", $this->request->post['nic']) == false ):
                        echo json_encode( array("status" => "failed", "error" => "Wrong NIC Format. Please enter a valid NIC" ), JSON_PRETTY_PRINT );
                        exit();
                    endif;
                else:
                    echo json_encode( array("status" => "failed", "error" => "Please enter a valid NIC number for guardian" ), JSON_PRETTY_PRINT );
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

                // VALIDATION : phone_mobile
                $is_valid_phone_mobile = GUMP::is_valid($this->request->post, array('phone_mobile' => 'numeric|exact_len,10'));
                if ( $is_valid_phone_mobile !== true ):
                    echo json_encode( array("status" => "failed", "message" => "Please enter a valid 10 digit mobile number" ), JSON_PRETTY_PRINT );
                    exit();
                endif;

                // VALIDATION : phone_home
                $is_valid_phone_home = GUMP::is_valid($this->request->post, array('phone_home' => 'numeric|exact_len,10'));
                if ( $is_valid_phone_home !== true ):
                    echo json_encode( array("status" => "failed", "message" => "Please enter a valid 10 digit landline number" ), JSON_PRETTY_PRINT );
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

                // VALIDATION : district
                $is_valid_district = GUMP::is_valid($this->request->post, array('district_id' => 'numeric|max_len,2'));
                if ( $is_valid_district !== true AND $this->request->post['district_id'] != "null" ):
                    echo json_encode( array("status" => "failed", "message" => "Invalid district" ), JSON_PRETTY_PRINT );
                    exit();
                endif;

                // VALIDATION : address
                $is_valid_address = GUMP::is_valid($this->request->post, array('address' => 'required|street_address|max_len,50'));
                if ( $is_valid_address !== true ):
                    echo json_encode( array("status" => "failed", "message" => "Please enter a valid address" ), JSON_PRETTY_PRINT );
                    exit();
                endif;

                // VALIDATION : admission_date
                $is_valid_admission_date = GUMP::is_valid($this->request->post, array('admission_date' => 'required|date'));
                if ( $is_valid_admission_date !== true ):
                    echo json_encode( array("status" => "failed", "message" => "Please select a valid admission date" ), JSON_PRETTY_PRINT );
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
                    echo json_encode( array("status" => "failed", "message" => "Password and confirm pssword doesn't match" ), JSON_PRETTY_PRINT );
                    exit();
                endif;

                // CHECK ANY USER AVAILABLE
                $is_available_user = $this->model_user->select('id')->where('user_type', '=', 'coach')->where('ref_id', '=', $this->request->post['coach_id']);
                if ( $is_available_user->first() != NULL):
                     // IS CHANGED USERNAME
                    $current_username = $this->model_user->select('username')->where('user_type', '=', 'coach')->where('ref_id', '=', $this->request->post['coach_id'])->first();
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
                    $this->model_coach->find($this->request->post['coach_id'])->update([

                        // UPDATE ACADEMIC
                        'admission_date' => $this->request->post['admission_date'],

                        // UPDATE BIO
                        'full_name' => $this->request->post['full_name'],
                        'initials' => $this->request->post['initials'],
                        'surname' => $this->request->post['surname'],
                        'nic' => $this->request->post['nic'],
                        'gender' => $this->request->post['gender'],
                        'dob' => $this->request->post['dob'],
                        'phone_mobile' => $this->request->post['phone_mobile'],
                        'phone_home' => $this->request->post['phone_home'],
                        'email' => $this->request->post['email'],
                        'city' => $this->request->post['city'],
                        'address' => $this->request->post['address'],
                        'district_id' => $this->request->post['district_id'],
                    ]);

                    // START : UPDATE COACH HAS SPORTS

                        // REMOVE CURRENT RECORDS
                        if ( $this->model_coach_sport->where('coach_id', '=', $this->request->post['coach_id'])->first() !== NULL ):
                            if ($this->model_coach_sport->where('coach_id', '=', $this->request->post['coach_id'])->delete() == FALSE ):
                                echo json_encode( array( "status" => "failed", "message" => "Couldn't Remove existing Sports. Please contact your System Administrator" ), JSON_PRETTY_PRINT );
                                exit();
                            endif;
                        endif;

                        // SEPERATE DATA BY COMMAS TO ARRAY
                        $sport_ids = explode(",", $this->request->post['sport_ids']);

                        // LOOP SPORT IDS
                        foreach( $sport_ids as $key => $element ):

                            // CHECK IS SPORT EXISTS
                            $is_exist_sport = $this->model_sport->where('id', '=', $element)->first();
                            if ( $is_exist_sport !== NULL ):

                                // CREATE COACH HAS SPORT RECORD
                                $this->model_coach_sport->create([
                                    'coach_id' => $this->request->post['coach_id'],
                                    'sport_id' => $element
                                ]);
                            endif;
                        endforeach;

                    // END : UPDATE COACH HAS SPORTS

                    // UPDATE SETTINGS IF AVAILABLE USER FOUND
                    $is_available_user = $this->model_user->select('id')->where('user_type', '=', 'coach')->where('ref_id', '=', $this->request->post['coach_id']);
                    if ( $is_available_user->first() != NULL):

                        // UPDATE STATUS,ROLE,USERNAME
                        $this->model_user->where('user_type', '=', 'coach')->where('ref_id', '=', $this->request->post['coach_id'])->update([
                            'status' => $this->request->post['status'],
                            'role_id' => $this->request->post['role_id'],
                            'username' => $this->request->post['username'],
                        ]);

                        // UPDATE PASSWORD
                        if ( isset($this->request->post['password']) == TRUE AND !empty( $this->request->post['password']) == TRUE ):
                            $this->model_user->where('user_type', '=', 'coach')->where('ref_id', '=', $this->request->post['coach_id'])->update(['password' => password_hash($this->request->post['password'], PASSWORD_DEFAULT)]);
                            
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
                            echo json_encode( array( "status" => "failed", "message" => "This username already exists" ), JSON_PRETTY_PRINT );
                            exit();
                        endif;

                        // VALIDATION : password
                        $is_valid_password = GUMP::is_valid($this->request->post, array('password' => 'required|alpha_numeric|min_len,6|max_len,20'));
                        if ( $is_valid_password !== true ):
                            echo json_encode( array("status" => "failed", "message" => "Please select a valid password of minimum 6 characters without any special characters and spaces except dash(-),underscore(_)" ), JSON_PRETTY_PRINT );
                            exit();
                        endif;                        

                        // INITIATE : USER RECORD
                        $this->model_user->user_type = "coach";
                        $this->model_user->ref_id = $this->request->post['coach_id'];
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
                    var_dump( $e->errorInfo );
                    echo json_encode( array( "status" => "failed", "message" => "Unable to edit coach. Please contact your System Administrator" ), JSON_PRETTY_PRINT );
                    exit();
                }
            else:
                // NO RECORD FOUND TO UPDATE
				echo json_encode( array( "status" => "failed", "message" => "No coach record found to modify" ), JSON_PRETTY_PRINT );
				exit();
			endif;
        else:
            // COACH ID IS NOT SET
			echo json_encode( array( "status" => "failed", "message" => "Please select a valid coach record" ), JSON_PRETTY_PRINT );
			exit();
		endif;
    }

    public function ajax_removecoach() {
        
        // CHECK LOGIN STATUS
		if( !isset($_SESSION['user']) OR $_SESSION['user']['is_login'] != true ):
			header( 'Location:' . $this->config->get('base_url') . '/logout' );
			exit();
		endif;

		// SET JSON HEADER
        header('Content-Type: application/json');

        // MODEL
        $this->load->model('coach');
        $this->load->model('coach/sport');
        
        if ( isset($this->request->post['coach_id']) AND !empty($this->request->post['coach_id']) ):
            $is_valid_coach_id = $this->model_coach->select('id')->where('id', '=', $this->request->post['coach_id']);

            if ( $is_valid_coach_id->first() !== NULL ):

                // CHECK COACH HAS SPORTS
                if( $this->model_coach_sport->select('id')->where('coach_id', '=', $this->request->post['coach_id'])->where('sport_id', '!=', NULL)->first() != NULL ):
                    echo json_encode( array( "status" => "failed", "message" => "Coach already engaged in some sports. Please retry after removing." ), JSON_PRETTY_PRINT );
                    exit();
                endif;

                // PROCEED TO DELETE
				if ( $this->model_coach->find($this->request->post['coach_id'])->delete() ):
					echo json_encode( array( "status" => "success" ), JSON_PRETTY_PRINT );
					exit();
				else:
					echo json_encode( array( "status" => "failed", "message" => "Cannot delete this coach. Please contact system administrator" ), JSON_PRETTY_PRINT );
                    exit();
				endif;
            else:
                // NO RECORD FOUND TO DELETE
				echo json_encode( array( "status" => "failed", "message" => "No coach record found" ), JSON_PRETTY_PRINT );
				exit();
			endif;
        else:
            // COACH ID IS NOT SET
			echo json_encode( array( "status" => "failed", "message" => "Please select a valid coach record" ), JSON_PRETTY_PRINT );
			exit();
		endif;
    }
}
?>