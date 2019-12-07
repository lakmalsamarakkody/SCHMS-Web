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
		$this->load->model('User');
		$this->load->model('Staff');

		//Login
		if (isset($this->request->post['is_submit']) AND $this->request->post['login_as'] == "staff" ):
			$validate = GUMP::is_valid($this->request->post,['username' => 'required']);

			if($validate == true):

				$User = $this->model_user->where('username',$this->request->post['username'])->where('user_type', '=', 'staff')->first();

				if($User != null):

					if(password_verify ($this->request->post['password'],$User->password)):
						$_SESSION['user']['is_login'] = true;
						$_SESSION['user']['id'] = $User->id;
						header('Location:' . $this->config->get('base_url') . '/home');
						exit();
					else:
						$data['msg'] = "Incorrect Password";
					endif;

				else:

					$User = $this->model_staff->where('employee_number',$this->request->post['username'])->where('nic', '=', $this->request->post['password'])->first();

					if($User != null):
						$data['msg'] = "Available Staff detected";
					else:
						$data['msg'] = "No Staff is registered to match these details";
					endif;
				endif;
			
			else:
				$data['msg'] = "Enter your Username";
			endif;
		
		elseif (isset($this->request->post['is_submit']) AND $this->request->post['login_as'] == "student" ):
			$validate = GUMP::is_valid($this->request->post,['username' => 'required']);

			if($validate == true):

				$User = $this->model_user->where('username',$this->request->post['username'])->where('user_type', '=', 'student')->first();

				if($User != null):

					if(password_verify ($this->request->post['password'],$User->password)):
						$_SESSION['user']['is_login'] = true;
						$_SESSION['user']['id'] = $User->id;
						header('Location:' . $this->config->get('base_url') . '/home');
						exit();
					else:
						$data['msg'] = "Incorrect Password";
					endif;

				else:

					$User = DB::table('student')
					->join('student_has_parent', 'student.id', 'student_has_parent.student_id')
					->join('parent', 'student_has_parent.parent_id', 'parent.id')
					->where('student.admission_no',$this->request->post['username'])
					->where('parent.nic', '=', $this->request->post['password'])->first();

					if($User != null):
						$data['msg'] = "Available Student detected";
					else:
						$data['msg'] = "No Student is enrolled to match these details";
					endif;
				endif;
			
			else:
				$data['msg'] = "Enter your Username";
			endif;

		elseif (isset($this->request->post['is_submit']) AND $this->request->post['login_as'] == "parent" ):
			$validate = GUMP::is_valid($this->request->post,['username' => 'required']);

			if($validate == true):

				$User = $this->model_user->where('username',$this->request->post['username'])->where('user_type', '=', 'parent')->first();

				if($User != null):

					if(password_verify ($this->request->post['password'],$User->password)):
						$_SESSION['user']['is_login'] = true;
						$_SESSION['user']['id'] = $User->id;
						header('Location:' . $this->config->get('base_url') . '/home');
						exit();
					else:
						$data['msg'] = "Incorrect Password";
					endif;

				else:

					$User = DB::table('parent')
					->join('student_has_parent', 'parent.id', 'student_has_parent.parent_id')
					->join('student', 'student_has_parent.student_id', 'student.id')
					->where('parent.nic',$this->request->post['username'])
					->where('student.admission_no', '=', $this->request->post['password'])->first();

					if($User != null):
						$data['msg'] = "Available parent detected";
					else:
						$data['msg'] = "No Parent is enrolled to match these details";
					endif;
				endif;
			
			else:
				$data['msg'] = "Enter your Username";
			endif;

		endif;

		// RENDER VIEW
		$this->load->view('login/index', $data);
        
	}


	public function ajax_login() {

		// SET JSON HEADER
		header('Content-Type: application/json');

		// MODEL
		$this->load->model('User');
		$this->load->model('Staff');

		//Login
		if (isset($this->request->post['is_submit']) AND $this->request->post['login_as'] == "staff" ):
			$validate = GUMP::is_valid($this->request->post,['username' => 'required']);

			if($validate == true):

				$User = $this->model_user->where('username',$this->request->post['username'])->where('user_type', '=', 'staff')->first();

				if($User != null):

					if(password_verify ($this->request->post['password'],$User->password)):
						$_SESSION['user']['is_login'] = true;
						$_SESSION['user']['id'] = $User->id;
						header('Location:' . $this->config->get('base_url') . '/home');
						// $login['location']['url'] = $this->config->get('base_url')."/home";
						exit();
					else:
						$data['msg'] = "Incorrect Password";
					endif;

				else:

					$User = $this->model_staff->where('employee_number',$this->request->post['username'])->where('nic', '=', $this->request->post['password'])->first();

					if($User != null):
						$data['msg'] = "Available Staff detected";
					else:
						$data['msg'] = "No Staff is registered to match these details";
					endif;
				endif;
			
			else:
				$data['msg'] = "Enter your Username";
			endif;
		
		elseif (isset($this->request->post['is_submit']) AND $this->request->post['login_as'] == "student" ):
			$validate = GUMP::is_valid($this->request->post,['username' => 'required']);

			if($validate == true):

				$User = $this->model_user->where('username',$this->request->post['username'])->where('user_type', '=', 'student')->first();

				if($User != null):

					if(password_verify ($this->request->post['password'],$User->password)):
						$_SESSION['user']['is_login'] = true;
						$_SESSION['user']['id'] = $User->id;
						header('Location:' . $this->config->get('base_url') . '/home');
						exit();
					else:
						$data['msg'] = "Incorrect Password";
					endif;

				else:

					$User = DB::table('student')
					->join('student_has_parent', 'student.id', 'student_has_parent.student_id')
					->join('parent', 'student_has_parent.parent_id', 'parent.id')
					->where('student.admission_no',$this->request->post['username'])
					->where('parent.nic', '=', $this->request->post['password'])->first();

					if($User != null):
						$data['msg'] = "Available Student detected";
					else:
						$data['msg'] = "No Student is enrolled to match these details";
					endif;
				endif;
			
			else:
				$data['msg'] = "Enter your Username";
			endif;

		elseif (isset($this->request->post['is_submit']) AND $this->request->post['login_as'] == "parent" ):
			$validate = GUMP::is_valid($this->request->post,['username' => 'required']);

			if($validate == true):

				$User = $this->model_user->where('username',$this->request->post['username'])->where('user_type', '=', 'parent')->first();

				if($User != null):

					if(password_verify ($this->request->post['password'],$User->password)):
						$_SESSION['user']['is_login'] = true;
						$_SESSION['user']['id'] = $User->id;
						header('Location:' . $this->config->get('base_url') . '/home');
						exit();
					else:
						$data['msg'] = "Incorrect Password";
					endif;

				else:

					$User = DB::table('parent')
					->join('student_has_parent', 'parent.id', 'student_has_parent.parent_id')
					->join('student', 'student_has_parent.student_id', 'student.id')
					->where('parent.nic',$this->request->post['username'])
					->where('student.admission_no', '=', $this->request->post['password'])->first();

					if($User != null):
						$data['msg'] = "Available parent detected";
					else:
						$data['msg'] = "No Parent is enrolled to match these details";
					endif;
				endif;
			
			else:
				$data['msg'] = "Enter your Username";
			endif;

		endif;

		// RENDER VIEW
		$this->load->view('login/index', $data);
        
	}
}
?>