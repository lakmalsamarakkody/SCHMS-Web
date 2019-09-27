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
        $this->load->model('student');
        $this->load->model('staff');
        $this->load->model('student/attendance');
        $this->load->model('student/class');
        $this->load->model('staff/attendance');

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

            // PRESERVE SUBMITED DATA
            $data['form']['field']['addno'] = ( isset($this->request->post['addno']) AND !empty($this->request->post['addno']) ) ? $this->request->post['addno'] : "";
            $data['form']['field']['name'] = ( isset($this->request->post['name']) AND !empty($this->request->post['name']) ) ? $this->request->post['name'] : "";
            $data['form']['field']['isStaff'] = ( isset($this->request->post['isStaff']) AND !empty($this->request->post['isStaff']) ) ? $this->request->post['isStaff'] : "";
            $data['form']['field']['class'] = ( isset($this->request->post['class']) AND !empty($this->request->post['class']) ) ? $this->request->post['class'] : "";
            $data['form']['field']['date'] = ( isset($this->request->post['date']) AND !empty($this->request->post['date']) ) ? $this->request->post['date'] : "";

            /**
             * First of all to we have to check if we need
             * to query staff attendance or student attendance.
             * This can be done using the staff toggle switch
             * input data passed from the front end.
             */
            if ( isset($this->request->post['isStaff']) ):

                /**
                 * Front end user is asking for attendance data for
                 * the staff members. We have to pull data from the
                 * database according to the form inputs and push them
                 * into the twig to render.
                 */

                $staff = $this->model_staff->select('id', 'employee_number', 'full_name', 'initials', 'surname', 'gender');

                // RETURN
                foreach( $staff->get() as $key => $element ):
                    $data['search']['staff'][$key]['id']  = $element->id;
                    $data['search']['staff'][$key]['employee_number'] = $element->employee_number;
                    $data['search']['staff'][$key]['full_name'] = $element->full_name;
                    $data['search']['staff'][$key]['initials'] = $element->initials;
                    $data['search']['staff'][$key]['surname'] = $element->surname;
                    $data['search']['staff'][$key]['gender'] = $element->gender;
                endforeach;

            else:

                /**
                 * User is asking for student attendance records.
                 * We have to query data according to the form inputs
                 * and push them to the twig to render.
                 */

                $student = $this->model_student::select('id', 'admission_no', 'class_id', 'full_name', 'initials', 'surname', 'gender');

                // FILTER ( ADMISSION NO )
                if ( isset($this->request->post['addno']) AND !empty($this->request->post['addno']) ):
                    $student->where('admission_no', '=', $this->request->post['addno']);
                endif;

                // FILTER ( NAME )
                if ( isset($this->request->post['name']) AND !empty($this->request->post['name']) ):
                    $student->where('full_name', 'LIKE', '%'.$this->request->post['name'].'%');
                endif;

                // RETURN
                foreach( $student->get() as $key => $element ):
                    $data['search']['students'][$key]['id']  = $element->id;
                    $data['search']['students'][$key]['admission_no'] = $element->admission_no;
                    $data['search']['students'][$key]['full_name'] = $element->full_name;
                    $data['search']['students'][$key]['initials'] = $element->initials;
                    $data['search']['students'][$key]['surname'] = $element->surname;
                    $data['search']['students'][$key]['gender'] = $element->gender;
                    $data['search']['students'][$key]['class_id'] = $element->class_id;
                endforeach;

            endif;

        endif;

		// RENDER VIEW
        $this->load->view('attendance/mark', $data);
        
    } 
    
}
?>