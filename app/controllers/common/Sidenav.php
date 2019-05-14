<?php

class CommonSidenav extends Controller {
	public function index($data) {
		return $this->load_view('common/sidenav', $data);
	}
}

?>
