<?php

class CommonFooter extends Controller {
	public function index($data) {
		return $this->load_view('common/footer', $data);
	}
}

?>