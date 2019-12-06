<?php

class Login extends Controller {
    public function index() {
    
        // SITE DETAILS
		$data['app']['url']			= $this->config->get('base_url');
		$data['app']['title']		= $this->config->get('site_title');
		$data['app']['theme']		= $this->config->get('app_theme');

		// HEADER / FOOTER
		$data['template']['header']		= $this->load->controller('common/header', $data);
		$data['template']['footer']		= $this->load->controller('common/footer', $data);

		$this->load->model('User');
		$this->load->model('Staff');

		//Login
		if (isset($this->request->post['is_submit']) AND $this->request->post['login_as'] == "staff"  ):

			$validate = GUMP::is_valid($this->request->post,['username' => 'required']);

			if($validate == true):

				$User = $this->model_user::where('username',$this->request->post['username'])->where('user_type', '=', 'staff')->first();

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

						if($_POST['password'] == $User->nic):

							$data['msg'] = "Available Staff detected";

						else:

							$data['msg'] = "Incorrect NIC";

						endif;
					
					else:

						$data['msg'] = "No Staff is registered to this NIC";

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