<?php

class CommonTopmenu extends Controller {
	public function index($data) {
		return $this->load_view('common/topmenu', $data);
	}
}

?>