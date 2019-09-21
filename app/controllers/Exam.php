<?php

use Carbon\Carbon;

class Exam extends Controller {
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
        $this->load->view('exam/index', $data);
        
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
        $this->load->view('exam/search', $data);
        
    }
    
    public function create() {
    
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
        $this->load->model('exam');
        $this->load->model('exam/type');
        $this->load->model('grade');
        $this->load->model('subject');

        // TWIG : EXAM TYPE
        foreach( $this->model_exam_type->select('id', 'name')->get() as $key => $element ):
			$data['exam_types'][$key]['id'] = $element->id;
			$data['exam_types'][$key]['name']= $element->name;
        endforeach;
        
        // TWIG : EXAM YEAR
        $exam_year = Carbon::now()->format('Y');
        for ( $i=1; $i<=10; $i++ ):
            $data['years'][$i] = $exam_year;
            $exam_year++;
        endfor;

        // TWIG : EXAMS
        foreach( $this->model_exam->select('id', 'type_id', 'year')->get() as $key => $element ):
			$data['exams'][$key]['id'] = $element->id;
            $data['exams'][$key]['type_id']= $element->type_id;
            $data['exams'][$key]['year'] = $element->year;

            $data['exams'][$key]['type']['name'] = $this->model_exam_type->select('name')->where('id', '=', $element->type_id)->first()->name;
        endforeach;

        // TWIG : GRADE
		foreach( $this->model_grade->select('id', 'name')->get() as $key => $element ):
			$data['grades'][$key]['id'] = $element->id;
			$data['grades'][$key]['name']= $element->name;
		endforeach;

		// TWIG : SUBJECT
		foreach( $this->model_subject->select('id', 'name', 'si_name')->get() as $key => $element ):
			$data['subjects'][$key]['id'] = $element->id;
			$data['subjects'][$key]['name']= $element->name;
			$data['subjects'][$key]['si_name']= $element->si_name;
		endforeach;

		// RENDER VIEW
        $this->load->view('exam/create', $data);
        
    }
    
    public function ajax_addexam_type() {

       /**
         * This method will receive ajax request from
         * the front end with the payload
         * 
         *	exam_type_name
         * 
         * We need to validate the data and then perform
         * the following tasks.
         *    - validate
         *    - CRUD
         *    - response ( JSON )
         */

        //  MODEL
        $this->load->model('exam/type');

        // SET JSON HEADER
        header('Content-Type: application/json');
        
        // VALIDATION : exam_type_name
        $is_valid_exam_type_name = GUMP::is_valid($this->request->post, array('exam_type_name' => 'required|alpha_space'));
        if ( $is_valid_exam_type_name !== true ):
            echo json_encode( array( "error" => $is_valid_exam_type_name[0] ), JSON_PRETTY_PRINT );
            exit();
        endif;
        
        // EXAM_TYPE IS ENTERED : CHECK FOR DUPLICATE
		if ( $this->model_exam_type->select('id')->where('name', '=', $this->request->post['exam_type_name'])->first() != NULL ):
			echo json_encode( array( "error" => "This Exam type is already exists" ), JSON_PRETTY_PRINT );
			exit();
        endif;
        
        $this->model_exam_type->name = $this->request->post['exam_type_name'];
		
		// SUBMIT
		if ( $this->model_exam_type->save() ):
			echo json_encode( array( "status" => "success" ), JSON_PRETTY_PRINT );
		else:
			echo json_encode( array( "status" => "failed" ), JSON_PRETTY_PRINT );
		endif;
    }

    public function ajax_create_exam() {

        /**
         * This method will receive ajax request from
         * the front end with the payload
         * 
         *	exam_year
         *  exam_type_id
         *  exam_venue
         *  exam_instructions
         * 
         * We need to validate the data and then perform
         * the following tasks.
         *    - validate
         *    - CRUD
         *    - response ( JSON )
         */

        // MODEL
        $this->load->model('exam');

        // SET JSON HEADER
        header('Content-Type: application/json');

        // VALIDATION : exam_type
        $is_valid_exam_type = GUMP::is_valid($this->request->post, array('exam_type' => 'required|numeric|max_len,2'));
        if ( $is_valid_exam_type !== true ):
            echo json_encode( array( "error" => "Please select a exam type" ), JSON_PRETTY_PRINT );
            exit();
        endif;

        // VALIDATION : exam_year
        $is_valid_exam_year = GUMP::is_valid($this->request->post, array('exam_year' => 'required|numeric|exact_len,4'));
        if ( $is_valid_exam_year !== true ):
            echo json_encode( array( "error" => "Please select a exam year" ), JSON_PRETTY_PRINT );
            exit();
        endif;

        // VALIDATE EXAM_TYPE AND YEAR
		$is_exist = $this->model_exam->select('id')->where('type_id', '=', $this->request->post['exam_type'])->where('year', '=', $this->request->post['exam_year'])->first() != NULL;

		if( $is_exist != FALSE ):
			echo json_encode( array( "error" => "This Exam is already exist" ), JSON_PRETTY_PRINT );
			exit();
		endif;

        // VALIDATION : exam_venue
        $is_valid_exam_venue = GUMP::is_valid($this->request->post, array('exam_venue' => 'alpha_space|max_len,50'));
        if ( $is_valid_exam_venue !== true ):
            echo json_encode( array( "error" => $is_valid_exam_venue[0] ), JSON_PRETTY_PRINT );
            exit();
        endif;

        // VALIDATION : exam_instructions
        $is_valid_exam_instructions = GUMP::is_valid($this->request->post, array('exam_instructions' => 'alpha_space|max_len,200'));
        if ( $is_valid_exam_instructions !== true ):
            echo json_encode( array( "error" => $is_valid_exam_instructions[0] ), JSON_PRETTY_PRINT );
            exit();
        endif;

        $this->model_exam->type_id = $this->request->post['exam_type'];
        $this->model_exam->year = $this->request->post['exam_year'];
        $this->model_exam->venue = $this->request->post['exam_venue'];
        $this->model_exam->instructions = $this->request->post['exam_instructions'];

        // SUBMIT
		if ( $this->model_exam->save() ):
			echo json_encode( array( "status" => "success" ), JSON_PRETTY_PRINT );
		else:
			echo json_encode( array( "status" => "failed" ), JSON_PRETTY_PRINT );
		endif;
    }

    public function ajax_add_schedule() {

        /**
         * This method will receive ajax request from
         * the front end with the payload
         * 
         *	exam
         *  exam_grade
         *  exam_subject_name
         *  exam_date
         *  exam_starttime
         *  exam_endtime
         *  exam_instructions
         * 
         * We need to validate the data and then perform
         * the following tasks.
         *    - validate
         *    - CRUD
         *    - response ( JSON )
         */

        // MODEL
        $this->load->model('exam/schedule');

        // SET JSON HEADER
        header('Content-Type: application/json');

        // VALIDATION : select_exam
        $is_valid_select_exam = GUMP::is_valid($this->request->post, array('select_exam_name' => 'required|numeric'));
        if ( $is_valid_select_exam !== true ):
            echo json_encode( array( "error" => "Please select a exam" ), JSON_PRETTY_PRINT );
            exit();
        endif;

        // VALIDATION : exam_grade
        $is_valid_exam_grade = GUMP::is_valid($this->request->post, array('exam_grade' => 'required|numeric|max_len,2'));
        if ( $is_valid_exam_grade !== true ):
            echo json_encode( array( "error" => "Please select a grade" ), JSON_PRETTY_PRINT );
            exit();
        endif;

        // VALIDATION : exam_subject_name
        $is_valid_exam_subject_name = GUMP::is_valid($this->request->post, array('exam_subject_name' => 'required|numeric|max_len,3'));
        if ( $is_valid_exam_subject_name !== true ):
            echo json_encode( array( "error" => "Please select a subject" ), JSON_PRETTY_PRINT );
            exit();
        endif;

        // VALIDATION : exam_date
        $is_valid_exam_date = GUMP::is_valid($this->request->post, array('exam_date' => 'required|date'));
        if ( $is_valid_exam_date !== true ):
            echo json_encode( array( "error" => "Please set a exam date" ), JSON_PRETTY_PRINT );
            exit();
        endif;

        // VALIDATION : exam_starttime
        $is_valid_exam_starttime = GUMP::is_valid($this->request->post, array('exam_starttime' => 'required'));
        if ( $is_valid_exam_starttime !== true ):
            echo json_encode( array( "error" => "Please set exam start time" ), JSON_PRETTY_PRINT );
            exit();
        endif;

        // VALIDATION : exam_endtime
        $is_valid_exam_endtime = GUMP::is_valid($this->request->post, array('exam_endtime' => 'required'));
        if ( $is_valid_exam_endtime !== true ):
            echo json_encode( array( "error" => "Please set exam end time" ), JSON_PRETTY_PRINT );
            exit();
        endif;

        // VALIDATION : exam_instructions
        $is_valid_exam_instructions = GUMP::is_valid($this->request->post, array('exam_instructions' => 'alpha_space|max_len,200'));
        if ( $is_valid_exam_instructions !== true ):
            echo json_encode( array( "error" => $is_valid_exam_instructions[0] ), JSON_PRETTY_PRINT );
            exit();
        endif;

        $this->model_exam_schedule->exam_id = $this->request->post['exam_name'];
        $this->model_exam_schedule->grade_id = $this->request->post['exam_grade'];
        $this->model_exam_schedule->subject_id = $this->request->post['exam_subject_name'];
        $this->model_exam_schedule->date = $this->request->post['exam_date'];
        $this->model_exam_schedule->start_time = $this->request->post['exam_starttime'];
        $this->model_exam_schedule->end_time = $this->request->post['exam_endtime'];
        $this->model_exam_schedule->instructions = $this->request->post['exam_instructions'];

        // SUBMIT
		if ( $this->model_exam_schedule->save() ):
			echo json_encode( array( "status" => "success" ), JSON_PRETTY_PRINT );
		else:
			echo json_encode( array( "status" => "failed" ), JSON_PRETTY_PRINT );
        endif;
        
    }
    
}
?>