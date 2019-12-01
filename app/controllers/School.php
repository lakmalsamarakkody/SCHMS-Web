<?php

use Illuminate\Database\Capsule\Manager as DB;

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
		$this->load->model('staff/category');
		$this->load->model('staff/type');
		$this->load->model('religion');
		$this->load->model('subject');
		$this->load->model('student/relation');
		$this->load->model('exam/type');
		$this->load->model('sport');

		// CLASS
		foreach( $this->model_class->select('id', 'grade_id', 'staff_id','name')->orderBy('grade_id', 'asc')->orderBy('name', 'asc')->get() as $key => $element ):
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
		foreach( $this->model_grade->select('id', 'name')->orderBy('name')->get() as $key => $element ):
			$data['grades'][$key]['id'] = $element->id;
			$data['grades'][$key]['name']= $element->name;
		endforeach;
		
		// RELIGION
		foreach( $this->model_religion->select('id', 'name')->orderBy('name')->get() as $key => $element ):
			$data['religions'][$key]['id'] = $element->id;
			$data['religions'][$key]['name']= $element->name;
		endforeach;

		// SUBJECT
		foreach( $this->model_subject->select('id', 'name', 'si_name')->orderBy('name')->get() as $key => $element ):
			$data['subjects'][$key]['id'] = $element->id;
			$data['subjects'][$key]['name']= $element->name;
			$data['subjects'][$key]['si_name']= $element->si_name;
		endforeach;

		// RELATIONSHIP
		foreach( $this->model_student_relation->select('id', 'name')->orderBy('id')->get() as $key => $element ):
			$data['student_relations'][$key]['id'] = $element->id;
			$data['student_relations'][$key]['name']= $element->name;
		endforeach;

		// EXAM TYPE
		foreach( $this->model_exam_type->select('id', 'name')->orderBy('name')->get() as $key => $element ):
			$data['exam_types'][$key]['id'] = $element->id;
			$data['exam_types'][$key]['name']= $element->name;
		endforeach;

		// SPORT
		foreach( $this->model_sport->select('id', 'name')->orderBy('name')->get() as $key => $element ):
			$data['sports'][$key]['id'] = $element->id;
			$data['sports'][$key]['name']= $element->name;
		endforeach;

		// STAFF CATEGORY
		foreach( $this->model_staff_category->select('id', 'name')->orderBy('name')->get() as $key => $element ):
			$data['staff']['category'][$key]['id'] = $element->id;
			$data['staff']['category'][$key]['name']= $element->name;
		endforeach;

		// STAFF TYPE
		foreach( $this->model_staff_type->select('id', 'name')->orderBy('id')->get() as $key => $element ):

			$category_data = DB::table('staff_type')
				->join('staff_category', 'staff_type.category_id', 'staff_category.id')
				->select('staff_category.name')
				->where('staff_type.id', '=', $element->id)->first();

			$data['staff']['type'][$key]['id'] = $element->id;
			$data['staff']['type'][$key]['name']= $element->name;
			$data['staff']['type'][$key]['category']['name']= $category_data->name;
		endforeach;


		// RENDER VIEW
		$this->load->view('school/index', $data);
	}

	public function ajax_addclass() {

		/**
         * This method will receive ajax request from
         * the front end with the payload
         * 
         *   - class_name
         *   - grade_id
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
            echo json_encode( array( "error" => "Please enter a class name" ), JSON_PRETTY_PRINT );
            exit();
		endif;
		
		// VALIDATION : grade_id
        $is_valid_grade_id = GUMP::is_valid($this->request->post, array('grade_id' => 'numeric|max_len,2'));
        if ( $is_valid_grade_id !== true ):
            echo json_encode( array( "error" => "Please select a Grade" ), JSON_PRETTY_PRINT );
            exit();
		endif;

		// VALIDATION : employee_id
        $is_valid_employee_id = GUMP::is_valid($this->request->post, array('employee_id' => 'numeric|max_len,6'));
        if ( $is_valid_employee_id !== true ):
            echo json_encode( array( "error" => "Please enter a valid Employee ID" ), JSON_PRETTY_PRINT );
            exit();
		endif;

		// VALIDATE CLASS AND GRADE
		$is_exist = $this->model_class->select('id')->where('name', '=', $this->request->post['class_name'])->where('grade_id', '=', $this->request->post['grade_id'])->first() != NULL;

		if( $is_exist != FALSE ):
			echo json_encode( array( "error" => "This class name and grade combination exists" ), JSON_PRETTY_PRINT );
			exit();
		endif;

		// CHECK EMPLOYEE ID 
		if ( GUMP::is_valid($this->request->post, array('employee_id' => 'required')) === true ):

			// EMPLOYEE ID IS ENTERED : CHECK FOR DUPLICATE
			if ( $this->model_class->select('id')->where('staff_id', '=', $this->request->post['employee_id'])->first() != NULL ):
				echo json_encode( array( "error" => "This staff member is already have a class" ), JSON_PRETTY_PRINT );
				exit();
			endif;

			// EMPLOYEE ID IS ENTERED : CHECK FOR DUPLICATE
			if ( $this->model_staff->select('id')->where('employee_number', '=', $this->request->post['employee_id'])->first() == NULL ):
				echo json_encode( array( "error" => "Please enter a valid Employee ID" ), JSON_PRETTY_PRINT );
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
         *   - grade_name
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
            echo json_encode( array( "error" => "Please insert a grade number" ), JSON_PRETTY_PRINT );
            exit();
		endif;

		// ADMISSION NUMBER IS ENTERED : CHECK FOR DUPLICATE
		if ( $this->model_grade->select('id')->where('name', '=', $this->request->post['grade_name'])->first() != NULL ):
			echo json_encode( array( "error" => "This grade already exists" ), JSON_PRETTY_PRINT );
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
         *   - religion_name
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
        $is_valid_religion_name = GUMP::is_valid($this->request->post, array('religion_name' => 'required|valid_name'));
        if ( $is_valid_religion_name !== true ):
            echo json_encode( array( "error" => "Please enter a religion name" ), JSON_PRETTY_PRINT );
            exit();
		endif;

		// RELIGION IS ENTERED : CHECK FOR DUPLICATE
		if ( $this->model_religion->select('id')->where('name', '=', $this->request->post['religion_name'])->first() != NULL ):
			echo json_encode( array( "error" => "Religion already exists" ), JSON_PRETTY_PRINT );
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
         *	- subject_name
		 *	- subject_si_name
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
        $is_valid_subject_name = GUMP::is_valid($this->request->post, array('subject_name' => 'required|valid_name'));
        if ( $is_valid_subject_name !== true ):
            echo json_encode( array( "error" => "Please insert Subject name" ), JSON_PRETTY_PRINT );
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
		$this->model_subject->si_name = ( $this->request->post['subject_in_sinhala'] == "" )  ? null : $this->request->post['subject_in_sinhala'];
		
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
         *	- relation_name
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
        $is_valid_relation_name = GUMP::is_valid($this->request->post, array('relation_name' => 'required|valid_name'));
        if ( $is_valid_relation_name !== true ):
            echo json_encode( array( "error" => "Please enter a relation type name" ), JSON_PRETTY_PRINT );
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

	public function ajax_addexam_type() {

		/**
		  * This method will receive ajax request from
		  * the front end with the payload
		  * 
		  *	- exam_type_name
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
			echo json_encode( array( "error" => "Please enter exam type name" ), JSON_PRETTY_PRINT );
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

	public function ajax_addsport() {

		/**
		  * This method will receive ajax request from
		  * the front end with the payload
		  * 
		  *	- sport name
		  * 
		  * We need to validate the data and then perform
		  * the following tasks.
		  *    - validate
		  *    - CRUD
		  *    - response ( JSON )
		  */
 
		//  MODEL
		$this->load->model('sport');

		// SET JSON HEADER
		header('Content-Type: application/json');
		
		// VALIDATION : sport
		$is_valid_sport = GUMP::is_valid($this->request->post, array('sport_name' => 'required|valid_name'));
		if ( $is_valid_sport !== true ):
			echo json_encode( array( "error" => "Please enter a sport name" ), JSON_PRETTY_PRINT );
			exit();
		endif;
		
			// SPORT IS ENTERED : CHECK FOR DUPLICATE
			if ( $this->model_sport->select('id')->where('name', '=', $this->request->post['sport_name'])->first() != NULL ):
				echo json_encode( array( "error" => "This Sport is already exists" ), JSON_PRETTY_PRINT );
				exit();
			endif;
		
		$this->model_sport->name = $this->request->post['sport_name'];
		
		// SUBMIT
		if ( $this->model_sport->save() ):
			echo json_encode( array( "status" => "success" ), JSON_PRETTY_PRINT );
		else:
			echo json_encode( array( "status" => "failed" ), JSON_PRETTY_PRINT );
		endif;
	}

	public function ajax_add_staff_category() {

		/**
		  * This method will receive ajax request from
		  * the front end with the payload
		  * 
		  *	- staff category name
		  * 
		  * We need to validate the data and then perform
		  * the following tasks.
		  *    - validate
		  *    - CRUD
		  *    - response ( JSON )
		  */
 
		//  MODEL
		$this->load->model('staff/category');

		// SET JSON HEADER
		header('Content-Type: application/json');
		
		// VALIDATION : staff_category_name
		$is_valid_staff_category_name = GUMP::is_valid($this->request->post, array('staff_category_name' => 'required|valid_name'));
		if ( $is_valid_staff_category_name !== true ):
			echo json_encode( array( "error" => "Please enter a valid category name" ), JSON_PRETTY_PRINT );
			exit();
		endif;
		
			// staff_category_name IS ENTERED : CHECK FOR DUPLICATE
			if ( $this->model_staff_category->select('id')->where('name', '=', $this->request->post['staff_category_name'])->first() != NULL ):
				echo json_encode( array( "error" => "This Category is already exists" ), JSON_PRETTY_PRINT );
				exit();
			endif;
		
		$this->model_staff_category->name = $this->request->post['staff_category_name'];
		
		// SUBMIT
		if ( $this->model_staff_category->save() ):
			echo json_encode( array( "status" => "success" ), JSON_PRETTY_PRINT );
		else:
			echo json_encode( array( "status" => "failed" ), JSON_PRETTY_PRINT );
		endif;
	}

	public function ajax_add_staff_type() {

		/**
		  * This method will receive ajax request from
		  * the front end with the payload
		  * 
		  *	- staff category name
		  * 
		  * We need to validate the data and then perform
		  * the following tasks.
		  *    - validate
		  *    - CRUD
		  *    - response ( JSON )
		  */
 
		//  MODEL
		$this->load->model('staff/type');

		// SET JSON HEADER
		header('Content-Type: application/json');

		// VALIDATION : staff_category_id
		$is_valid_staff_category_id = GUMP::is_valid($this->request->post, array('staff_category_id' => 'required|numeric|min_len,1|max_len,3'));
		if ( $is_valid_staff_category_id !== true ):
			echo json_encode( array( "error" => "Please select a valid category" ), JSON_PRETTY_PRINT );
			exit();
		endif;
		
		// VALIDATION : staff_type_name
		$is_valid_staff_type_name = GUMP::is_valid($this->request->post, array('staff_type_name' => 'required|valid_name'));
		if ( $is_valid_staff_type_name !== true ):
			echo json_encode( array( "error" => "Please enter a valid type name" ), JSON_PRETTY_PRINT );
			exit();
		endif;
		
			// staff_type_name IS ENTERED : CHECK FOR DUPLICATE
			if ( $this->model_staff_type->select('id')->where('name', '=', $this->request->post['staff_type_name'])->first() != NULL ):
				echo json_encode( array( "error" => "This Type is already exists" ), JSON_PRETTY_PRINT );
				exit();
			endif;
		
		$this->model_staff_type->category_id = $this->request->post['staff_category_id'];
		$this->model_staff_type->name = $this->request->post['staff_type_name'];
		
		// SUBMIT
		if ( $this->model_staff_type->save() ):
			echo json_encode( array( "status" => "success" ), JSON_PRETTY_PRINT );
		else:
			echo json_encode( array( "status" => "failed" ), JSON_PRETTY_PRINT );
		endif;
	}
}

?>