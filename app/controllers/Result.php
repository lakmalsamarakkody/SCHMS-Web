<?php

use Carbon\Carbon;

class Result extends Controller {
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

		// RENDER VIEW
        $this->load->view('result/index', $data);
        
    }

    public function search() {
    
        // SITE DETAILS
		$data['app']['url']			= $this->config->get('base_url');
		$data['app']['title']		= $this->config->get('site_title');
		$data['app']['theme']		= $this->config->get('app_theme');

		// HEADER / FOOTER
		$data['template']['header']		= $this->load->controller('common/header', $data);
        $data['template']['footer']		= $this->load->controller('common/footer', $data);
        $data['template']['sidenav']	= $this->load->controller('common/sidenav', $data);
        $data['template']['topmenu']	= $this->load->controller('common/topmenu', $data);

        // MODEL
        $this->load->model('exam');
        $this->load->model('exam/type');
        $this->load->model('class');
        $this->load->model('grade');

        // TWIG : EXAM YEAR
        $exam_year = Carbon::now()->format('Y');
        for ( $i=1; $i<=10; $i++ ):
            $data['years'][$i] = $exam_year;
            $exam_year--;
        endfor;

        // TWIG : EXAMS
        foreach( $this->model_exam->select('id', 'type_id', 'year')->orderBy('year')->get() as $key => $element ):
			$data['exams'][$key]['id'] = $element->id;
            $data['exams'][$key]['type_id']= $element->type_id;
            $data['exams'][$key]['year'] = $element->year;

            $data['exams'][$key]['type']['name'] = $this->model_exam_type->select('name')->where('id', '=', $element->type_id)->first()->name;
        endforeach;
        
		// RENDER VIEW
        $this->load->view('result/search', $data);
        
    }
    
    public function add() {
    
        // SITE DETAILS
		$data['app']['url']			= $this->config->get('base_url');
		$data['app']['title']		= $this->config->get('site_title');
		$data['app']['theme']		= $this->config->get('app_theme');

		// HEADER / FOOTER
		$data['template']['header']		= $this->load->controller('common/header', $data);
        $data['template']['footer']		= $this->load->controller('common/footer', $data);
        $data['template']['sidenav']	= $this->load->controller('common/sidenav', $data);
        $data['template']['topmenu']	= $this->load->controller('common/topmenu', $data);

		// RENDER VIEW
        $this->load->view('result/add', $data);
        
    }
    
}
?>