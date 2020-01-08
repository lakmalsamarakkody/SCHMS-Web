<?php

use Carbon\Carbon;
use Illuminate\Database\Capsule\Manager as DB;

class Attendance extends Controller {
    public function index() {
        
        //CHECK LOGIN STATUS
		if( !isset($_SESSION['user']) OR $_SESSION['user']['is_login'] != true ):
			header( 'Location:' . $this->config->get('base_url') . '/logout' );
			exit();
		endif;
    
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
		$this->load->model('student');
		$this->load->model('student/attendance');
		$this->load->model('staff');
        $this->load->model('staff/attendance');
        $this->load->model('class');
        $this->load->model('grade');

        $date_now = Carbon::now()->isoFormat('YYYY-MM-DD');
        
        // PERMISSION LEVEL
        $data['permission']['level'] = 'student';

		// STUDENT TOTAL
		$data['student']['total']['all'] = $this->model_student->select('id')->count();
		$data['student']['total']['male'] = $this->model_student->select('id')->where('gender', '=', 'male')->count();
		$data['student']['total']['female'] = $this->model_student->select('id')->where('gender', '=', 'female')->count();

		// STUDENT ATTENDANCE
		$data['student']['attendance']['all'] = $this->model_student_attendance->select('id')->where('date', '=', $date_now)->count();

		$data['student']['attendance']['male'] = DB::table('student_attendance')
		->join('student', 'student_attendance.student_id', '=', 'student.id')
		->select('student.id')
		->where('date', '=', $date_now)
		->where('gender', '=', 'male')
		->count();

		$data['student']['attendance']['female'] = DB::table('student_attendance')
		->join('student', 'student_attendance.student_id', '=', 'student.id')
		->select('student.id')
		->where('date', '=', $date_now)
		->where('gender', '=', 'female')
		->count();

		$data['student']['absent']['all'] = $data['student']['total']['all'] - $data['student']['attendance']['all'];
		$data['student']['absent']['male'] = $data['student']['total']['male'] - $data['student']['attendance']['male'];
		$data['student']['absent']['female'] = $data['student']['total']['female'] - $data['student']['attendance']['female'];

		// STAFF TOTAL
		$data['staff']['total']['all'] = $this->model_staff->select('id')->count();
		$data['staff']['total']['male'] = $this->model_staff->select('id')->where('gender', '=', 'male')->count();
		$data['staff']['total']['female'] = $this->model_staff->select('id')->where('gender', '=', 'female')->count();

		// STAFF ATTENDANCE
		$data['staff']['attendance']['all'] = $this->model_staff_attendance->select('id')->where('date', '=', $date_now)->count();

		$data['staff']['attendance']['male'] = DB::table('staff_attendance')
		->join('staff', 'staff_attendance.staff_id', '=', 'staff.id')
		->select('staff.id')
		->where('date', '=', $date_now)
		->where('gender', '=', 'male')
		->count();

		$data['staff']['attendance']['female'] = DB::table('staff_attendance')
		->join('staff', 'staff_attendance.staff_id', '=', 'staff.id')
		->select('staff.id')
		->where('date', '=', $date_now)
		->where('gender', '=', 'female')
		->count();
		
		$data['staff']['absent']['all'] = $data['staff']['total']['all'] - $data['staff']['attendance']['all'];
		$data['staff']['absent']['male'] = $data['staff']['total']['male'] - $data['staff']['attendance']['male'];
        $data['staff']['absent']['female'] = $data['staff']['total']['female'] - $data['staff']['attendance']['female'];
        
        // CLASS ATTENDANCE CHART
        foreach ( $this->model_class->select('id','grade_id','name')->get() as $key => $element ):
            $grade = $this->model_grade->select('name')->where('id', '=', $element->grade_id)->first()->name;
            $data['classes'][$key]['name'] = $grade." - ".$element->name;
            $data['classes'][$key]['present'] = DB::table('student_attendance')
            ->join('student', 'student_attendance.student_id', '=', 'student.id')
            ->select('student.id')
            ->where('student.class_id', '=', $element->id)
            ->where('date', '=', $date_now)
            ->count();
        endforeach;

        // TODAY ABSENT STAFF
        $staff = DB::table('staff')
            ->join('staff_type', 'staff.type_id', 'staff_type.id')
            ->join('staff_category', 'staff_type.category_id', 'staff_category.id')
            ->select('staff.id', 'staff.employee_number', 'staff.initials', 'staff.surname', 'staff.gender', 'staff_type.name as stname', 'staff_category.name as scname')
            ->orderBy('staff.employee_number');

        $count = 0;

        // CONTENT
        if ( $staff !== NULL ):

            foreach ( $staff->get() as $key => $element ):

                $staff_attendance = $this->model_staff_attendance->select('id')->where('staff_id', '=', $element->id)->where('date', '=', $date_now)->first();

                if ( $staff_attendance == NULL ):

                    $data['staffs'][$key]['employee_number'] = $element->employee_number;
                    $data['staffs'][$key]['name'] = $element->initials. " ". $element->surname;
                    $data['staffs'][$key]['category'] = $element->scname;
                    $data['staffs'][$key]['type'] = $element->stname;

                    // SET TITLE
                    if ( $element->gender == "Male" ): 
                        $data['staffs'][$key]['title'] = "Mr. "; 
                    else:
                        $data['staffs'][$key]['title'] = "Mrs. "; 
                    endif;

                    // TEACHER IN CHARGE CLASS
                    $tic_class = $this->model_class->select('id', 'grade_id', 'name')->where('staff_id', '=', $element->id)->first();

                    if ( $tic_class !== NULL ):

                        // QUERY CLASS NAME
                        $grade = $this->model_grade->select('name')->where('id', '=', $tic_class->grade_id)->first();
                        $data['staffs'][$key]['class'] =  $grade->name. " - ". $tic_class->name ;

                    endif;
                    unset ($staff_attendance);

                    // COUNT
                    $count = $count + 1;

                endif;
                $data['all_staffs']['absent']['count'] = $count;

            endforeach;
        endif;

		// RENDER VIEW
        $this->load->view('attendance/index', $data);
    }

    public function search() {

        //CHECK LOGIN STATUS
		if( !isset($_SESSION['user']) OR $_SESSION['user']['is_login'] != true ):
			header( 'Location:' . $this->config->get('base_url') . '/logout' );
			exit();
		endif;
    
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
        $this->load->model('staff');
        $this->load->model('staff/attendance');
        $this->load->model('student');
        $this->load->model('student/class');
        $this->load->model('student/attendance');

        // TWIG : STUDENT CLASS
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
            $data['form']['field']['month'] = ( isset($this->request->post['month']) AND !empty($this->request->post['month']) ) ? $this->request->post['month'] : "";
        
            /**
             * First of all to we have to check if we need
             * to query staff attendance or student attendance.
             * This can be done using the staff toggle switch
             * input data passed from the front end.
             */

            // Days in a month
            $dates = Carbon::createFromFormat("d/m/Y", "01/".$this->request->post['month']);
            $month_year = $dates->format("Y-m");
            $days_in_month = $dates->daysInMonth;

            if ( isset($this->request->post['isStaff']) ):

                /**
                 * Front end user is asking for attendance data for
                 * the staff members. We have to pull data from the
                 * database according to the form inputs and push them
                 * into the twig to render.
                 */

                $staff = $this->model_staff->select('id', 'employee_number', 'full_name', 'initials', 'surname');
                $staff_attendance = $this->model_staff_attendance->select('id', 'staff_id', 'date');
        
                // FILTER ( STAFF ID )
                if ( isset($this->request->post['addno']) AND !empty($this->request->post['addno']) ):
                    $staff->where('employee_number', '=', $this->request->post['addno']);
                endif;

                // FILTER ( NAME )
                if ( isset($this->request->post['name']) AND !empty($this->request->post['name']) ):
                    $staff->where('full_name', 'LIKE', '%'.$this->request->post['name'].'%');
                endif;
                
                // RETURN
                foreach( $staff->get() as $key => $element ):
                    $data['search']['staff'][$key]['id']  = $element->id;
                    $data['search']['staff'][$key]['employee_number'] = $element->employee_number;
                    $data['search']['staff'][$key]['full_name'] = $element->full_name;
                    $data['search']['staff'][$key]['initials'] = $element->initials;
                    $data['search']['staff'][$key]['surname'] = $element->surname;

                    // STAFF STATUS FOR MONTH
                    for ( $i=1; $i<= $days_in_month; $i++ ):
                        $attendance = $this->model_staff_attendance->select('id', 'date')->where('staff_id', '=', $element->id)->where('date', '=', $month_year."-".$i)->first();
                        if ( $attendance != NULL):
                            $data['search']['staff'][$key]['status'][$i] = true;
                        else:
                            $data['search']['staff'][$key]['status'][$i] = false;
                        endif;

                        $data['days_in_month'][$i] = $i;
                    endfor;

                endforeach;

            else:
                /**
                 * Front end user is asking for attendance data for
                 * the students. We have to pull data from the
                 * database according to the form inputs and push them
                 * into the twig to render.
                 */

                $student = $this->model_student->select('id', 'class_id', 'admission_no', 'full_name', 'initials', 'surname');
                $student_attendance = $this->model_student_attendance->select('id', 'student_id', 'date');

                // FILTER ( STUDENT ID )
                if ( isset($this->request->post['addno']) AND !empty($this->request->post['addno']) ):
                    $student->where('admission_no', '=', $this->request->post['addno']);
                endif;

                // FILTER ( NAME )
                if ( isset($this->request->post['name']) AND !empty($this->request->post['name']) ):
                    $student->where('full_name', 'LIKE', '%'.$this->request->post['name'].'%');
                endif;

                // FILTER ( CLASS )
                if ( isset($this->request->post['class']) AND !empty($this->request->post['class']) ):
                    $student->where('class_id', '=', $this->request->post['class']);
                endif;

                // RETURN
                foreach( $student->get() as $key => $element ):
                    $data['search']['students'][$key]['id']  = $element->id;
                    $data['search']['students'][$key]['admission_no'] = $element->admission_no;
                    $data['search']['students'][$key]['full_name'] = $element->full_name;
                    $data['search']['students'][$key]['initials'] = $element->initials;
                    $data['search']['students'][$key]['surname'] = $element->surname;
                    $data['search']['students'][$key]['class_id'] = $element->class_id;

                    // GET INDEX
                    $index_no = $this->model_student_class->select('index_no')->where('student_id', '=', $element->id)->where('class_id', '=', $element->class_id)->first()->index_no;
                    $data['search']['students'][$key]['index'] = $index_no;

                    // STUDENT STATUS FOR MONTH
                    for ( $i=1; $i<= $days_in_month; $i++ ):
                        $attendance = $this->model_student_attendance->select('id', 'date')->where('student_id', '=', $element->id)->where('date', '=', $month_year."-".$i)->first();
                        if ( $attendance != NULL):
                            $data['search']['students'][$key]['status'][$i] = true;
                        else:
                            $data['search']['students'][$key]['status'][$i] = false;
                        endif;

                        $data['days_in_month'][$i] = $i;
                    endfor;

                endforeach;

            endif;
        
        endif;

		// RENDER VIEW
        $this->load->view('attendance/search', $data);
        
    }
    
    public function mark() {

        //CHECK LOGIN STATUS
		if( !isset($_SESSION['user']) OR $_SESSION['user']['is_login'] != true ):
			header( 'Location:' . $this->config->get('base_url') . '/logout' );
			exit();
		endif;
    
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
        $this->load->model('user');
        $this->load->model('notification');

        // TWIG : STUDENT CLASS
        foreach( $this->model_class->select('id', 'grade_id', 'staff_id', 'name')->get() as $key => $element ):
            $data['student_class'][$key]['id'] = $element->id;
            $data['student_class'][$key]['grade']['id'] = $element->grade_id;
            $data['student_class'][$key]['staff']['id'] = $element->staff_id;
            $data['student_class'][$key]['name'] = $element->name;

            $data['student_class'][$key]['grade']['name'] = $this->model_grade->select('name')->where('id', '=', $element->grade_id)->first()->name;
        endforeach;

         //  TWIG : SELECT EXAM DATE
        $data['exam_max_date'] = Carbon::now()->format('Y-m-d');
        $data['exam_min_date'] = Carbon::now()->subWeek()->format('Y-m-d');

        // CHECK SUBMIT ( ATTENDANCE MARK )
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
                $staff_attendance = $this->model_staff_attendance->select('id', 'staff_id', 'date');

                // FILTER ( STAFF ID )
                if ( isset($this->request->post['addno']) AND !empty($this->request->post['addno']) ):
                    $staff->where('employee_number', '=', $this->request->post['addno']);
                endif;

                // FILTER ( NAME )
                if ( isset($this->request->post['name']) AND !empty($this->request->post['name']) ):
                    $staff->where('full_name', 'LIKE', '%'.$this->request->post['name'].'%');
                endif;

                // RETURN
                foreach( $staff->get() as $key => $element ):
                    $data['search']['staff'][$key]['id']  = $element->id;
                    $data['search']['staff'][$key]['employee_number'] = $element->employee_number;
                    $data['search']['staff'][$key]['full_name'] = $element->full_name;
                    $data['search']['staff'][$key]['initials'] = $element->initials;
                    $data['search']['staff'][$key]['surname'] = $element->surname;
                    $data['search']['staff'][$key]['gender'] = $element->gender;
                    $data['search']['staff'][$key]['date'] = $this->request->post['date'];

                    // CLASS IN CHARGE
                    $cic = $this->model_class->select('grade_id', 'name')->where('staff_id', '=', $element->id)->first();

                    if ( $cic != NULL ):
                        $grade_name = $this->model_grade->select('name')->where('id', '=', $cic->grade_id)->first();
                        $data['search']['staff'][$key]['cic'] = $grade_name->name . " - " . $cic->name;
                    endif;

                    // ATTENDANCE STATUS
                    if ( $this->model_staff_attendance->select('id')->where('staff_id', '=', $element->id)->where('date', '=', $this->request->post['date'])->first() != NULL):
                        $data['search']['staff'][$key]['status'] = "Present";
                    else:
                        $data['search']['staff'][$key]['status'] = "Absent";
                    endif;

                endforeach;

            else:

                /**
                 * User is asking for student attendance records.
                 * We have to query data according to the form inputs
                 * and push them to the twig to render.
                 */

                $student = $this->model_student->select('id', 'admission_no', 'class_id', 'full_name', 'initials', 'surname', 'gender');
                $student_attendance = $this->model_student_attendance->select('id', 'student_id', 'date');

                // FILTER ( ADMISSION NO )
                if ( isset($this->request->post['addno']) AND !empty($this->request->post['addno']) ):
                    $student->where('admission_no', '=', $this->request->post['addno']);
                endif;

                // FILTER ( NAME )
                if ( isset($this->request->post['name']) AND !empty($this->request->post['name']) ):
                    $student->where('full_name', 'LIKE', '%'.$this->request->post['name'].'%');
                endif;

                // FILTER ( CLASS )
                if ( isset($this->request->post['class']) AND !empty($this->request->post['class']) ):
                    $student->where('class_id', '=', $this->request->post['class']);
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
                    $data['search']['students'][$key]['date'] = $this->request->post['date'];

                    // GET INDEX
                    $index_no = $this->model_student_class->select('index_no')->where('student_id', '=', $element->id)->where('class_id', '=', $element->class_id)->first()->index_no;
                    $data['search']['students'][$key]['index'] = $index_no;

                    // ATTENDANCE STATUS
                    if ( $this->model_student_attendance->select('id')->where('student_id', '=', $element->id)->where('date', '=', $this->request->post['date'])->first() != NULL):
                        $data['search']['students'][$key]['status'] = "Present";
                    else:
                        $data['search']['students'][$key]['status'] = "Absent";
                    endif;

                endforeach;

            endif;

        endif;

		// RENDER VIEW
        $this->load->view('attendance/mark', $data);
        
    }
    
    public function ajax_mark() {

        //CHECK LOGIN STATUS
		if( !isset($_SESSION['user']) OR $_SESSION['user']['is_login'] != true ):
			header( 'Location:' . $this->config->get('base_url') . '/logout' );
			exit();
		endif;

        // MODEL
        $this->load->model('student/attendance');
        $this->load->model('staff/attendance');
        $this->load->model('user');
        $this->load->model('notification');

        // SET JSON HEADER
        header('Content-Type: application/json');

        if ( $this->request->post['student_id'] != "NULL" ):

            // VALIDATION : student_id
            $is_valid_student_id = GUMP::is_valid($this->request->post, array('student_id' => 'required|numeric|max_len,6'));
            if ( $is_valid_student_id !== true ):
                echo json_encode( array( "error" => "Please select a valid student" ), JSON_PRETTY_PRINT );
                exit();
            endif;

            // VALIDATION : date
            $is_valid_date = GUMP::is_valid($this->request->post, array('date' => 'required|date'));
            if ( $is_valid_date !== true ):
                echo json_encode( array( "error" => "Please select a valid date" ), JSON_PRETTY_PRINT );
                exit();
            endif;

            // STUDENT ATTENDANCE MARK
            $student_id = $this->request->post['student_id'];
            $date = $this->request->post['date'];

            // CHECK IS PRESENT
            $is_present = $this->model_student_attendance->select('id')->where('student_id', '=', $student_id)->where('date', '=', $date)->first();

            if ( $is_present != NULL ):

                // SET STATUS AS ABSENT
                if ( $this->model_student_attendance->destroy($is_present->id) ):

                    // CHECK AVAILABLE USER
                    $available_user = $this->model_user->select('id')->where('ref_id', '=', $student_id)->where('user_type', '=', 'student')->first();
                    if ( $available_user != NULL ):
                        // INITIATE : NOTIFICATION
                        $this->model_notification->sender_id = $_SESSION['user']['id'];
                        $this->model_notification->receiver_id = $available_user->id;
                        $this->model_notification->title = "Attendance Marked";
                        $this->model_notification->body = "Your are absent on ".$date;
                        $this->model_notification->save();
                    endif;

                    echo json_encode( array( "status" => "success" ), JSON_PRETTY_PRINT );
                    exit();
                else:
                    echo json_encode( array( "status" => "failed" ), JSON_PRETTY_PRINT );
                    exit();
                endif;

            else:

                // SET STATUS AS PRESENT
                $this->model_student_attendance->student_id = $student_id;
                $this->model_student_attendance->date = $date;

                // CHECK : STUDENT ATTENDANCE QUERY
                if ( $this->model_student_attendance->save() ):

                    // CHECK AVAILABLE USER
                    $available_user = $this->model_user->select('id')->where('ref_id', '=', $student_id)->where('user_type', '=', 'student')->first();
                    if ( $available_user != NULL ):
                        // INITIATE : NOTIFICATION
                        $this->model_notification->sender_id = $_SESSION['user']['id'];
                        $this->model_notification->receiver_id = $available_user->id;
                        $this->model_notification->title = "Attendance Marked";
                        $this->model_notification->body = "Your are present on ".$date;
                        $this->model_notification->save();
                    endif;

                    echo json_encode( array( "status" => "success" ), JSON_PRETTY_PRINT );
                    exit();
                else:
                    echo json_encode( array( "status" => "failed" ), JSON_PRETTY_PRINT );
                    exit();
                endif;
                        

            endif;

        else:
            
            // VALIDATION : staff_id
            $is_valid_staff_id = GUMP::is_valid($this->request->post, array('staff_id' => 'required|numeric|max_len,6'));
            if ( $is_valid_staff_id !== true ):
                echo json_encode( array( "error" => "Please select a valid student" ), JSON_PRETTY_PRINT );
                exit();
            endif;

            // VALIDATION : date
            $is_valid_date = GUMP::is_valid($this->request->post, array('date' => 'required|date'));
            if ( $is_valid_date !== true ):
                echo json_encode( array( "error" => "Please select a valid date" ), JSON_PRETTY_PRINT );
                exit();
            endif;

            // STAFF ATTENDANCE MARK
            $staff_id = $this->request->post['staff_id'];
            $date = $this->request->post['date'];

            // CHECK IS PRESENT
            $is_present = $this->model_staff_attendance->select('id')->where('staff_id', '=', $staff_id)->where('date', '=', $date)->first();

            if ( $is_present !== NULL ):

                // SET STATUS AS ABSENT
                if ( $this->model_staff_attendance->destroy($is_present->id)):

                    // CHECK AVAILABLE USER
                    $available_user = $this->model_user->select('id')->where('ref_id', '=', $staff_id)->where('user_type', '=', 'staff')->first();
                    if ( $available_user != NULL ):
                        // INITIATE : NOTIFICATION
                        $this->model_notification->sender_id = $_SESSION['user']['id'];
                        $this->model_notification->receiver_id = $available_user->id;
                        $this->model_notification->title = "Attendance Marked";
                        $this->model_notification->body = "Your are absent on ".$date;
                        $this->model_notification->save();
                    endif;

                    echo json_encode( array( "status" => "success" ), JSON_PRETTY_PRINT );
                    exit();
                else:
                    echo json_encode( array( "status" => "failed" ), JSON_PRETTY_PRINT );
                    exit();
                endif;

            else:
                // SET STATUS AS PRESENT
                $this->model_staff_attendance->staff_id = $staff_id;
                $this->model_staff_attendance->date = $date;

                // CHECK : STAFF ATTENDANCE QUERY
                if ( $this->model_staff_attendance->save() ):

                    // CHECK AVAILABLE USER
                    $available_user = $this->model_user->select('id')->where('ref_id', '=', $staff_id)->where('user_type', '=', 'staff')->first();
                    if ( $available_user != NULL ):
                        // INITIATE : NOTIFICATION
                        $this->model_notification->sender_id = $_SESSION['user']['id'];
                        $this->model_notification->receiver_id = $available_user->id;
                        $this->model_notification->title = "Attendance Marked";
                        $this->model_notification->body = "Your are present on ".$date;
                        $this->model_notification->save();
                    endif;

                    echo json_encode( array( "status" => "success" ), JSON_PRETTY_PRINT );
                    exit();
                else:
                    echo json_encode( array( "status" => "failed" ), JSON_PRETTY_PRINT );
                    exit();
                endif;
                    
            endif;

        endif;
    }
    
}
?>