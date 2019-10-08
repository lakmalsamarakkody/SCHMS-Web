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

		//Login
		if (isset($this->request->post['is_submit']) AND $this->request->post['login_as'] == "staff"  ):

			$this->load->model('User');

			$validate = GUMP::is_valid($this->request->post,['username' => 'required']);

			if($validate == true):

				$User = $this->model_user::where('username',$this->request->post['username']) ->first();

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

					$User = $this->model_user->where('staff_id',$this->request->post['username'])->where('username',"")->where('password',"")->first();

					if($User != null):

						if($_POST['password'] == $User->nic):

							$data['msg'] = "New User detected";

						else:

							$data['msg'] = "Incorrect NIC";

						endif;
					
					else:

						$data['msg'] = "No User found";

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