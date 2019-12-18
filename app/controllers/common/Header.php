<?php

class CommonHeader extends Controller {
	public function index($data) {

		$this->load->model('user');
		if ( isset($_SESSION['user']['id']) ):
			$data['user']['theme'] = $this->model_user->findOrFail($_SESSION['user']['id'])->theme;
		else:
			$data['user']['theme'] = 'Default';
		endif;

		return $this->load_view('common/header', $data);
	}
}

?>