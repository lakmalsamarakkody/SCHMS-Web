<?php

// USE
use Carbon\Carbon;
use Illuminate\Database\Capsule\Manager as DB;
use Fpdf\Fpdf;

class Report extends Controller {

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
        $this->load->view('report/index', $data);
    }



    // START : ATTENDANCE REPORTS
    public function attendance() {
    
        // SITE DETAILS
		$data['app']['url']			= $this->config->get('base_url');
		$data['app']['title']		= $this->config->get('site_title');
		$data['app']['theme']		= $this->config->get('app_theme');

		// HEADER / FOOTER
		$data['template']['header']		= $this->load->controller('common/header', $data);
        $data['template']['footer']		= $this->load->controller('common/footer', $data);
        $data['template']['sidenav']	= $this->load->controller('common/sidenav', $data);
        $data['template']['topmenu']	= $this->load->controller('common/topmenu', $data);

        // MODELS
        $this->load->model('class');
        $this->load->model('grade');

        // QUERY CLASS
        foreach( $this->model_class->select('id', 'grade_id', 'staff_id', 'name')->get() as $key => $element ):
            $data['student_class'][$key]['id'] = $element->id;
            $data['student_class'][$key]['grade']['id'] = $element->grade_id;
            $data['student_class'][$key]['staff']['id'] = $element->staff_id;
            $data['student_class'][$key]['name'] = $element->name;

            $data['student_class'][$key]['grade']['name'] = $this->model_grade->select('name')->where('id', '=', $element->grade_id)->first()->name;
        endforeach;

		// RENDER VIEW
        $this->load->view('report/attendance', $data);
    }



    public function class_attendance_ajax() {

        // SET JSON HEADER
        header('Content-Type: application/json');

        // MODELS
        $this->load->model("class");
        $this->load->model("grade");
        $this->load->model("student");
        $this->load->model("report");
        $this->load->model("student/class");
        $this->load->model("student/attendance");

         // IS ANY student EXISTS
         if ( $this->model_student->select('id')->first() === NULL ):
            echo json_encode( array("status" => "failed", "error" => "No student exists in this system" ), JSON_PRETTY_PRINT );
            exit();
        endif;

        // VALIDATION : month
        $is_valid_month = GUMP::is_valid($this->request->post, array('month' => 'required|max_len,8'));
        if ( $is_valid_month !== true ):
            echo json_encode( array("status" => "failed", "error" => "Please select a valid Month" ), JSON_PRETTY_PRINT );
            exit();
        endif;

        $time_now = Carbon::now()->isoFormat('YYYY-MM-DD HH:mm');
        $date_now = Carbon::now()->isoFormat('YYYY-MM-DD');

        // Days in a month
        $dates = Carbon::createFromFormat("d/m/Y", "01/".$this->request->post['month']);
        $month_year = $dates->format("Y-m");
        $days_in_month = $dates->daysInMonth;

        // CHECK IF SUBMITED
        if ( isset($this->request->post['class_id']) AND !empty($this->request->post['class_id']) ):

            // IS CORRECT CLASS ID
            if ( $this->model_class->select('name')->where('id', '=', $this->request->post['class_id'])->first() === NULL ):
                echo json_encode( array("status" => "failed", "error" => "Invalid Class is Selected" ), JSON_PRETTY_PRINT );
                exit();
            endif;

            // CLASS DATA
            $class_data = $this->model_class->select('grade_id', 'name')->where('id', "=", $this->request->post['class_id'])->first();

            // DAY COUTNS
            $data['day_count'] = $days_in_month;

            // TITLE DETAILS
            $data['class_attendance']['class']['name'] = $this->model_grade->select('name')->where('id', '=', $class_data->grade_id)->first()->name." - ".$class_data->name;
            $data['class_attendance']['month'] = $this->request->post['month'];
            $data['class_attendance']['generated_on'] = $time_now;
            $data['class_attendance']['generated_by'] = "";

            // CONTENT
            $student = $this->model_student->select('id', 'class_id', 'admission_no', 'full_name', 'initials', 'surname')->where('class_id', '=', $this->request->post['class_id']);

            foreach( $student->get() as $key => $element ):

                // GET INDEX
                $index_no = $this->model_student_class->select('index_no')->where('student_id', '=', $element->id)->where('class_id', '=', $element->class_id)->first()->index_no;

                // STUDENT DETAILS
                $data['student'][$key]['index']  = $index_no;
                $data['student'][$key]['name'] = $element->initials.' '.$element->surname;

                // STUDENT STATUS FOR MONTH
                for ( $i=1; $i<= $days_in_month; $i++ ):
                    $attendance = $this->model_student_attendance->select('id', 'date')->where('student_id', '=', $element->id)->where('date', '=', $month_year."-".$i)->first();
                    if ( $attendance !== NULL):
                        $data['student'][$key]['attendance'][$i] = true;
                    else:
                        $data['student'][$key]['attendance'][$i] = false;
                    endif;

                    $data['days_in_month'][$i] = $i;
                endfor;

            endforeach;

            // JSReports
            $JSReport = new JSReport();
            $file = 'CLASS-ATTENDANCE-'.$_SESSION['user']['id'].'-'.Carbon::now()->format('Ymd-His');
            $JSReport->get_report('CLASS_ATTENDANCE', $data, 'attendance/'.$file);

            // ADD ENTRY TO DATABASE ( report table )
            $this->model_report->type = 'attendance_class';
            $this->model_report->file_name = $file.'.pdf';
            $this->model_report->generated_by = $_SESSION['user']['id'];

            // VALIDATE SAVE
            if ( $this->model_report->save() ):
                echo json_encode( array("status" => "success", "path" => $this->config->get('base_url').'/data/report/attendance/' ), JSON_PRETTY_PRINT );  
                exit();
            else:
                echo json_encode( array("status" => "failed", "error" => "Invalid Class Selected" ), JSON_PRETTY_PRINT );
                exit();
            endif;

        else:
            echo json_encode( array("status" => "failed", "error" => "Invalid Class Selected" ), JSON_PRETTY_PRINT );
            exit();
        endif;

    }

    public function staff_attendance_ajax() {

        // SET JSON HEADER
        header('Content-Type: application/json');

        // MODELS
        $this->load->model("staff");
        $this->load->model("staff/attendance");

        // IS ANY STAFF EXISTS
        if ( $this->model_staff->select('id')->first() === NULL ):
            echo json_encode( array("status" => "failed", "error" => "No staff exists in this system" ), JSON_PRETTY_PRINT );
            exit();
        endif;

        // VALIDATION : month
        $is_valid_month = GUMP::is_valid($this->request->post, array('month' => 'required|max_len,8'));
        if ( $is_valid_month !== true ):
            echo json_encode( array("status" => "failed", "error" => "Please select a valid Month" ), JSON_PRETTY_PRINT );
            exit();
        endif;

        $time_now = Carbon::now()->isoFormat('YYYY-MM-DD HH:mm');
        $date_now = Carbon::now()->isoFormat('YYYY-MM-DD');

        // Days in a month
        $dates = Carbon::createFromFormat("d/m/Y", "01/".$this->request->post['month']);
        $month_year = $dates->format("Y-m");
        $days_in_month = $dates->daysInMonth;

        // CHECK IF SUBMITED
        if ( isset($this->request->post['month']) AND !empty($this->request->post['month']) ):

            // DAY COUTNS
            $data['day_count'] = $days_in_month;

            // TITLE DETAILS
            $data['staff_attendance']['month'] = $this->request->post['month'];
            $data['staff_attendance']['generated_on'] = $time_now;
            $data['staff_attendance']['generated_by'] = "";

            // CONTENT
            $staff = $this->model_staff->select('id', 'employee_number', 'full_name', 'initials', 'surname');

            foreach( $staff->get() as $key => $element ):
                $data['staff'][$key]['employee_number']  = $element->employee_number;
                $data['staff'][$key]['name'] = $element->initials.' '.$element->surname;

                // STAFF STATUS FOR MONTH
                for ( $i=1; $i<= $days_in_month; $i++ ):
                    $attendance = $this->model_staff_attendance->select('id', 'date')->where('staff_id', '=', $element->id)->where('date', '=', $month_year."-".$i)->first();
                    if ( $attendance !== NULL):
                        $data['staff'][$key]['attendance'][$i] = true;
                    else:
                        $data['staff'][$key]['attendance'][$i] = false;
                    endif;

                    $data['days_in_month'][$i] = $i;
                endfor;

            endforeach;

            // JSReports
            $JSReport = new JSReport();
            $file = 'staff_attendance';
            $JSReport->get_report('STAFF_ATTENDANCE', $data, 'attendance/'.$file);

            // ADD ENTRY TO DATABASE ( report table )

            echo json_encode( array("status" => "success", "path" => $this->config->get('base_url').'/data/report/attendance/' ), JSON_PRETTY_PRINT );  
            exit();


        else:
            echo json_encode( array("status" => "failed", "error" => "Invalid Month Selected" ), JSON_PRETTY_PRINT );
            exit();
        endif;

    }
    // END : ATTENDANCE REPORTS

    // START : STUDENT REPORTS
    public function student() {
    
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
        $this->load->view('report/student', $data);
    }
    // END : STUDENT REPORTS

    // START : TIMETABLE REPORTS
    public function timetable() {
    
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

        // QUERY CLASS
        foreach( $this->model_class->select('id', 'grade_id', 'staff_id', 'name')->get() as $key => $element ):
            $data['classes'][$key]['id'] = $element->id;
            $data['classes'][$key]['grade']['id'] = $element->grade_id;
            $data['classes'][$key]['staff']['id'] = $element->staff_id;
            $data['classes'][$key]['name'] = $element->name;

            $data['classes'][$key]['grade']['name'] = $this->model_grade->select('name')->where('id', '=', $element->grade_id)->first()->name;
        endforeach;

        // QUERY STAFF
        foreach( $this->model_staff->select('id', 'full_name')->get() as $key => $element ):
            $data['staffs'][$key]['id'] = $element->id;
            $data['staffs'][$key]['fullname'] = $element->full_name;
        endforeach;

		// RENDER VIEW
        $this->load->view('report/timetable', $data);
    }

    public function class_timetable_ajax() {

        // SET JSON HEADER
        header('Content-Type: application/json');

        // MODELS
        $this->load->model("class");
        $this->load->model("grade");
        $this->load->model("class/timetable");
        $this->load->model("subject");
        $this->load->model("staff");

        $time_now = Carbon::now()->isoFormat('YYYY-MM-DD HH:mm');
        $date_now = Carbon::now()->isoFormat('YYYY-MM-DD');

        // CHECK IF SUBMITED
        if ( isset($this->request->post['class_id']) AND !empty($this->request->post['class_id']) ):

            // IS ANY class EXISTS
            if ( $this->model_class->select('id')->first() === NULL ):
                echo json_encode( array("status" => "failed", "error" => "No class exists in this system" ), JSON_PRETTY_PRINT );
                exit();
            endif;

            // IS CORRECT CLASS ID
            if ( $this->model_class->select('name')->where('id', '=', $this->request->post['class_id'])->first() === NULL ):
                echo json_encode( array("status" => "failed", "error" => "Invalid Class is Selected" ), JSON_PRETTY_PRINT );
                exit();
            endif;

            // CLASS DATA
            $class_data = $this->model_class->select('grade_id', 'name')->where('id', "=", $this->request->post['class_id'])->first();

            // TITLE DETAILS
            $data['timetable']['name'] = $this->model_grade->select('name')->where('id', '=', $class_data->grade_id)->first()->name." - ".$class_data->name;
            $data['timetable']['generated_on'] = $time_now;
            $data['timetable']['generated_by'] = "";

            // CONTENT
            $class_timetable = $this->model_class_timetable->select('id', 'day', 'period', 'subject_id', 'staff_id')->where('class_id', '=', $this->request->post['class_id']);

            $day_map = array(
                "1" => "mon",
                "2" => "tue",
                "3" => "wed",
                "4" => "thu",
                "5" => "fri"
            );

            foreach( $class_timetable->get() as $key => $el ):

                // CLEAR ASSIGNED VALUES AFTER REPETITION
                $subject_name = NULL;
                $staff_name = NULL;

                // QUERY SUBJECT NAME
                if ( $el->subject_id !== NULL ):
                    $subject_name = $this->model_subject->select('name')->where('id', '=', $el->subject_id)->first()->name;
                endif;

                // QUERY STAFF NAME
                if ( $el->staff_id !== NULL ):
                    $staff_name = $this->model_staff->select('initials')->where('id', '=', $el->staff_id)->first()->initials . " ". $this->model_staff->select('surname')->where('id', '=', $el->staff_id)->first()->surname;
                endif;
                // SCHEDULE
                $data['timetable']['schedule'][$day_map[$el->day]][$el->period]['subject']  = $subject_name;
                $data['timetable']['schedule'][$day_map[$el->day]][$el->period]['staff']  = $staff_name;

            endforeach;

            // JSReports
            $JSReport = new JSReport();
            $file = 'class_timetable';
            $JSReport->get_report('CLASS_TIMETABLE', $data, 'timetable/'.$file);

            // ADD ENTRY TO DATABASE ( report table )

            // RETURN
            echo json_encode( array("status" => "success", "path" => $this->config->get('base_url').'/data/report/timetable/' ), JSON_PRETTY_PRINT );  
            exit();


        else:
            echo json_encode( array("status" => "failed", "error" => "Invalid Class Selected" ), JSON_PRETTY_PRINT );
            exit();
        endif;
    }

    public function staff_timetable_ajax() {

        // SET JSON HEADER
        header('Content-Type: application/json');

        // MODELS
        $this->load->model("class");
        $this->load->model("grade");
        $this->load->model("class/timetable");
        $this->load->model("subject");
        $this->load->model("staff");

        $time_now = Carbon::now()->isoFormat('YYYY-MM-DD HH:mm');
        $date_now = Carbon::now()->isoFormat('YYYY-MM-DD');

        // CHECK IF SUBMITED
        if ( isset($this->request->post['staff_id']) AND !empty($this->request->post['staff_id']) ):

             // IS ANY STAFF EXISTS
            if ( $this->model_staff->select('id')->first() === NULL ):
                echo json_encode( array("status" => "failed", "error" => "No staff exists in this system" ), JSON_PRETTY_PRINT );
                exit();
            endif;

            // IS CORRECT STAFF ID
            if ( $this->model_staff->select('initials')->where('id', '=', $this->request->post['staff_id'])->first() === NULL ):
                echo json_encode( array("status" => "failed", "error" => "Invalid Staff is Selected" ), JSON_PRETTY_PRINT );
                exit();
            endif;

            $staff = $this->model_staff->select('employee_number','initials', 'surname')->where('id', '=', $this->request->post['staff_id'])->first();

            // TITLE DETAILS
            $data['timetable']['employee_number'] = $staff->employee_number;
            $data['timetable']['name'] = $staff->initials. " ". $staff->surname;
            $data['timetable']['generated_on'] = $time_now;
            $data['timetable']['generated_by'] = "";

            // CONTENT
            $class_timetable = $this->model_class_timetable->select('id', 'day', 'period', 'subject_id', 'class_id')->where('staff_id', '=', $this->request->post['staff_id']);

            $day_map = array(
                "1" => "mon",
                "2" => "tue",
                "3" => "wed",
                "4" => "thu",
                "5" => "fri"
            );

            foreach( $class_timetable->get() as $key => $el ):

                // CLEAR ASSIGNED VALUES AFTER REPETITION
                $subject_name = NULL;
                $class_name = NULL;

                // QUERY SUBJECT NAME
                if ( $el->subject_id !== NULL ):
                    $subject_name = $this->model_subject->select('name')->where('id', '=', $el->subject_id)->first()->name;
                endif;

                // QUERY CLASS NAME
                if ( $el->class_id !== NULL ):
                    $class = $this->model_class->select('grade_id', 'name')->where('id', '=', $el->class_id)->first();
                    $grade = $this->model_grade->select('name')->where('id', '=', $class->grade_id)->first();
                    $class_name =  $grade->name. " - ". $class->name ;
                endif;

                // SCHEDULE
                $data['timetable']['schedule'][$day_map[$el->day]][$el->period]['subject']  = $subject_name;
                $data['timetable']['schedule'][$day_map[$el->day]][$el->period]['class']  = $class_name;

            endforeach;

            // JSReports
            $JSReport = new JSReport();
            $file = 'staff_timetable';
            $JSReport->get_report('STAFF_TIMETABLE', $data, 'timetable/'.$file);

            // ADD ENTRY TO DATABASE ( report table )

            // RETURN
            echo json_encode( array("status" => "success", "path" => $this->config->get('base_url').'/data/report/timetable/' ), JSON_PRETTY_PRINT );  
            exit();


        else:
            echo json_encode( array("status" => "failed", "error" => "Please Select a Staff name" ), JSON_PRETTY_PRINT );
            exit();
        endif;
    }
    // END : TIMETABLE REPORTS

    // START : RESULT REPORTS
    public function result() {
    
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
        $this->load->view('report/result', $data);
    }
    // END : RESULT REPORTS

    // START : HEALTH REPORTS
    public function health() {
    
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

        // QUERY CLASS
        foreach( $this->model_class->select('id', 'grade_id', 'staff_id', 'name')->get() as $key => $element ):
            $data['student_class'][$key]['id'] = $element->id;
            $data['student_class'][$key]['grade']['id'] = $element->grade_id;
            $data['student_class'][$key]['staff']['id'] = $element->staff_id;
            $data['student_class'][$key]['name'] = $element->name;

            $data['student_class'][$key]['grade']['name'] = $this->model_grade->select('name')->where('id', '=', $element->grade_id)->first()->name;
        endforeach;

        // QUERY STUDENT
        foreach( $this->model_student->select('id', 'full_name')->get() as $key => $element ):
            $data['students'][$key]['id'] = $element->id;
            $data['students'][$key]['fullname'] = $element->full_name;
        endforeach;

		// RENDER VIEW
        $this->load->view('report/health', $data);
    }

    public function class_health_ajax() {

        // SET JSON HEADER
        header('Content-Type: application/json');

        // MODELS
        $this->load->model("class");
        $this->load->model("grade");
        $this->load->model("student");
        $this->load->model("student/health");

        $time_now = Carbon::now()->isoFormat('YYYY-MM-DD HH:mm');
        $date_now = Carbon::now()->isoFormat('YYYY-MM-DD');

        // CHECK IF SUBMITED
        if ( isset($this->request->post['class_id']) AND !empty($this->request->post['class_id']) ):

             // IS ANY STUDENT EXISTS
             if ( $this->model_student->select('id')->first() === NULL ):
                echo json_encode( array("status" => "failed", "error" => "No student exists in this system" ), JSON_PRETTY_PRINT );
                exit();
            endif;

            // IS CORRECT CLASS ID
            if ( $this->model_class->select('name')->where('id', '=', $this->request->post['class_id'])->first() === NULL ):
                echo json_encode( array("status" => "failed", "error" => "Invalid Class is Selected" ), JSON_PRETTY_PRINT );
                exit();
            endif;

            // QUERY CLASS NAME
            $class = $this->model_class->select('grade_id', 'name')->where('id', '=', $this->request->post['class_id'])->first();
            $grade = $this->model_grade->select('name')->where('id', '=', $class->grade_id)->first();
            $class_name =  $grade->name. " - ". $class->name ;

            $join_data = DB::table('student')
            ->join('student_has_class', 'student.id', 'student_has_class.student_id')
            ->join('student_health', 'student.id', 'student_health.student_id')
            ->where('student.class_id', '=', $this->request->post['class_id'])
            ->select('student.initials', 'student.surname', 'student_has_class.index_no', 'student_health.heart_rate', 'student_health.blood_pressure', 'student_health.height', 'student_health.weight', 'student_health.bmi', 'student_health.vaccination', 'student_health.speciality', 'student_health.blood_group', 'student_health.surgeries');

            // TITLE DETAILS
            $data['health']['class']['name'] = $class_name;
            $data['health']['generated_on'] = $time_now;
            $data['health']['generated_by'] = "";

            // CONTENT
            foreach ( $join_data->get() as $key => $el ):
                $data['health']['student'][$key]['index'] = $el->index_no;
                $data['health']['student'][$key]['name'] = $el->initials. " ". $el->surname;
                $data['health']['student'][$key]['hr'] = $el->heart_rate;
                $data['health']['student'][$key]['bp'] = $el->blood_pressure;
                $data['health']['student'][$key]['height'] = $el->height;
                $data['health']['student'][$key]['weight'] = $el->weight;
                $data['health']['student'][$key]['bmi'] = $el->bmi;
                $data['health']['student'][$key]['vaccination'] = $el->vaccination;
                $data['health']['student'][$key]['specialities'] = $el->speciality;
                $data['health']['student'][$key]['blood_group'] = $el->blood_group;
                $data['health']['student'][$key]['surgeries'] = $el->surgeries;
            endforeach;

            // JSReports
            $JSReport = new JSReport();
            $file = 'class_health';
            $JSReport->get_report('CLASS_HEALTH', $data, 'health/'.$file);

            // ADD ENTRY TO DATABASE ( report table )

            // RETURN
            echo json_encode( array("status" => "success", "path" => $this->config->get('base_url').'/data/report/health/' ), JSON_PRETTY_PRINT );  
            exit();


        else:
            echo json_encode( array("status" => "failed", "error" => "Please Select a Class" ), JSON_PRETTY_PRINT );
            exit();
        endif;

    }

    public function student_health_ajax() {

        // SET JSON HEADER
        header('Content-Type: application/json');

        // MODELS
        $this->load->model("class");
        $this->load->model("grade");
        $this->load->model("student");
        $this->load->model("student/health");

        $time_now = Carbon::now()->isoFormat('YYYY-MM-DD HH:mm');
        $date_now = Carbon::now()->isoFormat('YYYY-MM-DD');

        // CHECK IF SUBMITED
        if ( isset($this->request->post['student_id']) AND !empty($this->request->post['student_id']) ):

             // IS ANY STUDENT EXISTS
             if ( $this->model_student->select('id')->first() === NULL ):
                echo json_encode( array("status" => "failed", "error" => "No Student exists in this system" ), JSON_PRETTY_PRINT );
                exit();
            endif;

            // IS CORRECT STUDENT ID
            if ( $this->model_student->select('id')->where('id', '=', $this->request->post['student_id'])->first() === NULL ):
                echo json_encode( array("status" => "failed", "error" => "Invalid Student is Selected" ), JSON_PRETTY_PRINT );
                exit();
            endif;

            // QUERY CLASS NAME
            $class_id = $this->model_student->select('class_id')->where('id', '=', $this->request->post['student_id'])->first()->class_id;
            $class = $this->model_class->select('grade_id', 'name')->where('id', '=', $class_id)->first();
            $grade = $this->model_grade->select('name')->where('id', '=', $class->grade_id)->first();
            $class_name =  $grade->name. " - ". $class->name ;

            $join_data = DB::table('student')
            ->join('student_has_class', 'student.id', 'student_has_class.student_id')
            ->join('student_health', 'student.id', 'student_health.student_id')
            ->where('student.id', '=', $this->request->post['student_id'])
            ->select('student.initials', 'student.surname', 'student_has_class.index_no', 'student_health.heart_rate', 'student_health.blood_pressure', 'student_health.height', 'student_health.weight', 'student_health.bmi', 'student_health.vaccination', 'student_health.speciality', 'student_health.blood_group', 'student_health.surgeries')
            ->first();

            // TITLE DETAILS
            $data['health']['class']['name'] = $class_name;
            $data['health']['generated_on'] = $time_now;
            $data['health']['generated_by'] = "";

            // CONTENT
            $data['health']['student']['index'] = $join_data->index_no;
            $data['health']['student']['name'] = $join_data->initials. " ". $join_data->surname;
            $data['health']['student']['hr'] = $join_data->heart_rate;
            $data['health']['student']['bp'] = $join_data->blood_pressure;
            $data['health']['student']['height'] = $join_data->height;
            $data['health']['student']['weight'] = $join_data->weight;
            $data['health']['student']['bmi'] = $join_data->bmi;
            $data['health']['student']['vaccination'] = $join_data->vaccination;
            $data['health']['student']['specialities'] = $join_data->speciality;
            $data['health']['student']['blood_group'] = $join_data->blood_group;
            $data['health']['student']['surgeries'] = $join_data->surgeries;

            // JSReports
            $JSReport = new JSReport();
            $file = 'student_health';
            $JSReport->get_report('STUDENT_HEALTH', $data, 'health/'.$file);

            // ADD ENTRY TO DATABASE ( report table )

            // RETURN
            echo json_encode( array("status" => "success", "path" => $this->config->get('base_url').'/data/report/health/' ), JSON_PRETTY_PRINT );  
            exit();


        else:
            echo json_encode( array("status" => "failed", "error" => "Please Select a Student" ), JSON_PRETTY_PRINT );
            exit();
        endif;

    }
    // END : HEALTH REPORTS

    // START : STAFF REPORTS
    public function staff() {
    
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
        $this->load->view('report/staff', $data);
    }

    public function staff_present_ajax() {

        // SET JSON HEADER
        header('Content-Type: application/json');

        // MODELS
        $this->load->model("class");
        $this->load->model("grade");
        $this->load->model("staff");
        $this->load->model("staff/attendance");

        $time_now = Carbon::now()->isoFormat('YYYY-MM-DD HH:mm');
        $date_now = Carbon::now()->isoFormat('YYYY-MM-DD');

        // CHECK IF SUBMITED
        if ( isset($this->request->post['staff-present']) AND !empty($this->request->post['staff-present']) ):

            // IS ANY STAFF EXISTS
            if ( $this->model_staff->select('id')->first() === NULL ):
                echo json_encode( array("status" => "failed", "error" => "No staff exists in this system" ), JSON_PRETTY_PRINT );
                exit();
            endif;

            $staff = DB::table('staff_attendance')
            ->join('staff', 'staff_attendance.staff_id', 'staff.id')
            ->join('staff_type', 'staff.type_id', 'staff_type.id')
            ->join('staff_category', 'staff_type.category_id', 'staff_category.id')
            ->where('staff_attendance.date', '=', $date_now)
            ->select('staff.id', 'staff.employee_number', 'staff.initials', 'staff.surname', 'staff.gender', 'staff_attendance.date', 'staff_type.name as stname', 'staff_category.name as scname');

            // TITLE DETAILS
            $data['staff']['present']['date'] = $date_now;
            $data['staff']['present']['count'] = $staff->get()->count();
            $data['staff']['present']['generated_on'] = $time_now;
            $data['staff']['present']['generated_by'] = "";
            
            // CONTENT
            if ( $staff !== NULL ):

                foreach ( $staff->get() as $key => $element ):

                    $data['staff'][$key]['employee_number'] = $element->employee_number;
                    $data['staff'][$key]['name'] = $element->initials. " ". $element->surname;
                    $data['staff'][$key]['category'] = $element->scname;
                    $data['staff'][$key]['type'] = $element->stname;

                    // SET TITLE
                    if ( $element->gender == "Male" ): 
                        $data['staff'][$key]['title'] = "Mr. "; 
                    else:
                        $data['staff'][$key]['title'] = "Mrs. "; 
                    endif;

                    // TEACHER IN CHARGE CLASS
                    $tic_class = $this->model_class->select('id', 'grade_id', 'name')->where('staff_id', '=', $element->id)->first();

                    if ( $tic_class !== NULL ):

                        // QUERY CLASS NAME
                        $grade = $this->model_grade->select('name')->where('id', '=', $tic_class->grade_id)->first();
                        $data['staff'][$key]['class'] =  $grade->name. " - ". $tic_class->name ;

                    endif;

                endforeach;

                // JSReports
                $JSReport = new JSReport();
                $file = 'staff_present';
                $JSReport->get_report('STAFF_PRESENT', $data, 'staff/'.$file);

                // ADD ENTRY TO DATABASE ( report table )

                // RETURN
                echo json_encode( array("status" => "success", "path" => $this->config->get('base_url').'/data/report/staff/' ), JSON_PRETTY_PRINT );  
                exit();

            else:
                // RETURN
                echo json_encode( array("status" => "failed", "error" => "No any staff is present today till now" ), JSON_PRETTY_PRINT );
                exit();
            endif;        

        else:
            // RETURN
            echo json_encode( array("status" => "failed", "error" => "Generating from an Invalid path" ), JSON_PRETTY_PRINT );
            exit();
        endif;        
    }

    public function staff_absent_ajax() {

        // SET JSON HEADER
        header('Content-Type: application/json');

        // MODELS
        $this->load->model("class");
        $this->load->model("grade");
        $this->load->model("staff");
        $this->load->model("staff/attendance");

        $time_now = Carbon::now()->isoFormat('YYYY-MM-DD HH:mm');
        $date_now = Carbon::now()->isoFormat('YYYY-MM-DD');

        // CHECK IF SUBMITED
        if ( isset($this->request->post['staff-absent']) AND !empty($this->request->post['staff-absent']) ):

            // IS ANY STAFF EXISTS
            if ( $this->model_staff->select('id')->first() === NULL ):
                echo json_encode( array("status" => "failed", "error" => "No staff exists in this system" ), JSON_PRETTY_PRINT );
                exit();
            endif;

            $staff = DB::table('staff')
            ->join('staff_type', 'staff.type_id', 'staff_type.id')
            ->join('staff_category', 'staff_type.category_id', 'staff_category.id')
            ->select('staff.id', 'staff.employee_number', 'staff.initials', 'staff.surname', 'staff.gender', 'staff_type.name as stname', 'staff_category.name as scname');

            // TITLE DETAILS
            $data['staff']['absent']['date'] = $date_now;
            $data['staff']['absent']['generated_on'] = $time_now;
            $data['staff']['absent']['generated_by'] = "";
            $count = 0;
            
            // CONTENT
            if ( $staff !== NULL ):

                foreach ( $staff->get() as $key => $element ):

                    $staff_attendance = $this->model_staff_attendance->select('id')->where('staff_id', '=', $element->id)->where('date', '=', $date_now)->first();

                    if ( $staff_attendance == NULL ):

                        $data['staff'][$key]['employee_number'] = $element->employee_number;
                        $data['staff'][$key]['name'] = $element->initials. " ". $element->surname;
                        $data['staff'][$key]['category'] = $element->scname;
                        $data['staff'][$key]['type'] = $element->stname;

                        // SET TITLE
                        if ( $element->gender == "Male" ): 
                            $data['staff'][$key]['title'] = "Mr. "; 
                        else:
                            $data['staff'][$key]['title'] = "Mrs. "; 
                        endif;

                        // TEACHER IN CHARGE CLASS
                        $tic_class = $this->model_class->select('id', 'grade_id', 'name')->where('staff_id', '=', $element->id)->first();

                        if ( $tic_class !== NULL ):

                            // QUERY CLASS NAME
                            $grade = $this->model_grade->select('name')->where('id', '=', $tic_class->grade_id)->first();
                            $data['staff'][$key]['class'] =  $grade->name. " - ". $tic_class->name ;

                        endif;
                        unset ($staff_attendance);

                        // COUNT
                        $count = $count + 1;

                    endif;
                    $data['staff']['absent']['count'] = $count;

                endforeach;

                // JSReports
                $JSReport = new JSReport();
                $file = 'staff_absent';
                $JSReport->get_report('STAFF_ABSENT', $data, 'staff/'.$file);

                // ADD ENTRY TO DATABASE ( report table )

                // RETURN
                echo json_encode( array("status" => "success", "path" => $this->config->get('base_url').'/data/report/staff/' ), JSON_PRETTY_PRINT );  
                exit();
                
            else:
                // RETURN
                echo json_encode( array("status" => "failed", "error" => "No any staff is present today till now" ), JSON_PRETTY_PRINT );
                exit();
            endif;        

        else:
            // RETURN
            echo json_encode( array("status" => "failed", "error" => "Generating from an Invalid path" ), JSON_PRETTY_PRINT );
            exit();
        endif;        
    }
    // END : STAFF REPORTS

}