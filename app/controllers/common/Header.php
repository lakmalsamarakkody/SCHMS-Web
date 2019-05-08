<?php

class CommonHeader extends Controller {
	public function index($data) {
		return $this->load_view('common/header', $data);
	}
}

?>