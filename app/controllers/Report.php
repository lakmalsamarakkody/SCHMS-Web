<?php

// USE
use Carbon\Carbon;
use Illuminate\Database\Capsule\Manager as DB;

class Report extends Controller {

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
        $this->load->model('user');

        // CHECK PERMISSION : index
        if ( $this->model_user->find($_SESSION['user']['id'])->hasPermission('report-index-view') ):
            $data['permission']['report']['index']['view'] = true;
        else:
            $data['permission']['report']['index']['view'] = false;
        endif;

        // CHECK PERMISSION : report_any_generate
        if ( $this->model_user->find($_SESSION['user']['id'])->hasPermission('report-any-generate') ):
            $data['permission']['report']['any']['generate'] = true;
        else:
            $data['permission']['report']['any']['generate'] = false;
        endif;

        // CHECK PERMISSION : report_any_view
        if ( $this->model_user->find($_SESSION['user']['id'])->hasPermission('report-any-view') ):
            $data['permission']['report']['any']['view'] = true;
        else:
            $data['permission']['report']['any']['view'] = false;
        endif;

        // CHECK PERMISSION : report_any_delete
        if ( $this->model_user->find($_SESSION['user']['id'])->hasPermission('report-any-delete') ):
            $data['permission']['report']['any']['delete'] = true;
        else:
            $data['permission']['report']['any']['delete'] = false;
        endif;

		// RENDER VIEW
        $this->load->view('report/index', $data);
    }



    // START : ATTENDANCE REPORTS
    public function attendance() {

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

        // MODELS
        $this->load->model('user');
        $this->load->model('report');
        $this->load->model('class');
        $this->load->model('grade');

        // CHECK PERMISSION : attendance
        if ( $this->model_user->find($_SESSION['user']['id'])->hasPermission('report-attendance-view') ):
            $data['permission']['report']['attendance']['view'] = true;
        else:
            $data['permission']['report']['attendance']['view'] = false;
        endif;

        // CHECK PERMISSION : report_any_generate
        if ( $this->model_user->find($_SESSION['user']['id'])->hasPermission('report-any-generate') ):
            $data['permission']['report']['any']['generate'] = true;
        else:
            $data['permission']['report']['any']['generate'] = false;
        endif;

        // CHECK PERMISSION : report_any_view
        if ( $this->model_user->find($_SESSION['user']['id'])->hasPermission('report-any-view') ):
            $data['permission']['report']['any']['view'] = true;
        else:
            $data['permission']['report']['any']['view'] = false;
        endif;

        // CHECK PERMISSION : report_any_delete
        if ( $this->model_user->find($_SESSION['user']['id'])->hasPermission('report-any-delete') ):
            $data['permission']['report']['any']['delete'] = true;
        else:
            $data['permission']['report']['any']['delete'] = false;
        endif;

        // QUERY CLASS
        foreach( $this->model_class->select('id', 'grade_id', 'staff_id', 'name')->get() as $key => $element ):
            $data['student_class'][$key]['id'] = $element->id;
            $data['student_class'][$key]['grade']['id'] = $element->grade_id;
            $data['student_class'][$key]['staff']['id'] = $element->staff_id;
            $data['student_class'][$key]['name'] = $element->name;

            $data['student_class'][$key]['grade']['name'] = $this->model_grade->select('name')->where('id', '=', $element->grade_id)->first()->name;
        endforeach;


        // QUERY REPORTS ( BY CLASS )
        $is_class_reports = $this->model_report->select('id', 'file_name', 'generated_by', 'created_on')->where('type', '=', 'class_attendance')->get();
        if ( $is_class_reports !== NULL ):
            foreach( $is_class_reports as $key => $el ):
                $user = $this->model_user->select('username')->where('id', '=', $el->generated_by)->first();
                $data['reports']['class'][$key]['id'] = $el->id;
                $data['reports']['class'][$key]['generated_on'] = $el->created_on->format('Y-m-d h:i:s A');
                $data['reports']['class'][$key]['user']['username'] = $user->username;
                $data['reports']['class'][$key]['path'] = $this->config->get('base_url').'/data/reports/attendance/'.$el->file_name;
                $data['reports']['class'][$key]['file'] = $el->file_name;
            endforeach;
        endif;

        // QUERY REPORTS ( BY STAFF )
        $is_staff_reports = $this->model_report->select('id', 'file_name', 'generated_by', 'created_on')->where('type', '=', 'staff_attendance')->get();
        if ( $is_staff_reports !== NULL ):
            foreach( $is_staff_reports as $key => $el ):
                $user = $this->model_user->select('username')->where('id', '=', $el->generated_by)->first();
                $data['reports']['staff'][$key]['id'] = $el->id;
                $data['reports']['staff'][$key]['generated_on'] = $el->created_on->format('Y-m-d h:i:s A');
                $data['reports']['staff'][$key]['user']['username'] = $user->username;
                $data['reports']['staff'][$key]['path'] = $this->config->get('base_url').'/data/reports/attendance/'.$el->file_name;
                $data['reports']['staff'][$key]['file'] = $el->file_name;
            endforeach;
        endif;

		// RENDER VIEW
        $this->load->view('report/attendance', $data);
    }



    public function class_attendance_ajax() {

        //CHECK LOGIN STATUS
		if( !isset($_SESSION['user']) OR $_SESSION['user']['is_login'] != true ):
			header( 'Location:' . $this->config->get('base_url') . '/logout' );
			exit();
		endif;

        // SET JSON HEADER
        header('Content-Type: application/json');

        // MODELS
        $this->load->model("user");
        $this->load->model("report");
        $this->load->model("class");
        $this->load->model("grade");
        $this->load->model("student");
        $this->load->model("student/class");
        $this->load->model("student/attendance");

        // PERMISSION
        if ( !$this->model_user->find($_SESSION['user']['id'])->hasPermission('report-any-create') ):
            echo json_encode( array( "status" => "failed", "error" => "Permission denied" ), JSON_PRETTY_PRINT );
            exit();
        endif;

        $time_now = Carbon::now()->format('Y-m-d h:i:s A');
        $date_now = Carbon::now()->isoFormat('YYYY-MM-DD');

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
            $data['class_attendance']['generated_by'] = $this->model_user->select('username')->where('id', '=', $_SESSION['user']['id'])->first()->username;

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
            $file = 'class_attendance_'.$_SESSION['user']['id'].'_'.Carbon::now()->format('Ymd_His');
            $JSReport->get_report('CLASS_ATTENDANCE', $data, 'attendance/'.$file);

            // ADD ENTRY TO DATABASE ( report table )
            $this->model_report->type = 'class_attendance';
            $this->model_report->file_name = $file.'.pdf';
            $this->model_report->generated_by = $_SESSION['user']['id'];

            // VALIDATE SAVE
            if ( $this->model_report->save() ):
                echo json_encode( array("status" => "success", "path" => $this->config->get('base_url').'/data/report/attendance/' ), JSON_PRETTY_PRINT );  
                exit();
            else:
                echo json_encode( array("status" => "failed", "error" => "Error occured while saving your report" ), JSON_PRETTY_PRINT );
                exit();
            endif;

        else:
            echo json_encode( array("status" => "failed", "error" => "Invalid Class Selected" ), JSON_PRETTY_PRINT );
            exit();
        endif;

    }

    public function staff_attendance_ajax() {

        //CHECK LOGIN STATUS
		if( !isset($_SESSION['user']) OR $_SESSION['user']['is_login'] != true ):
			header( 'Location:' . $this->config->get('base_url') . '/logout' );
			exit();
		endif;

        // SET JSON HEADER
        header('Content-Type: application/json');

        // MODELS
        $this->load->model("user");
        $this->load->model("report");
        $this->load->model("staff");
        $this->load->model("staff/attendance");

        // PERMISSION
        if ( !$this->model_user->find($_SESSION['user']['id'])->hasPermission('report-any-create') ):
            echo json_encode( array( "status" => "failed", "error" => "Permission denied" ), JSON_PRETTY_PRINT );
            exit();
        endif;

        $time_now = Carbon::now()->format('Y-m-d h:i:s A');
        $date_now = Carbon::now()->isoFormat('YYYY-MM-DD');

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
            $data['staff_attendance']['generated_by'] = $this->model_user->select('username')->where('id', '=', $_SESSION['user']['id'])->first()->username;

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
            $file = 'staff_attendance_'.$_SESSION['user']['id'].'_'.Carbon::now()->format('Ymd_His');
            $JSReport->get_report('STAFF_ATTENDANCE', $data, 'attendance/'.$file);

            // ADD ENTRY TO DATABASE ( report table )
            $this->model_report->type = 'staff_attendance';
            $this->model_report->file_name = $file.'.pdf';
            $this->model_report->generated_by = $_SESSION['user']['id'];

            // VALIDATE SAVE
            if ( $this->model_report->save() ):
                echo json_encode( array("status" => "success", "path" => $this->config->get('base_url').'/data/report/attendance/' ), JSON_PRETTY_PRINT );  
                exit();
            else:
                echo json_encode( array("status" => "failed", "error" => "Error occured while saving your report" ), JSON_PRETTY_PRINT );
                exit();
            endif;

        else:
            echo json_encode( array("status" => "failed", "error" => "Invalid Month Selected" ), JSON_PRETTY_PRINT );
            exit();
        endif;
    }
    // END : ATTENDANCE REPORTS

    // START : STUDENT REPORTS
    public function student() {

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
        $this->load->model('user');
        $this->load->model('report');
        $this->load->model('class');
        $this->load->model('grade');
        $this->load->model('student');

        // CHECK PERMISSION : student
        if ( $this->model_user->find($_SESSION['user']['id'])->hasPermission('report-student-view') ):
            $data['permission']['report']['student']['view'] = true;
        else:
            $data['permission']['report']['student']['view'] = false;
        endif;

        // CHECK PERMISSION : report_any_generate
        if ( $this->model_user->find($_SESSION['user']['id'])->hasPermission('report-any-generate') ):
            $data['permission']['report']['any']['generate'] = true;
        else:
            $data['permission']['report']['any']['generate'] = false;
        endif;

        // CHECK PERMISSION : report_any_view
        if ( $this->model_user->find($_SESSION['user']['id'])->hasPermission('report-any-view') ):
            $data['permission']['report']['any']['view'] = true;
        else:
            $data['permission']['report']['any']['view'] = false;
        endif;

        // CHECK PERMISSION : report_any_delete
        if ( $this->model_user->find($_SESSION['user']['id'])->hasPermission('report-any-delete') ):
            $data['permission']['report']['any']['delete'] = true;
        else:
            $data['permission']['report']['any']['delete'] = false;
        endif;

        // QUERY CLASS
        foreach( $this->model_class->select('id', 'grade_id', 'staff_id', 'name')->orderBy('grade_id')->orderBy('name')->get() as $key => $element ):
            $data['classes'][$key]['id'] = $element->id;
            $data['classes'][$key]['grade']['id'] = $element->grade_id;
            $data['classes'][$key]['staff']['id'] = $element->staff_id;
            $data['classes'][$key]['name'] = $element->name;

            $data['classes'][$key]['grade']['name'] = $this->model_grade->select('name')->where('id', '=', $element->grade_id)->first()->name;
        endforeach;

        // QUERY STUDENT
        foreach( $this->model_student->select('id', 'full_name')->get() as $key => $element ):
            $data['students'][$key]['id'] = $element->id;
            $data['students'][$key]['fullname'] = $element->full_name;
        endforeach;

        // QUERY REPORTS ( BY CLASS )
        $is_class_reports = $this->model_report->select('id', 'file_name', 'generated_by', 'created_on')->where('type', '=', 'class_student_bio')->get();
        if ( $is_class_reports !== NULL ):
            foreach( $is_class_reports as $key => $el ):
                $user = $this->model_user->select('username')->where('id', '=', $el->generated_by)->first();
                $data['reports']['class'][$key]['id'] = $el->id;
                $data['reports']['class'][$key]['generated_on'] = $el->created_on->format('Y-m-d h:i:s A');
                $data['reports']['class'][$key]['user']['username'] = $user->username;
                $data['reports']['class'][$key]['path'] = $this->config->get('base_url').'/data/reports/student/'.$el->file_name;
                $data['reports']['class'][$key]['file'] = $el->file_name;
            endforeach;
        endif;

        // QUERY REPORTS ( BY STUDENT )
        $is_student_reports = $this->model_report->select('id', 'file_name', 'generated_by', 'created_on')->where('type', '=', 'one_student_bio')->get();
        if ( $is_student_reports !== NULL ):
            foreach( $is_student_reports as $key => $el ):
                $user = $this->model_user->select('username')->where('id', '=', $el->generated_by)->first();
                $data['reports']['student'][$key]['id'] = $el->id;
                $data['reports']['student'][$key]['generated_on'] = $el->created_on->format('Y-m-d h:i:s A');
                $data['reports']['student'][$key]['user']['username'] = $user->username;
                $data['reports']['student'][$key]['path'] = $this->config->get('base_url').'/data/reports/student/'.$el->file_name;
                $data['reports']['student'][$key]['file'] = $el->file_name;
            endforeach;
        endif;

		// RENDER VIEW
        $this->load->view('report/student', $data);
    }

    public function class_all_student_ajax() {

        //CHECK LOGIN STATUS
		if( !isset($_SESSION['user']) OR $_SESSION['user']['is_login'] != true ):
			header( 'Location:' . $this->config->get('base_url') . '/logout' );
			exit();
        endif;
        
        // SET JSON HEADER
        header('Content-Type: application/json');

        // MODELS
        $this->load->model("user");
        $this->load->model("report");
        $this->load->model("student");
        $this->load->model("district");
        $this->load->model("religion");
        $this->load->model("student/class");
        $this->load->model("class");
        $this->load->model("grade");

        // PERMISSION
        if ( !$this->model_user->find($_SESSION['user']['id'])->hasPermission('report-any-create') ):
            echo json_encode( array( "status" => "failed", "error" => "Permission denied" ), JSON_PRETTY_PRINT );
            exit();
        endif;

        $time_now = Carbon::now()->format('Y-m-d h:i:s A');
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

            // QUERY STUDENT DATA
            $join_data = DB::table('student')
            ->join('district', 'student.district_id', 'district.id')
            ->join('religion', 'student.religion_id', 'religion.id')
            ->join('student_has_class', 'student.id', 'student_has_class.student_id')
            ->where('student.class_id', '=', $this->request->post['class_id'])
            ->select('admission_no', 'admission_date', 'full_name', 'initials', 'surname', 'dob', 'gender', 'email', 'phone_mobile', 'address', 'city', 'birth_place', 'district.name as distname', 'religion.name as relname', 'student_has_class.index_no');

            // TITLE DETAILS
            $data['report']['class']['name'] = $class_name;
            $data['report']['generated_on'] = $time_now;
            $data['report']['generated_by'] = $this->model_user->select('username')->where('id', '=', $_SESSION['user']['id'])->first()->username;

            // CONTENT
            foreach ( $join_data->get() as $key => $el ):
                $data['student'][$key]['admission'] = $el->admission_no;
                // $data['student'][$key]['admission_date'] = $el->admission_date;
                $data['student'][$key]['index'] = $el->index_no;
                // $data['student'][$key]['fullname'] = $el->full_name;
                $data['student'][$key]['name'] = $el->initials. " ". $el->surname;
                $data['student'][$key]['dob'] = $el->dob;
                $data['student'][$key]['gender'] = $el->gender;
                $data['student'][$key]['email'] = $el->email;
                $data['student'][$key]['mobile'] = $el->phone_mobile;
                $data['student'][$key]['address'] = $el->address;
                $data['student'][$key]['city'] = $el->city;
                // $data['student'][$key]['birth_place'] = $el->birth_place;
                $data['student'][$key]['distname'] = $el->distname;
                $data['student'][$key]['relname'] = $el->relname;
            endforeach;

            // JSReports
            $JSReport = new JSReport();
            $file = 'class_student_bio_'.$_SESSION['user']['id'].'_'.Carbon::now()->format('Ymd_His');
            $JSReport->get_report('CLASS_STUDENT', $data, 'student/'.$file);

            // ADD ENTRY TO DATABASE ( report table )
            $this->model_report->type = 'class_student_bio';
            $this->model_report->file_name = $file.'.pdf';
            $this->model_report->generated_by = $_SESSION['user']['id'];

            // VALIDATE SAVE
            if ( $this->model_report->save() ):
                echo json_encode( array("status" => "success", "path" => $this->config->get('base_url').'/data/report/attendance/' ), JSON_PRETTY_PRINT );  
                exit();
            else:
                echo json_encode( array("status" => "failed", "error" => "Error occured while saving your report" ), JSON_PRETTY_PRINT );
                exit();
            endif;

        else:
            echo json_encode( array("status" => "failed", "error" => "Please Select a Class" ), JSON_PRETTY_PRINT );
            exit();
        endif;

    }

    public function class_one_student_ajax() {

        //CHECK LOGIN STATUS
		if( !isset($_SESSION['user']) OR $_SESSION['user']['is_login'] != true ):
			header( 'Location:' . $this->config->get('base_url') . '/logout' );
			exit();
		endif;

        // SET JSON HEADER
        header('Content-Type: application/json');

        // MODELS
        $this->load->model("user");
        $this->load->model("report");
        $this->load->model("student");
        $this->load->model("district");
        $this->load->model("religion");
        $this->load->model("student/class");
        $this->load->model("class");
        $this->load->model("grade");

        // PERMISSION
        if ( !$this->model_user->find($_SESSION['user']['id'])->hasPermission('report-any-create') ):
            echo json_encode( array( "status" => "failed", "error" => "Permission denied" ), JSON_PRETTY_PRINT );
            exit();
        endif;

        $time_now = Carbon::now()->format('Y-m-d h:i:s A');
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

            // QUERY STUDENT DATA
            $join_data = DB::table('student')
            ->join('district', 'student.district_id', 'district.id')
            ->join('religion', 'student.religion_id', 'religion.id')
            ->join('student_has_class', 'student.id', 'student_has_class.student_id')
            ->where('student.id', '=', $this->request->post['student_id'])
            ->select('admission_no', 'admission_date', 'full_name', 'initials', 'surname', 'dob', 'gender', 'email', 'phone_mobile', 'address', 'city', 'birth_place', 'district.name as distname', 'religion.name as relname', 'student_has_class.index_no')
            ->orderBy('admission_no')
            ->first();

            // TITLE DETAILS
            $data['report']['class']['name'] = $class_name;
            $data['report']['generated_on'] = $time_now;
            $data['report']['generated_by'] = $this->model_user->select('username')->where('id', '=', $_SESSION['user']['id'])->first()->username;

            // CONTENT
            $data['student']['admission'] = $join_data->admission_no;
            $data['student']['admission_date'] = $join_data->admission_date;
            $data['student']['index'] = $join_data->index_no;
            $data['student']['fullname'] = $join_data->full_name;
            $data['student']['name'] = $join_data->initials. " ". $join_data->surname;
            $data['student']['dob'] = $join_data->dob;
            $data['student']['gender'] = $join_data->gender;
            $data['student']['email'] = $join_data->email;
            $data['student']['mobile'] = $join_data->phone_mobile;
            $data['student']['address'] = $join_data->address;
            $data['student']['city'] = $join_data->city;
            $data['student']['birth_place'] = $join_data->birth_place;
            $data['student']['district'] = $join_data->distname;
            $data['student']['religion'] = $join_data->relname;

            // JSReports
            $JSReport = new JSReport();
            $file = 'one_student_bio_'.$_SESSION['user']['id'].'_'.Carbon::now()->format('Ymd_His');;
            $JSReport->get_report('ONE_STUDENT', $data, 'student/'.$file);

            // ADD ENTRY TO DATABASE ( report table )
            $this->model_report->type = 'one_student_bio';
            $this->model_report->file_name = $file.'.pdf';
            $this->model_report->generated_by = $_SESSION['user']['id'];

            // VALIDATE SAVE
            if ( $this->model_report->save() ):
                echo json_encode( array("status" => "success", "path" => $this->config->get('base_url').'/data/report/attendance/' ), JSON_PRETTY_PRINT );  
                exit();
            else:
                echo json_encode( array("status" => "failed", "error" => "Error occured while saving your report" ), JSON_PRETTY_PRINT );
                exit();
            endif;


        else:
            echo json_encode( array("status" => "failed", "error" => "Please Select a Student" ), JSON_PRETTY_PRINT );
            exit();
        endif;
        
    }
    // END : STUDENT REPORTS

    // START : TIMETABLE REPORTS
    public function timetable() {

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
        $this->load->model('user');
        $this->load->model('report');
        $this->load->model('class');
        $this->load->model('grade');
        $this->load->model('staff');

        // CHECK PERMISSION : timetable
        if ( $this->model_user->find($_SESSION['user']['id'])->hasPermission('report-timetable-view') ):
            $data['permission']['report']['timetable']['view'] = true;
        else:
            $data['permission']['report']['timetable']['view'] = false;
        endif;

        // CHECK PERMISSION : report_any_generate
        if ( $this->model_user->find($_SESSION['user']['id'])->hasPermission('report-any-generate') ):
            $data['permission']['report']['any']['generate'] = true;
        else:
            $data['permission']['report']['any']['generate'] = false;
        endif;

        // CHECK PERMISSION : report_any_view
        if ( $this->model_user->find($_SESSION['user']['id'])->hasPermission('report-any-view') ):
            $data['permission']['report']['any']['view'] = true;
        else:
            $data['permission']['report']['any']['view'] = false;
        endif;

        // CHECK PERMISSION : report_any_delete
        if ( $this->model_user->find($_SESSION['user']['id'])->hasPermission('report-any-delete') ):
            $data['permission']['report']['any']['delete'] = true;
        else:
            $data['permission']['report']['any']['delete'] = false;
        endif;

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

        // QUERY REPORTS ( BY CLASS )
        $is_class_reports = $this->model_report->select('id', 'file_name', 'generated_by', 'created_on')->where('type', '=', 'class_timetable')->get();
        if ( $is_class_reports !== NULL ):
            foreach( $is_class_reports as $key => $el ):
                $user = $this->model_user->select('username')->where('id', '=', $el->generated_by)->first();
                $data['reports']['class'][$key]['id'] = $el->id;
                $data['reports']['class'][$key]['generated_on'] = $el->created_on->format('Y-m-d h:i:s A');
                $data['reports']['class'][$key]['user']['username'] = $user->username;
                $data['reports']['class'][$key]['path'] = $this->config->get('base_url').'/data/reports/timetable/'.$el->file_name;
                $data['reports']['class'][$key]['file'] = $el->file_name;
            endforeach;
        endif;

        // QUERY REPORTS ( BY STAFF )
        $is_staff_reports = $this->model_report->select('id', 'file_name', 'generated_by', 'created_on')->where('type', '=', 'staff_timetable')->get();
        if ( $is_staff_reports !== NULL ):
            foreach( $is_staff_reports as $key => $el ):
                $user = $this->model_user->select('username')->where('id', '=', $el->generated_by)->first();
                $data['reports']['staff'][$key]['id'] = $el->id;
                $data['reports']['staff'][$key]['generated_on'] = $el->created_on->format('Y-m-d h:i:s A');
                $data['reports']['staff'][$key]['user']['username'] = $user->username;
                $data['reports']['staff'][$key]['path'] = $this->config->get('base_url').'/data/reports/timetable/'.$el->file_name;
                $data['reports']['staff'][$key]['file'] = $el->file_name;
            endforeach;
        endif;

		// RENDER VIEW
        $this->load->view('report/timetable', $data);
    }

    public function class_timetable_ajax() {

        //CHECK LOGIN STATUS
		if( !isset($_SESSION['user']) OR $_SESSION['user']['is_login'] != true ):
			header( 'Location:' . $this->config->get('base_url') . '/logout' );
			exit();
		endif;

        // SET JSON HEADER
        header('Content-Type: application/json');

        // MODELS
        $this->load->model("user");
        $this->load->model("report");
        $this->load->model("class");
        $this->load->model("grade");
        $this->load->model("class/timetable");
        $this->load->model("subject");
        $this->load->model("staff");

        // PERMISSION
        if ( !$this->model_user->find($_SESSION['user']['id'])->hasPermission('report-any-create') ):
            echo json_encode( array( "status" => "failed", "error" => "Permission denied" ), JSON_PRETTY_PRINT );
            exit();
        endif;

        $time_now = Carbon::now()->format('Y-m-d h:i:s A');
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
            $data['timetable']['generated_by'] = $this->model_user->select('username')->where('id', '=', $_SESSION['user']['id'])->first()->username;

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
            $file = 'class_timetable_'.$_SESSION['user']['id'].'_'.Carbon::now()->format('Ymd_His');
            $JSReport->get_report('CLASS_TIMETABLE', $data, 'timetable/'.$file);

            // ADD ENTRY TO DATABASE ( report table )
            $this->model_report->type = 'class_timetable';
            $this->model_report->file_name = $file.'.pdf';
            $this->model_report->generated_by = $_SESSION['user']['id'];

            // VALIDATE SAVE
            if ( $this->model_report->save() ):
                echo json_encode( array("status" => "success", "path" => $this->config->get('base_url').'/data/report/timetable/' ), JSON_PRETTY_PRINT );  
                exit();
            else:
                echo json_encode( array("status" => "failed", "error" => "Error occured while saving your report" ), JSON_PRETTY_PRINT );
                exit();
            endif;


        else:
            echo json_encode( array("status" => "failed", "error" => "Invalid Class Selected" ), JSON_PRETTY_PRINT );
            exit();
        endif;
    }

    public function staff_timetable_ajax() {

        //CHECK LOGIN STATUS
		if( !isset($_SESSION['user']) OR $_SESSION['user']['is_login'] != true ):
			header( 'Location:' . $this->config->get('base_url') . '/logout' );
			exit();
		endif;

        // SET JSON HEADER
        header('Content-Type: application/json');

        // MODELS
        $this->load->model("user");
        $this->load->model("report");
        $this->load->model("class");
        $this->load->model("grade");
        $this->load->model("class/timetable");
        $this->load->model("subject");
        $this->load->model("staff");

        // PERMISSION
        if ( !$this->model_user->find($_SESSION['user']['id'])->hasPermission('report-any-create') ):
            echo json_encode( array( "status" => "failed", "error" => "Permission denied" ), JSON_PRETTY_PRINT );
            exit();
        endif;

        $time_now = Carbon::now()->format('Y-m-d h:i:s A');
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
            $data['timetable']['generated_by'] = $this->model_user->select('username')->where('id', '=', $_SESSION['user']['id'])->first()->username;

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
            $file = 'staff_timetable_'.$_SESSION['user']['id'].'_'.Carbon::now()->format('Ymd_His');
            $JSReport->get_report('STAFF_TIMETABLE', $data, 'timetable/'.$file);

            // ADD ENTRY TO DATABASE ( report table )
            $this->model_report->type = 'staff_timetable';
            $this->model_report->file_name = $file.'.pdf';
            $this->model_report->generated_by = $_SESSION['user']['id'];

            // VALIDATE SAVE
            if ( $this->model_report->save() ):
                echo json_encode( array("status" => "success", "path" => $this->config->get('base_url').'/data/report/attendance/' ), JSON_PRETTY_PRINT );  
                exit();
            else:
                echo json_encode( array("status" => "failed", "error" => "Error occured while saving your report" ), JSON_PRETTY_PRINT );
                exit();
            endif;


        else:
            echo json_encode( array("status" => "failed", "error" => "Please Select a Staff name" ), JSON_PRETTY_PRINT );
            exit();
        endif;
    }
    // END : TIMETABLE REPORTS

    // START : RESULT REPORTS
    public function result() {

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
        $this->load->model('exam');
        $this->load->model('exam/type');
        $this->load->model('report');
        $this->load->model('user');

        // CHECK PERMISSION : result
        if ( $this->model_user->find($_SESSION['user']['id'])->hasPermission('report-result-view') ):
            $data['permission']['report']['result']['view'] = true;
        else:
            $data['permission']['report']['result']['view'] = false;
        endif;

        // CHECK PERMISSION : report_any_generate
        if ( $this->model_user->find($_SESSION['user']['id'])->hasPermission('report-any-generate') ):
            $data['permission']['report']['any']['generate'] = true;
        else:
            $data['permission']['report']['any']['generate'] = false;
        endif;

        // CHECK PERMISSION : report_any_view
        if ( $this->model_user->find($_SESSION['user']['id'])->hasPermission('report-any-view') ):
            $data['permission']['report']['any']['view'] = true;
        else:
            $data['permission']['report']['any']['view'] = false;
        endif;

        // CHECK PERMISSION : report_any_delete
        if ( $this->model_user->find($_SESSION['user']['id'])->hasPermission('report-any-delete') ):
            $data['permission']['report']['any']['delete'] = true;
        else:
            $data['permission']['report']['any']['delete'] = false;
        endif;

        // QUERY CLASS
        foreach( $this->model_class->select('id', 'grade_id', 'staff_id', 'name')->get() as $key => $element ):
            $data['classes'][$key]['id'] = $element->id;
            $data['classes'][$key]['grade']['id'] = $element->grade_id;
            $data['classes'][$key]['staff']['id'] = $element->staff_id;
            $data['classes'][$key]['name'] = $element->name;

            $data['classes'][$key]['grade']['name'] = $this->model_grade->select('name')->where('id', '=', $element->grade_id)->first()->name;
        endforeach;

        // QUERY STUDENT
        foreach( $this->model_student->select('id', 'full_name')->get() as $key => $element ):
            $data['students'][$key]['id'] = $element->id;
            $data['students'][$key]['full_name'] = $element->full_name;
        endforeach;

         // TWIG : EXAM YEAR
         $current_year = Carbon::now()->format('Y');
         $least_year = $current_year-2;
         $exam_year = Carbon::now()->format('Y');
         for ( $i=1; $i<=2; $i++ ):
             $data['years'][$i] = $exam_year;
             $exam_year++;
         endfor;

        // TWIG : EXAMS
        foreach( $this->model_exam->select('id', 'type_id', 'year', 'venue', 'instructions')->where('year', '>=', $least_year)->where('year', '<=', $current_year)->orderBy('year', 'DESC')->get() as $key => $element ):
			$data['exams'][$key]['id'] = $element->id;
            $data['exams'][$key]['type_id']= $element->type_id;
            $data['exams'][$key]['year'] = $element->year;
            $data['exams'][$key]['venue'] = $element->venue;
            $data['exams'][$key]['instructions'] = $element->instructions;

            $data['exams'][$key]['type']['name'] = $this->model_exam_type->select('name')->where('id', '=', $element->type_id)->first()->name;
        endforeach;

        // QUERY REPORTS ( BY CLASS )
        $is_class_reports = $this->model_report->select('id', 'file_name', 'generated_by', 'created_on')->where('type', '=', 'class_exam')->get();
        if ( $is_class_reports !== NULL ):
            foreach( $is_class_reports as $key => $el ):
                $user = $this->model_user->select('username')->where('id', '=', $el->generated_by)->first();
                $data['reports']['class'][$key]['id'] = $el->id;
                $data['reports']['class'][$key]['generated_on'] = $el->created_on->format('Y-m-d h:i:s A');
                $data['reports']['class'][$key]['user']['username'] = $user->username;
                $data['reports']['class'][$key]['path'] = $this->config->get('base_url').'/data/reports/result/'.$el->file_name;
                $data['reports']['class'][$key]['file'] = $el->file_name;
            endforeach;
        endif;

        // QUERY REPORTS ( BY STUDENT )
        $is_student_reports = $this->model_report->select('id', 'file_name', 'generated_by', 'created_on')->where('type', '=', 'student_exam')->get();
        if ( $is_student_reports !== NULL ):
            foreach( $is_student_reports as $key => $el ):
                $user = $this->model_user->select('username')->where('id', '=', $el->generated_by)->first();
                $data['reports']['student'][$key]['id'] = $el->id;
                $data['reports']['student'][$key]['generated_on'] = $el->created_on->format('Y-m-d h:i:s A');
                $data['reports']['student'][$key]['user']['username'] = $user->username;
                $data['reports']['student'][$key]['path'] = $this->config->get('base_url').'/data/reports/result/'.$el->file_name;
                $data['reports']['student'][$key]['file'] = $el->file_name;
            endforeach;
        endif;

		// RENDER VIEW
        $this->load->view('report/result', $data);
    }
    // END : RESULT REPORTS

    // START : STUDENT EXAM RESULT
    public function student_exam_result_ajax() {

        //CHECK LOGIN STATUS
		if( !isset($_SESSION['user']) OR $_SESSION['user']['is_login'] != true ):
			header( 'Location:' . $this->config->get('base_url') . '/logout' );
			exit();
        endif;
        
        // SET JSON HEADER
        header('Content-Type: application/json');

        // MODELS
        $this->load->model("user");
        $this->load->model("report");
        $this->load->model("class");
        $this->load->model("grade");
        $this->load->model("student");
        $this->load->model("student/exam");
        $this->load->model("exam");
        $this->load->model("exam/type");
        $this->load->model("exam/grade");

        // PERMISSION
        if ( !$this->model_user->find($_SESSION['user']['id'])->hasPermission('report-any-create') ):
            echo json_encode( array( "status" => "failed", "message" => "Permission denied" ), JSON_PRETTY_PRINT );
            exit();
        endif;

        $time_now = Carbon::now()->format('Y-m-d h:i:s A');
        $date_now = Carbon::now()->isoFormat('YYYY-MM-DD');

        // VALIDATION : student_id
        $is_valid_student_id = GUMP::is_valid($this->request->post, array('student_id' => 'required|numeric'));
        if ( $is_valid_student_id !== true ):
            echo json_encode( array( "status" => "failed", "message" => "Please select a valid student" ), JSON_PRETTY_PRINT );
            exit();
        endif;

        // VALIDATION : exam_id
        $is_valid_exam_id = GUMP::is_valid($this->request->post, array('exam_id' => 'required|numeric'));
        if ( $is_valid_exam_id !== true ):
            echo json_encode( array( "status" => "failed", "message" => "Please select a valid exam" ), JSON_PRETTY_PRINT );
            exit();
        endif;

        // IS STUDENT EXISTS
        if ( $this->model_student->where('id', '=', $this->request->post['student_id'])->first() === NULL ):
            echo json_encode( array("status" => "failed", "message" => "Invalid student selected" ), JSON_PRETTY_PRINT );
            exit();
        endif;

        // IS EXAM ID EXISTS
        if ( $this->model_exam->where('id', '=', $this->request->post['exam_id'])->first() === NULL ):
            echo json_encode( array("status" => "failed", "message" => "Invalid exam is selected" ), JSON_PRETTY_PRINT );
            exit();
        endif;

        $student = $this->model_student->where('id', '=', $this->request->post['student_id'])->first();
        $exam = $this->model_exam->where('id', '=', $this->request->post['exam_id'])->first();

        // QUERY EXAM NAME
        $exam_details = $this->model_exam->select('type_id', 'year')->where('id', '=', $this->request->post['exam_id'])->first();
        $exam_type_name = $this->model_exam_type->select('name')->where('id', '=', $exam_details->type_id)->first();
        $exam_name = $exam_type_name->name." - ".$exam_details->year;

        // QUERY GRADE
        $grade_id = $this->model_class->select('grade_id')->where('id', '=', $student->class_id)->first()->grade_id;
        $grade_name = $this->model_grade->select('name')->where('id', '=', $grade_id)->first()->name;

        // TITLE DETAILS
        $data['student_exam_report']['student_name'] = $student->initials." ".$student->surname;
        $data['student_exam_report']['exam_name'] = $exam_name;
        $data['student_exam_report']['grade'] = $grade_name;
        $data['student_exam_report']['generated_on'] = $time_now;
        $data['student_exam_report']['generated_by'] = $this->model_user->select('username')->where('id', '=', $_SESSION['user']['id'])->first()->username;

        $exam_result = DB::table('student_has_exam_schedule')
        ->join('exam_grade_has_schedule', 'student_has_exam_schedule.exam_schedule_id', 'exam_grade_has_schedule.id')
        ->join('exam_has_grade', 'exam_grade_has_schedule.exam_grade_id', 'exam_has_grade.id')
        ->join('exam', 'exam_has_grade.exam_id', 'exam.id')
        ->join('exam_type', 'exam.type_id', 'exam_type.id')
        ->join('grade', 'exam_has_grade.grade_id', 'grade.id')
        ->join('subject', 'exam_grade_has_schedule.subject_id', 'subject.id')
        ->where('student_has_exam_schedule.student_id', '=', $this->request->post['student_id'])
        ->where('exam.id', '=', $this->request->post['exam_id'])
        ->select('subject.name as subject_name', 'student_has_exam_schedule.marks');

        $data['exam_total']['total']['marks'] = 0;
        $data['exam_average']['average']['marks'] = 0;
        $total = 0;
        $subject_count = 0;

        foreach ( $exam_result->get() as $key => $element ):
            $data['exam']['subject'][$key]['name'] = $element->subject_name;
            $data['exam']['subject'][$key]['mark'] = $element->marks;
            $data['exam_total']['total']['marks'] = $total + $element->marks;
            $total = $data['exam_total']['total']['marks'];
            $subject_count = $subject_count + 1;
            $data['exam_average']['average']['marks'] = $total / $subject_count;
        endforeach;

        // JSReports
        $JSReport = new JSReport();
        $file = 'student_result_'.$_SESSION['user']['id'].'_'.Carbon::now()->format('Ymd_His');
        $JSReport->get_report('STUDENT_EXAM', $data, 'result/'.$file);

        // ADD ENTRY TO DATABASE ( report table )
        $this->model_report->type = 'student_exam';
        $this->model_report->file_name = $file.'.pdf';
        $this->model_report->generated_by = $_SESSION['user']['id'];

        // VALIDATE SAVE
        if ( $this->model_report->save() ):
            echo json_encode( array("status" => "success", "path" => $this->config->get('base_url').'/data/report/result/' ), JSON_PRETTY_PRINT );  
            exit();
        else:
            echo json_encode( array("status" => "failed", "error" => "Error occured while saving your report" ), JSON_PRETTY_PRINT );
            exit();
        endif;
    }
    // END : STUDENT EXAM RESULT











    // START : EXAM ALL CLASS REPORT
    public function class_exam_result_ajax() {

        //CHECK LOGIN STATUS
		if( !isset($_SESSION['user']) OR $_SESSION['user']['is_login'] != true ):
			header( 'Location:' . $this->config->get('base_url') . '/logout' );
			exit();
        endif;
        
        // SET JSON HEADER
        header('Content-Type: application/json');

        // MODELS
        $this->load->model("user");
        $this->load->model("report");
        $this->load->model("class");
        $this->load->model("grade");
        $this->load->model("student");
        $this->load->model("student/exam");
        $this->load->model("exam");
        $this->load->model("exam/type");
        $this->load->model("exam/grade");

        $time_now = Carbon::now()->format('Y-m-d h:i:s A');
        $date_now = Carbon::now()->isoFormat('YYYY-MM-DD');

        // PERMISSION
        if ( !$this->model_user->find($_SESSION['user']['id'])->hasPermission('report-any-create') ):
            echo json_encode( array( "status" => "failed", "message" => "Permission denied" ), JSON_PRETTY_PRINT );
            exit();
        endif;


        // CHECK IF SUBMITED
        if ( isset($this->request->post['class_id']) AND !empty($this->request->post['class_id']) AND isset($this->request->post['exam_id']) AND !empty($this->request->post['exam_id']) ):


            // VALIDATION : class_id
            $is_valid_class_id = GUMP::is_valid($this->request->post, array('class_id' => 'required|numeric'));
            if ( $is_valid_class_id !== true ):
                echo json_encode( array( "status" => "failed", "message" => "Please select a valid class" ), JSON_PRETTY_PRINT );
                exit();
            endif;

            // VALIDATION : exam_id
            $is_valid_exam_id = GUMP::is_valid($this->request->post, array('exam_id' => 'required|numeric'));
            if ( $is_valid_exam_id !== true ):
                echo json_encode( array( "status" => "failed", "message" => "Please select a valid exam" ), JSON_PRETTY_PRINT );
                exit();
            endif;
        
            // IS ANY STUDENT EXISTS
            if ( $this->model_student->select('id')->first() === NULL ):
                echo json_encode( array("status" => "failed", "message" => "No student exists in this system" ), JSON_PRETTY_PRINT );
                exit();
            endif;

            // IS CORRECT CLASS ID
            if ( $this->model_class->select('name')->where('id', '=', $this->request->post['class_id'])->first() === NULL ):
                echo json_encode( array("status" => "failed", "message" => "Invalid Class is Selected" ), JSON_PRETTY_PRINT );
                exit();
            endif;

            // QUERY CLASS NAME
            $class = $this->model_class->select('grade_id', 'name')->where('id', '=', $this->request->post['class_id'])->first();
            $grade = $this->model_grade->select('name')->where('id', '=', $class->grade_id)->first();
            $class_name =  $grade->name. " - ". $class->name ;

            // QUERY EXAM NAME
            $exam_details = $this->model_exam->select('type_id', 'year')->where('id', '=', $this->request->post['exam_id'])->first();
            $exam_type_name = $this->model_exam_type->select('name')->where('id', '=', $exam_details->type_id)->first();
            $exam_name = $exam_type_name->name." - ".$exam_details->year;

            $subjects = DB::table('exam')
            ->join('exam_has_grade', 'exam.id', 'exam_has_grade.exam_id')
            ->join('exam_grade_has_schedule', 'exam_has_grade.id', 'exam_grade_has_schedule.exam_grade_id')
            ->join('subject', 'exam_grade_has_schedule.subject_id', 'subject.id')
            ->where('exam.id', '=', $this->request->post['exam_id'])
            ->groupBy('exam_grade_has_schedule.subject_id')
            ->select('exam_grade_has_schedule.subject_id', 'subject.name as subject_name')->get();

            $students = $this->model_student->where('class_id', $this->request->post['class_id'])->get();

            $data['subjects'] = $subjects;
            $data['students'] = $students;

            foreach( $students as $student ):
                foreach ( $subjects as $subject ):

                    $schedule = DB::table('exam_has_grade')
                    ->join('exam_grade_has_schedule', 'exam_has_grade.id', 'exam_grade_has_schedule.exam_grade_id')
                    ->join('student_has_exam_schedule', 'exam_grade_has_schedule.id', 'student_has_exam_schedule.exam_schedule_id')
                    ->where('exam_has_grade.exam_id', $this->request->post['exam_id'])
                    ->where('student_has_exam_schedule.student_id', $student->id)
                    ->where('exam_grade_has_schedule.subject_id', $subject->subject_id)
                    ->select('exam_grade_has_schedule.id', 'student_has_exam_schedule.marks')
                    ->first();

                    // var_dump( $subject->subject_id );


                    // $exam_result = DB::table('exam')
                    // ->join('exam_has_grade', 'exam.id', 'exam_has_grade.exam_id')
                    // ->join('exam_grade_has_schedule', 'exam_has_grade.id', 'exam_grade_has_schedule.exam_grade_id')
                    // ->join('student_has_exam_schedule', 'exam_grade_has_schedule.id', 'student_has_exam_schedule.exam_schedule_id')
                    // ->where('exam.id', '=', $this->request->post['exam_id'])
                    // ->where('exam_grade_has_schedule.subject_id', '=', $subject->subject_id)
                    // ->where('student.class_id', '=', $this->request->post['class_id'])
                    // ->select('student.initials', 'student.surname', 'subject.id as subject_id', 'subject.name as subject_name', 'student_has_exam_schedule.marks')->first();

                    // // STUDENT
                    // // SUBJECT
                    if ( $schedule !== null ):
                        $data['results'][$student->id]['subjects'][$subject->subject_id]['marks'] = $schedule->marks;
                        $data['results'][$student->id]['subjects'][$subject->subject_id]['subject_name'] = $subject->subject_name;
                        // var_dump( $schedule->marks );
                        // echo $exam_result->surname." : ".$exam_result->subject_name." : ".$exam_result->marks."<br>";
                    else:
                        $data['results'][$student->id]['subjects'][$subject->subject_id]['marks'] = 'A/B';
                        $data['results'][$student->id]['subjects'][$subject->subject_id]['subject_name'] = $subject->subject_name;
                    endif;

                endforeach;
            endforeach;

            var_dump( $data['students'] );

            // if ( $subjects->get() != NULL ):
            //     foreach( $subjects->get() as $key => $element ):

            //         $exam_result = DB::table('exam')
            //         ->join('exam_has_grade', 'exam.id', 'exam_has_grade.exam_id')
            //         ->join('exam_grade_has_schedule', 'exam_has_grade.id', 'exam_grade_has_schedule.exam_grade_id')
            //         ->join('student_has_exam_schedule', 'exam_grade_has_schedule.id', 'student_has_exam_schedule.exam_schedule_id')
            //         ->join('subject', 'exam_grade_has_schedule.subject_id', 'subject.id')
            //         ->join('student', 'student_has_exam_schedule.student_id', 'student.id')
            //         ->where('exam.id', '=', $this->request->post['exam_id'])
            //         ->where('exam_grade_has_schedule.subject_id', '=', $element->subject_id)
            //         ->where('student.class_id', '=', $this->request->post['class_id'])
            //         ->select('student.initials', 'student.surname', 'subject.id as subject_id', 'subject.name as subject_name', 'student_has_exam_schedule.marks');
                    
            //         if ( $exam_result->get() != NULL ):
            //             foreach( $exam_result->get() as $key2 => $element2 ):
            //                 echo "hi";
            //                 var_dump($element2->surname);
            //                 var_dump($element2->subject_name);
            //                 var_dump($element2->marks);
            //             endforeach;
                        
            //         else:
            //             echo json_encode( array("status" => "failed", "message" => "No results exist to this exam" ), JSON_PRETTY_PRINT );
            //             exit();
            //         endif;

            //     endforeach;
            // else:
            //     echo json_encode( array("status" => "failed", "message" => "No any subjects exist to this exam" ), JSON_PRETTY_PRINT );
            //     exit();
            // endif;

        endif;
    }
















    // START : HEALTH REPORTS
    public function health() {

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
        $this->load->model('user');
        $this->load->model('report');
        $this->load->model('class');
        $this->load->model('grade');
        $this->load->model('student');

        // CHECK PERMISSION : health
        if ( $this->model_user->find($_SESSION['user']['id'])->hasPermission('report-health-view') ):
            $data['permission']['report']['health']['view'] = true;
        else:
            $data['permission']['report']['health']['view'] = false;
        endif;

        // CHECK PERMISSION : report_any_generate
        if ( $this->model_user->find($_SESSION['user']['id'])->hasPermission('report-any-generate') ):
            $data['permission']['report']['any']['generate'] = true;
        else:
            $data['permission']['report']['any']['generate'] = false;
        endif;

        // CHECK PERMISSION : report_any_view
        if ( $this->model_user->find($_SESSION['user']['id'])->hasPermission('report-any-view') ):
            $data['permission']['report']['any']['view'] = true;
        else:
            $data['permission']['report']['any']['view'] = false;
        endif;

        // CHECK PERMISSION : report_any_delete
        if ( $this->model_user->find($_SESSION['user']['id'])->hasPermission('report-any-delete') ):
            $data['permission']['report']['any']['delete'] = true;
        else:
            $data['permission']['report']['any']['delete'] = false;
        endif;

        // QUERY CLASS
        foreach( $this->model_class->select('id', 'grade_id', 'staff_id', 'name')->orderBY('grade_id')->orderBY('name')->get() as $key => $element ):
            $data['classes'][$key]['id'] = $element->id;
            $data['classes'][$key]['grade']['id'] = $element->grade_id;
            $data['classes'][$key]['staff']['id'] = $element->staff_id;
            $data['classes'][$key]['name'] = $element->name;

            $data['classes'][$key]['grade']['name'] = $this->model_grade->select('name')->where('id', '=', $element->grade_id)->first()->name;
        endforeach;

        // QUERY STUDENT
        foreach( $this->model_student->select('id', 'full_name')->get() as $key => $element ):
            $data['students'][$key]['id'] = $element->id;
            $data['students'][$key]['fullname'] = $element->full_name;
        endforeach;

        // QUERY REPORTS ( BY CLASS )
        $is_class_reports = $this->model_report->select('id', 'file_name', 'generated_by', 'created_on')->where('type', '=', 'class_health')->get();
        if ( $is_class_reports !== NULL ):
            foreach( $is_class_reports as $key => $el ):
                $user = $this->model_user->select('username')->where('id', '=', $el->generated_by)->first();
                $data['reports']['class'][$key]['id'] = $el->id;
                $data['reports']['class'][$key]['generated_on'] = $el->created_on->format('Y-m-d h:i:s A');
                $data['reports']['class'][$key]['user']['username'] = $user->username;
                $data['reports']['class'][$key]['path'] = $this->config->get('base_url').'/data/reports/health/'.$el->file_name;
                $data['reports']['class'][$key]['file'] = $el->file_name;
            endforeach;
        endif;

        // QUERY REPORTS ( BY STUDENT )
        $is_student_reports = $this->model_report->select('id', 'file_name', 'generated_by', 'created_on')->where('type', '=', 'student_health')->get();
        if ( $is_student_reports !== NULL ):
            foreach( $is_student_reports as $key => $el ):
                $user = $this->model_user->select('username')->where('id', '=', $el->generated_by)->first();
                $data['reports']['student'][$key]['id'] = $el->id;
                $data['reports']['student'][$key]['generated_on'] = $el->created_on->format('Y-m-d h:i:s A');
                $data['reports']['student'][$key]['user']['username'] = $user->username;
                $data['reports']['student'][$key]['path'] = $this->config->get('base_url').'/data/reports/health/'.$el->file_name;
                $data['reports']['student'][$key]['file'] = $el->file_name;
            endforeach;
        endif;

		// RENDER VIEW
        $this->load->view('report/health', $data);
    }

    public function class_health_ajax() {

        //CHECK LOGIN STATUS
		if( !isset($_SESSION['user']) OR $_SESSION['user']['is_login'] != true ):
			header( 'Location:' . $this->config->get('base_url') . '/logout' );
			exit();
		endif;

        // SET JSON HEADER
        header('Content-Type: application/json');

        // MODELS
        $this->load->model("user");
        $this->load->model("report");
        $this->load->model("class");
        $this->load->model("grade");
        $this->load->model("student");
        $this->load->model("student/health");

        // PERMISSION
        if ( !$this->model_user->find($_SESSION['user']['id'])->hasPermission('report-any-create') ):
            echo json_encode( array( "status" => "failed", "error" => "Permission denied" ), JSON_PRETTY_PRINT );
            exit();
        endif;

        $time_now = Carbon::now()->format('Y-m-d h:i:s A');
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
            $data['health']['generated_by'] = $this->model_user->select('username')->where('id', '=', $_SESSION['user']['id'])->first()->username;

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
            $file = 'class_health_'.$_SESSION['user']['id'].'_'.Carbon::now()->format('Ymd_His');
            $JSReport->get_report('CLASS_HEALTH', $data, 'health/'.$file);

            // ADD ENTRY TO DATABASE ( report table )
            $this->model_report->type = 'class_health';
            $this->model_report->file_name = $file.'.pdf';
            $this->model_report->generated_by = $_SESSION['user']['id'];

            // VALIDATE SAVE
            if ( $this->model_report->save() ):
                echo json_encode( array("status" => "success", "path" => $this->config->get('base_url').'/data/report/attendance/' ), JSON_PRETTY_PRINT );  
                exit();
            else:
                echo json_encode( array("status" => "failed", "error" => "Error occured while saving your report" ), JSON_PRETTY_PRINT );
                exit();
            endif;

        else:
            echo json_encode( array("status" => "failed", "error" => "Please Select a Class" ), JSON_PRETTY_PRINT );
            exit();
        endif;

    }

    public function student_health_ajax() {

        //CHECK LOGIN STATUS
		if( !isset($_SESSION['user']) OR $_SESSION['user']['is_login'] != true ):
			header( 'Location:' . $this->config->get('base_url') . '/logout' );
			exit();
		endif;

        // SET JSON HEADER
        header('Content-Type: application/json');

        // MODELS
        $this->load->model("user");
        $this->load->model("report");
        $this->load->model("class");
        $this->load->model("grade");
        $this->load->model("student");
        $this->load->model("student/health");

        // PERMISSION
        if ( !$this->model_user->find($_SESSION['user']['id'])->hasPermission('report-any-create') ):
            echo json_encode( array( "status" => "failed", "error" => "Permission denied" ), JSON_PRETTY_PRINT );
            exit();
        endif;

        $time_now = Carbon::now()->format('Y-m-d h:i:s A');
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
            $data['health']['generated_by'] = $this->model_user->select('username')->where('id', '=', $_SESSION['user']['id'])->first()->username;

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
            $file = 'student_health_'.$_SESSION['user']['id'].'_'.Carbon::now()->format('Ymd_His');;
            $JSReport->get_report('STUDENT_HEALTH', $data, 'health/'.$file);

            // ADD ENTRY TO DATABASE ( report table )
            $this->model_report->type = 'student_health';
            $this->model_report->file_name = $file.'.pdf';
            $this->model_report->generated_by = $_SESSION['user']['id'];

            // VALIDATE SAVE
            if ( $this->model_report->save() ):
                echo json_encode( array("status" => "success", "path" => $this->config->get('base_url').'/data/report/attendance/' ), JSON_PRETTY_PRINT );  
                exit();
            else:
                echo json_encode( array("status" => "failed", "error" => "Error occured while saving your report" ), JSON_PRETTY_PRINT );
                exit();
            endif;


        else:
            echo json_encode( array("status" => "failed", "error" => "Please Select a Student" ), JSON_PRETTY_PRINT );
            exit();
        endif;

    }
    // END : HEALTH REPORTS

    // START : STAFF REPORTS
    public function staff() {

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

        // MODELS
        $this->load->model("user");
        $this->load->model("report");

        // CHECK PERMISSION : staff
        if ( $this->model_user->find($_SESSION['user']['id'])->hasPermission('report-staff-view') ):
            $data['permission']['report']['staff']['view'] = true;
        else:
            $data['permission']['report']['staff']['view'] = false;
        endif;

        // CHECK PERMISSION : report_any_generate
        if ( $this->model_user->find($_SESSION['user']['id'])->hasPermission('report-any-generate') ):
            $data['permission']['report']['any']['generate'] = true;
        else:
            $data['permission']['report']['any']['generate'] = false;
        endif;

        // CHECK PERMISSION : report_any_view
        if ( $this->model_user->find($_SESSION['user']['id'])->hasPermission('report-any-view') ):
            $data['permission']['report']['any']['view'] = true;
        else:
            $data['permission']['report']['any']['view'] = false;
        endif;

        // CHECK PERMISSION : report_any_delete
        if ( $this->model_user->find($_SESSION['user']['id'])->hasPermission('report-any-delete') ):
            $data['permission']['report']['any']['delete'] = true;
        else:
            $data['permission']['report']['any']['delete'] = false;
        endif;

        // QUERY REPORTS ( BY PRESENT )
        $is_staff_present_reports = $this->model_report->select('id', 'file_name', 'generated_by', 'created_on')->where('type', '=', 'staff_present_today')->get();
        if ( $is_staff_present_reports !== NULL ):
            foreach( $is_staff_present_reports as $key => $el ):
                $user = $this->model_user->select('username')->where('id', '=', $el->generated_by)->first();
                $data['reports']['staff']['present'][$key]['id'] = $el->id;
                $data['reports']['staff']['present'][$key]['generated_on'] = $el->created_on->format('Y-m-d h:i:s A');
                $data['reports']['staff']['present'][$key]['user']['username'] = $user->username;
                $data['reports']['staff']['present'][$key]['path'] = $this->config->get('base_url').'/data/reports/staff/'.$el->file_name;
                $data['reports']['staff']['present'][$key]['file'] = $el->file_name;
            endforeach;
        endif;

        // QUERY REPORTS ( BY ABSENT )
        $is_staff__absent_reports = $this->model_report->select('id', 'file_name', 'generated_by', 'created_on')->where('type', '=', 'staff_absent_today')->get();
        if ( $is_staff__absent_reports !== NULL ):
            foreach( $is_staff__absent_reports as $key => $el ):
                $user = $this->model_user->select('username')->where('id', '=', $el->generated_by)->first();
                $data['reports']['staff']['absent'][$key]['id'] = $el->id;
                $data['reports']['staff']['absent'][$key]['generated_on'] = $el->created_on->format('Y-m-d h:i:s A');
                $data['reports']['staff']['absent'][$key]['user']['username'] = $user->username;
                $data['reports']['staff']['absent'][$key]['path'] = $this->config->get('base_url').'/data/reports/staff/'.$el->file_name;
                $data['reports']['staff']['absent'][$key]['file'] = $el->file_name;
            endforeach;
        endif;

		// RENDER VIEW
        $this->load->view('report/staff', $data);
    }

    public function staff_present_ajax() {

        //CHECK LOGIN STATUS
		if( !isset($_SESSION['user']) OR $_SESSION['user']['is_login'] != true ):
			header( 'Location:' . $this->config->get('base_url') . '/logout' );
			exit();
		endif;

        // SET JSON HEADER
        header('Content-Type: application/json');

        // MODELS
        $this->load->model('user');
        $this->load->model('report');
        $this->load->model("class");
        $this->load->model("grade");
        $this->load->model("staff");
        $this->load->model("staff/attendance");

        // PERMISSION
        if ( !$this->model_user->find($_SESSION['user']['id'])->hasPermission('report-any-create') ):
            echo json_encode( array( "status" => "failed", "error" => "Permission denied" ), JSON_PRETTY_PRINT );
            exit();
        endif;

        $time_now = Carbon::now()->format('Y-m-d h:i:s A');
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
            $data['staff']['present']['generated_by'] = $this->model_user->select('username')->where('id', '=', $_SESSION['user']['id'])->first()->username;
            
            // IS AVAILABLE STAFF TODAY
            $is_staff_available = $this->model_staff_attendance->select('id')->where('date', '=', $date_now)->first();

            // CONTENT
            if ( $is_staff_available !== NULL ):

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
                $file = 'staff_present_today_'.$_SESSION['user']['id'].'_'.Carbon::now()->format('Ymd_His');
                $JSReport->get_report('STAFF_PRESENT', $data, 'staff/'.$file);

                // ADD ENTRY TO DATABASE ( report table )
                $this->model_report->type = 'staff_present_today';
                $this->model_report->file_name = $file.'.pdf';
                $this->model_report->generated_by = $_SESSION['user']['id'];

                // VALIDATE SAVE
                if ( $this->model_report->save() ):
                    echo json_encode( array("status" => "success", "path" => $this->config->get('base_url').'/data/report/attendance/' ), JSON_PRETTY_PRINT );  
                    exit();
                else:
                    echo json_encode( array("status" => "failed", "error" => "Error occured while saving your report" ), JSON_PRETTY_PRINT );
                    exit();
                endif;

            else:
                // RETURN
                echo json_encode( array("status" => "failed", "error" => "No any staff is present today" ), JSON_PRETTY_PRINT );
                exit();
            endif;        

        else:
            // RETURN
            echo json_encode( array("status" => "failed", "error" => "Generating from an Invalid path" ), JSON_PRETTY_PRINT );
            exit();
        endif;        
    }

    public function staff_absent_ajax() {

        //CHECK LOGIN STATUS
		if( !isset($_SESSION['user']) OR $_SESSION['user']['is_login'] != true ):
			header( 'Location:' . $this->config->get('base_url') . '/logout' );
			exit();
		endif;

        // SET JSON HEADER
        header('Content-Type: application/json');

        // MODELS
        $this->load->model("user");
        $this->load->model("report");
        $this->load->model("class");
        $this->load->model("grade");
        $this->load->model("staff");
        $this->load->model("staff/attendance");

        // PERMISSION
        if ( !$this->model_user->find($_SESSION['user']['id'])->hasPermission('report-any-create') ):
            echo json_encode( array( "status" => "failed", "error" => "Permission denied" ), JSON_PRETTY_PRINT );
            exit();
        endif;

        $time_now = Carbon::now()->format('Y-m-d h:i:s A');
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
            $data['staff']['absent']['generated_by'] = $this->model_user->select('username')->where('id', '=', $_SESSION['user']['id'])->first()->username;
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
                $file = 'staff_absent_today_'.$_SESSION['user']['id'].'_'.Carbon::now()->format('Ymd_His');
                $JSReport->get_report('STAFF_ABSENT', $data, 'staff/'.$file);

                // ADD ENTRY TO DATABASE ( report table )
                $this->model_report->type = 'staff_absent_today';
                $this->model_report->file_name = $file.'.pdf';
                $this->model_report->generated_by = $_SESSION['user']['id'];

                // VALIDATE SAVE
                if ( $this->model_report->save() ):
                    echo json_encode( array("status" => "success", "path" => $this->config->get('base_url').'/data/report/attendance/' ), JSON_PRETTY_PRINT );  
                    exit();
                else:
                    echo json_encode( array("status" => "failed", "error" => "Error occured while saving your report" ), JSON_PRETTY_PRINT );
                    exit();
                endif;
                
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

    // START : DELETE REPORTS
    public function delete_report_ajax() {

        //CHECK LOGIN STATUS
		if( !isset($_SESSION['user']) OR $_SESSION['user']['is_login'] != true ):
			header( 'Location:' . $this->config->get('base_url') . '/logout' );
			exit();
		endif;

        // SET JSON HEADER
        header('Content-Type: application/json');

        // MODELS
        $this->load->model("report");
        $this->load->model('user');

        // PERMISSION
        if ( !$this->model_user->find($_SESSION['user']['id'])->hasPermission('report-any-delete') ):
            echo json_encode( array( "status" => "failed", "msg" => "Permission denied" ), JSON_PRETTY_PRINT );
            exit();
        endif;

        // QUERY REPORT
        $report = $this->model_report->find($this->request->post['report_id']);

        // REMOVE FILE
        // unlink( ABS_PATH.'/data/reports/attendance/'.$report->file_name );

        // REMOVE DATABASE RECORD
        if ( $report->delete() ):
            echo json_encode( array("status" => "success", "msg" => "Report Deleted Successfully" ), JSON_PRETTY_PRINT );  
            exit();
        endif;
    }
    // END : DELETE REPORTS

}