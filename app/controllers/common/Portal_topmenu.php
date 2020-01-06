<?php

use Carbon\Carbon;

class CommonPortal_topmenu extends Controller {
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

		$data['date_now'] = Carbon::now()->isoFormat('dddd, DD MMMM - YYYY');
		$data['time_now'] = Carbon::now()->isoFormat( 'h:mm:ss A' );

		$data['user']['theme'] = $this->model_user->findOrFail($_SESSION['user']['id'])->theme;


		$user_model = "model_".$_SESSION['user']['type'];
		$ref_id = $this->model_user->select('ref_id')->where('id', '=', $_SESSION['user']['id'])->first()->ref_id;
		$profile = $this->$user_model->where('id', '=', $ref_id)->first();
		
		// USER DATA
		$data['user']['view_name'] = $profile->initials." ".$profile->surname;
		$data['user']['type'] = $_SESSION['user']['type'];
		$data['user']['id'] = $ref_id;

		return $this->load_view('common/portal_topmenu', $data);
	}
}

?>