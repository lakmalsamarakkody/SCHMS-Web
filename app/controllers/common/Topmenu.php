<?php

use Carbon\Carbon;

class CommonTopmenu extends Controller {
	public function index($data) {

		$data['date_now'] = Carbon::now()->isoFormat('dddd, DD MMMM - YYYY');
		$data['time_now'] = Carbon::now()->isoFormat( 'h:mm:ss A' );

		$this->load->model('user');
		$data['user']['theme'] = $this->model_user->findOrFail($_SESSION['user']['id'])->theme;

		return $this->load_view('common/topmenu', $data);
	}
}

?>