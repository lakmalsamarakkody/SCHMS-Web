<?php

class CommonSidenav extends Controller {
	public function index($data) {

		// CHECK LOGIN STATUS
		if( !isset($_SESSION['user']) OR $_SESSION['user']['is_login'] != true ):
			header( 'Location:' . $this->config->get('base_url') . '/logout' );
			exit();
		endif;

		// MODEL
		$this->load->model('student');
		$this->load->model('staff');
		$this->load->model('parent');
		$this->load->model('coach');
		$this->load->model('user');

		$user_model = "model_".$_SESSION['user']['type'];
		$ref_id = $this->model_user->select('ref_id')->where('id', '=', $_SESSION['user']['id'])->first()->ref_id;
		$profile = $this->$user_model->where('id', '=', $ref_id)->first();

		// USER DATA
		$data['user']['view_name'] = $profile->initials." ".$profile->surname;
		$data['user']['type'] = $_SESSION['user']['type'];
		$data['user']['id'] = $ref_id;
		
		// RETURN VIEW
		return $this->load_view('common/sidenav', $data);
	}
}

?>
