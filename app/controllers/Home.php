<?php

class Home extends Controller {
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

		//Check Login Status
		// if( !isset($_SESSION['user']) OR $_SESSION['user']['is_login'] != true ):

		// 	header( 'Location:' . $this->config->get('base_url') . '/logout' );
		// 	exit();

		// endif;

		// RENDER VIEW
		$this->load->view('home/index', $data);

	}
}

?>