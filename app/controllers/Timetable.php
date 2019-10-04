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
    
    public function class_timetable() {
    
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
        $this->load->model('grade');
        $this->load->model('subject');
        $this->load->model('staff');
        $this->load->model('class');
        $this->load->model('class/timetable');
        
        //STUDENT CLASS
        foreach( $this->model_class->select('id', 'grade_id', 'staff_id', 'name')->get() as $key => $element ):
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

        // CLASS TIME TABLE
        if ( isset($this->request->post['isSubmitedClassTimeTable']) ):
            
            // PRESERVE SUBMITED DATA
            $data['form']['field']['timetable_class'] = ( isset($this->request->post['timetable_class']) AND !empty($this->request->post['timetable_class']) ) ? $this->request->post['timetable_class'] : "";

            // VALIDATE CLASS
            // GUMP VALIDATION
            $gump = new GUMP();
            $gump->validation_rules(array(
                'timetable_class'     => 'required|numeric|min_len,1|max_len,3'
            ));

            if ( $gump->run($this->request->post) === false ):
                $data['error']['status'] = true;
                $data['error']['msg'] = "Invalid class selected. Refresh your Browser and try again";
            else:
                // DB VALIDATION : CLASS
                if ( $this->model_class->select('id')->where('id', '=', $this->request->post['timetable_class'])->first() != NULL ):

                    $data['class']['id'] = $this->request->post['timetable_class'];

                    $class_timetable = $this->model_class_timetable->select('id', 'class_id', 'day', 'period', 'subject_id', 'staff_id')->where('class_id', '=', $this->request->post['timetable_class']);
                    if ( $class_timetable =! NULL ):

                        foreach ( $this->model_class_timetable->select('id', 'class_id', 'day', 'period', 'subject_id', 'staff_id')->where('class_id', '=', $this->request->post['timetable_class'])->get() as $key => $element ):

                            $subject = $this->model_subject->select('name')->where('id', '=', $element->subject_id)->first();
                            $staff = $this->model_staff->select('initials', 'surname')->where('id', '=', $element->staff_id)->first();

                            $data['timetables'][$element->day] = array(
                                'period'    => array(
                                    'id'            => $element->period,
                                    'subject_name'  => ( $subject !== NULL ) ? $subject->name : null,
                                    'staff_name'    =>  ( $staff !== NULL ) ? $staff->initials." ".$staff->surname : null,
                                )
                            );

                        endforeach;

                    else:
                        $data['error']['status'] = true;
                        $data['error']['msg'] = "No schedule to selected class";
                    endif;

                else:
                    $data['error']['status'] = true;
                    $data['error']['msg'] = "No class found. Please try again";
                endif;
            endif;

        endif;

		// RENDER VIEW
        $this->load->view('timetable/class_timetable', $data);
        
    }
    
    public function staff_timetable() {
    
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
        $this->load->model('grade');
        $this->load->model('subject');
        $this->load->model('staff');
        $this->load->model('class');
        $this->load->model('class/timetable');
        
        //STUDENT CLASS
        foreach( $this->model_class->select('id', 'grade_id', 'staff_id', 'name')->get() as $key => $element ):
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

        // STAFF TIMETABLE
        if ( isset($this->request->post['isSubmitedStaffTimeTable']) ):

            // PRESERVE SUBMITED DATA
            $data['form']['field']['timetable_staff'] = ( isset($this->request->post['timetable_staff']) AND !empty($this->request->post['timetable_staff']) ) ? $this->request->post['timetable_staff'] : "";

            // VALIDATE STAFF
            // GUMP VALIDATION
            $gump = new GUMP();
            $gump->validation_rules(array(
                'timetable_staff'     => 'required|numeric|min_len,1|max_len,6'
            ));

            if ( $gump->run($this->request->post) === false ):
                $data['error']['status'] = true;
                $data['error']['msg'] = "Invalid class selected. Refresh your Browser and try again";
            else:
                // DB VALIDATION : STAFF
                if ( $this->model_staff->select('id')->where('id', '=', $this->request->post['timetable_staff'])->first() != NULL ):

                    $data['staff']['id'] = $this->request->post['timetable_staff'];

                    $staff_timetable = $this->model_class_timetable->select('id', 'class_id', 'day', 'period', 'subject_id', 'staff_id')->where('staff_id', '=', $this->request->post['timetable_staff']);
                    if ( $staff_timetable =! NULL ):

                        foreach ( $this->model_class_timetable->select('id', 'class_id', 'day', 'period', 'subject_id', 'staff_id')->where('staff_id', '=', $this->request->post['timetable_staff'])->get() as $key => $element ):

                            $subject = $this->model_subject->select('name')->where('id', '=', $element->subject_id)->first();
                            $class = $this->model_class->select('id', 'grade_id', 'name')->where('id', '=', $element->class_id)->first();

                            $data['timetables'][$element->day] = array(
                                'period'    => array(
                                    'id'            => $element->period,
                                    'class_name'    =>  ( $class !== NULL ) ? $this->model_grade->select('name')->where('id', '=', $class->grade_id)->first()->name." - ".$class->name : null,
                                    'subject_name'  => ( $subject !== NULL ) ? $subject->name : null,
                                )
                            );

                        endforeach;

                    else:
                        $data['error']['status'] = true;
                        $data['error']['msg'] = "No schedule to selected Staff";
                    endif;

                else:
                    $data['error']['status'] = true;
                    $data['error']['msg'] = "No Staff found. Please try again";
                endif;
            endif;

        endif;

		// RENDER VIEW
        $this->load->view('timetable/staff_timetable', $data);
        
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
        $this->load->model('class/timetable');
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

        if ( isset($this->request->post['isSubmited']) ):

            // PRESERVE SUBMITED DATA
            $data['form']['field']['timetable_class'] = ( isset($this->request->post['timetable_class']) AND !empty($this->request->post['timetable_class']) ) ? $this->request->post['timetable_class'] : "";

            // VALIDATE CLASS
            // GUMP VALIDATION
            $gump = new GUMP();
            $gump->validation_rules(array(
                'timetable_class'     => 'required|numeric|min_len,1|max_len,3'
            ));

            if ( $gump->run($this->request->post) === false ):
                $data['error']['status'] = true;
                $data['error']['msg'] = "Invalid class selected. Refresh your Browser and try again";
            else:
                // DB VALIDATION : CLASS
                if ( $this->model_class->select('id')->where('id', '=', $this->request->post['timetable_class'])->first() != NULL ):

                    $data['class']['id'] = $this->request->post['timetable_class'];

                    $class_timetable = $this->model_class_timetable->select('id', 'class_id', 'day', 'period', 'subject_id', 'staff_id')->where('class_id', '=', $this->request->post['timetable_class']);
                    if ( $class_timetable =! NULL ):

                        foreach ( $this->model_class_timetable->select('id', 'class_id', 'day', 'period', 'subject_id', 'staff_id')->where('class_id', '=', $this->request->post['timetable_class'])->get() as $key => $element ):
                            $data['timetables'][$element->day][$element->period] = array(
                                'subject_id' => $element->subject_id,
                                'staff_id' => $element->staff_id
                            );
                        endforeach;

                    else:
                        $data['error']['status'] = true;
                        $data['error']['msg'] = "No schedule to selected class";
                    endif;

                else:
                    $data['error']['status'] = true;
                    $data['error']['msg'] = "No class found. Please try again";
                endif;

            endif;

            
    
        endif;
        
		// RENDER VIEW
        $this->load->view('timetable/create', $data);
        
    }

    // THIS METHOD WILL MANIPULATE SUBJECT PER EACH CLASS
    public function ajax_assign_subject() {

        // SET JSON HEADER
        header('Content-Type: application/json');

        // MODEL
        $this->load->model('class');
        $this->load->model('subject');
        $this->load->model('class/timetable');
        $this->load->model('student/class');
        $this->load->model('student/subject');

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
                if ( $this->model_student_class->select('student_id')->where('class_id', '=', $this->request->post['class'])->first() !== NULL ):

                    // loop all students in the student has class
                    foreach( $this->model_student_class->select('student_id')->where('class_id', '=', $this->request->post['class'])->get() as $key => $element ):

                        // check already student does not have this subject
                        if ( $this->model_student_subject->select('id')->where('student_id', '=', $element->student_id)->where('subject_id', '=', $this->request->post['subject'])->first() == NULL  ):

                            try {

                                $this->model_student_subject->create([
                                    'student_id' => $element->student_id,
                                    'subject_id' => $this->request->post['subject']
                                ]);

                            } catch(Exception $e){
                                echo json_encode( array( "status" => "failed" ), JSON_PRETTY_PRINT );
                                exit();
                            }

                        endif;

                    endforeach;

                    echo json_encode( array( "status" => "success" ), JSON_PRETTY_PRINT );
                    exit();
                
                else:
                    echo json_encode( array( "status" => "success" ), JSON_PRETTY_PRINT );
                    exit();
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

        // GUMP VALIDATION
        $gump = new GUMP();
        $gump->validation_rules(array(
            'class'     => 'required|numeric|min_len,1|max_len,3',
            'day'       => 'required|numeric|max_len,1|min_numeric,1|max_numeric,5',
            'period'    => 'required|numeric|max_len,1|min_numeric,1|max_numeric,8',
            'staff'     => 'required|numeric|min_len,1|max_len,6'
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

        // STAFF VALIDATION
        if ( $this->model_staff->select('id')->where('id', '=', $this->request->post['staff'])->first() == NULL ):
            echo json_encode(array("status" => "failed", "error" => "Invalid staff is selected."), JSON_PRETTY_PRINT);
            exit();
        endif;

        // SUBJECT VALIDATION
        if ( $this->model_class_timetable->select('subject_id')->where('class_id', '=', $this->request->post['class'])->where('day', '=', $this->request->post['day'])->where('period', '=', $this->request->post['period'])->first() == NULL  ):
            echo json_encode(array("status" => "failed", "error" => "Schedule a subject before assigning a staff"), JSON_PRETTY_PRINT);
            exit();
        endif;

        // TIME SLOT VALIDATION
        if ( $this->model_class_timetable->select('id')->where('staff_id', '=', $this->request->post['staff'])->where('day', '=', $this->request->post['day'])->where('period', '=', $this->request->post['period'])->first() != NULL  ):
            echo json_encode(array("status" => "failed", "error" => "Staff has already a class in this period"), JSON_PRETTY_PRINT);
            exit();
        endif;

        // UPDATE CURRENT STAFF
        $is_update = $this->model_class_timetable->where('class_id', '=', $this->request->post['class'])->where('day', '=', $this->request->post['day'])->where('period', '=', $this->request->post['period'])->update(['staff_id' => $this->request->post['staff']]);
        
        if ( $is_update ):
            $subject_id = $this->model_class_timetable->select('subject_id')->where('class_id', '=', $this->request->post['class'])->where('day', '=', $this->request->post['day'])->where('period', '=', $this->request->post['period'])->first();
            
            // Create STAFF has SUBJECT
            if ( $this->model_staff_subject->select('staff_id')->where('staff_id', '=', $this->request->post['staff'])->where('subject_id', '=', $subject_id->subject_id)->first() == NULL ):

                try {
                    $this->model_staff_subject->create([
                        'staff_id' => $this->request->post['staff'],
                        'subject_id' => $subject_id->subject_id
                    ]);

                echo json_encode( array( "status" => "success" ), JSON_PRETTY_PRINT );
                exit();

                } catch(Exception $e){
                    echo json_encode( array( "status" => "failed" ), JSON_PRETTY_PRINT );
                    exit();
                }
            
            else:
                echo json_encode( array( "status" => "success" ), JSON_PRETTY_PRINT );
                exit();
            endif;

        else:
            echo json_encode(array("status" => "failed"), JSON_PRETTY_PRINT);
            exit();
        endif;

                

                    
    }
}
?>