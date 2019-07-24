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
		if (isset($_POST['is_submit'])):

			$this->load->model('User');

			$validate = GUMP::is_valid($_POST,['username' => 'required']);

			if($validate == true):

				$User = $this->model_user::where('username',$_POST['username']) ->first();

				if($User != null):

					if(password_verify ($_POST['password'],$User->password) == true):

						$data['msg'] = "Logged in Successfully";

					else:

						$data['msg'] = "Incorrect Password";

					endif;

				else:

					$User = $this->model_user::where('emp_id',$_POST['username']) -> where('username',"") -> where('password',"") ->first();

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