<?php

class School extends Controller {
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

		//CHECK LOGIN STATUS
		// if( !isset($_SESSION['user']) OR $_SESSION['user']['is_login'] != true ):

		// 	header( 'Location:' . $this->config->get('base_url') . '/logout' );
		// 	exit();

		// endif;

		//MODEL
		$this->load->model('class');
		$this->load->model('grade');
		$this->load->model('staff');
		$this->load->model('religion');
		$this->load->model('subject');
		$this->load->model('student/relation');

		// CLASS
		foreach( $this->model_class->select('id', 'grade_id', 'staff_id','name')->get() as $key => $element ):
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
		foreach( $this->model_grade->select('id', 'name')->get() as $key => $element ):
			$data['grades'][$key]['id'] = $element->id;
			$data['grades'][$key]['name']= $element->name;
		endforeach;
		
		// RELIGION
		foreach( $this->model_religion->select('id', 'name')->get() as $key => $element ):
			$data['religions'][$key]['id'] = $element->id;
			$data['religions'][$key]['name']= $element->name;
		endforeach;

		// SUBJECT
		foreach( $this->model_subject->select('id', 'name', 'si_name')->get() as $key => $element ):
			$data['subjects'][$key]['id'] = $element->id;
			$data['subjects'][$key]['name']= $element->name;
			$data['subjects'][$key]['si_name']= $element->si_name;
		endforeach;

		// RELATIONSHIP
		foreach( $this->model_student_relation->select('id', 'name')->get() as $key => $element ):
			$data['student_relations'][$key]['id'] = $element->id;
			$data['student_relations'][$key]['name']= $element->name;
		endforeach;


		// RENDER VIEW
		$this->load->view('school/index', $data);

	}

	public function ajax_addclass() {

		/**
         * This method will receive ajax request from
         * the front end with the payload
         * 
         *   class_name
         *   grade_id
         * 
         * We need to validate the data and then perform
         * the following tasks.
         *    - validate
         *    - CRUD
         *    - response ( JSON )
         */

		//  MODEL
		$this->load->model('class');
		$this->load->model('staff');


		// SET JSON HEADER
		header('Content-Type: application/json');
		
		// VALIDATION : class_name
        $is_valid_class_name = GUMP::is_valid($this->request->post, array('class_name' => 'required|alpha_numeric|max_len,2'));
        if ( $is_valid_class_name !== true ):
            echo json_encode( array( "error" => $is_valid_class_name[0] ), JSON_PRETTY_PRINT );
            exit();
		endif;
		
		// VALIDATION : grade
        $is_valid_grade = GUMP::is_valid($this->request->post, array('grade' => 'numeric|max_len,2'));
        if ( $is_valid_grade !== true ):
            echo json_encode( array( "error" => $is_valid_grade[0] ), JSON_PRETTY_PRINT );
            exit();
		endif;

		// VALIDATION : employee_id
        $is_valid_employee_id = GUMP::is_valid($this->request->post, array('employee_id' => 'numeric|max_len,6'));
        if ( $is_valid_employee_id !== true ):
            echo json_encode( array( "error" => $is_valid_employee_id[0] ), JSON_PRETTY_PRINT );
            exit();
		endif;

		// VALIDATE CLASS AND GRADE
		$is_exist = $this->model_class->select('id')->where('name', '=', $this->request->post['class_name'])->where('grade_id', '=', $this->request->post['grade_id'])->first() != NULL;

		if( $is_exist != FALSE ):
			echo json_encode( array( "error" => "This Class name and grade combination exists" ), JSON_PRETTY_PRINT );
			exit();
		endif;

		// CHECK EMPLOYEE ID 
		if ( GUMP::is_valid($this->request->post, array('employee_id' => 'required')) === true ):

			// EMPLOYEE ID IS ENTERED : CHECK FOR DUPLICATE
			if ( $this->model_class->select('id')->where('staff_id', '=', $this->request->post['employee_id'])->first() != NULL ):
				echo json_encode( array( "error" => "This Staff member is already have a class" ), JSON_PRETTY_PRINT );
				exit();
			endif;

			// EMPLOYEE ID IS ENTERED : CHECK FOR DUPLICATE
			if ( $this->model_staff->select('id')->where('employee_number', '=', $this->request->post['employee_id'])->first() == NULL ):
				echo json_encode( array( "error" => "Invalid Employee ID" ), JSON_PRETTY_PRINT );
				exit();
			endif;

		endif;
		
		$this->model_class->name = strtoupper($this->request->post['class_name']);
		$this->model_class->grade_id = $this->request->post['grade_id'];

		if($this->request->post['employee_id'] != NULL):
		$this->model_class->staff_id = $this->model_staff->select('id')->where('employee_number', '=', $this->request->post['employee_id'])->first()->id;
		endif;

		// SUBMIT
		if ( $this->model_class->save() ):
			echo json_encode( array( "status" => "success" ), JSON_PRETTY_PRINT );
		else:
			echo json_encode( array( "status" => "failed" ), JSON_PRETTY_PRINT );
		endif;

	}

	public function ajax_addgrade() {

		/**
         * This method will receive ajax request from
         * the front end with the payload
         * 
         *   grade_name
         * 
         * We need to validate the data and then perform
         * the following tasks.
         *    - validate
         *    - CRUD
         *    - response ( JSON )
         */

		//  MODEL
		$this->load->model('grade');

		// SET JSON HEADER
		header('Content-Type: application/json');
		
		// VALIDATION : grade_name
        $is_valid_grade_name = GUMP::is_valid($this->request->post, array('grade_name' => 'required|numeric|max_len,2'));
        if ( $is_valid_grade_name !== true ):
            echo json_encode( array( "error" => $is_valid_grade_name[0] ), JSON_PRETTY_PRINT );
            exit();
		endif;

		// ADMISSION NUMBER IS ENTERED : CHECK FOR DUPLICATE
		if ( $this->model_grade->select('id')->where('name', '=', $this->request->post['grade_name'])->first() != NULL ):
			echo json_encode( array( "error" => "This Grade is already exists" ), JSON_PRETTY_PRINT );
			exit();
		endif;
		
		$this->model_grade->name = $this->request->post['grade_name'];
		
		// SUBMIT
		if ( $this->model_grade->save() ):
			echo json_encode( array( "status" => "success" ), JSON_PRETTY_PRINT );
		else:
			echo json_encode( array( "status" => "failed" ), JSON_PRETTY_PRINT );
		endif;

	}

	public function ajax_addreligion() {

		/**
         * This method will receive ajax request from
         * the front end with the payload
         * 
         *   religion_name
         * 
         * We need to validate the data and then perform
         * the following tasks.
         *    - validate
         *    - CRUD
         *    - response ( JSON )
         */

		//  MODEL
		$this->load->model('religion');

		// SET JSON HEADER
		header('Content-Type: application/json');
		
		// VALIDATION : religion_name
        $is_valid_religion_name = GUMP::is_valid($this->request->post, array('religion_name' => 'required|alpha'));
        if ( $is_valid_religion_name !== true ):
            echo json_encode( array( "error" => $is_valid_religion_name[0] ), JSON_PRETTY_PRINT );
            exit();
		endif;

		// RELIGION IS ENTERED : CHECK FOR DUPLICATE
		if ( $this->model_religion->select('id')->where('name', '=', $this->request->post['religion_name'])->first() != NULL ):
			echo json_encode( array( "error" => "This Religion is already exists" ), JSON_PRETTY_PRINT );
			exit();
		endif;
		
		$this->model_religion->name = $this->request->post['religion_name'];
		
		// SUBMIT
		if ( $this->model_religion->save() ):
			echo json_encode( array( "status" => "success" ), JSON_PRETTY_PRINT );
		else:
			echo json_encode( array( "status" => "failed" ), JSON_PRETTY_PRINT );
		endif;

	}

	public function ajax_addsubject() {

		/**
         * This method will receive ajax request from
         * the front end with the payload
         * 
         *	subject_name
		 *	ubject_si_name
         * 
         * We need to validate the data and then perform
         * the following tasks.
         *    - validate
         *    - CRUD
         *    - response ( JSON )
         */

		//  MODEL
		$this->load->model('subject');

		// SET JSON HEADER
		header('Content-Type: application/json');
		
		// VALIDATION : subject_name
        $is_valid_subject_name = GUMP::is_valid($this->request->post, array('subject_name' => 'required|alpha'));
        if ( $is_valid_subject_name !== true ):
            echo json_encode( array( "error" => $is_valid_subject_name[0] ), JSON_PRETTY_PRINT );
            exit();
		endif;

		// SUBJECT IS ENTERED : CHECK FOR DUPLICATE
		if ( $this->model_subject->select('id')->where('name', '=', $this->request->post['subject_name'])->first() != NULL ):
			echo json_encode( array( "error" => "This Subject is already exists" ), JSON_PRETTY_PRINT );
			exit();
		endif;

		// VALIDATION : DUPLICATE subject_in_sinhala
		if ( $this->request->post['subject_in_sinhala'] != NULL ):
			if ( $this->model_subject->select('id')->where('si_name', '=', $this->request->post['subject_in_sinhala'])->first() !== NULL ):
				echo json_encode( array( "error" => "This Subject name in Sinhala is already exists" ), JSON_PRETTY_PRINT );
				exit();
			endif;
		endif;        
		
		$this->model_subject->name = $this->request->post['subject_name'];
		$this->model_subject->si_name = $this->request->post['subject_si_name'];
		
		// SUBMIT
		if ( $this->model_subject->save() ):
			echo json_encode( array( "status" => "success" ), JSON_PRETTY_PRINT );
		else:
			echo json_encode( array( "status" => "failed" ), JSON_PRETTY_PRINT );
		endif;

	}

	public function ajax_addrelation() {

		/**
         * This method will receive ajax request from
         * the front end with the payload
         * 
         *	relation_name
         * 
         * We need to validate the data and then perform
         * the following tasks.
         *    - validate
         *    - CRUD
         *    - response ( JSON )
         */

		//  MODEL
		$this->load->model('student/relation');

		// SET JSON HEADER
		header('Content-Type: application/json');
		
		// VALIDATION : relation_name
        $is_valid_relation_name = GUMP::is_valid($this->request->post, array('relation_name' => 'required|alpha_space'));
        if ( $is_valid_relation_name !== true ):
            echo json_encode( array( "error" => $is_valid_relation_name[0] ), JSON_PRETTY_PRINT );
            exit();
		endif;

		// RELATION IS ENTERED : CHECK FOR DUPLICATE
		if ( $this->model_student_relation->select('id')->where('name', '=', $this->request->post['relation_name'])->first() != NULL ):
			echo json_encode( array( "error" => "This Relation type is already exists" ), JSON_PRETTY_PRINT );
			exit();
		endif;
		
		$this->model_student_relation->name = $this->request->post['relation_name'];
		
		// SUBMIT
		if ( $this->model_student_relation->save() ):
			echo json_encode( array( "status" => "success" ), JSON_PRETTY_PRINT );
		else:
			echo json_encode( array( "status" => "failed" ), JSON_PRETTY_PRINT );
		endif;

	}
}

?>