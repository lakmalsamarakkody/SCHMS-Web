<?php

class Health extends Controller {
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
        $this->load->view('health/index', $data);
        
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

        // MODEL
        $this->load->model('class');
        $this->load->model('grade');
        $this->load->model('sport');
        $this->load->model('student');
        $this->load->model('student/sport');
        $this->load->model('student/health');

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
                $data['students'][$key]['name'] = $value->initials." ".$value->surname;
                $data['students'][$key]['gender'] = $value->gender;
                $data['students'][$key]['dob'] = $value->dob;
                $data['students'][$key]['class'] = $value->class_id;
                $data['students'][$key]['city'] = $value->city;
            endforeach;

        endif;

		// RENDER VIEW
        $this->load->view('health/search', $data);
        
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

        // MODEL
        $this->load->model('class');
        $this->load->model('grade');
        $this->load->model('sport');
        $this->load->model('student');
        $this->load->model('student/sport');
        $this->load->model('student/health');

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
                $data['students'][$key]['name'] = $value->initials." ".$value->surname;
                $data['students'][$key]['gender'] = $value->gender;
                $data['students'][$key]['dob'] = $value->dob;
                $data['students'][$key]['class'] = $value->class_id;
                $data['students'][$key]['city'] = $value->city;
            endforeach;

        endif;

		// RENDER VIEW
        $this->load->view('health/add', $data);
        
    }
}
?>