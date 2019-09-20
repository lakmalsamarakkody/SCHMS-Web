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
		// if( !isset($_SESSION['user']) OR $_SESSION['user']['is_login'] != true ):

		// 	header( 'Location:' . $this->config->get('base_url') . '/logout' );
		// 	exit();

		// endif;

		//MODEL
		$this->load->model('class');
		$this->load->model('grade');
		$this->load->model('staff');
		$this->load->model('religion');
		$this->load->model('subject');
		$this->load->model('student/relation');

		// CLASS
		foreach( $this->model_class->select('id', 'grade_id', 'staff_id','name')->get() as $key => $element ):
			$data['classes'][$key]['id'] = $element->id;
			$data['classes'][$key]['grade']['id'] = $element->grade_id;
			$data['classes'][$key]['staff']['id'] = $element->staff_id;
			$data['classes'][$key]['name'] = $element->name;
			
			$data['classes'][$key]['grade']['name'] = $this->model_grade->select('name')->where('id', '=', $element->grade_id)->first()->name;
			$data['classes'][$key]['staff'] = $this->model_staff->select('initials', 'surname')->where('id', '=',$element->staff_id)->first()->toArray();
		endforeach;

		// GRADE
		foreach( $this->model_grade->select('id', 'name')->get() as $key => $element ):
			$data['grades'][$key]['id'] = $element->id;
			$data['grades'][$key]['name']= $element->name;
		endforeach;
		
		// RELIGION
		foreach( $this->model_religion->select('id', 'name')->get() as $key => $element ):
			$data['religions'][$key]['id'] = $element->id;
			$data['religions'][$key]['name']= $element->name;
		endforeach;

		// SUBJECT
		foreach( $this->model_subject->select('id', 'name', 'si_name')->get() as $key => $element ):
			$data['subjects'][$key]['id'] = $element->id;
			$data['subjects'][$key]['name']= $element->name;
			$data['subjects'][$key]['si_name']= $element->si_name;
		endforeach;

		// RELATIONSHIP
		foreach( $this->model_student_relation->select('id', 'name')->get() as $key => $element ):
			$data['student_relations'][$key]['id'] = $element->id;
			$data['student_relations'][$key]['name']= $element->name;
		endforeach;


		// RENDER VIEW
		$this->load->view('school/index', $data);

	}
}

?>