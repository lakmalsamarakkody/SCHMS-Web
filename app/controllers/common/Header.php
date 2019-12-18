<?php

class CommonHeader extends Controller {
	public function index($data) {

		$this->load->model('user');
		$data['user']['theme'] = $this->model_user->findOrFail($_SESSION['user']['id'])->theme;

		return $this->load_view('common/header', $data);
	}
}

?>