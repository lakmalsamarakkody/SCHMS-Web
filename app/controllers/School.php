<?php

class School extends Controller {
	public function index() {

		// SITE DETAILS
		$data['app']['url']			= $this->config->get('base_url');
		$data['app']['title']		= $this->config->get('site_title');
		$data['app']['theme']		= $this->config->get('app_theme');

		// HEADER / FOOTER
		$data['template']['header']		= $this->load->controller('common/header', $data);
		$data['template']['footer']		= $this->load->controller('common/footer', $data);
		$data['template']['sidenav']	= $this->load->controller('common/sidenav', $data);
		$data['template']['topmenu']	= $this->load->controller('common/topmenu', $data);

		//CHECK LOGIN STATUS
		if( !isset($_SESSION['user']) OR $_SESSION['user']['is_login'] != true ):

			header( 'Location:' . $this->config->get('base_url') . '/logout' );
			exit();

		endif;

		//MODEL
		$this->load->model('class');
		$this->load->model('grade');
		$this->load->model('staff');

		foreach( $this->model_class->select('id', 'grade_id', 'staff_id','name')->get() as $key => $element ):
			$data['class'][$key]['id'] = $element->id;
			$data['class'][$key]['grade']['id'] = $element->grade_id;
			$data['class'][$key]['staff']['_id'] = $element->staff_id;
			$data['class'][$key]['name'] = $element->name;
			
			$data['class'][$key]['grade']['name'] = $this->model_grade->select('name')->where('id', '=', $element->grade_id)->first()->name;

			$data['class'][$key]['staff'] = $this->model_staff->select('initials', 'surname')->where('id', '=',$element->staff_id)->first()->toArray();
        endforeach;

		// RENDER VIEW
		$this->load->view('school/index', $data);

	}
}

?>