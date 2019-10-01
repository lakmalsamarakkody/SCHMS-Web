<?php

class Timetable extends Controller {
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
        $this->load->view('timetable/index', $data);
        
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
            $data['classes'][$key]['id'] = $element->id;
            $data['classes'][$key]['grade']['id'] = $element->grade_id;
            $data['classes'][$key]['staff']['id'] = $element->staff_id;
            $data['classes'][$key]['name'] = $element->name;

            $data['classes'][$key]['grade']['name'] = $this->model_grade->select('name')->where('id', '=', $element->grade_id)->first()->name;
        endforeach;

		// RENDER VIEW
        $this->load->view('timetable/search', $data);
        
    } 

    public function create() {
    
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
        $this->load->model('subject');
        $this->load->model('staff');


        
        //STUDENT CLASS
        foreach( $this->model_class->select('id', 'grade_id', 'staff_id', 'name')->orderBy('grade_id')->get() as $key => $element ):
            $data['classes'][$key]['id'] = $element->id;
            $data['classes'][$key]['grade']['id'] = $element->grade_id;
            $data['classes'][$key]['staff']['id'] = $element->staff_id;
            $data['classes'][$key]['name'] = $element->name;

            $data['classes'][$key]['grade']['name'] = $this->model_grade->select('name')->where('id', '=', $element->grade_id)->first()->name;
        endforeach;

        // SUBJECTS
        foreach( $this->model_subject->select('id', 'name', 'si_name')->orderBy('name')->get() as $key => $element ):
            $data['subject'][$key]['id'] = $element->id;
            $data['subject'][$key]['name'] = $element->name;
            $data['subject'][$key]['si_name'] = $element->si_name;
        endforeach;

        // STAFF
        foreach( $this->model_staff->select('id', 'initials', 'surname')->orderBy('surname')->get() as $key => $element ):
            $data['staffs'][$key]['id'] = $element->id;
            $data['staffs'][$key]['initials'] = $element->initials;
            $data['staffs'][$key]['surname'] = $element->surname;
            
        endforeach;
        
		// RENDER VIEW
        $this->load->view('timetable/create', $data);
        
    }


    // THIS METHOD WILL MANIPULATE SUBJECT PER EACH CLASS
    public function ajax_assign_subject() {

        // MODEL
        $this->load->model('class');
        $this->load->model('subject');
        $this->load->model('class/timetable');
        $this->load->model('student/class');
        $this->load->model('student/subject');

        // SET JSON HEADER
        header('Content-Type: application/json');

        // GUMP VALIDATION
        $gump = new GUMP();
        $gump->validation_rules(array(
            'class'     => 'required|numeric|min_len,1|max_len,3',
            'day'       => 'required|numeric|max_len,1|min_numeric,1|max_numeric,5',
            'period'    => 'required|numeric|max_len,1|min_numeric,1|max_numeric,8',
            'subject'   => 'required|numeric|min_len,1|max_len,3'
        ));
        if ( $gump->run($this->request->post) === false ):
            echo json_encode(array("status" => "failed", "error" => "Invalid data supplied. Please reload and try again."), JSON_PRETTY_PRINT);
            exit();
        endif;

        // CLASS VALIDATION
        if ( $this->model_class->select('id')->where('id', '=', $this->request->post['class'])->first() == NULL ):
            echo json_encode(array("status" => "failed", "error" => "Invalid class is selected."), JSON_PRETTY_PRINT);
            exit();
        endif;

        // SUBJECT VALIDATION
        if ( $this->model_subject->select('id')->where('id', '=', $this->request->post['subject'])->first() == NULL ):
            echo json_encode(array("status" => "failed", "error" => "Invalid Subject is selected."), JSON_PRETTY_PRINT);
            exit();
        endif;

        // CHECK FOR AVAILABLE SUBJECT
        if ( $this->model_class_timetable->select('id')->where('class_id', '=', $this->request->post['class'])->where('day', '=', $this->request->post['day'])->where('period', '=', $this->request->post['period'])->first() != NULL ):
            
            // UPDATE CURRENT SUBJECT
            $is_update = $this->model_class_timetable->where('class_id', '=', $this->request->post['class'])->where('day', '=', $this->request->post['day'])->where('period', '=', $this->request->post['period'])->update(['subject_id' => $this->request->post['subject']]);
            
            if ( $is_update ):
                echo json_encode(array("status" => "success"), JSON_PRETTY_PRINT);
                exit();
            else:
                echo json_encode(array("status" => "failed"), JSON_PRETTY_PRINT);
                exit();
            endif;

        // CREATE A NEW CLASS AND DAY AND PERIOD
        else:

            $this->model_class_timetable->class_id = $this->request->post['class'];
            $this->model_class_timetable->day = $this->request->post['day'];
            $this->model_class_timetable->period = $this->request->post['period'];
            $this->model_class_timetable->subject_id = $this->request->post['subject'];

            if ( $this->model_class_timetable->save() ):

                // Create STUDENT has SUBJECT
                // select students in the relevant class
                if ( $this->model_student_class->select('stu_id')->where('class_id', '=', $this->request->post['class'])->first() !== NULL ):

                    // loop all students in the student has class
                    foreach( $this->model_student_class->select('stu_id')->where('class_id', '=', $this->request->post['class'])->get() as $key => $element ):

                        // check already student does not have this subject
                        if ( $this->model_student_subject->select('id')->where('student_id', '=', $element->stu_id)->where('subject_id', '=', $this->request->post['subject'])->first() == NULL  ):

                            try {
                                $this->model_student_subject->create([
                                    'student_id' => $element->stu_id,
                                    'subject_id' => $this->request->post['subject']
                                ]);

                                echo json_encode( array( "status" => "success" ), JSON_PRETTY_PRINT );
                                exit();

                            } catch(Exception $e){
                                echo json_encode( array( "status" => "failed" ), JSON_PRETTY_PRINT );
                                exit();
                            }

                        endif;

                    endforeach;

                endif;

            else:
                echo json_encode(array("status" => "failed"), JSON_PRETTY_PRINT);
                exit();
            endif;

        endif;
    }

    // THIS METHOD WILL MANIPULATE STAFF PER EACH PERIOD
    public function ajax_assign_staff() {

        // MODEL
        $this->load->model('class');
        $this->load->model('staff');
        $this->load->model('staff/subject');
        $this->load->model('class/timetable');
    }
}
?>