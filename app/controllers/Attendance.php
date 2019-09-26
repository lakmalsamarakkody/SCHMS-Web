<?php

use Carbon\Carbon;

class Attendance extends Controller {
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
        $this->load->view('attendance/index', $data);
        
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
        $this->load->model('class');
        $this->load->model('grade');

        //STUDENT CLASS
        foreach( $this->model_class->select('id', 'grade_id', 'staff_id', 'name')->get() as $key => $element ):
            $data['student_class'][$key]['id'] = $element->id;
            $data['student_class'][$key]['grade']['id'] = $element->grade_id;
            $data['student_class'][$key]['staff']['id'] = $element->staff_id;
            $data['student_class'][$key]['name'] = $element->name;

            $data['student_class'][$key]['grade']['name'] = $this->model_grade->select('name')->where('id', '=', $element->grade_id)->first()->name;
        endforeach;

        // YEAR
        $exam_year = Carbon::now()->format('Y');
        for ( $i=1; $i<=10; $i++ ):
            $data['years'][$i] = $exam_year;
            $exam_year--;
        endfor;

		// RENDER VIEW
        $this->load->view('attendance/search', $data);
        
    }
    
    public function mark() {
    
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
        $this->load->model('class');
        $this->load->model('grade');

        //STUDENT CLASS
        foreach( $this->model_class->select('id', 'grade_id', 'staff_id', 'name')->get() as $key => $element ):
            $data['student_class'][$key]['id'] = $element->id;
            $data['student_class'][$key]['grade']['id'] = $element->grade_id;
            $data['student_class'][$key]['staff']['id'] = $element->staff_id;
            $data['student_class'][$key]['name'] = $element->name;

            $data['student_class'][$key]['grade']['name'] = $this->model_grade->select('name')->where('id', '=', $element->grade_id)->first()->name;
        endforeach;

        // CHECK SUBMIT ( STUDENT SEARCH )
        if ( isset($this->request->post['isSubmited']) ):

            $student = $this->model_student->select('id', 'admission_no', 'full_name', 'initials', 'surname', 'gender');
            $staff = $this->model_staff->select('id', 'employee_number', 'full_name', 'initials', 'surname', 'gender');
            $student_attendance = $this->model_student_attendance->select('id', 'student_id', 'date', 'time' );
            $staff_attendance = $this->model_student_attendance->select('id', 'staff_id', 'date', 'time' );

            // FILTER ( ADMISSION NO )
            if ( isset($this->request->post['addno']) AND !empty($this->request->post['addno']) ):

                if ( $this->request->post['class'] != 'Staff' ):

                    $student->where(function($query) {
                        $query->where('admission_no', '=', $this->request->post['addno']);
                    });
                    $data['search']['query']['addno'] = $this->request->post['addno'];

                else:

                    $staff->where(function($query) {
                        $query->where('employee_number', '=', $this->request->post['addno']);
                    });
                    $data['search']['query']['addno'] = $this->request->post['addno'];

                endif;
            endif;

            // FILTER ( NAME )
            if ( isset($this->request->post['name']) AND !empty($this->request->post['name']) ):

                if ( $this->request->post['class'] != 'Staff' ):

                    $student->where(function($query) {
                        $query->where('full_name', 'LIKE', '%'.$this->request->post['name'].'%');
                    });
                    $data['search']['query']['name'] = $this->request->post['name'];

                else:

                    $staff->where(function($query) {
                        $query->where('full_name', 'LIKE', '%'.$this->request->post['name'].'%');
                    });
                    $data['search']['query']['name'] = $this->request->post['name'];    

                endif;
            endif;

            // FILTER ( CLASS ID )
            if ( isset($this->request->post['class']) AND !empty($this->request->post['class']) AND $this->request->post['class'] != '- Select -' ):

                if ( $this->request->post['class'] != 'Staff' ):

                    $student->where(function($query) {
                        $query->where('class_id', '=', $this->request->post['class']);
                    });
                    $data['search']['query']['class'] = $this->request->post['class'];

                else:
                    $data['search']['query']['class'] = $this->request->post['class'];

                endif;
            endif;

            // APPEND DATA TO ARRAY

            if ( $this->request->post['class'] != 'Staff' ):

                foreach( $student->get() as $key => $value ):
                    $data['search']['students'][$key]['id'] = $value->id;
                    $data['search']['students'][$key]['admission_no'] = $value->admission_no;
                    $data['search']['students'][$key]['full_name'] = $value->full_name;
                    $data['search']['students'][$key]['initials'] = $value->initials;
                    $data['search']['students'][$key]['surname'] = $value->surname;
                    $data['search']['students'][$key]['gender'] = $value->gender;
                    $data['search']['students'][$key]['class_id'] = $value->class_id;

                    // GET INDEX
                    $data['search']['students'][$key]['index'] = $this->model_student_class->select('index_no')->where('stu_id', '=', $value->id)->where('class_id', '=', $value->class_id)->first()->index_no;
                endforeach;

            else:

                foreach( $staff->get() as $key => $value ):
                    $data['search']['staff'][$key]['id'] = $value->id;
                    $data['search']['staff'][$key]['employee_number'] = $value->employee_name;
                    $data['search']['staff'][$key]['full_name'] = $value->full_name;
                    $data['search']['staff'][$key]['initials'] = $value->initials;
                    $data['search']['staff'][$key]['surname'] = $value->surname;
                    $data['search']['staff'][$key]['gender'] = $value->gender;
                endforeach;

            endif;

        endif;

		// RENDER VIEW
        $this->load->view('attendance/mark', $data);
        
    } 
    
}
?>