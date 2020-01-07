<?php

use Illuminate\Database\Capsule\Manager as DB;

class Login extends Controller {
    public function index() {
    
        // SITE DETAILS
		$data['app']['url']			= $this->config->get('base_url');
		$data['app']['title']		= $this->config->get('site_title');
		$data['app']['theme']		= $this->config->get('app_theme');

		// HEADER / FOOTER
		$data['template']['header']		= $this->load->controller('common/header', $data);
		$data['template']['footer']		= $this->load->controller('common/footer', $data);

		// MODEL
		$this->load->model('user');

		// STAFF LOGIN
		if (isset($this->request->post['is_login']) AND $this->request->post['login_as'] == "staff" ):

			$validate = GUMP::is_valid($this->request->post,['username' => 'required|alpha_numeric|min_len,6|max_len,20']);
			if($validate == TRUE):

				// CHECK ANY USER FOR THIS USERNAME
				$user = $this->model_user->where('username',$this->request->post['username'])->where('user_type', '=', 'staff')->first();
				if($user != NULL):

					// CHECK USER IS ACTIVE
					if( $user->status == "Active" ):
						// CHECK PASSWORD IS CORRECT
						if(password_verify ($this->request->post['password'],$user->password)):
							// PROCESS TO LOGIN
							$_SESSION['user']['is_login'] = TRUE;
							$_SESSION['user']['id'] = $user->id;
							$_SESSION['user']['type'] = 'staff';
							header('Location:' . $this->config->get('base_url') . '/home');
							exit();
						else:
							// DISPLAY MESSAGE PASSWORD IS INCORRECT
							$data['msg'] = "Incorrect Password";
						endif;
					else:
						// DISPLAY MESSAGE USER IS DEACTIVE
						$data['msg'] = "Sorry, your account is disabled. please contact your system administrator";
					endif;
				else:
					// DISPLAY MESSAGE USER NOT FOUND
					$data['msg'] = "User not found";
				endif;
			
			else:
				$data['msg'] = "Enter your Username";
			endif;

		// STUDENT LOGIN
		elseif (isset($this->request->post['is_login']) AND $this->request->post['login_as'] == "student" ):
			$validate = GUMP::is_valid($this->request->post,['username' => 'required|alpha_numeric|min_len,6|max_len,20']);
			if($validate == TRUE):

				// CHECK ANY USER FOR THIS USERNAME
				$user = $this->model_user->where('username',$this->request->post['username'])->where('user_type', '=', 'student')->first();
				if($user != NULL):

					// CHECK USER IS ACTIVE
					if( $user->status == "Active" ):
						// CHECK PASSWORD IS CORRECT
						if(password_verify ($this->request->post['password'],$user->password)):
							// PROCESS TO LOGIN
							$_SESSION['user']['is_login'] = TRUE;
							$_SESSION['user']['id'] = $user->id;
							$_SESSION['user']['type'] = 'student';
							header('Location:' . $this->config->get('base_url') . '/portal/student/'. $user->ref_id);
							exit();
						else:
							// DISPLAY MESSAGE PASSWORD IS INCORRECT
							$data['msg'] = "Incorrect Password";
						endif;
					else:
						// DISPLAY MESSAGE USER IS DEACTIVE
						$data['msg'] = "Sorry, your account is disabled. please contact your system administrator";
					endif;
				else:
					// DISPLAY MESSAGE USER NOT FOUND
					$data['msg'] = "User not found";
				endif;
			
			else:
				$data['msg'] = "Enter your Username";
			endif;

		// PARENT LOGIN
		elseif (isset($this->request->post['is_login']) AND $this->request->post['login_as'] == "parent" ):
			$validate = GUMP::is_valid($this->request->post,['username' => 'required|alpha_numeric|min_len,6|max_len,20']);
			if($validate == TRUE):

				// CHECK ANY USER FOR THIS USERNAME
				$user = $this->model_user->where('username',$this->request->post['username'])->where('user_type', '=', 'parent')->first();
				if($user != NULL):

					// CHECK USER IS ACTIVE
					if( $user->status == "Active" ):
						// CHECK PASSWORD IS CORRECT
						if(password_verify ($this->request->post['password'],$user->password)):
							// PROCESS TO LOGIN
							$_SESSION['user']['is_login'] = TRUE;
							$_SESSION['user']['id'] = $user->id;
							$_SESSION['user']['type'] = 'parent';
							header('Location:' . $this->config->get('base_url') . '/portal/parent/'. $user->ref_id);
							exit();
						else:
							// DISPLAY MESSAGE PASSWORD IS INCORRECT
							$data['msg'] = "Incorrect Password";
						endif;
					else:
						// DISPLAY MESSAGE USER IS DEACTIVE
						$data['msg'] = "Sorry, your account is disabled. please contact your system administrator";
					endif;
				else:
					// DISPLAY MESSAGE USER NOT FOUND
					$data['msg'] = "User not found";
				endif;
			
			else:
				$data['msg'] = "Enter your Username";
			endif;

		// COACH LOGIN
		elseif (isset($this->request->post['is_login']) AND $this->request->post['login_as'] == "coach" ):
			// DISPLAY MESSAGE FUTURE UPDATE
			$data['msg'] = "COACH PORTAL FEATURE WILL BE AVAILABLE IN A FUTURE UPDATE";

		// INVALID LOGIN TYPE
		elseif (isset($this->request->post['is_login'])):
			// DISPLAY MESSAGE INVALD LOGIN ENTRY
			$data['msg'] = "Invalid Login type. Refresh the webpage";
		endif;

		// RENDER VIEW
		$this->load->view('login/index', $data);
	}


	public function ajax_register() {

		// SET JSON HEADER
		header('Content-Type: application/json');

		// MODEL
		$this->load->model('user');
		$this->load->model('staff');
		$this->load->model('student');
		$this->load->model('parent');
		$this->load->model('coch');

		// VALIDATION : unique_id
		$is_valid_unique_id = GUMP::is_valid($this->request->post, array('unique_id' => 'required|numeric|min_len,1|max_len,6'));
		if ( $is_valid_unique_id !== true ):
			echo json_encode( array( "status" => "failed", "message" => "Please enter your valid admission/employee ID number" ), JSON_PRETTY_PRINT );
			exit();
		endif;

		// VALIDATION : nic
		$is_valid_nic = GUMP::is_valid($this->request->post, array('nic' => "required"));
		if ( $is_valid_nic === true ):
			if ( preg_match("/^([0-9]{9}[x|X|v|V]|[0-9]{12})$/", $this->request->post['nic']) == false ):
				echo json_encode( array( "status" => "failed", "message" => "Please enter valid NIC number" ), JSON_PRETTY_PRINT );
				exit();
			endif;
		else:
			echo json_encode( array( "status" => "failed", "message" => "Please enter a NIC number" ), JSON_PRETTY_PRINT );
			exit();
		endif;

		// VALIDATION : register_as
		$is_valid_register_as = GUMP::is_valid($this->request->post, array('register_as' => 'required|contains_list,staff;student;parent;coach'));
		if ( $is_valid_register_as !== true ):
			echo json_encode( array("status" => "failed", "message" => "Please select relevent option from register as list" ), JSON_PRETTY_PRINT );
			exit();
		endif;

		// REGISTER
		if (isset($this->request->post['is_register'])):

			// REGISTER STAFF 
			if ( !empty($this->request->post['register_as']) AND $this->request->post['register_as'] == "staff" ):

				// CHECK ANY EXISITNG STAFF
				$available_staff = $this->model_staff->where('employee_number',$this->request->post['unique_id'])->where('nic', '=', $this->request->post['nic'])->first();
				if($available_staff != NULL):

					// CHECK ANY EXISITNG USER EXISTS
					$available_user = $this->model_user->where('ref_id', '=', $available_staff->id)->where('user_type', '=', 'staff')->first();
					if($available_user == NULL):
						echo json_encode( array( "status" => "success" ), JSON_PRETTY_PRINT );
						exit();
						
					else:
						// DISPLAY MESSAGE EXISTING USER FOUND
						echo json_encode( array("status" => "failed", "message" => "This employee ID is already registered" ), JSON_PRETTY_PRINT );
						exit();
					endif;
					
				else:
					// DISPLAY MESSAGE USER NOT FOUND
					echo json_encode( array("status" => "failed", "message" => "Sorry, we couldn't find any matching staff record" ), JSON_PRETTY_PRINT );
					exit();
				endif;

			// REGISTER STUDENT 
			elseif ( !empty($this->request->post['register_as']) AND $this->request->post['register_as'] == "student" ):

				// CHECK ANY EXISITNG STUDENT
				$available_student = DB::table('student')
					->join('student_has_parent', 'student.id', 'student_has_parent.student_id')
					->join('parent', 'student_has_parent.parent_id', 'parent.id')
					->where('student.admission_no',$this->request->post['unique_id'])
					->where('parent.nic', '=', $this->request->post['nic'])->first();
				if($available_student != NULL):

					// CHECK ANY EXISITNG USER EXISTS
					$available_user = $this->model_user->where('ref_id', '=', $available_student->id)->where('user_type', '=', 'student')->first();
					if ( $available_user == NULL ):
						echo json_encode( array( "status" => "success" ), JSON_PRETTY_PRINT );
						exit();
					else:
						// DISPLAY MESSAGE EXISTING USER FOUND
						echo json_encode( array("status" => "failed", "message" => "This admission ID is already registered" ), JSON_PRETTY_PRINT );
						exit();
					endif;
				else:
					// DISPLAY MESSAGE USER NOT FOUND
					echo json_encode( array("status" => "failed", "message" => "Sorry, we couldn't find any matching student record" ), JSON_PRETTY_PRINT );
					exit();
				endif;

			// REGISTER PARENT 
			elseif ( !empty($this->request->post['register_as']) AND $this->request->post['register_as'] == "parent" ):

				// CHECK ANY EXISITNG PARENT
				$available_parent = DB::table('parent')
					->join('student_has_parent', 'parent.id', 'student_has_parent.parent_id')
					->join('student', 'student_has_parent.student_id', 'student.id')
					->where('parent.nic',$this->request->post['nic'])
					->where('student.admission_no', '=', $this->request->post['unique_id'])->first();
				if($available_parent != NULL):

					// CHECK ANY EXISITNG USER EXISTS
					$available_user = $this->model_user->where('ref_id', '=', $available_parent->id)->where('user_type', '=', 'parent')->first();
					if ( $available_user == NULL ):
						echo json_encode( array( "status" => "success" ), JSON_PRETTY_PRINT );
						exit();
					else:
						// DISPLAY MESSAGE EXISTING USER FOUND
						echo json_encode( array("status" => "failed", "message" => "This admission ID is already registered" ), JSON_PRETTY_PRINT );
						exit();
					endif;
				else:
					// DISPLAY MESSAGE USER NOT FOUND
					echo json_encode( array("status" => "failed", "message" => "Sorry, we couldn't find any matching parent record" ), JSON_PRETTY_PRINT );
					exit();
				endif;
			
			// REGISTER COACH 
			elseif ( !empty($this->request->post['register_as']) AND $this->request->post['register_as'] == "coach" ):

				// DISPLAY MESSAGE FUTURE UPDATE
				echo json_encode( array("status" => "failed", "message" => "<b>COACH PORTAL FEATURE WILL BE AVAILABLE IN A FUTURE UPDATE</b>" ), JSON_PRETTY_PRINT );
				exit();

			// INVALID REGISTRATION TYPE
			else:
				// DISPLAY MESSAGE INVALD REGISTRATION ENTRY
				echo json_encode( array("status" => "failed", "message" => "Invalid registration type. Refresh the webpage" ), JSON_PRETTY_PRINT );
				exit();
			endif;

		else:
			echo json_encode( array("status" => "failed", "message" => "Refresh the webpage" ), JSON_PRETTY_PRINT );
			exit();
		endif;
	}

	public function ajax_create_user() {

		// SET JSON HEADER
		header('Content-Type: application/json');

		// MODEL
		$this->load->model('user');
		$this->load->model('staff');
		$this->load->model('student');
		$this->load->model('parent');
		$this->load->model('coch');

		// VALIDATION : unique_id
		$is_valid_unique_id = GUMP::is_valid($this->request->post, array('unique_id' => 'required|numeric|min_len,1|max_len,6'));
		if ( $is_valid_unique_id !== true ):
			echo json_encode( array("status" => "failed", "message" => "Please select a valid registration ID" ), JSON_PRETTY_PRINT );
			exit();
		endif;

		// VALIDATION : nic
		$is_valid_nic = GUMP::is_valid($this->request->post, array('nic' => "required"));
		if ( $is_valid_nic === true ):
			if ( preg_match("/^([0-9]{9}[x|X|v|V]|[0-9]{12})$/", $this->request->post['nic']) == false ):
				echo json_encode( array("status" => "failed", "message" => "Wrong NIC Format. Please enter a valid NIC" ), JSON_PRETTY_PRINT );
				exit();
			endif;
		else:
			echo json_encode( array("status" => "failed", "message" => "Please enter a valid NIC number for guardian" ), JSON_PRETTY_PRINT );
			exit();
		endif;

		// VALIDATION : user_type
		$is_valid_user_type = GUMP::is_valid($this->request->post, array('user_type' => 'required|contains_list,staff;student;parent;coach'));
		if ( $is_valid_user_type !== true ):
			echo json_encode( array("status" => "failed", "message" => "Please select relevent option from register as list" ), JSON_PRETTY_PRINT );
			exit();
		endif;

		// VALIDATION : username
		$is_valid_username = GUMP::is_valid($this->request->post, array('username' => 'required|alpha_numeric|min_len,6|max_len,20'));
		if ( $is_valid_username !== true ):
			echo json_encode( array("status" => "failed", "message" => "Please select a valid username of minimum 6 characters. only letters and numbers are allowed" ), JSON_PRETTY_PRINT );
			exit();
		endif;

		// VALIDATION : password
		$is_valid_password = GUMP::is_valid($this->request->post, array('password' => 'required|alpha_dash|min_len,6|max_len,20'));
		if ( $is_valid_password !== true ):
			echo json_encode( array("status" => "failed", "message" => "Please select a valid password of minimum 6 characters without any special characters and spaces except dash(-),underscore(_)" ), JSON_PRETTY_PRINT );
			exit();
		endif;

		// VALIDATION : confirm_password
		$is_valid_confirm_password = GUMP::is_valid($this->request->post, array('confirm_password' => 'alpha_dash|min_len,6|max_len,20'));
		if ( $is_valid_confirm_password !== true ):
			echo json_encode( array("status" => "failed", "message" => "Please enter a valid confirmation password as same as the password" ), JSON_PRETTY_PRINT );
			exit();
		endif;

		// CHECK : PASSWORD = CONFIRM PASSWORD
		if ( $this->request->post['confirm_password'] != $this->request->post['password'] ):
			echo json_encode( array("status" => "failed", "message" => "Password and confirm pssword doesn't match" ), JSON_PRETTY_PRINT );
			exit();
		endif;

		// GET REF_ID FROM UNIQUE ID
		if ( $this->request->post['user_type'] == "staff" ):
			$ref_id = $this->model_staff->select('id')->where('employee_number', '=', $this->request->post['unique_id'])->first()->id;
		elseif ( $this->request->post['user_type'] == "student" ):
			$ref_id = $this->model_student->select('id')->where('admission_no', '=', $this->request->post['unique_id'])->first()->id;
		elseif ( $this->request->post['user_type'] == "parent" ):
			$ref_id = $this->model_parent->select('id')->where('nic', '=', $this->request->post['nic'])->first()->id;
		endif;

		// CHECK REF_ID AND TYPE EXISTS
		if ( $this->model_user->select('ref_id')->where('ref_id', '=', $ref_id)->where('user_type', '=', $this->request->post['user_type'])->first() != NULL ):
			echo json_encode( array( "status" => "failed", "message" => "This REGISTRATION ID and Type already exists." ), JSON_PRETTY_PRINT );
			exit();
		endif;

		// USERNAME ASSIGNED : CHECK FOR DUPLICATE
		if ( $this->model_user->select('id')->where('username', '=', $this->request->post['username'])->first() != NULL ):
			echo json_encode( array( "status" => "failed", "message" => "This username already exists. Try another" ), JSON_PRETTY_PRINT );
			exit();
		endif;

		// INITIATE : USER RECORD
		$this->model_user->user_type = $this->request->post['user_type'];
		$this->model_user->ref_id = $ref_id;
		$this->model_user->username = $this->request->post['username'];
		$this->model_user->password = password_hash($this->request->post['password'], PASSWORD_DEFAULT);
		if ( $this->request->post['user_type'] == "staff" ):
			// SET STATUS : DEACTIVE USER ROLE : GUEST STAFF
			$this->model_user->status = "Deactive";
			$this->model_user->role_id = 6;
		elseif ( $this->request->post['user_type'] == "student" ):
			// SET STATUS : ACTIVE USER ROLE : STUDENT
			$this->model_user->status = "Active";
			$this->model_user->role_id = 3;
		elseif ( $this->request->post['user_type'] == "parent" ):
			// SET STATUS : ACTIVE USER ROLE : PARENT
			$this->model_user->status = "Active";
			$this->model_user->role_id = 4;
		elseif ( $this->request->post['user_type'] == "coach" ):
			// SET STATUS : DEACTIVE USER ROLE : GUEST STAFF
			$this->model_user->status = "Deactive";
			$this->model_user->role_id = 6;
		endif;

		// CHECK : USER RECORD QUERY
		if ( $this->model_user->save() ):
			echo json_encode( array( "status" => "success" ), JSON_PRETTY_PRINT );
			exit();
		else:
			echo json_encode( array( "status" => "failed", "message" => "Unable to create user. Please set username and password" ), JSON_PRETTY_PRINT );
			exit();
		endif;
	}

}
?>