<?php

use Illuminate\Database\Capsule\Manager as DB;

class School extends Controller {
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
		$this->load->model('user');
		$this->load->model('user/role');

        // CHECK PERMISSION : index
        if ( $this->model_user->find($_SESSION['user']['id'])->hasPermission('management-index-view') ):
            $data['permission']['management']['index']['view'] = true;
        else:
            $data['permission']['management']['index']['view'] = false;
        endif;

		// CLASS
		foreach( $this->model_class->select('id', 'grade_id', 'staff_id','name')->orderBy('grade_id', 'asc')->orderBy('name', 'asc')->get() as $key => $element ):
			$data['classes'][$key]['id'] = $element->id;
			$data['classes'][$key]['grade']['id'] = $element->grade_id;
			$data['classes'][$key]['name'] = $element->name;

			// GET GRADE DETAILS
			$data['classes'][$key]['grade']['name'] = $this->model_grade->select('name')->where('id', '=', $element->grade_id)->first()->name;

			// GET STAFF DETAILS
			if ( $element->staff_id !== NULL):
				$data['classes'][$key]['staff'] = $this->model_staff->select('id','initials', 'surname')->where('id', '=', $element->staff_id)->first()->toArray();
			else:
				$data['classes'][$key]['staff'] = "";
			endif;
		endforeach;

		// GRADE
		foreach( $this->model_grade->select('id', 'name')->orderBy('name')->get() as $key => $element ):
			$data['grades'][$key]['id'] = $element->id;
			$data['grades'][$key]['name']= $element->name;
		endforeach;

		// STAFF NAMES
		$is_teacher = DB::table('staff')
		->join('staff_type', 'staff.type_id', 'staff_type.id')
		->join('staff_category', 'staff_type.category_id', 'staff_category.id')
		->select('staff.id', 'staff.full_name')
		->where('staff_category.name', '=', 'Academic')
		->orderBy('full_name');

		foreach( $is_teacher->get() as $key => $element ):
			$data['staffs'][$key]['id'] = $element->id;
			$data['staffs'][$key]['name']= $element->full_name;
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
		foreach( $this->model_staff_type->select('id','category_id', 'name')->orderBy('id')->get() as $key => $element ):

			$category_data = DB::table('staff_type')
				->join('staff_category', 'staff_type.category_id', 'staff_category.id')
				->select('staff_category.name as category_name')
				->where('staff_type.id', '=', $element->id)->first();

			$data['staff']['type'][$key]['id'] = $element->id;
			$data['staff']['type'][$key]['name']= $element->name;
			$data['staff']['type'][$key]['category_id']= $element->category_id;
			$data['staff']['type'][$key]['category_name']= $category_data->category_name;
		endforeach;

		// USER ROLE
		foreach( $this->model_user_role->select('id', 'name', 'description')->orderBy('name')->get() as $key => $element ):
			$data['user']['roles'][$key]['id'] = $element->id;
			$data['user']['roles'][$key]['name']= $element->name;
			$data['user']['roles'][$key]['description']= $element->description;
		endforeach;


		// RENDER VIEW
		$this->load->view('school/index', $data);
	}

	public function ajax_addclass() {

		//CHECK LOGIN STATUS
		if( !isset($_SESSION['user']) OR $_SESSION['user']['is_login'] != true ):
			header( 'Location:' . $this->config->get('base_url') . '/logout' );
			exit();
		endif;

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


		// SET JSON HEADER
		header('Content-Type: application/json');

		//  MODEL
		$this->load->model('class');
		$this->load->model('staff');
		$this->load->model('user');

		// PERMISSION
        if ( !$this->model_user->find($_SESSION['user']['id'])->hasPermission('management-index-add-any') ):
            echo json_encode( array( "error" => "Permission denied" ), JSON_PRETTY_PRINT );
            exit();
        endif;
		
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

		// VALIDATION : staff_id
        $is_valid_staff_id = GUMP::is_valid($this->request->post, array('staff_id' => 'numeric|max_len,6'));
        if ( $is_valid_staff_id !== true ):
            echo json_encode( array( "error" => "Please select a valid Employee ID" ), JSON_PRETTY_PRINT );
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
			if ( $this->model_staff->select('id')->where('id', '=', $this->request->post['employee_id'])->first() == NULL ):
				echo json_encode( array( "error" => "Please enter a valid Employee ID" ), JSON_PRETTY_PRINT );
				exit();
			endif;

		endif;
		
		$this->model_class->name = strtoupper($this->request->post['class_name']);
		$this->model_class->grade_id = $this->request->post['grade_id'];

		if($this->request->post['employee_id'] != NULL):
			$this->model_class->staff_id = $this->request->post['employee_id'];
		endif;

		// SUBMIT
		if ( $this->model_class->save() ):
			echo json_encode( array( "status" => "success" ), JSON_PRETTY_PRINT );
		else:
			echo json_encode( array( "status" => "failed" ), JSON_PRETTY_PRINT );
		endif;
	}

	public function ajax_editclass() {

		//CHECK LOGIN STATUS
		if( !isset($_SESSION['user']) OR $_SESSION['user']['is_login'] != true ):
			header( 'Location:' . $this->config->get('base_url') . '/logout' );
			exit();
		endif;

		// SET JSON HEADER
		header('Content-Type: application/json');

		// MODEL
		$this->load->model('class');
		$this->load->model('staff');
		$this->load->model('user');

		// PERMISSION
        if ( !$this->model_user->find($_SESSION['user']['id'])->hasPermission('management-index-edit-any') ):
            echo json_encode( array( "status" => "failed", "message" => "Permission denied" ), JSON_PRETTY_PRINT );
            exit();
        endif;

		// VALIDATION : class_id
        $is_valid_class_id = GUMP::is_valid($this->request->post, array('id' => 'required|alpha_numeric|max_len,3'));
        if ( $is_valid_class_id !== true ):
            echo json_encode( array( "status" => "failed", "message" => "Invalid class id" ), JSON_PRETTY_PRINT );
            exit();
		endif;

		// VALIDATE CLASS ID
		$is_exist = $this->model_class->select('id')->where('id', '=', $this->request->post['id'])->first();

		if( $is_exist == NULL ):
			echo json_encode( array( "status" => "failed", "message" => "Editing class doesnot exists" ), JSON_PRETTY_PRINT );
			exit();
		endif;

		// VALIDATION : class_name
        $is_valid_class_name = GUMP::is_valid($this->request->post, array('name' => 'required|alpha_numeric|max_len,2'));
        if ( $is_valid_class_name !== true ):
            echo json_encode( array( "status" => "failed", "message" => "Please enter a class name" ), JSON_PRETTY_PRINT );
            exit();
		endif;
		
		// VALIDATION : grade_id
        $is_valid_grade_id = GUMP::is_valid($this->request->post, array('grade' => 'required|numeric|max_len,2'));
        if ( $is_valid_grade_id !== true ):
            echo json_encode( array( "status" => "failed", "message" => "Please select a Grade" ), JSON_PRETTY_PRINT );
            exit();
		endif;

		// VALIDATION : staff_id
        $is_valid_staff_id = GUMP::is_valid($this->request->post, array('staff' => 'numeric|max_len,6'));
        if ( $is_valid_staff_id !== true ):
            echo json_encode( array( "status" => "failed", "message" => "Please select a valid Employee ID" ), JSON_PRETTY_PRINT );
            exit();
		endif;

		// CHECK ANY CHANGE IN CLASS
		$is_class_changed = $this->model_class->select('id', 'name', 'grade_id')->where('id', '=', $this->request->post['id'])->first();
		if ( $is_class_changed->name != $this->request->post['name'] OR $is_class_changed->grade_id != $this->request->post['grade'] ):
			
			// VALIDATE CLASS AND GRADE
			$is_exist = $this->model_class->select('id')->where('name', '=', $this->request->post['name'])->where('grade_id', '=', $this->request->post['grade'])->first();
			if( $is_exist != NULL ):
				echo json_encode( array( "status" => "failed", "message" => "This class name and grade combination exists" ), JSON_PRETTY_PRINT );
				exit();
			endif;
		endif;

		// CHECK EMPLOYEE ID 
		if ( GUMP::is_valid($this->request->post, array('staff' => 'required')) === true ):

			// EMPLOYEE ID IS ENTERED : CHECK FOR VALID STAFF
			if ( $this->model_staff->select('id')->where('id', '=', $this->request->post['staff'])->first() == NULL ):
				echo json_encode( array( "status" => "failed", "message" => "Please enter a valid Employee ID" ), JSON_PRETTY_PRINT );
				exit();
			endif;

			// EMPLOYEE ID IS ENTERED : CHECK FOR DUPLICATE
			if ( $this->model_class->select('id')->where('staff_id', '=', $this->request->post['staff'])->first() != NULL ):
				echo json_encode( array( "status" => "failed", "message" => "This staff already has a class" ), JSON_PRETTY_PRINT );
				exit();
			endif;

		endif;
		
		// UPDATE
		if ( $this->request->post['staff'] == "" ):
			$this->request->post['staff'] = NULL;
		endif;

		try {
			$this->model_class->where('id', '=', $this->request->post['id'])->update([
				'grade_id' => $this->request->post['grade'],
				'staff_id' => $this->request->post['staff'],
				'name' => $this->request->post['name']
			]);
			echo json_encode( array("status" => "success"), JSON_PRETTY_PRINT );
			exit();
		} catch (\Illuminate\Database\QueryException $e) {
			// var_dump( $e->errorInfo );
			echo json_encode( array( "status" => "failed", "message" => "Unable to edit class. Please verify that details are not duplicating" ), JSON_PRETTY_PRINT );
			exit();
		}
	}

	public function ajax_removeclass() {

		//CHECK LOGIN STATUS
		if( !isset($_SESSION['user']) OR $_SESSION['user']['is_login'] != true ):
			header( 'Location:' . $this->config->get('base_url') . '/logout' );
			exit();
		endif;

		// SET JSON HEADER
		header('Content-Type: application/json');

		// MODEL
		$this->load->model('class');
		$this->load->model('student/class');
		$this->load->model('user');

		// PERMISSION
        if ( !$this->model_user->find($_SESSION['user']['id'])->hasPermission('management-index-delete-any') ):
            echo json_encode( array( "status" => "error", "message" => "Permission denied" ), JSON_PRETTY_PRINT );
            exit();
        endif;
		
		if ( isset($this->request->post['class_id']) AND !empty($this->request->post['class_id']) ):
			$is_available_student = $this->model_student_class->select('id')->where('class_id', '=', $this->request->post['class_id'])->first();
			if ( $is_available_student == NULL ):
				if ( $this->model_class->find($this->request->post['class_id'])->delete() ):
					echo json_encode( array( "status" => "success" ), JSON_PRETTY_PRINT );
					exit();
				else:
					echo json_encode( array( "status" => "error", "message" => "Cannot delete this class. Please contact system administrator" ), JSON_PRETTY_PRINT );
                    exit();
				endif;
			else:
				echo json_encode( array( "status" => "error", "message" => "Cannot delete this class. Class has one or more students" ), JSON_PRETTY_PRINT );
				exit();
			endif;
		else:
			echo json_encode( array( "status" => "error", "message" => "Please select a valid class" ), JSON_PRETTY_PRINT );
			exit();
		endif;
	}

	public function ajax_addgrade() {

		//CHECK LOGIN STATUS
		if( !isset($_SESSION['user']) OR $_SESSION['user']['is_login'] != true ):
			header( 'Location:' . $this->config->get('base_url') . '/logout' );
			exit();
		endif;

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
		$this->load->model('user');

		// SET JSON HEADER
		header('Content-Type: application/json');

		// PERMISSION
        if ( !$this->model_user->find($_SESSION['user']['id'])->hasPermission('management-index-add-any') ):
            echo json_encode( array( "error" => "Permission denied" ), JSON_PRETTY_PRINT );
            exit();
        endif;
		
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

	public function ajax_editgrade() {

		//CHECK LOGIN STATUS
		if( !isset($_SESSION['user']) OR $_SESSION['user']['is_login'] != true ):
			header( 'Location:' . $this->config->get('base_url') . '/logout' );
			exit();
		endif;

		// SET JSON HEADER
		header('Content-Type: application/json');

		// MODEL
		$this->load->model('grade');
		$this->load->model('user');

		// PERMISSION
        if ( !$this->model_user->find($_SESSION['user']['id'])->hasPermission('management-index-edit-any') ):
            echo json_encode( array( "status" => "failed", "message" => "Permission denied" ), JSON_PRETTY_PRINT );
            exit();
        endif;

		// VALIDATE GRADE ID
		$is_exist = $this->model_grade->select('id')->where('id', '=', $this->request->post['id'])->first();

		if( $is_exist == NULL ):
			echo json_encode( array( "status" => "failed", "message" => "Editing grade doesn't exists" ), JSON_PRETTY_PRINT );
			exit();
		endif;
		
		// VALIDATION : grade_name
        $is_valid_grade_name = GUMP::is_valid($this->request->post, array('name' => 'required|numeric|max_len,2'));
        if ( $is_valid_grade_name !== true ):
            echo json_encode( array( "status" => "failed", "message" => "Please insert a grade number" ), JSON_PRETTY_PRINT );
            exit();
		endif;

		// ADMISSION NUMBER IS ENTERED : CHECK FOR DUPLICATE
		if ( $this->model_grade->select('id')->where('name', '=', $this->request->post['name'])->first() != NULL ):
			echo json_encode( array( "status" => "failed", "message" => "This grade already exists" ), JSON_PRETTY_PRINT );
			exit();
		endif;

		// UPDATE
		try {
			$this->model_grade->where('id', '=', $this->request->post['id'])->update(['name' => $this->request->post['name']]);
			echo json_encode( array("status" => "success"), JSON_PRETTY_PRINT );
			exit();

		} catch (\Illuminate\Database\QueryException $e) {
			// var_dump( $e->errorInfo );
			echo json_encode( array( "status" => "failed", "message" => "Unable to edit Grade. Please verify that grade is not duplicating" ), JSON_PRETTY_PRINT );
			exit();
		}
	}

	public function ajax_removegrade() {

		//CHECK LOGIN STATUS
		if( !isset($_SESSION['user']) OR $_SESSION['user']['is_login'] != true ):
			header( 'Location:' . $this->config->get('base_url') . '/logout' );
			exit();
		endif;

		// SET JSON HEADER
		header('Content-Type: application/json');

		// MODEL
		$this->load->model('grade');
		$this->load->model('class');
		$this->load->model('user');
		
		// PERMISSION
        if ( !$this->model_user->find($_SESSION['user']['id'])->hasPermission('management-index-delete-any') ):
            echo json_encode( array( "status" => "error", "message" => "Permission denied" ), JSON_PRETTY_PRINT );
            exit();
        endif;
		
		if ( isset($this->request->post['grade_id']) AND !empty($this->request->post['grade_id']) ):
			$is_available_class = $this->model_class->select('id')->where('grade_id', '=', $this->request->post['grade_id']);
			if ( $is_available_class->first() == NULL ):
				if ( $this->model_grade->find($this->request->post['grade_id'])->delete() ):
					echo json_encode( array( "status" => "success" ), JSON_PRETTY_PRINT );
					exit();
				else:
					echo json_encode( array( "status" => "error", "message" => "Cannot delete this Grade. Please contact system administrator" ), JSON_PRETTY_PRINT );
                    exit();
				endif;
			else:
				echo json_encode( array( "status" => "error", "message" => "Cannot delete this Grade. Grade has existing classes" ), JSON_PRETTY_PRINT );
				exit();
			endif;
		else:
			echo json_encode( array( "status" => "error", "message" => "Please select a valid Grade" ), JSON_PRETTY_PRINT );
			exit();
		endif;
	}

	public function ajax_addreligion() {

		//CHECK LOGIN STATUS
		if( !isset($_SESSION['user']) OR $_SESSION['user']['is_login'] != true ):
			header( 'Location:' . $this->config->get('base_url') . '/logout' );
			exit();
		endif;

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

		// SET JSON HEADER
		header('Content-Type: application/json');

		//  MODEL
		$this->load->model('religion');
		$this->load->model('user');
		
		// PERMISSION
        if ( !$this->model_user->find($_SESSION['user']['id'])->hasPermission('management-index-add-any') ):
            echo json_encode( array( "error" => "Permission denied" ), JSON_PRETTY_PRINT );
            exit();
        endif;
		
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

	public function ajax_editreligion() {

		//CHECK LOGIN STATUS
		if( !isset($_SESSION['user']) OR $_SESSION['user']['is_login'] != true ):
			header( 'Location:' . $this->config->get('base_url') . '/logout' );
			exit();
		endif;

		// SET JSON HEADER
		header('Content-Type: application/json');

		// MODEL
		$this->load->model('religion');
		$this->load->model('user');
		
		// PERMISSION
        if ( !$this->model_user->find($_SESSION['user']['id'])->hasPermission('management-index-edit-any') ):
            echo json_encode( array( "status" => "failed", "message" => "Permission denied" ), JSON_PRETTY_PRINT );
            exit();
        endif;

		// VALIDATE RELIGION ID
		$is_exist = $this->model_religion->select('id')->where('id', '=', $this->request->post['id'])->first();

		if( $is_exist == NULL ):
			echo json_encode( array( "status" => "failed", "message" => "Editing religion doesn't exists" ), JSON_PRETTY_PRINT );
			exit();
		endif;
		
		// VALIDATION : religion_name
        $is_valid_religion_name = GUMP::is_valid($this->request->post, array('name' => 'required|valid_name'));
        if ( $is_valid_religion_name !== true ):
            echo json_encode( array( "status" => "failed", "message" => "Please insert a religion name" ), JSON_PRETTY_PRINT );
            exit();
		endif;

		// religion_name ENTERED : CHECK FOR DUPLICATE
		if ( $this->model_religion->select('id')->where('name', '=', $this->request->post['name'])->first() != NULL ):
			echo json_encode( array( "status" => "failed", "message" => "This religion already exists" ), JSON_PRETTY_PRINT );
			exit();
		endif;

		// UPDATE
		try {
			$this->model_religion->where('id', '=', $this->request->post['id'])->update(['name' => $this->request->post['name']]);
			echo json_encode( array("status" => "success"), JSON_PRETTY_PRINT );
			exit();

		} catch (\Illuminate\Database\QueryException $e) {
			// var_dump( $e->errorInfo );
			echo json_encode( array( "status" => "failed", "message" => "Unable to edit Religion. Please verify that religion is not duplicating" ), JSON_PRETTY_PRINT );
			exit();
		}
	}

	public function ajax_removereligion() {

		//CHECK LOGIN STATUS
		if( !isset($_SESSION['user']) OR $_SESSION['user']['is_login'] != true ):
			header( 'Location:' . $this->config->get('base_url') . '/logout' );
			exit();
		endif;

		// SET JSON HEADER
		header('Content-Type: application/json');

		// MODEL
		$this->load->model('religion');
		$this->load->model('student');
		$this->load->model('staff');
		$this->load->model('user');
		
		// PERMISSION
        if ( !$this->model_user->find($_SESSION['user']['id'])->hasPermission('management-index-delete-any') ):
            echo json_encode( array( "status" => "error", "message" => "Permission denied" ), JSON_PRETTY_PRINT );
            exit();
        endif;
		
		if ( isset($this->request->post['religion_id']) AND !empty($this->request->post['religion_id']) ):
			$is_available_student = $this->model_student->select('id')->where('religion_id', '=', $this->request->post['religion_id']);
			$is_available_staff = $this->model_staff->select('id')->where('religion_id', '=', $this->request->post['religion_id']);

			if ( $is_available_student->first() == NULL AND $is_available_staff->first() == NULL ):
				if ( $this->model_religion->find($this->request->post['religion_id'])->delete() ):
					echo json_encode( array( "status" => "success" ), JSON_PRETTY_PRINT );
					exit();
				else:
					echo json_encode( array( "status" => "error", "message" => "Cannot delete this religion. Please contact system administrator" ), JSON_PRETTY_PRINT );
                    exit();
				endif;
			else:
				echo json_encode( array( "status" => "error", "message" => "Cannot delete this Religion. Religion has existing student or staff" ), JSON_PRETTY_PRINT );
				exit();
			endif;
		else:
			echo json_encode( array( "status" => "error", "message" => "Please select a valid Religion" ), JSON_PRETTY_PRINT );
			exit();
		endif;
	}

	public function ajax_addsubject() {

		//CHECK LOGIN STATUS
		if( !isset($_SESSION['user']) OR $_SESSION['user']['is_login'] != true ):
			header( 'Location:' . $this->config->get('base_url') . '/logout' );
			exit();
		endif;

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

		// SET JSON HEADER
		header('Content-Type: application/json');
		
		 //  MODEL
		$this->load->model('subject');
		$this->load->model('user');
		
		// PERMISSION
        if ( !$this->model_user->find($_SESSION['user']['id'])->hasPermission('management-index-add-any') ):
            echo json_encode( array( "error" => "Permission denied" ), JSON_PRETTY_PRINT );
            exit();
        endif;
		
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

	public function ajax_editsubject() {

		//CHECK LOGIN STATUS
		if( !isset($_SESSION['user']) OR $_SESSION['user']['is_login'] != true ):
			header( 'Location:' . $this->config->get('base_url') . '/logout' );
			exit();
		endif;

		// SET JSON HEADER
		header('Content-Type: application/json');

		// MODEL
		$this->load->model('subject');
		$this->load->model('user');
		
		// PERMISSION
        if ( !$this->model_user->find($_SESSION['user']['id'])->hasPermission('management-index-edit-any') ):
            echo json_encode( array( "status" => "failed", "message" => "Permission denied" ), JSON_PRETTY_PRINT );
            exit();
        endif;

		// VALIDATE subject ID
		$is_exist = $this->model_subject->select('id')->where('id', '=', $this->request->post['id'])->first();

		if( $is_exist == NULL ):
			echo json_encode( array( "status" => "failed", "message" => "Editing subject doesn't exists" ), JSON_PRETTY_PRINT );
			exit();
		endif;
		
		// VALIDATION : subject_name
        $is_valid_subject_name = GUMP::is_valid($this->request->post, array('name' => 'required|valid_name'));
        if ( $is_valid_subject_name !== true ):
            echo json_encode( array( "status" => "failed", "message" => "Please insert a subject name" ), JSON_PRETTY_PRINT );
            exit();
		endif;

		// IS_CHANGED
		$is_changed_subject = $this->model_subject->select('id', 'name', 'si_name')->where('id', '=', $this->request->post['id'])->first();
		if ( $is_changed_subject->name !== $this->request->post['name'] ):
			// subject_name ENTERED : CHECK FOR DUPLICATE
			if ( $this->model_subject->select('id')->where('name', '=', $this->request->post['name'])->first() != NULL ):
				echo json_encode( array( "status" => "failed", "message" => "This subject already exists" ), JSON_PRETTY_PRINT );
				exit();
			endif;
		endif;

		// UPDATE
		try {
			$this->model_subject->where('id', '=', $this->request->post['id'])->update([
				'name' => $this->request->post['name'],
				'si_name' => $this->request->post['siname']
			]);
			echo json_encode( array("status" => "success"), JSON_PRETTY_PRINT );
			exit();

		} catch (\Illuminate\Database\QueryException $e) {
			// var_dump( $e->errorInfo );
			echo json_encode( array( "status" => "failed", "message" => "Unable to edit subject. Please verify that subject is not duplicating" ), JSON_PRETTY_PRINT );
			exit();
		}
	}

	public function ajax_removesubject() {

		//CHECK LOGIN STATUS
		if( !isset($_SESSION['user']) OR $_SESSION['user']['is_login'] != true ):
			header( 'Location:' . $this->config->get('base_url') . '/logout' );
			exit();
		endif;

		// SET JSON HEADER
		header('Content-Type: application/json');

		// MODEL
		$this->load->model('subject');
		$this->load->model('student/subject');
		$this->load->model('staff/subject');
		$this->load->model('exam/schedule');
		$this->load->model('user');
		
		// PERMISSION
        if ( !$this->model_user->find($_SESSION['user']['id'])->hasPermission('management-index-delete-any') ):
            echo json_encode( array( "status" => "error", "message" => "Permission denied" ), JSON_PRETTY_PRINT );
            exit();
        endif;
		
		if ( isset($this->request->post['subject_id']) AND !empty($this->request->post['subject_id']) ):
			$is_available_student = $this->model_student_subject->select('id')->where('subject_id', '=', $this->request->post['subject_id'])->first();
			$is_available_staff = $this->model_staff_subject->select('id')->where('subject_id', '=', $this->request->post['subject_id'])->first();
			$is_available_exam_schedule = $this->model_exam_schedule->select('id')->where('subject_id', '=', $this->request->post['subject_id'])->first();

			if ( $is_available_student == NULL AND $is_available_staff == NULL AND $is_available_exam_schedule == NULL ):
				if ( $this->model_subject->find($this->request->post['subject_id'])->delete() ):
					echo json_encode( array( "status" => "success" ), JSON_PRETTY_PRINT );
					exit();
				else:
					echo json_encode( array( "status" => "error", "message" => "Cannot delete this subject. Please contact system administrator" ), JSON_PRETTY_PRINT );
                    exit();
				endif;
			else:
				echo json_encode( array( "status" => "error", "message" => "Cannot delete this subject. Subject is used by students or staff or exam schedule" ), JSON_PRETTY_PRINT );
				exit();
			endif;
		else:
			echo json_encode( array( "status" => "error", "message" => "Please select a valid subject" ), JSON_PRETTY_PRINT );
			exit();
		endif;
	}

	public function ajax_addrelation() {

		//CHECK LOGIN STATUS
		if( !isset($_SESSION['user']) OR $_SESSION['user']['is_login'] != true ):
			header( 'Location:' . $this->config->get('base_url') . '/logout' );
			exit();
		endif;

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

		// SET JSON HEADER
		header('Content-Type: application/json');
		
		 //  MODEL
		$this->load->model('student/relation');
		$this->load->model('user');
		
		// PERMISSION
        if ( !$this->model_user->find($_SESSION['user']['id'])->hasPermission('management-index-add-any') ):
            echo json_encode( array( "error" => "Permission denied" ), JSON_PRETTY_PRINT );
            exit();
        endif;
		
		// VALIDATION : relation_name
        $is_valid_relation_name = GUMP::is_valid($this->request->post, array('relation_name' => 'required'));
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

	public function ajax_editrelation() {

		//CHECK LOGIN STATUS
		if( !isset($_SESSION['user']) OR $_SESSION['user']['is_login'] != true ):
			header( 'Location:' . $this->config->get('base_url') . '/logout' );
			exit();
		endif;

		// SET JSON HEADER
		header('Content-Type: application/json');

		// MODEL
		$this->load->model('student/relation');
		$this->load->model('user');
		
		// PERMISSION
        if ( !$this->model_user->find($_SESSION['user']['id'])->hasPermission('management-index-edit-any') ):
            echo json_encode( array( "status" => "failed", "message" => "Permission denied" ), JSON_PRETTY_PRINT );
            exit();
        endif;

		// VALIDATE relation ID
		$is_exist = $this->model_student_relation->select('id')->where('id', '=', $this->request->post['id'])->first();

		if( $is_exist == NULL ):
			echo json_encode( array( "status" => "failed", "message" => "Editing relation doesn't exists" ), JSON_PRETTY_PRINT );
			exit();
		endif;
		
		// VALIDATION : relation_name
        $is_valid_relation_name = GUMP::is_valid($this->request->post, array('name' => 'required'));
        if ( $is_valid_relation_name !== true ):
            echo json_encode( array( "status" => "failed", "message" => "Please insert a relation name" ), JSON_PRETTY_PRINT );
            exit();
		endif;

		// relation_name ENTERED : CHECK FOR DUPLICATE
		if ( $this->model_student_relation->select('id')->where('name', '=', $this->request->post['name'])->first() != NULL ):
			echo json_encode( array( "status" => "failed", "message" => "This relation already exists" ), JSON_PRETTY_PRINT );
			exit();
		endif;

		// UPDATE
		try {
			$this->model_student_relation->where('id', '=', $this->request->post['id'])->update(['name' => $this->request->post['name']]);
			echo json_encode( array("status" => "success"), JSON_PRETTY_PRINT );
			exit();

		} catch (\Illuminate\Database\QueryException $e) {
			// var_dump( $e->errorInfo );
			echo json_encode( array( "status" => "failed", "message" => "Unable to edit relation. Please verify that relation is not duplicating" ), JSON_PRETTY_PRINT );
			exit();
		}
	}

	public function ajax_removerelation() {

		//CHECK LOGIN STATUS
		if( !isset($_SESSION['user']) OR $_SESSION['user']['is_login'] != true ):
			header( 'Location:' . $this->config->get('base_url') . '/logout' );
			exit();
		endif;

		// SET JSON HEADER
		header('Content-Type: application/json');

		// MODEL
		$this->load->model('student/relation');
		$this->load->model('student/parent');
		$this->load->model('user');
		
		// PERMISSION
        if ( !$this->model_user->find($_SESSION['user']['id'])->hasPermission('management-index-delete-any') ):
            echo json_encode( array( "status" => "error", "message" => "Permission denied" ), JSON_PRETTY_PRINT );
            exit();
        endif;
		
		if ( isset($this->request->post['relation_id']) AND !empty($this->request->post['relation_id']) ):
			$is_available_relation = $this->model_student_parent->select('id')->where('relation_id', '=', $this->request->post['relation_id'])->first();

			if ( $is_available_relation == NULL ):
				if ( $this->model_student_relation->find($this->request->post['relation_id'])->delete() ):
					echo json_encode( array( "status" => "success" ), JSON_PRETTY_PRINT );
					exit();
				else:
					echo json_encode( array( "status" => "error", "message" => "Cannot delete this Relation type. Please contact system administrator" ), JSON_PRETTY_PRINT );
                    exit();
				endif;
			else:
				echo json_encode( array( "status" => "error", "message" => "Cannot delete this Relation type. Relation type is used by existing students with their parents" ), JSON_PRETTY_PRINT );
				exit();
			endif;
		else:
			echo json_encode( array( "status" => "error", "message" => "Please select a valid Relation type" ), JSON_PRETTY_PRINT );
			exit();
		endif;
	}

	public function ajax_addexam_type() {

		//CHECK LOGIN STATUS
		if( !isset($_SESSION['user']) OR $_SESSION['user']['is_login'] != true ):
			header( 'Location:' . $this->config->get('base_url') . '/logout' );
			exit();
		endif;

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

		// SET JSON HEADER
		header('Content-Type: application/json');
 
		//  MODEL
		$this->load->model('exam/type');
		$this->load->model('user');
		
		// PERMISSION
        if ( !$this->model_user->find($_SESSION['user']['id'])->hasPermission('management-index-add-any') ):
            echo json_encode( array( "error" => "Permission denied" ), JSON_PRETTY_PRINT );
            exit();
        endif;
		
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

	public function ajax_editexam_type() {

		//CHECK LOGIN STATUS
		if( !isset($_SESSION['user']) OR $_SESSION['user']['is_login'] != true ):
			header( 'Location:' . $this->config->get('base_url') . '/logout' );
			exit();
		endif;

		// SET JSON HEADER
		header('Content-Type: application/json');

		// MODEL
		$this->load->model('exam/type');
		$this->load->model('user');
		
		// PERMISSION
        if ( !$this->model_user->find($_SESSION['user']['id'])->hasPermission('management-index-edit-any') ):
            echo json_encode( array( "status" => "failed", "message" => "Permission denied" ), JSON_PRETTY_PRINT );
            exit();
		endif;
		
		// VALIDATE exam_type ID
		$is_exist = $this->model_exam_type->select('id')->where('id', '=', $this->request->post['id'])->first();

		if( $is_exist == NULL ):
			echo json_encode( array( "error" => "Editing exam type doesn't exists" ), JSON_PRETTY_PRINT );
			exit();
		endif;
		
		// VALIDATION : exam_type_name
        $is_valid_exam_type_name = GUMP::is_valid($this->request->post, array('name' => 'required'));
        if ( $is_valid_exam_type_name !== true ):
            echo json_encode( array( "status" => "failed", "message" => "Please insert a exam type" ), JSON_PRETTY_PRINT );
            exit();
		endif;

		// exam_type_name ENTERED : CHECK FOR DUPLICATE
		if ( $this->model_exam_type->select('id')->where('name', '=', $this->request->post['name'])->first() != NULL ):
			echo json_encode( array( "status" => "failed", "message" => "This exam type already exists" ), JSON_PRETTY_PRINT );
			exit();
		endif;

		// UPDATE
		try {
			$this->model_exam_type->where('id', '=', $this->request->post['id'])->update(['name' => $this->request->post['name']]);
			echo json_encode( array("status" => "success"), JSON_PRETTY_PRINT );
			exit();

		} catch (\Illuminate\Database\QueryException $e) {
			// var_dump( $e->errorInfo );
			echo json_encode( array( "status" => "failed", "message" => "Unable to edit exam type. Please verify that exam type is not duplicating" ), JSON_PRETTY_PRINT );
			exit();
		}
	}

	public function ajax_removeexamtype() {

		//CHECK LOGIN STATUS
		if( !isset($_SESSION['user']) OR $_SESSION['user']['is_login'] != true ):
			header( 'Location:' . $this->config->get('base_url') . '/logout' );
			exit();
		endif;

		// SET JSON HEADER
		header('Content-Type: application/json');

		// MODEL
		$this->load->model('exam');
		$this->load->model('exam/type');
		$this->load->model('user');
		
		// PERMISSION
        if ( !$this->model_user->find($_SESSION['user']['id'])->hasPermission('management-index-delete-any') ):
            echo json_encode( array( "status" => "error", "message" => "Permission denied" ), JSON_PRETTY_PRINT );
            exit();
        endif;
		
		if ( isset($this->request->post['examtype_id']) AND !empty($this->request->post['examtype_id']) ):
			$is_available_exam_type = $this->model_exam->select('id')->where('type_id', '=', $this->request->post['examtype_id'])->first();

			if ( $is_available_exam_type == NULL ):
				if ( $this->model_exam_type->find($this->request->post['examtype_id'])->delete() ):
					echo json_encode( array( "status" => "success" ), JSON_PRETTY_PRINT );
					exit();
				else:
					echo json_encode( array( "status" => "error", "message" => "Cannot delete this Exam type. Please contact system administrator" ), JSON_PRETTY_PRINT );
                    exit();
				endif;
			else:
				echo json_encode( array( "status" => "error", "message" => "Cannot delete this Exam type. Exam type is used by an existing exam" ), JSON_PRETTY_PRINT );
				exit();
			endif;
		else:
			echo json_encode( array( "status" => "error", "message" => "Please select a valid Exam type" ), JSON_PRETTY_PRINT );
			exit();
		endif;
	}

	public function ajax_addsport() {

		//CHECK LOGIN STATUS
		if( !isset($_SESSION['user']) OR $_SESSION['user']['is_login'] != true ):
			header( 'Location:' . $this->config->get('base_url') . '/logout' );
			exit();
		endif;

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
 
		// SET JSON HEADER
		header('Content-Type: application/json');
		
		  //  MODEL
		$this->load->model('sport');
		$this->load->model('user');
		
		// PERMISSION
        if ( !$this->model_user->find($_SESSION['user']['id'])->hasPermission('management-index-add-any') ):
            echo json_encode( array( "error" => "Permission denied" ), JSON_PRETTY_PRINT );
            exit();
        endif;
		
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

	public function ajax_editsport() {

		//CHECK LOGIN STATUS
		if( !isset($_SESSION['user']) OR $_SESSION['user']['is_login'] != true ):
			header( 'Location:' . $this->config->get('base_url') . '/logout' );
			exit();
		endif;

		// SET JSON HEADER
		header('Content-Type: application/json');

		// MODEL
		$this->load->model('sport');
		$this->load->model('user');
		
		// PERMISSION
        if ( !$this->model_user->find($_SESSION['user']['id'])->hasPermission('management-index-edit-any') ):
            echo json_encode( array( "status" => "failed", "message" => "Permission denied" ), JSON_PRETTY_PRINT );
            exit();
        endif;

		// VALIDATE sport ID
		$is_exist = $this->model_sport->select('id')->where('id', '=', $this->request->post['id'])->first();

		if( $is_exist == NULL ):
			echo json_encode( array( "status" => "failed", "message" => "Editing sport doesn't exists" ), JSON_PRETTY_PRINT );
			exit();
		endif;
		
		// VALIDATION : sport_name
        $is_valid_sport_name = GUMP::is_valid($this->request->post, array('name' => 'required|valid_name'));
        if ( $is_valid_sport_name !== true ):
            echo json_encode( array( "status" => "failed", "message" => "Please insert a sport name" ), JSON_PRETTY_PRINT );
            exit();
		endif;

		// sport_name ENTERED : CHECK FOR DUPLICATE
		if ( $this->model_sport->select('id')->where('name', '=', $this->request->post['name'])->first() != NULL ):
			echo json_encode( array( "status" => "failed", "message" => "This sport already exists" ), JSON_PRETTY_PRINT );
			exit();
		endif;

		// UPDATE
		try {
			$this->model_sport->where('id', '=', $this->request->post['id'])->update(['name' => $this->request->post['name']]);
			echo json_encode( array("status" => "success"), JSON_PRETTY_PRINT );
			exit();

		} catch (\Illuminate\Database\QueryException $e) {
			// var_dump( $e->errorInfo );
			echo json_encode( array( "status" => "failed", "message" => "Unable to edit sport. Please verify that sport is not duplicating" ), JSON_PRETTY_PRINT );
			exit();
		}
	}

	public function ajax_removesport() {

		//CHECK LOGIN STATUS
		if( !isset($_SESSION['user']) OR $_SESSION['user']['is_login'] != true ):
			header( 'Location:' . $this->config->get('base_url') . '/logout' );
			exit();
		endif;

		// SET JSON HEADER
		header('Content-Type: application/json');

		// MODEL
		$this->load->model('sport');
		$this->load->model('student/sport');
		$this->load->model('user');
		
		// PERMISSION
        if ( !$this->model_user->find($_SESSION['user']['id'])->hasPermission('management-index-delete-any') ):
            echo json_encode( array( "status" => "error", "message" => "Permission denied" ), JSON_PRETTY_PRINT );
            exit();
        endif;
		
		if ( isset($this->request->post['sport_id']) AND !empty($this->request->post['sport_id']) ):
			$is_available_sport = $this->model_student_sport->select('id')->where('sport_id', '=', $this->request->post['sport_id'])->first();

			if ( $is_available_sport == NULL ):
				if ( $this->model_sport->find($this->request->post['sport_id'])->delete() ):
					echo json_encode( array( "status" => "success" ), JSON_PRETTY_PRINT );
					exit();
				else:
					echo json_encode( array( "status" => "error", "message" => "Cannot delete this Sport. Please contact system administrator" ), JSON_PRETTY_PRINT );
                    exit();
				endif;
			else:
				echo json_encode( array( "status" => "error", "message" => "Cannot delete this Sport. One or More student is engaged in this sport" ), JSON_PRETTY_PRINT );
				exit();
			endif;
		else:
			echo json_encode( array( "status" => "error", "message" => "Please select a valid Sport" ), JSON_PRETTY_PRINT );
			exit();
		endif;
	}

	public function ajax_add_staff_category() {

		//CHECK LOGIN STATUS
		if( !isset($_SESSION['user']) OR $_SESSION['user']['is_login'] != true ):
			header( 'Location:' . $this->config->get('base_url') . '/logout' );
			exit();
		endif;

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
 
		// SET JSON HEADER
		header('Content-Type: application/json');
		
		  //  MODEL
		$this->load->model('staff/category');
		$this->load->model('user');
		
		// PERMISSION
        if ( !$this->model_user->find($_SESSION['user']['id'])->hasPermission('management-index-add-any') ):
            echo json_encode( array( "error" => "Permission denied" ), JSON_PRETTY_PRINT );
            exit();
        endif;
		
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

	public function ajax_editstaff_category() {

		//CHECK LOGIN STATUS
		if( !isset($_SESSION['user']) OR $_SESSION['user']['is_login'] != true ):
			header( 'Location:' . $this->config->get('base_url') . '/logout' );
			exit();
		endif;

		// SET JSON HEADER
		header('Content-Type: application/json');

		// MODEL
		$this->load->model('staff/category');
		$this->load->model('user');
		
		// PERMISSION
        if ( !$this->model_user->find($_SESSION['user']['id'])->hasPermission('management-index-edit-any') ):
            echo json_encode( array( "status" => "failed", "message" => "Permission denied" ), JSON_PRETTY_PRINT );
            exit();
        endif;

		// VALIDATE staff_category ID
		$is_exist = $this->model_staff_category->select('id')->where('id', '=', $this->request->post['id'])->first();

		if( $is_exist == NULL ):
			echo json_encode( array( "status" => "failed", "message" => "Editing staff category doesn't exists" ), JSON_PRETTY_PRINT );
			exit();
		endif;
		
		// VALIDATION : staff_category_name
        $is_valid_staff_category_name = GUMP::is_valid($this->request->post, array('name' => 'required|valid_name'));
        if ( $is_valid_staff_category_name !== true ):
            echo json_encode( array( "status" => "failed", "message" => "Please insert a staff category" ), JSON_PRETTY_PRINT );
            exit();
		endif;

		// staff_category_name ENTERED : CHECK FOR DUPLICATE
		if ( $this->model_staff_category->select('id')->where('name', '=', $this->request->post['name'])->first() != NULL ):
			echo json_encode( array( "status" => "failed", "message" => "This staff category already exists" ), JSON_PRETTY_PRINT );
			exit();
		endif;

		// UPDATE
		try {
			$this->model_staff_category->where('id', '=', $this->request->post['id'])->update(['name' => $this->request->post['name']]);
			echo json_encode( array("status" => "success"), JSON_PRETTY_PRINT );
			exit();

		} catch (\Illuminate\Database\QueryException $e) {
			// var_dump( $e->errorInfo );
			echo json_encode( array( "status" => "failed", "message" => "Unable to edit staff category. Please verify that staff category is not duplicating" ), JSON_PRETTY_PRINT );
			exit();
		}
	}

	public function ajax_removestaffcategory() {

		//CHECK LOGIN STATUS
		if( !isset($_SESSION['user']) OR $_SESSION['user']['is_login'] != true ):
			header( 'Location:' . $this->config->get('base_url') . '/logout' );
			exit();
		endif;

		// SET JSON HEADER
		header('Content-Type: application/json');

		// MODEL
		$this->load->model('staff/category');
		$this->load->model('staff/type');
		$this->load->model('user');
		
		// PERMISSION
        if ( !$this->model_user->find($_SESSION['user']['id'])->hasPermission('management-index-delete-any') ):
            echo json_encode( array( "status" => "error", "message" => "Permission denied" ), JSON_PRETTY_PRINT );
            exit();
        endif;
		
		if ( isset($this->request->post['category_id']) AND !empty($this->request->post['category_id']) ):
			$is_available_category = $this->model_staff_type->select('id')->where('category_id', '=', $this->request->post['category_id'])->first();

			if ( $is_available_category == NULL ):
				if ( $this->model_staff_category->find($this->request->post['category_id'])->delete() ):
					echo json_encode( array( "status" => "success" ), JSON_PRETTY_PRINT );
					exit();
				else:
					echo json_encode( array( "status" => "error", "message" => "Cannot delete this Staff Category. Please contact system administrator" ), JSON_PRETTY_PRINT );
                    exit();
				endif;
			else:
				echo json_encode( array( "status" => "error", "message" => "Cannot delete this Staff Category. One or More Staff is relevant to this Staff Category" ), JSON_PRETTY_PRINT );
				exit();
			endif;
		else:
			echo json_encode( array( "status" => "error", "message" => "Please select a valid Staff Category" ), JSON_PRETTY_PRINT );
			exit();
		endif;
	}

	public function ajax_add_staff_type() {

		//CHECK LOGIN STATUS
		if( !isset($_SESSION['user']) OR $_SESSION['user']['is_login'] != true ):
			header( 'Location:' . $this->config->get('base_url') . '/logout' );
			exit();
		endif;

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
 
		// SET JSON HEADER
		header('Content-Type: application/json');

		  //  MODEL
		$this->load->model('staff/type');
		$this->load->model('user');
		
		// PERMISSION
        if ( !$this->model_user->find($_SESSION['user']['id'])->hasPermission('management-index-add-any') ):
            echo json_encode( array( "error" => "Permission denied" ), JSON_PRETTY_PRINT );
            exit();
        endif;
		
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

	public function ajax_editstaff_type() {

		//CHECK LOGIN STATUS
		if( !isset($_SESSION['user']) OR $_SESSION['user']['is_login'] != true ):
			header( 'Location:' . $this->config->get('base_url') . '/logout' );
			exit();
		endif;

		// SET JSON HEADER
		header('Content-Type: application/json');

		// MODEL
		$this->load->model('staff');
		$this->load->model('staff/category');
		$this->load->model('staff/type');
		$this->load->model('user');
		
		// PERMISSION
        if ( !$this->model_user->find($_SESSION['user']['id'])->hasPermission('management-index-edit-any') ):
            echo json_encode( array( "status" => "failed", "message" => "Permission denied" ), JSON_PRETTY_PRINT );
            exit();
        endif;

		// VALIDATE staff_type ID
		$is_exist = $this->model_staff_type->select('id')->where('id', '=', $this->request->post['id'])->first();

		if( $is_exist == NULL ):
			echo json_encode( array( "status" => "failed", "message" => "Editing staff type doesn't exists" ), JSON_PRETTY_PRINT );
			exit();
		endif;

		// VALIDATION : staff_type_name
        $is_valid_staff_type_name = GUMP::is_valid($this->request->post, array('name' => 'required|valid_name'));
        if ( $is_valid_staff_type_name !== true ):
            echo json_encode( array( "status" => "failed", "message" => "Please enter a staff type" ), JSON_PRETTY_PRINT );
            exit();
		endif;

		// VALIDATION : staff_category_id
		$is_valid_staff_category_id = GUMP::is_valid($this->request->post, array('category' => 'required|numeric|min_len,1|max_len,3'));
		if ( $is_valid_staff_category_id !== true ):
			echo json_encode( array( "status" => "failed", "message" => "Please select a valid category" ), JSON_PRETTY_PRINT );
			exit();
		endif;

		// VALIDATE staff_category
		$is_exist = $this->model_staff_category->select('id')->where('name', '=', $this->request->post['category'])->first();

		if( $is_exist != NULL ):
			echo json_encode( array( "status" => "failed", "message" => "This staff category is not valid" ), JSON_PRETTY_PRINT );
			exit();
		endif;

		// VALIDATE staff_type AND staff_category
		$is_exist = $this->model_staff_type->select('id')->where('name', '=', $this->request->post['name'])->where('category_id', '=', $this->request->post['category'])->first();

		if( $is_exist != NULL ):
			echo json_encode( array( "status" => "failed", "message" => "This staff type name and grade combination exists" ), JSON_PRETTY_PRINT );
			exit();
		endif;

		try {
			$this->model_staff_type->where('id', '=', $this->request->post['id'])->update([
				'category_id' => $this->request->post['category'],
				'name' => $this->request->post['name']
			]);
			echo json_encode( array("status" => "success"), JSON_PRETTY_PRINT );
			exit();
		} catch (\Illuminate\Database\QueryException $e) {
			// var_dump( $e->errorInfo );
			echo json_encode( array( "status" => "failed", "message" => "Unable to edit staff type. Please verify that details are not duplicating" ), JSON_PRETTY_PRINT );
			exit();
		}
	}

	public function ajax_removestafftype() {

		//CHECK LOGIN STATUS
		if( !isset($_SESSION['user']) OR $_SESSION['user']['is_login'] != true ):
			header( 'Location:' . $this->config->get('base_url') . '/logout' );
			exit();
		endif;

		// SET JSON HEADER
		header('Content-Type: application/json');

		// MODEL
		$this->load->model('staff');
		$this->load->model('staff/category');
		$this->load->model('staff/type');
		$this->load->model('user');
		
		// PERMISSION
        if ( !$this->model_user->find($_SESSION['user']['id'])->hasPermission('management-index-delete-any') ):
            echo json_encode( array( "status" => "error", "message" => "Permission denied" ), JSON_PRETTY_PRINT );
            exit();
        endif;
		
		if ( isset($this->request->post['type_id']) AND !empty($this->request->post['type_id']) ):
			$is_available_type = $this->model_staff->select('id')->where('type_id', '=', $this->request->post['type_id'])->first();

			if ( $is_available_type == NULL ):
				if ( $this->model_staff_type->find($this->request->post['type_id'])->delete() ):
					echo json_encode( array( "status" => "success" ), JSON_PRETTY_PRINT );
					exit();
				else:
					echo json_encode( array( "status" => "error", "message" => "Cannot delete this Staff Type. Please contact system administrator" ), JSON_PRETTY_PRINT );
                    exit();
				endif;
			else:
				echo json_encode( array( "status" => "error", "message" => "Cannot delete this Staff Type. One or More Staff is relevant to this Staff Type" ), JSON_PRETTY_PRINT );
				exit();
			endif;
		else:
			echo json_encode( array( "status" => "error", "message" => "Please select a valid Staff Type" ), JSON_PRETTY_PRINT );
			exit();
		endif;
	}

	public function ajax_add_user_role() {

		//CHECK LOGIN STATUS
		if( !isset($_SESSION['user']) OR $_SESSION['user']['is_login'] != true ):
			header( 'Location:' . $this->config->get('base_url') . '/logout' );
			exit();
		endif;

		/**
		  * This method will receive ajax request from
		  * the front end with the payload
		  * 
		  *	- user_role_name description
		  * 
		  * We need to validate the data and then perform
		  * the following tasks.
		  *    - validate
		  *    - CRUD
		  *    - response ( JSON )
		  */
 
		// SET JSON HEADER
		header('Content-Type: application/json');
		
		  //  MODEL
		$this->load->model('user');
		$this->load->model('user/role');
		$this->load->model('user');
		
		// PERMISSION
        if ( !$this->model_user->find($_SESSION['user']['id'])->hasPermission('management-index-add-any') ):
            echo json_encode( array( "error" => "Permission denied" ), JSON_PRETTY_PRINT );
            exit();
        endif;

		// VALIDATION : user_role_name
		$is_valid_user_role_name = GUMP::is_valid($this->request->post, array('user_role_name' => 'required|valid_name|min_len,1'));
		if ( $is_valid_user_role_name !== true ):
			echo json_encode( array( "error" => "Please select a valid role name" ), JSON_PRETTY_PRINT );
			exit();
		endif;
		
		// VALIDATION : user_role_description
		$is_valid_user_role_description = GUMP::is_valid($this->request->post, array('user_role_description' => 'valid_name'));
		if ( $is_valid_user_role_description !== true ):
			echo json_encode( array( "error" => "Please enter a valid role description" ), JSON_PRETTY_PRINT );
			exit();
		endif;
		
			// user_role_name IS ENTERED : CHECK FOR DUPLICATE
			if ( $this->model_user_role->select('id')->where('name', '=', $this->request->post['user_role_name'])->first() != NULL ):
				echo json_encode( array( "error" => "This Role is already exists" ), JSON_PRETTY_PRINT );
				exit();
			endif;
		
		$this->model_user_role->name = $this->request->post['user_role_name'];
		$this->model_user_role->description = $this->request->post['user_role_description'];
		
		// SUBMIT
		if ( $this->model_user_role->save() ):
			echo json_encode( array( "status" => "success" ), JSON_PRETTY_PRINT );
		else:
			echo json_encode( array( "status" => "failed" ), JSON_PRETTY_PRINT );
		endif;
	}

	public function ajax_edituser_role() {

		//CHECK LOGIN STATUS
		if( !isset($_SESSION['user']) OR $_SESSION['user']['is_login'] != true ):
			header( 'Location:' . $this->config->get('base_url') . '/logout' );
			exit();
		endif;

		/**
		  * This method will receive ajax request from
		  * the front end with the payload
		  * 
		  *	- user_role_name description
		  * 
		  * We need to validate the data and then perform
		  * the following tasks.
		  *    - validate
		  *    - CRUD
		  *    - response ( JSON )
		  */
 
		// SET JSON HEADER
		header('Content-Type: application/json');

		//  MODEL
		$this->load->model('user');
		$this->load->model('user/role');
		$this->load->model('user');
		
		// PERMISSION
        if ( !$this->model_user->find($_SESSION['user']['id'])->hasPermission('management-index-edit-any') ):
            echo json_encode( array( "status" => "failed", "message" => "Permission denied" ), JSON_PRETTY_PRINT );
            exit();
        endif;

		// VALIDATE staff_type ID
		$is_exist = $this->model_user_role->select('id')->where('id', '=', $this->request->post['id'])->first();

		if( $is_exist == NULL ):
			echo json_encode( array( "status" => "failed", "message" => "Editing User role doesn't exists" ), JSON_PRETTY_PRINT );
			exit();
		endif;

		// VALIDATION : user_role_name
		$is_valid_user_role_name = GUMP::is_valid($this->request->post, array('name' => 'required|valid_name|min_len,1'));
		if ( $is_valid_user_role_name !== true ):
			echo json_encode( array( "status" => "failed", "message" => "Please select a valid role name" ), JSON_PRETTY_PRINT );
			exit();
		endif;
		
		// VALIDATION : user_role_description
		$is_valid_user_role_description = GUMP::is_valid($this->request->post, array('description' => 'valid_name'));
		if ( $is_valid_user_role_description !== true ):
			echo json_encode( array( "status" => "failed", "message" => "Please enter a valid role description" ), JSON_PRETTY_PRINT );
			exit();
		endif;
		
		// NAME CHANGED CHECK
		$is_changed = $this->model_user_role->where('id', '=', $this->request->post['id'])->first();
		if ( $is_changed->name != $this->request->post['name'] ):
			// user_role_name IS ENTERED : CHECK FOR DUPLICATE
			if ( $this->model_user_role->select('id')->where('name', '=', $this->request->post['name'])->first() != NULL ):
				echo json_encode( array( "status" => "failed", "message" => "This Role is already exists" ), JSON_PRETTY_PRINT );
				exit();
			endif;
		endif;

		if ( $this->request->post['description'] == "" ):
			$this->request->post['description'] == NULL;
		endif;
		
		try {
			$this->model_user_role->where('id', '=', $this->request->post['id'])->update([
				'name' => $this->request->post['name'],
				'description' => $this->request->post['description']
			]);
			echo json_encode( array("status" => "success"), JSON_PRETTY_PRINT );
			exit();

		} catch (\Illuminate\Database\QueryException $e) {
			// var_dump( $e->errorInfo );
			echo json_encode( array( "status" => "failed", "message" => "Unable to edit staff type. Please verify that details are not duplicating" ), JSON_PRETTY_PRINT );
			exit();
		}
	}

	public function ajax_removeuserrole() {

		//CHECK LOGIN STATUS
		if( !isset($_SESSION['user']) OR $_SESSION['user']['is_login'] != true ):
			header( 'Location:' . $this->config->get('base_url') . '/logout' );
			exit();
		endif;

		// SET JSON HEADER
		header('Content-Type: application/json');

		// MODEL
		$this->load->model('user');
		$this->load->model('user/role');
		$this->load->model('user');
		
		// PERMISSION
        if ( !$this->model_user->find($_SESSION['user']['id'])->hasPermission('management-index-delete-any') ):
            echo json_encode( array( "status" => "error", "message" => "Permission denied" ), JSON_PRETTY_PRINT );
            exit();
        endif;
		
		if ( isset($this->request->post['role_id']) AND !empty($this->request->post['role_id']) ):
			$is_available_user = $this->model_user->select('id')->where('role_id', '=', $this->request->post['role_id'])->first();

			if ( $is_available_user == NULL ):
				if ( $this->model_user_role->find($this->request->post['role_id'])->delete() ):
					echo json_encode( array( "status" => "success" ), JSON_PRETTY_PRINT );
					exit();
				else:
					echo json_encode( array( "status" => "error", "message" => "Cannot delete this user role. Please contact system administrator" ), JSON_PRETTY_PRINT );
                    exit();
				endif;
			else:
				echo json_encode( array( "status" => "error", "message" => "Cannot delete this user role. One or More user has this role" ), JSON_PRETTY_PRINT );
				exit();
			endif;
		else:
			echo json_encode( array( "status" => "error", "message" => "Please select a valid user role" ), JSON_PRETTY_PRINT );
			exit();
		endif;
	}

}

?>